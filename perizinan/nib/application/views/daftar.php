<head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
    tampan{
        color:red;
    }
    .hidden {
            display: none;
        }
</style>
</head>
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

<form class="splash-container" action="<?php echo base_url('daftar/save') ?>" method="post" enctype="multipart/form-data" >
    <div class="text-box-cont">
        <div class="row form">
            <div class="col-lg-12">
            <div class="mb-3">
                <label for="email" class="form-label"><span data-en="Fullname"> Nama Lengkap </span><tampan>*</tampan></label>
                <input type="text" name="fullname" class="form-control" placeholder="" value="" required="required">
            </div>
            
            <div class="mb-3">
                <label for="nik" class="form-label">Nomor Induk Kependudukan (NIK) <tampan>*</tampan></label>
                <input type="number" value="" name="nik" class="form-control" id="custom-form-elm-1492" required="required" placeholder="">
            </div>

            <div class="mb-3">
                <label for="domisili" class="form-label">Email <tampan>*</tampan></label>
                <input type="email" name="email" class="form-control" placeholder="" value="" required="required">
            </div>

            <div class="mb-3">
                <label for="whatsapp" class="form-label">Nomor Handphone Aktif (WhatsApp) <tampan>*</tampan></label>
                <input type="number" name="telephone" class="form-control" placeholder="" value="" required="required">
            </div>

            <div class="mb-3">
                <label for="group_umk" class="form-label">Domisili <tampan>*</tampan></label>
                <select name="domisili" id="custom-form-elm-1493" class="uk-select" onchange="showHideTextbox(this)">

                    <option value="Kabupaten Bandung"> Kabupaten Bandung</option>
                    <option value="Kabupaten Bandung Barat"> Kabupaten Bandung Barat</option>
                    <option value="Kota Bandung"> Kota Bandung</option>
                    <option value="Kota Cimahi"> Kota Cimahi</option>
                    <option value="Other"> Other </option>
                </select>
            </div>

            <div class="mb-3 hidden" id="hiddenTextbox">
                <label for="jenis_usaha" class="form-label">Domisili [Lainnya] <tampan>*</tampan></label>
                <input type="text" value="" name="domisili" class="form-control" id="custom-form-elm-1507" placeholder="">
            </div>

            <div class="mb-3">
                <label class="form-label">Alamat sesuai KTP <tampan>*</tampan></label>
                <div class="form-check">
                    <textarea name="address" class="form-control" required="required"></textarea>
                </div>
            </div>

            <div class="mb-3">
                <label>Pilih Layanan:</label><br>
                <input type="checkbox" id="nib" name="layanan[]" value="Konsultasi dan Pelayanan Nomor Induk Berusaha(NIB)">
                <label for="nib">Konsultasi dan Pelayanan Nomor Induk Berusaha(NIB)</label><br>

                <input type="checkbox" id="sni" name="layanan[]" value="Konsultasi dan Pelayanan Standar Nasional Indonesia(SNI)">
                <label for="sni">Konsultasi dan Pelayanan Standar Nasional Indonesia(SNI)</label><br>

                <input type="checkbox" id="halal" name="layanan[]" value="Konsultasi dan Pelayanan Sertifikasi Halal">
                <label for="halal">Konsultasi dan Pelayanan Sertifikasi Halal</label><br>

                <input type="checkbox" id="haki" name="layanan[]" value="Konsultasi dan Pelayanan Hak Kekayaan Intelektual(HaKi)">
                <label for="haki">Konsultasi dan Pelayanan Hak Kekayaan Intelektual(HaKi)</label><br>

                <input type="checkbox" id="bpom" name="layanan[]" value="Konsultasi dan Pelayanan Badan Pengawas Obat dan Makanan(BPOM)">
                <label for="bpom">Konsultasi dan Pelayanan Badan Pengawas Obat dan Makanan(BPOM)</label><br>

                <input type="checkbox" id="bjb" name="layanan[]" value="Konsultasi dan Pelayanan Bank Pembangunan Daerah Jawa Barat dan Banten(BJB)">
                <label for="bjb">Konsultasi dan Pelayanan Bank Pembangunan Daerah Jawa Barat dan Banten(BJB)</label><br>

                <input type="checkbox" id="ekatalog" name="layanan[]" value="Konsultasi dan Pelayanan e-Katalog">
                <label for="ekatalog">Konsultasi dan Pelayanan e-Katalog</label>
            </div>

            <div class="mb-3">
                <label for="persetujuan" class="form-label">Data untuk pendaftaran NIB <tampan>*</tampan></label>
                <div class="form-check">
                    <input type="text" value="" name="nib" class="form-control" id="custom-form-elm-1499" required="required" placeholder="">
                </div>
            </div>    
            <div class="mb-3">
                <label for="persetujuan" class="form-label"> Jenis Usaha <tampan>*</tampan></label>
                <div class="form-check">
                    <select name="jenis_usaha" id="custom-form-elm-1497" class="uk-select" onchange="showHideTextbox1(this)">
                        <option value="Makanan &amp; Minuman"> Makanan &amp; Minuman</option>
                        <option value="Jasa"> Jasa</option>
                        <option value="Pakaian"> Pakaian</option>
                        <option value="Other"> Other </option>
                    </select>
                </div>
            </div>    
            <div class="mb-3 hidden" id="hiddenTextbox1">
                <label for="persetujuan" class="form-label">Jenis Usaha [Lainnya] <tampan>*</tampan></label>
                <div class="form-check">
                    <input type="text" value="" name="jenis_usaha" class="form-control" id="custom-form-elm-1499" placeholder="">
                </div>
            </div>
            <div class="mb-3">
                <label for="persetujuan" class="form-label"> Alamat Tempat Usaha <tampan>*</tampan></label>
                <div class="form-check">
                        <input type="text" value="" name="tempat_usaha" class="form-control" id="custom-form-elm-1498" required="required" placeholder="">
                </div>
            </div>        
            <div class="mb-3">
                <label for="persetujuan" class="form-label"> Modal Usaha <tampan>*</tampan></label>
                <div class="form-check">
                    <input type="number" value="" name="modal_usaha" class="form-control" id="custom-form-elm-1501" required="required" placeholder="">
                </div>
                <div class="uk-text-meta">
                        Modal Usaha Termasuk Alat-Alat Pendukung Usaha, Seperti Gerobak, Etalase, Mesin dll. (Jumlah
                        Keseluruhan Modal Contoh 10000000) </div>
            </div>     
            <div class="mb-3">
                <label for="persetujuan" class="form-label"> Luas Lahan Usaha <tampan>*</tampan></label>
                <div class="form-check">
                        <input type="number" value="" name="luas_lahan" class="form-control"
                                id="custom-form-elm-1502" required="required" placeholder="">
                <div class="uk-text-meta">
                        Dalam Satuan Meter Persegi (Contoh 12) </div>
                </div>
            </div>   
            <div class="mb-3">
                <label for="persetujuan" class="form-label"> Jumlah Tenaga Kerja <tampan>*</tampan></label>
                <div class="form-check">
                        <input type="number" value="" name="jumlah_tenaga" class="form-control"
                                id="custom-form-elm-1503" required="required" placeholder="">
                </div>
            </div>    
            <div class="mb-3">
                <label for="persetujuan" class="form-label"> Pendapatan/Penghasilan Per-Tahun <tampan>*</tampan></label>
                <div class="form-check">
                        <input type="number" value="" name="pendapatan" class="form-control"
                                id="custom-form-elm-1504" required="required" placeholder="">
                </div>
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
        <div class="uk-margin custom-elmidx98005">
                <label class="uk-form-label your-status">
                        Dengan ini <b>saya bersedia untuk mendaftarkan diri dan
                                hadir pada acara GEBYAR PELAYANAN TERPADU UMK 2023</b> yang
                        diselenggarakan oleh Dinas Penanaman Modal dan Pelayanan
                        Terpadu Satu Pintu Provinsi Jawa Barat di Gedung Youth Center
                        Sport Jabar Arcamanik pada tanggal 21 November 2023, jam 07:00 - 15:00 WIB
                </label>

                <div class="uk-form-controls">
                        <select name="present" class="uk-select" required="required">

                                <option value="Going">Ya, Setuju</option>


                                <option value="Not Going">Maaf, Tidak Setuju</option>

                        </select>
                </div>

                <div class="uk-text-meta">
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
  <script>
    function showHideTextbox(selectElement) {
        var hiddenTextbox = document.getElementById('hiddenTextbox');
        if (selectElement.value === 'Other') {
            hiddenTextbox.classList.remove('hidden');
        } else {
            hiddenTextbox.classList.add('hidden');
        }
    }
    function showHideTextbox1(selectElement) {
        var hiddenTextbox1 = document.getElementById('hiddenTextbox1');
        if (selectElement.value === 'Other') {
            hiddenTextbox1.classList.remove('hidden');
        } else {
            hiddenTextbox1.classList.add('hidden');
        }
    }
</script>                     
                            
<?php $this->load->view("partial/foot.php") ?>