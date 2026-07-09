<head>
  <style>
    /* Style untuk modal */
    .modal {
      display: none;
      position: fixed;
      z-index: 1;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      overflow: auto;
      background-color: rgba(0,0,0,0.4);
    }
    
    /* Style untuk konten modal */
    .modal-content {
      background-color: #fefefe;
      margin: 15% auto;
      padding: 20px;
      border: 1px solid #888;
      width: 70%;
    }
    
    /* Style untuk tombol penutup modal */
    .close {
      color: #aaa;
      float: right;
      font-size: 28px;
      font-weight: bold;
      cursor: pointer;
    }
    
    .close:hover,
    .close:focus {
      color: black;
      text-decoration: none;
    }
    
    /* Menghilangkan border dari tombol */
    .button-no-border {
      border: none;
      background: none;
      padding: 0;
      cursor: pointer;
    }
    input {
      appearance: none;
      padding: 16px 32px;
      border-radius: 16px;
      background: radial-gradient(circle 12px, white 100%, transparent calc(100% + 1px)) #ccc -16px;
      transition: 0.3s ease-in-out;
    }

    :checked {
      background-color: dodgerBlue;
      background-position: 16px;
    }
  </style>
 
  <script src="https://code.responsivevoice.org/responsivevoice.js?key=KQ3jY54s"></script>
  
</head>
<div id="content">
  <div class="post"> 
  	<div class="title">
 
      <?php echo $this->lib_date->view_title($page_name); ?>
    </div>
  </div>
</div>
<div id="tabs">
<ul>
  <li><a href="#tabs-1"><strong>Data Pembayaran Perjalanan Dinas</a></li>
  <li><a href="#tabs-2"><strong>Jadwal Perjalanan</a></li>
</ul>

<!-- tabs-1 Data Pembayaran Perjalanan Dinas -->

