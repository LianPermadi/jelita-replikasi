<?php
/**
 * Description of Pengambilan SK
 * @author agusnur Created : 22 Sep 2010
 * @edit PBS Created : 7 Agustus 2015
 */
class AmbilSK extends WRC_AdminCont {

    public function __construct() {
        parent::__construct();
        $this->sk = new tmsk();
		$this->settings = new settings();
        $enabled = FALSE;
        $list_auths = $this->session_info['app_list_auth'];
        
        foreach ($list_auths as $list_auth) {
            if ($list_auth->id_role === '15') {
                $enabled = TRUE;
            }
        }
        
        if (!$enabled) {
            redirect('dashboard');
        }
    }

    public function index() {  // Penyerahan Izin pertama masuk saat klik menu uzin
        $tgla = $this->input->post('tgla');
        $tglb = $this->input->post('tglb');
        $now = $this->lib_date->get_date_now();
        $tgl_before = $this->lib_date->set_date($now, -30);
        $tgl_now = $this->lib_date->set_date($now, 0);
		$kd_filter = $this->input->post('kd_filter');
		$no_daftar = $this->input->post('kt_cari');

        if ($tgla && $tglb) {
            $data['tgla'] = $tgla;
            $data['tglb'] = $tglb;
        } else {
            $tgla = $tgl_before;
            $tglb = $tgl_now;
            $data['tgla'] = $tgla;
            $data['tglb'] = $tglb;
        }
        $username = new user();
        $username->where('username', $this->session->userdata('username'))->get();
		//$this->lib_date->post_variable($username->id, $tgla, $tglb, '', '', '', '', '', '', '', '');   // post variable
		$lokasi_user = $this->session->userdata('lokasi');
		$data['lokasi_user'] = $lokasi_user;
		$data['kt_cari'] = $no_daftar;
		if($kd_filter != ''){
		    $this->lib_date->post_variable($username->id, $tgla, $tglb, '', '', '', '', '', '', '', '');          // post variable
			if($kd_filter == '1'){
                $query_filter = " AND A.pendaftaran_id LIKE '%".$no_daftar."%' ";
				$data['tgla'] = '0000-00-00';
                $data['tglb'] = '0000-00-00';
		    }else{
                $query_filter = " AND A.d_terima_berkas between '$tgla' and '$tglb' ";
		    }
		}else{
            $query_filter = " AND A.d_terima_berkas between '$tgla' and '$tglb' ";			
		}
        if ($lokasi_user === 'Pusat') { // Untuk daerah lain
		//if ($lokasi_user === 'DPMPTSP Prov. tasikmalaya' || $lokasi_user === 'BPMPT Prov. tasikmalaya' || $lokasi_user === 'BPPT Prov. tasikmalaya') {
            $query = "SELECT  A.id, A.pendaftaran_id, A.c_status_bayar, A.d_terima_berkas, A.a_izin, A.keterangan,
            A.d_perubahan, A.d_perpanjangan, A.d_daftarulang, A.siap_serah, A.status_berkas,
            C.id idizin, C.n_perizinan, E.n_pemohon,
            G.id idjenis, G.n_permohonan,
            I.status_bap, K.tgl_surat, K.no_surat, K.c_cetak, K.no_surat_edit, K.tgl_surat_edit, N.n_sts_permohonan,
            L.trkelompok_perizinan_id idkelompok,
            E.telp_pemohon, A.kd_gerai
            FROM tmpermohonan as A
            INNER JOIN tmpermohonan_trperizinan as B ON B.tmpermohonan_id = A.id
            INNER JOIN trperizinan as C ON B.trperizinan_id = C.id
            INNER JOIN tmpemohon_tmpermohonan as D ON D.tmpermohonan_id = A.id
            INNER JOIN tmpemohon as E ON D.tmpemohon_id = E.id
            INNER JOIN tmpermohonan_trjenis_permohonan as F ON F.tmpermohonan_id = A.id
            INNER JOIN trjenis_permohonan as G ON F.trjenis_permohonan_id = G.id
            INNER JOIN tmbap_tmpermohonan H ON A.id = H.tmpermohonan_id
            INNER JOIN tmbap I ON H.tmbap_id = I.id
            INNER JOIN tmpermohonan_tmsk J ON A.id = J.tmpermohonan_id
            INNER JOIN tmsk K ON J.tmsk_id = K.id
            INNER JOIN trkelompok_perizinan_trperizinan L ON L.trperizinan_id = C.id
            INNER JOIN tmpermohonan_trstspermohonan M ON A.id = M.tmpermohonan_id
            INNER JOIN trstspermohonan N ON M.trstspermohonan_id = N.id
            /* INNER JOIN trperizinan_user AS M ON M.trperizinan_id = C.id */
            WHERE A.c_pendaftaran = 1
            AND A.c_izin_dicabut = 0
            AND A.c_izin_selesai = 0
            /* AND M.user_id = '" . $username->id . "' */".$query_filter."order by A.id DESC";
		} else {
            $query = "SELECT  A.id, A.pendaftaran_id, A.c_status_bayar, A.d_terima_berkas, A.a_izin, A.keterangan,
            A.d_perubahan, A.d_perpanjangan, A.d_daftarulang, A.siap_serah, A.status_berkas,
            C.id idizin, C.n_perizinan, E.n_pemohon,
            G.id idjenis, G.n_permohonan,
            I.status_bap, K.tgl_surat, K.no_surat, K.c_cetak, K.no_surat_edit, K.tgl_surat_edit, N.n_sts_permohonan,
            L.trkelompok_perizinan_id idkelompok,
            E.telp_pemohon, A.kd_gerai
            FROM tmpermohonan as A
            INNER JOIN tmpermohonan_trperizinan as B ON B.tmpermohonan_id = A.id
            INNER JOIN trperizinan as C ON B.trperizinan_id = C.id
            INNER JOIN tmpemohon_tmpermohonan as D ON D.tmpermohonan_id = A.id
            INNER JOIN tmpemohon as E ON D.tmpemohon_id = E.id
            INNER JOIN tmpermohonan_trjenis_permohonan as F ON F.tmpermohonan_id = A.id
            INNER JOIN trjenis_permohonan as G ON F.trjenis_permohonan_id = G.id
            INNER JOIN tmbap_tmpermohonan H ON A.id = H.tmpermohonan_id
            INNER JOIN tmbap I ON H.tmbap_id = I.id
            INNER JOIN tmpermohonan_tmsk J ON A.id = J.tmpermohonan_id
            INNER JOIN tmsk K ON J.tmsk_id = K.id
            INNER JOIN trkelompok_perizinan_trperizinan L ON L.trperizinan_id = C.id
            INNER JOIN tmpermohonan_trstspermohonan M ON A.id = M.tmpermohonan_id
            INNER JOIN trstspermohonan N ON M.trstspermohonan_id = N.id
            /* INNER JOIN trperizinan_user AS M ON M.trperizinan_id = C.id */
            WHERE A.c_pendaftaran = 1
            AND A.c_izin_dicabut = 0
            AND A.c_izin_selesai = 0
			AND A.kd_gerai = '" . $username->lokasi . "'
            /* AND M.user_id = '" . $username->id . "' */".$query_filter."order by A.id DESC";
		}
        $data['list'] = $query;
        $this->load->vars($data);
        $js = "
		        $(document).ready(function() {
                    $(\"#tabs\").tabs();

                    $('a[rel*=penyerahan_box]').facebox();
                } );

                function confirm_link(text){
                    if(confirm(text)){ return true;
                    }else{ return false; }
                }

                $(document).ready(function() {
                        oTable = $('#penyerahan').dataTable({
                                \"bJQueryUI\": true,
                                \"sPaginationType\": \"full_numbers\"
                        });
                } );
                $(function() {
                    $(\".monbulan\").datepicker({
                        changeMonth: true,
                        changeYear: true,
                        dateFormat: 'yy-mm-dd',
                        closeText: 'X'
                    });
                $('.kirimsms').click(function(){               
                    $('#smsdialog').dialog({modal: true,title:'Konfirmasi SMS',autoOpen: false,height: 150,width:250,draggable:false,resizable:false});
                    $('#smsdialog').dialog('open');
                    return false;
                });    
				$('#tblreset').click(function(){
					$('#smsdialog').dialog('close');
				});

                });
                
                function isino(data,isisms) {
                    $('#txtno').val(data.toString());
	                $('#spanno').text(data.toString());
                    $('#txtisi').val(isisms.toString());
                    //var url=$(this).attr('href'); 
                }
                ";
        $this->template->set_metadata_javascript($js);        
        $this->session_info['page_name'] = "Penyerahan Izin";
        $this->template->build('ambilsk_list', $this->session_info);
    }

