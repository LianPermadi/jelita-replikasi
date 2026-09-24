
<div id="content">
  <div class="post">
    <div class="title">
      <h2><?php echo $page_name;  ?></h2>
    </div>
      
 <link href="<?php echo base_url("assets/assets/grafik/img/logo-dinas.png"); ?> " rel="icon">

    <!-- Custom fonts for this template-->
    <link href="<?php echo site_url('assets/assets/grafik/'); ?>/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
         <!--  -->

    <!-- Custom styles for this template-->
    <!-- <link href="<?php echo site_url('assets/assets/grafik/'); ?>/css/sb-admin-2.min.css" rel="stylesheet"> -->
    <!-- <link href="<?php echo site_url('assets/assets/grafik/'); ?>/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet"> -->
    <script src="<?php echo site_url('assets/assets/grafik/'); ?>/js/chart.js"></script>
   <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0-rc/dist/chartjs-plugin-datalabels.min.js"></script>

<div id="tabs">
          <ul>
            <li><a href="#tabs-1">Data Perdin</a></li>
            <li><a href="#tabs-2">Data Rekap Anggaran Perjalanan Dinas</a></li>
            <!-- <li><a href="#tabs-2">Grafik dan Chart Data</a></li> -->
          </ul>
          <div id="tabs-2">

     <?php
// Array bulan Indonesia (index 1 sampai 12)
$array_bulan = [
    1 => "Januari", 2 => "Februari", 3 => "Maret", 4 => "April",
    5 => "Mei", 6 => "Juni", 7 => "Juli", 8 => "Agustus",
    9 => "September", 10 => "Oktober", 11 => "November", 12 => "Desember"
];
?>

<table cellpadding="0" cellspacing="0" border="0" class="display" id="data_rekap_anggaran">
    <thead>
    <tr>
        <th style="display:none;">Bulan Sort</th> <!-- kolom tersembunyi -->
        <th>Bulan</th>
        <th>Total SP</th>
        <th>Total Uang Harian</th>
          <th>Periode</th>
      </tr>
  </thead>

    <tbody>
        <?php 
            $total_row = null;

            // Pisahkan baris total (bulan = NULL)
            foreach ($rekap_anggaran as $key => $row) {
                if ($row['bulan'] === null) {
                    $total_row = $row;
                    unset($rekap_anggaran[$key]);
                    break;
                }
            }

            // Urutkan berdasarkan bulan (1 - 12)
         

            if (!empty($rekap_anggaran) && is_array($rekap_anggaran)) :
                foreach ($rekap_anggaran as $row) :
        ?>
      <tr>
          <td style="display:none;"><?= $row['bulan'] ?></td> <!-- bulan angka -->
          <td><?= $array_bulan[$row['bulan']] ?></td>
          <td><?= $row['total_sp'] ?></td>
          <td>Rp <?= number_format($row['total_uang_harian'], 0, ',', '.') ?></td>
          <td><?= $row['tanggal_awal'] ?> s/d <?= $row['tanggal_akhir'] ?></td>
      </tr>


        <?php 
                endforeach;
            else: 
        ?>
            <tr><td colspan="4">Data tidak tersedia</td></tr>
        <?php endif; ?>
    </tbody>    

    <?php if ($total_row): ?>
        <tfoot>
            <tr>
                <th>Total Keseluruhan</th>
                <th><?= $total_row['total_sp'] ?></th>
                <th>Rp <?= number_format($total_row['total_uang_harian'], 0, ',', '.') ?></th>
                <th><?= $total_row['tanggal_awal'] ?> s/d <?= $total_row['tanggal_akhir'] ?></th>
            </tr>
        </tfoot>
    <?php endif; ?>
</table>





