
<?php 
    $routees        = str_replace('index.php', '', $_SERVER['SCRIPT_NAME']);
    $root           = rtrim($_SERVER['DOCUMENT_ROOT'], '/'); // buang trailing slash
    $routees        = ltrim($routees, '/');              // buang leading slash
    $routees_portal = str_replace('backoffice/index.php', '', $_SERVER['SCRIPT_NAME']); 
    $master_url     = $_SERVER['REQUEST_SCHEME'] .'://'. $_SERVER['HTTP_HOST'];
?>
<div id="content">
  <div class="post">
    <div class="title">
      <?php echo $this->lib_date->view_title($page_name); ?>
    </div>
        <div class="entry">
      <fieldset id="half">
        <legend>Filter Data Berdasarkan Tanggal</legend>
        <?php echo form_open('peminjamanmobil/history'); ?>

        <div id="statusRail">
          <div id="leftRail">
            <?php echo form_label('Tanggal Awal','d_tahun'); ?>
          </div>
          <div id="rightRail">
            <?php
            $periodeawal_input = array('name'  => 'tgla',
                                       'value' => $tgla,
                                       'class' => 'input-wrc',
                                       'readOnly'=>TRUE,
                                       'class' => 'monbulan');
            echo form_input($periodeawal_input);
            ?>
          </div>
        </div>
        
        <div id="statusRail">
          <div id="leftRail">
            <?php echo form_label('Tanggal Akhir','d_tahun'); ?>
          </div>
          <div id="rightRail">
            <?php
            $periodeakhir_input = array('name'  => 'tglb',
                                        'value' => $tglb,
                                        'class' => 'input-wrc',
                                        'readOnly'=>TRUE,
                                        'class' => 'monbulan');
            echo form_input($periodeakhir_input);
            echo ' ';

            $filter_data = array('name' => 'button',
                                 'class' => 'button-wrc',
                                 'content' => 'Filter',
                                 'value' => 'Filter');
            echo form_submit($filter_data);
            ?>
          </div>
        </div>
        <?php
        echo form_hidden('kd_filter', '2');
        echo form_close();
        ?>
      </fieldset>
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
        <br>
        <div style="color: red; font-size: 12px; margin-left: 20px; margin-bottom: 10px; font-weight: bold;"><center><?php echo $alert; ?></center></div>
      <?php } ?>

    <div class="entry"> 

      <?php

      include $root.'/'.$routees.'www/modules/peminjamanmobil/assets/js/button.php';
                ?>
      <?php
        $id_user = $this->session->userdata('id_auth');
        $idpegawai = $this->m_mobil->get_user_id($id_user);
      if($langkah == 100){
      $ctk_list = array('name' => 'button',
                        'content' => 'History User',
                        'value' => 'History User',
                        'class' => 'button-wrc',
                        'onclick' => 'parent.location=\''.site_url('peminjamanmobil/kembali_mobil').'\''
                       );
      echo form_button($ctk_list);  
    }
                ?>

            <form action="peminjamanmobil/cetak_pengeluaran" method="post">
              <table>
                <tr>
                  <td>
                <label for="bulan">Pilih Bulan:</label>
                  </td>
                  <td>
                <label for="tahun">Pilih Tahun:</label>
                  </td>
                </tr>
                <tr>
                  <td>
                <select id="bulan" class="input-wrc" name="bulan">
                    <option value="01">Januari</option>
                    <option value="02">Februari</option>
                    <option value="03">Maret</option>
                    <option value="04">April</option>
                    <option value="05">Mei</option>
                    <option value="06">Juni</option>
                    <option value="07">Juli</option>
                    <option value="08">Agustus</option>
                    <option value="09">September</option>
                    <option value="10">Oktober</option>
                    <option value="11">November</option>
                    <option value="12">Desember</option>
                </select>
                  </td>
                  <td>
                <select id="tahun" class="input-wrc" name="tahun">
                    <?php
                        $tahunSekarang = date("Y");
                        for ($tahun = $tahunSekarang - 10; $tahun <= $tahunSekarang + 10; $tahun++) {
                          ?>
                            <option value="<?php echo $tahun; ?>" <?php if($tahun == $tahunSekarang){ echo 'selected'; } ?>><?php echo $tahun; ?></option>
                            <?php
                        }
                      ?>
                </select>
                  </td>
                </tr>
                <tr>
                  <td colspan="2">
                <input type="submit" class="button-wrc" value="Submit">
                  </td>
                </tr>
              </table>
            </form>

    <div id="barang">
      <table cellpadding="0" cellspacing="0" border="0" class="display" id="pendataan">
        <thead>
          <tr>
            <th width="2%">No</th>
            <th width="20%">Peminjam</th>
            <th width="20%"><?php echo ucfirst($button) ?></th>
            <th width="20%">Tanggal</th>
            <th width="20%">Tanggal Pinjam<br>Tanggal Kembali</th>
            <th width="18%">Action</th>
          </tr>
        </thead>
        <tbody>
          <?php 
          $i = 1;
          foreach ($mobil as $row) { 
            if($row->kategori == $button){
            if($row->status == 3){
            ?>
      <tr>
        <td><?php echo $i; ?></td>
        <td valign='top'>
          <?php 
            $peminjam = $this->m_mobil->get_nama_user($row->peminjam);
    // var_dump($peminjam);die();
            echo $peminjam;
           ?>
        </td>
        <td valign='top'>
          <?php
            $nama_mobil = $this->m_mobil->get_nama_mobil_id($row->mobil);
            $plat = $this->m_mobil->get_platnomor_id($row->mobil);
            echo $nama_mobil.' - '.$plat;
          ?>
        </td>
        <td valign='top'>
          <?php
            echo date("l", strtotime($row->tanggal)).', '.date("d F Y", strtotime($row->tanggal)).'<br>';
          ?>
          </td>
        <td valign='top'>
          <?php
            echo date("l", strtotime($row->tanggal_pinjam)).', '.date("d F Y", strtotime($row->tanggal_pinjam)).'<br>';
            if($row->tanggal_kembali != '0000-00-00 00:00:00'){
              echo date("l", strtotime($row->tanggal_kembali)).', '.date("d F Y", strtotime($row->tanggal_kembali)).'<br>';
            }
          ?>
          </td>
          <td>
            <?php
            $id_surat_mobil = $this->m_mobil->get_id_mobil_persuratan($row->id);
            $approve = NULL;
            if (!empty($id_surat_mobil)) {
              $surat = $this->m_approve_surat->data_surat($id_surat_mobil);
                if (!empty($surat)) {
                  $n_file = $surat->id.".pdf";
                  $approve = $surat->approve;
                }
            }
            if($approve == '0'){
            echo '<a href="'.base_url().'persuratan/unduh/'.$id_surat_mobil.'">
            <img src="https://cdn-icons-png.flaticon.com/512/337/337946.png" alt="Preview Surat" title="Preview Surat" border="0" width="25px"></a>
                &nbsp;';
            }else{
              if($approve != NULL){
                echo '<a href="'.base_url().'persuratan/unduh_preview/'.$id_surat_mobil.'">
                <img src="https://cdn-icons-png.flaticon.com/512/337/337946.png" alt="Preview Surat" title="Preview Surat Draft" border="0" width="25px"></a>
                    &nbsp;';
              }
            }
            ?>
          </td>
      </tr>
          <?php $i++; }
          }} ?>
        </tbody>
      </table>
  </div>
</div>
  <br style="clear: both;" />
</div>