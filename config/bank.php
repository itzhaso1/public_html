<?php

return [
    /*
     * Manual bank transfer details (shown to customers).
     * Configure via environment variables on your server.
     */
    'enabled' => env('MANUAL_BANK_TRANSFER_ENABLED', true),

    'bank_name' => env('BANK_NAME', ''),
    'account_name' => env('BANK_ACCOUNT_NAME', ''),
    'account_number' => env('BANK_ACCOUNT_NUMBER', ''),
    'iban' => env('BANK_IBAN', ''),

    'note' => env('BANK_NOTE', ''),
    'whatsapp' => env('BANK_WHATSAPP', ''),
];

