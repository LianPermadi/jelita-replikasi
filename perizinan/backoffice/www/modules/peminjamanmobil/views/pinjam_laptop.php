<?php 
    $routees        = str_replace('index.php', '', $_SERVER['SCRIPT_NAME']);
    $root           = rtrim($_SERVER['DOCUMENT_ROOT'], '/'); // buang trailing slash
    $routees        = ltrim($routees, '/');              // buang leading slash
    $routees_portal = str_replace('backoffice/index.php', '', $_SERVER['SCRIPT_NAME']); 
    $master_url     = $_SERVER['REQUEST_SCHEME'] .'://'. $_SERVER['HTTP_HOST'];
?>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
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
                    <li><a href="#tabs-1">Input Peminjaman Laptop</a></li>
                </ul>
                <div id="tabs-1">
                    <form action="/<?php echo $routees; ?>/peminjamanmobil/pinjamlaptop/<?php echo $id; ?>" method="post" enctype="multipart/form-data">
                        <table cellpadding="0" cellspacing="0" border="0" class="display">
                            <tbody>
                                <?php
                                $jam = date('G:i:s');
                                $cek = 0;
                                if($tgla != NULL || $tglb != NULL){
                                    $tgla_tanggal = date("Y-m-d", strtotime($tgla));
                                    $tglb_tanggal = date("Y-m-d", strtotime($tglb));
                                    $cek = 1;
                                }
                                foreach ($mobil as $row) {
                                ?>
                                <h4>Merk Laptop : <?php echo $row->nama_mobil; ?></h4>
                                <h4>Nomor Seri : <?php echo $row->plat; ?></h4>
                                <h4>Tahun Laptop : <?php echo $row->tahun; ?></h4>
                                <h4>Jenis : <?php echo $row->jenis; ?></h4>
                                <h4>Daya : <?php echo $row->bahan_bakar; ?></h4>
                                <h4>Kapasitas Baterai : <?php echo $row->kapasitas; ?></h4>
                                <tr>
                                    <td align="left" width="15%" class="bg-grid">
                                        <b>Tanggal Pinjam</b>
                                    </td>
                                    <td class="bg-grid">
                                        <input type="date" name="tanggal_pinjam" style="width:25%" class="input-wrc" value="<?php if($cek == 1){ echo $tgla_tanggal; }else{ echo date('Y-m-d'); } ?>" required>
                                        <!-- <input type="time" name="jam_pinjam" style="width:25%" class="input-wrc" value="<?php if($cek == 1){ echo $jam; }else{ echo '00:00:00'; } ?>" required> -->
                                        <input type="hidden" name="jam_pinjam" style="width:25%" class="input-wrc" value="06:00:00">
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" width="15%">
                                        <b>Tanggal Kembali</b>
                                    </td>
                                    <td>
                                        <input type="date" name="tanggal_kembali" style="width:25%" class="input-wrc" value="<?php if($cek == 1){ echo $tglb_tanggal; }else{ echo date('Y-m-d'); } ?>" required>
                                        <!-- <input type="time" name="jam_kembali" style="width:25%" class="input-wrc" value="<?php if($cek == 1){ echo $jam; }else{ echo '23:59:59'; } ?>" required> -->
                                        <input type="hidden" name="jam_kembali" style="width:25%" class="input-wrc" value="23:00:00">
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" width="15%" class="bg-grid">
                                        <b>Peminjam</b>
                                    </td>
                                    <td class="bg-grid">
                                        <?php 
                                        $id_user = $this->session->userdata('id_auth');
                                        $idpegawai = $this->m_mobil->get_user_id($id_user);
                                        echo $this->m_mobil->get_nama_user($idpegawai); ?>
                                        <input type="hidden" name="idpegawai" value="<?php echo $idpegawai; ?>">
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" width="15%">
                                        <b>Bagian/Bidang</b>
                                    </td>
                                    <td>
                                        <?php $bidang = $this->m_mobil->get_bidang(); ?>
                                        <!-- <input type="text" name="bagian" style="width:100%" class="input-wrc" required> -->
                                        <select name="bagian" id="" class="input-wrc">
                                                <option value="">Pilih bidang</option>
                                            <?php foreach ($bidang as $data) { ?>
                                                <option value="<?php echo $data->nama_tim; ?>"><?php echo $data->nama_tim; ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" width="15%" class="bg-grid">
                                        <b>Tujuan</b>
                                    </td>
                                    <td class="bg-grid">
                                        <input type="text" name="tujuan" style="width:100%" class="input-wrc" required>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" width="15%">
                                        <b>Pengguna</b>
                                    </td>
                                    <td>
                                        <input type="text" name="driver" style="width:100%" class="input-wrc">
                                    </td>
                                </tr>
                                <?php 
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
                <input type="submit" name="submit" value="Pinjam" class="submit-wrc" content="Pinjam">
            <span></span>
            <button name="button" type="button" class="button-wrc" onclick="parent.location='<?php echo site_url('peminjamanmobil/peminjaman_laptop/'); ?>'">Batal</button>
        </div>
        </form>
    </div>
    <br style="clear: both;" />
</div>