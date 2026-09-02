<?php

define( 'ABSPATH', __DIR__ . '/' );

function add_action() {}
function add_filter() {}

require_once __DIR__ . '/../../src/homepage/forms/callback-request.php';

$cases = [
    '09123456789' => '09123456789',
    '۰۹۱۲۳۴۵۶۷۸۹' => '09123456789',
    '٠٩١٢٣٤٥٦٧٨٩' => '09123456789',
    '+98 (912) 345-6789' => '989123456789',
];

foreach ( $cases as $input => $expected ) {
    $actual = gpante_home_normalize_mobile( $input );

    if ( $actual !== $expected ) {
        fwrite( STDERR, "Normalization failed for {$input}: {$actual} !== {$expected}\n" );
        exit( 1 );
    }
}

echo "callback normalization: OK\n";
