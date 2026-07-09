<?php
/*
 * Created By : Jonas Banurea / 25-02-2022
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



    public function cetak_excel($tgla = 0, $tglb = 0){
           $iduser = $this->session->userdata('id_auth');
            if ($this->All) { 
              $admin = 1;
            } else {
              $admin = 0;
            }
           if ($admin == 1 OR $iduser ==197 OR $iduser ==218 OR $iduser ==550 OR $iduser== 543 OR $iduser== 683) {
             $sql = "SELECT * 
                    FROM keu_perdin 
                    WHERE DATE(tgl_pembayaran) BETWEEN ? AND ?
                    
                    ORDER BY  tgl_pembayaran  ASC";
    
            $list_perdin = $this->db->query($sql, array($tgla, $tglb))->result();
           }
           else{
               $sql = "SELECT * 
                    FROM keu_perdin 
                    WHERE DATE(tgl_pembayaran) BETWEEN ? AND ?
                     AND user_id = ? or user_id = 443
                    ORDER BY  tgl_pembayaran  ASC";
    
            $list_perdin = $this->db->query($sql, array($tgla, $tglb, $iduser))->result();
           }

          
            
            header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
            header("Content-Disposition: attachment; filename=REKAP_E-PERDIN_FORMAT_BPK_(DPMPTSP_JABAR).xls");
            header("Expires: 0");
            header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
            header("Cache-Control: private",false);

            echo "<table width='100%' border='0' font-size:15px;font-style:bold;'>";
            echo "E-PERDIN (REKAP PERJALANAN DINAS) DPMPTSP JAWA BARAT (FORMAT BPK)";
            echo "<tr>PERIODE : ".$this->lib_date->mysql_to_human($tgla)." - ".$this->lib_date->mysql_to_human($tglb)."</tr>";
            echo "</table>";
           	

           	 $jd2= " <tr>
                      <td colspan='8'>".''."</td>
                      <td colspan='39' align='center'>".'Biaya Perjalanan Dinas perorangan (Rp)'."</td>
                      <td colspan='4'>".''."</td>
                      <td colspan='20' align='center'>".'Informasi Tiket Perjalanan Dinas'."</td>
                      <td colspan='2'>".''."</td>
                
                                        
                    </tr>";
                      // echo "<table width='100%' border='0' align='center' font-size:16px;'>";
                       echo "</table>";

             echo "<table width='100%' cellspacing='0' cellpadding='0'  border='1' style='border-style:solid; border-width:thin;font-size:14px;font-weight:bold;'>";
             echo $jd2; 

              $jd3= " <tr>
                      <td colspan='8' align='center'>".''."</td>
                      <td colspan='4' align='center'>".'Uang Harian'."</td>
                      <td colspan='4' align='center'>".'Representasi'."</td>
                      <td colspan='4' align='center'>".'Uang Saku Peserta'."</td>
                      <td colspan='4' align='center'>".'Penginapan'."</td>
                      <td colspan='3' align='center'>".'Tiket/E-Tol'."</td>
                      <td colspan='4' align='center'>".'Sewa Taksi (Kota Asal)'."</td>
                      <td colspan='4' align='center'>".'Sewa Taksi (Kota Tujuan)'."</td>
                      <td colspan='4' align='center'>".'Sewa Kendaraan'."</td>
                      <td colspan='4' align='center'>".'BBM'."</td>
                      <td colspan='3' align='center'>".'Swab'."</td>
                      <td colspan='1' align='center'>".'Jumlah Total'."</td>
                      <td colspan='4' align='center'>".''."</td>
                      <td colspan='10' align='center'>".'Berangkat'."</td>
                      <td colspan='10' align='center'>".'Kembali'."</td>
                      <td colspan='2'>".''."</td>

                
                                        
                    </tr>";
                      // echo "<table width='100%' border='0' align='center' font-size:16px;'>";
                       echo "</table>";

             echo "<table width='100%' cellspacing='0' cellpadding='0'  border='1' style='border-style:solid; border-width:thin;font-size:12px;font-weight:bold;'>";
             echo $jd3; 

 
            $jdl= " <tr>
                      <td align='center'>".'NO.'."</td>
                      <td align='center'>".'Bulan '."</td>
                      <td align='center'>".'No BKU'."</td>
                      <td align='center'>".'Uraian'."</td>
                      <td align='center'>".'Tujuan'."</td>
                      <td align='center'>".'Nama Pelaksana'."</td>
                      <td align='center'>".'Jabatan'."</td>
                      <td align='center'>".'SKPD'."</td>
                      <td align='center'>".'Hari'."</td>
                      <td align='center'>".'Satuan'."</td>
                      <td align='center'>".'Harga'."</td>
                      <td align='center'>".'Jumlah'."</td>
                      <td align='center'>".'Hari'."</td>
                      <td align='center'>".'Satuan'."</td>
                      <td align='center'>".'Harga'."</td>
                      <td align='center'>".'Jumlah'."</td>
                      <td align='center'>".'Hari'."</td>
                      <td align='center'>".'Satuan'."</td>
                      <td align='center'>".'Harga'."</td>
                      <td align='center'>".'Jumlah'."</td>
                      <td align='center'>".'Hari'."</td>
                      <td align='center'>".'Satuan'."</td>
                      <td align='center'>".'Harga'."</td>
                      <td align='center'>".'Jumlah'."</td>
                      <td align='center'>".'Pulang'."</td>
                      <td align='center'>".'Pergi'."</td>
                      <td align='center'>".'Jumlah'."</td>
                       <td align='center'>".'Hari'."</td>
                      <td align='center'>".'Satuan'."</td>
                      <td align='center'>".'Harga'."</td>
                      <td align='center'>".'Jumlah'."</td>
                       <td align='center'>".'Hari'."</td>
                      <td align='center'>".'Satuan'."</td>
                      <td align='center'>".'Harga'."</td>
                      <td align='center'>".'Jumlah'."</td>
                       <td align='center'>".'Hari'."</td>
                      <td align='center'>".'Satuan'."</td>
                      <td align='center'>".'Harga'."</td>
                      <td align='center'>".'Jumlah'."</td>
                       <td align='center'>".'Liter'."</td>
                      <td align='center'>".'Satuan'."</td>
                      <td align='center'>".'Harga'."</td>
                      <td align='center'>".'Jumlah'."</td>
                      <td align='center'>".'Di Kota Asal'."</td>
                      <td align='center'>".'Dikota Tujuan'."</td>
                      <td align='center'>".'Jumlah'."</td>
                      <td align='center'>".'Jumlah Total '."</td>
                      <td align='center'>".'No. SPPD'."</td>
                      <td align='center'>".'Lama perjalanan dinas (Hari)'."</td>
                      <td align='center'>".'Tanggal berangkat '."</td>
                      <td align='center'>".'Tanggal kembali'."</td>
                      <td align='center'>".'Maskapai'."</td>
                      <td align='center'>".'Nama'."</td>
                      <td align='center'>".'No Tiket'."</td>
                      <td align='center'>".'Kode Booking'."</td>
                      <td align='center'>".'No penerbangan'."</td>
                      <td align='center'>".'Asal Daerah '."</td>
                      <td align='center'>".'Tujuan '."</td>
                      <td align='center'>".'Tanggal '."</td>
                      <td align='center'>".'Kelas'."</td>
                      <td align='center'>".'Harga Tiket (Rp)'."</td>
                      <td align='center'>".'Maskapai'."</td>
                      <td align='center'>".'Nama'."</td>
                      <td align='center'>".'No Tiket'."</td>
                      <td align='center'>".'Kode Booking'."</td>
                      <td align='center'>".'No penerbangan'."</td>
                      <td align='center'>".'Asal Daerah '."</td>
                      <td align='center'>".'Tujuan '."</td>
                      <td align='center'>".'Tanggal '."</td>
                      <td align='center'>".'Kelas'."</td>
                      <td align='center'>".'Harga Tiket (Rp)'."</td>
                      <td align='center'>".'Nama Penginapan/Hotel'."</td>
                      <td align='center'>".'Keterangan'."</td>
                                        
                    </tr>";
                      // echo "<table width='100%' border='0' font-size:16px;'>";
                       echo "</table>";

             echo "<table width='100%' cellspacing='0' cellpadding='0' border='1' style='border-style:solid; border-width:thin;font-size:10px;font-weight:bold;'>";
             echo $jdl; 

              $jd4= " <tr font-style: italic>
                     <td align='center'>".'1'."</td>
					<td align='center'>".'2'."</td>
					<td align='center'>".'3'."</td>
					<td align='center'>".'4'."</td>
					<td align='center'>".'5'."</td>
					<td align='center'>".'6'."</td>
					<td align='center'>".'7'."</td>
					<td align='center'>".'8'."</td>
					<td align='center'>".'9'."</td>
					<td align='center'>".'10'."</td>
					<td align='center'>".'11'."</td>
					<td align='center'>".'12=9x11'."</td>
					<td align='center'>".'13'."</td>
					<td align='center'>".'14'."</td>
					<td align='center'>".'15'."</td>
					<td align='center'>".'16=13x15'."</td>
					<td align='center'>".'17'."</td>
					<td align='center'>".'18'."</td>
					<td align='center'>".'19'."</td>
					<td align='center'>".'20=17x19'."</td>
					<td align='center'>".'21'."</td>
					<td align='center'>".'22'."</td>
					<td align='center'>".'23'."</td>
					<td align='center'>".'24=21x23'."</td>
					<td align='center'>".'25'."</td>
					<td align='center'>".'26'."</td>
					<td align='center'>".'27=25+26'."</td>
					<td align='center'>".'28'."</td>
					<td align='center'>".'29'."</td>
					<td align='center'>".'30'."</td>
					<td align='center'>".'31=28x30'."</td>
					<td align='center'>".'32'."</td>
					<td align='center'>".'33'."</td>
					<td align='center'>".'34'."</td>
					<td align='center'>".'35=32x34'."</td>
					<td align='center'>".'36'."</td>
					<td align='center'>".'37'."</td>
					<td align='center'>".'38'."</td>
					<td align='center'>".'39=36x38'."</td>
					<td align='center'>".'40'."</td>
					<td align='center'>".'41'."</td>
					<td align='center'>".'42'."</td>
					<td align='center'>".'43=40x42'."</td>
					<td align='center'>".'44'."</td>
					<td align='center'>".'45'."</td>
					<td align='center'>".'46=44+45'."</td>
					<td align='center'>".'47=12+16+20+24+27+31+35+39+43+46'."</td>
					<td align='center'>".'48'."</td>
					<td align='center'>".'49'."</td>
					<td align='center'>".'50'."</td>
					<td align='center'>".'51'."</td>
					<td align='center'>".'52'."</td>
					<td align='center'>".'53'."</td>
					<td align='center'>".'54'."</td>
					<td align='center'>".'55'."</td>
					<td align='center'>".'56'."</td>
					<td align='center'>".'57'."</td>
					<td align='center'>".'58'."</td>
					<td align='center'>".'59'."</td>
					<td align='center'>".'60'."</td>
					<td align='center'>".'61'."</td>
					<td align='center'>".'62'."</td>
					<td align='center'>".'63'."</td>
					<td align='center'>".'64'."</td>
					<td align='center'>".'65'."</td>
					<td align='center'>".'66'."</td>
					<td align='center'>".'67'."</td>
					<td align='center'>".'68'."</td>
					<td align='center'>".'69'."</td>
					<td align='center'>".'70'."</td>
					<td align='center'>".'71'."</td>
					<td align='center'>".'72'."</td>
					<td align='center'>".'73'."</td>

                                        
                    </tr>";
                      // echo "<table width='100%' border='0' font-size:16px;'>";
                       echo "</table>";

             echo "<table width='100%' cellspacing='0' cellpadding='0' border='1' style='border-style:solid; border-width:thin;font-size:10px;font-style:italic;'>";
             echo $jd4; 

            $i=1;
            foreach ($list_perdin as $row){
                  $isi = "<tr>
                        <td>".$i."</td>                        
                        <td>".$this->lib_date->set_month_name(date('m',strtotime($row->tgl_pembayaran)), 'id')."</td>
                        <td>".$row->no_bku."</td>
                        <td>".$row->uraian."</td>
                        <td>".$this->m_perdin->get_n_kabupaten($row->tujuan)."</td>
                        <td>".$this->m_perdin->get_n_pegawai($row->id_pegawai)."</td>
                        <td>".$this->m_perdin->get_n_jabatan($row->id_pegawai)."</td>
                        <td>".$row->skpd."</td>

                        <td>".$row->uang_hari."</td>
                        <td align='center'>".'Hari'."</td>
                        <td>".$this->rupiah($row->harga_hari)."</td>
                        <td style='background-color:#fce4d6'>".$this->rupiah($row->jumlah_uang)."</td>

                        <td>".$row->representasi_hari."</td>
                        <td align='center'>".'Hari'."</td>
                        <td>".$this->rupiah($row->representasi_harga)."</td>
                        <td style='background-color:#fce4d6'>".$this->rupiah($row->jumlah_representasi)."</td>

                        <td>".$row->uang_sakuhari."</td>
                        <td align='center'>".'Hari'."</td>
                        <td>".$this->rupiah($row->uang_sakuharga)."</td>
                        <td style='background-color:#fce4d6'>".$this->rupiah($row->uang_sku_p_j)."</td>

                        <td>".$row->penginapan_malam."</td>
                        <td align='center'>".'Malam'."</td>
                        <td>".$this->rupiah($row->penginapan_harga)."</td>
                        <td style='background-color:#fce4d6'>".$this->rupiah($row->penginapan_jumlah)."</td>

                        <td>".$this->rupiah($row->tikettol_pulang)."</td>
                        <td>".$this->rupiah($row->tikettol_pergi)."</td>
                        <td style='background-color:#fce4d6'>".$this->rupiah($row->tikettol_jumlah)."</td>

                        <td>".$row->s_t_k_asal_hari."</td>
                        <td align='center'>".'Kali'."</td>
                        <td>".$this->rupiah($row->s_t_k_asal_harga)."</td>
                        <td style='background-color:#fce4d6'>".$this->rupiah($row->s_t_k_asal_jumlah)."</td>

                        <td>".$row->s_t_k_tujuan_hari."</td>
                        <td align='center'>".'Kali'."</td>
                        <td>".$this->rupiah($row->s_t_k_tujuan_harga)."</td>
                        <td style='background-color:#fce4d6'>".$this->rupiah($row->s_t_k_tujuan_jumlah)."</td>

                        <td>".$row->sewa_kendaraan_hari."</td>
                        <td align='center'>".'Hari'."</td>
                        <td>".$this->rupiah($row->sewa_kendaraan_harga)."</td>
                        <td style='background-color:#fce4d6'>".$this->rupiah($row->sewa_kendaraan_jumlah)."</td>

                         
                          <td>=\"$row->bbm_liter\"</td>
                        <td align='center'>".'Liter'."</td>
                        <td>".$this->rupiah($row->bbm_harga)."</td>
                        <td style='background-color:#fce4d6'>".$this->rupiah($row->bbm_jumlah)."</td>

                        <td>".$this->rupiah($row->swabdi_kota_asal)."</td>
                        <td>".$this->rupiah($row->swabdi_kota_tujuan)."</td>
                        <td style='background-color:#fce4d6'>".$this->rupiah($row->swab_jumlah)."</td>

                        <td style='background-color:#f8cbad'>".$this->rupiah($row->jumlah_total)."</td>

                        <td>".$row->no__sppd."</td>
                        <td>".$row->lama_p_d."</td>
                        <td>".$this->lib_date->mysql_to_human($row->tanggal_berangkat)."</td>
                        <td>".$this->lib_date->mysql_to_human($row->tanggal_kembali)."</td>

                        <td>".$row->itberangkat_maskapai."</td>
                        <td>".$this->m_perdin->get_n_pegawai($row->id_pegawai)."</td>
                        <td>".$row->itberangkat_no_tiket."</td>
                        <td>".$row->itberangkat_kodebooking."</td>
                        <td>".$row->itberangkat_no_penerbangan."</td>
                        <td>".$this->m_perdin->get_n_kabupaten($row->itberangkat_asal_daerah)."</td>
                        <td>".$this->m_perdin->get_n_kabupaten($row->itberangkat_tujuan)."</td>
                        <td>".$this->lib_date->mysql_to_human($row->itberangkat_tanggal)."</td>
                        <td>".$row->itberangkat_kelas."</td>
                        <td>".$this->rupiah($row->itberangkat_harga_tiket)."</td>

                        <td>".$row->itkembali_maskapai."</td>
                        <td>".$this->m_perdin->get_n_pegawai($row->id_pegawai)."</td>
                        <td>".$row->itkembali_no_tiket."</td>
                        <td>".$row->itkembali_kode_booking."</td>
                        <td>".$row->itkembali_no_penerbangan."</td>
                        <td>".$this->m_perdin->get_n_kabupaten($row->itkembali_asal_daerah)."</td>
                        <td>".$this->m_perdin->get_n_kabupaten($row->itberangkat_tujuan)."</td>
                        <td>".$this->lib_date->mysql_to_human($row->itberangkat_tanggal)."</td>
                        <td>".$row->itberangkat_kelas."</td>
                        <td>".$this->rupiah($row->itberangkat_harga_tiket)."</td>                        

                        <td>".$row->nama_penginapan."</td>
                        <td>".$row->keterangan."</td>
                        

                  </tr>";

                    echo "<table width='100%' cellspacing='0' cellpadding='0' border='1' style='border-style:solid; border-width:thin;font-size:10px;font-style:normal;'>";
            echo $isi; 
             $i++;
          }

             echo "</table>";
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

    public function cetak_excel_rekap() {
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

      $search  = $this->m_perdin->get_data($tgla, $tglb, $admin, $iduser);
        $data['search'] = $search;
        $data['rekap'] = 1;
  
   
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
      $this->template->build('rekap', $this->session_info);
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

      $search  = $this->m_perdin->get_rekap_sp_by_pegawai($tgla, $tglb, $admin, $iduser);
        $data['search'] = $search;
        $data['rekap'] = 0;
      // var_dump($search);die();
   
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
      $this->template->build('rekap', $this->session_info);
    }


    public function addrekap($id = NULL) {
      // $no__sppd = $this->m_perdin->get_no_sppd($id);
      // var_dump($no__sppd);die();
      // $data['perdin'] = $this->m_perdin->get_perdin_sppd($no__sppd);
      // $data['perdin'] = $this->m_perdin->get_perdin_sppd($no__sppd);
      // $data['perdin1'] = $this->m_perdin->get_perdin($id);
      // $data['step'] = "update";
      $data['step'] = "simpan_perdin";
      $method = "save";
      $data['save_method'] = $method;
      $data['kabupaten'] = $this->m_perdin->get_kabupaten();
      $data['lokasi'] = "";
      $data['iduser'] = $this->session->userdata('id_auth');
      // var_dump($data['iduser']);die();
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
      // var_dump($data['list_tim']);die();
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

      // var_dump($iduser);die();
      $data['admin'] = $admin;
      $data['iduser'] = $iduser;

      
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
  $data['perdin_no_grup'] = $this->m_perdin->get_perdin_join_tim_tot($data['perdin_grup']->no_grup_perdin, $data['perdin_grup']->id_tim);

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
  $this->session_info['page_name'] = "Penomoran Surat Perintah Perjalanan Dinas";
  $this->template->build('penomoran_sp_perdin', $this->session_info);
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
            if ($data_file->id_pegawai == "1061") {
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
            $protocol = $_SERVER['REQUEST_SCHEME'];
            $domain = $_SERVER['http_host'];
            $script_filename = $_SERVER["PHP_SELF"];
            // Cek apakah "index.php" ada di dalam string
            if (strpos($script_filename, 'index.php') !== false) {
                // Hapus "index.php" dari string
                $clean_path = str_replace('index.php', '', $script_filename);
            } else {
                $clean_path = $script_filename;
            }
            $n_pesan = "Anda ditugaskan untuk perjalanan dinas pada kegiatan {$data_file->mksd_pemberangkatan} 
            dari tim {$nama_tim} pada tanggal {$tanggal_berangkat} 
            ke {$tujuan[0]}. 

            Surat perintah dapat dilihat pada link berikut:".
            $protocol."://".$domain.$clean_path."survey/sp_saya";
            // var_dump($n_pesan);die();
            
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

  $script_filename = $_SERVER["SCRIPT_FILENAME"];
  // Cek apakah "index.php" ada di dalam string
  if (strpos($script_filename, 'index.php') !== false) {
      // Hapus "index.php" dari string
      $clean_path = str_replace('index.php', '', $script_filename);
  } else {
      $clean_path = $script_filename;
  }
  if ($json->status && $json->status == 'success') {
      // Path file PDF dari API
      $dtpdf = 'http://103.122.5.250/siapi/web/assets/pdf/' . preg_replace('/\s/i', '%20', $namafile) . '.pdf';
      // Path penyimpanan sementara di server
      $newfile = $clean_path.'assets/file_surat_perdin/' . $namafile . '.pdf';

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

  $script_filename = $_SERVER["SCRIPT_FILENAME"];
  // Cek apakah "index.php" ada di dalam string
  if (strpos($script_filename, 'index.php') !== false) {
      // Hapus "index.php" dari string
      $clean_path = str_replace('index.php', '', $script_filename);
  } else {
      $clean_path = $script_filename;
  }

  if ($json->status && $json->status == 'success') {
      // Path file PDF dari API
      $dtpdf = 'http://103.122.5.250/siapi/web/assets/pdf/' . preg_replace('/\s/i', '%20', $namafile) . '.pdf';
      // Path penyimpanan sementara di server
      $newfile = $clean_path . 'assets/file_surat_perdin/' . $namafile . '.pdf';

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
    $prioritas = [1061, 31];

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
        

          if ($tipe_undangan != 2) {

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

            if (in_array("31", $pkepada) || in_array("1061", $pkepada)) {
  
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

                      if ($pegawai['tanggal_sp_backdate'] == '0000-00-00' || $pegawai['tanggal_sp_backdate'] === false) {

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
                if (in_array("1061", $pkepada)) {
                  $filtered_data_bu_kadis = array_filter($data_pegawai, function($item) {
                      return $item['id_pegawai'] == 1061;
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
                          if ($pegawai['id_pegawai'] != 1061) {
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
                            if ($pegawai['id_pegawai'] != 1061) {
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
                          if ($pegawai['id_pegawai'] != 1061) {
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
                            if ($pegawai['id_pegawai'] != 1061) {
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
                          if ($pegawai['id_pegawai'] != 1061) {
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
                            if ($pegawai['id_pegawai'] != 1061) {
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
              return $item['id_pegawai'] != 1061 && $item['id_pegawai'] != 31;
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
                if ($pegawai->id_pegawai == "1061") {
                    continue; // Skip jika ID pegawai 1061
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
                var_dump($data);die();

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
            return $item['id_pegawai'] != 1061 && $item['id_pegawai'] != 31;
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
              return $item['id_pegawai'] != 1061 && $item['id_pegawai'] != 31;
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
              $tgl_srt_undangan = str_replace('Pebruari', 'Februari', $tglKeberangkatan);
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
      $prioritas = [1061, 31];

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
    // var_dump($date_value_pertama);die();
    
    


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

    
    // // Debugging output menggunakan var_dump
    // var_dump([
    //     'tglberangkat' => $tglberangkat,
    //     'tglkembali' => $tglkembali,
    //     'hari1' => $hari1,
    //     'tglberangkat2' => $tglberangkat2,
    //     'tglkembali2' => $tglkembali2,
    //     'hari2' => $hari2,
    //     'tglberangkat3' => $tglberangkat3,
    //     'tglkembali3' => $tglkembali3,
    //     'hari3' => $hari3,
    //     'total_hari' => $total_hari
    // ]);
    // die;
      
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

    
 

        // Cek jika jumlah elemen lebih dari 4, kecuali jika mengandung 1061 dan 31
    
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
        if ($tipe_undangan != 2) {
          if ($lama_p_d > 2) {
             
                $this->session->set_flashdata('gagal',"Batas melakukan perjalan dinas adalah 2 hari dalam minggu pemilihan tanggal" );
                redirect('/perdin/addrekap/');
          }else{
            foreach ($pkepada as $row) {
              $data_pegawai_sudah_perdin = $this->m_perdin->get_data_pegawai_sudah_perdin($date_value_pertama , $date_value_akhir, $row);
              // var_dump($data_pegawai_sudah_perdin);die();
              if($data_pegawai_sudah_perdin[0]->total_lama_p_d >= 2) {
            
                  
                  $data_pegawai = $this->m_perdin->get_n_pegawai($row);
                  
                  $this->db->trans_rollback();
                  if (is_array($data_pegawai) || is_object($data_pegawai)) {
                    // Jika $data_pegawai adalah array atau objek, kita ubah menjadi JSON atau format string lainnya
                    $data_pegawai = json_encode($data_pegawai);
                  }
                // Set flashdata dengan pesan yang lebih jelas
                $this->session->set_flashdata('gagal',$data_pegawai. " sudah melakukan 2 hari perjalanan dinas dalam minggu ini" );
                redirect('/perdin/addrekap/');
              }
            }
          }  
        }
       
       
  
        foreach ($pkepada as $row) {

      
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

          ];

          $pegawai = $this->m_perdin->get_n_pegawai_perdin($row);
          // var_dump($pegawai);die();
          $nip = $this->m_perdin->get_n_nip($row);
          $jabatan = $this->m_perdin->get_n_jabatan($row);
          $kode_tim_file = $this->m_perdin->get_tim_details($id_tim);
      
          // Simpan data dan ambil ID yang dihasilkan
          $id_perdin = $this->m_perdin->save_e_perdin($data);
      
          
      
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
        $this->db->trans_complete();
        
        
        require_once 'assets/phpword/src/PhpWord/Autoloader.php';
        \PhpOffice\PhpWord\Autoloader::register();

        // Menentukan file template berdasarkan jumlah $pkepada
        $templateFile = '';
        $countPkepada = count($pkepada); // Menghitung jumlah elemen dalam $pkepada
        
        if (is_array($pkepada)) {

          if (in_array("31", $pkepada) || in_array("1061", $pkepada)) {

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
              if (in_array("1061", $pkepada)) {
                $filtered_data_bu_kadis = array_filter($data_pegawai, function($item) {
                    return $item['id_pegawai'] == 1061;
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
                        if ($pegawai['id_pegawai'] != 1061) {
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
                          if ($pegawai['id_pegawai'] != 1061) {
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
                        if ($pegawai['id_pegawai'] != 1061) {
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
                          if ($pegawai['id_pegawai'] != 1061) {
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
                        if ($pegawai['id_pegawai'] != 1061) {
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
                          if ($pegawai['id_pegawai'] != 1061) {
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
          return $item['id_pegawai'] != 1061 && $item['id_pegawai'] != 31;
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
            $tgl_srt_undangan = str_replace('Pebruari', 'Februari', $tglKeberangkatan);
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
  
  
  

}