<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$tables = Illuminate\Support\Facades\DB::select('SHOW TABLES');
$names = [];
foreach ($tables as $table) {
    if ($table instanceof \stdClass) {
        $table = (array) $table;
    }
    $values = array_values($table);
    $names[] = $values[0];
}
echo json_encode($names);
