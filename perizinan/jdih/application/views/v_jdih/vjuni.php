<!doctype html>
<html lang="en">
 
<head>
    <?php $this->load->view("realisasi_dpa/partial/head.php") ?>
</head>

<body>
    <!-- ============================================================== -->
    <!-- main wrapper -->
    <!-- ============================================================== -->
    <div class="dashboard-main-wrapper">
        <!-- ============================================================== -->
        <!-- navbar -->
        <!-- ============================================================== -->
         <?php $this->load->view("realisasi_dpa/partial/navbar.php") ?>
        <!-- ============================================================== -->
        <!-- end navbar -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- left sidebar -->
        <!-- ============================================================== -->
     <!-- <?php $this->load->view("realisasi_dpa/partial/sidebar.php") ?> -->
        <!-- ============================================================== -->
        <!-- end left sidebar -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- wrapper  -->
        <!-- ============================================================== -->
        <div class="dashboard-wrapper">
            <div class="dashboard-ecommerce">
                <div class="container-fluid dashboard-content ">
                    <!-- ============================================================== -->
                    <!-- pageheader  -->
                    <!-- ============================================================== -->
                    <div class="row">
                        <div class="col-xl-9 col-lg-12 col-md-6 col-sm-12 col-12">
                            <div class="page-header text-center">
                                <h2 class="pageheader-title">REALISASI APBD TAHUN ANGGARAN 2021</h2>
                                <h3 class="pageheader-title">Dinas Penanaman Modal dan Pelayanan Terpadu Satu Pintu Provinsi Jawa Barat</h3>
                                <h3 class="pageheader-title">(s.d 30 Juni 2021)</h3>
                                <!-- <h3 class="pageheader-title"><?php echo $tanggal->tgl; ?></h3> -->
                                <p class="pageheader-text">-</p>
                                
                            </div>
                        </div>
                    </div>
                    <!-- ============================================================== -->
                    <!-- end pageheader  -->
                    <!-- ============================================================== -->
                    
                    <div class="ecommerce-widget">
                     <div class="dropdown">
                      <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Pilih Bulan
                      </button>
                      <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item"  href="<?php echo base_url('Realisasidpa/januari') ?>">Januari</a>
                        <a class="dropdown-item"  href="<?php echo base_url('Realisasidpa/februari') ?>">Februari</a>
                        <a class="dropdown-item"  href="<?php echo base_url('Realisasidpa/maret') ?>">Maret</a>
                        <a class="dropdown-item"  href="<?php echo base_url('Realisasidpa/april') ?>">April</a>
                        <a class="dropdown-item"  href="<?php echo base_url('Realisasidpa/mei') ?>">Mei</a>
                        <a class="dropdown-item"  href="<?php echo base_url('Realisasidpa/juli') ?>">Juli</a>
                        <a class="dropdown-item"  href="<?php echo base_url('Realisasidpa/agustus') ?>">Agustus</a>
                        <a class="dropdown-item"  href="<?php echo base_url('Realisasidpa/september') ?>">September</a>
                        <a class="dropdown-item"  href="<?php echo base_url('Realisasidpa') ?>">Oktober</a>
                      </div>
                    </div>
                    <div class=""><!-- col-xl-9 col-lg-12 col-md-6 col-sm-12 col-12 -->
                                <div class="card">
                                    <!-- <select class="form-control" name="combo1" id="combo1">
                                <option value="">Pilih Combobox Statis</option>
                                <option value="Nama Provinsi 1">Nama Provinsi 1</option>
                                <option value="Nama Provinsi 2">Nama Provinsi 2</option>
                                <option value="Nama Provinsi 3">Nama Provinsi 3</option>
                                <option value="Nama Provinsi 4">Nama Provinsi 4</option>
                                <option value="Nama Provinsi 5">Nama Provinsi 5</option>
                            </select> -->
                            <br>
                                 <!--    <h5 class="card-header">Recent Orders</h5> -->
                                    <div class="card-body p-0">
                                        <div class="table-responsive">
                                            <table class="table table-hover">
                                                <thead class="bg-light">
                                                    <tr class="border-0">
                                                        <th class="border-0" colspan="3">Kode Kegiatan</th>
                                                        <th class="border-0" colspan="">Nama Kegiatan</th>
                                                        <th class="border-0">Jumlah Anggaran</th>
                                                        <th class="border-0">Realisasi</th>
                                                        <th class="border-0">%</th>
                                                        <th class="border-0">Sisa SP2D</th>
                                                        <th class="border-0">Keterangan</th>
                                                    </tr>
                                                </thead>
                                                    <?php $pgaji = ($realisasi_gaji/$jumlah_gaji)*100; ?>
                                                <tbody>
                                                    <tr>                                                 
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th>Belanja Gaji dan Tunjangan</th>
                                                        <th><?php echo "Rp" . number_format($jumlah_gaji,0,',','.'); ?></th>
                                                        <th><?php echo  "Rp" . number_format($realisasi_gaji,0,',','.'); ?></th>
                                                        <th><?php echo round($pgaji,2); ?></td>
                                                        <th><?php echo  "Rp" . number_format($jumlah_gaji-$realisasi_gaji,0,',','.'); ?></th>
                                                        <th></th>
                                                    </tr>
                                                    <?php $coba = ($dpa_seluruhjuni->real_total/$dpa_seluruhjuni->dpa_total)*100; ?>
                                                    
                                                    <tr>                                                 
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th>Belanja Langsung</th>
                                                        <th><?php echo "Rp" . number_format($dpa_seluruhjuni->dpa_total,0,',','.'); ?></th>
                                                        <th><?php echo  "Rp" . number_format($dpa_seluruhjuni->real_total,0,',','.'); ?></th>
                                                        <th><?php echo round($coba,2); ?></td>
                                                        <th><?php echo  "Rp" . number_format($dpa_seluruhjuni->sisa_total,0,',','.'); ?></th>
                                                        <th></th>
                                                    </tr>
                               
                                                </tbody>
                                                <tbody>
                                                    <tr>
                                                      <?php foreach ($sekretariatjuni as $sekretariat): ?>
                                                        <td><?php echo $sekretariat->kode1 ?></td>
                                                        <td><?php echo $sekretariat->kode2 ?></td>
                                                        <td><?php echo $sekretariat->kode3 ?></td>
                                                        <td><?php echo $sekretariat->nama_kegiatan ?></td>
                                                        <td><?php echo  "Rp" . number_format($sekretariat->dpa_perubahan,0,',','.'); ?></td>
                                                        <td><?php echo  "Rp" . number_format($sekretariat->realisasi,0,',','.'); ?></td>
                                                        <td><?php echo round($sekretariat->persentase,2); ?></td>
                                                        <td><?php echo  "Rp" . number_format($sekretariat->sisa_anggaran,0,',','.'); ?></td>
                                                        <td><?php echo $sekretariat->keterangan ?></td>
                                                    </tr>
                                                    <?php endforeach; ?>   
                                                </tbody>
                                                <?php $psek = ($dpa_sekrejuni->realisasi_sekre/$dpa_sekrejuni->dpa_sekre)*100; ?>
                                                <thead class="bg-light">
                                                    <tr class="border-0">
                                                        <th class="border-0" align="text-center"></th>
                                                        <th  class="border-0" align="text-center"></th>
                                                        <th  class="border-0" align="text-center"></th>
                                                        <th  class="border-0 d-flex justify-content-end" align="text-center">JUMLAH SEKRETARIAT</th>
                                                        
                                                        <th class="border-0"><?php echo "Rp" . number_format($dpa_sekrejuni->dpa_sekre,0,',','.'); ?></th>
                                                        <th class="border-0"><?php echo "Rp" . number_format($dpa_sekrejuni->realisasi_sekre,0,',','.'); ?></th>
                                                        <th class="border-0" id="psek"><?php echo round($psek,2);?></th>
                                                        <th class="border-0"><?php echo "Rp" . number_format($dpa_sekrejuni->sisa_sekre,0,',','.'); ?></th>
                                                        <th class="border-0" align="text-center"></th>
                                                    </tr>
                                                </thead>

                                                <tbody>
                                                    <tr>
                                                      <?php foreach ($bangpromjuni as $bangprom): ?>
                                                        <td><?php echo $bangprom->kode1 ?></td>
                                                        <td><?php echo $bangprom->kode2 ?></td>
                                                        <td><?php echo $bangprom->kode3 ?></td>
                                                        <td><?php echo $bangprom->nama_kegiatan ?></td>
                                                        <td><?php echo  "Rp" . number_format($bangprom->dpa_perubahan,0,',','.'); ?></td>
                                                        <td><?php echo  "Rp" . number_format($bangprom->realisasi,0,',','.'); ?></td>
                                                        <td><?php echo round($bangprom->persentase,2); ?></td>
                                                        <td><?php echo  "Rp" . number_format($bangprom->sisa_anggaran,0,',','.'); ?></td>
                                                        <td><?php echo $bangprom->keterangan ?></td>
                                                    </tr>
                                                    <?php endforeach; ?>   
                                                </tbody>

                                                <?php $pbang = ($dpa_bangpromjuni->realisasi_bangprom/$dpa_bangpromjuni->dpa_bangprom)*100; ?>
                                                 <thead class="bg-light">
                                                    <tr class="border-0">
                                                        <th class="border-0" align="text-center"></th>
                                                        <th  class="border-0" align="text-center"></th>
                                                        <th  class="border-0" align="text-center"></th>
                                                        <th  class="border-0 d-flex justify-content-end" align="text-center">JUMLAH BANGPROM</th>
                                                        
                                                        <th class="border-0"><?php echo "Rp" . number_format($dpa_bangpromjuni->dpa_bangprom,0,',','.'); ?></th>
                                                        <th class="border-0"><?php echo "Rp" . number_format($dpa_bangpromjuni->realisasi_bangprom,0,',','.'); ?></th>
                                                        <th class="border-0"><?php echo round($pbang,2); ?></th>
                                                        <th class="border-0"><?php echo "Rp" . number_format($dpa_bangpromjuni->sisa_bangprom,0,',','.'); ?></th>
                                                        <th class="border-0" align="text-center"></th>
                                                    </tr>
                                                </thead>
                                               
                                                
                                                
                                                <tbody>
                                                    <tr>
                                                      <?php foreach ($esdajuni as $esda): ?>
                                                        <td><?php echo $esda->kode1 ?></td>
                                                        <td><?php echo $esda->kode2 ?></td>
                                                        <td><?php echo $esda->kode3 ?></td>
                                                        <td><?php echo $esda->nama_kegiatan ?></td>
                                                        <td><?php echo  "Rp" . number_format($esda->dpa_perubahan,0,',','.'); ?></td>
                                                        <td><?php echo  "Rp" . number_format($esda->realisasi,0,',','.'); ?></td>
                                                        <td><?php echo round($esda->persentase,2); ?></td>
                                                        <td><?php echo  "Rp" . number_format($esda->sisa_anggaran,0,',','.'); ?></td>
                                                        <td><?php echo $esda->keterangan ?></td>
                                                    </tr>
                                                    <?php endforeach; ?>   
                                                </tbody>

                                                <?php $pesda = ($dpa_esdajuni->realisasi_esda/$dpa_esdajuni->dpa_esda)*100; ?>
                                                <thead class="bg-light">
                                                    <tr class="border-0">
                                                         <th class="border-0" align="text-center"></th>
                                                        <th  class="border-0" align="text-center"></th>
                                                        <th  class="border-0" align="text-center"></th>
                                                        <th  class="border-0 d-flex justify-content-end" align="text-center">JUMLAH ESDA/INSOS</th>
                                                        
                                                        <th class="border-0"><?php echo "Rp" . number_format($dpa_esdajuni->dpa_esda,0,',','.'); ?></th>
                                                        <th class="border-0"><?php echo "Rp" . number_format($dpa_esdajuni->realisasi_esda,0,',','.'); ?></th>
                                                        <th class="border-0"><?php echo round($pesda,2); ?></th>
                                                        <th class="border-0"><?php echo "Rp" . number_format($dpa_esdajuni->sisa_esda,0,',','.'); ?></th>
                                                        <th class="border-0" align="text-center"></th>
                                                    </tr>
                                                </thead>
                                                
                                                <!-- <tbody>
                                                    <tr>
                                                      <?php foreach ($insosfeb as $insos): ?>
                                                        <td><?php echo $insos->kode1 ?></td>
                                                        <td><?php echo $insos->kode2 ?></td>
                                                        <td><?php echo $insos->kode3 ?></td>
                                                        <td><?php echo $insos->nama_kegiatan ?></td>
                                                        <td><?php echo  "Rp" . number_format($insos->dpa_perubahan,0,',','.'); ?></td>
                                                        <td><?php echo  "Rp" . number_format($insos->realisasi,0,',','.'); ?></td>
                                                        <td><?php echo $insos->persentase ?></td>
                                                        <td><?php echo  "Rp" . number_format($insos->sisa_anggaran,0,',','.'); ?></td>
                                                        <td><?php echo $insos->keterangan ?></td>
                                                    </tr>
                                                    <?php endforeach; ?>   
                                                </tbody>
                                                <thead class="bg-light">
                                                    <tr class="border-0">
                                                        <th class="border-0" align="text-center"></th>
                                                        <th  class="border-0" align="text-center"></th>
                                                        <th  class="border-0" align="text-center"></th>
                                                        <th  class="border-0 d-flex justify-content-end" align="text-center">JUMLAH INSOS</th>
                                                        
                                                        <th class="border-0"><?php echo "Rp" . number_format($dpa_insos->dpa_insos,0,',','.'); ?></th>
                                                        <th class="border-0"><?php echo "Rp" . number_format($dpa_insos->realisasi_insos,0,',','.'); ?></th>
                                                        <th class="border-0">99.99%</th>
                                                        <th class="border-0"><?php echo "Rp" . number_format($dpa_insos->sisa_insos,0,',','.'); ?></th>
                                                        <th class="border-0" align="text-center"></th>
                                                    </tr>
                                                </thead> -->
                                                                                                                                               
                                                <tbody>
                                                    <tr>
                                                      <?php foreach ($pengendalianjuni as $pengendalian): ?>
                                                        <td><?php echo $pengendalian->kode1 ?></td>
                                                        <td><?php echo $pengendalian->kode2 ?></td>
                                                        <td><?php echo $pengendalian->kode3 ?></td>
                                                        <td><?php echo $pengendalian->nama_kegiatan ?></td>
                                                        <td><?php echo  "Rp" . number_format($pengendalian->dpa_perubahan,0,',','.'); ?></td>
                                                        <td><?php echo  "Rp" . number_format($pengendalian->realisasi,0,',','.'); ?></td>
                                                        <td><?php echo round($pengendalian->persentase,2); ?></td>
                                                        <td><?php echo  "Rp" . number_format($pengendalian->sisa_anggaran,0,',','.'); ?></td>
                                                        <td><?php echo $pengendalian->keterangan ?></td>
                                                    </tr>
                                                    <?php endforeach; ?>   
                                                </tbody>

                                                <?php $pdal = ($dpa_pengendalianjuni->realisasi_pengendalian/$dpa_pengendalianjuni->dpa_pengendalian)*100; ?>
                                                 <thead class="bg-light">
                                                    <tr class="border-0">
                                                        <th class="border-0" align="text-center"></th>
                                                        <th  class="border-0" align="text-center"></th>
                                                        <th  class="border-0" align="text-center"></th>
                                                        <th  class="border-0 d-flex justify-content-end" align="text-center">JUMLAH PENGENDALIAN</th>
                                                        
                                                        <th class="border-0"><?php echo "Rp" . number_format($dpa_pengendalianjuni->dpa_pengendalian,0,',','.'); ?></th>
                                                        <th class="border-0"><?php echo "Rp" . number_format($dpa_pengendalianjuni->realisasi_pengendalian,0,',','.'); ?></th>
                                                        <th class="border-0"><?php echo round($pdal,2); ?></th>
                                                        <th class="border-0"><?php echo "Rp" . number_format($dpa_pengendalianjuni->sisa_pengendalian,0,',','.'); ?></th>
                                                        <th class="border-0" align="text-center"></th>
                                                    </tr>
                                                </thead>

                                                <tbody>
                                                    <tr>
                                                      <?php foreach ($datinjuni as $datin): ?>
                                                        <td><?php echo $datin->kode1 ?></td>
                                                        <td><?php echo $datin->kode2 ?></td>
                                                        <td><?php echo $datin->kode3 ?></td>
                                                        <td><?php echo $datin->nama_kegiatan ?></td>
                                                        <td><?php echo  "Rp" . number_format($datin->dpa_perubahan,0,',','.'); ?></td>
                                                        <td><?php echo  "Rp" . number_format($datin->realisasi,0,',','.'); ?></td>
                                                        <td><?php echo $datin->persentase ?></td>
                                                        <td><?php echo  "Rp" . number_format($datin->sisa_anggaran,0,',','.'); ?></td>
                                                        <td><?php echo $datin->keterangan ?></td>
                                                    </tr>
                                                    <?php endforeach; ?>   
                                                </tbody>

                                                <?php $pdatin = ($dpa_datinjuni->realisasi_datin/$dpa_datinjuni->dpa_datin)*100; ?>
                                                <thead class="bg-light">
                                                    <tr class="border-0">
                                                        <th class="border-0" align="text-center"></th>
                                                        <th  class="border-0" align="text-center"></th>
                                                        <th  class="border-0" align="text-center"></th>
                                                        <th  class="border-0 d-flex justify-content-end" align="text-center">JUMLAH DATIN</th>
                                                        
                                                        <th class="border-0"><?php echo "Rp" . number_format($dpa_datinjuni->dpa_datin,0,',','.'); ?></th>
                                                        <th class="border-0"><?php echo "Rp" . number_format($dpa_datinjuni->realisasi_datin,0,',','.'); ?></th>
                                                        <th class="border-0"><?php echo round($pdatin,2); ?></th>
                                                        <th class="border-0"><?php echo "Rp" . number_format($dpa_datinjuni->sisa_datin,0,',','.'); ?></th>
                                                        <th class="border-0" align="text-center"></th>
                                                    </tr>
                                                </thead>

                                                <?php $ptotal = ($realisasi_gaji+$dpa_seluruhjuni->real_total)/($jumlah_gaji+$dpa_seluruhjuni->dpa_total)*100; ?>
                                                <tbody>
                                                    <tr>                                                 
                                                        <th colspan="4">JUMLAH TOTAL</th>
                                                        
                                                        <th><?php echo  "Rp" . number_format($jumlah_gaji+$dpa_seluruhjuni->dpa_total,0,',','.'); ?></th>
                                                        <th><?php echo  "Rp" . number_format($realisasi_gaji+$dpa_seluruhjuni->real_total,0,',','.'); ?></th>
                                                        <th><?php echo round($ptotal,2); ?></td>
                                                        <th><?php echo  "Rp" . number_format(($jumlah_gaji-$realisasi_gaji)+$dpa_seluruhjuni->sisa_total,0,',','.'); ?></th>
                                                        <th></th>
                                                    </tr>
                                                </tbody>

                                            
                                            </table>
                                                 
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        
                            <?php $pseluruh = 100-($psek + $pbang + $pesda + $pdal + $pdatin); ?>
                           
                                

            
    <script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>

