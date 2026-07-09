<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i">
    <link rel="stylesheet" href="assets/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/fonts/fontawesome5-overrides.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
    <style>
        .lukiganteng{
            margin : 5px;
            color  : blue;
        }
    </style>
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
                    <li><a href="#tabs-1">Input Barang</a></li>
                </ul>
                <div id="tabs-1">
                    <form action="/jelita/backoffice/peminjamanmobil/editpinjammobil/<?php echo $id; ?>" method="post" enctype="multipart/form-data">
                        <table cellpadding="0" cellspacing="0" border="0" class="display">
                            <tbody>
                                <?php
                                $jam = date('G:i:s');
                                $cek = 0;
                                if(!empty($tgla)){
                                if($tgla != NULL || $tglb != NULL){
                                    $tgla_tanggal = date("Y-m-d", strtotime($tgla));
                                    $tglb_tanggal = date("Y-m-d", strtotime($tglb));
                                    $cek = 1;
                                }
                            }
                                foreach ($mobil as $row) {
                                    // var_dump($row);die;
                                    $nama_mobil = $this->m_mobil->get_nama_mobil_id($row->mobil);
                                    $plat = $this->m_mobil->get_platnomor_id($row->mobil);
                                    $tahun = $this->m_mobil->get_tahun_id($row->mobil);
                                    $jenis = $this->m_mobil->get_jenis_id($row->mobil);
                                    $bahan_bakar = $this->m_mobil->get_bahan_bakar_id($row->mobil);
                                    $kapasitas = $this->m_mobil->get_kapasitas_id($row->mobil);
                                    $tanggal_pinjam = date("Y-m-d", strtotime($row->tanggal_pinjam));
                                    $jam_tanggal_pinjam = date("G:i:s", strtotime($row->tanggal_pinjam));
                                    $tanggal_kembali = date("Y-m-d", strtotime($row->tanggal_kembali));
                                    $jam_tanggal_kembali = date("G:i:s", strtotime($row->tanggal_kembali));
                                ?>
                                <tr>
                                        <td>Merk Kendaraan : <?php echo $nama_mobil; ?></td>
                                        <td>Nomor Polisi : <?php echo $plat; ?></td>
                                </tr>
                                <tr>
                                        <td>Tahun Kendaraan : <?php echo $tahun; ?></td>
                                        <td>Jenis : <?php echo $jenis; ?></td>
                                </tr>
                                <tr>
                                        <td>Bahan Bakar : <?php echo $bahan_bakar; ?></td>
                                        <td>Kapasitas Angkutan : <?php echo $kapasitas; ?></td>
                                    </tr>
                                <?php
                                ?>
                                <tr>
                                    <td align="left" width="15%" class="bg-grid">
                                        <b>Tanggal Pinjam</b>
                                    </td>
                                    <td class="bg-grid">
                                        <input type="date" name="tanggal_pinjam" style="width:25%" class="input-wrc" value="<?php 
                                        if($cek == 1){ 
                                            echo $tgla_tanggal; 
                                            }elseif($tanggal_pinjam != NULL){
                                                echo $tanggal_pinjam;
                                                }else{ echo date('Y-m-d'); 
                                            } 
                                            ?>" required>
                                        <input type="time" name="jam_pinjam" style="width:25%" class="input-wrc" value="<?php 
                                        if($cek == 1){
                                            echo $jam; 
                                            }elseif($jam_tanggal_pinjam != NULL){
                                                 echo $jam_tanggal_pinjam;
                                                 }else{
                                                     echo '00:00:00'; 
                                                     } 
                                                     ?>" required>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" width="15%">
                                        <b>Tanggal Kembali</b>
                                    </td>
                                    <td>
                                        <input type="date" name="tanggal_kembali" style="width:25%" class="input-wrc" value="<?php 
                                        if($cek == 1){ 
                                            echo $tglb_tanggal; 
                                            }elseif($tanggal_kembali != NULL){
                                                echo $tanggal_kembali;
                                                }
                                            else{
                                                 echo date('Y-m-d'); 
                                                 } ?>" required>
                                        <input type="time" name="jam_kembali" style="width:25%" class="input-wrc" value="<?php if($cek == 1){ echo $jam; }elseif($jam_tanggal_kembali != NULL){
                                                echo $jam_tanggal_kembali;
                                                }else{ echo '23:59:59'; } ?>" required>
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
                                        <input type="text" name="bagian" style="width:100%" value="<?php echo $row->bagian; ?>" class="input-wrc" required>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" width="15%" class="bg-grid">
                                        <b>Tujuan</b>
                                    </td>
                                    <td class="bg-grid">
                                        <input type="text" name="tujuan" style="width:100%" value="<?php echo $row->tujuan; ?>" class="input-wrc" required>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" width="15%">
                                        <b>Driver</b>
                                    </td>
                                    <td>
                                        <input type="text" name="driver" style="width:100%" value="<?php echo $row->driver; ?>" class="input-wrc">
                                        <input type="hidden" name="kategori" style="width:100%" value="<?php echo $row->kategori; ?>" class="input-wrc">
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
            <button name="button" type="button" class="button-wrc" onclick="parent.location='<?php echo site_url('peminjamanmobil/'); ?>'">Batal</button>
        </div>
        </form>
    </div>
    <br style="clear: both;" />
</div>