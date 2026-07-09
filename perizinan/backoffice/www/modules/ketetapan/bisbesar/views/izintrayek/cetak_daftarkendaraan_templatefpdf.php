<?php

$NO_SK = "";
$TG_SK = "";
$BERLAKU = "";
$NAMA_PERUS ="";
$ALAMAT_PER = "";

$i=1;
$b=5;

//$pdf = new FPDF('P','mm',array(100,150));
//$pdf = new PDF('P','mm','A4');
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


class PDF extends FPDF {

  function Header()
{

    // Logo
   //$this->Image('logo.png',10,6,30);
    // Arial bold 15
    $this->SetFont('Arial','',11);
    // Move to the right
    $this->Cell(80);
    //$this->Cell(0,10,$NO_SK,0,1);
    $this->Ln(1);
    $this->Cell(1,10,$TG_SK,0,0,'C');
    $this->Ln(1);
    $this->Cell(0,30,'Trayek',0,0,'C');
    $this->Ln(2);



}

// Page footer
function Footer()
{
   // Position at 1.5 cm from bottom
   // $this->SetY(-15);
     $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Page number

    $this->Image(base_url().'assets/images/icon/ttd.png',20,260,25);
     $this->Cell(10,8,'tes',0,0,'C');
    // $this->Ln(2);
     $this->Cell(2,12,'Page '.$this->PageNo().'/{nb}',0,0,'C');
     
  
}

    function myCell($w,$h,$x,$t){
        $height=$h/6;
        $first=$height+2;
        $second=$height+$height+$height+3;
        $third=$height+$height+$height+$height+4;
        $fourth = $height+$height+$height+$height+$height+5;
        $fifth = $height+$height+$height+$height+$height+$height+6;
        $six = $height+$height+$height+$height+$height+$height+$height+7;
        $seven = $height+$height+$height+$height+$height+$height+$height+$height+8;
        $len=strlen($t);
        if($len<25){
            $this->SetX($x);
            $this->Cell($w,$h,$t,'TBLR',0,'C',0);
        }
        else if($len<=25){
            $txt=str_split($t,25);
            $this->SetX($x);
            $this->Cell($w,$first,$txt[0],'','','');
            $this->SetX($x);
            $this->Cell($w,$h,'','TBLR',0,'C',0);
        }else if($len<=50){
           $txt=str_split($t,25);
            $this->SetX($x);
            $this->Cell($w,$first,$txt[0],'','','');
            $this->SetX($x);
            $this->Cell($w,$second,$txt[1],'','','');
            $this->SetX($x);
            $this->Cell($w,$h,'','TBLR',0,'C',0);
        }else if($len<=75){
          $txt=str_split($t,25);
            $this->SetX($x);
            $this->Cell($w,$first,$txt[0],'','','');
            $this->SetX($x);
            $this->Cell($w,$second,$txt[1],'','','');
            $this->SetX($x);
            $this->Cell($w,$third,$txt[2],'','','');
             $this->SetX($x);
            $this->SetX($x);
            $this->Cell($w,$h,'','TBLR',0,'C',0);
        }else if($len<=100){
           $txt=str_split($t,25);
            $this->SetX($x);
            $this->Cell($w,$first,$txt[0],'','','');
            $this->SetX($x);
            $this->Cell($w,$second,$txt[1],'','','');
            $this->SetX($x);
            $this->Cell($w,$third,$txt[2],'','','');
            $this->SetX($x);
            $this->Cell($w,$fourth,$txt[3],'','','');
            $this->SetX($x);
            $this->Cell($w,$h,'','TBLR',0,'C',0);
        }else if($len<=125){
          $txt=str_split($t,25);
            $this->SetX($x);
            $this->Cell($w,$first,$txt[0],'','','');
            $this->SetX($x);
            $this->Cell($w,$second,$txt[1],'','','');
            $this->SetX($x);
            $this->Cell($w,$third,$txt[2],'','','');
             $this->SetX($x);
            $this->Cell($w,$fourth,$txt[3],'','','');
            $this->SetX($x);
            $this->Cell($w,$fifth,$txt[4],'','','');
           
            $this->SetX($x);
            $this->Cell($w,$h,'','TBLR',0,'C',0);
        }else if($len<=150){
           $txt=str_split($t,25);
            $this->SetX($x);
            $this->Cell($w,$first,$txt[0],'','','');
            $this->SetX($x);
            $this->Cell($w,$second,$txt[1],'','','');
            $this->SetX($x);
            $this->Cell($w,$third,$txt[2],'','','');
             $this->SetX($x);
            $this->Cell($w,$fourth,$txt[3],'','','');
            $this->SetX($x);
            $this->Cell($w,$fifth,$txt[4],'','','');
           $this->SetX($x);
            $this->Cell($w,$six,$txt[5],'','','');
            $this->SetX($x);
            $this->Cell($w,$h,'','TBLR',0,'C',0);
        }else if($len >150){
           $txt=str_split($t,25);
            $this->SetX($x);
            $this->Cell($w,$first,$txt[0],'','','');
            $this->SetX($x);
            $this->Cell($w,$second,$txt[1],'','','');
            $this->SetX($x);
            $this->Cell($w,$third,$txt[2],'','','');
             $this->SetX($x);
            $this->Cell($w,$fourth,$txt[3],'','','');
            $this->SetX($x);
            $this->Cell($w,$fifth,$txt[4],'','','');
           $this->SetX($x);
            $this->Cell($w,$six,$txt[5],'','','');
            $this->SetX($x);
           $this->Cell($w,$seven,$txt[6],'','','');
            $this->SetX($x);
            $this->Cell($w,$h,'','TBLR',0,'C',0);
        }
    
    }
}
$pdf = new PDF('P','mm','A4');