</div>
            <div id="tabs-1">
     <div class="entry">

        <fieldset id="half">
        <legend>Filter Data Berdasarkan Tanggal Keberangkatan</legend>
        <?php
        echo form_open('perdin/rekap');

         //$asal_permohonan = array('0' => '------ Seluruhnya ------','Pusat' => 'Pusat'); // Untuk daerah lain
            $esselon_id = array('0' => '-------- Seluruhnya --------','1' => 'Esselon 4','4' => 'Esselon 3',
                                     '3' => 'Esselon 2','2' => "Selesai Jelita",'9' => 'Selesai OSS RBA','10' => 'Belum Approve Ess.3 di OSSRBA');
            ?>
           
        <!--     <div id="statusRail">
              <div id="leftRail"> 
                <?php 
                echo form_label('Status Izin', 'label_permohonan');
               // echo form_hidden('mark', 'tanda');
                ?>
              </div>
              <div id="rightRail"> <?php
                  echo form_dropdown('statusizin', $esselon_id, $statusizin, 'class = "input-select-wrc" id="selector"');
                
                ?>
              </div>
            </div> -->

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

                // $x=  date('m',strtotime($tglb));
                // echo $x;
                // echo  $this->lib_date->set_month_name(date('m',strtotime($tglb)), 'id');
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
      <?php } ?>

      <?php 
        $alert = $this->session->flashdata("gagal");
        if(!empty($alert)){
      ?>
        <br>
        <div style="color: red; font-size: 12px; margin-left: 20px; margin-bottom: 10px; font-weight: bold;"><center><?php echo $alert; ?></center></div>
      <?php } ?>
    
    <div class="entry">
     <table>
      <tr>
        <td>
      <?php 
      // $tipe_rekap = "";
      // $id = "";
      // $jenis_jumlah="";
      //  $img_cetak_excel = array('src' => base_url().'assets/images/icon/excel.png',
      //                                'alt' => 'Cetak Data Perdin (Format BPK)',
      //                                'title' => 'Cetak Data Perdin (Format BPK)'
      //                               );
      //   // echo "Export Data Perdin (Format BPK) <br>";
      //       echo anchor(site_url('perdin/cetak_excel').'/'.(!empty($tgla) && !empty($tglb) ? $tgla.'/'.$tglb : '0/0'), img($img_cetak_excel));
           
            ?>
            </td>
            <!-- <td><span>Export Data Perdin (Format BPK)</span></td> -->
      </tr>
      <tr>
        <td>
             <?php 
      // $tipe_rekap = "";
      // $id = "";
      // $jenis_jumlah="";
      //  $img_cetak_excel = array('src' => base_url().'assets/images/icon/excel.png',
      //                                'alt' => 'Cetak Data Perdin (Format Pimpinan)',
      //                                'title' => 'Cetak Data Perdin (Format Pimpinan)'
      //                               );
      //   // echo "Export Data Perdin (Format Pimpinan) <br>";
      //       echo anchor(site_url('perdin/cetak_excel_pimpinan').'/'.(!empty($tgla) && !empty($tglb) ? $tgla.'/'.$tglb : '0/0'), img($img_cetak_excel));
           
            ?>
          </td>
          <!-- <td><span>Export Data Perdin (Format Pimpinan)</span></td> -->
        </tr>
      </table>
      <br><br>
      <form method="post" action="<?= site_url('perdin/cetak_excel_rekap') ?>" target="_blank">
  <input type="hidden" name="tgla" value="<?= $tgla ?>" />
  <input type="hidden" name="tglb" value="<?= $tglb ?>" />
  <button type="submit" class="button-wrc">Cetak Rekap Perdin</button>
  </form>

         <table cellpadding="0" cellspacing="0" border="0" class="display" id="pendataan">
            <thead>
                <tr>
                    <th width="2%">No</th>
                    <th width="10%">Nama Pelaksana</th>
                    <th width="28%">Jumlah Perdin</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 1;
                foreach ($search as $data):
                ?>
                <tr>
                    <td style="text-align: center;"><?= $i ?></td>
                    <td style="text-align: center;"><?= $data['n_pegawai'] ?></td>
                    <td style="text-align: center;"><?= $data['total_sp'] ?></td>
                </tr>
                <?php
                $i++;
                endforeach;
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
    

   