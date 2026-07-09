<html>
  <head>
    <title>Realisasi Penerimaan</title>
    <style type="text/css">
      .myButton {
        -moz-box-shadow:inset 0px 1px 0px 0px #54a3f7;
        -webkit-box-shadow:inset 0px 1px 0px 0px #54a3f7;
        box-shadow:inset 0px 1px 0px 0px #54a3f7;
        background:-webkit-gradient(linear, left top, left bottom, color-stop(0.05, #007dc1), color-stop(1, #0061a7));
        background:-moz-linear-gradient(top, #007dc1 5%, #0061a7 100%);
        background:-webkit-linear-gradient(top, #007dc1 5%, #0061a7 100%);
        background:-o-linear-gradient(top, #007dc1 5%, #0061a7 100%);
        background:-ms-linear-gradient(top, #007dc1 5%, #0061a7 100%);
        background:linear-gradient(to bottom, #007dc1 5%, #0061a7 100%);
        filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#007dc1', endColorstr='#0061a7',GradientType=0);
        background-color:#007dc1;
        -moz-border-radius:3px;
        -webkit-border-radius:3px;
        border-radius:3px;
        border:1px solid #124d77;
        display:inline-block;
        cursor:pointer;
        color:#ffffff;
        font-family:Arial;
        font-size:13px;
        padding:4px 12px;
        text-decoration:none;
        text-shadow:0px 1px 0px #154682;
      }
      .myButton:hover {
        background:-webkit-gradient(linear, left top, left bottom, color-stop(0.05, #0061a7), color-stop(1, #007dc1));
        background:-moz-linear-gradient(top, #0061a7 5%, #007dc1 100%);
        background:-webkit-linear-gradient(top, #0061a7 5%, #007dc1 100%);
        background:-o-linear-gradient(top, #0061a7 5%, #007dc1 100%);
        background:-ms-linear-gradient(top, #0061a7 5%, #007dc1 100%);
        background:linear-gradient(to bottom, #0061a7 5%, #007dc1 100%);
        filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#0061a7', endColorstr='#007dc1',GradientType=0);
        background-color:#0061a7;
      }
      .myButton:active {
        position:relative;
        top:1px;
      }
    </style>
  </head>
  
  <!--<body onLoad="window.print()">-->
  <body>
    <div id="content">
      <div class="post">
        <div class="title">
          <h2><?php echo $page_name;?></h2>
        </div>
        <!--<form name="form1" method="post"> -->
        <div class="entry">
          <div id="tabs">
            <?php 
            if($list_state == '0') $ctk_asal = "Seluruhnya"; else $ctk_asal = $list_state;
            echo form_open('rekapitulasi/izin/cetak/'. $tgla.'/'.$tglb.'/'.$ctk_asal.'/1');
            
            // EOF() Proses Rekapitulasi
            //inisialisasi tabel dummy rekap izin
            $username = new user();
            $username->where('username', $this->session->userdata('username'))->get();
            $id_user = $username->id;
            $t_jumlah_masuk = 0;
            $t_jumlah_terbit = 0;
            $t_terbit_ambil = 0;
            $t_terbit_proses = 0;
            $t_jumlah_tolak = 0;
            $t_tolak_ambil = 0;
            $t_tolak_proses = 0;
            $t_jml_tolak_FO = 0;
            $t_jumlah_proses = 0;
            if(!$back){ 
	            $delete = "DELETE FROM dmrekap_izin WHERE user_id = '".$id_user."'";
              $del = @mysql_query($delete);
              //EOF() inisialisasi tabel dummy rekap izin
              $query_data = "select id, n_sektor from trsektor order by urutan ASC";
              $results = mysql_query($query_data);
              while($data = mysql_fetch_assoc(@$results)){
                $jumlah_masuk = 0;
                $jumlah_terbit = 0;
                $terbit_ambil = 0;
                $terbit_proses = 0;
                $jumlah_tolak = 0;
                $tolak_ambil = 0;
                $tolak_proses = 0;
                $jml_tolak_FO = 0;
                $jumlah_proses = 0;
                
                $izin = new trperizinan();
                $izin->get_by_id($data['id']);
                $kd_sektor = $izin->id;
                $sektor = new trsektor();
                $sektor->get_by_id($data['id']);
                $list_sektor = $sektor->id;
                
                $permohonan = new tmpermohonan();
                
                $query = "select A.id, A.pendaftaran_id, A.c_izin_selesai, A.status_berkas, A.d_ambil_izin, B.trperizinan_id, G.tgl_surat
                          from tmpermohonan A
                          INNER JOIN tmpermohonan_trperizinan B on A.id = B.tmpermohonan_id
                          LEFT JOIN trperizinan C on B.trperizinan_id = C.id
                          LEFT JOIN tmpermohonan_trstspermohonan as D on A.id = D.tmpermohonan_id
                          LEFT JOIN trstspermohonan as E on E.id = D.trstspermohonan_id
                          LEFT JOIN tmpermohonan_tmsk as F on B.tmpermohonan_id = F.tmpermohonan_id
                          LEFT JOIN tmsk as G on G.id = F.tmsk_id
                          LEFT JOIN trperizinan_trsektor as H on C.id = H.trperizinan_id
                          where H.trsektor_id = '".$data['id']."'
                          and C.kd_izin NOT LIKE '99999'
                          and E.id <> 1 ";
                switch($list_kat){
                  case 0: // untuk tanggal terima Berkas
                    if($list_state === '0') { // Untuk Seluruh Data
                      $query .= "and (A.d_terima_berkas between '$tgla' and '$tglb')";
                    }else{
                      $query .= "and (A.d_terima_berkas between '$tgla' and '$tglb') 
                                 and A.kd_gerai = '$list_state'";
                    }
                    break;
                  case 1: // untuk tanggal selesai
                    if($list_state === '0') { // Untuk Seluruh Data
                      $query .= "and (G.tgl_surat between '$tgla' and '$tglb')";
                    }else{
                      $query .= "and (G.tgl_surat between '$tgla' and '$tglb') 
                                 and A.kd_gerai = '$list_state'";
                    }
                    break;
                  case 2: // untuk tanggal terima Berkas dan tanggal selesai
                    if($list_state === '0') { // Untuk Seluruh Data
                      //$query .= "and (A.d_terima_berkas between '$tgla' and '$tglb') 
                      //           and (G.tgl_surat between '$tgla' and '$tglb')";
                      $query .= "and (A.d_terima_berkas between '$tgla' and '$tglb')";
                    }else{
                      //$query .= "and (A.d_terima_berkas between '$tgla' and '$tglb') 
                      //           and (G.tgl_surat between '$tgla' and '$tglb') 
                      //           and A.kd_gerai = '$list_state'";
                      $query .= "and (A.d_terima_berkas between '$tgla' and '$tglb')";
                    }
                    break;
                }
                $hasil_data = mysql_query($query);
                
                if($lokasi == 'OPD Teknis'){
                  if($list_sektor == $cek_sektor)
                    $hitung = TRUE;
                  else
                    $hitung = FALSE;
                }else{
                  $hitung = TRUE;
                }
                
                if($hitung){
                  $jumlah_masuk = mysql_num_rows(@$hasil_data);
                  $id_jml_masuk = '';
                  $id_jml_tolak_fo = '';
                  $id_jml_terbit = '';
                  $id_terbit_diambil = '';
                  $id_terbit_proses = '';
                  $id_jml_tolak = '';
                  $id_tolak_diambil = '';
                  $id_tolak_proses = '';
                  $id_jml_proses = ''; 
                  while($rows_data = mysql_fetch_assoc(@$hasil_data)){  // menghitung per sektor
                  	$id_jml_masuk .= $rows_data['id'].'^';
                  	$sts_id_jml_masuk = $rows_data['id'].'^';
                    $sts_jml_tolak_FO = 0;   $sts_id_jml_tolak_fo = '';  
                    $sts_jumlah_terbit = 0;  $sts_id_jml_terbit = '';    
                    $sts_terbit_ambil = 0;   $sts_id_terbit_diambil = '';
                    $sts_terbit_proses = 0;  $sts_id_terbit_proses = ''; 
                    $sts_jumlah_tolak = 0;   $sts_id_jml_tolak = '';     
                    $sts_tolak_ambil = 0;    $sts_id_tolak_diambil = ''; 
                    $sts_tolak_proses = 0;   $sts_id_tolak_proses = '';  
                    $sts_jumlah_proses = 0;  $sts_id_jml_proses = '';    
                    if(substr($data['n_sektor'], 0, 1) != '*') { // untuk bukan izin lain2
                      if($rows_data['status_berkas'] == "Izin Ditolak FO"){
                        $jml_tolak_FO++; $id_jml_tolak_fo .= $rows_data['id'].'^';
                        $sts_jml_tolak_FO = 1; $sts_id_jml_tolak_fo = $rows_data['id'].'^';
                      }
                      if($rows_data['status_berkas'] == "Izin Disetujui"){
                      	if($list_kat != 2){
                          $jumlah_terbit++; $id_jml_terbit .= $rows_data['id'].'^';
                          $sts_jumlah_terbit = 1; $sts_id_jml_terbit = $rows_data['id'].'^';
                        }else{
                          if($rows_data['tgl_surat'] >= $tgla && $rows_data['tgl_surat'] <= $tglb){
                            $jumlah_terbit++; $id_jml_terbit .= $rows_data['id'].'^';
                            $sts_jumlah_terbit = 1; $sts_id_jml_terbit = $rows_data['id'].'^';	
                          }
                        }
                      }
                      if($rows_data['status_berkas'] == "Izin Disetujui" && $rows_data['d_ambil_izin'] != NULL){
                      	if($list_kat != 2){
                          $terbit_ambil++; $id_terbit_diambil .= $rows_data['id'].'^';
                          $sts_terbit_ambil = 1; $sts_id_terbit_diambil = $rows_data['id'].'^';
                        }else{
                          if($rows_data['tgl_surat'] >= $tgla && $rows_data['tgl_surat'] <= $tglb){
                            $terbit_ambil++; $id_terbit_diambil .= $rows_data['id'].'^';
                            $sts_terbit_ambil = 1; $sts_id_terbit_diambil = $rows_data['id'].'^';
                          }
                        }
                      }
                      if($rows_data['status_berkas'] == "Izin Disetujui" && $rows_data['d_ambil_izin'] == NULL){
                      	if($list_kat != 2){
                          $terbit_proses++; $id_terbit_proses .= $rows_data['id'].'^';
                          $sts_terbit_proses = 1; $sts_id_terbit_proses = $rows_data['id'].'^';
                        }else{
                          if($rows_data['tgl_surat'] >= $tgla && $rows_data['tgl_surat'] <= $tglb){
                            $terbit_proses++; $id_terbit_proses .= $rows_data['id'].'^';
                            $sts_terbit_proses = 1; $sts_id_terbit_proses = $rows_data['id'].'^';
                          }
                        }
                      }
                      if($rows_data['status_berkas'] == "Izin Ditolak"){
                      	if($list_kat != 2){
                          $jumlah_tolak++; $id_jml_tolak .= $rows_data['id'].'^';
                          $sts_jumlah_tolak = 1; $sts_id_jml_tolak = $rows_data['id'].'^';
                        }else{
                          if($rows_data['tgl_surat'] >= $tgla && $rows_data['tgl_surat'] <= $tglb){
                            $jumlah_tolak++; $id_jml_tolak .= $rows_data['id'].'^';
                            $sts_jumlah_tolak = 1; $sts_id_jml_tolak = $rows_data['id'].'^';
                          }
                        }
                      }
                      $tolak_ambil = 0; $id_tolak_diambil = '';                                                 //$tolak_ambil++;
                      $sts_tolak_ambil = 0; $sts_id_tolak_diambil = '';
                      $tolak_proses = $jumlah_tolak; $id_tolak_proses = $id_jml_tolak;                          //$tolak_proses++;
                      $sts_tolak_proses = $sts_jumlah_tolak; $sts_id_tolak_proses = $sts_id_jml_tolak;
                      
                      if($list_kat != 2){
                      	if($rows_data['status_berkas'] == "proses"){
                          $jumlah_proses++; $id_jml_proses .= $rows_data['id'].'^';
                          $sts_jumlah_proses = 1; $sts_id_jml_proses = $rows_data['id'].'^';
                        }
                      }else{
                          if($rows_data['tgl_surat'] >= $tgla && $rows_data['tgl_surat'] <= $tglb){
                            $jumlah_proses++; $id_jml_proses .= $rows_data['id'].'^';
                            $sts_jumlah_proses = 1; $sts_id_jml_proses = $rows_data['id'].'^';	
                          }
                        }
                      // Rekap Per Perizinan
                      $trperizinan_id = $rows_data['trperizinan_id'];
                      $dmrekap_izin = new dmrekap_izin();
                      $dmrekap_izin->where('user_id = '.$id_user.' AND trsektor_id = '.$data['id'].' AND trperizinan_id = '.$trperizinan_id)->get();
                      if($dmrekap_izin->id){
                        $xdata = array('jml_masuk'         => $dmrekap_izin->jml_masuk         + 1,                               
                                       'id_jml_masuk'      => $dmrekap_izin->id_jml_masuk      . $sts_id_jml_masuk,
                                       'jml_tolak_fo'      => $dmrekap_izin->jml_tolak_fo      + $sts_jml_tolak_FO,
                                       'id_jml_tolak_fo'   => $dmrekap_izin->id_jml_tolak_fo   . $sts_id_jml_tolak_fo,
                                       'jml_terbit'        => $dmrekap_izin->jml_terbit        + $sts_jumlah_terbit,
                                       'id_jml_terbit'     => $dmrekap_izin->id_jml_terbit     . $sts_id_jml_terbit,
                                       'terbit_diambil'    => $dmrekap_izin->terbit_diambil    + $sts_terbit_ambil,
                                       'id_terbit_diambil' => $dmrekap_izin->id_terbit_diambil . $sts_id_terbit_diambil,
                                       'terbit_proses'     => $dmrekap_izin->terbit_proses     + $sts_terbit_proses,
                                       'id_terbit_proses'  => $dmrekap_izin->id_terbit_proses  . $sts_id_terbit_proses,
                                       'jml_tolak'         => $dmrekap_izin->jml_tolak         + $sts_jumlah_tolak,
                                       'id_jml_tolak'      => $dmrekap_izin->id_jml_tolak      . $sts_id_jml_tolak,
                                       'tolak_diambil'     => $dmrekap_izin->tolak_diambil     + $sts_tolak_ambil,
                                       'id_tolak_diambil'  => $dmrekap_izin->id_tolak_diambil  . $sts_id_tolak_diambil,
                                       'tolak_proses'      => $dmrekap_izin->tolak_proses      + $sts_tolak_proses,
                                       'id_tolak_proses'   => $dmrekap_izin->id_tolak_proses   . $sts_id_tolak_proses,
                                       'jml_proses'        => $dmrekap_izin->jml_proses        + $sts_jumlah_proses,
                                       'id_jml_proses'     => $dmrekap_izin->id_jml_proses     . $sts_id_jml_proses);
                        $dmrekap_izin->where('user_id = '.$id_user.' AND trsektor_id = '.$data['id'].' AND trperizinan_id = '.$trperizinan_id)
                                     ->update($xdata);
                      }else{
                        $dmrekap_izin = new dmrekap_izin();
                        $dmrekap_izin->user_id           = $id_user;
                        $dmrekap_izin->trsektor_id       = $data['id'];
                        $dmrekap_izin->trperizinan_id    = $trperizinan_id;
                        $dmrekap_izin->jml_masuk         = 1;
                        $dmrekap_izin->id_jml_masuk      = $sts_id_jml_masuk;
                        $dmrekap_izin->jml_tolak_fo      = $sts_jml_tolak_FO;
                        $dmrekap_izin->id_jml_tolak_fo   = $sts_id_jml_tolak_fo;
                        $dmrekap_izin->jml_terbit        = $sts_jumlah_terbit;
                        $dmrekap_izin->id_jml_terbit     = $sts_id_jml_terbit;
                        $dmrekap_izin->terbit_diambil    = $sts_terbit_ambil;
                        $dmrekap_izin->id_terbit_diambil = $sts_id_terbit_diambil;
                        $dmrekap_izin->terbit_proses     = $sts_terbit_proses;
                        $dmrekap_izin->id_terbit_proses  = $sts_id_terbit_proses;
                        $dmrekap_izin->jml_tolak         = $sts_jumlah_tolak;
                        $dmrekap_izin->id_jml_tolak      = $sts_id_jml_tolak;
                        $dmrekap_izin->tolak_diambil     = $sts_tolak_ambil;
                        $dmrekap_izin->id_tolak_diambil  = $sts_id_tolak_diambil;
                        $dmrekap_izin->tolak_proses      = $sts_tolak_proses;
                        $dmrekap_izin->id_tolak_proses   = $sts_id_tolak_proses;
                        $dmrekap_izin->jml_proses        = $sts_jumlah_proses;
                        $dmrekap_izin->id_jml_proses     = $sts_id_jml_proses;
                        $dmrekap_izin->save();
                      }
                      // EOF() Rekap Per Perizinan
                    }
                  }
                  // Rekap Per Sektor
                  $dmrekap_izin = new dmrekap_izin();
                  $dmrekap_izin->user_id           = $id_user;
                  $dmrekap_izin->trsektor_id       = $data['id'];
                  $dmrekap_izin->trperizinan_id    = '';
                  $dmrekap_izin->jml_masuk         = $jumlah_masuk;
                  $dmrekap_izin->id_jml_masuk      = $id_jml_masuk;
                  $dmrekap_izin->jml_tolak_fo      = $jml_tolak_FO;
                  $dmrekap_izin->id_jml_tolak_fo   = $id_jml_tolak_fo;
                  $dmrekap_izin->jml_terbit        = $jumlah_terbit;
                  $dmrekap_izin->id_jml_terbit     = $id_jml_terbit;
                  $dmrekap_izin->terbit_diambil    = $terbit_ambil;
                  $dmrekap_izin->id_terbit_diambil = $id_terbit_diambil;
                  $dmrekap_izin->terbit_proses     = $terbit_proses;
                  $dmrekap_izin->id_terbit_proses  = $id_terbit_proses;
                  $dmrekap_izin->jml_tolak         = $jumlah_tolak;
                  $dmrekap_izin->id_jml_tolak      = $id_jml_tolak;
                  $dmrekap_izin->tolak_diambil     = $tolak_ambil;
                  $dmrekap_izin->id_tolak_diambil  = $id_tolak_diambil;
                  $dmrekap_izin->tolak_proses      = $tolak_proses;
                  $dmrekap_izin->id_tolak_proses   = $id_tolak_proses;
                  $dmrekap_izin->jml_proses        = $jumlah_proses;
                  $dmrekap_izin->id_jml_proses     = $id_jml_proses;
                  $dmrekap_izin->save();
                  // EOF() Rekap Per Sektor
                }
              }
            }
            // EOF() Proses Rekapitulasi
            
            ?>
            <ul>
              <li><a href="#tabs-1"><b>REKAPITULASI PER SEKTOR</b></a></li>
              <li><a href="#tabs-2"><b>REKAPITULASI PER JENIS IZIN</b></a></li>
            </ul>
            
            <div id="tabs-1">
              <fieldset>
                <legend style="color: #045000" align="bottom">
                  <?php
                  echo 'Rekapitulasi Perizinan Periode '. $this->lib_date->mysql_to_human($tgla)." - ".$this->lib_date->mysql_to_human($tglb)." ( Asal Permohonan : " . $ctk_asal." )";
                  ?>
                </legend>
                <table align=right>
                  <tr>
                    <td align="center">
                      <?php
                      $back_data = array('name' => 'button',
                                         'content' => 'Kembali',
                                         'value' => 'Kembali',
                                         'class' => 'button-wrc',
                                         'onclick' => 'parent.location=\''. site_url('rekapitulasi/izin') . '\''
                                        );
                      echo form_button($back_data);
                      
                      $img_cetak = array('name' => 'button',
                                         'content' => 'Cetak PDF',
                                         'value' => 'Cetak PDF',
                                         'class' => 'button-wrc'
                                        );
                      echo form_submit($img_cetak);
                      ?>
                    </td>
                  </tr>
                </table>
                <table align="center" width="90%" border="1" class="display" cellpadding="1" cellspacing="0" id="rev">
                  <tr class="title">
                    <th width="3%"  rowspan="2"><font size="2" color="#1A1A1A"><b>No</b></font></th>
                    <th width="43%" rowspan="2"><font size="2" color="#1A1A1A"><b>Sektor Perizinan</b></font></th>
                    <th width="6%"  rowspan="2"><font size="2" color="#1A1A1A"><b>Jumlah Permohonan</b></font></th>
                    <th width="6%"  rowspan="2"><font size="2" color="#1A1A1A"><b>Izin Ditolak FO</b></font></th>
                    <th colspan="3">            <font size="2" color="#1A1A1A"><b>Izin Disetujui</b></font></th>
                    <th colspan="3">            <font size="2" color="#1A1A1A"><b>Izin Ditolak</b></font></th>
                    <th width="6%"  rowspan="2"><font size="2" color="#1A1A1A"><b>Dalam Proses</b></font></th>
                  </tr>
                  <tr class="title">
                    <th width="6%" align="center"><font size="2" color="#1A1A1A"><b>Jumlah</b></font></th>
                    <th width="6%" align="center"><font size="2" color="#1A1A1A"><b>Diambil</b></font></th>
                    <th width="6%" align="center"><font size="2" color="#1A1A1A"><b>Belum Diambil</b></font></th>
                    <th width="6%" align="center"><font size="2" color="#1A1A1A"><b>Jumlah</b></font></th>
                    <th width="6%" align="center"><font size="2" color="#1A1A1A"><b>Diambil</b></font></th>
                    <th width="6%" align="center"><font size="2" color="#1A1A1A"><b>Belum Diambil</b></font></th>
                  </tr>
                  <tr>
                    <?php
                    $data1 = array();
                    $temp = implode(';', array('NO', 'SEKTOR PERIZINAN', 'JUMLAH PERMOHONAN', 'IZIN DITOLAK FO',
                                               'JUMLAH IZIN TERBIT', 'IZIN TERBIT DIAMBIL', 'IZIN TERBIT BELUM DIAMBIL', 
                                               'JUMLAH IZIN DITOLAK', 'IZIN DITOLAK DIAMBIL', 'IZIN DITOLAK BELUM DIAMBIL', 
                                               'DALAM PROSES')
                                   );
                    array_push($data1, $temp); //tambahkan isi temp ke array data2
                    $i = NULL;
                    $dmrekap_izin = new dmrekap_izin();
                    $dmrekap_izin->where('user_id = '.$id_user.' AND trperizinan_id = 0')->get();
                    foreach ($dmrekap_izin as $data){
                      $sektor = new trsektor();
                      $sektor->get_by_id($data->trsektor_id);
                      $n_sektor = $sektor->n_sektor;

                      $jumlah_masuk = $data->jml_masuk;
                      $jml_tolak_FO = $data->jml_tolak_fo;
                      $jumlah_terbit = $data->jml_terbit;
                      $terbit_ambil = $data->terbit_diambil;
                      $terbit_proses = $data->terbit_proses;
                      $jumlah_tolak = $data->jml_tolak;
                      $tolak_ambil = $data->tolak_diambil;
                      $tolak_proses = $data->tolak_proses;
                      $jumlah_proses = $data->jml_proses;
                      $i++;
                      ?>
                      <tr bgcolor="#FEF9BF">
                        <td align="center"><font size="2" color="#1A1A1A"><?php echo $i; ?></td>
                        <td align="left"> <font size="2" color="#1A1A1A"><?php echo $n_sektor; ?></font></td>
                        <td align="center">
                          <font size="2" color="#1A1A1A">
                            <?php
                            $img_jml_masuk = array('alt' => number_format($jumlah_masuk,0,'.','.'),
                                                   'title' => 'Lihat Detail',
                                                   'border' => '0'
                                                  );
                            if($jumlah_masuk == 0 )
                              echo number_format($jumlah_masuk,0,'.','.');
                            else
                              // echo anchor(site_url('rekapitulasi/izin/list_data').'/'.$data->id.'/'.'1', img($img_jml_masuk), 'class="link2-wrc"');
                              echo anchor(site_url('rekapitulasi/izin/list_data').'/'.$data->id.'/'.'1', '<button type="button" class="myButton" title="Lihat Detail">'.number_format($jumlah_masuk,0,'.','.').'</button>', 'class="link2-wrc"');
                            ?>
                          </font>
                        </td>
                        <td align="center">
                          <font size="2" color="#1A1A1A">
                            <?php
                            $img_jml_tolak_FO = array('alt' => number_format($jml_tolak_FO,0,'.','.'),
                                                      'title' => 'Lihat Detail',
                                                      'border' => '0'
                                                     );
                            if($jml_tolak_FO == 0 )
                              echo number_format($jml_tolak_FO,0,'.','.');
                            else
                              // echo anchor(site_url('rekapitulasi/izin/list_data').'/'.$data->id.'/'.'2', img($img_jml_tolak_FO), 'class="link2-wrc"');
                              echo anchor(site_url('rekapitulasi/izin/list_data').'/'.$data->id.'/'.'2', '<button type="button" class="myButton" title="Lihat Detail">'.number_format($jml_tolak_FO,0,'.','.').'</button>', 'class="link2-wrc"');
                            ?>
                          </font>
                        </td>
                        <td align="center">
                          <font size="2" color="#1A1A1A">
                            <?php
                  	        $img_jml_terbit = array('alt' => number_format($jumlah_terbit,0,'.','.'),
                                                    'title' => 'Lihat Detail',
                                                    'border' => '0'
                                                   );
                  	    	  if($jumlah_terbit == 0 )
                  	    	    echo number_format($jumlah_terbit,0,'.','.');
                  	    	  else
                  	    	    // echo anchor(site_url('rekapitulasi/izin/list_data').'/'.$data->id.'/'.'3', img($img_jml_terbit),  'class="link2-wrc"');
                              echo anchor(site_url('rekapitulasi/izin/list_data').'/'.$data->id.'/'.'3', '<button type="button" class="myButton" title="Lihat Detail">'.number_format($jumlah_terbit,0,'.','.').'</button>',  'class="link2-wrc"');
                  	        ?>
                  	    
                  	      </font>
                        </td>
                        <td align="center">
                          <font size="2" color="#1A1A1A">
                	          <?php
                		        $img_terbit_ambil = array('alt' => number_format($terbit_ambil,0,'.','.'),
                                                      'title' => 'Lihat Detail',
                                                      'border' => '0'
                                                     );
                		        if($terbit_ambil == 0 )
                		      	  echo number_format($terbit_ambil,0,'.','.');
                		        else
                  	          // echo anchor(site_url('rekapitulasi/izin/list_data').'/'.$data->id.'/'.'4', img($img_terbit_ambil), 'class="link2-wrc"');
                              echo anchor(site_url('rekapitulasi/izin/list_data').'/'.$data->id.'/'.'4', '<button type="button" class="myButton" title="Lihat Detail">'.number_format($terbit_ambil,0,'.','.').'</button>', 'class="link2-wrc"');
                	          ?>
                	        </font>
                        </td>
                        <td align="center">
                          <font size="2" color="#1A1A1A">
                            <?php 
                            $img_terbit_proses = array('alt' => number_format($terbit_proses,0,'.','.'),
                                                       'title' => 'Lihat Detail',
                                                       'border' => '0'
                                                      );
                            if($terbit_proses == 0 )
                              echo number_format($terbit_proses,0,'.','.');
                            else
                              // echo anchor(site_url('rekapitulasi/izin/list_data').'/'.$data->id.'/'.'5', img($img_terbit_proses), 'class="link2-wrc"');
                              echo anchor(site_url('rekapitulasi/izin/list_data').'/'.$data->id.'/'.'5', '<button type="button" class="myButton" title="Lihat Detail">'.number_format($terbit_proses,0,'.','.').'</button>', 'class="link2-wrc"');
                            ?>
                          </font>
                        </td>
                        <td align="center">
                          <font size="2" color="#1A1A1A">
                            <?php
                            $img_jml_tolak = array('alt' => number_format($jumlah_tolak,0,'.','.'),
                                                   'title' => 'Lihat Detail',
                                                   'border' => '0'
                                                  );
                            if($jumlah_tolak == 0 )
                              echo number_format($jumlah_tolak,0,'.','.');
                            else
                              // echo anchor(site_url('rekapitulasi/izin/list_data').'/'.$data->id.'/'.'6', img($img_jml_tolak), 'class="link2-wrc"');
                              echo anchor(site_url('rekapitulasi/izin/list_data').'/'.$data->id.'/'.'6', '<button type="button" class="myButton" title="Lihat Detail">'.number_format($jumlah_tolak,0,'.','.').'</button>', 'class="link2-wrc"');
                            ?>
                        	</font>
                        </td>
                        <td align="center"><font size="2" color="#1A1A1A"><?php echo number_format($tolak_ambil); ?></font></td>
                        <td align="center"><font size="2" color="#1A1A1A"><?php echo number_format($tolak_proses); ?></font></td>
                        
                        <td align="center">
                          <font size="2" color="#1A1A1A">
                            <?php 
                            $img_jml_proses = array('alt' => number_format($jumlah_proses,0,'.','.'),
                                                    'title' => 'Lihat Detail',
                                                    'border' => '0'
                                                   );
                            if($jumlah_proses == 0 )
                             echo number_format($jumlah_proses,0,'.','.'); 
                            else
                             // echo anchor(site_url('rekapitulasi/izin/list_data').'/'.$data->id.'/'.'9', img($img_jml_proses), 'class="link2-wrc"');
                              echo anchor(site_url('rekapitulasi/izin/list_data').'/'.$data->id.'/'.'9', '<button type="button" class="myButton" title="Lihat Detail">'.number_format($jumlah_proses,0,'.','.').'</button>', 'class="link2-wrc"');
                        		?>
                        	</font>
                        </td>
                      </tr>
                      <?php
                      $temp = implode(';', array($i, $n_sektor, 
                      		            number_format($jumlah_masuk,0,'.','.'), number_format($jml_tolak_FO,0,'.','.'),
                      			          number_format($jumlah_terbit,0,'.','.'), number_format($terbit_ambil,0,'.','.'),
                      			          number_format($terbit_proses,0,'.','.'), number_format($jumlah_tolak,0,'.','.'),
                      			          number_format($tolak_ambil,0,'.','.'), number_format($tolak_proses,0,'.','.'),
                      			          number_format($jumlah_proses,0,'.','.'))
                                     );
                      array_push($data1, $temp); //tambahkan isi temp ke array data2 
                      $t_jumlah_masuk  = $t_jumlah_masuk  + $jumlah_masuk;
                      $t_jumlah_terbit = $t_jumlah_terbit + $jumlah_terbit;
                      $t_terbit_ambil  = $t_terbit_ambil  + $terbit_ambil;
                      $t_terbit_proses = $t_terbit_proses + $terbit_proses;
                      $t_jumlah_tolak  = $t_jumlah_tolak  + $jumlah_tolak;
                      $t_tolak_ambil   = $t_tolak_ambil   + $tolak_ambil;
                      $t_tolak_proses  = $t_tolak_proses  + $tolak_proses;
                      $t_jml_tolak_FO  = $t_jml_tolak_FO  + $jml_tolak_FO;
                      $t_jumlah_proses = $t_jumlah_proses + $jumlah_proses;
                    }
                    ?>
                  </tr>
                	<tr bgcolor bgcolor="#BFCFFE">
                	  <td align="right" colspan="2"> <font size="2" color="#1A1A1A"><b><?php echo 'TOTAL    '; ?></b></font></td>                                     
                    <td align="center"><font size="2" color="#1A1A1A"><b><?php echo number_format($t_jumlah_masuk,0,'.','.'); ?></b></font></td> 
                	  <td align="center"><font size="2" color="#1A1A1A"><b><?php echo number_format($t_jml_tolak_FO,0,'.','.'); ?></b></font></td>                     
                    <td align="center"><font size="2" color="#1A1A1A"><b><?php echo number_format($t_jumlah_terbit,0,'.','.'); ?></b></font></td>
                    <td align="center"><font size="2" color="#1A1A1A"><b><?php echo number_format($t_terbit_ambil,0,'.','.'); ?></b></font></td> 
                    <td align="center"><font size="2" color="#1A1A1A"><b><?php echo number_format($t_terbit_proses,0,'.','.'); ?></b></font></td>
                    <td align="center"><font size="2" color="#1A1A1A"><b><?php echo number_format($t_jumlah_tolak,0,'.','.'); ?></b></font></td> 
                    <td align="center"><font size="2" color="#1A1A1A"><b><?php echo number_format($t_tolak_ambil,0,'.','.'); ?></b></font></td>  
                    <td align="center"><font size="2" color="#1A1A1A"><b><?php echo number_format($t_tolak_proses,0,'.','.'); ?></b></font></td> 
                    <td align="center"><font size="2" color="#1A1A1A"><b><?php echo number_format($t_jumlah_proses,0,'.','.'); ?></b></font></td>
                  </tr>                                                                                                                                       
                </table>                                                                                                                                        
              </fieldset>                                                                                                                                         
              <?php
              $temp = implode(';', array($i, 'TOTAL', number_format($t_jumlah_masuk,0,'.','.'), number_format($t_jml_tolak_FO,0,'.','.'),
                              number_format($t_jumlah_terbit,0,'.','.'), number_format($t_terbit_ambil,0,'.','.'),
              								number_format($t_terbit_proses,0,'.','.'), number_format($t_jumlah_tolak,0,'.','.'),
              								number_format($t_tolak_ambil,0,'.','.'), number_format($t_tolak_proses,0,'.','.'),
              								number_format($t_jumlah_proses,0,'.','.'))
                             );
              array_push($data1, $temp); //tambahkan isi temp ke array data2 
              $data1 = implode('&',$data1);
              echo form_hidden('data1', $data1);
              echo form_close();
              ?>
            </div>
                
            <div id="tabs-2">
              <?php echo form_open('rekapitulasi/izin/cetak/'. $tgla.'/'.$tglb.'/'.$ctk_asal.'/2'); ?>
              <fieldset>
                <legend style="color: #045000" align="bottom">
                  <?php
                  echo 'Rekapitulasi Perizinan Periode '. $this->lib_date->mysql_to_human($tgla)." - ".$this->lib_date->mysql_to_human($tglb)." ( Asal Permohonan : " . $ctk_asal." )";
                  ?>
                </legend>
                <table align=right>
                  <tr>
                    <td align="center">
                      <?php
              	      $back_data = array('name' => 'button',
                                         'content' => 'Kembali',
                                         'value' => 'Kembali',
              	                         'class' => 'button-wrc',
                                         'onclick' => 'parent.location=\''. site_url('rekapitulasi/izin') . '\''
                                        );
              	      echo form_button($back_data);
                                 
                      $img_cetak = array('name' => 'button',
                                         'content' => 'Cetak PDF',
                                         'value' => 'Cetak PDF',
              	                         'class' => 'button-wrc'
                                        );
              	      echo form_submit($img_cetak);
                      ?>
                    </td>
                  </tr>
                </table>
                <table align="center" width="90%" border="1" class="display" cellpadding="1" cellspacing="0" id="rev">
                  <tr class="title">
                    <th width="3%"  rowspan="2"><font size="2" color="#1A1A1A"><b>No</b></font></th>
              	    <th width="58%" rowspan="2"><font size="2" color="#1A1A1A"><b>Jenis Izin</b></font></th>
              	    <td width="7%"  rowspan="2"><font size="2" color="#1A1A1A"><b>Kode Izin</b></font></td>
                    <th width="4%"  rowspan="2"><font size="2" color="#1A1A1A"><b>Jumlah Permohonan</b></font></th>
              	    <th width="4%"  rowspan="2"><font size="2" color="#1A1A1A"><b>Izin Ditolak FO</b></font></th>
                    <th             colspan="3"><font size="2" color="#1A1A1A"><b>Izin Disetujui</b></font></th>
                    <th             colspan="3"><font size="2" color="#1A1A1A"><b>Izin Ditolak</b></font></th>
                    <th width="4%"  rowspan="2"><font size="2" color="#1A1A1A"><b>Izin Dalam Proses</b></font></th>
                  </tr>
                  <tr class="title">
                    <th width="4%" align="center"><font size="2" color="#1A1A1A"><b>Jumlah</b></font></th>
                    <th width="4%" align="center"><font size="2" color="#1A1A1A"><b>Diambil</b></font></th>
                    <th width="4%" align="center"><font size="2" color="#1A1A1A"><b>Belum Diambil</b></font></th>
                    <th width="4%" align="center"><font size="2" color="#1A1A1A"><b>Jumlah</b></font></th>
                    <th width="4%" align="center"><font size="2" color="#1A1A1A"><b>Diambil</b></font></th>
                    <th width="4%" align="center"><font size="2" color="#1A1A1A"><b>Belum Diambil</b></font></th>
                  </tr>
                  <tr>
                    <?php
              	    $data11 = array();
              	    $temp = implode('|', array('NO', 'JENIS IZIN', 'KODE IZIN','JUMLAH PERMOHONAN', 'IZIN DITOLAK FO',
              	                    'JUMLAH IZIN TERBIT', 'IZIN TERBIT DIAMBIL', 'IZIN TERBIT BELUM DIAMBIL', 
              	                    'JUMLAH IZIN DITOLAK', 'IZIN DITOLAK DIAMBIL', 'IZIN DITOLAK BELUM DIAMBIL', 
              	                    'DALAM PROSES')
              	                   );
              	    array_push($data11, $temp); //tambahkan isi temp ke array data11
                    $i = NULL;
                    $i1 = NULL;
              	    $i2 = NULL;
              	    $romawi = NULL;
              	    $n_sektor_1 = 'PERTAMA';
              	    $a_sektor = '';
              	    $t_jumlah_masuk = 0;
              	    $t_tolak_FO = 0;
                    $t_jumlah_terbit = 0;
                    $t_terbit_ambil = 0;
                    $t_terbit_proses = 0;
                    $t_jumlah_tolak = 0;
                    $t_tolak_ambil = 0;
                    $t_tolak_proses = 0;
                    $t_jumlah_proses = 0;
              	    $g_jumlah_masuk = 0;
              	    $g_tolak_FO = 0;
                    $g_jumlah_terbit = 0;
                    $g_terbit_ambil = 0;
                    $g_terbit_proses = 0;
                    $g_jumlah_tolak = 0;
                    $g_tolak_ambil = 0;
                    $g_tolak_proses = 0;
                    $g_jumlah_proses = 0;
                    $dmrekap_izin = new dmrekap_izin();
                    $dmrekap_izin->where('user_id = '.$id_user.' AND trperizinan_id = 0')->get();
                    foreach ($dmrekap_izin as $data){
                    	$sektor = new trsektor();
                      $sektor->get_by_id($data->trsektor_id);
                      $sektor_id = $data->trsektor_id;
                      $n_sektor = $sektor->n_sektor;
                      
                      $jumlah_masuk = 0;
              	      $tolak_FO = 0;
                      $jumlah_terbit = 0;
                      $terbit_ambil = 0;
                      $terbit_proses = 0;
                      $jumlah_tolak = 0;
                      $tolak_ambil = 0;
                      $tolak_proses = 0;
                      $jumlah_proses = 0;

              	  	  if($n_sektor != $n_sektor_1){ // JIKA GANTI SEKTOR
              	  	    $i1 = NULL;
              	  	    $n_sektor_1 = $n_sektor;
              	  	    if(substr($n_sektor, 0, 1) != '*') {
              	  	      $romawi++;
              	  	      $anka_romawi = $this->terbilang->DecRomawi($romawi);
              	  	      $jdl_sektor = 'PERIZINAN SEKTOR '.$n_sektor_1;
                          if($romawi != 1){
              	  	        $ket_cetak  = 'JUMLAH PERMOHONAN IZIN SEKTOR '.$a_sektor;
                            ?>
              	            <tr bgcolor="#FEF280">
                              <td align="right" colspan="3">
              	  	    	      <font size="2" color="#1A1A1A"><?php echo '<b>'.$ket_cetak.'</b>'; ?></font>
              	  	    	    </td>
              	  	    	    <td align="center">
              	  	    	      <font size="2" color="#1A1A1A"><?php echo '<b>'.number_format($g_jumlah_masuk,0,'.','.').'</b>'; ?></font>
              	  	    	    </td>
              	  	    	    <td align="center">
              	  	    	      <font size="2" color="#1A1A1A"><?php echo '<b>'.number_format($g_tolak_FO,0,'.','.').'</b>'; ?></font>
              	  	    	    </td>
                              <td align="center">
              	  	    	      <font size="2" color="#1A1A1A"><?php echo '<b>'.number_format($g_jumlah_terbit,0,'.','.').'</b>'; ?></font>
              	  	    	    </td>
                              <td align="center">
              	  	    	      <font size="2" color="#1A1A1A"><?php echo '<b>'.number_format($g_terbit_ambil,0,'.','.').'</b>'; ?></font>
              	  	    	    </td>
                              <td align="center">
              	  	    	      <font size="2" color="#1A1A1A"><?php echo '<b>'.number_format($g_terbit_proses,0,'.','.').'</b>'; ?></font>
              	  	    	    </td>
                              <td align="center">
              	  	    	      <font size="2" color="#1A1A1A"><?php echo '<b>'.number_format($g_jumlah_tolak,0,'.','.').'</b>'; ?></font>
              	  	    	    </td>
                              <td align="center">
              	  	    	      <font size="2" color="#1A1A1A"><?php echo '<b>'.number_format($g_tolak_ambil,0,'.','.').'</b>'; ?></font>
              	  	    	    </td>
                              <td align="center">
              	  	    	      <font size="2" color="#1A1A1A"><?php echo '<b>'.number_format($g_tolak_proses,0,'.','.').'</b>'; ?></font>
              	  	    	    </td>
                              <td align="center">
              	  	    	      <font size="2" color="#1A1A1A"><?php echo '<b>'.number_format($g_jumlah_proses,0,'.','.').'</b>'; ?></font>
              	  	    	    </td>
                            </tr>
              	  	        <tr>
                              <td align="center" colspan="12"><font size="2" color="#1A1A1A"><?php echo ''; ?></font></td>
              	  	        </tr>
                            <?php
                            $temp = implode('|', array('', $ket_cetak, '', 
              	                            number_format($g_jumlah_masuk,0,'.','.'), number_format($g_tolak_FO,0,'.','.'), number_format($g_jumlah_terbit,0,'.','.'), number_format($g_terbit_ambil,0,'.','.'), number_format($g_terbit_proses,0,'.','.'), number_format($g_jumlah_tolak,0,'.','.'), number_format($g_tolak_ambil,0,'.','.'), number_format($g_tolak_proses,0,'.','.'), number_format($g_jumlah_proses,0,'.','.'))
              	  		                     );
              	            array_push($data11, $temp); //tambahkan isi temp ke array data2 
                            
              	  		      $temp = implode('|', array('', '', '', '', '', '', '', '', '', '', '', ''));
              	            array_push($data11, $temp); //tambahkan isi temp ke array data2
                          }
              	          $g_jumlah_masuk = 0;
                  		    $g_tolak_FO = 0;
                          $g_jumlah_terbit = 0;
                          $g_terbit_ambil = 0;
                          $g_terbit_proses = 0;
                          $g_jumlah_tolak = 0;
                          $g_tolak_ambil = 0;
                          $g_tolak_proses = 0;
                          $g_jumlah_proses = 0;
              	  		    ?>
                      
              	  		    <tr bgcolor="#B2A100">
                            <td align="Left"> <font size="2" color="#1A1A1A"><?php echo '<b>'.$anka_romawi.'</b>'; ?></font> </td>
                            <td colspan="11">
              	  			      <font size="2" color="#1A1A1A">
              	  			        <?php echo '<b>'.$jdl_sektor.'</b>'; ?>
              	  			      </font>
              	  		      </td>
                          </tr>
                          <?php
              	  		    $temp = implode('|', array($anka_romawi, $jdl_sektor, '', '', '', '', '', '', '', '', '', ''));
              	          array_push($data11, $temp); //tambahkan isi temp ke array data2
              	  		    $a_sektor = $n_sektor;
              	  		  }
              	  	  }
                      if(substr($n_sektor, 0, 1) != '*') {
                        $i++;
                        // loop semua izin per sektor
                        $perizinan_sektor = $sektor->trperizinan->order_by('kd_izin', 'ASC')->get();                     
                        foreach ($perizinan_sektor as $data_izin){
                        	$n_perizinan = $data_izin->n_perizinan;
                          $kd_izin = $data_izin->kd_izin;
                          $tmp_kd_izin = substr($kd_izin,0,2).'.'.substr($kd_izin,2,1).'.'.substr($kd_izin,3,2).'.'.substr($kd_izin,5);
                          if($data_izin->c_aktif == '0' || $data_izin->c_online == '0'){
                            $i1++;
                            $dmrekap_izin = new dmrekap_izin();
                            $dmrekap_izin->where('user_id = '.$id_user.' AND trsektor_id = '.$sektor_id.' AND trperizinan_id = '.$data_izin->id)->get();
                            $jumlah_masuk = 0;
                            $tolak_FO = 0;
                            $jumlah_terbit = 0;
                            $terbit_ambil = 0;
                            $terbit_proses = 0;
                            $jumlah_tolak = 0;
                            $tolak_ambil = 0;
                            $tolak_proses = 0;
                            $jumlah_proses = 0;
                            if($dmrekap_izin->trperizinan_id != 0){
                              $jumlah_masuk = $dmrekap_izin->jml_masuk; 
                              $tolak_FO = $dmrekap_izin->jml_tolak_fo;     
                              $jumlah_terbit = $dmrekap_izin->jml_terbit;
                              $terbit_ambil = $dmrekap_izin->terbit_diambil; 
                              $terbit_proses = $dmrekap_izin->terbit_proses;
                              $jumlah_tolak = $dmrekap_izin->jml_tolak; 
                              $tolak_ambil = $dmrekap_izin->tolak_diambil;  
                              $tolak_proses = $dmrekap_izin->tolak_proses; 
                              $jumlah_proses = $dmrekap_izin->jml_proses;
	                          }
                            ?>                       
                            <tr bgcolor="#FEF9BF">
                      	      <td align="right"><font size="2" color="#1A1A1A"><?php echo $i1; ?></font></td>
                      	      <td>              <font size="2" color="#1A1A1A"><?php echo $n_perizinan; ?></font></td>
                              <td>              <font size="2" color="#1A1A1A"><?php echo $tmp_kd_izin; ?></font></td>
                              <td align="center">
                      	        <font size="2" color="#1A1A1A">
                                  <?php
                      	    	    $img_jml_masuk = array('alt' => number_format($jumlah_masuk,0,'.','.'),
                                                         'title' => 'Lihat Detail',
                                                         'border' => '0'
                                                        );
                                  if($jumlah_masuk == 0 )
                                    echo number_format($jumlah_masuk,0,'.','.');
                      	    	    else
                      	    	      // echo anchor(site_url('rekapitulasi/izin/list_data').'/'.$dmrekap_izin->id.'/'.'10', img($img_jml_masuk), 'class="link2-wrc"');

                      	    	    	echo anchor(site_url('rekapitulasi/izin/list_data').'/'.$dmrekap_izin->id.'/'.'10', '<button type="button" class="myButton" title="Lihat Detail">'.number_format($jumlah_masuk,0,'.','.').'</button>', 'class="link2-wrc"');

                      	    	    	
                      	    	    ?>
                      	    	  </font>
                      	    	</td>
                      	    	<td align="center">
                      	    	  <font size="2" color="#1A1A1A">
                                  <?php
                      	    	    $img_jml_tolak_FO = array('alt' => number_format($tolak_FO,0,'.','.'),
                                                            'title' => 'Lihat Detail',
                                                            'border' => '0'
                                                           );
                                  if($tolak_FO == 0 )
                                    echo number_format($tolak_FO,0,'.','.');
                      	    	    else
                      	    	      //echo anchor(site_url('rekapitulasi/izin/list_data').'/'.$dmrekap_izin->id.'/'.'11', img($img_jml_tolak_FO), 'class="link2-wrc"');

                      	    	    	echo anchor(site_url('rekapitulasi/izin/list_data').'/'.$dmrekap_izin->id.'/'.'11', '<button type="button" class="myButton" title="Lihat Detail">'.number_format($tolak_FO,0,'.','.').'</button>', 'class="link2-wrc"');
                      	    	    ?>
                      	    	  </font>
                      	    	</td>
                              <td align="center">
                      	    	  <font size="2" color="#1A1A1A">
                                  <?php
                      	    	    $img_jml_terbit = array('alt' => number_format($jumlah_terbit,0,'.','.'),
                                                          'title' => 'Lihat Detail',
                                                          'border' => '0'
                                                         );
                                  if($jumlah_terbit == 0 )
                                    echo number_format($jumlah_terbit,0,'.','.');
                      	    	    else
                      	    	      //echo anchor(site_url('rekapitulasi/izin/list_data').'/'.$dmrekap_izin->id.'/'.'12', img($img_jml_terbit), 'class="link2-wrc"');

                      	    	    	echo anchor(site_url('rekapitulasi/izin/list_data').'/'.$dmrekap_izin->id.'/'.'12', '<button type="button" class="myButton" title="Lihat Detail">'.number_format($jumlah_terbit,0,'.','.').'</button>', 'class="link2-wrc"');
                      	    	    ?>
                      	    	  </font>
                      	    	</td>
                              <td align="center">
                                <font size="2" color="#1A1A1A">
                                  <?php
                                  $img_jml_terbit_ambil = array('alt' => number_format($terbit_ambil,0,'.','.'),
                                                                'title' => 'Lihat Detail',
                                                                'border' => '0'
                                                               );
                                  if($terbit_ambil == 0 )
                                    echo number_format($terbit_ambil,0,'.','.');
                                  else
                                    //echo anchor(site_url('rekapitulasi/izin/list_data').'/'.$dmrekap_izin->id.'/'.'13', img($img_jml_terbit_ambil), 'class="link2-wrc"');
                                    echo anchor(site_url('rekapitulasi/izin/list_data').'/'.$dmrekap_izin->id.'/'.'13', '<button type="button" class="myButton" title="Lihat Detail">'.number_format($terbit_ambil,0,'.','.').'</button>', 'class="link2-wrc"');
                                  ?>
                                </font>
                              </td>
                              <td align="center">
                                <font size="2" color="#1A1A1A">
                                  <?php
                                  $img_jml_terbit_proses = array('alt' => number_format($terbit_proses,0,'.','.'),
                                                                 'title' => 'Lihat Detail',
                                                                 'border' => '0'
                                                                );
                                  if($terbit_proses == 0 )
                                    echo number_format($terbit_proses,0,'.','.');
                                  else
                                    //echo anchor(site_url('rekapitulasi/izin/list_data').'/'.$dmrekap_izin->id.'/'.'14', img($img_jml_terbit_proses), 'class="link2-wrc"');
                                    echo anchor(site_url('rekapitulasi/izin/list_data').'/'.$dmrekap_izin->id.'/'.'14', '<button type="button" class="myButton" title="Lihat Detail">'.number_format($terbit_proses,0,'.','.').'</button>', 'class="link2-wrc"');
                                  ?>
                                </font>
                              </td>
                              <td align="center">
                                <font size="2" color="#1A1A1A">
                                  <?php
                                  $img_jml_tolak = array('alt' => number_format($jumlah_tolak,0,'.','.'),
                                                         'title' => 'Lihat Detail',
                                                         'border' => '0'
                                                        );
                                  if($jumlah_tolak == 0 )
                                    echo number_format($jumlah_tolak,0,'.','.');
                                  else
                                    //echo anchor(site_url('rekapitulasi/izin/list_data').'/'.$dmrekap_izin->id.'/'.'15', img($img_jml_tolak), 'class="link2-wrc"');
                                    echo anchor(site_url('rekapitulasi/izin/list_data').'/'.$dmrekap_izin->id.'/'.'15', '<button type="button" class="myButton" title="Lihat Detail">'.number_format($jumlah_tolak,0,'.','.').'</button>', 'class="link2-wrc"');
                                  ?>
                                </font>
                              </td>
                              <td align="center">
                                <font size="2" color="#1A1A1A"><?php echo number_format($tolak_ambil,0,'.','.'); ?></font>
                              </td>
                              <td align="center">
                                <font size="2" color="#1A1A1A"><?php echo number_format($tolak_proses,0,'.','.'); ?></font>
                              </td>
                              <td align="center">
                                <font size="2" color="#1A1A1A">
                                  <?php
                                  $img_jml_proses = array('alt' => number_format($jumlah_proses,0,'.','.'),
                                                          'title' => 'Lihat Detail',
                                                          'border' => '0'
                                                         );
                                  if($jumlah_proses == 0 )
                                    echo number_format($jumlah_proses,0,'.','.');
                                  else
                                    //echo anchor(site_url('rekapitulasi/izin/list_data').'/'.$dmrekap_izin->id.'/'.'18', img($img_jml_proses), 'class="link2-wrc"');
                                    echo anchor(site_url('rekapitulasi/izin/list_data').'/'.$dmrekap_izin->id.'/'.'18', '<button type="button" class="myButton" title="Lihat Detail">'.number_format($jumlah_proses,0,'.','.').'</button>', 'class="link2-wrc"');
                                  ?>
                                </font>
                              </td>
                            </tr>
                                                      
                            <?php
                            $temp = implode('|', array($i1, $n_perizinan, $kd_izin, 
                                            number_format($jumlah_masuk,0,'.','.'), number_format($tolak_FO,0,'.','.'), 
                                            number_format($jumlah_terbit,0,'.','.'), number_format($terbit_ambil,0,'.','.'),
                                            number_format($terbit_proses,0,'.','.'), number_format($jumlah_tolak,0,'.','.'),
                                            number_format($tolak_ambil,0,'.','.'), number_format($tolak_proses,0,'.','.'),
                                            number_format($jumlah_proses,0,'.','.'))
                                           );
                            array_push($data11, $temp); //tambahkan isi temp ke array data2 
                            
                            $t_jumlah_masuk  = $t_jumlah_masuk  + $jumlah_masuk ;
                            $t_tolak_FO      = $t_tolak_FO      + $tolak_FO;
                            $t_jumlah_terbit = $t_jumlah_terbit + $jumlah_terbit;
                            $t_terbit_ambil  = $t_terbit_ambil  + $terbit_ambil ;
                            $t_terbit_proses = $t_terbit_proses + $terbit_proses;
                            $t_jumlah_tolak  = $t_jumlah_tolak  + $jumlah_tolak ;
                            $t_tolak_ambil   = $t_tolak_ambil   + $tolak_ambil  ;
                            $t_tolak_proses  = $t_tolak_proses  + $tolak_proses ;
                            $t_jumlah_proses = $t_jumlah_proses + $jumlah_proses;
                            
                            $g_jumlah_masuk  = $g_jumlah_masuk  + $jumlah_masuk;
                            $g_tolak_FO      = $g_tolak_FO      + $tolak_FO;
                            $g_jumlah_terbit = $g_jumlah_terbit + $jumlah_terbit;
                            $g_terbit_ambil  = $g_terbit_ambil  + $terbit_ambil;
                            $g_terbit_proses = $g_terbit_proses + $terbit_proses;
                            $g_jumlah_tolak  = $g_jumlah_tolak  + $jumlah_tolak;
                            $g_tolak_ambil   = $g_tolak_ambil   + $tolak_ambil;
                            $g_tolak_proses  = $g_tolak_proses  + $tolak_proses;
                            $g_jumlah_proses = $g_jumlah_proses + $jumlah_proses;
                          }
                        }
                        
                      }
              	    }
                    ?>
                  </tr>
                  <tr bgcolor="#FEF280">
                    <td align="right" colspan="3">
                      <font size="2" color="#1A1A1A">
                        <?php
                        $ket_cetak = 'JUMLAH PERMOHONAN IZIN SEKTOR '.$a_sektor;
                        echo '<b>'.$ket_cetak.'</b>';
                        ?>
                      </font>
                    </td>
                    <td align="center"><font size="2" color="#1A1A1A"><?php echo '<b>'.number_format($g_jumlah_masuk,0,'.','.') .'</b>';?></font></td>
                    <td align="center"><font size="2" color="#1A1A1A"><?php echo '<b>'.number_format($g_tolak_FO,0,'.','.')     .'</b>';?></font></td>
                    <td align="center"><font size="2" color="#1A1A1A"><?php echo '<b>'.number_format($g_jumlah_terbit,0,'.','.').'</b>';?></font></td>
                    <td align="center"><font size="2" color="#1A1A1A"><?php echo '<b>'.number_format($g_terbit_ambil,0,'.','.') .'</b>';?></font></td>
                    <td align="center"><font size="2" color="#1A1A1A"><?php echo '<b>'.number_format($g_terbit_proses,0,'.','.').'</b>';?></font></td>
                    <td align="center"><font size="2" color="#1A1A1A"><?php echo '<b>'.number_format($g_jumlah_tolak,0,'.','.') .'</b>';?></font></td>
                    <td align="center"><font size="2" color="#1A1A1A"><?php echo '<b>'.number_format($g_tolak_ambil,0,'.','.')  .'</b>';?></font></td>
                    <td align="center"><font size="2" color="#1A1A1A"><?php echo '<b>'.number_format($g_tolak_proses,0,'.','.') .'</b>';?></font></td>
                    <td align="center"><font size="2" color="#1A1A1A"><?php echo '<b>'.number_format($g_jumlah_proses,0,'.','.').'</b>';?></font></td>
                  </tr>
                  
                  <tr bgcolor="#BFCFFE">
                    <td align="right" colspan="3">
                      <font size="2" color="#1A1A1A">
                        <b>
                          <?php 
                          $tot_cetak = 'TOTAL JENIS IZIN = '.$i.'; TOTAL PERMOHONAN';
                          echo $tot_cetak;
                          ?>
                        </b>
                      </font>
                    </td>
                    <td align="center"><font size="2" color="#1A1A1A"><?php echo '<b>'.number_format($t_jumlah_masuk,0,'.','.') .'</b>';?></font></td>
                    <td align="center"><font size="2" color="#1A1A1A"><?php echo '<b>'.number_format($t_tolak_FO,0,'.','.')     .'</b>';?></font></td>
                    <td align="center"><font size="2" color="#1A1A1A"><?php echo '<b>'.number_format($t_jumlah_terbit,0,'.','.').'</b>';?></font></td>
                    <td align="center"><font size="2" color="#1A1A1A"><?php echo '<b>'.number_format($t_terbit_ambil,0,'.','.') .'</b>';?></font></td>
                    <td align="center"><font size="2" color="#1A1A1A"><?php echo '<b>'.number_format($t_terbit_proses,0,'.','.').'</b>';?></font></td>
                    <td align="center"><font size="2" color="#1A1A1A"><?php echo '<b>'.number_format($t_jumlah_tolak,0,'.','.') .'</b>';?></font></td>
                    <td align="center"><font size="2" color="#1A1A1A"><?php echo '<b>'.number_format($t_tolak_ambil,0,'.','.')  .'</b>';?></font></td>
                    <td align="center"><font size="2" color="#1A1A1A"><?php echo '<b>'.number_format($t_tolak_proses,0,'.','.') .'</b>';?></font></td>
                    <td align="center"><font size="2" color="#1A1A1A"><?php echo '<b>'.number_format($t_jumlah_proses,0,'.','.').'</b>';?></font></td>
                  </tr>
                </table>
              </fieldset>
            </div>
            <?php
            $temp = implode('|', array('', $ket_cetak, '', 
                            number_format($g_jumlah_masuk,0,'.','.'), number_format($g_tolak_FO,0,'.','.'),
                            number_format($g_jumlah_terbit,0,'.','.'), number_format($g_terbit_ambil,0,'.','.'),
                            number_format($g_terbit_proses,0,'.','.'), number_format($g_jumlah_tolak,0,'.','.'),
                            number_format($g_tolak_ambil,0,'.','.'), number_format($g_tolak_proses,0,'.','.'),
                            number_format($g_jumlah_proses,0,'.','.'))
                           );
            array_push($data11, $temp); //tambahkan isi temp ke array data2
            
           	$temp = implode('|', array('', $tot_cetak, '',
                            number_format($t_jumlah_masuk,0,'.','.'), number_format($t_tolak_FO,0,'.','.'),
                            number_format($t_jumlah_terbit,0,'.','.'), number_format($t_terbit_ambil,0,'.','.'),
                            number_format($t_terbit_proses,0,'.','.'), number_format($t_jumlah_tolak,0,'.','.'),
                            number_format($t_tolak_ambil,0,'.','.'), number_format($t_tolak_proses,0,'.','.'),
                            number_format($t_jumlah_proses,0,'.','.'))
                           );
            array_push($data11, $temp); //tambahkan isi temp ke array data2
            $data11 = implode('~',$data11);
            echo form_hidden('data11', $data11);
            echo form_close();
            ?>
          </div>
        </div>
        <!--</form>-->
      </div>
    </div>
  </body>
</html>