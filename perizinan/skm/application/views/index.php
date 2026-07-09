<?php $this->load->view("partial/head.php") ?>

<!-- Script untuk SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php if ($this->session->flashdata('success')): ?>
    <script type="text/javascript">
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: '<?php echo $this->session->flashdata('success'); ?>',
            showConfirmButton: true,
            confirmButtonText: 'Lanjutkan',
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "https://dpmptsp.jabarprov.go.id/Survey/Pengisian_Survey/Form_pengisian_survey";
            }
        });
    </script>
<?php endif; ?>
<?php if ($this->session->flashdata('berhasil')): ?>
    <script type="text/javascript">
        Swal.fire({
            icon: 'success',
            title: 'Survey berhasil disimpan!',
            text: '<?php echo $this->session->flashdata('success'); ?>',
            showConfirmButton: true,
            confirmButtonText: 'Lanjutkan',
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "https://dpmptsp.jabarprov.go.id/Survey/Pengisian_Survey/Form_pengisian_survey";
            }
        });
    </script>
<?php endif; ?>

<?php if ($this->session->flashdata('error')): ?>
    <script type="text/javascript">
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: '<?php echo $this->session->flashdata('error'); ?>',
            showConfirmButton: true,
            timer: 3000
        });
    </script>
<?php endif; ?>

                <div class="small-logo">
                    <img src="<?php echo base_url('assets/images/logo-dinas.png') ?>"><p>PENGECEKAN NOMOR INDUK BERUSAHAN</p>
                </div>
                <form class="splash-container" action="<?php echo base_url('Pengisian_Survey/cek_nib') ?>" method="post"
                            enctype="multipart/form-data" >
                    <div class="text-box-cont">
                        <div class="row form">
                            
                                <div class="col-lg-12">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1"><i class="fas fa-user"></i></span>
                                    </div>
                                    <input type="text" class="form-control" name="nib" placeholder="Masukan Nomer Induk Berusaha Anda" required="required" aria-label="Nama Lengkap" aria-describedby="basic-addon1">
                                </div>
                               
                            </div>
                          
                        </div>
                                <div class="input-group center" required>
                                    <div required="required" class="g-recaptcha" data-sitekey="6LdIHikeAAAAAEPuJ66GNSHB_XlIHqMC6zS2Snvs"></div>
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