<?php
/* To change this template, choose Tools | Templates
 * and open the template in the editor.
 * Description of welcome
 * @author Obi
*/
class Permohonan extends MY_Controller {
  
  function __construct() {
    parent::__construct();
    
    $this->tm_pemohon = new Tm_pemohon();
    $this->tmwcm = new Tmwcm();
    $this->load->library('curl');
    $this->load->library('xml_parsing_win');
    $this->load->library('font_1.8/fpdf');
    
    $otherdb = $this->load->database('otherdb', TRUE);
    $this->sms  = $otherdb->get_where("settings",array('name'=>'smsGateway'))->first_row();
    $this->email = $otherdb->get_where("settings",array('name'=>'send_mail'))->first_row();
    $detect = $this->load->library('Mobile_Detect');
    if ($detect->isMobile()) {
      $link = "http" . ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "s" : "") . "://";
      $server = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : $_SERVER['SERVER_NAME'];
      
      $base_url = base_url();
      $xx = explode('/', $base_url);
      $x = 0;
      $jumlah_url_1 = count($xx) - 1;
      $jumlah_url = count($xx);
      $url_mobile = NULL;
      foreach ($xx as $apl_mobile_url) {
        $x++;
        if ($jumlah_url_1 == $x) {
        }else
        if ($jumlah_url == $x) {
        }else{
          if($x == 1) {
            $url_mobile.= $apl_mobile_url;
            $url_mobile.= '//';
          }else
          if ($x == 2) {
          }else{
            $url_mobile.= $apl_mobile_url;
            $url_mobile.= '/';
          }
        }
      }
      redirect($url_mobile."alp_mobile");
    }
  }
  
  function index(){
    redirect('main/permohonan/step1', 'refresh');
  }
  
  function step1(){
    $username = $this->session->userdata("username");
    $session  = $this->session->userdata("userlogin");
    
    //if($username != 'pamudi1694'){
    //	echo 'Mohon Maaf, Permohonan Izin Secara Online Sedang Dalam Perbaikan '; die;
    //}
    
    if(empty($session)){
     redirect('main/login', 'refresh');
     die;
    }
    $otherdb = $this->load->database('otherdb', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
    $otherdb->order_by("urutan","asc");
    
    //$query	= $otherdb->query("select * from trsektor")->result();
	  $query	= $otherdb->query("select * from trsektor WHERE `n_sektor` != '*Lain-lain' order by urutan")->result();
	  $query2	= $this->db->get_where('tm_pemohon', array('username' => $username,'status'=>'1'))->first_row();
	  
	  $data['title']     = "Permohonan Perizinan";
	  $data['load']      = "permohonan/step1";
	  $data['perizinan'] = $query;
	  $data['data']      = $query2;
    $this->load->view('template_user',$data);
	  
  }
  
  function step2($id) {
    $username = $this->session->userdata("username");
    $session = $this->session->userdata("userlogin");
    
    if(empty($session)){
      redirect('main/login', 'refresh');
      die;
    }
    
    if(empty($id)){
      redirect('main/permohonan/step1', 'refresh');
    }
    
    $query = $this->db->get_where('tm_pemohon', array('username' => $username,'status'=>'1'))->first_row();
    
    if($query->data=="0" || $query->dokumen=="0"){
      redirect('main/permohonan/step1', 'refresh');
    }
    
    $id = htmlspecialchars($id,ENT_QUOTES);
    $otherdb = $this->load->database('otherdb', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
    $sektor = $otherdb->get_where("trsektor",array("id"=>$id))->first_row();
    
    if(count($sektor)==0){
      $this->session->set_flashdata('error', "Terjadi kesalahan, mohon mengulangi proses perizinan");
      redirect('main/permohonan/step1', 'refresh');
      die;
    }
    
    $query	= $otherdb->query("select * from trperizinan where c_online = '0'                                   
                               And id in(select trperizinan_id from trperizinan_trsektor where trsektor_id='".$id."') order by n_perizinan")->result();
    
    if(count($query)==0){
      $this->session->set_flashdata('error', "Data Perizinan Tidak Ditemukan Dalam Bidang ".$sektor->n_sektor);
      redirect('main/permohonan/step1', 'refresh');
      die;
    }
    
    $query2	= $this->db->get_where('tm_pemohon', array('username' => $username,'status'=>'1'))->first_row();
    
    $data['title']     = "Permohonan Perizinan";
    $data['load']      = "permohonan/step2";
    $data['bidang']    = $sektor->n_sektor;
    $data['perizinan'] = $query;
    $data['data']      = $query2;
    $this->load->view('template_user',$data);
  }
  
  function step3($id,$uuid=null) {
    $username = $this->session->userdata("username");
    $session = $this->session->userdata("userlogin");
    
    if(empty($session)){
    	redirect('main/login', 'refresh');
    	die;
    }
    
    $query = $this->db->get_where('tm_pemohon', array('username' => $username,'status'=>'1'))->first_row();
    
    if($query->data=="0" || $query->dokumen=="0"){
    	redirect('main/permohonan/step1', 'refresh');
    }
    
    $id	= htmlspecialchars($id,ENT_QUOTES);
    
    if(empty($id)){
    	redirect('main/permohonan/step1', 'refresh');
    }
    
    $otherdb = $this->load->database('otherdb', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
    $sql = "select * from trperizinan where id='".$id."'";
    $query = $otherdb->query($sql)->row_array();
    
    if(count($query)==0){
    	redirect('main/permohonan/step1', 'refresh');
    }
    
    $sql = "select * from trperizinan_trsektor where trperizinan_id=".$id."";
    $sektor = $otherdb->query($sql)->first_row();
    
    $sql = "select trsektor.* from trsektor,trperizinan_trsektor where trsektor.id=trperizinan_trsektor.trsektor_id and trperizinan_trsektor.trperizinan_id=".$id."";
    $sektor2 = $otherdb->query($sql)->first_row();
    $properti = count($query);
    $judul = $otherdb->query("select * from trperizinan where id='".$id."' limit 1")->first_row();
    
    
    
    $data['title']     = "Permohonan Perizinan";
    $data['load']      = "permohonan/step3";
    $data['property']  = $query;
    $data['id']        = $id;
    $data['id_sektor'] = $sektor->trsektor_id;
    $data['sektor']    = $sektor2->n_sektor;
    $data['jml']       = $properti;
    $data['judul']     = $judul;
    $data['uuid']      = $uuid;
        $this->load->view('template_user',$data);
  }
  
  function step4($id,$jml_property,$uuid) {
    $username = $this->session->userdata("username");
    $session  = $this->session->userdata("userlogin");
    $otherdb  = $this->load->database('otherdb', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
    
    if(empty($session)){
      redirect('main/login', 'refresh');
    }
    
    if(empty($_POST)){
      //redirect('main/permohonan/step1', 'refresh');
    }
    
    if(!isset($id)){
      redirect('main/permohonan/step1', 'refresh');
      die;
    }
    
    $query = $this->db->get_where('tm_pemohon', array('username' => $username,'status'=>'1'))->first_row();
    $id_pemohon	= $query->id;
    
    if($query->data=="0" || $query->dokumen=="0"){
      redirect('main/permohonan/step1', 'refresh');
    }
    
    $sql = "select * from trperizinan where id='".$id."'";
    $query = $otherdb->query($sql)->result();
    
    if(count($query)==0){
      redirect('main/permohonan/step1', 'refresh');
    }
    
    $sql   = "select trsyarat_perizinan.* from trsyarat_perizinan 
              where trsyarat_perizinan.id IN(select trsyarat_perizinan_id from trperizinan_trsyarat_perizinan 
              where trperizinan_id='".$id."' and status='1')  ORDER BY trsyarat_perizinan.status";
    $query = $otherdb->query($sql)->result();
    
    if(count($query)==0){
      redirect('main/permohonan/step1', 'refresh');
      die;
    }
    
    $judul = $otherdb->query("select * from trperizinan where id='".$id."' limit 1")->first_row();
    
    $user = $this->db->get_where("tm_pemohon",array("username"=>$username))->first_row();
    $syarat = $this->db->get_where("tm_pemohon_persyaratan",array("id_pemohon"=>$user->id))->result();
    
    $array = array();
    foreach($syarat as $sya){
      array_push($array,$sya->id_persyaratan);
    }
    
    $sql = "select trsektor.* from trsektor,trperizinan_trsektor where trsektor.id=trperizinan_trsektor.trsektor_id and trperizinan_trsektor.trperizinan_id=".$id."";
    $sektor = $otherdb->query($sql)->first_row();
    
    $data['title']        = "Permohonan Perizinan Step 2";
    $data['load']         = "permohonan/step4";
    $data['syarat']       = $query;
    $data['sektor']       = $sektor->n_sektor;
    $data['judul']        = $judul;
    $data['id']           = $id;
    $data['user_id']      = $user->id;
    $data['id_pemohon']   = $id_pemohon;
    $data['jml']          = $jml_property;
    $data['array_syarat'] = $array;
    $data['uuid']         = $uuid;
    $this->load->view('template_user',$data);
  }
  
  function savestep3($cid){  // proses simpan step 1, 2 da 3
    $session  = $this->session->userdata("userlogin");
    $username = $this->session->userdata("username");
    $otherdb  = $this->load->database('otherdb', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
    
    if(empty($session)){
      redirect('main/login', 'refresh');
    }
    
    if(empty($_POST)){
      echo 'tidak ada post';
    	//redirect('main/permohonan/step1', 'refresh');
    	die;
    }
    $lokasi_izin  =	htmlspecialchars($_POST['lokasi_izin'],ENT_QUOTES);
    $jml_properti =	htmlspecialchars($_POST['jml_properti'],ENT_QUOTES);
    $id           =	htmlspecialchars($_POST['id'],ENT_QUOTES);
    $sektor       =	htmlspecialchars($_POST['sektor'],ENT_QUOTES);
    $uuid         =	htmlspecialchars($_POST['uuid'],ENT_QUOTES);
    $jml_property = htmlspecialchars($_POST['jml_properti'],ENT_QUOTES);
    $user         = $this->db->get_where('tm_pemohon', array('username' => $username,'status'=>'1'))->first_row();
    $jenis        = $user->jenis;
    // Input permohonan baru
    $data = array('id_pemohon'   => $user->id,
                  'id_perizinan' => $id,
                  'd_entry'      => date("Y-m-d h-i-s"),
                  'lokasi_izin'	 => $lokasi_izin,
    	            'status'	     => 0,        // status pemohon
                 );
    $update = FALSE;
    if($uuid != ''){
      $eksis = $this->db->query("select * from tmpermohonan_portal where id_pemohon=".$user->id." order by id desc")->first_row();
      if(!empty($eksis)){
      	$update = TRUE;
      	$this->db->where('id', $eksis->id);
        $this->db->update('tmpermohonan_portal', $data);
      }
    }else{
    	$update = TRUE;
      $this->db->insert('tmpermohonan_portal',$data);
      $eksis = $this->db->query("select * from tmpermohonan_portal where id_pemohon=".$user->id." order by id desc")->first_row();
      $uuid = $eksis->uuid;
    }
    
    // fungsi input persyaratan //
    // fungsi input properti
    if($update){
      if($jml_properti>0){
        $sql   = "select * from trperizinan where id='".$id."'";
        $query = $otherdb->query($sql)->row_array();
        $array_properti = array();
        $no	= 1;
        while($no<=$jml_properti){
          $tek  = "var_teknis".$no;
          $data = array('dt_teknis'.$no => htmlspecialchars($_POST['var_teknis'.$no],ENT_QUOTES)."^-",);
          $this->db->where('id', $eksis->id);
          $this->db->update('tmpermohonan_portal', $data); 
          $no++;
        }
      }
    }
    // EOF() fungsi input properti
    redirect('main/permohonan/step4/'.$cid.'/'.$jml_property.'/'.$uuid, 'refresh');
  }

  function addpermohonanbaru(){  // proses simpan data permohonan simpan ke Backoffice
    $session  = $this->session->userdata("userlogin");
    $username = $this->session->userdata("username");
    $otherdb  = $this->load->database('otherdb', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
    
    if(empty($session)){
      redirect('main/login', 'refresh');
    }
    
    if(empty($_POST)){
      redirect('main/permohonan/step1', 'refresh');
      die;
    }
    
    if(empty($_POST["tanggung_jawab"])){
      redirect('main/permohonan/step1', 'refresh');
      die;
    }
    
    $tanggung_jawab	= htmlspecialchars($_POST['tanggung_jawab'],ENT_QUOTES);
    
    if($tanggung_jawab != "on"){
      $this->session->set_flashdata('error', 'Terjadi Kesalahan, mohon mengulangi proses permohonan');
      redirect('main/permohonan/step1', 'refresh');
    }
    
    $jml_properti =	htmlspecialchars($_POST['jml_properti'],ENT_QUOTES);
    $id           =	htmlspecialchars($_POST['id'],ENT_QUOTES);
    $sektor       =	htmlspecialchars($_POST['sektor'],ENT_QUOTES);
    $user         = $this->db->get_where('tm_pemohon', array('username' => $username,'status'=>'1'))->first_row();
    $jenis        = $user->jenis;
    $eksis        = $this->db->query("select * from tmpermohonan_portal where id_pemohon=".$user->id." order by id desc")->first_row();
    $lokasi_izin  =	$eksis->lokasi_izin;
    
    // Input ke database back office
    $lasdata   = $otherdb->query("select * from tmpemohon_portal order by id desc")->first_row();
    $perizinan = $otherdb->query("select * from trperizinan where id=".$id."")->first_row();
    
    $no_ref = '000';
    if($jenis=="pemohon"){
      $no_ref = $user->ktpPerusahaan;
      $nm_Pemohon = $user->namaPerusahaan;
      $data = array('namaPemohon'          => $nm_Pemohon,
                    'id_pemohon'           => $user->id,
                    'id_permohonan_portal' => $eksis->id,
                    'referensi'            => $no_ref,
                    'telpPemohon'          => $user->telpPerusahaan,
                    'almtPemohon'          => $user->almtPerusahaan,
                    'propinsi1'            => $user->propinsi2,
                    'kabupaten1'           => $user->kabupaten2,
                    'kecamatan1'           => $user->kecamatan2,
                    'kelurahan1'           => $user->kelurahan2,
                    'almtPerusahaan'       => $user->almtPerusahaan,
                    'propinsi2'            => $user->propinsi2,
                    'kabupaten2'           => $user->kabupaten2,
                    'kecamatan2'           => $user->kecamatan2,
                    'kelurahan2'           => $user->kelurahan2,
                    'emailPerusahaan'      => $user->emailPerusahaan,
                    'tglPermohonan'        => date("Y-m-d"),
                    'izin'                 => $id,
                    'urut'                 => $lasdata->urut+1,
                    'isi_izin'             => $perizinan->n_perizinan,
                    'lokasi_izin'          => $lokasi_izin,
                    'perantara'            => $user->telpPemohon." - ".$user->namaPemohon,
                   );
    }
      
    if($jenis=="perusahaan"){
      $no_ref = $user->ktpPemohon;
      //$nm_Pemohon = $user->nama_penanggung_jawab;
      $nm_Pemohon = $user->namaPerusahaan;
      $data = array('namaPemohon'          => $nm_Pemohon,
                    'id_pemohon'           => $user->id,
                    'id_permohonan_portal' => $eksis->id,
                    'referensi'            => $no_ref,
                    'telpPemohon'          => $user->telpPerusahaan,
                    'telpPerusahaan'       => $user->telp_penanggung_jawab,
                    'almtPemohon'          => $user->almtPemohon,
                    'propinsi1'            => $user->propinsi1,
                    'kabupaten1'           => $user->kabupaten1,
                    'kecamatan1'           => $user->kecamatan1,
                    'kelurahan1'           => $user->kelurahan1,
                    'npwpPerusahaan'       => $user->npwpPerusahaan,
                    'regPerusahaan'        => $user->regPerusahaan,
                    'namaPerusahaan'       => $user->namaPerusahaan,
                    'emailPerusahaan'      => $user->emailPerusahaan,
                    'faxPerusahaan'        => $user->faxPerusahaan,
                    'almtPerusahaan'       => $user->almtPerusahaan,
                    'tglPermohonan'        => date("Y-m-d"),
                    'propinsi2'            => $user->propinsi2,
                    'kabupaten2'           => $user->kabupaten2,
                    'kecamatan2'           => $user->kecamatan2,
                    'kelurahan2'           => $user->kelurahan2,
                    'izin'                 => $id,
                    'urut'                 => $lasdata->urut+1,
                    'isi_izin'             => $perizinan->n_perizinan,
                    'lokasi_izin'          => $lokasi_izin,
                    'perantara'            => $user->telpPemohon." - ".$user->namaPemohon,
    	             );
    }
    $otherdb->insert("tmpemohon_portal",$data);
    // EOF() Input ke database back office

    // Assign path penyimpanan file persyaratan
    $path = "assets/userassets/pemohon/".$user->username."/pengajuan/".$eksis->id;
    
    // fungsi input persyaratan //
    // retrive persyaratan dibutuhkan
    $sql = "select trsyarat_perizinan.* from trsyarat_perizinan 
            where trsyarat_perizinan.id IN(select trsyarat_perizinan_id from trperizinan_trsyarat_perizinan where trperizinan_id='".$id."' and status='1')  ORDER BY trsyarat_perizinan.status";
    $query = $otherdb->query($sql)->result();
    
    // Cek type file
    foreach($query as $syarat){
      // mengecek ekstensi file dan upload atau tidak
      if(!empty($_FILES["file_".$syarat->id]["name"])){
        $temp	= explode(".",$_FILES["file_".$syarat->id]["name"]); // get file ekstensi
        if(strtolower(end($temp))!="pdf"){
          //if(end($temp)!="pdf"){	
          //$this->db->delete('tmpermohonan_portal', array('id' => $eksis->id)); 
          $this->session->set_flashdata('error', 'Terjadi Kesalahan, mohon hanya mengunggah file pdf saja');
          redirect('main/permohonan/step1', 'refresh');
        }
      }else{
        //$this->db->delete('tmpermohonan_portal', array('id' => $eksis->id)); 
        $this->session->set_flashdata('error', 'Terjadi Kesalahan, mengunggah semua dokumen persyaratan');
        redirect('main/permohonan/step1', 'refresh');
      }
    }
      	
    // bikin folder untuk file persyaratan
    if(!is_dir($path)){ //create the folder if it's not already exists
      mkdir($path,0755,TRUE);
    } 
    
    // input ke table & upload file
    $a=0;
    foreach($query as $syarat){
      // input data persyaratan ke persyaratan permohonan
      $teknis	= htmlspecialchars($_POST["teknis".$syarat->id]);
      if(!empty($_FILES["file_".$syarat->id]["name"])){
        $data = array('tmpermohonan_id'       => $eksis->id,
                      'trsyarat_perizinan_id' => $syarat->id,
                      'nama_file'             => $syarat->id.".pdf",
                      'nomor_surat'           => $_POST["nomor_surat_".$syarat->id]
                     );
        if(!empty($_POST["tanggal_".$syarat->id])){
          $data['tanggal_surat'] = date("Y-m-d",strtotime($_POST["tanggal_".$syarat->id]));
        }
        if(!empty($_POST["masa_berlaku_".$syarat->id])){
          $data['masa_berlaku_surat'] = date("Y-m-d",strtotime($_POST["masa_berlaku_".$syarat->id]));
        }
      }
      
      if($this->db->insert('tmpermohonan_trsyarat_perizinan',$data)){
        // assign nama file & direktori upload
        $file =	$syarat->id.".pdf";
        $dir2 = $path."/";
        		
        // assign nama file & direktori upload
        // upload file pengajuan
        $data = array("id_pemohon" 	=> $user->id,
                      "id_persyaratan" => $syarat->id,
                      "nomor_surat"		=> $_POST["nomor_surat_".$syarat->id]
                     );
        if(!empty($_POST["tanggal_".$syarat->id])){
          $data['tanggal_surat'] = date("Y-m-d",strtotime($_POST["tanggal_".$syarat->id]));
        }
        			
        if(!empty($_POST["masa_berlaku_".$syarat->id])){
          $data['masa_berlaku_surat'] = date("Y-m-d",strtotime($_POST["masa_berlaku_".$syarat->id]));
        }
        				
        $this->db->insert("tm_pemohon_persyaratan",$data);
        $lokasi=$_FILES['file_'.$syarat->id]['tmp_name'];
        move_uploaded_file($lokasi,$dir2.$file);
      }
    }
    // EOF() input ke table & upload file
      
    // Kirim Notifikasi ke Penerima otoritas 
    $bidang = $sektor;
    $nizin = $perizinan->n_perizinan;
    $nomor = $no_ref;
    $pemohon = $nm_Pemohon;
    $tgl_masuk = date("d-m-Y");
    
    $base_url      = 'assets/pendaftaran/';
    $host          = "smtp.gmail.com";
    $emailpengirim = "dpmptspjabar@gmail.com";
    $namapengirim  = "DPMPTSP JABAR";
    $password      = "~dpmptspjabarprovgoid#";
    require("".$base_url."back/plugins/phpmailer/class.phpmailer.php");
    require("".$base_url."back/plugins/phpmailer/class.smtp.php");
          
    //if($username != 'pamudi1694'){
    $sqlsms = "select user.id, user.no_hp, user.email from user 
               where user.id IN(select user_id from user_user_auth where user_auth_id = 22 )"; //jika sebagai pendaftaran Online
    $querysms = $otherdb->query($sqlsms)->result();
    foreach($querysms as $kirimsms){
      $email = $kirimsms->email;
      $telp_pemohon = $kirimsms->no_hp;
      $targetpengiriman = $email;
      
      $izin_user = $otherdb->query("select * from trperizinan_user where user_id = ". $kirimsms->id . " AND trperizinan_id = ".$id)->row_array();
      if(count($izin_user)>0){
        $cekid = $izin_user['trperizinan_id'];
        if($cekid != ''){
          // Kirim e-mail
          if($email != ''){
            $mailer = new PHPMailer();
            $mailer->CharSet = "UTF-8";
            $mailer->IsSMTP();
          
            $mailer->SMTPSecure = 'tls';
            $mailer->Host =$host;
            $mailer->Port =587;
            $mailer->SMTPAuth = true;
          
            $mailer->Username = $emailpengirim;
            $mailer->Password = $password;
            $mailer->FromName = $namapengirim;
            $mailer->From = $emailpengirim;
            $mailer->AddAddress($targetpengiriman,$targetpengiriman);
          
            $mailer->Subject = 'DPMPTSP OnLine';
          
            $isi  = "<p>Terdapat Permohonan Izin Bidang: ".$bidang. " Izin : ".$nizin."</p>";
            $isi .= "<p>Nomor Referensi : ".$nomor." Atas Nama : ".$pemohon." Tanggal Daftar : ".$tgl_masuk."</p>";
            $isi .= "<p>Terima kasih atas perhatiannya<br>DPMPTSP JAWA BARAT</p>";
          
            $mailer->Body = $isi;
            $mailer->AltBody = $isi;
            $mailer->Send();
          }
        }
        
        //Kirim SMS
        if($telp_pemohon != ''){
          $gammu = $this->load->database('gammu', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
          $data = array( 'DestinationNumber'	=> $telp_pemohon,
                         'TextDecoded'		=> "DPMPTSP OnLine NoRef.".$nomor." Tgl:".$tgl_masuk." a/n:".$pemohon." Izin:".$nizin,
                         // 'CreatorID' 			=> "Gammu",
                        );
          $gammu->insert('outbox',$data);
        }
      }
    }
    //}
    $this->session->set_flashdata('success', 'Berhasil Mengajuakan Permohonan');
    redirect('main/permohonan/success', 'refresh');
  }	
  
  public function editpermohonanbaru(){
    $session  = $this->session->userdata("userlogin");
    $username = $this->session->userdata("username");
    $otherdb  = $this->load->database('otherdb', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
    
    if(empty($session)){
      redirect('main/login', 'refresh');
    }
    
    if(empty($_POST)){
      redirect('main/permohonan/step1', 'refresh');
      die;
    }
    
    $uuid = htmlspecialchars($_POST['uuid'],ENT_QUOTES);
    $user_id = htmlspecialchars($_POST['user_id'],ENT_QUOTES);
    $id_perizinan = htmlspecialchars($_POST['id'],ENT_QUOTES);
    $user = $this->db->get_where('tm_pemohon', array('username' => $username,'status'=>'1'))->first_row();
    $permohonan = $this->db->get_where("tmpermohonan_portal",array('uuid'=>$uuid))->first_row();
    
    if(count($permohonan)==0){
      redirect('main/user/permohonan', 'refresh');
      die;
    }
    
    $path = "assets/userassets/pemohon/".$user->username."/pengajuan/".$permohonan->id."/";
    $sql  =	"select trsyarat_perizinan.* from trsyarat_perizinan 
             where trsyarat_perizinan.id IN(select trsyarat_perizinan_id from trperizinan_trsyarat_perizinan 
             where trperizinan_id='".$id_perizinan."')  ORDER BY trsyarat_perizinan.status";
             
    $query = $otherdb->query($sql)->result();
    $ada_upload	= 0;
    
    foreach($query as $syarat){
      if(!empty($_FILES["file_".$syarat->id]["name"])){
        $ada_upload=1;
        $temp	= explode(".",$_FILES["file_".$syarat->id]["name"]); // get file ekstensi
        //if(end($temp)!="pdf"){
        if(strtolower(end($temp))!="pdf"){
          $this->session->set_flashdata('error', 'Terjadi Kesalahan, mohon hanya mengunggah file pdf saja');
          redirect('main/permohonan/detail/'.$uuid, 'refresh');
        }
        $data = array('nomor_surat'	=> $_POST["nomor_surat_".$syarat->id],);
        $data['tanggal_surat'] = null;
        
        if(!empty($_POST["tanggal_".$syarat->id])){
          $data['tanggal_surat'] = date("Y-m-d",strtotime($_POST["tanggal_".$syarat->id]));
        }
        
        $data['masa_berlaku_surat'] = null;
        if(!empty($_POST["masa_berlaku_".$syarat->id])){
          $data['masa_berlaku_surat'] = date("Y-m-d",strtotime($_POST["masa_berlaku_".$syarat->id]));
        }
        
        $this->db->where('tmpermohonan_id', $permohonan->id);
        $this->db->where('trsyarat_perizinan_id', $syarat->id);
        if($this->db->update('tmpermohonan_trsyarat_perizinan', $data)){
          unlink($path.$syarat->id.".pdf");
          $file = $syarat->id.".pdf";
          $lokasi=$_FILES['file_'.$syarat->id]['tmp_name'];
          move_uploaded_file($lokasi,$path.$file);
        }else{
          $this->session->set_flashdata('error', 'Terjadi Kesalahan, mohon hanya mengunggah file pdf saja');
          redirect('main/permohonan/detail/'.$uuid, 'refresh');
        }
      }			
      ////////////////////////// jika mengupload file persyaratan, mengecek ekstensi file	
    }
    
    if($ada_upload==0){
      $this->session->set_flashdata('error', 'Terjadi Kesalahan, Anda tidak mengunggah file apapun');
      redirect('main/permohonan/detail/'.$uuid, 'refresh');
    }
    
    if($ada_upload==1){
      $data = array('editable' => "0",);
      $this->db->where('id', $permohonan->id);
      $this->db->update('tmpermohonan_portal', $data);
    }
    
    $this->session->set_flashdata('success', 'Persyaratan berhasil diubah');
    redirect('main/permohonan/detail/'.$uuid, 'refresh');
  }
  
  function success(){
    $session  = $this->session->userdata("userlogin");
    $username = $this->session->userdata("username");
    $otherdb  = $this->load->database('otherdb', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
    
    if(empty($session)){
      redirect('main/login', 'refresh');
    }
    
    $data['title'] = "Detail Permohonan Perizinan";
    $data['load']  = "permohonan/success";
    $this->load->view('template_user',$data);
  }
  
  function cetak_resi($id) {
  	$permohonan_portal = new tmpermohonan_portal();
  	$permohonan_portal->where('id', $id)->get();
  	$otherdb  = $this->load->database('otherdb', TRUE);
  	$no_resi = $permohonan_portal->no_permohonan;
    $permohonan	= $otherdb->get_where("tmpermohonan",array("pendaftaran_id"=>$no_resi))->first_row();
    $permohonan_pemohon	= $otherdb->get_where("tmpemohon_tmpermohonan",array("tmpermohonan_id"=>$permohonan->id))->first_row();
    $pemohon	= $otherdb->get_where("tmpemohon",array("id"=>$permohonan_pemohon->tmpemohon_id))->first_row();
    $permohonan_izin	= $otherdb->get_where("tmpermohonan_trperizinan",array("tmpermohonan_id"=>$permohonan->id))->first_row();
    $izin= $otherdb->get_where("trperizinan",array("id"=>$permohonan_izin->trperizinan_id))->first_row();

    //Cetak ke PDF

    // Ambil Logo
    $n_logo = base_url(). 'backoffice/uploads/logo/logo.png';
    
    // Ambil Pemerintah 
    $settings	= $otherdb->get_where("settings",array("id"=>'17'))->first_row();
    $nama_prov = $settings->value;
    
    // Ambil Badan
    $settings	= $otherdb->get_where("settings",array("id"=>'9'))->first_row();
    $nama_badan = $settings->value;
    
    // Ambil Alamat
    $settings	= $otherdb->get_where("settings",array("id"=>'12'))->first_row();
    $alamat = $settings->value;
    
    // Ambil Telpon
    $settings	= $otherdb->get_where("settings",array("id"=>'10'))->first_row();
    $tlp = $settings->value;
    
    // Ambil Fax
    $settings	= $otherdb->get_where("settings",array("id"=>'13'))->first_row();
    $fax = $settings->value;
    
    // Ambil Kota
    $settings	= $otherdb->get_where("settings",array("id"=>'19'))->first_row();
    $kota = $settings->value;
    
    // Ambil Kode Pos
    $settings	= $otherdb->get_where("settings",array("id"=>'20'))->first_row();
    $kdpos = $settings->value;
    
    // Ambil web
    $settings	= $otherdb->get_where("settings",array("id"=>'21'))->first_row();
    $web = $settings->value;
    
    // Ambil e-mail
    $settings	= $otherdb->get_where("settings",array("id"=>'22'))->first_row();
    $e_mail = $settings->value;
    
    $alamat = $alamat . ' Tlp. ' . $tlp . ', Fax. ' . $fax;
    $alamat2 = 'Website: ' . $web . '   e-mail: ' . $e_mail;
    $alamat3 = strtoupper($kota) . ' - ' . $kdpos;
    
    //Create QRCode
    include('./assets/qrcode/qrlib.php');
    $tempDir = 'uploads/data_qrcode/';
    $link = 'https://dpmptsp.jabarprov.go.id/sicantik/main/ceksts/index/';
    $codeContents = $no_resi;
    $codeContentskey = $permohonan_portal->i_entry;
    $key = md5($codeContents.' '.$codeContentskey);
    $codeContents = $link.$codeContents;//.' idkey.'.$key;
    $fileName = 'resi_'.$key.'.png';
    $pngAbsoluteFilePath = $tempDir.$fileName;
    $urlRelativeFilePath = base_url().$tempDir.$fileName; //EXAMPLE_TMP_URLRELPATH.$fileName;
    
    if(!file_exists($tempDir)) { #kalau folder belum ada, maka buat.
      mkdir($tempDir);
    } 
    
    $create_file = FALSE;
    if(!file_exists($pngAbsoluteFilePath)) {  # jika file tidak ada
      $create_file = TRUE;
      $quality = 'H'; //ada 4 pilihan, L (Low), M(Medium), Q(Good), H(High)
      $ukuran = 5;    //batasan 1 paling kecil, 10 paling besar
      $padding = 0;
    	QRCode::png($codeContents,$tempDir.$fileName,$quality,$ukuran,$padding);
    }
    //EOF() Create QRCode
    
    //$pdf = new FPDF({P/L},{pt/mm/cm/in},{A3/A4/A5/LETTER/LEGAL});
    $pdf = new FPDF('P','mm','A4'); //('a3'=>array(841.89,1190.55), 'a4'=>array(595.28,841.89), 'a5'=>array(420.94,595.28), 'letter'=>array(612,792), 'legal'=>array(612,1008));
    $pdf->SetMargins(1,1);
    $pdf->AddPage();
    $pdf->Image($n_logo,2,5,22);
    $pdf->SetFont('Arial','',13);
    $pdf->Ln(9); $pdf->Cell(0,0.5,$nama_prov,0,1,'C');
    $pdf->SetFont('Arial','',12);
    $pdf->Ln(5); $pdf->Cell(0,0.5,$nama_badan,0,1,'C');
    $pdf->SetFont('Arial','',10);
    $pdf->Ln(5); $pdf->Cell(0,0.5,$alamat,0,1,'C');
    $pdf->Ln(4); $pdf->Cell(0,0.5,$alamat2,0,1,'C');
    $pdf->Ln(4); $pdf->Cell(0,0.5,$alamat3,0,1,'C');
    $pdf->SetLineWidth(0.1); $pdf->Line(1,33,209,33);
    $pdf->SetLineWidth(0.5); $pdf->Line(1,34,209,34);
    $pdf->SetFont('Arial','B',12);
    $pdf->Ln(7); $pdf->Cell(0,0.5,'BUKTI PENDAFTARAN PERIZINAN ONLINE NON OSS',0,1,'L');
    $pdf->SetFont('Arial','',9);
    $pdf->Ln(7); $pdf->SetX(50); $pdf->Cell(0,0.5,'NOMOR RESI',0,1,'L');
                 $pdf->SetX(85); $pdf->Cell(0,-0.5,':',0,1,'L');
                 $pdf->SetX(87); $pdf->Cell(0,0,$no_resi,0,1,'L');
    $pdf->Ln(4); $pdf->SetX(50); $pdf->Cell(0,0.5,'NAMA PEMOHON',0,1,'L');
                 $pdf->SetX(85); $pdf->Cell(0,-0.5,':',0,1,'L');
                 $pdf->SetX(87); $pdf->Cell(0,0,$pemohon->n_pemohon,0,1,'L');
    $pdf->Ln(4); $pdf->SetX(50); $pdf->Cell(0,0.5,'JENIS PERMOHONAN',0,1,'L');
                 $pdf->SetX(85); $pdf->Cell(0,-0.5,':',0,1,'L');
                 $pdf->SetXY(87, $pdf->GetY()-1.5); $pdf->MultiCell(0,4,$izin->n_perizinan,0,'L');
    $pdf->Ln(2); $pdf->SetX(50); $pdf->Cell(0,0.5,'LOKASI',0,1,'L');
                 $pdf->SetX(85); $pdf->Cell(0,-0.5,':',0,1,'L');
                 $pdf->SetXY(87, $pdf->GetY()-1.5); $pdf->MultiCell(0,4,$permohonan->a_izin,0,'L');
    $pdf->Ln(2); $pdf->SetX(50); $pdf->Cell(0,0.5,'TANGGAL DAFTAR',0,1,'L');
                 $pdf->SetX(85); $pdf->Cell(0,-0.5,':',0,1,'L');
                 $pdf->SetX(87); $pdf->Cell(0,0,$permohonan->d_terima_berkas,0,1,'L');
        
    $QRCode = base_url(). $tempDir . $fileName;
    $pdf->Image($QRCode,2,45,40);
    
    $bebas_biaya = base_url(). 'backoffice/uploads/logo/BebasBiaya.png';
    $pdf->Image($bebas_biaya,2,86,40);
        
    $pdf->SetFont('Arial','',7);
    $pdf->SetXY(50,85); $pdf->MultiCell(0,4,'Catatan :',0,'L');
    $pdf->SetXY(50,89); $pdf->MultiCell(0,2.5,'1.',0,'L');
    $pdf->SetXY(53,89); $pdf->MultiCell(0,2.5,'Tanda terima berkas ini tidak menjamin diterbitkannya Dokumen Perizinan.',0,'L');
    $pdf->SetXY(50,92); $pdf->MultiCell(0,2.5,'2.',0,'L');
    $pdf->SetXY(53,92); $pdf->MultiCell(0,2.5,'Resi ini adalah tanda bukti Pendaftaran Online untuk pengambilan Naskah Izin atau Cek WEB.',0,'L');
    $pdf->SetXY(50,95); $pdf->MultiCell(0,2.5,'3.',0,'L');
    $pdf->SetXY(53,95); $pdf->MultiCell(0,2.5,'Status permohonan atau Informasi dapat dicek di Website https://dpmptsp.jabarprov.go.id / 0800 1001 100 (Gratis) atau Scan QRCode untuk link webcek.',0,'L');

    $pdf->SetLineWidth(0.1); $pdf->Line(1,100,209,100);
        
    #output file PDF {I:ViewStd ;D:Download ;F:SaveLocalFile S:ReturnString}
    $pdf->Output('Resi.pdf','D');    
    //EOF() Cetak ke PDF
  }
  
  function detail($uuid=NULL, $his=NULL) {
    $uuid     =	htmlspecialchars($uuid,ENT_QUOTES);
    $session  = $this->session->userdata("userlogin");
    $username = $this->session->userdata("username");
    $otherdb  = $this->load->database('otherdb', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
    
    if(empty($session)){
      redirect('main/login', 'refresh');
    }
    
    $permohonan	= $this->db->get_where("tmpermohonan_portal", array("uuid"=>$uuid))->first_row();
    
    if(count($permohonan)==0){
      $this->session->set_flashdata('error', 'Data Tidak Ditemukan');
      redirect('main/user/permohonan/', 'refresh');
    }
    
    $belakang = $otherdb->get_where("tmpemohon_portal",array('id_permohonan_portal'=>$permohonan->id))->first_row();
    
    ////////////// kalau harus edit
    if($permohonan->editable=="1" && count($belakang)>0){
      $sql   = "select * from trperizinan where id='".$permohonan->id_perizinan."'";
      $query = $otherdb->query($sql)->first_row();
      
      if(count($query)==0){
        redirect('main/permohonan/step1', 'refresh');
      }
      
      $judul	= $query->n_perizinan;
      
      $sql = "select trsyarat_perizinan.* from trsyarat_perizinan 
              where trsyarat_perizinan.id IN(select trsyarat_perizinan_id from trperizinan_trsyarat_perizinan 
              where trperizinan_id='".$permohonan->id_perizinan."' and status='1') ORDER BY trsyarat_perizinan.status";
      $query 	= $otherdb->query($sql)->result();
      
      if(count($query)==0){
        redirect('main/permohonan/step1', 'refresh');
        die;
      }
      
      $user      = $this->db->get_where("tm_pemohon",array("username"=>$username))->first_row();
      $asistensi = $this->db->order_by("tanggal","ASC");
      $asistensi = $this->db->get_where("asistensi",array("id_permohonan"=>$permohonan->id))->result();
      
      $data['title']      = "Ubah Syarat Permohonan Izin";
      $data['load']       = "permohonan/edit";
      $data['judul']      = $judul;
      $data['id']         = $permohonan->id_perizinan;
      $data['uuid']       = $permohonan->uuid;
      $data['user_id']    = $user->id;
      $data['pemohon']    = $user->namaPerusahaan;
      $data['username']   = $username;
      $data['permohonan'] = $permohonan;
      $data['syarat']     = $query;
      $data['asistensi']  = $asistensi;
      return $this->load->view('template_user',$data);
      // die;
    }
    /////////////// kalau harus edit
    
    $sql = "select * from trperizinan where id='".$permohonan->id_perizinan."'";
    $nama = $otherdb->query($sql)->first_row();
    	
    $sql = "select trsyarat_perizinan.* from trsyarat_perizinan 
            where trsyarat_perizinan.id IN(select trsyarat_perizinan_id from trperizinan_trsyarat_perizinan 
            where trperizinan_id='".$permohonan->id_perizinan."' and status='1')  ORDER BY trsyarat_perizinan.status";
    $query = $otherdb->query($sql)->result();
    	
    $status	= "Online";
    $track = 0;
    
    if(!empty($permohonan->no_permohonan)){
      $databackoffice	= $otherdb->get_where("tmpermohonan",array("pendaftaran_id"=>$permohonan->no_permohonan))->first_row();
      if(count($databackoffice)==1){
        $stats = $otherdb->get_where("tmpermohonan_trstspermohonan",array("tmpermohonan_id"=>$databackoffice->id))->first_row();
        $stat = $otherdb->get_where("trstspermohonan",array("id"=>$stats->trstspermohonan_id))->first_row();
        
        if(count($stat)!=0){
          $status = $stat->n_sts_permohonan_2;
        }	
      }else{
        $status = "Ditolak";
      }
      $track = $otherdb->order_by("id","desc");
      $track = $otherdb->get_where("tmtrackingperizinan", array("pendaftaran_id"=>$permohonan->no_permohonan))->result();
    }else{
      $belakang = $otherdb->get_where("tmpemohon_portal",array('id_permohonan_portal'=>$permohonan->id))->first_row();
      if(count($belakang)==0){
        $status =  "Ditolak";
      }	
    }
    
    $asistensi = $this->db->order_by("tanggal","ASC");
    $asistensi = $this->db->get_where("asistensi",array("id_permohonan"=>$permohonan->id))->result();
    $user = $this->db->get_where("tm_pemohon",array("username"=>$username))->first_row();
    
    $otherdb = $this->load->database('otherdb', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
    $sql = "select * from trperizinan where id='".$permohonan->id_perizinan."'";
    $qry = $otherdb->query($sql)->row_array();
    $data['property']  = $qry;
    
    $data['title']       = "Detail Permohonan Perizinan";
    $data['load']        = "permohonan/detail";
    $data['nama']        = $nama->n_perizinan;
    $data['username']    = $username;
    $data['pemohon']     = $user->namaPerusahaan;
    $data['permohonan']  = $permohonan;
    $data['persyaratan'] = $query;
    $data['status']      = $status;
    $data['track']       = $track;
    $data['asistensi']   = $asistensi;
    $data['belakang']    = count($belakang);
    $data['his']         = $his;
    $this->load->view('template_user',$data);
  }
  
  function addasistensi(){
    $session = $this->session->userdata("userlogin");
    $username = $this->session->userdata("username");
    $otherdb = $this->load->database('otherdb', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
    
    if(empty($session)){
      redirect('main/login', 'refresh');
    }
    
    if(empty($_POST)){
      redirect('main/user/permohonan/', 'refresh');
    }
    
    $uuid = htmlspecialchars($_POST['uuid'],ENT_QUOTES);
    $pesan = htmlspecialchars($_POST['pesan'],ENT_QUOTES);
    $pemohon = htmlspecialchars($_POST['pemohon'],ENT_QUOTES);
    
    $permohonan = $this->db->get_where("tmpermohonan_portal",array("uuid"=>$uuid))->first_row();
    
    if(count($permohonan)==0){
      $this->session->set_flashdata('error', 'Terjadi Kesalahan, mohon mengulangi proses');
      redirect('main/user/permohonan/', 'refresh');
    }
    
    $data = array('id_permohonan' => $permohonan->id,
                  'oleh' => $pemohon,
                  'pesan' => $pesan
                 );
    
    if($this->db->insert('asistensi',$data)){
      $this->session->set_flashdata('success', 'Pesan Anda Telah Terkirim');
      redirect('main/permohonan/detail/'.$uuid, 'refresh');
    }else{
      $this->session->set_flashdata('error', 'Terjadi Kesalahan, mohon mengulangi proses');
      redirect('main/permohonan/detail/'.$uuid, 'refresh');
    }
  }
}
?>