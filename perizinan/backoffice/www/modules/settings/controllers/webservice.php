<?php
if (!defined('BASEPATH'))
  exit('No direct script access allowed');

/* Description of webservice class
 * @author  AgusN  1.0
 * Edit PBS 25/4/2017
 */
class Webservice extends WRC_AdminCont {
  public function __construct() {
    parent::__construct();

    $this->settings = NULL;
     $this->load->model("m_webservice");
    $enabled = FALSE;
    $list_auths = $this->session_info['app_list_auth'];

    foreach ($list_auths as $list_auth) {
      if ($list_auth->id_role === '3') {
        $enabled = TRUE;
        $this->settings = new settings();
      }
    }

    if (!$enabled) {
      redirect('dashboard');
    }
  }

  public function index() {
    //NPWP
	  $this->settings->where('name', 'app_web_service')->get();
    $service = $this->settings->value;
    $data['status'] = $this->settings->status;
    $data['service'] = $service;

    //penduduk / KTP
    $this->settings->where('name', 'web_service_penduduk')->get();
    $service2 = $this->settings->value;
    $data['status2'] = $this->settings->status;
    $data['service2'] = $service2;

	  //BKPM
    $this->settings->where('name', 'web_service_bkpm')->get();
    $service3 = $this->settings->value;
    $data['status3'] = $this->settings->status;
    $data['service3'] = $service3;

	  //smsGetway
    $this->settings->where('name', 'smsGateway')->get();
    $data['statsms'] = $this->settings->status;

	  //send_email
    $this->settings->where('name', 'send_mail')->get();
    $data['statmail'] = $this->settings->status;

	  //Kop Piksel
	  $this->settings->where('name', 'tinggi_kop')->get();
    $piksel = $this->settings->value;
    $data['piksel'] = $piksel;

	  //Status Approve stop approve esl2
    $this->settings->where('name', 'stop_esl2')->get();
    $data['stat_stop_esl2'] = $this->settings->status;

	  //Status Approve stop approve esl3
    $this->settings->where('name', 'stop_esl3')->get();
    $data['stat_stop_esl3'] = $this->settings->status;
    
    //Penomoran Pertek
    $this->settings->where('name', 'no_pertek')->get();
    $data['stat_nopertek'] = $this->settings->status;

	  //Penomoran Surat Penolakan
    $this->settings->where('name', 'no_srt_tolak')->get();
    $data['stat_nostolak'] = $this->settings->status;
    
    $data['save_method'] = "update";
    $this->load->vars($data);
    $this->session_info['page_name'] = "Setting Web Service ";
    $this->template->build('web_service_edit', $this->session_info);
  }

  public function logEsign() { 
      $now = $this->lib_date->get_date_now();
      $tgla = (!empty($this->input->post('tgla')) ? $this->input->post('tgla') : $this->lib_date->set_date($now, -7));;
      $tglb = (!empty($this->input->post('tglb')) ? $this->input->post('tglb') : $this->lib_date->set_date($now, 0));

      $surat = $this->m_webservice->get_data($tgla, $tglb);

      $data['tgla'] = $tgla;
      $data['tglb'] = $tglb;
      $data['surat'] = $surat;
      $this->load->vars($data);

      $js = "function confirm_link(text){
              if(confirm(text)){ return true;
              }else{ return false; }
            }
            
