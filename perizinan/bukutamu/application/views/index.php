<?php $this->load->view("partial/head.php") ?>

 <?php if ($this->session->flashdata('success')){ ?>
                    

                <div class="alert alert-success" role="alert" style="text-align:center;">
                    <?php echo $this->session->flashdata('success'); ?>
                </div>

                <?php } ?>

<form class="splash-container" action="<?php echo base_url('bukutamu/add') ?>" method="post"
                            enctype="multipart/form-data" >
                    <div class="text-box-cont">
                        <div class="row form">
                                <div class="col-lg-6">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1"><i class="fas fa-user"></i></span>
                                    </div>
                                    <input type="text" class="form-control" name="nama" placeholder="Nama Lengkap Tamu" required="required" aria-label="Nama Lengkap" aria-describedby="basic-addon1">
                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1"><i class="fas fa-address-card"></i></span>
                                    </div>
                                    <input type="number"  required="" class="form-control" name="nik" placeholder="Nomor Induk Kependudukan (NIK)" aria-label="Nama Lengkap" aria-describedby="basic-addon1">
                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1"><i class="fas fa-address-card"></i></span>
                                    </div>
                                    <input type="number"  required="" class="form-control" name="nib" placeholder="Nomor Induk Berusaha (NIB)" aria-label="Nama Lengkap" aria-describedby="basic-addon1">
                                </div>

                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"  id="basic-addon1"><i class="fas fa-at"></i></span>
                                    </div>
                                    <input type="email" class="form-control"   name="email"  required="required" placeholder="E-mail" aria-label="Email" aria-describedby="basic-addon1">
                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1"><i class="fas fa-phone"></i></span>
                                    </div>
                                    <input type="number" class="form-control" name="telepon" required="required" placeholder="Handphone" aria-label="Handphone" aria-describedby="basic-addon1">
                                </div>
                                 <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"  id="basic-addon1"><i class="fas fa-comment"></i></span>
                                    </div>
                                    <textarea type="text" class="form-control" required="required" name="keperluan"  placeholder="Keperluan / Permasalahan" aria-label="Keperluan" aria-describedby="basic-addon1"></textarea>
                                </div>
                               <!--  <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1"><i class="fas fa-users"></i></span>
                                    </div>
                                    <select class="custom-select" name="nama_petugas"  required="required" id="inputGroupSelect01">
                                        <option value="" selected disabled>Nama Petugas MPP/GPP</option>
                                        <option value="Bimafaza">Bimafaza</option>
                                        <option value="Azy Rohmat">Azy Rohmat</option>
                                        <option value="giri furqoni">giri furqoni</option>
                                          <option value="Deni Heryana">Deni Heryana</option>
                                          <option value="Ikbal Arianto">Ikbal Arianto</option>
                                          <option value="Donny">Donny</option>
                                          <option value="Komala Dewi">Komala Dewi</option>
                                          <option value="Lukman Nurhalim">Lukman Nurhalim</option>
                                          <option value="Arif Rahman Hidayat">Arif Rahman Hidayat</option>                                          
                                          <option value="Galih">Galih</option>
                                          <option value="Eva Nurfitriani">Eva Nurfitriani</option>
                                          <option value="Andi Nurochman">Andi Nurochman</option>
                                          <option value="Wilman Nailufar">Wilman Nailufar</option>
                                          <option value="siti fadillah  amelia">siti fadillah  amelia</option>
                                          <option value="Wawan">Wawan</option>
                                          <option value="Rendy ">Rendy </option>
                                          <option value="Robby Nugraha">Robby Nugraha</option>
                                          <option value="Lukman Abdullah">Lukman Abdullah</option>
                                          <option value="Shuci Shasfika">Shuci Shasfika</option>
                                          <option value="Raden Robi">Raden Robi</option>
                                          <option value="Wawan">Wawan</option>
                                          <option value="Wawan">Wawan</option>
                                          <option value="Wawan">Wawan</option>
                                          <option value="Wawan">Wawan</option>
                                          <option value="Wawan">Wawan</option>
                                          <option value="Wawan">Wawan</option>
                                          <option value="Wawan">Wawan</option>
                                          <option value="Wawan">Wawan</option>
                                          <option value="Wawan">Wawan</option>

                                    </select>
                                </div> -->
                            </div>
                            
                            <div class="col-lg-6">
                            	<div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1"><i class="fas fa-users"></i></span>
                                    </div>
                                    <select class="custom-select" name="tujuan"  required="required" id="inputGroupSelect01">
                                        <option value="" selected disabled>Tujuan Kedatangan</option>
                                        <option value="1">Informasi</option>
                                           <option value="2">OSS</option>
                                          <option value="3">LKPM</option>
                                          <option value="4">Pengaduan</option>
                                           <option value="5">Even Gempita</option>
                                        
                                            </select>
                                </div>
                               <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1"><i class="fas fa-users"></i></span>
                                    </div>
                                    <select class="custom-select" name="layanan"  required="required" id="inputGroupSelect01">
                                        <option value="" selected disabled>Pilih Layanan:</option>
                                        <option value="Konsultasi dan Pelayanan Nomor Induk Berusaha(NIB)">Konsultasi dan Pelayanan Nomor Induk Berusaha(NIB)</option>
                                           <option value="Konsultasi dan Pelayanan Standar Nasional Indonesia(SNI)">Konsultasi dan Pelayanan Standar Nasional Indonesia(SNI)</option>
                                          <option value="Konsultasi dan Pelayanan Sertifikasi Halal">Konsultasi dan Pelayanan Sertifikasi Halal</option>
                                          <option value="Konsultasi dan Pelayanan Hak Kekayaan Intelektual(HaKi)">Konsultasi dan Pelayanan Hak Kekayaan Intelektual(HaKi)</option>
                                          <option value="Konsultasi dan Pelayanan Badan Pengawas Obat dan Makanan(BPOM)">Konsultasi dan Pelayanan Badan Pengawas Obat dan Makanan(BPOM)</option>
                                          <option value="Konsultasi dan Pelayanan Bank Pembangunan Daerah Jawa Barat dan Banten(BJB)">Konsultasi dan Pelayanan Bank Pembangunan Daerah Jawa Barat dan Banten(BJB)</option>
                                           <option value="Konsultasi dan Pelayanan e-Katalog">Konsultasi dan Pelayanan e-Katalog</option>
                                            </select>
                                </div>
                                 <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1"><i class="fas fa-users"></i></span>
                                    </div>
                                    <select class="custom-select" name="namampp"  required="required" id="inputGroupSelect01">
                                        <option value="" selected disabled>Lokasi Tamu</option>
                                     <?php  $sektor = ""; foreach ($namampp as $rowlist) { ?>                                    
                                      <option value="<?php echo $rowlist->id; ?>" <?php echo ($sektor == $rowlist->id ? "selected" : ""); ?>><?php echo $rowlist->n_kabupaten; ?></option>
                                      <?php } ?>
                                    </select>
                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1"><i class="fas fa-users"></i></span>
                                    </div>
                                    <select class="custom-select" name="esselon"  required="required" id="inputGroupSelect01">
                                        <option value="" selected disabled>Jabatan</option>
                                        <option value="Perusahaan">Perusahaan</option>
                                           <option value="Perorangan">Perorangan</option>
                                          <option value="Non Esselon">Non Esselon</option>
                                          <option value="Esselon 4">Esselon 4</option>
                                          <option value="Esselon 3">Esselon 3</option>
                                          <option value="Esselon 2">Esselon 2</option>
                                            </select>
                                </div>
                                <!--  <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1"><i class="fas fa-briefcase"></i></span>
                                    </div>
                                    <input type="text" class="form-control" required="required" name="bidang" placeholder="Bidang usaha sesuai sektor" aria-label="Bidang" aria-describedby="basic-addon1">
                                </div> -->
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1"><i class="fas fa-users"></i></span>
                                    </div>
                                    <select class="custom-select" name="list2"  required="required" id="inputGroupSelect01">
                                        <option value="" selected disabled>Nama Bidang/Sektor Izin</option>
                                     <?php  $sektor = ""; foreach ($list2 as $rowlist) { ?>                                    
                                      <option value="<?php echo $rowlist->id; ?>" <?php echo ($sektor == $rowlist->id ? "selected" : ""); ?>><?php echo $rowlist->n_sektor; ?></option>
                                      <?php }  ?>
                                    </select>
                                </div>

                               

                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1"><i class="fas fa-briefcase"></i></span>
                                    </div>
                                    <input type="text" class="form-control" required="required" name="jenis_izin" placeholder="Jenis Izin Usaha" aria-label="jenis_izin" aria-describedby="basic-addon1">
                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1"><i class="fas fa-building"></i></span>
                                    </div>
                                    <input type="text" class="form-control" name="instansi" required="required"  placeholder="Instansi / Perusahaan" aria-label="Instansi" aria-describedby="basic-addon1">
                                </div>
                                 <!--  <div class="col-lg">
                                      <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"  id="basic-addon1"><i class="fas fa-comment"></i></span>
                                    </div>
                                    <textarea type="text" class="form-control"  name="solusi"  placeholder="Solusi" aria-label="Keperluan" aria-describedby="basic-addon1"></textarea>
                                </div>
                              </div> -->

                            </div>
                          
                        </div>
                                <div class="input-group center" required>
                                    <div required="required" class="g-recaptcha" data-sitekey="6LcPEK0mAAAAANk0sSXsrrAxKPbgHBWtrMI8eMN4"></div>
                                </div> 
                                <div class="input-group center">
                                    <button class="btn btn-primary btn-round"  value="Save">SIMPAN</button>
                                </div> 
                                <!-- <div class="row">
                                    <p class="forget-p">Don't have an account? <span>Sign Up Now</span></p>
                                </div> -->
                                 <div class="row">
                                    <p class="small-info">Kunjungi Kami</p>
                                </div>
                                <div class="row medsos">
                                <ul>
                                    <a href="https://www.youtube.com/c/HumasDPMPTSPProvinsiJawaBarat"><i class="fab fa-youtube"></i></a>
                                    <a href="https://www.instagram.com/dpmptsp.jabar/"><i class="fab fa-instagram"></i></a>
                                    <a href="https://www.facebook.com/dpmptsp.jabar"><i class="fab fa-facebook-f"></i></a>
                                </ul>
                                </div>   
                    </div>
                  </form>              
                            
  <script src='https://www.google.com/recaptcha/api.js'></script>                            
                            
<?php $this->load->view("partial/foot.php") ?>