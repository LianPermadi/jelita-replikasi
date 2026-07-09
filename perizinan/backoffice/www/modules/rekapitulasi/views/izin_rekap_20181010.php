<html>
  <head>
    <title>Realisasi Penerimaan</title>
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
                    $t_jumlah_masuk = 0;
                    $t_jumlah_terbit = 0;
                    $t_terbit_ambil = 0;
                    $t_terbit_proses = 0;
                    $t_jumlah_tolak = 0;
                    $t_tolak_ambil = 0;
                    $t_tolak_proses = 0;
                    $t_jml_tolak_FO = 0;
                    $t_jumlah_proses = 0;
                    $query_data = "select id, n_sektor from trsektor order by urutan ASC";
                    $results = mysql_query($query_data);
                    while($data = mysql_fetch_assoc(@$results)){
                      //$i++;
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
                      if($list_kat === '0'){  // untuk tanggal terima Berkas
                        if($list_state === '0') { // Untuk Seluruh Data
                          $query = "select a.id jumlah, a.pendaftaran_id, a.c_izin_selesai, a.status_berkas, a.d_ambil_izin from tmpermohonan a
                                    inner join tmpermohonan_trperizinan b on a.id = b.tmpermohonan_id
                                    LEFT JOIN tmpermohonan_trstspermohonan as t6 on a.id = t6.tmpermohonan_id
                                    LEFT JOIN trstspermohonan as t7 on t7.id = t6.trstspermohonan_id
                                    where a.trsektor_id = '".$data['id']."'
                                    and t7.id <> 1 
                                    and a.d_terima_berkas between '$tgla' and '$tglb'";
                        }else{
                          $query = "select a.id jumlah, a.pendaftaran_id, a.c_izin_selesai, a.status_berkas, a.d_ambil_izin from tmpermohonan a
                                    inner join tmpermohonan_trperizinan b on a.id = b.tmpermohonan_id
                                    LEFT JOIN tmpermohonan_trstspermohonan as t6 on a.id = t6.tmpermohonan_id
                                    LEFT JOIN trstspermohonan as t7 on t7.id = t6.trstspermohonan_id
                                    where a.trsektor_id = '".$data['id']."'
                                    and t7.id <> 1 
                                    and a.d_terima_berkas between '$tgla' and '$tglb' and a.kd_gerai = '$list_state'";
                        }
                      }else{  // untuk tanggal selesai
                        if($list_state === '0') { // Untuk Seluruh Data
                          $query = "select a.id jumlah, a.pendaftaran_id, a.c_izin_selesai, a.status_berkas, a.d_ambil_izin from tmpermohonan a
                                    inner join tmpermohonan_trperizinan b on a.id = b.tmpermohonan_id
                                    LEFT JOIN tmpermohonan_trstspermohonan as t6 on a.id = t6.tmpermohonan_id
                                    LEFT JOIN trstspermohonan as t7 on t7.id = t6.trstspermohonan_id
                                    LEFT JOIN tmpermohonan_tmsk as t8 on b.tmpermohonan_id = t8.tmpermohonan_id
                                    LEFT JOIN tmsk as t9 on t9.id = t8.tmsk_id
                                    where a.trsektor_id = '".$data['id']."'
                                    and t7.id <> 1 
                                    and ( t9.tgl_surat between '$tgla' and '$tglb')";
                                    //and ( t9.tgl_surat between '$tgla' and '$tglb' or t9.tgl_surat_edit between '$tgla' and '$tglb')";
                        }else{
                          $query = "select a.id jumlah, a.pendaftaran_id, a.c_izin_selesai, a.status_berkas, a.d_ambil_izin from tmpermohonan a
                                    inner join tmpermohonan_trperizinan b on a.id = b.tmpermohonan_id
                                    LEFT JOIN tmpermohonan_trstspermohonan as t6 on a.id = t6.tmpermohonan_id
                                    LEFT JOIN trstspermohonan as t7 on t7.id = t6.trstspermohonan_id
                                    LEFT JOIN tmpermohonan_tmsk as t8 on b.tmpermohonan_id = t8.tmpermohonan_id
                                    LEFT JOIN tmsk as t9 on t9.id = t8.tmsk_id
                                    where a.trsektor_id = '".$data['id']."'
                                    and t7.id <> 1
                                    and a.kd_gerai = '$list_state'
                                    and ( t9.tgl_surat between '$tgla' and '$tglb')";
                                    //and ( t9.tgl_surat between '$tgla' and '$tglb' or t9.tgl_surat_edit between '$tgla' and '$tglb')";
                        }
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
                        //$jumlah_terbit = mysql_num_rows(@mysql_query($query." and a.status_berkas = 'Izin Disetujui'"));
                        //$terbit_ambil = mysql_num_rows(@mysql_query($query." and a.status_berkas = 'Izin Disetujui' and a.d_ambil_izin IS NOT NULL"));
                        //$terbit_proses =  mysql_num_rows(@mysql_query($query." and a.status_berkas = 'Izin Disetujui' and a.d_ambil_izin IS NULL"));
                        //$jumlah_tolak = mysql_num_rows(@mysql_query($query." and a.status_berkas = 'Izin Ditolak'"));
                        //$tolak_ambil = 0;
                        //$tolak_proses = $jumlah_tolak_a;
                        //$jml_tolak_FO = mysql_num_rows(@mysql_query($query." and a.status_berkas = 'Izin Ditolak FO'"));
                        //$jumlah_proses = mysql_num_rows(@mysql_query($query." and a.status_berkas = 'proses'"));
                        while ($rows_data = mysql_fetch_assoc(@$hasil_data)){
                          if(substr($data['n_sektor'], 0, 1) != '*') { // untuk bukan izin lain2
                            if($rows_data['status_berkas'] == "Izin Disetujui")                                       $jumlah_terbit++;
                            if($rows_data['status_berkas'] == "Izin Disetujui" && $rows_data['d_ambil_izin'] != NULL) $terbit_ambil++;
                            if($rows_data['status_berkas'] == "Izin Disetujui" && $rows_data['d_ambil_izin'] == NULL) $terbit_proses++;
                            if($rows_data['status_berkas'] == "Izin Ditolak")                                         $jumlah_tolak++;
                            $tolak_ambil = 0;                                                                         //$tolak_ambil++;
                            $tolak_proses = $jumlah_tolak;                                                            //$tolak_proses++;
                            if($rows_data['status_berkas'] == "Izin Ditolak FO")                                      $jml_tolak_FO++;
                            if($rows_data['status_berkas'] == "proses")                                               $jumlah_proses++;
                          }
                        }
                      }
                      
                      if(substr($data['n_sektor'], 0, 1) != '*') { // untuk bukan izin lain2 ditampilkan
                        $i++;
                        ?>
                        <tr bgcolor="#FEF9BF">
                          <td align="right"><font size="2" color="#1A1A1A"><?php echo $i; ?></td>
                          <td align="left"> <font size="2" color="#1A1A1A"><?php echo $data['n_sektor']; ?></font></td>
                          <td align="right">
                            <font size="2" color="#1A1A1A">
                              <?php
                              $img_jml_masuk = array('alt' => number_format($jumlah_masuk,0,'.','.'),
                                                     'title' => 'Lihat Detail',
                                                     'border' => '0'
                                                    );
                              if($jumlah_masuk == 0 )
                                echo number_format($jumlah_masuk,0,'.','.');
                              else
                                echo anchor(site_url('rekapitulasi/izin/list_data').'/'.$data['id'].'/'.'1', img($img_jml_masuk), 'class="link2-wrc"');
                              ?>
                            </font>
                          </td>
                          <td align="right">
                            <font size="2" color="#1A1A1A">
                              <?php
                              $img_jml_tolak_FO = array('alt' => number_format($jml_tolak_FO,0,'.','.'),
                                                        'title' => 'Lihat Detail',
                                                        'border' => '0'
                                                       );
                              if($jml_tolak_FO == 0 )
                                echo number_format($jml_tolak_FO,0,'.','.');
                              else
                                echo anchor(site_url('rekapitulasi/izin/list_data').'/'.$data['id'].'/'.'6', img($img_jml_tolak_FO), 'class="link2-wrc"');
                  	          //echo ' || '.$jml_tolak_FO_a;
                              ?>
                            </font>
                          </td>
                          <td align="right">
                            <font size="2" color="#1A1A1A">
                              <?php
                  	          $img_jml_terbit = array('alt' => number_format($jumlah_terbit,0,'.','.'),
                                                      'title' => 'Lihat Detail',
                                                      'border' => '0'
                                                     );
                  	      	  if($jumlah_terbit == 0 )
                  	      	    echo number_format($jumlah_terbit,0,'.','.');
                  	      	  else
                  	      	    echo anchor(site_url('rekapitulasi/izin/list_data').'/'.$data['id'].'/'.'2', img($img_jml_terbit),  'class="link2-wrc"');
                              //echo ' || '.$jumlah_terbit_a;
                  	          ?>
                  	      
                  	        </font>
                          </td>
                          <td align="right">
                            <font size="2" color="#1A1A1A">
                	            <?php
                		          $img_terbit_ambil = array('alt' => number_format($terbit_ambil,0,'.','.'),
                                                        'title' => 'Lihat Detail',
                                                        'border' => '0'
                                                       );
                		          if($terbit_ambil == 0 )
                		        	  echo number_format($terbit_ambil,0,'.','.');
                		          else
                  	            echo anchor(site_url('rekapitulasi/izin/list_data').'/'.$data['id'].'/'.'3', img($img_terbit_ambil), 'class="link2-wrc"');
                	            //echo ' || '.$terbit_ambil_a;
                	            ?>
                	          </font>
                          </td>
                          <td align="right">
                            <font size="2" color="#1A1A1A">
                              <?php 
                              $img_terbit_proses = array('alt' => number_format($terbit_proses,0,'.','.'),
                                                         'title' => 'Lihat Detail',
                                                         'border' => '0'
                                                        );
                              if($terbit_proses == 0 )
                                echo number_format($terbit_proses,0,'.','.');
                              else
                                echo anchor(site_url('rekapitulasi/izin/list_data').'/'.$data['id'].'/'.'4', img($img_terbit_proses), 'class="link2-wrc"');
                              //echo ' || '.$terbit_proses_a;
                              ?>
                            </font>
                          </td>
                          <td align="right">
                            <font size="2" color="#1A1A1A">
                              <?php
                              $img_jml_tolak = array('alt' => number_format($jumlah_tolak,0,'.','.'),
                                                     'title' => 'Lihat Detail',
                                                     'border' => '0'
                                                    );
                              if($jumlah_tolak == 0 )
                                echo number_format($jumlah_tolak,0,'.','.');
                              else
                                echo anchor(site_url('rekapitulasi/izin/list_data').'/'.$data['id'].'/'.'5', img($img_jml_tolak), 'class="link2-wrc"');
                          	  //echo ' || '.$jumlah_tolak_a;
                              ?>
                          	</font>
                          </td>
                          <td align="right"><font size="2" color="#1A1A1A"><?php echo number_format($tolak_ambil); ?></font></td>
                          <td align="right"><font size="2" color="#1A1A1A"><?php echo number_format($tolak_proses); ?></font></td>
                          
                          <td align="right">
                            <font size="2" color="#1A1A1A">
                              <?php 
                              $img_jml_proses = array('alt' => number_format($jumlah_proses,0,'.','.'),
                                                      'title' => 'Lihat Detail',
                                                      'border' => '0'
                                                     );
                              if($jumlah_proses == 0 )
                               echo number_format($jumlah_proses,0,'.','.'); 
                              else
                               echo anchor(site_url('rekapitulasi/izin/list_data').'/'.$data['id'].'/'.'7', img($img_jml_proses), 'class="link2-wrc"');
                          	  //echo ' || '.$jumlah_proses_a;
                          		?>
                          	</font>
                          </td>
                        </tr>
                        <?php
                        $temp = implode(';', array($i, $data['n_sektor'], 
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
                		}       
                    ?>
                  </tr>
                	<tr bgcolor bgcolor="#BFCFFE">
                	  <td align="right" colspan="2"> <font size="2" color="#1A1A1A"><b><?php echo 'TOTAL    '; ?></b></font></td>                                     
                    <td align="right"><font size="2" color="#1A1A1A"><b><?php echo number_format($t_jumlah_masuk,0,'.','.'); ?></b></font></td> 
                	  <td align="right"><font size="2" color="#1A1A1A"><b><?php echo number_format($t_jml_tolak_FO,0,'.','.'); ?></b></font></td>                     
                    <td align="right"><font size="2" color="#1A1A1A"><b><?php echo number_format($t_jumlah_terbit,0,'.','.'); ?></b></font></td>
                    <td align="right"><font size="2" color="#1A1A1A"><b><?php echo number_format($t_terbit_ambil,0,'.','.'); ?></b></font></td> 
                    <td align="right"><font size="2" color="#1A1A1A"><b><?php echo number_format($t_terbit_proses,0,'.','.'); ?></b></font></td>
                    <td align="right"><font size="2" color="#1A1A1A"><b><?php echo number_format($t_jumlah_tolak,0,'.','.'); ?></b></font></td> 
                    <td align="right"><font size="2" color="#1A1A1A"><b><?php echo number_format($t_tolak_ambil,0,'.','.'); ?></b></font></td>  
                    <td align="right"><font size="2" color="#1A1A1A"><b><?php echo number_format($t_tolak_proses,0,'.','.'); ?></b></font></td> 
                    <td align="right"><font size="2" color="#1A1A1A"><b><?php echo number_format($t_jumlah_proses,0,'.','.'); ?></b></font></td>
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
                    $query_data = "select id, kd_izin, n_perizinan, v_perizinan from trperizinan order by kd_izin ASC";
                    $results = mysql_query($query_data);
                    while ($data = mysql_fetch_assoc(@$results)){
                      //$i++;
                      $jumlah_masuk = 0;
              	      $tolak_FO = 0;
                      $jumlah_terbit = 0;
                      $terbit_ambil = 0;
                      $terbit_proses = 0;
                      $jumlah_tolak = 0;
                      $tolak_ambil = 0;
                      $tolak_proses = 0;
                      $jumlah_proses = 0;
                      
              	  	  $kd_sektor = new trperizinan_trsektor();
                      $kd_sektor->where('trperizinan_id', $data['id'])->get();
                      $kd_sektor = $kd_sektor->trsektor_id; 
                      $sektor = new trsektor();
                      $sektor->get_by_id($kd_sektor);
              	  	  $sektor_id = $sektor->id;
                      $n_sektor = $sektor->n_sektor;
                        
              	  	  if($list_kat === '1'){  // untuk tanggal terima Berkas
              	  	    if($list_state === '0') { // Untuk Seluruh Data
              	  	      $query = "select a.id jumlah, a.pendaftaran_id, a.c_izin_selesai, a.status_berkas, a.d_ambil_izin from tmpermohonan a
                                    inner join tmpermohonan_trperizinan b on a.id = b.tmpermohonan_id
                                    LEFT JOIN tmpermohonan_trstspermohonan as t6 on a.id = t6.tmpermohonan_id
                                    LEFT JOIN trstspermohonan as t7 on t7.id = t6.trstspermohonan_id
                                    where b.trperizinan_id = '".$data['id']."'
                                    and t7.id <> 1 
                                    and a.d_terima_berkas between '$tgla' and '$tglb'";
              	  	 	  }else{
                          $query = "select a.id jumlah, a.pendaftaran_id, a.c_izin_selesai, a.status_berkas, a.d_ambil_izin from tmpermohonan a
                                    inner join tmpermohonan_trperizinan b on a.id = b.tmpermohonan_id
                                    LEFT JOIN tmpermohonan_trstspermohonan as t6 on a.id = t6.tmpermohonan_id
                                    LEFT JOIN trstspermohonan as t7 on t7.id = t6.trstspermohonan_id
                                    where b.trperizinan_id = '".$data['id']."'
                                    and t7.id <> 1 
                                    and a.d_terima_berkas between '$tgla' and '$tglb' and a.kd_gerai = '$list_state'";
              	  	    }
              	  	  }else{  // untuk tanggal selesai
              	  	  	if($list_state === '0') { // Untuk Seluruh Data
              	  	  	  $query = "select a.id jumlah, a.pendaftaran_id, a.c_izin_selesai, a.status_berkas, a.d_ambil_izin from tmpermohonan a
                                    inner join tmpermohonan_trperizinan b on a.id = b.tmpermohonan_id
                                    LEFT JOIN tmpermohonan_trstspermohonan as t6 on a.id = t6.tmpermohonan_id
                                    LEFT JOIN trstspermohonan as t7 on t7.id = t6.trstspermohonan_id
              	  	  	            LEFT JOIN tmpermohonan_tmsk as t8 on b.tmpermohonan_id = t8.tmpermohonan_id
                                    LEFT JOIN tmsk as t9 on t9.id = t8.tmsk_id
              	  	  	            where b.trperizinan_id = '".$data['id']."'
                                    and t7.id <> 1 
                                    and ( t9.tgl_surat between '$tgla' and '$tglb' or t9.tgl_surat_edit between '$tgla' and '$tglb')";
              	  	  	}else{
              	  	  	  $query = "select a.id jumlah, a.pendaftaran_id, a.c_izin_selesai, a.status_berkas, a.d_ambil_izin from tmpermohonan a
                                    inner join tmpermohonan_trperizinan b on a.id = b.tmpermohonan_id
                                    LEFT JOIN tmpermohonan_trstspermohonan as t6 on a.id = t6.tmpermohonan_id
                                    LEFT JOIN trstspermohonan as t7 on t7.id = t6.trstspermohonan_id
              	  	  	            LEFT JOIN tmpermohonan_tmsk as t8 on b.tmpermohonan_id = t8.tmpermohonan_id
                                    LEFT JOIN tmsk as t9 on t9.id = t8.tmsk_id
                                    where b.trperizinan_id = '".$data['id']."'
                                    and t7.id <> 1 
                                    and ( t9.tgl_surat between '$tgla' and '$tglb' or t9.tgl_surat_edit between '$tgla' and '$tglb') 
              	  	  	            and a.kd_gerai = '$list_state'";
              	    		}
              	  	  }
                      $hasil_data = mysql_query($query);
                      
              	  	  if($lokasi == 'OPD Teknis'){
              	  	    if($kd_sektor == $cek_sektor)
              	  	      $hitung = TRUE;
              	  	    else
              	  	      $hitung = FALSE;
              	  	  }else{
                        $hitung = TRUE;
              	  	  }
                      
              	  	  if($hitung){
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
              	  	      	    <td align="right">
              	  	      	      <font size="2" color="#1A1A1A"><?php echo '<b>'.number_format($g_jumlah_masuk,0,'.','.').'</b>'; ?></font>
              	  	      	    </td>
              	  	      	    <td align="right">
              	  	      	      <font size="2" color="#1A1A1A"><?php echo '<b>'.number_format($g_tolak_FO,0,'.','.').'</b>'; ?></font>
              	  	      	    </td>
                                <td align="right">
              	  	      	      <font size="2" color="#1A1A1A"><?php echo '<b>'.number_format($g_jumlah_terbit,0,'.','.').'</b>'; ?></font>
              	  	      	    </td>
                                <td align="right">
              	  	      	      <font size="2" color="#1A1A1A"><?php echo '<b>'.number_format($g_terbit_ambil,0,'.','.').'</b>'; ?></font>
              	  	      	    </td>
                                <td align="right">
              	  	      	      <font size="2" color="#1A1A1A"><?php echo '<b>'.number_format($g_terbit_proses,0,'.','.').'</b>'; ?></font>
              	  	      	    </td>
                                <td align="right">
              	  	      	      <font size="2" color="#1A1A1A"><?php echo '<b>'.number_format($g_jumlah_tolak,0,'.','.').'</b>'; ?></font>
              	  	      	    </td>
                                <td align="right">
              	  	      	      <font size="2" color="#1A1A1A"><?php echo '<b>'.number_format($g_tolak_ambil,0,'.','.').'</b>'; ?></font>
              	  	      	    </td>
                                <td align="right">
              	  	      	      <font size="2" color="#1A1A1A"><?php echo '<b>'.number_format($g_tolak_proses,0,'.','.').'</b>'; ?></font>
              	  	      	    </td>
                                <td align="right">
              	  	      	      <font size="2" color="#1A1A1A"><?php echo '<b>'.number_format($g_jumlah_proses,0,'.','.').'</b>'; ?></font>
              	  	      	    </td>
                              </tr>
              	  	          <tr>
                                <td align="right" colspan="12"><font size="2" color="#1A1A1A"><?php echo ''; ?></font></td>
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
                          $i1++;
                          $jumlah_masuk = mysql_num_rows(@$hasil_data);
                        	while ($rows_data2 = mysql_fetch_assoc(@$hasil_data)){
                        	  $bap = new tmbap();
                        	  $status_bap = $bap->where('pendaftaran_id',$rows_data2['pendaftaran_id'])->get()->status_bap;
                        	  if($rows_data2['status_berkas'] == "Izin Ditolak FO")                                       $tolak_FO++;
                        	  if($rows_data2['status_berkas'] == "Izin Disetujui")                                        $jumlah_terbit++;
                        	  if($rows_data2['status_berkas'] == "Izin Ditolak")                                          $jumlah_tolak++;
                        	  if($rows_data2['status_berkas'] == "proses")                                                $jumlah_proses++;
                            if($rows_data2['status_berkas'] == "Izin Disetujui" && $rows_data2['d_ambil_izin'] != NULL) $terbit_ambil++;
                            if($rows_data2['status_berkas'] == "Izin Disetujui" && $rows_data2['d_ambil_izin'] == NULL) $terbit_proses++;
                            $tolak_ambil = 0;                                                                           //$tolak_ambil++;
                            $tolak_proses = $jumlah_tolak;                                                              //$tolak_proses++;
                          }
                          ?>
                          <tr bgcolor="#FEF9BF">
                        	  <td align="right"><font size="2" color="#1A1A1A"><?php echo $i1; ?></td>
                        	  <td>              <font size="2" color="#1A1A1A"><?php echo $data['n_perizinan']; ?></font></td>
                            <td>              <font size="2" color="#1A1A1A"><?php echo $data['kd_izin']; ?></font></td>
                            <td align="right">
                        	    <font size="2" color="#1A1A1A">
                                <?php
                        		    $img_jml_masuk = array('alt' => number_format($jumlah_masuk,0,'.','.'),
                                                       'title' => 'Lihat Detail',
                                                       'border' => '0'
                                                      );
                                if($jumlah_masuk == 0 )
                                  echo number_format($jumlah_masuk,0,'.','.');
                        		    else
                        		      echo anchor(site_url('rekapitulasi/izin/list_data').'/'.$data['id'].'/'.'8', img($img_jml_masuk), 'class="link2-wrc"');
                        		    ?>
                        		  </font>
                        		</td>
                        		<td align="right">
                        		  <font size="2" color="#1A1A1A">
                                <?php
                        		    $img_jml_tolak_FO = array('alt' => number_format($tolak_FO,0,'.','.'),
                                                          'title' => 'Lihat Detail',
                                                          'border' => '0'
                                                         );
                                if($tolak_FO == 0 )
                                  echo number_format($tolak_FO,0,'.','.');
                        		    else
                        		      echo anchor(site_url('rekapitulasi/izin/list_data').'/'.$data['id'].'/'.'13', img($img_jml_tolak_FO), 'class="link2-wrc"');
                        		    ?>
                        		  </font>
                        		</td>
                            <td align="right">
                        		  <font size="2" color="#1A1A1A">
                                <?php
                        		    $img_jml_terbit = array('alt' => number_format($jumlah_terbit,0,'.','.'),
                                                        'title' => 'Lihat Detail',
                                                        'border' => '0'
                                                       );
                                if($jumlah_terbit == 0 )
                                  echo number_format($jumlah_terbit,0,'.','.');
                        		    else
                        		      echo anchor(site_url('rekapitulasi/izin/list_data').'/'.$data['id'].'/'.'9', img($img_jml_terbit), 'class="link2-wrc"');
                        		    ?>
                        		  </font>
                        		</td>
                            <td align="right">
                              <font size="2" color="#1A1A1A">
                                <?php
                                $img_jml_terbit_ambil = array('alt' => number_format($terbit_ambil,0,'.','.'),
                                                              'title' => 'Lihat Detail',
                                                              'border' => '0'
                                                             );
                                if($terbit_ambil == 0 )
                                  echo number_format($terbit_ambil,0,'.','.');
                                else
                                  echo anchor(site_url('rekapitulasi/izin/list_data').'/'.$data['id'].'/'.'10', img($img_jml_terbit_ambil), 'class="link2-wrc"');
                                ?>
                              </font>
                            </td>
                            <td align="right">
                              <font size="2" color="#1A1A1A">
                                <?php
                                $img_jml_terbit_proses = array('alt' => number_format($terbit_proses,0,'.','.'),
                                                               'title' => 'Lihat Detail',
                                                               'border' => '0'
                                                              );
                                if($terbit_proses == 0 )
                                  echo number_format($terbit_proses,0,'.','.');
                                else
                                  echo anchor(site_url('rekapitulasi/izin/list_data').'/'.$data['id'].'/'.'11', img($img_jml_terbit_proses), 'class="link2-wrc"');
                                ?>
                              </font>
                            </td>
                            <td align="right">
                              <font size="2" color="#1A1A1A">
                                <?php
                                $img_jml_tolak = array('alt' => number_format($jumlah_tolak,0,'.','.'),
                                                       'title' => 'Lihat Detail',
                                                       'border' => '0'
                                                      );
                                if($jumlah_tolak == 0 )
                                  echo number_format($jumlah_tolak,0,'.','.');
                                else
                                  echo anchor(site_url('rekapitulasi/izin/list_data').'/'.$data['id'].'/'.'12', img($img_jml_tolak), 'class="link2-wrc"');
                                ?>
                              </font>
                            </td>
                            <td align="right">
                              <font size="2" color="#1A1A1A"><?php echo number_format($tolak_ambil,0,'.','.'); ?></font>
                            </td>
                            <td align="right">
                              <font size="2" color="#1A1A1A"><?php echo number_format($tolak_proses,0,'.','.'); ?></font>
                            </td>
                            <td align="right">
                              <font size="2" color="#1A1A1A">
                                <?php
                                $img_jml_proses = array('alt' => number_format($jumlah_proses,0,'.','.'),
                                                        'title' => 'Lihat Detail',
                                                        'border' => '0'
                                                       );
                                if($jumlah_proses == 0 )
                                  echo number_format($jumlah_proses,0,'.','.');
                                else
                                  echo anchor(site_url('rekapitulasi/izin/list_data').'/'.$data['id'].'/'.'14', img($img_jml_proses), 'class="link2-wrc"');
                                ?>
                              </font>
                            </td>
                          </tr>
                                                    
                          <?php
                          $temp = implode('|', array($i1, $data['n_perizinan'], $data['kd_izin'], 
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
                    <td align="right"><font size="2" color="#1A1A1A"><?php echo '<b>'.number_format($g_jumlah_masuk,0,'.','.').'</b>'; ?></font></td>
                    <td align="right"><font size="2" color="#1A1A1A"><?php echo '<b>'.number_format($g_tolak_FO,0,'.','.').'</b>'; ?></font></td>
                    <td align="right"><font size="2" color="#1A1A1A"><?php echo '<b>'.number_format($g_jumlah_terbit,0,'.','.').'</b>'; ?></font></td>
                    <td align="right"><font size="2" color="#1A1A1A"><?php echo '<b>'.number_format($g_terbit_ambil,0,'.','.').'</b>'; ?></font></td>
                    <td align="right"><font size="2" color="#1A1A1A"><?php echo '<b>'.number_format($g_terbit_proses,0,'.','.').'</b>'; ?></font></td>
                    <td align="right"><font size="2" color="#1A1A1A"><?php echo '<b>'.number_format($g_jumlah_tolak,0,'.','.').'</b>'; ?></font></td>
                    <td align="right"><font size="2" color="#1A1A1A"><?php echo '<b>'.number_format($g_tolak_ambil,0,'.','.').'</b>'; ?></font></td>
                    <td align="right"><font size="2" color="#1A1A1A"><?php echo '<b>'.number_format($g_tolak_proses,0,'.','.').'</b>'; ?></font></td>
                    <td align="right"><font size="2" color="#1A1A1A"><?php echo '<b>'.number_format($g_jumlah_proses,0,'.','.').'</b>'; ?></font></td>
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
                    <td align="right"><font size="2" color="#1A1A1A"><b><?php echo number_format($t_jumlah_masuk,0,'.','.');  ?></b></font></td>
                    <td align="right"><font size="2" color="#1A1A1A"><b><?php echo number_format($t_tolak_FO,0,'.','.');      ?></b></font></td>
                    <td align="right"><font size="2" color="#1A1A1A"><b><?php echo number_format($t_jumlah_terbit,0,'.','.'); ?></b></font></td>
                    <td align="right"><font size="2" color="#1A1A1A"><b><?php echo number_format($t_terbit_ambil,0,'.','.');  ?></b></font></td>
                    <td align="right"><font size="2" color="#1A1A1A"><b><?php echo number_format($t_terbit_proses,0,'.','.'); ?></b></font></td>
                    <td align="right"><font size="2" color="#1A1A1A"><b><?php echo number_format($t_jumlah_tolak,0,'.','.');  ?></b></font></td>
                    <td align="right"><font size="2" color="#1A1A1A"><b><?php echo number_format($t_tolak_ambil,0,'.','.');   ?></b></font></td>
                    <td align="right"><font size="2" color="#1A1A1A"><b><?php echo number_format($t_tolak_proses,0,'.','.');  ?></b></font></td>
                    <td align="right"><font size="2" color="#1A1A1A"><b><?php echo number_format($t_jumlah_proses,0,'.','.'); ?></b></font></td>
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