	public function list_index() { // Kembali dari proses penyiapan dan penyerahan Izin
        $kd_filter = $this->input->post('kd_filter');
		$no_daftar = $this->input->post('kt_cari');
		$username = new user();
        $username->where('username', $this->session->userdata('username'))->get();
		$tgla = $username->gvar1;
        $tglb = $username->gvar2;
        $data['tgla'] = $tgla;
        $data['tglb'] = $tglb;

		$lokasi_user = $this->session->userdata('lokasi');
        $data['lokasi_user'] = $lokasi_user;
		$data['kt_cari'] = $no_daftar;
		if($kd_filter != ''){
		    $this->lib_date->post_variable($username->id, $tgla, $tglb, '', '', '', '', '', '', '', '');          // post variable
			if($kd_filter == '1'){
                $query_filter = " AND A.pendaftaran_id LIKE '%".$no_daftar."%' ";
				$data['tgla'] = '0000-00-00';
                $data['tglb'] = '0000-00-00';
		    }else{
                $query_filter = " AND A.d_terima_berkas between '$tgla' and '$tglb' ";
		    }
		}else{
            $query_filter = " AND A.d_terima_berkas between '$tgla' and '$tglb' ";			
		}
        if ($lokasi_user === 'Pusat') { // Untuk daerah lain
		//if ($lokasi_user === 'DPMPTSP Prov. tasikmalaya' || $lokasi_user === 'BPMPT Prov. tasikmalaya' || $lokasi_user === 'BPPT Prov. tasikmalaya') {
            $query = "SELECT  A.id, A.pendaftaran_id, A.c_status_bayar, A.d_terima_berkas, A.a_izin, A.keterangan,
            A.d_perubahan, A.d_perpanjangan, A.d_daftarulang, A.siap_serah, A.status_berkas,
            C.id idizin, C.n_perizinan, E.n_pemohon,
            G.id idjenis, G.n_permohonan,
            I.status_bap, K.tgl_surat, K.no_surat, K.c_cetak, K.no_surat_edit, K.tgl_surat_edit, N.n_sts_permohonan,
            L.trkelompok_perizinan_id idkelompok,
            E.telp_pemohon, A.kd_gerai
            FROM tmpermohonan as A
            INNER JOIN tmpermohonan_trperizinan as B ON B.tmpermohonan_id = A.id
            INNER JOIN trperizinan as C ON B.trperizinan_id = C.id
            INNER JOIN tmpemohon_tmpermohonan as D ON D.tmpermohonan_id = A.id
            INNER JOIN tmpemohon as E ON D.tmpemohon_id = E.id
            INNER JOIN tmpermohonan_trjenis_permohonan as F ON F.tmpermohonan_id = A.id
            INNER JOIN trjenis_permohonan as G ON F.trjenis_permohonan_id = G.id
            INNER JOIN tmbap_tmpermohonan H ON A.id = H.tmpermohonan_id
            INNER JOIN tmbap I ON H.tmbap_id = I.id
            INNER JOIN tmpermohonan_tmsk J ON A.id = J.tmpermohonan_id
            INNER JOIN tmsk K ON J.tmsk_id = K.id
            INNER JOIN trkelompok_perizinan_trperizinan L ON L.trperizinan_id = C.id
            INNER JOIN tmpermohonan_trstspermohonan M ON A.id = M.tmpermohonan_id
            INNER JOIN trstspermohonan N ON M.trstspermohonan_id = N.id
            /* INNER JOIN trperizinan_user AS M ON M.trperizinan_id = C.id */
            WHERE A.c_pendaftaran = 1
            AND A.c_izin_dicabut = 0
            AND A.c_izin_selesai = 0
            /* AND M.user_id = '" . $username->id . "' */".$query_filter."order by A.id DESC";
		} else {
            $query = "SELECT  A.id, A.pendaftaran_id, A.c_status_bayar, A.d_terima_berkas, A.a_izin, A.keterangan,
            A.d_perubahan, A.d_perpanjangan, A.d_daftarulang, A.siap_serah, A.status_berkas,
            C.id idizin, C.n_perizinan, E.n_pemohon,
            G.id idjenis, G.n_permohonan,
            I.status_bap, K.tgl_surat, K.no_surat, K.c_cetak, K.no_surat_edit, K.tgl_surat_edit, N.n_sts_permohonan,
            L.trkelompok_perizinan_id idkelompok,
            E.telp_pemohon, A.kd_gerai
            FROM tmpermohonan as A
            INNER JOIN tmpermohonan_trperizinan as B ON B.tmpermohonan_id = A.id
            INNER JOIN trperizinan as C ON B.trperizinan_id = C.id
            INNER JOIN tmpemohon_tmpermohonan as D ON D.tmpermohonan_id = A.id
            INNER JOIN tmpemohon as E ON D.tmpemohon_id = E.id
            INNER JOIN tmpermohonan_trjenis_permohonan as F ON F.tmpermohonan_id = A.id
            INNER JOIN trjenis_permohonan as G ON F.trjenis_permohonan_id = G.id
            INNER JOIN tmbap_tmpermohonan H ON A.id = H.tmpermohonan_id
            INNER JOIN tmbap I ON H.tmbap_id = I.id
            INNER JOIN tmpermohonan_tmsk J ON A.id = J.tmpermohonan_id
            INNER JOIN tmsk K ON J.tmsk_id = K.id
            INNER JOIN trkelompok_perizinan_trperizinan L ON L.trperizinan_id = C.id
            INNER JOIN tmpermohonan_trstspermohonan M ON A.id = M.tmpermohonan_id
            INNER JOIN trstspermohonan N ON M.trstspermohonan_id = N.id
            /* INNER JOIN trperizinan_user AS M ON M.trperizinan_id = C.id */
            WHERE A.c_pendaftaran = 1
            AND A.c_izin_dicabut = 0
            AND A.c_izin_selesai = 0
			AND A.kd_gerai = '" . $username->lokasi . "'
            /* AND M.user_id = '" . $username->id . "' */".$query_filter."order by A.id DESC";
		}

		$data['list'] = $query;
        $this->load->vars($data);

        $js = "
		        $(document).ready(function() {
                    $(\"#tabs\").tabs();

                    $('a[rel*=penyerahan_box]').facebox();
                } );

                function confirm_link(text){
                    if(confirm(text)){ return true;
                    }else{ return false; }
                }

                $(document).ready(function() {
                        oTable = $('#penyerahan').dataTable({
                                \"bJQueryUI\": true,
                                \"sPaginationType\": \"full_numbers\"
                        });
                } );
                $(function() {
                    $(\".monbulan\").datepicker({
                        changeMonth: true,
                        changeYear: true,
                        dateFormat: 'yy-mm-dd',
                        closeText: 'X'
                    });
                });
                ";

        $this->template->set_metadata_javascript($js);
        $this->session_info['page_name'] = "Penyerahan Izin";
        $this->template->build('ambilsk_list', $this->session_info);
    }

