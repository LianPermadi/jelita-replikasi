<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<style>
.calendar-icon {
    margin-left: 5px;
    vertical-align: middle;
    cursor: pointer;
    color: #007bff; /* Ubah warna ikon jika perlu */
}

.tooltip {
    display: none;
    position: absolute;
    background-color: #fff;
    border: 1px solid #ccc;
    padding: 5px;
    border-radius: 3px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    z-index: 1000;
}

.date-cell:hover .tooltip {
    display: block;
}
</style>

</head>
<div id="content">
  <div class="post">
    <div class="title">
      <?php echo $this->lib_date->view_title($page_name); ?>
    </div>

    
    <?php 
      include '/var/www/html/jelita/backoffice/www/modules/peminjamanmobil/assets/js/button.php';
                ?>
      <?php
        $id_user = $this->session->userdata('id_auth');
        $idpegawai = $this->m_mobil->get_user_id($id_user);
      // if($langkah == 100){
      $ctk_list = array('name' => 'button',
                        'content' => 'Back',
                        'value' => 'Back',
                        'class' => 'button-wrc',
                        'style' => 'margin:5px;',
                        'onclick' => 'parent.location=\''.site_url('peminjamanmobil/jadwal').'\''
                       );
      echo form_button($ctk_list);  
    // }
    ?>

    <div class="entry">
      <fieldset id="half">
        <legend>Filter Data Berdasarkan Tanggal</legend>
        <?php echo form_open('peminjamanmobil/detail_mobil/'.$id); ?>

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

    <center><h1>Jadwal Peminjaman Mobil <?php echo $this->m_mobil->get_nama_mobil_id($id).' - '.$this->m_mobil->get_platnomor_id($id); ?></h1></center>
      <div>
      <table cellpadding="0" cellspacing="0" border="0" class="display" id="pendataan">
        <thead>
          <tr>
            <th width="4%">No</th>
            <th width="26%">Nama Peminjam</th>
            <th width="15%">Tanggal Pinjam</th>
            <th width="15%">Tanggal Kembali</th>
            <th width="15%">Tujuan</th>
            <th width="15%">Bidang</th>
            <th width="15%">Driver</th>
            <th width="15%">Status</th>
            <!-- <th width="15%">Aksi</th> -->
          </tr>
        </thead>
        <tbody>
          <?php
            $wrg = '<span style="color:yellow;">';
            $dgr = '<span style="color:red;">';
            $akf = '<span style="color:green;">';
            $ttp = '</span>';
            $no = 1;
            foreach ($mobil as $row) {
            $plat = $this->m_mobil->get_platnomor_id($row->mobil);
            $nama_mobil = $this->m_mobil->get_nama_mobil_id($row->mobil);
            $tahun = $this->m_mobil->get_tahun_id($row->mobil);
            // if($row->status == '0'){
          ?>
            <tr>
              <td><?php echo $no; ?></td>
              <td><?php echo $this->m_mobil->get_nama_user($row->peminjam); ?></td>
              <?php
              // Mengatur lokal ke bahasa Indonesia
              setlocale(LC_TIME, 'id_ID.utf8');

              // Tanggal dalam bahasa Inggris
              $tanggal_pinjam = date("l", strtotime($row->tanggal_pinjam)).', '.date("d F Y", strtotime($row->tanggal_pinjam));
              $tanggal_kembali = date("l", strtotime($row->tanggal_kembali)).', '.date("d F Y", strtotime($row->tanggal_kembali));

              // Mengonversi tanggal menjadi format timestamp
              $timestamptanggal_pinjam = strtotime($tanggal_pinjam);
              $timestamptanggal_kembali = strtotime($tanggal_kembali);

              // Memformat tanggal ke dalam bahasa Indonesia
              $tanggal_pinjam = strftime('%A, %d %B %Y', $timestamptanggal_pinjam);
              $tanggal_kembali = strftime('%A, %d %B %Y', $timestamptanggal_kembali);
              ?>

<td data-date="<?php echo $tanggal_pinjam; ?>" class="date-cell">
    <i class="fas fa-calendar-alt calendar-icon"></i>
    <?php echo $tanggal_pinjam; ?>
</td>
<td data-date="<?php echo $tanggal_kembali; ?>" class="date-cell">
    <i class="fas fa-calendar-alt calendar-icon"></i>
    <?php echo $tanggal_kembali; ?>
</td>
              <td><?php 
                      echo $row->tujuan;
                  ?>
              </td>
              <td>
                <?php 
                      echo $row->bagian;
                  ?>
              </td>
              <td>
                <?php 
                      echo $row->driver;
                  ?>
              </td>
              <td>
                <?php
                if($row->status == '0'){
                  echo $dgr.'Menunggu Approve'.$ttp;
                }elseif($row->status == '1'){
                  echo $akf.'Sudah Approve'.$ttp;
                  ?>
                  <!-- <a href="/peminjamanmobil/berita_acara/<?php echo $row->id; ?>"><button class="button-wrc">Berita Acara</button></a> -->
                  <?php
                }elseif($row->status == '2'){
                  echo 'Sudah Di Kembalikan';
                  ?>
                  <!-- <a href="/peminjamanmobil/berita_acara/<?php echo $row->id; ?>"><button class="button-wrc">Berita Acara</button></a> -->
                  <?php
                }
                ?>
              </td>
            </tr>
          <?php
          $no++;
        }
        // }
          ?>
        </tbody>
      </table>
      </div>
      <br style="clear: both;" />
    </div>
  </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function () {
    var dateCells = document.querySelectorAll('.date-cell');

    dateCells.forEach(function(cell) {
        var icon = cell.querySelector('.calendar-icon');
        var date = cell.getAttribute('data-date');

        icon.addEventListener('mouseover', function() {
            showTooltip(icon, date);
        });

        icon.addEventListener('mouseout', function() {
            hideTooltip();
        });
    });

    function showTooltip(element, date) {
        var tooltip = document.createElement('div');
        tooltip.className = 'tooltip';
        tooltip.innerText = date;

        document.body.appendChild(tooltip);

        var rect = element.getBoundingClientRect();
        tooltip.style.left = rect.left + window.scrollX + 'px';
        tooltip.style.top = rect.bottom + window.scrollY + 'px';
    }

    function hideTooltip() {
        var tooltip = document.querySelector('.tooltip');
        if (tooltip) {
            tooltip.remove();
        }
    }
});
</script>
