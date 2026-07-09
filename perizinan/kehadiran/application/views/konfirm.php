<?php $this->load->view("partial/head.php") ?>

<?php if ($this->session->flashdata('success')){ ?>            
    <div class="alert alert-success" role="alert" style="text-align:center;">
        <?php echo $this->session->flashdata('success'); ?>
    </div>
<?php } ?>

<?php if ($this->session->flashdata('error')){ ?>            
    <div class="alert alert-danger" role="alert" style="text-align:center;">
        <?php echo $this->session->flashdata('error'); ?>
    </div>
<?php } ?>

<form class="splash-container" action="<?php echo base_url('konfirmasi/save') ?>" method="post" enctype="multipart/form-data" >
    <div class="text-box-cont">
        <div class="row form">
            <div class="col-lg-12">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1"><i class="fas fa-user"></i></span>
                    </div>
                    <input type="text" class="form-control" name="nama" placeholder="Nama Lengkap" required="required" aria-label="Nama Lengkap" aria-describedby="basic-addon1">
                </div>

                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1"><i class="fas fa-landmark"></i></span>
                    </div>
                    <input type="text" class="form-control" name="instansi" placeholder="Instansi" required="required" aria-label="Instansi" aria-describedby="basic-addon1">
                </div>

                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"  id="basic-addon1"><i class="fas fa-at"></i></span>
                    </div>
                    <input type="email" class="form-control" name="email"  required="required" placeholder="E-mail" aria-label="Email" aria-describedby="basic-addon1">
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1"><i class="fas fa-phone"></i></span>
                    </div>
                    <input type="number" class="form-control" name="telepon" required="required" placeholder="Handphone" aria-label="Handphone" aria-describedby="basic-addon1">
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1"><i class="fas fa-users"></i></span>
                    </div>
                    <select class="custom-select" name="namakab" required="required" id="inputGroupSelect01">
                        <option value="" selected disabled>Lokasi Tamu</option>
                      <?php  $sektor = ""; foreach ($namampp as $rowlist) { ?>
                        <option value="<?php echo $rowlist->n_kabupaten; ?>"><?php echo $rowlist->n_kabupaten; ?></option>
                        <?php } ?>
                        <option value="Lainnya">LAINNYA</option>
                    </select>
                </div>
                <div class="input-group mb3" id="lok">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1"><i class="fas fa-users"></i></span>
                    </div>
                    <input type="text" class="form-control" name="kablain" required="required" placeholder="Lokasi" aria-label="Lokasi" aria-describedby="basic-addon1" id="kablain">
                </div>
            </div>
          
        </div>
                <div class="input-group center" required>
                    <div required="required" class="g-recaptcha" data-sitekey="6LdIHikeAAAAAEPuJ66GNSHB_XlIHqMC6zS2Snvs"></div>
                </div> 
                <div class="input-group center">
                    <button class="btn btn-primary btn-round"  value="Save">SIMPAN</button>
                </div> 
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