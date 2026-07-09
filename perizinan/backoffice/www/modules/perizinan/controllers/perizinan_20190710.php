<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/** Description of perizinan class
 *  @author  Y; since   1.0
 *  @edit PBS 23-03-2015
 *  data => v_adm    = durasi administrasi 
 *	data => v_teknis = durasi teknis
 *	data => v_terbit = durasi penerbitan
 *	data => v_hari   = total durasi
 */

class Perizinan extends WRC_AdminCont {

  public function __construct() {
    parent::__construct();
    $this->perizinan = new trperizinan();

    $enabled = FALSE;
    $list_auths = $this->session_info['app_list_auth'];

    foreach ($list_auths as $list_auth) {
      if($list_auth->id_role === '1') {
        $enabled = TRUE;
      }
    }

    if(!$enabled) {
      redirect('dashboard');
    }
  }

  public function index() {
    $data['list'] = $this->perizinan->order_by('kd_izin asc')->get();
    $data['list_izin'] = $this->perizinan->get_list();

    $this->load->vars($data);

    $js = "function confirm_link(text){
             if(confirm(text)){ return true;
             }else{ return false; }
           }
           $(document).ready(function() {
             oTable = $('#perizinan').dataTable({
               \"bJQueryUI\": true,
               \"sPaginationType\": \"full_numbers\"
             });
           } );
          ";

