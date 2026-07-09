<?php
foreach ($id as $ids) {
    $id_permintaan = $ids->id;
    $status_permintaan = $ids->status;
    $user_permintaan = $ids->pemberi_barang;
    $id_user_permintaan = $ids->id_user;
    $date_masuk = $ids->date;
    $tanggal_approve = $ids->tanggal_approve;
    $tanggal_terima = $ids->tanggal_terima;
    $tanggal_kirim = $ids->tanggal_kirim;
}
// var_dump($date_masuk);die();
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
                <center>
                    <?php echo $alert; ?>
                </center>
            </div>
        <?php } ?>

        <?php
        $alert = $this->session->flashdata("gagal");
        if (!empty($alert)) {
            ?>
            <br>
            <div style="color: red; font-size: 12px; margin-left: 20px; margin-bottom: 10px; font-weight: bold;">
                <center>
                    <?php echo $alert; ?>
                </center>
            </div>
        <?php } ?>

        <div class="entry">
            <?php if ($langkah == '1') { ?>
                <?php
                $ctk_list = array(
                    'name' => 'button',
                    'content' => 'Daftar Barang',
                    'value' => 'Daftar Barang',
                    'class' => 'button-wrc',
                    'onclick' => 'parent.location=\'' . site_url('permintaanbarang/pengajuan_barang') . '\''
                );
                echo form_button($ctk_list);
                ?>
                <?php
                $ctk_list = array(
                    'name' => 'button',
                    'content' => 'Checkout Barang',
                    'value' => 'Checkout Barang',
                    'class' => 'button-wrc',
                    'onclick' => 'parent.location=\'' . site_url('permintaanbarang/checkout_barang') . '\''
                );
                echo form_button($ctk_list);
                ?>
                <?php
                $ctk_list = array(
                    'name' => 'button',
                    'content' => 'List Permintaan Barang',
                    'value' => 'List Permintaan Barang',
                    'class' => 'button-wrc',
                    'style' => 'background:#B0C4DE; color:black;',
                    'onclick' => 'parent.location=\'' . site_url('permintaanbarang/list_permintaan') . '\''
                );
                echo form_button($ctk_list);
                ?>                
                <?php
            $ctk_list = array(
                'name' => 'button',
                'content' => 'History Permintaan barang',
                'value' => 'History Permintaan barang',
                'class' => 'button-wrc',
                'onclick' => 'parent.location=\'' . site_url('permintaanbarang/log_permintaan') . '\''
            );
            echo form_button($ctk_list);
            ?>
            <?php } elseif ($langkah == '0') { ?>

                <?php
                $ctk_list = array(
                    'name' => 'button',
                    'content' => 'Tambah Barang Baru',
                    'value' => 'Tambah Barang Baru',
                    'class' => 'button-wrc',
                    'onclick' => 'parent.location=\'' . site_url('permintaanbarang/addbarang') . '\''
                );
                echo form_button($ctk_list);
                ?>
                <?php
                $ctk_list = array(
                    'name' => 'button',
                    'content' => 'List Persediaan',
                    'value' => '',
                    'class' => 'button-wrc',
                    'onclick' => 'parent.location=\'' . site_url('permintaanbarang/barang') . '\''
                );
                echo form_button($ctk_list);
                ?>
                <?php
                $ctk_list = array(
                    'name' => 'button',
                    'content' => 'List Permintaan barang',
                    'value' => 'List Permintaan barang',
                    'class' => 'button-wrc',
                    'onclick' => 'parent.location=\'' . site_url('permintaanbarang/pengajuan') . '\''
                );
                echo form_button($ctk_list);
                ?>
                <?php
                $ctk_list = array(
                    'name' => 'button',
                    'content' => 'checkout Barang',
                    'value' => 'checkout Barang',
                    'style' => 'background:#B0C4DE; color:black;',
                    'class' => 'button-wrc',
                    'onclick' => 'parent.location=\'' . site_url('permintaanbarang/checkout') . '\''
                );
                echo form_button($ctk_list);
                ?>
                <?php
                $ctk_list = array(
                    'name' => 'button',
                    'content' => 'Activity Barang',
                    'value' => 'Activity Barang',
                    'class' => 'button-wrc',
                    'onclick' => 'parent.location=\'' . site_url('permintaanbarang/activity') . '\''
                );
                echo form_button($ctk_list);
                ?>
                <?php
                $ctk_list = array(
                    'name' => 'button',
                    'content' => 'Log Barang',
                    'value' => 'Log Barang',
                    'class' => 'button-wrc',
                    'onclick' => 'parent.location=\'' . site_url('permintaanbarang/') . '\''
                );
                echo form_button($ctk_list);
                ?>
            <?php } ?>