    public function sendSMSGateway() {
		$n_hp = $this->input->post('txtno',TRUE);
		$n_email = 'pamudi1694@gmail.com';
        $n_judul = 'Status Perizinan';
		$n_pesan = $this->input->post('txtisi',TRUE);

		echo 'NO :' . $n_hp . 'PESAN : ' . $n_pesan;
        
   		// Kirim ke media SMS  via gammu dan e-mail via PHPMailer()
   		// Kirim ke media SMS  via gammu

        $this->settings->where('name', 'smsGateway')->get();
        if($this->settings->status == 1){
		    $gammu   = $this->load->database('gammu', TRUE);   // the TRUE paramater tells CI that you'd like to return the database object.
     		$data = array(     // Isi data untuk sms hanya 158 char
        	   'DestinationNumber'	=> $n_hp,
	           'TextDecoded'		=> $n_pesan,
	           // 'CreatorID' 			=> "Gammu",
   		    );
    	    $gammu->insert('outbox',$data);
		}

   		// Kirim ke media e-mail via PHPMailer()
		$this->settings->where('name', 'send_mail')->get();
        if($this->settings->status == 1){
    	    $host             =	"smtp.gmail.com";
    		$emailpengirim    =	"ptsptasikmalayakab@gmail.com";
    		$namapengirim     =	"DPMPTSP TASIKMALAYA";
    		$password         =	"~ptsptasikmalayakabgoid#";
    		$targetpengiriman =	$n_email;
   	    	require("assets/plugins/phpmailer/class.phpmailer.php");
   		    require("assets/plugins/phpmailer/class.smtp.php");
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
   	    	$mailer->From     = $emailpengirim;
   		    $mailer->AddAddress($targetpengiriman,$targetpengiriman);
     		//Isi Data untuk e-mail
    		$mailer->Subject = $n_judul;
    		//$isi = "<p>Pengajuan ".$perizinan->n_perizinan." an. ".$user->namaPerusahaan." dalam proses : ".$status->n_sts_permohonan_2."</p>";
   	    	//$isi .= "<p>Terima kasih atas perhatiannya<br>- BPMPT TASIKMALAYA</p>";
   	 	    $isi = $n_pesan;
    		$mailer->Body = $isi;
    		$mailer->AltBody = $isi;
    		$mailer->Send();
		}
   		// EOF() Kirim ke media SMS  via gammu dan e-mail via PHPMailer() 

		//redirect('pelayanan/ambilsk');
    }

