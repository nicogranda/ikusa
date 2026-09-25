<?php
// app/Domains/Irs/IrsController.php
namespace App\Domains\Irs;

use mysqli;

class IrsController
{
    private mysqli $db;
    private IrsFilingRepository $repo;

    public function __construct(mysqli $db)
    {
        $this->db = $db;
        $this->repo = new IrsFilingRepository($db);
    }

    public function index(): void
    {
        $companyId = (int)($_GET['company_id'] ?? 1);
        $filings = $this->repo->fetchAll(
            "SELECT f.*, f5.id AS form5472_id, f1.id AS form1120_id
             FROM irs_filings f
             LEFT JOIN form_5472 f5 ON f5.filing_id = f.id
             LEFT JOIN form_1120 f1 ON f1.filing_id = f.id
             WHERE f.company_id = ?
             ORDER BY f.tax_year DESC, f.version DESC",
            'i', [$companyId]
        );
        include '/home/ot2ryobi838h/app/views/admin/irs/index.php';
    }

    public function create(): void
    {
        $companyId = (int)($_GET['company_id'] ?? 1);
        $taxYear   = (int)($_GET['tax_year'] ?? date('Y'));

        $company = $this->repo->fetchOne('SELECT * FROM companies WHERE id = ?', 'i', [$companyId]);
        if (!$company) die('Company not found');

        $shareholder = $this->repo->fetchOne('SELECT * FROM shareholders WHERE company_id = ? LIMIT 1', 'i', [$companyId]);
        $financials  = $this->repo->fetchOne(
            'SELECT * FROM company_financials WHERE company_id = ? AND tax_year = ?', 'ii', [$companyId, $taxYear]
        );
        $stockTotal = $this->repo->fetchOne(
            "SELECT SUM(amount) AS total FROM capital_contributions WHERE company_id = ? AND contribution_date <= ?",
            'is', [$companyId, "$taxYear-12-31"]
        );

        $form5472 = null; $form1120 = null; $filing = null; // vacío = primera vez
        include '/home/ot2ryobi838h/app/views/admin/irs/create.php';
    }

    public function store(): void
    {
        $companyId = (int)($_POST['company_id'] ?? 1);
        $taxYear   = (int)($_POST['tax_year'] ?? date('Y'));

        $this->db->begin_transaction();
        try {
            $filingId = $this->repo->insert('irs_filings', [
                'company_id' => $companyId, 'tax_year' => $taxYear, 'version' => 1, 'status' => 'draft'
            ]);
            $this->repo->insert('form_5472', $this->extract5472($_POST, $filingId));
            $this->repo->insert('form_1120', $this->extract1120($_POST, $filingId));
            $this->db->commit();
        } catch (\Throwable $e) {
            $this->db->rollback();
            die('Error al guardar: ' . $e->getMessage());
        }

        header('Location: /admin/index.php?page=irs&action=show&id=' . $filingId);
        exit;
    }

    public function show(): void
    {
        $filingId = (int)($_GET['id'] ?? 0);
        $filing = $this->repo->fetchOne('SELECT * FROM irs_filings WHERE id = ?', 'i', [$filingId]);
        if (!$filing) die('Filing not found');

        $form5472 = $this->repo->fetchOne('SELECT * FROM form_5472 WHERE filing_id = ?', 'i', [$filingId]);
        $form1120 = $this->repo->fetchOne('SELECT * FROM form_1120 WHERE filing_id = ?', 'i', [$filingId]);
        include '/home/ot2ryobi838h/app/views/admin/irs/show.php';
    }

    public function update(): void
    {
        $filingId = (int)($_GET['id'] ?? $_POST['id'] ?? 0);
        $filing = $this->repo->fetchOne('SELECT * FROM irs_filings WHERE id = ?', 'i', [$filingId]);
        if (!$filing) die('Filing not found');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $form5472 = $this->repo->fetchOne('SELECT * FROM form_5472 WHERE filing_id = ?', 'i', [$filingId]);
            $form1120 = $this->repo->fetchOne('SELECT * FROM form_1120 WHERE filing_id = ?', 'i', [$filingId]);
            $company = $this->repo->fetchOne('SELECT * FROM companies WHERE id = ?', 'i', [$filing['company_id']]);
            $shareholder = $this->repo->fetchOne('SELECT * FROM shareholders WHERE company_id = ? LIMIT 1', 'i', [$filing['company_id']]);
            $financials = $this->repo->fetchOne('SELECT * FROM company_financials WHERE company_id = ? AND tax_year = ?', 'ii', [$filing['company_id'], $filing['tax_year']]);
            $stockTotal = $this->repo->fetchOne("SELECT SUM(amount) AS total FROM capital_contributions WHERE company_id = ? AND contribution_date <= ?", 'is', [$filing['company_id'], $filing['tax_year'] . '-12-31']);
            include '/home/ot2ryobi838h/app/views/admin/irs/create.php'; // reusa el form, precargado
            return;
        }

