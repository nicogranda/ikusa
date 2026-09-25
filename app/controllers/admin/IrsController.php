<?php
require_once "../../app/libraries/admin/Model.php";
require_once "../../app/models/admin/Invoice.php";

class IrsController
{
    public function __construct() {}

    public function form5472()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $path = '/home/ot2ryobi838h/public_html/admin/f5472.php';
            require_once $path;
            return;
        }

        $invoiceModel = new \App\Models\Admin\Invoice();
        $annualTotal  = $invoiceModel->getTotalByYear(2025);

        // Pagos al foreign owner (distribuciones + consultoría)
        $zellePaidToNicolas = 270.00;   // Zelle BofA → Nicolás
        $cashPaidToNicolas  = 3316.63;  // Efectivo clientes → Nicolás
        $totalPaidToNicolas = $zellePaidToNicolas + $cashPaidToNicolas; // 3586.63
        
        

        $data = [
            'company' => [
                'name'                  => 'Ikusa LLC',
                'address'               => '8735 Dunwoody Place, Ste R',
                'city'                  => 'Atlanta',
                'state'                 => 'GA',
                'zip'                   => '30350',
                'ein'                   => '87-2680481',
                'business_activity'     => 'Marketing and web development services',
                'activity_code'         => '541800',
                'incorporation_country' => 'US',
                'incorporation_date'    => '2021-08-31',
                'total_assets'          => 3000.00,
            ],
            'shareholders' => [
                [
                    'name'        => 'Nicolas Granda Bauza',
                    'address'     => 'Calle General Freire, 5 Piso 2 Apt A, Irun, 20303, Guipuzcoa, Spain',
                    'country'     => 'ES',
                    'ftin'        => 'Z0773740W',
                    'ref_id'      => '27-000-001',
                    'tax_country' => 'ES',
                ]
            ],
            
            
            // Line 1f — total gross payments on this form
            'gross_payments_form' => $annualTotal,

            // Part IV — monetary transactions
            // Line 15: servicios recibidos del foreign owner (si aplica)
            'line_15' => $annualTotal,

            // Line 29: pagos por servicios al foreign owner (consultoría/manager)
            'line_29' => $totalPaidToNicolas,

            // Line 35: otros pagos (si hubiera alguno adicional)
            'line_35' => 0,
        ];

        include '../../app/views/admin/irs/form5472.php';
    }

    public function form1120()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            require_once "fpdf/form1120.php";
            return;
        }

        $invoiceModel  = new \App\Models\Admin\Invoice();
        $grossReceipts = $invoiceModel->getTotalByYear(2025); // 4337.18

        // ── Deducciones ──────────────────────────────────────
        // Line 17 — Taxes and licenses
        $taxesLicenses = 80.00;     // GA Corporate Registry $55 + Registered Agent $25

        // Line 26 — Other deductions (detalle en statement adjunto)
        // Consultoría Nicolás:     3586.63
        // GoDaddy hosting:          175.20
        // Gastos tarjeta España:     90.08
        // Fees bancarios BofA:      188.76
        // USPS:                      10.52
        $otherDeductions = 3586.63 + 175.20 + 90.08 + 188.76 + 10.52; // 4051.19

        // ── Balance Sheet ────────────────────────────────────
        // Cash beginning: saldo BofA 01/01/2025
        $cashBeginning = 6.08;
        // Cash end: saldo BofA 31/12/2025
        $cashEnd = 36.91;

        // Total assets beginning: equipos aportados 2021
        // Nota: pendiente de depreciar — confirmar con CPA
        // MacBook Pro $1,500 + Cámara $1,000 + Accesorios $500 = $3,000
        // Con ~4 años de depreciación (5yr MACRS) el valor libro
        // podría estar entre $0-$600. Usamos $600 como estimado conservador.
        $totalAssetsBeginning = 600.00; // ← CPA debe confirmar

        // Total assets end: cash end + valor equipos remanente
        $totalAssetsEnd = $cashEnd + $totalAssetsBeginning; // 636.91

        // Retained earnings: utilidad neta acumulada
        // Ingreso gravable 2025 = grossReceipts - taxesLicenses - otherDeductions
        $retainedEarnings = $grossReceipts - $taxesLicenses - $otherDeductions;

        $data = [
            'company' => [
                'name'               => 'Ikusa LLC',
                'address'            => '8735 Dunwoody Place, Ste R',
                'city'               => 'Atlanta',
                'state'              => 'GA',
                'zip'                => '30350',
                'ein'                => '87-2680481',
                'date_incorporated'  => '2021-08-31',
                'total_assets'       => $totalAssetsEnd,
                'business_activity'  => 'Marketing and web development services',
                'activity_code'      => '541800',
                'accounting_method'  => 'cash',
                'initial_return'     => false,
                'final_return'       => false,
            ],
            'income' => [
                'gross_receipts'     => $grossReceipts,
                'returns_allowances' => 0,
                'cost_of_goods_sold' => 0,
                'dividends'          => 0,
                'interest'           => 0,
                'gross_rents'        => 0,
                'gross_royalties'    => 0,
                'capital_gain'       => 0,
                'other_income'       => 0,
            ],
            'deductions' => [
                'compensation_officers' => 0,
                'salaries_wages'        => 0,
                'repairs_maintenance'   => 0,
                'bad_debts'             => 0,
                'rents'                 => 0,
                'taxes_licenses'        => $taxesLicenses,
                'interest'              => 0,
                'charitable'            => 0,
                'depreciation'          => 0,
                'advertising'           => 0,
                'other_deductions'      => $otherDeductions,
            ],
            'tax' => [
                'estimated_payments' => 0,
                'tax_deposited_7004' => 0,
                'withholding'        => 0,
            ],
            'balance_sheet' => [
                'cash_beginning'         => $cashBeginning,
                'cash_end'               => $cashEnd,
                'total_assets_beginning' => $totalAssetsBeginning,
                'total_assets_end'       => $totalAssetsEnd,
                'retained_earnings'      => $retainedEarnings,
            ],
        ];

        include '../../app/views/admin/irs/form1120.php';
    }
}