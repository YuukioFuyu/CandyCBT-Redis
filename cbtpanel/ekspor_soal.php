<?php
require "../config/config.default.php";
require "../vendor/autoload.php";
require "../config/config.function.php";

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

if($token == $token1) {

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setCellValue('A1', 'ID SOAL');
$sheet->setCellValue('B1', 'ID MAPEL');
$sheet->setCellValue('C1', 'NOMOR');
$sheet->setCellValue('D1', 'SOAL');
$sheet->setCellValue('E1', 'JENIS');
$sheet->setCellValue('F1', 'PILA');
$sheet->setCellValue('G1', 'PILB');
$sheet->setCellValue('H1', 'PILC');
$sheet->setCellValue('I1', 'PILD');
$sheet->setCellValue('J1', 'PILE');
$sheet->setCellValue('K1', 'JAWABAN');
$sheet->setCellValue('L1', 'FILE');
$sheet->setCellValue('M1', 'FILE1');
$sheet->setCellValue('N1', 'FILEA');
$sheet->setCellValue('O1', 'FILEB');
$sheet->setCellValue('P1', 'FILEC');
$sheet->setCellValue('Q1', 'FILED');
$sheet->setCellValue('R1', 'FILEE');

$sheet->getStyle('A1:R1')->applyFromArray(
    array(
        'fill' => array(
            'type' => Fill::FILL_SOLID,
            'color' => array('rgb' => '00FF00')
        ),
        'font'  => array(
            'bold'  =>  true
        )
    )
);
$query = mysqli_query($koneksi, "SELECT * FROM SOAL");
$i = 2;
$no = 1;
while ($row = mysqli_fetch_array($query)) {
    $sheet->setCellValue('A' . $i, $row['id_soal']);
    $sheet->setCellValue('B' . $i, $row['id_mapel']);
    $sheet->setCellValue('C' . $i, $row['nomor']);
    $sheet->setCellValue('D' . $i, $row['soal']);
    $sheet->setCellValue('E' . $i, $row['jenis']);
    $sheet->setCellValue('F' . $i, $row['pilA']);
    $sheet->setCellValue('G' . $i, $row['pilB']);
    $sheet->setCellValue('H' . $i, $row['pilC']);
    $sheet->setCellValue('I' . $i, $row['pilD']);
    $sheet->setCellValue('J' . $i, $row['pilE']);
    $sheet->setCellValue('K' . $i, $row['jawaban']);
    $sheet->setCellValue('L' . $i, $row['file']);
    $sheet->setCellValue('M' . $i, $row['file1']);
    $sheet->setCellValue('N' . $i, $row['fileA']);
    $sheet->setCellValue('O' . $i, $row['fileB']);
    $sheet->setCellValue('P' . $i, $row['fileC']);
    $sheet->setCellValue('Q' . $i, $row['fileD']);
    $sheet->setCellValue('R' . $i, $row['fileE']);
     $i++;
}
foreach (range('A', 'R') as $col) {
    $sheet->getColumnDimension($col)->setAutoSize(true);
}
$styleArray = [
    'borders' => [
        'allBorders' => [
            'borderStyle' => Border::BORDER_MEDIUM,
            'color' => array('argb' => '000000'),
        ],
    ],
];
$i = $i - 1;
$sheet->getStyle('A2:R' . $i)->applyFromArray($styleArray);


$writer = new Xlsx($spreadsheet);
$filename = 'soal_candy';
header('Content-Type: application/vnd.ms-excel'); // generate excel file
header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
header('Cache-Control: max-age=0');
$writer->save('php://output');
}

else{
  jump("$homeurl");
exit;
}