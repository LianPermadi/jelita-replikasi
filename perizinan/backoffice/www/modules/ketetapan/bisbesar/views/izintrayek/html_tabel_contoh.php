<?php
require('html_table.php');

function tanggal_indo($tanggal)
{
  $bulan = array (1 =>   'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember'
      );
  $split = explode('-', $tanggal);
  return $split[2] . ' ' . $bulan[ (int)$split[1] ] . ' ' . $split[0];
}


class PDF extends FPDF
{


// Page header
function Header()
{

    // Logo
   //$this->Image('logo.png',10,6,30);
    // Arial bold 15
    $this->SetFont('Arial','',11);
    // Move to the right
    $this->Cell(80);
   // $this->Cell(0,10,$NO_SK,0,1);
    $this->Ln(1);
    //$this->Cell(1,10,$TG_SK,0,0,'C');
    $this->Ln(1);
    $this->Cell(0,5,'Trayek',0,0,'C');
    $this->Ln(2);


}

// Page footer
function Footer()
{
    // Position at 1.5 cm from bottom
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Page number
   
     $this->Cell(0,5,'LAPORAN REKAPITULASI PENERIMAAN MAHASISWA BARU',0,0,'C');
     $this->Ln(2);
      $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
}
}



// Instanciation of inherited class



//for($i=1;$i<=40;$i++)
   // $pdf->Cell(0,10,'Printing line number '.$i,0,1);

$htmlTable=
'<div id="kolom" style="border:1px solid red;"><TABLE>
  <tr>
    <td>No.</td><td>Nama</td><td>Hobi</td>
  </tr>
  <tr>
    <td>1</td><td>Dida Nurwanda</td><td>Makan, Maen PES, Ngoding, Maen Gundu, Jalan jalan sore</td>
  </tr>
  <tr>
    <td>1</td><td>Dida Nurwanda</td><td>Makan, Maen PES, Ngoding, Maen Gundu, Jalan jalan sore</td>
  </tr>
  <tr>
    <td>1</td><td>Dida Nurwanda</td><td>Makan, Maen PES, Ngoding, Maen Gundu, Jalan jalan sore</td>
  </tr>
  <tr>
    <td>1</td><td>Dida Nurwanda</td><td>Makan, Maen PES, Ngoding, Maen Gundu, Jalan jalan sore</td>
  </tr>
  <tr>
    <td>1</td><td>Dida Nurwanda</td><td>Makan, Maen PES, Ngoding, Maen Gundu, Jalan jalan sore</td>
  </tr>
  <tr>
    <td>1</td><td>Dida Nurwanda</td><td>Makan, Maen PES, Ngoding, Maen Gundu, Jalan jalan sore</td>
  </tr>
  <tr>
    <td>1</td><td>Dida Nurwanda</td><td>Makan, Maen PES, Ngoding, Maen Gundu, Jalan jalan sore</td>
  </tr><tr>
    <td>1</td><td>Dida Nurwanda</td><td>Makan, Maen PES, Ngoding, Maen Gundu, Jalan jalan sore</td>
  </tr>
  <tr>
    <td>1</td><td>Dida Nurwanda</td><td>Makan, Maen PES, Ngoding, Maen Gundu, Jalan jalan sore</td>
  </tr>
  <tr>
    <td>1</td><td>Dida Nurwanda</td><td>Makan, Maen PES, Ngoding, Maen Gundu, Jalan jalan sore</td>
  </tr>

  <tr>
    <td>1</td><td>Dida Nurwanda</td><td>Makan, Maen PES, Ngoding, Maen Gundu, Jalan jalan sore</td>
  </tr>
  <tr>
    <td>1</td><td>Dida Nurwanda</td><td>Makan, Maen PES, Ngoding, Maen Gundu, Jalan jalan sore</td>
  </tr>
  <tr>
    <td>1</td><td>Dida Nurwanda</td><td>Makan, Maen PES, Ngoding, Maen Gundu, Jalan jalan sore</td>
  </tr>
  <tr>
    <td>1</td><td>Dida Nurwanda</td><td>Makan, Maen PES, Ngoding, Maen Gundu, Jalan jalan sore</td>
  </tr>
  <tr>
    <td>1</td><td>Dida Nurwanda</td><td>Makan, Maen PES, Ngoding, Maen Gundu, Jalan jalan sore</td>
  </tr>
  <tr>
    <td>1</td><td>Dida Nurwanda</td><td>Makan, Maen PES, Ngoding, Maen Gundu, Jalan jalan sore</td>
  </tr>
  <tr>
    <td>1</td><td>Dida Nurwanda</td><td>Makan, Maen PES, Ngoding, Maen Gundu, Jalan jalan sore</td>
  </tr>

  <tr>
    <td>1</td><td>Dida Nurwanda</td><td>Makan, Maen PES, Ngoding, Maen Gundu, Jalan jalan sore</td>
  </tr>

  <tr>
    <td>1</td><td>Dida Nurwanda</td><td>Makan, Maen PES, Ngoding, Maen Gundu, Jalan jalan sore</td>
  </tr>
  <tr>
    <td>1</td><td>Dida Nurwanda</td><td>Makan, Maen PES, Ngoding, Maen Gundu, Jalan jalan sore</td>
  </tr>
  <tr>
    <td>1</td><td>Dida Nurwanda</td><td>Makan, Maen PES, Ngoding, Maen Gundu, Jalan jalan sore</td>
  </tr>








  <tr>
    <td>1</td><td>Dida Nurwanda</td><td>Makan, Maen PES, Ngoding, Maen Gundu, Jalan jalan sore</td>
  </tr><tr>
    <td>1</td><td>Dida Nurwanda</td><td>Makan, Maen PES, Ngoding, Maen Gundu, Jalan jalan sore</td>
  </tr>
  <tr>
    <td>1</td><td>Dida Nurwanda</td><td>Makan, Maen PES, Ngoding, Maen Gundu, Jalan jalan sore</td>
  </tr>
  <tr>
    <td>1</td><td>Dida Nurwanda</td><td>Makan, Maen PES, Ngoding, Maen Gundu, Jalan jalan sore</td>
  </tr>
  <tr>
    <td>1</td><td>Dida Nurwanda</td><td>Makan, Maen PES, Ngoding, Maen Gundu, Jalan jalan sore</td>
  </tr>
  <tr>
    <td>1</td><td>Dida Nurwanda</td><td>Makan, Maen PES, Ngoding, Maen Gundu, Jalan jalan sore</td>
  </tr>
  <tr>
    <td>1</td><td>Dida Nurwanda</td><td>Makan, Maen PES, Ngoding, Maen Gundu, Jalan jalan sore</td>
  </tr>
  <tr>
    <td>1</td><td>Dida Nurwanda</td><td>Makan, Maen PES, Ngoding, Maen Gundu, Jalan jalan sore</td>
  </tr>
  <tr>
    <td>1</td><td>Dida Nurwanda</td><td>Makan, Maen PES, Ngoding, Maen Gundu, Jalan jalan sore</td>
  </tr>
  <tr>
    <td>1</td><td>Dida Nurwanda</td><td>Makan, Maen PES, Ngoding, Maen Gundu, Jalan jalan sore</td>
  </tr>
</TABLE></div>';
//$pdf = new PDF();

$pdf=new PDF_HTML_Table();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','',10);
$pdf->WriteHTML("Start of the HTML table.<BR>$htmlTable<BR>End of the table.");
$pdf->Output();
?>