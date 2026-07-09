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
                                    <input type="text" class="form-control" name="nama" placeholder="Nama Lengkap" required="required" aria-label="Nama Lengkap" aria-describedby="basic-addon1">
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
                                
                            </div>
                            
                            <div class="col-lg-6">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1"><i class="fas fa-map-marked"></i></span>
                                    </div>
                                    <select class="custom-select" name="lokasi" required="required" id="inputGroupSelect01">
                                        <option value="" selected disabled>Lokasi Tamu</option>
                                        <option value="JIH DPMPTSP Jabar">JIH DPMPTSP Jabar</option>
                                          <option value="Lobby DPMPTSP Jabar">Lobby DPMPTSP Jabar</option>
                                          <option value="MPP Kota Bandung">MPP Kota Bandung (Jl. Cianjur)</option>
                                          <option value="GPP Kota Bandung">GPP Kota Bandung (Sumarecon)</option>
                                          <option value="MPP Kab. Bandung">MPP Kab. Bandung (Soreang)</option>
                                          <option value="GPP Kota Cirebon">GPP Kota Cirebon</option>
                                          <option value="MPP Kota Tasikmalaya">MPP Kota Tasikmalaya</option>
                                          <option value="GPP Kab. Garut">GPP Kab. Garut</option>
                                          <option value="MPP Kab. Purwakarta">MPP Kab. Purwakarta</option>
                                          <option value="MPP Kab. Karawang">MPP Kab. Karawang</option>
                                          <option value="MPP Kota Bekasi">MPP Kota Bekasi</option>
                                          <option value="MPP Kab. Bekasi">MPP Kab. Bekasi</option>
                                          <option value="MPP Kota Bogor">MPP Kota Bogor</option>
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
                                 <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1"><i class="fas fa-briefcase"></i></span>
                                    </div>
                                    <input type="text" class="form-control" required="required" name="bidang" placeholder="Bidang usaha sesuai sektor" aria-label="Bidang" aria-describedby="basic-addon1">
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
                                
                            </div>
                            <div class="col-lg">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"  id="basic-addon1"><i class="fas fa-comment"></i></span>
                                    </div>
                                    <textarea type="text" class="form-control" required="required" name="keperluan"  placeholder="Keperluan / Permasalahan" aria-label="Keperluan" aria-describedby="basic-addon1"></textarea>
                                </div>
                            </div>
                        </div>
                                <div class="input-group center"  >
                                    <div class="g-recaptcha" data-sitekey="6LdIHikeAAAAAEPuJ66GNSHB_XlIHqMC6zS2Snvs"></div>
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