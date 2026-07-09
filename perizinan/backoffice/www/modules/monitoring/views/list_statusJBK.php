<script type="text/javascript">
  function validasi() {
    var	first=document.forms[0].first_date.value;
   	var	second=document.forms[0].second_date.value;
    if(first.length==0) {
      document.forms[0].first_date.focus();
		  alert("Periode awal mohon diisi");
		  return false;
	  }else{ 
      if(second.length==0) {
        document.forms[0].second_date.focus();
        alert("Periode akhir mohon diisi");
        return false;
      }else{
			  return true;		
		  }
    }
  }
</script>
	
<div id="content">
  <div class="post">
    <div class="title">
      <h2><?php echo $page_name; ?></h2>
    </div>
    <div class="entry">
      <fieldset id="half">
        <legend>Filter Data</legend>
        <?php
        $attr = array('class' => 'searchForm',
                      'id' => 'searchForm'
                     );
        $opsi_stat = array('0' => 'Izin Dalam Proses Melebihi Masa Durasi',
                           '1' => 'Masa Berlaku Izin Segera Berakhir', // dalam '.$set_kriteria.' Hari Kedepan',
                           '2' => 'Masa Berlaku Izin Telah Berakhir'
                          );
   	    $kirim = array('0' => '-------- Seluruhnya --------',
                       '1' => 'Telah Dikirim',
                       '2' => 'Belum Dikirim'
                      );
    			
   	    //$asal_permohonan = array('0' => '-------- Seluruhnya --------','Pusat' => 'Pusat'); // Untuk daerah lain
        $asal_permohonan = array('0' => '-------- Seluruhnya --------','BPPT Prov. Jabar' => 'BPPT Prov. Jabar','BPMPT Prov. Jabar' => 'BPMPT Prov. Jabar',
                                 'DPMPTSP Prov. Jabar' => 'DPMPTSP Prov. Jabar','Gerai Bogor' => "Gerai Bogor",'Gerai Purwakarta' => 'Gerai Purwakarta','Gerai Garut' => "Gerai Garut",
                                 'Gerai Cirebon' => "Gerai Cirebon",'SMS' => "SMS",'Surat' => "Surat",'OnLine' => "OnLine");

        $periodeawal_input = array('name' => 'first_date',
                                   'class' => 'monbulan',
                                   'id' => 'firstDateInput',
                                   'readOnly'=>TRUE,
                                   'value' => $first_date
                                  );
        $periodeakhir_input = array('name' => 'second_date',
                                    'class' => 'monbulan',
                                    'id' => 'secondDateInput',
                                    'readOnly'=>TRUE,
                                    'value' => $second_date
                                   );
   	    $cari = array('name' => 'submit',
                      'class' => 'button-wrc',
                      'content' => 'Cari',
                      'type' => 'submit',
                      'onclick'=>'return validasi()'
                     );
        echo form_open("monitoring/state", $attr);
        echo form_hidden('refresh', TRUE);
        ?>
       
        <div id="statusRail">
          <div id="leftRail">
            <?php echo form_label('Jenis Status', 'label_izin'); echo form_hidden('mark','tanda'); ?>
          </div>
          <div id="rightRail">
            <?php
            echo form_dropdown('list_status', $opsi_stat, $list_status2,'class = "input-select-wrc" id="selecStatus_id"');
            ?>
          </div>
        </div>
        
        <div id="statusRail">
        	<div id='show_selecStatus_1'>
          <div id="leftRail">
            <?php echo form_label('Tanggal Awal', 'd_tahun');
              //echo form_label($opsi_stat[$list_status2]);
            ?>
          </div>
          <div id="rightRail">
            <?php echo form_input($periodeawal_input);?>
          </div>
          </div>
        </div>
        
        <div id="statusRail">
          <div id="leftRail">
            <?php echo form_label('Tanggal Akhir', 'd_tahun');?>
          </div>
          <div id="rightRail">
            <?php echo form_input($periodeakhir_input);?>
          </div>
        </div>
        
        <div id="statusRail">
          <div id="leftRail">
            &nbsp;
          </div>
          <div id="rightRail">
            <?php echo form_button($cari); echo form_close(); ?>
          </div>
        </div>

        <!-- <table>
          <tr>
        	  <td></td>
            <?php
            // echo form_open('monitoring/monitoringstatus/cetak_monitoring_ambil');
            // echo form_hidden('list_status',$list_status2);
        	  // echo form_hidden('list_asal',$list_asal);
            // echo form_hidden('first_date',$first_date);
            // echo form_hidden('second_date',$second_date);
            // $cetak = array('name' => 'cetak',
            //                'class' => 'button-wrc',
            //                'id' => 'cetak',
            //                'content' => 'Cetak',
            //                'type' => 'submit',
            //                'onclick'=>'return validasi()'                       
            //               );
            ?>
        	  <td><?php  
                              // if ($jumlah > 0){
                              //     echo form_button($cetak);
                              // }
                              //     echo form_close();
                              ?>
        	  </td>
        	</tr>	
        </table> -->
      </fieldset>
    </div>

    <div class="entry">
      <table cellpadding="0" cellspacing="0" border="0" class="display" id="listdata">
        <thead>
          <tr>
            <th rowspan="2">No</th>
            <th width="15%" rowspan="2">No Pendaftaran<br>Nama Pemohon<br>Asal Permohonan</th>
            <th width="53%" rowspan="2">Nama Perizinan<br>Objek Izin</th>
            <?php
            if($list_status2 == 0){	
              echo '<th width="15%" rowspan="2">Tanggal Pendaftaran<br>Target Selesai<br>Tanggal Selesai<br>Melebihi Durasi</th>';
            }else{
              echo '<th width="15%" rowspan="2">Tanggal Pendaftaran<br>Tanggal Selesai<br>Masa Berlaku</th>';
            } 
            if($list_status2 == 0){
              echo '<th width="17%" rowspan="2">Status Permohonan</th>';
            }else{ 
              if($list_status2 == 2){ 
                echo '<th width="17%" rowspan="2">Keterangan</th>';
              }else{ 
                echo '<th width="4%" align="right"></th>';
                echo '<th width="13%" align="left">Keterangan</th>';
              }  
            }
            ?>
          </tr>
        </thead>
        <tbody>
          <?php 
          $no = 1;
          foreach ($list_izin as $izin) {
          	$view = FALSE;
            if($izin->v_berlaku_tahun == 1000){
              $masa_laku = 'Tak terbatas';
              $kurang_hari = 0;
              $view = TRUE;
            }else{
              $hit_berlaku = date('Y-m-d', strtotime($izin->v_berlaku_tahun.' '.'months', strtotime($izin->tgl_surat)));
              $masa_laku = $izin->v_berlaku_tahun.' bulan s/d '.$this->lib_date->mysql_to_human($hit_berlaku);
              $tgl1 = new DateTime(date('Y-m-d'));
	            $tgl2 = new DateTime($hit_berlaku);
	            $kurang_hari = $tgl2->diff($tgl1)->days + 1;
	            if(date('Y-m-d') > $hit_berlaku){
	              $a='-';	
	            }else{
	            	$a='+';
	            }
	            if($hit_berlaku >= $first_date && $hit_berlaku <= $second_date){
	              if($a == '+' AND $kurang_hari < $set_kriteria AND $list_status2 == 1) $view = TRUE; // izin hampir berakhir
	              if($a == '-' AND $list_status2 == 2) $view = TRUE;                                  // izin telah kedaluarsa
	            }else{
	              $view = FALSE;
	            }  
            }
            if($view){           	
          	  ?>
              <tr>
                <td><?php echo $no; ?></td>
                <td><?php echo $izin->pendaftaran_id."<br>".$izin->n_pemohon."<br>".$izin->kd_gerai; ?></td>
                <td><?php echo $izin->n_perizinan."<br>".$izin->a_izin; ?></td>
                <td><?php 
                	  if($list_status2 == 0){
                	  	$tgl_daftar = $izin->d_terima_berkas;
                	  	$tgl_now = date('Y-m-d');
                	  	$ldurasi = $this->lib_date->lama_durasi($tgl_daftar, $tgl_now);
                      $ketdurasi = $ldurasi-$izin->v_hari.' Hari Melebihi Target Selesai';
                	  	echo $this->lib_date->mysql_to_human($izin->d_terima_berkas)."<br>".
                	         $izin->v_hari." Hari / ". $this->lib_date->mysql_to_human($izin->d_selesai_proses)."<br>".
                	         "<span style='color: Red'><b>".$this->lib_date->mysql_to_human($izin->tgl_surat)."<br>".
                	         $ketdurasi."</b></span>";
                	  }else{	 
                	    echo $this->lib_date->mysql_to_human($izin->d_terima_berkas)."<br>".
                	         $this->lib_date->mysql_to_human($izin->tgl_surat)."<br>"."<span style='color: Red'><b>".
                	         $masa_laku."</b></span>";
                	  }
                	  ?>
                </td>
                <?php
                if($list_status2 == 1)
                  echo '<td align="right">';
                else
                  echo '<td>';
                	  if($list_status2 == 0){
                      switch ($izin->kd_status) {
                        case '0': echo "FRONT OFFICE";
                                  break;
                        case '1': echo "EVALUASI ADMINISTRASI";
                                  break;
                        case '2': echo "PENJADWALAN TINJAUAN LAPANGAN";
                                  break;
                        case '3': echo "EVALUASI DATA HASIL PENINJAUAN LAPANGAN (TIM TEKNIS)";
                                  break;
                        case '4': echo "PENYUSUNAN PERTIMBANGAN TEKNIS (TIM TEKNIS)";
                                  break;
                        case '5': echo "PENETAPAN IZIN";
                                  break;
                        case '6': echo "PENGESAHAN IZIN";
                                  break;
                        case '7': echo "PENCETAKAN NASKAH IZIN";
                                  break;
                        case '8': echo "PENGAMBILAN NASKAH IZIN";
                                  break;
                        default:  echo "SELESAI";
                                  break;
                      }
                    }else{
                    	if($list_status2 == 1){
                    		echo $kurang_hari;
                    	}else{
                    		echo 'Izin Tidak Berlaku';
                    	}
                    } 
                echo '</td>';
                
                if($list_status2 == 1){
                  echo '<td> '.'Hari Lagi Izin Berakhir'.'</td>';
                }	
                ?>
              </tr>
              <?php
              $no++;
            }  
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
  <br style="clear: both;" />
</div>