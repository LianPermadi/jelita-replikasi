<!doctype html>
<html lang="en">
 
<head>
    <?php $this->load->view("v_jdih/partial/head_table.php") ?>
</head>

<body>
	<meta name="description" content="JARINGAN DOKUMENTASI DAN INFORMASI HUKUM (JDIH). Dinas Penanaman Modal dan Pelayanan Terpadu Satu Pintu Provinsi Jawa Barat " itemprop="description">
    <!-- ============================================================== -->
    <!-- main wrapper -->
    <!-- ============================================================== -->
    <div class="dashboard-main-wrapper">
        <!-- ============================================================== -->
        <!-- navbar -->
        <!-- ============================================================== -->
         <?php $this->load->view("v_jdih/partial/navbar.php") ?>
        <!-- ============================================================== -->
        <!-- end navbar -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- left sidebar -->
        <!-- ============================================================== -->
     <?php $this->load->view("v_jdih/partial/sidebar.php") ?>
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
                            <div class="page-header">
                                <h1 class="pageheader-title"  align="center">JARINGAN DOKUMENTASI DAN INFORMASI HUKUM (JDIH)</h1>
                                <h3 class="pageheader-title"  align="center">Dinas Penanaman Modal dan Pelayanan Terpadu Satu Pintu Provinsi Jawa Barat</h3>
                           
                                <p class="pageheader-text">-</p>
                                
                            </div>
                        </div>
                    </div>
                    <!-- ============================================================== -->
                    <!-- end pageheader  -->
                    <!-- ============================================================== -->
                    
                    <div class="row">
                    <!-- ============================================================== -->
                    <!-- data table  -->
                    <!-- ============================================================== -->
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="card">
                           <!--  <div class="card-header">
                                <h5 class="mb-0">Data Tables - Print, Excel, CSV, PDF Buttons</h5>
                                <p>This example shows DataTables and the Buttons extension being used with the Bootstrap 4 framework providing the styling.</p>
                            </div> -->
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="example" class="table table-striped table-bordered second" style="width:100%">
                                        <thead>
                                            <tr align="center">
                                                
                                               <!--  <th width="15%">Hukum</th>
                                                <th width="24%">Tentang</th>
                                                <th width="14%">Status</th> -->
                                                 <th>Hukum <br>Tentang <br>Status</th>
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php 
                                        $i = 1;
                                        foreach ($jdih as $row) { 
                                        ?>
                                        <tr align="center">
                                          
                                            <td><b><h4><?php 
                                            			  if($row->kategori != 4){
                                               echo $this->jdih_model->get_kategori($row->kategori)." Nomor ".$row->nomor. " Tahun ".$row->tahun; 
                                               }
                                               else {
                                                 echo "Peraturan ".$this->jdih_model->get_institusi($row->institusi)." Nomor ".$row->nomor. " Tahun ".$row->tahun; 
                                               } 
                                              ?></b></h4>
                                           <?php echo $row->tentang; ?> <br>
                                            <?php 

                                            if($row->status == 0){  ?>
                                                <a href="#" class="btn btn-rounded btn-success" title='Klik untuk melihat detail'>ACTIVE</a> 
                                           <?php  }
                                            else{  ?>
                                                 <a href="#" class="btn btn-rounded btn-danger">INACTIVE</a>
                                             <?php }

                                            ?>

                                            <a href="<?php echo site_url('jdih/download').'/'.$row->id; ?>" class="btn btn-rounded btn-primary">Download</a>

                                            <a href="<?php echo site_url('jdih/downloadabstrak').'/'.$row->id; ?>" class="btn btn-rounded btn-secondary">Abstrak</a>

                                             <a href="<?php echo site_url('jdih/detail_jdih').'/'.$row->id; ?>" class="btn btn-rounded btn-brand">Detail</a>
                                            
                                                                                      
                                        </tr>
                                           
                                          <?php $i++; } ?>
                                        </tbody>
                                        <tfoot>
                                            <tr  align="center">
                                          <!--    
                                                <th>Hukum</th>
                                                <th>Tentang</th>
                                                <th>Status</th> -->
                                                <th>Hukum <br>Tentang <br>Status</th>
                                                
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- ============================================================== -->
                    <!-- end data table  -->
                    <!-- ============================================================== -->

            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
             <?php $this->load->view("v_jdih/partial/footer.php") ?>
            <!-- ============================================================== -->
            <!-- end footer -->
            <!-- ============================================================== -->

                </div>

          </div>
            </div>
              </div>
    </div>
          </h3></div></div>       
</body>
 <script src="<?php echo base_url('assets/vendor/jquery/jquery-3.3.1.min.js') ?>"></script>
    <script src="<?php echo base_url('assets/vendor/bootstrap/js/bootstrap.bundle.js') ?>"></script>
    <script src="<?php echo base_url('assets/vendor/slimscroll/jquery.slimscroll.js') ?>"></script>
    <script src="<?php echo base_url('assets/vendor/multi-select/js/jquery.multi-select.js') ?>"></script>
    <script src="<?php echo base_url('assets/libs/js/main-js.js') ?>"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url('assets/vendor/datatables/js/dataTables.bootstrap4.min.js') ?>"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
    <script src="<?php echo base_url('assets/vendor/datatables/js/buttons.bootstrap4.min.js') ?>"></script>
    <script src="<?php echo base_url('assets/vendor/datatables/js/data-table.js') ?>"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.colVis.min.js"></script>
    <script src="https://cdn.datatables.net/rowgroup/1.0.4/js/dataTables.rowGroup.min.js"></script>
    <script src="https://cdn.datatables.net/select/1.2.7/js/dataTables.select.min.js"></script>
    <script src="https://cdn.datatables.net/fixedheader/3.1.5/js/dataTables.fixedHeader.min.js"></script>

    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/vendor/datatables/css/fixedHeader.bootstrap4.css') ?>">
</html>
