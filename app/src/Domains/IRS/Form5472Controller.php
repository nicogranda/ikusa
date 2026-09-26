<?php
namespace Src\Domains\IRS;

use mysqli;
use Src\Domains\Company\Company;
use Src\Domains\Shareholder\Shareholder;
use Src\Domains\RelatedParty\RelatedParty;
use Src\Domains\Invoice\Invoice;
use Src\Domains\Quote\QuoteDetail;

require_once '/home/ot2ryobi838h/app/src/Domains/Invoice/Invoice.php';
require_once '/home/ot2ryobi838h/app/src/Domains/Quote/QuoteDetail.php';

class Form5472Controller
{
    private Company $company;
    private Shareholder $shareholder;
    private RelatedParty $relatedParty;
    private Invoice $invoice;
    private QuoteDetail $quoteDetail; // <<== Nueva propiedad

    public function __construct(mysqli $db)
    {
        $this->company = new Company($db);
        $this->shareholder = new Shareholder($db);
        $this->relatedParty = new RelatedParty($db);
        $this->invoice = new Invoice($db);
        $this->quoteDetail = new QuoteDetail($db); // <<== Instanciamos
    }

    public function generate(int $companyId): array
    {
        $company = $this->company->find($companyId);
        if (!$company) throw new \Exception("Company not found");

        $shareholders = $this->shareholder->getByCompany($companyId);
        $relatedParties = $this->relatedParty->getByCompany($companyId);

        return [
            'company' => $company,
            'shareholders' => $shareholders,
            'related_parties' => $relatedParties
        ];
    }

    public function form5472(): void
    {
        $companyId = isset($_GET['id']) ? (int) $_GET['id'] : 1;
        
        // Generar datos básicos
        $data = $this->generate($companyId);
    
        // Año fijo 2025
        $year = 2025;
    
        // Traer todas las invoices del año 2025
        $invoices = $this->invoice->getByYear((string)$year);
    
        // Obtener el monto real de cada invoice según el quote
        $totalGrossPayments = 0;
        foreach ($invoices as &$inv) {
            $quoteId = $inv['quote_id'] ?? null;
            if ($quoteId) {
                $amountData = $this->quoteDetail->getAmount($quoteId);
                $inv['amount'] = $amountData['total'] ?? 0;
                $totalGrossPayments += $inv['amount'];
            } else {
                $inv['amount'] = 0;
            }
        }
        unset($inv);
    
        $data['invoices'] = $invoices;
        $data['gross_payments_form'] = $totalGrossPayments;
    
        include dirname(__DIR__, 4) . '/app/src/Domains/Admin/Irs/views/form5472.php';
    }
}