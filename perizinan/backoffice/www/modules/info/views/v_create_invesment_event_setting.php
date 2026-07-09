
<div id="content">
  <div class="post">
    <div class="title">
      <?php echo $this->lib_date->view_title($page_name); ?>
      <!-- Lib Date View Title Here -->
    </div>
    <?php 
        $alert = $this->session->flashdata("sukses");
        if(!empty($alert)){
    ?>
        <br>
        <div style="color: green; font-size: 12px; margin-left: 20px; margin-bottom: 10px; font-weight: bold;"><center><?php echo $alert; ?></center></div>
    <?php } ?>

    <?php 
        $alert = $this->session->flashdata("gagal");
        if(!empty($alert)){
    ?>
    <?php
    }
    ?>
    <?php
    if ($this->session->flashdata('error')) {
    ?>
        <div class="alert alert-danger" role="alert" style="text-align:center;">
            <?php echo $this->session->flashdata('error'); ?>
        </div>
        <br>
        <div style="color: red; font-size: 12px; margin-left: 20px; margin-bottom: 10px; font-weight: bold;"><center><?php echo $alert; ?></center></div>
    <?php } ?>
    <?php
    if ($this->session->flashdata('success')) {
    ?>
        <div class="alert alert-danger" role="alert" style="text-align:center;">
            <?php echo $this->session->flashdata('success'); ?>
        </div>
    <?php
    }
    ?>

    <form method="post" action="<?php echo site_url().'info/invesment/store_event_setting' ?>" enctype="multipart/form-data">
        <div class="entry">
            <div id="tabs">
                <ul>
                <li><a href="#tabs-1">Tambah Event Setting</a></li>
                
                </ul>
            <div id="tabs-1">
                <table cellpadding="0" cellspacing="0" border="0" class="display">
                    <tbody>
                        <tr>
                            <td align="left" width="15%" class="bg-grid">
                                <b>Nama Event Setting</b>
                            </td>
                            <td class="bg-grid">
                                <input type="text" class="input-wrc" style="width:100%" id="nama_event" placeholder="Masukan Nama Event" name="nama_event">
                            </td>
                        </tr>
                        <tr>
                            <td align="left" width="15%" class="bg-grid">
                                <b>Jumlah</b>
                            </td>
                            <td class="bg-grid">
                                <input type="text" class="input-wrc" style="width:100%" id="jumlah" placeholder="Masukan Jumlah jika ada perhitungan" name="jumlah">
                            </td>
                        </tr>

                        <tr>
                            <td align="left" width="15%" class="bg-grid">
                                <b>Status Event</b>
                            </td>
                            <td class="bg-grid">
                                <select class="input-wrc" name="status_setting_event" value="{!! old('status_setting_event') !!}">
                                    <option value='1'>Aktif</option>
                                    <option value='0'>Tidak Aktif</option>
                                </select>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div style="display: flex; flex-direction: row; align-items: center; margin-top: 2%;">
                    <div style="margin-left: auto;"> <!-- Bagian kanan, tombol -->
                        <button name="button" type="submit" id="tambahDataBtn" class="button-wrc">Simpan</button>
                        <button name="button" type="button" value="Checkout Barang" class="button-wrc" onclick="parent.location='https://dpmptsp.jabarprov.go.id/jelita/backoffice/info/invesment'">Batal</button>

                    </div>
                </div>
            </div>
        </div>
    </form>
  </div>
  <br style="clear: both;" />
</div>