<figure class="highcharts-figure">
    <div id="container"></div>
</figure>

<script type="text/javascript">
    // Build the chart
Highcharts.chart('container', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: 'REALISASI APBD TAHUN ANGGARAN 2021 DPMPTSP Provinsi Jawa Barat'
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
    },
    accessibility: {
        point: {
            valueSuffix: '%'
        }
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: false
            },
            showInLegend: true
        }
    },
    series: [{
        name: '',
        colorByPoint: true,
        data: [{
            name: 'Belum Terserap',
            y: <?php echo round($pseluruh,2); ?>,
            sliced: true,
            selected: true
        }, {
            name: 'Sekretariat',
            y: <?php echo round($psek,2); ?>
        }, {
            name: 'Bangprom',
            y: <?php echo round($pbang,2); ?>
        }, {
            name: 'ESDA/INSOS',
            y: <?php echo round($pesda,2); ?>
        }, {
            name: 'Pengendalian',
            y: <?php echo round($pdal,2); ?>
        }, {
            name: 'Datin',
            y: <?php echo round($pdatin,2); ?>
        }]
    }]
});
</script>

    <!-- <script>
window.onload = function () {

var chart = new CanvasJS.Chart("chartContainer", {
    exportEnabled: true,
    animationEnabled: true,
    title:{
        text: "REALISASI APBD TAHUN ANGGARAN 2021 DPMPTSP Provinsi Jawa Barat"

    },
    legend:{
        cursor: "pointer",
        itemclick: explodePie
    },
    data: [{
        type: "pie",
        showInLegend: true,
        toolTipContent: "{name}: <strong>{y}%</strong>",
        indexLabel: "{name} - {y}%",
        dataPoints: [
            { y: <?php echo round($pseluruh,2); ?>, 
                name: "Belum Terserap", exploded: true },
            { y: <?php echo round($psek,2); ?>, 
                name: "Sekretariat" },
            { y:<?php echo round($pbang,2); ?>, 
                name: "Bangprom" },
            { y: <?php echo round($pesda,2); ?>, 
                name: "ESDA/INSOS" },
            { y: <?php echo round($pdal,2); ?>, 
                name: "Pengendalian" },
            { y: <?php echo round($pdatin,2); ?>, 
                name: "Datin" }
        ]
        // dataPoints: [
        //     <?php echo json_encode($psek, JSON_NUMERIC_CHECK); ?>
        // ]

    }]
});
chart.render();
}

function explodePie (e) {
    if(typeof (e.dataSeries.dataPoints[e.dataPointIndex].exploded) === "undefined" || !e.dataSeries.dataPoints[e.dataPointIndex].exploded) {
        e.dataSeries.dataPoints[e.dataPointIndex].exploded = true;
    } else {
        e.dataSeries.dataPoints[e.dataPointIndex].exploded = false;
    }
    e.chart.render();

}
</script> -->


<div id="chartContainer" style="height: 300px; width: 100%;"></div>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
    <?php $this->load->view("realisasi_dpa/partial/js.php") ?>
    <script src="<?php echo base_url().'realisasi_dpa/assets/vendor/charts/charts-bundle/chartjs.js'?>"></script>
    <script src="<?php echo base_url().'realisasi_dpa/assets/vendor/charts/morris-bundle/chartjs.js'?>"></script>
</body>
 
</html>
