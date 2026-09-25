<?php
// app/Domains/Irs/Data/Form5472Data.php

namespace App\Domains\Irs\Data;

class Form5472Data
{
    // TODO: reemplazar por consulta a form_5472 WHERE filing_id = $id
    public static function get(int $filingId = 0): array
    {
        return [
            'company' => [
                'name'                     => 'Ikusa LLC',
                'address'                  => '8735 Dunwoody Place, Ste R',
                'city'                     => 'Atlanta',
                'state'                    => 'GA',
                'zip'                      => '30350',
                'ein'                      => '87-2680481',
                'total_assets'             => 3242.90,
                'business_activity'        => 'Marketing and web development services',
                'activity_code'            => '541800',
                'gross_payments_form'      => 3586.63,
                'incorporation_country'    => 'US',
                'incorporation_date'       => '08/31/2021',
                'principal_countries_business' => 'United States, Spain',
                'foreign_owned_50pct'      => true,
                'is_disregarded_entity'    => true,
                'related_party_activity'   => 'Advertising and management services',
                'distribution_note'        =>
                    "During tax year 2025, Ikusa LLC, a foreign-owned U.S. disregarded entity treated as a corporation " .
                    "solely for purposes of section 6038A, made cash distributions totaling \$3,586.63 to its sole foreign owner, " .
                    "Nicolas Granda Bauza.\n\nThe company also received \$4,337.18 of gross receipts from unrelated third-party " .
                    "customers. Those customer receipts are not reported as transactions with the foreign related party on this Form 5472.",
            ],
            'shareholder' => [
                'name'               => 'Nicolas Granda Bauza',
                'full_address_line'  => 'Nicolas Granda Bauza - Calle General Freire, 5 Piso 2 Apt A, Irun, 20303, Guipuzcoa, Spain',
                'reference_id'       => '27-000-001',
                'ftin'               => 'Z0773740W',
                'country'            => 'Spain',
                'tax_country'        => 'Spain',
            ],
            'lines' => [
                // Part IV — todo en 0/blanco para este año (Ikusa no tuvo transacciones ahí, todo fue Part V)
                'line_9' => 0, 'line_10' => 0, 'line_11' => 0, 'line_12' => 0,
                'line_13a' => 0, 'line_13b' => 0, 'line_14' => 0, 'line_15' => 0,
                'line_16' => 0, 'line_17b' => 0, 'line_18' => 0, 'line_19' => 0,
                'line_20' => 0, 'line_21' => 0,
                'line_23' => 0, 'line_24' => 0, 'line_25' => 0, 'line_26' => 0,
                'line_27a' => 0, 'line_27b' => 0, 'line_28' => 0, 'line_29' => 0,
                'line_30' => 0, 'line_31b' => 0, 'line_32' => 0, 'line_33' => 0,
                'line_34' => 0, 'line_35' => 0,
            ],
            'csa' => [
                'csa_description'    => '',
                'csa_benefit_share'  => null,
                'beat_payments'      => null,
                'beat_tax_benefits'  => null,
            ],
            'is_corrected' => true,   // este filing es el CORRECTED que ya generaste
            'tax_year'     => '2025',
        ];
    }
}