<?php
/*
 * Created By : Jonas Banurea / 25-02-2022
 */

class Perdin extends WRC_AdminCont {
    public function __construct() {
      parent::__construct();
      $this->CI = & get_instance();
      $this->load->model("m_perdin");
	    $base_url = base_url();
      $enabled = FALSE;
  	  $this->All = FALSE;
      $list_auths = $this->session_info['app_list_auth'];
      $rekap = FALSE;

      foreach ($list_auths as $list_auth) {
  			if ($list_auth->id_role === '46') {
          $enabled = TRUE;
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

      $search  = $this->m_perdin->get_data($tgla, $tglb, $admin, $iduser);
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
      $this->template->build('rekap', $this->session_info);
    }


    public function addrekap($id = NULL) {
      // $no__sppd = $this->m_perdin->get_no_sppd($id);
      // var_dump($no__sppd);die();
      // $data['perdin'] = $this->m_perdin->get_perdin_sppd($no__sppd);
      // $data['perdin'] = $this->m_perdin->get_perdin_sppd($no__sppd);
      // $data['perdin1'] = $this->m_perdin->get_perdin($id);
      // $data['step'] = "update";
      $method = "save";
      $data['save_method'] = $method;
      $data['kabupaten'] = $this->m_perdin->get_kabupaten();

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
      $data['list'] = $petugas->order_by('golongan', "DESC")->get();

      $data['itberangkat_asal_daerah1'] = $this->m_perdin->get_kabupaten();
      $data['itberangkat_tujuan1'] = $this->m_perdin->get_kabupaten();
      $data['itkembali_tujuan1'] = $this->m_perdin->get_kabupaten();
      $data['itkembali_asal_daerah1'] = $this->m_perdin->get_kabupaten();

      $data['pegawai'] = $this->m_perdin->get_pegawai(); 
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
      $(document).ready(
                   function() {
                     $('#listizin').multiselect().multiselectfilter({
                       show:'blind',
                       hide:'blind',
                       selectedText:'# dari # terpilih'
                     }
                   );
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
      // $this->template->set_metadata_javascript($js_date);
      $this->load->vars($data);
      $this->session_info['page_name'] = "Rekap Perdin";
      $this->template->build('addperdin', $this->session_info);
  }

    public function suratperintah($id = NULL) {
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
      $data['detailpage'] = '0';

      $search  = $this->m_perdin->get_data_rekap($tgla, $tglb, $admin, $iduser);
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
  	  $data['perdin'] = $this->m_perdin->get_perdin($id);
      $data['step'] = "update";
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

                // $file = $_FILES["file_evidence"]["name"];
                //   $file_name = basename($_FILES["file_evidence"]["name"]);
                //   $ext = pathinfo($file, PATHINFO_EXTENSION);
                  
                //   $target_dir = "assets/assets/calen/ereport/";
                //   $target_file = $target_dir . $file_name;

                //   $fileBaru = $target_dir.'evidence_'.$id.'.'.$ext;

                //   $upload = move_uploaded_file($_FILES["file_evidence"]["tmp_name"], $target_file);

                 

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

  public function update() {

      $id = ($this->input->post('id'));
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
      // var_dump($keterangan);die();


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

}