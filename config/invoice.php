<?php
return [
    // Starting number for regular (partial) invoices
    'start_number' => env('INVOICE_START_NUMBER', 335),

    // Starting number for global invoices
    'global_start_number' => env('GLOBAL_INVOICE_START_NUMBER', 057),
];