<div id="tabs-1">
  <div class="entry">
    <fieldset id="half">
      <legend>Filter Data Berdasarkan Tanggal Keberangkatan</legend>
      <?php
      echo form_open('perdin/index');

      $esselon_id = array(
        '0' => '-------- Seluruhnya --------',
        '1' => 'Esselon 4',
        '4' => 'Esselon 3',
        '3' => 'Esselon 2',
        '2' => 'Selesai Jelita',
        '9' => 'Selesai OSS RBA',
        '10' => 'Belum Approve Ess.3 di OSSRBA'
      );
      ?>

      <div id="statusRail">
        <div id="leftRail">
          <?php echo form_label('Periode Awal', 'd_tahun'); ?>
        </div>
        <div id="rightRail">
          <?php
          $periodeawal_input = array(
            'name' => 'tgla',
            'value' => $tgla,
            'class' => 'input-wrc monbulan',
            'readOnly' => TRUE
          );
          echo form_input($periodeawal_input);
          ?>
        </div>
      </div>

      <div id="statusRail">
        <div id="leftRail">
          <?php echo form_label('Periode Akhir', 'd_tahun'); ?>
        </div>
        <div id="rightRail">
          <?php
          $periodeakhir_input = array(
            'name' => 'tglb',
            'value' => $tglb,
            'class' => 'input-wrc monbulan',
            'readOnly' => TRUE
          );
          echo form_input($periodeakhir_input);
          ?>
        </div>
      </div>

      <?php
      $filter_data = array(
        'name' => 'button',
        'class' => 'button-wrc',
        'content' => 'Cari Data',
        'value' => 'Cari Data'
      );
      ?>
      <div id="statusRail">
        <div id="rightRail">
          <?php
          echo form_submit($filter_data);
          echo form_close();
          ?>
        </div>
      </div>
    </fieldset>
  </div>

  <?php
  $alert = $this->session->flashdata("sukses");
  if (!empty($alert)) { ?>
    <br>
    <div style="color: green; font-size: 12px; margin-left: 20px; margin-bottom: 10px; font-weight: bold;">
      <center><?php echo $alert; ?></center>
    </div>
  <?php } ?>

  <?php
  $alert = $this->session->flashdata("gagal");
  if (!empty($alert)) { ?>
    <br>
    <div style="color: red; font-size: 12px; margin-left: 20px; margin-bottom: 10px; font-weight: bold;">
      <center><?php echo $alert; ?></center>
    </div>
  <?php } ?>

  <div class="entry">
    <table>
      <tr>
        <td>
          <?php
          $img_cetak_excel = array(
            'src' => base_url() . 'assets/images/icon/excel.png',
            'alt' => 'Cetak Data Perdin (Format BPK)',
            'title' => 'Cetak Data Perdin (Format BPK)'
          );
          echo anchor(site_url('perdin/cetak_excel') . '/' . (!empty($tgla) && !empty($tglb) ? $tgla . '/' . $tglb : '0/0'), img($img_cetak_excel));
          ?>
        </td>
        <td><span>Export Data Perdin (Format BPK)</span></td>
      </tr>
      <tr>
        <td>
          <?php
          $img_cetak_excel = array(
            'src' => base_url() . 'assets/images/icon/excel.png',
            'alt' => 'Cetak Data Perdin (Format Pimpinan)',
            'title' => 'Cetak Data Perdin (Format Pimpinan)'
          );
          echo anchor(site_url('perdin/cetak_excel_pimpinan') . '/' . (!empty($tgla) && !empty($tglb) ? $tgla . '/' . $tglb : '0/0'), img($img_cetak_excel));
          ?>
        </td>
        <td><span>Export Data Perdin (Format Pimpinan)</span></td>
      </tr>
    </table>
    <br><br>

    <?php
    $ctk_list = array(
      'name' => 'button',
      'content' => 'Tambah Data Perdin',
      'value' => 'Tambah Data Perdin',
      'class' => 'button-wrc',
      'onclick' => 'parent.location=\'' . site_url('perdin/add') . '\''
    );
    echo form_button($ctk_list);
    ?>

    <table cellpadding="0" cellspacing="0" border="0" class="display" id="pendataan">
      <thead>
        <tr>
          <th width="2%">No</th>
          <th width="20%">Nama Pelaksana <br> NIP <br> Jabatan </th>
          <th width="10%">Tanggal Pembayaran <br> Tanggal Berangkat <br> Tanggal Kembali</th>
          <th width="15%">1. Nomor BKU<br>2. Tujuan  <br>3. NIK </th>
          <th width="15%">Uang Harian<br>SKPD</th>
          <th width="28%">Nama BPP <br>Uraian</th>
          <th width="10%">Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $i = 1;
        foreach ($search as $row) {
          $b = $row->tujuan == '' ? '<span style="color: Red">' : '';
          $be = $row->tujuan == '' ? '</span>' : '';
        ?>
          <tr>
            <td><?php echo $i; ?></td>
            <td><?php echo $b . $this->m_perdin->get_n_pegawai($row->id_pegawai) . " <br> " . $this->m_perdin->get_n_nip($row->id_pegawai) . " <br> " . $this->m_perdin->get_n_jabatan($row->id_pegawai) . $be; ?></td>
            <td><?php echo $b . $this->lib_date->mysql_to_human($row->tgl_pembayaran) . "<br>" . $this->lib_date->mysql_to_human($row->tanggal_berangkat) . "<br>" . $this->lib_date->mysql_to_human($row->tanggal_kembali) . $be; ?></td>
            <td><?php echo $b . "1. " . $row->no_bku . "<br>2. " . $this->m_perdin->get_n_kabupaten($row->tujuan) . "<br>3. " . $this->m_perdin->get_n_nik($row->id_pegawai) . $be; ?></td>
            <td><?php echo $b . "1. " . $this->CI->rupiah($row->jumlah_uang) . "<br>2. " . $row->skpd . $be; ?></td>
            <td><?php echo $b . $this->m_perdin->get_n_user($row->user_id) . " <br> " . $row->uraian . $be; ?></td>
            <td>
              <a href="<?php echo base_url() . 'perdin/ubah/' . $row->id; ?>"><img src="<?php echo base_url() . 'assets/images/icon/property.png'; ?>" alt="Edit Perdin" title="Edit Perdin" border="0"></a>
            </td>
          </tr>
        <?php $i++; } ?>
      </tbody>
    </table>
  </div>
</div>