    $this->template->set_metadata_javascript($js);
    $this->session_info['page_name'] = "Data Jenis Perizinan";
    $this->template->build('list', $this->session_info);
  }

  public function create() {
    $kabupaten = new trkabupaten();
    $unitkerja = new trunitkerja();
    $kelompok = new trkelompok_perizinan();
    $sektor = new trsektor();
  
    $data['list_kab'] = $kabupaten->order_by('n_kabupaten','ASC')->get()->all;
    $data['list_uk'] = $unitkerja->order_by('n_unitkerja','ASC')->get()->all;
    $data['list_klp'] = $kelompok->order_by('n_kelompok','ASC')->get()->all;
    $data['list_sektor'] = $sektor->order_by('n_sektor','ASC')->get()->all;
  
    $data['kd_izin']  = "";
    $data['n_perizinan']  = "";
    $data['n_perizinan_cetak']  = "";
    $data['kd_indeks']  = "";
    $data['indeks']  = "";
    $data['v_berlaku_tahun'] = "";
    $data['v_perizinan'] = "";
    $data['v_adm'] = "";
    $data['v_teknis'] = "";
    $data['v_hari'] = "";
    $data['is_open'] = "2";
    $data['c_foto'] = "2";
    $data['e_ttd'] = "0";
    $data['e_sertifikat'] = "0";
    $data['c_keputusan'] = "2";
    $data['c_berlaku'] = "2";
    $data['c_aktif'] = "1";
    $data['c_online'] = "1";   // 0:OffLine 1:OnLine
    $data['kelompok_id']  = "";
    $data['unitkerja_id']  = "";
    $data['bid_teknis']  = "";
    $data['sektor_id']  = "";
    $data['save_method'] = "save";
    $data['id'] = "";
    $data['no_sk_awal'] = "";
    $data['no_sk_tengah'] = 0;
    $data['no_sk_akhir'] = "";
    $data['c_in_nomor'] = 0;

    $js =  "
            $(document).ready(function() {
                $('#form').validate();
                $(\"#tabs\").tabs();
            } );
        ";
    $this->template->set_metadata_javascript($js);

    $this->load->vars($data);
    $this->session_info['page_name'] = "Tambah Jenis Perizinan";
    $this->template->build('edit', $this->session_info);
  }

  /*
   * edit is a method to show page for updating data
   */
  public function edit($id_jnsizin = NULL) {
    $this->perizinan->where('id', $id_jnsizin);
    $this->perizinan->get();
    
    $kelompok = new trkelompok_perizinan();
    $unit = new trunitkerja();
    $sektor = new trkecamatan();
	  $sektor = new trsektor();

    $this->perizinan->trkelompok_perizinan->get();
    $this->perizinan->trunitkerja->get();
    $this->perizinan->trsektor->get();

    $data['list_uk'] = $unit->get();
    $data['list_klp'] = $kelompok->get();
    $data['list_sektor'] = $sektor->get();

    $data['id'] = $this->perizinan->id;
    $data['kd_izin']  = $this->perizinan->kd_izin;
  	$data['n_perizinan'] = $this->perizinan->n_perizinan;
  	$data['n_perizinan_cetak']  = $this->perizinan->n_perizinan_cetak;
	  $data['kd_indeks']  = $this->perizinan->kd_indeks;
	  $data['indeks']  = $this->perizinan->indeks;
    $data['kelompok_id'] = $this->perizinan->trkelompok_perizinan->id;
    $data['unitkerja_id'] = $this->perizinan->trunitkerja->id;
	  $data['bid_teknis']  = $this->perizinan->bid_teknis;
	  $data['sektor_id'] = $this->perizinan->trsektor->id;
    $data['save_method'] = "update";
    $data['v_berlaku_tahun'] = $this->perizinan->v_berlaku_tahun;
    $data['v_hari'] = $this->perizinan->v_hari;
    $data['is_open'] = $this->perizinan->is_open;
    $data['c_foto'] = $this->perizinan->c_foto;
	  $data['e_ttd'] = $this->perizinan->e_ttd;
	  $data['e_sertifikat'] = $this->perizinan->e_sertifikat;
    $data['c_keputusan'] = $this->perizinan->c_keputusan;
    $data['c_berlaku'] = $this->perizinan->c_berlaku;
	  $data['c_aktif'] = $this->perizinan->c_aktif;
	  $data['c_online'] = $this->perizinan->c_online;
    $data['v_perizinan'] = $this->perizinan->v_perizinan;
	  $data['no_sk_awal'] = $this->perizinan->no_sk_awal;
	  $data['no_sk_tengah'] = $this->perizinan->no_sk_tengah;
	  $data['no_sk_akhir'] = $this->perizinan->no_sk_akhir;
	  $data['c_in_nomor'] = $this->perizinan->cara_penomoran;

    $js = "$(document).ready(function(){
             $(\"#tabs\").tabs();
             $('#form').validate();
          })";
    $this->template->set_metadata_javascript($js);

    $this->load->vars($data);
    $this->session_info['page_name'] = "Edit Jenis Perizinan";
    $this->template->build('edit', $this->session_info);
  }

  /**
   * Not yet in use, because of some limit of dataTables
   */
  public function datalist() {
    $this->perizinan->get();
    $this->perizinan->set_json_content_type();
    echo $this->perizinan->json_for_data_table();
  }

  /*
   * Save and update for manipulating data.
   */
  public function save() {
	  $opsi_klp = $this->input->post('opsi_klp');
    if($opsi_klp === '3' || $opsi_klp === '4') {
      $c_tarif = 1;
    } else {
      $c_tarif = 0;
    }
    if($this->input->post('e_ttd')==0) $e_sertifikat=0; else $e_sertifikat=$this->input->post('e_sertifikat');
    $perizinan = new trperizinan();
    $perizinan->kd_izin = $this->input->post('kd_izin');
    $perizinan->n_perizinan = $this->input->post('n_perizinan');
	  $perizinan->n_perizinan_cetak = $this->input->post('n_perizinan_cetak');
	  $perizinan->kd_indeks = $this->input->post('kd_indeks');
	  $perizinan->indeks = $this->input->post('indeks');
    $perizinan->unitkerja_id = $this->input->post('opsi_uk');
	  $perizinan->bid_teknis = $this->input->post('bid_teknis');
	  $perizinan->sektor_id = $this->input->post('opsi_sektor');
    $perizinan->is_open = $this->input->post('is_open');
    $perizinan->c_foto = $this->input->post('c_foto');
	  $perizinan->e_ttd = $this->input->post('e_ttd');
	  $perizinan->e_sertifikat  = $e_sertifikat;
    $perizinan->c_keputusan = $this->input->post('c_keputusan');
    $perizinan->c_berlaku = $this->input->post('c_berlaku');
	  $perizinan->c_aktif = $this->input->post('c_aktif');
    $perizinan->c_online = $this->input->post('c_online');
    $perizinan->v_berlaku_tahun = $this->input->post('v_berlaku_tahun');
    $perizinan->v_hari = $this->input->post('v_hari');
    $perizinan->v_perizinan = $this->input->post('v_perizinan');
    $perizinan->c_tarif = $c_tarif;
	  $perizinan->no_sk_awal = $this->input->post('no_sk_awal');
	  $perizinan->no_sk_tengah = $this->input->post('no_sk_tengah');
	  $perizinan->no_sk_akhir = $this->input->post('no_sk_akhir');
	  $perizinan->cara_penomoran = $this->input->post('c_in_nomor');

    $unitkerja = new trunitkerja();
    $unitkerja->where('id', $this->input->post('opsi_uk'))->get();

    $sektor = new trsektor();
    $sektor->where('id', $this->input->post('opsi_sektor'))->get();

    $kelompok = new trkelompok_perizinan();
    $kelompok->where('id', $this->input->post('opsi_klp'))->get();
    $opsi_klp = $this->input->post('opsi_klp');
    
    if($opsi_klp === '3' || $opsi_klp === '4') {
      $perizinan->c_tarif = 1;
    } else {
      $perizinan->c_tarif = 0;
    }

    if ($perizinan->save(array($unitkerja,$kelompok, $sektor))) {
      $tgl = date("Y-m-d H:i:s");
      $u_ser = $this->session->userdata('username');
      //$p = $this->db->query("call log ('Setting Perizinan','Insert ".$this->input->post('n_perizinan')."','".$tgl."','".$u_ser."')");
      redirect('perizinan');
    } else {
      echo '<p>' . $this->perizinan->error->string . '</p>';
    }
  }

  public function update() {
    $c_tarif = 0;
    
    $opsi_klp = $this->input->post('opsi_klp');

    if($opsi_klp === '3' || $opsi_klp === '4') {
      $c_tarif = 1;
    } else {
      $c_tarif = 0;
    }
    if($this->input->post('e_ttd')==0) $e_sertifikat=0; else $e_sertifikat=$this->input->post('e_sertifikat');
    $update = $this->perizinan
                   ->where('id', $this->input->post('id'))
                   ->update(array('kd_izin'  => $this->input->post('kd_izin'),
                                  'n_perizinan' => $this->input->post('n_perizinan'),
	                                'n_perizinan_cetak' => $this->input->post('n_perizinan_cetak'),
	                                'kd_indeks'  => $this->input->post('kd_indeks'),
	                                'indeks'  => $this->input->post('indeks'),
                                  'is_open' => $this->input->post('is_open'),
                                  'c_foto' => $this->input->post('c_foto'),
                                  'e_ttd' => $this->input->post('e_ttd'),
                                  'e_sertifikat' => $e_sertifikat,
                                  'c_keputusan' => $this->input->post('c_keputusan'),
	                                'bid_teknis' => $this->input->post('bid_teknis'),
                                  'c_berlaku' => $this->input->post('c_berlaku'),
			                            'c_aktif' => $this->input->post('c_aktif'),
                                  'c_online' => $this->input->post('c_online'),
                                  'c_tarif' => $c_tarif,
                                  'v_hari' => $this->input->post('v_hari'),
                                  'v_perizinan' => $this->input->post('v_perizinan'),
                                  'v_berlaku_tahun' => $this->input->post('v_berlaku_tahun'),
	                                'no_sk_awal' => $this->input->post('no_sk_awal'),
	                                'no_sk_tengah' => $this->input->post('no_sk_tengah'),
                                  'no_sk_akhir' => $this->input->post('no_sk_akhir'),
	                                'cara_penomoran' => $this->input->post('c_in_nomor')
                                 )
                           );

    $kel = new trperizinan();
    $kel->where('id', $this->input->post('id'))->get();

    $kel2 = new trkelompok_perizinan();
    $kel2->where('id', $this->input->post('opsi_klp'))->get();

    $kel->save($kel2);

    $table_gen_2 = new trperizinan_trunitkerja();
	  if($table_gen_2->where('trperizinan_id',$this->input->post('id'))->count() < 1) {
      $table_gen_2->trunitkerja_id = $this->input->post('opsi_uk');
      $table_gen_2->trperizinan_id = $this->input->post('id');
      $table_gen_2->save();
    } else {
      $unit = new trunitkerja();
      $unit->where('id', $this->input->post('opsi_uk'))->get();
      $kel->save($unit);
    }

	  $table_gen_3 = new trperizinan_trsektor();
	  if($table_gen_3->where('trperizinan_id',$this->input->post('id'))->count() < 1) {
      $table_gen_3->trsektor_id = $this->input->post('opsi_sektor');
      $table_gen_3->trperizinan_id = $this->input->post('id');
      $table_gen_3->save();
    }else{
      $unit = new trsektor();
      $unit->where('id', $this->input->post('opsi_sektor'))->get();
      $kel->save($unit);
    }

    if($update){
      $tgl = date("Y-m-d H:i:s");
      $u_ser = $this->session->userdata('username');
      //$p = $this->db->query("call log ('Setting Perizinan','Update ".$this->input->post('n_perizinan')."','".$tgl."','".$u_ser."')");
      redirect('perizinan');
    }
  }

  public function delete($id = NULL) {
    $izin = new trperizinan();
    $izin->where('id',$id)->get();
    $izin->delete($id);

    $izin2 = new trperizinan();
    $jml=$izin2->where('id',$id)->count();
    
    if($jml > 0){
      $this->session->set_flashdata('pesan', '<font color=red>' . "Data tidak bisa dihapus karena telah dipakai di modul lain". '!</font><br/>');
      redirect('perizinan');
    }else{
      redirect('perizinan');
      $tgl = date("Y-m-d H:i:s");
      $u_ser = $this->session->userdata('username');
      //$p = $this->db->query("call log ('Setting Perizinan','Delete ".$izin->n_perizinan."','".$tgl."','".$u_ser."')");
      redirect('perizinan');
    }
  }
}