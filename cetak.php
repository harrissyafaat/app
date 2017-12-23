	<?php
	// http://achmatim.net/2009/11/29/step-by-step-php-membuat-laporan-pdf-dengan-fpdf/#codesyntax_2
	
	include "config/conn.php";
     
    #ambil data di tabel dan masukkan ke array
    $query = "SELECT * FROM t_anggota ORDER BY nama_anggota";
    $sql = mysqli_query ($koneksi, $query);
    $data = array();
    while ($row = mysqli_fetch_assoc($sql)) {
    array_push($data, $row);
    }
     
    #setting judul laporan dan header tabel
    $judul = "Jam'iyah Waqi'ah "Sunan Kalijogo"";
    $header = array(
    array("label"=>"Kode", "length"=>15, "align"=>"L"),
    array("label"=>"Nama", "length"=>30, "align"=>"L"),
    array("label"=>"Alamat", "length"=>35, "align"=>"L"),
    array("label"=>"Jenis Kelamin", "length"=>27, "align"=>"L"),
	array("label"=>"Pekerjaan", "length"=>30, "align"=>"L"),
    array("label"=>"Tgl Masuk", "length"=>25, "align"=>"L"),
    array("label"=>"Telp", "length"=>20, "align"=>"L")
    );
     
    #sertakan library FPDF dan bentuk objek
    require_once ("fpdf/fpdf.php");
    $pdf = new FPDF();
    $pdf->AddPage();
     
    #tampilkan judul laporan
    $pdf->SetFont('Arial','B','16');
    $pdf->Cell(0,20, $judul, '0', 1, 'C');
     
    #buat header tabel
    $pdf->SetFont('Arial','','10');
    $pdf->SetFillColor(255,0,0);
    $pdf->SetTextColor(255);
    $pdf->SetDrawColor(128,0,0);
    foreach ($header as $kolom) {
    $pdf->Cell($kolom['length'], 5, $kolom['label'], 1, '0', $kolom['align'], true);
    }
    $pdf->Ln();
     
    #tampilkan data tabelnya
    $pdf->SetFillColor(224,235,255);
    $pdf->SetTextColor(0);
    $pdf->SetFont('');
    $fill=false;
    foreach ($data as $baris) {
    $i = 0;
    foreach ($baris as $cell) {
    $pdf->Cell($header[$i]['length'], 5, $cell, 1, '0', $kolom['align'], $fill);
    $i++;
    }
    $fill = !$fill;
    $pdf->Ln();
    }
     
    #output file PDF
    $pdf->Output();
    ?> 
    <!-- Enter code here -->