	public function kirim_ulang_sms($n_hp = NULL, $n_email = NULL, $i_ok = NULL) {
		//$n_hp = $this->input->post('txtno',TRUE);
		//$n_email = 'pamudi1694@gmail.com';
        $n_judul = 'Status Perizinan';
        if($i_ok=='T')
    	    $n_pesan = 'DPMPTSP: Izin dg no daftar: '.$permohonan->pendaftaran_id.' DISETUJUI, dan bisa di ambil di tempat anda daftar '.$stat;
		else
		    $n_pesan = 'DPMPTSP: Izin dg no daftar: '.$permohonan->pendaftaran_id.' DITOLAK, mohon utk mengambil berkas permohonan di tempat anda daftar '.$stat;


   		// Kirim ke media SMS  via gammu dan e-mail via PHPMailer()
   		// Kirim ke media SMS  via gammu
        $this->settings->where('name', 'smsGateway')->get();
        if($this->settings->status == 1){
            // Kirim SMS
			$gammu = $this->load->database('gammu', TRUE);   // the TRUE paramater tells CI that you'd like to return the database object.
	    	$data = array(     // Isi data untuk sms hanya 158 char
	        	   'DestinationNumber'	=> $n_hp,
		           'TextDecoded'		=> $n_pesan,
		           // 'CreatorID' 			=> "Gammu",
        	);
	        $gammu->insert('outbox',$data);

        	// Kirim ke media e-mail via PHPMailer()
			if($n_email != '-'){
    	        $this->settings->where('name', 'send_mail')->get();
	    		$host             =	"smtp.gmail.com";
        		$emailpengirim    =	"ptsptasikmalaya@gmail.com";
    		    $namapengirim     =	"DPMPTSP TASIKMALAYA";
    		    $password         =	"~ptsptasikmalayakabgoid#";
    	    	$targetpengiriman =	$n_email;
        		require("assets/plugins/phpmailer/class.phpmailer.php");
        		require("assets/plugins/phpmailer/class.smtp.php");
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
    		    $mailer->From     = $emailpengirim;
    		    $mailer->AddAddress($targetpengiriman,$targetpengiriman);
    	    	//Isi Data untuk e-mail
        		$mailer->Subject = $n_judul;
        		//$isi = "<p>Pengajuan ".$perizinan->n_perizinan." an. ".$user->namaPerusahaan." dalam proses : ".$status->n_sts_permohonan_2."</p>";
    		    //$isi .= "<p>Terima kasih atas perhatiannya<br>- BPMPT TASIKMALAYA</p>";
    		    $isi = $n_pesan;
    	    	$mailer->Body = $isi;
        		$mailer->AltBody = $isi;
        		$mailer->Send();
			}
		}
   		// EOF() Kirim ke media SMS  via gammu dan e-mail via PHPMailer()
		redirect('pelayanan/ambilsk/list_index');
    }

	public function sendSMSGateway_OLD() {
        $this->load->library('form_validation');
		
		$this->form_validation->set_rules('txtno','No Tujuan','trim|required|numeric');
		$this->form_validation->set_rules('txtisi','Isi Pesan','trim|required|max_length[160]|min_length[4]|htmlspecialchars|xss_clean');
		
		if($this->form_validation->run()==FALSE) {
			echo validation_errors();
			exit;
		} else {			
			$no = $this->input->post('txtno',TRUE);
			$pesan = $this->input->post('txtisi',TRUE);
			if($this->_sembunyiInsert($no,$pesan)) {
				redirect('pelayanan/ambilsk');
			} else {
				echo "Terjadi Kesalahan, Silahkan kirim kembali";
				exit;
			}
		}		        
    }

	function _sembunyiInsert($no,$pesan) {
		$this->load->model('m_insert','MInsert');
		return $this->MInsert->inserData($no,$pesan);
	}

