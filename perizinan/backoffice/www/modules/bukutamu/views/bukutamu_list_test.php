<div id="content">
  <div class="post">
    <div class="title">
      <?php echo $this->lib_date->view_title($page_name); ?>
    </div>
    <link href="<?php echo base_url("assets/assets/grafik/img/logo-dinas.png"); ?> " rel="icon">
    <!-- Custom fonts for this template-->
    <link href="<?php echo site_url('assets/assets/grafik/'); ?>/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <!-- Custom styles for this template-->
    <!-- <link href="<?php echo site_url('assets/assets/grafik/'); ?>/css/sb-admin-2.min.css" rel="stylesheet"> -->
    <!-- <link href="<?php echo site_url('assets/assets/grafik/'); ?>/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet"> -->
    <script src="<?php echo site_url('assets/assets/grafik/'); ?>/js/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0-rc/dist/chartjs-plugin-datalabels.min.js"></script>
    
    <div id="tabs">
      <ul>
        <li><a href="#tabs-1">Data BukuTamu / E-Report</a></li>
        <li><a href="#tabs-2">Grafik dan Chart Data</a></li>
      </ul>
      <div id="tabs-1">
        <div class="entry">
          <fieldset id="half">
            <legend>Filter Data Berdasarkan Tanggal Kedatangan Tamu</legend>
            <?php
            echo form_open('bukutamu/index');
            
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
            <!--   <div id="statusRail">
                    <div id="leftRail"> 
              <table>
                <tr>
                  <td> <?php echo 'Tanggal Awal : ' . form_input($periodeawal_input); ?> </td>
                  <td> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                  <td> <?php echo 'Tanggal Akhir : '. form_input($periodeakhir_input); ?> </td>
                  <td> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
              
                </tr>
              </table>
            </div></div> -->
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
        <?php } ?>
        
        <div class="entry">
          <!--  <?php
            $ctk_list = array('name' => 'button',
                              'content' => 'Tambah Bukutamu',
                              'value' => 'Tambah Bukutamu',
                              'class' => 'button-wrc',
                              'onclick' => 'parent.location=\''.site_url('bukutamu/add').'\''
                             );
            echo form_button($ctk_list);  
          ?> -->
          <?php 
          $tipe_rekap = "";
          $id = "";
          $jenis_jumlah="";
          $img_cetak_excel = array('src' => base_url().'assets/images/icon/excel.png',
                                   'alt' => 'Cetak Excel',
                                   'title' => 'Cetak Detail ke Excel'
                                  );
          echo "Export Data Tamu (Excel) <br>";
          echo anchor(site_url('bukutamu/cetak_excel').'/'.(!empty($tgla) && !empty($tglb) ? $tgla.'/'.$tglb : '0/0'), img($img_cetak_excel));
          ?>
          <table cellpadding="0" cellspacing="0" border="0" class="display" id="pendataan">
            <thead>
              <tr>
                <th width="2%">No</th>
                <th width="18%">Tanggal / Jam <br> Nama Tamu <br> Email <br> Handphone</th>
                <th width="17%">Sektor <br> Jenis Izin<br>Jabatan</th>
                <th width="15%">Nama Perusahaan/Instansi<br> NIB  <br> NIK </th>
                <th width="20%">Informasi/ Permasalahan<br>FO / MPP/ Gerai <br>Tujuan Kedatangan<br>Layanan</th>
                <th width="18%">Nama Petugas <br>Solusi <br> Keterangan</th>
                <th width="10%">Aksi</th>
                
              </tr>
            </thead>
            <tbody>
              <?php 
              $i = 1;
              foreach ($search as $row) {
              	$tgl = $this->lib_date->mysql_to_human(date("Y/m/d", strtotime($row->waktu)));
          	    $jam = date("h:i:sa", strtotime($row->waktu));
                if($row->nama_petugas == '-' or $row->nama_petugas==NULL) {
                  $b = '<span style="color: Red">';
                  $be = '</span>';
                  //$c = '<br>Revisi : '.$row->revisi;
                }else{
                  $b = '';
                  $be = '';
                 // $c = '<br>'.$row->revisi; 
                }
                ?>
                <tr>
                  <td><?php echo $i; ?></td>
                  <td><?php echo $b.$tgl.' / '.$jam."<br>".$row->nama."<br>".$row->email."<br>".$row->telepon; ?></td>
                  <td><?php echo $b.$this->m_bukutamu->get_n_sektor($row->bidang)."<br>".$row->jenis_izin."<br>".$row->esselon.$be;  ?></td>
                  <td><?php echo $b.$row->instansi."<br>".$row->nib."<br>".$row->nik.$be; ?></td>
                  <td><?php echo $b."1. ".$row->keperluan." <br> 2. ".$this->m_bukutamu->get_n_mpp($row->lokasi)."<br>3. ".$this->m_bukutamu->get_tujuan($row->tujuan)." <br> 4. ".$row->layanan.$be; ?></td>
                  <td><?php echo $b.$this->m_bukutamu->get_n_user($row->nama_petugas)." <br>".$row->solusi." <br>".$row->Keterangan.$be; ?></td>
                  <td><?php echo '<a href="'.base_url().'bukutamu/ubah/'.$row->id.'"><img src="'.
                    base_url().'assets/images/icon/property.png" alt="Edit BukuTamu" title="Edit BukuTamu" border="0"></a> &nbsp;'; 
                    if ($admin == 1) {
                      $confirm_text = $this->session->userdata('username').', Apakah Anda yakin menghapus data '.'?';
                      $img_delete = array('src' => 'assets/images/icon/cross.png',
                                          'alt' => 'Hapus Data',
                                          'title' => 'Hapus Data',
                                          'border' => '0',
                                          'onClick' => 'return confirm_link(\''.$confirm_text.'\')'
                                         );
                      echo anchor(site_url('bukutamu/hapus/')."/".$row->id, img($img_delete))."&nbsp;";
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
        </div>
      </div>
      
      <div id="tabs-2">
        <div class="entry">
          <fieldset id="half">
            <legend>Filter Data Berdasarkan Tanggal Kedatangan Tamu</legend>
            <?php
            echo form_open('bukutamu/index');
            ?>
            <div id="statusRail">
              <div id="leftRail">
                <?php echo form_label('Periode Awal','d_tahun'); ?>
              </div>
              <div id="rightRail">
                <?php
                $periodeawal_input = array('name'  => 'tgla', // tglc
                                           'value' => $tgla, // $tglc
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
                $periodeakhir_input = array('name'  => 'tglb', //tgld
                                            'value' => $tglb,  //$tgld
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
            <!--   <div id="statusRail">
              <div id="leftRail"> 
              <table>
                <tr>
                  <td> <?php echo 'Tanggal Awal : ' . form_input($periodeawal_input); ?> </td>
                  <td> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                  <td> <?php echo 'Tanggal Akhir : '. form_input($periodeakhir_input); ?> </td>
                  <td> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
              
                </tr>
              </table>
            </div></div> -->
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

        <div class="entry">
          <div class="row">     
            <div class="col-xl-4 col-lg-5">
              <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h2 class="m-0 font-weight-bold text-primary">Grafik Berdasarkan Jumlah Pengunjung MPP/GPP (<?php echo $this->lib_date->mysql_to_human($tglc)." - ".$this->lib_date->mysql_to_human($tgld); ?>)</h2>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                  <div class="chart-pie pt-4 pb-2">
                    <canvas id="myChart5" style="height: 60%; width: 60%;"></canvas>
                  </div>
                </div>
                <!-- </div> -->
              </div>
            </div>
            
            <div class="col-xl-4 col-lg-5">
              <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h2 class="m-0 font-weight-bold text-primary">Grafik Berdasarkan Petugas (<?php echo $this->lib_date->mysql_to_human($tglc)." - ".$this->lib_date->mysql_to_human($tgld); ?>)</h2>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                  <div class="chart-pie pt-4 pb-2">
                    <canvas id="myChart7" style="height: 50%; width: 50%;"></canvas>
                  </div>
                </div>
                <!-- </div> -->
              </div>
            </div>
            
            <div class="col-xl-4 col-lg-5">
              <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h2 class="m-0 font-weight-bold text-primary">Grafik Berdasarkan Tujuan Kedatangan (<?php echo $this->lib_date->mysql_to_human($tglc)." - ".$this->lib_date->mysql_to_human($tgld); ?>)</h2>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                  <div class="chart-pie pt-4 pb-2">
                    <canvas id="myChart8" style="height: 50%; width: 50%;"></canvas>
                  </div>
                </div>
                <!-- </div> -->
              </div>
            </div>
            
            <div class="col-xl-4 col-lg-5">
              <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h2 class="m-0 font-weight-bold text-primary">Grafik Berdasarkan Sektor (<?php echo $this->lib_date->mysql_to_human($tglc)." - ".$this->lib_date->mysql_to_human($tgld); ?>)</h2>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                  <div class="chart-pie pt-4 pb-2">
                    <canvas id="myChart4" style="height: 50%; width: 50%;"></canvas>
                  </div>
                </div>
                <!-- </div> -->
              </div>
            </div>
            
            <!--   <div class="col-xl-4 col-lg-5">
                  <div class="card shadow mb-4">
                      Card Header - Dropdown
                      <div
                          class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                          <h2 class="m-0 font-weight-bold text-primary">5 Peringkat Teratas Jumlah Investasi PMA Jawa Barat Hingga TW 3 Berdasarkan Negara 2021</h6>
                      </div>
                      Card Body
                      <div class="card-body">
                          <div class="chart-pie pt-4 pb-2">
                              <canvas id="myChart6" style="height: 50%; width: 50%;"></canvas>
                          </div>
                         
                      </div>
                  </div>
              </div>
            </div> -->
            
          </div> 
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
                      echo "'".$this->m_bukutamu->get_n_sektor($rank->bidang)."',";
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
                    if($rank->Total > 0){
                      echo $rank->Total.",";
                    }else{
                  	  //PBS Edit
                   	  $euis_bukutamu = new euis_bukutamu();
                   	  $list_jumlah = $euis_bukutamu->where("DATE(waktu) between '$tgla' and '$tglb' AND bidang IS NULL")->count();
                   	  echo "'".$list_jumlah."'".",";
                   	  //PBS Edit
                    }
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
                      echo "'".$this->m_bukutamu->get_n_mpp($rank->lokasi)."',";
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
  
  // var myChart5 = new Chart(ctx5, {
  //     type: 'bar',
  //      plugins: [ChartDataLabels],
  //     data: {
  //         labels: [
  //         <?php 
  //             // if(count($mpp)>0){
  //             //     foreach ($mpp as $row) {
  //                     echo "'JIH DPMPTSP Jabar',";
  //                     echo "'Lobby DPMPTSP Jabar',";
  //                     echo "'MPP Kota. Bandung',";
  //                     echo "'GPP Kota Bandung',";
  //                     echo "'MPP Kab. Bandung',";
  //                     echo "'GPP Kota Cirebon',";
  //                     echo "'GPP Kab. Cirebon',";
  //                     echo "'MPP Kota Tasikmalaya',";
  //                     echo "'GPP Kab. Garut',";
  //                     echo "'MPP Kab. Purwakarta',";
  //                     echo "'MPP Kab. Karawang',";
  //                     echo "'MPP Kota Bekasi',";
  //                     echo "'MPP Kab. Bekasi',";
  //                     echo "'MPP Kota Bogor',";
  //                     echo "'GPP Plasa Cibubur',";
  //                     echo "'MPP Kab. Sumedang',";
                     
  //              //   }
  //             //}    
  //         ?>
  //     ],
  //         datasets: [{
  //     label: '',
  //     data: [
  //         <?php 
  //           //  if(count($mpp)>0){
  //              //   foreach ($mpp as $row) {
  //                    echo $mpp->jdpmptsp.",";
  //                     echo $mpp->ldpmptsp.",";
  //                     echo $mpp->mkotabandung.",";
  //                     echo $mpp->gkotabandung.",";
  //                     echo $mpp->kabbandung.",";
  //                     echo $mpp->kotacirebon.",";
  //                     echo $mpp->kabcirebon.",";
  //                     echo $mpp->kotatasik.",";
  //                     echo $mpp->kabgarut.",";
  //                     echo $mpp->kabpurwakarta.",";
  //                     echo $mpp->kabkarawang.",";
  //                     echo $mpp->kotabekasi.",";
  //                     echo $mpp->kabbekasi.",";
  //                     echo $mpp->kotabogor.",";                 
  //                     echo $mpp->cibubur.",";
  //                     echo $mpp->sumedang.",";
  
  //               //  }
  //           //  }    
  //         ?>
  //     ],
  //     backgroundColor: [
  //       'rgba(255, 99, 132)', 
  //       'rgba(255, 205, 86)',
  //       'rgba(255, 159, 64)',     
  //        'rgba(170, 207, 207)',
  //       'rgba(3, 252, 32)'
  //     ]
  //   }]
  //     },
  //      options: {
  //         scales: {
  //             y: {
  //                 beginAtZero: true
  //             }
  //         },
  //         plugins: {
  //         datalabels: {
  //         labels: {
  //             value: {
  //               color: 'blue'
  //             }
  //           }
  //          }
  //         }
  //       }
  // });
  
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
                    echo "'".$this->m_bukutamu->get_n_user($rank->nama_petugas)."',";
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
                  	if($rank->petugas > 0){
                      echo $rank->petugas.",";
                    }else{
                    	//PBS Edit
                    	$euis_bukutamu = new euis_bukutamu();
                    	$list_jumlah = $euis_bukutamu->where("DATE(waktu) between '$tgla' and '$tglb' AND nama_petugas IS NULL")->count();
                    	echo "'".$list_jumlah."'".",";
                    	//PBS Edit
                    }  
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
                      echo "'".$this->m_bukutamu->get_tujuan($rank->tujuan)."',";
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
                  if($rank->Totaltujuan > 0){
                    echo $rank->Totaltujuan.",";
                  }else{
                  	//PBS Edit
                   	$euis_bukutamu = new euis_bukutamu();
                   	$list_jumlah = $euis_bukutamu->where("DATE(waktu) between '$tgla' and '$tglb' AND tujuan IS NULL")->count();
                   	echo "'".$list_jumlah."'".",";
                   	//PBS Edit
                  }
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