            $(document).ready(function() {
              oTable = $('#pendataan').dataTable({
                \"bJQueryUI\": true,
                \"sPaginationType\": \"full_numbers\"
              });
            });
            $(function() {
              $(\".monbulan\").datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: 'yy-mm-dd',
                closeText: 'X'
              });
              $('#form').validate();
            });";

      $this->template->set_metadata_javascript($js);
      $this->session_info['page_name'] = "Log Penandatanganan d|sign";
      $this->template->build('log_esign_list', $this->session_info);
    }

  public function update($cek=NULL) {
	  $cek_sms  = $this->input->post('cek_sms');
	  $cek_mail = $this->input->post('cek_mail');
	  
	  //NPWP
    $service = $this->input->post('service');
    $status = $this->input->post('online');
    
    //KTP
    $service2 = $this->input->post('penduduk');
    $status2 = $this->input->post('online2');

	  //BKPM
    $service3 = $this->input->post('bkpm');
    $status3 = $this->input->post('online3');
      
	  //smsGetway
    $statsms = $this->input->post('smsgateway');
	  if($statsms == '1') $servsms = 'OnLine'; else $servsms = 'OffLine';

	  //smsGetway
    $statmail = $this->input->post('send_mail');
	  if($statmail == '1') $servmail = 'OnLine'; else $servmail = 'OffLine';

    //Kop Piksel
	  $piksel = $this->input->post('piksel');

	  //Status Approve stop approve esl2 
    $stat_stop_esl2 = $this->input->post('stop_esl2');
	  if($stat_stop_esl2 == '1') $servesl2 = 'ON'; else $servesl2 = 'OFF';

	  //Status Approve stop approve esl3
    $stat_stop_esl3 = $this->input->post('stop_esl3');
	  if($stat_stop_esl3 == '1') $servesl3 = 'ON'; else $servesl3 = 'OFF';
	  
	  //Penomoran Pertek
    $stat_nopertek = $this->input->post('no_pertek');
	  if($stat_nopertek == '1') $servpertek = 'System'; else $servpertek = 'Manual';

	  //Penomoran Surat Penolakan
    $stat_nostolak = $this->input->post('no_srt_tolak');
	  if($stat_nostolak == '1') $servtolak = 'System'; else $servtolak = 'Manual';

    $u_ser = $this->session->userdata('username');
    $tgl = date("Y-m-d H:i:s");
    //$p = $this->db->query("call log ('Setting Umum','Setting Webservice','".$tgl."','".$u_ser."')");

    $update        = $this->settings->where('name', 'app_web_service')     ->update(array('value' => $service ,   'status' => $status));
    $update2       = $this->settings->where('name', 'web_service_penduduk')->update(array('value' => $service2,   'status' => $status2));
	  $update3       = $this->settings->where('name', 'web_service_bkpm')    ->update(array('value' => $service3,   'status' => $status3));
	  $updatsms      = $this->settings->where('name', 'smsGateway')          ->update(array('value' => $servsms ,   'status' => $statsms));
	  $updatmail     = $this->settings->where('name', 'send_mail')           ->update(array('value' => $servmail,   'status' => $statmail));
	  $updatpiksel   = $this->settings->where('name', 'tinggi_kop')          ->update(array('value' => $piksel,     'status' => '0'));
	  
	  $updatesl2     = $this->settings->where('name', 'stop_esl2')           ->update(array('value' => $servesl2,   'status' => $stat_stop_esl2));
	  $updatesl3     = $this->settings->where('name', 'stop_esl3')           ->update(array('value' => $servesl3,   'status' => $stat_stop_esl3));
	  
	  $updatnopertek = $this->settings->where('name', 'no_pertek')           ->update(array('value' => $servpertek, 'status' => $stat_nopertek));
	  $updatnostolak = $this->settings->where('name', 'no_srt_tolak')        ->update(array('value' => $servtolak,  'status' => $stat_nostolak));
      
	  $u_ser = $this->session->userdata('username');
	  $username = new user();
    $username->where('username', $u_ser)->get();
    $n_hp    = $username->no_hp;
	  $n_email = $username->email;
	  $n_judul = 'Cek Status Pengiriman Pesan';
	  $n_pesan = "Pesan Terkirim pada tanggal : ".$this->lib_date->mysql_to_human($this->lib_date->get_date_now())."\nCreate PBS";

	  if($statsms == '1' && $cek_sms == 1){ // Kirim SMS
     //  $gammu = $this->load->database('gammu', TRUE);                              // the TRUE paramater tells CI that you'd like to return the database object.
    	// $data = array('DestinationNumber' => $n_hp,'TextDecoded' => $n_pesan);      // 'CreatorID' => "Gammu",
     //  $gammu->insert('outbox',$data);
	  	$username 	= 'dpmptspjbr';
	  	$password 	= '4RrtRM5X';
	  	$receiver 	= $n_hp;
	  	$message 	= urlencode($n_pesan);

	  	$url = 'https://portal.smsblast.id/api/sendsingle.json?username='.$username.'&password='.$password.'&sender=DPMPTSP+JBR&msisdn='.$receiver.'&message='.$message;

	  	$data = file_get_contents($url);
	  	if ($data) {
	  		$json = json_decode($data);
	  		if (isset($json->code)) {
	  			if ($json->code == 1) {
	  				redirect('settings/webservice');
	  			} else {
	  				echo "Ada Yang Error Gan: " . $json->message . " " . $json->status;
	  			}
	  		}
	  	}
  	}
	  if($statmail == '1' && $cek_mail == 1){ // Kirim mail
      $host             =  "smtp.gmail.com";
      $emailpengirim    = "spekta.tasikmalaya@gmail.com";
      $namapengirim     = "DPMPTSP TASIKMALAYA";
      $password         = "sqijtjsisvmeykmi";
  	  $targetpengiriman =	$n_email;
      require("assets/plugins/phpmailer/class.phpmailer.php");
      require("assets/plugins/phpmailer/class.smtp.php");
  		$mailer = new PHPMailer();
  		$mailer->CharSet = "UTF-8";
  	  $mailer->IsSMTP();
      $mailer->SMTPAuth = true;
      $mailer->Host =$host;
		  //$mailer->SMTPDebug = 2;
      $mailer->Port = 465;
      $mailer->SMTPSecure = 'ssl';
  	  $mailer->Username = $emailpengirim;
      // $config['smtp_crypto'] = 'ssl';
      // $mailer->smtp_crypto= 'ssl';
      $mailer->Password = $password;
      $mailer->FromName = $namapengirim;
  		$mailer->From     = $emailpengirim;
  		$mailer->AddAddress($targetpengiriman,$targetpengiriman);
  	  //Isi Data untuk e-mail
      $mailer->Subject = $n_judul;
		  $isi = $n_pesan;
  	  $mailer->Body = $isi;
 		  $mailer->AltBody = $isi;
      //$mailer->Send();
		  if(!$mailer->send()) {
        echo "Ada Yang Error Gan: " . $mailer->ErrorInfo;die;
      }else{
        //echo "Berhasil di Send!";
			  redirect('settings/webservice');
      }
  	}
    redirect('settings/webservice');
  }
}