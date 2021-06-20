<?php 
    include 'baglan.php';
    require 'vendor/autoload.php';

    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    $basTarih=date("Y.m.d",strtotime($_POST["basTarih"]));
    $bitTarih=date("Y.m.d",strtotime($_POST["bitTarih"]));

    $basTarih=$basTarih." 00:00";
    $bitTarih=$bitTarih." 23:59";

    $sheet->setCellValue('A1', '#');
    $sheet->setCellValue('B1', 'Tarih');
    $sheet->setCellValue('C1', 'Ürün');
    $sheet->setCellValue('D1', 'Ücret');
    $sheet->setCellValue('E1', 'Miktar');
    
    $tableExcelSor = $db->prepare("SELECT * FROM siparis
        LEFT JOIN urun ON urun.urunId=siparis.urunId
        WHERE siparisTarih BETWEEN '$basTarih' and '$bitTarih'
        ");
    $tableExcelSor->execute();
    $x=2;
    $y=1;
    while ($tableExcelCek=$tableExcelSor->fetch(PDO::FETCH_ASSOC)) {
        $tarih = $tableExcelCek['siparisTarih'];
        $urunAd = $tableExcelCek['urunAd'];
        $kullaniciurunFiyat = $tableExcelCek['kullaniciurunFiyat'];
        $kullaniciurunMiktar = $tableExcelCek['kullaniciurunMiktar'];

        $sheet->setCellValue('A'.$x, $y);
        $sheet->setCellValue('B'.$x, $tarih);
        $sheet->setCellValue('C'.$x, $urunAd);
        $sheet->setCellValue('D'.$x, $kullaniciurunFiyat);
        $sheet->setCellValue('E'.$x, $kullaniciurunMiktar);
        $x++;
        $y++;

    } 

    $filename='rapor.xlsx';

    $writer = new Xlsx($spreadsheet);
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header("Content-Disposition: attachment; filename=$filename");
    $writer->save('php://output');


?>