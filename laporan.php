<?php
   include "koneksi.php";
   include "fpdf/fpdf.php";
   
    $pdf = new FPDF();
    $pdf->Open();
    $pdf->addPage();
    $pdf->setAutoPageBreak(true);
    $pdf->setFont('Arial','',12);
    $pdf->text(50,15,'LAPORAN DATA PENJUALAN 12 BULAN TERAKHIR');
    $pdf->text(80,20,'CV. SACK DENIM');
    $pdf->text(83,25,'PEKALONGAN');
    $pdf->Line(10,31,198,31);
    $pdf->Line(10,32,198,32);
    $yi = 46;
    $ya = 40;
    $pdf->setFont('Arial','',9);
    $pdf->setFillColor(222,222,222);
    $pdf->setXY(40,$ya);
    $pdf->CELL(6,6,'NO',1,0,'C',1);
    $pdf->CELL(30,6,'Tanggal',1,0,'C',1);
    $pdf->CELL(30,6,'Penjualan',1,0,'C',1);
    $pdf->CELL(30,6,'Moving Average',1,0,'C',1);
	$pdf->CELL(25,6,'Error',1,0,'C',1);
    $ya = $yi + $row;
    $sql = mysql_query("select * from rekap_penjualan order by id_penjualan DESC LIMIT 12",$koneksi);
    $i = 1;
    $no = 1;
    $max = 31;
    $row = 6;
    while($data = mysql_fetch_array($sql)){
    $tgl = tgl_indo($data[4]);
    $pdf->setXY(40,$ya);
    $pdf->setFont('arial','',9);
    $pdf->setFillColor(255,255,255);
    $pdf->cell(6,6,$no,1,0,'C',1);
    $pdf->cell(30,6,$tgl,1,0,'L',1);
    $pdf->cell(30,6,$data[2],1,0,'C',1);
    $pdf->CELL(30,6,$data[1],1,0,'C',1);
	$pdf->CELL(25,6,$data[3],1,0,'C',1);
    $ya = $ya+$row;
    $no++;
    $i++;
    $dm[id] = $data[0];
    }
    $pdf->text(150,$ya+6,"PEKALONGAN , ". date('d-M-Y'));
    $pdf->text(150,$ya+20,"OWNER SACK DENIM");
    $pdf->output();
    ?>