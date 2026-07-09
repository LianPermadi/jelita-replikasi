<?php 
    $routees        = str_replace('index.php', '', $_SERVER['SCRIPT_NAME']);
    $root           = rtrim($_SERVER['DOCUMENT_ROOT'], '/'); // buang trailing slash
    $routees        = ltrim($routees, '/');              // buang leading slash
    $routees_portal = str_replace('backoffice/index.php', '', $_SERVER['SCRIPT_NAME']); 
    $master_url     = $_SERVER['REQUEST_SCHEME'] .'://'. $_SERVER['HTTP_HOST'];
    // var_dump($routees, $root,$routees_portal,$master_url);
?>
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
<div id="content">
    <div class="post">
        <div class="title">
          <?php echo $this->lib_date->view_title($page_name); ?>
        </div>

        <?php
        if(!empty($user)){
        foreach ($user as $row) {
                    $id_user = $row->id;
                    $nama = $row->n_pegawai;
                }
        }else{
                    $id_user = '';
                    $nama = '';
        }
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
                    <form action="<?php echo '/'.$routees; ?>peminjamanmobil/add_mobil" method="POST" enctype="multipart/form-data">
                        <table cellpadding="0" cellspacing="0" border="0" class="display">
                            <tbody>
                            	  <?php
                                echo form_hidden('harga', 0);
                                echo form_hidden('jumlah', 1);
                                ?>
                                <tr>
                                    <td align="left" width="15%" class="bg-grid">
                                        <b>Nama Merk</b>
                                    </td>
                                    <td class="bg-grid">
                                        <input type="text" name="nama_mobil" style="width:100%" class="input-wrc" required>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" width="15%" class="bg-grid">
                                        <!-- <b>Kategori</b> -->
                                    </td>
                                    <td class="bg-grid">
                                        <!-- <select class="pilihan" name="ketegori_jenis" style="width:100%" class="input-wrc" required>
                                            <option value="-">-</option>
                                            <option value="laptop">LAPTOP</option>
                                            <option value="mobil">MOBIL</option>
                                            <option value="motor">MOTOR</option>
                                            <option value="truk">TRUK</option>
                                            <option value="bus">BUS</option>
                                            <option value="pesawat">PESAWAT</option>
                                        </select> -->
                                        <!-- <input type="hidden" name="date" value="<?php echo date('Y-m-d G:i:s') ?>"> -->
                                        <input type="hidden" name="ketegori_jenis" value="mobil">
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" width="15%">
                                        <b>Nomor Seri/ Plat</b>
                                    </td>
                                    <td>
                                        <input type="text" name="plat" style="width:100%" class="input-wrc" required>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" width="15%" class="bg-grid">
                                        <b>Tahun Edar/Pembuatan/Pembelian</b>
                                    </td>
                                    <td class="bg-grid">
                                        <input type="number" name="tahun" style="width:99%; background-color: white;  border: 1px solid blue;" class="input-wrc" required>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" width="15%">
                                        <b>Jenis</b>
                                    </td>
                                    <td>
                                        <select class="pilihan" name="jenis" style="width:100%" class="input-wrc" required>
                                            <option value="-">-</option>
                                            <option value="AT">AT</option>
                                            <option value="MT">MT</option>
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
                                            <option value="-">-</option>
                                            <option value="Bensin">Bensin</option>
                                            <option value="Solar">Solar</option>
                                            <option value="Listrik">Listrik</option>
                                            <option value="Uap">Uap</option>
                                            <option value="Kuda">Kuda</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" width="15%">
                                        <b>Kapasitas</b>
                                    </td>
                                    <td>
                                        <input type="hidden" name="id_user" value="<?php echo $id_user; ?>">
                                        <input type="hidden" name="nama" value="<?php echo $nama; ?>">
                                        <input type="text" name="kapasitas" style="width:100%" class="input-wrc" required>
                                        <input type="hidden" name="status" value="1">
                                        <input type="hidden" name="kondisi" value="1">
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" width="15%" class="bg-grid">
                                        <b>Foto Kendaraan</b>
                                    </td>
                                    <td class="bg-grid">
                                        <img class="img-preview img-fluid mb-3 col-sm-5" style="max-height: 250px; max-width: 250px;"><br>
                                        <input type="file" class="submit-wrc" id="foto" onchange="previewImage()" name="foto1" accept=".jpg,.jpeg,.png,.JPG,.JPEG,.PNG" required="required">
                                        <!-- <input type="file" name="foto1"> -->
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                </div>
            </div>
            <label>&nbsp;</label>
            <div class="spacer"></div>
        </div>
        <div class="entry" style="text-align: center;">
                <input type="submit" name="submit" value="Simpan" class="submit-wrc" content="Simpan">
            <span></span>
            <button name="button" type="button" class="button-wrc" onclick="parent.location='<?php echo site_url('video_tutor'); ?>'">Batal</button>
        </div>
        </form>
    </div>
    <br style="clear: both;" />
</div>

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