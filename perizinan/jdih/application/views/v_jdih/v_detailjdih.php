<!doctype html>
<html lang="en">

<head>
    <?php $this->load->view("v_jdih/partial/head.php");  
  
    foreach($detailjdih as $row){
        $id = $row->id;
        $tentang = $row->tentang;
        // $mencabut = $row->mencabut;
        $status = $row->status;
        $nomor = $row->nomor;
        $tahun = $row->tahun;
        $kategori = $row->kategori;
        $tgl_penetapan = $row->tgl_penetapan;
        $tgl_pengundangan = $row->tgl_pengundangan;
        $mencabut = $row ->mencabut;
        $mengubah = $row ->mengubah;
        $dirubah = $row ->dirubah;
        $dicabut = $row ->dicabut;

        //var_dump($_SERVER['DOCUMENT_ROOT']);die();
    }
   // echo  '<meta property="og:description" content="'.$tentang.'"/>';


     ?>
         <meta name="description" content="  <?php
                                                if($row->kategori != 4){
                                               echo $this->jdih_model->get_kategori($row->kategori)." Nomor ".$row->nomor. " Tahun ".$row->tahun; 
                                               }
                                               else {
                                                 echo "Peraturan ".$this->jdih_model->get_institusi($row->institusi)." Nomor ".$row->nomor. " Tahun ".$row->tahun; 
                                               } 

                                               ?>" itemprop="description">

</head>
<!-- <title> <?php echo $this->jdih_model->get_kategori($row->kategori)." Nomor ".$row->nomor. " Tahun ".$row->tahun;  ?></title> -->

