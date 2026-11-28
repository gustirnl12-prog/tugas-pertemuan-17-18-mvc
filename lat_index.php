<?php
require_once __DIR__ . '/controller/proses_barang.php';

$dataBarang = prosesTampilBarang();
$totalPersediaan = prosesTotalPersediaan($dataBarang);

require_once __DIR__ . '/view/form_barang.php';