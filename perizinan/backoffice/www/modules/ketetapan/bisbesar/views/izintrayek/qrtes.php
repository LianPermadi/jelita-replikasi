<?php
/*header("Content-Type: image/png");

 $qr['data'] = 'http://spekta.tasikmalayakab.go.id/web/index.php';

 $this->ciqrcode->generate($qr);
 */
 //include "QR_BarCode.php"; 

// objek QRcode 
//$qr = new QR_BarCode(); 

// membuat QR code teks yang berisikan "Codingan.com"
//$qr->text("tes.com"); 

// me-render QR code
//$qr->qrCode();

// menyimpan gambar QR code dengan nama barcode.png
//$qr->qrCode(350,'barcode.png');
$PNG_WEB_DIR = '';
 include "royqrcode/qrlib.php";    
    
    //ofcourse we need rights to create temp dir
    //if (!file_exists($PNG_TEMP_DIR))
      //  mkdir($PNG_TEMP_DIR);
    //$filename = $PNG_TEMP_DIR.'test.png';
    $filename = 'test.png';
    $errorCorrectionLevel = 'L';
    if (isset($_REQUEST['level']) && in_array($_REQUEST['level'], array('L','M','Q','H')))
        $errorCorrectionLevel = $_REQUEST['level'];    

    $matrixPointSize = 4;
    if (isset($_REQUEST['size']))
        $matrixPointSize = min(max((int)$_REQUEST['size'], 1), 10);

    //display generated file
	 QRcode::png('http://localhost/webbppt/spekta/backoffice/login', $filename, $errorCorrectionLevel, $matrixPointSize, 2); 
    echo '<center><img src="'.$PNG_WEB_DIR.basename($filename).'" /></center>';  
?>
tes




