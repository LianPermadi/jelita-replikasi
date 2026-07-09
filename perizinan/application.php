<?php	
$callback = $_REQUEST['callback'];

require_once "api-connector.php";
$nik=$_POST['nik'];
//$nik="3173055312880007";

function get_data_wni($nik)
{
	global $messageAPI;
	$result=false;              

	$uri="http://gsb.layanan.go.id/api/4f94a755/ditjendukcapil/ws_dukcapil/data_wni/NIK=".$nik;
	$result=queryAPI($uri);
	return $result;
}

// konversi/parsing format data XML ke Array melalui fungsi get_data_wni()

$xml=get_data_wni($nik);
$data=setXML2Arr($xml);

header('Content-Type: text/javascript; charset=UTF-8');
echo $callback . '(' . json_encode($data) . ');';

//echo json_encode($data);

?>