    public function siap_diserahkan($sts_info=NULL, $id_daftar=NULL, $i_ok=NULL) { // Untuk Siap diserahkan dan notifikasi ulang ke pemohon
		$u_ser = $this->session->userdata('username');
		$r_name = $this->lib_date->get_nama_ori($u_ser);
		$username = new user();
        $username->where('username', $u_ser)->get();
		$tgla = $username->gvar1;
        $tglb = $username->gvar2;

        $permohonan = new tmpermohonan();
        $permohonan->get_by_id($id_daftar);
		$no_pendaftaran = $permohonan->pendaftaran_id;
		$id_portal = $permohonan->id_pemohon_portal;
        $permohonan->siap_serah = 'OK';
		$permohonan->tgl_siap_serah = $this->lib_date->get_date_now(); 
		$permohonan->kd_status = 8; // ubah kd_status menjadi 8 untuk proses selanjutnya (penyerahan)
        $update = $permohonan->save();
        $pemohon = $permohonan->tmpemohon->get();
        $status_izin = $permohonan->trstspermohonan->get();
		$perusahaan = $permohonan->tmperusahaan->get();

        if($sts_info == 1){
			//$info = "call log ('Siap Penyerahan Izin','Siap Penyerahan izin ";
            //$status_skr = "8";                 //Penyusunan / Pencetakan Naskah Perizinan [Lihat Tabel trstspermohonan()]
            $id_status = "16";                   //Siap Diserahkan [Lihat Tabel trstspermohonan()]

		    $tracking_izin = new tmtrackingperizinan();
            $tracking_izin->where('pendaftaran_id', $no_pendaftaran)
                          ->where('tr_activiti', 'Penyerahan Izin')->get();
    		if($tracking_izin->pendaftaran_id){
			$tracking_izin->status = 'Update';
				$tracking_izin->tr_name = $r_name;
                $tracking_izin->tr_user = $u_ser;
				$tracking_izin->d_entry = $this->lib_date->get_date_now();
				$hit_ubah = $tracking_izin->hit_ubah + 1;
		        $his_ubah = $tracking_izin->his_ubah;
		        $tracking_izin->hit_ubah = $hit_ubah;
		        $tracking_izin->his_ubah = $his_ubah.'SIAP DISERAHKAN^'.$r_name.'^'.$this->lib_date->get_date_now().';';
		        $tracking_izin->save();
            }

            /* [Lihat Tabel trstspermohonan()] */
            $tracking_izin2 = new tmtrackingperizinan();
            $tracking_izin2->where('pendaftaran_id', $no_pendaftaran)
                           ->where('tr_activiti', 'Arsip')->get();
			if(!$tracking_izin2->pendaftaran_id){
                $tracking_izin2->pendaftaran_id = $permohonan->pendaftaran_id;
                $tracking_izin2->status = 'Insert';
	    		$tracking_izin2->tr_activiti = 'Arsip';
                $tracking_izin2->d_entry_awal = $this->lib_date->get_date_now();
                $tracking_izin2->d_entry = $this->lib_date->get_date_now();
                $sts_izin2 = new trstspermohonan();
                $sts_izin2->get_by_id($id_status); //[Lihat Tabel trstspermohonan()]
                $sts_izin2->save($permohonan);
                $tracking_izin2->save($permohonan);
                $tracking_izin2->save($sts_izin2);
			}
        }else{
			//$info = "call log ('Notifikasi Ulang','Notifikasi Ulang ";
            $update = TRUE;
		}

        if (!$update) {
            echo '<p>' . $update->error->string . '</p>';
        } else {
			$jm = 1;
    		if($id_portal > 0){ //untuk pendaftaran OnLine
    	    	$pemohon_portal = new tmpemohon_portal();
	        	$pemohon_portal->get_by_id($id_portal);
                $n_hp = $pemohon_portal->telpPemohon;
		        $n_email = $pemohon_portal->emailPerusahaan;
				$stat = '<Bawa Resi Asli & Tunjukkan SMS ini>'; //max 35 dgt
		    } else {
                $n_hp = $permohonan->kontak_person;
				$n_hp2 = $pemohon->telp_pemohon;
                if($n_hp != $n_hp2) $jm = 2;
                $n_email = $perusahaan->email;
				if($n_email == '') $n_email = '-';
				$stat = '<Bawa Tanda Terima Berkas Asli>'; //max 35 dgt
			}
            // 1        01        01        01        01        01        01        01        01        01        01        01        01        0    135 dgt
            //'DPMPTSP: Izin dg no daftar: 0000000000000000000 DISETUJUI, dan bisa di ambil di tempat anda daftar 00000000000000000000000000000000000';
            $n_judul = 'Status Perizinan';
			if($i_ok=='T')
	    	    $n_pesan = 'DPMPTSP: Izin dg no daftar: '.$permohonan->pendaftaran_id.' DISETUJUI, dan bisa diambil di tempat anda daftar '.$stat;
			else
			    $n_pesan = 'DPMPTSP: Izin dg no daftar: '.$permohonan->pendaftaran_id.' DITOLAK, mohon utk mengambil berkas permohonan di tempat anda daftar '.$stat;
    		$jum_in_pesan = 10;
        
    		// Kirim ke media SMS  via gammu dan e-mail via PHPMailer()
    		// Kirim ke media SMS  via gammu
            $this->settings->where('name', 'smsGateway')->get();
            if($this->settings->status == 1) {
            	$sendS = FALSE;
				// Kirim SMS
				// $gammu = $this->load->database('gammu', TRUE);
	   			//  		$data = array('DestinationNumber' => $n_hp,'TextDecoded' => $n_pesan);
	   			//          $gammu->insert('outbox',$data);
				// if($jm == 2){
				//     $gammu = $this->load->database('gammu', TRUE);
	   			//  		    $data = array('DestinationNumber' => $n_hp2,'TextDecoded' => $n_pesan);
	   			//              $gammu->insert('outbox',$data);
				// }
			}
				// EOF() Kirim SMS

        		// Kirim ke media e-mail via PHPMailer()
			$this->settings->where('name', 'send_mail')->get();
			if ($this->settings->status == 1) {
				if($n_email != '-'){
	    		    $host             =	"smtp.gmail.com";
        		    $emailpengirim    =	"ptsptasikmalayakab@gmail.com";
    		        $namapengirim     =	"DPMPTSP TASIKMALAYA";
    		        $password         =	"~ptsptasikmalayakabgoid#";
    	    	    $targetpengiriman =	$n_email;
        		    require("assets/plugins/phpmailer/class.phpmailer.php");
        		    require("assets/plugins/phpmailer/class.smtp.php");
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
    		        $mailer->From     = $emailpengirim;
    		        $mailer->AddAddress($targetpengiriman,$targetpengiriman);
    	    	    //Isi Data untuk e-mail
        		    $mailer->Subject = $n_judul;
        		    //$isi = "<p>Pengajuan ".$perizinan->n_perizinan." an. ".$user->namaPerusahaan." dalam proses : ".$status->n_sts_permohonan_2."</p>";
    		        //$isi .= "<p>Terima kasih atas perhatiannya<br>- BPMPT TASIKMALAYA</p>";
    		        // $isi  = "<img src = 'https://spekta.tasikmalayakab.go.id/spekta/assets/2016/images/logo_bpmpt.png' style = 'max-width:35%; max-height:35%; line-height: 100%; outline: none; text-decoration: none; border: 0 none;'><br>";
    		        $isi  = "<h2>Informasi Permohonan Perizinan anda di Dinas PMPTSP Tasikmalaya</h2><hr>";
    		        if($i_ok=='T') {
    		        	$isi .= 'Izin dengan nomor pendaftaran: '.$permohonan->pendaftaran_id.' DISETUJUI, dan dapat diambil di tempat anda mendaftar.';
    		        } else {
    		        	$isi .= 'Izin dengan nomor pendaftaran: '.$permohonan->pendaftaran_id.' DITOLAK, mohon untuk mengambil berkas permohonan di tempat anda daftar.';
    		        }
    		        $isi .= "<p>Terima kasih atas perhatiannya.<br>- Dinas PMPTSP Tasikmalaya</p>";
		            $isi .= "<br><hr>";
		            // $isi .= "<p><small>&copy; Dinas Penanaman Modal dan Pelayanan Terpadu Satu Pintu Kabupaten Tasikmalaya - ".date('Y')."<br>Jalan Windu Nomor 26<br>Tasikmalaya, Tasikmalaya, Indonesia. 40263.</small></p>";
		            // $isi .= "<hr>";
		            $isi .= "<center><p><small>Harap jangan membalas e-mail ini, karena e-mail ini dikirimkan secara otomatis oleh sistem.</small></p></center>";
    	    	    $mailer->Body = $isi;
        		    $mailer->AltBody = $isi;
        		    $mailer->Send();
				}
			}
    		// EOF() Kirim ke media SMS  via gammu dan e-mail via PHPMailer()

            $tgl = date("Y-m-d H:i:s");
            $u_ser = $this->session->userdata('username');
            $g = $this->sql($u_ser);
            //$p = $this->db->query($info.$permohonan->pendaftaran_id."','".$tgl."','".$u_ser."')");
			redirect('pelayanan/ambilsk/list_index');
        }
    }