        if ($filing['status'] === 'draft') {
            $this->db->begin_transaction();
            try {
                $this->repo->updateByFilingId('form_5472', $filingId, $this->extract5472($_POST, $filingId, false));
                $this->repo->updateByFilingId('form_1120', $filingId, $this->extract1120($_POST, $filingId, false));
                $this->db->commit();
            } catch (\Throwable $e) {
                $this->db->rollback();
                die('Error al actualizar: ' . $e->getMessage());
            }
            header('Location: /admin/index.php?page=irs&action=show&id=' . $filingId);
            exit;
        }

        // Ya filed -> nueva versión corregida
        $this->db->begin_transaction();
        try {
            $newFilingId = $this->repo->insert('irs_filings', [
                'company_id' => $filing['company_id'], 'tax_year' => $filing['tax_year'],
                'version' => $filing['version'] + 1, 'status' => 'draft',
                'is_corrected' => 1, 'corrects_filing_id' => $filingId,
            ]);
            $this->repo->insert('form_5472', $this->extract5472($_POST, $newFilingId));
            $this->repo->insert('form_1120', $this->extract1120($_POST, $newFilingId));
            $this->db->commit();
        } catch (\Throwable $e) {
            $this->db->rollback();
            die('Error al crear versión corregida: ' . $e->getMessage());
        }

        header('Location: /admin/index.php?page=irs&action=show&id=' . $newFilingId);
        exit;
    }

    public function markFiled(): void
    {
        $filingId = (int)($_GET['id'] ?? 0);
        $filing = $this->repo->fetchOne('SELECT * FROM irs_filings WHERE id = ?', 'i', [$filingId]);

        if ($filing['status'] === 'draft') {
            $stmt = $this->db->prepare("UPDATE irs_filings SET status = 'filed', filed_at = NOW() WHERE id = ?");
            $stmt->bind_param('i', $filingId);
            $stmt->execute();
            $stmt->close();
        }

        header('Location: /admin/index.php?page=irs&action=show&id=' . $filingId);
        exit;
    }

    public function pdf(): void
    {
        $filingId = (int)($_GET['id'] ?? 0);
        $type = $_GET['type'] ?? '5472';

        $filing = $this->repo->fetchOne('SELECT * FROM irs_filings WHERE id = ?', 'i', [$filingId]);
        if (!$filing) die('Filing not found');

        if ($type === '5472') {
            $form = $this->repo->fetchOne('SELECT * FROM form_5472 WHERE filing_id = ?', 'i', [$filingId]);
            if (!$form) die('Form 5472 not found');
            include '/home/ot2ryobi838h/app/views/admin/irs/5472/pdf.php';
        } else {
            $form = $this->repo->fetchOne('SELECT * FROM form_1120 WHERE filing_id = ?', 'i', [$filingId]);
            if (!$form) die('Form 1120 not found');
            include '/home/ot2ryobi838h/app/views/admin/irs/1120/pdf.php';
        }
    }


