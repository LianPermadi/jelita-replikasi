<?php
/*
 * Created By : Jonas Banurea sani / 25-02-2022
 */

class Perdin extends WRC_AdminCont {


    public function __construct() {
      parent::__construct();
      $this->CI = & get_instance();
      $this->load->model("m_perdin");
      $this->load->library('Lib_date');
	    $base_url = base_url();
      $enabled = FALSE;
  	  $this->All = FALSE;
      $list_auths = $this->session_info['app_list_auth'];
      $rekap = FALSE;
          $enabled = TRUE;

      foreach ($list_auths as $list_auth) {
  			if ($list_auth->id_role === '46') {
        }
  			if ($list_auth->id_role === '18') {
          $this->All = TRUE;
        }
        if ($list_auth->id_role === '51') {
          $this->All = TRUE;
          $rekap = TRUE;
        }
      }

      if (!$enabled) {
          redirect('dashboard');
      }
    }

    public function check_data_pegawai_by_date() {
      $list_izin = $this->input->post('id'); // Daftar pegawai yang dipilih (array ID)
      $tgl_berangkat = $this->input->post('tglberangkat'); // Tanggal keberangkatan
  
      if (empty($list_izin) || empty($tgl_berangkat)) {
          echo json_encode(['status' => false, 'message' => 'Invalid data.']);
          return;
      }
  
      // Convert the comma-separated list to an array (if it's a string)
      if (is_string($list_izin)) {
          $list_izin = explode(',', $list_izin); // Convert the string into an array
      }
  
      // Ambil data pegawai berdasarkan tanggal dan ID
      $result = $this->m_perdin->check_data_pegawai($list_izin, $tgl_berangkat);
      // var_dump($result);die();
  
      if ($result['exists'] == true) {

          echo json_encode(['status' => true, 'exists' => true, 'data' => $result]);
      } else {
          echo json_encode(['status' => true, 'exists' => false]);
      }
    }
  
    public function check_data_pegawai_by_date_double_check($id, $tgl_berangkat) {
      $list_izin = $id; // Daftar pegawai yang dipilih (array ID)
      $tgl_berangkat = $tgl_berangkat; // Tanggal keberangkatan
  
      if (empty($list_izin) || empty($tgl_berangkat)) {
          return ['status' => false, 'message' => 'Invalid data.'];
      }
  
      // Convert the comma-separated list to an array (if it's a string)
      if (is_string($list_izin)) {
          $list_izin = explode(',', $list_izin); // Convert the string into an array
      }
  
      // Ambil data pegawai berdasarkan tanggal dan ID
      $result = $this->m_perdin->check_data_pegawai($list_izin, $tgl_berangkat);
  
      if ($result['exists'] == true) {
          return ['status' => true, 'exists' => true, 'data' => $result];
      } else {
          return ['status' => true, 'exists' => false];
      }
  }
  
    public function testing() {
      $this->template->build('perbaikan', $this->session_info);
    }

    public function index() {
       $now = $this->lib_date->get_date_now();
           $admin = "";
      if ($this->All) { 
        $admin = 1;
      } else {
        $admin = 0;
      }
      // $tgla = (!empty($this->input->post('tgla')) ? $this->input->post('tgla') : $this->lib_date->set_date($now, -60));
      // $tglb = (!empty($this->input->post// Tanggal awal
      $tanggal_awal = date('Y-m-d');
      // Ubah format tanggal
      $tanggal_baru = date('Y-m-d', strtotime($tanggal_awal . ' -1 year'));('tglb') ? $this->input->post('tglb') : $this->lib_date->set_date($now, 30);

       $awalyear =  $tanggal_baru;
       $akhiryear =  $tanggal_awal;
       // var_dump($this->lib_date->set_date($now, -60)));die(); 
      // var_dump($tgla);die();
 	    $tgla = !empty($this->input->post('tgla')) ? $this->input->post('tgla') : $awalyear; 
      $tglb = !empty($this->input->post('tglb')) ? $this->input->post('tglb') :   $akhiryear;


      $tglc = (!empty($this->input->post('tglc')) ? $this->input->post('tglc') : $this->lib_date->set_date($now, -30));
      $tgld = (!empty($this->input->post('tgld')) ? $this->input->post('tgld') : $this->lib_date->set_date($now, 0));

      $mark = $this->input->post('mark');
      $statusizin = $this->input->post('statusizin');
       $iduser = $this->session->userdata('id_auth');

       $data['tgla'] = $tgla;
      $data['tglb'] = $tglb;

      $data['tglc'] = $tglc;
      $data['tgld'] = $tgld;

      $search  = $this->m_perdin->get_data($tgla, $tglb, $admin, $iduser);
        $data['search'] = $search;
  
   
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
             $(document).ready(function() {
              oTable = $('#Jadwal_Perjalanan_Dinas').dataTable({
                \"bJQueryUI\": true,
                \"sPaginationType\": \"full_numbers\"
              });
            });
            $(function() {
               $(\"#tabs\").tabs();
              $(\".monbulan\").datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: 'yy-mm-dd',
                closeText: 'X'
              });
              $('#form').validate();
            });";

      $this->template->set_metadata_javascript($js);
      $this->session_info['page_name'] = "Laporan Perjalanan Dinas (e-perdin)";
      $this->template->build('perdin_list_remake', $this->session_info);
    }



    // public function cetak_excel($tgla = 0, $tglb = 0){
    //        $iduser = $this->session->userdata('id_auth');
    //         if ($this->All) { 
    //           $admin = 1;
    //         } else {
    //           $admin = 0;
    //         }
    //   if ($admin == 1 || $iduser == 197 || $iduser == 218 || $iduser == 550 || $iduser == 543 || $iduser == 683) {

    //     $sql = "SELECT *
    //             FROM keu_perdin
    //             WHERE DATE(tgl_pembayaran) BETWEEN ? AND ?
    //             ORDER BY tgl_pembayaran ASC";

    //     $list_perdin = $this->db->query($sql, array($tgla, $tglb))->result();

    //     // kalau kosong → ambil dari keu_perdin_2024
    //     if (empty($list_perdin)) {
    //         $sql = "SELECT *
    //                 FROM keu_perdin_2024
    //                 WHERE DATE(tgl_pembayaran) BETWEEN ? AND ?
    //                 ORDER BY tgl_pembayaran ASC";

    //         $list_perdin = $this->db->query($sql, array($tgla, $tglb))->result();
    //     }

    //     // var_dump($list_perdin); die();

    //   } else {

    //     $sql = "SELECT *
    //             FROM keu_perdin
    //             WHERE DATE(tgl_pembayaran) BETWEEN ? AND ?
    //               AND (user_id = ? OR user_id = 443)
    //             ORDER BY tgl_pembayaran ASC";

    //     $list_perdin = $this->db->query($sql, array($tgla, $tglb, $iduser))->result();

    //     // kalau kosong → ambil dari keu_perdin_2024
    //     if (empty($list_perdin)) {
    //         $sql = "SELECT *
    //                 FROM keu_perdin_2024
    //                 WHERE DATE(tgl_pembayaran) BETWEEN ? AND ?
    //                   AND (user_id = ? OR user_id = 443)
    //                 ORDER BY tgl_pembayaran ASC";

    //         $list_perdin = $this->db->query($sql, array($tgla, $tglb, $iduser))->result();
    //     }

    //     // var_dump($list_perdin); die();
    //   }

          
            
    //         header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
    //         header("Content-Disposition: attachment; filename=REKAP_E-PERDIN_FORMAT_BPK_(DPMPTSP_JABAR).xls");
    //         header("Expires: 0");
    //         header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    //         header("Cache-Control: private",false);

    //         echo "<table width='100%' border='0' font-size:15px;font-style:bold;'>";
    //         echo "E-PERDIN (REKAP PERJALANAN DINAS) DPMPTSP JAWA BARAT (FORMAT BPK)";
    //         echo "<tr>PERIODE : ".$this->lib_date->mysql_to_human($tgla)." - ".$this->lib_date->mysql_to_human($tglb)."</tr>";
    //         echo "</table>";
           	

    //        	 $jd2= " <tr>
    //                   <td colspan='8'>".''."</td>
    //                   <td colspan='39' align='center'>".'Biaya Perjalanan Dinas perorangan (Rp)'."</td>
    //                   <td colspan='4'>".''."</td>
    //                   <td colspan='20' align='center'>".'Informasi Tiket Perjalanan Dinas'."</td>
    //                   <td colspan='2'>".''."</td>
                
                                        
    //                 </tr>";
    //                   // echo "<table width='100%' border='0' align='center' font-size:16px;'>";
    //                    echo "</table>";

    //          echo "<table width='100%' cellspacing='0' cellpadding='0'  border='1' style='border-style:solid; border-width:thin;font-size:14px;font-weight:bold;'>";
    //          echo $jd2; 

    //           $jd3= " <tr>
    //                   <td colspan='8' align='center'>".''."</td>
    //                   <td colspan='4' align='center'>".'Uang Harian'."</td>
    //                   <td colspan='4' align='center'>".'Representasi'."</td>
    //                   <td colspan='4' align='center'>".'Uang Saku Peserta'."</td>
    //                   <td colspan='4' align='center'>".'Penginapan'."</td>
    //                   <td colspan='3' align='center'>".'Tiket/E-Tol'."</td>
    //                   <td colspan='4' align='center'>".'Sewa Taksi (Kota Asal)'."</td>
    //                   <td colspan='4' align='center'>".'Sewa Taksi (Kota Tujuan)'."</td>
    //                   <td colspan='4' align='center'>".'Sewa Kendaraan'."</td>
    //                   <td colspan='4' align='center'>".'BBM'."</td>
    //                   <td colspan='3' align='center'>".'Swab'."</td>
    //                   <td colspan='1' align='center'>".'Jumlah Total'."</td>
    //                   <td colspan='4' align='center'>".''."</td>
    //                   <td colspan='10' align='center'>".'Berangkat'."</td>
    //                   <td colspan='10' align='center'>".'Kembali'."</td>
    //                   <td colspan='2'>".''."</td>

                
                                        
    //                 </tr>";
    //                   // echo "<table width='100%' border='0' align='center' font-size:16px;'>";
    //                    echo "</table>";

    //          echo "<table width='100%' cellspacing='0' cellpadding='0'  border='1' style='border-style:solid; border-width:thin;font-size:12px;font-weight:bold;'>";
    //          echo $jd3; 

 
    //         $jdl= " <tr>
    //                   <td align='center'>".'NO.'."</td>
    //                   <td align='center'>".'Bulan '."</td>
    //                   <td align='center'>".'No BKU'."</td>
    //                   <td align='center'>".'Uraian'."</td>
    //                   <td align='center'>".'Tujuan'."</td>
    //                   <td align='center'>".'Nama Pelaksana'."</td>
    //                   <td align='center'>".'Jabatan'."</td>
    //                   <td align='center'>".'SKPD'."</td>
    //                   <td align='center'>".'Hari'."</td>
    //                   <td align='center'>".'Satuan'."</td>
    //                   <td align='center'>".'Harga'."</td>
    //                   <td align='center'>".'Jumlah'."</td>
    //                   <td align='center'>".'Hari'."</td>
    //                   <td align='center'>".'Satuan'."</td>
    //                   <td align='center'>".'Harga'."</td>
    //                   <td align='center'>".'Jumlah'."</td>
    //                   <td align='center'>".'Hari'."</td>
    //                   <td align='center'>".'Satuan'."</td>
    //                   <td align='center'>".'Harga'."</td>
    //                   <td align='center'>".'Jumlah'."</td>
    //                   <td align='center'>".'Hari'."</td>
    //                   <td align='center'>".'Satuan'."</td>
    //                   <td align='center'>".'Harga'."</td>
    //                   <td align='center'>".'Jumlah'."</td>
    //                   <td align='center'>".'Pulang'."</td>
    //                   <td align='center'>".'Pergi'."</td>
    //                   <td align='center'>".'Jumlah'."</td>
    //                    <td align='center'>".'Hari'."</td>
    //                   <td align='center'>".'Satuan'."</td>
    //                   <td align='center'>".'Harga'."</td>
    //                   <td align='center'>".'Jumlah'."</td>
    //                    <td align='center'>".'Hari'."</td>
    //                   <td align='center'>".'Satuan'."</td>
    //                   <td align='center'>".'Harga'."</td>
    //                   <td align='center'>".'Jumlah'."</td>
    //                    <td align='center'>".'Hari'."</td>
    //                   <td align='center'>".'Satuan'."</td>
    //                   <td align='center'>".'Harga'."</td>
    //                   <td align='center'>".'Jumlah'."</td>
    //                    <td align='center'>".'Liter'."</td>
    //                   <td align='center'>".'Satuan'."</td>
    //                   <td align='center'>".'Harga'."</td>
    //                   <td align='center'>".'Jumlah'."</td>
    //                   <td align='center'>".'Di Kota Asal'."</td>
    //                   <td align='center'>".'Dikota Tujuan'."</td>
    //                   <td align='center'>".'Jumlah'."</td>
    //                   <td align='center'>".'Jumlah Total '."</td>
    //                   <td align='center'>".'No. SPPD'."</td>
    //                   <td align='center'>".'Lama perjalanan dinas (Hari)'."</td>
    //                   <td align='center'>".'Tanggal berangkat '."</td>
    //                   <td align='center'>".'Tanggal kembali'."</td>
    //                   <td align='center'>".'Maskapai'."</td>
    //                   <td align='center'>".'Nama'."</td>
    //                   <td align='center'>".'No Tiket'."</td>
    //                   <td align='center'>".'Kode Booking'."</td>
    //                   <td align='center'>".'No penerbangan'."</td>
    //                   <td align='center'>".'Asal Daerah '."</td>
    //                   <td align='center'>".'Tujuan '."</td>
    //                   <td align='center'>".'Tanggal '."</td>
    //                   <td align='center'>".'Kelas'."</td>
    //                   <td align='center'>".'Harga Tiket (Rp)'."</td>
    //                   <td align='center'>".'Maskapai'."</td>
    //                   <td align='center'>".'Nama'."</td>
    //                   <td align='center'>".'No Tiket'."</td>
    //                   <td align='center'>".'Kode Booking'."</td>
    //                   <td align='center'>".'No penerbangan'."</td>
    //                   <td align='center'>".'Asal Daerah '."</td>
    //                   <td align='center'>".'Tujuan '."</td>
    //                   <td align='center'>".'Tanggal '."</td>
    //                   <td align='center'>".'Kelas'."</td>
    //                   <td align='center'>".'Harga Tiket (Rp)'."</td>
    //                   <td align='center'>".'Nama Penginapan/Hotel'."</td>
    //                   <td align='center'>".'Keterangan'."</td>
                                        
    //                 </tr>";
    //                   // echo "<table width='100%' border='0' font-size:16px;'>";
    //                    echo "</table>";

    //          echo "<table width='100%' cellspacing='0' cellpadding='0' border='1' style='border-style:solid; border-width:thin;font-size:10px;font-weight:bold;'>";
    //          echo $jdl; 

    //           $jd4= " <tr font-style: italic>
    //                  <td align='center'>".'1'."</td>
		// 			<td align='center'>".'2'."</td>
		// 			<td align='center'>".'3'."</td>
		// 			<td align='center'>".'4'."</td>
		// 			<td align='center'>".'5'."</td>
		// 			<td align='center'>".'6'."</td>
		// 			<td align='center'>".'7'."</td>
		// 			<td align='center'>".'8'."</td>
		// 			<td align='center'>".'9'."</td>
		// 			<td align='center'>".'10'."</td>
		// 			<td align='center'>".'11'."</td>
		// 			<td align='center'>".'12=9x11'."</td>
		// 			<td align='center'>".'13'."</td>
		// 			<td align='center'>".'14'."</td>
		// 			<td align='center'>".'15'."</td>
		// 			<td align='center'>".'16=13x15'."</td>
		// 			<td align='center'>".'17'."</td>
		// 			<td align='center'>".'18'."</td>
		// 			<td align='center'>".'19'."</td>
		// 			<td align='center'>".'20=17x19'."</td>
		// 			<td align='center'>".'21'."</td>
		// 			<td align='center'>".'22'."</td>
		// 			<td align='center'>".'23'."</td>
		// 			<td align='center'>".'24=21x23'."</td>
		// 			<td align='center'>".'25'."</td>
		// 			<td align='center'>".'26'."</td>
		// 			<td align='center'>".'27=25+26'."</td>
		// 			<td align='center'>".'28'."</td>
		// 			<td align='center'>".'29'."</td>
		// 			<td align='center'>".'30'."</td>
		// 			<td align='center'>".'31=28x30'."</td>
		// 			<td align='center'>".'32'."</td>
		// 			<td align='center'>".'33'."</td>
		// 			<td align='center'>".'34'."</td>
		// 			<td align='center'>".'35=32x34'."</td>
		// 			<td align='center'>".'36'."</td>
		// 			<td align='center'>".'37'."</td>
		// 			<td align='center'>".'38'."</td>
		// 			<td align='center'>".'39=36x38'."</td>
		// 			<td align='center'>".'40'."</td>
		// 			<td align='center'>".'41'."</td>
		// 			<td align='center'>".'42'."</td>
		// 			<td align='center'>".'43=40x42'."</td>
		// 			<td align='center'>".'44'."</td>
		// 			<td align='center'>".'45'."</td>
		// 			<td align='center'>".'46=44+45'."</td>
		// 			<td align='center'>".'47=12+16+20+24+27+31+35+39+43+46'."</td>
		// 			<td align='center'>".'48'."</td>
		// 			<td align='center'>".'49'."</td>
		// 			<td align='center'>".'50'."</td>
		// 			<td align='center'>".'51'."</td>
		// 			<td align='center'>".'52'."</td>
		// 			<td align='center'>".'53'."</td>
		// 			<td align='center'>".'54'."</td>
		// 			<td align='center'>".'55'."</td>
		// 			<td align='center'>".'56'."</td>
		// 			<td align='center'>".'57'."</td>
		// 			<td align='center'>".'58'."</td>
		// 			<td align='center'>".'59'."</td>
		// 			<td align='center'>".'60'."</td>
		// 			<td align='center'>".'61'."</td>
		// 			<td align='center'>".'62'."</td>
		// 			<td align='center'>".'63'."</td>
		// 			<td align='center'>".'64'."</td>
		// 			<td align='center'>".'65'."</td>
		// 			<td align='center'>".'66'."</td>
		// 			<td align='center'>".'67'."</td>
		// 			<td align='center'>".'68'."</td>
		// 			<td align='center'>".'69'."</td>
		// 			<td align='center'>".'70'."</td>
		// 			<td align='center'>".'71'."</td>
		// 			<td align='center'>".'72'."</td>
		// 			<td align='center'>".'73'."</td>

                                        
    //                 </tr>";
    //                   // echo "<table width='100%' border='0' font-size:16px;'>";
    //                    echo "</table>";

    //          echo "<table width='100%' cellspacing='0' cellpadding='0' border='1' style='border-style:solid; border-width:thin;font-size:10px;font-style:italic;'>";
    //          echo $jd4; 

    //         $i=1;
    //         foreach ($list_perdin as $row){
    //               $isi = "<tr>
    //                     <td>".$i."</td>                        
    //                     <td>".$this->lib_date->set_month_name(date('m',strtotime($row->tgl_pembayaran)), 'id')."</td>
    //                     <td>".$row->no_bku."</td>
    //                     <td>".$row->uraian."</td>
    //                     <td>".$this->m_perdin->get_n_kabupaten($row->tujuan)."</td>
    //                     <td>".$this->m_perdin->get_n_pegawai($row->id_pegawai)."</td>
    //                     <td>".$this->m_perdin->get_n_jabatan($row->id_pegawai)."</td>
    //                     <td>".$row->skpd."</td>

    //                     <td>".$row->uang_hari."</td>
    //                     <td align='center'>".'Hari'."</td>
    //                     <td>".$this->rupiah($row->harga_hari)."</td>
    //                     <td style='background-color:#fce4d6'>".$this->rupiah($row->jumlah_uang)."</td>

    //                     <td>".$row->representasi_hari."</td>
    //                     <td align='center'>".'Hari'."</td>
    //                     <td>".$this->rupiah($row->representasi_harga)."</td>
    //                     <td style='background-color:#fce4d6'>".$this->rupiah($row->jumlah_representasi)."</td>

    //                     <td>".$row->uang_sakuhari."</td>
    //                     <td align='center'>".'Hari'."</td>
    //                     <td>".$this->rupiah($row->uang_sakuharga)."</td>
    //                     <td style='background-color:#fce4d6'>".$this->rupiah($row->uang_sku_p_j)."</td>

    //                     <td>".$row->penginapan_malam."</td>
    //                     <td align='center'>".'Malam'."</td>
    //                     <td>".$this->rupiah($row->penginapan_harga)."</td>
    //                     <td style='background-color:#fce4d6'>".$this->rupiah($row->penginapan_jumlah)."</td>

    //                     <td>".$this->rupiah($row->tikettol_pulang)."</td>
    //                     <td>".$this->rupiah($row->tikettol_pergi)."</td>
    //                     <td style='background-color:#fce4d6'>".$this->rupiah($row->tikettol_jumlah)."</td>

    //                     <td>".$row->s_t_k_asal_hari."</td>
    //                     <td align='center'>".'Kali'."</td>
    //                     <td>".$this->rupiah($row->s_t_k_asal_harga)."</td>
    //                     <td style='background-color:#fce4d6'>".$this->rupiah($row->s_t_k_asal_jumlah)."</td>

    //                     <td>".$row->s_t_k_tujuan_hari."</td>
    //                     <td align='center'>".'Kali'."</td>
    //                     <td>".$this->rupiah($row->s_t_k_tujuan_harga)."</td>
    //                     <td style='background-color:#fce4d6'>".$this->rupiah($row->s_t_k_tujuan_jumlah)."</td>

    //                     <td>".$row->sewa_kendaraan_hari."</td>
    //                     <td align='center'>".'Hari'."</td>
    //                     <td>".$this->rupiah($row->sewa_kendaraan_harga)."</td>
    //                     <td style='background-color:#fce4d6'>".$this->rupiah($row->sewa_kendaraan_jumlah)."</td>

                         
    //                       <td>=\"$row->bbm_liter\"</td>
    //                     <td align='center'>".'Liter'."</td>
    //                     <td>".$this->rupiah($row->bbm_harga)."</td>
    //                     <td style='background-color:#fce4d6'>".$this->rupiah($row->bbm_jumlah)."</td>

    //                     <td>".$this->rupiah($row->swabdi_kota_asal)."</td>
    //                     <td>".$this->rupiah($row->swabdi_kota_tujuan)."</td>
    //                     <td style='background-color:#fce4d6'>".$this->rupiah($row->swab_jumlah)."</td>

    //                     <td style='background-color:#f8cbad'>".$this->rupiah($row->jumlah_total)."</td>

    //                     <td>".$row->no__sppd."</td>
    //                     <td>".$row->lama_p_d."</td>
    //                     <td>".$this->lib_date->mysql_to_human($row->tanggal_berangkat)."</td>
    //                     <td>".$this->lib_date->mysql_to_human($row->tanggal_kembali)."</td>

    //                     <td>".$row->itberangkat_maskapai."</td>
    //                     <td>".$this->m_perdin->get_n_pegawai($row->id_pegawai)."</td>
    //                     <td>".$row->itberangkat_no_tiket."</td>
    //                     <td>".$row->itberangkat_kodebooking."</td>
    //                     <td>".$row->itberangkat_no_penerbangan."</td>
    //                     <td>".$this->m_perdin->get_n_kabupaten($row->itberangkat_asal_daerah)."</td>
    //                     <td>".$this->m_perdin->get_n_kabupaten($row->itberangkat_tujuan)."</td>
    //                     <td>".$this->lib_date->mysql_to_human($row->itberangkat_tanggal)."</td>
    //                     <td>".$row->itberangkat_kelas."</td>
    //                     <td>".$this->rupiah($row->itberangkat_harga_tiket)."</td>

    //                     <td>".$row->itkembali_maskapai."</td>
    //                     <td>".$this->m_perdin->get_n_pegawai($row->id_pegawai)."</td>
    //                     <td>".$row->itkembali_no_tiket."</td>
    //                     <td>".$row->itkembali_kode_booking."</td>
    //                     <td>".$row->itkembali_no_penerbangan."</td>
    //                     <td>".$this->m_perdin->get_n_kabupaten($row->itkembali_asal_daerah)."</td>
    //                     <td>".$this->m_perdin->get_n_kabupaten($row->itberangkat_tujuan)."</td>
    //                     <td>".$this->lib_date->mysql_to_human($row->itberangkat_tanggal)."</td>
    //                     <td>".$row->itberangkat_kelas."</td>
    //                     <td>".$this->rupiah($row->itberangkat_harga_tiket)."</td>                        

    //                     <td>".$row->nama_penginapan."</td>
    //                     <td>".$row->keterangan."</td>
                        

    //               </tr>";

    //                 echo "<table width='100%' cellspacing='0' cellpadding='0' border='1' style='border-style:solid; border-width:thin;font-size:10px;font-style:normal;'>";
    //         echo $isi; 
    //          $i++;
    //       }

    //          echo "</table>";
    // }
    public function cetak_excel_2024($tgla = 0, $tglb = 0){
        $iduser = $this->session->userdata('id_auth');
        if ($this->All) { 
            $admin = 1;
        } else {
            $admin = 0;
        }

        if ($admin == 1 || in_array($iduser, [197, 218, 550, 543, 683])) {
            $sql = "SELECT * FROM keu_perdin
                    WHERE DATE(tgl_pembayaran) BETWEEN ? AND ?
                    ORDER BY tgl_pembayaran ASC";
            $list_perdin = $this->db->query($sql, [$tgla, $tglb])->result();

            if (empty($list_perdin)) {
                $sql = "SELECT * FROM keu_perdin_2024
                        WHERE DATE(tgl_pembayaran) BETWEEN ? AND ?
                        ORDER BY tgl_pembayaran ASC";
                $list_perdin = $this->db->query($sql, [$tgla, $tglb])->result();
            }
        } else {
            $sql = "SELECT * FROM keu_perdin
                    WHERE DATE(tgl_pembayaran) BETWEEN ? AND ?
                      AND (user_id = ? OR user_id = 443)
                    ORDER BY tgl_pembayaran ASC";
            $list_perdin = $this->db->query($sql, [$tgla, $tglb, $iduser])->result();

            if (empty($list_perdin)) {
                $sql = "SELECT * FROM keu_perdin_2024
                        WHERE DATE(tgl_pembayaran) BETWEEN ? AND ?
                          AND (user_id = ? OR user_id = 443)
                        ORDER BY tgl_pembayaran ASC";
                $list_perdin = $this->db->query($sql, [$tgla, $tglb, $iduser])->result();
            }
        }

        // === Load PHPExcel ===
        require_once APPPATH . 'third_party/PHPExcel/Classes/PHPExcel.php';
        $objPHPExcel = new PHPExcel();
        $sheet = $objPHPExcel->setActiveSheetIndex(0);

        // Judul
        $sheet->setCellValue("A1", "E-PERDIN (REKAP PERJALANAN DINAS) DPMPTSP JAWA BARAT (FORMAT BPK)");
        $sheet->mergeCells("A1:S1");
        $sheet->setCellValue("A2", "PERIODE : ".$this->lib_date->mysql_to_human($tgla)." - ".$this->lib_date->mysql_to_human($tglb));

        // Header sesuai echo table
        $header = [
            'NO','Bulan','No BKU','Uraian','Tujuan','Nama Pelaksana','Jabatan','SKPD',
            'Uang Harian','Jumlah','Representasi','Jumlah','Uang Saku','Jumlah',
            'Penginapan','Jumlah','Tiket/E-Tol','Jumlah','Jumlah Total'
        ];

        $col = "A";
        foreach ($header as $h) {
            $sheet->setCellValue($col."4", $h);
            $sheet->getStyle($col."4")->getFont()->setBold(true);
            $sheet->getColumnDimension($col)->setAutoSize(true);
            $col++;
        }

        // Isi data sesuai echo table
        $rowExcel = 5;
        $no = 1;
        foreach($list_perdin as $row){
            $sheet->setCellValue("A".$rowExcel, $no++);
            $sheet->setCellValue("B".$rowExcel, $this->lib_date->set_month_name(date('m',strtotime($row->tgl_pembayaran)), 'id'));
            $sheet->setCellValue("C".$rowExcel, $row->no_bku);
            $sheet->setCellValue("D".$rowExcel, $row->uraian);
            $sheet->setCellValue("E".$rowExcel, $this->m_perdin->get_n_kabupaten($row->tujuan));
            $sheet->setCellValue("F".$rowExcel, $this->m_perdin->get_n_pegawai($row->id_pegawai));
            $sheet->setCellValue("G".$rowExcel, $this->m_perdin->get_n_jabatan($row->id_pegawai));
            $sheet->setCellValue("H".$rowExcel, $row->skpd);
            $sheet->setCellValue("I".$rowExcel, $row->uang_hari);
            $sheet->setCellValue("J".$rowExcel, $row->jumlah_uang);
            $sheet->setCellValue("K".$rowExcel, $row->representasi_hari);
            $sheet->setCellValue("L".$rowExcel, $row->jumlah_representasi);
            $sheet->setCellValue("M".$rowExcel, $row->uang_sakuhari);
            $sheet->setCellValue("N".$rowExcel, $row->uang_sku_p_j);
            $sheet->setCellValue("O".$rowExcel, $row->penginapan_malam);
            $sheet->setCellValue("P".$rowExcel, $row->penginapan_jumlah);
            $sheet->setCellValue("Q".$rowExcel, $row->tikettol_pergi + $row->tikettol_pulang);
            $sheet->setCellValue("R".$rowExcel, $row->tikettol_jumlah);
            $sheet->setCellValue("S".$rowExcel, $row->jumlah_total);

            $rowExcel++;
        }

        // Nama Sheet
        $objPHPExcel->getActiveSheet()->setTitle("Rekap Perdin");

        // Output ke browser
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="REKAP_E-PERDIN_FORMAT_BPK.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
        exit;
    }

    public function cetak_excel_2025($tgla = 0, $tglb = 0){
        $iduser = $this->session->userdata('id_auth');
        if ($this->All) { 
            $admin = 1;
        } else {
            $admin = 0;
        }

        if ($admin == 1 || in_array($iduser, [197, 218, 550, 543, 683])) {
            $sql = "SELECT * FROM keu_perdin
                    WHERE DATE(tgl_pembayaran) BETWEEN ? AND ?
                    ORDER BY tgl_pembayaran ASC";
            $list_perdin = $this->db->query($sql, [$tgla, $tglb])->result();

            if (empty($list_perdin)) {
                $sql = "SELECT * FROM keu_perdin_2024
                        WHERE DATE(tgl_pembayaran) BETWEEN ? AND ?
                        ORDER BY tgl_pembayaran ASC";
                $list_perdin = $this->db->query($sql, [$tgla, $tglb])->result();
            }
        } else {
            $sql = "SELECT * FROM keu_perdin
                    WHERE DATE(tgl_pembayaran) BETWEEN ? AND ?
                      AND (user_id = ? OR user_id = 443)
                    ORDER BY tgl_pembayaran ASC";
            $list_perdin = $this->db->query($sql, [$tgla, $tglb, $iduser])->result();

            if (empty($list_perdin)) {
                $sql = "SELECT * FROM keu_perdin_2024
                        WHERE DATE(tgl_pembayaran) BETWEEN ? AND ?
                          AND (user_id = ? OR user_id = 443)
                        ORDER BY tgl_pembayaran ASC";
                $list_perdin = $this->db->query($sql, [$tgla, $tglb, $iduser])->result();
            }
        }

        // === Load PHPExcel ===
        require_once APPPATH . 'third_party/PHPExcel/Classes/PHPExcel.php';
        $objPHPExcel = new PHPExcel();
        $sheet = $objPHPExcel->setActiveSheetIndex(0);

        // Judul
        $sheet->setCellValue("A1", "E-PERDIN (REKAP PERJALANAN DINAS) DPMPTSP JAWA BARAT (FORMAT BPK)");
        $sheet->mergeCells("A1:Q1");
        $sheet->getStyle("A1")->getFont()->setBold(true);

        $sheet->setCellValue("A2", "PERIODE : ".$this->lib_date->mysql_to_human($tgla)." - ".$this->lib_date->mysql_to_human($tglb));
        $sheet->mergeCells("A2:Q2");


          // ==========================
          // HEADER (baris 4 & 5)
          // ==========================
          $sheet->setCellValue("A4", "No"); $sheet->mergeCells("A4:A5");
          $sheet->setCellValue("B4", "Nama"); $sheet->mergeCells("B4:B5");
          $sheet->setCellValue("C4", "Jabatan"); $sheet->mergeCells("C4:C5");
          $sheet->setCellValue("D4", "Tempat Tujuan"); $sheet->mergeCells("D4:D5");
          $sheet->setCellValue("E4", "Jumlah Hari Penugasan"); $sheet->mergeCells("E4:E5");
          $sheet->setCellValue("F4", "Tanggal Berangkat"); $sheet->mergeCells("F4:F5");
          $sheet->setCellValue("G4", "Tanggal Kembali"); $sheet->mergeCells("G4:G5");

          // Header gabungan Biaya Perjalanan Dinas
          $sheet->setCellValue("H4", "Biaya Perjalanan Dinas");
          $sheet->mergeCells("H4:N4");

          $sheet->setCellValue("H5", "Uang Harian (Rp)");
          $sheet->setCellValue("I5", "Uang Penginapan (Rp)");
          $sheet->setCellValue("J5", "Transport (Rp)");
          $sheet->setCellValue("K5", "Uang Representasi (Rp)");
          $sheet->setCellValue("L5", "Sewa Kendaraan (Rp)");
          $sheet->setCellValue("M5", "Harga Tiket (Rp)");
          $sheet->setCellValue("N5", "Airport Tax (Rp)");

          $sheet->setCellValue("O4", "Total"); $sheet->mergeCells("O4:O5");

          // Header gabungan Keberangkatan
          $sheet->setCellValue("P4", "Keberangkatan");
          $sheet->mergeCells("P4:W4");

          $sheet->setCellValue("P5", "Maskapai");
          $sheet->setCellValue("Q5", "Nomor Flight");
          $sheet->setCellValue("R5", "No Tiket/Kode Boking");
          $sheet->setCellValue("S5", "Asal");
          $sheet->setCellValue("T5", "Tujuan");
          $sheet->setCellValue("U5", "Tanggal Penerbangan");
          $sheet->setCellValue("V5", "Jam");
          $sheet->setCellValue("W5", "Harga Tiket");

          // Header gabungan Keberangkatan
          $sheet->setCellValue("X4", "Kembali");
          $sheet->mergeCells("X4:AE4");

          $sheet->setCellValue("X5", "Maskapai");
          $sheet->setCellValue("Y5", "Nomor Flight");
          $sheet->setCellValue("Z5", "No Tiket/Kode Boking");
          $sheet->setCellValue("AA5", "Asal");
          $sheet->setCellValue("AB5", "Tujuan");
          $sheet->setCellValue("AC5", "Tanggal Penerbangan");
          $sheet->setCellValue("AD5", "Jam");
          $sheet->setCellValue("AE5", "Harga Tiket");

          // Header gabungan Hotel
          $sheet->setCellValue("AF4", "HOTEL");
          $sheet->mergeCells("AF4:AK4");

          $sheet->setCellValue("AF5", "Kegiatan");
          $sheet->setCellValue("AG5", "Nama Hotel");
          $sheet->setCellValue("AH5", "Tanggal Menginap");
          $sheet->setCellValue("AI5", "Nomor Kamar");
          $sheet->setCellValue("AJ5", "Biaya Hotel");
          $sheet->setCellValue("AK5", "Keterangan");


        // Style tebal
        $sheet->getStyle("A4:AK4")->getFont()->setBold(true);


        // Atur lebar kolom otomatis
        foreach (range('A','Z') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }


        // Isi data sesuai echo table
       $rowExcel = 6; // data mulai setelah header
        $no = 1;
        $currentMonth = "";
        foreach($list_perdin as $row){

              // Ambil nama bulan dari tanggal berangkat (atau pembayaran sesuai kebutuhan)
    $bulan = $this->lib_date->set_month_name(date('m', strtotime($row->tgl_pembayaran)), 'id');

    // Jika bulan berubah, tampilkan nama bulan di 1 baris penuh
    if ($bulan != $currentMonth) {
        $sheet->setCellValue("A".$rowExcel, strtoupper($bulan));
        $sheet->mergeCells("A".$rowExcel.":O".$rowExcel);
        $sheet->getStyle("A".$rowExcel)->getFont()->setBold(true);
        $currentMonth = $bulan;
        $rowExcel++;

        // Reset nomor urut ke 1 setiap bulan baru
        $no = 1;
    }
$sheet->setCellValue("A".$rowExcel, $no++);
            $sheet->setCellValue("B".$rowExcel, $this->m_perdin->get_n_pegawai($row->id_pegawai));
            $sheet->setCellValue("C".$rowExcel, $this->m_perdin->get_n_jabatan($row->id_pegawai));
            $sheet->setCellValue("D".$rowExcel, $this->m_perdin->get_n_kabupaten($row->tujuan));
            $sheet->setCellValue("E".$rowExcel, $row->uang_hari);
            $sheet->setCellValue("F".$rowExcel, $row->tanggal_berangkat);
            $sheet->setCellValue("G".$rowExcel, $row->tanggal_kembali);
            $sheet->setCellValue("H".$rowExcel, $row->jumlah_uang);
            $sheet->setCellValue("I".$rowExcel, $row->penginapan_jumlah);
            $sheet->setCellValue("J".$rowExcel, $row->bbm_harga+$row->tikettol_pergi+$row->tikettol_pulang);
            $sheet->setCellValue("K".$rowExcel, $row->jumlah_representasi);
            $sheet->setCellValue("L".$rowExcel, $row->sewa_kendaraan_jumlah);
            $sheet->setCellValue("M".$rowExcel, $row->itberangkat_harga_tiket + $row->itkembali_harga_tiket);
            $sheet->setCellValue("N".$rowExcel, '');
            // $sheet->setCellValue("O".$rowExcel, $row->jumlah_total);
            $sheet->setCellValue("O".$rowExcel, $row->jumlah_uang+$row->penginapan_jumlah+$row->bbm_harga+$row->tikettol_pergi+$row->tikettol_pulang+$row->uang_sku_p_j+$row->jumlah_representasi+$row->sewa_kendaraan_jumlah+$row->itberangkat_harga_tiket + $row->itkembali_harga_tiket);

            $sheet->setCellValue("P".$rowExcel, $row->itberangkat_maskapai);
            $sheet->setCellValue("Q".$rowExcel, $row->itberangkat_no_penerbangan);
            $sheet->setCellValue("R".$rowExcel, $row->itberangkat_no_tiket);
            $sheet->setCellValue("S".$rowExcel, $this->m_perdin->get_n_kabupaten($row->itberangkat_asal_daerah));
            $sheet->setCellValue("T".$rowExcel, $this->m_perdin->get_n_kabupaten($row->itberangkat_tujuan));
            $sheet->setCellValue("U".$rowExcel, $row->itberangkat_tanggal);
            $sheet->setCellValue("V".$rowExcel, '');
            $sheet->setCellValue("W".$rowExcel, $row->itberangkat_harga_tiket);

            $sheet->setCellValue("X".$rowExcel, $row->itkembali_maskapai);
            $sheet->setCellValue("Y".$rowExcel, $row->itkembali_no_penerbangan);
            $sheet->setCellValue("Z".$rowExcel, $row->itkembali_no_tiket);
            $sheet->setCellValue("AA".$rowExcel, $this->m_perdin->get_n_kabupaten($row->itkembali_asal_daerah));
            $sheet->setCellValue("AB".$rowExcel, $this->m_perdin->get_n_kabupaten($row->itkembali_tujuan));
            $sheet->setCellValue("AC".$rowExcel, $row->itkembali_tanggal);
            $sheet->setCellValue("AD".$rowExcel, '');
            $sheet->setCellValue("AE".$rowExcel, $row->itkembali_harga_tiket);
            if (empty($row->uraian)) {
              $maksud = $row->mksd_pemberangkatan;
            } else {
              $maksud = $row->uraian;
            }
            $sheet->setCellValue("AF".$rowExcel, $maksud);
            $sheet->setCellValue("AG".$rowExcel, $row->nama_penginapan);
            $sheet->setCellValue("AH".$rowExcel, '');
            $sheet->setCellValue("AI".$rowExcel, '');
            $sheet->setCellValue("AJ".$rowExcel, '');
            $sheet->setCellValue("AK".$rowExcel, '');

            $rowExcel++;
        }

        // Nama Sheet
        $objPHPExcel->getActiveSheet()->setTitle("Rekap Perdin");

        // Output ke browser
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="REKAP_E-PERDIN_FORMAT_BPK2025.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
        exit;
    }

    public function cetak_excel_pimpinan($tgla = 0, $tglb = 0){
           // $sql = "SELECT * FROM keu_perdin 
           //      where  DATE(tanggal_berangkat) BETWEEN ? AND ?
           //      group by id_pegawai 
           //      order by jumlah_uang asc  
                          	        
           //         ";

       $sql = "SELECT  b.n_pegawai as namapegawai, a.* 
                FROM keu_perdin a 
                left join tmpegawai b on a.id_pegawai = b.id 
                where  DATE(a.tanggal_berangkat) BETWEEN '$tgla' AND '$tglb'
                group by a.id_pegawai 
                order by namapegawai asc  
                                    
                   ";
                  //  var_dump($sql);die();
    
            $list_perdin = $this->db->query($sql, array($tgla, $tglb))->result();
            // var_dump($this->m_perdin->get_n_pegawai($row->id_pegawai));die();
            // var_dump($this->m_perdin->get_data_per_month('820', '3', $tgla, $tglb));die();
            // var_dump($this->m_perdin->get_bulanbulan('820'));die();
            
            header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
            header("Content-Disposition: attachment; filename=REKAP_E-PERDIN_FORMAT_PIMPINAN(DPMPTSP_JABAR).xls");
            header("Expires: 0");
            header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
            header("Cache-Control: private",false);

            echo "<table width='100%' border='0' font-size:15px;font-style:bold;'>";
            echo "E-PERDIN (REKAP PERJALANAN DINAS) DPMPTSP JAWA BARAT (FORMAT PIMPINAN)";
            echo "<tr>PERIODE : ".$this->lib_date->mysql_to_human($tgla)." - ".$this->lib_date->mysql_to_human($tglb)."</tr>";
            echo "</table>";
           	

           


              $jd3= " <tr>
                      <td colspan='2' align='center'>".''."</td>
                      <td colspan='12' align='center'>".'Bulan'."</td>
                      <td colspan='2' align='center'>".''."</td>              
                                        
                    </tr>";
                      // echo "<table width='100%' border='0' align='center' font-size:16px;'>";
                       echo "</table>";

             echo "<table width='100%' cellspacing='0' cellpadding='0'  border='1' style='border-style:solid; border-width:thin;font-size:12px;font-weight:bold;'>";
             echo $jd3; 

 
            $jdl= " <tr>
                      <td align='center'>".'NO.'."</td>
                      <td align='center'>".'Nama '."</td>
                      <td align='center'>".'Januari'."</td>
                      <td align='center'>".'Februari'."</td>
                      <td align='center'>".'Maret'."</td>
                      <td align='center'>".'April'."</td>
                      <td align='center'>".'Mei'."</td>
                      <td align='center'>".'Juni'."</td>
                      <td align='center'>".'Juli'."</td>
                      <td align='center'>".'Agustus'."</td>
                      <td align='center'>".'September'."</td>
                      <td align='center'>".'Oktober'."</td>
                      <td align='center'>".'November'."</td>
                      <td align='center'>".'Desember'."</td>
                      <td align='center'>".'Jumlah'."</td>
                      <td style='background-color:#fce4d6' align='center'>".'Nominal'."</td>
                     
                                        
                    </tr>";
                      // echo "<table width='100%' border='0' font-size:16px;'>";
                       echo "</table>";

             echo "<table width='100%' cellspacing='0' cellpadding='0' border='1' style='border-style:solid; border-width:thin;font-size:10px;font-weight:bold;'>";
             echo $jdl; 

             

            $i=1;
            foreach ($list_perdin as $row){
                  $isi = "<tr>
                        <td>".$i."</td>                        
                        <td>".$this->m_perdin->get_n_pegawai($row->id_pegawai)."</td>
                        <td>".$this->m_perdin->get_data_per_month($row->id_pegawai, '1', $tgla, $tglb)."</td>
                        <td>".$this->m_perdin->get_data_per_month($row->id_pegawai, '2', $tgla, $tglb)."</td>
                        <td>".$this->m_perdin->get_data_per_month($row->id_pegawai, '3', $tgla, $tglb)."</td>
                        <td>".$this->m_perdin->get_data_per_month($row->id_pegawai, '4', $tgla, $tglb)."</td>
                        <td>".$this->m_perdin->get_data_per_month($row->id_pegawai, '5', $tgla, $tglb)."</td>
                        <td>".$this->m_perdin->get_data_per_month($row->id_pegawai, '6', $tgla, $tglb)."</td>
                        <td>".$this->m_perdin->get_data_per_month($row->id_pegawai, '7', $tgla, $tglb)."</td>
                        <td>".$this->m_perdin->get_data_per_month($row->id_pegawai, '8', $tgla, $tglb)."</td>
                        <td>".$this->m_perdin->get_data_per_month($row->id_pegawai, '9', $tgla, $tglb)."</td>
                        <td>".$this->m_perdin->get_data_per_month($row->id_pegawai, '10', $tgla, $tglb)."</td>
                        <td>".$this->m_perdin->get_data_per_month($row->id_pegawai, '11', $tgla, $tglb)."</td>
                        <td>".$this->m_perdin->get_data_per_month($row->id_pegawai, '12', $tgla, $tglb)."</td>
						<td>".$this->m_perdin->get_total_jumlahperjalanan($row->id_pegawai, $tgla, $tglb)."</td>
                        <td style='background-color:#fce4d6'>".$this->rupiah($this->m_perdin->get_total_uangperjalanan($row->id_pegawai, $tgla, $tglb))."</td>
                  

                  </tr>";

                    echo "<table width='100%' cellspacing='0' cellpadding='0' border='1' style='border-style:solid; border-width:thin;font-size:10px;font-style:normal;'>";
            echo $isi; 

            

             $i++;
          }

           $jdl1= " <tr>
                      <td align='center'>".'NO.'."</td>
                      <td align='center'>".'Nama '."</td>
                      <td align='center'>".'Januari'."</td>
                      <td align='center'>".'Februari'."</td>
                      <td align='center'>".'Maret'."</td>
                      <td align='center'>".'April'."</td>
                      <td align='center'>".'Mei'."</td>
                      <td align='center'>".'Juni'."</td>
                      <td align='center'>".'Juli'."</td>
                      <td align='center'>".'Agustus'."</td>
                      <td align='center'>".'September'."</td>
                      <td align='center'>".'Oktober'."</td>
                      <td align='center'>".'November'."</td>
                      <td align='center'>".'Desember'."</td>
                      <td align='center'>".'Jumlah'."</td>
                      <td style='background-color:#fce4d6' align='center'>".'Nominal'."</td>
                     
                                        
                    </tr>";
                      // echo "<table width='100%' border='0' font-size:16px;'>";
                       echo "</table>";

             echo "<table width='100%' cellspacing='0' cellpadding='0' border='1' style='border-style:solid; border-width:thin;font-size:10px;font-weight:bold;'>";
             echo $jdl1; 

              $jdl2= " <tr>
                      <td colspan='2' align='center'>".'Jumlah Total.'."</td>
                      <td>".$this->m_perdin->get_data_perbulan('1', $tgla, $tglb)."</td>
                       <td>".$this->m_perdin->get_data_perbulan('2', $tgla, $tglb)."</td>
                        <td>".$this->m_perdin->get_data_perbulan('3', $tgla, $tglb)."</td>
                         <td>".$this->m_perdin->get_data_perbulan('4', $tgla, $tglb)."</td>
                          <td>".$this->m_perdin->get_data_perbulan('5', $tgla, $tglb)."</td>
                           <td>".$this->m_perdin->get_data_perbulan('6', $tgla, $tglb)."</td>
                            <td>".$this->m_perdin->get_data_perbulan('7', $tgla, $tglb)."</td>
                             <td>".$this->m_perdin->get_data_perbulan('8', $tgla, $tglb)."</td>
                              <td>".$this->m_perdin->get_data_perbulan('9', $tgla, $tglb)."</td>
                               <td>".$this->m_perdin->get_data_perbulan('10', $tgla, $tglb)."</td>
                                <td>".$this->m_perdin->get_data_perbulan('11', $tgla, $tglb)."</td>
                                 <td>".$this->m_perdin->get_data_perbulan('12', $tgla, $tglb)."</td>
                                 <td>".$this->m_perdin->get_data_perbulan_jumlah($tgla, $tglb)."</td>
                                 <td style='background-color:#fce4d6'>".$this->rupiah($this->m_perdin->get_total_jumlahperjalanan_semua($tgla, $tglb))."</td>
                                  

                     
                                        
                    </tr>";
                      // echo "<table width='100%' border='0' font-size:16px;'>";
                       echo "</table>";

             echo "<table width='100%' cellspacing='0' cellpadding='0' border='1' style='border-style:solid; border-width:thin;font-size:10px;font-weight:bold;'>";
             echo $jdl2; 

             echo "</table>";
    }

   public function rupiah($angka){
	
	$hasil_rupiah = "Rp" . number_format($angka,0,',','.');
	return $hasil_rupiah;
 
}

public function cetak_excel_rekap($tgla = null, $tglb = null) {
  $now = $this->lib_date->get_date_now();
  $admin = "";
      $petugas = new tmpegawai();

  $list = $petugas->where('unitkerja_id', 1)->order_by('golongan', "DESC")->get();

  if ($this->All) { 
      $admin = 1;
  } else {
      $admin = 0;
  }

  $tanggal_awal = date('Y-m-d');
  // Ubah format tanggal
  $tanggal_baru = date('Y-m-d', strtotime($tanggal_awal . ' -1 year'));

  $awalyear =  $tanggal_baru;
  $akhiryear =  $tanggal_awal;

  $tgla = !empty($this->input->post('tgla')) ? $this->input->post('tgla') : $awalyear; 
  $tglb = !empty($this->input->post('tglb')) ? $this->input->post('tglb') : $akhiryear;

  $iduser = $this->session->userdata('id_user');

  // Ambil data rekap
  $search = $this->m_perdin->get_rekap_sp_by_pegawai($tgla, $tglb, $admin, $iduser);
  // Set header untuk download Excel
  header("Content-Type: application/vnd.ms-excel; charset=utf-8");
  header("Content-Disposition: attachment; filename=REKAP_E-PERDIN_PELAKSANA.xls");
  header("Expires: 0");
  header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
  header("Cache-Control: private", false);

  // Output Excel
  echo "<table border='1'>";
  echo "<thead>
          <tr>
              <th>No</th>
              <th>Nama Pelaksana</th>
              <th>Jumlah Perdin</th>
          </tr>
      </thead>";
  echo "<tbody>";

  $i = 1;
  $rekap = [];

  // Kumpulkan dan kelompokkan data berdasarkan nama pegawai
  foreach ($search as $row) {
      $nama_pelaksana = $this->m_perdin->get_n_pegawai($row->id_pegawai);

      if (!isset($rekap[$nama_pelaksana])) {
          $rekap[$nama_pelaksana] = [
              'total_sp' => 0,
              'kab_kota_array' => [],
              'nama_pelaksana' => $nama_pelaksana
          ];
      }

      // Tambahkan total SP
      $rekap[$nama_pelaksana]['total_sp'] += $row->total_sp;

      // Tambahkan kabupaten/kota tujuan (gabungan)
      $tujuan = $this->m_perdin->get_tujuan_keberangkatan_perdin($row->no_grup_perdin, $row->id_tim);
      if (!empty($tujuan)) {
          foreach ($tujuan as $tujuan_row) {
              $decoded = json_decode($tujuan_row->kab_kota, true);
              if (is_array($decoded)) {
                  $rekap[$nama_pelaksana]['kab_kota_array'] = array_merge($rekap[$nama_pelaksana]['kab_kota_array'], $decoded);
              } elseif (!empty($tujuan_row->kab_kota)) {
                  $rekap[$nama_pelaksana]['kab_kota_array'][] = $tujuan_row->kab_kota;
              }
          }
      }
  }

  // Tampilkan hasil
  $i = 1;
  foreach ($rekap as $data) {
      $kab_kota_list = !empty($data['kab_kota_array']) ? implode(", ", array_unique($data['kab_kota_array'])) : "Tidak tersedia";

      echo "<tr>
              <td>{$i}</td>
              <td>{$data['nama_pelaksana']}</td>
              <td>{$data['total_sp']}</td>
              <td>{$kab_kota_list}</td>
            </tr>";
      $i++;
  }


    echo "</tbody></table>";
 }

private function normalize_name($nama) {
    $nama = strtolower($nama);
    $hapus = ['[tidak aktif]'];
    $nama = str_ireplace($hapus, '', $nama);
    $nama = preg_replace('/\s+/', ' ', $nama); // Hilangkan spasi ganda
    return trim($nama);
}

    public function rekap() {
       $now = $this->lib_date->get_date_now();
      // if ($rekap == FALSE) {
      //     redirect('dashboard');
      // }

      $admin = "";
      if ($this->All) { 
        $admin = 1;
      } else {
        $admin = 0;
      }

       $awalyear =  date('Y').'-01-01';
       $akhiryear =  date('Y').'-12-31';
      $tgla = !empty($this->input->post('tgla')) ? $this->input->post('tgla') : $awalyear; 
      $tglb = !empty($this->input->post('tglb')) ? $this->input->post('tglb') :   $akhiryear;


      $tglc = (!empty($this->input->post('tglc')) ? $this->input->post('tglc') : $this->lib_date->set_date($now, -30));
      $tgld = (!empty($this->input->post('tgld')) ? $this->input->post('tgld') : $this->lib_date->set_date($now, 0));

      $mark = $this->input->post('mark');
      $statusizin = $this->input->post('statusizin');
       $iduser = $this->session->userdata('id_auth');

       $data['tgla'] = $tgla;
      $data['tglb'] = $tglb;

      $data['tglc'] = $tglc;
      $data['tgld'] = $tgld;
      $tahun = date('Y', strtotime($tgla)); 
      $data['rekap_anggaran'] = $this->m_perdin->get_rekap_per_bulan($tahun);
        $data['array_bulan'] = [
               1 => "Januari", 2 => "Februari", 3 => "Maret", 4 => "April",
                5 => "Mei", 6 => "Juni", 7 => "Juli", 8 => "Agustus",
                9 => "September", 10 => "Oktober", 11 => "November", 12 => "Desember"
        ];

      $petugas = new tmpegawai();

      $data['list'] = $petugas->where('unitkerja_id', 1)->order_by('golongan', "DESC")->get();

      // $search  = $this->m_perdin->get_rekap_sp_by_pegawai($tgla, $tglb, $admin, $iduser);
      $data_mentah = $this->m_perdin->get_rekap_sp_by_pegawai($tgla, $tglb);

      $search = [];

    foreach ($data_mentah as $row) {
        $nama_asli = trim($row->n_pegawai);
        $nama_key = $this->normalize_name($nama_asli); // Pakai method, bukan fungsi global

        if (!isset($search[$nama_key])) {
            $search[$nama_key] = [
                'n_pegawai' => $nama_asli,
                'total_sp' => 0,
                'tanggal_awal' => $row->tanggal_berangkat_awal,
                'tanggal_akhir' => $row->tanggal_berangkat_akhir
            ];
        }

        $search[$nama_key]['total_sp'] += $row->total_sp;
        $search[$nama_key]['tanggal_awal'] = min($search[$nama_key]['tanggal_awal'], $row->tanggal_berangkat_awal);
        $search[$nama_key]['tanggal_akhir'] = max($search[$nama_key]['tanggal_akhir'], $row->tanggal_berangkat_akhir);
    }



        $data['search'] = $search;
        // var_dump($data['search']);die();

        // $data['search'] = $search;
        $data['rekap'] = 0;
      // var_dump($search);die();
   
      $this->load->vars($data);

      $js = "function confirm_link(text){
                  if(confirm(text)){ return true;
                  } else { return false; }
              }

              $(document).ready(function() {
                  // DataTable untuk tabel #pendataan
                  oTable = $('#pendataan').dataTable({
                      \"bJQueryUI\": true,
                      \"sPaginationType\": \"full_numbers\"
                  });

                  // DataTable untuk #data_rekap_anggaran dengan sorting bulan berdasarkan angka
                  oTable = $('#data_rekap_anggaran').dataTable({
                      \"bJQueryUI\": true,
                      \"sPaginationType\": \"full_numbers\",
                      \"aaSorting\": [[0, \"asc\"]],
                      \"aoColumns\": [
                          { \"iDataSort\": 0 }, // Kolom Bulan, baca dari data-order
                          null, // Bulan (teks)
                          null, // Total SP
                          null, // Total Uang Harian
                          null  // Periode
                      ]
                  });
              });

              // jQuery UI Tabs dan Datepicker
              $(function() {
                  $(\"#tabs\").tabs();
                  $(\".monbulan\").datepicker({
                      changeMonth: true,
                      changeYear: true,
                      dateFormat: 'yy-mm-dd',
                      closeText: 'X'
                  });
                  $('#form').validate();
              });";


      $this->template->set_metadata_javascript($js);
      $this->session_info['page_name'] = "Rekap Perdin";
      $this->template->build('rekap', $this->session_info);
    }


    public function addrekap($id = NULL) {
      // $no__sppd = $this->m_perdin->get_no_sppd($id);
      // var_dump($no__sppd);die();
      // $data['perdin'] = $this->m_perdin->get_perdin_sppd($no__sppd);
      // $data['perdin'] = $this->m_perdin->get_perdin_sppd($no__sppd);
      // $data['perdin1'] = $this->m_perdin->get_perdin($id);
      if ($this->All) { 
        $data['admin'] = 1;
      } else {
        $data['admin'] = 0;
      }
      // $data['step'] = "update";
      $data['step'] = "simpan_perdin";
      $method = "save";
      $data['save_method'] = $method;
      $data['kabupaten'] = $this->m_perdin->get_kabupaten();
      $data['lokasi'] = "";
      $data['iduser'] = $this->session->userdata('id_auth');
      $pendaftaran = new tmpermohonan();
      $pendaftaran->where('id', $id)->get();
      $pendaftaran->tmpemohon->get();
      $pendaftaran->trperizinan->get();
      $pendaftaran->trtanggal_survey->get();
    
      $survey_date = new trtanggal_survey();
      $survey_date->where('id', $pendaftaran->trtanggal_survey->id)->get();
      $survey_date->tmpegawai->get();

      $petugas = new tmpegawai();
      $data['petugas'] = $petugas->where('status = 1 OR status = 2')->get();
      $data['petugas_id'] = $survey_date->tmpegawai->id;
      
      $petugas = new tmpegawai();
      $data['list'] = $petugas->where('unitkerja_id', 1)->order_by('golongan', "DESC")->get();
      // var_dump($petugas);die();


      $data['itberangkat_asal_daerah1'] = $this->m_perdin->get_kabupaten();
      $data['itberangkat_tujuan1'] = $this->m_perdin->get_kabupaten();
      $data['itkembali_tujuan1'] = $this->m_perdin->get_kabupaten();
      $data['itkembali_asal_daerah1'] = $this->m_perdin->get_kabupaten();

      $data['pegawai'] = $this->m_perdin->get_pegawai(); 
      $data['surat_kode_reg'] = $this->m_perdin->get_kode_reg();
      $data['list_tims'] = $this->m_perdin->get_list_tim();
      $js_date = " $(function() {
                   $(\".survey\").datepicker({
                     changeMonth: true,
                     changeYear: true,
                     dateFormat: 'yy-mm-dd',
                     closeText: 'X'
                   });
                 });
               ";
    
      $js_date .= "$(document).ready(
                   function() {
                     $('#listizin').multiselect().multiselectfilter({
                       show:'blind',
                       hide:'blind',
                       selectedText:'# dari # terpilih'
                     }
                   );
                 });
                ";
      $js =  "
               
              $(document).ready(function() {
                  $(\"#tabs\").tabs();
                  $('.monbulan').datepicker({
                      changeMonth: true,
                      changeYear: true,
                      dateFormat: 'yy-mm-dd',
                      closeText: 'X'
                  });
                  $('#form').validate();
                  $('.pilihan').select2();

              });
      
              function finishAjax(id, response){
                  $('#'+id).html(unescape(response));
                  $('#'+id).fadeIn();
              } 
          ";
    
      $this->template->set_metadata_javascript($js);
      // $this->template->set_metadata_javascript($js_date);
      
      $this->load->vars($data);
      $this->session_info['page_name'] = "Penomoran Surat Perintah Perjalanan Dinas";

      $this->template->build('addperdin', $this->session_info);
  }

    public function suratperintah($id = NULL) {
       $now = $this->lib_date->get_date_now();
      // if ($rekap == FALSE) {
      //     redirect('dashboard');
      // }
      
      
      $petugas = new tmpegawai();
      $data['list'] = $petugas->where('unitkerja_id', 1)->order_by('golongan', "DESC")->get();

      $admin = "";
      if ($this->All) { 
        $admin = 1;
      } else {
        $admin = 0;
      }
    

       $awalyear =  date('Y').'-01-01';
       $akhiryear =  date('Y').'-12-31';
      $tgla = !empty($this->input->post('tgla')) ? $this->input->post('tgla') : $awalyear; 
      $tglb = !empty($this->input->post('tglb')) ? $this->input->post('tglb') :   $akhiryear;


      $tglc = (!empty($this->input->post('tglc')) ? $this->input->post('tglc') : $this->lib_date->set_date($now, -30));
      $tgld = (!empty($this->input->post('tgld')) ? $this->input->post('tgld') : $this->lib_date->set_date($now, 0));

      $mark = $this->input->post('mark');
      $statusizin = $this->input->post('statusizin');
       $iduser = $this->session->userdata('id_auth');

       $data['tgla'] = $tgla;
      $data['tglb'] = $tglb;

      $data['tglc'] = $tglc;
      $data['tgld'] = $tgld;
      $data['detailpage'] = '0';

      $data['admin'] = $admin;
      $data['iduser'] = $iduser;
      // var_dump($iduser);die();

      
      $search  = $this->m_perdin->get_data_surat_perintah($tgla, $tglb, $admin, $iduser);


      $search_preview = $this->m_perdin->get_data_preview($tgla, $tglb, $admin, $iduser);
      $search_preview_preview = $this->m_perdin->get_data_preview_preview($tgla, $tglb, $admin, $iduser);


      $data['search'] = $search;
      // echo json_encode($data['search']);
      // die();
      

        $data['search_preview'] = $search_preview;
        $data['search_preview_preview'] = $search_preview_preview;
        $data['rekap'] = 0;
  
   
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
               $(\"#tabs\").tabs();
              $(\".monbulan\").datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: 'yy-mm-dd',
                closeText: 'X'
              });
              $('#form').validate();
            });";

      $this->template->set_metadata_javascript($js);
      $this->session_info['page_name'] = "Surat Perintah Perjalanan Dinas";
      $this->template->build('suratperintah', $this->session_info);
  }

    public function cetak_surat_perintah($id){ // berita acara
      $nomor_surat = $this->m_perdin->get_nomor_surat($id);
       $now = $this->lib_date->get_date_now();
      // if ($rekap == FALSE) {
      //     redirect('dashboard');
      // }

      $admin = "";
      if ($this->All) { 
        $admin = 1;
      } else {
        $admin = 0;
      }

       $awalyear =  date('Y').'-01-01';
       $akhiryear =  date('Y').'-12-31';
      $tgla = !empty($this->input->post('tgla')) ? $this->input->post('tgla') : $awalyear; 
      $tglb = !empty($this->input->post('tglb')) ? $this->input->post('tglb') :   $akhiryear;


      $tglc = (!empty($this->input->post('tglc')) ? $this->input->post('tglc') : $this->lib_date->set_date($now, -30));
      $tgld = (!empty($this->input->post('tgld')) ? $this->input->post('tgld') : $this->lib_date->set_date($now, 0));

      $mark = $this->input->post('mark');
      $statusizin = $this->input->post('statusizin');
       $iduser = $this->session->userdata('id_auth');

       $data['tgla'] = $tgla;
      $data['tglb'] = $tglb;

      $data['tglc'] = $tglc;
      $data['tgld'] = $tgld;
      $data['detailpage'] = '1';

      $data['list'] = $this->m_perdin->get_data_rekap_id($id);
      $search  = $this->m_perdin->get_data_rekap_detail($nomor_surat);
        $data['search'] = $search;
        $data['rekap'] = 0;
  
   
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
            });

            $(document).ready(function() {
                  $(\"#tabs\").tabs();
                  $('.monbulan').datepicker({
                      changeMonth: true,
                      changeYear: true,
                      dateFormat: 'yy-mm-dd',
                      closeText: 'X'
                  });
                  $('#form').validate();
                  $('.pilihan').select2();
              });
      
              function finishAjax(id, response){
                  $('#'+id).html(unescape(response));
                  $('#'+id).fadeIn();
              }";

        $this->template->set_metadata_javascript($js);
        $this->session_info['page_name'] = "Surat Perintah";
        $this->template->build('cetak_surat_perintah', $this->session_info);
    }

    public function detailsuratperintah($id) {
      $nomor_surat = $this->m_perdin->get_nomor_surat($id);
       $now = $this->lib_date->get_date_now();
      // if ($rekap == FALSE) {
      //     redirect('dashboard');
      // }

      $admin = "";
      if ($this->All) { 
        $admin = 1;
      } else {
        $admin = 0;
      }

       $awalyear =  date('Y').'-01-01';
       $akhiryear =  date('Y').'-12-31';
      $tgla = !empty($this->input->post('tgla')) ? $this->input->post('tgla') : $awalyear; 
      $tglb = !empty($this->input->post('tglb')) ? $this->input->post('tglb') :   $akhiryear;


      $tglc = (!empty($this->input->post('tglc')) ? $this->input->post('tglc') : $this->lib_date->set_date($now, -30));
      $tgld = (!empty($this->input->post('tgld')) ? $this->input->post('tgld') : $this->lib_date->set_date($now, 0));
      $data['id'] = $id;
      $mark = $this->input->post('mark');
      $statusizin = $this->input->post('statusizin');
       $iduser = $this->session->userdata('id_auth');

       $data['tgla'] = $tgla;
      $data['tglb'] = $tglb;

      $data['tglc'] = $tglc;
      $data['tgld'] = $tgld;
      $data['detailpage'] = '1';

      $search  = $this->m_perdin->get_data_rekap_detail($nomor_surat);
        $data['search'] = $search;
        $data['rekap'] = 0;
  
   
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
               $(\"#tabs\").tabs();
              $(\".monbulan\").datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: 'yy-mm-dd',
                closeText: 'X'
              });
              $('#form').validate();
            });";

      $this->template->set_metadata_javascript($js);
      $this->session_info['page_name'] = "Rekap Perdin";
      $this->template->build('detailpage', $this->session_info);
  }

    public function add() {
      $petugas = new tmpegawai();
      $data['list'] = $petugas->order_by('golongan', "DESC")->get();
      $data['step'] = "simpan";
  	  // $data['perdin'] = $this->m_perdin->get_perdin($id);
      // $data['step'] = "update";
         // $data['pegawai'] = $this->m_perdin->get_pegawai(); 
      $data['kabupaten'] = $this->m_perdin->get_kabupaten();
 
      $data['itberangkat_asal_daerah1'] = $this->m_perdin->get_kabupaten();
      $data['itberangkat_tujuan1'] = $this->m_perdin->get_kabupaten();
      $data['itkembali_tujuan1'] = $this->m_perdin->get_kabupaten();
      $data['itkembali_asal_daerah1'] = $this->m_perdin->get_kabupaten();

      $js =  "
              $(document).ready(function() {
                  $(\"#tabs\").tabs();
                  $('.monbulan').datepicker({
                      changeMonth: true,
                      changeYear: true,
                      dateFormat: 'yy-mm-dd',
                      closeText: 'X'
                  });
                  $('#form').validate();
                  $('.pilihan').select2();
              });
      
              function finishAjax(id, response){
                  $('#'+id).html(unescape(response));
                  $('#'+id).fadeIn();
              } 

                $(document).ready(
                     function() {
                       $('#listizin').multiselect({
                        buttonWidth: '75%'
                       }).multiselectfilter({
                         show:'blind',
                         hide:'blind',
                         selectedText:'# dari # terpilih'
                       }
                     );
                     $('#listizin .ui-multiselect').css('width', '75%');
                   });
          ";
    
      $this->template->set_metadata_javascript($js);
      $this->load->vars($data);
      $this->session_info['page_name'] = "Tambah Data Perdin";
      $this->template->build('perdin_edit', $this->session_info);
  }

    public function inputrekapperdin(){ // Surat Perintah
      $kepada = $this->input->post('kepada');
      $nomor_surat = $this->input->post('nomor_surat');
      $dasar = $this->input->post('dasar');
      $untuk = $this->input->post('untuk');
      $tanggal = $this->input->post('tanggal');
      $ttd = $this->input->post('ttd');
      foreach ($kepada as $row) {
        $save_data = $this->m_perdin->insert_surat_perintah($row, $nomor_surat, $dasar, $untuk, $tanggal, $ttd);        
      }
      redirect('perdin/suratperintah');
    }

    public function ubah($id) {
  	  $data['perdin'] = $this->m_perdin->get_perdin_ubah($id);
      // var_dump($data['perdin']);die();
      $data['step'] = "update_e_perdin";
      $data['kabupaten'] = $this->m_perdin->get_kabupaten();

      $data['itberangkat_asal_daerah1'] = $this->m_perdin->get_kabupaten();
      $data['itberangkat_tujuan1'] = $this->m_perdin->get_kabupaten();
      $data['itkembali_tujuan1'] = $this->m_perdin->get_kabupaten();
      $data['itkembali_asal_daerah1'] = $this->m_perdin->get_kabupaten();

      $data['pegawai'] = $this->m_perdin->get_pegawai(); 
      $js =  "
              $(document).ready(function() {
                  $(\"#tabs\").tabs();
                  $('.monbulan').datepicker({
                      changeMonth: true,
                      changeYear: true,
                      dateFormat: 'yy-mm-dd',
                      closeText: 'X'
                  });
                  $('#form').validate();
                  $('.pilihan').select2();
              });
      
              function finishAjax(id, response){
                  $('#'+id).html(unescape(response));
                  $('#'+id).fadeIn();
              } 

                $(document).ready(
                     function() {
                       $('#listizin').multiselect({
                        buttonWidth: '75%'
                       }).multiselectfilter({
                         show:'blind',
                         hide:'blind',
                         selectedText:'# dari # terpilih'
                       }
                     );
                     $('#listizin .ui-multiselect').css('width', '75%');
                   });
          ";
    
      $this->template->set_metadata_javascript($js);
      $this->load->vars($data);
      $this->session_info['page_name'] = "Ubah Data Perdin";
      $this->template->build('perdin_edit', $this->session_info);
  }
  public function ubah_sp_perdin($id = NULL) {
    // $no__sppd = $this->m_perdin->get_no_sppd($id);
    // $data['perdin'] = $this->m_perdin->get_perdin_sppd($no__sppd);
    // $data['perdin'] = $this->m_perdin->get_perdin_sppd($no__sppd);
    // $data['perdin1'] = $this->m_perdin->get_perdin($id);
    // $data['step'] = "update";
    if ($this->All) { 
      $data['admin'] = 1;
    } else {
      $data['admin'] = 0;
    }
    $data['perdin_grup'] = $this->m_perdin->get_perdin_sp($id);
    // var_dump($data['perdin_grup']);die();
    $data['perdin_no_grup'] = $this->m_perdin->get_perdin($data['perdin_grup']->no_grup_perdin, $data['perdin_grup']->id_tim);


    $data['tujuan_keberangkatan_perdin'] = $this->m_perdin->get_tujuan_keberangkatan_perdin($data['perdin_grup']->no_grup_perdin, $data['perdin_grup']->id_tim);
    // var_dump($data['tujuan_keberangkatan_perdin']);die();
    // Debug untuk melihat isi data

    
    // Loop untuk mengekstrak tanggal keberangkatan dan tanggal pulang
    foreach ($data['tujuan_keberangkatan_perdin'] as $key => $value) {
        // Loop untuk mengakses tanggal keberangkatan (1, 2, 3)
        for ($i = 1; $i <= 3; $i++) {
            // Menyimpan tanggal keberangkatan untuk setiap index
            $data['tanggal_berangkat_' . $i] = isset($value->{'tanggal_berangkat_' . $i}) ? $value->{'tanggal_berangkat_' . $i} : null;
            // Menyimpan tanggal pulang untuk setiap index
            $data['tanggal_pulang_' . $i] = isset($value->{'tanggal_pulang_' . $i}) ? $value->{'tanggal_pulang_' . $i} : null;

            $data['detail_tempat_' . $i] = isset($value->{'detail_tempat_' . $i}) ? $value->{'detail_tempat_' . $i} : null;
            
        }
    }
    
    // Output untuk memverifikasi
    
    $data['user_id'] = $this->session->userdata('id_auth'); 
    // var_dump($data['user_id']);die();

    $data['step'] = "update";
    $method = "save";
    $data['save_method'] = $method;
    $data['kabupaten'] = $this->m_perdin->get_kabupaten();
    // var_dump($data['kabupaten']);die();

    $data['lokasi'] = "";

    $pendaftaran = new tmpermohonan();
    $pendaftaran->where('id', $id)->get();
    $pendaftaran->tmpemohon->get();
    $pendaftaran->trperizinan->get();
    $pendaftaran->trtanggal_survey->get();
  
    $survey_date = new trtanggal_survey();
    $survey_date->where('id', $pendaftaran->trtanggal_survey->id)->get();
    $survey_date->tmpegawai->get();

    $petugas = new tmpegawai();
    $data['petugas'] = $petugas->where('status = 1 OR status = 2')->get();
    $data['petugas_id'] = $survey_date->tmpegawai->id;
    
    $petugas = new tmpegawai();
    $data['list'] = $petugas->where('unitkerja_id', 1)->order_by('golongan', "DESC")->get();

    $data['itberangkat_asal_daerah1'] = $this->m_perdin->get_kabupaten();
    $data['itberangkat_tujuan1'] = $this->m_perdin->get_kabupaten();
    $data['itkembali_tujuan1'] = $this->m_perdin->get_kabupaten();
    $data['itkembali_asal_daerah1'] = $this->m_perdin->get_kabupaten();

    $data['pegawai'] = $this->m_perdin->get_pegawai(); 
    $data['surat_kode_reg'] = $this->m_perdin->get_kode_reg();
    $data['list_tims'] = $this->m_perdin->get_list_tim();

    $js_date = " $(function() {
                 $(\".survey\").datepicker({
                   changeMonth: true,
                   changeYear: true,
                   dateFormat: 'yy-mm-dd',
                   closeText: 'X'
                 });
               });
             ";
  

    $js =  "
             
            $(document).ready(function() {
                $(\"#tabs\").tabs();
                $('.monbulan').datepicker({
                    changeMonth: true,
                    changeYear: true,
                    dateFormat: 'yy-mm-dd',
                    closeText: 'X'
                });
                $('#form').validate();
                $('.pilihan').select2();
            });
    
            function finishAjax(id, response){
                $('#'+id).html(unescape(response));
                $('#'+id).fadeIn();
            } 
                
        ";
  
    $this->template->set_metadata_javascript($js);
    // $this->template->set_metadata_javascript($js_date);
    $this->load->vars($data);
    $this->session_info['page_name'] = "Ubah Data Perdin";
    $this->template->build('sp_perdin_edit', $this->session_info);
}
public function penomoran_surat($id = NULL , $id_tim = NULL) {
  // $no__sppd = $this->m_perdin->get_no_sppd($id);
  // $data['perdin'] = $this->m_perdin->get_perdin_sppd($no__sppd);
  // $data['perdin'] = $this->m_perdin->get_perdin_sppd($no__sppd);
  // $data['perdin1'] = $this->m_perdin->get_perdin($id);
  // $data['step'] = "update";
  $data['perdin_grup'] = $this->m_perdin->get_perdin_sp($id);
  // var_dump($data['perdin_grup']);die();

  $data['perdin_no_grup'] = $this->m_perdin->get_perdin_join_tim_tot($data['perdin_grup']->no_grup_perdin, $data['perdin_grup']->id_tim);

  $data['step'] = "update";
  $method = "save";
  $data['save_method'] = $method;
  $data['kabupaten'] = $this->m_perdin->get_kabupaten();

  $data['lokasi'] = "";

  $pendaftaran = new tmpermohonan();
  $pendaftaran->where('id', $id)->get();
  $pendaftaran->tmpemohon->get();
  $pendaftaran->trperizinan->get();
  $pendaftaran->trtanggal_survey->get();

  $survey_date = new trtanggal_survey();
  $survey_date->where('id', $pendaftaran->trtanggal_survey->id)->get();
  $survey_date->tmpegawai->get();

  $petugas = new tmpegawai();
  $data['petugas'] = $petugas->where('status = 1 OR status = 2')->get();
  $data['petugas_id'] = $survey_date->tmpegawai->id;
  
  $petugas = new tmpegawai();
  $data['list'] = $petugas->where('unitkerja_id', 1)->order_by('golongan', "DESC")->get();
  // var_dump( $data['list']);die();
  $data['itberangkat_asal_daerah1'] = $this->m_perdin->get_kabupaten();
  $data['itberangkat_tujuan1'] = $this->m_perdin->get_kabupaten();
  $data['itkembali_tujuan1'] = $this->m_perdin->get_kabupaten();
  $data['itkembali_asal_daerah1'] = $this->m_perdin->get_kabupaten();

  $data['pegawai'] = $this->m_perdin->get_pegawai(); 
  $data['surat_kode_reg'] = $this->m_perdin->get_kode_reg();

  $js_date = " $(function() {
               $(\".survey\").datepicker({
                 changeMonth: true,
                 changeYear: true,
                 dateFormat: 'yy-mm-dd',
                 closeText: 'X'
               });
             });
           ";

  $js_date .= "$(document).ready(
               function() {
                 $('#listizin').multiselect().multiselectfilter({
                   show:'blind',
                   hide:'blind',
                   selectedText:'# dari # terpilih'
                 }
               );
             });
            ";
  $js =  "
             $(document).ready(function() {
              oTable = $('#pendataan').dataTable({
                \"bJQueryUI\": true,
                \"sPaginationType\": \"full_numbers\"
              });
            });
          $(document).ready(function() {
              $(\"#tabs\").tabs();
              $('.monbulan').datepicker({
                  changeMonth: true,
                  changeYear: true,
                  dateFormat: 'yy-mm-dd',
                  closeText: 'X'
              });
              $('#form').validate();
              $('.pilihan').select2();
          });
  
          function finishAjax(id, response){
              $('#'+id).html(unescape(response));
              $('#'+id).fadeIn();
          } 
      ";

  $this->template->set_metadata_javascript($js);
  // $this->template->set_metadata_javascript($js_date);
  $this->load->vars($data);
  $this->session_info['page_name'] = "Penomoran Surat Perintah Perjalanan Dinas";
  $this->template->build('penomoran_sp_perdin', $this->session_info);
}

public function approve_surat_perdin($id = NULL , $id_tim = NULL) {
  // $no__sppd = $this->m_perdin->get_no_sppd($id);
  // $data['perdin'] = $this->m_perdin->get_perdin_sppd($no__sppd);
  // $data['perdin'] = $this->m_perdin->get_perdin_sppd($no__sppd);
  // $data['perdin1'] = $this->m_perdin->get_perdin($id);
  // $data['step'] = "update";
     $admin = "";
      if ($this->All) { 
        $data['admin'] = 1;
      } else {
        $data['admin'] = 0;
      }
  $data['perdin_grup'] = $this->m_perdin->get_perdin_sp($id);
  $data['perdin_no_grup'] = $this->m_perdin->get_perdin_join_tim_tot($data['perdin_grup']->no_grup_perdin, $data['perdin_grup']->id_tim);
  // var_dump($data['perdin_grup']);die();
  $data['user_id'] = $this->session->userdata('id_auth'); 

  $data['step'] = "update";
  $method = "save";
  $data['save_method'] = $method;
  $data['kabupaten'] = $this->m_perdin->get_kabupaten();
  // var_dump($data['kabupaten']);die();

  $data['lokasi'] = "";

  $pendaftaran = new tmpermohonan();
  $pendaftaran->where('id', $id)->get();
  $pendaftaran->tmpemohon->get();
  $pendaftaran->trperizinan->get();
  $pendaftaran->trtanggal_survey->get();

  $survey_date = new trtanggal_survey();
  $survey_date->where('id', $pendaftaran->trtanggal_survey->id)->get();
  $survey_date->tmpegawai->get();

  $petugas = new tmpegawai();
  $data['petugas'] = $petugas->where('status = 1 OR status = 2')->get();
  $data['petugas_id'] = $survey_date->tmpegawai->id;
  
  $petugas = new tmpegawai();
  $data['list'] = $petugas->where('unitkerja_id', 1)->order_by('golongan', "DESC")->get();
  // var_dump( $data['list']);die();
  $data['itberangkat_asal_daerah1'] = $this->m_perdin->get_kabupaten();
  $data['itberangkat_tujuan1'] = $this->m_perdin->get_kabupaten();
  $data['itkembali_tujuan1'] = $this->m_perdin->get_kabupaten();
  $data['itkembali_asal_daerah1'] = $this->m_perdin->get_kabupaten();

  $data['pegawai'] = $this->m_perdin->get_pegawai(); 
  $data['surat_kode_reg'] = $this->m_perdin->get_kode_reg();

  $js_date = " $(function() {
               $(\".survey\").datepicker({
                 changeMonth: true,
                 changeYear: true,
                 dateFormat: 'yy-mm-dd',
                 closeText: 'X'
               });
             });
           ";

  $js_date .= "$(document).ready(
               function() {
                 $('#listizin').multiselect().multiselectfilter({
                   show:'blind',
                   hide:'blind',
                   selectedText:'# dari # terpilih'
                 }
               );
             });
            ";
  $js =  "
             $(document).ready(function() {
              oTable = $('#pendataan').dataTable({
                \"bJQueryUI\": true,
                \"sPaginationType\": \"full_numbers\"
              });
            });
          $(document).ready(function() {
              $(\"#tabs\").tabs();
              $('.monbulan').datepicker({
                  changeMonth: true,
                  changeYear: true,
                  dateFormat: 'yy-mm-dd',
                  closeText: 'X'
              });
              $('#form').validate();
              $('.pilihan').select2();
          });
  
          function finishAjax(id, response){
              $('#'+id).html(unescape(response));
              $('#'+id).fadeIn();
          } 
      ";

  $this->template->set_metadata_javascript($js);
  // $this->template->set_metadata_javascript($js_date);
  $this->load->vars($data);
  $this->session_info['page_name'] = "Approve Surat Perintah Perjalanan Dinas";
  $this->template->build('approve_surat', $this->session_info);
}
//   public function ubah_sp_perdin($id) {
//     $data['perdin_grup'] = $this->m_perdin->get_perdin_sp($id);
//     $data['perdin_no_grup'] = $this->m_perdin->get_perdin_sp($id);

//     // var_dump($data['perdin_no_grup']);die();
//     $data['step'] = "update";
//     $data['kabupaten'] = $this->m_perdin->get_kabupaten();

//     $data['itberangkat_asal_daerah1'] = $this->m_perdin->get_kabupaten();
//     $data['itberangkat_tujuan1'] = $this->m_perdin->get_kabupaten();
//     $data['itkembali_tujuan1'] = $this->m_perdin->get_kabupaten();
//     $data['itkembali_asal_daerah1'] = $this->m_perdin->get_kabupaten();

//     $data['pegawai'] = $this->m_perdin->get_pegawai(); 
//     $js =  "
//             $(document).ready(function() {
//                 $(\"#tabs\").tabs();
//                 $('.monbulan').datepicker({
//                     changeMonth: true,
//                     changeYear: true,
//                     dateFormat: 'yy-mm-dd',
//                     closeText: 'X'
//                 });
//                 $('#form').validate();
//                 $('.pilihan').select2();
//             });
    
//             function finishAjax(id, response){
//                 $('#'+id).html(unescape(response));
//                 $('#'+id).fadeIn();
//             } 

//               $(document).ready(
//                    function() {
//                      $('#listizin').multiselect({
//                       buttonWidth: '75%'
//                      }).multiselectfilter({
//                        show:'blind',
//                        hide:'blind',
//                        selectedText:'# dari # terpilih'
//                      }
//                    );
//                    $('#listizin .ui-multiselect').css('width', '75%');
//                  });
//         ";
  
//     $this->template->set_metadata_javascript($js);
//     $this->load->vars($data);
//     $this->session_info['page_name'] = "Ubah Data Perdin";
//     $this->template->build('sp_perdin_edit', $this->session_info);
// }
  function get_number($number){
  	// var_dump($number);die();
  	$result =  filter_var($number, FILTER_SANITIZE_NUMBER_INT);
  	return $result;
  }

   public function simpan() {
          $pkepada      = $this->input->post('listizin');
          // var_dump($pkepada);die();
          if($pkepada){
            $user_kepada  = ($pkepada ? $pkepada : Array());
            // $beda =  round(abs(strtotime($tglberangkat) - strtotime($tglkembali))/86400)+1;

            if (!empty($user_kepada)) {
                foreach ($user_kepada as $row) {

                $user_id = $this->session->userdata('id_auth'); 

                $no_bku = $this->input->post('no_bku');
                $uraian = $this->input->post('uraian');
                $tujuan = $this->input->post('kabupaten');
                // var_dump($tujuan);die();
                $skpd = "Dinas PMPTSP Jawa Barat";//$this->input->post('skpd');
                $no__sppd = $this->input->post('no__sppd');               
                $tanggal_berangkat =$this->input->post('tanggal_berangkat');
                $tgl_pembayaran =$this->input->post('tgl_pembayaran');
                $tgl_surat = $this->input->post('tgl_surat');
                $tanggal_kembali = $this->input->post('tanggal_kembali');
                 $lama_p_d =  round(abs(strtotime($tanggal_berangkat) - strtotime($tanggal_kembali))/86400)+1;
                $uang_hari = ($this->input->post('uang_hari'));
                $harga_hari = $this->m_perdin->get_number($this->input->post('harga_hari'));
                $jumlah_uang = $uang_hari*$harga_hari;
                // var_dump($jumlah_uang);die();
                $representasi_hari = ($this->input->post('representasi_hari'));
                $representasi_harga = $this->m_perdin->get_number($this->input->post('representasi_harga'));
                $jumlah_representasi = $representasi_hari*$representasi_harga;
                $uang_sakuhari = ($this->input->post('uang_sakuhari'));
                $uang_sakuharga = $this->m_perdin->get_number($this->input->post('uang_sakuharga'));
                $uang_saku_peserta_jumlah = $uang_sakuhari*$uang_sakuharga;
                $penginapan_malam = ($this->input->post('penginapan_malam'));
                $penginapan_harga = $this->m_perdin->get_number($this->input->post('penginapan_harga'));
                $penginapan_jumlah = $penginapan_malam * $penginapan_harga;
                $tikettol_pulang = $this->m_perdin->get_number($this->input->post('tikettol_pulang'));
                $tikettol_pergi = $this->m_perdin->get_number($this->input->post('tikettol_pergi'));
                $tikettol_jumlah = $tikettol_pulang + $tikettol_pergi;
                $s_t_k_asal_hari = ($this->input->post('s_t_k_asal_hari'));
                $s_t_k_asal_harga = $this->m_perdin->get_number($this->input->post('s_t_k_asal_harga'));
                $s_t_k_asal_jumlah = $s_t_k_asal_hari*$s_t_k_asal_harga;
                $s_t_k_tujuan_hari = ($this->input->post('s_t_k_tujuan_hari'));
                $s_t_k_tujuan_harga = $this->m_perdin->get_number($this->input->post('s_t_k_tujuan_harga'));
                $s_t_k_tujuan_jumlah = $s_t_k_tujuan_hari*$s_t_k_tujuan_harga;
                $sewa_kendaraan_hari = ($this->input->post('sewa_kendaraan_hari'));
                $sewa_kendaraan_harga = $this->m_perdin->get_number($this->input->post('sewa_kendaraan_harga'));
                $sewa_kendaraan_jumlah = $sewa_kendaraan_hari*$sewa_kendaraan_harga;
                $bbm_liter = ($this->input->post('bbm_liter'));
                $bbm_harga = $this->m_perdin->get_number($this->input->post('bbm_harga'));
                $bbm_jumlah = $bbm_liter*$bbm_harga;
                $swabdi_kota_asal = $this->m_perdin->get_number($this->input->post('swabdi_kota_asal'));
                $swabdi_kota_tujuan = $this->m_perdin->get_number($this->input->post('swabdi_kota_tujuan'));
                $swab_jumlah = $swabdi_kota_asal+$swabdi_kota_tujuan;
                $jumlah_total = $jumlah_uang+$jumlah_representasi+$uang_saku_peserta_jumlah+$penginapan_jumlah+$tikettol_jumlah+$s_t_k_asal_jumlah+$s_t_k_tujuan_jumlah+$sewa_kendaraan_jumlah+$bbm_jumlah+$swab_jumlah;
                $itberangkat_maskapai = ($this->input->post('itberangkat_maskapai'));
                $itberangkat_no_tiket = ($this->input->post('itberangkat_no_tiket'));
                $itberangkat_kodebooking = ($this->input->post('itberangkat_kodebooking'));
                $itberangkat_no_penerbangan = ($this->input->post('itberangkat_no_penerbangan'));
                $itberangkat_asal_daerah = ($this->input->post('itberangkat_asal_daerah1'));
                $itberangkat_tujuan = ($this->input->post('itberangkat_tujuan1'));
                $itberangkat_tanggal = ($this->input->post('itberangkat_tanggal'));
                $itberangkat_kelas = ($this->input->post('itberangkat_kelas'));
                $itberangkat_harga_tiket = $this->m_perdin->get_number($this->input->post('itberangkat_harga_tiket'));
                $itkembali_maskapai = ($this->input->post('itkembali_maskapai'));
                $itkembali_nama = ($this->input->post('itkembali_nama'));
                $itkembali_no_tiket = ($this->input->post('itkembali_no_tiket'));
                $itkembali_kode_booking = ($this->input->post('itkembali_kode_booking'));
                $itkembali_no_penerbangan = ($this->input->post('itkembali_no_penerbangan'));
                $itkembali_asal_daerah = ($this->input->post('itkembali_asal_daerah1'));
                $itkembali_tujuan = ($this->input->post('itkembali_tujuan1'));
                $itkembali_tanggal = ($this->input->post('itkembali_tanggal'));
                // var_dump($itkembali_tanggal);die();
                $itkembali_kelas = ($this->input->post('itkembali_kelas'));
                $itkembali_harga_tiket = $this->m_perdin->get_number($this->input->post('itkembali_harga_tiket'));
                $nama_penginapan = ($this->input->post('nama_penginapan'));
                $keterangan = ($this->input->post('keterangan'));
                
              


                $simpan = $this->m_perdin->save_data( $tgl_pembayaran, $user_id, $row, $lama_p_d, $no_bku, $uraian, $tujuan, $skpd, $no__sppd, $tanggal_berangkat, $tgl_surat, $tanggal_kembali, $uang_hari, $harga_hari, $jumlah_uang, $representasi_hari, $representasi_harga, $jumlah_representasi, $uang_sakuhari, $uang_sakuharga, $uang_saku_peserta_jumlah, $penginapan_malam, $penginapan_harga, $penginapan_jumlah, $tikettol_pulang, $tikettol_pergi, $tikettol_jumlah, $s_t_k_asal_hari, $s_t_k_asal_harga, $s_t_k_asal_jumlah, $s_t_k_tujuan_hari, $s_t_k_tujuan_harga, $s_t_k_tujuan_jumlah, $sewa_kendaraan_hari, $sewa_kendaraan_harga, $sewa_kendaraan_jumlah, $bbm_liter, $bbm_harga, $bbm_jumlah, $swabdi_kota_asal, $swabdi_kota_tujuan, $swab_jumlah, $jumlah_total, $itberangkat_maskapai, $itberangkat_no_tiket, $itberangkat_kodebooking, $itberangkat_no_penerbangan, $itberangkat_asal_daerah, $itberangkat_tujuan, $itberangkat_tanggal, $itberangkat_kelas, $itberangkat_harga_tiket, $itkembali_maskapai, $itkembali_nama, $itkembali_no_tiket, $itkembali_kode_booking, $itkembali_no_penerbangan, $itkembali_asal_daerah, $itkembali_tujuan, $itkembali_tanggal, $itkembali_kelas, $itkembali_harga_tiket, $nama_penginapan, $keterangan);

                

                 

                  // $save_kepada = $this->m_persuratan->save_tim($id, $row, $lokasi,  $tglberangkat, $tglkembali, $beda);

                  if(!$simpan) {
                    $this->session->set_flashdata('gagal', "Gagal Menyimpan Data 1");
                    redirect('/perdin/add/');
                  }
                }

              }

      }
      $this->session->set_flashdata('sukses', "Berhasil Menyimpan Data 1");
      redirect('/perdin');
  }

  public function update_penomoran($id, $id_tim) {
    // Ambil data input dari form

    $data = $this->m_perdin->get_perdin($id,$id_tim);
 
    
    

    $no__sppd = $this->input->post('no__sppd');
    $tanggal_berangkat = $this->input->post('tglberangkat');
    $tanggal_kembali = $this->input->post('tglkembali');
    $tgl_surat = $this->input->post('tgl_surat');
    
    $detail_tempat_pemberangkatan = $this->input->post('detail_tempat_pemberangkatan');
    $kendaraan = $this->input->post('kendaraan');

    $mksd_pemberangkatan = $this->input->post('mksd_pemberangkatan');
    $kode_rek_sub_req = $this->input->post('kode_rek_sub_req');
    $perihal_srt_undangan = $this->input->post('perihal_srt_undangan');
    $nmr_srt_undangan = $this->input->post('nmr_srt_undangan');
    $tgl_srt_undangan = $this->input->post('tgl_srt_undangan');
    $tipe_undangan = $this->input->post('tipe_undangan');
    $srt_instansi_undangan = $this->input->post('srt_instansi_undangan');
         require_once 'assets/phpword/src/PhpWord/Autoloader.php';
        \PhpOffice\PhpWord\Autoloader::register();
          foreach ($data as $key => $data_file) {
            $kode_tim_file = $this->m_perdin->get_tim_details($data_file->id_tim);
            // Path ke file template yang sudah ada
            if ($data_file->id_pegawai == "1152") {
                continue;
            }elseif ($data_file->id_pegawai == "31"){
              $templateFile = "assets/file_surat_perdin/kadis_sekdis/{$data_file->file_srt}";

            }else{
              
              if (strpos($data_file->file_srt, 'upload') !== false) {
                  // Jika ada "upload" dalam nama file, simpan di folder "uploads"
                  $templateFile = "assets/file_surat_perdin/upload/{$data_file->file_srt}";
              } else {
                  // Jika tidak, simpan di folder default
                  $templateFile = "assets/file_surat_perdin/{$data_file->file_srt}";
              }
              

            }
            $get_data_pegawai = $this->m_perdin->get_n_pegawai_perdin($data_file->id_pegawai);
            $get_tim = $this->m_perdin->get_perdin_join_tim_tot($id, $id_tim);
            $get_tujuan = $this->m_perdin->get_tujuan_keberangkatan_perdin($id, $id_tim);
            $tujuan = json_decode($get_tujuan[0]->kab_kota, true);
            $tanggal_berangkat = date("d-F-Y", strtotime($get_tim[0]->tanggal_berangkat));
            $nama_tim = ucwords(strtolower($get_tim[0]->nama_tim));

            $n_pesan = "Anda ditugaskan untuk perjalanan dinas pada kegiatan {$data_file->mksd_pemberangkatan} 
            dari tim {$nama_tim} pada tanggal {$tanggal_berangkat} 
            ke {$tujuan[0]}. 

            Surat perintah dapat dilihat pada link berikut:
            https://dpmptsp.jabarprov.go.id/jelita/backoffice/survey/sp_saya";
            // var_dump($get_data_pegawai['telepon']);die();
            
            $kirim_notif = $this->m_perdin->postWaSms($get_data_pegawai['telepon'], $n_pesan);
            
           

            // Path ke file template yang sudah ada
        
            if (!file_exists($templateFile)) {
                // File tidak ditemukan, tangani kesalahan
                die("Template file not found: {$templateFile}");
            }
    
            // Muat template menggunakan TemplateProcessor
            $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor($templateFile);
    
            // Mendapatkan tanggal dan informasi lainnya
            $arrblnRomawi = array("I","II","III","IV","V","VI",'VII','VIII','IX','X','XI','XII');
            $blnRomawi = $arrblnRomawi[date("m")-1];
            setlocale(LC_TIME, 'id_ID.utf8');
    
            $hari_ttd = strftime('%A', time()); // Nama hari
            $tgl_ttd = strftime('%d', time()); // Tanggal (angka)
            $bln_ttd = strftime('%B', time()); // Nama bulan

              // Ganti "Pebruari" menjadi "Februari"
              $bln_ttd = str_replace("Pebruari", "Februari", $bln_ttd); // Nama bulan
            $tahun_text = strftime('%Y', time()); // Tahun (angka)
    
            $random_number = mt_rand(1000, 9999);
            $tanggal_hari_ini = date('dmY');
            $nomor_format = $no__sppd;

            // var_dump($kode_tim_file);die();
            // Ganti nilai placeholder di template
            $templateProcessor->setValue('no_surat', $nomor_format);
            $templateProcessor->setValue('no_urut', $data_file->no_grup_perdin);
      
                $templateProcessor->setValue('kode_tim', $kode_tim_file->kode_tim_ketua);

            $templateProcessor->setValue('tgl_surat', "{$tgl_ttd} {$bln_ttd} {$tahun_text}");
            // Simpan perubahan ke file baru

            if ($data_file->id_pegawai == "31") {
              $filename = 'assets/file_surat_perdin/kadis_sekdis/SPPD_' . date('Ymd') . '_' . $data_file->no_grup_perdin . '_' . $kode_tim_file->kode_tim_ketua . '_sekdis.docx';
              $filename_simpan = 'SPPD_' . date('Ymd') . '_' . $data_file->no_grup_perdin . '_' . $kode_tim_file->kode_tim_ketua . '_sekdis.docx';
      
            }else{
              $filename = 'assets/file_surat_perdin/SPPD_' . date('Ymd') . '_' . $data_file->no_grup_perdin . '_' . $kode_tim_file->kode_tim_ketua . '_penomoran_pegawai.docx';
              $filename_simpan = 'SPPD_' . date('Ymd') . '_' . $data_file->no_grup_perdin . '_' . $kode_tim_file->kode_tim_ketua . '_penomoran_pegawai.docx';
            }
      
           
            
            // Update database jika perlu
         
            $data = [
                'file_srt' => $filename_simpan,
            ];
            $update_perdin = $this->m_perdin->update_e_perdin($data_file->id, $data);
    
            // Simpan file Word yang sudah diedit

            $templateProcessor->saveAs($filename);
            
            // echo "File berhasil diperbarui: {$filename}";
          }
          $data = [
            'tgl_surat' => date('Y-m-d'), // Format: 2024-01-30
            'no__sppd'  => $no__sppd,
        ];
        // var_dump($kirim_notif);die();
        $simpan = $this->m_perdin->update_e_perdin_by_no_grup_perdin($id,$id_tim,$data);
        

    // Cek apakah update berhasil
    if ($simpan) {
        $this->session->set_flashdata('sukses', "Berhasil Mengupdate Data.");
            redirect('/perdin/suratperintah/');
        

    } else {
        $this->session->set_flashdata('gagal', "Gagal Mengupdate Data");
            redirect('/perdin/suratperintah/');
        



    }
}
 public function update_approve_surat($id, $id_tim) {
    // Ambil data input dari form

    $data = $this->m_perdin->get_perdin($id,$id_tim);
 
    $status_approve = $this->input->post('status_approve');
    
    

    $no__sppd = $this->input->post('no__sppd');
    $tanggal_berangkat = $this->input->post('tglberangkat');
    $tanggal_kembali = $this->input->post('tglkembali');
    $tgl_surat = $this->input->post('tgl_surat');
    
    $detail_tempat_pemberangkatan = $this->input->post('detail_tempat_pemberangkatan');
    $kendaraan = $this->input->post('kendaraan');

    $mksd_pemberangkatan = $this->input->post('mksd_pemberangkatan');
    $kode_rek_sub_req = $this->input->post('kode_rek_sub_req');
    $perihal_srt_undangan = $this->input->post('perihal_srt_undangan');
    $nmr_srt_undangan = $this->input->post('nmr_srt_undangan');
    $tgl_srt_undangan = $this->input->post('tgl_srt_undangan');
    $tipe_undangan = $this->input->post('tipe_undangan');
    $srt_instansi_undangan = $this->input->post('srt_instansi_undangan');
    $data = [
            'status_approve' => $status_approve, // Format: 2024-01-30
        ];
        $simpan = $this->m_perdin->update_e_perdin_by_no_grup_perdin($id,$id_tim,$data,$mksd_pemberangkatan);
        // var_dump($simpan);die(); 

        $data_log_perdin = [
              'id_user_pembuat' => $simpan['user_id'],
              'tanggal_pembuatan' => date('Y-m-d H:i:s'),
              'tanggal_approve' => date('Y-m-d H:i:s'),
              'status_approve' => $status_approve,
              'mksd_pemberangkatan' => $simpan['mksd_pemberangkatan'],
              'id_data_utama' => $simpan['id']
          ];


          $save_log_perdin  = $this->m_perdin->save_log_e_perdin($data_log_perdin);
          // var_dump($save_log_perdin);die();
    // Cek apakah update berhasil
    if ($simpan) {
        $this->session->set_flashdata('sukses', "Berhasil Mengupdate Data.");
            redirect('/perdin/suratperintah/');
        

    } else {
        $this->session->set_flashdata('gagal', "Gagal Mengupdate Data");
            redirect('/perdin/suratperintah/');
        



    }
}
public function konvert_pdf($name_file) {
  // Setup API client
  $opts = array('http' => array('header' => "User-Agent:MyAgent/1.0\r\n"));
  $context = stream_context_create($opts);

  $namafile = $name_file;

  // Perbaiki format nama file
  $namafile = str_replace('_docx', '.docx', $namafile);
  

  // Ambil data dari API
  $data = file_get_contents('http://103.122.5.250/siapi/api/perdin?id='.$namafile.'&token=9wdxc7txiH', FALSE, $context);
  // var_dump($data);
  // die();
  $json = json_decode($data);

  if ($json->status && $json->status == 'success') {
      // === Ambil PDF dari API ===
      $dtpdf = 'http://103.122.5.250/siapi/web/assets/pdf/' . preg_replace('/\s/i', '%20', $namafile) . '.pdf';
      $newfile = $_SERVER['DOCUMENT_ROOT'] . '/jelita/backoffice/assets/file_surat_perdin/' . $namafile . '.pdf';

      if (copy($dtpdf, $newfile)) {
          if (file_exists($newfile)) {
              // === Kirim file ke browser ===
              header('Content-Description: File Transfer');
              header('Content-Type: application/pdf');
              header('Content-Disposition: attachment; filename="' . basename($newfile) . '"');
              header('Expires: 0');
              header('Cache-Control: must-revalidate');
              header('Pragma: public');
              header('Content-Length: ' . filesize($newfile));
              readfile($newfile);
              exit;
          } else {
              echo "File tidak ditemukan: {$newfile}";
              return false;
          }
      } else {
          // === Jika gagal menyalin, buat file di server ===
          buat_pdf_local($namafile);
      }
  } else {
      // === Jika status API tidak sukses, buat file di server ===
      buat_pdf_local($namafile);
  }

}
function buat_pdf_local($namafile)
{
    require_once(APPPATH . 'libraries/fpdf/fpdf.php'); // pastikan FPDF tersedia
    $path = $_SERVER['DOCUMENT_ROOT'] . '/jelita/backoffice/assets/file_surat_perdin/' . $namafile . '.pdf';

    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 14);
    $pdf->Cell(0, 10, 'Gagal Mengambil File dari API', 0, 1, 'C');
    $pdf->SetFont('Arial', '', 12);
    $pdf->MultiCell(0, 8, "File ini dibuat otomatis di server karena proses pengambilan data dari API gagal.", 0, 'L');
    $pdf->Output('F', $path);

    // === Kirim file ke browser ===
    if (file_exists($path)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="' . basename($path) . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($path));
        readfile($path);
        exit;
    } else {
        echo "Gagal membuat file PDF di server.";
    }
}
public function konvert_pdf_sekdis_kadis($name_file) {
  // Setup API client
  $opts = array('http' => array('header' => "User-Agent:MyAgent/1.0\r\n"));
  $context = stream_context_create($opts);

  $namafile = $name_file;

  // Perbaiki format nama file
  $namafile = str_replace('_docx', '.docx', $namafile);
  

  // Ambil data dari API
  $data = file_get_contents('http://103.122.5.250/siapi/api/sekdis?id='.$namafile.'&token=9wdxc7txiH', FALSE, $context);
  // var_dump($data);
  // die();
  $json = json_decode($data);

  if ($json->status && $json->status == 'success') {
      // Path file PDF dari API
      $dtpdf = 'http://103.122.5.250/siapi/web/assets/pdf/' . preg_replace('/\s/i', '%20', $namafile) . '.pdf';
      // Path penyimpanan sementara di server
      $newfile = $_SERVER['DOCUMENT_ROOT'] . '/jelita/backoffice/assets/file_surat_perdin/' . $namafile . '.pdf';

      // Salin file PDF ke server
      if (copy($dtpdf, $newfile)) {
          // Cek apakah file berhasil disimpan
          if (file_exists($newfile)) {
              // Mengirim file ke browser untuk diunduh
              header('Content-Description: File Transfer');
              header('Content-Type: application/pdf');
              header('Content-Disposition: attachment; filename="' . basename($newfile) . '"');
              header('Expires: 0');
              header('Cache-Control: must-revalidate');
              header('Pragma: public');
              header('Content-Length: ' . filesize($newfile));
              readfile($newfile);

              // Hapus file sementara setelah diunduh
              // unlink($newfile);

              exit; // Menghentikan eksekusi setelah unduhan
          } else {
              echo "File tidak ditemukan: {$newfile}";
              return false;
          }
      } else {
          echo "Gagal menyalin file dari API.";
          return false;
      }
  } else {
      echo "Gagal mendapatkan data dari API atau status API tidak sukses.";
      return false;
  }
}


public function hapus_sp($id) {
  // Ambil data surat perjalanan dinas berdasarkan ID
  $data_sp = $this->m_perdin->get_perdin_sp($id);
  
  if (!$data_sp) {
      $this->session->set_flashdata('gagal', "Data tidak ditemukan.");
      redirect('perdin/ubah_sp_perdin/'.$id);
      return;
  }

  // Tentukan path file
  $file_path = 'assets/file_surat_perdin/' . $data_sp->file_srt;
  if (strpos($data_sp->file_srt, 'upload') !== false) {
      $file_path = 'assets/file_surat_perdin/upload/' . $data_sp->file_srt;
  }

  // Hapus file jika ada
  if (file_exists($file_path) && !empty($data_sp->file_srt)) {
      if (!unlink($file_path)) {
          log_message('error', 'Gagal menghapus file: ' . $file_path);
          $this->session->set_flashdata('gagal', "Gagal menghapus berkas.");
          redirect('perdin/ubah_sp_perdin/'.$id);
          return;
      }
  } else {
      log_message('error', 'File tidak ditemukan atau sudah terhapus: ' . $file_path);
  }

  // Update database untuk mengosongkan field file_srt
  $data = ['file_srt' => null];
  $update_perdin = $this->m_perdin->hapus_file_perdin($data_sp->no_grup_perdin, $data_sp->id_tim, $data);

  if ($update_perdin) {
      $this->session->set_flashdata('sukses', "Berhasil Menghapus Berkas.");
  } else {
      log_message('error', 'Gagal memperbarui database setelah menghapus file.');
      $this->session->set_flashdata('gagal', "Gagal memperbarui database.");
  }

  redirect('perdin/ubah_sp_perdin/'.$id);
}
public function update_e_perdin() {

  $id = ($this->input->post('id'));
  // var_dump($id);die();

  $id_pegawai = ($this->input->post('pegawai'));
  $user_id = $this->session->userdata('id_auth'); 
  $no_bku = $this->input->post('no_bku');
  $uraian = $this->input->post('uraian');
  $tujuan = $this->input->post('kabupaten');
   // var_dump($tujuan);die();
  $skpd = "Dinas PMPTSP Jawa Barat";//$this->input->post('skpd');
  $no__sppd = $this->input->post('no__sppd');
  $tanggal_berangkat =$this->input->post('tanggal_berangkat');
  $tgl_pembayaran =$this->input->post('tgl_pembayaran');
  // 
  $tgl_surat = $this->input->post('tgl_surat');
  $tanggal_kembali = $this->input->post('tanggal_kembali');
  $lama_p_d =  round(abs(strtotime($tanggal_berangkat) - strtotime($tanggal_kembali))/86400)+1;
  $uang_hari = ($this->input->post('uang_hari'));
  $harga_hari = $this->m_perdin->get_number($this->input->post('harga_hari'));
  $jumlah_uang = $uang_hari*$harga_hari;
  var_dump($jumlah_uang);die();
  $representasi_hari = ($this->input->post('representasi_hari'));
  $representasi_harga = $this->m_perdin->get_number($this->input->post('representasi_harga'));
  $jumlah_representasi = $representasi_hari*$representasi_harga;
  $uang_sakuhari = ($this->input->post('uang_sakuhari'));
  $uang_sakuharga = $this->m_perdin->get_number($this->input->post('uang_sakuharga'));
  $uang_saku_peserta_jumlah = $uang_sakuhari*$uang_sakuharga;
  $penginapan_malam = ($this->input->post('penginapan_malam'));
  $penginapan_harga = $this->m_perdin->get_number($this->input->post('penginapan_harga'));
  $penginapan_jumlah = $penginapan_malam * $penginapan_harga;
  $tikettol_pulang = $this->m_perdin->get_number($this->input->post('tikettol_pulang'));
  $tikettol_pergi = $this->m_perdin->get_number($this->input->post('tikettol_pergi'));
  $tikettol_jumlah = $tikettol_pulang + $tikettol_pergi;
  $s_t_k_asal_hari = ($this->input->post('s_t_k_asal_hari'));
  $s_t_k_asal_harga = $this->m_perdin->get_number($this->input->post('s_t_k_asal_harga'));
  $s_t_k_asal_jumlah = $s_t_k_asal_hari*$s_t_k_asal_harga;
  $s_t_k_tujuan_hari = ($this->input->post('s_t_k_tujuan_hari'));
  $s_t_k_tujuan_harga = $this->m_perdin->get_number($this->input->post('s_t_k_tujuan_harga'));
  $s_t_k_tujuan_jumlah = $s_t_k_tujuan_hari*$s_t_k_tujuan_harga;
  $sewa_kendaraan_hari = ($this->input->post('sewa_kendaraan_hari'));
  $sewa_kendaraan_harga = $this->m_perdin->get_number($this->input->post('sewa_kendaraan_harga'));
  $sewa_kendaraan_jumlah = $sewa_kendaraan_hari*$sewa_kendaraan_harga;
  $bbm_liter = ($this->input->post('bbm_liter'));
  $bbm_harga = $this->m_perdin->get_number($this->input->post('bbm_harga'));
  $bbm_jumlah = $bbm_liter*$bbm_harga;
  $swabdi_kota_asal = $this->m_perdin->get_number($this->input->post('swabdi_kota_asal'));
  $swabdi_kota_tujuan = $this->m_perdin->get_number($this->input->post('swabdi_kota_tujuan'));
  $swab_jumlah = $swabdi_kota_asal+$swabdi_kota_tujuan;
  $jumlah_total = $jumlah_uang+$jumlah_representasi+$uang_saku_peserta_jumlah+$penginapan_jumlah+$tikettol_jumlah+$s_t_k_asal_jumlah+$s_t_k_tujuan_jumlah+$sewa_kendaraan_jumlah+$bbm_jumlah+$swab_jumlah;
  $itberangkat_maskapai = ($this->input->post('itberangkat_maskapai'));
  $itberangkat_no_tiket = ($this->input->post('itberangkat_no_tiket'));
  $itberangkat_kodebooking = ($this->input->post('itberangkat_kodebooking'));
  $itberangkat_no_penerbangan = ($this->input->post('itberangkat_no_penerbangan'));
  $itberangkat_asal_daerah = ($this->input->post('itberangkat_asal_daerah1'));
  $itberangkat_tujuan = ($this->input->post('itberangkat_tujuan1'));
  $itberangkat_tanggal = ($this->input->post('itberangkat_tanggal'));
  $itberangkat_kelas = ($this->input->post('itberangkat_kelas'));
  $itberangkat_harga_tiket = $this->m_perdin->get_number($this->input->post('itberangkat_harga_tiket'));
  $itkembali_maskapai = ($this->input->post('itkembali_maskapai'));
  $itkembali_nama = ($this->input->post('itkembali_nama'));
  $itkembali_no_tiket = ($this->input->post('itkembali_no_tiket'));
  $itkembali_kode_booking = ($this->input->post('itkembali_kode_booking'));
  $itkembali_no_penerbangan = ($this->input->post('itkembali_no_penerbangan'));
  $itkembali_asal_daerah = ($this->input->post('itkembali_asal_daerah1'));
  $itkembali_tujuan = ($this->input->post('itkembali_tujuan1'));
  $itkembali_tanggal = ($this->input->post('itkembali_tanggal'));
  $itkembali_kelas = ($this->input->post('itkembali_kelas'));
  $itkembali_harga_tiket = $this->m_perdin->get_number($this->input->post('itkembali_harga_tiket'));
  $nama_penginapan = ($this->input->post('nama_penginapan'));
  $keterangan = ($this->input->post('keterangan'));


  $simpan = $this->m_perdin->update_data($tgl_pembayaran, $user_id, $lama_p_d,$id,$id_pegawai, $no_bku, $uraian, $tujuan, $skpd, $no__sppd, $tanggal_berangkat, $tgl_surat, $tanggal_kembali, $uang_hari, $harga_hari, $jumlah_uang, $representasi_hari, $representasi_harga, $jumlah_representasi, $uang_sakuhari, $uang_sakuharga, $uang_saku_peserta_jumlah, $penginapan_malam, $penginapan_harga, $penginapan_jumlah, $tikettol_pulang, $tikettol_pergi, $tikettol_jumlah, $s_t_k_asal_hari, $s_t_k_asal_harga, $s_t_k_asal_jumlah, $s_t_k_tujuan_hari, $s_t_k_tujuan_harga, $s_t_k_tujuan_jumlah, $sewa_kendaraan_hari, $sewa_kendaraan_harga, $sewa_kendaraan_jumlah, $bbm_liter, $bbm_harga, $bbm_jumlah, $swabdi_kota_asal, $swabdi_kota_tujuan, $swab_jumlah, $jumlah_total, $itberangkat_maskapai, $itberangkat_no_tiket, $itberangkat_kodebooking, $itberangkat_no_penerbangan, $itberangkat_asal_daerah, $itberangkat_tujuan, $itberangkat_tanggal, $itberangkat_kelas, $itberangkat_harga_tiket, $itkembali_maskapai, $itkembali_nama, $itkembali_no_tiket, $itkembali_kode_booking, $itkembali_no_penerbangan, $itkembali_asal_daerah, $itkembali_tujuan, $itkembali_tanggal, $itkembali_kelas, $itkembali_harga_tiket, $nama_penginapan, $keterangan);
  
  // if($user_id == 680){
  //   var_dump($simpan);die();
  // }
  // $file = $_FILES["file_evidence"]["name"];
  //   $file_name = basename($_FILES["file_evidence"]["name"]);
  //   $ext = pathinfo($file, PATHINFO_EXTENSION);
    
  //   $target_dir = "assets/assets/calen/ereport/";
  //   $target_file = $target_dir . $file_name;

  //   $fileBaru = $target_dir.'evidence_'.$id.'.'.$ext;

  //   $upload = move_uploaded_file($_FILES["file_evidence"]["tmp_name"], $target_file);

    if($simpan) {
      // $rnm = rename($target_file, $fileBaru);
       $this->session->set_flashdata('sukses', "Berhasil Mengupdate Data.");
        redirect('perdin');
      }
      else {
      $this->session->set_flashdata('gagal', "Gagal Mengupdate Data");
      redirect('perdin');
    }

}
public function update ($id,$id_tim_parameter) {

  // Ambil data input dari form
  // Ambil data izin yang ada di database berdasarkan $id
  $pkepada = $this->input->post('listizin');
    // Pastikan $pkepada adalah array
    $id = intval($id); // Mengonversi $id menjadi integer
    $id_pegawai = $this->input->post('listizin');

    // Pastikan $pkepada adalah array
    if (!is_array($id_pegawai)) {
        $id_pegawai = [];
    }

    // ID yang harus dipindahkan ke akhir
    $prioritas = [1152, 31];

    // Cek apakah ID prioritas ada dalam array
    $adaPrioritas = array_intersect($id_pegawai, $prioritas);

    if (!empty($adaPrioritas)) {
        // Pisahkan elemen prioritas dari array utama
        $normal = array_diff($id_pegawai, $prioritas);
        $akhir = array_intersect($id_pegawai, $prioritas);

        // Gabungkan kembali dengan elemen prioritas di akhir
        $id_pegawai = array_merge($normal, $akhir);
    }
 
    function hitungHari($tgl_awal, $tgl_akhir) {
        // Cek apakah tanggal kosong atau bernilai "0000-00-00"
        if (empty($tgl_awal) || empty($tgl_akhir) || $tgl_awal == "0000-00-00" || $tgl_akhir == "0000-00-00") {
            return 0;
        }

        $awal  = new DateTime($tgl_awal);
        $akhir = new DateTime($tgl_akhir);

        // Jika tanggal berangkat sama dengan tanggal kembali, hitungan = 1 hari
        if ($awal == $akhir) {
            return 1;
        }

        // Hitung selisih hari
        return $awal->diff($akhir)->days + 1; // +1 agar hari pertama tetap dihitung
    }
    $tglberangkat  = $this->input->post('tglberangkat');
    $tglkembali    = $this->input->post('tglkembali');
    $tglberangkat2 = $this->input->post('tglberangkat2');
    $tglkembali2   = $this->input->post('tglkembali2');
    $tglberangkat3 = $this->input->post('tglberangkat3');
    $tglkembali3   = $this->input->post('tglkembali3');
    $detail_tempat_1   = $this->input->post('detail_tempat_1');
    $detail_tempat_2   = $this->input->post('detail_tempat_2');
    $detail_tempat_3   = $this->input->post('detail_tempat_3');
    $titik_lokasi = $this->input->post('titik_lokasi');
    $id_perdin = $this->input->post('id_perdin');
          // var_dump($titik_lokasi);die();
          // $tipe_undangan   = $this->input->post('tipe_undangan');

          // Menghitung hari untuk perjalanan pertama
          $hari1 = hitungHari($tglberangkat, $tglkembali);

          // Jika tglberangkat2 kosong atau "0000-00-00", hanya hitung hari pertama
          if ($tglberangkat2 == "0000-00-00" || empty($tglberangkat2)) {
              $total_hari = $hari1;
          } else {
              // Menghitung hari untuk perjalanan kedua dan ketiga
              $hari2 = hitungHari($tglberangkat2, $tglkembali2);
              $hari3 = hitungHari($tglberangkat3, $tglkembali3);

              // Koreksi jika ada tumpang tindih hari
              if (!empty($tglkembali) && !empty($tglberangkat2) && $tglkembali == $tglberangkat2) {
                  $hari2--; // Hilangkan satu hari karena dihitung dua kali
              }
              if (!empty($tglkembali2) && !empty($tglberangkat3) && $tglkembali2 == $tglberangkat3) {
                  $hari3--; // Hilangkan satu hari karena dihitung dua kali
              }

              // Jika tglberangkat3 kosong atau "0000-00-00", hanya hitung sampai perjalanan kedua
              if ($tglberangkat3 == "0000-00-00" || empty($tglberangkat3)) {
                  $total_hari = $hari1 + $hari2;
              } else {
                  $total_hari = $hari1 + $hari2 + $hari3;
              }
          }

          // $data = $this->m_perdin->get_perdin($id);
          $user_id = $this->session->userdata('id_auth'); 
          $uraian = $this->input->post('uraian');
          $tujuan = $this->input->post('kabupaten');
          if (count($tujuan) > 3) {
              // Jika jumlah tujuan lebih dari 3, hentikan proses dan kembalikan pesan error
              echo json_encode(['status' => 'error', 'message' => 'Maksimal 3 tujuan diperbolehkan.']);
              exit; // Hentikan eksekusi script
          }
          // $nama_tujuan = $this->m_perdin->get_kabupaten_name($tujuan);
          $skpd = "Dinas PMPTSP Jawa Barat";
          $no__sppd = $this->input->post('no__sppd');
          $no__sppd = empty($no__sppd) ? null : $no__sppd;

          $tanggal_berangkat = $this->input->post('tglberangkat');
          $tanggal_kembali = $this->input->post('tglkembali');
          $tgl_surat = $this->input->post('tgl_surat');

          // If the value of $tgl_surat is explicitly bool(false), set it to null
          $tgl_surat = ($tgl_surat === false) ? null : $tgl_surat;

          // var_dump($tgl_surat);die();
          $detail_tempat_pemberangkatan = $this->input->post('detail_tempat_pemberangkatan');
          $kendaraan = $this->input->post('kendaraan');
          $tanggal_sp_backdate = $this->input->post('tanggal_sp_backdate');
          $status_approve = $this->input->post('status_approve');
          // var_dump($status_approve);die();
          $mksd_pemberangkatan = $this->input->post('mksd_pemberangkatan');
          $kode_rek_sub_req = $this->input->post('kode_rek_sub_req');

          $perihal_srt_undangan = $this->input->post('perihal_srt_undangan');
          $nmr_srt_undangan = $this->input->post('nmr_srt_undangan');
          $tgl_srt_undangan = $this->input->post('tgl_srt_undangan');
          $tipe_undangan = $this->input->post('tipe_undangan');
          $srt_instansi_undangan = $this->input->post('srt_instansi_undangan');


          $dasar_arahan_pimpiman = $this->input->post('dasar_arahan_pimpiman');
          $pegawai_dinas_lain = $this->input->post('pegawai_dinas_lain');
          $kode_rek = $this->input->post('kode_rek');
          $file_srt = $this->input->post('file_srt');
          $id_tim = $this->input->post('id_tim');
          $lama_p_d = $total_hari;
          
          
              
          $data = [
            'user_id' => $user_id,
            'lama_p_d' => $lama_p_d,
            'uraian' => $uraian,
            'tujuan' => $tujuan,
            'skpd' => $skpd,
            'tanggal_berangkat' => $tanggal_berangkat,
            'tanggal_kembali' => $tanggal_kembali,
            'tgl_surat' => $tgl_surat,
            'file_srt' => $file_srt,
            'mksd_pemberangkatan' => $mksd_pemberangkatan,
            'kode_rek_sub_req' => $kode_rek_sub_req,
            'perihal_srt_undangan' => $perihal_srt_undangan,
            'nmr_srt_undangan' => $nmr_srt_undangan,
            'tgl_srt_undangan' => $tgl_srt_undangan,
            'tipe_undangan' => $tipe_undangan,
            'srt_instansi_undangan' => $srt_instansi_undangan,
            'id_tim' => $id_tim,
            'detail_tempat_pemberangkatan' => $detail_tempat_pemberangkatan,
            'dasar_arahan_pimpiman' => $dasar_arahan_pimpiman,
            'pegawai_dinas_lain' => $pegawai_dinas_lain,
            'kode_rek' => $kode_rek,
            'titik_lokasi' => $titik_lokasi,
            'kendaraan' => $kendaraan,
            'tanggal_sp_backdate' => $tanggal_sp_backdate,
            'status_approve' => $status_approve,
            
          ];

        require_once 'assets/phpword/src/PhpWord/Autoloader.php';
        \PhpOffice\PhpWord\Autoloader::register();
        foreach ($id_pegawai as $row) {

          $pil_tgl = date('Y-m-d', strtotime($tglberangkat));
          $pil_tgl_saja = date('d', strtotime($tglberangkat));
      
          $n = date('N', strtotime($pil_tgl));
      
          $nilai_hari_sebelum = $n - 1;
      
          $hari_pertama = $pil_tgl_saja - $nilai_hari_sebelum;
      
          $jml_hari_akhir = 7 - $n;
      
          $hari_akhir = $pil_tgl_saja + $jml_hari_akhir;
          $date_value_akhir = date('Y-m-d', strtotime("$tglberangkat + $jml_hari_akhir days"));
          $date_value_pertama = date('Y-m-d', strtotime("$tglberangkat - $nilai_hari_sebelum days"));
        
          // var_dump($row);die();
          if ($tipe_undangan != 2) {
            if ($row != 1152) {
              if ($lama_p_d > 2) {
                
                    $this->session->set_flashdata('gagal',"Batas melakukan perjalan dinas adalah 2 hari dalam minggu pemilihan tanggal" );
                    redirect('/perdin/ubah_sp_perdin/' . $id_perdin );

              }else{

                foreach ($pkepada as $row) {
                  $data_pegawai_sudah_perdin = $this->m_perdin->get_data_pegawai_sudah_perdin($date_value_pertama , $date_value_akhir, $row);
          
                  if (!empty($data_pegawai_sudah_perdin) && 
                      ($tglberangkat != $data_pegawai_sudah_perdin[0]->tanggal_berangkat || 
                      $row != $data_pegawai_sudah_perdin[0]->id_pegawai)) {
                    $data = [
                        'lama_p_d' => null,
                    ];
                    $update_perdin = $this->m_perdin->update_e_perdin($id_perdin, $data);
                    $tambah_lama_p_d = $data_pegawai_sudah_perdin[0]->total_lama_p_d + $lama_p_d;
                    // var_dump($data_pegawai_sudah_perdin[0]->total_lama_p_d);die();
                    if($data_pegawai_sudah_perdin[0]->total_lama_p_d > 2) {
                        $data_pegawai = $this->m_perdin->get_n_pegawai($row);
                        
                        $this->db->trans_rollback();
                        if (is_array($data_pegawai) || is_object($data_pegawai)) {
                          // Jika $data_pegawai adalah array atau objek, kita ubah menjadi JSON atau format string lainnya
                          $data_pegawai = json_encode($data_pegawai);
                        }
                      // Set flashdata dengan pesan yang lebih jelas
                    
                      $this->session->set_flashdata('gagal',$data_pegawai. " sudah melakukan 2 hari perjalanan dinas dalam minggu ini" );
                      redirect('/perdin/ubah_sp_perdin/' . $id_perdin );
                    }
                  }
                }
              }
            }
          }
        }
          $test = $this->m_perdin->hapus_perdin_by_no_grup_perdin($id,$id_tim_parameter);
          $file_path = 'assets/file_surat_perdin/' .  $file_srt;
          if (strpos($file_srt, 'upload') !== false) {
              $file_path = 'assets/file_surat_perdin/upload/' .  $file_srt;
          }
        
          // Hapus file jika ada
          if (file_exists($file_path) && !empty( $file_srt)) {
              if (!unlink($file_path)) {
                  log_message('error', 'Gagal menghapus file: ' . $file_path);
                  $this->session->set_flashdata('gagal', "Gagal menghapus berkas.");
                  redirect('perdin/ubah_sp_perdin/'.$id);
                  return;
              }
          } else {
              log_message('error', 'File tidak ditemukan atau sudah terhapus: ' . $file_path);
          }
          foreach ($tujuan as $key => $value) {
              // Ambil nama kabupaten berdasarkan ID
              $kabupaten_name = $this->m_perdin->get_kabupaten_name($value);
      
              // Ekstrak field 'n_kabupaten' dari objek dan masukkan ke array
              foreach ($kabupaten_name as $item) {
                  $nama_tujuan[] = mb_convert_case(strtolower($item->n_kabupaten), MB_CASE_TITLE, "UTF-8");
      
              }
          }
      
          // Konversi array ke JSON string
          $kab_kota_json = json_encode($nama_tujuan);
      
          // $id_tim = $this->input->post('id_tim');
      
      
      
          foreach ($id_pegawai as $row) {
            $data_insert = [
              'user_id' => $user_id,
              'id_pegawai' => $row,
              'lama_p_d' => $total_hari,
              'skpd' => $skpd,
              'tanggal_berangkat' => $tanggal_berangkat,
              'tanggal_kembali' => $tanggal_kembali,
              'tgl_surat' => $tgl_surat,
              'file_srt' => $file_srt,
              'mksd_pemberangkatan' => $mksd_pemberangkatan,
              'kode_rek_sub_req' => $kode_rek_sub_req,
              'perihal_srt_undangan' => $perihal_srt_undangan,
              'nmr_srt_undangan' => $nmr_srt_undangan,
              'tgl_srt_undangan' => $tgl_srt_undangan,
              'tipe_undangan' => $tipe_undangan,
              'srt_instansi_undangan' => $srt_instansi_undangan,
              'detail_tempat_pemberangkatan' => $detail_tempat_pemberangkatan,
              'no__sppd' => $no__sppd,
              'no_grup_perdin' => $id,
              'dasar_arahan_pimpiman' => $dasar_arahan_pimpiman,
              'pegawai_dinas_lain' => $pegawai_dinas_lain,
              'kode_rek' => $kode_rek,
              'titik_lokasi' => $titik_lokasi,
              'id_tim' => $id_tim,
              'kendaraan' => $kendaraan,
              'tanggal_sp_backdate' => $tanggal_sp_backdate,
              'status_approve' => $status_approve,

            ];
            // var_dump($data_insert);die();
            // $nama_tujuan = $this->m_perdin->get_kabupaten_name($tujuan);
          
            $pegawai = $this->m_perdin->get_n_pegawai_perdin($row);
            $nip = $this->m_perdin->get_n_nip($row);
            $jabatan = $this->m_perdin->get_n_jabatan($row);
            $kode_tim_file = $this->m_perdin->get_tim_details($id_tim);

            // Gabungkan data pegawai ke dalam array

            $id_perdin = $this->m_perdin->save_e_perdin($data_insert);
            // var_dump($id_perdin);die();
            $data_log_perdin = [
              'id_user_pembuat' => $user_id,
              'tanggal_pembuatan' => date('Y-m-d H:i:s'),
              'status_approve' => $status_approve,
              'mksd_pemberangkatan' => $mksd_pemberangkatan,
              'id_data_utama' => $id_perdin
            ];


          $save_log_perdin  = $this->m_perdin->save_log_e_perdin($data_log_perdin);
            // if (!$id_perdin) {
            //     $this->db->trans_rollback();
            //     $this->session->set_flashdata('gagal', "Gagal menyimpan data perjalanan dinas.");
            //     redirect('/perdin/suratperintah/');
            // }
              $data_pegawai[] = [
                'id_perdin' => $id_perdin, // Tambahkan ID Perdin
                'id_pegawai' => $row,
                'nama_pegawai' => $pegawai['n_pegawai'],
                'pangkat_gol' => $pegawai['pangkat_gol'],
                'golongan' => $pegawai['golongan'],
                'nip' => $nip,
                'jabatan' => $jabatan,
                'lama_p_d' => $total_hari,
                'srt_instansi_undangan' => $srt_instansi_undangan,
                'mksd_pemberangkatan' => $mksd_pemberangkatan,
                'kode_rek_sub_req' => $kode_rek_sub_req,
                'perihal_srt_undangan' => $perihal_srt_undangan,
                'nmr_srt_undangan' => $nmr_srt_undangan,
                'tgl_srt_undangan' => $tgl_srt_undangan,
                'detail_tempat_pemberangkatan' => $detail_tempat_pemberangkatan,
                'tanggal_kembali' => $tanggal_kembali,
                'tanggal_berangkat' => $tanggal_berangkat,
                'nama_tujuan' => $nama_tujuan,
                'dasar_arahan_pimpiman' => $dasar_arahan_pimpiman,
                'kode_rek' => $kode_rek,
                'id_tim' => $id_tim,
                'no_grup_perdin' => $id,
                'no__sppd' => $no__sppd,
                'kendaraan' => $kendaraan,
                'tanggal_sp_backdate' => $tanggal_sp_backdate,
                'status_approve' => $status_approve,

                'tgl_Surat' => isset($tgl_Surat) ? $tgl_Surat : null,  // This works on older PHP versions

            ];
          }
          $data_keberangkatan = [
            'keu_perdin_id' => $id,
            'kab_kota' => $kab_kota_json, // Simpan JSON string
            'id_tim' => $id_tim,
            'tanggal_berangkat_1' => $tglberangkat,
            'tanggal_pulang_1' => $tglkembali,
            'tanggal_berangkat_2' => $tglberangkat2,
            'tanggal_pulang_2' => $tglkembali2,
            'tanggal_berangkat_3' => $tglberangkat3,
            'tanggal_pulang_3' => $tglkembali3,
            'detail_tempat_1' => $detail_tempat_1,
            'detail_tempat_2' => $detail_tempat_2,
            'detail_tempat_3' => $detail_tempat_3
        ];
        
        // Simpan data ke database
        $id_perdin = $this->m_perdin->save_e_perdin_tujuan_pemberangkatan($data_keberangkatan);
          if (is_array($pkepada)) {

            if (in_array("31", $pkepada) || in_array("1152", $pkepada)) {
  
                // Jika kedua nilai ada dalam array
                if (in_array("31", $pkepada)) {
                  $filtered_data = array_filter($data_pegawai, function($item) {
                      return $item['id_pegawai'] == 31;
                  });
  
                  if ($tipe_undangan == 1) {
                    $templateFile = 'assets/file_surat_perdin/template_surat_perdin/surat_perintah_template_pa_sekdis_tipe1.docx';
                      
              
                  
                  }elseif($tipe_undangan == 3){
                        $templateFile = 'assets/file_surat_perdin/template_surat_perdin/template_arahan_pimpinan/surat_perintah_template_pa_sekdis_arahan_pimpinan.docx';
                     
                  } else {
                      $templateFile = 'assets/file_surat_perdin/template_surat_perdin/surat_perintah_template_pa_sekdis.docx';
                    
                  }

                  // Memproses file template yang dipilih
                  $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor($templateFile);
  
                  // Lanjutkan dengan pengisian data ke dalam template...

                  $arrblnRomawi = array("I","II","III","IV","V","VI",'VII','VIII','IX','X','XI','XII');
                  $blnRomawi = $arrblnRomawi[date("m")-1];
                  
                  // Pastikan menggunakan setlocale untuk format bahasa Indonesia
                  setlocale(LC_TIME, 'id_ID.utf8');

                  // Mendapatkan hari, tanggal, bulan, dan tahun
                  $hari_ttd = strftime('%A', time()); // Nama hari
                  $tgl_ttd = strftime('%d', time()); // Tanggal (angka)
                  $bln_ttd = strftime('%B', time()); // Nama bulan

                  // Ganti "Pebruari" menjadi "Februari"
                  $bln_ttd = str_replace("Pebruari", "Februari", $bln_ttd); // Nama bulan
                  $tahun_text = strftime('%Y', time()); // Tahun (angka)
                  // Membuat nomor random
                  $random_number = mt_rand(1000, 9999); // Nomor random 4 digit

                  // Mendapatkan tanggal hari ini dalam format DDMMYYYY
                  $tanggal_hari_ini = date('dmY');

                  // Menggabungkan semua elemen menjadi nomor dengan format yang diinginkan
                  $kode_tim = $kode_tim_file->kode_tim_ketua;
                  foreach ($filtered_data as $index => $pegawai) {

                    // Hanya proses data dengan ID tertentu
                    // Menampilkan hasil yang sudah difilter
                    if ($pegawai['id_pegawai'] != 31) {
                        continue; // Lewati iterasi jika ID tidak sesuai
                    }
                    $tujuan_keberangkatan_perdin = $this->m_perdin->get_tujuan_keberangkatan_perdin($pegawai['no_grup_perdin'], $pegawai['id_tim']);

                    $kab_kota_array = [];
                    if (!empty($tujuan_keberangkatan_perdin)) {
                        foreach ($tujuan_keberangkatan_perdin as $rowlist) {
                            // Decode jika kab_kota dalam format JSON
                            $decoded = json_decode($rowlist->kab_kota, true);
                            if (is_array($decoded)) {
                                $kab_kota_array = array_merge($kab_kota_array, $decoded); // Gabungkan jika array
                            } else {
                                $kab_kota_array[] = $rowlist->kab_kota; // Tambahkan langsung jika bukan JSON
                            }
                        }
                    } else {
                        echo "No data available"; // Tampilkan pesan jika data kosong
                    }
                    $tujuan_keberangkatan_perdin = $this->m_perdin->get_tujuan_keberangkatan_perdin($pegawai['no_grup_perdin'], $pegawai['id_tim']);
                    
                    $tanggalBerangkat_1 = $tujuan_keberangkatan_perdin[0]->tanggal_berangkat_1;
                    $tanggalBerangkat_2 = $tujuan_keberangkatan_perdin[0]->tanggal_berangkat_2;
                    $tanggalBerangkat_3 = $tujuan_keberangkatan_perdin[0]->tanggal_berangkat_3;
          
                    $tanggal_pulang_1 = $tujuan_keberangkatan_perdin[0]->tanggal_pulang_1;
                    $tanggal_pulang_2 = $tujuan_keberangkatan_perdin[0]->tanggal_pulang_2;
                    $tanggal_pulang_3 = $tujuan_keberangkatan_perdin[0]->tanggal_pulang_3;
    
                    setlocale(LC_TIME, 'id_ID.UTF-8', 'Indonesian', 'id_ID');

                    // Format tanggal dengan strftime
                    // Format tanggal dengan strftime
                    $tanggal_pulang_1 = strftime('%d %B %Y', strtotime($tanggal_pulang_1));
                    if ($tanggal_pulang_2 == "0000-00-00") {
                      $tanggal_pulang_2 = '';
                    } else {
                      // Format the date only if it's a valid date
                      $tanggal_pulang_2 = strftime('%d %B %Y', strtotime($tanggal_pulang_2));
                    }
        
                    // Check if $tanggal_pulang_3 is "0000-00-00" and set it to an empty string if true
                    if ($tanggal_pulang_3 == "0000-00-00") {
                      $tanggal_pulang_3 = '';
                    } else {
                      // Format the date only if it's a valid date
                      $tanggal_pulang_3 = strftime('%d %B %Y', strtotime($tanggal_pulang_3));
                    }

                    $tglKeberangkatan_1 = strftime('%d %B %Y', strtotime($tanggalBerangkat_1));
                    $tglKeberangkatan_2 = strftime('%d %B %Y', strtotime($tanggalBerangkat_2));
                    $tglKeberangkatan_3 = strftime('%d %B %Y', strtotime($tanggalBerangkat_3));

                    // Ganti "Pebruari" menjadi "Februari"
                    $bulan_salah = 'Pebruari';
                    $bulan_benar = 'Februari';

                    $tanggal_pulang_1 = str_replace($bulan_salah, $bulan_benar, $tanggal_pulang_1);
                    $tanggal_pulang_2 = str_replace($bulan_salah, $bulan_benar, $tanggal_pulang_2);
                    $tanggal_pulang_3 = str_replace($bulan_salah, $bulan_benar, $tanggal_pulang_3);

                    $tglKeberangkatan_1 = str_replace($bulan_salah, $bulan_benar, $tglKeberangkatan_1);
                    $tglKeberangkatan_2 = str_replace($bulan_salah, $bulan_benar, $tglKeberangkatan_2);
                    $tglKeberangkatan_3 = str_replace($bulan_salah, $bulan_benar, $tglKeberangkatan_3);
                    // Format tanggal dengan strftime
                    $tglKeberangkatan = strftime('%d %B %Y', strtotime($pegawai['tanggal_berangkat']));
                    $tglKepulangan = strftime('%d %B %Y', strtotime($pegawai['tanggal_kembali']));

                    // Pastikan "Februari" ditulis dengan 'F' bukan 'P'
                    $tglKeberangkatan = str_replace('Pebruari', 'Februari', $tglKeberangkatan);
                    $tglKepulangan = str_replace('Pebruari', 'Februari', $tglKepulangan);
                    
                    if ($tanggalBerangkat_1 == "0000-00-00") {
                      $templateProcessor->setValue("tglKeberangkatan_1", '');
                      $templateProcessor->setValue("tanggal_pulang_1", '');
                      $templateProcessor->setValue("tgl_kepulangan#1", $tanggal_pulang_1);
        
                    }else{

                      $templateProcessor->setValue("tglKeberangkatan_1", $tglKeberangkatan_1);
                      $templateProcessor->setValue("tanggal_pulang_1", $tanggal_pulang_1);
                      
                      if ($tanggalBerangkat_2 === "0000-00-00") {

                        if ($pegawai['lama_p_d'] == 1) {
                            $templateProcessor->setValue("tgl_kepulangan_sp1", '');
                        } elseif (!empty($tanggal_pulang_2)) {
                            // Jika $tanggal_pulang_2 ada nilainya
                            $templateProcessor->setValue("tgl_kepulangan_sp1", "sampai dengan " . $tanggal_pulang_2);
                        }else {
                          // var_dump("tgl_kepulangan_sp1", "sampai dengan " . $tanggal_pulang_1);die();

                          $templateProcessor->setValue("tgl_kepulangan_sp1", "sampai dengan " . $tanggal_pulang_1);
                        }
                    
                        $templateProcessor->setValue("tgl_kepulangan1", $tanggal_pulang_1);
                    
                    } else {
                        $templateProcessor->setValue("tgl_kepulangan_sp1", '');
                        $templateProcessor->setValue("tgl_kepulangan1", '');
                    }
                    
                    
        
                    }
                    if ($tanggalBerangkat_2 == "0000-00-00") {
                      // var_dump($tanggalBerangkat_2);die();
        
                      $templateProcessor->setValue("tglKeberangkatan_2", '');
                      $templateProcessor->setValue("tanggal_pulang_2", '');
                      
                      $templateProcessor->setValue("tgl_kepulangan2", "");
                      if ($tanggalBerangkat_3 == "0000-00-00") {
                        if ($pegawai['lama_p_d'] == 1) {
                          $templateProcessor->setValue("tgl_kepulangan_sp2", '');
                        } elseif (!empty($tanggal_pulang_2)) {
                          // Jika $tanggal_pulang_2 ada nilainya
                          $templateProcessor->setValue("tgl_kepulangan_sp2", "sampai dengan " . $tanggal_pulang_2);
                        }else {
                          // var_dump("tgl_kepulangan_sp1", "sampai dengan " . $tanggal_pulang_1);die();

                          // $templateProcessor->setValue("tgl_kepulangan_sp2", "sampai dengan " . $tanggal_pulang_1);

                          $templateProcessor->setValue("tgl_kepulangan_sp2", '');
                          
                        }
                      }else{
                        $templateProcessor->setValue("tgl_kepulangan_sp2", "sampai dengan " . $tanggal_pulang_3);
                      }
                    }else{
                      $templateProcessor->setValue("tglKeberangkatan_2", $tglKeberangkatan_2);
                      $templateProcessor->setValue("tanggal_pulang_2", $tanggal_pulang_2);
                      // var_dump($pegawai['lama_p_d']);die();
        
                      if ($tanggalBerangkat_3 == "0000-00-00") {
                        if ($pegawai['lama_p_d'] == 1) {
                          $templateProcessor->setValue("tgl_kepulangan_sp2", '');
                        } else {
                            $templateProcessor->setValue("tgl_kepulangan_sp2", "sampai dengan " . $tanggal_pulang_2);
                        }
                        $templateProcessor->setValue("tgl_kepulangan2", $tanggal_pulang_2);
        
                      }else{
                        $templateProcessor->setValue("tgl_kepulangan2", "");
                        $templateProcessor->setValue("tgl_kepulangan_sp2", "sampai dengan " . $tanggal_pulang_3);
                      }
        
                    }
                    if ($tanggalBerangkat_3 == "0000-00-00") {
                      $templateProcessor->setValue("tglKeberangkatan_3", '');
                      $templateProcessor->setValue("tanggal_pulang_3", '');
                      $templateProcessor->setValue("tgl_kepulangan3", "");
                      $templateProcessor->setValue("tgl_kepulangan_sp3", '');
                    }else{
                      $templateProcessor->setValue("tglKeberangkatan_3", $tglKeberangkatan_3);
                      $templateProcessor->setValue("tanggal_pulang_3", $tanggal_pulang_3);
                      $templateProcessor->setValue("tgl_kepulangan3", $tanggal_pulang_3);
                      $templateProcessor->setValue("tgl_kepulangan_sp3", '');
                    }
                  
                    
                    // Sanitasi untuk srt_instansi_undangan agar aman untuk penggunaan dalam dokumen Word
                    $srtInstansiUndangan = htmlspecialchars($pegawai['srt_instansi_undangan'], ENT_QUOTES, 'UTF-8');

                      // Check if 'nama_tujuan' is an array and if the first element exists
                      if (isset($pegawai['nama_tujuan'][0]) && is_object($pegawai['nama_tujuan'][0])) {
                        $kabupatenKota = ucwords(strtolower($pegawai['nama_tujuan'][0]->n_kabupaten));
                      } else {
                        // Handle the case when 'nama_tujuan' is not properly structured or the element doesn't exist
                        $kabupatenKota = '';  // Or some default value
                      }

                      if ($pegawai['tanggal_sp_backdate'] == '0000-00-00' || $pegawai['tanggal_sp_backdate'] === false || $pegawai['backdate'] === '-' || $pegawai['backdate'] === 'tidak' ) {

                      }else{
                        $tanggal_sp_backdate = strftime('%d %B %Y', strtotime($pegawai['tanggal_sp_backdate']));
                        $templateProcessor->setValue("tgl_surat", $tanggal_sp_backdate);
                      }
                    // Menetapkan nilai pada placeholder di template
                    $templateProcessor->setValue("jabatan", $pegawai['jabatan']);
                    $templateProcessor->setValue("ada", $srtInstansiUndangan);
                    $templateProcessor->setValue("mksd", $pegawai['mksd_pemberangkatan']);
                    $templateProcessor->setValue("kode_rekening_sub_keg", $pegawai['kode_rek_sub_req']);
                    $templateProcessor->setValue("srt_perihal_undangan", $pegawai['perihal_srt_undangan']);
                    $templateProcessor->setValue("srt_nmr_undangan", $pegawai['nmr_srt_undangan']);
                    $templateProcessor->setValue("tgl_srt_undangan", $pegawai['tgl_srt_undangan']);
                      $templateProcessor->setValue("tgl_srt_undangan#{$index}", $tgl_srt_undangan);

                    $location_details = [];
                    
                    if (!empty($detail_tempat_1) && isset($kab_kota_array[0])) {
                        $location_details[] = $detail_tempat_1 . ' ' . $kab_kota_array[0];
                    }
                    if (!empty($detail_tempat_2) && isset($kab_kota_array[1])) {
                        $location_details[] = $detail_tempat_2 . ' ' . $kab_kota_array[1];
                    }
                    if (!empty($detail_tempat_3) && isset($kab_kota_array[2])) {
                        $location_details[] = $detail_tempat_3 . ' ' . $kab_kota_array[2];
                    }
                    
                    $final_location_string = implode(', ', $location_details);
                    
                    $templateProcessor->setValue("brtmpt", $final_location_string);
                    $templateProcessor->setValue("lama_perdin", $pegawai['lama_p_d']);
                    if (isset($pegawai['no__sppd']) && !empty($pegawai['no__sppd'])) {
                      $templateProcessor->setValue("no_surat", $pegawai['no__sppd']);
                      $templateProcessor->setValue("tgl_surat", $pegawai['tgl_surat']);
                    }
                    $templateProcessor->setValue("tgl_keberangkatan", $tglKeberangkatan);
                    $templateProcessor->setValue("tgl_kepulangan", $tglKepulangan);
                    $templateProcessor->setValue("kabupaten_kota_bertempatan", $kabupatenKota);
                    $templateProcessor->setValue("kepada_nama", $pegawai['nama_pegawai']);
                    $templateProcessor->setValue("kode_rek", $pegawai['kode_rek']);
                    $templateProcessor->setValue("arahan_pimpinan", $pegawai['dasar_arahan_pimpiman']);
                    $templateProcessor->setValue("kode_tim", $kode_tim);
                    $templateProcessor->setValue("no_urut", $id);
                    $templateProcessor->setValue("kendaraan", $pegawai['kendaraan']);
                    // Cek apakah nip ada, jika ada maka kolom nip akan muncul
                    if (!empty($pegawai['pangkat_gol']) && strtolower($pegawai['pangkat_gol']) != 'tenaga kontrak') {
                        $templateProcessor->setValue("nama_kolom_nip", 'Nomor Induk Pegawai');
                        $templateProcessor->setValue("nip", $pegawai['nip']);
                        $pangkatGolongan = (isset($pegawai['pangkat_gol']) && isset($pegawai['golongan']) && $pegawai['pangkat_gol'] !== '' && $pegawai['golongan'] !== '' && $pegawai['pangkat_gol'] !== 'Tenaga Kontrak') 
                        ? $pegawai['pangkat_gol'] . ' (' . $pegawai['golongan'] .')'
                        : 'Non ASN';
            
            
                                        $templateProcessor->setValue("Pangkat_golongan", $pangkatGolongan);


                    } else {
                      $templateProcessor->setValue("nama_kolom_nip#{$index}", 'Nomor Induk Pegawai');
                      $templateProcessor->setValue("nip#{$index}", '-');
                      $pangkatGolongan = (isset($pegawai['pangkat_gol']) && isset($pegawai['golongan']) && $pegawai['pangkat_gol'] !== '' && $pegawai['golongan'] !== '' && $pegawai['pangkat_gol'] !== 'Tenaga Kontrak') 
                      ? $pegawai['pangkat_gol'] . ' (' . $pegawai['golongan'] .')'
                      : 'Non ASN';
          
          
                                      $templateProcessor->setValue("Pangkat_golongan", $pangkatGolongan);
                    }
                    $templateProcessor->setValue("Pangkat_golongan_visum#{$index}", $pangkatGolongan);

                    $templateProcessor->setValue("jabatan", $pegawai['jabatan']); 
                    $templateProcessor->setValue("golongan", $pegawai['golongan']); 

                    if (count($kab_kota_array) == 1) {
                        $templateProcessor->setValue("tempat_tujuan#1", isset($kab_kota_array[0]) ? $kab_kota_array[0] . ' ' : '');
                        $templateProcessor->setValue("tempat_tujuan#2", isset($kab_kota_array[1]) ? $kab_kota_array[1] . ',' : '');
                        $templateProcessor->setValue("tempat_tujuan#3", isset($kab_kota_array[2]) ? $kab_kota_array[2] . ',' : '');
          
                        $templateProcessor->setValue("tempat_tujuan_1_kota#0", 'Kota Bandung');
                        $templateProcessor->setValue("tempat_tujuan_2_kota#0", '');
                        $templateProcessor->setValue("tempat_tujuan_3_kota#0", '');
                    }elseif(count($kab_kota_array) == 2){
                      $templateProcessor->setValue("tempat_tujuan#1", isset($kab_kota_array[0]) ? $kab_kota_array[0] . ',' : '');
                      $templateProcessor->setValue("tempat_tujuan#2", isset($kab_kota_array[1]) ? $kab_kota_array[1] . ' ' : '');
                      $templateProcessor->setValue("tempat_tujuan#3", isset($kab_kota_array[2]) ? $kab_kota_array[2] . ',' : '');
          
                      $templateProcessor->setValue("tempat_tujuan_1_kota#0", '');
                      $templateProcessor->setValue("tempat_tujuan_2_kota#0", 'Kota Bandung');
                      $templateProcessor->setValue("tempat_tujuan_3_kota#0", '');
                    }else{
                      $templateProcessor->setValue("tempat_tujuan#1", isset($kab_kota_array[0]) ? $kab_kota_array[0] . ',' : '');
                      $templateProcessor->setValue("tempat_tujuan#2", isset($kab_kota_array[1]) ? $kab_kota_array[1] . ',' : '');
                      $templateProcessor->setValue("tempat_tujuan#3", isset($kab_kota_array[2]) ? $kab_kota_array[2] . ' ' : '');
          
                      $templateProcessor->setValue("tempat_tujuan_1_kota#0", '');
                      $templateProcessor->setValue("tempat_tujuan_2_kota#0", '');
                      $templateProcessor->setValue("tempat_tujuan_3_kota#0", 'Kota Bandung');
                    }
                    $templateProcessor->deleteBlock('nomor_induk_pegawai_row');

                    
                }
                // var_dump($kode_tim_file);die();

                $filename_pa_sekdis = 'assets/file_surat_perdin/kadis_sekdis/SPPD_' . date('Ymd') . '_' . $id . '_' . $kode_tim_file->kode_tim_ketua . '_sekdis.docx';
                $filename_pa_sekdis_simpan = 'SPPD_' . date('Ymd') . '_' . $id . '_' . $kode_tim_file->kode_tim_ketua . '_sekdis.docx';
                $templateProcessor->saveAs($filename_pa_sekdis);
                

                $data = [
                    'file_srt' => $filename_pa_sekdis_simpan,
                ];
                $update_perdin = $this->m_perdin->update_e_perdin($pegawai['id_perdin'], $data);
                // var_dump($filename_pa_sekdis);die();
                } 
                if (in_array("1152", $pkepada)) {
                  $filtered_data_bu_kadis = array_filter($data_pegawai, function($item) {
                      return $item['id_pegawai'] == 1152;
                  });

                  if ($tipe_undangan == 1) {
                      $templateFile = 'assets/file_surat_perdin/template_surat_perdin/surat_perintah_template_bu_kadis.docx';
                       // Memproses file template yang dipilih
                      $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor($templateFile);
  
                      // Lanjutkan dengan pengisian data ke dalam template...
  
                      $arrblnRomawi = array("I","II","III","IV","V","VI",'VII','VIII','IX','X','XI','XII');
                      $blnRomawi = $arrblnRomawi[date("m")-1];
                      
                      // Pastikan menggunakan setlocale untuk format bahasa Indonesia
                      setlocale(LC_TIME, 'id_ID.utf8');
  
                      // Mendapatkan hari, tanggal, bulan, dan tahun
                      $hari_ttd = strftime('%A', time()); // Nama hari
                      $tgl_ttd = strftime('%d', time()); // Tanggal (angka)
                      $bln_ttd = strftime('%B', time()); // Nama bulan
  
                      // Ganti "Pebruari" menjadi "Februari"
                      $bln_ttd = str_replace("Pebruari", "Februari", $bln_ttd); // Nama bulan
                      $tahun_text = strftime('%Y', time()); // Tahun (angka)
                      // Membuat nomor random
                      $random_number = mt_rand(1000, 9999); // Nomor random 4 digit
  
                      // Mendapatkan tanggal hari ini dalam format DDMMYYYY
                      $tanggal_hari_ini = date('dmY');
  
                      // Menggabungkan semua elemen menjadi nomor dengan format yang diinginkan
                      $kode_tim = $kode_tim_file->kode_tim_ketua;
                        foreach ($filtered_data_bu_kadis as $index => $pegawai) {
                          // Hanya proses data dengan ID tertentu
                          if ($pegawai['id_pegawai'] != 1152) {
                              continue; // Lewati iterasi jika ID tidak sesuai
                          }
                          //  var_dump($pegawai);die();
  
                          $tujuan_keberangkatan_perdin = $this->m_perdin->get_tujuan_keberangkatan_perdin($pegawai['no_grup_perdin'], $pegawai['id_tim']);
  
                          $kab_kota_array = [];
                          if (!empty($tujuan_keberangkatan_perdin)) {
                              foreach ($tujuan_keberangkatan_perdin as $rowlist) {
                                  // Decode jika kab_kota dalam format JSON
                                  $decoded = json_decode($rowlist->kab_kota, true);
                                  if (is_array($decoded)) {
                                      $kab_kota_array = array_merge($kab_kota_array, $decoded); // Gabungkan jika array
                                  } else {
                                      $kab_kota_array[] = $rowlist->kab_kota; // Tambahkan langsung jika bukan JSON
                                  }
                              }
                          } else {
                              echo "No data available"; // Tampilkan pesan jika data kosong
                          }
                          $tujuan_keberangkatan_perdin = $this->m_perdin->get_tujuan_keberangkatan_perdin($pegawai['no_grup_perdin'], $pegawai['id_tim']);
                          
                          $tanggalBerangkat_1 = $tujuan_keberangkatan_perdin[0]->tanggal_berangkat_1;
                          $tanggalBerangkat_2 = $tujuan_keberangkatan_perdin[0]->tanggal_berangkat_2;
                          $tanggalBerangkat_3 = $tujuan_keberangkatan_perdin[0]->tanggal_berangkat_3;
                
                          $tanggal_pulang_1 = $tujuan_keberangkatan_perdin[0]->tanggal_pulang_1;
                          $tanggal_pulang_2 = $tujuan_keberangkatan_perdin[0]->tanggal_pulang_2;
                          $tanggal_pulang_3 = $tujuan_keberangkatan_perdin[0]->tanggal_pulang_3;
          
                          setlocale(LC_TIME, 'id_ID.UTF-8', 'Indonesian', 'id_ID');
  
                          // Format tanggal dengan strftime
                          // Format tanggal dengan strftime
                          $tanggal_pulang_1 = strftime('%d %B %Y', strtotime($tanggal_pulang_1));
                          if ($tanggal_pulang_2 == "0000-00-00") {
                            $tanggal_pulang_2 = '';
                          } else {
                            // Format the date only if it's a valid date
                            $tanggal_pulang_2 = strftime('%d %B %Y', strtotime($tanggal_pulang_2));
                          }
              
                          // Check if $tanggal_pulang_3 is "0000-00-00" and set it to an empty string if true
                          if ($tanggal_pulang_3 == "0000-00-00") {
                            $tanggal_pulang_3 = '';
                          } else {
                            // Format the date only if it's a valid date
                            $tanggal_pulang_3 = strftime('%d %B %Y', strtotime($tanggal_pulang_3));
                          }
                          $tglKeberangkatan_1 = strftime('%d %B %Y', strtotime($tanggalBerangkat_1));
                          $tglKeberangkatan_2 = strftime('%d %B %Y', strtotime($tanggalBerangkat_2));
                          $tglKeberangkatan_3 = strftime('%d %B %Y', strtotime($tanggalBerangkat_3));
  
                          // Ganti "Pebruari" menjadi "Februari"
                          $bulan_salah = 'Pebruari';
                          $bulan_benar = 'Februari';
  
                          $tanggal_pulang_1 = str_replace($bulan_salah, $bulan_benar, $tanggal_pulang_1);
                          $tanggal_pulang_2 = str_replace($bulan_salah, $bulan_benar, $tanggal_pulang_2);
                          $tanggal_pulang_3 = str_replace($bulan_salah, $bulan_benar, $tanggal_pulang_3);
  
                          $tglKeberangkatan_1 = str_replace($bulan_salah, $bulan_benar, $tglKeberangkatan_1);
                          $tglKeberangkatan_2 = str_replace($bulan_salah, $bulan_benar, $tglKeberangkatan_2);
                          $tglKeberangkatan_3 = str_replace($bulan_salah, $bulan_benar, $tglKeberangkatan_3);
                          // Format tanggal dengan strftime
                          $tglKeberangkatan = strftime('%d %B %Y', strtotime($pegawai['tanggal_berangkat']));
                          $tglKepulangan = strftime('%d %B %Y', strtotime($pegawai['tanggal_kembali']));
  
                          // Pastikan "Februari" ditulis dengan 'F' bukan 'P'
                          $tglKeberangkatan = str_replace('Pebruari', 'Februari', $tglKeberangkatan);
                          $tglKepulangan = str_replace('Pebruari', 'Februari', $tglKepulangan);
                          // var_dump($tglKeberangkatan);die();
                          
                          if ($tanggalBerangkat_1 == "0000-00-00") {
                            $templateProcessor->setValue("tglKeberangkatan_1", '');
                            $templateProcessor->setValue("tanggal_pulang_1", '');
                            $templateProcessor->setValue("tgl_kepulangan#1", $tanggal_pulang_1);
              
                          }else{
                            $templateProcessor->setValue("tglKeberangkatan_1", $tglKeberangkatan_1);
                            $templateProcessor->setValue("tanggal_pulang_1", $tanggal_pulang_1);
                            
                            if ($tanggalBerangkat_2 === "0000-00-00") {
                                if ($pegawai['lama_p_d'] == 1) {
                                    $templateProcessor->setValue("tgl_kepulangan_sp1", '');
                                } else {
                                    $templateProcessor->setValue("tgl_kepulangan_sp1", "sampai dengan " . $tanggal_pulang_2);
                                }
                                $templateProcessor->setValue("tgl_kepulangan1", $tanggal_pulang_1);
              
                            } else {
                                $templateProcessor->setValue("tgl_kepulangan_sp1", '');
                                $templateProcessor->setValue("tgl_kepulangan1", '');
              
                            }
                          
              
                          }
                          if ($tanggalBerangkat_2 == "0000-00-00") {
                            // var_dump($tanggalBerangkat_2);die();
              
                            $templateProcessor->setValue("tglKeberangkatan_2", '');
                            $templateProcessor->setValue("tanggal_pulang_2", '');
                            
                            $templateProcessor->setValue("tgl_kepulangan2", "");
                            if ($tanggalBerangkat_3 == "0000-00-00") {
                              if ($pegawai['lama_p_d'] == 1) {
                                $templateProcessor->setValue("tgl_kepulangan_sp2", '');
                              } else {
                                  $templateProcessor->setValue("tgl_kepulangan_sp2", "sampai dengan " . $tanggal_pulang_2);
                              }
                            }else{
                              $templateProcessor->setValue("tgl_kepulangan_sp2", "sampai dengan " . $tanggal_pulang_3);
                            }
                          }else{
                            $templateProcessor->setValue("tglKeberangkatan_2", $tglKeberangkatan_2);
                            $templateProcessor->setValue("tanggal_pulang_2", $tanggal_pulang_2);
                            // var_dump($pegawai['lama_p_d']);die();
              
                            if ($tanggalBerangkat_3 == "0000-00-00") {
                              if ($pegawai['lama_p_d'] == 1) {
                                $templateProcessor->setValue("tgl_kepulangan_sp2", '');
                              } else {
                                  $templateProcessor->setValue("tgl_kepulangan_sp2", "sampai dengan " . $tanggal_pulang_2);
                              }
                              $templateProcessor->setValue("tgl_kepulangan2", $tanggal_pulang_2);
              
                            }else{
                              $templateProcessor->setValue("tgl_kepulangan2", "");
                              $templateProcessor->setValue("tgl_kepulangan_sp2", "sampai dengan " . $tanggal_pulang_3);
                            }
              
                          }
                          if ($tanggalBerangkat_3 == "0000-00-00") {
                            $templateProcessor->setValue("tglKeberangkatan_3", '');
                            $templateProcessor->setValue("tanggal_pulang_3", '');
                            $templateProcessor->setValue("tgl_kepulangan3", "");
                            $templateProcessor->setValue("tgl_kepulangan_sp3", '');
                          }else{
                            $templateProcessor->setValue("tglKeberangkatan_3", $tglKeberangkatan_3);
                            $templateProcessor->setValue("tanggal_pulang_3", $tanggal_pulang_3);
                            $templateProcessor->setValue("tgl_kepulangan3", $tanggal_pulang_3);
                            $templateProcessor->setValue("tgl_kepulangan_sp3", '');
                          }
                        
                          
                          // Sanitasi untuk srt_instansi_undangan agar aman untuk penggunaan dalam dokumen Word
                          $srtInstansiUndangan = htmlspecialchars($pegawai['srt_instansi_undangan'], ENT_QUOTES, 'UTF-8');
  
                          // Check if 'nama_tujuan' is an array and if the first element exists
                          if (isset($pegawai['nama_tujuan'][0]) && is_object($pegawai['nama_tujuan'][0])) {
                            $kabupatenKota = ucwords(strtolower($pegawai['nama_tujuan'][0]->n_kabupaten));
                          } else {
                            // Handle the case when 'nama_tujuan' is not properly structured or the element doesn't exist
                            $kabupatenKota = '';  // Or some default value
                          }

                          // Menetapkan nilai pada placeholder di template
                          $templateProcessor->setValue("jabatan", $pegawai['jabatan']);
                          $templateProcessor->setValue("ada", $srtInstansiUndangan);
                          $templateProcessor->setValue("mksd", $pegawai['mksd_pemberangkatan']);
                          $templateProcessor->setValue("kode_rekening_sub_keg", $pegawai['kode_rek_sub_req']);
                          $templateProcessor->setValue("srt_perihal_undangan", $pegawai['perihal_srt_undangan']);
                          $templateProcessor->setValue("srt_nmr_undangan", $pegawai['nmr_srt_undangan']);
                          $templateProcessor->setValue("tgl_srt_undangan", $pegawai['tgl_srt_undangan']);
                            $templateProcessor->setValue("tgl_srt_undangan#{$index}", $tgl_srt_undangan);
  
                          $location_details = [];
                          
                          if (!empty($detail_tempat_1) && isset($kab_kota_array[0])) {
                              $location_details[] = $detail_tempat_1 . ' ' . $kab_kota_array[0];
                          }
                          if (!empty($detail_tempat_2) && isset($kab_kota_array[1])) {
                              $location_details[] = $detail_tempat_2 . ' ' . $kab_kota_array[1];
                          }
                          if (!empty($detail_tempat_3) && isset($kab_kota_array[2])) {
                              $location_details[] = $detail_tempat_3 . ' ' . $kab_kota_array[2];
                          }
                          
                          $final_location_string = implode(', ', $location_details);
                          
                          $templateProcessor->setValue("brtmpt", $final_location_string);
                          $templateProcessor->setValue("lama_perdin", $pegawai['lama_p_d']);
                          $templateProcessor->setValue("tgl_keberangkatan", $tglKeberangkatan);
                          $templateProcessor->setValue("tgl_kepulangan", $tglKepulangan);
                          $templateProcessor->setValue("kabupaten_kota_bertempatan", $kabupatenKota);
                          $templateProcessor->setValue("kepada_nama", $pegawai['nama_pegawai']);
                          $templateProcessor->setValue("kode_rek", $pegawai['kode_rek']);
                          $templateProcessor->setValue("arahan_pimpinan", $pegawai['dasar_arahan_pimpiman']);
                          $templateProcessor->setValue("kode_tim", $kode_tim);
                          $templateProcessor->setValue("no_urut", $id);
                          $templateProcessor->setValue("kendaraan", $pegawai['kendaraan']);
                          // Cek apakah nip ada, jika ada maka kolom nip akan muncul
                          if (!empty($pegawai['pangkat_gol']) && strtolower($pegawai['pangkat_gol']) != 'tenaga kontrak') {
                              $templateProcessor->setValue("nama_kolom_nip", 'Nomor Induk Pegawai');
                              $templateProcessor->setValue("nip", $pegawai['nip']);
                              $pangkatGolongan = (isset($pegawai['pangkat_gol']) && isset($pegawai['golongan']) && $pegawai['pangkat_gol'] !== '' && $pegawai['golongan'] !== '' && $pegawai['pangkat_gol'] !== 'Tenaga Kontrak') 
                              ? $pegawai['pangkat_gol'] . ' (' . $pegawai['golongan'] .')'
                              : 'Non ASN';
                  
                  
                                              $templateProcessor->setValue("Pangkat_golongan", $pangkatGolongan);
  
  
                          } else {
                            $templateProcessor->setValue("nama_kolom_nip#{$index}", 'Nomor Induk Pegawai');
                            $templateProcessor->setValue("nip#{$index}", '-');
                            $pangkatGolongan = (isset($pegawai['pangkat_gol']) && isset($pegawai['golongan']) && $pegawai['pangkat_gol'] !== '' && $pegawai['golongan'] !== '' && $pegawai['pangkat_gol'] !== 'Tenaga Kontrak') 
                            ? $pegawai['pangkat_gol'] . ' (' . $pegawai['golongan'] .')'
                            : 'Non ASN';
                
                
                                            $templateProcessor->setValue("Pangkat_golongan", $pangkatGolongan);
                          }
                          $templateProcessor->setValue("Pangkat_golongan_visum#{$index}", $pangkatGolongan);
  
                          $templateProcessor->setValue("jabatan", $pegawai['jabatan']); 
                          $templateProcessor->setValue("golongan", $pegawai['golongan']); 
  
                          if (count($kab_kota_array) == 1) {
                              $templateProcessor->setValue("tempat_tujuan#1", isset($kab_kota_array[0]) ? $kab_kota_array[0] . ' ' : '');
                              $templateProcessor->setValue("tempat_tujuan#2", isset($kab_kota_array[1]) ? $kab_kota_array[1] . ',' : '');
                              $templateProcessor->setValue("tempat_tujuan#3", isset($kab_kota_array[2]) ? $kab_kota_array[2] . ',' : '');
                
                              $templateProcessor->setValue("tempat_tujuan_1_kota#0", 'Kota Bandung');
                              $templateProcessor->setValue("tempat_tujuan_2_kota#0", '');
                              $templateProcessor->setValue("tempat_tujuan_3_kota#0", '');
                          }elseif(count($kab_kota_array) == 2){
                            $templateProcessor->setValue("tempat_tujuan#1", isset($kab_kota_array[0]) ? $kab_kota_array[0] . ',' : '');
                            $templateProcessor->setValue("tempat_tujuan#2", isset($kab_kota_array[1]) ? $kab_kota_array[1] . ' ' : '');
                            $templateProcessor->setValue("tempat_tujuan#3", isset($kab_kota_array[2]) ? $kab_kota_array[2] . ',' : '');
                
                            $templateProcessor->setValue("tempat_tujuan_1_kota#0", '');
                            $templateProcessor->setValue("tempat_tujuan_2_kota#0", 'Kota Bandung');
                            $templateProcessor->setValue("tempat_tujuan_3_kota#0", '');
                          }else{
                            $templateProcessor->setValue("tempat_tujuan#1", isset($kab_kota_array[0]) ? $kab_kota_array[0] . ',' : '');
                            $templateProcessor->setValue("tempat_tujuan#2", isset($kab_kota_array[1]) ? $kab_kota_array[1] . ',' : '');
                            $templateProcessor->setValue("tempat_tujuan#3", isset($kab_kota_array[2]) ? $kab_kota_array[2] . ' ' : '');
                
                            $templateProcessor->setValue("tempat_tujuan_1_kota#0", '');
                            $templateProcessor->setValue("tempat_tujuan_2_kota#0", '');
                            $templateProcessor->setValue("tempat_tujuan_3_kota#0", 'Kota Bandung');
                          }
                          $templateProcessor->deleteBlock('nomor_induk_pegawai_row');
  
                          
                       
  
                          $filename_bukadis = 'assets/file_surat_perdin/kadis_sekdis/SPPD_' . date('Ymd') . '_' . $id . '_' . $kode_tim_file->kode_tim_ketua . '_kadis.docx';
                          $filename_bukadis_simpan = 'SPPD_' . date('Ymd') . '_' . $id . '_' . $kode_tim_file->kode_tim_ketua . '_kadis.docx';
                          
                          $data = [
                              'file_srt' => $filename_bukadis_simpan,
                          ];
                          $update_perdin = $this->m_perdin->update_e_perdin($pegawai['id_perdin'], $data);
  
                          $templateProcessor->saveAs($filename_bukadis);
                          // var_dump($filename_bukadis);die();

                        }
                          $templateFile = 'assets/file_surat_perdin/template_surat_perdin/visum_kadis.docx';
                          // Memproses file template yang dipilih
    
                          $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor($templateFile);
    
                          // Lanjutkan dengan pengisian data ke dalam template...
    
                          $arrblnRomawi = array("I","II","III","IV","V","VI",'VII','VIII','IX','X','XI','XII');
                          $blnRomawi = $arrblnRomawi[date("m")-1];
                          
                          // Pastikan menggunakan setlocale untuk format bahasa Indonesia
                          setlocale(LC_TIME, 'id_ID.utf8');
    
                          // Mendapatkan hari, tanggal, bulan, dan tahun
                          $hari_ttd = strftime('%A', time()); // Nama hari
                          $tgl_ttd = strftime('%d', time()); // Tanggal (angka)
                          $bln_ttd = strftime('%B', time()); // Nama bulan
  
                          // Ganti "Pebruari" menjadi "Februari"
                          $bln_ttd = str_replace("Pebruari", "Februari", $bln_ttd); // Nama bulan
                          $tahun_text = strftime('%Y', time()); // Tahun (angka)
                          // Membuat nomor random
                          $random_number = mt_rand(1000, 9999); // Nomor random 4 digit
    
                          // Mendapatkan tanggal hari ini dalam format DDMMYYYY
                          $tanggal_hari_ini = date('dmY');
    
                          // Menggabungkan semua elemen menjadi nomor dengan format yang diinginkan
                          $nomor_format = $random_number . '/LKK/kemitraan/' . $tanggal_hari_ini;
    
                          foreach ($filtered_data_bu_kadis as $index => $pegawai) {
                            // Hanya proses data dengan ID tertentu
                            if ($pegawai['id_pegawai'] != 1152) {
                                continue; // Lewati iterasi jika ID tidak sesuai
                            }
                            //  var_dump($pegawai);die();
    
                            $tujuan_keberangkatan_perdin = $this->m_perdin->get_tujuan_keberangkatan_perdin($pegawai['no_grup_perdin'], $pegawai['id_tim']);
    
                            $kab_kota_array = [];
                            if (!empty($tujuan_keberangkatan_perdin)) {
                                foreach ($tujuan_keberangkatan_perdin as $rowlist) {
                                    // Decode jika kab_kota dalam format JSON
                                    $decoded = json_decode($rowlist->kab_kota, true);
                                    if (is_array($decoded)) {
                                        $kab_kota_array = array_merge($kab_kota_array, $decoded); // Gabungkan jika array
                                    } else {
                                        $kab_kota_array[] = $rowlist->kab_kota; // Tambahkan langsung jika bukan JSON
                                    }
                                }
                            } else {
                                echo "No data available"; // Tampilkan pesan jika data kosong
                            }
                            $tujuan_keberangkatan_perdin = $this->m_perdin->get_tujuan_keberangkatan_perdin($pegawai['no_grup_perdin'], $pegawai['id_tim']);
                            
                            $tanggalBerangkat_1 = $tujuan_keberangkatan_perdin[0]->tanggal_berangkat_1;
                            $tanggalBerangkat_2 = $tujuan_keberangkatan_perdin[0]->tanggal_berangkat_2;
                            $tanggalBerangkat_3 = $tujuan_keberangkatan_perdin[0]->tanggal_berangkat_3;
                  
                            $tanggal_pulang_1 = $tujuan_keberangkatan_perdin[0]->tanggal_pulang_1;
                            $tanggal_pulang_2 = $tujuan_keberangkatan_perdin[0]->tanggal_pulang_2;
                            $tanggal_pulang_3 = $tujuan_keberangkatan_perdin[0]->tanggal_pulang_3;
            
                            setlocale(LC_TIME, 'id_ID.UTF-8', 'Indonesian', 'id_ID');
    
                            // Format tanggal dengan strftime
                            // Format tanggal dengan strftime
                            $tanggal_pulang_1 = strftime('%d %B %Y', strtotime($tanggal_pulang_1));
                            if ($tanggal_pulang_2 == "0000-00-00") {
                              $tanggal_pulang_2 = '';
                            } else {
                              // Format the date only if it's a valid date
                              $tanggal_pulang_2 = strftime('%d %B %Y', strtotime($tanggal_pulang_2));
                            }
                
                            // Check if $tanggal_pulang_3 is "0000-00-00" and set it to an empty string if true
                            if ($tanggal_pulang_3 == "0000-00-00") {
                              $tanggal_pulang_3 = '';
                            } else {
                              // Format the date only if it's a valid date
                              $tanggal_pulang_3 = strftime('%d %B %Y', strtotime($tanggal_pulang_3));
                            }
    
                            $tglKeberangkatan_1 = strftime('%d %B %Y', strtotime($tanggalBerangkat_1));
                            $tglKeberangkatan_2 = strftime('%d %B %Y', strtotime($tanggalBerangkat_2));
                            $tglKeberangkatan_3 = strftime('%d %B %Y', strtotime($tanggalBerangkat_3));
    
                            // Ganti "Pebruari" menjadi "Februari"
                            $bulan_salah = 'Pebruari';
                            $bulan_benar = 'Februari';
    
                            $tanggal_pulang_1 = str_replace($bulan_salah, $bulan_benar, $tanggal_pulang_1);
                            $tanggal_pulang_2 = str_replace($bulan_salah, $bulan_benar, $tanggal_pulang_2);
                            $tanggal_pulang_3 = str_replace($bulan_salah, $bulan_benar, $tanggal_pulang_3);
    
                            $tglKeberangkatan_1 = str_replace($bulan_salah, $bulan_benar, $tglKeberangkatan_1);
                            $tglKeberangkatan_2 = str_replace($bulan_salah, $bulan_benar, $tglKeberangkatan_2);
                            $tglKeberangkatan_3 = str_replace($bulan_salah, $bulan_benar, $tglKeberangkatan_3);
                            // Format tanggal dengan strftime
                            $tglKeberangkatan = strftime('%d %B %Y', strtotime($pegawai['tanggal_berangkat']));
                            $tglKepulangan = strftime('%d %B %Y', strtotime($pegawai['tanggal_kembali']));
    
                            // Pastikan "Februari" ditulis dengan 'F' bukan 'P'
                            $tglKeberangkatan = str_replace('Pebruari', 'Februari', $tglKeberangkatan);
                            $tglKepulangan = str_replace('Pebruari', 'Februari', $tglKepulangan);
                            // var_dump($tglKeberangkatan);die();
                            if ($tanggalBerangkat_1 == "0000-00-00") {
                              $templateProcessor->setValue("tglKeberangkatan_1", '');
                              $templateProcessor->setValue("tanggal_pulang_1", '');
                              $templateProcessor->setValue("tgl_kepulangan#1", $tanggal_pulang_1);
                
                            }else{
                              $templateProcessor->setValue("tglKeberangkatan_1", $tglKeberangkatan_1);
                              $templateProcessor->setValue("tanggal_pulang_1", $tanggal_pulang_1);
                              
                              if ($tanggalBerangkat_2 === "0000-00-00") {
                                  if ($pegawai['lama_p_d'] == 1) {
                                      $templateProcessor->setValue("tgl_kepulangan_sp1", '');
                                  } else {
                                      $templateProcessor->setValue("tgl_kepulangan_sp1", "sampai dengan " . $tanggal_pulang_2);
                                  }
                                  $templateProcessor->setValue("tgl_kepulangan1", $tanggal_pulang_1);
                
                              } else {
                                  $templateProcessor->setValue("tgl_kepulangan_sp1", '');
                                  $templateProcessor->setValue("tgl_kepulangan1", '');
                
                              }
                            
                
                            }
                            if ($tanggalBerangkat_2 == "0000-00-00") {
                              // var_dump($tanggalBerangkat_2);die();
                
                              $templateProcessor->setValue("tglKeberangkatan_2", '');
                              $templateProcessor->setValue("tanggal_pulang_2", '');
                              
                              $templateProcessor->setValue("tgl_kepulangan2", "");
                              if ($tanggalBerangkat_3 == "0000-00-00") {
                                if ($pegawai['lama_p_d'] == 1) {
                                  $templateProcessor->setValue("tgl_kepulangan_sp2", '');
                                } else {
                                    $templateProcessor->setValue("tgl_kepulangan_sp2", "sampai dengan " . $tanggal_pulang_2);
                                }
                              }else{
                                $templateProcessor->setValue("tgl_kepulangan_sp2", "sampai dengan " . $tanggal_pulang_3);
                              }
                            }else{
                              $templateProcessor->setValue("tglKeberangkatan_2", $tglKeberangkatan_2);
                              $templateProcessor->setValue("tanggal_pulang_2", $tanggal_pulang_2);
                              // var_dump($pegawai['lama_p_d']);die();
                
                              if ($tanggalBerangkat_3 == "0000-00-00") {
                                if ($pegawai['lama_p_d'] == 1) {
                                  $templateProcessor->setValue("tgl_kepulangan_sp2", '');
                                } else {
                                    $templateProcessor->setValue("tgl_kepulangan_sp2", "sampai dengan " . $tanggal_pulang_2);
                                }
                                $templateProcessor->setValue("tgl_kepulangan2", $tanggal_pulang_2);
                
                              }else{
                                $templateProcessor->setValue("tgl_kepulangan2", "");
                                $templateProcessor->setValue("tgl_kepulangan_sp2", "sampai dengan " . $tanggal_pulang_3);
                              }
                
                            }
                        // Check if $tanggalBerangkat_3 is not the default "0000-00-00"
                          if ($tanggalBerangkat_3 == "0000-00-00") {
                            $templateProcessor->setValue("tglKeberangkatan_3", '');
                            $templateProcessor->setValue("tanggal_pulang_3", '');
                            $templateProcessor->setValue("tgl_kepulangan3", "");
                            $templateProcessor->setValue("tgl_kepulangan_sp3", '');
                          } else {
                            // Check if $tglKeberangkatan_3 and $tanggal_pulang_3 are set before using them
                            if (isset($tglKeberangkatan_3)) {
                                $templateProcessor->setValue("tglKeberangkatan_3", $tglKeberangkatan_3);
                            } else {
                                $templateProcessor->setValue("tglKeberangkatan_3", '');
                            }

                            if (isset($tanggal_pulang_3)) {
                                $templateProcessor->setValue("tanggal_pulang_3", $tanggal_pulang_3);
                                $templateProcessor->setValue("tgl_kepulangan3", $tanggal_pulang_3);
                            } else {
                                $templateProcessor->setValue("tanggal_pulang_3", '');
                                $templateProcessor->setValue("tgl_kepulangan3", '');
                            }

                            $templateProcessor->setValue("tgl_kepulangan_sp3", '');
                          }

                          
                            
                            // Sanitasi untuk srt_instansi_undangan agar aman untuk penggunaan dalam dokumen Word
                            $srtInstansiUndangan = htmlspecialchars($pegawai['srt_instansi_undangan'], ENT_QUOTES, 'UTF-8');
    
                            if (is_object($pegawai['nama_tujuan'])) {
                              $kabupatenKota = ucwords(strtolower($pegawai['nama_tujuan']->n_kabupaten));
                          } else {
                              // Handle the case when 'nama_tujuan' is not an object
                              $kabupatenKota = '';  // Or some default value
                          }
                          
                            // Menetapkan nilai pada placeholder di template
                            $templateProcessor->setValue("jabatan", $pegawai['jabatan']);
                            $templateProcessor->setValue("ada", $srtInstansiUndangan);
                            $templateProcessor->setValue("mksd", $pegawai['mksd_pemberangkatan']);
                            $templateProcessor->setValue("kode_rekening_sub_keg", $pegawai['kode_rek_sub_req']);
                            $templateProcessor->setValue("srt_perihal_undangan", $pegawai['perihal_srt_undangan']);
                            $templateProcessor->setValue("srt_nmr_undangan", $pegawai['nmr_srt_undangan']);
                             $tgl_srt_undangan = strftime('%d %B %Y', strtotime($pegawai['tgl_srt_undangan']));
                          $templateProcessor->setValue("tgl_srt_undangan#{$index}", $tgl_srt_undangan);
  
                            $location_details = [];
                            
                            if (!empty($detail_tempat_1) && isset($kab_kota_array[0])) {
                                $location_details[] = $detail_tempat_1 . ' ' . $kab_kota_array[0];
                            }
                            if (!empty($detail_tempat_2) && isset($kab_kota_array[1])) {
                                $location_details[] = $detail_tempat_2 . ' ' . $kab_kota_array[1];
                            }
                            if (!empty($detail_tempat_3) && isset($kab_kota_array[2])) {
                                $location_details[] = $detail_tempat_3 . ' ' . $kab_kota_array[2];
                            }
                            
                            $final_location_string = implode(', ', $location_details);
                            
                            $templateProcessor->setValue("brtmpt", $final_location_string);
                            $templateProcessor->setValue("lama_perdin", $pegawai['lama_p_d']);
                            $templateProcessor->setValue("tgl_keberangkatan", $tglKeberangkatan);
                            $templateProcessor->setValue("tgl_kepulangan", $tglKepulangan);
                            $templateProcessor->setValue("kabupaten_kota_bertempatan", $kabupatenKota);
                            $templateProcessor->setValue("kepada_nama", $pegawai['nama_pegawai']);
                            $templateProcessor->setValue("kode_rek", $pegawai['kode_rek']);
                            $templateProcessor->setValue("arahan_pimpinan", $pegawai['dasar_arahan_pimpiman']);
                            $templateProcessor->setValue("kode_tim", $kode_tim);
                            $templateProcessor->setValue("no_urut", $id);
                            $templateProcessor->setValue("kendaraan", $pegawai['kendaraan']);
                            // Cek apakah nip ada, jika ada maka kolom nip akan muncul
                            if (!empty($pegawai['pangkat_gol']) && strtolower($pegawai['pangkat_gol']) != 'tenaga kontrak') {
                                $templateProcessor->setValue("nama_kolom_nip", 'Nomor Induk Pegawai');
                                $templateProcessor->setValue("nip", $pegawai['nip']);
                                $pangkatGolongan = (isset($pegawai['pangkat_gol']) && isset($pegawai['golongan']) && $pegawai['pangkat_gol'] !== '' && $pegawai['golongan'] !== '' && $pegawai['pangkat_gol'] !== 'Tenaga Kontrak') 
                                ? $pegawai['pangkat_gol'] . ' (' . $pegawai['golongan'] .')'
                                : 'Non ASN';
                    
                    
                                                $templateProcessor->setValue("Pangkat_golongan", $pangkatGolongan);
    
    
                            } else {
                              $templateProcessor->setValue("nama_kolom_nip#{$index}", 'Nomor Induk Pegawai');
                              $templateProcessor->setValue("nip#{$index}", '-');
                              $pangkatGolongan = (isset($pegawai['pangkat_gol']) && isset($pegawai['golongan']) && $pegawai['pangkat_gol'] !== '' && $pegawai['golongan'] !== '' && $pegawai['pangkat_gol'] !== 'Tenaga Kontrak') 
                              ? $pegawai['pangkat_gol'] . ' (' . $pegawai['golongan'] .')'
                              : 'Non ASN';
                  
                  
                                              $templateProcessor->setValue("Pangkat_golongan", $pangkatGolongan);
                            }
                            $templateProcessor->setValue("Pangkat_golongan_visum#{$index}", $pangkatGolongan);
    
                            $templateProcessor->setValue("jabatan", $pegawai['jabatan']); 
                            $templateProcessor->setValue("golongan", $pegawai['golongan']); 
    
                            if (count($kab_kota_array) == 1) {
                                $templateProcessor->setValue("tempat_tujuan#1", isset($kab_kota_array[0]) ? $kab_kota_array[0] . ' ' : '');
                                $templateProcessor->setValue("tempat_tujuan#2", isset($kab_kota_array[1]) ? $kab_kota_array[1] . ',' : '');
                                $templateProcessor->setValue("tempat_tujuan#3", isset($kab_kota_array[2]) ? $kab_kota_array[2] . ',' : '');
                  
                                $templateProcessor->setValue("tempat_tujuan_1_kota#0", 'Kota Bandung');
                                $templateProcessor->setValue("tempat_tujuan_2_kota#0", '');
                                $templateProcessor->setValue("tempat_tujuan_3_kota#0", '');
                            }elseif(count($kab_kota_array) == 2){
                              $templateProcessor->setValue("tempat_tujuan#1", isset($kab_kota_array[0]) ? $kab_kota_array[0] . ',' : '');
                              $templateProcessor->setValue("tempat_tujuan#2", isset($kab_kota_array[1]) ? $kab_kota_array[1] . ' ' : '');
                              $templateProcessor->setValue("tempat_tujuan#3", isset($kab_kota_array[2]) ? $kab_kota_array[2] . ',' : '');
                  
                              $templateProcessor->setValue("tempat_tujuan_1_kota#0", '');
                              $templateProcessor->setValue("tempat_tujuan_2_kota#0", 'Kota Bandung');
                              $templateProcessor->setValue("tempat_tujuan_3_kota#0", '');
                            }else{
                              $templateProcessor->setValue("tempat_tujuan#1", isset($kab_kota_array[0]) ? $kab_kota_array[0] . ',' : '');
                              $templateProcessor->setValue("tempat_tujuan#2", isset($kab_kota_array[1]) ? $kab_kota_array[1] . ',' : '');
                              $templateProcessor->setValue("tempat_tujuan#3", isset($kab_kota_array[2]) ? $kab_kota_array[2] . ' ' : '');
                  
                              $templateProcessor->setValue("tempat_tujuan_1_kota#0", '');
                              $templateProcessor->setValue("tempat_tujuan_2_kota#0", '');
                              $templateProcessor->setValue("tempat_tujuan_3_kota#0", 'Kota Bandung');
                            }
                            // var_dump(isset($kab_kota_array[2]) ? $kab_kota_array[2] . ' ' : '');die();
                            $templateProcessor->deleteBlock('nomor_induk_pegawai_row');
    
                            
                         
    
                            $filename_bukadis = 'assets/file_surat_perdin/visum_kadis/SPPD_' . date('Ymd') . '_' . $id . '_' . $kode_tim_file->kode_tim_ketua . '_visum_kadis.docx';
                            $filename_bukadis_simpan = 'SPPD_' . date('Ymd') . '_' . $id . '_' . $kode_tim_file->kode_tim_ketua . '_visum_kadis.docx';
                            $templateProcessor->saveAs($filename_bukadis);
                           
                            // var_dump($filename_bukadis_simpan);die();
                            $data = [
                                'file_srt_visum_kadis' => $filename_bukadis_simpan,
                            ];
                            $update_perdin = $this->m_perdin->update_e_perdin($pegawai['id_perdin'], $data);
                          }
                          
    
                        
                  }elseif($tipe_undangan == 3){
                      $templateFile = 'assets/file_surat_perdin/template_surat_perdin/template_arahan_pimpinan/surat_perintah_template_bu_kadis_arahan_pimpinan.docx';
                      // Memproses file template yang dipilih
  
                        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor($templateFile);
  
                        // Lanjutkan dengan pengisian data ke dalam template...
  
                        $arrblnRomawi = array("I","II","III","IV","V","VI",'VII','VIII','IX','X','XI','XII');
                        $blnRomawi = $arrblnRomawi[date("m")-1];
                        
                        // Pastikan menggunakan setlocale untuk format bahasa Indonesia
                        setlocale(LC_TIME, 'id_ID.utf8');
  
                        // Mendapatkan hari, tanggal, bulan, dan tahun
                        $hari_ttd = strftime('%A', time()); // Nama hari
                        $tgl_ttd = strftime('%d', time()); // Tanggal (angka)
                        $bln_ttd = strftime('%B', time()); // Nama bulan
  
                        // Ganti "Pebruari" menjadi "Februari"
                        $bln_ttd = str_replace("Pebruari", "Februari", $bln_ttd); // Nama bulan
                        $tahun_text = strftime('%Y', time()); // Tahun (angka)
                        // Membuat nomor random
                        $random_number = mt_rand(1000, 9999); // Nomor random 4 digit
  
                        // Mendapatkan tanggal hari ini dalam format DDMMYYYY
                        $tanggal_hari_ini = date('dmY');
  
                        // Menggabungkan semua elemen menjadi nomor dengan format yang diinginkan
                        $nomor_format = $random_number . '/LKK/kemitraan/' . $tanggal_hari_ini;
  
                        foreach ($filtered_data_bu_kadis as $index => $pegawai) {
                          // Hanya proses data dengan ID tertentu
                          if ($pegawai['id_pegawai'] != 1152) {
                              continue; // Lewati iterasi jika ID tidak sesuai
                          }
                          //  var_dump($pegawai);die();
  
                          $tujuan_keberangkatan_perdin = $this->m_perdin->get_tujuan_keberangkatan_perdin($pegawai['no_grup_perdin'], $pegawai['id_tim']);
  
                          $kab_kota_array = [];
                          if (!empty($tujuan_keberangkatan_perdin)) {
                              foreach ($tujuan_keberangkatan_perdin as $rowlist) {
                                  // Decode jika kab_kota dalam format JSON
                                  $decoded = json_decode($rowlist->kab_kota, true);
                                  if (is_array($decoded)) {
                                      $kab_kota_array = array_merge($kab_kota_array, $decoded); // Gabungkan jika array
                                  } else {
                                      $kab_kota_array[] = $rowlist->kab_kota; // Tambahkan langsung jika bukan JSON
                                  }
                              }
                          } else {
                              echo "No data available"; // Tampilkan pesan jika data kosong
                          }
                          $tujuan_keberangkatan_perdin = $this->m_perdin->get_tujuan_keberangkatan_perdin($pegawai['no_grup_perdin'], $pegawai['id_tim']);
                          
                          $tanggalBerangkat_1 = $tujuan_keberangkatan_perdin[0]->tanggal_berangkat_1;
                          $tanggalBerangkat_2 = $tujuan_keberangkatan_perdin[0]->tanggal_berangkat_2;
                          $tanggalBerangkat_3 = $tujuan_keberangkatan_perdin[0]->tanggal_berangkat_3;
                
                          $tanggal_pulang_1 = $tujuan_keberangkatan_perdin[0]->tanggal_pulang_1;
                          $tanggal_pulang_2 = $tujuan_keberangkatan_perdin[0]->tanggal_pulang_2;
                          $tanggal_pulang_3 = $tujuan_keberangkatan_perdin[0]->tanggal_pulang_3;
          
                          setlocale(LC_TIME, 'id_ID.UTF-8', 'Indonesian', 'id_ID');
  
                          // Format tanggal dengan strftime
                          // Format tanggal dengan strftime
                          $tanggal_pulang_1 = strftime('%d %B %Y', strtotime($tanggal_pulang_1));
                          if ($tanggal_pulang_2 == "0000-00-00") {
                            $tanggal_pulang_2 = '';
                          } else {
                            // Format the date only if it's a valid date
                            $tanggal_pulang_2 = strftime('%d %B %Y', strtotime($tanggal_pulang_2));
                          }
              
                          // Check if $tanggal_pulang_3 is "0000-00-00" and set it to an empty string if true
                          if ($tanggal_pulang_3 == "0000-00-00") {
                            $tanggal_pulang_3 = '';
                          } else {
                            // Format the date only if it's a valid date
                            $tanggal_pulang_3 = strftime('%d %B %Y', strtotime($tanggal_pulang_3));
                          }
  
                          $tglKeberangkatan_1 = strftime('%d %B %Y', strtotime($tanggalBerangkat_1));
                          $tglKeberangkatan_2 = strftime('%d %B %Y', strtotime($tanggalBerangkat_2));
                          $tglKeberangkatan_3 = strftime('%d %B %Y', strtotime($tanggalBerangkat_3));
  
                          // Ganti "Pebruari" menjadi "Februari"
                          $bulan_salah = 'Pebruari';
                          $bulan_benar = 'Februari';
  
                          $tanggal_pulang_1 = str_replace($bulan_salah, $bulan_benar, $tanggal_pulang_1);
                          $tanggal_pulang_2 = str_replace($bulan_salah, $bulan_benar, $tanggal_pulang_2);
                          $tanggal_pulang_3 = str_replace($bulan_salah, $bulan_benar, $tanggal_pulang_3);
  
                          $tglKeberangkatan_1 = str_replace($bulan_salah, $bulan_benar, $tglKeberangkatan_1);
                          $tglKeberangkatan_2 = str_replace($bulan_salah, $bulan_benar, $tglKeberangkatan_2);
                          $tglKeberangkatan_3 = str_replace($bulan_salah, $bulan_benar, $tglKeberangkatan_3);
                          // Format tanggal dengan strftime
                          $tglKeberangkatan = strftime('%d %B %Y', strtotime($pegawai['tanggal_berangkat']));
                          $tglKepulangan = strftime('%d %B %Y', strtotime($pegawai['tanggal_kembali']));
  
                          // Pastikan "Februari" ditulis dengan 'F' bukan 'P'
                          $tglKeberangkatan = str_replace('Pebruari', 'Februari', $tglKeberangkatan);
                          $tglKepulangan = str_replace('Pebruari', 'Februari', $tglKepulangan);
                          
                          if ($tanggalBerangkat_1 == "0000-00-00") {
                            $templateProcessor->setValue("tglKeberangkatan_1", '');
                            $templateProcessor->setValue("tanggal_pulang_1", '');
                            $templateProcessor->setValue("tgl_kepulangan#1", $tanggal_pulang_1);
              
                          }else{
                            $templateProcessor->setValue("tglKeberangkatan_1", $tglKeberangkatan_1);
                            $templateProcessor->setValue("tanggal_pulang_1", $tanggal_pulang_1);
                            
                            if ($tanggalBerangkat_2 === "0000-00-00") {
                                if ($pegawai['lama_p_d'] == 1) {
                                    $templateProcessor->setValue("tgl_kepulangan_sp1", '');
                                } else {
                                    $templateProcessor->setValue("tgl_kepulangan_sp1", "sampai dengan " . $tanggal_pulang_2);
                                }
                                $templateProcessor->setValue("tgl_kepulangan1", $tanggal_pulang_1);
              
                            } else {
                                $templateProcessor->setValue("tgl_kepulangan_sp1", '');
                                $templateProcessor->setValue("tgl_kepulangan1", '');
              
                            }
                          
              
                          }
                          if ($tanggalBerangkat_2 == "0000-00-00") {
                            // var_dump($tanggalBerangkat_2);die();
              
                            $templateProcessor->setValue("tglKeberangkatan_2", '');
                            $templateProcessor->setValue("tanggal_pulang_2", '');
                            
                            $templateProcessor->setValue("tgl_kepulangan2", "");
                            if ($tanggalBerangkat_3 == "0000-00-00") {
                              if ($pegawai['lama_p_d'] == 1) {
                                $templateProcessor->setValue("tgl_kepulangan_sp2", '');
                              } else {
                                  $templateProcessor->setValue("tgl_kepulangan_sp2", "sampai dengan " . $tanggal_pulang_2);
                              }
                            }else{
                              $templateProcessor->setValue("tgl_kepulangan_sp2", "sampai dengan " . $tanggal_pulang_3);
                            }
                          }else{
                            $templateProcessor->setValue("tglKeberangkatan_2", $tglKeberangkatan_2);
                            $templateProcessor->setValue("tanggal_pulang_2", $tanggal_pulang_2);
                            // var_dump($pegawai['lama_p_d']);die();
              
                            if ($tanggalBerangkat_3 == "0000-00-00") {
                              if ($pegawai['lama_p_d'] == 1) {
                                $templateProcessor->setValue("tgl_kepulangan_sp2", '');
                              } else {
                                  $templateProcessor->setValue("tgl_kepulangan_sp2", "sampai dengan " . $tanggal_pulang_2);
                              }
                              $templateProcessor->setValue("tgl_kepulangan2", $tanggal_pulang_2);
              
                            }else{
                              $templateProcessor->setValue("tgl_kepulangan2", "");
                              $templateProcessor->setValue("tgl_kepulangan_sp2", "sampai dengan " . $tanggal_pulang_3);
                            }
              
                          }
                          if ($tanggalBerangkat_3 == "0000-00-00") {
                            $templateProcessor->setValue("tglKeberangkatan_3", '');
                            $templateProcessor->setValue("tanggal_pulang_3", '');
                            $templateProcessor->setValue("tgl_kepulangan3", "");
                            $templateProcessor->setValue("tgl_kepulangan_sp3", '');
                          }else{
                            $templateProcessor->setValue("tglKeberangkatan_3", $tglKeberangkatan_3);
                            $templateProcessor->setValue("tanggal_pulang_3", $tanggal_pulang_3);
                            $templateProcessor->setValue("tgl_kepulangan3", $tanggal_pulang_3);
                            $templateProcessor->setValue("tgl_kepulangan_sp3", '');
                          }
                        
                          
                          // Sanitasi untuk srt_instansi_undangan agar aman untuk penggunaan dalam dokumen Word
                          $srtInstansiUndangan = htmlspecialchars($pegawai['srt_instansi_undangan'], ENT_QUOTES, 'UTF-8');
  
                          $kabupatenKota = ucwords(strtolower($pegawai['nama_tujuan'][0]->n_kabupaten));
                      
                          // Menetapkan nilai pada placeholder di template
                          $templateProcessor->setValue("jabatan", $pegawai['jabatan']);
                          $templateProcessor->setValue("ada", $srtInstansiUndangan);
                          $templateProcessor->setValue("mksd", $pegawai['mksd_pemberangkatan']);
                          $templateProcessor->setValue("kode_rekening_sub_keg", $pegawai['kode_rek_sub_req']);
                          $templateProcessor->setValue("srt_perihal_undangan", $pegawai['perihal_srt_undangan']);
                          $templateProcessor->setValue("srt_nmr_undangan", $pegawai['nmr_srt_undangan']);
                          $templateProcessor->setValue("tgl_srt_undangan", $pegawai['tgl_srt_undangan']);
  
                          $tgl_srt_undangan = strftime('%d %B %Y', strtotime($pegawai['tgl_srt_undangan']));
                          $templateProcessor->setValue("tgl_srt_undangan#{$index}", $tgl_srt_undangan);
  
                            $location_details = [];
                            
                            if (!empty($detail_tempat_1) && isset($kab_kota_array[0])) {
                                $location_details[] = $detail_tempat_1 . ' ' . $kab_kota_array[0];
                            }
                            if (!empty($detail_tempat_2) && isset($kab_kota_array[1])) {
                                $location_details[] = $detail_tempat_2 . ' ' . $kab_kota_array[1];
                            }
                            if (!empty($detail_tempat_3) && isset($kab_kota_array[2])) {
                                $location_details[] = $detail_tempat_3 . ' ' . $kab_kota_array[2];
                            }
                            
                            $final_location_string = implode(', ', $location_details);
                            
                            $templateProcessor->setValue("brtmpt", $final_location_string);
                          $templateProcessor->setValue("lama_perdin", $pegawai['lama_p_d']);
                          $templateProcessor->setValue("tgl_keberangkatan", $tglKeberangkatan);
                          $templateProcessor->setValue("tgl_kepulangan", $tglKepulangan);
                          $templateProcessor->setValue("kabupaten_kota_bertempatan", $kabupatenKota);
                          $templateProcessor->setValue("kepada_nama", $pegawai['nama_pegawai']);
                          $templateProcessor->setValue("kode_rek", $pegawai['kode_rek']);
                          $templateProcessor->setValue("arahan_pimpinan", $pegawai['dasar_arahan_pimpiman']);
                          $templateProcessor->setValue("kode_tim", $kode_tim);
                          $templateProcessor->setValue("no_urut", $no_grup_perdin);
                          $templateProcessor->setValue("kendaraan", $pegawai['kendaraan']);
                          // Cek apakah nip ada, jika ada maka kolom nip akan muncul
                          if (!empty($pegawai['pangkat_gol']) && strtolower($pegawai['pangkat_gol']) != 'tenaga kontrak') {
                              $templateProcessor->setValue("nama_kolom_nip", 'Nomor Induk Pegawai');
                              $templateProcessor->setValue("nip", $pegawai['nip']);
                              $pangkatGolongan = (isset($pegawai['pangkat_gol']) && isset($pegawai['golongan']) && $pegawai['pangkat_gol'] !== '' && $pegawai['golongan'] !== '' && $pegawai['pangkat_gol'] !== 'Tenaga Kontrak') 
                              ? $pegawai['pangkat_gol'] . ' (' . $pegawai['golongan'] .')'
                              : 'Non ASN';
                  
                  
                                              $templateProcessor->setValue("Pangkat_golongan", $pangkatGolongan);
  
  
                          } else {
                            $templateProcessor->setValue("nama_kolom_nip#{$index}", 'Nomor Induk Pegawai');
                            $templateProcessor->setValue("nip#{$index}", '-');
                            $pangkatGolongan = (isset($pegawai['pangkat_gol']) && isset($pegawai['golongan']) && $pegawai['pangkat_gol'] !== '' && $pegawai['golongan'] !== '' && $pegawai['pangkat_gol'] !== 'Tenaga Kontrak') 
                            ? $pegawai['pangkat_gol'] . ' (' . $pegawai['golongan'] .')'
                            : 'Non ASN';
                
                
                                            $templateProcessor->setValue("Pangkat_golongan", $pangkatGolongan);
                          }
                          $templateProcessor->setValue("Pangkat_golongan_visum#{$index}", $pangkatGolongan);
  
                          $templateProcessor->setValue("jabatan", $pegawai['jabatan']); 
                          $templateProcessor->setValue("golongan", $pegawai['golongan']); 
  
                          if (count($kab_kota_array) == 1) {
                              $templateProcessor->setValue("tempat_tujuan#1", isset($kab_kota_array[0]) ? $kab_kota_array[0] . ' ' : '');
                              $templateProcessor->setValue("tempat_tujuan#2", isset($kab_kota_array[1]) ? $kab_kota_array[1] . ',' : '');
                              $templateProcessor->setValue("tempat_tujuan#3", isset($kab_kota_array[2]) ? $kab_kota_array[2] . ',' : '');
                
                              $templateProcessor->setValue("tempat_tujuan_1_kota#0", 'Kota Bandung');
                              $templateProcessor->setValue("tempat_tujuan_2_kota#0", '');
                              $templateProcessor->setValue("tempat_tujuan_3_kota#0", '');
                          }elseif(count($kab_kota_array) == 2){
                            $templateProcessor->setValue("tempat_tujuan#1", isset($kab_kota_array[0]) ? $kab_kota_array[0] . ',' : '');
                            $templateProcessor->setValue("tempat_tujuan#2", isset($kab_kota_array[1]) ? $kab_kota_array[1] . ' ' : '');
                            $templateProcessor->setValue("tempat_tujuan#3", isset($kab_kota_array[2]) ? $kab_kota_array[2] . ',' : '');
                
                            $templateProcessor->setValue("tempat_tujuan_1_kota#0", '');
                            $templateProcessor->setValue("tempat_tujuan_2_kota#0", 'Kota Bandung');
                            $templateProcessor->setValue("tempat_tujuan_3_kota#0", '');
                          }else{
                            $templateProcessor->setValue("tempat_tujuan#1", isset($kab_kota_array[0]) ? $kab_kota_array[0] . ',' : '');
                            $templateProcessor->setValue("tempat_tujuan#2", isset($kab_kota_array[1]) ? $kab_kota_array[1] . ',' : '');
                            $templateProcessor->setValue("tempat_tujuan#3", isset($kab_kota_array[2]) ? $kab_kota_array[2] . ' ' : '');
                
                            $templateProcessor->setValue("tempat_tujuan_1_kota#0", '');
                            $templateProcessor->setValue("tempat_tujuan_2_kota#0", '');
                            $templateProcessor->setValue("tempat_tujuan_3_kota#0", 'Kota Bandung');
                          }
                          $templateProcessor->deleteBlock('nomor_induk_pegawai_row');
  
                          
                       
  
                          $filename_bukadis = 'assets/file_surat_perdin/kadis_sekdis/SPPD_' . date('Ymd') . '_' . $id . '_' . $kode_tim_file->kode_tim_ketua . '_kadis.docx';
                          $filename_bukadis_simpan = 'SPPD_' . date('Ymd') . '_' . $id . '_' . $kode_tim_file->kode_tim_ketua . '_kadis.docx';
                          
                          $data = [
                              'file_srt' => $filename_bukadis_simpan,
                          ];
                          $update_perdin = $this->m_perdin->update_e_perdin($pegawai['id_perdin'], $data);
  
                          $templateProcessor->saveAs($filename_bukadis);
                        }
                          $templateFile = 'assets/file_surat_perdin/template_surat_perdin/visum_kadis.docx';
                          // Memproses file template yang dipilih
    
                          $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor($templateFile);
    
                          // Lanjutkan dengan pengisian data ke dalam template...
    
                          $arrblnRomawi = array("I","II","III","IV","V","VI",'VII','VIII','IX','X','XI','XII');
                          $blnRomawi = $arrblnRomawi[date("m")-1];
                          
                          // Pastikan menggunakan setlocale untuk format bahasa Indonesia
                          setlocale(LC_TIME, 'id_ID.utf8');
    
                          // Mendapatkan hari, tanggal, bulan, dan tahun
                          $hari_ttd = strftime('%A', time()); // Nama hari
                          $tgl_ttd = strftime('%d', time()); // Tanggal (angka)
                          $bln_ttd = strftime('%B', time()); // Nama bulan
  
                          // Ganti "Pebruari" menjadi "Februari"
                          $bln_ttd = str_replace("Pebruari", "Februari", $bln_ttd); // Nama bulan
                          $tahun_text = strftime('%Y', time()); // Tahun (angka)
                          // Membuat nomor random
                          $random_number = mt_rand(1000, 9999); // Nomor random 4 digit
    
                          // Mendapatkan tanggal hari ini dalam format DDMMYYYY
                          $tanggal_hari_ini = date('dmY');
    
                          // Menggabungkan semua elemen menjadi nomor dengan format yang diinginkan
                          $nomor_format = $random_number . '/LKK/kemitraan/' . $tanggal_hari_ini;
    
                          foreach ($filtered_data_bu_kadis as $index => $pegawai) {
                            // Hanya proses data dengan ID tertentu
                            if ($pegawai['id_pegawai'] != 1152) {
                                continue; // Lewati iterasi jika ID tidak sesuai
                            }
                            //  var_dump($pegawai);die();
    
                            $tujuan_keberangkatan_perdin = $this->m_perdin->get_tujuan_keberangkatan_perdin($pegawai['no_grup_perdin'], $pegawai['id_tim']);
    
                            $kab_kota_array = [];
                            if (!empty($tujuan_keberangkatan_perdin)) {
                                foreach ($tujuan_keberangkatan_perdin as $rowlist) {
                                    // Decode jika kab_kota dalam format JSON
                                    $decoded = json_decode($rowlist->kab_kota, true);
                                    if (is_array($decoded)) {
                                        $kab_kota_array = array_merge($kab_kota_array, $decoded); // Gabungkan jika array
                                    } else {
                                        $kab_kota_array[] = $rowlist->kab_kota; // Tambahkan langsung jika bukan JSON
                                    }
                                }
                            } else {
                                echo "No data available"; // Tampilkan pesan jika data kosong
                            }
                            $tujuan_keberangkatan_perdin = $this->m_perdin->get_tujuan_keberangkatan_perdin($pegawai['no_grup_perdin'], $pegawai['id_tim']);
                            
                            $tanggalBerangkat_1 = $tujuan_keberangkatan_perdin[0]->tanggal_berangkat_1;
                            $tanggalBerangkat_2 = $tujuan_keberangkatan_perdin[0]->tanggal_berangkat_2;
                            $tanggalBerangkat_3 = $tujuan_keberangkatan_perdin[0]->tanggal_berangkat_3;
                  
                            $tanggal_pulang_1 = $tujuan_keberangkatan_perdin[0]->tanggal_pulang_1;
                            $tanggal_pulang_2 = $tujuan_keberangkatan_perdin[0]->tanggal_pulang_2;
                            $tanggal_pulang_3 = $tujuan_keberangkatan_perdin[0]->tanggal_pulang_3;
            
                            setlocale(LC_TIME, 'id_ID.UTF-8', 'Indonesian', 'id_ID');
    
                            // Format tanggal dengan strftime
                            // Format tanggal dengan strftime
                            $tanggal_pulang_1 = strftime('%d %B %Y', strtotime($tanggal_pulang_1));
                            if ($tanggal_pulang_2 == "0000-00-00") {
                              $tanggal_pulang_2 = '';
                            } else {
                              // Format the date only if it's a valid date
                              $tanggal_pulang_2 = strftime('%d %B %Y', strtotime($tanggal_pulang_2));
                            }
                
                            // Check if $tanggal_pulang_3 is "0000-00-00" and set it to an empty string if true
                            if ($tanggal_pulang_3 == "0000-00-00") {
                              $tanggal_pulang_3 = '';
                            } else {
                              // Format the date only if it's a valid date
                              $tanggal_pulang_3 = strftime('%d %B %Y', strtotime($tanggal_pulang_3));
                            }
    
                            $tglKeberangkatan_1 = strftime('%d %B %Y', strtotime($tanggalBerangkat_1));
                            $tglKeberangkatan_2 = strftime('%d %B %Y', strtotime($tanggalBerangkat_2));
                            $tglKeberangkatan_3 = strftime('%d %B %Y', strtotime($tanggalBerangkat_3));
    
                            // Ganti "Pebruari" menjadi "Februari"
                            $bulan_salah = 'Pebruari';
                            $bulan_benar = 'Februari';
    
                            $tanggal_pulang_1 = str_replace($bulan_salah, $bulan_benar, $tanggal_pulang_1);
                            $tanggal_pulang_2 = str_replace($bulan_salah, $bulan_benar, $tanggal_pulang_2);
                            $tanggal_pulang_3 = str_replace($bulan_salah, $bulan_benar, $tanggal_pulang_3);
    
                            $tglKeberangkatan_1 = str_replace($bulan_salah, $bulan_benar, $tglKeberangkatan_1);
                            $tglKeberangkatan_2 = str_replace($bulan_salah, $bulan_benar, $tglKeberangkatan_2);
                            $tglKeberangkatan_3 = str_replace($bulan_salah, $bulan_benar, $tglKeberangkatan_3);
                            // Format tanggal dengan strftime
                            $tglKeberangkatan = strftime('%d %B %Y', strtotime($pegawai['tanggal_berangkat']));
                            $tglKepulangan = strftime('%d %B %Y', strtotime($pegawai['tanggal_kembali']));
    
                            // Pastikan "Februari" ditulis dengan 'F' bukan 'P'
                            $tglKeberangkatan = str_replace('Pebruari', 'Februari', $tglKeberangkatan);
                            $tglKepulangan = str_replace('Pebruari', 'Februari', $tglKepulangan);
                            // var_dump($tglKeberangkatan);die();
                            if ($tanggalBerangkat_1 == "0000-00-00") {
                              $templateProcessor->setValue("tglKeberangkatan_1", '');
                              $templateProcessor->setValue("tanggal_pulang_1", '');
                              $templateProcessor->setValue("tgl_kepulangan#1", $tanggal_pulang_1);
                
                            }else{
                              $templateProcessor->setValue("tglKeberangkatan_1", $tglKeberangkatan_1);
                              $templateProcessor->setValue("tanggal_pulang_1", $tanggal_pulang_1);
                              
                              if ($tanggalBerangkat_2 === "0000-00-00") {
                                  if ($pegawai['lama_p_d'] == 1) {
                                      $templateProcessor->setValue("tgl_kepulangan_sp1", '');
                                  } else {
                                      $templateProcessor->setValue("tgl_kepulangan_sp1", "sampai dengan " . $tanggal_pulang_2);
                                  }
                                  $templateProcessor->setValue("tgl_kepulangan1", $tanggal_pulang_1);
                
                              } else {
                                  $templateProcessor->setValue("tgl_kepulangan_sp1", '');
                                  $templateProcessor->setValue("tgl_kepulangan1", '');
                
                              }
                            
                
                            }
                            if ($tanggalBerangkat_2 == "0000-00-00") {
                              // var_dump($tanggalBerangkat_2);die();
                
                              $templateProcessor->setValue("tglKeberangkatan_2", '');
                              $templateProcessor->setValue("tanggal_pulang_2", '');
                              
                              $templateProcessor->setValue("tgl_kepulangan2", "");
                              if ($tanggalBerangkat_3 == "0000-00-00") {
                                if ($pegawai['lama_p_d'] == 1) {
                                  $templateProcessor->setValue("tgl_kepulangan_sp2", '');
                                } else {
                                    $templateProcessor->setValue("tgl_kepulangan_sp2", "sampai dengan " . $tanggal_pulang_2);
                                }
                              }else{
                                $templateProcessor->setValue("tgl_kepulangan_sp2", "sampai dengan " . $tanggal_pulang_3);
                              }
                            }else{
                              $templateProcessor->setValue("tglKeberangkatan_2", $tglKeberangkatan_2);
                              $templateProcessor->setValue("tanggal_pulang_2", $tanggal_pulang_2);
                              // var_dump($pegawai['lama_p_d']);die();
                
                              if ($tanggalBerangkat_3 == "0000-00-00") {
                                if ($pegawai['lama_p_d'] == 1) {
                                  $templateProcessor->setValue("tgl_kepulangan_sp2", '');
                                } else {
                                    $templateProcessor->setValue("tgl_kepulangan_sp2", "sampai dengan " . $tanggal_pulang_2);
                                }
                                $templateProcessor->setValue("tgl_kepulangan2", $tanggal_pulang_2);
                
                              }else{
                                $templateProcessor->setValue("tgl_kepulangan2", "");
                                $templateProcessor->setValue("tgl_kepulangan_sp2", "sampai dengan " . $tanggal_pulang_3);
                              }
                
                            }
                            if ($tanggalBerangkat_3 == "0000-00-00") {
                              $templateProcessor->setValue("tglKeberangkatan_3", '');
                              $templateProcessor->setValue("tanggal_pulang_3", '');
                              $templateProcessor->setValue("tgl_kepulangan3", "");
                              $templateProcessor->setValue("tgl_kepulangan_sp3", '');
                            }else{
                              $templateProcessor->setValue("tglKeberangkatan_3", $tglKeberangkatan_3);
                              $templateProcessor->setValue("tanggal_pulang_3", $tanggal_pulang_3);
                              $templateProcessor->setValue("tgl_kepulangan3", $tanggal_pulang_3);
                              $templateProcessor->setValue("tgl_kepulangan_sp3", '');
                            }
                          
                            
                            // Sanitasi untuk srt_instansi_undangan agar aman untuk penggunaan dalam dokumen Word
                            $srtInstansiUndangan = htmlspecialchars($pegawai['srt_instansi_undangan'], ENT_QUOTES, 'UTF-8');
    
                            $kabupatenKota = ucwords(strtolower($pegawai['nama_tujuan'][0]->n_kabupaten));
                        
                            // Menetapkan nilai pada placeholder di template
                            $templateProcessor->setValue("jabatan", $pegawai['jabatan']);
                            $templateProcessor->setValue("ada", $srtInstansiUndangan);
                            $templateProcessor->setValue("mksd", $pegawai['mksd_pemberangkatan']);
                            $templateProcessor->setValue("kode_rekening_sub_keg", $pegawai['kode_rek_sub_req']);
                            $templateProcessor->setValue("srt_perihal_undangan", $pegawai['perihal_srt_undangan']);
                            $templateProcessor->setValue("srt_nmr_undangan", $pegawai['nmr_srt_undangan']);
                            $tgl_srt_undangan = strftime('%d %B %Y', strtotime($pegawai['tgl_srt_undangan']));
                            $templateProcessor->setValue("tgl_srt_undangan#{$index}", $tgl_srt_undangan);
  
                            $location_details = [];
                            
                            if (!empty($detail_tempat_1) && isset($kab_kota_array[0])) {
                                $location_details[] = $detail_tempat_1 . ' ' . $kab_kota_array[0];
                            }
                            if (!empty($detail_tempat_2) && isset($kab_kota_array[1])) {
                                $location_details[] = $detail_tempat_2 . ' ' . $kab_kota_array[1];
                            }
                            if (!empty($detail_tempat_3) && isset($kab_kota_array[2])) {
                                $location_details[] = $detail_tempat_3 . ' ' . $kab_kota_array[2];
                            }
                            
                            $final_location_string = implode(', ', $location_details);
                            
                            $templateProcessor->setValue("brtmpt", $final_location_string);
                            $templateProcessor->setValue("lama_perdin", $pegawai['lama_p_d']);
                            $templateProcessor->setValue("tgl_keberangkatan", $tglKeberangkatan);
                            $templateProcessor->setValue("tgl_kepulangan", $tglKepulangan);
                            $templateProcessor->setValue("kabupaten_kota_bertempatan", $kabupatenKota);
                            $templateProcessor->setValue("kepada_nama", $pegawai['nama_pegawai']);
                            $templateProcessor->setValue("kode_rek", $pegawai['kode_rek']);
                            $templateProcessor->setValue("arahan_pimpinan", $pegawai['dasar_arahan_pimpiman']);
                            $templateProcessor->setValue("kode_tim", $kode_tim);
                            $templateProcessor->setValue("no_urut", $no_grup_perdin);
                            $templateProcessor->setValue("kendaraan", $pegawai['kendaraan']);
                            // Cek apakah nip ada, jika ada maka kolom nip akan muncul
                            if (!empty($pegawai['pangkat_gol']) && strtolower($pegawai['pangkat_gol']) != 'tenaga kontrak') {
                                $templateProcessor->setValue("nama_kolom_nip", 'Nomor Induk Pegawai');
                                $templateProcessor->setValue("nip", $pegawai['nip']);
                                $pangkatGolongan = (isset($pegawai['pangkat_gol']) && isset($pegawai['golongan']) && $pegawai['pangkat_gol'] !== '' && $pegawai['golongan'] !== '' && $pegawai['pangkat_gol'] !== 'Tenaga Kontrak') 
                                ? $pegawai['pangkat_gol'] . ' (' . $pegawai['golongan'] .')'
                                : 'Non ASN';
                    
                    
                                                $templateProcessor->setValue("Pangkat_golongan", $pangkatGolongan);
    
    
                            } else {
                              $templateProcessor->setValue("nama_kolom_nip#{$index}", 'Nomor Induk Pegawai');
                              $templateProcessor->setValue("nip#{$index}", '-');
                              $pangkatGolongan = (isset($pegawai['pangkat_gol']) && isset($pegawai['golongan']) && $pegawai['pangkat_gol'] !== '' && $pegawai['golongan'] !== '' && $pegawai['pangkat_gol'] !== 'Tenaga Kontrak') 
                              ? $pegawai['pangkat_gol'] . ' (' . $pegawai['golongan'] .')'
                              : 'Non ASN';
                  
                  
                                              $templateProcessor->setValue("Pangkat_golongan", $pangkatGolongan);
                            }
                            $templateProcessor->setValue("Pangkat_golongan_visum#{$index}", $pangkatGolongan);
    
                            $templateProcessor->setValue("jabatan", $pegawai['jabatan']); 
                            $templateProcessor->setValue("golongan", $pegawai['golongan']); 
    
                            if (count($kab_kota_array) == 1) {
                                $templateProcessor->setValue("tempat_tujuan#1", isset($kab_kota_array[0]) ? $kab_kota_array[0] . ' ' : '');
                                $templateProcessor->setValue("tempat_tujuan#2", isset($kab_kota_array[1]) ? $kab_kota_array[1] . ',' : '');
                                $templateProcessor->setValue("tempat_tujuan#3", isset($kab_kota_array[2]) ? $kab_kota_array[2] . ',' : '');
                  
                                $templateProcessor->setValue("tempat_tujuan_1_kota#0", 'Kota Bandung');
                                $templateProcessor->setValue("tempat_tujuan_2_kota#0", '');
                                $templateProcessor->setValue("tempat_tujuan_3_kota#0", '');
                            }elseif(count($kab_kota_array) == 2){
                              $templateProcessor->setValue("tempat_tujuan#1", isset($kab_kota_array[0]) ? $kab_kota_array[0] . ',' : '');
                              $templateProcessor->setValue("tempat_tujuan#2", isset($kab_kota_array[1]) ? $kab_kota_array[1] . ' ' : '');
                              $templateProcessor->setValue("tempat_tujuan#3", isset($kab_kota_array[2]) ? $kab_kota_array[2] . ',' : '');
                  
                              $templateProcessor->setValue("tempat_tujuan_1_kota#0", '');
                              $templateProcessor->setValue("tempat_tujuan_2_kota#0", 'Kota Bandung');
                              $templateProcessor->setValue("tempat_tujuan_3_kota#0", '');
                            }else{
                              $templateProcessor->setValue("tempat_tujuan#1", isset($kab_kota_array[0]) ? $kab_kota_array[0] . ',' : '');
                              $templateProcessor->setValue("tempat_tujuan#2", isset($kab_kota_array[1]) ? $kab_kota_array[1] . ',' : '');
                              $templateProcessor->setValue("tempat_tujuan#3", isset($kab_kota_array[2]) ? $kab_kota_array[2] . ' ' : '');
                  
                              $templateProcessor->setValue("tempat_tujuan_1_kota#0", '');
                              $templateProcessor->setValue("tempat_tujuan_2_kota#0", '');
                              $templateProcessor->setValue("tempat_tujuan_3_kota#0", 'Kota Bandung');
                            }
                            $templateProcessor->deleteBlock('nomor_induk_pegawai_row');
    
                            
                         
    
                            $filename_bukadis = 'assets/file_surat_perdin/visum_kadis/SPPD_' . date('Ymd') . '_' . $id . '_' . $kode_tim_file->kode_tim_ketua . '_visum_kadis.docx';
                            $filename_bukadis_simpan = 'SPPD_' . date('Ymd') . '_' . $id . '_' . $kode_tim_file->kode_tim_ketua . '_visum_kadis.docx';
                            $templateProcessor->saveAs($filename_bukadis);
                           
                            // var_dump($filename_bukadis_simpan);die();
                            $data = [
                                'file_srt_visum_kadis' => $filename_bukadis_simpan,
                            ];
                            $update_perdin = $this->m_perdin->update_e_perdin($pegawai['id_perdin'], $data);
                          }
  
                  } else {
                      $templateFile = 'assets/file_surat_perdin/template_surat_perdin/surat_perintah_template_bu_kadis_tipe1.docx';
                        // Memproses file template yang dipilih
  
                        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor($templateFile);
  
                        // Lanjutkan dengan pengisian data ke dalam template...
  
                        $arrblnRomawi = array("I","II","III","IV","V","VI",'VII','VIII','IX','X','XI','XII');
                        $blnRomawi = $arrblnRomawi[date("m")-1];
                        
                        // Pastikan menggunakan setlocale untuk format bahasa Indonesia
                        setlocale(LC_TIME, 'id_ID.utf8');
  
                        // Mendapatkan hari, tanggal, bulan, dan tahun
                        $hari_ttd = strftime('%A', time()); // Nama hari
                        $tgl_ttd = strftime('%d', time()); // Tanggal (angka)
                        $bln_ttd = strftime('%B', time()); // Nama bulan
  
                        // Ganti "Pebruari" menjadi "Februari"
                        $bln_ttd = str_replace("Pebruari", "Februari", $bln_ttd); // Nama bulan
                        $tahun_text = strftime('%Y', time()); // Tahun (angka)
                        // Membuat nomor random
                        $random_number = mt_rand(1000, 9999); // Nomor random 4 digit
  
                        // Mendapatkan tanggal hari ini dalam format DDMMYYYY
                        $tanggal_hari_ini = date('dmY');
  
                        // Menggabungkan semua elemen menjadi nomor dengan format yang diinginkan
                        $nomor_format = $random_number . '/LKK/kemitraan/' . $tanggal_hari_ini;
  
                        foreach ($filtered_data_bu_kadis as $index => $pegawai) {
                          // Hanya proses data dengan ID tertentu
                          if ($pegawai['id_pegawai'] != 1152) {
                              continue; // Lewati iterasi jika ID tidak sesuai
                          }
                          //  var_dump($pegawai);die();
  
                          $tujuan_keberangkatan_perdin = $this->m_perdin->get_tujuan_keberangkatan_perdin($pegawai['no_grup_perdin'], $pegawai['id_tim']);
  
                          $kab_kota_array = [];
                          if (!empty($tujuan_keberangkatan_perdin)) {
                              foreach ($tujuan_keberangkatan_perdin as $rowlist) {
                                  // Decode jika kab_kota dalam format JSON
                                  $decoded = json_decode($rowlist->kab_kota, true);
                                  if (is_array($decoded)) {
                                      $kab_kota_array = array_merge($kab_kota_array, $decoded); // Gabungkan jika array
                                  } else {
                                      $kab_kota_array[] = $rowlist->kab_kota; // Tambahkan langsung jika bukan JSON
                                  }
                              }
                          } else {
                              echo "No data available"; // Tampilkan pesan jika data kosong
                          }
                          $tujuan_keberangkatan_perdin = $this->m_perdin->get_tujuan_keberangkatan_perdin($pegawai['no_grup_perdin'], $pegawai['id_tim']);
                          
                          $tanggalBerangkat_1 = $tujuan_keberangkatan_perdin[0]->tanggal_berangkat_1;
                          $tanggalBerangkat_2 = $tujuan_keberangkatan_perdin[0]->tanggal_berangkat_2;
                          $tanggalBerangkat_3 = $tujuan_keberangkatan_perdin[0]->tanggal_berangkat_3;
                
                          $tanggal_pulang_1 = $tujuan_keberangkatan_perdin[0]->tanggal_pulang_1;
                          $tanggal_pulang_2 = $tujuan_keberangkatan_perdin[0]->tanggal_pulang_2;
                          $tanggal_pulang_3 = $tujuan_keberangkatan_perdin[0]->tanggal_pulang_3;
          
                          setlocale(LC_TIME, 'id_ID.UTF-8', 'Indonesian', 'id_ID');
  
                          // Format tanggal dengan strftime
                          // Format tanggal dengan strftime
                          $tanggal_pulang_1 = strftime('%d %B %Y', strtotime($tanggal_pulang_1));
                          if ($tanggal_pulang_2 == "0000-00-00") {
                            $tanggal_pulang_2 = '';
                          } else {
                            // Format the date only if it's a valid date
                            $tanggal_pulang_2 = strftime('%d %B %Y', strtotime($tanggal_pulang_2));
                          }
              
                          // Check if $tanggal_pulang_3 is "0000-00-00" and set it to an empty string if true
                          if ($tanggal_pulang_3 == "0000-00-00") {
                            $tanggal_pulang_3 = '';
                          } else {
                            // Format the date only if it's a valid date
                            $tanggal_pulang_3 = strftime('%d %B %Y', strtotime($tanggal_pulang_3));
                          }
  
                          $tglKeberangkatan_1 = strftime('%d %B %Y', strtotime($tanggalBerangkat_1));
                          $tglKeberangkatan_2 = strftime('%d %B %Y', strtotime($tanggalBerangkat_2));
                          $tglKeberangkatan_3 = strftime('%d %B %Y', strtotime($tanggalBerangkat_3));
  
                          // Ganti "Pebruari" menjadi "Februari"
                          $bulan_salah = 'Pebruari';
                          $bulan_benar = 'Februari';
  
                          $tanggal_pulang_1 = str_replace($bulan_salah, $bulan_benar, $tanggal_pulang_1);
                          $tanggal_pulang_2 = str_replace($bulan_salah, $bulan_benar, $tanggal_pulang_2);
                          $tanggal_pulang_3 = str_replace($bulan_salah, $bulan_benar, $tanggal_pulang_3);
  
                          $tglKeberangkatan_1 = str_replace($bulan_salah, $bulan_benar, $tglKeberangkatan_1);
                          $tglKeberangkatan_2 = str_replace($bulan_salah, $bulan_benar, $tglKeberangkatan_2);
                          $tglKeberangkatan_3 = str_replace($bulan_salah, $bulan_benar, $tglKeberangkatan_3);
                          // Format tanggal dengan strftime
                          $tglKeberangkatan = strftime('%d %B %Y', strtotime($pegawai['tanggal_berangkat']));
                          $tglKepulangan = strftime('%d %B %Y', strtotime($pegawai['tanggal_kembali']));
  
                          // Pastikan "Februari" ditulis dengan 'F' bukan 'P'
                          $tglKeberangkatan = str_replace('Pebruari', 'Februari', $tglKeberangkatan);
                          $tglKepulangan = str_replace('Pebruari', 'Februari', $tglKepulangan);
                          // var_dump($tglKeberangkatan);die();
                          if ($tanggalBerangkat_1 == "0000-00-00") {
                            $templateProcessor->setValue("tglKeberangkatan_1", '');
                            $templateProcessor->setValue("tanggal_pulang_1", '');
                            $templateProcessor->setValue("tgl_kepulangan#1", $tanggal_pulang_1);
              
                          }else{
                            $templateProcessor->setValue("tglKeberangkatan_1", $tglKeberangkatan_1);
                            $templateProcessor->setValue("tanggal_pulang_1", $tanggal_pulang_1);
                            
                            if ($tanggalBerangkat_2 === "0000-00-00") {
                                if ($pegawai['lama_p_d'] == 1) {
                                    $templateProcessor->setValue("tgl_kepulangan_sp1", '');
                                } else {
                                    $templateProcessor->setValue("tgl_kepulangan_sp1", "sampai dengan " . $tanggal_pulang_2);
                                }
                                $templateProcessor->setValue("tgl_kepulangan1", $tanggal_pulang_1);
              
                            } else {
                                $templateProcessor->setValue("tgl_kepulangan_sp1", '');
                                $templateProcessor->setValue("tgl_kepulangan1", '');
              
                            }
                          
              
                          }
                          if ($tanggalBerangkat_2 == "0000-00-00") {
                            // var_dump($tanggalBerangkat_2);die();
              
                            $templateProcessor->setValue("tglKeberangkatan_2", '');
                            $templateProcessor->setValue("tanggal_pulang_2", '');
                            
                            $templateProcessor->setValue("tgl_kepulangan2", "");
                            if ($tanggalBerangkat_3 == "0000-00-00") {
                              if ($pegawai['lama_p_d'] == 1) {
                                $templateProcessor->setValue("tgl_kepulangan_sp2", '');
                              } else {
                                  $templateProcessor->setValue("tgl_kepulangan_sp2", "sampai dengan " . $tanggal_pulang_2);
                              }
                            }else{
                              $templateProcessor->setValue("tgl_kepulangan_sp2", "sampai dengan " . $tanggal_pulang_3);
                            }
                          }else{
                            $templateProcessor->setValue("tglKeberangkatan_2", $tglKeberangkatan_2);
                            $templateProcessor->setValue("tanggal_pulang_2", $tanggal_pulang_2);
                            // var_dump($pegawai['lama_p_d']);die();
              
                            if ($tanggalBerangkat_3 == "0000-00-00") {
                              if ($pegawai['lama_p_d'] == 1) {
                                $templateProcessor->setValue("tgl_kepulangan_sp2", '');
                              } else {
                                  $templateProcessor->setValue("tgl_kepulangan_sp2", "sampai dengan " . $tanggal_pulang_2);
                              }
                              $templateProcessor->setValue("tgl_kepulangan2", $tanggal_pulang_2);
              
                            }else{
                              $templateProcessor->setValue("tgl_kepulangan2", "");
                              $templateProcessor->setValue("tgl_kepulangan_sp2", "sampai dengan " . $tanggal_pulang_3);
                            }
              
                          }
                          if ($tanggalBerangkat_3 == "0000-00-00") {
                            $templateProcessor->setValue("tglKeberangkatan_3", '');
                            $templateProcessor->setValue("tanggal_pulang_3", '');
                            $templateProcessor->setValue("tgl_kepulangan3", "");
                            $templateProcessor->setValue("tgl_kepulangan_sp3", '');
                          }else{
                            $templateProcessor->setValue("tglKeberangkatan_3", $tglKeberangkatan_3);
                            $templateProcessor->setValue("tanggal_pulang_3", $tanggal_pulang_3);
                            $templateProcessor->setValue("tgl_kepulangan3", $tanggal_pulang_3);
                            $templateProcessor->setValue("tgl_kepulangan_sp3", '');
                          }
                        
                          
                          // Sanitasi untuk srt_instansi_undangan agar aman untuk penggunaan dalam dokumen Word
                          $srtInstansiUndangan = htmlspecialchars($pegawai['srt_instansi_undangan'], ENT_QUOTES, 'UTF-8');
  
                          $kabupatenKota = ucwords(strtolower($pegawai['nama_tujuan'][0]->n_kabupaten));
                      
                          // Menetapkan nilai pada placeholder di template
                          $templateProcessor->setValue("jabatan", $pegawai['jabatan']);
                          $templateProcessor->setValue("ada", $srtInstansiUndangan);
                          $templateProcessor->setValue("mksd", $pegawai['mksd_pemberangkatan']);
                          $templateProcessor->setValue("kode_rekening_sub_keg", $pegawai['kode_rek_sub_req']);
                          $templateProcessor->setValue("srt_perihal_undangan", $pegawai['perihal_srt_undangan']);
                          $templateProcessor->setValue("srt_nmr_undangan", $pegawai['nmr_srt_undangan']);
                          $templateProcessor->setValue("tgl_srt_undangan", $pegawai['tgl_srt_undangan']);
                            $templateProcessor->setValue("tgl_srt_undangan#{$index}", $tgl_srt_undangan);
  
                  $location_details = [];
                  
                  if (!empty($detail_tempat_1) && isset($kab_kota_array[0])) {
                      $location_details[] = $detail_tempat_1 . ' ' . $kab_kota_array[0];
                  }
                  if (!empty($detail_tempat_2) && isset($kab_kota_array[1])) {
                      $location_details[] = $detail_tempat_2 . ' ' . $kab_kota_array[1];
                  }
                  if (!empty($detail_tempat_3) && isset($kab_kota_array[2])) {
                      $location_details[] = $detail_tempat_3 . ' ' . $kab_kota_array[2];
                  }
                  
                  $final_location_string = implode(', ', $location_details);
                  
                  $templateProcessor->setValue("brtmpt", $final_location_string);
                          $templateProcessor->setValue("lama_perdin", $pegawai['lama_p_d']);
                          $templateProcessor->setValue("tgl_keberangkatan", $tglKeberangkatan);
                          $templateProcessor->setValue("tgl_kepulangan", $tglKepulangan);
                          $templateProcessor->setValue("kabupaten_kota_bertempatan", $kabupatenKota);
                          $templateProcessor->setValue("kepada_nama", $pegawai['nama_pegawai']);
                          $templateProcessor->setValue("kode_rek", $pegawai['kode_rek']);
                          $templateProcessor->setValue("arahan_pimpinan", $pegawai['dasar_arahan_pimpiman']);
                          $templateProcessor->setValue("kode_tim", $kode_tim);
                          $templateProcessor->setValue("no_urut", $no_grup_perdin);
                          $templateProcessor->setValue("kendaraan", $pegawai['kendaraan']);
                          // Cek apakah nip ada, jika ada maka kolom nip akan muncul
                          if (!empty($pegawai['pangkat_gol']) && strtolower($pegawai['pangkat_gol']) != 'tenaga kontrak') {
                              $templateProcessor->setValue("nama_kolom_nip", 'Nomor Induk Pegawai');
                              $templateProcessor->setValue("nip", $pegawai['nip']);
                              $pangkatGolongan = (isset($pegawai['pangkat_gol']) && isset($pegawai['golongan']) && $pegawai['pangkat_gol'] !== '' && $pegawai['golongan'] !== '' && $pegawai['pangkat_gol'] !== 'Tenaga Kontrak') 
                              ? $pegawai['pangkat_gol'] . ' (' . $pegawai['golongan'] .')'
                              : 'Non ASN';
                  
                  
                                              $templateProcessor->setValue("Pangkat_golongan", $pangkatGolongan);
  
  
                          } else {
                            $templateProcessor->setValue("nama_kolom_nip#{$index}", 'Nomor Induk Pegawai');
                            $templateProcessor->setValue("nip#{$index}", '-');
                            $pangkatGolongan = (isset($pegawai['pangkat_gol']) && isset($pegawai['golongan']) && $pegawai['pangkat_gol'] !== '' && $pegawai['golongan'] !== '' && $pegawai['pangkat_gol'] !== 'Tenaga Kontrak') 
                            ? $pegawai['pangkat_gol'] . ' (' . $pegawai['golongan'] .')'
                            : 'Non ASN';
                
                
                                            $templateProcessor->setValue("Pangkat_golongan", $pangkatGolongan);
                          }
                          $templateProcessor->setValue("Pangkat_golongan_visum#{$index}", $pangkatGolongan);
  
                          $templateProcessor->setValue("jabatan", $pegawai['jabatan']); 
                          $templateProcessor->setValue("golongan", $pegawai['golongan']); 
  
                          if (count($kab_kota_array) == 1) {
                              $templateProcessor->setValue("tempat_tujuan#1", isset($kab_kota_array[0]) ? $kab_kota_array[0] . ' ' : '');
                              $templateProcessor->setValue("tempat_tujuan#2", isset($kab_kota_array[1]) ? $kab_kota_array[1] . ',' : '');
                              $templateProcessor->setValue("tempat_tujuan#3", isset($kab_kota_array[2]) ? $kab_kota_array[2] . ',' : '');
                
                              $templateProcessor->setValue("tempat_tujuan_1_kota#0", 'Kota Bandung');
                              $templateProcessor->setValue("tempat_tujuan_2_kota#0", '');
                              $templateProcessor->setValue("tempat_tujuan_3_kota#0", '');
                          }elseif(count($kab_kota_array) == 2){
                            $templateProcessor->setValue("tempat_tujuan#1", isset($kab_kota_array[0]) ? $kab_kota_array[0] . ',' : '');
                            $templateProcessor->setValue("tempat_tujuan#2", isset($kab_kota_array[1]) ? $kab_kota_array[1] . ' ' : '');
                            $templateProcessor->setValue("tempat_tujuan#3", isset($kab_kota_array[2]) ? $kab_kota_array[2] . ',' : '');
                
                            $templateProcessor->setValue("tempat_tujuan_1_kota#0", '');
                            $templateProcessor->setValue("tempat_tujuan_2_kota#0", 'Kota Bandung');
                            $templateProcessor->setValue("tempat_tujuan_3_kota#0", '');
                          }else{
                            $templateProcessor->setValue("tempat_tujuan#1", isset($kab_kota_array[0]) ? $kab_kota_array[0] . ',' : '');
                            $templateProcessor->setValue("tempat_tujuan#2", isset($kab_kota_array[1]) ? $kab_kota_array[1] . ',' : '');
                            $templateProcessor->setValue("tempat_tujuan#3", isset($kab_kota_array[2]) ? $kab_kota_array[2] . ' ' : '');
                
                            $templateProcessor->setValue("tempat_tujuan_1_kota#0", '');
                            $templateProcessor->setValue("tempat_tujuan_2_kota#0", '');
                            $templateProcessor->setValue("tempat_tujuan_3_kota#0", 'Kota Bandung');
                          }
                          $templateProcessor->deleteBlock('nomor_induk_pegawai_row');
  
                          
                       
  
                          $filename_bukadis = 'assets/file_surat_perdin/kadis_sekdis/SPPD_' . date('Ymd') . '_' . $id . '_' . $kode_tim_file->kode_tim_ketua . '_kadis.docx';
                          $filename_bukadis_simpan = 'SPPD_' . date('Ymd') . '_' . $id . '_' . $kode_tim_file->kode_tim_ketua . '_kadis.docx';
                          
                          $data = [
                              'file_srt' => $filename_bukadis_simpan,
                          ];
                          $update_perdin = $this->m_perdin->update_e_perdin($pegawai['id_perdin'], $data);
  
                          $templateProcessor->saveAs($filename_bukadis);
                        }
                          $templateFile = 'assets/file_surat_perdin/template_surat_perdin/visum_kadis.docx';
                          // Memproses file template yang dipilih
    
                          $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor($templateFile);
    
                          // Lanjutkan dengan pengisian data ke dalam template...
    
                          $arrblnRomawi = array("I","II","III","IV","V","VI",'VII','VIII','IX','X','XI','XII');
                          $blnRomawi = $arrblnRomawi[date("m")-1];
                          
                          // Pastikan menggunakan setlocale untuk format bahasa Indonesia
                          setlocale(LC_TIME, 'id_ID.utf8');
    
                          // Mendapatkan hari, tanggal, bulan, dan tahun
                          $hari_ttd = strftime('%A', time()); // Nama hari
                          $tgl_ttd = strftime('%d', time()); // Tanggal (angka)
                          $bln_ttd = strftime('%B', time()); // Nama bulan
  
                          // Ganti "Pebruari" menjadi "Februari"
                          $bln_ttd = str_replace("Pebruari", "Februari", $bln_ttd); // Nama bulan
                          $tahun_text = strftime('%Y', time()); // Tahun (angka)
                          // Membuat nomor random
                          $random_number = mt_rand(1000, 9999); // Nomor random 4 digit
    
                          // Mendapatkan tanggal hari ini dalam format DDMMYYYY
                          $tanggal_hari_ini = date('dmY');
    
                          // Menggabungkan semua elemen menjadi nomor dengan format yang diinginkan
                          $nomor_format = $random_number . '/LKK/kemitraan/' . $tanggal_hari_ini;
    
                          foreach ($filtered_data_bu_kadis as $index => $pegawai) {
                            // Hanya proses data dengan ID tertentu
                            if ($pegawai['id_pegawai'] != 1152) {
                                continue; // Lewati iterasi jika ID tidak sesuai
                            }
                            //  var_dump($pegawai);die();
    
                            $tujuan_keberangkatan_perdin = $this->m_perdin->get_tujuan_keberangkatan_perdin($pegawai['no_grup_perdin'], $pegawai['id_tim']);
    
                            $kab_kota_array = [];
                            if (!empty($tujuan_keberangkatan_perdin)) {
                                foreach ($tujuan_keberangkatan_perdin as $rowlist) {
                                    // Decode jika kab_kota dalam format JSON
                                    $decoded = json_decode($rowlist->kab_kota, true);
                                    if (is_array($decoded)) {
                                        $kab_kota_array = array_merge($kab_kota_array, $decoded); // Gabungkan jika array
                                    } else {
                                        $kab_kota_array[] = $rowlist->kab_kota; // Tambahkan langsung jika bukan JSON
                                    }
                                }
                            } else {
                                echo "No data available"; // Tampilkan pesan jika data kosong
                            }
                            $tujuan_keberangkatan_perdin = $this->m_perdin->get_tujuan_keberangkatan_perdin($pegawai['no_grup_perdin'], $pegawai['id_tim']);
                            
                            $tanggalBerangkat_1 = $tujuan_keberangkatan_perdin[0]->tanggal_berangkat_1;
                            $tanggalBerangkat_2 = $tujuan_keberangkatan_perdin[0]->tanggal_berangkat_2;
                            $tanggalBerangkat_3 = $tujuan_keberangkatan_perdin[0]->tanggal_berangkat_3;
                  
                            $tanggal_pulang_1 = $tujuan_keberangkatan_perdin[0]->tanggal_pulang_1;
                            $tanggal_pulang_2 = $tujuan_keberangkatan_perdin[0]->tanggal_pulang_2;
                            $tanggal_pulang_3 = $tujuan_keberangkatan_perdin[0]->tanggal_pulang_3;
            
                            setlocale(LC_TIME, 'id_ID.UTF-8', 'Indonesian', 'id_ID');
    
                            // Format tanggal dengan strftime
                            // Format tanggal dengan strftime
                            $tanggal_pulang_1 = strftime('%d %B %Y', strtotime($tanggal_pulang_1));
                            if ($tanggal_pulang_2 == "0000-00-00") {
                              $tanggal_pulang_2 = '';
                            } else {
                              // Format the date only if it's a valid date
                              $tanggal_pulang_2 = strftime('%d %B %Y', strtotime($tanggal_pulang_2));
                            }
                
                            // Check if $tanggal_pulang_3 is "0000-00-00" and set it to an empty string if true
                            if ($tanggal_pulang_3 == "0000-00-00") {
                              $tanggal_pulang_3 = '';
                            } else {
                              // Format the date only if it's a valid date
                              $tanggal_pulang_3 = strftime('%d %B %Y', strtotime($tanggal_pulang_3));
                            }
    
                            $tglKeberangkatan_1 = strftime('%d %B %Y', strtotime($tanggalBerangkat_1));
                            $tglKeberangkatan_2 = strftime('%d %B %Y', strtotime($tanggalBerangkat_2));
                            $tglKeberangkatan_3 = strftime('%d %B %Y', strtotime($tanggalBerangkat_3));
    
                            // Ganti "Pebruari" menjadi "Februari"
                            $bulan_salah = 'Pebruari';
                            $bulan_benar = 'Februari';
    
                            $tanggal_pulang_1 = str_replace($bulan_salah, $bulan_benar, $tanggal_pulang_1);
                            $tanggal_pulang_2 = str_replace($bulan_salah, $bulan_benar, $tanggal_pulang_2);
                            $tanggal_pulang_3 = str_replace($bulan_salah, $bulan_benar, $tanggal_pulang_3);
    
                            $tglKeberangkatan_1 = str_replace($bulan_salah, $bulan_benar, $tglKeberangkatan_1);
                            $tglKeberangkatan_2 = str_replace($bulan_salah, $bulan_benar, $tglKeberangkatan_2);
                            $tglKeberangkatan_3 = str_replace($bulan_salah, $bulan_benar, $tglKeberangkatan_3);
                            // Format tanggal dengan strftime
                            $tglKeberangkatan = strftime('%d %B %Y', strtotime($pegawai['tanggal_berangkat']));
                            $tglKepulangan = strftime('%d %B %Y', strtotime($pegawai['tanggal_kembali']));
    
                            // Pastikan "Februari" ditulis dengan 'F' bukan 'P'
                            $tglKeberangkatan = str_replace('Pebruari', 'Februari', $tglKeberangkatan);
                            $tglKepulangan = str_replace('Pebruari', 'Februari', $tglKepulangan);
                            // var_dump($tglKeberangkatan);die();
                            if ($tanggalBerangkat_1 == "0000-00-00") {
                              $templateProcessor->setValue("tglKeberangkatan_1", '');
                              $templateProcessor->setValue("tanggal_pulang_1", '');
                              $templateProcessor->setValue("tgl_kepulangan#1", $tanggal_pulang_1);
                
                            }else{
                              $templateProcessor->setValue("tglKeberangkatan_1", $tglKeberangkatan_1);
                              $templateProcessor->setValue("tanggal_pulang_1", $tanggal_pulang_1);
                              
                              if ($tanggalBerangkat_2 === "0000-00-00") {
                                  if ($pegawai['lama_p_d'] == 1) {
                                      $templateProcessor->setValue("tgl_kepulangan_sp1", '');
                                  } else {
                                      $templateProcessor->setValue("tgl_kepulangan_sp1", "sampai dengan " . $tanggal_pulang_2);
                                  }
                                  $templateProcessor->setValue("tgl_kepulangan1", $tanggal_pulang_1);
                
                              } else {
                                  $templateProcessor->setValue("tgl_kepulangan_sp1", '');
                                  $templateProcessor->setValue("tgl_kepulangan1", '');
                
                              }
                            
                
                            }
                            if ($tanggalBerangkat_2 == "0000-00-00") {
                              // var_dump($tanggalBerangkat_2);die();
                
                              $templateProcessor->setValue("tglKeberangkatan_2", '');
                              $templateProcessor->setValue("tanggal_pulang_2", '');
                              
                              $templateProcessor->setValue("tgl_kepulangan2", "");
                              if ($tanggalBerangkat_3 == "0000-00-00") {
                                if ($pegawai['lama_p_d'] == 1) {
                                  $templateProcessor->setValue("tgl_kepulangan_sp2", '');
                                } else {
                                    $templateProcessor->setValue("tgl_kepulangan_sp2", "sampai dengan " . $tanggal_pulang_2);
                                }
                              }else{
                                $templateProcessor->setValue("tgl_kepulangan_sp2", "sampai dengan " . $tanggal_pulang_3);
                              }
                            }else{
                              $templateProcessor->setValue("tglKeberangkatan_2", $tglKeberangkatan_2);
                              $templateProcessor->setValue("tanggal_pulang_2", $tanggal_pulang_2);
                              // var_dump($pegawai['lama_p_d']);die();
                
                              if ($tanggalBerangkat_3 == "0000-00-00") {
                                if ($pegawai['lama_p_d'] == 1) {
                                  $templateProcessor->setValue("tgl_kepulangan_sp2", '');
                                } else {
                                    $templateProcessor->setValue("tgl_kepulangan_sp2", "sampai dengan " . $tanggal_pulang_2);
                                }
                                $templateProcessor->setValue("tgl_kepulangan2", $tanggal_pulang_2);
                
                              }else{
                                $templateProcessor->setValue("tgl_kepulangan2", "");
                                $templateProcessor->setValue("tgl_kepulangan_sp2", "sampai dengan " . $tanggal_pulang_3);
                              }
                
                            }
                            if ($tanggalBerangkat_3 == "0000-00-00") {
                              $templateProcessor->setValue("tglKeberangkatan_3", '');
                              $templateProcessor->setValue("tanggal_pulang_3", '');
                              $templateProcessor->setValue("tgl_kepulangan3", "");
                              $templateProcessor->setValue("tgl_kepulangan_sp3", '');
                            }else{
                              $templateProcessor->setValue("tglKeberangkatan_3", $tglKeberangkatan_3);
                              $templateProcessor->setValue("tanggal_pulang_3", $tanggal_pulang_3);
                              $templateProcessor->setValue("tgl_kepulangan3", $tanggal_pulang_3);
                              $templateProcessor->setValue("tgl_kepulangan_sp3", '');
                            }
                          
                            
                            // Sanitasi untuk srt_instansi_undangan agar aman untuk penggunaan dalam dokumen Word
                            $srtInstansiUndangan = htmlspecialchars($pegawai['srt_instansi_undangan'], ENT_QUOTES, 'UTF-8');
    
                            $kabupatenKota = ucwords(strtolower($pegawai['nama_tujuan'][0]->n_kabupaten));
                        
                            // Menetapkan nilai pada placeholder di template
                            $templateProcessor->setValue("jabatan", $pegawai['jabatan']);
                            $templateProcessor->setValue("ada", $srtInstansiUndangan);
                            $templateProcessor->setValue("mksd", $pegawai['mksd_pemberangkatan']);
                            $templateProcessor->setValue("kode_rekening_sub_keg", $pegawai['kode_rek_sub_req']);
                            $templateProcessor->setValue("srt_perihal_undangan", $pegawai['perihal_srt_undangan']);
                            $templateProcessor->setValue("srt_nmr_undangan", $pegawai['nmr_srt_undangan']);
                            $tgl_srt_undangan = strftime('%d %B %Y', strtotime($pegawai['tgl_srt_undangan']));
                            $templateProcessor->setValue("tgl_srt_undangan#{$index}", $tgl_srt_undangan);
  
                              $location_details = [];
                              
                              if (!empty($detail_tempat_1) && isset($kab_kota_array[0])) {
                                  $location_details[] = $detail_tempat_1 . ' ' . $kab_kota_array[0];
                              }
                              if (!empty($detail_tempat_2) && isset($kab_kota_array[1])) {
                                  $location_details[] = $detail_tempat_2 . ' ' . $kab_kota_array[1];
                              }
                              if (!empty($detail_tempat_3) && isset($kab_kota_array[2])) {
                                  $location_details[] = $detail_tempat_3 . ' ' . $kab_kota_array[2];
                              }
                              
                              $final_location_string = implode(', ', $location_details);
                              
                              $templateProcessor->setValue("brtmpt", $final_location_string);
                            $templateProcessor->setValue("lama_perdin", $pegawai['lama_p_d']);
                            $templateProcessor->setValue("tgl_keberangkatan", $tglKeberangkatan);
                            $templateProcessor->setValue("tgl_kepulangan", $tglKepulangan);
                            $templateProcessor->setValue("kabupaten_kota_bertempatan", $kabupatenKota);
                            $templateProcessor->setValue("kepada_nama", $pegawai['nama_pegawai']);
                            $templateProcessor->setValue("kode_rek", $pegawai['kode_rek']);
                            $templateProcessor->setValue("arahan_pimpinan", $pegawai['dasar_arahan_pimpiman']);
                            $templateProcessor->setValue("kode_tim", $kode_tim);
                            $templateProcessor->setValue("no_urut", $no_grup_perdin);
                            $templateProcessor->setValue("kendaraan", $pegawai['kendaraan']);
                            // Cek apakah nip ada, jika ada maka kolom nip akan muncul
                            if (!empty($pegawai['pangkat_gol']) && strtolower($pegawai['pangkat_gol']) != 'tenaga kontrak') {
                                $templateProcessor->setValue("nama_kolom_nip", 'Nomor Induk Pegawai');
                                $templateProcessor->setValue("nip", $pegawai['nip']);
                                $pangkatGolongan = (isset($pegawai['pangkat_gol']) && isset($pegawai['golongan']) && $pegawai['pangkat_gol'] !== '' && $pegawai['golongan'] !== '' && $pegawai['pangkat_gol'] !== 'Tenaga Kontrak') 
                                ? $pegawai['pangkat_gol'] . ' (' . $pegawai['golongan'] .')'
                                : 'Non ASN';
                    
                    
                                                $templateProcessor->setValue("Pangkat_golongan", $pangkatGolongan);
    
    
                            } else {
                              $templateProcessor->setValue("nama_kolom_nip#{$index}", 'Nomor Induk Pegawai');
                              $templateProcessor->setValue("nip#{$index}", '-');
                              $pangkatGolongan = (isset($pegawai['pangkat_gol']) && isset($pegawai['golongan']) && $pegawai['pangkat_gol'] !== '' && $pegawai['golongan'] !== '' && $pegawai['pangkat_gol'] !== 'Tenaga Kontrak') 
                              ? $pegawai['pangkat_gol'] . ' (' . $pegawai['golongan'] .')'
                              : 'Non ASN';
                  
                  
                                              $templateProcessor->setValue("Pangkat_golongan", $pangkatGolongan);
                            }
                            $templateProcessor->setValue("Pangkat_golongan_visum#{$index}", $pangkatGolongan);
    
                            $templateProcessor->setValue("jabatan", $pegawai['jabatan']); 
                            $templateProcessor->setValue("golongan", $pegawai['golongan']); 
    
                            if (count($kab_kota_array) == 1) {
                                $templateProcessor->setValue("tempat_tujuan#1", isset($kab_kota_array[0]) ? $kab_kota_array[0] . ' ' : '');
                                $templateProcessor->setValue("tempat_tujuan#2", isset($kab_kota_array[1]) ? $kab_kota_array[1] . ',' : '');
                                $templateProcessor->setValue("tempat_tujuan#3", isset($kab_kota_array[2]) ? $kab_kota_array[2] . ',' : '');
                  
                                $templateProcessor->setValue("tempat_tujuan_1_kota#0", 'Kota Bandung');
                                $templateProcessor->setValue("tempat_tujuan_2_kota#0", '');
                                $templateProcessor->setValue("tempat_tujuan_3_kota#0", '');
                            }elseif(count($kab_kota_array) == 2){
                              $templateProcessor->setValue("tempat_tujuan#1", isset($kab_kota_array[0]) ? $kab_kota_array[0] . ',' : '');
                              $templateProcessor->setValue("tempat_tujuan#2", isset($kab_kota_array[1]) ? $kab_kota_array[1] . ' ' : '');
                              $templateProcessor->setValue("tempat_tujuan#3", isset($kab_kota_array[2]) ? $kab_kota_array[2] . ',' : '');
                  
                              $templateProcessor->setValue("tempat_tujuan_1_kota#0", '');
                              $templateProcessor->setValue("tempat_tujuan_2_kota#0", 'Kota Bandung');
                              $templateProcessor->setValue("tempat_tujuan_3_kota#0", '');
                            }else{
                              $templateProcessor->setValue("tempat_tujuan#1", isset($kab_kota_array[0]) ? $kab_kota_array[0] . ',' : '');
                              $templateProcessor->setValue("tempat_tujuan#2", isset($kab_kota_array[1]) ? $kab_kota_array[1] . ',' : '');
                              $templateProcessor->setValue("tempat_tujuan#3", isset($kab_kota_array[2]) ? $kab_kota_array[2] . ' ' : '');
                  
                              $templateProcessor->setValue("tempat_tujuan_1_kota#0", '');
                              $templateProcessor->setValue("tempat_tujuan_2_kota#0", '');
                              $templateProcessor->setValue("tempat_tujuan_3_kota#0", 'Kota Bandung');
                            }
                            $templateProcessor->deleteBlock('nomor_induk_pegawai_row');
    
                            
                         
    
                            $filename_bukadis = 'assets/file_surat_perdin/visum_kadis/SPPD_' . date('Ymd') . '_' . $id . '_' . $kode_tim_file->kode_tim_ketua . '_visum_kadis.docx';
                            $filename_bukadis_simpan = 'SPPD_' . date('Ymd') . '_' . $id . '_' . $kode_tim_file->kode_tim_ketua . '_visum_kadis.docx';
                            $templateProcessor->saveAs($filename_bukadis);
                           
                            // var_dump($filename_bukadis_simpan);die();
                            $data = [
                                'file_srt_visum_kadis' => $filename_bukadis_simpan,
                            ];
                            $update_perdin = $this->m_perdin->update_e_perdin($pegawai['id_perdin'], $data);
                          }
  
                  }
                }
            } else {
            }
          } else {
              // Jika $pkepada bukan array, gunakan template default
              $templateFile = 'assets/file_surat_perdin/template_surat_perdin/surat_perintah_template_1_orang_tipe1.docx';
          }

        if (isset($_FILES["file_srt"]) && $_FILES["file_srt"]["name"] != "") {
            

          if (strpos($file_srt, 'upload') !== false) {
              $file_path = 'assets/file_surat_perdin/upload/' .  $file_srt;
          }
        
          // Hapus file jika ada
          if (file_exists($file_path) && !empty( $file_srt)) {
              if (!unlink($file_path)) {
                  log_message('error', 'Gagal menghapus file: ' . $file_path);
                  $this->session->set_flashdata('gagal', "Gagal menghapus berkas.");
                  redirect('perdin/ubah_sp_perdin/'.$id);
                  return;
              }
          } else {
              log_message('error', 'File tidak ditemukan atau sudah terhapus: ' . $file_path);
          }
            $filtered_data = array_filter($data_pegawai, function($item) {
              return $item['id_pegawai'] != 1152 && $item['id_pegawai'] != 31;
            });
            $file = $_FILES["file_srt"]["name"];
            $ext = pathinfo($file, PATHINFO_EXTENSION);
    
            // Menentukan direktori tujuan
            $target_dir = "assets/file_surat_perdin/upload/";
    
            // Membuat nama file baru yang unik, bisa dengan menambahkan user_id dan timestamp
            // $file_srt = 'SPPD_' . $user_id . '_' . time() . '.' . $ext;
            $file_srt = 'SPPD_' . date('Ymd') . '_' . $id . '_' . $kode_tim_file->kode_tim_ketua . '_pegawai_upload.'.$ext;
    
            // Menentukan path file baru
            $target_file = $target_dir . $file_srt;
    
            // Memindahkan file yang di-upload ke direktori tujuan dengan nama file baru
            $upload = move_uploaded_file($_FILES["file_srt"]["tmp_name"], $target_file);
            foreach ($filtered_data as $index => $pegawai) {

              if ($pegawai['no__sppd'] == null) {
                $data = [
                  'file_srt' => $file_srt,
              ];
              $file_path = 'assets/file_surat_perdin/upload/' .  $file_srt;
        
              $update_perdin = $this->m_perdin->update_e_perdin($pegawai['id_perdin'], $data);
                
              }else{

                $kode_tim_file = $this->m_perdin->get_tim_details($pegawai['id_tim']);
                // Tentukan path template berdasarkan ID pegawai
                if ($pegawai->id_pegawai == "1152") {
                    continue; // Skip jika ID pegawai 1152
                } elseif ($pegawai->id_pegawai == "31") {
                    $templateFile = "assets/file_surat_perdin/kadis_sekdis/{$pegawai->file_srt}";
                } else {
                    // Cek apakah file berasal dari folder upload atau default
                    $templateFile = (strpos($file_srt, 'upload') !== false)
                        ? "assets/file_surat_perdin/upload/{$file_srt}"
                        : "assets/file_surat_perdin/{$file_srt}";
                }
        
                // Cek apakah file template ada
                if (!file_exists($templateFile)) {
                    die("Template file not found: {$templateFile}");
                }
        
                // Muat template menggunakan TemplateProcessor
                $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor($templateFile);
        
                // Mendapatkan tanggal dan informasi lainnya
                $arrblnRomawi = ["I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X", "XI", "XII"];
                $blnRomawi = $arrblnRomawi[date("m") - 1];
                setlocale(LC_TIME, 'id_ID.utf8');
        
                $hari_ttd = strftime('%A', time()); // Nama hari
                $tgl_ttd = strftime('%d', time()); // Tanggal (angka)
                $bln_ttd = strftime('%B', time()); // Nama bulan

                // Ganti "Pebruari" menjadi "Februari"
                $bln_ttd = str_replace("Pebruari", "Februari", $bln_ttd); // Nama bulan
                $tahun_text = strftime('%Y', time()); // Tahun (angka)
        
                $random_number = mt_rand(1000, 9999);
                $tanggal_hari_ini = date('dmY');
                $nomor_format = $no__sppd;
        
                // Ganti nilai placeholder di template
                $templateProcessor->setValue('no_surat', $nomor_format);
                $templateProcessor->setValue('no_urut', $pegawai['id_perdin']);
                $templateProcessor->setValue('kode_tim', $kode_tim_file->kode_tim_ketua);
                $templateProcessor->setValue('tgl_surat', "{$tgl_ttd} {$bln_ttd} {$tahun_text}");
        
                // Tentukan filename untuk simpanan
                if ($pegawai->id_pegawai == "31") {
                    $filename = 'assets/file_surat_perdin/kadis_sekdis/SPPD_' . date('Ymd') . '_' . $pegawai['no_grup_perdin'] . '_' . $kode_tim_file->kode_tim_ketua . '_sekdis.docx';
                    $filename_simpan = 'SPPD_' . date('Ymd') . '_' . $pegawai['no_grup_perdin'] . '_' . $kode_tim_file->kode_tim_ketua . '_sekdis.docx';
                } else {
                    $filename = 'assets/file_surat_perdin/upload/SPPD_' . date('Ymd') . '_' . $pegawai['no_grup_perdin']. '_' . $kode_tim_file->kode_tim_ketua . '_penomoran_pegawai.docx';
                    $filename_simpan = 'SPPD_' . date('Ymd') . '_' . $pegawai['no_grup_perdin']. '_' . $kode_tim_file->kode_tim_ketua . '_penomoran_pegawai.docx';
                }
        
                // Simpan template yang sudah diganti
                $templateProcessor->saveAs($filename);
        
                // Update database dengan informasi file yang telah disimpan
                $data = ['file_srt' => $filename_simpan];
                // var_dump($data);die();

                $update_perdin = $this->m_perdin->update_e_perdin($pegawai['id_perdin'], $data);
                // Cek hasil update
                if (!$update_perdin) {
                    $this->session->set_flashdata('gagal', "Gagal menyimpan file DOCX.");
                    redirect('/perdin/suratperintah/');
                    exit;
                }
             
              }
              
            }
              if (!$update_perdin) {
                  $this->session->set_flashdata('gagal', "Gagal menyimpan file DOCX.");
                  redirect('/perdin/suratperintah/');
                  exit;
              }
              $namafile = 'SPPD_'.$datename;
      
              if ($this->db->trans_status() === FALSE) {
                  // $this->session->set_flashdata('gagal', "Gagal menyimpan data perjalanan dinas.");
              } else {
                  $this->session->set_flashdata('sukses', "Berhasil menyimpan data perjalanan dinas.");
              }
            
            redirect('/perdin/suratperintah');
        }elseif(strpos($file_srt, 'upload') !== false){
          $filtered_data = array_filter($data_pegawai, function($item) {
            return $item['id_pegawai'] != 1152 && $item['id_pegawai'] != 31;
          });

          foreach ($filtered_data as $index => $pegawai) {
             
            $data = [
                'file_srt' => $file_srt,
            ];
            // var_dump($data);die();
            $update_perdin = $this->m_perdin->update_e_perdin($pegawai['id_perdin'], $data);
          }
          if (!$update_perdin) {
              $this->session->set_flashdata('gagal', "Gagal menyimpan file DOCX.");
              redirect('/perdin/suratperintah/');
              exit;
          }
            $namafile = 'SPPD_'.$datename;

            if ($this->db->trans_status() === FALSE) {
                // $this->session->set_flashdata('gagal', "Gagal menyimpan data perjalanan dinas.");
            } else {
                $this->session->set_flashdata('sukses', "Berhasil menyimpan data perjalanan dinas.");
            }
          
          redirect('/perdin/suratperintah');
        }else{
          $filtered_data = array_filter($data_pegawai, function($item) {
              return $item['id_pegawai'] != 1152 && $item['id_pegawai'] != 31;
          });
          $filtered_data = array_values($filtered_data);
          
          // Menghitung jumlah data
          $count = count($filtered_data);
            // Kondisi default jika "31" dan "931" tidak ditemukan
            if ($count == 1) {
    
                if ($tipe_undangan == 1) {
    
                    $templateFile = 'assets/file_surat_perdin/template_surat_perdin/surat_perintah_template_1_orang_tipe1.docx';
                } elseif($tipe_undangan == 3) {
                  $templateFile = 'assets/file_surat_perdin/template_surat_perdin/template_arahan_pimpinan/surat_perintah_template_1_orang_arahan_pimpinan.docx';
    
                }else{
                  $templateFile = 'assets/file_surat_perdin/template_surat_perdin/surat_perintah_template_1_orang.docx';
    
                }
            } elseif ($count == 2) {
                if ($tipe_undangan == 1) {
    
                    $templateFile = 'assets/file_surat_perdin/template_surat_perdin/surat_perintah_template_2_orang_tipe1.docx';
                } elseif($tipe_undangan == 3) {
                  $templateFile = 'assets/file_surat_perdin/template_surat_perdin/template_arahan_pimpinan/surat_perintah_template_2_orang_arahan_pimpinan.docx';
    
                } else {
                  $templateFile = 'assets/file_surat_perdin/template_surat_perdin/surat_perintah_template_2_orang.docx';
    
                }
            } elseif ($count == 3) {
                if ($tipe_undangan == 1) {
                    $templateFile = 'assets/file_surat_perdin/template_surat_perdin/surat_perintah_template_3_orang_tipe1.docx';
                } elseif($tipe_undangan == 3) {
                  $templateFile = 'assets/file_surat_perdin/template_surat_perdin/template_arahan_pimpinan/surat_perintah_template_3_orang_arahan_pimpinan.docx';
    
                } else {
                    $templateFile = 'assets/file_surat_perdin/template_surat_perdin/surat_perintah_template_3_orang.docx';
                }
            } elseif ($count == 4) {
    
                if ($tipe_undangan == 1) {
                    $templateFile = 'assets/file_surat_perdin/template_surat_perdin/surat_perintah_template_4_orang_tipe1.docx';
                } elseif($tipe_undangan == 3) {
                  $templateFile = 'assets/file_surat_perdin/template_surat_perdin/template_arahan_pimpinan/surat_perintah_template_4_orang_arahan_pimpinan.docx';
                } else {
                    $templateFile = 'assets/file_surat_perdin/template_surat_perdin/surat_perintah_template_4_orang.docx';
                }
            } else {
                $templateFile = 'assets/file_surat_perdin/template_surat_perdin/surat_perintah_template_1_orang_tipe1.docx';
            }
    
    
            // Memproses file template yang dipilih
            $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor($templateFile);
    
            // Lanjutkan dengan pengisian data ke dalam template...
    
            $arrblnRomawi = array("I","II","III","IV","V","VI",'VII','VIII','IX','X','XI','XII');
            $blnRomawi = $arrblnRomawi[date("m")-1];
            
            // Pastikan menggunakan setlocale untuk format bahasa Indonesia
            setlocale(LC_TIME, 'id_ID.utf8');
    
            // Mendapatkan hari, tanggal, bulan, dan tahun
            $hari_ttd = strftime('%A', time()); // Nama hari
            $tgl_ttd = strftime('%d', time()); // Tanggal (angka)
            $bln_ttd = strftime('%B', time()); // Nama bulan

              // Ganti "Pebruari" menjadi "Februari"
              $bln_ttd = str_replace("Pebruari", "Februari", $bln_ttd); // Nama bulan
            $tahun_text = strftime('%Y', time()); // Tahun (angka)
            // Membuat nomor random
            $random_number = mt_rand(1000, 9999); // Nomor random 4 digit
    
            // Mendapatkan tanggal hari ini dalam format DDMMYYYY
            $tanggal_hari_ini = date('dmY');
            // var_dump($kode_tim_file->kode_tim_ketua);die();
            // $kode_tim = "/\${no_surat}/$kode_tim_file";
            $kode_tim = $kode_tim_file->kode_tim_ketua;
    
            // $nomor_format_1= $no_grup_perdin.'/$a{no_surat}/'.$kode_tim_file .'/'. $kode_tim_file;45/{no_surat}/PK/PK
            
            foreach ($filtered_data as $index => $pegawai) {
              $nomor_format_1= '45/${no_surat}/PK/PK';
  
              $tujuan_keberangkatan_perdin = $this->m_perdin->get_tujuan_keberangkatan_perdin($pegawai['no_grup_perdin'], $pegawai['id_tim']);
  
              $kab_kota_array = [];
              if (!empty($tujuan_keberangkatan_perdin)) {
                  foreach ($tujuan_keberangkatan_perdin as $rowlist) {
                      // Decode jika kab_kota dalam format JSON
                      $decoded = json_decode($rowlist->kab_kota, true);
                      if (is_array($decoded)) {
                          $kab_kota_array = array_merge($kab_kota_array, $decoded); // Gabungkan jika array
                      } else {
                          $kab_kota_array[] = $rowlist->kab_kota; // Tambahkan langsung jika bukan JSON
                      }
                  }
              } else {
                  echo "No data available"; // Tampilkan pesan jika data kosong
              }
  
              $detail_tempat_1 = $tujuan_keberangkatan_perdin[0]->detail_tempat_1;
              $detail_tempat_2 = $tujuan_keberangkatan_perdin[0]->detail_tempat_2;
              $detail_tempat_3 = $tujuan_keberangkatan_perdin[0]->detail_tempat_3;
  
              $tanggalBerangkat_1 = $tujuan_keberangkatan_perdin[0]->tanggal_berangkat_1;
              $tanggalBerangkat_2 = $tujuan_keberangkatan_perdin[0]->tanggal_berangkat_2;
              $tanggalBerangkat_3 = $tujuan_keberangkatan_perdin[0]->tanggal_berangkat_3;
  
              $tanggal_pulang_1 = $tujuan_keberangkatan_perdin[0]->tanggal_pulang_1;
              $tanggal_pulang_2 = $tujuan_keberangkatan_perdin[0]->tanggal_pulang_2;
              $tanggal_pulang_3 = $tujuan_keberangkatan_perdin[0]->tanggal_pulang_3;
  
              // Pastikan sistem menggunakan Bahasa Indonesia
              setlocale(LC_TIME, 'id_ID.UTF-8', 'Indonesian', 'id_ID');
  
              // Format tanggal dengan strftime
             // Format tanggal dengan strftime

              $tanggal_pulang_1 = strftime('%d %B %Y', strtotime($tanggal_pulang_1));
              if ($tanggal_pulang_2 == "0000-00-00") {
                $tanggal_pulang_2 = '';
              } else {
                // Format the date only if it's a valid date
                $tanggal_pulang_2 = strftime('%d %B %Y', strtotime($tanggal_pulang_2));
              }
  
              // Check if $tanggal_pulang_3 is "0000-00-00" and set it to an empty string if true
              if ($tanggal_pulang_3 == "0000-00-00") {
                $tanggal_pulang_3 = '';
              } else {
                // Format the date only if it's a valid date
                $tanggal_pulang_3 = strftime('%d %B %Y', strtotime($tanggal_pulang_3));
              }
  
              $tglKeberangkatan_1 = strftime('%d %B %Y', strtotime($tanggalBerangkat_1));
              $tglKeberangkatan_2 = strftime('%d %B %Y', strtotime($tanggalBerangkat_2));
              $tglKeberangkatan_3 = strftime('%d %B %Y', strtotime($tanggalBerangkat_3));
  
              // Ganti "Pebruari" menjadi "Februari"
              $bulan_salah = 'Pebruari';
              $bulan_benar = 'Februari';
  
              $tanggal_pulang_1 = str_replace($bulan_salah, $bulan_benar, $tanggal_pulang_1);
              $tanggal_pulang_2 = str_replace($bulan_salah, $bulan_benar, $tanggal_pulang_2);
              $tanggal_pulang_3 = str_replace($bulan_salah, $bulan_benar, $tanggal_pulang_3);
  
              $tglKeberangkatan_1 = str_replace($bulan_salah, $bulan_benar, $tglKeberangkatan_1);
              $tglKeberangkatan_2 = str_replace($bulan_salah, $bulan_benar, $tglKeberangkatan_2);
              $tglKeberangkatan_3 = str_replace($bulan_salah, $bulan_benar, $tglKeberangkatan_3);
              // Format tanggal dengan strftime
              $tglKeberangkatan = strftime('%d %B %Y', strtotime($pegawai['tanggal_berangkat']));
              $tglKepulangan = strftime('%d %B %Y', strtotime($pegawai['tanggal_kembali']));
  
              // Pastikan "Februari" ditulis dengan 'F' bukan 'P'
              $tglKeberangkatan = str_replace('Pebruari', 'Februari', $tglKeberangkatan);
              $tglKepulangan = str_replace('Pebruari', 'Februari', $tglKepulangan);
  
              
              // Sanitasi untuk srt_instansi_undangan agar aman untuk penggunaan dalam dokumen Word
              $srtInstansiUndangan = htmlspecialchars($pegawai['srt_instansi_undangan'], ENT_QUOTES, 'UTF-8');
  
              $kabupatenKota = ucwords(strtolower($pegawai['nama_tujuan'][0]->n_kabupaten));
              setlocale(LC_TIME, 'id_ID.UTF-8', 'Indonesian', 'id_ID');
  
              
  
              // var_dump($kab_kota_array[0]);die();
              
              // Menetapkan nilai pada placeholder di template
              $templateProcessor->setValue("jabatan#{$index}", $pegawai['jabatan']);
              $templateProcessor->setValue("ada#{$index}", $srtInstansiUndangan);
              $templateProcessor->setValue("mksd#{$index}", $pegawai['mksd_pemberangkatan']);
              $templateProcessor->setValue("kode_rekening_sub_keg#{$index}", $pegawai['kode_rek_sub_req']);
              $templateProcessor->setValue("srt_perihal_undangan#{$index}", $pegawai['perihal_srt_undangan']);
              
              $templateProcessor->setValue("srt_nmr_undangan#{$index}", $pegawai['nmr_srt_undangan']);
              $templateProcessor->setValue("srt_nmr_undangan#{$index}", $pegawai['nmr_srt_undangan']);
              if (isset($pegawai['no__sppd']) && !empty($pegawai['no__sppd'])) {
                $templateProcessor->setValue("no_surat", $pegawai['no__sppd']);
                $templateProcessor->setValue("tgl_surat", $pegawai['tgl_surat']);

              }
  
              $tgl_srt_undangan = strftime('%d %B %Y', strtotime($pegawai['tgl_srt_undangan']));
              if ($pegawai['tanggal_sp_backdate'] == '0000-00-00' || $pegawai['tanggal_sp_backdate'] === false) {

              }else{
                $tanggal_sp_backdate = strftime('%d %B %Y', strtotime($pegawai['tanggal_sp_backdate']));
                $templateProcessor->setValue("tgl_surat", $tanggal_sp_backdate);
              }
              // Pastikan "Februari" ditulis dengan 'F' bukan 'P'
              $tgl_srt_undangan = str_replace('Pebruari', 'Februari', $tgl_srt_undangan);
              $templateProcessor->setValue("tgl_srt_undangan#{$index}", $tgl_srt_undangan);
  
              $location_details = [];
              
              if (!empty($detail_tempat_1) && isset($kab_kota_array[0])) {
                  $location_details[] = $detail_tempat_1 . ' ' . $kab_kota_array[0];
              }
              if (!empty($detail_tempat_2) && isset($kab_kota_array[1])) {
                  $location_details[] = $detail_tempat_2 . ' ' . $kab_kota_array[1];
              }
              if (!empty($detail_tempat_3) && isset($kab_kota_array[2])) {
                  $location_details[] = $detail_tempat_3 . ' ' . $kab_kota_array[2];
              }
              
              $final_location_string = implode(', ', $location_details);
              
              $templateProcessor->setValue("brtmpt#{$index}", $final_location_string);
              
              
            
              $templateProcessor->setValue("tgl_keberangkatan#{$index}", $tglKeberangkatan);
              
              $templateProcessor->setValue("lama_perdin#{$index}", $pegawai['lama_p_d']);
              $templateProcessor->setValue("arahan_pimpinan#{$index}", $pegawai['dasar_arahan_pimpiman']);
              $templateProcessor->setValue("kendaraan", $pegawai['kendaraan']);
              $templateProcessor->setValue("kabupaten_kota_bertempatan#{$index}", $kabupatenKota);

              if ($tanggalBerangkat_1 == "0000-00-00") {
                $templateProcessor->setValue("tglKeberangkatan_1", '');
                $templateProcessor->setValue("tanggal_pulang_1", '');
                $templateProcessor->setValue("tgl_kepulangan#1", $tanggal_pulang_1);
  
              }else{
                $templateProcessor->setValue("tglKeberangkatan_1", $tglKeberangkatan_1);
                $templateProcessor->setValue("tanggal_pulang_1", $tanggal_pulang_1);
                
                if ($tanggalBerangkat_2 === "0000-00-00") {
                    if ($pegawai['lama_p_d'] == 1) {
                        $templateProcessor->setValue("tgl_kepulangan_sp1", '');
                    } else {
                        $templateProcessor->setValue("tgl_kepulangan_sp1", "sampai dengan " . $tanggal_pulang_1);
                    }
                    $templateProcessor->setValue("tgl_kepulangan1", $tanggal_pulang_1);
  
                } else {
                    $templateProcessor->setValue("tgl_kepulangan_sp1", '');
                    $templateProcessor->setValue("tgl_kepulangan1", '');
  
                }
              
  
              }
              if ($tanggalBerangkat_2 == "0000-00-00") {
  
                $templateProcessor->setValue("tglKeberangkatan_2", '');
                $templateProcessor->setValue("tanggal_pulang_2", '');
                
                $templateProcessor->setValue("tgl_kepulangan2", "");
                // var_dump($tanggal_pulang_2);die();

                if ($tanggalBerangkat_3 == "0000-00-00") {

                  if ($pegawai['lama_p_d'] == 1) {
                    $templateProcessor->setValue("tgl_kepulangan_sp2", '');

                  } elseif ($tanggal_pulang_1 == "") {
                    $templateProcessor->setValue("tgl_kepulangan_sp2", "sampai dengan " . $tanggal_pulang_2);
                    
                  } else {
                    $templateProcessor->setValue("tgl_kepulangan_sp2", '');
                  }
                }else{
                  $templateProcessor->setValue("tgl_kepulangan_sp2", "sampai dengan " . $tanggal_pulang_3);
                }
              }else{
                $templateProcessor->setValue("tglKeberangkatan_2", $tglKeberangkatan_2);
                $templateProcessor->setValue("tanggal_pulang_2", $tanggal_pulang_2);
                // var_dump($pegawai['lama_p_d']);die();
  
                if ($tanggalBerangkat_3 == "0000-00-00") {
                  if ($pegawai['lama_p_d'] == 1) {
                    $templateProcessor->setValue("tgl_kepulangan_sp2", '');
                  } else {
                      $templateProcessor->setValue("tgl_kepulangan_sp2", "sampai dengan " . $tanggal_pulang_2);
                  }
                  $templateProcessor->setValue("tgl_kepulangan2", $tanggal_pulang_2);
  
                }else{
                  $templateProcessor->setValue("tgl_kepulangan2", "");
                  $templateProcessor->setValue("tgl_kepulangan_sp2", "sampai dengan " . $tanggal_pulang_3);
                }
  
              }
              if ($tanggalBerangkat_3 == "0000-00-00") {
                $templateProcessor->setValue("tglKeberangkatan_3", '');
                $templateProcessor->setValue("tanggal_pulang_3", '');
                $templateProcessor->setValue("tgl_kepulangan3", "");
                $templateProcessor->setValue("tgl_kepulangan_sp3", '');
              }else{
                $templateProcessor->setValue("tglKeberangkatan_3", $tglKeberangkatan_3);
                $templateProcessor->setValue("tanggal_pulang_3", $tanggal_pulang_3);
                $templateProcessor->setValue("tgl_kepulangan3", $tanggal_pulang_3);
                $templateProcessor->setValue("tgl_kepulangan_sp3", '');
              }
            
  
  
              if (count($kab_kota_array) == 1) {
                  $templateProcessor->setValue("tempat_tujuan#1", isset($kab_kota_array[0]) ? $kab_kota_array[0] . ' ' : '');
                  $templateProcessor->setValue("tempat_tujuan#2", isset($kab_kota_array[1]) ? $kab_kota_array[1] . ',' : '');
                  $templateProcessor->setValue("tempat_tujuan#3", isset($kab_kota_array[2]) ? $kab_kota_array[2] . ',' : '');
  
                  $templateProcessor->setValue("tempat_tujuan_1_kota#0", 'Kota Bandung');
                  $templateProcessor->setValue("tempat_tujuan_2_kota#0", '');
                  $templateProcessor->setValue("tempat_tujuan_3_kota#0", '');


              }elseif(count($kab_kota_array) == 2){
                $templateProcessor->setValue("tempat_tujuan#1", isset($kab_kota_array[0]) ? $kab_kota_array[0] . ',' : '');
                $templateProcessor->setValue("tempat_tujuan#2", isset($kab_kota_array[1]) ? $kab_kota_array[1] . ' ' : '');
                $templateProcessor->setValue("tempat_tujuan#3", isset($kab_kota_array[2]) ? $kab_kota_array[2] . ',' : '');
  
                $templateProcessor->setValue("tempat_tujuan_1_kota#0", '');
                $templateProcessor->setValue("tempat_tujuan_2_kota#0", 'Kota Bandung');
                $templateProcessor->setValue("tempat_tujuan_3_kota#0", '');
              }else{
                $templateProcessor->setValue("tempat_tujuan#1", isset($kab_kota_array[0]) ? $kab_kota_array[0] . ',' : '');
                $templateProcessor->setValue("tempat_tujuan#2", isset($kab_kota_array[1]) ? $kab_kota_array[1] . ',' : '');
                $templateProcessor->setValue("tempat_tujuan#3", isset($kab_kota_array[2]) ? $kab_kota_array[2] . ' ' : '');
  
                $templateProcessor->setValue("tempat_tujuan_1_kota#0", '');
                $templateProcessor->setValue("tempat_tujuan_2_kota#0", '');
                $templateProcessor->setValue("tempat_tujuan_3_kota#0", 'Kota Bandung');
              }
            
  
              // $templateProcessor->setValue("tempat_tujuan#1", isset($kab_kota_array[0]) ? $kab_kota_array[0] . ',' : '');
              // $templateProcessor->setValue("tempat_tujuan#2", isset($kab_kota_array[1]) ? $kab_kota_array[1] . ',' : '');
              // $templateProcessor->setValue("tempat_tujuan#3", isset($kab_kota_array[2]) ? $kab_kota_array[2] . ',' : '');
              $templateProcessor->setValue("tempat_kedudukan", '');
              
              $templateProcessor->setValue("kabupaten_kota_bertempatan#{$index}", $kabupatenKota);
              $templateProcessor->setValue("kabupaten_kota_bertempatan#{$index}", $kabupatenKota);
              // var_dump($nomor_format);
  
              // Duplicate, bisa dihapus jika tidak diperlukan lagi
              $templateProcessor->setValue("kepada_nama#{$index}", $pegawai['nama_pegawai']);
              $templateProcessor->setValue("kode_tim", $kode_tim);
              $templateProcessor->setValue("no_urut", $no_grup_perdin);
              $templateProcessor->setValue("kode_rek", $pegawai['kode_rek']);
  
              // Cek apakah nip ada, jika ada maka kolom nip akan muncul
              if (!empty($pegawai['pangkat_gol']) && strtolower($pegawai['pangkat_gol']) != 'tenaga kontrak') {
                  $templateProcessor->setValue("nama_kolom_nip#{$index}", 'Nomor Induk Pegawai');
                  $templateProcessor->setValue("nip#{$index}", $pegawai['nip']);
                  $pangkatGolongan = (isset($pegawai['pangkat_gol']) && isset($pegawai['golongan']) && $pegawai['pangkat_gol'] !== '' && $pegawai['golongan'] !== '' && $pegawai['pangkat_gol'] !== 'Tenaga Kontrak') 
                  ? $pegawai['pangkat_gol'] . ' (' . $pegawai['golongan'] .')'
                  : 'Non ASN';
      
      
                                  $templateProcessor->setValue("Pangkat_golongan#{$index}", $pangkatGolongan);
              } else {
                $templateProcessor->setValue("nama_kolom_nip#{$index}", 'Nomor Induk Pegawai');
                $templateProcessor->setValue("nip#{$index}", '-');
                $pangkatGolongan = (isset($pegawai['pangkat_gol']) && isset($pegawai['golongan']) && $pegawai['pangkat_gol'] !== '' && $pegawai['golongan'] !== '' && $pegawai['pangkat_gol'] !== 'Tenaga Kontrak') 
                ? $pegawai['pangkat_gol'] . ' (' . $pegawai['golongan'] .')'
                : 'Non ASN';
  
  
                                $templateProcessor->setValue("Pangkat_golongan#{$index}", $pangkatGolongan);
              }
              $templateProcessor->setValue("Pangkat_golongan_visum#{$index}", $pangkatGolongan);
  
  
              $pangkat_gol[] = [
                'pangkat_gol' => "Pangkat_golongan_visum#{$index}",
              ];
              $templateProcessor->setValue("jabatan#{$index}", $pegawai['jabatan']); 
              $templateProcessor->setValue("golongan#{$index}", $pegawai['golongan']); 
              
              
              
              $templateProcessor->deleteBlock('nomor_induk_pegawai_row');
              $filename = 'assets/file_surat_perdin/SPPD_' . date('Ymd') . '_' . $id . '_' . $kode_tim_file->kode_tim_ketua . '_pegawai.docx';
  
              $filename_pegawai = 'SPPD_' . date('Ymd') . '_' . $id . '_' . $kode_tim_file->kode_tim_ketua . '_pegawai.docx';
  
              $data = [
                  'file_srt' => $filename_pegawai,
              ];
              
              $update_perdin = $this->m_perdin->update_e_perdin($pegawai['id_perdin'], $data);
            }
    
          // die;
    
              $templateProcessor->saveAs($filename);
                  
            
            if (!$update_perdin) {
                $this->session->set_flashdata('gagal', "Gagal menyimpan file DOCX.");
                redirect('/perdin/suratperintah/');
                exit;
            }
            $namafile = 'SPPD_'.$datename;
    
            if ($this->db->trans_status() === FALSE) {
                // $this->session->set_flashdata('gagal', "Gagal menyimpan data perjalanan dinas.");
            } else {
                $this->session->set_flashdata('sukses', "Berhasil menyimpan data perjalanan dinas.");
            }
            
            redirect('/perdin/suratperintah');
    
        }
    }

  // public function simpan() {
  //    // $id_user = $this->session->userdata('id_auth');
  //     $title     = $this->input->post('title');
  //     $description= $this->input->post('description');
  //     $namabidang    = $this->input->post('namabidang');
  //     $start_date= $this->input->post('start_date');
  //      $startdate= $this->input->post('startdate');
  //     $end_date  = $this->input->post('end_date');
  //     $id        = $this->input->post('id');
  //       $iduser = $this->session->userdata('username');

  //     $simpan = $this->m_timeline->save_data($id, $iduser, $title, $description, $bidang,$namabidang, $start_date, $end_date, $startdate);
  //     if ($simpan != 0) {
  //       $id = $simpan;
  //       $this->session->set_flashdata('sukses', "Berhasil Menyimpan Data");
  //       redirect('/timeline');            
  //     } else {
  //       $this->session->set_flashdata('gagal', "Gagal Meyimpan Data Surat.");
  //       redirect('/timeline');
  //     }
  // }
  public function hapus_evidence($id) {
    $files_image = "";
    foreach(glob('assets/assets/calen/ereport/evidence_'.$id.'.*', GLOB_NOSORT) as $image){  
                  //echo "Filename: " . $image . "<br />";      
                  $files_image = $image ; 
              }  
             // var_dump($files_image);die();
    $hapus = unlink($files_image);

   // $hapus = unlink('assets/assets/calen/ereport/evidence_'.$id.'.pdf');
    //$hapus2 = unlink('assets/docx-surat-processed/SRT_'.$id.'.docx');

    if ($hapus) {
      $this->session->set_flashdata('sukses', "Berhasil Menghapus Berkas.");
      redirect('perdin/ubah/'.$id);
    } else {
      $this->session->set_flashdata('gagal', "Gagal Menghapus Berkas.");
      redirect('perdin/ubah/'.$id);
    }
  }

  public function hapus($id) {
    if ($this->m_perdin->delete_perdin($id)) {
        
      $this->session->set_flashdata('sukses', "Berhasil Hapus Data.");
        redirect('perdin');
    } else {
      $this->session->set_flashdata('gagal', "Gagal Hapus Data.");
        redirect('perdin');
    }
  }


  public function simpan_perdin() {
      // Get the list of employee IDs
      $pkepada = $this->input->post('listizin');
      // var_dump($pkepada);die();
    
      // Ensure $pkepada is an array
      if (!is_array($pkepada)) {
          $pkepada = [];
      }
      
      // Get the departure date (tgl_berangkat) from the input
      $tgl_berangkat = $this->input->post('tglberangkat');
      
     // Check if the list of employees and date are provided
      if (empty($pkepada) || empty($tgl_berangkat)) {
          echo json_encode(['status' => false, 'message' => 'Invalid data.']);
          return;
      }
      
      // Call the check_data_pegawai_by_date_double_check function
      $check = $this->check_data_pegawai_by_date_double_check($pkepada, $tgl_berangkat);
  
      // Check if the result indicates that the employee already has a trip scheduled on the selected date
      if ($check['status'] === true && $check['exists'] === true) {

          $this->session->set_flashdata('gagal', "Pegawai yang dipilih sudah melakukan perjalanan dinas di tanggal yang dipilih.");


          redirect('perdin/addrekap');  // Redirect to the same page or another page
          return;
      }

      if (!is_array($pkepada)) {
          $pkepada = [];
      }

      // ID yang harus dipindahkan ke akhir
      $prioritas = [1152, 31];

    // Cek apakah ID prioritas ada dalam array
    $adaPrioritas = array_intersect($pkepada, $prioritas);

    if (!empty($adaPrioritas)) {
        // Pisahkan elemen prioritas dari array utama
        $normal = array_diff($pkepada, $prioritas);
        $akhir = array_intersect($pkepada, $prioritas);

        // Gabungkan kembali dengan elemen prioritas di akhir
        $pkepada = array_merge($normal, $akhir);
    }
    $titik_lokasi = $this->input->post('titik_lokasi');
    // $dasar_arahan_pimpiman = $this->input->post('dasar_arahan_pimpiman');
    // $pegawai_dinas_lain = $this->input->post('pegawai_dinas_lain');
    $tujuan = $this->input->post('kabupaten');

    // Tangkap input POST untuk tanggal berangkat dan kembali
    $tglberangkat  = $this->input->post('tglberangkat');
    $tglkembali    = $this->input->post('tglkembali');
    $tglberangkat2 = $this->input->post('tglberangkat2');
    $tglkembali2   = $this->input->post('tglkembali2');
    $tglberangkat3 = $this->input->post('tglberangkat3');
    $tglkembali3   = $this->input->post('tglkembali3');

    $detail_tempat_1   = $this->input->post('detail_tempat_1');
    $detail_tempat_2   = $this->input->post('detail_tempat_2');
    $detail_tempat_3   = $this->input->post('detail_tempat_3');
    

    
    $pil_tgl = date('Y-m-d', strtotime($tglberangkat));
    $pil_tgl_saja = date('d', strtotime($tglberangkat));

    $n = date('N', strtotime($pil_tgl));

    $nilai_hari_sebelum = $n - 1;

    $hari_pertama = $pil_tgl_saja - $nilai_hari_sebelum;

    $jml_hari_akhir = 7 - $n;

    $hari_akhir = $pil_tgl_saja + $jml_hari_akhir;
    $date_value_akhir = date('Y-m-d', strtotime("$tglberangkat + $jml_hari_akhir days"));
    $date_value_pertama = date('Y-m-d', strtotime("$tglberangkat - $nilai_hari_sebelum days"));
    
    


    function hitungHari($tgl_awal, $tgl_akhir) {
        // Cek apakah tanggal kosong atau bernilai "0000-00-00"
        if (empty($tgl_awal) || empty($tgl_akhir) || $tgl_awal == "0000-00-00" || $tgl_akhir == "0000-00-00") {
            return 0;
        }

        $awal  = new DateTime($tgl_awal);
        $akhir = new DateTime($tgl_akhir);

        // Jika tanggal berangkat sama dengan tanggal kembali, hitungan = 1 hari
        if ($awal == $akhir) {
            return 1;
        }

        // Hitung selisih hari
        return $awal->diff($akhir)->days + 1; // +1 agar hari pertama tetap dihitung
    }

    // Menghitung hari untuk perjalanan pertama
    $hari1 = hitungHari($tglberangkat, $tglkembali);

    // Jika tglberangkat2 kosong atau "0000-00-00", hanya hitung hari pertama
    if ($tglberangkat2 == "0000-00-00" || empty($tglberangkat2)) {
        $total_hari = $hari1;
    } else {
        // Menghitung hari untuk perjalanan kedua dan ketiga
        $hari2 = hitungHari($tglberangkat2, $tglkembali2);
        $hari3 = hitungHari($tglberangkat3, $tglkembali3);

        // Koreksi jika ada tumpang tindih hari
        if (!empty($tglkembali) && !empty($tglberangkat2) && $tglkembali == $tglberangkat2) {
            $hari2--; // Hilangkan satu hari karena dihitung dua kali
        }
        if (!empty($tglkembali2) && !empty($tglberangkat3) && $tglkembali2 == $tglberangkat3) {
            $hari3--; // Hilangkan satu hari karena dihitung dua kali
        }

        // Jika tglberangkat3 kosong atau "0000-00-00", hanya hitung sampai perjalanan kedua
        if ($tglberangkat3 == "0000-00-00" || empty($tglberangkat3)) {
            $total_hari = $hari1 + $hari2;
        } else {
            $total_hari = $hari1 + $hari2 + $hari3;
        }
    }
    if (count($tujuan) > 3) {
        // Jika jumlah tujuan lebih dari 3, hentikan proses dan kembalikan pesan error
        echo json_encode(['status' => 'error', 'message' => 'Maksimal 3 tujuan diperbolehkan.']);
        exit; // Hentikan eksekusi script
    }

    $nama_tujuan = []; // Inisialisasi array kosong
    // var_dump($tujuan);die();

    foreach ($tujuan as $key => $value) {
        // Ambil nama kabupaten berdasarkan ID
        $kabupaten_name = $this->m_perdin->get_kabupaten_name($value);

        // Ekstrak field 'n_kabupaten' dari objek dan masukkan ke array
        foreach ($kabupaten_name as $item) {
            $nama_tujuan[] = mb_convert_case(strtolower($item->n_kabupaten), MB_CASE_TITLE, "UTF-8");

        }
    }

    // Konversi array ke JSON string
    $kab_kota_json = json_encode($nama_tujuan);

    $id_tim = $this->input->post('id_tim');

    // Mendapatkan nomor grup terakhir
    $no_grup_terakhir = $this->m_perdin->get_no_grup_terakhir();

    // Mendapatkan nomor grup sebelumnya berdasarkan id_tim
    $no_grup_sebelumnya = $this->m_perdin->get_no_grup_by_id_tim($id_tim);

    // Menentukan nomor grup perjalanan dinas
    if ($no_grup_sebelumnya != null) {
        // Jika nomor grup sebelumnya ada, tambahkan 1
        $no_grup_perdin = $no_grup_sebelumnya + 1;
    } else {
        // Jika tidak ada, mulai dari 1
        $no_grup_perdin = 1;
    }
      $data = [
          'keu_perdin_id' => $no_grup_perdin,
          'kab_kota' => $kab_kota_json, // Simpan JSON string
          'id_tim' => $id_tim,
          'tanggal_berangkat_1' => $tglberangkat,
          'tanggal_pulang_1' => $tglkembali,
          'tanggal_berangkat_2' => $tglberangkat2,
          'tanggal_pulang_2' => $tglkembali2,
          'tanggal_berangkat_3' => $tglberangkat3,
          'tanggal_pulang_3' => $tglkembali3,
          'detail_tempat_1' => $detail_tempat_1,
          'detail_tempat_2' => $detail_tempat_2,
          'detail_tempat_3' => $detail_tempat_3
      ];
      // Simpan data ke database
      $id_perdin = $this->m_perdin->save_e_perdin_tujuan_pemberangkatan($data);

    
 

        // Cek jika jumlah elemen lebih dari 4, kecuali jika mengandung 1152 dan 31
    
        // Data umum

        $user_id = $this->session->userdata('id_auth'); 
        $uraian = $this->input->post('uraian');
        // $tujuan = $this->input->post('kabupaten');
        // $nama_tujuan = $this->m_perdin->get_kabupaten_name($tujuan);
        $skpd = "Dinas PMPTSP Jawa Barat";
        $no__sppd = $this->input->post('no__sppd');
        $tanggal_berangkat = $this->input->post('tglberangkat');
        $tanggal_kembali = $this->input->post('tglkembali');
        $tgl_surat = $this->input->post('tgl_surat');
        
        $detail_tempat_pemberangkatan = $this->input->post('detail_tempat_pemberangkatan');
        $kendaraan = $this->input->post('kendaraan');

        $mksd_pemberangkatan = $this->input->post('mksd_pemberangkatan');
        $kode_rek_sub_req = $this->input->post('kode_rek_sub_req');
        $perihal_srt_undangan = $this->input->post('perihal_srt_undangan');
        $nmr_srt_undangan = $this->input->post('nmr_srt_undangan');
        $tgl_srt_undangan = $this->input->post('tgl_srt_undangan');
        $tipe_undangan = $this->input->post('tipe_undangan');
        $srt_instansi_undangan = $this->input->post('srt_instansi_undangan');
        $id_tim = $this->input->post('id_tim');
        $dasar_arahan_pimpiman = $this->input->post('dasar_arahan_pimpiman');
        $pegawai_dinas_lain = $this->input->post('pegawai_dinas_lain');
        $tanggal_sp_backdate = $this->input->post('tanggal_sp_backdate');
        $kode_rek = $this->input->post('kode_rek');
        $kendaraan = $this->input->post('kendaraan');
        $jenis_dinas_luar = $this->input->post('jenis_dinas_luar');
        
       

        
        $lama_p_d = $total_hari;

          // Mendapatkan nomor grup terakhir
          $no_grup_terakhir = $this->m_perdin->get_no_grup_terakhir();

          // Mendapatkan nomor grup sebelumnya (misalnya, berdasarkan id_tim sebelumnya)
          $no_grup_sebelumnya = $this->m_perdin->get_no_grup_by_id_tim($id_tim);

          // Memeriksa apakah id_tim tidak sama dengan nomor grup terakhir dan nomor grup sebelumnya
          if ($no_grup_sebelumnya != null) {
              // Jika id_tim tidak sama dengan nomor grup terakhir dan sebelumnya, tambahkan 1
              $no_grup_perdin = $no_grup_sebelumnya + 1;
          } else {
              // Jika id_tim sama dengan nomor grup terakhir atau sebelumnya, mulai dari 1
              $no_grup_perdin = 1;
          }
        
        // Mulai transaksi\
        $this->db->trans_start();
        $data_pegawai_sudah_perdin = [];
        if ($tipe_undangan != 2 || $tipe_undangan != 3 ) {
              foreach ($pkepada as $row) {
                $id_kepala = $this->m_perdin->get_kepala_dinas(2);
                $id_pengecualian = $this->m_perdin->get_id_pengecualian($row);
                // var_dump($id_tim);die();
            if ($lama_p_d > 2 &&  $id_kepala != $row && $id_pengecualian == FALSE && $id_tim != 73) {
              
                // var_dump($id_kepala, $id_pengecualian, $row);die();
                  $this->session->set_flashdata('gagal',"Batas melakukan perjalan dinas adalah 2 hari dalam minggu pemilihan tanggal" );
                  redirect('/perdin/addrekap/');
            }else{
                if ($id_kepala != $row && $id_pengecualian == FALSE && $id_tim != 73) {
                  $bulan_ini = date('m', strtotime($tanggal_berangkat)); // hasil: '07' jika Juli
                  $tahun_ini = date('Y', strtotime($tanggal_berangkat)); // hasil: '2025' jika tahun 2025
                  // Cek lama perjalanan minggu ini
                  $data_pegawai_sudah_perdin = $this->m_perdin->get_data_pegawai_sudah_perdin($date_value_pertama, $date_value_akhir, $row);

                  // Cek jumlah total anggaran dalam bulan ini
                  $total_uang_hari_bulanan = $this->m_perdin->get_total_uang_hari_bulanan($bulan_ini, $tahun_ini);
                  // var_dump($total_uang_hari_bulanan);die();
                  // Cek kondisi: minggu ini sudah 2 hari atau total anggaran dalam bulan ini >= 72jt
                 // var_dump($data_pegawai_sudah_perdin);die();
                 $limit = 1000000000000;
                  if (
                      (!empty($data_pegawai_sudah_perdin) && $data_pegawai_sudah_perdin[0]->total_lama_p_d >= 2  && $id_kepala != $row && $id_pengecualian == FALSE)
                      || ($total_uang_hari_bulanan >= $limit && $id_kepala != $row && $id_pengecualian == FALSE) && ($id_tim != 73)
                  ) {
                      $data_pegawai = $this->m_perdin->get_n_pegawai($row);

                      $this->db->trans_rollback();

                      $nama_pegawai = is_array($data_pegawai) || is_object($data_pegawai) ? json_encode($data_pegawai) : $data_pegawai;

                      // Buat pesan error yang jelas tergantung kondisi
                      $pesan = "tidak bisa diajukan perjalanan dinas karena: ";
                      if (!empty($data_pegawai_sudah_perdin) && $data_pegawai_sudah_perdin[0]->total_lama_p_d >= 2 && $id_kepala != $row && $id_pengecualian == FALSE) {
                          $pesan .= "sudah melakukan 2 hari perjalanan dinas minggu ini. ";
                      }
                      if ($total_uang_hari_bulanan >= $limit && $id_kepala != $row && $id_pengecualian == FALSE) {
                          $pesan .= "Total anggaran bulan ini telah mencapai Rp " . number_format($total_uang_hari_bulanan, 0, ',', '.') . ".";
                      }

                      $this->session->set_flashdata('gagal', $pesan);
                      redirect('/perdin/addrekap/');
                  }
                }
                
              }

            }  
        }
       
       
  
        foreach ($pkepada as $row) {
          $kab_kota_jabar = [
              'Bandung', 'Bekasi', 'Bogor', 'Depok', 'Cimahi', 'Cirebon', 'Sukabumi', 'Tasikmalaya', 
              'Garut', 'Sumedang', 'Majalengka', 'Subang', 'Indramayu', 'Karawang', 'Purwakarta', 
              'Cianjur', 'Kuningan', 'Pangandaran', 'Banjar'
          ];

          // Default uang_hari
          $uang_hari = 0;
          if ($user_id == 57) {
              $status_approve = 2;
          }else{
              $status_approve = 1;
          }

          // Cek kondisi jenis_dinas_luar dan lokasi
          if ($jenis_dinas_luar == 1) {
              foreach ($kab_kota_jabar as $kab_jabar) {
                  if (stripos($nama_tujuan, $kab_jabar) !== false) {
                      $uang_hari = 430000;
                      break; // berhenti jika sudah ketemu
                  }
              }
          } elseif ($jenis_dinas_luar == 2 || $jenis_dinas_luar == 3) {
              $uang_hari = 105000;
          }
         
          // var_dump($user_id);die();


          $data = [
              'id_pegawai' => $row,
              'user_id' => $user_id,
              'lama_p_d' => $lama_p_d,
              'no_grup_perdin' => $no_grup_perdin,
              'uraian' => $uraian,
              'tanggal_sp_backdate' => $tanggal_sp_backdate,
              'skpd' => $skpd,
              'no__sppd' => $nomor_format,
              'tanggal_berangkat' => $tanggal_berangkat,
              'tanggal_kembali' => $tanggal_kembali,
              'tgl_surat' => $tgl_surat,
              'file_srt' => $file_srt,
              'mksd_pemberangkatan' => $mksd_pemberangkatan,
              'kode_rek_sub_req' => $kode_rek_sub_req,
              'perihal_srt_undangan' => $perihal_srt_undangan,
              'nmr_srt_undangan' => $nmr_srt_undangan,
              'tgl_srt_undangan' => $tgl_srt_undangan,
              'tipe_undangan' => $tipe_undangan,
              'srt_instansi_undangan' => $srt_instansi_undangan,
              'id_tim' => $id_tim,
              'detail_tempat_pemberangkatan' => $detail_tempat_pemberangkatan,
              'dasar_arahan_pimpiman' => $dasar_arahan_pimpiman,
              'pegawai_dinas_lain' => $pegawai_dinas_lain,
              'kode_rek' => $kode_rek,
              'titik_lokasi' => $titik_lokasi,
              'kendaraan' => $kendaraan,
              'jenis_dinas_luar' => $jenis_dinas_luar,
              'uang_hari' => $uang_hari,
              'status_approve' => $status_approve,
          ];
         
          $pegawai = $this->m_perdin->get_n_pegawai_perdin($row);
          $nip = $this->m_perdin->get_n_nip($row);
          $jabatan = $this->m_perdin->get_n_jabatan($row);
          $kode_tim_file = $this->m_perdin->get_tim_details($id_tim);
          $this->db->trans_start();
          // Simpan data dan ambil ID yang dihasilkan
          $id_perdin = $this->m_perdin->save_e_perdin($data);
          // Contoh daftar kabupaten/kota di Jawa Barat
         
          $data_log_perdin = [
              'id_user_pembuat' => $user_id,
              'tanggal_pembuatan' => date('Y-m-d H:i:s'),
              'status_approve' => $status_approve,
              'mksd_pemberangkatan' => $mksd_pemberangkatan,
              'id_data_utama' => $id_perdin
          ];


          $save_log_perdin  = $this->m_perdin->save_log_e_perdin($data_log_perdin);
                  // var_dump($save_log_perdin);die();
          $this->db->trans_complete();

          // Gabungkan data pegawai ke dalam array
          $data_pegawai[] = [
              'id_perdin' => $id_perdin, // Tambahkan ID Perdin
              'id_pegawai' => $row,
              'id_tim' => $id_tim,
              'no_grup_perdin' => $no_grup_perdin,
              'nama_pegawai' => $pegawai['n_pegawai'],
              'pangkat_gol' => $pegawai['pangkat_gol'],
              'golongan' => $pegawai['golongan'],
              'nip' => $nip,
              'lama_p_d' => $lama_p_d,
              'jabatan' => $jabatan,
              'srt_instansi_undangan' => $srt_instansi_undangan,
              'mksd_pemberangkatan' => $mksd_pemberangkatan,
              'kode_rek_sub_req' => $kode_rek_sub_req,
              'perihal_srt_undangan' => $perihal_srt_undangan,
              'nmr_srt_undangan' => $nmr_srt_undangan,
              'tgl_srt_undangan' => $tgl_srt_undangan,
              'detail_tempat_pemberangkatan' => $detail_tempat_pemberangkatan,
              'tanggal_kembali' => $tanggal_kembali,
              'tanggal_berangkat' => $tanggal_berangkat,
              'nama_tujuan' => $nama_tujuan,
              'dasar_arahan_pimpiman' => $dasar_arahan_pimpiman,
              'pegawai_dinas_lain' => $pegawai_dinas_lain,
              'kode_rek' => $kode_rek,
              'kab_kota_array' => $kab_kota_array,
              'kendaraan' => $kendaraan,
              'jenis_dinas_luar' => $jenis_dinas_luar,
              'uang_hari' => $uang_hari,
              'tanggal_sp_backdate' => $tanggal_sp_backdate,
          ];
        

          if (count($kabupaten_name) > 2) {
        
              $data_pegawai = $this->m_perdin->get_n_pegawai($row);
              
                        $this->db->trans_rollback();
                      if (is_array($data_pegawai) || is_object($data_pegawai)) {
                        // Jika $data_pegawai adalah array atau objek, kita ubah menjadi JSON atau format string lainnya
                        $data_pegawai = json_encode($data_pegawai);
                      }
                      // Set flashdata dengan pesan yang lebih jelas
                      $this->session->set_flashdata('gagal',$data_pegawai. "sudah melakukan 2 kali perjalanan dinas" );
                      redirect('/perdin/addrekap/');
          }


        }
        // // Debug: Tampilkan data pegawai dengan ID perjalanan dinas      
        // Commit transaksi jika semua sukses
        
        
        require_once 'assets/phpword/src/PhpWord/Autoloader.php';
        \PhpOffice\PhpWord\Autoloader::register();

        // Menentukan file template berdasarkan jumlah $pkepada
        $templateFile = '';
        $countPkepada = count($pkepada); // Menghitung jumlah elemen dalam $pkepada
        
        if (is_array($pkepada)) {

          if (in_array("31", $pkepada) || in_array("1152", $pkepada)) {

              // Jika kedua nilai ada dalam array
              if (in_array("31", $pkepada)) {
                $filtered_data = array_filter($data_pegawai, function($item) {
                    return $item['id_pegawai'] == 31;
                });

                if ($tipe_undangan == 1) {
                  $templateFile = 'assets/file_surat_perdin/template_surat_perdin/surat_perintah_template_pa_sekdis_tipe1.docx';
                    // Memproses file template yang dipilih
                    $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor($templateFile);

                    // Lanjutkan dengan pengisian data ke dalam template...

                    $arrblnRomawi = array("I","II","III","IV","V","VI",'VII','VIII','IX','X','XI','XII');
                    $blnRomawi = $arrblnRomawi[date("m")-1];
                    
                    // Pastikan menggunakan setlocale untuk format bahasa Indonesia
                    setlocale(LC_TIME, 'id_ID.utf8');

                    // Mendapatkan hari, tanggal, bulan, dan tahun
                    $hari_ttd = strftime('%A', time()); // Nama hari
                    $tgl_ttd = strftime('%d', time()); // Tanggal (angka)
                    $bln_ttd = strftime('%B', time()); // Nama bulan

                    // Ganti "Pebruari" menjadi "Februari"
                    $bln_ttd = str_replace("Pebruari", "Februari", $bln_ttd); // Nama bulan
                    $tahun_text = strftime('%Y', time()); // Tahun (angka)
                    // Membuat nomor random
                    $random_number = mt_rand(1000, 9999); // Nomor random 4 digit

                    // Mendapatkan tanggal hari ini dalam format DDMMYYYY
                    $tanggal_hari_ini = date('dmY');

                    // Menggabungkan semua elemen menjadi nomor dengan format yang diinginkan
                    $kode_tim = $kode_tim_file->kode_tim_ketua;
                    // var_dump($kode_tim);die();
                    foreach ($filtered_data as $index => $pegawai) {
                      // Hanya proses data dengan ID tertentu
                      // Menampilkan hasil yang sudah difilter
                      if ($pegawai['id_pegawai'] != 31) {
                          continue; // Lewati iterasi jika ID tidak sesuai
                      }
                      $tujuan_keberangkatan_perdin = $this->m_perdin->get_tujuan_keberangkatan_perdin($pegawai['no_grup_perdin'], $pegawai['id_tim']);

                      $kab_kota_array = [];
                      if (!empty($tujuan_keberangkatan_perdin)) {
                          foreach ($tujuan_keberangkatan_perdin as $rowlist) {
                              // Decode jika kab_kota dalam format JSON
                              $decoded = json_decode($rowlist->kab_kota, true);
                              if (is_array($decoded)) {
                                  $kab_kota_array = array_merge($kab_kota_array, $decoded); // Gabungkan jika array
                              } else {
                                  $kab_kota_array[] = $rowlist->kab_kota; // Tambahkan langsung jika bukan JSON
                              }
                          }
                      } else {
                          echo "No data available"; // Tampilkan pesan jika data kosong
                      }
                      $tujuan_keberangkatan_perdin = $this->m_perdin->get_tujuan_keberangkatan_perdin($pegawai['no_grup_perdin'], $pegawai['id_tim']);
                      
                      $tanggalBerangkat_1 = $tujuan_keberangkatan_perdin[0]->tanggal_berangkat_1;
                      $tanggalBerangkat_2 = $tujuan_keberangkatan_perdin[0]->tanggal_berangkat_2;
                      $tanggalBerangkat_3 = $tujuan_keberangkatan_perdin[0]->tanggal_berangkat_3;
            
                      $tanggal_pulang_1 = $tujuan_keberangkatan_perdin[0]->tanggal_pulang_1;
                      $tanggal_pulang_2 = $tujuan_keberangkatan_perdin[0]->tanggal_pulang_2;
                      $tanggal_pulang_3 = $tujuan_keberangkatan_perdin[0]->tanggal_pulang_3;
      
                      setlocale(LC_TIME, 'id_ID.UTF-8', 'Indonesian', 'id_ID');

                      // Format tanggal dengan strftime
                      // Format tanggal dengan strftime
                      $tanggal_pulang_1 = strftime('%d %B %Y', strtotime($tanggal_pulang_1));
                      if ($tanggal_pulang_2 == "0000-00-00") {
                        $tanggal_pulang_2 = '';
                      } else {
                        // Format the date only if it's a valid date
                        $tanggal_pulang_2 = strftime('%d %B %Y', strtotime($tanggal_pulang_2));
                      }
          
                      // Check if $tanggal_pulang_3 is "0000-00-00" and set it to an empty string if true
                      if ($tanggal_pulang_3 == "0000-00-00") {
                        $tanggal_pulang_3 = '';
                      } else {
                        // Format the date only if it's a valid date
                        $tanggal_pulang_3 = strftime('%d %B %Y', strtotime($tanggal_pulang_3));
                      }

                      $tglKeberangkatan_1 = strftime('%d %B %Y', strtotime($tanggalBerangkat_1));
                      $tglKeberangkatan_2 = strftime('%d %B %Y', strtotime($tanggalBerangkat_2));
                      $tglKeberangkatan_3 = strftime('%d %B %Y', strtotime($tanggalBerangkat_3));

                      // Ganti "Pebruari" menjadi "Februari"
                      $bulan_salah = 'Pebruari';
                      $bulan_benar = 'Februari';

                      $tanggal_pulang_1 = str_replace($bulan_salah, $bulan_benar, $tanggal_pulang_1);
                      $tanggal_pulang_2 = str_replace($bulan_salah, $bulan_benar, $tanggal_pulang_2);
                      $tanggal_pulang_3 = str_replace($bulan_salah, $bulan_benar, $tanggal_pulang_3);

                      $tglKeberangkatan_1 = str_replace($bulan_salah, $bulan_benar, $tglKeberangkatan_1);
                      $tglKeberangkatan_2 = str_replace($bulan_salah, $bulan_benar, $tglKeberangkatan_2);
                      $tglKeberangkatan_3 = str_replace($bulan_salah, $bulan_benar, $tglKeberangkatan_3);
                      // Format tanggal dengan strftime
                      $tglKeberangkatan = strftime('%d %B %Y', strtotime($pegawai['tanggal_berangkat']));
                      $tglKepulangan = strftime('%d %B %Y', strtotime($pegawai['tanggal_kembali']));

                      // Pastikan "Februari" ditulis dengan 'F' bukan 'P'
                      $tglKeberangkatan = str_replace('Pebruari', 'Februari', $tglKeberangkatan);
                      $tglKepulangan = str_replace('Pebruari', 'Februari', $tglKepulangan);

                      // var_dump($pegawai['tanggal_sp_backdate']);die();
                      if ($pegawai['tanggal_sp_backdate'] == '0000-00-00' || $pegawai['tanggal_sp_backdate'] === false) {

                      }else{
                        $tanggal_sp_backdate = strftime('%d %B %Y', strtotime($pegawai['tanggal_sp_backdate']));
                        $templateProcessor->setValue("tgl_surat", $tanggal_sp_backdate);
                      }
                      // var_dump($tglKeberangkatan);die();
                      if ($tanggalBerangkat_1 == "0000-00-00") {
                        $templateProcessor->setValue("tglKeberangkatan_1", '');
                        $templateProcessor->setValue("tanggal_pulang_1", '');
                        $templateProcessor->setValue("tgl_kepulangan#1", $tanggal_pulang_1);
          
                      }else{
                        $templateProcessor->setValue("tglKeberangkatan_1", $tglKeberangkatan_1);
                        $templateProcessor->setValue("tanggal_pulang_1", $tanggal_pulang_1);
                        
                        if ($tanggalBerangkat_2 === "0000-00-00") {
                            if ($pegawai['lama_p_d'] == 1) {
                                $templateProcessor->setValue("tgl_kepulangan_sp1", '');
                            } else {
                                $templateProcessor->setValue("tgl_kepulangan_sp1", "sampai dengan " . $tanggal_pulang_2);
                            }
                            $templateProcessor->setValue("tgl_kepulangan1", $tanggal_pulang_1);
          
                        } else {
                            $templateProcessor->setValue("tgl_kepulangan_sp1", '');
                            $templateProcessor->setValue("tgl_kepulangan1", '');
          
                        }
                      
          
                      }
                      if ($tanggalBerangkat_2 == "0000-00-00") {
                        // var_dump($tanggalBerangkat_2);die();
          
                        $templateProcessor->setValue("tglKeberangkatan_2", '');
                        $templateProcessor->setValue("tanggal_pulang_2", '');
                        
                        $templateProcessor->setValue("tgl_kepulangan2", "");
                        if ($tanggalBerangkat_3 == "0000-00-00") {
                          if ($pegawai['lama_p_d'] == 1) {
                            $templateProcessor->setValue("tgl_kepulangan_sp2", '');
                          } else {
                              $templateProcessor->setValue("tgl_kepulangan_sp2", "sampai dengan " . $tanggal_pulang_2);
                          }
                        }else{
                          $templateProcessor->setValue("tgl_kepulangan_sp2", "sampai dengan " . $tanggal_pulang_3);
                        }
                      }else{
                        $templateProcessor->setValue("tglKeberangkatan_2", $tglKeberangkatan_2);
                        $templateProcessor->setValue("tanggal_pulang_2", $tanggal_pulang_2);
                        // var_dump($pegawai['lama_p_d']);die();
          
                        if ($tanggalBerangkat_3 == "0000-00-00") {
                          if ($pegawai['lama_p_d'] == 1) {
                            $templateProcessor->setValue("tgl_kepulangan_sp2", '');
                          } else {
                              $templateProcessor->setValue("tgl_kepulangan_sp2", "sampai dengan " . $tanggal_pulang_2);
                          }
                          $templateProcessor->setValue("tgl_kepulangan2", $tanggal_pulang_2);
          
                        }else{
                          $templateProcessor->setValue("tgl_kepulangan2", "");
                          $templateProcessor->setValue("tgl_kepulangan_sp2", "sampai dengan " . $tanggal_pulang_3);
                        }
          
                      }
                      if ($tanggalBerangkat_3 == "0000-00-00") {
                        $templateProcessor->setValue("tglKeberangkatan_3", '');
                        $templateProcessor->setValue("tanggal_pulang_3", '');
                        $templateProcessor->setValue("tgl_kepulangan3", "");
                        $templateProcessor->setValue("tgl_kepulangan_sp3", '');
                      }else{
                        $templateProcessor->setValue("tglKeberangkatan_3", $tglKeberangkatan_3);
                        $templateProcessor->setValue("tanggal_pulang_3", $tanggal_pulang_3);
                        $templateProcessor->setValue("tgl_kepulangan3", $tanggal_pulang_3);
                        $templateProcessor->setValue("tgl_kepulangan_sp3", '');
                      }
                    
                      
                      // Sanitasi untuk srt_instansi_undangan agar aman untuk penggunaan dalam dokumen Word
                      $srtInstansiUndangan = htmlspecialchars($pegawai['srt_instansi_undangan'], ENT_QUOTES, 'UTF-8');

                      $kabupatenKota = ucwords(strtolower($pegawai['nama_tujuan'][0]->n_kabupaten));
                  
                      // Menetapkan nilai pada placeholder di template
                      $templateProcessor->setValue("jabatan", $pegawai['jabatan']);
                      $templateProcessor->setValue("ada", $srtInstansiUndangan);
                      $templateProcessor->setValue("mksd", $pegawai['mksd_pemberangkatan']);
                      $templateProcessor->setValue("kode_rekening_sub_keg", $pegawai['kode_rek_sub_req']);
                      $templateProcessor->setValue("srt_perihal_undangan", $pegawai['perihal_srt_undangan']);
                      $templateProcessor->setValue("srt_nmr_undangan", $pegawai['nmr_srt_undangan']);
                      $templateProcessor->setValue("tgl_srt_undangan", $pegawai['tgl_srt_undangan']);
                        $templateProcessor->setValue("tgl_srt_undangan#{$index}", $tgl_srt_undangan);

                      $location_details = [];
                      
                      if (!empty($detail_tempat_1) && isset($kab_kota_array[0])) {
                          $location_details[] = $detail_tempat_1 . ' ' . $kab_kota_array[0];
                      }
                      if (!empty($detail_tempat_2) && isset($kab_kota_array[1])) {
                          $location_details[] = $detail_tempat_2 . ' ' . $kab_kota_array[1];
                      }
                      if (!empty($detail_tempat_3) && isset($kab_kota_array[2])) {
                          $location_details[] = $detail_tempat_3 . ' ' . $kab_kota_array[2];
                      }
                      
                      $final_location_string = implode(', ', $location_details);
                      
                      $templateProcessor->setValue("brtmpt", $final_location_string);
                      $templateProcessor->setValue("lama_perdin", $pegawai['lama_p_d']);
                      $templateProcessor->setValue("tgl_keberangkatan", $tglKeberangkatan);
                      $templateProcessor->setValue("tgl_kepulangan", $tglKepulangan);
                      $templateProcessor->setValue("kabupaten_kota_bertempatan", $kabupatenKota);
                      $templateProcessor->setValue("kepada_nama", $pegawai['nama_pegawai']);
                      $templateProcessor->setValue("kode_rek", $pegawai['kode_rek']);
                      $templateProcessor->setValue("arahan_pimpinan", $pegawai['dasar_arahan_pimpiman']);
                      $templateProcessor->setValue("kode_tim", $kode_tim);
                      $templateProcessor->setValue("no_urut", $no_grup_perdin);
                      $templateProcessor->setValue("kendaraan", $pegawai['kendaraan']);
                      // Cek apakah nip ada, jika ada maka kolom nip akan muncul
                      if (!empty($pegawai['pangkat_gol']) && strtolower($pegawai['pangkat_gol']) != 'tenaga kontrak') {
                          $templateProcessor->setValue("nama_kolom_nip", 'Nomor Induk Pegawai');
                          $templateProcessor->setValue("nip", $pegawai['nip']);
                          $pangkatGolongan = (isset($pegawai['pangkat_gol']) && isset($pegawai['golongan']) && $pegawai['pangkat_gol'] !== '' && $pegawai['golongan'] !== '' && $pegawai['pangkat_gol'] !== 'Tenaga Kontrak') 
                          ? $pegawai['pangkat_gol'] . ' (' . $pegawai['golongan'] .')'
                          : 'Non ASN';
              
              
                                          $templateProcessor->setValue("Pangkat_golongan", $pangkatGolongan);


                      } else {
                        $templateProcessor->setValue("nama_kolom_nip#{$index}", 'Nomor Induk Pegawai');
                        $templateProcessor->setValue("nip#{$index}", '-');
                        $pangkatGolongan = (isset($pegawai['pangkat_gol']) && isset($pegawai['golongan']) && $pegawai['pangkat_gol'] !== '' && $pegawai['golongan'] !== '' && $pegawai['pangkat_gol'] !== 'Tenaga Kontrak') 
                        ? $pegawai['pangkat_gol'] . ' (' . $pegawai['golongan'] .')'
                        : 'Non ASN';
            
            
                                        $templateProcessor->setValue("Pangkat_golongan", $pangkatGolongan);
                      }
                      $templateProcessor->setValue("Pangkat_golongan_visum#{$index}", $pangkatGolongan);

                      $templateProcessor->setValue("jabatan", $pegawai['jabatan']); 
                      $templateProcessor->setValue("golongan", $pegawai['golongan']); 

                      if (count($kab_kota_array) == 1) {
                          $templateProcessor->setValue("tempat_tujuan#1", isset($kab_kota_array[0]) ? $kab_kota_array[0] . ' ' : '');
                          $templateProcessor->setValue("tempat_tujuan#2", isset($kab_kota_array[1]) ? $kab_kota_array[1] . ',' : '');
                          $templateProcessor->setValue("tempat_tujuan#3", isset($kab_kota_array[2]) ? $kab_kota_array[2] . ',' : '');
            
                          $templateProcessor->setValue("tempat_tujuan_1_kota#0", 'Kota Bandung');
                          $templateProcessor->setValue("tempat_tujuan_2_kota#0", '');
                          $templateProcessor->setValue("tempat_tujuan_3_kota#0", '');
                      }elseif(count($kab_kota_array) == 2){
                        $templateProcessor->setValue("tempat_tujuan#1", isset($kab_kota_array[0]) ? $kab_kota_array[0] . ',' : '');
                        $templateProcessor->setValue("tempat_tujuan#2", isset($kab_kota_array[1]) ? $kab_kota_array[1] . ' ' : '');
                        $templateProcessor->setValue("tempat_tujuan#3", isset($kab_kota_array[2]) ? $kab_kota_array[2] . ',' : '');
            
                        $templateProcessor->setValue("tempat_tujuan_1_kota#0", '');
                        $templateProcessor->setValue("tempat_tujuan_2_kota#0", 'Kota Bandung');
                        $templateProcessor->setValue("tempat_tujuan_3_kota#0", '');
                      }else{
                        $templateProcessor->setValue("tempat_tujuan#1", isset($kab_kota_array[0]) ? $kab_kota_array[0] . ',' : '');
                        $templateProcessor->setValue("tempat_tujuan#2", isset($kab_kota_array[1]) ? $kab_kota_array[1] . ',' : '');
                        $templateProcessor->setValue("tempat_tujuan#3", isset($kab_kota_array[2]) ? $kab_kota_array[2] . ' ' : '');
            
                        $templateProcessor->setValue("tempat_tujuan_1_kota#0", '');
                        $templateProcessor->setValue("tempat_tujuan_2_kota#0", '');
                        $templateProcessor->setValue("tempat_tujuan_3_kota#0", 'Kota Bandung');
                      }
                      $templateProcessor->deleteBlock('nomor_induk_pegawai_row');

                      
                  }
                  $filename_pa_sekdis = 'assets/file_surat_perdin/kadis_sekdis/SPPD_' . date('Ymd') . '_' . $no_grup_perdin . '_' . $kode_tim_file->kode_tim_ketua . '_sekdis.docx';
                  $filename_pa_sekdis_simpan = 'SPPD_' . date('Ymd') . '_' . $no_grup_perdin . '_' . $kode_tim_file->kode_tim_ketua . '_sekdis.docx';
                  $templateProcessor->saveAs($filename_pa_sekdis);
                  

                  $data = [
                      'file_srt' => $filename_pa_sekdis_simpan,
                  ];
                  $update_perdin = $this->m_perdin->update_e_perdin($pegawai['id_perdin'], $data);
                  // var_dump($filename_pa_sekdis);die();
            
                
                }elseif($tipe_undangan == 3){
                      $templateFile = 'assets/file_surat_perdin/template_surat_perdin/template_arahan_pimpinan/surat_perintah_template_pa_sekdis_arahan_pimpinan.docx';
                      // Memproses file template yang dipilih
                      $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor($templateFile);
  
                      // Lanjutkan dengan pengisian data ke dalam template...
  
                      $arrblnRomawi = array("I","II","III","IV","V","VI",'VII','VIII','IX','X','XI','XII');
                      $blnRomawi = $arrblnRomawi[date("m")-1];
                      
                      // Pastikan menggunakan setlocale untuk format bahasa Indonesia
                      setlocale(LC_TIME, 'id_ID.utf8');
  
                      // Mendapatkan hari, tanggal, bulan, dan tahun
                      $hari_ttd = strftime('%A', time()); // Nama hari
                      $tgl_ttd = strftime('%d', time()); // Tanggal (angka)
                      $bln_ttd = strftime('%B', time()); // Nama bulan
  
                      // Ganti "Pebruari" menjadi "Februari"
                      $bln_ttd = str_replace("Pebruari", "Februari", $bln_ttd); // Nama bulan
                      $tahun_text = strftime('%Y', time()); // Tahun (angka)
                      // Membuat nomor random
                      $random_number = mt_rand(1000, 9999); // Nomor random 4 digit
  
                      // Mendapatkan tanggal hari ini dalam format DDMMYYYY
                      $tanggal_hari_ini = date('dmY');
  
                      // Menggabungkan semua elemen menjadi nomor dengan format yang diinginkan
                      $kode_tim = $kode_tim_file->kode_tim_ketua;
                      // var_dump($kode_tim);die();
                      foreach ($filtered_data as $index => $pegawai) {
                        // Hanya proses data dengan ID tertentu
                        // Menampilkan hasil yang sudah difilter
                        if ($pegawai['id_pegawai'] != 31) {
                            continue; // Lewati iterasi jika ID tidak sesuai
                        }
                        $tujuan_keberangkatan_perdin = $this->m_perdin->get_tujuan_keberangkatan_perdin($pegawai['no_grup_perdin'], $pegawai['id_tim']);
  
                        $kab_kota_array = [];
                        if (!empty($tujuan_keberangkatan_perdin)) {
                            foreach ($tujuan_keberangkatan_perdin as $rowlist) {
                                // Decode jika kab_kota dalam format JSON
                                $decoded = json_decode($rowlist->kab_kota, true);
                                if (is_array($decoded)) {
                                    $kab_kota_array = array_merge($kab_kota_array, $decoded); // Gabungkan jika array
                                } else {
                                    $kab_kota_array[] = $rowlist->kab_kota; // Tambahkan langsung jika bukan JSON
                                }
                            }
                        } else {
                            echo "No data available"; // Tampilkan pesan jika data kosong
                        }
                        $tujuan_keberangkatan_perdin = $this->m_perdin->get_tujuan_keberangkatan_perdin($pegawai['no_grup_perdin'], $pegawai['id_tim']);
                        
                        $tanggalBerangkat_1 = $tujuan_keberangkatan_perdin[0]->tanggal_berangkat_1;
                        $tanggalBerangkat_2 = $tujuan_keberangkatan_perdin[0]->tanggal_berangkat_2;
                        $tanggalBerangkat_3 = $tujuan_keberangkatan_perdin[0]->tanggal_berangkat_3;
              
                        $tanggal_pulang_1 = $tujuan_keberangkatan_perdin[0]->tanggal_pulang_1;
                        $tanggal_pulang_2 = $tujuan_keberangkatan_perdin[0]->tanggal_pulang_2;
                        $tanggal_pulang_3 = $tujuan_keberangkatan_perdin[0]->tanggal_pulang_3;
        
                        setlocale(LC_TIME, 'id_ID.UTF-8', 'Indonesian', 'id_ID');
  
                        // Format tanggal dengan strftime
                        // Format tanggal dengan strftime
                        $tanggal_pulang_1 = strftime('%d %B %Y', strtotime($tanggal_pulang_1));
                        if ($tanggal_pulang_2 == "0000-00-00") {
                          $tanggal_pulang_2 = '';
                        } else {
                          // Format the date only if it's a valid date
                          $tanggal_pulang_2 = strftime('%d %B %Y', strtotime($tanggal_pulang_2));
                        }
            
                        // Check if $tanggal_pulang_3 is "0000-00-00" and set it to an empty string if true
                        if ($tanggal_pulang_3 == "0000-00-00") {
                          $tanggal_pulang_3 = '';
                        } else {
                          // Format the date only if it's a valid date
                          $tanggal_pulang_3 = strftime('%d %B %Y', strtotime($tanggal_pulang_3));
                        }
  
                        $tglKeberangkatan_1 = strftime('%d %B %Y', strtotime($tanggalBerangkat_1));
                        $tglKeberangkatan_2 = strftime('%d %B %Y', strtotime($tanggalBerangkat_2));
                        $tglKeberangkatan_3 = strftime('%d %B %Y', strtotime($tanggalBerangkat_3));
  
                        // Ganti "Pebruari" menjadi "Februari"
                        $bulan_salah = 'Pebruari';
                        $bulan_benar = 'Februari';
  
                        $tanggal_pulang_1 = str_replace($bulan_salah, $bulan_benar, $tanggal_pulang_1);
                        $tanggal_pulang_2 = str_replace($bulan_salah, $bulan_benar, $tanggal_pulang_2);
                        $tanggal_pulang_3 = str_replace($bulan_salah, $bulan_benar, $tanggal_pulang_3);
  
                        $tglKeberangkatan_1 = str_replace($bulan_salah, $bulan_benar, $tglKeberangkatan_1);
                        $tglKeberangkatan_2 = str_replace($bulan_salah, $bulan_benar, $tglKeberangkatan_2);
                        $tglKeberangkatan_3 = str_replace($bulan_salah, $bulan_benar, $tglKeberangkatan_3);
                        // Format tanggal dengan strftime
                        $tglKeberangkatan = strftime('%d %B %Y', strtotime($pegawai['tanggal_berangkat']));
                        $tglKepulangan = strftime('%d %B %Y', strtotime($pegawai['tanggal_kembali']));
  
                        // Pastikan "Februari" ditulis dengan 'F' bukan 'P'
                        $tglKeberangkatan = str_replace('Pebruari', 'Februari', $tglKeberangkatan);
                        $tglKepulangan = str_replace('Pebruari', 'Februari', $tglKepulangan);
                        // var_dump($tglKeberangkatan);die();
                        // var_dump($pegawai['tanggal_sp_backdate']);die();
                        if ($pegawai['tanggal_sp_backdate'] == '0000-00-00' || $pegawai['tanggal_sp_backdate'] === false) {

                        }else{
                          $tanggal_sp_backdate = strftime('%d %B %Y', strtotime($pegawai['tanggal_sp_backdate']));
                          $templateProcessor->setValue("tgl_surat", $tanggal_sp_backdate);
                        }
                        if ($tanggalBerangkat_1 == "0000-00-00") {
                          $templateProcessor->setValue("tglKeberangkatan_1", '');
                          $templateProcessor->setValue("tanggal_pulang_1", '');
                          $templateProcessor->setValue("tgl_kepulangan#1", $tanggal_pulang_1);
            
                        }else{
                          $templateProcessor->setValue("tglKeberangkatan_1", $tglKeberangkatan_1);
                          $templateProcessor->setValue("tanggal_pulang_1", $tanggal_pulang_1);
                          
                          if ($tanggalBerangkat_2 === "0000-00-00") {
                              if ($pegawai['lama_p_d'] == 1) {
                                  $templateProcessor->setValue("tgl_kepulangan_sp1", '');
                              } else {
                                  $templateProcessor->setValue("tgl_kepulangan_sp1", "sampai dengan " . $tanggal_pulang_2);
                              }
                              $templateProcessor->setValue("tgl_kepulangan1", $tanggal_pulang_1);
            
                          } else {
                              $templateProcessor->setValue("tgl_kepulangan_sp1", '');
                              $templateProcessor->setValue("tgl_kepulangan1", '');
            
                          }
                        
            
                        }
                        if ($tanggalBerangkat_2 == "0000-00-00") {
                          // var_dump($tanggalBerangkat_2);die();
            
                          $templateProcessor->setValue("tglKeberangkatan_2", '');
                          $templateProcessor->setValue("tanggal_pulang_2", '');
                          
                          $templateProcessor->setValue("tgl_kepulangan2", "");
                          if ($tanggalBerangkat_3 == "0000-00-00") {
                            if ($pegawai['lama_p_d'] == 1) {
                              $templateProcessor->setValue("tgl_kepulangan_sp2", '');
                            } else {
                                $templateProcessor->setValue("tgl_kepulangan_sp2", "sampai dengan " . $tanggal_pulang_2);
                            }
                          }else{
                            $templateProcessor->setValue("tgl_kepulangan_sp2", "sampai dengan " . $tanggal_pulang_3);
                          }
                        }else{
                          $templateProcessor->setValue("tglKeberangkatan_2", $tglKeberangkatan_2);
                          $templateProcessor->setValue("tanggal_pulang_2", $tanggal_pulang_2);
                          // var_dump($pegawai['lama_p_d']);die();
            
                          if ($tanggalBerangkat_3 == "0000-00-00") {
                            if ($pegawai['lama_p_d'] == 1) {
                              $templateProcessor->setValue("tgl_kepulangan_sp2", '');
                            } else {
                                $templateProcessor->setValue("tgl_kepulangan_sp2", "sampai dengan " . $tanggal_pulang_2);
                            }
                            $templateProcessor->setValue("tgl_kepulangan2", $tanggal_pulang_2);
            
                          }else{
                            $templateProcessor->setValue("tgl_kepulangan2", "");
                            $templateProcessor->setValue("tgl_kepulangan_sp2", "sampai dengan " . $tanggal_pulang_3);
                          }
            
                        }
                        if ($tanggalBerangkat_3 == "0000-00-00") {
                          $templateProcessor->setValue("tglKeberangkatan_3", '');
                          $templateProcessor->setValue("tanggal_pulang_3", '');
                          $templateProcessor->setValue("tgl_kepulangan3", "");
                          $templateProcessor->setValue("tgl_kepulangan_sp3", '');
                        }else{
                          $templateProcessor->setValue("tglKeberangkatan_3", $tglKeberangkatan_3);
                          $templateProcessor->setValue("tanggal_pulang_3", $tanggal_pulang_3);
                          $templateProcessor->setValue("tgl_kepulangan3", $tanggal_pulang_3);
                          $templateProcessor->setValue("tgl_kepulangan_sp3", '');
                        }
                        
                        // Sanitasi untuk srt_instansi_undangan agar aman untuk penggunaan dalam dokumen Word
                        $srtInstansiUndangan = htmlspecialchars($pegawai['srt_instansi_undangan'], ENT_QUOTES, 'UTF-8');
  
                        $kabupatenKota = ucwords(strtolower($pegawai['nama_tujuan'][0]->n_kabupaten));
                    
                        // Menetapkan nilai pada placeholder di template
                        $templateProcessor->setValue("jabatan", $pegawai['jabatan']);
                        $templateProcessor->setValue("ada", $srtInstansiUndangan);
                        $templateProcessor->setValue("mksd", $pegawai['mksd_pemberangkatan']);
                        $templateProcessor->setValue("kode_rekening_sub_keg", $pegawai['kode_rek_sub_req']);
                        $templateProcessor->setValue("srt_perihal_undangan", $pegawai['perihal_srt_undangan']);
                        $templateProcessor->setValue("srt_nmr_undangan", $pegawai['nmr_srt_undangan']);
                        $templateProcessor->setValue("tgl_srt_undangan", $pegawai['tgl_srt_undangan']);
                          $templateProcessor->setValue("tgl_srt_undangan#{$index}", $tgl_srt_undangan);

                        $location_details = [];
                        
                        if (!empty($detail_tempat_1) && isset($kab_kota_array[0])) {
                            $location_details[] = $detail_tempat_1 . ' ' . $kab_kota_array[0];
                        }
                        if (!empty($detail_tempat_2) && isset($kab_kota_array[1])) {
                            $location_details[] = $detail_tempat_2 . ' ' . $kab_kota_array[1];
                        }
                        if (!empty($detail_tempat_3) && isset($kab_kota_array[2])) {
                            $location_details[] = $detail_tempat_3 . ' ' . $kab_kota_array[2];
                        }
                        
                        $final_location_string = implode(', ', $location_details);
                        
                        $templateProcessor->setValue("brtmpt", $final_location_string);
                        $templateProcessor->setValue("lama_perdin", $pegawai['lama_p_d']);
                        $templateProcessor->setValue("tgl_keberangkatan", $tglKeberangkatan);
                        $templateProcessor->setValue("tgl_kepulangan", $tglKepulangan);
                        $templateProcessor->setValue("kabupaten_kota_bertempatan", $kabupatenKota);
                        $templateProcessor->setValue("kepada_nama", $pegawai['nama_pegawai']);
                        $templateProcessor->setValue("kode_rek", $pegawai['kode_rek']);
                        $templateProcessor->setValue("arahan_pimpinan", $pegawai['dasar_arahan_pimpiman']);
                        $templateProcessor->setValue("kode_tim", $kode_tim);
                        $templateProcessor->setValue("no_urut", $no_grup_perdin);
                        $templateProcessor->setValue("kendaraan", $pegawai['kendaraan']);
                        // Cek apakah nip ada, jika ada maka kolom nip akan muncul
                        if (!empty($pegawai['pangkat_gol']) && strtolower($pegawai['pangkat_gol']) != 'tenaga kontrak') {
                            $templateProcessor->setValue("nama_kolom_nip", 'Nomor Induk Pegawai');
                            $templateProcessor->setValue("nip", $pegawai['nip']);
                            $pangkatGolongan = (isset($pegawai['pangkat_gol']) && isset($pegawai['golongan']) && $pegawai['pangkat_gol'] !== '' && $pegawai['golongan'] !== '' && $pegawai['pangkat_gol'] !== 'Tenaga Kontrak') 
                            ? $pegawai['pangkat_gol'] . ' (' . $pegawai['golongan'] .')'
                            : 'Non ASN';
                
                
                                            $templateProcessor->setValue("Pangkat_golongan", $pangkatGolongan);
  
  
                        } else {
                          $templateProcessor->setValue("nama_kolom_nip#{$index}", 'Nomor Induk Pegawai');
                          $templateProcessor->setValue("nip#{$index}", '-');
                          $pangkatGolongan = (isset($pegawai['pangkat_gol']) && isset($pegawai['golongan']) && $pegawai['pangkat_gol'] !== '' && $pegawai['golongan'] !== '' && $pegawai['pangkat_gol'] !== 'Tenaga Kontrak') 
                          ? $pegawai['pangkat_gol'] . ' (' . $pegawai['golongan'] .')'
                          : 'Non ASN';
              
              
                                          $templateProcessor->setValue("Pangkat_golongan", $pangkatGolongan);
                        }
                        $templateProcessor->setValue("Pangkat_golongan_visum#{$index}", $pangkatGolongan);
  
                        $templateProcessor->setValue("jabatan", $pegawai['jabatan']); 
                        $templateProcessor->setValue("golongan", $pegawai['golongan']); 
  
                        if (count($kab_kota_array) == 1) {
                            $templateProcessor->setValue("tempat_tujuan#1", isset($kab_kota_array[0]) ? $kab_kota_array[0] . ' ' : '');
                            $templateProcessor->setValue("tempat_tujuan#2", isset($kab_kota_array[1]) ? $kab_kota_array[1] . ',' : '');
                            $templateProcessor->setValue("tempat_tujuan#3", isset($kab_kota_array[2]) ? $kab_kota_array[2] . ',' : '');
              
                            $templateProcessor->setValue("tempat_tujuan_1_kota#0", 'Kota Bandung');
                            $templateProcessor->setValue("tempat_tujuan_2_kota#0", '');
                            $templateProcessor->setValue("tempat_tujuan_3_kota#0", '');
                        }elseif(count($kab_kota_array) == 2){
                          $templateProcessor->setValue("tempat_tujuan#1", isset($kab_kota_array[0]) ? $kab_kota_array[0] . ',' : '');
                          $templateProcessor->setValue("tempat_tujuan#2", isset($kab_kota_array[1]) ? $kab_kota_array[1] . ' ' : '');
                          $templateProcessor->setValue("tempat_tujuan#3", isset($kab_kota_array[2]) ? $kab_kota_array[2] . ',' : '');
              
                          $templateProcessor->setValue("tempat_tujuan_1_kota#0", '');
                          $templateProcessor->setValue("tempat_tujuan_2_kota#0", 'Kota Bandung');
                          $templateProcessor->setValue("tempat_tujuan_3_kota#0", '');
                        }else{
                          $templateProcessor->setValue("tempat_tujuan#1", isset($kab_kota_array[0]) ? $kab_kota_array[0] . ',' : '');
                          $templateProcessor->setValue("tempat_tujuan#2", isset($kab_kota_array[1]) ? $kab_kota_array[1] . ',' : '');
                          $templateProcessor->setValue("tempat_tujuan#3", isset($kab_kota_array[2]) ? $kab_kota_array[2] . ' ' : '');
              
                          $templateProcessor->setValue("tempat_tujuan_1_kota#0", '');
                          $templateProcessor->setValue("tempat_tujuan_2_kota#0", '');
                          $templateProcessor->setValue("tempat_tujuan_3_kota#0", 'Kota Bandung');
                        }
                        $templateProcessor->deleteBlock('nomor_induk_pegawai_row');
  
                        
                    }
                    $filename_pa_sekdis = 'assets/file_surat_perdin/kadis_sekdis/SPPD_' . date('Ymd') . '_' . $no_grup_perdin . '_' . $kode_tim_file->kode_tim_ketua . '_sekdis.docx';
                    $filename_pa_sekdis_simpan = 'SPPD_' . date('Ymd') . '_' . $no_grup_perdin . '_' . $kode_tim_file->kode_tim_ketua . '_sekdis.docx';
                    $templateProcessor->saveAs($filename_pa_sekdis);
                    
  
                    $data = [
                        'file_srt' => $filename_pa_sekdis_simpan,
                    ];
                    $update_perdin = $this->m_perdin->update_e_perdin($pegawai['id_perdin'], $data);

                    // var_dump($filename_pa_sekdis);die();
                } else {
                    $templateFile = 'assets/file_surat_perdin/template_surat_perdin/surat_perintah_template_pa_sekdis.docx';
                    // Memproses file template yang dipilih
                    $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor($templateFile);

                    // Lanjutkan dengan pengisian data ke dalam template...

                    $arrblnRomawi = array("I","II","III","IV","V","VI",'VII','VIII','IX','X','XI','XII');
                    $blnRomawi = $arrblnRomawi[date("m")-1];
                    
                    // Pastikan menggunakan setlocale untuk format bahasa Indonesia
                    setlocale(LC_TIME, 'id_ID.utf8');

                    // Mendapatkan hari, tanggal, bulan, dan tahun
                    $hari_ttd = strftime('%A', time()); // Nama hari
                    $tgl_ttd = strftime('%d', time()); // Tanggal (angka)
                    $bln_ttd = strftime('%B', time()); // Nama bulan

                    // Ganti "Pebruari" menjadi "Februari"
                    $bln_ttd = str_replace("Pebruari", "Februari", $bln_ttd); // Nama bulan
                    $tahun_text = strftime('%Y', time()); // Tahun (angka)
                    // Membuat nomor random
                    $random_number = mt_rand(1000, 9999); // Nomor random 4 digit

                    // Mendapatkan tanggal hari ini dalam format DDMMYYYY
                    $tanggal_hari_ini = date('dmY');

                    // Menggabungkan semua elemen menjadi nomor dengan format yang diinginkan
                    $kode_tim = $kode_tim_file->kode_tim_ketua;
                    // var_dump($kode_tim);die();
                    foreach ($filtered_data as $index => $pegawai) {
                      // Hanya proses data dengan ID tertentu
                      // Menampilkan hasil yang sudah difilter
                      if ($pegawai['id_pegawai'] != 31) {
                          continue; // Lewati iterasi jika ID tidak sesuai
                      }
                      $tujuan_keberangkatan_perdin = $this->m_perdin->get_tujuan_keberangkatan_perdin($pegawai['no_grup_perdin'], $pegawai['id_tim']);

                      $kab_kota_array = [];
                      if (!empty($tujuan_keberangkatan_perdin)) {
                          foreach ($tujuan_keberangkatan_perdin as $rowlist) {
                              // Decode jika kab_kota dalam format JSON
                              $decoded = json_decode($rowlist->kab_kota, true);
                              if (is_array($decoded)) {
                                  $kab_kota_array = array_merge($kab_kota_array, $decoded); // Gabungkan jika array
                              } else {
                                  $kab_kota_array[] = $rowlist->kab_kota; // Tambahkan langsung jika bukan JSON
                              }
                          }
                      } else {
                          echo "No data available"; // Tampilkan pesan jika data kosong
                      }
                      $tujuan_keberangkatan_perdin = $this->m_perdin->get_tujuan_keberangkatan_perdin($pegawai['no_grup_perdin'], $pegawai['id_tim']);
                      
                      $tanggalBerangkat_1 = $tujuan_keberangkatan_perdin[0]->tanggal_berangkat_1;
                      $tanggalBerangkat_2 = $tujuan_keberangkatan_perdin[0]->tanggal_berangkat_2;
                      $tanggalBerangkat_3 = $tujuan_keberangkatan_perdin[0]->tanggal_berangkat_3;
            
                      $tanggal_pulang_1 = $tujuan_keberangkatan_perdin[0]->tanggal_pulang_1;
                      $tanggal_pulang_2 = $tujuan_keberangkatan_perdin[0]->tanggal_pulang_2;
                      $tanggal_pulang_3 = $tujuan_keberangkatan_perdin[0]->tanggal_pulang_3;
      
                      setlocale(LC_TIME, 'id_ID.UTF-8', 'Indonesian', 'id_ID');

                      // Format tanggal dengan strftime
                      // Format tanggal dengan strftime
                      $tanggal_pulang_1 = strftime('%d %B %Y', strtotime($tanggal_pulang_1));
                      if ($tanggal_pulang_2 == "0000-00-00") {
                        $tanggal_pulang_2 = '';
                      } else {
                        // Format the date only if it's a valid date
                        $tanggal_pulang_2 = strftime('%d %B %Y', strtotime($tanggal_pulang_2));
                      }
          
                      // Check if $tanggal_pulang_3 is "0000-00-00" and set it to an empty string if true
                      if ($tanggal_pulang_3 == "0000-00-00") {
                        $tanggal_pulang_3 = '';
                      } else {
                        // Format the date only if it's a valid date
                        $tanggal_pulang_3 = strftime('%d %B %Y', strtotime($tanggal_pulang_3));
                      }

                      $tglKeberangkatan_1 = strftime('%d %B %Y', strtotime($tanggalBerangkat_1));
                      $tglKeberangkatan_2 = strftime('%d %B %Y', strtotime($tanggalBerangkat_2));
                      $tglKeberangkatan_3 = strftime('%d %B %Y', strtotime($tanggalBerangkat_3));

                      // Ganti "Pebruari" menjadi "Februari"
                      $bulan_salah = 'Pebruari';
                      $bulan_benar = 'Februari';

                      $tanggal_pulang_1 = str_replace($bulan_salah, $bulan_benar, $tanggal_pulang_1);
                      $tanggal_pulang_2 = str_replace($bulan_salah, $bulan_benar, $tanggal_pulang_2);
                      $tanggal_pulang_3 = str_replace($bulan_salah, $bulan_benar, $tanggal_pulang_3);

                      $tglKeberangkatan_1 = str_replace($bulan_salah, $bulan_benar, $tglKeberangkatan_1);
                      $tglKeberangkatan_2 = str_replace($bulan_salah, $bulan_benar, $tglKeberangkatan_2);
                      $tglKeberangkatan_3 = str_replace($bulan_salah, $bulan_benar, $tglKeberangkatan_3);
                      // Format tanggal dengan strftime
                      $tglKeberangkatan = strftime('%d %B %Y', strtotime($pegawai['tanggal_berangkat']));
                      $tglKepulangan = strftime('%d %B %Y', strtotime($pegawai['tanggal_kembali']));

                      // Pastikan "Februari" ditulis dengan 'F' bukan 'P'
                      $tglKeberangkatan = str_replace('Pebruari', 'Februari', $tglKeberangkatan);
                      $tglKepulangan = str_replace('Pebruari', 'Februari', $tglKepulangan);
                      // var_dump($tglKeberangkatan);die();

                      // var_dump($pegawai['tanggal_sp_backdate']);die();
                      if ($pegawai['tanggal_sp_backdate'] == '0000-00-00' || $pegawai['tanggal_sp_backdate'] === false) {

                      }else{
                        $tanggal_sp_backdate = strftime('%d %B %Y', strtotime($pegawai['tanggal_sp_backdate']));
                        $templateProcessor->setValue("tgl_surat", $tanggal_sp_backdate);
                      }
                      if ($tanggalBerangkat_1 == "0000-00-00") {
                        $templateProcessor->setValue("tglKeberangkatan_1", '');
                        $templateProcessor->setValue("tanggal_pulang_1", '');
                        $templateProcessor->setValue("tgl_kepulangan#1", $tanggal_pulang_1);
          
                      }else{
                        $templateProcessor->setValue("tglKeberangkatan_1", $tglKeberangkatan_1);
                        $templateProcessor->setValue("tanggal_pulang_1", $tanggal_pulang_1);
                        
                        if ($tanggalBerangkat_2 === "0000-00-00") {
                            if ($pegawai['lama_p_d'] == 1) {
                                $templateProcessor->setValue("tgl_kepulangan_sp1", '');
                            } else {
                                $templateProcessor->setValue("tgl_kepulangan_sp1", "sampai dengan " . $tanggal_pulang_2);
                            }
                            $templateProcessor->setValue("tgl_kepulangan1", $tanggal_pulang_1);
          
                        } else {
                            $templateProcessor->setValue("tgl_kepulangan_sp1", '');
                            $templateProcessor->setValue("tgl_kepulangan1", '');
          
                        }
                      
          
                      }
                      if ($tanggalBerangkat_2 == "0000-00-00") {
                        // var_dump($tanggalBerangkat_2);die();
          
                        $templateProcessor->setValue("tglKeberangkatan_2", '');
                        $templateProcessor->setValue("tanggal_pulang_2", '');
                        
                        $templateProcessor->setValue("tgl_kepulangan2", "");
                        if ($tanggalBerangkat_3 == "0000-00-00") {
                          if ($pegawai['lama_p_d'] == 1) {
                            $templateProcessor->setValue("tgl_kepulangan_sp2", '');
                          } else {
                              $templateProcessor->setValue("tgl_kepulangan_sp2", "sampai dengan " . $tanggal_pulang_2);
                          }
                        }else{
                          $templateProcessor->setValue("tgl_kepulangan_sp2", "sampai dengan " . $tanggal_pulang_3);
                        }
                      }else{
                        $templateProcessor->setValue("tglKeberangkatan_2", $tglKeberangkatan_2);
                        $templateProcessor->setValue("tanggal_pulang_2", $tanggal_pulang_2);
                        // var_dump($pegawai['lama_p_d']);die();
          
                        if ($tanggalBerangkat_3 == "0000-00-00") {
                          if ($pegawai['lama_p_d'] == 1) {
                            $templateProcessor->setValue("tgl_kepulangan_sp2", '');
                          } else {
                              $templateProcessor->setValue("tgl_kepulangan_sp2", "sampai dengan " . $tanggal_pulang_2);
                          }
                          $templateProcessor->setValue("tgl_kepulangan2", $tanggal_pulang_2);
          
                        }else{
                          $templateProcessor->setValue("tgl_kepulangan2", "");
                          $templateProcessor->setValue("tgl_kepulangan_sp2", "sampai dengan " . $tanggal_pulang_3);
                        }
          
                      }
                      if ($tanggalBerangkat_3 == "0000-00-00") {
                        $templateProcessor->setValue("tglKeberangkatan_3", '');
                        $templateProcessor->setValue("tanggal_pulang_3", '');
                        $templateProcessor->setValue("tgl_kepulangan3", "");
                        $templateProcessor->setValue("tgl_kepulangan_sp3", '');
                      }else{
                        $templateProcessor->setValue("tglKeberangkatan_3", $tglKeberangkatan_3);
                        $templateProcessor->setValue("tanggal_pulang_3", $tanggal_pulang_3);
                        $templateProcessor->setValue("tgl_kepulangan3", $tanggal_pulang_3);
                        $templateProcessor->setValue("tgl_kepulangan_sp3", '');
                      }
                    
                      
                      // Sanitasi untuk srt_instansi_undangan agar aman untuk penggunaan dalam dokumen Word
                      $srtInstansiUndangan = htmlspecialchars($pegawai['srt_instansi_undangan'], ENT_QUOTES, 'UTF-8');

                      $kabupatenKota = ucwords(strtolower($pegawai['nama_tujuan'][0]->n_kabupaten));
                  
                      // Menetapkan nilai pada placeholder di template
                      $templateProcessor->setValue("jabatan", $pegawai['jabatan']);
                      $templateProcessor->setValue("ada", $srtInstansiUndangan);
                      $templateProcessor->setValue("mksd", $pegawai['mksd_pemberangkatan']);
                      $templateProcessor->setValue("kode_rekening_sub_keg", $pegawai['kode_rek_sub_req']);
                      $templateProcessor->setValue("srt_perihal_undangan", $pegawai['perihal_srt_undangan']);
                      $templateProcessor->setValue("srt_nmr_undangan", $pegawai['nmr_srt_undangan']);
                      $templateProcessor->setValue("tgl_srt_undangan", $pegawai['tgl_srt_undangan']);
                        $templateProcessor->setValue("tgl_srt_undangan#{$index}", $tgl_srt_undangan);

                      $location_details = [];
                      
                      if (!empty($detail_tempat_1) && isset($kab_kota_array[0])) {
                          $location_details[] = $detail_tempat_1 . ' ' . $kab_kota_array[0];
                      }
                      if (!empty($detail_tempat_2) && isset($kab_kota_array[1])) {
                          $location_details[] = $detail_tempat_2 . ' ' . $kab_kota_array[1];
                      }
                      if (!empty($detail_tempat_3) && isset($kab_kota_array[2])) {
                          $location_details[] = $detail_tempat_3 . ' ' . $kab_kota_array[2];
                      }
                      
                      $final_location_string = implode(', ', $location_details);
                      
                      $templateProcessor->setValue("brtmpt", $final_location_string);
                      $templateProcessor->setValue("lama_perdin", $pegawai['lama_p_d']);
                      $templateProcessor->setValue("tgl_keberangkatan", $tglKeberangkatan);
                      $templateProcessor->setValue("tgl_kepulangan", $tglKepulangan);
                      $templateProcessor->setValue("kabupaten_kota_bertempatan", $kabupatenKota);
                      $templateProcessor->setValue("kepada_nama", $pegawai['nama_pegawai']);
                      $templateProcessor->setValue("kode_rek", $pegawai['kode_rek']);
                      $templateProcessor->setValue("arahan_pimpinan", $pegawai['dasar_arahan_pimpiman']);
                      $templateProcessor->setValue("kode_tim", $kode_tim);
                      $templateProcessor->setValue("no_urut", $no_grup_perdin);
                      $templateProcessor->setValue("kendaraan", $pegawai['kendaraan']);
                      // Cek apakah nip ada, jika ada maka kolom nip akan muncul
                      if (!empty($pegawai['pangkat_gol']) && strtolower($pegawai['pangkat_gol']) != 'tenaga kontrak') {
                          $templateProcessor->setValue("nama_kolom_nip", 'Nomor Induk Pegawai');
                          $templateProcessor->setValue("nip", $pegawai['nip']);
                          $pangkatGolongan = (isset($pegawai['pangkat_gol']) && isset($pegawai['golongan']) && $pegawai['pangkat_gol'] !== '' && $pegawai['golongan'] !== '' && $pegawai['pangkat_gol'] !== 'Tenaga Kontrak') 
                          ? $pegawai['pangkat_gol'] . ' (' . $pegawai['golongan'] .')'
                          : 'Non ASN';
              
              
                                          $templateProcessor->setValue("Pangkat_golongan", $pangkatGolongan);


                      } else {
                        $templateProcessor->setValue("nama_kolom_nip#{$index}", 'Nomor Induk Pegawai');
                        $templateProcessor->setValue("nip#{$index}", '-');
                        $pangkatGolongan = (isset($pegawai['pangkat_gol']) && isset($pegawai['golongan']) && $pegawai['pangkat_gol'] !== '' && $pegawai['golongan'] !== '' && $pegawai['pangkat_gol'] !== 'Tenaga Kontrak') 
                        ? $pegawai['pangkat_gol'] . ' (' . $pegawai['golongan'] .')'
                        : 'Non ASN';
            
            
                                        $templateProcessor->setValue("Pangkat_golongan", $pangkatGolongan);
                      }
                      $templateProcessor->setValue("Pangkat_golongan_visum#{$index}", $pangkatGolongan);

                      $templateProcessor->setValue("jabatan", $pegawai['jabatan']); 
                      $templateProcessor->setValue("golongan", $pegawai['golongan']); 

                      if (count($kab_kota_array) == 1) {
                          $templateProcessor->setValue("tempat_tujuan#1", isset($kab_kota_array[0]) ? $kab_kota_array[0] . ' ' : '');
                          $templateProcessor->setValue("tempat_tujuan#2", isset($kab_kota_array[1]) ? $kab_kota_array[1] . ',' : '');
                          $templateProcessor->setValue("tempat_tujuan#3", isset($kab_kota_array[2]) ? $kab_kota_array[2] . ',' : '');
            
                          $templateProcessor->setValue("tempat_tujuan_1_kota#0", 'Kota Bandung');
                          $templateProcessor->setValue("tempat_tujuan_2_kota#0", '');
                          $templateProcessor->setValue("tempat_tujuan_3_kota#0", '');
                      }elseif(count($kab_kota_array) == 2){
                        $templateProcessor->setValue("tempat_tujuan#1", isset($kab_kota_array[0]) ? $kab_kota_array[0] . ',' : '');
                        $templateProcessor->setValue("tempat_tujuan#2", isset($kab_kota_array[1]) ? $kab_kota_array[1] . ' ' : '');
                        $templateProcessor->setValue("tempat_tujuan#3", isset($kab_kota_array[2]) ? $kab_kota_array[2] . ',' : '');
            
                        $templateProcessor->setValue("tempat_tujuan_1_kota#0", '');
                        $templateProcessor->setValue("tempat_tujuan_2_kota#0", 'Kota Bandung');
                        $templateProcessor->setValue("tempat_tujuan_3_kota#0", '');
                      }else{
                        $templateProcessor->setValue("tempat_tujuan#1", isset($kab_kota_array[0]) ? $kab_kota_array[0] . ',' : '');
                        $templateProcessor->setValue("tempat_tujuan#2", isset($kab_kota_array[1]) ? $kab_kota_array[1] . ',' : '');
                        $templateProcessor->setValue("tempat_tujuan#3", isset($kab_kota_array[2]) ? $kab_kota_array[2] . ' ' : '');
            
                        $templateProcessor->setValue("tempat_tujuan_1_kota#0", '');
                        $templateProcessor->setValue("tempat_tujuan_2_kota#0", '');
                        $templateProcessor->setValue("tempat_tujuan_3_kota#0", 'Kota Bandung');
                      }
                      $templateProcessor->deleteBlock('nomor_induk_pegawai_row');

                      
                  }
                  $filename_pa_sekdis = 'assets/file_surat_perdin/kadis_sekdis/SPPD_' . date('Ymd') . '_' . $no_grup_perdin . '_' . $kode_tim_file->kode_tim_ketua . '_sekdis.docx';
                  $filename_pa_sekdis_simpan = 'SPPD_' . date('Ymd') . '_' . $no_grup_perdin . '_' . $kode_tim_file->kode_tim_ketua . '_sekdis.docx';
                  $templateProcessor->saveAs($filename_pa_sekdis);
                  

                  $data = [
                      'file_srt' => $filename_pa_sekdis_simpan,
                  ];
                  $update_perdin = $this->m_perdin->update_e_perdin($pegawai['id_perdin'], $data);
                }
              } 
              if (in_array("1152", $pkepada)) {
                $filtered_data_bu_kadis = array_filter($data_pegawai, function($item) {
                    return $item['id_pegawai'] == 1152;
                });
                if ($tipe_undangan == 1) {
                    $templateFile = 'assets/file_surat_perdin/template_surat_perdin/surat_perintah_template_bu_kadis.docx';
                     // Memproses file template yang dipilih
                    $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor($templateFile);

                    // Lanjutkan dengan pengisian data ke dalam template...

                    $arrblnRomawi = array("I","II","III","IV","V","VI",'VII','VIII','IX','X','XI','XII');
                    $blnRomawi = $arrblnRomawi[date("m")-1];
                    
                    // Pastikan menggunakan setlocale untuk format bahasa Indonesia
                    setlocale(LC_TIME, 'id_ID.utf8');

                    // Mendapatkan hari, tanggal, bulan, dan tahun
                    $hari_ttd = strftime('%A', time()); // Nama hari
                    $tgl_ttd = strftime('%d', time()); // Tanggal (angka)
                    $bln_ttd = strftime('%B', time()); // Nama bulan

                    // Ganti "Pebruari" menjadi "Februari"
                    $bln_ttd = str_replace("Pebruari", "Februari", $bln_ttd); // Nama bulan
                    $tahun_text = strftime('%Y', time()); // Tahun (angka)
                    // Membuat nomor random
                    $random_number = mt_rand(1000, 9999); // Nomor random 4 digit

                    // Mendapatkan tanggal hari ini dalam format DDMMYYYY
                    $tanggal_hari_ini = date('dmY');

                    // Menggabungkan semua elemen menjadi nomor dengan format yang diinginkan
                    $kode_tim = $kode_tim_file->kode_tim_ketua;
                      foreach ($filtered_data_bu_kadis as $index => $pegawai) {
                        // Hanya proses data dengan ID tertentu
                        if ($pegawai['id_pegawai'] != 1152) {
                            continue; // Lewati iterasi jika ID tidak sesuai
                        }
                        //  var_dump($pegawai);die();

                        $tujuan_keberangkatan_perdin = $this->m_perdin->get_tujuan_keberangkatan_perdin($pegawai['no_grup_perdin'], $pegawai['id_tim']);

                        $kab_kota_array = [];
                        if (!empty($tujuan_keberangkatan_perdin)) {
                            foreach ($tujuan_keberangkatan_perdin as $rowlist) {
                                // Decode jika kab_kota dalam format JSON
                                $decoded = json_decode($rowlist->kab_kota, true);
                                if (is_array($decoded)) {
                                    $kab_kota_array = array_merge($kab_kota_array, $decoded); // Gabungkan jika array
                                } else {
                                    $kab_kota_array[] = $rowlist->kab_kota; // Tambahkan langsung jika bukan JSON
                                }
                            }
                        } else {
                            echo "No data available"; // Tampilkan pesan jika data kosong
                        }
                        $tujuan_keberangkatan_perdin = $this->m_perdin->get_tujuan_keberangkatan_perdin($pegawai['no_grup_perdin'], $pegawai['id_tim']);
                        
                        $tanggalBerangkat_1 = $tujuan_keberangkatan_perdin[0]->tanggal_berangkat_1;
                        $tanggalBerangkat_2 = $tujuan_keberangkatan_perdin[0]->tanggal_berangkat_2;
                        $tanggalBerangkat_3 = $tujuan_keberangkatan_perdin[0]->tanggal_berangkat_3;
              
                        $tanggal_pulang_1 = $tujuan_keberangkatan_perdin[0]->tanggal_pulang_1;
                        $tanggal_pulang_2 = $tujuan_keberangkatan_perdin[0]->tanggal_pulang_2;
                        $tanggal_pulang_3 = $tujuan_keberangkatan_perdin[0]->tanggal_pulang_3;
        
                        setlocale(LC_TIME, 'id_ID.UTF-8', 'Indonesian', 'id_ID');

                        // Format tanggal dengan strftime
                        // Format tanggal dengan strftime
                        $tanggal_pulang_1 = strftime('%d %B %Y', strtotime($tanggal_pulang_1));
                        if ($tanggal_pulang_2 == "0000-00-00") {
                          $tanggal_pulang_2 = '';
                        } else {
                          // Format the date only if it's a valid date
                          $tanggal_pulang_2 = strftime('%d %B %Y', strtotime($tanggal_pulang_2));
                        }
            
                        // Check if $tanggal_pulang_3 is "0000-00-00" and set it to an empty string if true
                        if ($tanggal_pulang_3 == "0000-00-00") {
                          $tanggal_pulang_3 = '';
                        } else {
                          // Format the date only if it's a valid date
                          $tanggal_pulang_3 = strftime('%d %B %Y', strtotime($tanggal_pulang_3));
                        }

                        $tglKeberangkatan_1 = strftime('%d %B %Y', strtotime($tanggalBerangkat_1));
                        $tglKeberangkatan_2 = strftime('%d %B %Y', strtotime($tanggalBerangkat_2));
                        $tglKeberangkatan_3 = strftime('%d %B %Y', strtotime($tanggalBerangkat_3));

                        // Ganti "Pebruari" menjadi "Februari"
                        $bulan_salah = 'Pebruari';
                        $bulan_benar = 'Februari';

                        $tanggal_pulang_1 = str_replace($bulan_salah, $bulan_benar, $tanggal_pulang_1);
                        $tanggal_pulang_2 = str_replace($bulan_salah, $bulan_benar, $tanggal_pulang_2);
                        $tanggal_pulang_3 = str_replace($bulan_salah, $bulan_benar, $tanggal_pulang_3);

                        $tglKeberangkatan_1 = str_replace($bulan_salah, $bulan_benar, $tglKeberangkatan_1);
                        $tglKeberangkatan_2 = str_replace($bulan_salah, $bulan_benar, $tglKeberangkatan_2);
                        $tglKeberangkatan_3 = str_replace($bulan_salah, $bulan_benar, $tglKeberangkatan_3);
                        // Format tanggal dengan strftime
                        $tglKeberangkatan = strftime('%d %B %Y', strtotime($pegawai['tanggal_berangkat']));
                        $tglKepulangan = strftime('%d %B %Y', strtotime($pegawai['tanggal_kembali']));

                        // Pastikan "Februari" ditulis dengan 'F' bukan 'P'
                        $tglKeberangkatan = str_replace('Pebruari', 'Februari', $tglKeberangkatan);
                        $tglKepulangan = str_replace('Pebruari', 'Februari', $tglKepulangan);
                        // var_dump($tglKeberangkatan);die();
                        if ($tanggalBerangkat_1 == "0000-00-00") {
                          $templateProcessor->setValue("tglKeberangkatan_1", '');
                          $templateProcessor->setValue("tanggal_pulang_1", '');
                          $templateProcessor->setValue("tgl_kepulangan#1", $tanggal_pulang_1);
            
                        }else{
                          $templateProcessor->setValue("tglKeberangkatan_1", $tglKeberangkatan_1);
                          $templateProcessor->setValue("tanggal_pulang_1", $tanggal_pulang_1);
                          
                          if ($tanggalBerangkat_2 === "0000-00-00") {
                              if ($pegawai['lama_p_d'] == 1) {
                                  $templateProcessor->setValue("tgl_kepulangan_sp1", '');
                              } else {
                                  $templateProcessor->setValue("tgl_kepulangan_sp1", "sampai dengan " . $tanggal_pulang_2);
                              }
                              $templateProcessor->setValue("tgl_kepulangan1", $tanggal_pulang_1);
            
                          } else {
                              $templateProcessor->setValue("tgl_kepulangan_sp1", '');
                              $templateProcessor->setValue("tgl_kepulangan1", '');
            
                          }
                        
            
                        }
                        if ($tanggalBerangkat_2 == "0000-00-00") {
                          // var_dump($tanggalBerangkat_2);die();
            
                          $templateProcessor->setValue("tglKeberangkatan_2", '');
                          $templateProcessor->setValue("tanggal_pulang_2", '');
                          
                          $templateProcessor->setValue("tgl_kepulangan2", "");
                          if ($tanggalBerangkat_3 == "0000-00-00") {
                            if ($pegawai['lama_p_d'] == 1) {
                              $templateProcessor->setValue("tgl_kepulangan_sp2", '');
                            } else {
                                $templateProcessor->setValue("tgl_kepulangan_sp2", "sampai dengan " . $tanggal_pulang_2);
                            }
                          }else{
                            $templateProcessor->setValue("tgl_kepulangan_sp2", "sampai dengan " . $tanggal_pulang_3);
                          }
                        }else{
                          $templateProcessor->setValue("tglKeberangkatan_2", $tglKeberangkatan_2);
                          $templateProcessor->setValue("tanggal_pulang_2", $tanggal_pulang_2);
                          // var_dump($pegawai['lama_p_d']);die();
            
                          if ($tanggalBerangkat_3 == "0000-00-00") {
                            if ($pegawai['lama_p_d'] == 1) {
                              $templateProcessor->setValue("tgl_kepulangan_sp2", '');
                            } else {
                                $templateProcessor->setValue("tgl_kepulangan_sp2", "sampai dengan " . $tanggal_pulang_2);
                            }
                            $templateProcessor->setValue("tgl_kepulangan2", $tanggal_pulang_2);
            
                          }else{
                            $templateProcessor->setValue("tgl_kepulangan2", "");
                            $templateProcessor->setValue("tgl_kepulangan_sp2", "sampai dengan " . $tanggal_pulang_3);
                          }
            
                        }
                        if ($tanggalBerangkat_3 == "0000-00-00") {
                          $templateProcessor->setValue("tglKeberangkatan_3", '');
                          $templateProcessor->setValue("tanggal_pulang_3", '');
                          $templateProcessor->setValue("tgl_kepulangan3", "");
                          $templateProcessor->setValue("tgl_kepulangan_sp3", '');
                        }else{
                          $templateProcessor->setValue("tglKeberangkatan_3", $tglKeberangkatan_3);
                          $templateProcessor->setValue("tanggal_pulang_3", $tanggal_pulang_3);
                          $templateProcessor->setValue("tgl_kepulangan3", $tanggal_pulang_3);
                          $templateProcessor->setValue("tgl_kepulangan_sp3", '');
                        }
                      
                        
                        // Sanitasi untuk srt_instansi_undangan agar aman untuk penggunaan dalam dokumen Word
                        $srtInstansiUndangan = htmlspecialchars($pegawai['srt_instansi_undangan'], ENT_QUOTES, 'UTF-8');

                        $kabupatenKota = ucwords(strtolower($pegawai['nama_tujuan'][0]->n_kabupaten));
                    
                        // Menetapkan nilai pada placeholder di template
                        $templateProcessor->setValue("jabatan", $pegawai['jabatan']);
                        $templateProcessor->setValue("ada", $srtInstansiUndangan);
                        $templateProcessor->setValue("mksd", $pegawai['mksd_pemberangkatan']);
                        $templateProcessor->setValue("kode_rekening_sub_keg", $pegawai['kode_rek_sub_req']);
                        $templateProcessor->setValue("srt_perihal_undangan", $pegawai['perihal_srt_undangan']);
                        $templateProcessor->setValue("srt_nmr_undangan", $pegawai['nmr_srt_undangan']);
                        $templateProcessor->setValue("tgl_srt_undangan", $pegawai['tgl_srt_undangan']);
                          $templateProcessor->setValue("tgl_srt_undangan#{$index}", $tgl_srt_undangan);

                        $location_details = [];
                        
                        if (!empty($detail_tempat_1) && isset($kab_kota_array[0])) {
                            $location_details[] = $detail_tempat_1 . ' ' . $kab_kota_array[0];
                        }
                        if (!empty($detail_tempat_2) && isset($kab_kota_array[1])) {
                            $location_details[] = $detail_tempat_2 . ' ' . $kab_kota_array[1];
                        }
                        if (!empty($detail_tempat_3) && isset($kab_kota_array[2])) {
                            $location_details[] = $detail_tempat_3 . ' ' . $kab_kota_array[2];
                        }
                        
                        $final_location_string = implode(', ', $location_details);
                        
                        $templateProcessor->setValue("brtmpt", $final_location_string);
                        $templateProcessor->setValue("lama_perdin", $pegawai['lama_p_d']);
                        $templateProcessor->setValue("tgl_keberangkatan", $tglKeberangkatan);
                        $templateProcessor->setValue("tgl_kepulangan", $tglKepulangan);
                        $templateProcessor->setValue("kabupaten_kota_bertempatan", $kabupatenKota);
                        $templateProcessor->setValue("kepada_nama", $pegawai['nama_pegawai']);
                        $templateProcessor->setValue("kode_rek", $pegawai['kode_rek']);
                        $templateProcessor->setValue("arahan_pimpinan", $pegawai['dasar_arahan_pimpiman']);
                        $templateProcessor->setValue("kode_tim", $kode_tim);
                        $templateProcessor->setValue("no_urut", $no_grup_perdin);
                        $templateProcessor->setValue("kendaraan", $pegawai['kendaraan']);
                        // Cek apakah nip ada, jika ada maka kolom nip akan muncul
                        if (!empty($pegawai['pangkat_gol']) && strtolower($pegawai['pangkat_gol']) != 'tenaga kontrak') {
                            $templateProcessor->setValue("nama_kolom_nip", 'Nomor Induk Pegawai');
                            $templateProcessor->setValue("nip", $pegawai['nip']);
                            $pangkatGolongan = (isset($pegawai['pangkat_gol']) && isset($pegawai['golongan']) && $pegawai['pangkat_gol'] !== '' && $pegawai['golongan'] !== '' && $pegawai['pangkat_gol'] !== 'Tenaga Kontrak') 
                            ? $pegawai['pangkat_gol'] . ' (' . $pegawai['golongan'] .')'
                            : 'Non ASN';
                
                
                                            $templateProcessor->setValue("Pangkat_golongan", $pangkatGolongan);


                        } else {
                          $templateProcessor->setValue("nama_kolom_nip#{$index}", 'Nomor Induk Pegawai');
                          $templateProcessor->setValue("nip#{$index}", '-');
                          $pangkatGolongan = (isset($pegawai['pangkat_gol']) && isset($pegawai['golongan']) && $pegawai['pangkat_gol'] !== '' && $pegawai['golongan'] !== '' && $pegawai['pangkat_gol'] !== 'Tenaga Kontrak') 
                          ? $pegawai['pangkat_gol'] . ' (' . $pegawai['golongan'] .')'
                          : 'Non ASN';
              
              
                                          $templateProcessor->setValue("Pangkat_golongan", $pangkatGolongan);
                        }
                        $templateProcessor->setValue("Pangkat_golongan_visum#{$index}", $pangkatGolongan);

                        $templateProcessor->setValue("jabatan", $pegawai['jabatan']); 
                        $templateProcessor->setValue("golongan", $pegawai['golongan']); 

                        if (count($kab_kota_array) == 1) {
                            $templateProcessor->setValue("tempat_tujuan#1", isset($kab_kota_array[0]) ? $kab_kota_array[0] . ' ' : '');
                            $templateProcessor->setValue("tempat_tujuan#2", isset($kab_kota_array[1]) ? $kab_kota_array[1] . ',' : '');
                            $templateProcessor->setValue("tempat_tujuan#3", isset($kab_kota_array[2]) ? $kab_kota_array[2] . ',' : '');
              
                            $templateProcessor->setValue("tempat_tujuan_1_kota#0", 'Kota Bandung');
                            $templateProcessor->setValue("tempat_tujuan_2_kota#0", '');
                            $templateProcessor->setValue("tempat_tujuan_3_kota#0", '');
                        }elseif(count($kab_kota_array) == 2){
                          $templateProcessor->setValue("tempat_tujuan#1", isset($kab_kota_array[0]) ? $kab_kota_array[0] . ',' : '');
                          $templateProcessor->setValue("tempat_tujuan#2", isset($kab_kota_array[1]) ? $kab_kota_array[1] . ' ' : '');
                          $templateProcessor->setValue("tempat_tujuan#3", isset($kab_kota_array[2]) ? $kab_kota_array[2] . ',' : '');
              
                          $templateProcessor->setValue("tempat_tujuan_1_kota#0", '');
                          $templateProcessor->setValue("tempat_tujuan_2_kota#0", 'Kota Bandung');
                          $templateProcessor->setValue("tempat_tujuan_3_kota#0", '');
                        }else{
                          $templateProcessor->setValue("tempat_tujuan#1", isset($kab_kota_array[0]) ? $kab_kota_array[0] . ',' : '');
                          $templateProcessor->setValue("tempat_tujuan#2", isset($kab_kota_array[1]) ? $kab_kota_array[1] . ',' : '');
                          $templateProcessor->setValue("tempat_tujuan#3", isset($kab_kota_array[2]) ? $kab_kota_array[2] . ' ' : '');
              
                          $templateProcessor->setValue("tempat_tujuan_1_kota#0", '');
                          $templateProcessor->setValue("tempat_tujuan_2_kota#0", '');
                          $templateProcessor->setValue("tempat_tujuan_3_kota#0", 'Kota Bandung');
                        }
                        $templateProcessor->deleteBlock('nomor_induk_pegawai_row');

                        
                     

                        $filename_bukadis = 'assets/file_surat_perdin/kadis_sekdis/SPPD_' . date('Ymd') . '_' . $no_grup_perdin . '_' . $kode_tim_file->kode_tim_ketua . '_kadis.docx';
                        $filename_bukadis_simpan = 'SPPD_' . date('Ymd') . '_' . $no_grup_perdin . '_' . $kode_tim_file->kode_tim_ketua . '_kadis.docx';
                        
                        $data = [
                            'file_srt' => $filename_bukadis_simpan,
                        ];
                        $update_perdin = $this->m_perdin->update_e_perdin($pegawai['id_perdin'], $data);

                        $templateProcessor->saveAs($filename_bukadis);
                      }
                        $templateFile = 'assets/file_surat_perdin/template_surat_perdin/visum_kadis.docx';
                        // Memproses file template yang dipilih
  
                        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor($templateFile);
  
                        // Lanjutkan dengan pengisian data ke dalam template...
  
                        $arrblnRomawi = array("I","II","III","IV","V","VI",'VII','VIII','IX','X','XI','XII');
                        $blnRomawi = $arrblnRomawi[date("m")-1];
                        
                        // Pastikan menggunakan setlocale untuk format bahasa Indonesia
                        setlocale(LC_TIME, 'id_ID.utf8');
  
                        // Mendapatkan hari, tanggal, bulan, dan tahun
                        $hari_ttd = strftime('%A', time()); // Nama hari
                        $tgl_ttd = strftime('%d', time()); // Tanggal (angka)
                        $bln_ttd = strftime('%B', time()); // Nama bulan

                        // Ganti "Pebruari" menjadi "Februari"
                        $bln_ttd = str_replace("Pebruari", "Februari", $bln_ttd); // Nama bulan
                        $tahun_text = strftime('%Y', time()); // Tahun (angka)
                        // Membuat nomor random
                        $random_number = mt_rand(1000, 9999); // Nomor random 4 digit
  
                        // Mendapatkan tanggal hari ini dalam format DDMMYYYY
                        $tanggal_hari_ini = date('dmY');
  
                        // Menggabungkan semua elemen menjadi nomor dengan format yang diinginkan
                        $nomor_format = $random_number . '/LKK/kemitraan/' . $tanggal_hari_ini;
  
                        foreach ($filtered_data_bu_kadis as $index => $pegawai) {
                          // Hanya proses data dengan ID tertentu
                          if ($pegawai['id_pegawai'] != 1152) {
                              continue; // Lewati iterasi jika ID tidak sesuai
                          }
                          //  var_dump($pegawai);die();
  
                          $tujuan_keberangkatan_perdin = $this->m_perdin->get_tujuan_keberangkatan_perdin($pegawai['no_grup_perdin'], $pegawai['id_tim']);
  
                          $kab_kota_array = [];
                          if (!empty($tujuan_keberangkatan_perdin)) {
                              foreach ($tujuan_keberangkatan_perdin as $rowlist) {
                                  // Decode jika kab_kota dalam format JSON
                                  $decoded = json_decode($rowlist->kab_kota, true);
                                  if (is_array($decoded)) {
                                      $kab_kota_array = array_merge($kab_kota_array, $decoded); // Gabungkan jika array
                                  } else {
                                      $kab_kota_array[] = $rowlist->kab_kota; // Tambahkan langsung jika bukan JSON
                                  }
                              }
                          } else {
                              echo "No data available"; // Tampilkan pesan jika data kosong
                          }
                          $tujuan_keberangkatan_perdin = $this->m_perdin->get_tujuan_keberangkatan_perdin($pegawai['no_grup_perdin'], $pegawai['id_tim']);
                          
                          $tanggalBerangkat_1 = $tujuan_keberangkatan_perdin[0]->tanggal_berangkat_1;
                          $tanggalBerangkat_2 = $tujuan_keberangkatan_perdin[0]->tanggal_berangkat_2;
                          $tanggalBerangkat_3 = $tujuan_keberangkatan_perdin[0]->tanggal_berangkat_3;
                
                          $tanggal_pulang_1 = $tujuan_keberangkatan_perdin[0]->tanggal_pulang_1;
                          $tanggal_pulang_2 = $tujuan_keberangkatan_perdin[0]->tanggal_pulang_2;
                          $tanggal_pulang_3 = $tujuan_keberangkatan_perdin[0]->tanggal_pulang_3;
          
                          setlocale(LC_TIME, 'id_ID.UTF-8', 'Indonesian', 'id_ID');
  
                          // Format tanggal dengan strftime
                          // Format tanggal dengan strftime
                          $tanggal_pulang_1 = strftime('%d %B %Y', strtotime($tanggal_pulang_1));
                          if ($tanggal_pulang_2 == "0000-00-00") {
                            $tanggal_pulang_2 = '';
                          } else {
                            // Format the date only if it's a valid date
                            $tanggal_pulang_2 = strftime('%d %B %Y', strtotime($tanggal_pulang_2));
                          }
              
                          // Check if $tanggal_pulang_3 is "0000-00-00" and set it to an empty string if true
                          if ($tanggal_pulang_3 == "0000-00-00") {
                            $tanggal_pulang_3 = '';
                          } else {
                            // Format the date only if it's a valid date
                            $tanggal_pulang_3 = strftime('%d %B %Y', strtotime($tanggal_pulang_3));
                          }
  
                          $tglKeberangkatan_1 = strftime('%d %B %Y', strtotime($tanggalBerangkat_1));
                          $tglKeberangkatan_2 = strftime('%d %B %Y', strtotime($tanggalBerangkat_2));
                          $tglKeberangkatan_3 = strftime('%d %B %Y', strtotime($tanggalBerangkat_3));
  
                          // Ganti "Pebruari" menjadi "Februari"
                          $bulan_salah = 'Pebruari';
                          $bulan_benar = 'Februari';
  
                          $tanggal_pulang_1 = str_replace($bulan_salah, $bulan_benar, $tanggal_pulang_1);
                          $tanggal_pulang_2 = str_replace($bulan_salah, $bulan_benar, $tanggal_pulang_2);
                          $tanggal_pulang_3 = str_replace($bulan_salah, $bulan_benar, $tanggal_pulang_3);
  
                          $tglKeberangkatan_1 = str_replace($bulan_salah, $bulan_benar, $tglKeberangkatan_1);
                          $tglKeberangkatan_2 = str_replace($bulan_salah, $bulan_benar, $tglKeberangkatan_2);
                          $tglKeberangkatan_3 = str_replace($bulan_salah, $bulan_benar, $tglKeberangkatan_3);
                          // Format tanggal dengan strftime
                          $tglKeberangkatan = strftime('%d %B %Y', strtotime($pegawai['tanggal_berangkat']));
                          $tglKepulangan = strftime('%d %B %Y', strtotime($pegawai['tanggal_kembali']));
  
                          // Pastikan "Februari" ditulis dengan 'F' bukan 'P'
                          $tglKeberangkatan = str_replace('Pebruari', 'Februari', $tglKeberangkatan);
                          $tglKepulangan = str_replace('Pebruari', 'Februari', $tglKepulangan);
                          // var_dump($tglKeberangkatan);die();
                          if ($tanggalBerangkat_1 == "0000-00-00") {
                            $templateProcessor->setValue("tglKeberangkatan_1", '');
                            $templateProcessor->setValue("tanggal_pulang_1", '');
                            $templateProcessor->setValue("tgl_kepulangan#1", $tanggal_pulang_1);
              
                          }else{
                            $templateProcessor->setValue("tglKeberangkatan_1", $tglKeberangkatan_1);
                            $templateProcessor->setValue("tanggal_pulang_1", $tanggal_pulang_1);
                            
                            if ($tanggalBerangkat_2 === "0000-00-00") {
                                if ($pegawai['lama_p_d'] == 1) {
                                    $templateProcessor->setValue("tgl_kepulangan_sp1", '');
                                } else {
                                    $templateProcessor->setValue("tgl_kepulangan_sp1", "sampai dengan " . $tanggal_pulang_2);
                                }
                                $templateProcessor->setValue("tgl_kepulangan1", $tanggal_pulang_1);
              
                            } else {
                                $templateProcessor->setValue("tgl_kepulangan_sp1", '');
                                $templateProcessor->setValue("tgl_kepulangan1", '');
              
                            }
                          
              
                          }
                          if ($tanggalBerangkat_2 == "0000-00-00") {
                            // var_dump($tanggalBerangkat_2);die();
              
                            $templateProcessor->setValue("tglKeberangkatan_2", '');
                            $templateProcessor->setValue("tanggal_pulang_2", '');
                            
                            $templateProcessor->setValue("tgl_kepulangan2", "");
                            if ($tanggalBerangkat_3 == "0000-00-00") {
                              if ($pegawai['lama_p_d'] == 1) {
                                $templateProcessor->setValue("tgl_kepulangan_sp2", '');
                              } else {
                                  $templateProcessor->setValue("tgl_kepulangan_sp2", "sampai dengan " . $tanggal_pulang_2);
                              }
                            }else{
                              $templateProcessor->setValue("tgl_kepulangan_sp2", "sampai dengan " . $tanggal_pulang_3);
                            }
                          }else{
                            $templateProcessor->setValue("tglKeberangkatan_2", $tglKeberangkatan_2);
                            $templateProcessor->setValue("tanggal_pulang_2", $tanggal_pulang_2);
                            // var_dump($pegawai['lama_p_d']);die();
              
                            if ($tanggalBerangkat_3 == "0000-00-00") {
                              if ($pegawai['lama_p_d'] == 1) {
                                $templateProcessor->setValue("tgl_kepulangan_sp2", '');
                              } else {
                                  $templateProcessor->setValue("tgl_kepulangan_sp2", "sampai dengan " . $tanggal_pulang_2);
                              }
                              $templateProcessor->setValue("tgl_kepulangan2", $tanggal_pulang_2);
              
                            }else{
                              $templateProcessor->setValue("tgl_kepulangan2", "");
                              $templateProcessor->setValue("tgl_kepulangan_sp2", "sampai dengan " . $tanggal_pulang_3);
                            }
              
                          }
                          if ($tanggalBerangkat_3 == "0000-00-00") {
                            $templateProcessor->setValue("tglKeberangkatan_3", '');
                            $templateProcessor->setValue("tanggal_pulang_3", '');
                            $templateProcessor->setValue("tgl_kepulangan3", "");
                            $templateProcessor->setValue("tgl_kepulangan_sp3", '');
                          }else{
                            $templateProcessor->setValue("tglKeberangkatan_3", $tglKeberangkatan_3);
                            $templateProcessor->setValue("tanggal_pulang_3", $tanggal_pulang_3);
                            $templateProcessor->setValue("tgl_kepulangan3", $tanggal_pulang_3);
                            $templateProcessor->setValue("tgl_kepulangan_sp3", '');
                          }
                        
                          
                          // Sanitasi untuk srt_instansi_undangan agar aman untuk penggunaan dalam dokumen Word
                          $srtInstansiUndangan = htmlspecialchars($pegawai['srt_instansi_undangan'], ENT_QUOTES, 'UTF-8');
  
                          $kabupatenKota = ucwords(strtolower($pegawai['nama_tujuan'][0]->n_kabupaten));
                      
                          // Menetapkan nilai pada placeholder di template
                          $templateProcessor->setValue("jabatan", $pegawai['jabatan']);
                          $templateProcessor->setValue("ada", $srtInstansiUndangan);
                          $templateProcessor->setValue("mksd", $pegawai['mksd_pemberangkatan']);
                          $templateProcessor->setValue("kode_rekening_sub_keg", $pegawai['kode_rek_sub_req']);
                          $templateProcessor->setValue("srt_perihal_undangan", $pegawai['perihal_srt_undangan']);
                          $templateProcessor->setValue("srt_nmr_undangan", $pegawai['nmr_srt_undangan']);
                           $tgl_srt_undangan = strftime('%d %B %Y', strtotime($pegawai['tgl_srt_undangan']));
                        $templateProcessor->setValue("tgl_srt_undangan#{$index}", $tgl_srt_undangan);

                          $location_details = [];
                          
                          if (!empty($detail_tempat_1) && isset($kab_kota_array[0])) {
                              $location_details[] = $detail_tempat_1 . ' ' . $kab_kota_array[0];
                          }
                          if (!empty($detail_tempat_2) && isset($kab_kota_array[1])) {
                              $location_details[] = $detail_tempat_2 . ' ' . $kab_kota_array[1];
                          }
                          if (!empty($detail_tempat_3) && isset($kab_kota_array[2])) {
                              $location_details[] = $detail_tempat_3 . ' ' . $kab_kota_array[2];
                          }
                          
                          $final_location_string = implode(', ', $location_details);
                          
                          $templateProcessor->setValue("brtmpt", $final_location_string);
                          $templateProcessor->setValue("lama_perdin", $pegawai['lama_p_d']);
                          $templateProcessor->setValue("tgl_keberangkatan", $tglKeberangkatan);
                          $templateProcessor->setValue("tgl_kepulangan", $tglKepulangan);
                          $templateProcessor->setValue("kabupaten_kota_bertempatan", $kabupatenKota);
                          $templateProcessor->setValue("kepada_nama", $pegawai['nama_pegawai']);
                          $templateProcessor->setValue("kode_rek", $pegawai['kode_rek']);
                          $templateProcessor->setValue("arahan_pimpinan", $pegawai['dasar_arahan_pimpiman']);
                          $templateProcessor->setValue("kode_tim", $kode_tim);
                          $templateProcessor->setValue("no_urut", $no_grup_perdin);
                          $templateProcessor->setValue("kendaraan", $pegawai['kendaraan']);
                          // Cek apakah nip ada, jika ada maka kolom nip akan muncul
                          if (!empty($pegawai['pangkat_gol']) && strtolower($pegawai['pangkat_gol']) != 'tenaga kontrak') {
                              $templateProcessor->setValue("nama_kolom_nip", 'Nomor Induk Pegawai');
                              $templateProcessor->setValue("nip", $pegawai['nip']);
                              $pangkatGolongan = (isset($pegawai['pangkat_gol']) && isset($pegawai['golongan']) && $pegawai['pangkat_gol'] !== '' && $pegawai['golongan'] !== '' && $pegawai['pangkat_gol'] !== 'Tenaga Kontrak') 
                              ? $pegawai['pangkat_gol'] . ' (' . $pegawai['golongan'] .')'
                              : 'Non ASN';
                  
                  
                                              $templateProcessor->setValue("Pangkat_golongan", $pangkatGolongan);
  
  
                          } else {
                            $templateProcessor->setValue("nama_kolom_nip#{$index}", 'Nomor Induk Pegawai');
                            $templateProcessor->setValue("nip#{$index}", '-');
                            $pangkatGolongan = (isset($pegawai['pangkat_gol']) && isset($pegawai['golongan']) && $pegawai['pangkat_gol'] !== '' && $pegawai['golongan'] !== '' && $pegawai['pangkat_gol'] !== 'Tenaga Kontrak') 
                            ? $pegawai['pangkat_gol'] . ' (' . $pegawai['golongan'] .')'
                            : 'Non ASN';
                
                
                                            $templateProcessor->setValue("Pangkat_golongan", $pangkatGolongan);
                          }
                          $templateProcessor->setValue("Pangkat_golongan_visum#{$index}", $pangkatGolongan);
  
                          $templateProcessor->setValue("jabatan", $pegawai['jabatan']); 
                          $templateProcessor->setValue("golongan", $pegawai['golongan']); 
  
                          if (count($kab_kota_array) == 1) {
                              $templateProcessor->setValue("tempat_tujuan#1", isset($kab_kota_array[0]) ? $kab_kota_array[0] . ' ' : '');
                              $templateProcessor->setValue("tempat_tujuan#2", isset($kab_kota_array[1]) ? $kab_kota_array[1] . ',' : '');
                              $templateProcessor->setValue("tempat_tujuan#3", isset($kab_kota_array[2]) ? $kab_kota_array[2] . ',' : '');
                
                              $templateProcessor->setValue("tempat_tujuan_1_kota#0", 'Kota Bandung');
                              $templateProcessor->setValue("tempat_tujuan_2_kota#0", '');
                              $templateProcessor->setValue("tempat_tujuan_3_kota#0", '');
                          }elseif(count($kab_kota_array) == 2){
                            $templateProcessor->setValue("tempat_tujuan#1", isset($kab_kota_array[0]) ? $kab_kota_array[0] . ',' : '');
                            $templateProcessor->setValue("tempat_tujuan#2", isset($kab_kota_array[1]) ? $kab_kota_array[1] . ' ' : '');
                            $templateProcessor->setValue("tempat_tujuan#3", isset($kab_kota_array[2]) ? $kab_kota_array[2] . ',' : '');
                
                            $templateProcessor->setValue("tempat_tujuan_1_kota#0", '');
                            $templateProcessor->setValue("tempat_tujuan_2_kota#0", 'Kota Bandung');
                            $templateProcessor->setValue("tempat_tujuan_3_kota#0", '');
                          }else{
                            $templateProcessor->setValue("tempat_tujuan#1", isset($kab_kota_array[0]) ? $kab_kota_array[0] . ',' : '');
                            $templateProcessor->setValue("tempat_tujuan#2", isset($kab_kota_array[1]) ? $kab_kota_array[1] . ',' : '');
                            $templateProcessor->setValue("tempat_tujuan#3", isset($kab_kota_array[2]) ? $kab_kota_array[2] . ' ' : '');
                
                            $templateProcessor->setValue("tempat_tujuan_1_kota#0", '');
                            $templateProcessor->setValue("tempat_tujuan_2_kota#0", '');
                            $templateProcessor->setValue("tempat_tujuan_3_kota#0", 'Kota Bandung');
                          }
                          $templateProcessor->deleteBlock('nomor_induk_pegawai_row');
  
                          
                       
  
                          $filename_bukadis = 'assets/file_surat_perdin/visum_kadis/SPPD_' . date('Ymd') . '_' . $no_grup_perdin . '_' . $kode_tim_file->kode_tim_ketua . '_visum_kadis.docx';
                          $filename_bukadis_simpan = 'SPPD_' . date('Ymd') . '_' . $no_grup_perdin . '_' . $kode_tim_file->kode_tim_ketua . '_visum_kadis.docx';
                          $templateProcessor->saveAs($filename_bukadis);
                         
                          // var_dump($filename_bukadis_simpan);die();
                          $data = [
                              'file_srt_visum_kadis' => $filename_bukadis_simpan,
                          ];
                          $update_perdin = $this->m_perdin->update_e_perdin($pegawai['id_perdin'], $data);
                        }
                        
  
                      
                }elseif($tipe_undangan == 3){
                    $templateFile = 'assets/file_surat_perdin/template_surat_perdin/template_arahan_pimpinan/surat_perintah_template_bu_kadis_arahan_pimpinan.docx';
                    // Memproses file template yang dipilih

                      $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor($templateFile);

                      // Lanjutkan dengan pengisian data ke dalam template...

                      $arrblnRomawi = array("I","II","III","IV","V","VI",'VII','VIII','IX','X','XI','XII');
                      $blnRomawi = $arrblnRomawi[date("m")-1];
                      
                      // Pastikan menggunakan setlocale untuk format bahasa Indonesia
                      setlocale(LC_TIME, 'id_ID.utf8');

                      // Mendapatkan hari, tanggal, bulan, dan tahun
                      $hari_ttd = strftime('%A', time()); // Nama hari
                      $tgl_ttd = strftime('%d', time()); // Tanggal (angka)
                      $bln_ttd = strftime('%B', time()); // Nama bulan

                      // Ganti "Pebruari" menjadi "Februari"
                      $bln_ttd = str_replace("Pebruari", "Februari", $bln_ttd); // Nama bulan
                      $tahun_text = strftime('%Y', time()); // Tahun (angka)
                      // Membuat nomor random
                      $random_number = mt_rand(1000, 9999); // Nomor random 4 digit

                      // Mendapatkan tanggal hari ini dalam format DDMMYYYY
                      $tanggal_hari_ini = date('dmY');

                      // Menggabungkan semua elemen menjadi nomor dengan format yang diinginkan
                      $nomor_format = $random_number . '/LKK/kemitraan/' . $tanggal_hari_ini;

                      foreach ($filtered_data_bu_kadis as $index => $pegawai) {
                        // Hanya proses data dengan ID tertentu
                        if ($pegawai['id_pegawai'] != 1152) {
                            continue; // Lewati iterasi jika ID tidak sesuai
                        }
                        //  var_dump($pegawai);die();

                        $tujuan_keberangkatan_perdin = $this->m_perdin->get_tujuan_keberangkatan_perdin($pegawai['no_grup_perdin'], $pegawai['id_tim']);

                        $kab_kota_array = [];
                        if (!empty($tujuan_keberangkatan_perdin)) {
                            foreach ($tujuan_keberangkatan_perdin as $rowlist) {
                                // Decode jika kab_kota dalam format JSON
                                $decoded = json_decode($rowlist->kab_kota, true);
                                if (is_array($decoded)) {
                                    $kab_kota_array = array_merge($kab_kota_array, $decoded); // Gabungkan jika array
                                } else {
                                    $kab_kota_array[] = $rowlist->kab_kota; // Tambahkan langsung jika bukan JSON
                                }
                            }
                        } else {
                            echo "No data available"; // Tampilkan pesan jika data kosong
                        }
                        $tujuan_keberangkatan_perdin = $this->m_perdin->get_tujuan_keberangkatan_perdin($pegawai['no_grup_perdin'], $pegawai['id_tim']);
                        
                        $tanggalBerangkat_1 = $tujuan_keberangkatan_perdin[0]->tanggal_berangkat_1;
                        $tanggalBerangkat_2 = $tujuan_keberangkatan_perdin[0]->tanggal_berangkat_2;
                        $tanggalBerangkat_3 = $tujuan_keberangkatan_perdin[0]->tanggal_berangkat_3;
              
                        $tanggal_pulang_1 = $tujuan_keberangkatan_perdin[0]->tanggal_pulang_1;
                        $tanggal_pulang_2 = $tujuan_keberangkatan_perdin[0]->tanggal_pulang_2;
                        $tanggal_pulang_3 = $tujuan_keberangkatan_perdin[0]->tanggal_pulang_3;
        
                        setlocale(LC_TIME, 'id_ID.UTF-8', 'Indonesian', 'id_ID');

                        // Format tanggal dengan strftime
                        // Format tanggal dengan strftime
                        $tanggal_pulang_1 = strftime('%d %B %Y', strtotime($tanggal_pulang_1));
                        if ($tanggal_pulang_2 == "0000-00-00") {
                          $tanggal_pulang_2 = '';
                        } else {
                          // Format the date only if it's a valid date
                          $tanggal_pulang_2 = strftime('%d %B %Y', strtotime($tanggal_pulang_2));
                        }
            
                        // Check if $tanggal_pulang_3 is "0000-00-00" and set it to an empty string if true
                        if ($tanggal_pulang_3 == "0000-00-00") {
                          $tanggal_pulang_3 = '';
                        } else {
                          // Format the date only if it's a valid date
                          $tanggal_pulang_3 = strftime('%d %B %Y', strtotime($tanggal_pulang_3));
                        }

                        $tglKeberangkatan_1 = strftime('%d %B %Y', strtotime($tanggalBerangkat_1));
                        $tglKeberangkatan_2 = strftime('%d %B %Y', strtotime($tanggalBerangkat_2));
                        $tglKeberangkatan_3 = strftime('%d %B %Y', strtotime($tanggalBerangkat_3));

                        // Ganti "Pebruari" menjadi "Februari"
                        $bulan_salah = 'Pebruari';
                        $bulan_benar = 'Februari';

                        $tanggal_pulang_1 = str_replace($bulan_salah, $bulan_benar, $tanggal_pulang_1);
                        $tanggal_pulang_2 = str_replace($bulan_salah, $bulan_benar, $tanggal_pulang_2);
                        $tanggal_pulang_3 = str_replace($bulan_salah, $bulan_benar, $tanggal_pulang_3);

                        $tglKeberangkatan_1 = str_replace($bulan_salah, $bulan_benar, $tglKeberangkatan_1);
                        $tglKeberangkatan_2 = str_replace($bulan_salah, $bulan_benar, $tglKeberangkatan_2);
                        $tglKeberangkatan_3 = str_replace($bulan_salah, $bulan_benar, $tglKeberangkatan_3);
                        // Format tanggal dengan strftime
                        $tglKeberangkatan = strftime('%d %B %Y', strtotime($pegawai['tanggal_berangkat']));
                        $tglKepulangan = strftime('%d %B %Y', strtotime($pegawai['tanggal_kembali']));

                        // Pastikan "Februari" ditulis dengan 'F' bukan 'P'
                        $tglKeberangkatan = str_replace('Pebruari', 'Februari', $tglKeberangkatan);
                        $tglKepulangan = str_replace('Pebruari', 'Februari', $tglKepulangan);
                        if ($tanggalBerangkat_1 == "0000-00-00") {
                          $templateProcessor->setValue("tglKeberangkatan_1", '');
                          $templateProcessor->setValue("tanggal_pulang_1", '');
                          $templateProcessor->setValue("tgl_kepulangan#1", $tanggal_pulang_1);
            
                        }else{
                          $templateProcessor->setValue("tglKeberangkatan_1", $tglKeberangkatan_1);
                          $templateProcessor->setValue("tanggal_pulang_1", $tanggal_pulang_1);
                          
                          if ($tanggalBerangkat_2 === "0000-00-00") {
                              if ($pegawai['lama_p_d'] == 1) {
                                  $templateProcessor->setValue("tgl_kepulangan_sp1", '');
                              } else {
                                  $templateProcessor->setValue("tgl_kepulangan_sp1", "sampai dengan " . $tanggal_pulang_2);
                              }
                              $templateProcessor->setValue("tgl_kepulangan1", $tanggal_pulang_1);
            
                          } else {
                              $templateProcessor->setValue("tgl_kepulangan_sp1", '');
                              $templateProcessor->setValue("tgl_kepulangan1", '');
            
                          }
                        
            
                        }
                        if ($tanggalBerangkat_2 == "0000-00-00") {
                          // var_dump($tanggalBerangkat_2);die();
            
                          $templateProcessor->setValue("tglKeberangkatan_2", '');
                          $templateProcessor->setValue("tanggal_pulang_2", '');
                          
                          $templateProcessor->setValue("tgl_kepulangan2", "");
                          if ($tanggalBerangkat_3 == "0000-00-00") {
                            if ($pegawai['lama_p_d'] == 1) {
                              $templateProcessor->setValue("tgl_kepulangan_sp2", '');
                            } else {
                                $templateProcessor->setValue("tgl_kepulangan_sp2", "sampai dengan " . $tanggal_pulang_2);
                            }
                          }else{
                            $templateProcessor->setValue("tgl_kepulangan_sp2", "sampai dengan " . $tanggal_pulang_3);
                          }
                        }else{
                          $templateProcessor->setValue("tglKeberangkatan_2", $tglKeberangkatan_2);
                          $templateProcessor->setValue("tanggal_pulang_2", $tanggal_pulang_2);
                          // var_dump($pegawai['lama_p_d']);die();
            
                          if ($tanggalBerangkat_3 == "0000-00-00") {
                            if ($pegawai['lama_p_d'] == 1) {
                              $templateProcessor->setValue("tgl_kepulangan_sp2", '');
                            } else {
                                $templateProcessor->setValue("tgl_kepulangan_sp2", "sampai dengan " . $tanggal_pulang_2);
                            }
                            $templateProcessor->setValue("tgl_kepulangan2", $tanggal_pulang_2);
            
                          }else{
                            $templateProcessor->setValue("tgl_kepulangan2", "");
                            $templateProcessor->setValue("tgl_kepulangan_sp2", "sampai dengan " . $tanggal_pulang_3);
                          }
            
                        }
                        if ($tanggalBerangkat_3 == "0000-00-00") {
                          $templateProcessor->setValue("tglKeberangkatan_3", '');
                          $templateProcessor->setValue("tanggal_pulang_3", '');
                          $templateProcessor->setValue("tgl_kepulangan3", "");
                          $templateProcessor->setValue("tgl_kepulangan_sp3", '');
                        }else{
                          $templateProcessor->setValue("tglKeberangkatan_3", $tglKeberangkatan_3);
                          $templateProcessor->setValue("tanggal_pulang_3", $tanggal_pulang_3);
                          $templateProcessor->setValue("tgl_kepulangan3", $tanggal_pulang_3);
                          $templateProcessor->setValue("tgl_kepulangan_sp3", '');
                        }
                      
                        
                        // Sanitasi untuk srt_instansi_undangan agar aman untuk penggunaan dalam dokumen Word
                        $srtInstansiUndangan = htmlspecialchars($pegawai['srt_instansi_undangan'], ENT_QUOTES, 'UTF-8');

                        $kabupatenKota = ucwords(strtolower($pegawai['nama_tujuan'][0]->n_kabupaten));
                    
                        // Menetapkan nilai pada placeholder di template
                        $templateProcessor->setValue("jabatan", $pegawai['jabatan']);
                        $templateProcessor->setValue("ada", $srtInstansiUndangan);
                        $templateProcessor->setValue("mksd", $pegawai['mksd_pemberangkatan']);
                        $templateProcessor->setValue("kode_rekening_sub_keg", $pegawai['kode_rek_sub_req']);
                        $templateProcessor->setValue("srt_perihal_undangan", $pegawai['perihal_srt_undangan']);
                        $templateProcessor->setValue("srt_nmr_undangan", $pegawai['nmr_srt_undangan']);
                        $templateProcessor->setValue("tgl_srt_undangan", $pegawai['tgl_srt_undangan']);

                        $tgl_srt_undangan = strftime('%d %B %Y', strtotime($pegawai['tgl_srt_undangan']));
                        $templateProcessor->setValue("tgl_srt_undangan#{$index}", $tgl_srt_undangan);

                          $location_details = [];
                          
                          if (!empty($detail_tempat_1) && isset($kab_kota_array[0])) {
                              $location_details[] = $detail_tempat_1 . ' ' . $kab_kota_array[0];
                          }
                          if (!empty($detail_tempat_2) && isset($kab_kota_array[1])) {
                              $location_details[] = $detail_tempat_2 . ' ' . $kab_kota_array[1];
                          }
                          if (!empty($detail_tempat_3) && isset($kab_kota_array[2])) {
                              $location_details[] = $detail_tempat_3 . ' ' . $kab_kota_array[2];
                          }
                          
                          $final_location_string = implode(', ', $location_details);
                          
                          $templateProcessor->setValue("brtmpt", $final_location_string);
                        $templateProcessor->setValue("lama_perdin", $pegawai['lama_p_d']);
                        $templateProcessor->setValue("tgl_keberangkatan", $tglKeberangkatan);
                        $templateProcessor->setValue("tgl_kepulangan", $tglKepulangan);
                        $templateProcessor->setValue("kabupaten_kota_bertempatan", $kabupatenKota);
                        $templateProcessor->setValue("kepada_nama", $pegawai['nama_pegawai']);
                        $templateProcessor->setValue("kode_rek", $pegawai['kode_rek']);
                        $templateProcessor->setValue("arahan_pimpinan", $pegawai['dasar_arahan_pimpiman']);
                        $templateProcessor->setValue("kode_tim", $kode_tim);
                        $templateProcessor->setValue("no_urut", $no_grup_perdin);
                        $templateProcessor->setValue("kendaraan", $pegawai['kendaraan']);
                        // Cek apakah nip ada, jika ada maka kolom nip akan muncul
                        if (!empty($pegawai['pangkat_gol']) && strtolower($pegawai['pangkat_gol']) != 'tenaga kontrak') {
                            $templateProcessor->setValue("nama_kolom_nip", 'Nomor Induk Pegawai');
                            $templateProcessor->setValue("nip", $pegawai['nip']);
                            $pangkatGolongan = (isset($pegawai['pangkat_gol']) && isset($pegawai['golongan']) && $pegawai['pangkat_gol'] !== '' && $pegawai['golongan'] !== '' && $pegawai['pangkat_gol'] !== 'Tenaga Kontrak') 
                            ? $pegawai['pangkat_gol'] . ' (' . $pegawai['golongan'] .')'
                            : 'Non ASN';
                
                
                                            $templateProcessor->setValue("Pangkat_golongan", $pangkatGolongan);


                        } else {
                          $templateProcessor->setValue("nama_kolom_nip#{$index}", 'Nomor Induk Pegawai');
                          $templateProcessor->setValue("nip#{$index}", '-');
                          $pangkatGolongan = (isset($pegawai['pangkat_gol']) && isset($pegawai['golongan']) && $pegawai['pangkat_gol'] !== '' && $pegawai['golongan'] !== '' && $pegawai['pangkat_gol'] !== 'Tenaga Kontrak') 
                          ? $pegawai['pangkat_gol'] . ' (' . $pegawai['golongan'] .')'
                          : 'Non ASN';
              
              
                                          $templateProcessor->setValue("Pangkat_golongan", $pangkatGolongan);
                        }
                        $templateProcessor->setValue("Pangkat_golongan_visum#{$index}", $pangkatGolongan);

                        $templateProcessor->setValue("jabatan", $pegawai['jabatan']); 
                        $templateProcessor->setValue("golongan", $pegawai['golongan']); 

                        if (count($kab_kota_array) == 1) {
                            $templateProcessor->setValue("tempat_tujuan#1", isset($kab_kota_array[0]) ? $kab_kota_array[0] . ' ' : '');
                            $templateProcessor->setValue("tempat_tujuan#2", isset($kab_kota_array[1]) ? $kab_kota_array[1] . ',' : '');
                            $templateProcessor->setValue("tempat_tujuan#3", isset($kab_kota_array[2]) ? $kab_kota_array[2] . ',' : '');
              
                            $templateProcessor->setValue("tempat_tujuan_1_kota#0", 'Kota Bandung');
                            $templateProcessor->setValue("tempat_tujuan_2_kota#0", '');
                            $templateProcessor->setValue("tempat_tujuan_3_kota#0", '');
                        }elseif(count($kab_kota_array) == 2){
                          $templateProcessor->setValue("tempat_tujuan#1", isset($kab_kota_array[0]) ? $kab_kota_array[0] . ',' : '');
                          $templateProcessor->setValue("tempat_tujuan#2", isset($kab_kota_array[1]) ? $kab_kota_array[1] . ' ' : '');
                          $templateProcessor->setValue("tempat_tujuan#3", isset($kab_kota_array[2]) ? $kab_kota_array[2] . ',' : '');
              
                          $templateProcessor->setValue("tempat_tujuan_1_kota#0", '');
                          $templateProcessor->setValue("tempat_tujuan_2_kota#0", 'Kota Bandung');
                          $templateProcessor->setValue("tempat_tujuan_3_kota#0", '');
                        }else{
                          $templateProcessor->setValue("tempat_tujuan#1", isset($kab_kota_array[0]) ? $kab_kota_array[0] . ',' : '');
                          $templateProcessor->setValue("tempat_tujuan#2", isset($kab_kota_array[1]) ? $kab_kota_array[1] . ',' : '');
                          $templateProcessor->setValue("tempat_tujuan#3", isset($kab_kota_array[2]) ? $kab_kota_array[2] . ' ' : '');
              
                          $templateProcessor->setValue("tempat_tujuan_1_kota#0", '');
                          $templateProcessor->setValue("tempat_tujuan_2_kota#0", '');
                          $templateProcessor->setValue("tempat_tujuan_3_kota#0", 'Kota Bandung');
                        }
                        $templateProcessor->deleteBlock('nomor_induk_pegawai_row');

                        
                     

                        $filename_bukadis = 'assets/file_surat_perdin/kadis_sekdis/SPPD_' . date('Ymd') . '_' . $no_grup_perdin . '_' . $kode_tim_file->kode_tim_ketua . '_kadis.docx';
                        $filename_bukadis_simpan = 'SPPD_' . date('Ymd') . '_' . $no_grup_perdin . '_' . $kode_tim_file->kode_tim_ketua . '_kadis.docx';
                        
                        $data = [
                            'file_srt' => $filename_bukadis_simpan,
                        ];
                        $update_perdin = $this->m_perdin->update_e_perdin($pegawai['id_perdin'], $data);

                        $templateProcessor->saveAs($filename_bukadis);
                      }
                        $templateFile = 'assets/file_surat_perdin/template_surat_perdin/visum_kadis.docx';
                        // Memproses file template yang dipilih
  
                        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor($templateFile);
  
                        // Lanjutkan dengan pengisian data ke dalam template...
  
                        $arrblnRomawi = array("I","II","III","IV","V","VI",'VII','VIII','IX','X','XI','XII');
                        $blnRomawi = $arrblnRomawi[date("m")-1];
                        
                        // Pastikan menggunakan setlocale untuk format bahasa Indonesia
                        setlocale(LC_TIME, 'id_ID.utf8');
  
                        // Mendapatkan hari, tanggal, bulan, dan tahun
                        $hari_ttd = strftime('%A', time()); // Nama hari
                        $tgl_ttd = strftime('%d', time()); // Tanggal (angka)
                        $bln_ttd = strftime('%B', time()); // Nama bulan

                        // Ganti "Pebruari" menjadi "Februari"
                        $bln_ttd = str_replace("Pebruari", "Februari", $bln_ttd); // Nama bulan
                        $tahun_text = strftime('%Y', time()); // Tahun (angka)
                        // Membuat nomor random
                        $random_number = mt_rand(1000, 9999); // Nomor random 4 digit
  
                        // Mendapatkan tanggal hari ini dalam format DDMMYYYY
                        $tanggal_hari_ini = date('dmY');
  
                        // Menggabungkan semua elemen menjadi nomor dengan format yang diinginkan
                        $nomor_format = $random_number . '/LKK/kemitraan/' . $tanggal_hari_ini;
  
                        foreach ($filtered_data_bu_kadis as $index => $pegawai) {
                          // Hanya proses data dengan ID tertentu
                          if ($pegawai['id_pegawai'] != 1152) {
                              continue; // Lewati iterasi jika ID tidak sesuai
                          }
                          //  var_dump($pegawai);die();
  
                          $tujuan_keberangkatan_perdin = $this->m_perdin->get_tujuan_keberangkatan_perdin($pegawai['no_grup_perdin'], $pegawai['id_tim']);
  
                          $kab_kota_array = [];
                          if (!empty($tujuan_keberangkatan_perdin)) {
                              foreach ($tujuan_keberangkatan_perdin as $rowlist) {
                                  // Decode jika kab_kota dalam format JSON
                                  $decoded = json_decode($rowlist->kab_kota, true);
                                  if (is_array($decoded)) {
                                      $kab_kota_array = array_merge($kab_kota_array, $decoded); // Gabungkan jika array
                                  } else {
                                      $kab_kota_array[] = $rowlist->kab_kota; // Tambahkan langsung jika bukan JSON
                                  }
                              }
                          } else {
                              echo "No data available"; // Tampilkan pesan jika data kosong
                          }
                          $tujuan_keberangkatan_perdin = $this->m_perdin->get_tujuan_keberangkatan_perdin($pegawai['no_grup_perdin'], $pegawai['id_tim']);
                          
                          $tanggalBerangkat_1 = $tujuan_keberangkatan_perdin[0]->tanggal_berangkat_1;
                          $tanggalBerangkat_2 = $tujuan_keberangkatan_perdin[0]->tanggal_berangkat_2;
                          $tanggalBerangkat_3 = $tujuan_keberangkatan_perdin[0]->tanggal_berangkat_3;
                
                          $tanggal_pulang_1 = $tujuan_keberangkatan_perdin[0]->tanggal_pulang_1;
                          $tanggal_pulang_2 = $tujuan_keberangkatan_perdin[0]->tanggal_pulang_2;
                          $tanggal_pulang_3 = $tujuan_keberangkatan_perdin[0]->tanggal_pulang_3;
          
                          setlocale(LC_TIME, 'id_ID.UTF-8', 'Indonesian', 'id_ID');
  
                          // Format tanggal dengan strftime
                          // Format tanggal dengan strftime
                          $tanggal_pulang_1 = strftime('%d %B %Y', strtotime($tanggal_pulang_1));
                          if ($tanggal_pulang_2 == "0000-00-00") {
                            $tanggal_pulang_2 = '';
                          } else {
                            // Format the date only if it's a valid date
                            $tanggal_pulang_2 = strftime('%d %B %Y', strtotime($tanggal_pulang_2));
                          }
              
                          // Check if $tanggal_pulang_3 is "0000-00-00" and set it to an empty string if true
                          if ($tanggal_pulang_3 == "0000-00-00") {
                            $tanggal_pulang_3 = '';
                          } else {
                            // Format the date only if it's a valid date
                            $tanggal_pulang_3 = strftime('%d %B %Y', strtotime($tanggal_pulang_3));
                          }
  
                          $tglKeberangkatan_1 = strftime('%d %B %Y', strtotime($tanggalBerangkat_1));
                          $tglKeberangkatan_2 = strftime('%d %B %Y', strtotime($tanggalBerangkat_2));
                          $tglKeberangkatan_3 = strftime('%d %B %Y', strtotime($tanggalBerangkat_3));
  
                          // Ganti "Pebruari" menjadi "Februari"
                          $bulan_salah = 'Pebruari';
                          $bulan_benar = 'Februari';
  
                          $tanggal_pulang_1 = str_replace($bulan_salah, $bulan_benar, $tanggal_pulang_1);
                          $tanggal_pulang_2 = str_replace($bulan_salah, $bulan_benar, $tanggal_pulang_2);
                          $tanggal_pulang_3 = str_replace($bulan_salah, $bulan_benar, $tanggal_pulang_3);
  
                          $tglKeberangkatan_1 = str_replace($bulan_salah, $bulan_benar, $tglKeberangkatan_1);
                          $tglKeberangkatan_2 = str_replace($bulan_salah, $bulan_benar, $tglKeberangkatan_2);
                          $tglKeberangkatan_3 = str_replace($bulan_salah, $bulan_benar, $tglKeberangkatan_3);
                          // Format tanggal dengan strftime
                          $tglKeberangkatan = strftime('%d %B %Y', strtotime($pegawai['tanggal_berangkat']));
                          $tglKepulangan = strftime('%d %B %Y', strtotime($pegawai['tanggal_kembali']));
  
                          // Pastikan "Februari" ditulis dengan 'F' bukan 'P'
                          $tglKeberangkatan = str_replace('Pebruari', 'Februari', $tglKeberangkatan);
                          $tglKepulangan = str_replace('Pebruari', 'Februari', $tglKepulangan);
                          // var_dump($tglKeberangkatan);die();
                          if ($tanggalBerangkat_1 == "0000-00-00") {
                            $templateProcessor->setValue("tglKeberangkatan_1", '');
                            $templateProcessor->setValue("tanggal_pulang_1", '');
                            $templateProcessor->setValue("tgl_kepulangan#1", $tanggal_pulang_1);
              
                          }else{
                            $templateProcessor->setValue("tglKeberangkatan_1", $tglKeberangkatan_1);
                            $templateProcessor->setValue("tanggal_pulang_1", $tanggal_pulang_1);
                            
                            if ($tanggalBerangkat_2 === "0000-00-00") {
                                if ($pegawai['lama_p_d'] == 1) {
                                    $templateProcessor->setValue("tgl_kepulangan_sp1", '');
                                } else {
                                    $templateProcessor->setValue("tgl_kepulangan_sp1", "sampai dengan " . $tanggal_pulang_2);
                                }
                                $templateProcessor->setValue("tgl_kepulangan1", $tanggal_pulang_1);
              
                            } else {
                                $templateProcessor->setValue("tgl_kepulangan_sp1", '');
                                $templateProcessor->setValue("tgl_kepulangan1", '');
              
                            }
                          
              
                          }
                          if ($tanggalBerangkat_2 == "0000-00-00") {
                            // var_dump($tanggalBerangkat_2);die();
              
                            $templateProcessor->setValue("tglKeberangkatan_2", '');
                            $templateProcessor->setValue("tanggal_pulang_2", '');
                            
                            $templateProcessor->setValue("tgl_kepulangan2", "");
                            if ($tanggalBerangkat_3 == "0000-00-00") {
                              if ($pegawai['lama_p_d'] == 1) {
                                $templateProcessor->setValue("tgl_kepulangan_sp2", '');
                              } else {
                                  $templateProcessor->setValue("tgl_kepulangan_sp2", "sampai dengan " . $tanggal_pulang_2);
                              }
                            }else{
                              $templateProcessor->setValue("tgl_kepulangan_sp2", "sampai dengan " . $tanggal_pulang_3);
                            }
                          }else{
                            $templateProcessor->setValue("tglKeberangkatan_2", $tglKeberangkatan_2);
                            $templateProcessor->setValue("tanggal_pulang_2", $tanggal_pulang_2);
                            // var_dump($pegawai['lama_p_d']);die();
              
                            if ($tanggalBerangkat_3 == "0000-00-00") {
                              if ($pegawai['lama_p_d'] == 1) {
                                $templateProcessor->setValue("tgl_kepulangan_sp2", '');
                              } else {
                                  $templateProcessor->setValue("tgl_kepulangan_sp2", "sampai dengan " . $tanggal_pulang_2);
                              }
                              $templateProcessor->setValue("tgl_kepulangan2", $tanggal_pulang_2);
              
                            }else{
                              $templateProcessor->setValue("tgl_kepulangan2", "");
                              $templateProcessor->setValue("tgl_kepulangan_sp2", "sampai dengan " . $tanggal_pulang_3);
                            }
              
                          }
                          if ($tanggalBerangkat_3 == "0000-00-00") {
                            $templateProcessor->setValue("tglKeberangkatan_3", '');
                            $templateProcessor->setValue("tanggal_pulang_3", '');
                            $templateProcessor->setValue("tgl_kepulangan3", "");
                            $templateProcessor->setValue("tgl_kepulangan_sp3", '');
                          }else{
                            $templateProcessor->setValue("tglKeberangkatan_3", $tglKeberangkatan_3);
                            $templateProcessor->setValue("tanggal_pulang_3", $tanggal_pulang_3);
                            $templateProcessor->setValue("tgl_kepulangan3", $tanggal_pulang_3);
                            $templateProcessor->setValue("tgl_kepulangan_sp3", '');
                          }
                        
                          
                          // Sanitasi untuk srt_instansi_undangan agar aman untuk penggunaan dalam dokumen Word
                          $srtInstansiUndangan = htmlspecialchars($pegawai['srt_instansi_undangan'], ENT_QUOTES, 'UTF-8');
  
                          $kabupatenKota = ucwords(strtolower($pegawai['nama_tujuan'][0]->n_kabupaten));
                      
                          // Menetapkan nilai pada placeholder di template
                          $templateProcessor->setValue("jabatan", $pegawai['jabatan']);
                          $templateProcessor->setValue("ada", $srtInstansiUndangan);
                          $templateProcessor->setValue("mksd", $pegawai['mksd_pemberangkatan']);
                          $templateProcessor->setValue("kode_rekening_sub_keg", $pegawai['kode_rek_sub_req']);
                          $templateProcessor->setValue("srt_perihal_undangan", $pegawai['perihal_srt_undangan']);
                          $templateProcessor->setValue("srt_nmr_undangan", $pegawai['nmr_srt_undangan']);
                          $tgl_srt_undangan = strftime('%d %B %Y', strtotime($pegawai['tgl_srt_undangan']));
                          $templateProcessor->setValue("tgl_srt_undangan#{$index}", $tgl_srt_undangan);

                          $location_details = [];
                          
                          if (!empty($detail_tempat_1) && isset($kab_kota_array[0])) {
                              $location_details[] = $detail_tempat_1 . ' ' . $kab_kota_array[0];
                          }
                          if (!empty($detail_tempat_2) && isset($kab_kota_array[1])) {
                              $location_details[] = $detail_tempat_2 . ' ' . $kab_kota_array[1];
                          }
                          if (!empty($detail_tempat_3) && isset($kab_kota_array[2])) {
                              $location_details[] = $detail_tempat_3 . ' ' . $kab_kota_array[2];
                          }
                          
                          $final_location_string = implode(', ', $location_details);
                          
                          $templateProcessor->setValue("brtmpt", $final_location_string);
                          $templateProcessor->setValue("lama_perdin", $pegawai['lama_p_d']);
                          $templateProcessor->setValue("tgl_keberangkatan", $tglKeberangkatan);
                          $templateProcessor->setValue("tgl_kepulangan", $tglKepulangan);
                          $templateProcessor->setValue("kabupaten_kota_bertempatan", $kabupatenKota);
                          $templateProcessor->setValue("kepada_nama", $pegawai['nama_pegawai']);
                          $templateProcessor->setValue("kode_rek", $pegawai['kode_rek']);
                          $templateProcessor->setValue("arahan_pimpinan", $pegawai['dasar_arahan_pimpiman']);
                          $templateProcessor->setValue("kode_tim", $kode_tim);
                          $templateProcessor->setValue("no_urut", $no_grup_perdin);
                          $templateProcessor->setValue("kendaraan", $pegawai['kendaraan']);
                          // Cek apakah nip ada, jika ada maka kolom nip akan muncul
                          if (!empty($pegawai['pangkat_gol']) && strtolower($pegawai['pangkat_gol']) != 'tenaga kontrak') {
                              $templateProcessor->setValue("nama_kolom_nip", 'Nomor Induk Pegawai');
                              $templateProcessor->setValue("nip", $pegawai['nip']);
                              $pangkatGolongan = (isset($pegawai['pangkat_gol']) && isset($pegawai['golongan']) && $pegawai['pangkat_gol'] !== '' && $pegawai['golongan'] !== '' && $pegawai['pangkat_gol'] !== 'Tenaga Kontrak') 
                              ? $pegawai['pangkat_gol'] . ' (' . $pegawai['golongan'] .')'
                              : 'Non ASN';
                  
                  
                                              $templateProcessor->setValue("Pangkat_golongan", $pangkatGolongan);
  
  
                          } else {
                            $templateProcessor->setValue("nama_kolom_nip#{$index}", 'Nomor Induk Pegawai');
                            $templateProcessor->setValue("nip#{$index}", '-');
                            $pangkatGolongan = (isset($pegawai['pangkat_gol']) && isset($pegawai['golongan']) && $pegawai['pangkat_gol'] !== '' && $pegawai['golongan'] !== '' && $pegawai['pangkat_gol'] !== 'Tenaga Kontrak') 
                            ? $pegawai['pangkat_gol'] . ' (' . $pegawai['golongan'] .')'
                            : 'Non ASN';
                
                
                                            $templateProcessor->setValue("Pangkat_golongan", $pangkatGolongan);
                          }
                          $templateProcessor->setValue("Pangkat_golongan_visum#{$index}", $pangkatGolongan);
  
                          $templateProcessor->setValue("jabatan", $pegawai['jabatan']); 
                          $templateProcessor->setValue("golongan", $pegawai['golongan']); 
  
                          if (count($kab_kota_array) == 1) {
                              $templateProcessor->setValue("tempat_tujuan#1", isset($kab_kota_array[0]) ? $kab_kota_array[0] . ' ' : '');
                              $templateProcessor->setValue("tempat_tujuan#2", isset($kab_kota_array[1]) ? $kab_kota_array[1] . ',' : '');
                              $templateProcessor->setValue("tempat_tujuan#3", isset($kab_kota_array[2]) ? $kab_kota_array[2] . ',' : '');
                
                              $templateProcessor->setValue("tempat_tujuan_1_kota#0", 'Kota Bandung');
                              $templateProcessor->setValue("tempat_tujuan_2_kota#0", '');
                              $templateProcessor->setValue("tempat_tujuan_3_kota#0", '');
                          }elseif(count($kab_kota_array) == 2){
                            $templateProcessor->setValue("tempat_tujuan#1", isset($kab_kota_array[0]) ? $kab_kota_array[0] . ',' : '');
                            $templateProcessor->setValue("tempat_tujuan#2", isset($kab_kota_array[1]) ? $kab_kota_array[1] . ' ' : '');
                            $templateProcessor->setValue("tempat_tujuan#3", isset($kab_kota_array[2]) ? $kab_kota_array[2] . ',' : '');
                
                            $templateProcessor->setValue("tempat_tujuan_1_kota#0", '');
                            $templateProcessor->setValue("tempat_tujuan_2_kota#0", 'Kota Bandung');
                            $templateProcessor->setValue("tempat_tujuan_3_kota#0", '');
                          }else{
                            $templateProcessor->setValue("tempat_tujuan#1", isset($kab_kota_array[0]) ? $kab_kota_array[0] . ',' : '');
                            $templateProcessor->setValue("tempat_tujuan#2", isset($kab_kota_array[1]) ? $kab_kota_array[1] . ',' : '');
                            $templateProcessor->setValue("tempat_tujuan#3", isset($kab_kota_array[2]) ? $kab_kota_array[2] . ' ' : '');
                
                            $templateProcessor->setValue("tempat_tujuan_1_kota#0", '');
                            $templateProcessor->setValue("tempat_tujuan_2_kota#0", '');
                            $templateProcessor->setValue("tempat_tujuan_3_kota#0", 'Kota Bandung');
                          }
                          $templateProcessor->deleteBlock('nomor_induk_pegawai_row');
  
                          
                       
  
                          $filename_bukadis = 'assets/file_surat_perdin/visum_kadis/SPPD_' . date('Ymd') . '_' . $no_grup_perdin . '_' . $kode_tim_file->kode_tim_ketua . '_visum_kadis.docx';
                          $filename_bukadis_simpan = 'SPPD_' . date('Ymd') . '_' . $no_grup_perdin . '_' . $kode_tim_file->kode_tim_ketua . '_visum_kadis.docx';
                          $templateProcessor->saveAs($filename_bukadis);
                         
                          // var_dump($filename_bukadis_simpan);die();
                          $data = [
                              'file_srt_visum_kadis' => $filename_bukadis_simpan,
                          ];
                          $update_perdin = $this->m_perdin->update_e_perdin($pegawai['id_perdin'], $data);
                        }

                } else {
                    $templateFile = 'assets/file_surat_perdin/template_surat_perdin/surat_perintah_template_bu_kadis_tipe1.docx';
                      // Memproses file template yang dipilih

                      $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor($templateFile);

                      // Lanjutkan dengan pengisian data ke dalam template...

                      $arrblnRomawi = array("I","II","III","IV","V","VI",'VII','VIII','IX','X','XI','XII');
                      $blnRomawi = $arrblnRomawi[date("m")-1];
                      
                      // Pastikan menggunakan setlocale untuk format bahasa Indonesia
                      setlocale(LC_TIME, 'id_ID.utf8');

                      // Mendapatkan hari, tanggal, bulan, dan tahun
                      $hari_ttd = strftime('%A', time()); // Nama hari
                      $tgl_ttd = strftime('%d', time()); // Tanggal (angka)
                      $bln_ttd = strftime('%B', time()); // Nama bulan

                      // Ganti "Pebruari" menjadi "Februari"
                      $bln_ttd = str_replace("Pebruari", "Februari", $bln_ttd); // Nama bulan
                      $tahun_text = strftime('%Y', time()); // Tahun (angka)
                      // Membuat nomor random
                      $random_number = mt_rand(1000, 9999); // Nomor random 4 digit

                      // Mendapatkan tanggal hari ini dalam format DDMMYYYY
                      $tanggal_hari_ini = date('dmY');

                      // Menggabungkan semua elemen menjadi nomor dengan format yang diinginkan
                      $nomor_format = $random_number . '/LKK/kemitraan/' . $tanggal_hari_ini;

                      foreach ($filtered_data_bu_kadis as $index => $pegawai) {
                        // Hanya proses data dengan ID tertentu
                        if ($pegawai['id_pegawai'] != 1152) {
                            continue; // Lewati iterasi jika ID tidak sesuai
                        }
                        //  var_dump($pegawai);die();

                        $tujuan_keberangkatan_perdin = $this->m_perdin->get_tujuan_keberangkatan_perdin($pegawai['no_grup_perdin'], $pegawai['id_tim']);

                        $kab_kota_array = [];
                        if (!empty($tujuan_keberangkatan_perdin)) {
                            foreach ($tujuan_keberangkatan_perdin as $rowlist) {
                                // Decode jika kab_kota dalam format JSON
                                $decoded = json_decode($rowlist->kab_kota, true);
                                if (is_array($decoded)) {
                                    $kab_kota_array = array_merge($kab_kota_array, $decoded); // Gabungkan jika array
                                } else {
                                    $kab_kota_array[] = $rowlist->kab_kota; // Tambahkan langsung jika bukan JSON
                                }
                            }
                        } else {
                            echo "No data available"; // Tampilkan pesan jika data kosong
                        }
                        $tujuan_keberangkatan_perdin = $this->m_perdin->get_tujuan_keberangkatan_perdin($pegawai['no_grup_perdin'], $pegawai['id_tim']);
                        
                        $tanggalBerangkat_1 = $tujuan_keberangkatan_perdin[0]->tanggal_berangkat_1;
                        $tanggalBerangkat_2 = $tujuan_keberangkatan_perdin[0]->tanggal_berangkat_2;
                        $tanggalBerangkat_3 = $tujuan_keberangkatan_perdin[0]->tanggal_berangkat_3;
              
                        $tanggal_pulang_1 = $tujuan_keberangkatan_perdin[0]->tanggal_pulang_1;
                        $tanggal_pulang_2 = $tujuan_keberangkatan_perdin[0]->tanggal_pulang_2;
                        $tanggal_pulang_3 = $tujuan_keberangkatan_perdin[0]->tanggal_pulang_3;
        
                        setlocale(LC_TIME, 'id_ID.UTF-8', 'Indonesian', 'id_ID');

                        // Format tanggal dengan strftime
                        // Format tanggal dengan strftime
                        $tanggal_pulang_1 = strftime('%d %B %Y', strtotime($tanggal_pulang_1));
                        if ($tanggal_pulang_2 == "0000-00-00") {
                          $tanggal_pulang_2 = '';
                        } else {
                          // Format the date only if it's a valid date
                          $tanggal_pulang_2 = strftime('%d %B %Y', strtotime($tanggal_pulang_2));
                        }
            
                        // Check if $tanggal_pulang_3 is "0000-00-00" and set it to an empty string if true
                        if ($tanggal_pulang_3 == "0000-00-00") {
                          $tanggal_pulang_3 = '';
                        } else {
                          // Format the date only if it's a valid date
                          $tanggal_pulang_3 = strftime('%d %B %Y', strtotime($tanggal_pulang_3));
                        }

                        $tglKeberangkatan_1 = strftime('%d %B %Y', strtotime($tanggalBerangkat_1));
                        $tglKeberangkatan_2 = strftime('%d %B %Y', strtotime($tanggalBerangkat_2));
                        $tglKeberangkatan_3 = strftime('%d %B %Y', strtotime($tanggalBerangkat_3));

                        // Ganti "Pebruari" menjadi "Februari"
                        $bulan_salah = 'Pebruari';
                        $bulan_benar = 'Februari';

                        $tanggal_pulang_1 = str_replace($bulan_salah, $bulan_benar, $tanggal_pulang_1);
                        $tanggal_pulang_2 = str_replace($bulan_salah, $bulan_benar, $tanggal_pulang_2);
                        $tanggal_pulang_3 = str_replace($bulan_salah, $bulan_benar, $tanggal_pulang_3);

                        $tglKeberangkatan_1 = str_replace($bulan_salah, $bulan_benar, $tglKeberangkatan_1);
                        $tglKeberangkatan_2 = str_replace($bulan_salah, $bulan_benar, $tglKeberangkatan_2);
                        $tglKeberangkatan_3 = str_replace($bulan_salah, $bulan_benar, $tglKeberangkatan_3);
                        // Format tanggal dengan strftime
                        $tglKeberangkatan = strftime('%d %B %Y', strtotime($pegawai['tanggal_berangkat']));
                        $tglKepulangan = strftime('%d %B %Y', strtotime($pegawai['tanggal_kembali']));

                        // Pastikan "Februari" ditulis dengan 'F' bukan 'P'
                        $tglKeberangkatan = str_replace('Pebruari', 'Februari', $tglKeberangkatan);
                        $tglKepulangan = str_replace('Pebruari', 'Februari', $tglKepulangan);
                        // var_dump($tglKeberangkatan);die();
                        if ($tanggalBerangkat_1 == "0000-00-00") {
                          $templateProcessor->setValue("tglKeberangkatan_1", '');
                          $templateProcessor->setValue("tanggal_pulang_1", '');
                          $templateProcessor->setValue("tgl_kepulangan#1", $tanggal_pulang_1);
            
                        }else{
                          $templateProcessor->setValue("tglKeberangkatan_1", $tglKeberangkatan_1);
                          $templateProcessor->setValue("tanggal_pulang_1", $tanggal_pulang_1);
                          
                          if ($tanggalBerangkat_2 === "0000-00-00") {
                              if ($pegawai['lama_p_d'] == 1) {
                                  $templateProcessor->setValue("tgl_kepulangan_sp1", '');
                              } else {
                                  $templateProcessor->setValue("tgl_kepulangan_sp1", "sampai dengan " . $tanggal_pulang_2);
                              }
                              $templateProcessor->setValue("tgl_kepulangan1", $tanggal_pulang_1);
            
                          } else {
                              $templateProcessor->setValue("tgl_kepulangan_sp1", '');
                              $templateProcessor->setValue("tgl_kepulangan1", '');
            
                          }
                        
            
                        }
                        if ($tanggalBerangkat_2 == "0000-00-00") {
                          // var_dump($tanggalBerangkat_2);die();
            
                          $templateProcessor->setValue("tglKeberangkatan_2", '');
                          $templateProcessor->setValue("tanggal_pulang_2", '');
                          
                          $templateProcessor->setValue("tgl_kepulangan2", "");
                          if ($tanggalBerangkat_3 == "0000-00-00") {
                            if ($pegawai['lama_p_d'] == 1) {
                              $templateProcessor->setValue("tgl_kepulangan_sp2", '');
                            } else {
                                $templateProcessor->setValue("tgl_kepulangan_sp2", "sampai dengan " . $tanggal_pulang_2);
                            }
                          }else{
                            $templateProcessor->setValue("tgl_kepulangan_sp2", "sampai dengan " . $tanggal_pulang_3);
                          }
                        }else{
                          $templateProcessor->setValue("tglKeberangkatan_2", $tglKeberangkatan_2);
                          $templateProcessor->setValue("tanggal_pulang_2", $tanggal_pulang_2);
                          // var_dump($pegawai['lama_p_d']);die();
            
                          if ($tanggalBerangkat_3 == "0000-00-00") {
                            if ($pegawai['lama_p_d'] == 1) {
                              $templateProcessor->setValue("tgl_kepulangan_sp2", '');
                            } else {
                                $templateProcessor->setValue("tgl_kepulangan_sp2", "sampai dengan " . $tanggal_pulang_2);
                            }
                            $templateProcessor->setValue("tgl_kepulangan2", $tanggal_pulang_2);
            
                          }else{
                            $templateProcessor->setValue("tgl_kepulangan2", "");
                            $templateProcessor->setValue("tgl_kepulangan_sp2", "sampai dengan " . $tanggal_pulang_3);
                          }
            
                        }
                        if ($tanggalBerangkat_3 == "0000-00-00") {
                          $templateProcessor->setValue("tglKeberangkatan_3", '');
                          $templateProcessor->setValue("tanggal_pulang_3", '');
                          $templateProcessor->setValue("tgl_kepulangan3", "");
                          $templateProcessor->setValue("tgl_kepulangan_sp3", '');
                        }else{
                          $templateProcessor->setValue("tglKeberangkatan_3", $tglKeberangkatan_3);
                          $templateProcessor->setValue("tanggal_pulang_3", $tanggal_pulang_3);
                          $templateProcessor->setValue("tgl_kepulangan3", $tanggal_pulang_3);
                          $templateProcessor->setValue("tgl_kepulangan_sp3", '');
                        }
                      
                        
                        // Sanitasi untuk srt_instansi_undangan agar aman untuk penggunaan dalam dokumen Word
                        $srtInstansiUndangan = htmlspecialchars($pegawai['srt_instansi_undangan'], ENT_QUOTES, 'UTF-8');

                        $kabupatenKota = ucwords(strtolower($pegawai['nama_tujuan'][0]->n_kabupaten));
                    
                        // Menetapkan nilai pada placeholder di template
                        $templateProcessor->setValue("jabatan", $pegawai['jabatan']);
                        $templateProcessor->setValue("ada", $srtInstansiUndangan);
                        $templateProcessor->setValue("mksd", $pegawai['mksd_pemberangkatan']);
                        $templateProcessor->setValue("kode_rekening_sub_keg", $pegawai['kode_rek_sub_req']);
                        $templateProcessor->setValue("srt_perihal_undangan", $pegawai['perihal_srt_undangan']);
                        $templateProcessor->setValue("srt_nmr_undangan", $pegawai['nmr_srt_undangan']);
                        $templateProcessor->setValue("tgl_srt_undangan", $pegawai['tgl_srt_undangan']);
                          $templateProcessor->setValue("tgl_srt_undangan#{$index}", $tgl_srt_undangan);

                $location_details = [];
                
                if (!empty($detail_tempat_1) && isset($kab_kota_array[0])) {
                    $location_details[] = $detail_tempat_1 . ' ' . $kab_kota_array[0];
                }
                if (!empty($detail_tempat_2) && isset($kab_kota_array[1])) {
                    $location_details[] = $detail_tempat_2 . ' ' . $kab_kota_array[1];
                }
                if (!empty($detail_tempat_3) && isset($kab_kota_array[2])) {
                    $location_details[] = $detail_tempat_3 . ' ' . $kab_kota_array[2];
                }
                
                $final_location_string = implode(', ', $location_details);
                
                $templateProcessor->setValue("brtmpt", $final_location_string);
                        $templateProcessor->setValue("lama_perdin", $pegawai['lama_p_d']);
                        $templateProcessor->setValue("tgl_keberangkatan", $tglKeberangkatan);
                        $templateProcessor->setValue("tgl_kepulangan", $tglKepulangan);
                        $templateProcessor->setValue("kabupaten_kota_bertempatan", $kabupatenKota);
                        $templateProcessor->setValue("kepada_nama", $pegawai['nama_pegawai']);
                        $templateProcessor->setValue("kode_rek", $pegawai['kode_rek']);
                        $templateProcessor->setValue("arahan_pimpinan", $pegawai['dasar_arahan_pimpiman']);
                        $templateProcessor->setValue("kode_tim", $kode_tim);
                        $templateProcessor->setValue("no_urut", $no_grup_perdin);
                        $templateProcessor->setValue("kendaraan", $pegawai['kendaraan']);
                        // Cek apakah nip ada, jika ada maka kolom nip akan muncul
                        if (!empty($pegawai['pangkat_gol']) && strtolower($pegawai['pangkat_gol']) != 'tenaga kontrak') {
                            $templateProcessor->setValue("nama_kolom_nip", 'Nomor Induk Pegawai');
                            $templateProcessor->setValue("nip", $pegawai['nip']);
                            $pangkatGolongan = (isset($pegawai['pangkat_gol']) && isset($pegawai['golongan']) && $pegawai['pangkat_gol'] !== '' && $pegawai['golongan'] !== '' && $pegawai['pangkat_gol'] !== 'Tenaga Kontrak') 
                            ? $pegawai['pangkat_gol'] . ' (' . $pegawai['golongan'] .')'
                            : 'Non ASN';
                
                
                                            $templateProcessor->setValue("Pangkat_golongan", $pangkatGolongan);


                        } else {
                          $templateProcessor->setValue("nama_kolom_nip#{$index}", 'Nomor Induk Pegawai');
                          $templateProcessor->setValue("nip#{$index}", '-');
                          $pangkatGolongan = (isset($pegawai['pangkat_gol']) && isset($pegawai['golongan']) && $pegawai['pangkat_gol'] !== '' && $pegawai['golongan'] !== '' && $pegawai['pangkat_gol'] !== 'Tenaga Kontrak') 
                          ? $pegawai['pangkat_gol'] . ' (' . $pegawai['golongan'] .')'
                          : 'Non ASN';
              
              
                                          $templateProcessor->setValue("Pangkat_golongan", $pangkatGolongan);
                        }
                        $templateProcessor->setValue("Pangkat_golongan_visum#{$index}", $pangkatGolongan);

                        $templateProcessor->setValue("jabatan", $pegawai['jabatan']); 
                        $templateProcessor->setValue("golongan", $pegawai['golongan']); 

                        if (count($kab_kota_array) == 1) {
                            $templateProcessor->setValue("tempat_tujuan#1", isset($kab_kota_array[0]) ? $kab_kota_array[0] . ' ' : '');
                            $templateProcessor->setValue("tempat_tujuan#2", isset($kab_kota_array[1]) ? $kab_kota_array[1] . ',' : '');
                            $templateProcessor->setValue("tempat_tujuan#3", isset($kab_kota_array[2]) ? $kab_kota_array[2] . ',' : '');
              
                            $templateProcessor->setValue("tempat_tujuan_1_kota#0", 'Kota Bandung');
                            $templateProcessor->setValue("tempat_tujuan_2_kota#0", '');
                            $templateProcessor->setValue("tempat_tujuan_3_kota#0", '');
                        }elseif(count($kab_kota_array) == 2){
                          $templateProcessor->setValue("tempat_tujuan#1", isset($kab_kota_array[0]) ? $kab_kota_array[0] . ',' : '');
                          $templateProcessor->setValue("tempat_tujuan#2", isset($kab_kota_array[1]) ? $kab_kota_array[1] . ' ' : '');
                          $templateProcessor->setValue("tempat_tujuan#3", isset($kab_kota_array[2]) ? $kab_kota_array[2] . ',' : '');
              
                          $templateProcessor->setValue("tempat_tujuan_1_kota#0", '');
                          $templateProcessor->setValue("tempat_tujuan_2_kota#0", 'Kota Bandung');
                          $templateProcessor->setValue("tempat_tujuan_3_kota#0", '');
                        }else{
                          $templateProcessor->setValue("tempat_tujuan#1", isset($kab_kota_array[0]) ? $kab_kota_array[0] . ',' : '');
                          $templateProcessor->setValue("tempat_tujuan#2", isset($kab_kota_array[1]) ? $kab_kota_array[1] . ',' : '');
                          $templateProcessor->setValue("tempat_tujuan#3", isset($kab_kota_array[2]) ? $kab_kota_array[2] . ' ' : '');
              
                          $templateProcessor->setValue("tempat_tujuan_1_kota#0", '');
                          $templateProcessor->setValue("tempat_tujuan_2_kota#0", '');
                          $templateProcessor->setValue("tempat_tujuan_3_kota#0", 'Kota Bandung');
                        }
                        $templateProcessor->deleteBlock('nomor_induk_pegawai_row');

                        
                     

                        $filename_bukadis = 'assets/file_surat_perdin/kadis_sekdis/SPPD_' . date('Ymd') . '_' . $no_grup_perdin . '_' . $kode_tim_file->kode_tim_ketua . '_kadis.docx';
                        $filename_bukadis_simpan = 'SPPD_' . date('Ymd') . '_' . $no_grup_perdin . '_' . $kode_tim_file->kode_tim_ketua . '_kadis.docx';
                        
                        $data = [
                            'file_srt' => $filename_bukadis_simpan,
                        ];
                        $update_perdin = $this->m_perdin->update_e_perdin($pegawai['id_perdin'], $data);

                        $templateProcessor->saveAs($filename_bukadis);
                      }
                        $templateFile = 'assets/file_surat_perdin/template_surat_perdin/visum_kadis.docx';
                        // Memproses file template yang dipilih
  
                        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor($templateFile);
  
                        // Lanjutkan dengan pengisian data ke dalam template...
  
                        $arrblnRomawi = array("I","II","III","IV","V","VI",'VII','VIII','IX','X','XI','XII');
                        $blnRomawi = $arrblnRomawi[date("m")-1];
                        
                        // Pastikan menggunakan setlocale untuk format bahasa Indonesia
                        setlocale(LC_TIME, 'id_ID.utf8');
  
                        // Mendapatkan hari, tanggal, bulan, dan tahun
                        $hari_ttd = strftime('%A', time()); // Nama hari
                        $tgl_ttd = strftime('%d', time()); // Tanggal (angka)
                        $bln_ttd = strftime('%B', time()); // Nama bulan

                        // Ganti "Pebruari" menjadi "Februari"
                        $bln_ttd = str_replace("Pebruari", "Februari", $bln_ttd); // Nama bulan
                        $tahun_text = strftime('%Y', time()); // Tahun (angka)
                        // Membuat nomor random
                        $random_number = mt_rand(1000, 9999); // Nomor random 4 digit
  
                        // Mendapatkan tanggal hari ini dalam format DDMMYYYY
                        $tanggal_hari_ini = date('dmY');
  
                        // Menggabungkan semua elemen menjadi nomor dengan format yang diinginkan
                        $nomor_format = $random_number . '/LKK/kemitraan/' . $tanggal_hari_ini;
  
                        foreach ($filtered_data_bu_kadis as $index => $pegawai) {
                          // Hanya proses data dengan ID tertentu
                          if ($pegawai['id_pegawai'] != 1152) {
                              continue; // Lewati iterasi jika ID tidak sesuai
                          }
                          //  var_dump($pegawai);die();
  
                          $tujuan_keberangkatan_perdin = $this->m_perdin->get_tujuan_keberangkatan_perdin($pegawai['no_grup_perdin'], $pegawai['id_tim']);
  
                          $kab_kota_array = [];
                          if (!empty($tujuan_keberangkatan_perdin)) {
                              foreach ($tujuan_keberangkatan_perdin as $rowlist) {
                                  // Decode jika kab_kota dalam format JSON
                                  $decoded = json_decode($rowlist->kab_kota, true);
                                  if (is_array($decoded)) {
                                      $kab_kota_array = array_merge($kab_kota_array, $decoded); // Gabungkan jika array
                                  } else {
                                      $kab_kota_array[] = $rowlist->kab_kota; // Tambahkan langsung jika bukan JSON
                                  }
                              }
                          } else {
                              echo "No data available"; // Tampilkan pesan jika data kosong
                          }
                          $tujuan_keberangkatan_perdin = $this->m_perdin->get_tujuan_keberangkatan_perdin($pegawai['no_grup_perdin'], $pegawai['id_tim']);
                          
                          $tanggalBerangkat_1 = $tujuan_keberangkatan_perdin[0]->tanggal_berangkat_1;
                          $tanggalBerangkat_2 = $tujuan_keberangkatan_perdin[0]->tanggal_berangkat_2;
                          $tanggalBerangkat_3 = $tujuan_keberangkatan_perdin[0]->tanggal_berangkat_3;
                
                          $tanggal_pulang_1 = $tujuan_keberangkatan_perdin[0]->tanggal_pulang_1;
                          $tanggal_pulang_2 = $tujuan_keberangkatan_perdin[0]->tanggal_pulang_2;
                          $tanggal_pulang_3 = $tujuan_keberangkatan_perdin[0]->tanggal_pulang_3;
          
                          setlocale(LC_TIME, 'id_ID.UTF-8', 'Indonesian', 'id_ID');
  
                          // Format tanggal dengan strftime
                          // Format tanggal dengan strftime
                          $tanggal_pulang_1 = strftime('%d %B %Y', strtotime($tanggal_pulang_1));
                          if ($tanggal_pulang_2 == "0000-00-00") {
                            $tanggal_pulang_2 = '';
                          } else {
                            // Format the date only if it's a valid date
                            $tanggal_pulang_2 = strftime('%d %B %Y', strtotime($tanggal_pulang_2));
                          }
              
                          // Check if $tanggal_pulang_3 is "0000-00-00" and set it to an empty string if true
                          if ($tanggal_pulang_3 == "0000-00-00") {
                            $tanggal_pulang_3 = '';
                          } else {
                            // Format the date only if it's a valid date
                            $tanggal_pulang_3 = strftime('%d %B %Y', strtotime($tanggal_pulang_3));
                          }
  
                          $tglKeberangkatan_1 = strftime('%d %B %Y', strtotime($tanggalBerangkat_1));
                          $tglKeberangkatan_2 = strftime('%d %B %Y', strtotime($tanggalBerangkat_2));
                          $tglKeberangkatan_3 = strftime('%d %B %Y', strtotime($tanggalBerangkat_3));
  
                          // Ganti "Pebruari" menjadi "Februari"
                          $bulan_salah = 'Pebruari';
                          $bulan_benar = 'Februari';
  
                          $tanggal_pulang_1 = str_replace($bulan_salah, $bulan_benar, $tanggal_pulang_1);
                          $tanggal_pulang_2 = str_replace($bulan_salah, $bulan_benar, $tanggal_pulang_2);
                          $tanggal_pulang_3 = str_replace($bulan_salah, $bulan_benar, $tanggal_pulang_3);
  
                          $tglKeberangkatan_1 = str_replace($bulan_salah, $bulan_benar, $tglKeberangkatan_1);
                          $tglKeberangkatan_2 = str_replace($bulan_salah, $bulan_benar, $tglKeberangkatan_2);
                          $tglKeberangkatan_3 = str_replace($bulan_salah, $bulan_benar, $tglKeberangkatan_3);
                          // Format tanggal dengan strftime
                          $tglKeberangkatan = strftime('%d %B %Y', strtotime($pegawai['tanggal_berangkat']));
                          $tglKepulangan = strftime('%d %B %Y', strtotime($pegawai['tanggal_kembali']));
  
                          // Pastikan "Februari" ditulis dengan 'F' bukan 'P'
                          $tglKeberangkatan = str_replace('Pebruari', 'Februari', $tglKeberangkatan);
                          $tglKepulangan = str_replace('Pebruari', 'Februari', $tglKepulangan);
                          // var_dump($tglKeberangkatan);die();
                          if ($tanggalBerangkat_1 == "0000-00-00") {
                            $templateProcessor->setValue("tglKeberangkatan_1", '');
                            $templateProcessor->setValue("tanggal_pulang_1", '');
                            $templateProcessor->setValue("tgl_kepulangan#1", $tanggal_pulang_1);
              
                          }else{
                            $templateProcessor->setValue("tglKeberangkatan_1", $tglKeberangkatan_1);
                            $templateProcessor->setValue("tanggal_pulang_1", $tanggal_pulang_1);
                            
                            if ($tanggalBerangkat_2 === "0000-00-00") {
                                if ($pegawai['lama_p_d'] == 1) {
                                    $templateProcessor->setValue("tgl_kepulangan_sp1", '');
                                } else {
                                    $templateProcessor->setValue("tgl_kepulangan_sp1", "sampai dengan " . $tanggal_pulang_2);
                                }
                                $templateProcessor->setValue("tgl_kepulangan1", $tanggal_pulang_1);
              
                            } else {
                                $templateProcessor->setValue("tgl_kepulangan_sp1", '');
                                $templateProcessor->setValue("tgl_kepulangan1", '');
              
                            }
                          
              
                          }
                          if ($tanggalBerangkat_2 == "0000-00-00") {
                            // var_dump($tanggalBerangkat_2);die();
              
                            $templateProcessor->setValue("tglKeberangkatan_2", '');
                            $templateProcessor->setValue("tanggal_pulang_2", '');
                            
                            $templateProcessor->setValue("tgl_kepulangan2", "");
                            if ($tanggalBerangkat_3 == "0000-00-00") {
                              if ($pegawai['lama_p_d'] == 1) {
                                $templateProcessor->setValue("tgl_kepulangan_sp2", '');
                              } else {
                                  $templateProcessor->setValue("tgl_kepulangan_sp2", "sampai dengan " . $tanggal_pulang_2);
                              }
                            }else{
                              $templateProcessor->setValue("tgl_kepulangan_sp2", "sampai dengan " . $tanggal_pulang_3);
                            }
                          }else{
                            $templateProcessor->setValue("tglKeberangkatan_2", $tglKeberangkatan_2);
                            $templateProcessor->setValue("tanggal_pulang_2", $tanggal_pulang_2);
                            // var_dump($pegawai['lama_p_d']);die();
              
                            if ($tanggalBerangkat_3 == "0000-00-00") {
                              if ($pegawai['lama_p_d'] == 1) {
                                $templateProcessor->setValue("tgl_kepulangan_sp2", '');
                              } else {
                                  $templateProcessor->setValue("tgl_kepulangan_sp2", "sampai dengan " . $tanggal_pulang_2);
                              }
                              $templateProcessor->setValue("tgl_kepulangan2", $tanggal_pulang_2);
              
                            }else{
                              $templateProcessor->setValue("tgl_kepulangan2", "");
                              $templateProcessor->setValue("tgl_kepulangan_sp2", "sampai dengan " . $tanggal_pulang_3);
                            }
              
                          }
                          if ($tanggalBerangkat_3 == "0000-00-00") {
                            $templateProcessor->setValue("tglKeberangkatan_3", '');
                            $templateProcessor->setValue("tanggal_pulang_3", '');
                            $templateProcessor->setValue("tgl_kepulangan3", "");
                            $templateProcessor->setValue("tgl_kepulangan_sp3", '');
                          }else{
                            $templateProcessor->setValue("tglKeberangkatan_3", $tglKeberangkatan_3);
                            $templateProcessor->setValue("tanggal_pulang_3", $tanggal_pulang_3);
                            $templateProcessor->setValue("tgl_kepulangan3", $tanggal_pulang_3);
                            $templateProcessor->setValue("tgl_kepulangan_sp3", '');
                          }
                        
                          
                          // Sanitasi untuk srt_instansi_undangan agar aman untuk penggunaan dalam dokumen Word
                          $srtInstansiUndangan = htmlspecialchars($pegawai['srt_instansi_undangan'], ENT_QUOTES, 'UTF-8');
  
                          $kabupatenKota = ucwords(strtolower($pegawai['nama_tujuan'][0]->n_kabupaten));
                      
                          // Menetapkan nilai pada placeholder di template
                          $templateProcessor->setValue("jabatan", $pegawai['jabatan']);
                          $templateProcessor->setValue("ada", $srtInstansiUndangan);
                          $templateProcessor->setValue("mksd", $pegawai['mksd_pemberangkatan']);
                          $templateProcessor->setValue("kode_rekening_sub_keg", $pegawai['kode_rek_sub_req']);
                          $templateProcessor->setValue("srt_perihal_undangan", $pegawai['perihal_srt_undangan']);
                          $templateProcessor->setValue("srt_nmr_undangan", $pegawai['nmr_srt_undangan']);
                           $tgl_srt_undangan = strftime('%d %B %Y', strtotime($pegawai['tgl_srt_undangan']));
                            $templateProcessor->setValue("tgl_srt_undangan#{$index}", $tgl_srt_undangan);

                            $location_details = [];
                            
                            if (!empty($detail_tempat_1) && isset($kab_kota_array[0])) {
                                $location_details[] = $detail_tempat_1 . ' ' . $kab_kota_array[0];
                            }
                            if (!empty($detail_tempat_2) && isset($kab_kota_array[1])) {
                                $location_details[] = $detail_tempat_2 . ' ' . $kab_kota_array[1];
                            }
                            if (!empty($detail_tempat_3) && isset($kab_kota_array[2])) {
                                $location_details[] = $detail_tempat_3 . ' ' . $kab_kota_array[2];
                            }
                            
                            $final_location_string = implode(', ', $location_details);
                            
                            $templateProcessor->setValue("brtmpt", $final_location_string);
                          $templateProcessor->setValue("lama_perdin", $pegawai['lama_p_d']);
                          $templateProcessor->setValue("tgl_keberangkatan", $tglKeberangkatan);
                          $templateProcessor->setValue("tgl_kepulangan", $tglKepulangan);
                          $templateProcessor->setValue("kabupaten_kota_bertempatan", $kabupatenKota);
                          $templateProcessor->setValue("kepada_nama", $pegawai['nama_pegawai']);
                          $templateProcessor->setValue("kode_rek", $pegawai['kode_rek']);
                          $templateProcessor->setValue("arahan_pimpinan", $pegawai['dasar_arahan_pimpiman']);
                          $templateProcessor->setValue("kode_tim", $kode_tim);
                          $templateProcessor->setValue("no_urut", $no_grup_perdin);
                          $templateProcessor->setValue("kendaraan", $pegawai['kendaraan']);
                          // Cek apakah nip ada, jika ada maka kolom nip akan muncul
                          if (!empty($pegawai['pangkat_gol']) && strtolower($pegawai['pangkat_gol']) != 'tenaga kontrak') {
                              $templateProcessor->setValue("nama_kolom_nip", 'Nomor Induk Pegawai');
                              $templateProcessor->setValue("nip", $pegawai['nip']);
                              $pangkatGolongan = (isset($pegawai['pangkat_gol']) && isset($pegawai['golongan']) && $pegawai['pangkat_gol'] !== '' && $pegawai['golongan'] !== '' && $pegawai['pangkat_gol'] !== 'Tenaga Kontrak') 
                              ? $pegawai['pangkat_gol'] . ' (' . $pegawai['golongan'] .')'
                              : 'Non ASN';
                  
                  
                                              $templateProcessor->setValue("Pangkat_golongan", $pangkatGolongan);
  
  
                          } else {
                            $templateProcessor->setValue("nama_kolom_nip#{$index}", 'Nomor Induk Pegawai');
                            $templateProcessor->setValue("nip#{$index}", '-');
                            $pangkatGolongan = (isset($pegawai['pangkat_gol']) && isset($pegawai['golongan']) && $pegawai['pangkat_gol'] !== '' && $pegawai['golongan'] !== '' && $pegawai['pangkat_gol'] !== 'Tenaga Kontrak') 
                            ? $pegawai['pangkat_gol'] . ' (' . $pegawai['golongan'] .')'
                            : 'Non ASN';
                
                
                                            $templateProcessor->setValue("Pangkat_golongan", $pangkatGolongan);
                          }
                          $templateProcessor->setValue("Pangkat_golongan_visum#{$index}", $pangkatGolongan);
  
                          $templateProcessor->setValue("jabatan", $pegawai['jabatan']); 
                          $templateProcessor->setValue("golongan", $pegawai['golongan']); 
  
                          if (count($kab_kota_array) == 1) {
                              $templateProcessor->setValue("tempat_tujuan#1", isset($kab_kota_array[0]) ? $kab_kota_array[0] . ' ' : '');
                              $templateProcessor->setValue("tempat_tujuan#2", isset($kab_kota_array[1]) ? $kab_kota_array[1] . ',' : '');
                              $templateProcessor->setValue("tempat_tujuan#3", isset($kab_kota_array[2]) ? $kab_kota_array[2] . ',' : '');
                
                              $templateProcessor->setValue("tempat_tujuan_1_kota#0", 'Kota Bandung');
                              $templateProcessor->setValue("tempat_tujuan_2_kota#0", '');
                              $templateProcessor->setValue("tempat_tujuan_3_kota#0", '');
                          }elseif(count($kab_kota_array) == 2){
                            $templateProcessor->setValue("tempat_tujuan#1", isset($kab_kota_array[0]) ? $kab_kota_array[0] . ',' : '');
                            $templateProcessor->setValue("tempat_tujuan#2", isset($kab_kota_array[1]) ? $kab_kota_array[1] . ' ' : '');
                            $templateProcessor->setValue("tempat_tujuan#3", isset($kab_kota_array[2]) ? $kab_kota_array[2] . ',' : '');
                
                            $templateProcessor->setValue("tempat_tujuan_1_kota#0", '');
                            $templateProcessor->setValue("tempat_tujuan_2_kota#0", 'Kota Bandung');
                            $templateProcessor->setValue("tempat_tujuan_3_kota#0", '');
                          }else{
                            $templateProcessor->setValue("tempat_tujuan#1", isset($kab_kota_array[0]) ? $kab_kota_array[0] . ',' : '');
                            $templateProcessor->setValue("tempat_tujuan#2", isset($kab_kota_array[1]) ? $kab_kota_array[1] . ',' : '');
                            $templateProcessor->setValue("tempat_tujuan#3", isset($kab_kota_array[2]) ? $kab_kota_array[2] . ' ' : '');
                
                            $templateProcessor->setValue("tempat_tujuan_1_kota#0", '');
                            $templateProcessor->setValue("tempat_tujuan_2_kota#0", '');
                            $templateProcessor->setValue("tempat_tujuan_3_kota#0", 'Kota Bandung');
                          }
                          $templateProcessor->deleteBlock('nomor_induk_pegawai_row');
  
                          
                       
  
                          $filename_bukadis = 'assets/file_surat_perdin/visum_kadis/SPPD_' . date('Ymd') . '_' . $no_grup_perdin . '_' . $kode_tim_file->kode_tim_ketua . '_visum_kadis.docx';
                          $filename_bukadis_simpan = 'SPPD_' . date('Ymd') . '_' . $no_grup_perdin . '_' . $kode_tim_file->kode_tim_ketua . '_visum_kadis.docx';
                          $templateProcessor->saveAs($filename_bukadis);
                         
                          // var_dump($filename_bukadis_simpan);die();
                          $data = [
                              'file_srt_visum_kadis' => $filename_bukadis_simpan,
                          ];
                          $update_perdin = $this->m_perdin->update_e_perdin($pegawai['id_perdin'], $data);
                        }

                }
              }
          } else {
          }
        } else {
            // Jika $pkepada bukan array, gunakan template default
            $templateFile = 'assets/file_surat_perdin/template_surat_perdin/surat_perintah_template_1_orang_tipe1.docx';
        }

      
        // var_dump('tidak masuk kondisi');die();

        $filtered_data = array_filter($data_pegawai, function($item) {
          return $item['id_pegawai'] != 1152 && $item['id_pegawai'] != 31;
        });

        // Mengatur ulang indeks array

        if (isset($_FILES["file_srt"]) && $_FILES["file_srt"]["name"] != "") {
          foreach ($filtered_data as $index => $pegawai) {
            $file = $_FILES["file_srt"]["name"];
            $ext = pathinfo($file, PATHINFO_EXTENSION);


            // Menentukan direktori tujuan
            $target_dir = "assets/file_surat_perdin/upload/";

            // Membuat nama file baru yang unik, bisa dengan menambahkan user_id dan timestamp
            // $file_srt = 'SPPD_upload' . $user_id . '_' . time() . '.' . $ext;
            $file_srt = 'SPPD_' . date('Ymd') . '_' . $no_grup_perdin . '_' . $kode_tim_file->kode_tim_ketua . '_pegawai_upload.'.$ext;

            // Menentukan path file baru
            $target_file = $target_dir . $file_srt;

            // Memindahkan file yang di-upload ke direktori tujuan dengan nama file baru
            $upload = move_uploaded_file($_FILES["file_srt"]["tmp_name"], $target_file);
            
            
            $data = [
                'file_srt' => $file_srt,
            ];
            
            $update_perdin = $this->m_perdin->update_e_perdin($pegawai['id_perdin'], $data);
          }
            if (!$update_perdin) {
                $this->session->set_flashdata('gagal', "Gagal menyimpan file DOCX.");
                redirect('/perdin/suratperintah/');
                exit;
            }
            $namafile = 'SPPD_'.$datename;

            if ($this->db->trans_status() === FALSE) {
                $this->session->set_flashdata('gagal', "Gagal menyimpan data perjalanan dinas.");
            } else {
                $this->session->set_flashdata('sukses', "Berhasil menyimpan data perjalanan dinas.");
            }
          
          redirect('/perdin/suratperintah');
        }else{
        
          $filtered_data = array_values($filtered_data);

          // Menghitung jumlah data
          $count = count($filtered_data);
          // Kondisi default jika "31" dan "931" tidak ditemukan
          
          if ($count == 1) {

              if ($tipe_undangan == 1) {

                  $templateFile = 'assets/file_surat_perdin/template_surat_perdin/surat_perintah_template_1_orang_tipe1.docx';
              } elseif($tipe_undangan == 3) {
                $templateFile = 'assets/file_surat_perdin/template_surat_perdin/template_arahan_pimpinan/surat_perintah_template_1_orang_arahan_pimpinan.docx';

              }else{
                $templateFile = 'assets/file_surat_perdin/template_surat_perdin/surat_perintah_template_1_orang.docx';

              }
          } elseif ($count == 2) {
              if ($tipe_undangan == 1) {

                  $templateFile = 'assets/file_surat_perdin/template_surat_perdin/surat_perintah_template_2_orang_tipe1.docx';
              } elseif($tipe_undangan == 3) {
                $templateFile = 'assets/file_surat_perdin/template_surat_perdin/template_arahan_pimpinan/surat_perintah_template_2_orang_arahan_pimpinan.docx';

              } else {
                $templateFile = 'assets/file_surat_perdin/template_surat_perdin/surat_perintah_template_2_orang.docx';

              }
          } elseif ($count == 3) {
              if ($tipe_undangan == 1) {
                  $templateFile = 'assets/file_surat_perdin/template_surat_perdin/surat_perintah_template_3_orang_tipe1.docx';
              } elseif($tipe_undangan == 3) {
                $templateFile = 'assets/file_surat_perdin/template_surat_perdin/template_arahan_pimpinan/surat_perintah_template_3_orang_arahan_pimpinan.docx';

              } else {
                  $templateFile = 'assets/file_surat_perdin/template_surat_perdin/surat_perintah_template_3_orang.docx';
              }
          } elseif ($count == 4) {

              if ($tipe_undangan == 1) {
                  $templateFile = 'assets/file_surat_perdin/template_surat_perdin/surat_perintah_template_4_orang_tipe1.docx';
              } elseif($tipe_undangan == 3) {
                $templateFile = 'assets/file_surat_perdin/template_surat_perdin/template_arahan_pimpinan/surat_perintah_template_4_orang_arahan_pimpinan.docx';
              } else {
                  $templateFile = 'assets/file_surat_perdin/template_surat_perdin/surat_perintah_template_4_orang.docx';
              }
          } else {
              $templateFile = 'assets/file_surat_perdin/template_surat_perdin/surat_perintah_template_1_orang_tipe1.docx';
          }


          // Memproses file template yang dipilih
          $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor($templateFile);

          // Lanjutkan dengan pengisian data ke dalam template...

          $arrblnRomawi = array("I","II","III","IV","V","VI",'VII','VIII','IX','X','XI','XII');
          $blnRomawi = $arrblnRomawi[date("m")-1];
          
          // Pastikan menggunakan setlocale untuk format bahasa Indonesia
          setlocale(LC_TIME, 'id_ID.utf8');

          // Mendapatkan hari, tanggal, bulan, dan tahun
          $hari_ttd = strftime('%A', time()); // Nama hari
          $tgl_ttd = strftime('%d', time()); // Tanggal (angka)
          $bln_ttd = strftime('%B', time()); // Nama bulan

              // Ganti "Pebruari" menjadi "Februari"
              $bln_ttd = str_replace("Pebruari", "Februari", $bln_ttd); // Nama bulan
          $tahun_text = strftime('%Y', time()); // Tahun (angka)
          // Membuat nomor random
          $random_number = mt_rand(1000, 9999); // Nomor random 4 digit

          // Mendapatkan tanggal hari ini dalam format DDMMYYYY
          $tanggal_hari_ini = date('dmY');
          // var_dump($kode_tim_file->kode_tim_ketua);die();
          // $kode_tim = "/\${no_surat}/$kode_tim_file";
          $kode_tim = $kode_tim_file->kode_tim_ketua;

          // $nomor_format_1= $no_grup_perdin.'/$a{no_surat}/'.$kode_tim_file .'/'. $kode_tim_file;45/{no_surat}/PK/PK
          
          foreach ($filtered_data as $index => $pegawai) {
            $nomor_format_1= '45/${no_surat}/PK/PK';

            $tujuan_keberangkatan_perdin = $this->m_perdin->get_tujuan_keberangkatan_perdin($pegawai['no_grup_perdin'], $pegawai['id_tim']);

            $kab_kota_array = [];
            if (!empty($tujuan_keberangkatan_perdin)) {
                foreach ($tujuan_keberangkatan_perdin as $rowlist) {
                    // Decode jika kab_kota dalam format JSON
                    $decoded = json_decode($rowlist->kab_kota, true);
                    if (is_array($decoded)) {
                        $kab_kota_array = array_merge($kab_kota_array, $decoded); // Gabungkan jika array
                    } else {
                        $kab_kota_array[] = $rowlist->kab_kota; // Tambahkan langsung jika bukan JSON
                    }
                }
            } else {
                echo "No data available"; // Tampilkan pesan jika data kosong
            }

            $detail_tempat_1 = $tujuan_keberangkatan_perdin[0]->detail_tempat_1;
            $detail_tempat_2 = $tujuan_keberangkatan_perdin[0]->detail_tempat_2;
            $detail_tempat_3 = $tujuan_keberangkatan_perdin[0]->detail_tempat_3;

            $tanggalBerangkat_1 = $tujuan_keberangkatan_perdin[0]->tanggal_berangkat_1;
            $tanggalBerangkat_2 = $tujuan_keberangkatan_perdin[0]->tanggal_berangkat_2;
            $tanggalBerangkat_3 = $tujuan_keberangkatan_perdin[0]->tanggal_berangkat_3;

            $tanggal_pulang_1 = $tujuan_keberangkatan_perdin[0]->tanggal_pulang_1;
            $tanggal_pulang_2 = $tujuan_keberangkatan_perdin[0]->tanggal_pulang_2;
            $tanggal_pulang_3 = $tujuan_keberangkatan_perdin[0]->tanggal_pulang_3;

            // Pastikan sistem menggunakan Bahasa Indonesia
            setlocale(LC_TIME, 'id_ID.UTF-8', 'Indonesian', 'id_ID');

            // Format tanggal dengan strftime
           // Format tanggal dengan strftime
            $tanggal_pulang_1 = strftime('%d %B %Y', strtotime($tanggal_pulang_1));
            // Check if $tanggal_pulang_2 is "0000-00-00" and set it to an empty string if true
            if ($tanggal_pulang_2 == "0000-00-00") {
              $tanggal_pulang_2 = '';
            } else {
              // Format the date only if it's a valid date
              $tanggal_pulang_2 = strftime('%d %B %Y', strtotime($tanggal_pulang_2));
            }

            // Check if $tanggal_pulang_3 is "0000-00-00" and set it to an empty string if true
            if ($tanggal_pulang_3 == "0000-00-00") {
              $tanggal_pulang_3 = '';
            } else {
              // Format the date only if it's a valid date
              $tanggal_pulang_3 = strftime('%d %B %Y', strtotime($tanggal_pulang_3));
            }

            // var_dump($tanggal_pulang_2);die();

            $tglKeberangkatan_1 = strftime('%d %B %Y', strtotime($tanggalBerangkat_1));
            $tglKeberangkatan_2 = strftime('%d %B %Y', strtotime($tanggalBerangkat_2));
            $tglKeberangkatan_3 = strftime('%d %B %Y', strtotime($tanggalBerangkat_3));

            // Ganti "Pebruari" menjadi "Februari"
            $bulan_salah = 'Pebruari';
            $bulan_benar = 'Februari';

            $tanggal_pulang_1 = str_replace($bulan_salah, $bulan_benar, $tanggal_pulang_1);
            $tanggal_pulang_2 = str_replace($bulan_salah, $bulan_benar, $tanggal_pulang_2);
            $tanggal_pulang_3 = str_replace($bulan_salah, $bulan_benar, $tanggal_pulang_3);
            $tglKeberangkatan_1 = str_replace($bulan_salah, $bulan_benar, $tglKeberangkatan_1);
            $tglKeberangkatan_2 = str_replace($bulan_salah, $bulan_benar, $tglKeberangkatan_2);
            $tglKeberangkatan_3 = str_replace($bulan_salah, $bulan_benar, $tglKeberangkatan_3);
            // Format tanggal dengan strftime
            $tglKeberangkatan = strftime('%d %B %Y', strtotime($pegawai['tanggal_berangkat']));
            $tglKepulangan = strftime('%d %B %Y', strtotime($pegawai['tanggal_kembali']));

            // Pastikan "Februari" ditulis dengan 'F' bukan 'P'
            $tglKeberangkatan = str_replace('Pebruari', 'Februari', $tglKeberangkatan);
            $tglKepulangan = str_replace('Pebruari', 'Februari', $tglKepulangan);

            
            // Sanitasi untuk srt_instansi_undangan agar aman untuk penggunaan dalam dokumen Word
            $srtInstansiUndangan = htmlspecialchars($pegawai['srt_instansi_undangan'], ENT_QUOTES, 'UTF-8');

            $kabupatenKota = ucwords(strtolower($pegawai['nama_tujuan'][0]->n_kabupaten));
            setlocale(LC_TIME, 'id_ID.UTF-8', 'Indonesian', 'id_ID');

            

            // var_dump($kab_kota_array[0]);die();
            
            // Menetapkan nilai pada placeholder di template
            $templateProcessor->setValue("jabatan#{$index}", $pegawai['jabatan']);
            $templateProcessor->setValue("ada#{$index}", $srtInstansiUndangan);
            $templateProcessor->setValue("mksd#{$index}", $pegawai['mksd_pemberangkatan']);
            $templateProcessor->setValue("kode_rekening_sub_keg#{$index}", $pegawai['kode_rek_sub_req']);
            $templateProcessor->setValue("srt_perihal_undangan#{$index}", $pegawai['perihal_srt_undangan']);
            $templateProcessor->setValue("srt_nmr_undangan#{$index}", $pegawai['nmr_srt_undangan']);

            $tgl_srt_undangan = strftime('%d %B %Y', strtotime($pegawai['tgl_srt_undangan']));
            // Pastikan "Februari" ditulis dengan 'F' bukan 'P'
            $tgl_srt_undangan = str_replace('Pebruari', 'Februari', $tgl_srt_undangan);
            

            $templateProcessor->setValue("tgl_srt_undangan#{$index}", $tgl_srt_undangan);

            $location_details = [];
            
            if (!empty($detail_tempat_1) && isset($kab_kota_array[0])) {
                $location_details[] = $detail_tempat_1 . ' ' . $kab_kota_array[0];
            }
            if (!empty($detail_tempat_2) && isset($kab_kota_array[1])) {
                $location_details[] = $detail_tempat_2 . ' ' . $kab_kota_array[1];
            }
            if (!empty($detail_tempat_3) && isset($kab_kota_array[2])) {
                $location_details[] = $detail_tempat_3 . ' ' . $kab_kota_array[2];
            }
            
            $final_location_string = implode(', ', $location_details);
            $templateProcessor->setValue("brtmpt#{$index}", $final_location_string);
            // var_dump($pegawai['tanggal_sp_backdate']);die();
            if ($pegawai['tanggal_sp_backdate'] == '0000-00-00' || $pegawai['tanggal_sp_backdate'] === false) {

            }else{
              $tanggal_sp_backdate = strftime('%d %B %Y', strtotime($pegawai['tanggal_sp_backdate']));
              $templateProcessor->setValue("tgl_surat", $tanggal_sp_backdate);
            }

          
            $templateProcessor->setValue("tgl_keberangkatan#{$index}", $tglKeberangkatan);
            
            $templateProcessor->setValue("lama_perdin#{$index}", $pegawai['lama_p_d']);
            $templateProcessor->setValue("arahan_pimpinan#{$index}", $pegawai['dasar_arahan_pimpiman']);
            $templateProcessor->setValue("kendaraan", $pegawai['kendaraan']);
            $templateProcessor->setValue("kabupaten_kota_bertempatan#{$index}", $kabupatenKota);
    

              if ($tanggalBerangkat_1 == "0000-00-00") {
                      $templateProcessor->setValue("tglKeberangkatan_1", '');
                      $templateProcessor->setValue("tanggal_pulang_1", '');
                      $templateProcessor->setValue("tgl_kepulangan#1", $tanggal_pulang_1);
        
                    }else{

                      $templateProcessor->setValue("tglKeberangkatan_1", $tglKeberangkatan_1);
                      $templateProcessor->setValue("tanggal_pulang_1", $tanggal_pulang_1);
                      
                      if ($tanggalBerangkat_2 === "0000-00-00") {

                        if ($pegawai['lama_p_d'] == 1) {
                            $templateProcessor->setValue("tgl_kepulangan_sp1", '');
                        } elseif (!empty($tanggal_pulang_2)) {
                            // Jika $tanggal_pulang_2 ada nilainya
                            $templateProcessor->setValue("tgl_kepulangan_sp1", "sampai dengan " . $tanggal_pulang_2);
                        }else {
                          // var_dump("tgl_kepulangan_sp1", "sampai dengan " . $tanggal_pulang_1);die();

                          $templateProcessor->setValue("tgl_kepulangan_sp1", "sampai dengan " . $tanggal_pulang_1);
                        }
                    
                        $templateProcessor->setValue("tgl_kepulangan1", $tanggal_pulang_1);
                    
                    } else {
                        $templateProcessor->setValue("tgl_kepulangan_sp1", '');
                        $templateProcessor->setValue("tgl_kepulangan1", '');
                    }
                    
                    
        
                    }
                    if ($tanggalBerangkat_2 == "0000-00-00") {
                      // var_dump($tanggalBerangkat_2);die();
        
                      $templateProcessor->setValue("tglKeberangkatan_2", '');
                      $templateProcessor->setValue("tanggal_pulang_2", '');
                      
                      $templateProcessor->setValue("tgl_kepulangan2", "");
                      if ($tanggalBerangkat_3 == "0000-00-00") {
                        if ($pegawai['lama_p_d'] == 1) {
                          $templateProcessor->setValue("tgl_kepulangan_sp2", '');
                        } elseif (!empty($tanggal_pulang_2)) {
                          // Jika $tanggal_pulang_2 ada nilainya
                          $templateProcessor->setValue("tgl_kepulangan_sp2", "sampai dengan " . $tanggal_pulang_2);
                        }else {
                          // var_dump("tgl_kepulangan_sp1", "sampai dengan " . $tanggal_pulang_1);die();

                          // $templateProcessor->setValue("tgl_kepulangan_sp2", "sampai dengan " . $tanggal_pulang_1);

                          $templateProcessor->setValue("tgl_kepulangan_sp2", '');
                          
                        }
                      }else{
                        $templateProcessor->setValue("tgl_kepulangan_sp2", "sampai dengan " . $tanggal_pulang_3);
                      }
                    }else{
                      $templateProcessor->setValue("tglKeberangkatan_2", $tglKeberangkatan_2);
                      $templateProcessor->setValue("tanggal_pulang_2", $tanggal_pulang_2);
                      // var_dump($pegawai['lama_p_d']);die();
        
                      if ($tanggalBerangkat_3 == "0000-00-00") {
                        if ($pegawai['lama_p_d'] == 1) {
                          $templateProcessor->setValue("tgl_kepulangan_sp2", '');
                        } else {
                            $templateProcessor->setValue("tgl_kepulangan_sp2", "sampai dengan " . $tanggal_pulang_2);
                        }
                        $templateProcessor->setValue("tgl_kepulangan2", $tanggal_pulang_2);
        
                      }else{
                        $templateProcessor->setValue("tgl_kepulangan2", "");
                        $templateProcessor->setValue("tgl_kepulangan_sp2", "sampai dengan " . $tanggal_pulang_3);
                      }
        
                    }
                    if ($tanggalBerangkat_3 == "0000-00-00") {
                      $templateProcessor->setValue("tglKeberangkatan_3", '');
                      $templateProcessor->setValue("tanggal_pulang_3", '');
                      $templateProcessor->setValue("tgl_kepulangan3", "");
                      $templateProcessor->setValue("tgl_kepulangan_sp3", '');
                    }else{
                      $templateProcessor->setValue("tglKeberangkatan_3", $tglKeberangkatan_3);
                      $templateProcessor->setValue("tanggal_pulang_3", $tanggal_pulang_3);
                      $templateProcessor->setValue("tgl_kepulangan3", $tanggal_pulang_3);
                      $templateProcessor->setValue("tgl_kepulangan_sp3", '');
                    }
          


            if (count($kab_kota_array) == 1) {
                $templateProcessor->setValue("tempat_tujuan#1", isset($kab_kota_array[0]) ? $kab_kota_array[0] . ' ' : '');
                $templateProcessor->setValue("tempat_tujuan#2", isset($kab_kota_array[1]) ? $kab_kota_array[1] . ',' : '');
                $templateProcessor->setValue("tempat_tujuan#3", isset($kab_kota_array[2]) ? $kab_kota_array[2] . ',' : '');


                $templateProcessor->setValue("tempat_tujuan_1_kota#0", 'Kota Bandung');
                $templateProcessor->setValue("tempat_tujuan_2_kota#0", '');
                $templateProcessor->setValue("tempat_tujuan_3_kota#0", '');
            }elseif(count($kab_kota_array) == 2){
              $templateProcessor->setValue("tempat_tujuan#1", isset($kab_kota_array[0]) ? $kab_kota_array[0] . ',' : '');
              $templateProcessor->setValue("tempat_tujuan#2", isset($kab_kota_array[1]) ? $kab_kota_array[1] . ' ' : '');
              $templateProcessor->setValue("tempat_tujuan#3", isset($kab_kota_array[2]) ? $kab_kota_array[2] . ',' : '');

              $templateProcessor->setValue("tempat_tujuan_1_kota#0", '');
              $templateProcessor->setValue("tempat_tujuan_2_kota#0", 'Kota Bandung');
              $templateProcessor->setValue("tempat_tujuan_3_kota#0", '');
            }else{
              $templateProcessor->setValue("tempat_tujuan#1", isset($kab_kota_array[0]) ? $kab_kota_array[0] . ',' : '');
              $templateProcessor->setValue("tempat_tujuan#2", isset($kab_kota_array[1]) ? $kab_kota_array[1] . ',' : '');
              $templateProcessor->setValue("tempat_tujuan#3", isset($kab_kota_array[2]) ? $kab_kota_array[2] . ' ' : '');

              $templateProcessor->setValue("tempat_tujuan_1_kota#0", '');
              $templateProcessor->setValue("tempat_tujuan_2_kota#0", '');
              $templateProcessor->setValue("tempat_tujuan_3_kota#0", 'Kota Bandung');
            }
          

            // $templateProcessor->setValue("tempat_tujuan#1", isset($kab_kota_array[0]) ? $kab_kota_array[0] . ',' : '');
            // $templateProcessor->setValue("tempat_tujuan#2", isset($kab_kota_array[1]) ? $kab_kota_array[1] . ',' : '');
            // $templateProcessor->setValue("tempat_tujuan#3", isset($kab_kota_array[2]) ? $kab_kota_array[2] . ',' : '');
            $templateProcessor->setValue("tempat_kedudukan", '');
            
            $templateProcessor->setValue("kabupaten_kota_bertempatan#{$index}", $kabupatenKota);
            $templateProcessor->setValue("kabupaten_kota_bertempatan#{$index}", $kabupatenKota);
            // var_dump($nomor_format);

            // Duplicate, bisa dihapus jika tidak diperlukan lagi
            $templateProcessor->setValue("kepada_nama#{$index}", $pegawai['nama_pegawai']);
            $templateProcessor->setValue("kode_tim", $kode_tim);
            $templateProcessor->setValue("no_urut", $no_grup_perdin);
            $templateProcessor->setValue("kode_rek", $pegawai['kode_rek']);

            // Cek apakah nip ada, jika ada maka kolom nip akan muncul
            if (!empty($pegawai['pangkat_gol']) && strtolower($pegawai['pangkat_gol']) != 'tenaga kontrak') {
                $templateProcessor->setValue("nama_kolom_nip#{$index}", 'Nomor Induk Pegawai');
                $templateProcessor->setValue("nip#{$index}", $pegawai['nip']);
                $pangkatGolongan = (isset($pegawai['pangkat_gol']) && isset($pegawai['golongan']) && $pegawai['pangkat_gol'] !== '' && $pegawai['golongan'] !== '' && $pegawai['pangkat_gol'] !== 'Tenaga Kontrak') 
                ? $pegawai['pangkat_gol'] . ' (' . $pegawai['golongan'] .')'
                : 'Non ASN';
    
    
                                $templateProcessor->setValue("Pangkat_golongan#{$index}", $pangkatGolongan);
            } else {
              $templateProcessor->setValue("nama_kolom_nip#{$index}", 'Nomor Induk Pegawai');
              $templateProcessor->setValue("nip#{$index}", '-');
              $pangkatGolongan = (isset($pegawai['pangkat_gol']) && isset($pegawai['golongan']) && $pegawai['pangkat_gol'] !== '' && $pegawai['golongan'] !== '' && $pegawai['pangkat_gol'] !== 'Tenaga Kontrak') 
              ? $pegawai['pangkat_gol'] . ' (' . $pegawai['golongan'] .')'
              : 'Non ASN';


                              $templateProcessor->setValue("Pangkat_golongan#{$index}", $pangkatGolongan);
            }
            $templateProcessor->setValue("Pangkat_golongan_visum#{$index}", $pangkatGolongan);


            $pangkat_gol[] = [
              'pangkat_gol' => "Pangkat_golongan_visum#{$index}",
            ];
            $templateProcessor->setValue("jabatan#{$index}", $pegawai['jabatan']); 
            $templateProcessor->setValue("golongan#{$index}", $pegawai['golongan']); 
            
            
            
            $templateProcessor->deleteBlock('nomor_induk_pegawai_row');
            $filename = 'assets/file_surat_perdin/SPPD_' . date('Ymd') . '_' . $no_grup_perdin . '_' . $kode_tim_file->kode_tim_ketua . '_pegawai.docx';

            $filename_pegawai = 'SPPD_' . date('Ymd') . '_' . $no_grup_perdin . '_' . $kode_tim_file->kode_tim_ketua . '_pegawai.docx';

            $data = [
                'file_srt' => $filename_pegawai,
            ];
            
            $update_perdin = $this->m_perdin->update_e_perdin($pegawai['id_perdin'], $data);
          }
      

            $templateProcessor->saveAs($filename);
                
          
          if (!$update_perdin) {
              $this->session->set_flashdata('gagal', "Gagal menyimpan file DOCX.");
              redirect('/perdin/suratperintah/');
              exit;
          }
          $namafile = 'SPPD_'.$datename;

          if ($this->db->trans_status() === FALSE) {
              $this->session->set_flashdata('gagal', "Gagal menyimpan data perjalanan dinas.");
          } else {
              $this->session->set_flashdata('sukses', "Berhasil menyimpan data perjalanan dinas.");
          }
          
          redirect('/perdin/suratperintah');
        
      
        }
  }
  public function approve_surat_pertama($id)
  {   

      $id_auth = $this->session->userdata('user_id');
      $session = $this->session->userdata("user_id");
      $id_umk = $this->input->post('id_perusahaan');
      $first_name = $this->input->post('namadepan');
      $last_name = $this->input->post('namabelakang');
      $country = $this->input->post('country');
      $street_address1 = $this->input->post('address1'); // Opsional
      $street_address2 = $this->input->post('address2'); // Opsional
      $city = $this->input->post('kota');
      $state = $this->input->post('provinsi');
      $zipcode = $this->input->post('kodepos');
      $phone = $this->input->post('phone');
      $email = $this->input->post('email');
      $ttd = $this->input->post('canvasData');


   
  
      redirect('/perdin/suratperintah');
  }
  
  public function delete_perdin($no_grup_perdin, $id_tim)
  {

      // Mulai transaksi database
      $this->db->trans_start();
  
      // Panggil fungsi hapus_perdin_by_no_grup_perdin
      $hapus = $this->m_perdin->hapus_perdin_by_no_grup_perdin($no_grup_perdin, $id_tim);
      // var_dump($hapus);die();
  
      // Selesaikan transaksi database
      $this->db->trans_complete();
  
      // Periksa status transaksi
      if ($hapus && $this->db->trans_status()) {
          $this->session->set_flashdata('sukses', "Berhasil menghapus data perjalanan dinas.");
      } else {
          log_message('error', 'Gagal menghapus data perjalanan dinas untuk no_grup_perdin: ' . $no_grup_perdin . ', id_tim: ' . $id_tim);
          $this->session->set_flashdata('gagal', "Gagal menghapus data perjalanan dinas.");
      }
  
      // Redirect ke halaman lain setelah penghapusan
      redirect('/perdin/suratperintah');
  }
  public function reload_docx($no_grup_perdin, $id_tim) {
      $perdin_list = $this->m_perdin->get_perdin($no_grup_perdin, $id_tim);
      if(empty($perdin_list)) {
          $this->session->set_flashdata('gagal', 'Data perjalanan dinas tidak ditemukan.');
          redirect('perdin/suratperintah');
          return;
      }
      $first = $perdin_list[0];

      $listizin = [];
      foreach($perdin_list as $p) {
          $listizin[] = $p->id_pegawai;
      }

      $tujuan_keberangkatan = $this->m_perdin->get_tujuan_keberangkatan_perdin($no_grup_perdin, $id_tim);
      $tk = !empty($tujuan_keberangkatan) ? $tujuan_keberangkatan[0] : null;

      $_POST['listizin'] = $listizin;
      $_POST['tglberangkat'] = $tk ? $tk->tanggal_berangkat_1 : $first->tanggal_berangkat;
      $_POST['tglkembali'] = $tk ? $tk->tanggal_pulang_1 : $first->tanggal_kembali;
      $_POST['tglberangkat2'] = $tk ? $tk->tanggal_berangkat_2 : '';
      $_POST['tglkembali2'] = $tk ? $tk->tanggal_pulang_2 : '';
      $_POST['tglberangkat3'] = $tk ? $tk->tanggal_berangkat_3 : '';
      $_POST['tglkembali3'] = $tk ? $tk->tanggal_pulang_3 : '';
      $_POST['detail_tempat_1'] = $tk ? $tk->detail_tempat_1 : '';
      $_POST['detail_tempat_2'] = $tk ? $tk->detail_tempat_2 : '';
      $_POST['detail_tempat_3'] = $tk ? $tk->detail_tempat_3 : '';
      $_POST['titik_lokasi'] = $first->titik_lokasi;
      $_POST['id_perdin'] = $first->id;
      $_POST['uraian'] = $first->uraian;

      $kab_kota_array = [];
      if($tk && $tk->kab_kota) {
          $decoded = json_decode($tk->kab_kota, true);
          if(is_array($decoded)) {
              $kabupaten_db = $this->m_perdin->get_kabupaten();
              foreach($decoded as $nama_kab) {
                  foreach($kabupaten_db as $kdb) {
                      if(strtoupper($kdb->n_kabupaten) == strtoupper($nama_kab)) {
                          $kab_kota_array[] = $kdb->id;
                          break;
                      }
                  }
              }
          }
      }
      $_POST['kabupaten'] = $kab_kota_array;
      $_POST['no__sppd'] = $first->no__sppd;
      $_POST['tgl_surat'] = $first->tgl_surat;
      $_POST['detail_tempat_pemberangkatan'] = $first->detail_tempat_pemberangkatan;
      $_POST['kendaraan'] = $first->kendaraan;
      $_POST['tanggal_sp_backdate'] = $first->tanggal_sp_backdate;
      $_POST['status_approve'] = $first->status_approve;
      $_POST['mksd_pemberangkatan'] = $first->mksd_pemberangkatan;
      $_POST['kode_rek_sub_req'] = $first->kode_rek_sub_req;
      $_POST['perihal_srt_undangan'] = $first->perihal_srt_undangan;
      $_POST['nmr_srt_undangan'] = $first->nmr_srt_undangan;
      $_POST['tgl_srt_undangan'] = $first->tgl_srt_undangan;
      $_POST['tipe_undangan'] = $first->tipe_undangan;
      $_POST['srt_instansi_undangan'] = $first->srt_instansi_undangan;
      $_POST['dasar_arahan_pimpiman'] = $first->dasar_arahan_pimpiman;
      $_POST['pegawai_dinas_lain'] = $first->pegawai_dinas_lain;
      $_POST['kode_rek'] = $first->kode_rek;
      $_POST['file_srt'] = $first->file_srt;
      $_POST['id_tim'] = $id_tim;

      $this->update($no_grup_perdin, $id_tim);
  }
  

}
