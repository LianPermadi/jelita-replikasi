<html>
  <head>
    <title>Realisasi Penerimaan</title>
  </head>

  <body>
    <div id="content">
      <div class="post">
        <div class="title">
          <h2><?php echo $page_name; ?></h2>
        </div>
        <form name="form1" method="post">
          <div class="entry">
            <div id="tabs">
              <?php 
              if($list_state == '0') $ctk_asal = "Seluruhnya"; else $ctk_asal = $list_state; ?>
              <ul>
                <li><a href="#tabs-1"><b>PERMOHONAN PER BIDANG</b></a></li>
                <li><a href="#tabs-2"><b>PERMOHONAN PER JENIS IZIN</b></a></li>
              </ul>
              <div id="tabs-1">
                <fieldset>
                  <legend style="color: #045000" align="bottom">
                    <?php
                    echo 'Rekap Pendaftaran Periode '. $this->lib_date->mysql_to_human($tgla)." - ".$this->lib_date->mysql_to_human($tglb)." ( Asal Permohonan : " . $ctk_asal." )";
                    //echo 'Realisasi Penerimaan Tahun '.$list_tahun->d_tahun;
                    ?>
                  </legend>
                  <table align="left">
                    <tr>
                      <td align="center">
                        <?php
                        $Back_data = array('src' => base_url().'assets/images/icon/back_alt.png',
                                           'alt' => 'Lihat di HTML to Openoffice',
                                           'title' => 'Kembali',
                                           'onclick' => 'parent.location=\''. site_url('rekapitulasi/rekapitulasi'). '\''
                                          );
                        echo img($Back_data);
                        $img_cetak = array('src' => base_url().'assets/images/icon/print.png',
                                           'alt' => 'Selesai',
                                           'title' => 'View Report with OpenOffice',
                                           'onclick' => 'parent.location=\''.site_url('rekapitulasi/realisasi/cetak_report').'/'.$tgla.'/'.$tglb.'\''
                                            );
                        echo img($img_cetak);
                        //echo anchor(site_url('rekapitulasi/realisasi/cetak_report') .'/'. $list_tahun->d_tahun, img($img_cetak))."&nbsp;";
                        ?>
                      </td>
                    </tr>
                  </table>
                
            		  <table align="center" width="90%" border="1" class="display" cellpadding="1" cellspacing="0" id="rev">
                    <tr class="title">
                      <td align="center" width="10%"><font  size="2" color="#1A1A1A"><b>No</b></font></td>
                      <td align="center" width="75%"><font  size="2" color="#1A1A1A"><b>Bidang Perizinan</b></font></td>
                      <td align="center" width="10%"><font  size="2" color="#1A1A1A"><b>Jumlah Permohonan</b></font></td>
            		      <td align="center" width="5%"><font  size="2" color="#1A1A1A"><b>Cetak Excel</b></font></td>
                    </tr>
                    <tr>
                      <?php
                      $i = NULL;
            		      //$obj = $this->permohonan;
            		      //$jumlah = $obj->where_related("trstspermohonan", 'id <> 1')->where("trsektor_id = '$list_sektor' AND d_terima_berkas >= '$first_date' AND //d_terima_berkas <= '$second_date'")->count();
                      
                      $query_data = "select id, n_sektor from trsektor order by urutan ASC";
                      $hasil_data = mysql_query($query_data);
                      $total = 0;
            		      //echo form_hidden('tgla', $tgla);
            		      //echo form_hidden('tglb', $tglb);
            		      while ($data = mysql_fetch_assoc(@$hasil_data)){
                        $i++;
                        $jumlah = 0;
                        $izin = new trperizinan();
                        $izin->get_by_id($data['id']);
            		        $kd_sektor = $izin->id;
                        $sektor = new trsektor();
                        $sektor->get_by_id($data['id']);
                        $list_sektor = $sektor->id;
                        
                        $permohonan = new tmpermohonan();
            		        if($lokasi == 'OPD Teknis'){
            		          if($list_sektor == $cek_sektor)
            		            $hitung = TRUE;
            		          else
            		            $hitung = FALSE;
            		        }else{
                          $hitung = TRUE;
            		        }
                        
            		        if($hitung){
            		          if($list_state === '0') {
            		            $jumlah = $permohonan->where_related("trstspermohonan", 'id <> 1')->where("trsektor_id = '$list_sektor' AND d_terima_berkas between '$tgla' and '$tglb' AND status_berkas != 'Izin Ditolak FO'")->count();
            		          }else{
            		            $jumlah = $permohonan->where_related("trstspermohonan", 'id <> 1')->where("kd_gerai = '$list_state' AND trsektor_id = '$list_sektor' AND d_terima_berkas between '$tgla' and '$tglb' AND status_berkas != 'Izin Ditolak FO'")->count();
            		          }
            		        }
                                              
            		        if(substr($data['n_sektor'], 0, 1) != '*') { // untuk bukan izin lain2
            		          $total = $total + $jumlah;
                          $f_jumlah = number_format($jumlah);
                          $f_total = number_format($total);
                          ?>
                          <tr>
                            <td width="10%" align="center"> <font  size="2" color="#1A1A1A"><?php echo $i; ?></font> </td>
                            <td width="75%"> <font  size="2" color="#1A1A1A"><?php echo $data['n_sektor']; ?></font> </td>
                            <td width="10%" align="center"> 
            		              <font size="2" color="#A9A9A9"> 
                                <?php 
            		                $title = 'Lihat Detail';
            		                if($f_jumlah > '1999') {
            		                  $title = 'OVER';
                                }else{
                                  if($f_jumlah == '0') {
            		                    $title = 'NULL';
            		                  }
            		                }
            		          		  $img_jumlah = array('alt' => $f_jumlah,
                                                    'title' => $title,
                                                    'border' => '0'
                                                   );
                                //echo anchor(site_url('rekapitulasi/DetailSektorTahun').'/'.$data['id'] .'/'.$tgla.'/'.$tglb.'/'.$data['n_sektor'] , $f_jumlah,  'class="link2-wrc" rel="rekapitulasi_box"');  
            		          		  if($f_jumlah > '1999' || $f_jumlah == '0')
            		          	      echo img($img_jumlah);
            		                else
                          		    echo anchor(site_url('rekapitulasi/DetailSektorTahun').'/'.$data['id'] , img($img_jumlah), 'class="link2-wrc"'); // rel="rekapitulasi_box" Dihilangkan karena bukan popup
            		                ?>
                              </font>
                            </td>
                            <td width="5%" align="center"> 
                              <?php 
            		              $title = 'Cetak Ke Excel';
            		              if($f_jumlah > '1999') {
            		                $title = 'OVER';
            		              }else{
            		                if($f_jumlah == '0') {
            		                  $title = 'NULL';
            		                }
            		              }
                              
            		              $img_excel = array('src' => base_url().'assets/images/icon/clipboard.png',
                                                 'alt' => 'Excel',
                                                 'title' => $title,
                                                 'border' => '0'
                                                );
                              
            		              if($f_jumlah > '1999' || $f_jumlah == '0')
            		                echo img($img_excel);
            		              else
            		                echo anchor(site_url('rekapitulasi/cetak_excel').'/'.$list_sektor , img($img_excel), 'class="link2-wrc"');
            		              ?>
                            </td>
                          </tr>
                          <?php
            		        }
                      }
                      ?>
                      <tr>
                        <td width="80%" align="right" colspan="2"><font size="2" color="#1A1A1A"><b>Total Permohonan</b></font></td>
                        <td width="10%" align="center"><font size="2" color="#1A1A1A"><b><?php echo $f_total; ?></b></font></td>
            		        <td width="10%" align="center"><font size="2" color="#1A1A1A"><b><?php echo ''; ?></b></font></td>
                      </tr>
                    </tr>
                  </table>
                </fieldset>
              </div>
            
              <div id="tabs-2">
                <fieldset>
                  <legend style="color: #045000" align="bottom">
                    <?php
                    echo 'Rekap Pendaftaran Periode '. $this->lib_date->mysql_to_human($tgla)." - ".$this->lib_date->mysql_to_human($tglb)." ( Asal Permohonan : " . $ctk_asal." )";
                    //echo 'Realisasi Penerimaan Tahun '.$list_tahun->d_tahun;
                                        ?>
                  </legend>
                  <table align="left">
                    <tr>
                      <td align="center">
                        <?php
                        $Back_data = array('src' => base_url().'assets/images/icon/back_alt.png',
                                           'alt' => 'Lihat di HTML to Openoffice',
                                           'title' => 'Kembali',
                                           'onclick' => 'parent.location=\''. site_url('rekapitulasi/rekapitulasi'). '\''
                                          );
                        echo img($Back_data);
                        $img_cetak = array('src' => base_url().'assets/images/icon/print.png',
                                           'alt' => 'Selesai',
                                           'title' => 'View Report with OpenOffice',
                                           'onclick' => 'parent.location=\''.site_url('rekapitulasi/realisasi/cetak_report').'/'.$tgla.'/'.$tglb.'\''
                                          );
                        echo img($img_cetak);
                        //echo anchor(site_url('rekapitulasi/realisasi/cetak_report') .'/'. $list_tahun->d_tahun, img($img_cetak))."&nbsp;";
                        ?>
                      </td>
                    </tr>
                  </table>
                  <table align="center" width="90%" border="1" class="display" cellpadding="1" cellspacing="0" id="rev">
                    <tr class="title">
                      <td align="center" width="3%"><font size="2" color="#1A1A1A"><b>No</b></font></td>
            			    <td align="center" width="77%"><font size="2" color="#1A1A1A"><b>Jenis Izin</b></font></td>
                      <td align="center" width="7%"><font size="2" color="#1A1A1A"><b>Kode Izin</b></font></td>
                      <td align="center" width="8%"><font size="2" color="#1A1A1A"><b>Jumlah Permohonan</b></font></td>
            			    <td align="center" width="5%"><font size="2" color="#1A1A1A"><b>Cetak Excel</b></font></td>
                    </tr>
                    <tr>
                      <!------------------------------------------------------------------------------------------------------------------------------------------------------------.-->
                      <?php
                      $i = NULL;
            			    $i1 = NULL;
            			    $romawi = NULL;
            			    //"select id, n_sektor from trsektor order by urutan ASC"
                      $query_data = "select id, kd_izin, n_perizinan, v_perizinan from trperizinan order by kd_izin ASC";
                      $hasil_data = mysql_query($query_data);
                      $total = 0;
            			    $n_sektor_1 = 'PERTAMA';
                      while ($data = mysql_fetch_assoc(@$hasil_data)){
                        //$i++;
                        $jumlah = 0;
                        $izin = new trperizinan();
                        $izin->get_by_id($data['id']);
                        $id_izin = $izin->id;
            			      $kd_sektor = new trperizinan_trsektor();
                                              $kd_sektor->where('trperizinan_id', $id_izin)->get();
                                              $kd_sektor = $kd_sektor->trsektor_id; 
                                              $sektor = new trsektor();
                                              $sektor->get_by_id($kd_sektor);
                                              $n_sektor = $sektor->n_sektor;
                        
                                              $permohonan = new tmpermohonan();
                        
            			      if($lokasi == 'OPD Teknis'){
            			      	if($kd_sektor == $cek_sektor)
            			      	    $hitung = TRUE;
            			      	else
            			      	    $hitung = FALSE;
            			      }else{
                                                  $hitung = TRUE;
            			      }
                                              
            			      if($hitung){
                          if($n_sektor != $n_sektor_1){
            			          $i1 = NULL;
            			          $n_sektor_1 = $n_sektor;
            			          if(substr($n_sektor, 0, 1) != '*') {
            			            $romawi++;
            			            $anka_romawi = $this->terbilang->DecRomawi($romawi);
                              ?>
                              <tr>
                                <td align="Left"> <font size="2" color="#1A1A1A"><?php echo '<b>'.$anka_romawi.'</b>'; ?></font> </td>
                                <td colspan="4">
            			                <font size="2" color="#1A1A1A">
            			                  <?php echo '<b>'.'PERIZINAN SEKTOR '.$n_sektor_1.'</b>'; ?>
            			                </font>
            			          	  </td>
                              </tr>
                              <?php
            			          }
            			        }
            			           
            			        if(substr($n_sektor, 0, 1) != '*') {
            			          if($list_state === '0') {
            			            $jumlah = $permohonan->where_related("trstspermohonan", 'id <> 1')->where("d_terima_berkas between '$tgla' and '$tglb' AND status_berkas != 'Izin Ditolak FO'")->where_related($izin)->count();
            			          }else{
            			            $jumlah = $permohonan->where_related("trstspermohonan", 'id <> 1')->where("kd_gerai = '$list_state' AND d_terima_berkas between '$tgla' and '$tglb' AND status_berkas != 'Izin Ditolak FO'")->where_related($izin)->count();
            			          }
            			          $i++;
            			          $i1++;
                            $total = $total + $jumlah;
                            $f_jumlah = number_format($jumlah);
                            $f_total = number_format($total);
                            ?>
                            <tr>
                              <td align="right"> <font size="2" color="#1A1A1A"><?php echo $i1; ?></font> </td>
            			            <td> <font size="2" color="#1A1A1A"><?php echo $data['n_perizinan']; ?></font> </td>
                              <td align="left"> <font size="2" color="#1A1A1A"><?php echo $data['kd_izin']; ?></font> </td>
                              <td align="center"> 
            			              <font size="2" color="#A9A9A9"> 
                                  <?php 
            			                $title = 'Lihat Detail';
            			                if($f_jumlah > '1999') {
                	                  $title = 'OVER';
                                  }else{
            	                      if($f_jumlah == '0') {
            			                    $title = 'NULL';
            			                  }
            			                }
                                                       
            			                $img_jumlah = array('alt' => $f_jumlah,
                                                      'title' => $title,
                                                      'border' => '0'
                                                     );
              		                if($f_jumlah > '1999' || $f_jumlah == '0')
                	                  echo $f_jumlah;
            	                    else
            	                      echo anchor(site_url('rekapitulasi/DetailTahun').'/'. $data['id'], img($img_jumlah), 'class="link2-wrc"'); //Dihilangkan karena bukan popup 
                                    //echo anchor(site_url('rekapitulasi/DetailTahun').'/'. $data['id'] .'/'. $tgla.'/'. $tglb , $f_jumlah, 'class="link2-wrc" rel="rekapitulasi_box"');
                                  ?>
                                </font>
                              </td>
                	            <td align="center"> 
                                <?php 
            		                $title = 'Cetak Ke Excel';
            			              if($f_jumlah > '1999') {
            			                $title = 'OVER';
            			              }else{
            			                if($f_jumlah == '0') {
            			                  $title = 'NULL';
            			                }
            			              }
                                
            			              $img_excel = array('src' => base_url().'assets/images/icon/clipboard.png',
                                                   'alt' => 'Excel',
                                                   'title' => $title,
                                                   'border' => '0'
                                                  );
                                
                	              if($f_jumlah > '1999' || $f_jumlah == '0')
            	                    echo img($img_excel);
            		                else
            			                echo anchor(site_url('rekapitulasi/cetak_excel_perizin').'/'.$id_izin , img($img_excel), 'class="link2-wrc"');
            			              ?>
                              </td>
                            </tr>
                            <?php
            			        }
            			      }
                      }
                      ?>
                      <tr>
                        <td align="right" colspan="3"><font size="2" color="#1A1A1A"><b><?php echo 'Jumlah Izin = '.$i.'; Total Permohonan'; ?></b></font></td>
                        <td align="center"><font size="2" color="#1A1A1A"><b><?php echo $f_total; ?></b></font></td>
            			      <td align="center"><font size="2" color="#1A1A1A"><b><?php echo ''; ?></b></font></td>
                      </tr>
                      <!-----------------------------------------------------------------------------------------------------------------------------------------------------------.-->
                    </tr>
                  </table>
                </fieldset>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </body>
</html>
