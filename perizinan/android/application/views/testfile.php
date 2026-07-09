<?php

require_once $_SERVER['DOCUMENT_ROOT'].'/android/assets/rdoc/classes/DocxUtilities.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/android/assets/rdoc/classes/CryptoPHPDOCX.php';

$docx = new CryptoPHPDOCX();

$docx2 = new DocxUtilities();

$source = $_SERVER['DOCUMENT_ROOT'].'/backoffice/assets/download/SK_'.$no_pendaftaran.'.docx';
$source2 = $_SERVER['DOCUMENT_ROOT'].'/android/assets/filepreview/SK_'.$no_pendaftaran.'.docx';
$target = $_SERVER['DOCUMENT_ROOT'].'/android/assets/filepreview/SK_'.$no_pendaftaran.'.docx';

$docx2->watermarkDocx($source, $target, $type = 'text', $options = array('text' => 'PREVIEW SK')); 
$docx->protectDocx($source2, $target, array('password' => 'rr2018dipo'));    
redirect( base_url().'assets/filepreview/SK_'.$no_pendaftaran.'.docx');

//echo $source;

?>