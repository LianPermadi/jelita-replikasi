<?php
    $i = 1;
    $n_file = '';
    $id = '';
    $n_file = '';
    $n_file_draft = '';
    $tgl_entry = '';
    $page = '';
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
    // var_dump($routees, $root,$routees_portal,$master_url);
?>
<head>
    <!-- <meta charset="utf-8"> -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Untitled</title>
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
      $ctk_list = array('name' => 'button',
                        'content' => 'Kembali',
                        'value' => 'Back',
                        'class' => 'button-wrc',
                        'onclick' => 'parent.location=\''.site_url('peminjamanmobil').'\''
                       );
      echo form_button($ctk_list); 
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
    <div id="barang">
      <table cellpadding="0" cellspacing="0" border="0" class="display" id="pendataan">
        <thead>
          <tr>
            <th width="2%">No</th>
            <th width="15%">Peminjam</th>
            <th width="15%">Mobil</th>
            <th width="20%">Tanggal</th>
            <th width="15%">Tanggal Pinjam</th>
            <th width="23%">Tujuan</th>
            <th width="10%">Action</th>
          </tr>
        </thead>
        <tbody>
          <?php 

            $wrg = '<span style="color:yellow;">';
            $dgr = '<span style="color:red;">';
            $akf = '<span style="color:green;">';
            $ttp = '</span>';
          $a = $this->m_mobil->get_user_id($id_user);
          // echo $a;
          foreach ($mobil as $row) { 
            if($row->peminjam == $a){
$id_surat_mobil = $this->m_mobil->get_id_mobil_persuratan($row->id);
// var_dump($id_surat_mobil);die();
if (!empty($id_surat_mobil)) {
    $surat = $this->m_approve_surat->data_surat($id_surat_mobil);
    // var_dump($surat);

    if (!empty($surat)) {

    $n_file = $surat->id.".pdf";
    $approve = $surat->approve;
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
  $plat = $this->m_mobil->get_platnomor_id($row->mobil);
            ?>
      <tr>
        <td><?php echo $i; ?></td>
        <td valign='top'>
          <?php 
            $peminjam = $this->m_mobil->get_nama_user($row->peminjam);
    // var_dump($peminjam);die();
            echo $peminjam.'<br> '.$row->id;
           ?>
        </td>
        <td valign='top'>
          <?php
            $nama_mobil = $this->m_mobil->get_nama_mobil_id($row->mobil);
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
          ?>
          </td>
        <td valign='top'>
          <?php
            echo $row->tujuan;
          ?>
          </td>
          <td>
            <?php
            // echo $n_file;
              if($row->status == 0){
                echo $wrg.'Menunggu Approve'.$ttp;
          }elseif($row->status == 12){
                echo $dgr.'Pengajuan Ditolak'.$ttp;
          }elseif($row->status == 1){
            ?>
            <?php
            if($approve == '0'){
            echo '<a href="'.base_url().'persuratan/unduh/'.$id_surat_mobil.'">
            <img src="https://cdn-icons-png.flaticon.com/512/337/337946.png" alt="Preview Surat" title="Preview Surat" border="0" width="25px"></a>
                &nbsp;';
            }else{
            echo '<a href="'.base_url().'persuratan/unduh_preview/'.$id_surat_mobil.'">
            <img src="https://cdn-icons-png.flaticon.com/512/337/337946.png" alt="Preview Surat" title="Preview Surat Draft" border="0" width="25px"></a>
                &nbsp;';
            }
                ?>
            <a href="peminjamanmobil/kembali/<?php echo $row->id; ?>"><button class="button-wrc" title="Konfirmasi Kembalikan Mobil">Selesai</button></a>
            <?php
          }elseif($row->status == 3 || $row->status == 2){
            ?>
            <!-- <a href="peminjamanmobil/berita_acara/<?php echo $row->id; ?>"><button class="button-wrc">Berita Acara</button></a> -->
            <?php
            if($approve == '0'){
            echo '<a href="'.base_url().'persuratan/unduh/'.$id_surat_mobil.'">
            <img src="https://cdn-icons-png.flaticon.com/512/337/337946.png" alt="Preview Surat" title="Preview Surat" border="0" width="25px"></a>
                &nbsp;';
            }else{
            echo '<a href="'.base_url().'persuratan/unduh_preview/'.$id_surat_mobil.'">
            <img src="https://cdn-icons-png.flaticon.com/512/337/337946.png" alt="Preview Surat" title="Preview Surat Draft" border="0" width="25px"></a>
                &nbsp;';
            }
                ?>
            <?php
          }elseif($row->status == 10) {
            $id_mobil = $this->m_mobil->get_id_mobil_persuratan($row->id);
            $status_surat = $this->m_mobil->get_id_surat($id_mobil);
            if($status_surat != '1'){
            ?>
            <!-- <a href="https://dpmptsp.jabarprov.go.id/android/approve_surat/preview_peminjaman_mobil/<?php echo $id_mobil; ?>"><button class="button-wrc">Approve</button></a> -->
            <!-- <a href="preview_peminjaman_mobil/<?php echo $id_mobil; ?>"><button class="button-wrc">TTE</button></a> -->
<?php
// $i = 1; // Pastikan variabel i diinisialisasi sebelum loop
// foreach ($mobil as $row) { 
  $nama_mobil = $this->m_mobil->get_nama_mobil_id($row->mobil);
?>
    <button id="showModalBtn<?php echo $i; ?>" class="button-wrc"><img src="https://cdn.icon-icons.com/icons2/2622/PNG/512/gui_signature_icon_157586.png" alt="TTE" title="TTE" width="25px"></button>
    <a href="/<?php echo $routees; ?>peminjamanmobil/edit_pemohonan/<?php echo $row->id; ?>" onclick="return confirm('Apa Anda Yakin Edit Mobil <?php echo $nama_mobil.' - '.$plat;; ?>?')">

        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/6/64/Edit_icon_%28the_Noun_Project_30184%29.svg/1200px-Edit_icon_%28the_Noun_Project_30184%29.svg.png" alt="edit" title="Edit" width="25px">

    </a>
    
    <form action="peminjamanmobil/update_multiple_mobil" method="post">
        <div id="myModal<?php echo $i; ?>" class="modal">
            <div class="modal-content">
                <span class="close<?php echo $i; ?>">&times;</span>
                <center>
                    PASSPHRASE
                    <input type="hidden" value="<?php echo $this->session->userdata('id_auth'); ?>" name="id_user">
                    <input type="hidden" name="msg" value="<?php echo $id; ?>">
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
    // $i++;
// }
?>
            <?php
            }
            ?>
            <a href="<?php echo $master_url.'/'.$routees; ?>peminjamanmobil/hapus_pengajuan/<?php echo $row->id; ?>/2" title='batal'><img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/5e/Antu_task-reject.svg/2048px-Antu_task-reject.svg.png" width='30px'></a>
            <?php 
          }elseif($row->status == 11){
            ?>
            <a href="<?php echo $master_url.'/'.$routees; ?>persuratan/mobil/<?php echo $row->id; ?>"><button class="button-wrc">Kirim Surat</button></a>
            <?php
          }
            ?>
          </td>
      </tr>
          <?php $i++; 

          }
          } ?>
        </tbody>
      </table>
  </div>
</div>
  <br style="clear: both;" />
</div>