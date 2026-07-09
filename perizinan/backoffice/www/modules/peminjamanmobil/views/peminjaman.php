<?php
    $i = 1;
    $n_file = '';
    $id = '';
    $n_file = '';
    $n_file_draft = '';
    $tgl_entry = '';
    // $page = '';
    $no_surat = '';
    $tgl_surat = '';
	  $id_ess2 = '';
	  $id_sekdis = '';
	  $id_ess3 = '';
	  $id_ess4 = '';
    $id_jfah = '';
    $analis_hukum = '';
	  $id_konseptor = '';
?>
<?php 
    $routees        = str_replace('index.php', '', $_SERVER['SCRIPT_NAME']);
    $root           = rtrim($_SERVER['DOCUMENT_ROOT'], '/'); // buang trailing slash
    $routees        = ltrim($routees, '/');              // buang leading slash
    $routees_portal = str_replace('backoffice/index.php', '', $_SERVER['SCRIPT_NAME']); 
    $master_url     = $_SERVER['REQUEST_SCHEME'] .'://'. $_SERVER['HTTP_HOST'];
?>
<head>
   <style>
    /* Gaya umum */
.modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.7);
}

.modal-content {
    background-color: #fff;
    margin: 15% auto;
    padding: 20px;
    border-radius: 5px;
    width: 60%;
}

.close {
    float: right;
    font-size: 20px;
    font-weight: bold;
    cursor: pointer;
}
  </style>
</head>
<div id="content">
  <div class="post">
    <div class="title">
      <?php echo $this->lib_date->view_title($page_name); ?>
    </div>

            <div class="entry">
      <fieldset id="half">
        <legend>Filter Data Berdasarkan Tanggal</legend>
        <?php echo form_open('peminjamanmobil/peminjaman'); ?>

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
    <div id="barang">
      <table cellpadding="0" cellspacing="0" border="0" class="display" id="pendataan">
        <thead>
          <tr>
            <th width="2%">No</th>
            <th width="15%">Peminjam<br>UUID<br>TIM</th>
            <th width="15%"><?php echo ucfirst($button); ?></th>
            <th width="20%">Tanggal</th>
            <th width="20%">Tanggal Pinjam<br>Tanggal Kembali</th>
            <th width="23%">Tujuan</th>
            <th width="10%">Action</th>
          </tr>
        </thead>
        <tbody>
          <?php 
          $i = 1;
          foreach ($mobil as $row) { 
            if($row->kategori == $button){
            if($row->status == 0 || $row->status == 10){
              $id_surat_mobil = $this->m_mobil->get_id_mobil_persuratan($row->id);

if (!empty($id_surat_mobil)) {
    $surat = $this->m_approve_surat->data_surat($id_surat_mobil);
    // var_dump($surat);

    if (!empty($surat)) {
      $n_file = $surat->id.".pdf";
      $id = $surat->id;
      $n_file = 'SRT_'.$n_file;
      $n_file_draft = 'SRTDRAFT_'.$n_file;
      $tgl_entry = $surat->tgl_entry;
      $page = 'surat';
      $no_surat = $surat->nomor_surat;
      $tgl_surat = $surat->tgl_surat;
      $id_ess2 = $surat->ess2;
      $id_sekdis = $surat->sekdis;
      $id_ess3 = $surat->ess3;
      $id_ess4 = $surat->ess4;
      $id_jfah = $surat->jfah;
      $analis_hukum = $surat->analis_hukum;
      $id_konseptor = $surat->user_id;
    }
  }
            ?>
      <tr>
        <td><?php echo $i; ?></td>
        <td valign='top'>
          <?php 
            $peminjam = $this->m_mobil->get_nama_user($row->peminjam);
    // var_dump($peminjam);die();
            echo $peminjam.'<br>'.$row->id.'<br>'.$row->bagian;
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
            echo date("l", strtotime($row->tanggal_kembali)).', '.date("d F Y", strtotime($row->tanggal_kembali)).'<br>';
          ?>
          </td>
        <td valign='top'>
          <?php
            echo $row->tujuan;
          ?>
          </td>
          <td>
            <table>
              <tr>
                <td>
                <?php
                // $pengolah_laptop     = $this->m_persuratan->struktural(7);
                $id_mobil            = $this->m_mobil->get_id_mobil_persuratan_ess3($row->id);
                // echo $id_mobil.' = '.$idpegawai;
                if($row->status != 11 && $row->status != 10){

                if($idpegawai == $id_mobil || $this->pengelolalaptop){

                ?>
                  <button id="showModalBtn<?php echo $i; ?>" class="button-wrc">Approve(TTE)</button>
                          <a href="peminjamanmobil/reject/<?php echo $row->id; ?>/<?php echo $button; ?>"><button class="button-wrc" onclick="return confirm('Apa Anda Yakin reject Mobil <?php echo $nama_mobil.' - '.$plat;; ?>?')">Reject</button></a>
                  
                  <!-- <form action="https://dpmptsp.jabarprov.go.id/android/approve_surat/update_multiple_mobil" method="post"> -->
                  <?php if($button != 'laptop'){ ?>
                  <form action="peminjamanmobil/update_multiple_mobil_ess3" method="post">
                  <?php }else{ ?>
                  <form action="peminjamanmobil/update_multiple_laptop_ess3" method="post">
                  <?php } ?>
                      <div id="myModal<?php echo $i; ?>" class="modal">
                          <div class="modal-content">
                              <span class="close<?php echo $i; ?>">&times;</span>
                              <center>
                                  PASSPHRASE
                                  <input type="hidden" value="<?php echo $this->session->userdata('id_auth'); ?>" name="id_user">
                                  <input type="hidden" name="msg" value="<?php echo $id; ?>">
                                  <input type="hidden" name="idpegawai" value="<?php echo $idpegawai; ?>">
                                  <input type="hidden" name="id_pengolah" value="<?php echo $id_mobil; ?>">
                                  <input type="hidden" name="id_pemintaan" value="<?php echo $row->id; ?>">
                                  <input type="hidden" value="<?php echo $this->session->userdata("id"); ?>" name="id">
                                  <input type="hidden" name="n_file" value="<?php echo $n_file; ?>">
                                  <input type="hidden" name="no_surat" value="<?php echo $no_surat; ?>">
                                  <input type="hidden" name="tgl_surat" value="<?php echo $tgl_surat; ?>">
                                  <input type="password" name="passphrase" class="input-wrc" width="100%" required>
                                  <br>
                                  <input type="submit" name="submit" autofocus required value="Proses" class="btn">
                              </center>
                          </div>
                      </div>
                  </form>

                  <script>
                      document.addEventListener("DOMContentLoaded", function () {
                          var showModalBtn = document.getElementById("showModalBtn<?php echo $i; ?>");
                          var modal = document.getElementById("myModal<?php echo $i; ?>");
                          var closeBtn = document.querySelector(".close<?php echo $i; ?>");

                          showModalBtn.addEventListener("click", function () {
                              modal.style.display = "block";
                          });

                          closeBtn.addEventListener("click", function () {
                              modal.style.display = "none";
                          });

                          window.addEventListener("click", function (event) {
                              if (event.target == modal) {
                                  modal.style.display = "none";
                              }
                          });
                      });
                  </script>
                  <?php
                          }
                }
                  ?>
              </td>
              <td>
                <?php if($row->status == 11){ ?>
                <span style="color:red;">Di tolak</span>
                <?php } ?>
                <?php if($row->status == 10){ ?>
                <span style="color:red;">Peminjam Belum Melakukan TTE</span>
                <?php } ?>
              </td>
            </tr>
          </table>
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