public function proforma1120(): void
{
    $filingId = (int)($_GET['id'] ?? 0);

    if ($filingId <= 0) {
        http_response_code(400);
        exit('Filing ID inválido');
    }

    $filing = $this->repo->fetchOne(
        'SELECT * FROM irs_filings WHERE id = ?',
        'i',
        [$filingId]
    );

    if (!$filing) {
        http_response_code(404);
        exit('Filing not found');
    }

    $form = $this->repo->fetchOne(
        'SELECT * FROM form_1120 WHERE filing_id = ?',
        'i',
        [$filingId]
    );

    if (!$form) {
        http_response_code(404);
        exit('Form 1120 not found');
    }

    include '/home/ot2ryobi838h/app/views/admin/irs/1120/proforma.php';
}


    private function extract5472(array $p, int $filingId, bool $withFilingId = true): array
    {
        $d = $withFilingId ? ['filing_id' => $filingId] : [];
        $d += [
            'shareholder_id' => $p['shareholder_id'] ?? null,
            'corp_name' => $p['corp_name'] ?? '', 'corp_address' => $p['corp_address'] ?? '',
            'corp_city' => $p['corp_city'] ?? '', 'corp_state' => $p['corp_state'] ?? '',
            'corp_zip' => $p['corp_zip'] ?? '', 'ein' => $p['ein'] ?? '',
            'total_assets' => $p['total_assets'] ?? 0, 'business_activity' => $p['business_activity'] ?? '',
            'activity_code' => $p['activity_code'] ?? '', 'incorporation_country' => $p['incorporation_country'] ?? '',
            'incorporation_date' => $p['incorporation_date'] ?? null,
            'principal_countries_business' => $p['principal_countries_business'] ?? null,
            'foreign_owned_50pct' => isset($p['foreign_owned_50pct']) ? 1 : 0,
            'is_disregarded_entity' => isset($p['is_disregarded_entity']) ? 1 : 0,
            'shareholder_name' => $p['shareholder_name'] ?? '',
            'shareholder_full_address_line' => $p['shareholder_full_address_line'] ?? '',
            'shareholder_reference_id' => $p['shareholder_reference_id'] ?? '',
            'shareholder_ftin' => $p['shareholder_ftin'] ?? '',
            'shareholder_country' => $p['shareholder_country'] ?? '',
            'shareholder_citizenship_country' => $p['shareholder_citizenship_country'] ?? '',
            'shareholder_tax_country' => $p['shareholder_tax_country'] ?? '',
            'related_party_activity' => $p['related_party_activity'] ?? null,
            'distribution_amount' => $p['distribution_amount'] ?? null,
            'third_party_gross_receipts' => $p['third_party_gross_receipts'] ?? null,
            'csa_description' => $p['csa_description'] ?? null,
            'csa_benefit_share' => $p['csa_benefit_share'] ?? null,
            'beat_payments' => $p['beat_payments'] ?? null,
            'beat_tax_benefits' => $p['beat_tax_benefits'] ?? null,
        ];
        foreach (['9','10','11','12','13a','13b','14','15','16','17b','18','19','20','21',
                  '23','24','25','26','27a','27b','28','29','30','31b','32','33','34','35'] as $n) {
            $d['line_' . $n] = $p['line_' . $n] ?? 0;
        }
        return $d;
    }

    private function extract1120(array $p, int $filingId, bool $withFilingId = true): array
    {
        $d = $withFilingId ? ['filing_id' => $filingId] : [];
        $d += [
            'corp_name' => $p['corp_name'] ?? '', 'corp_address' => $p['corp_address'] ?? '',
            'corp_city' => $p['corp_city'] ?? '', 'corp_state' => $p['corp_state'] ?? '',
            'corp_country' => $p['corp_country'] ?? 'United States', 'corp_zip' => $p['corp_zip'] ?? '',
            'ein' => $p['ein'] ?? '', 'date_incorporated' => $p['date_incorporated'] ?? null,
            'activity' => $p['activity'] ?? '', 'activity_code' => $p['activity_code'] ?? '',
            'accounting_method' => $p['accounting_method'] ?? 'cash',
            'signer_name' => $p['signer_name'] ?? '', 'signer_title' => $p['signer_title'] ?? 'Manager',
            'signature_date' => $p['signature_date'] ?? date('Y-m-d'), // default hoy, editable
            'shareholder_pct' => $p['shareholder_pct'] ?? 100.00,
            'cash_distributions' => $p['cash_distributions'] ?? 0,
        ];
        foreach (['gross_receipts','returns_allowances','cost_of_goods_sold','dividends','interest_income',
                  'gross_rents','gross_royalties','capital_gain','other_income','compensation_officers',
                  'salaries_wages','repairs_maintenance','bad_debts','rents','taxes_licenses','interest_deduction',
                  'charitable','depreciation','advertising','other_deductions','estimated_payments',
                  'tax_deposited_7004','withholding','cash_beginning','cash_end','common_stock_beginning',
                  'common_stock_end','retained_earnings_begin','retained_earnings'] as $f) {
            $d[$f] = $p[$f] ?? 0;
        }
        return $d;
    }
}