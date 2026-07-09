<?php
$this->load->view("partial/head.php");
if($this->session->flashdata('success')){
  ?>
  <div class="alert alert-success" role="alert" style="text-align:center;">
    <?php echo $this->session->flashdata('success'); ?>
  </div>
  <?php
}

if($this->session->flashdata('error')){
  ?>
  <div class="alert alert-danger" role="alert" style="text-align:center;">
    <?php echo $this->session->flashdata('error'); ?>
  </div>
  <?php
}
?>

<form class="splash-container" action="<?php echo base_url('absensi/save') ?>" method="post" enctype="multipart/form-data" >
  <div class="text-box-cont">
    <div class="row form">
      <div class="col-lg-12">
        <?php if($kegiatan->status_pembatalan == 0){ ?>
        <div class="input-group mb-3">
          <div class="input-group-prepend">
            <span class="input-group-text" id="basic-addon1"><i class="fas fa-book"></i></span>
          </div>
          <input type="hidden" name="idkegiatan" value="<?php echo $kegiatan->id; ?>">
          <input type="text" class="form-control" name="kegiatan" placeholder="Kegiatan" value="<?php echo $kegiatan->acara; ?>" aria-label="Kegiatan" aria-describedby="basic-addon1" readonly>
        </div>
    
        <div class="input-group mb-3">
          <div class="input-group-prepend">
            <span class="input-group-text" id="basic-addon1"><i class="fas fa-user"></i></span>
          </div>
          <input type="text" class="form-control" name="nama" placeholder="Nama Lengkap" required="required" aria-label="Nama Lengkap" aria-describedby="basic-addon1">
        </div>
    
        <div class="input-group mb-3">
          <div class="input-group-prepend">
            &nbsp;
          </div>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="gender" id="flexRadioDefault1" value="0" checked="checked" required="required">
            <label class="form-check-label" for="flexRadioDefault1">Pria</label>
          </div>
          <label class="form-check-label">&nbsp;</label>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="gender" id="flexRadioDefault2" value="1">
            <label class="form-check-label" for="flexRadioDefault2">Wanita</label>
          </div>
        </div>
    
        <div class="input-group mb-3">
          <div class="input-group-prepend">
            <span class="input-group-text" id="basic-addon1"><i class="fas fa-landmark"></i></span>
          </div>
          <input type="text" class="form-control" name="instansi" placeholder="Instansi" required="required" aria-label="Instansi" aria-describedby="basic-addon1">
        </div>
    
        <div class="input-group mb-3">
          <div class="input-group-prepend">
            <span class="input-group-text" id="basic-addon1"><i class="fas fa-landmark"></i></span>
          </div>
          <input type="text" class="form-control" name="jabatan" placeholder="Jabatan" required="required" aria-label="Jabatan" aria-describedby="basic-addon1">
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
            <option value="" selected disabled>Asal Tamu</option>
            <?php
            $sektor = "";
            foreach ($namampp as $rowlist) {
              ?>
              <option value="<?php echo $rowlist->n_kabupaten; ?>"><?php echo $rowlist->n_kabupaten; ?></option>
              <?php
            }
            ?>
            <option value="Lainnya">LAINNYA</option>
          </select>
        </div>
        
        <div class="input-group mb3" id="lok">
          <div class="input-group-prepend">
            <span class="input-group-text" id="basic-addon1"><i class="fas fa-users"></i></span>
          </div>
          <input type="text" class="form-control" name="kablain" placeholder="Lokasi" aria-label="Lokasi" aria-describedby="basic-addon1" id="kablain">
        </div>
        <center>
          <div class="col-xs-4 col-xs-offset-4">
            <p>Tanda Tangan</p>
            <center><div id="sig" style="clear: both;"></div></center>
            <p style="clear: both;">
              <button id="clear" class="btn btn-secondary" type="button">Bersihkan</button>
              <textarea id="signature64" name="signed" style="display: none"></textarea>
            </p>
          </div>
        </center>
        </div>
    </div>
    
    <div class="input-group center" required>
      <div required="required" class="g-recaptcha" data-sitekey="6LcPEK0mAAAAANk0sSXsrrAxKPbgHBWtrMI8eMN4"></div>
    </div>
    
    <div class="input-group center">
      <button class="btn btn-primary btn-round"  value="Save">SIMPAN</button>
    </div>
        <?php }else{ ?>
        <div class="input-group mb-3">
          <div class="input-group-prepend">
            <span class="input-group-text" id="basic-addon1"><i class="fas fa-phone"></i></span>
          </div>
          <center><h1>Absensi sudah di bekukan (Konfirmasi kepada pemboking ruangan)</h1></center>
        </div>
          
          <?php } ?>
    
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
<?php
$this->load->view("partial/foot.php");
?>