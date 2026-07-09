<?php
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