<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Description of pesan class
 *
 * @author  Yogi Cahyana
 * @since   1.0
 *
 */

class Pesan extends WRC_AdminCont {

    public function __construct() {
        parent::__construct();
        $this->pengaduan = new tmpesan();
        $this->stspesan = new trstspesan();
        $this->propinsi = new trpropinsi();
        $this->kabupaten = new trkabupaten();
        $this->kecamatan = new trkecamatan();
        $this->kelurahan = new trkelurahan();
		$this->permohonan = new tmpermohonan();
		$this->load->library('email');
		$this->load->library('fpdf');
        $enabled = FALSE;
        $list_auths = $this->session_info['app_list_auth'];
        $this->pesan = NULL;

        foreach ($list_auths as $list_auth) {
            if($list_auth->id_role === '14') {
                $enabled = TRUE;
                $this->pesan = new user_auth();
            }
        }

        if(!$enabled) {
            redirect('dashboard');
        }
    }

    public function index() {
        $data['list'] = $this->pengaduan->where("c_tindak_lanjut <> 'Hapus' AND c_stat_hapus <> 1" )->order_by('id', 'desc')->get();
        $data['liststspesan'] = $this->stspesan->get();

        $this->load->vars($data);

        $js =  "
		        function confirm_link(text){
                    if(confirm(text)){ 
						return true;
                    } else { 
						return false; 
					}
                }

                $(document).ready(function() {
                    oTable = $('#pesan').dataTable({
                             \"bJQueryUI\": true,
                             \"sPaginationType\": \"full_numbers\"
                    });
                } );

               $(function() {
                $(\".pesan\").datepicker({
                    changeMonth: true,
                    changeYear: true,
                    dateFormat: 'yy-mm-dd',
                    closeText: 'X'
                });
            });
        ";

