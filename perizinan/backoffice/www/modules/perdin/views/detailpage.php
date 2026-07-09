
<div id="content">
    <div class="post">
        <div class="title">
            <h2><?php echo $page_name; ?></h2>
        </div>

<div id="tabs">
            <?php
      $ctk_list = array('name' => 'button',
                        'content' => 'Cetak Surat',
                        'value' => 'Cetak Surat',
                        'class' => 'button-wrc',
                        'onclick' => 'parent.location=\''.site_url('perdin/cetak_surat_perintah/'.$id).'\''
                       );
      echo form_button($ctk_list);  
      ?>
            <?php
      $ctk_list = array('name' => 'button',
                        'content' => 'Back',
                        'value' => 'Back',
                        'class' => 'button-wrc',
                        'onclick' => 'parent.location=\''.site_url('perdin/suratperintah').'\''
                       );
      echo form_button($ctk_list);  
      ?>
<?php
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
            <th width="10%">Nomor Surat</th>
            <th width="10%">Dasar</th>
            <th width="10%">Kepada</th>
            <th width="10%">Untuk</th>
            <th width="10%">Tanggal</th>
            <th width="15%">TTD</th>
          </tr>   
        </thead>
        <tbody>
          <?php 
          $i = 1;
          foreach ($search as $row) { 
            if($row->ttd == '') {
              $b = '<span style="color: Red">';
              $be = '</span>';
            }else{
              $b = '';
              $be = '';
            }
          ?>
            <tr>
              <td><?php echo $i; ?></td>
              <td><?php echo $b.$row->nomor.$be; ?></td>
              <td><?php echo $b.$row->dasar.$be; ?> </td>
              <td><?php echo 'Nama : '.$b.$this->m_perdin->get_n_pegawai($row->kepada).$be.'<br>'.'NIP : '.$b.$this->m_perdin->get_n_nip($row->kepada).$be.'<br>'.'Jabatan : '.$b.$this->m_perdin->get_n_jabatan($row->kepada).$be; ?></td>
              <td><?php echo $b.$row->untuk.$be;  ?></td>
              <td><?php echo $b.$row->tanggal.$be;  ?></td>
              <td><?php 
              if($row->ttd == '1'){
                echo "Kepala Dinas";
              }else{
                echo "Sekertaris Dinas";
              }
          ?></td>
            </tr>
          <?php $i++; } ?>
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
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const listizin = document.getElementById("listizin");

        listizin.addEventListener("change", function () {
            const maxSelection = 4;
            const selectedOptions = Array.from(listizin.selectedOptions);

            if (selectedOptions.length > maxSelection) {
                alert("You can only select up to " + maxSelection + " people!");
                
                // Deselect the last selected option
                selectedOptions[selectedOptions.length - 1].selected = false;
            }
        });
    });
</script>

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
    
