<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class viewData {

		
	public function __construct(){
		require_once "adapter.php";
		}
		
	public function getdataperusahaanbynoip($noip){
		//$url='http://203.114.227.117/mantra/api/bkpm_integrasi_daerah/view_daerah/';
		$url='http://203.114.226.119/mantra/api/bkpm_integrasi_daerah/view_daerah/';		
		//$url='http://10.1.237.135/mantra/api/bkpm_integrasi_daerah/view_daerah/';
		$method='get_data_perusahaan_by_qrcode';
		$accesskey='gnfw4efvl8';
		$_POST["par"]["QRCODE"]='%'.$noip.'%';
		$request=$_POST["par"];
		
		$result=callAPI(
				$endpoint=$url,
				$operation=$method,
				$accesskey,
				$parameter=$request,
				$xmlformat=true,  // true:output data XML, false:output data Array
				$callmethod='POST' // call option: GET, POST, REST, RESTFULL, RESTFULLPAR
		);
		//var_dump($result);die();
		$arrayData=simplexml_load_string($result);
		//print_r($arrayData);die();
		return $arrayData->data->get_data_perusahaan_by_qrcode[0];
	}
	
	public function getselectedkegiatanid($stringkodejeniskegiatan){
		$stringkodejeniskegiatan=mysql_real_escape_string($stringkodejeniskegiatan);
		$query="SELECT id FROM trkegiatan WHERE n_kegiatan in($stringkodejeniskegiatan)";
		//print_r($query);
		//die();
		$result = mysql_query($query);
		// output data of each row
		$i=0;
		$selectedkegiatan=array('0' => '');
		while($row = mysql_fetch_assoc($result)) {
			$selectedkegiatan[$i]=$row["id"];	
			$i++;
			}
		return $selectedkegiatan;				
	}

	public function getselectedinvestasiid($stringkodejenisinvestasi){
		$stringkodejeniskegiatan=mysql_real_escape_string($stringkodejenisinvestasi);
		$query="SELECT id FROM trinvestasi WHERE n_investasi in($stringkodejenisinvestasi)";
		//print_r($query);
		//die();
		$result = mysql_query($query);
		// output data of each row
		$i=0;
		$selectedinvestasi=array('0' => '');
		while($row = mysql_fetch_assoc($result)) {
			$selectedinvestasi[$i]=$row["id"];
			$i++;
		}
		return $selectedinvestasi;
			
	}
}
?>