<?php
require __DIR__ . '/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

$dir = __DIR__ . '/xlsx';
$files = glob($dir . '/*.xlsx');

usort($files, function($a, $b) {
    $na = strtolower(basename($a));
    $nb = strtolower(basename($b));
    $aMain = (strpos($na, '(') === false) ? 0 : 1;
    $bMain = (strpos($nb, '(') === false) ? 0 : 1;
    if ($aMain !== $bMain) return $aMain - $bMain;
    return strcmp($na, $nb);
});

$allCategories = [];
$allProducts = [];

foreach ($files as $file) {
    $spreadsheet = IOFactory::load($file);
    $sheet = $spreadsheet->getActiveSheet();
    $highestRow = $sheet->getHighestRow();
    $highestCol = $sheet->getHighestColumn();

    echo "===== " . basename($file) . " (rows=" . $highestRow . ", cols=" . $highestCol . ") =====\n";

    // Find header row (row 5 has headers)
    $headerRow = 5;
    $headers = [];
    for ($col = 'A'; $col <= $highestCol; $col++) {
        $headers[$col] = trim((string)$sheet->getCell($col . $headerRow)->getValue());
    }

    for ($row = 6; $row <= $highestRow; $row++) {
        $group = trim((string)$sheet->getCell('M' . $row)->getValue());
        $nameEn = trim((string)$sheet->getCell('E' . $row)->getValue());
        $nameKh = trim((string)$sheet->getCell('D' . $row)->getValue());
        $price = $sheet->getCell('H' . $row)->getValue();
        $code = trim((string)$sheet->getCell('B' . $row)->getValue());
        $desc = trim((string)$sheet->getCell('Q' . $row)->getValue());

        // Skip empty/header/total rows
        if (empty($group) && empty($nameEn) && empty($nameKh)) continue;
        if (is_string($price) && stripos($price, 'SUM') !== false) continue;
        if (empty($nameEn) && empty($nameKh)) continue;

        if (!isset($allCategories[$group])) $allCategories[$group] = 0;
        $allCategories[$group]++;

        $allProducts[] = [
            'file' => basename($file),
            'code' => $code,
            'name_en' => $nameEn,
            'name_kh' => $nameKh,
            'price' => $price,
            'group' => $group,
            'desc' => $desc,
        ];
    }
}

echo "\n\n=========== UNIQUE CATEGORIES (Product Group) ===========\n";
$i = 1;
foreach ($allCategories as $cat => $count) {
    echo $i . ". " . $cat . "  [" . $count . " products]\n";
    $i++;
}

echo "\n\n=========== ALL PRODUCTS ===========\n";
foreach ($allProducts as $p) {
    echo $p['code'] . " | " . $p['name_en'] . " | " . $p['name_kh'] . " | $" . $p['price'] . " | GROUP: " . $p['group'] . "\n";
}

echo "\nTotal products: " . count($allProducts) . "\n";
echo "Total categories: " . count($allCategories) . "\n";
