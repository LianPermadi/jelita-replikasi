<div id="content">
  <div class="post">
    <div class="title">
      <h2><?php echo $page_name; ?></h2>
    </div>
    
    <div id="tabs">
      <ul>
        <li><a href="#tabs-1">Data Perdin</a></li>
        <!-- <li><a href="#tabs-2">Grafik dan Chart Data</a></li> -->
      </ul>
      <div id="tabs-1">
        <div class="entry">
          <fieldset id="half">
            <legend>Filter Data Berdasarkan Tanggal Keberangkatan</legend>
            <?php
            echo form_open('perdin/suratperintah');
            
            //$asal_permohonan = array('0' => '------ Seluruhnya ------','Pusat' => 'Pusat'); // Untuk daerah lain
            $esselon_id = array('0' => '-------- Seluruhnya --------','1' => 'Esselon 4','4' => 'Esselon 3',
                                '3' => 'Esselon 2','2' => "Selesai Jelita",'9' => 'Selesai OSS RBA','10' => 'Belum Approve Ess.3 di OSSRBA');
            ?>
            <div id="statusRail">
              <div id="leftRail">
                <?php echo form_label('Periode Awal','d_tahun'); ?>
              </div>
              <div id="rightRail">
                <?php
                $periodeawal_input = array('name'  => 'tgla',
                                           'value' => $tgla,
                                           'class' => 'input-wrc',
                                           'readOnly'=>TRUE,
                                           'class' => 'monbulan'
                                          );
                echo form_input($periodeawal_input);
                ?>
              </div>
            </div>
                        
            <div id="statusRail">
              <div id="leftRail">
                <?php echo form_label('Periode Akhir','d_tahun'); ?>
              </div>
              <div id="rightRail">
                <?php
                $periodeakhir_input = array('name'  => 'tglb',
                                            'value' => $tglb,
                                            'class' => 'input-wrc',
                                            'readOnly'=>TRUE,
                                            'class' => 'monbulan'
                                           );
                echo form_input($periodeakhir_input);
                ?>
              </div>
            </div>
            <?php 
            $filter_data = array('name' => 'button',
                                 'class' => 'button-wrc',
                                 'content' => 'Cari Data',
                                 'value' => 'Cari Data'
                                );
            ?>
            <div id="statusRail">
              <div id="rightRail">
                <?php
                echo form_submit($filter_data);
                // echo form_hidden('kd_filter', '2');
                echo form_close();
                ?>
              </div>
            </div>
          </fieldset>
        </div> 
        
        <?php 
        $alert = $this->session->flashdata("sukses");
        if(!empty($alert)){
          ?>
          <br>
          <div style="color: green; font-size: 12px; margin-left: 20px; margin-bottom: 10px; font-weight: bold;"><center><?php echo $alert; ?></center></div>
          <?php
        }
        $alert = $this->session->flashdata("gagal");
        if(!empty($alert)){
          ?>
          <br>
          <div style="color: red; font-size: 12px; margin-left: 20px; margin-bottom: 10px; font-weight: bold;"><center><?php echo $alert; ?></center></div>
          <?php
        }
        ?>
            
        <div class="entry">
       
          <?php
          $ctk_list = array('name' => 'button',
                            'content' => 'Tambah Surat',
                            'value' => 'Tambah Surat',
                            'class' => 'button-wrc',
                            'onclick' => 'parent.location=\''.site_url('perdin/addrekap').'\''
                           );
          echo form_button($ctk_list);  
          if($rekap == 1){        
            header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
            header("Content-Disposition: attachment; filename=Rekap_perdin.xls"); 
            header("Expires: 0");
            header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
            header("Cache-Control: private",false);
            ob_start();
          }
          ?>
          <table cellpadding="0" cellspacing="0" border="0" class="display" id="pendataan">
            <thead>
              <tr>
                <th width="2%">No</th>
                <th width="20%">Maksud & Tujuan Perdin</th>
                <th width="20%">No Surat Perintah<br>Nama Pembuat Surat<br>Nama Tim</th>
                <th width="10%">Tanggal Berangkat<br>Tanggal Kembali<br>Kabupaten/Kota Tujuan</th>
                <th width="19%">Pelaksana Tugas</th> 
                <th width="7%">Preview/Download SP pegawai</th>
                <th width="7%">Preview/Download SP Kepala Dinas</th>
                <th width="7%">Preview/Download SP Sekretaris Dinas</th>
                <th width="8%">Status Approve</th>
                <th width="8%">tanggal pembuatan perdin</th>
                <th width="8%">Aksi</th>

              </tr>
            </thead>
            <tbody>
              <?php
              $i = 1;
              foreach($search as $row){
                $b = $row->no__sppd == '' ? '<span style="color: Red">' : '';
                $be = $row->tujuan == '' ? '</span>' : '';
                ?>
                <tr>
                  <td><?php echo $i; ?></td>
                  <td><?php echo $b . $row->mksd_pemberangkatan . " <br> ". $be; ?></td>
                  <td>
                    <?php 
                    // Ambil data tim TOT
                    $tim_tot = $this->m_perdin->get_list_tim_by_id($row->id_tim);

                    // Tampilkan no_sppd dan kode_tim (jika ada)
                    if (!empty($tim_tot) && isset($tim_tot[0]->kode_tim)) {
                        echo $b . $row->no__sppd . '/' . htmlspecialchars($tim_tot[0]->kode_tim) . " <br> " . $be;
                    } else {
                        echo $b . $row->no__sppd . '/-' . " <br> " . $be;
                    }

                    // Ambil user
                    $tujuan_keberangkatan_perdin = $this->m_perdin->get_user_id($row->user_id);
                      // var_dump($tujuan_keberangkatan_perdin);die();

                    // Tampilkan nama user (jika ada)
                    if (!empty($tujuan_keberangkatan_perdin) && isset($tujuan_keberangkatan_perdin[0]->realname)) {
                        echo $b . htmlspecialchars($tujuan_keberangkatan_perdin[0]->realname) . " <br> " . $be; 
                    } else {
                        echo $b . "Nama tidak ditemukan" . " <br> " . $be;
                    }

                    // Tampilkan nama tim (jika ada)
                    if (!empty($tim_tot) && isset($tim_tot[0]->nama_tim)) {
                        echo $b . htmlspecialchars($tim_tot[0]->nama_tim) . " <br> " . $be;
                    } else {
                        echo $b . "Nama Tim tidak ditemukan" . " <br> " . $be;
                    }
                    ?>
                  </td>

                  <td>
                     <?php 
                     echo $b . $this->lib_date->mysql_to_human($row->tanggal_berangkat) . "<br>" 
                             . $this->lib_date->mysql_to_human($row->tanggal_kembali) . $be . "<br>";
                     
                     // Ambil data tujuan keberangkatan
                     $tujuan_keberangkatan_perdin = $this->m_perdin->get_tujuan_keberangkatan_perdin($row->no_grup_perdin, $row->id_tim);
                     
                     // Membuat array untuk menampung kab_kota
                     $kab_kota_array = [];
                     
                     if(!empty($tujuan_keberangkatan_perdin)){
                       foreach($tujuan_keberangkatan_perdin as $rowlist){
                         // Decode jika kab_kota dalam format JSON
                         $decoded = json_decode($rowlist->kab_kota, true);
                         if(is_array($decoded)){
                           $kab_kota_array = array_merge($kab_kota_array, $decoded); // Gabungkan jika array
                         }else if (!empty($rowlist->kab_kota)){
                           $kab_kota_array[] = $rowlist->kab_kota; // Tambahkan langsung jika bukan JSON
                         }
                       }
                       
                       // Tampilkan kab_kota dengan nomor urut
                       if(!empty($kab_kota_array)){
                         foreach($kab_kota_array as $index => $item){
                           echo ($index + 1) . ". " . htmlspecialchars($item) . "<br>";
                         }
                       }else{
                         echo "Tidak ada data kab/kota yang valid.<br>";
                       }
                     }else{
                       echo "Data tujuan keberangkatan tidak tersedia.<br>"; // Tampilkan pesan jika data kosong
                     }
                     ?>
                  </td>
                
                  <td>
                    <?php
                    $perdin_no_grup = $this->m_perdin->get_perdin($row->no_grup_perdin, $row->id_tim , $row->mksd_pemberangkatan);
                    foreach($perdin_no_grup as $rowlist){
                      foreach($list as $data){
                        if($rowlist->id_pegawai == $data->id){
                            echo "                                        " . $data->n_pegawai . "<br>                                ";
                        }
                      }
                    }
                    ?>
                  </td>
                  <td>
                    <?php
                    foreach($search_preview as $preview){
                      if($preview->no_grup_perdin == $row->no_grup_perdin && $preview->id_tim == $row->id_tim ){
                        ?>
                        <?php
                        if($preview->id_pegawai == 31):?>
                          <!-- Condition for id_pegawai 31 -->
                          <?php
                        elseif ($preview->id_pegawai == 1152): ?>
                            <!-- Condition for id_pegawai 1152 -->
                            <?php
                          else: ?>
                            <?php 
                            // Check if the file path contains the word 'upload'
                            $file_path = 'assets/file_surat_perdin/' . $preview->file_srt;
                            $file_path_upload = 'assets/file_surat_perdin/upload/' . $preview->file_srt; 
                      
                            if(strpos($file_path, 'upload') !== false): 
                              ?>
                               <!-- If 'upload' is found in the file path -->
                              <a href="<?php echo base_url() . $file_path_upload; ?>" target="_blank">
                                <img src="<?php echo base_url() . 'assets/images/icon/staf_sp.png'; ?>" alt="File Surat Perdin" title="File Surat Perdin" border="0">
                              </a>
                                  
                              <?php
                              if(!empty($preview->no__sppd)): ?>
                                <!-- Display link for visum_kadis if no_surat is not empty -->
                                <a href="<?php echo base_url() . 'perdin/konvert_pdf/' . $preview->file_srt; ?>" target="_blank">
                                  <img src="<?php echo base_url() . 'assets/images/icon/download.png'; ?>" alt="File Surat Visum Kadis" title="File Surat Visum Kadis" border="0">
                                </a>
                                <?php
                              endif;
                              ?>
                              <?php
                            else:
                              ?>
                              <a href="<?php echo base_url() . $file_path; ?>" target="_blank">
                                <img src="<?php echo base_url() . 'assets/images/icon/staf_sp.png'; ?>" alt="File Surat Perdin" title="File Surat Perdin" border="0">
                              </a>
                              <!-- If 'upload' is not found, do something else or display a message -->
                              <?php
                              if(!empty($preview->no__sppd)): ?>
                                <a href="<?php echo base_url() . 'perdin/konvert_pdf/' . $preview->file_srt; ?>" target="_blank">
                                  <img src="<?php echo base_url() . 'assets/images/icon/download.png'; ?>" alt="File Surat Visum Kadis" title="File Surat Visum Kadis" border="0">
                                </a>
                                <?php
                              endif;
                            endif;
                            ?>
                            <?php
                          endif; ?>
                        <?php 
                      } 
                    } 
                    ?>
                  </td>
                
                  <td>
                    <?php foreach ($search_preview as $preview) { 
                              if ($preview->no_grup_perdin == $row->no_grup_perdin && $preview->id_tim == $row->id_tim ) { 
                      ?>
                          <?php if ($preview->id_pegawai == 1152): ?>
                              <!-- Kondisi untuk id_pegawai 1152 -->
                              <a href="<?php echo base_url() . 'assets/file_surat_perdin/kadis_sekdis/' . $preview->file_srt; ?>" target="_blank">
                                  <img src="<?php echo base_url() . 'assets/images/icon/kadis_sp.png'; ?>" alt="File Surat Perdin Kadis" title="File Surat Perdin Kadis" border="0">
                              </a>
                              <?php if (!empty($preview->file_srt_visum_kadis)): ?>
                                  <!-- Tampilkan link visum_kadis jika no_surat tidak kosong -->
                                  <a href="<?php echo base_url() . 'assets/file_surat_perdin/visum_kadis/' . $preview->file_srt_visum_kadis; ?>" target="_blank">
                                      <button name="button" type="button" value="visum-kadis" class="button-wrc">Surat Visum Kadis</button>
                                  </a>
                                  <a href="<?php echo base_url() . 'perdin/konvert_pdf_sekdis_kadis/' . $preview->file_srt; ?>" target="_blank">
                                      <img src="<?php echo base_url() . 'assets/images/icon/download.png'; ?>" alt="File Surat Visum Kadis" title="File Surat Visum Kadis" border="0">
                                  </a>
                              <?php endif; ?>
                
                          
                          <?php endif; ?>
                      <?php 
                          } 
                      } 
                      ?>
                
                
                   
                  </td>
                
                  <td>
                   
                    <?php foreach ($search_preview as $preview) { 
                              if ($preview->no_grup_perdin == $row->no_grup_perdin && $preview->id_tim == $row->id_tim ) { 
                      ?>
                          <?php if ($preview->id_pegawai == 31): ?>
                              <!-- Kondisi untuk id_pegawai 31 -->
                              <a href="<?php echo base_url() . 'assets/file_surat_perdin/kadis_sekdis/' . $preview->file_srt; ?>" target="_blank">
                                  <img src="<?php echo base_url() . 'assets/images/icon/sekdis_sp.png'; ?>" alt="File Surat Perdin Kadis Sekdis" title="File Surat Perdin Kadis Sekdis" border="0">
                              </a>
                              <?php if (!empty($preview->no__sppd)): ?>
                                  <a href="<?php echo base_url() . 'perdin/konvert_pdf_sekdis_kadis/' . $preview->file_srt; ?>" target="_blank">
                                      <img src="<?php echo base_url() . 'assets/images/icon/download.png'; ?>" alt="File Surat Visum Kadis" title="File Surat Visum Kadis" border="0">
                                  </a>
                              <?php endif; ?>
                
                         <?php else: ?>
                          
                          <?php endif; ?>
                      <?php 
                          } 
                      } 
                      ?>
                
                
                   
                  </td>
                 
                  <td>
                      <?php 
                          if ($row->status_approve == 2) {
                              echo "✅ Sudah Di-approve";
                          } elseif ($row->status_approve == 1) {
                              echo "⏳ Belum Di-approve";
                          } else {
                            
                          }
                      ?>
                  </td>
                  <td>
                    <?php
                      if (!empty($row->log_terakhir)) {
                          echo $b . $this->lib_date->mysql_to_human($row->log_terakhir) . "<br>";
                      }
                    ?>
                  </td>
                  <td>
                    <a href="<?php echo base_url() . 'perdin/ubah_sp_perdin/' . $row->id; ?>">
                        <img src="<?php echo base_url() . 'assets/images/icon/property.png'; ?>" alt="Edit Perdin" title="Edit Perdin" border="0">
                    </a>
                      <?php 
                          if (($admin == 1 && $row->status_approve == 2) || ($iduser == 182 && $row->status_approve == 2)) {
                      ?>
                    <a href="<?php echo base_url() . 'perdin/penomoran_surat/' . $row->id  ?>">
                
                        <img src="<?php echo base_url() . 'assets/images/icon/arrow_icon.png'; ?>" alt="Penomoran Surat Perintah" title="Penomoran Surat Perintah" border="0">
                    </a>
                    <?php
                          }
                    ?>
                    <?php if ($admin == 1): ?>
                        <a href="<?php echo base_url().'perdin/delete_perdin/' . $row->no_grup_perdin . '/' . $row->id_tim; ?>" 
                          onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                            <img src="<?php echo base_url() .'assets/images/icon/silang.png'; ?>" alt="Hapus" title="Hapus Data">
                        </a>
                    <?php endif; ?>
                    <a href="<?php echo base_url() . 'perdin/reload_docx/' . $row->no_grup_perdin . '/' . $row->id_tim; ?>" onclick="return confirm('Apakah Anda yakin ingin reload (generate ulang) file word untuk data ini?');">
                        <img src="<?php echo base_url() . 'assets/images/icon/refresh.png'; ?>" alt="Reload Word" title="Reload Word" border="0" style="width: 16px; height: 16px; margin-left: 3px;">
                    </a>
                      <?php 
                          // if (($admin == 1 && $row->status_approve == 2) || ($iduser == 57 && $row->status_approve == 1)  || ($iduser == 182 && $row->status_approve == 1))  {
                          if (
                              ($admin == 1 && $row->status_approve == 2) || 
                              (
                                  ($iduser == 57 || $iduser == 182) && 
                                  ($row->status_approve == 1 || $row->status_approve == 0)
                              )
                          ){

                      ?>
                    <a href="<?php echo base_url() . 'perdin/approve_surat_perdin/' . $row->id  ?>">
                      <img src="https://dpmptsp.jabarprov.go.id/jelita/backoffice/assets/images/icon/clipboard.png" alt="approve surat perjalanan dinas" title="approve surat perjalanan dinas" border="0">
                    </a>
                     <?php
                          }
                    ?>
                  </td>
                </tr>
                <?php
                $i++;
              }
              ?>
            </tbody>
          </table>
          <?php
          if($rekap == 1){
            ob_end_flush();
            exit;
          }
          ?>
        </div>
      </div>
    </div>
  </div>
  <br style="clear: both;" />
