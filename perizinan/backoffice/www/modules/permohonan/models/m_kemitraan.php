<?php

class M_kemitraan extends Model{

  function __construct() {
    parent::__construct();
  }

  function get_kategori(){
    return $this->db->query("SELECT * FROM `kemitraan`.`sektor_usaha` ORDER BY `sektor_usaha`.`no_urut`  ASC")->result();
  }

  function pegawai_detail($id){
    return $this->db->query("SELECT * FROM `db_sicantik_backoffice`.`tmpegawai` WHERE id LIKE '$id'")->result();
  }

  function pegawai_juara($id_juara){
    $juara = $this->db->select('n_pegawai')
                  ->from('db_sicantik_backoffice.tmpegawai')
                  ->where('no_akses', $id_juara)
                  ->get()->row();
    if(!empty($juara)) {
      return $juara->n_pegawai;
    }else{
      return '';
    }  
  }

  function jum_absen(){
    $juara = $this->db->select('jml_card')
                  ->from('db_sicantik_backoffice.year')
                  ->where('tahun', 2024)
                  ->get()->row();
    if(!empty($juara)) {
      return $juara->jml_card;
    }else{
      return 0;
    }
  }

  public function update_akses($id){
  	$tahun_now = date("Y");
  	$peg = $this->db->select('jml_akses, no_akses')
                ->from('db_sicantik_backoffice.tmpegawai')
                ->where('id', $id)
                ->get()->row();
    $jml_akses = $peg->jml_akses+1;
    $peringkat = $peg->no_akses;
    if($peg->no_akses == 0){	
      $tahun = $this->db->select('jml_card')
                    ->from('db_sicantik_backoffice.year')
                    ->where('tahun', $tahun_now)
                    ->get()->row();
      $jml_card = $tahun->jml_card+1;
      $dt_jml_card = array('jml_card' => $jml_card);
      $this->db->where('tahun', $tahun_now);
      $save = $this->db->update('db_sicantik_backoffice.year', $dt_jml_card); //simpan banyaknya IDCard discan seluruh pegawai per tahu
      $data = array('jml_akses' => $jml_akses, 'no_akses' => $jml_card);
    }else{
      $data = array('jml_akses' => $jml_akses);
    }
    $this->db->where('id', $id);
    $save = $this->db->update('db_sicantik_backoffice.tmpegawai', $data); //simpan banyaknya scan IDCard per pegawai

    //untuk kondisi jumlah mengakses
    $tahun = $this->db->select('akses_card')
                  ->from('db_sicantik_backoffice.year')
                  ->where('tahun', $tahun_now)
                  ->get()->row();
    $akses_card = $tahun->akses_card+1;
    $akses_card = array('akses_card' => $akses_card);
    $this->db->where('tahun', $tahun_now);
    $save = $this->db->update('db_sicantik_backoffice.year', $akses_card); //simpan banyaknya scan IDCard seluruh pegawai per tahun

    //EOF() untuk kondisi jumlah mengakses

    //if($save){
    //  $return = true;
    //}else{
    //  $return = false;
    //}
    return $peringkat;
  }

  function unitkerja($id){
    // var_dump($id);die();
    $surat = $this->db->select('n_unitkerja')
                  ->from('db_sicantik_backoffice.trunitkerja')
                  ->where('id', $id)
                  ->get()->row();
    if(!empty($surat)) {
      return $surat->n_unitkerja;
    }else{
      return 'Undifined Unit';
    }
    // return $this->db->query("SELECT n_unitkerja FROM `db_sicantik_backoffice`.`trunitkerja` WHERE id LIKE '$id' limit 1")->result();
  }

  function koor_tot($id){
    // var_dump($id);die();
    $koor = $this->db->select('nama_tim')
                 ->from('db_sicantik_backoffice.koor_tot')
                 ->where('id_pegawai', $id)
                 ->get()->row();

    if(!empty($koor)) {
      return $koor->nama_tim;
    }else{
      return 0;
    }
    // return $this->db->query("SELECT n_unitkerja FROM `db_sicantik_backoffice`.`trunitkerja` WHERE id LIKE '$id' limit 1")->result();
  }

  function kegiatan_dinas($menu = NULL){
    $this->db->select('*');
    $this->db->from('db_sicantik_backoffice.ruangan_pemakai');
    switch ($menu){
      case "I":
        $this->db->where('tanggal = curdate() && waktu_akhir >=curtime()');
        $this->db->where('status_pembatalan = 0');
        break;
      case "L":
        $this->db->where('tanggal >=', date('Y-m-d',strtotime("-7 days")));
        $this->db->where('tanggal <=', date('Y-m-d',strtotime("yesterday")));
        $this->db->where('status_pembatalan = 0');
        break;
      case "D":
        $this->db->where('tanggal >=', date('Y-m-d',strtotime("tomorrow")));
        $this->db->where('tanggal <=', date('Y-m-d',strtotime("+7 days")));
        $this->db->where('status_pembatalan = 0');
        break;
    }
    $this->db->order_by('waktu_awal', 'asc');
    $query = $this->db->get();
    return $query->result();
  }

  function save_absen($id_peg=null,$id_acara=null){
  	if($id_acara == 0){
     	$return = 'Agenda Tidak Terdefinisi';
    }else{
      $peg = $this->db->select('*')
                  ->from('db_sicantik_backoffice.tmpegawai')
                  ->where('id', $id_peg)
                  ->get()->row();
      $unit = $this->db->select('*')
                  ->from('db_sicantik_backoffice.trunitkerja')
                  ->where('id', $peg->unitkerja_id)
                  ->get()->row();
      $hadir = $this->db->select('*')
                  ->from('db_sicantik_backoffice.absensi_mpp')
                  ->where('kegiatan', $id_acara)
                  ->where('id_pegawai', $id_peg)
                  ->get();
      if($hadir->num_rows() > 0){
      	$return = 'Anda Sudah Isi Absensi';
      }else{
      	if($unit){
      	  $n_unit = $unit->n_unitkerja;
      	}else{
      		$n_unit = 'Jawa Barat';
      	}  
        $data = array('kegiatan'   => $id_acara,
                      'nama'       => $peg->n_pegawai,
                      'gender'     => $peg->gender,
                      'instansi'   => $n_unit,
                      'email'      => $peg->e_mail,
                      'handphone'  => $peg->telepon,
                      'kabupaten'  => 'Kota Bandung',
                      'jabatan'    => $peg->n_jabatan,
                      'id_pegawai' => $id_peg,
                      'sys_absen' => 2
                     );
        $save = $this->db->insert('db_sicantik_backoffice.absensi_mpp', $data);
        if($save){
          $this->db->insert_id();           // Ambil id absen yang baru di insert
          $return = 'Isi Absensi Berhasil';
        }else{
          $return = 'Isi Absensi Gagal';
        }
      }  
    }
    return $return;
  }
  
  function cek_absensi($id_peg=null,$id_acara=null){
    $hadir = $this->db->select('*')
                  ->from('db_sicantik_backoffice.absensi_mpp')
                  ->where('kegiatan', $id_acara)
                  ->where('id_pegawai', $id_peg)
                  ->get();
    if($hadir->num_rows() > 0){
      $return = '✔';;
    }else{
      $return = '';
    }
    return $return;
  }
}
?>