<body>
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
                        <!-- accrodions style one -->
                        <!-- ============================================================== -->
                        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                            <!-- <div class="section-block">
                                <h5 class="section-title"><?php echo $this->jdih_model->get_kategori($row->kategori)." Nomor ".$row->nomor. " Tahun ".$row->tahun;  ?></h5>
                                <p>Takes the basic nav from above and adds the .nav-tabs class to generate a tabbed interface..</p>
                            </div> -->

                            <div class="accrodion-regular">
                                <div id="accordion">
                                    <div class="card">
                                        <div class="card-header" id="headingOne">
                                            <h3 class="mb-0">                                       
                                              

                                              <?php
                                                if($row->kategori != 4){
                                               echo $this->jdih_model->get_kategori($row->kategori)." Nomor ".$row->nomor. " Tahun ".$row->tahun; 
                                               }
                                               else {
                                                 echo "Peraturan ".$this->jdih_model->get_institusi($row->institusi)." Nomor ".$row->nomor. " Tahun ".$row->tahun; 
                                               } 

                                               ?>
                                               
                                              </h3>
                                        </div>
                                        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                                            <div class="card-body">
                                                <p class="lead">Tentang : <?php echo $tentang; ?>.</p>
                                                <p> Status : 
                                            <?php 

                                            if($row->status == 0){  ?>
                                                <a href="#" class="btn btn-rounded btn-success" title='Klik untuk melihat detail'>ACTIVE</a> 
                                           <?php  }
                                            else{  ?>
                                                 <a href="#" class="btn btn-rounded btn-danger">INACTIVE</a>
                                             <?php }

                                            ?>
                                                </p> <p>Nomor : <?php  echo $nomor; ?></p> <p>Tahun : <?php echo $tahun; ?></p> <p> Ditetapkan Tanggal : <?php echo $this->jdih_model->tgl_indo($tgl_penetapan); ?></p>
                                                <p>Diundangkan Tanggal : <?php  if($tgl_pengundangan==NULL){  echo $this->jdih_model->tgl_indo($tgl_pengundangan); } else{ echo "-";} ?> </p>
                                                  <a href="<?php echo site_url('jdih/download').'/'.$row->id; ?>" class="btn btn-rounded btn-primary">Download</a>
                                                  <a href="<?php echo site_url('jdih/downloadabstrak').'/'.$row->id; ?>" class="btn btn-rounded btn-secondary">Abstrak</a>
                                            
                                                <!-- <p><?php echo nl2br($mengubah); ?></p> -->
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header" id="headingTwo">
                                            <h5 class="mb-0">
                                               
                                               Status
                                               </h5>
                                        </div>
                                        <div id="collapseTwo"  class="collapse show"  aria-labelledby="headingTwo" data-parent="#accordion">
                                            <div class="card-body">
                                                <?php if (!empty($mencabut)) {
                                                    echo "<h4><b>MENCABUT</b></h4>".nl2br($mencabut)."<br>"; 
                                                    }
                                                    if (!empty($mengubah)) {
                                                    echo "<br><h4><b>MENGUBAH</b></h4>".nl2br($mengubah)."<br>"; 
                                                }
                                                  if (!empty($dirubah)) {
                                                    echo "<br><h4><b>DIUBAH</b></h4>".nl2br($dirubah)."<br>"; 
                                                }
                                                if (!empty($dicabut)) {
                                                    echo "<br><h4><b>DICABUT</b></h4>".nl2br($dicabut)."<br>"; 
                                                }

                                                    ?>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- 
                                    <div class="card">
                                        <div class="card-header" id="headingThree">
                                            <h5 class="mb-0">
                            <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                 Accordion Heading Title Here
                                             </button>
                                                       </h5>
                                        </div>
                                        <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                                            <div class="card-body">
                                                Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-tabhetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                                            </div>
                                        </div>
                                    </div> -->


                                </div>
                            </div>
                        </div>
                        <!-- ============================================================== -->
                        <!-- end accrodions style one -->
                        <!-- ============================================================== -->
                        <!-- ============================================================== -->
                        <!-- accrodions style two -->
                        <!-- ============================================================== -->
                        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                            <!-- <div class="section-block">
                                <h5 class="section-title">Outline Accordions</h5>
                                <p>Takes the basic nav from above and adds the .nav-tabs class to generate a tabbed interface..</p>
                            </div> -->
                            <div class="accrodion-outline">
                                <div id="accordion2">
                                    <div class="card">
                                        <div class="card-header" id="headingFour">
                                            <h5 class="mb-0">
                                               <button class="btn btn-link" data-toggle="collapse" data-target="#collapseFour" aria-expanded="true" aria-controls="collapseFour">
                                               VIEW HUKUM
                                               </button>
                                              </h5>
                                        </div>
                                        <div id="collapseFour" class="collapse show" aria-labelledby="headingFour" data-parent="#accordion2">
                                            <div class="card-body">
                                                <!-- <iframe src='https://docs.google.com/gview?url=https://dpmptsp.jabarprov.go.id/jdih/assets/pdf_hukum/HUKUM_<?php echo $id;?>.pdf&embedded=true' width='100%' height='588px'></iframe>
                                                 -->
                                                 <iframe src='https://docs.google.com/gview?url=https://dpmptsp.jabarprov.go.id/jelita/backoffice/assets/jdih/hukum/HUKUM_<?php echo $id;?>.pdf&embedded=true' width='100%' height='458px'></iframe>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header" id="headingFive">
                                            <h5 class="mb-0">
                                               <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                              VIEW  ABSTRAK
                                             </button>       </h5>
                                        </div>
                                        <div id="collapseFive" class="collapse" aria-labelledby="headingFive" data-parent="#accordion2">
                                            <div class="card-body">
                                                <iframe src='https://docs.google.com/gview?url=https://dpmptsp.jabarprov.go.id/jelita/backoffice/assets/jdih/abstrak/ABSTRAK_<?php echo $id;?>.pdf&embedded=true' width='100%' height='458px'></iframe>
                                            </div>
                                        </div>
                                    </div>
                                  <!--   <div class="card">
                                        <div class="card-header" id="headingSix">
                                            <h5 class="mb-0">
                            <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                                 Accordion Heading Title Here
                                             </button>
                                                       </h5>
                                        </div>
                                        <div id="collapseSix" class="collapse" aria-labelledby="headingSix" data-parent="#accordion2">
                                            <div class="card-body">
                                                Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-tabhetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                                            </div>
                                        </div>
                                    </div> -->

                                </div>
                            </div>
                        </div>
                        <!-- ============================================================== -->
                        <!-- end accrodions style two -->
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