</div>


<?php
function singkat_angka($n, $presisi=1) {
    if ($n < 900) {
        $format_angka = number_format($n, $presisi);
        $simbol = '';
    } else if ($n < 900000) {
        $format_angka = number_format($n / 1000, $presisi);
        $simbol = 'rb';
    } else if ($n < 900000000) {
        $format_angka = number_format($n / 1000000, $presisi);
        $simbol = 'jt';
    } else if ($n < 900000000000) {
        $format_angka = number_format($n / 1000000000, $presisi);
        $simbol = 'M';
    } else {
        $format_angka = number_format($n / 1000000000000, $presisi);
        $simbol = 'T';
    }

    if ( $presisi > 0 ) {
        $pisah = '.' . str_repeat( '0', $presisi );
        $format_angka = str_replace( $pisah, '', $format_angka );
    }
    
    return $format_angka;
}

?>

<script>

 Chart.defaults.font.size = 14;
  //Chart.register(ChartDataLabels);
 var ctx4 = document.getElementById('myChart4');



var ctx5 = document.getElementById('myChart5');
var ctx6 = document.getElementById('myChart6');
var ctx7 = document.getElementById('myChart7');
var ctx8 = document.getElementById('myChart8');


var myChart4 = new Chart(ctx4, {
    type: 'bar',
    plugins: [ChartDataLabels],
    data: {
        labels: [
        <?php 
            if(count($sektor)>0){
                foreach ($sektor as $rank) {
                    echo "'".$this->m_perdin->get_n_sektor($rank->bidang)."',";
                  // echo "'MPP Kab. Bandung',";
                }
            }    
        ?>
    ],
        datasets: [{
    label: '',
    data: [
        <?php 
            if(count($sektor)>0){
                foreach ($sektor as $rank) {
                    echo $rank->Total.",";
                }
            }    
        ?>
    ],
    backgroundColor: [
     'rgba(255, 99, 132)', 
    'rgba(255, 205, 86)',
    'rgba(170, 207, 207)',
    'rgba(255, 159, 64)',     
    'rgba(3, 252, 32)'
    ]
  }]
    },
     options: {
        //responsive: false,
        scales: {
            y: {
                beginAtZero: true
            }
        },
      plugins: {
        datalabels: {
        labels: {
            value: {
              color: 'blue'
            }
          }
         }
        }
      
    }
});

