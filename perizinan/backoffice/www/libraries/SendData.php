<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class SendData {

	//require_once "adapter.php";
		
		private $url;
		private $method;
		private $accesskey;
		private $deletelist;
		private $myfile;
		private $onlineIndex;
	public function __construct(){
		require_once "adapter.php";
		$this->CI =& get_instance();
		$this->CI->load->helper('file');
		//$this->url='http://203.114.227.117/mantra/api/bkpm_integrasi_daerah/track_daerah/';
		//$this->url='http://203.114.226.119/mantra/api/bkpm_integrasi_daerah/track_daerah/';
		//$this->url='http://10.1.237.135/mantra/api/bkpm_integrasi_daerah/track_daerah/';
		//$this->url='http://localhost:8888/mantra.others/api/bkpm_integrasi_daerah/track_daerah/';

		$listUrl=array("10.31.2.9","203.114.227.117","203.114.226.119");
		$listPort=array(80,80,80);
		$listAccessKey=array("3eb57lba6j","ujkvikyks0","ujkvikyks0");		
		$this->onlineIndex=$this->setUrl($listUrl,$listAccessKey,$listPort);
		if ($this->onlineIndex!=='OFFLINE'){
		if($this->onlineIndex==0)
			$this->url='http://'.$listUrl[$this->onlineIndex].'/api/bkpm/track_daerah/';
		else 
			$this->url='http://'.$listUrl[$this->onlineIndex].'/mantra/api/bkpm_integrasi_daerah/track_daerah/';
		$this->accesskey=$listAccessKey[$this->onlineIndex];
		}
		//echo $this->url;
		$this->deletelist='';
		$this->myfile = fopen("integrasi-log.txt", "a") or die("Unable to open file!");
		}
		
	public function setUrl($listUrl,$listAccessKey, $listPort){
		$n=count($listUrl);
		for ($i=0;$i<count($listUrl);$i++){
			//echo $listUrl[$i];
			$fp = @fsockopen($listUrl[$i], $listPort[$i], $errno, $errstr, 2);
			if ($fp) {
				//echo 'ONLINE'.'</br>';
				//$this->url='http://'.$listUrl[$i].'/mantra/api/bkpm_integrasi_daerah/track_daerah/';
				//$this->accesskey=$listAccessKey[$i];
				//break;
				echo $listUrl[$i].'</br>';
				return $i;
			}
			//else echo 'OFFLINE'.'</br>';
		}
		return 'OFFLINE';
	}	
	//sendData(1);
	public function SendData($idPermohonan,$status){	
		
		if ($this->onlineIndex!=='OFFLINE'){
		//$this->method='set_integrasi_izin_daerah_contoh';
		//$this->accesskey='vbyiwh182e';
		$this->method='set_izin_daerah';
		//echo $this->url.'#'.$this->accesskey.'#'.$this->method;die();
		//$this->accesskey='ujkvikyks0';
		
		$this->deletelist='';
		$query=sprintf("Select no_izin, kode_jenis_izin, jenis_izin, pendaftaran_id, npwp, nama_perusahaan, durasi_sop, tanggal_daftar,tanggal_selesai, no_ip, kode_kbli, id_permohonan, kecamatan, kelurahan, persyaratan from v_webservices_bkpm where id_permohonan=%d",mysql_real_escape_string($idPermohonan));
		echo $query;
		$result = mysql_query($query);  
		$row = mysql_fetch_assoc($result);
			
				$array["no_izin"]=empty($row["no_izin"])?'-':$row["no_izin"];
				$array["kode_jenis_izin"]=empty($row["kode_jenis_izin"])?'-':$row["kode_jenis_izin"];
				$array["jenis_izin"]=empty($row["jenis_izin"])?'-':$row["jenis_izin"];
				$array["npwp"]=empty($row["npwp"])?'-':$row["npwp"];
				$array["nama_perusahaan"]=empty($row["nama_perusahaan"])?'-':$row["nama_perusahaan"];
				$array["durasi_sop"]=empty($row["durasi_sop"])?'-':$row["durasi_sop"];
				$array["tgl_daftar"]=date("d/m/Y", strtotime($row["tanggal_daftar"]));
				if($status==1){
					$array["tgl_selesai"]=date("d/m/Y", strtotime("01/01/1970"));
				}
				else {
				
				$array["tgl_selesai"]=date("d/m/Y", strtotime($row["tanggal_selesai"]));
				}
				$array["kontak_ptsp"]="(022)5896882";
				//$array["no_izin_prinsip"]=$row["no_ip"];
				$array["qrcode"]=empty($row["no_ip"])?'-':$row["no_ip"];
				//Kode PTSP ubah sesuai ptsp
				$array["kode_ptsp"]="32";
				$array["kode_kbli"]="-";
				$array["no_permohonan"]=empty($row["pendaftaran_id"])?'-':$row["pendaftaran_id"];
				$array["kelurahan"]=empty($row["kelurahan"])?'-':$row["kelurahan"];
				$array["kecamatan"]=empty($row["kecamatan"])?'-':$row["kecamatan"];
				$array["persyaratan"]=empty($row["persyaratan"])?'-':$row["persyaratan"];
				$array["status"]=$status;
				//if($array["tgl_selesai"]=="01/01/1970") $array["tgl_selesai"]=null;
		var_dump($array);
		$this->sendToApi($array);
		}
		else  echo 'No Active Server';
		
		//$this->deleteTemp();
		}
	
		
	
	public function sendToApi($request){
		//echo $this->url;
		//print_r($request);
		$result=callAPI(
			$endpoint=$this->url,
			$operation=$this->method,
			$this->accesskey,
			$parameter=$request,
			$xmlformat=true,  // true:output data XML, false:output data Array
			$callmethod='POST' // call option: GET, POST, REST, RESTFULL, RESTFULLPAR
		);
		$arrayData=simplexml_load_string($result);
		print_r ($arrayData);
		if($arrayData[0]->code=='200'){
			write_file('integrasi-log.txt',date('d-m-Y').' '.$request['no_izin'].' Sent :'. $arrayData[0]->data->set_izin_daerah[0]->output.". Message:".$arrayData[0]->message."\r\n",'a+');
			//fwrite($myfile, $request['id_permohonan'].' Sent \n');
			if($this->deletelist=='') $this->deletelist=$request["no_permohonan"];
			else $this->deletelist=$this->deletelist.', '.$request["no_permohonan"];
		}
		else 
		{
			write_file('integrasi-log.txt', date('d-m-Y').' '.$request['no_izin']. $request['no_permohonan'].' Failed to Sent:'.$arrayData[0]->message ."\r\n",'a+')	;
		}
		/*$table=setXML2Array($result);
		echo '<pre>';
			var_dump($table);
		echo '</pre>';
		die;
		
		$table=array();
		if(is_array($result)) $table=$result; 
		else $table=setXML2Array($result); // buat tabel data
		if(isset($table['response']['data'][$this->method])) view_table($table['response'],$this->method);		
	
		echo "<hr/>";	
		
		if(is_array($result)) $xml=setArray2XML('response',$result); 
		else $xml=$result; 
		$p_xml=html_entity_decode($xml,ENT_QUOTES);
		echo "Uraian data xml:<br/>";
		echo "<pre>".htmlentities($p_xml,ENT_QUOTES)."</pre><hr/>";
		
		if(is_array($result)) $data=$result;
		else $data=setXML2Array($result);
		echo "Uraian data array:<br/><pre>";
		echo var_export($data,true); 
		echo "</pre><br/><hr/>";
		echo "Uraian data json:<br/><pre>";
		echo json_encode($data);
		echo "</pre><br/><hr/>";*/
		
	}
}
?>