    public function diambil2($id_daftar = NULL, $tgla = NULL, $tglb = NULL) { // untuk entri data pengambilan berkas
        $data['page_name'] = "Detail Daftar Rekap Pendaftaran";
//        $data['list_tahun'] = $this->permohonan->group_by('d_tahun','ASC')->get();
//        $this->permohonan->where("date(d_entry) between '$tgla' and '$tglb'")->get();
//        $data['list'] = $this->perizinan->where('id',$id)->get();
        $data['tgla'] = $tgla;
        $data['tglb'] = $tglb;
//        $data['izin_id'] = $id;
//        $data['data_tahun'] = $this->input->post('d_tahun');
//        $data['list_tahun'] = $this->permohonan->group_by('d_tahun','ASC')->get();
//        $data['list'] = $this->perizinan->where('id', $id)->get();
//        $data['data_tahun'] = $this->permohonan->where('d_tahun', $tahun)->get();
//        $data['data_th'] = $tahun->get();
        $this->load->vars($data);
        $this->load->view('view_ambilsk', $data);
    }

    public function input_data($id=NULL, $idizin=NULL) {    // Input pengambilan berkas
        $permohonan = new tmpermohonan();
        $perizinan = new trperizinan();
        $property = new trproperty();
        $jenisproperty = new tmproperty_jenisperizinan();
        $koefesientarifretribusi = new trkoefesientarifretribusi();
        $bap = new tmbap();
        $retribusi = new trretribusi();

        $permohonan->where('id', $id)->get();

        $permohonan->trperizinan->get();
        $permohonan->tmpemohon->get();
        $permohonan->tmperusahaan->get();
        $bap = $permohonan->tmbap->get();
		$sk = $permohonan->tmsk->get();
        $p_pemohon = $permohonan->tmpemohon->get();
        $p_kelurahan = $p_pemohon->trkelurahan->get();
        $p_kecamatan = $p_kelurahan->trkecamatan->get();
        $p_kabupaten = $p_kecamatan->trkabupaten->get();
        $p_prov = $p_kabupaten->trpropinsi->get();

        $permohonan->$perizinan->where('id', $idizin)->get();
        $permohonan->$perizinan->$retribusi->get();

        $k_property = $permohonan->$perizinan->$property->$jenisproperty->k_property;
        $koefesientarifretribusi->where('id', $k_property)->get();

/*  jamgam digunakan dulu utk membuktikan pengambilan berkas
		// Untuk cek sms pengambilan berkas
        //untuk pendaftaran OnLine
		$token	= substr(str_shuffle("1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 5);
		$id_portal = $permohonan->id_pemohon_portal;
		$ncek = FALSE;
    	if($id_portal > 0){
			$ncek = TRUE;
    	    $pemohon_portal = new tmpemohon_portal();
	        $pemohon_portal->get_by_id($id_portal);
            $n_hp = $pemohon_portal->telpPemohon;
		    $n_email = $pemohon_portal->emailPerusahaan;
		}
        $n_judul = 'Status Perizinan';
   	    $n_pesan = 'BPMPT: Gunakan Nomor Token : '.$token.' untuk mengambil berkas Izin';
        
    		// Kirim ke media SMS  via gammu dan e-mail via PHPMailer()
    		// Kirim ke media SMS  via gammu
            $this->settings->where('name', 'smsGateway')->get();
            if($this->settings->status == 1 && $ncek){
				// Kirim SMS
				$gammu   = $this->load->database('gammu', TRUE);   // the TRUE paramater tells CI that you'd like to return the database object.
	    		$data = array(     // Isi data untuk sms hanya 158 char
	        	   'DestinationNumber'	=> $n_hp,
		           'TextDecoded'		=> $n_pesan,
		           // 'CreatorID' 			=> "Gammu",
        		);
	        	$gammu->insert('outbox',$data);

        		// Kirim ke media e-mail via PHPMailer()
   	        	$this->settings->where('name', 'send_mail')->get();
    		    $host             =	"smtp.gmail.com";
       		    $emailpengirim    =	"bpmpttasikmalaya@gmail.com";
   		        $namapengirim     =	"BPMPT tasikmalaya";
   		        $password         =	"bpmpttasikmalayakabgoid";
   	    	    $targetpengiriman =	$n_email;
       		    require("assets/plugins/phpmailer/class.phpmailer.php");
       		    require("assets/plugins/phpmailer/class.smtp.php");
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
   		        $mailer->From     = $emailpengirim;
   		        $mailer->AddAddress($targetpengiriman,$targetpengiriman);
   	    	    //Isi Data untuk e-mail
       		    $mailer->Subject = $n_judul;
       		    //$isi = "<p>Pengajuan ".$perizinan->n_perizinan." an. ".$user->namaPerusahaan." dalam proses : ".$status->n_sts_permohonan_2."</p>";
   		        //$isi .= "<p>Terima kasih atas perhatiannya<br>- BPMPT TASIKMALAYA</p>";
   		        $isi = $n_pesan;
   	    	    $mailer->Body = $isi;
       		    $mailer->AltBody = $isi;
       		    $mailer->Send();
			}
    		// EOF() Kirim ke media SMS  via gammu dan e-mail via PHPMailer()
        // EOF() Untuk cek sms pengambilan berkas
*/

        $data['list'] = $permohonan->$perizinan->trproperty->order_by('c_parent_order asc, c_order asc')->get();
        $data['list_daftar'] = $permohonan->tmproperty_jenisperizinan->get();

        $data['waktu_awal'] = $this->lib_date->get_date_now();
        $data['id'] = $permohonan->id;
        $data['idpemohon'] = $permohonan->tmpemohon->id;
        $data['idjenis'] = $permohonan->trperizinan->id;
        $data['jenislayanan'] = $permohonan->trperizinan->n_perizinan;
        $data['nopendaftaran'] = $permohonan->pendaftaran_id;
		$data['noantri'] = $permohonan->no_antri;
		$data['tgl_permohonan'] = $permohonan->d_terima_berkas;
		$data['gerai'] = $permohonan->kd_gerai;
		$data['objekizin'] = $permohonan->a_izin;
        $data['namapemohon'] = $permohonan->tmpemohon->n_pemohon;
        $alamat = $p_pemohon->a_pemohon;
		if($p_kelurahan->n_kelurahan !== "-") $alamat = $alamat . ', ' . $p_kelurahan->n_kelurahan; 
		if($p_kecamatan->n_kecamatan !== "-") $alamat = $alamat . ', ' . $p_kecamatan->n_kecamatan; 
		if($p_kabupaten->n_kabupaten !== "-") $alamat = $alamat . ', ' . $p_kabupaten->n_kabupaten; 
		if($p_prov->n_propinsi !== "-") $alamat = $alamat . ', ' . $p_prov->n_propinsi;
        $data['alamatpemohon'] = $alamat;
        $data['namaperusahaan'] = $permohonan->tmperusahaan->n_perusahaan;
        $data['m_hitung'] = $permohonan->trperizinan->$retribusi->m_perhitungan;
        $data['hitManualRet'] = $this->sqlRet($permohonan->pendaftaran_id);

        $data['tglperiksa'] = $permohonan->d_survey;
        $data['id_bap'] = $bap->id;
        $data['nobap'] = $bap->bap_id;
        $data['tglbap'] = $bap->bap_id;
        $data['status'] = $bap->status_bap;
        $data['ditetapkan'] = $bap->c_penetapan;
        $data['retribusi'] = $bap->nilai_retribusi;
       // $data['nosk'] = $sk->no_surat;
		$data['id_sk'] = $sk->id;
        if($sk->no_surat_edit == "") {
		    $data['noskedit'] = $sk->no_surat;
	    } else {
			$data['noskedit'] = $sk->no_surat_edit;
		}
		//$data['tglsk'] = $sk->tgl_surat;
        if($sk->tgl_surat_edit == "0000-00-00") {
		    $data['tglterbit'] = $sk->tgl_surat;
	    } else {
			$data['tglterbit'] = $sk->tgl_surat_edit;
		}
		$data['tglsk'] = $sk->tgl_surat;
		$now = $sk->tgl_surat;
        $tgl_before = $this->lib_date->set_date($now, +720);
		$data['tglmasaberlaku'] = $tgl_before;
//		$data['tglambil'] = $sk->tgl_ambil1;
		$data['tglambil'] = $this->lib_date->get_date_now();
		$data['kontak'] = $sk->kontak;

        //cek data
        
        $index = $koefesientarifretribusi->index_kategori;

        $data['indexcba'] = $index;
        $data['xx'] = $idizin;
        $data['yy'] = $k_property;

		$js_date = "
            $(document).ready(function() {
                    oTable = $('#sk').dataTable({
                            \"bJQueryUI\": true,
                            \"sPaginationType\": \"full_numbers\"
                    });
            } );
            $(function() {
                $(\".monbulan\").datepicker({
                    changeMonth: true,
                    changeYear: true,
                    dateFormat: 'yy-mm-dd',
                    closeText: 'X'
                });
            });
            ";
        $this->template->set_metadata_javascript($js_date);