        $this->template->set_metadata_javascript($js);
        $this->session_info['page_name'] = "Daftar pengaduan / saran";
        $this->template->build('list', $this->session_info);
    }

    public function create() {
        // menampilakan combobox
        $data = $this->_funcwilayah();
        $status = new trstspesan();
//        $data['list_status'] = $status->get();
		$data['list_status'] = $status->order_by('urutan','ASC')->get();
        $sumber = new trsumber_pesan();
        $data['list_sumber'] = $sumber->get();
        $data['propinsi_usaha'] = "";
        $data['kabupaten_usaha'] = "";
        $data['nomor_permohonan']  = "";
		$data['jns_pengaduan']  = "";

        $data['e_pesan']  = "";
        $data['RbTindakLanjut']  = "";
        $data['d_entry']  = "";
        $data['nama']  = "";
        $data['alamat']  = "";
        $data['telp']  = "";
		$data['no_hp']  = "";
		$data['n_email']  = "";
        $data['kelurahan_usaha']  = "";
        $data['kecamatan_usaha']  = "";
        $data['tmpesan_id']  = "";
        $data['tmpesan_id']  = "";
        $data['save_method'] = "save";

        $js =  "
                $(document).ready(function() {
                    $('#form').validate();
                    $(\"#tabs\").tabs();
                } );

                $(function() {
                    $(\"#pesan\").datepicker({
                        changeMonth: true,
                        changeYear: true,
                        dateFormat: 'yy-mm-dd',
                        closeText: 'X'
                    });
                });
   
                $(document).ready(function() {
                    $('#propinsi_pemohon_id').change(function(){
                        $.post('".base_url()."pelayanan/pendaftaran/kabupaten_pemohon', { propinsi_id: $('#propinsi_pemohon_id').val() },
                            function(data) {
                                $('#show_kabupaten_pemohon').html(data);
                                $('#show_kecamatan_pemohon').html('Data Tidak tersedia');
                                $('#show_kelurahan_pemohon').html('Data Tidak tersedia');
                            }
                        );
                    }); 
                });
                
                function finishAjax(id, response){
                    $('#'+id).html(unescape(response));
                    $('#'+id).fadeIn();
                }

                function Check(chk){
                    if(document.myform.Check_ctr.checked==true){
                        for (i = 0; i < chk.length; i++)
                            chk[i].checked = true ;
                    } else {
                        for (i = 0; i < chk.length; i++)
                            chk[i].checked = false ;
                    }
                }
        ";

        $this->template->set_metadata_javascript($js);
        $this->load->vars($data);
        $this->session_info['page_name'] = "Tambah Pengaduan";
        $this->template->build('create', $this->session_info);
    }

    public function save() {
        $username = new user();
        $username->where('username', $this->session->userdata('username'))->get();
        $id_user = $username->id;

		$this->pengaduan->jns_pengaduan = $this->input->post('status_pesan');
        $this->pengaduan->pendaftaran_id = $this->input->post('nomor_permohonan');
		$this->pengaduan->e_pesan = $this->input->post('e_pesan');
        $this->pengaduan->c_tindak_lajut = $this->input->post('RbTindakLanjut');
        $this->pengaduan->nama = $this->input->post('nama');
        $this->pengaduan->telp = $this->input->post('telp');
		$this->pengaduan->no_hp = $this->input->post('no_hp');
		$this->pengaduan->email = $this->input->post('n_email');
        $this->pengaduan->pendaftaran_id = $this->input->post('nomor_permohonan');
		$this->pengaduan->n_izin = $this->input->post('n_izin');
        $sumber = new trsumber_pesan();
        $sumber->get_by_id($this->input->post('sumber_pesan'));
        $status = new trstspesan();
        $status->get_by_id($this->input->post('status_pesan'));
        $this->pengaduan->alamat = $this->input->post('alamat');
        $this->pengaduan->kelurahan = $this->input->post('kelurahan_pemohon');
        $this->pengaduan->kecamatan = $this->input->post('kecamatan_pemohon');
        $this->pengaduan->d_entry = $this->input->post('d_entry');
		$this->pengaduan->i_entry = $id_user;
        if(! $this->pengaduan->save($status)) {
            echo '<p>' . $this->pengaduan->error->string . '</p>';
        }
       
		if(! $this->pengaduan->save($sumber)) {
            echo '<p>' . $this->pengaduan->error->string . '</p>';
        } else {
            $tgl = date("Y-m-d H:i:s");
            $u_ser = $this->session->userdata('username');
            $g = $this->sql2($u_ser);
            //$p = $this->db->query("call log ('Daftar Pengaduan / Saran','Insert ".$this->input->post('nama')."','".$tgl."','".$u_ser."')");
            redirect('pesan');
        }
    }

    public function edit($kd = NULL, $lht = NULL, $id_pesan = NULL) {
        $username = new user();
        $username->where('username', $this->session->userdata('username'))->get();
        $this->lib_date->post_variable($username->id, $kd, $lht, $id_pesan, '', '', '', '', '', '', '');   // post variable

        $data = $this->_funcwilayah();
        $this->pengaduan->where('id', $id_pesan);
        $this->pengaduan->get();
        $sumber_id = $this->pengaduan->trsumber_pesan->get();
        $status_id = $this->pengaduan->trstspesan->get();
        
        $idKelurahan =  $this->pengaduan->kelurahan;
        $u_kelurahan = $this->kelurahan->get_by_id($idKelurahan);
        $u_kecamatan = $u_kelurahan->trkecamatan->get();
        $u_kabupaten = $u_kelurahan->trkecamatan->trkabupaten->get();
        $u_propinsi  = $u_kelurahan->trkecamatan->trkabupaten->trpropinsi->get();
        
        $status = new trstspesan();
        $data['list_status'] = $status->order_by('urutan','ASC')->get()->all;
        $sumber = new trsumber_pesan();
        $data['list_sumber'] = $sumber->get();
        $data['RbTindakLanjut'] = $this->pengaduan->c_tindak_lanjut;
        $data['id'] = $this->pengaduan->id;
        $data['e_pesan'] = $this->pengaduan->e_pesan;
		$data['jenis'] = $this->pengaduan->jns_pengaduan;
        $data['nomor'] = $this->pengaduan->pendaftaran_id;
        $data['nama'] = $this->pengaduan->nama;
        $data['telp'] = $this->pengaduan->telp;
		$data['no_hp'] = $this->pengaduan->no_hp;
		$data['n_email'] = $this->pengaduan->email;
        $data['alamat'] = $this->pengaduan->alamat;
		$data['tgl_jawab'] = $this->pengaduan->tgl_jawab;
		$data['laporan_kirim'] = $this->pengaduan->laporan_kirim;
        $data['petugas_jawab'] = $this->pengaduan->petugas_jawab;
        $data['e_pesan_koreksi'] = $this->pengaduan->e_pesan_koreksi;
		$data['kelurahan_usaha'] = $this->pengaduan->kelurahan;
		$data['n_kelurahan_usaha'] = $u_kelurahan->n_kelurahan;
        $data['kecamatan_usaha'] = $this->pengaduan->kecamatan;
		$data['n_kecamatan_usaha'] = $u_kecamatan->n_kecamatan;
        $data['propinsi_usaha'] = $u_propinsi->id;
		$data['n_propinsi_usaha'] = $u_propinsi->n_propinsi;
        $data['kabupaten_usaha'] = $u_kabupaten->id;
		$data['n_kabupaten_usaha'] = $u_kabupaten->n_kabupaten;
        $data['sumber_pesan'] = $sumber_id->id;
        $data['status_pesan'] = $status_id->id;
        $data['list_kelurahan'] = $this->kelurahan->order_by('n_kelurahan','ASC')->get();
        $data['lht'] = $lht;
        $pesan = '';
        if($lht == '0') {
            $pesan .= 'Tasikmalaya, '.$this->lib_date->mysql_to_human($this->lib_date->get_date_now())."\n"."\n".'Menindaklanjuti Pengaduan Bpk/Ibu : '.$this->pengaduan->nama."\n".
                      'Tentang : '.$this->pengaduan->e_pesan."\n".'Dengan ini kami sampaikan : ';
		} else {
            $pesan = $this->pengaduan->jwb_langsung;
		}

        $data['e_pesan_jawab'] = $pesan; 
		
        $js_date = "
                    $(document).ready(function() {
                        $(\"#tabs\").tabs();
                        $('#form').validate();
                    });
            
                    $(function() {
                        $(\"#pesan\").datepicker({
                            changeMonth: true,
                            changeYear: true,
                            dateFormat: 'yy-mm-dd',
                            closeText: 'X'
                        });
                    });
            
                    $(document).ready(function() {
                        $('#propinsi_pemohon_id').change(function(){
                            $.post('".base_url()."pelayanan/pendaftaran/kabupaten_pemohon', { propinsi_id: $('#propinsi_pemohon_id').val() },
                                function(data) {
                                    $('#show_kabupaten_pemohon').html(data);
                                    $('#show_kecamatan_pemohon').html('Data Tidak tersedia');
                                    $('#show_kelurahan_pemohon').html('Data Tidak tersedia');
                                }
					        );
                        });
                    });

                    function finishAjax(id, response){
                        $('#'+id).html(unescape(response));
                        $('#'+id).fadeIn();
                    }
               ";
            
        $this->template->set_metadata_javascript($js_date);
        $data['d_entry'] = $this->pengaduan->d_entry;
        if($kd == 1) {
		    $data['save_method'] = "update";
            $this->load->vars($data);
            $this->session_info['page_name'] = "Edit Pengaduan";
            $this->template->build('edit', $this->session_info);
        } else {
    		$data['save_method'] = "jawab_langsung";
            $this->load->vars($data);
            $this->session_info['page_name'] = "Jawab Pengaduan Secara Langsung";
            $this->template->build('edit', $this->session_info);
		}
    }

	public function edit_next() {
        $username = new user();
        $username->where('username', $this->session->userdata('username'))->get();
        $kd = $username->gvar1;
		$lht = $username->gvar2;
		$id_pesan = $username->gvar3;

        $data = $this->_funcwilayah();
        $this->pengaduan->where('id', $id_pesan);
        $this->pengaduan->get();
        $sumber_id = $this->pengaduan->trsumber_pesan->get();
        $status_id = $this->pengaduan->trstspesan->get();
        
        $idKelurahan =  $this->pengaduan->kelurahan;
        $u_kelurahan = $this->kelurahan->get_by_id($idKelurahan);
        $u_kecamatan = $u_kelurahan->trkecamatan->get();
        $u_kabupaten = $u_kelurahan->trkecamatan->trkabupaten->get();
        $u_propinsi  = $u_kelurahan->trkecamatan->trkabupaten->trpropinsi->get();
        
        $status = new trstspesan();
        $data['list_status'] = $status->order_by('urutan','ASC')->get()->all;
        $sumber = new trsumber_pesan();
        $data['list_sumber'] = $sumber->get();
        $data['RbTindakLanjut'] = $this->pengaduan->c_tindak_lanjut;
        $data['id'] = $this->pengaduan->id;
        $data['e_pesan'] = $this->pengaduan->e_pesan;
		$data['jenis'] = $this->pengaduan->jns_pengaduan;
        $data['nomor'] = $this->pengaduan->pendaftaran_id;
        $data['nama'] = $this->pengaduan->nama;
        $data['telp'] = $this->pengaduan->telp;
		$data['no_hp'] = $this->pengaduan->no_hp;
		$data['n_email'] = $this->pengaduan->email;
        $data['alamat'] = $this->pengaduan->alamat;
		$data['tgl_jawab'] = $this->pengaduan->tgl_jawab;
		$data['laporan_kirim'] = $this->pengaduan->laporan_kirim;
        $data['petugas_jawab'] = $this->pengaduan->petugas_jawab;
        $data['e_pesan_koreksi'] = $this->pengaduan->e_pesan_koreksi;
		$data['kelurahan_usaha'] = $this->pengaduan->kelurahan;
		$data['n_kelurahan_usaha'] = $u_kelurahan->n_kelurahan;
        $data['kecamatan_usaha'] = $this->pengaduan->kecamatan;
		$data['n_kecamatan_usaha'] = $u_kecamatan->n_kecamatan;
        $data['propinsi_usaha'] = $u_propinsi->id;
		$data['n_propinsi_usaha'] = $u_propinsi->n_propinsi;
        $data['kabupaten_usaha'] = $u_kabupaten->id;
		$data['n_kabupaten_usaha'] = $u_kabupaten->n_kabupaten;
        $data['sumber_pesan'] = $sumber_id->id;
        $data['status_pesan'] = $status_id->id;
        $data['list_kelurahan'] = $this->kelurahan->order_by('n_kelurahan','ASC')->get();
        $data['lht'] = $lht;
        $pesan = '';
        if($lht == '0') {
            $pesan .= 'Tasikmalaya, '.$this->lib_date->mysql_to_human($this->lib_date->get_date_now())."\n"."\n".'Menindaklanjuti Pengaduan Bpk/Ibu : '.$this->pengaduan->nama."\n".
                      'Tentang : '.$this->pengaduan->e_pesan."\n".'Dengan ini kami sampaikan : ';
		} else {
            $pesan = $this->pengaduan->jwb_langsung;
		}

        $data['e_pesan_jawab'] = $pesan; 
		
        $js_date = "
            $(document).ready(function() {
                $(\"#tabs\").tabs();
                $('#form').validate();
            });
            
			$(function() {
                $(\"#pesan\").datepicker({
                    changeMonth: true,
                    changeYear: true,
                    dateFormat: 'yy-mm-dd',
                    closeText: 'X'
                });
            });
            
			$(document).ready(function() {
                $('#propinsi_pemohon_id').change(function(){
                    $.post('".base_url()."pelayanan/pendaftaran/kabupaten_pemohon', { propinsi_id: $('#propinsi_pemohon_id').val() },
                        function(data) {
                            $('#show_kabupaten_pemohon').html(data);
                            $('#show_kecamatan_pemohon').html('Data Tidak tersedia');
                            $('#show_kelurahan_pemohon').html('Data Tidak tersedia');
                        }
					);
                });
            });

            function finishAjax(id, response){
                $('#'+id).html(unescape(response));
                $('#'+id).fadeIn();
            }
        ";
            
        $this->template->set_metadata_javascript($js_date);
        $data['d_entry'] = $this->pengaduan->d_entry;
        if($kd == 1) {
		    $data['save_method'] = "update";
            $this->load->vars($data);
            $this->session_info['page_name'] = "Edit Pengaduan";
            $this->template->build('edit', $this->session_info);
        } else {
    		$data['save_method'] = "jawab_langsung";
            $this->load->vars($data);
            $this->session_info['page_name'] = "Jawab Pengaduan Secara Langsung";
            $this->template->build('edit', $this->session_info);
		}
    }

    public function update() {
        $update = $this->pengaduan
                       ->where('id', $this->input->post('id'))
                       ->update(array(
                           'id' => $this->input->post('id'),
                           'c_tindak_lanjut' => $this->input->post('RbTindakLanjut'),
                           'nama' => $this->input->post('nama'),
                           'telp' => $this->input->post('telp'),
			               'no_hp' => $this->input->post('no_hp'),
			               'email' => $this->input->post('n_email'),
                           'alamat' => $this->input->post('alamat'),
                           'kecamatan' => $this->input->post('kecamatan_pemohon'),
                           'e_pesan_koreksi' => $this->input->post('e_pesan_koreksi'),
                           'kelurahan' => $this->input->post('kelurahan_pemohon'),
                           'd_entry' => $this->input->post('d_entry')));
        $sumber = new tmpesan_trsumber();
        $sumber->where('tmpesan_id', $this->input->post('id'))
               ->update(array('trsumber_pesan_id' => $this->input->post('sumber_pesan')));

        $status = new tmpesan_trstspesan();
        $status->where('tmpesan_id', $this->input->post('id'))
               ->update(array('trstspesan_id' => $this->input->post('status_pesan')));

        if($update) {
            $tgl = date("Y-m-d H:i:s");
            $u_ser = $this->session->userdata('username');
            $g = $this->sql2($u_ser);
            //$p = $this->db->query("call log ('Daftar Pengaduan/Saran','Update ".$this->input->post('nama')."','".$tgl."','".$u_ser."')");

            redirect('pesan');
        }
    }

    public function jawab_langsung() {
        $n_hp    = $this->input->post('no_hp');
		$n_email = $this->input->post('n_email');
        $n_judul = 'Jawaban Pengaduan';
		$n_pesan = $this->input->post('e_pesan_jawab');
		$jum_in_pesan = $this->input->post('jum_char_pesan');
        
        $username = new user();
        $username->where('username', $this->session->userdata('username'))->get();
        $user = $username->oriname;
        $update = $this->pengaduan
                       ->where('id', $this->input->post('id'))
                       ->update(array(
                           'petugas_jawab' => $user,
			               'tgl_jawab' => date("Y-m-d H:i:s"),
                           'jwb_langsung' =>$n_pesan,
			               'laporan_kirim' =>'Telah Terkirim',));

		// Kirim ke media SMS  via gammu dan e-mail via PHPMailer()
		// Kirim ke media SMS  via gammu
    	$this->settings->where('name', 'smsGateway')->get();
        if($this->settings->status == 1){
		    $gammu   = $this->load->database('gammu', TRUE);   // the TRUE paramater tells CI that you'd like to return the database object.
		    $data = array(     // Isi data untuk sms hanya 158 char
		       'DestinationNumber'	=> $n_hp,
		       'TextDecoded'		=> 'DPMPTSP.Pengaduan: '.substr($n_pesan,$jum_in_pesan,158-32).'..<lihat-email>',
		       // 'CreatorID' 			=> "Gammu",
		    );
		    $gammu->insert('outbox',$data);
		}


		// Kirim ke media e-mail via PHPMailer()
		$this->settings->where('name', 'send_mail')->get();
        if($this->settings->status == 1){
		    $host             =	"smtp.gmail.com";
		    $emailpengirim    =	"dpmptsptasikmalaya@gmail.com";
		    $namapengirim     =	"DPMPTSP tasikmalaya";
		    $password         =	"~dpmptsptasikmalayakabgoid#";
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

		redirect('pesan');
	}

    public function sementara() {
		
	}

	public function jawab_langsungOLD() {
        $n_hp    = $this->input->post('no_hp');
		$n_email = $this->input->post('n_email');
		$n_pesan = $this->input->post('e_pesan_jawab');

		$this->load->library('email');
        echo "testing sending email with sendmail method".
        $config['protocol'] = 'smtp';                       //sendmail
        $config['mailtype'] = 'text';
        $config['charset']='utf-8'; 
        $config['newline']="\r\n";                  
        $config['multipart'] = 'mixed';	                    // "mixed" (in the body) or "related" (separate)
        $config['smtp_host'] = 'ssl://smtp.googlemail.com';	// SMTP Server.  Example: mail.earthlink.net
        $config['smtp_user'] = 'bpptprovtasikmalaya@gmail.com';	// SMTP Username
        $config['smtp_pass'] = 'xxxx';		                // SMTP Password
        $config['smtp_port'] = 465;		                    // SMTP Port
		$config['smtp_timeout']='30';
        $config['wordwrap'] = TRUE;
        $this->email->initialize($config);
        $this->email->from('bpptprovtasikmalaya@gmail.com', 'KPPT Kota Cimahi');
		$this->email->to($n_email);
        //$this->email->to('pamudi1694@yahoo.com');
        //$this->email->cc('pamudi1694@tasikmalayakab.go.id');
        //$this->email->cc('denirusyana@gmail.com');
        //$this->email->bcc('xx@gmail.com');
        $this->email->subject('Jawaban Pengaduan');
        $this->email->message($n_pesan);
        $this->email->send();
        //echo $this->email->print_debugger();   // menampilakan informasi pengiriman
        //$laporan = $this->email->print_debugger();
	    $laporan = $this->email->laporan_debugger();

		$username = new user();
        $username->where('username', $this->session->userdata('username'))->get();
        $user = $username->oriname;
        $update = $this->pengaduan
                       ->where('id', $this->input->post('id'))
                       ->update(array(
                           'petugas_jawab' => $user,
			               'tgl_jawab' => date("Y-m-d H:i:s"),
                           'jwb_langsung' =>$n_pesan,
			               'laporan_kirim' =>'',));

		redirect('pesan');
    }

    public function cek_detail($id_permohonan = NULL) {
        $this->permohonan->where('pendaftaran_id', $id_permohonan)->get();
		$id_pemohon = $this->permohonan->id;
        if($id_pemohon == "") {
			if($id_permohonan == "")
			    echo "Data tidak ditemukan ";
			else
				echo "Data dengan nomor permohonan $id_permohonan tidak ditemukan ";
			echo anchor(site_url('pesan'), 'KEMBALI');
		} else {
			redirect('arsip/edit' .'/L/'. $id_pemohon.'/2');
		}
    }

    public function tanda_hapus($pesan_id = NULL) {
		$username = new user();
        $username->where('username', $this->session->userdata('username'))->get();
        $user = $username->realname;
        $update = $this->pengaduan
                       ->where('id', $pesan_id)
                       ->update(array(
                           'petugas_jawab' => $user,
			               'tgl_jawab' => date("Y-m-d H:i:s"),
                           'jwb_langsung' => 'Pesan ini Dihapus',
			               'c_stat_hapus' => '1',));

		redirect('pesan');
    }

    public function cetak_pesan($pesan_id = NULL) {
		$username = new user();
        $username->where('username', $this->session->userdata('username'))->get();
        $user = $username->realname;
        
        // Ambil Logo
		$this->tr_instansi = new Tr_instansi();
        $logo = $this->tr_instansi->get_by_id(23);
        $n_logo = base_url(). 'uploads/logo/logo.png';

		// Ambil Pemerintah 
        $this->tr_instansi = new Tr_instansi();
        $nama_prov = $this->tr_instansi->get_by_id(17)->value;

        // Ambil Badan
        $this->tr_instansi = new Tr_instansi();
        $nama_badan = $this->tr_instansi->get_by_id(9)->value;

        // Ambil Alamat
        $this->tr_instansi = new Tr_instansi();
        $alamat = $this->tr_instansi->get_by_id(12)->value;

		// Ambil Telpon
        $this->tr_instansi = new Tr_instansi();
        $tlp = $this->tr_instansi->get_by_id(10)->value;

        // Ambil Fax
        $this->tr_instansi = new Tr_instansi();
        $fax = $this->tr_instansi->get_by_id(13)->value;

		// Ambil Kota
        $this->tr_instansi = new Tr_instansi();
        $kota = $this->tr_instansi->get_by_id(19)->value;

		// Ambil Kode Pos
        $this->tr_instansi = new Tr_instansi();
        $kdpos = $this->tr_instansi->get_by_id(20)->value;

		// Ambil web
        $this->tr_instansi = new Tr_instansi();
        $web = $this->tr_instansi->get_by_id(21)->value;

		// Ambil e-mail
        $this->tr_instansi = new Tr_instansi();
        $e_mail = $this->tr_instansi->get_by_id(22)->value;
        
        $alamat = $alamat . ' Tlp. ' . $tlp . ', Fax. ' . $fax;
        $alamat2 = 'Website: ' . $web . '   e-mail: ' . $e_mail;
		$alamat3 = strtoupper($kota) . ' - ' . $kdpos;

		$pdf = new FPDF();
		$pdf->SetMargins(1,1);
		$pdf->AddPage();
		$pdf->SetFont('Arial','B',14);
		$pdf->Image($n_logo,10,7,18);
		$pdf->Ln(9); $pdf->Cell(0,0.5,$nama_prov,0,1,'C');
		$pdf->Ln(4); $pdf->Cell(0,0.5,$nama_badan,0,1,'C');
		$pdf->SetFont('Arial','B',10);
		$pdf->Ln(4); $pdf->Cell(0,0.5,$alamat,0,1,'C');
		$pdf->Ln(3); $pdf->Cell(0,0.5,$alamat2,0,1,'C');
		$pdf->Ln(3.5); $pdf->Cell(0,0.5,$alamat3,0,1,'C');
        $pdf->SetLineWidth(0.5); $pdf->Line(10,30,200,30);
		$pdf->SetLineWidth(0.2);

        $pdf->SetFont('Arial','B',12);
		$pdf->Ln(13); $pdf->Cell(0,0.5,'JAWABAN PENGADUAN',0,1,'C');
		$pdf->SetMargins(1,1);

        //perintah untuk mengambil data dari database
		$data = $this->_funcwilayah();
        $this->pengaduan->where('id', $pesan_id);
        $this->pengaduan->get();
        $sumber_id = $this->pengaduan->trsumber_pesan->get();
        $status_id = $this->pengaduan->trstspesan->get();
        
        $idKelurahan =  $this->pengaduan->kelurahan;
        $u_kelurahan = $this->kelurahan->get_by_id($idKelurahan);
        $u_kecamatan = $u_kelurahan->trkecamatan->get();
        $u_kabupaten = $u_kelurahan->trkecamatan->trkabupaten->get();
        $u_propinsi  = $u_kelurahan->trkecamatan->trkabupaten->trpropinsi->get();
        
        $status = new trstspesan();
        $sumber = new trsumber_pesan();
        $nama = $this->pengaduan->nama;
        $telp = $this->pengaduan->telp;
		$no_hp = $this->pengaduan->no_hp;
		$n_email = $this->pengaduan->email;
        $alamat = $this->pengaduan->alamat;
		$tgl_pesan = $this->lib_date->mysql_to_human($this->pengaduan->d_entry);
		$e_pesan = $this->pengaduan->e_pesan;
        $jwb_langsung = $this->pengaduan->jwb_langsung;
        $petugas_jawab = $this->pengaduan->petugas_jawab;

        #tampilkan data
		$pdf->SetFont('Arial','',10);
		$pdf->Ln(10);

        $pdf->Cell(9); $pdf->Cell(30,5,'Nama',0,0,'L');
		$pdf->Cell(6); $pdf->Cell(1,5,':',0,0,'L');
		$pdf->Cell(5); $pdf->MultiCell(145,5,$nama,0,'J');

        $pdf->Ln(5); 
		$pdf->Cell(9); $pdf->Cell(30,5,'Alamat',0,0,'L');
		$pdf->Cell(6); $pdf->Cell(1,5,':',0,0,'L');
		$pdf->Cell(5); $pdf->MultiCell(145,5,$alamat,0,'J');

		$pdf->Ln(5); 
		$pdf->Cell(9); $pdf->Cell(30,5,'Nomor Telpon / HP',0,0,'L');
		$pdf->Cell(6); $pdf->Cell(1,5,':',0,0,'L');
		$pdf->Cell(5); $pdf->MultiCell(145,5,$telp.' / '.$no_hp,0,'J');

		$pdf->Ln(5); 
		$pdf->Cell(9); $pdf->Cell(30,5,'e-mail',0,0,'L');
		$pdf->Cell(6); $pdf->Cell(1,5,':',0,0,'L');
		$pdf->Cell(5); $pdf->MultiCell(145,5,$n_email,0,'J');

		$pdf->Ln(5); 
		$pdf->Cell(9); $pdf->Cell(30,5,'Tanggal Pengaduan',0,0,'L');
		$pdf->Cell(6); $pdf->Cell(1,5,':',0,0,'L');
		$pdf->Cell(5); $pdf->MultiCell(145,5,$tgl_pesan,0,'J');

        $pdf->Ln(5); 
		$pdf->Cell(9); $pdf->Cell(30,5,'Jawaban',0,0,'L');
		$pdf->Cell(6); $pdf->Cell(1,5,':',0,0,'L');
		$pdf->Cell(5); $pdf->MultiCell(145,5,$jwb_langsung,0,'J');

        $pdf->Ln(10); 
		$pdf->Cell(140); $pdf->Cell(30,5,'Bagian Pengaduan,',0,0,'C');
		$pdf->Ln(10);
		$pdf->Cell(140); $pdf->Cell(30,5,'ttd.',0,0,'C');
		$pdf->Ln(10);
		$pdf->Cell(140); $pdf->Cell(30,5,$petugas_jawab,0,0,'C');

        #output file PDF
        $pdf->Output('jawaban.pdf','D');
    }

	public function delete($pesan_id = NULL) {
        $this->pengaduan->where('id', $pesan_id)->get();
        if($this->pengaduan->delete()) {
            redirect('pesan');
        }
    }

    public function filterdata() {
        $this->stspesan->where('id', $this->input->post('sts_pesan'))->get();
        $data['liststspesan'] = $this->stspesan->order_by('id', 'ASC')->get();

        $data['sts_pesan'] = $this->stspesan->get_by_id($this->input->post('sts_pesan'));

        $data['list'] = $this->stspesan->tmpesan->where("c_tindak_lanjut <> 'Hapus'" )->get($this->stspesan);
        $this->load->vars($data);

        $js = "
               $(document).ready(function() {
                   oTable = $('#pesan').dataTable({
                       \"bJQueryUI\": true,
                       \"sPaginationType\": \"full_numbers\"
                   });
               });
              ";

        $this->template->set_metadata_javascript($js);
        $this->session_info['page_name'] = $this->stspesan->n_sts_pesan;
        $this->template->build('view_pesan', $this->session_info);
    }

    public function filPesPerBul($tgla = Null, $tglb = Null) {
//        $tgla = $this->input->post('tgla');
//        $tglb = $this->input->post('tglb');

        $data['list'] = $this->pengaduan->where("c_tindak_lanjut <> 'Hapus' AND d_entry BETWEEN '$tgla' AND '$tglb' " )->get();
        $data['liststspesan'] = $this->stspesan->get();

        $this->load->vars($data);

        $js =  "
                $(document).ready(function() {
                    oTable = $('#pesan').dataTable({
                        \"bJQueryUI\": true,
                        \"sPaginationType\": \"full_numbers\"
                    });
                });

                $(function() {
                    $(\".pesan\").datepicker({
                        changeMonth: true,
                        changeYear: true,
                        dateFormat: 'yy-mm-dd',
                        closeText: 'X'
                    });
                });
               ";

        $this->template->set_metadata_javascript($js);
        $this->session_info['page_name'] = "Manajemen Pesan";
        $this->template->build('view', $this->session_info);
    }

    function _funcwilayah(){
        $data['list_propinsi'] = $this->propinsi->order_by('n_propinsi','ASC')->get();
        $data['list_kabupaten'] = $this->kabupaten->order_by('n_kabupaten','ASC')->get();
        $data['list_kecamatan'] = $this->kecamatan->order_by('n_kecamatan','ASC')->get();
        $data['list_kelurahan'] = $this->kelurahan->order_by('n_kelurahan','ASC')->get();
        return $data;
    }

    public function sql2($u_ser) {
        $query = "select a.description
                  from user_auth as a
                  inner join user_user_auth as  x on a.id = x.user_auth_id
                  inner join user as b on b.id = x.user_id
                  where b.id = (select id from user where username='".$u_ser."')";
        $hasil = $this->db->query($query);
        return $hasil->row();
    }
 }