var myChart5 = new Chart(ctx5, {
    type: 'bar',
    plugins: [ChartDataLabels],
    data: {
        labels: [
        <?php 
            //if(count($lokasimpp)>0){
                foreach ($lokasimpp as $rank) {
                    echo "'".$this->m_perdin->get_n_mpp($rank->lokasi)."',";
                   // echo "'MPP Kota Bogor',";
                }
           // }    
        ?>
    ],
        datasets: [{
    label: '',
    data: [
        <?php 
         //   if(count($lokasimpp)>0){
                foreach ($lokasimpp as $rank) {
                    echo $rank->lok.",";
                }
           // }    
        ?>
    ],
    backgroundColor: [
     'rgba(255, 99, 132)', 
    'rgba(255, 205, 86)',
    'rgba(170, 207, 207)',
    'rgba(255, 159, 64)',     
    'rgba(3, 252, 32)'
    ]
  }]
    },
     options: {
        //responsive: false,
        scales: {
            y: {
                beginAtZero: true
            }
        },
      plugins: {
        datalabels: {
        labels: {
            value: {
              color: 'blue'
            }
          }
         }
        }
      
    }
});

var myChart6 = new Chart(ctx6, {
    type: 'bar',
    data: {
        labels: [
        <?php 
            if(count($peringkat)>0){
                foreach ($peringkat as $rank) {
                   // echo "'".get_negara($rank->id_negara)."',";
                }
            }    
        ?>
    ],
        datasets: [{
    label: '',
    data: [
        <?php 
            if(count($peringkat)>0){
                foreach ($peringkat as $rank) {
                    echo $rank->Total.",";
                }
            }    
        ?>
    ],
    backgroundColor: [
     'rgba(255, 99, 132)', 
    'rgba(255, 205, 86)',
    'rgba(170, 207, 207)',
    'rgba(255, 159, 64)',     
    'rgba(3, 252, 32)'
    ]
  }]
    },
    options: {
        plugins: {
                legend: {
                    display: false
                }
            },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    callback: function(value){
                        const valueLegend = this.getLabelForValue(value);
                        const valueLegendRep = valueLegend.replaceAll(',', '');
                        if (valueLegendRep.length === 1) {
                            return valueLegendRep;
                        }
                        if (valueLegendRep.length === 13) {
                            return valueLegendRep.substr(0, 1) + ' T';
                        }
                        if (valueLegendRep.length === 14) {
                            return valueLegendRep.substr(0, 2) + ' T';
                        }

                    }
                }
            }
            
        }
    }
});