		$this->load->vars($data);
        $this->session_info['page_name'] = "Penyerahan Berkas Izin";
        $this->template->build('input_diambil', $this->session_info);
	}

    public function diserahkan() {  // Create PBS
	    $u_ser = $this->session->userdata('username');
		$r_name = $this->lib_date->get_nama_ori($u_ser);

		$permohonan = new tmpermohonan();
        $permohonan->get_by_id($this->input->post('id'));
        $pemohon = $permohonan->tmpemohon->get();

        $status_izin = $permohonan->trstspermohonan->get();

        //$status_skr = "16";                   //Penyerahan Izin [Lihat Tabel trstspermohonan()] => old kominfo 13
        $id_status = "17";                    //Arsip [Lihat Tabel trstspermohonan()]           => old kominfo 14
        //if ($status_izin->id == $status_skr) {
			$cek_sk = $this->input->post('id_sk');
            $sk = new tmsk();
            $sk->get_by_id($cek_sk);
	    	$sk->tgl_ambil1 = $this->input->post('tglambil');
            $sk->kontak = $this->input->post('kontak');
            $sk->save();

			$permohonan->d_ambil_izin = $this->lib_date->get_date_now();
            $permohonan->c_izin_selesai = '1';
			$permohonan->kd_status = 9; // ubah kd_status menjadi 9 ( sudah diserahkan ) atau 17 di sts_permohonan
            $update = $permohonan->save();

            /* Input Data Tracking Progress */
            $tracking_izin = new tmtrackingperizinan();
		    $tracking_izin->where('pendaftaran_id', $permohonan->pendaftaran_id)
			              ->where('tr_activiti', 'Penyerahan Izin')->get();
    		if($tracking_izin->pendaftaran_id){
				$tracking_izin->status = 'Update';
                $tracking_izin->d_entry = $this->lib_date->get_date_now();
                $tracking_izin->tr_user = $u_ser;
                $tracking_izin->tr_name = $r_name;
    			$hit_ubah = $tracking_izin->hit_ubah + 1;
	            $his_ubah = $tracking_izin->his_ubah;
	            $tracking_izin->hit_ubah = $hit_ubah;
	            $tracking_izin->his_ubah = $his_ubah.'DISERAHKAN^'.$r_name.'^'.$this->lib_date->get_date_now().';';
                $tracking_izin->save();             // hanya edit di tracking_izin
            }

            $sts_izin2 = new trstspermohonan();
            $sts_izin2->get_by_id($id_status); //[Lihat Tabel trstspermohonan()]
            $sts_izin2->save($permohonan);
        //}

        if (!$update) {
            echo '<p>' . $update->error->string . '</p>';
        } else {
            $tgl = date("Y-m-d H:i:s");
            $u_ser = $this->session->userdata('username');
            $g = $this->sql($u_ser);
            //$p = $this->db->query("call log ('Penyerahan Izin','Penyerahan izin ".$permohonan->pendaftaran_id."','".$tgl."','".$u_ser."')");
			redirect('pelayanan/ambilsk/list_index');
        }
    }

    public function diambil_old($id_daftar = NULL, $tgla = NULL, $tglb = NULL) {    // diganti dengan func diserahkan
        $permohonan = new tmpermohonan();
        $permohonan->get_by_id($id_daftar);
        $permohonan->d_ambil_izin = $this->lib_date->get_date_now();
        $permohonan->c_izin_selesai = '1';
        $update = $permohonan->save();
        $pemohon = $permohonan->tmpemohon->get();

        $status_izin = $permohonan->trstspermohonan->get();

        $status_skr = "16";                   //Penyerahan Izin [Lihat Tabel trstspermohonan()] => old kominfo 13
        $id_status = "17";                    //Arsip [Lihat Tabel trstspermohonan()]           => old kominfo 14
        if ($status_izin->id == $status_skr) {
            /* Input Data Tracking Progress */
            $sts_izin = new trstspermohonan();
            $sts_izin->get_by_id($status_skr);
            $data_status = new tmtrackingperizinan_trstspermohonan();
            $list_tracking = $permohonan->tmtrackingperizinan->get();
            if ($list_tracking) {
                $tracking_id = 0;
                foreach ($list_tracking as $data_track) {
                    $data_status = new tmtrackingperizinan_trstspermohonan();
                    $data_status->where('tmtrackingperizinan_id', $data_track->id)
                            ->where('trstspermohonan_id', $sts_izin->id)->get();
                    if ($data_status->tmtrackingperizinan_id) {
                        $tracking_id = $data_status->tmtrackingperizinan_id;
                    }
                }
            }
            $tracking_izin = new tmtrackingperizinan();
            $tracking_izin->get_by_id($tracking_id);

            //$tracking_izin->pendaftaran_id = $permohonan->pendaftaran_id;
            $tracking_izin->status = 'Update';
            $tracking_izin->d_entry = $this->lib_date->get_date_now();
            $tracking_izin->save();

            /* [Lihat Tabel trstspermohonan()] */
            $tracking_izin2 = new tmtrackingperizinan();
            $tracking_izin2->pendaftaran_id = $permohonan->pendaftaran_id;
            $tracking_izin2->status = 'Insert';
            $tracking_izin2->d_entry_awal = $this->lib_date->get_date_now();
            $tracking_izin2->d_entry = $this->lib_date->get_date_now();

            $sts_izin2 = new trstspermohonan();
            $sts_izin2->get_by_id($id_status); //[Lihat Tabel trstspermohonan()]
            $sts_izin2->save($permohonan);
            $tracking_izin2->save($permohonan);
            $tracking_izin2->save($sts_izin2);
        }

        if (!$update) {
            echo '<p>' . $update->error->string . '</p>';
        } else {
            $tgl = date("Y-m-d H:i:s");
            $u_ser = $this->session->userdata('username');
            $g = $this->sql($u_ser);
            //$p = $this->db->query("call log ('Penyerahan Izin','Penyerahan izin ".$permohonan->pendaftaran_id."','".$tgl."','".$u_ser."')");
//            redirect('pelayanan/ambilsk/list_index' . '/' . $tgla . '/' . $tglb);
			redirect('pelayanan/ambilsk/list_index');
        }
    }

     public function sql($u_ser) {
        $query = "select a.description from user_auth as a
	              inner join user_user_auth as  x on a.id = x.user_auth_id
	              inner join user as b on b.id = x.user_id
                  where b.id = (select id from user where username='".$u_ser."')";
        $hasil = $this->db->query($query);
        return $hasil->row();
    }

	public function sqlRet($id) {
        $query = "select v_tinjauan from tmproperty_jenisperizinan as a 
                inner join tmpermohonan as b on b.pendaftaran_id=a.pendaftaran_id
                inner join tmproperty_jenisperizinan_trproperty as c on c.tmproperty_jenisperizinan_id=a.id
                inner join trproperty as d on d.id=c.trproperty_id
                where b.pendaftaran_id='".$id."' and d.id='45'";
        
        $hasil = $this->db->query($query);
        return $hasil->row();
        
    }

}

// This is the end of role class