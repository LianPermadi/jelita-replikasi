<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Istana Djaya Plaza</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i">
    <link rel="stylesheet" href="assets/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/fonts/fontawesome5-overrides.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
</head>
<?php 
    $routees        = str_replace('index.php', '', $_SERVER['SCRIPT_NAME']);
    $root           = rtrim($_SERVER['DOCUMENT_ROOT'], '/'); // buang trailing slash
    $routees        = ltrim($routees, '/');              // buang leading slash
    $routees_portal = str_replace('backoffice/index.php', '', $_SERVER['SCRIPT_NAME']); 
    $master_url     = $_SERVER['REQUEST_SCHEME'] .'://'. $_SERVER['HTTP_HOST'];
    // var_dump($routees, $root,$routees_portal,$master_url);
?>
<div id="content">
    <div class="post">
        <div class="title">
          <?php echo $this->lib_date->view_title($page_name); ?>
        </div>

        <?php
        $alert = $this->session->flashdata("sukses");
        if (!empty($alert)) {
        ?>
            <br>
            <div style="color: green; font-size: 12px; margin-left: 20px; margin-bottom: 10px; font-weight: bold;">
                <center><?php echo $alert; ?></center>
            </div>
        <?php } ?>

        <?php
        $alert = $this->session->flashdata("gagal");
        if (!empty($alert)) {
        ?>
            <br>
            <div style="color: red; font-size: 12px; margin-left: 20px; margin-bottom: 10px; font-weight: bold;">
                <center><?php echo $alert; ?></center>
            </div>
        <?php } ?>

        <div class="entry">
            <div id="tabs">
                <ul>
                    <li><a href="#tabs-1">Input Barang</a></li>
                </ul>
                <div id="tabs-1">
                    <form action="<?php echo '/'.$routees; ?>peminjamanmobil/editmobil/<?php echo $id; ?>" method="post" enctype="multipart/form-data">
                        <table cellpadding="0" cellspacing="0" border="0" class="display">
                            <tbody>
                                <?php
                                echo form_hidden('ketegori_jenis', 'mobil');
                                echo form_hidden('harga', 0);
                                echo form_hidden('jumlah', 1);
                                foreach ($mobil as $row) {
                                ?>
                                <tr>
                                    <td align="left" width="15%" class="bg-grid">
                                        <b>Nama Mobil</b>
                                    </td>
                                    <td class="bg-grid">
                                        <input type="text" name="nama_mobil" style="width:100%" class="input-wrc" value="<?php echo $row->nama_mobil; ?>" required>
                                    </td>
                                </tr>
                                <!-- <tr>
                                    <td align="left" width="15%">
                                        <b>Kategori</b>
                                    </td>
                                    <td>
                                        <select class="pilihan" name="ketegori_jenis" style="width:100%" class="input-wrc" required>
                                            <option value="-">-</option>
                                            <option value="laptop" <?php if($row->kategori == "laptop"){ echo 'selected'; } ?>>LAPTOP</option>
                                            <option value="mobil" <?php if($row->kategori == "mobil"){ echo 'selected'; } ?>>MOBIL</option>
                                            <option value="motor" <?php if($row->kategori == "motor"){ echo 'selected'; } ?>>MOTOR</option>
                                            <option value="truk" <?php if($row->kategori == "truk"){ echo 'selected'; } ?>>TRUK</option>
                                            <option value="bus" <?php if($row->kategori == "bus"){ echo 'selected'; } ?>>BUS</option>
                                            <option value="pesawat" <?php if($row->kategori == "pesawat"){ echo 'selected'; } ?>>PESAWAT</option>
                                        </select>
                                        <input type="hidden" name="date" value="<?php echo date('Y-m-d G:i:s') ?>">
                                    </td>
                                </tr> -->
                                <tr>
                                    <td align="left" width="15%">
                                        <b>Plat Nomor</b>
                                    </td>
                                    <td>
                                        <input type="text" name="plat" style="width:100%" class="input-wrc" value="<?php echo $row->plat; ?>"  required>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" width="15%" class="bg-grid">
                                        <b>tahun</b>
                                    </td>
                                    <td class="bg-grid">
                                        <input type="number" name="tahun" style="width:99%; background-color: white;  border: 1px solid blue;" class="input-wrc" value="<?php echo $row->tahun; ?>"  required>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" width="15%">
                                        <b>Jenis</b>
                                    </td>
                                    <td>
                                        <select class="pilihan" name="jenis" style="width:100%" class="input-wrc" required>
                                            <option value="-" >-</option>
                                            <option value="AT" <?php if($row->jenis == "AT"){ echo 'selected'; } ?>>AT</option>
                                            <option value="MT" <?php if($row->jenis == "MT"){ echo 'selected'; } ?>>MT</option>
                                        </select>
                                        <input type="hidden" name="date" value="<?php echo date('Y-m-d G:i:s') ?>">
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" width="15%" class="bg-grid">
                                        <b>Bahan Bakar</b>
                                    </td>
                                    <td class="bg-grid">
                                        <select class="pilihan" name="kategori" style="width:100%" class="input-wrc" required>
                                            <option value="-" >-</option>
                                            <option value="Bensin" <?php if($row->bahan_bakar == "Bensin"){ echo 'selected'; } ?>>Bensin</option>
                                            <option value="Solar" <?php if($row->bahan_bakar == "Solar"){ echo 'selected'; } ?>>Solar</option>
                                            <option value="Listrik" <?php if($row->bahan_bakar == "Listrik"){ echo 'selected'; } ?>>Listrik</option>
                                            <option value="Uap" <?php if($row->bahan_bakar == "Uap"){ echo 'selected'; } ?>>Uap</option>
                                            <option value="Kuda" <?php if($row->bahan_bakar == "Kuda"){ echo 'selected'; } ?>>Kuda</option>
                                        </select>
                                    </td>
                                </tr>
                        <!--    <tr>
                                    <td align="left" width="15%">
                                        <b>Foto</b>
                                    </td>
                                    <td>
                                        <img class="img-preview img-fluid mb-3 col-sm-5" style="max-height: 250px; max-width: 250px;">
                                        <input type="file" class="submit-wrc" id="foto" onchange="previewImage()" name="foto1" style="width:100%;" accept=".jpg,.jpeg,.png,.JPG,.JPEG,.PNG" required="required">
                                    </td>
                                </tr> -->
                                <tr>
                                    <td align="left" width="15%" >
                                        <b>Foto</b>
                                    </td>
                                    <td style="padding:10px;">
                                      <input type="hidden" name="oldfoto" value="<?php echo $row->foto; ?>">
                                      <?php if ($row->foto) { ?>
                                        <img 
                                        src="<?php echo $master_url.'/'.$routees; ?>www/modules/peminjamanmobil/assets/img/<?php echo $row->foto; ?>"
                                        class="img-preview img-fluid mb-3 col-sm-5"  
                                        style="max-height: 250px; max-width: 250px;"
                                        >
                                      <?php }else{ ?>
                                        <img 
                                        class="img-preview img-fluid mb-3 col-sm-5" 
                                        style="max-height: 250px; max-width: 250px;"
                                        >
                                      <?php } ?>
                                        <input type="file" class="submit-wrc" id="foto" onchange="previewImage()" name="gambar" style="width:100%;" accept=".jpg,.jpeg,.png,.JPG,.JPEG,.PNG" value="">
                                        <!-- <input type="text"  value="<?php echo $row->foto; ?>"> -->
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" width="15%" class="bg-grid">
                                        <b>Kapasitas</b>
                                    </td>
                                    <td class="bg-grid">
                                        <input type="text" name="kapasitas" style="width:100%" class="input-wrc" value="<?php echo $row->kapasitas; ?>" required>
                                        <input type="hidden" name="status"  value="<?php echo $row->status; ?>" >
                                    </td>
                                </tr>
<tr>
    <td align="left" width="15%">
        <b>Kondisi</b>
    </td>
    <td>
        <select class="pilihan" name="kondisi" style="width:100%" class="input-wrc" required onchange="showInput(this)">
            <option value="-" >-</option>
            <option value="0" <?php if($row->kondisi == "0"){ echo 'selected'; } ?>><span style="color:red;">Mobil Dalam Kondisi Tidak Baik (OFF)</span></option>
            <option value="1" <?php if($row->kondisi == "1"){ echo 'selected'; } ?>><span style="color:green;">Mobil Dalam Kondisi Baik (ON)</span></option>
            <option value="2" <?php if($row->kondisi == "2"){ echo 'selected'; } ?>><span style="color:blue;">Mobil Operasional TOT</span></option>
            <option value="3" <?php if($row->kondisi == "3"){ echo 'selected'; } ?>><span style="color:green;">Mobil Dalam Kondisi Baik (ON) Khusus Dalam Kota</span></option>
        </select>
    </td>
</tr>
<tr <?php if($row->kondisi != '2'){ ?>id="inputBaru" style="display:none;"<?php } ?>>
    <td align="left">
        <b>Tim Pengelola</b>
    </td>
    <td>
        <select class="pilihan" name="tim" style="width:100%" class="input-wrc" required onchange="showInput(this)" <?php if($row->kondisi != '2'){ ?>id="inputBaru"<?php } ?>>
            <option value="-" >-</option>
            <?php foreach($koor_tot as $roow){ ?>
            <option value="<?php echo $roow->id; ?>" <?php if($row->tot == $roow->id){ echo 'selected'; } ?>><span style="color:red;"><?php echo $this->m_mobil->get_nama_user($roow->id_pegawai).' || '.$roow->nama_tim; ?></span></option>
            <?php } ?>
        </select>
        <!-- <input type="text" name="tim" value="<?php echo $row->tot ?>" <?php if($row->kondisi != '2'){ ?>id="inputBaru"<?php } ?>> -->
    </td>
</tr>
                                <?php 
                                if($this->All || $this->peminjamanmobil){
                                ?>
                                <tr>
                                    <td align="left" width="15%">
                                        <b>Status Aktif & non aktif</b>
                                    </td>
                                    <td>
                                        <select class="pilihan" name="on_off" style="width:100%" class="input-wrc" required>
                                            <option value="-" >-</option>
                                            <option value="1" <?php if($row->on_off == "1"){ echo 'selected'; } ?>><span style="color:red;">Mobil Masih Beroperasi</span></option>
                                            <option value="0" <?php if($row->on_off == "0"){ echo 'selected'; } ?>><span style="color:green;">Mobil Sudah Tidak Beroperasi</span></option>
                                        </select>
                                    </td>
                                </tr>
                                <?php 
                                    }
                                 } 
                                ?>
                            </tbody>
                        </table>
                </div>
            </div>
            <label>&nbsp;</label>
            <div class="spacer"></div>
        </div>
        <div class="entry" style="text-align: center;">
                <input type="submit" name="submit" value="Ubah" class="submit-wrc" content="Ubah">
            <span></span>
            <button name="button" type="button" class="button-wrc" onclick="parent.location='<?php echo site_url('peminjamanmobil/mobil'); ?>'">Batal</button>
        </div>
        </form>
    </div>
    <br style="clear: both;" />
</div>

<script>
    function showInput(select) {
        var selectedValue = select.value;
        var inputBaru = document.getElementById("inputBaru");

        if (selectedValue === "2") {
            inputBaru.style.display = "table-row";
        } else {
            inputBaru.style.display = "none";
        }
    }
</script>
<script type="text/javascript">
    
    function previewImage() {
        const image = document.querySelector('#foto');
        const imgPreview = document.querySelector('.img-preview')

        imgPreview.style.display = 'block';

        const oFReader = new FileReader();
        oFReader.readAsDataURL(image.files[0]);
        oFReader.onload = function(oFREvent) {
            imgPreview.src = oFREvent.target.result;
        }
    }

</script>