var myChart7 = new Chart(ctx7, {
    type: 'bar',
    plugins: [ChartDataLabels],
    data: {
        labels: [
        <?php 
            if(count($petugas)>0){
                foreach ($petugas as $rank) {
                    echo "'".$this->m_perdin->get_n_user($rank->nama_petugas)."',";
                  // echo "'MPP Kab. Bandung',";
                }
            }    
        ?>
    ],
        datasets: [{
    label: '',
    data: [
        <?php 
            if(count($petugas)>0){
                foreach ($petugas as $rank) {
                    echo $rank->petugas.",";
                }
            }    
        ?>
    ],
    backgroundColor: [
     'rgba(255, 99, 132)', 
    'rgba(255, 205, 86)',
    'rgba(170, 207, 207)',
    'rgba(255, 159, 64)',     
    'rgba(3, 252, 32)'
    ]
  }]
    },
     options: {
        //responsive: false,
        scales: {
            y: {
                beginAtZero: true
            }
        },
      plugins: {
        datalabels: {
        labels: {
            value: {
              color: 'blue'
            }
          }
         }
        }
      
    }
});

var myChart8 = new Chart(ctx8, {
    type: 'bar',
    plugins: [ChartDataLabels],
    data: {
        labels: [
        <?php 
            if(count($tujuandatang)>0){
                foreach ($tujuandatang as $rank) {
                    echo "'".$this->m_perdin->get_tujuan($rank->tujuan)."',";
                  // echo "'MPP Kab. Bandung',";
                }
            }    
        ?>
    ],
        datasets: [{
    label: '',
    data: [
        <?php 
            if(count($tujuandatang)>0){
                foreach ($tujuandatang as $rank) {
                    echo $rank->Totaltujuan.",";
                }
            }    
        ?>
    ],
    backgroundColor: [
    'rgba(255, 99, 132)', 
    'rgba(255, 205, 86)',
    'rgba(170, 207, 207)',
    'rgba(255, 159, 64)',     
    'rgba(3, 252, 32)'
    ]
  }]
    },
     options: {
        //responsive: false,
        scales: {
            y: {
                beginAtZero: true
            }
        },
      plugins: {
        datalabels: {
        labels: {
            value: {
              color: 'blue'
            }
          }
         }
        }
      
    }
});

  </script>


 <!-- Bootstrap core JavaScript-->
     <!-- <script src="<?php echo site_url('assets/assets/grafik/'); ?>/js/jquery-3.5.1.js"></script>  -->
    <!-- <script src="<?php echo site_url('assets/assets/grafik/'); ?>/vendor/jquery/jquery.min.js"></script> -->
     <script src="<?php echo site_url('assets/assets/grafik/'); ?>/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>


    <!-- Core plugin JavaScript-->
    <!-- <script src="<?php echo site_url('assets/assets/grafik/'); ?>/vendor/jquery-easing/jquery.easing.min.js"></script> -->

    <!-- Custom scripts for all pages-->
    <!-- <script src="<?php echo site_url('assets/assets/grafik/'); ?>/js/sb-admin-2.min.js"></script> -->

    <!-- Page level plugins -->
    <script src="<?php echo site_url('assets/assets/grafik/'); ?>/js/chart.js"></script>
    <script src="<?php echo site_url('assets/assets/grafik/'); ?>/vendor/chart.js/Chart.min.js"></script>

    

    <!-- Page level custom scripts -->
    <!-- <script src="<?php echo site_url('assets/assets/grafik/'); ?>/vendor/canvasjs/canvasjs.min.js"></script> -->

   
    <!-- <script src="<?php echo site_url('assets/assets/grafik/'); ?>/vendor/datatables/dataTables.bootstrap4.min.js"></script> -->

    <!-- Page level custom scripts -->
    <!-- <script src="<?php echo site_url('assets/assets/grafik/'); ?>/js/demo/datatables-demo.js"></script> -->
    