$pdf->AddPage();
$pdf->AliasNbPages();
$pdf->SetFont('Arial','',10);
$pdf->Ln();

$w=45;
$h=25;

$z=5;

 foreach($bb_izintrayek as $row)
    {
      if ($row->BBM == '1'){
$BBM = 'BENSIN';
}else if($row->BBM == '2'){
$BBM = 'SOLAR';
}else if($row->BBM == '3'){
$BBM =  'GAS';
}




$pdf->SetFont('Arial','',9);
       $x=$pdf->getx();
$pdf->myCell(7,$h,$x,$i);
$pdf->SetFont('Arial','',9);
$x=$pdf->getx();
$pdf->myCell(25,$h,$x,$row->NO_IK);
$pdf->SetFont('Arial','',9);
$x=$pdf->getx();
$pdf->myCell(22,$h,$x,$row->NO_MOBIL);
$pdf->SetFont('Arial','',9);
$x=$pdf->getx();
$pdf->myCell(20,$h,$x,$row->NO_UJI);
$pdf->SetFont('Arial','',9);
$x=$pdf->getx();
$pdf->myCell(18,$h,$x,$row->MERK);
$pdf->SetFont('Arial','',9);
$x=$pdf->getx();
$pdf->myCell(15,$h,$x,$BBM);
$pdf->SetFont('Arial','',9);
$x=$pdf->getx();
$pdf->myCell(10,$h,$x,$row->TAHUN_PEMB);
$pdf->SetFont('Arial','',9);
$x=$pdf->getx();
$pdf->myCell(10,$h,$x,$row->DA_ORANG);
$pdf->SetFont('Arial','',9);
$x=$pdf->getx();
$pdf->myCell(22,$h,$x,$row->KODE_TRAYE);

$pdf->SetFont('Arial','',8);
$x=$pdf->getx();
$pdf->myCell($w,$h,$x,$row->TG_AKHIR."               ".$row->NAMATRAYEK);

      $pdf->Ln();
if($i==5 ){
$pdf->Cell(30,100,'',' ');
$pdf->Cell(30,100,'',' ');
$pdf->Cell(30,100,'',' ');
$pdf->Cell(30,100,'',' ');
$pdf->Cell(30,100,'',' ');
$pdf->Cell(30,100,'',' ');
$pdf->Cell(30,100,'',' ');
$pdf->Cell(30,100,'',' ');
$pdf->Cell(30,100,'',' ');
$pdf->Cell(30,100,'',' ');
$pdf->Ln();

}

       
    
       
       
      //  $fill = !$fill;
        $i++;
       
    }
ob_start();