<!-- tabs - 2 data jadwal perjalana dinas  -->
<div id="tabs-2">
  <div class="entry">
    <fieldset id="half">
      <legend>Filter Data Jadwal Perjalanan Dinas </legend>
      <?php
      echo form_open('perdin/index');

      $esselon_id = array(
        '0' => '-------- Seluruhnya --------',
        '1' => 'Esselon 4',
        '4' => 'Esselon 3',
        '3' => 'Esselon 2',
        '2' => 'Selesai Jelita',
        '9' => 'Selesai OSS RBA',
        '10' => 'Belum Approve Ess.3 di OSSRBA'
      );
      ?>

      <div id="statusRail">
        <div id="leftRail">
          <?php echo form_label('Periode Awal', 'd_tahun'); ?>
        </div>
        <div id="rightRail">
          <?php
          $periodeawal_input = array(
            'name' => 'tgla',
            'value' => $tgla,
            'class' => 'input-wrc monbulan',
            'readOnly' => TRUE
          );
          echo form_input($periodeawal_input);
          ?>
        </div>
      </div>

      <div id="statusRail">
        <div id="leftRail">
          <?php echo form_label('Periode Akhir', 'd_tahun'); ?>
        </div>
        <div id="rightRail">
          <?php
          $periodeakhir_input = array(
            'name' => 'tglb',
            'value' => $tglb,
            'class' => 'input-wrc monbulan',
            'readOnly' => TRUE
          );
          echo form_input($periodeakhir_input);
          ?>
        </div>
      </div>

      <?php
      $filter_data = array(
        'name' => 'button',
        'class' => 'button-wrc',
        'content' => 'Cari Data',
        'value' => 'Cari Data'
      );
      ?>
      <div id="statusRail">
        <div id="rightRail">
          <?php
          echo form_submit($filter_data);
          echo form_close();
          ?>
        </div>
      </div>
    </fieldset>
  </div>

  <?php
  $alert = $this->session->flashdata("sukses");
  if (!empty($alert)) { ?>
    <br>
    <div style="color: green; font-size: 12px; margin-left: 20px; margin-bottom: 10px; font-weight: bold;">
      <center><?php echo $alert; ?></center>
    </div>
  <?php } ?>

  <?php
  $alert = $this->session->flashdata("gagal");
  if (!empty($alert)) { ?>
    <br>
    <div style="color: red; font-size: 12px; margin-left: 20px; margin-bottom: 10px; font-weight: bold;">
      <center><?php echo $alert; ?></center>
    </div>
  <?php } ?>

  <div class="entry">
    <table>
      <tr>
        <td>
          <?php
          $img_cetak_excel = array(
            'src' => base_url() . 'assets/images/icon/excel.png',
            'alt' => 'Cetak Data Perdin (Format BPK)',
            'title' => 'Cetak Data Perdin (Format BPK)'
          );
          echo anchor(site_url('perdin/cetak_excel') . '/' . (!empty($tgla) && !empty($tglb) ? $tgla . '/' . $tglb : '0/0'), img($img_cetak_excel));
          ?>
        </td>
        <td><span>Export Data Perdin (Format BPK)</span></td>
      </tr>
      <tr>
        <td>
          <?php
          $img_cetak_excel = array(
            'src' => base_url() . 'assets/images/icon/excel.png',
            'alt' => 'Cetak Data Perdin (Format Pimpinan)',
            'title' => 'Cetak Data Perdin (Format Pimpinan)'
          );
          echo anchor(site_url('perdin/cetak_excel_pimpinan') . '/' . (!empty($tgla) && !empty($tglb) ? $tgla . '/' . $tglb : '0/0'), img($img_cetak_excel));
          ?>
        </td>
        <td><span>Export Data Perdin (Format Pimpinan)</span></td>
      </tr>
    </table>
    <br><br>

    <?php
    $ctk_list = array(
      'name' => 'button',
      'content' => 'Tambah Data Perdin',
      'value' => 'Tambah Data Perdin',
      'class' => 'button-wrc',
      'onclick' => 'parent.location=\'' . site_url('perdin/add') . '\''
    );
    echo form_button($ctk_list);
    ?>

    <table cellpadding="0" cellspacing="0" border="0" class="display" id="Jadwal_Perjalanan_Dinas">
      <thead>
        <tr>
          <th width="2%">No</th>
          <th width="20%">Nama Pelaksana <br> NIP <br> Jabatan </th>
          <th width="10%">Tanggal Pembayaran <br> Tanggal Berangkat <br> Tanggal Kembali</th>
          <th width="15%">1. Nomor BKU<br>2. Tujuan  <br>3. NIK </th>
          <th width="15%">Uang Harian<br>SKPD</th>
          <th width="28%">Nama BPP <br>Uraian</th>
          <th width="10%">Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $i = 1;
        foreach ($search as $row) {
          $b = $row->tujuan == '' ? '<span style="color: Red">' : '';
          $be = $row->tujuan == '' ? '</span>' : '';
        ?>
          <tr>
            <td><?php echo $i; ?></td>
            <td><?php echo $b . $this->m_perdin->get_n_pegawai($row->id_pegawai) . " <br> " . $this->m_perdin->get_n_nip($row->id_pegawai) . " <br> " . $this->m_perdin->get_n_jabatan($row->id_pegawai) . $be; ?></td>
            <td><?php echo $b . $this->lib_date->mysql_to_human($row->tgl_pembayaran) . "<br>" . $this->lib_date->mysql_to_human($row->tanggal_berangkat) . "<br>" . $this->lib_date->mysql_to_human($row->tanggal_kembali) . $be; ?></td>
            <td><?php echo $b . "1. " . $row->no_bku . "<br>2. " . $this->m_perdin->get_n_kabupaten($row->tujuan) . "<br>3. " . $this->m_perdin->get_n_nik($row->id_pegawai) . $be; ?></td>
            <td><?php echo $b . "1. " . $this->CI->rupiah($row->jumlah_uang) . "<br>2. " . $row->skpd . $be; ?></td>
            <td><?php echo $b . $this->m_perdin->get_n_user($row->user_id) . " <br> " . $row->uraian . $be; ?></td>
            <td>
              <a href="<?php echo base_url() . 'perdin/ubah/' . $row->id; ?>"><img src="<?php echo base_url() . 'assets/images/icon/property.png'; ?>" alt="Edit Perdin" title="Edit Perdin" border="0"></a>
            </td>
          </tr>
        <?php $i++; } ?>
      </tbody>
    </table>
  </div>
</div>