<?php if ($langkah == '1') { ?>
    <table cellpadding="0" cellspacing="0" border="0" class="display" id="pendataan1">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="15%">Nama Barang</th>
                <th width="10%">Merk</th>
                <th width="5%">Jumlah</th>
                <th width="23%">Tanggal</th>
                <th width="17%">Keterangan</th>
                <th width="13%">Status</th>
                <th width="12%">action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 1;
            foreach ($barang as $row) {
                if ($row->status == '2' || $row->status == '3' || $row->status == '4' || $row->status == '5' || $row->status == '6' || $row->status == '7') {
                    ?>
                    <tr>
                        <td>
                            <?php echo $i; ?>
                        </td>
                        <td>
                            <?php echo $row->nama_barang; ?>
                        </td>
                        <td>
                            <center>
                            <?php echo $row->merk; ?></center>
                        </td>
                        <td><center>
                            <span><?php echo $row->jumlah_barang; ?> <?php echo $row->satuan; ?></span></center>
                        </td>
                        <td><center>
                            <span style="color:green;">Tanggal Pengajuan </span>
                            <?php
                              $tgl = $this->lib_date->mysql_to_human(date("Y/m/d", strtotime($row->date_masuk)));
          	                  $jam = date("H:i:s a", strtotime($row->date_masuk));
                              echo $tgl.' , '.$jam;  ?><br />
                            <?php
                            if ($row->tanggal_permintaan == NULL) {

                            } else { ?>
                                <span style="color:green;">Tanggal Approve </span>
                                <?php
                                $tgl = $this->lib_date->mysql_to_human(date("Y/m/d", strtotime($row->tanggal_permintaan)));
          	                    $jam = date("H:i:s a", strtotime($row->tanggal_permintaan));
                                echo $tgl.' , '.$jam;
                            }
                            if ($row->tanggal_kirim_barang == NULL) {

                            } else { ?>
                                <br /><span style="color:green;">Tanggal Kirim </span>
                                <?php
                                $tgl = $this->lib_date->mysql_to_human(date("Y/m/d", strtotime($row->tanggal_kirim_barang)));
          	                    $jam = date("H:i:s a", strtotime($row->tanggal_kirim_barang));
                                echo $tgl.' , '.$jam;
                            } ?></center>
                        </td>
                        <td><?php echo $row->keterangan; ?></td>
                        <td><center>
                            <?php if ($row->status == '2') { ?>
                                <h4 style="color:orange;">Sedang Proses</h4>
                            <?php } elseif ($row->status == '3') { ?>
                                <h4 style="color:blue;">Di siapkan</h4>
                            <?php } elseif ($row->status == '4') { ?>
                                <h4 style="color:green;">Barang Sedang di kirim</h4>
                            <?php } elseif ($row->status == '5') { ?>
                                <h4 style="color:green;">Sudah Menerima Barang?</h4>
                            <?php } elseif ($row->status == '6') { ?>
                                <h4 style="color:green;">Barang Di terima</h4>
                            <?php } elseif ($row->status == '8') { ?>
                                <h4 style="color:green;">Mengirim Pengajuan Pengembalian/Kurang Lengkap</h4>
                            <?php } elseif ($row->status == '9') { ?>
                                <h4 style="color:green;">Barang Siap Di Ambil</h4>
                            <?php } ?></center>
                        </td>
                        <td>
                            <center>
                            <?php if ($row->status == '5') { ?>
                                <a href="terima/<?php echo $row->no_id; ?>"><button class="button-wrc" style="background: green;">Ya</button></a>
                                    <a
                                        href="hapus_checkout_permintaan/<?php echo $row->no_id; ?>/<?php echo $row->jumlah_barang; ?>/<?php echo $row->id_barang; ?>/<?php echo $langkah; ?>"><button
                                            class="button-wrc"  onclick="return confirm('Yakin Batal?')" style="background: red;">Tidak Ada</button></a>
                            <?php } elseif ($row->status == '6') {
                            } elseif($row->status == '9'){
                                echo "<a href='diambil/".$row->no_id."/".$row->jumlah_barang."/".$row->id_barang."/".$langkah."'><button class='button-wrc'  onclick='return confirm('Yakin Batal?')' style='background: red;'>Tidak Ada</button></a>";
                            } else {
                                echo "<input type='submit' class='button-wrc' value='Terima' readonly>
                                            <input type='submit' class='button-wrc' value='Tidak Ada' readonly>";
                            } ?>
                            </center>
                        </td>
                    </tr>
                    <?php $i++;
                } else {
                    echo '';
                }
            } ?>
            <!-- <thead> -->
        </tbody>
        <!-- </thead> -->
    </table>
    <center>
        <div style="
                position: absolute;
                right: 20px;
                ">
            <table>
                <tr>
                    <td colspan="7">
                        <?php
                        if (!empty($id_permintaan)) {
                            if ($status_permintaan == '0') { ?>
                                <h2 style="margin: 20px;">Permintaan Selesai </h2>
                            <?php } elseif ($status_permintaan == '5') { ?>
                                <div style="margin-left: 20px;">
                                    <form method="post" action="terima/<?php echo $id_permintaan; ?>">
                                        <!-- <form method="post" action="<?php echo site_url() . 'permintaanbarang/accept_selesai/' . $id_permintaan; ?>" enctype="multipart/form-data"> -->
                                        <?php foreach ($barang as $bar) { ?>
                                            <input type="hidden" name="status[]" value="<?php echo $bar->status; ?>">
                                            <input type="hidden" name="id_barang[]" value="<?php echo $bar->id_barang; ?>">
                                            <input type="hidden" name="jumlah_barang[]" value="<?php echo $bar->jumlah_barang; ?>">
                                        <?php } ?>
                                        <input type="hidden" name="langkah" value="2">
                                        <input type="hidden" name="id_user" value="<?php echo $user_permintaan; ?>">
                                        <input type="hidden" name="nama_barang" value="<?php foreach ($barang as $row) { 
                                            if($row->merk == NULL){
                                                echo '* <b>' . $row->nama_barang . '</b> Dengan Jumlah <b>' . $row->jumlah_barang . '</b><br>';
                                            }else{
                                            echo '* <b>' . $row->nama_barang . '</b> Merk <b>'.$row->merk. '</b> Dengan Jumlah <b>' . $row->jumlah_barang . '</b><br>';
                                            }
                                        } ?>">
                                        <input type="hidden" name="Keterangan" value="<?php 
                                        $n = 1;
                                        foreach ($barang as $ket) { 
                                            if ($ket->keterangan == NULL || $ket->keterangan == '' || $ket->keterangan == ' ' || $ket->keterangan == '-') {
                                                echo '';
                                            }else{
                                                echo $n.'. <b>'.$ket->nama_barang.'</b> Merk <b>'.$ket->merk.'</b> : '.$ket->keterangan.'<br>';
                                            }
                                            $n++;
                                        }
                                        ?>">
                                        <input type="hidden" name="tanggal_barang" value="<?php
                                        echo '<span>Tanggal Masuk </span>' . $date_masuk . '<br/><span>Tanggal Approve </span>' . $tanggal_approve . '<br><span>Tanggal Kirim </span>' . $tanggal_kirim . '<br><span>Tanggal Terima </span>' . $tanggal_terima . '<br/>';
                                        ?>">
                                        <input type="hidden" name="id_user_permintaan" value="<?php echo $id_user_permintaan; ?>">
                                        <!-- <input type="hidden" name="id_user" value=""> -->

                                        <input type="hidden" name="data_barang" value="
                                        <?php 
                                        echo "
                                        <table border='1' width='100%' style='border-collapse: collapse;'>
                                        <tr>
                                        <th>NO</th>
                                        <th>Nama Barang Spesifikasi</th>
                                        <th>Jumlah</th>
                                        <th>Satuan Barang</th>
                                        <th>Ket</th>
                                        </tr>
                                        ";
                                        $no = 1; 
                                        foreach ($barang as $row) { 
                                                echo "
                                                <tr>
                                                <td><center>$no</center></td>
                                                <td><b>$row->nama_barang</b> Dengan Merk <b>$row->merk</b></td>
                                                <td><center>$row->jumlah_barang</center></td>
                                                <td><center>$row->satuan</center></td>
                                                <td></td>
                                                </tr>
                                                ";
                                        $no++; 
                                        } 
                                        echo "</table>"; 
                                       
                                   ?>">
                                        <input type="submit" name="submit" class="button-wrc" style="text-align: right;" value="Selesaikan Pengajuan">
                                    </form>
                                </div>
                            <?php }
                        } ?>
                    </td>
                </tr>
            </table>
    </center>
    </div>
    <br>
    <br>
<?php } ?> 
        </div>
    </div>
    <br style="clear: both;" />
</div>