$pdf->Output();
?>
/*$NO_SK = "";
$TG_SK = "";
$BERLAKU = "";
$NAMA_PERUS ="";
$ALAMAT_PER = "";

$i=1;


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
    //$this->Cell(0,10,$NO_SK,0,1);
    $this->Ln(1);
  //  $this->Cell(1,10,$TG_SK,0,0,'C');
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
$pdf = new PDF();

$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','',12);
//for($i=1;$i<=40;$i++)
   // $pdf->Cell(0,10,'Printing line number '.$i,0,1);
foreach($bb_izintrayek as $u){
 $NO_SK =  $u->NO_SK;
 $TG_SK = $u->TG_SK;
 $BERLAKU = $u->BERLAKU;
 $NAMA_PERUS = $u->NAMA_PERUS;
 $ALAMAT_PER = $u->ALAMAT_PER;


}

$pdf->SetFont('Arial','',9);
$pdf->Ln();

$pdf->Cell(80,0,$NO_SK,0);
$pdf->Ln();
$pdf->Cell(100,6,$TG_SK,0);
$pdf->Ln();
$pdf->Cell(30,6,$NAMA_PERUS,0,'C');
$pdf->Ln();
$pdf->Cell(30,6,'Trayek',0,'C');
$pdf->Ln();
$pdf->Cell(30,6,$ALAMAT_PER,0,'C');

$html='<table border=”1″>
<tr>
<td width=”200″ height=”30″>cell 1</td><td width=”200″ height=”30″ bgcolor=”#D0D0FF”>cell 2</td>
</tr>
<tr>
<td width=”200″ height=”30″>cell 3</td><td width=”200″ height=”30″>cell 4</td>
</tr>
</table>';

//$pdf->WriteHTML($html);


/*$i = 0;
while($data=mysql_fetch_row($bb_izintrayek))
{
$cell[$i][0] = $data[0];
$cell[$i][1] = $data[1];
$cell[$i][2] = $data[2];
$cell[$i][3] = $data[3];
$i++;
}
class PDF extends FPDF
{
//untuk pengaturan header halaman
function Header()
{
//Pengaturan Font Header
$this->SetFont('Times','B',14); //jenis font : Times New Romans, Bold, ukuran 14
 
//untuk warna background Header
$this->SetFillColor(255,255,255);
 
//untuk warna text
$this->SetTextColor(0,0,0);
 
//Menampilkan tulisan di halaman
$this->Cell(19,1,'Data Pribadi','TBLR',0,'C',1); //TBLR (untuk garis)=> B = Bottom,
// L = Left, R = Right
//untuk garis, C = center
}
}
 
//pengaturan ukuran kertas P = Portrait
$pdf = new PDF('P','cm','A4');
$pdf->Open();
$pdf->AddPage();
 
//Ln() = untuk pindah baris
$pdf->Ln();
$pdf->SetFont('Times','B',12);
 
$pdf->Cell(1,1,'No','LRTB',0,'C');
$pdf->Cell(3,1,'Nama','LRTB',0,'C');
$pdf->Cell(4,1,'Alamat','LRTB',0,'C');
$pdf->Cell(5,1,'Telepon','LRTB',0,'C');
$pdf->Cell(6,1,'Jabatan','LRTB',0,'C');
$pdf->Ln();
 
$pdf->SetFont('Times','',10);
for($j=0;$j<$i;$j++)
{
//menampilkan data dari hasil query database
$pdf->Cell(1,1,$j+1,'LBTR',0,'C');
$pdf->Cell(3,1,$cell[$j][0],'LBTR',0,'C');
$pdf->Cell(4,1,$cell[$j][1],'LBTR',0,'C');
$pdf->Cell(5,1,$cell[$j][2],'LBTR',0,'C');
$pdf->Cell(6,1,$cell[$j][3],'LBTR',0,'C');
$pdf->Ln();
}
 ob_start();
//menampilkan output berupa halaman PDF
$pdf->Output();
?>
*/
$pdf->Ln(10);

$pdf->Ln(5);
 //$pdf->Cell(0,10,$TG_SK,0,1);
//$w = array(40, 35, 40, 45);
$fill = false;
    foreach($bb_izintrayek as $row)
    {
       $pdf->MultiCell(4,7,$i,1);
        /*$pdf->MultiCell(20,30,$row->NO_IK,'B',0,'C');
        $pdf->MultiCell(20,30,$row->NO_MOBIL,'B',0,'C');
        $pdf->MultiCell(20,30,$row->NO_UJI,'B',0,'C');
        $pdf->MultiCell(20,30,$row->MERK,'B',0,'C');
        $pdf->MultiCell(20,30,$row->BBM,'B',0,'C');
        $pdf->MultiCell(20,30,$row->TAHUN_PEMB,'B',0,'C');
        $pdf->MultiCell(20,30,$row->DA_ORANG,'B',0,'C');
        $pdf->MultiCell(20,30,$row->KODE_TRAYE,'B',0,'C');*/
        $pdf->MultiCell(40,7,$row->NAMATRAYEK,1,'C');
      
        //$pdf->Ln();
        $fill = !$fill;
        $i++;
    }
    // Closing line
    //$pdf->Cell(array_sum($w),0,'','T');

ob_start();
$pdf->Output();*/
?>