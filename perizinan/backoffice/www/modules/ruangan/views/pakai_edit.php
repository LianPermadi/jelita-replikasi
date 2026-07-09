<head>
<!-- Tambahkan referensi ke jQuery -->
<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->

<!-- Tambahkan referensi ke DataTables -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.7/css/jquery.dataTables.css">
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.7/js/jquery.dataTables.js"></script>  
<style>
/* Tambahkan ini ke dalam tag <style> atau file CSS Anda */

    /* Tambahkan ini ke dalam tag <style> atau file CSS Anda */
    table {
      font-family: Arial, sans-serif;
      border-collapse: collapse;
      width: 100%;
    }

    th, td {
      border: 1px solid #dddddd;
      text-align: left;
      padding: 8px;
    }

    th {
      background-color: #f2f2f2;
    }

    input[type="text"] {
      padding: 6px;
      box-sizing: border-box;
    }

.modal {
    display: none;
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgb(0,0,0);
    background-color: rgba(0,0,0,0.4);
    padding-top: 60px;
}

.modal-content {
    background-color: #fefefe;
    margin: 5% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
    max-width: 600px;
}

.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}
  </style>
  </head>
<?php 
  if (!empty($pakai)) {
    $id_ruangan = $pakai->id_ruangan; 
    $seksi = $pakai->seksi;
    $kegiatan = $pakai->kegiatan;
    $acara = $pakai->acara;
    $target_undangan = $pakai->target_undangan;
    $snack = $pakai->snack;
    $mamin = $pakai->mamin;
    $tanggal = $pakai->tanggal;
    $waktu_awal = explode(":", $pakai->waktu_awal);
    $waktu_awal1 = $waktu_awal[0]; //Jam
    $waktu_awal2 = $waktu_awal[1]; //Menit
    $waktu_akhir = explode(":", $pakai->waktu_akhir);
    $waktu_akhir1 = $waktu_akhir[0];
    $waktu_akhir2 = $waktu_akhir[1];
    $keterangan = $pakai->keterangan;
    $id = $pakai->id;
    $token = '3';
  } else {
    $id_ruangan = "";
    $seksi = "";
    $kegiatan = "0";
    $target_undangan = 0;
    $acara = "";
    $snack = "";
    $mamin = "";
    $tanggal = "";
    $waktu_awal1 = "";
    $waktu_awal2 = "";
    $waktu_akhir1 = "";
    $waktu_akhir2 = "";
    $keterangan = "";
    $id = "";
    $token = "";
  }
 ?>

<div id="content">
  <div class="post">
    <div class="title">
      <?php
      if($this->username != 'Guest'){
        echo $this->lib_date->view_title($page_name);
      }else{
        echo 'ADD/EDIT Dalam Pengembangan';
      }  
      ?>
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
    <form method="post" action="<?php echo site_url().'ruangan/'.$step; ?>" enctype="multipart/form-data">
    <div class="entry">
      <div id="tabs">
        <ul>
          <li><a href="#tabs-1">Booking Ruangan</a></li>
        </ul>
        <div id="tabs-1">
        <?php 
          if ($step == "update") { ?>
            <input type="hidden" name="id" value="<?php echo $id; ?>">
          <?php } ?>
          <table cellpadding="0" cellspacing="0" border="0" class="display">
            <tbody>
            	
              <!--
              <tr>
                <td align="left" width="15%">
                  <b>Nama Ruangan</b>
                </td>
                <td>
                  <select class="pilihan" name="id_ruangan" style="width:100%">
                    <?php
                    foreach ($ruangan as $rowRuangan) {
                    	if($rowRuangan->status == 0){
                    		$b = '<span style="color: Blue">';
                        $be = '</span>';
                    	  $add_ket = $b.'( Only Show Up for Admin Saparapat )'.$be;
                    	}else{
                    		$add_ket = '';
                    	}
                    	?>
                      <option value="<?php echo $rowRuangan->id; ?>" <?php echo ($id_ruangan == $rowRuangan->id ? "selected" : ""); ?>><?php echo $rowRuangan->nama_ruangan." Lt. ".$rowRuangan->lantai." - Kapasitas ".$rowRuangan->kapasitas." Orang ".$add_ket; ?></option>
                      <?php
                    }
                    ?>
                  </select>
                </td>
              </tr>
              -->
              
              <tr>
                <td align="left" width="15%">
                  <b>Nama Ruangan</b> 
                </td>
                <td>
                  <select class="pilihan" name="id_ruangan" id="ruanganSelect" style="width:40%">
                    <!--<option value="" data-images="">-- Pilih Ruangan --</option>-->
                    <?php
                    $routees = str_replace('index.php', '', $_SERVER['PHP_SELF']); 
                    $url_link = $_SERVER['REQUEST_SCHEME'] .'://'. $_SERVER['HTTP_HOST'] . $routees;
                    $base_url = $url_link."assets/ruangan/image/";
                    foreach ($ruangan as $rowRuangan) {
                      if ($rowRuangan->status == 0) {
                        $b = '<span style="color: Blue">';
                        $be = '</span>';
                        $add_ket = $b . '( Only Show Up for Admin Saparapat )' . $be;
                      } else {
                        $add_ket = '';
                      }
              
                      // Simpan hanya nama file gambar di database, lalu gabungkan dengan base URL
                      //$imageNames = [$rowRuangan->gambar1, $rowRuangan->gambar2, $rowRuangan->gambar3]; // Nama file gambar
                      //$imageNames = ['15RR2025021195232.jpg','15RR2025021195632.png'];
                      $foto = $rowRuangan->foto;
                      if($foto == NULL){
                        $foto = 'no_img.png';
                        // Jangan di ubah2 si Ine id 941 sedang dipaksa biar tanggung jawab update foto ruangan 
                        // ini kemauan dia sendiri untuk menambah fitur foto tapi lama gak mau update (PBS)
                        if($this->id == 941 || $this->id == 64){ // id ini sedang dipaksa biar isi foto ruangan 
                          $foto = 'no_img.png;no_img2.png;no_img4.png;no_img3.png;no_img.png'; 
                        }
                      }
                      $foto_arr = explode(";", $foto);
                      $jml_arr = count($foto_arr);
                      $ket_foto = ' ('.$jml_arr.' Foto )';
                      if($rowRuangan->foto == ""){
                      	$ket_foto = '';
                      }
                      $imageNames = $foto_arr;
                      $imageUrls = array_map(function($img) use ($base_url) {
                        return $img ? $base_url . $img : ''; // Gabungkan dengan URL direktori
                      }, array_filter($imageNames)); // Hapus nilai kosong
                      $imagesString = implode(',', $imageUrls); // Gabungkan menjadi string dengan koma
                      ?>
                      <option value="<?php echo $rowRuangan->id; ?>" 
                              data-images="<?php echo $imagesString; ?>">
                        <?php echo $rowRuangan->nama_ruangan . " Lt. " . $rowRuangan->lantai . " - Kapasitas " . $rowRuangan->kapasitas . " Orang " . $add_ket; ?>
                      </option>
                      <?php
                    }
                    ?>
                  </select>
              
                  <br><br>
                  <div id="imageContainer" style="display: flex; gap: 10px; flex-wrap: wrap;"></div>
                </td>
              </tr>
              
              <tr>
                <td align="left" width="15%" class="bg-grid">
                  <b>Tim</b>
                </td>
                <td class="bg-grid">
                  <select class="pilihan" name="seksi" id="seksiSelect" style="width:25%">
                    <option value="-"> - </option>
                    <?php foreach ($koor as $tim): ?>
                      <option value="<?php echo $tim->id; ?>" <?php echo ($seksi == $tim->id ? "selected" : ""); ?>>
                        <?php echo $tim->nama_tim; ?>
                      </option>
                    <?php endforeach ?>
                    <option value="lainnya">Lainnya</option>
                  </select>

                  <!-- Input tambahan untuk 'lainnya', awalnya disembunyikan -->
                  <input type="text" name="seksi_lainnya" id="inputLainnya" placeholder="Masukkan nama TIM" style="display:none; margin-top:5px; width:25%">
                </td>
                <script>
                  document.getElementById('seksiSelect').addEventListener('change', function () {
                    var lainnyaInput = document.getElementById('inputLainnya');
                    if (this.value === 'lainnya') {
                      lainnyaInput.style.display = 'inline-block';
                    } else {
                      lainnyaInput.style.display = 'none';
                    }
                  });
                </script>
                <!-- <td class="bg-grid">
                  <select class="pilihan" name="seksi" style="width:25%">
                    <option value="0" <?php echo ($seksi == "0" ? "selected" : ""); ?>> - </option>
                    <option value="8" <?php echo ($seksi == "8" ? "selected" : ""); ?>>Sub Bagian Tata Usaha</option>
                    <option value="9" <?php echo ($seksi == "9" ? "selected" : ""); ?>>Sekretaris Dinas PMPTSP</option>
                    <option value="10" <?php echo ($seksi == "10" ? "selected" : ""); ?>>Kepala Dinas PMPTSP</option>
                    <option value="11" <?php echo ($seksi == "11" ? "selected" : ""); ?>>Badan Pengelola Kawasan Rebana</option>
                    <option value="12" <?php echo ($seksi == "12" ? "selected" : ""); ?>>Aturan dan Kebijakan ( Ranjak)</option>
                    <option value="13" <?php echo ($seksi == "13" ? "selected" : ""); ?>>Kemitraan dan Penialian Kinerja (KPK)</option>
                    <option value="14" <?php echo ($seksi == "14" ? "selected" : ""); ?>>Pelayanan Advokasi Hukum (ReAvoK)</option>
                    <option value="15" <?php echo ($seksi == "15" ? "selected" : ""); ?>>Pembinaan dan Kinerja (Pemkin)</option>
                    <option value="16" <?php echo ($seksi == "16" ? "selected" : ""); ?>>Data dan Penyelesaian Permasalahan  (MasLahta)</option>
                    <option value="17" <?php echo ($seksi == "17" ? "selected" : ""); ?>>Digitalisasi Internal dan Eksternal (DgIE)</option>
                    <option value="18" <?php echo ($seksi == "18" ? "selected" : ""); ?>>Potensi Promosi dan Investasi  (PPI)</option>
                    <option value="19" <?php echo ($seksi == "19" ? "selected" : ""); ?>>Pelayanan Perizinan ( DurZin)</option>
                    <option value="20" <?php echo ($seksi == "20" ? "selected" : ""); ?>>Pengawasan Pelaku Usaha (WaspelkU)</option>
                  </select>
                </td> -->
              </tr>
              <tr>
                <td align="left" width="15%">
                  <b>Kegiatan</b>
                </td>
                <td>
                  <select class="pilihan" name="kegiatan" style="width:10%">
                    <option value="0" <?php echo ($kegiatan == "0" ? "selected" : ""); ?>>Internal</option>
                    <option value="1" <?php echo ($kegiatan == "1" ? "selected" : ""); ?>>Eksternal</option>
                  </select>
                </td>
              </tr>
              <tr>
                <td align="left" width="15%" class="bg-grid">
                  <b>Acara</b>
                </td>
                <td class="bg-grid">
                  <input type="text" name="acara" style="width:100%" class="input-wrc" value="<?php echo $acara; ?>" required="required">
                </td>
              </tr>
              
              <tr>
                <td align="left" width="15%">
                  <b>Target Undangan (0 Undefined)</b>
                </td>
                <td>
                  <input type="number" name="target_undangan" style="width:10%" class="input-wrc" value="<?php echo $target_undangan; ?>" required="required">
                </td>
              </tr>
              <tr>
                <td align="left" width="15%" class="bg-grid">
                  <b>Snack</b>
                </td>
                <td class="bg-grid">
                  <input type="text" name="snack" style="width:10%" class="input-wrc" value="<?php echo $snack; ?>" required="required">
                </td>
              </tr>
              <tr>
                <td align="left" width="15%">
                  <b>Mamin</b>
                </td>
                <td>
                  <input type="text" name="mamin" style="width:10%" class="input-wrc" value="<?php echo $mamin; ?>" required="required">
                </td>
              </tr>
              <tr>
                <td align="left" width="15%" class="bg-grid">
                  <b>Tanggal Pakai</b>
                </td>
                <td class="bg-grid">
                  <?php 
                  $tgl_input = array('name' => 'tanggal',
                                     'value' => ((!empty($tanggal)) ? $tanggal : date('Y-m-d')),
                                     'class' => 'input-wrc',
                                     'readOnly'=>TRUE,
                                     'style' => "width:10%",
                                     'class' => 'monbulan'
                                    );
                  echo form_input($tgl_input);
                  ?>
                </td>
              </tr>
              
              <tr>
                <td align="left" width="15%">
                  <b>Waktu Mulai</b>
                </td>
                <td>
                  <input type="text" name="awal1" style="width:5%; text-align: center;" class="input-wrc" value="<?php echo $waktu_awal1; ?>" maxlength="2" required="required"> : <input type="text" name="awal2" style="width:5%; text-align: center;" class="input-wrc" value="<?php echo $waktu_awal2; ?>" maxlength="2" required="required">
                </td>
              </tr>
              <tr>
                <td align="left" width="15%" class="bg-grid">
                  <b>Waktu Akhir</b>
                </td>
                <td class="bg-grid">
                  <input type="text" name="akhir1" style="width:5%; text-align: center;" class="input-wrc" value="<?php echo $waktu_akhir1; ?>" maxlength="2" required="required"> : <input type="text" name="akhir2" style="width:5%; text-align: center;" class="input-wrc" value="<?php echo $waktu_akhir2; ?>" maxlength="2" required="required">
                </td>
              </tr>
              <tr>
                <td align="left" width="15%">
                  <b>Keterangan</b><br>
                  <span style="font-size: 10px; font-style: italic; color: red;">
                    * isikan nama dan lokasi acara, jika ruangan diluar gedung Windu atau belum terdaftar
                  </span>
                </td>
                <td>
                  <textarea name="keterangan" style="width:100%" class="input-area-wrc"><?php echo $keterangan; ?></textarea>
                </td>
              </tr>
              <tr>
                <td align="left" width="15%" class="bg-grid">
                  <b>Nota Dinas Pengajuan Snack/MaMin</b><br>
                  <span style="font-size: 10px; font-style: italic; color: red;">
                    * Upload jika snack/MaMin dari Sub Bagian Umum
                  </span>
                </td>
                <td class="bg-grid">
                  <?php 
                  //  var_dump(file_exists('assets/ossrba/bap/BAP_'.$id.'.pdf'));die;
                  if(file_exists('assets/ruangan/notdin/NOTAMAMIN_'.$id.'.pdf')) {
                    echo "<a href='".base_url()."ruangan/unduh_naskah/".$id."' style='color:blue;' target='_blank' title='Unduh Berkas'>Berkas Siap</a>&nbsp;"; ?>
                    <button name="button" type="button" class="button-wrc" onclick="if (confirm('Yakin Hapus Berkas?')) parent.location='<?php echo base_url(). "ruangan/hapus_notdin/".$id; ?>'">X</button>
                    <?php 
                  }else{
                    ?>
                    <input type="file" name="file_srt" id="fileToUpload" class="submit-wrc" value="Pilih file" accept=".pdf">
                    <?php
                  }
                  ?>
                </td>
              </tr>
              <tr>
                <td align="left" width="15%">
                  <b>Link Absensi</b>
                </td>
                <td>
                  <b><?php
                  	$xid = $id;
                  	if($xid == ''){$xid = '????';}
                    echo $_SERVER['REQUEST_SCHEME'] .'://'. $_SERVER['HTTP_HOST'].'/kehadiran/Absensi/index/'.$xid; 
                  ?></b>
                </td>
              </tr>  
              <?php 
              $iduser       = $this->session->userdata('id_auth');
              if($this->username != 'Guest'){ 
                $pegawai = $this->m_ruangan->get_data_pegawai(); 
                ?>
                <tr>
                  <td align="left" width="15%" rowspan='2'>
                	  <b>Pilih Pegawai</b><br>
                    <span style="font-size: 10px; font-style: italic; color: red;">
                      * Pilih pegawai yang ditugaskan mengisi laporan atau notulensi kegiatan
                    </span>
                  </td>
                  <td>
                    <div class="dropdown">
                      <button type="button" onclick="toggleDropdown()" class="dropbtn">Pilih Pegawai</button>
                      <div id="myDropdown" class="dropdown-content">
                        <input type="text" id="searchInput" onkeyup="filterFunction()" placeholder="Cari pegawai...">
                        <?php
                        foreach ($pegawai as $data): 
                          ?>
                          <label>
                            <input type="checkbox" name="pegawai[]" value="<?php echo $data->id ?>"><?php echo $data->n_pegawai ?>
                          </label>
                          <?php
                        endforeach;
                        ?>
                      </div>
                    </div>
                    <!-- <div id="selectedEmployees">
                      <strong>Pegawai yang dipilih:</strong>
                      <div id="selectedList"></div>
                    </div> -->
                  </td>
                </tr>  
                <?php
              }else{
              	?>
                <tr>
                  <td align="left" width="15%" class="bg-grid">
                    <b>Token</b>
                  </td>
                  <td class="bg-grid">
                    <input type="text" name="token" style="width:10%" class="input-wrc" value="<?php echo $token; ?>" required="required">
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
      <?php 
      if($step == "simpan"){
        ?>
        <input type="submit" name="submit" value="Simpan" class="submit-wrc" content="Simpan">
        <?php
      }else{
        ?>
        <input type="submit" name="submit" value="Ubah" class="submit-wrc" content="Ubah">
        <?php
      }
      ?>
      <span></span>
      <button name="button" type="button" class="button-wrc" onclick="parent.location='<?php echo site_url('ruangan'); ?>'">Batal</button>
    </div>
  </form>
  </div>
  <br style="clear: both;" />
</div>


<!-- ... Kode HTML setelahnya ... -->

<script>
  $(document).ready(function() {
    // Inisialisasi DataTables pada tabel
    $('#myTable').DataTable();

    // Fungsi pencarian
    function filterTable(tableId, className, filter) {
      var input, table, tr, td, i, txtValue;
      input = filter || document.getElementById("myInput");
      table = document.getElementById(tableId);
      tr = table.getElementsByTagName("tr");

      for (i = 0; i < tr.length; i++) {
        var found = false;
        td = tr[i].getElementsByClassName(className);

        for (var j = 0; j < td.length; j++) {
          txtValue = td[j].textContent || td[j].innerText;
          if (txtValue.toUpperCase().indexOf(input.value.toUpperCase()) > -1) {
            found = true;
            break;
          }
        }

        if (found) {
          tr[i].style.display = "";
        } else {
          tr[i].style.display = "none";
        }
      }
    }

    // Event listener untuk input pencarian
    $('#myInput').on('keyup', function() {
      filterTable('myTable', 'search', this);
    });
  });
  function closeModal() {
    var modal = document.getElementById('pegawaiModal');
    modal.style.display = 'none';
  }
  
  function searchOptions() {
    var input, filter, checkboxes, checkbox, text;
    input = document.getElementById('searchInput');
    filter = input.value.toUpperCase();
    checkboxes = document.querySelectorAll('#pegawaiModal input[type="checkbox"]');
  
    checkboxes.forEach(function(checkbox) {
      text = checkbox.nextElementSibling.textContent || checkbox.nextElementSibling.innerText;
      checkbox.style.display = (text.toUpperCase().indexOf(filter) > -1) ? '' : 'none';
    });
  }
  
  
    function filterTable(tableId, className) {
      var input, filter, table, tr, td, i, txtValue;
      input = document.getElementById("myInput");
      filter = input.value.toUpperCase();
      table = document.getElementById(tableId);
      tr = table.getElementsByTagName("tr");
  
      for (i = 0; i < tr.length; i++) {
        var found = false;
        td = tr[i].getElementsByClassName(className);
        
        for (var j = 0; j < td.length; j++) {
          txtValue = td[j].textContent || td[j].innerText;
          if (txtValue.toUpperCase().indexOf(filter) > -1) {
            found = true;
            break;
          }
        }
  
        if (found) {
          tr[i].style.display = "";
        } else {
          tr[i].style.display = "none";
        }
      }
    }
  
    
  
  
  document.addEventListener('DOMContentLoaded', function() {
      // Daftar opsi pegawai
      var pegawaiOptions = <?php echo json_encode($pegawai); ?>;
      // var pegawaiOptions = [{
      //   'test' => 'test'
      // }];
  
      // Dapatkan elemen modal
      var modal = document.getElementById('pegawaiModal');
  
      // Tambahkan opsi checkbox ke modal
      // pegawaiOptions.forEach(function(pegawai) {
      //     var checkbox = document.createElement('input');
      //     checkbox.type = 'checkbox';
      //     checkbox.name = 'pegawai[]';
      //     checkbox.value = pegawai.id;
  
      //     var label = document.createElement('label');
      //     label.appendChild(checkbox);
      //     label.appendChild(document.createTextNode(pegawai.n_pegawai));
  
      //     modal.querySelector('.modal-content').appendChild(label);
      // });
  
      // Dapatkan elemen tombol untuk membuka modal
      var openModalBtn = document.getElementById('openModalBtn');
  
      // Tampilkan modal saat tombol dibuka
      openModalBtn.addEventListener('click', function() {
          modal.style.display = 'block';
      });
  
      // Tutup modal jika klik di luar modal
      window.addEventListener('click', function(event) {
          if (event.target == modal) {
              modal.style.display = 'none';
          }
      });
  });
  
  function closeModal() {
      var modal = document.getElementById('pegawaiModal');
      modal.style.display = 'none';
  }
  
  function searchOptions() {
      var input, filter, checkboxes, checkbox, text;
      input = document.getElementById('searchInput');
      filter = input.value.toUpperCase();
      checkboxes = document.querySelectorAll('#pegawaiModal input[type="checkbox"]');
  
      checkboxes.forEach(function(checkbox) {
          text = checkbox.nextElementSibling.textContent || checkbox.nextElementSibling.innerText;
          checkbox.style.display = (text.toUpperCase().indexOf(filter) > -1) ? '' : 'none';
      });
  }
  
  
  // script.js
  function toggleDropdown() {
      document.getElementById("myDropdown").classList.toggle("show");
  }
  
  function filterFunction() {
      var input, filter, dropdown, labels, i;
      input = document.getElementById("searchInput");
      filter = input.value.toUpperCase();
      dropdown = document.getElementById("myDropdown");
      labels = dropdown.getElementsByTagName("label");
  
      for (i = 0; i < labels.length; i++) {
          var text = labels[i].textContent || labels[i].innerText;
          if (text.toUpperCase().indexOf(filter) > -1) {
              labels[i].style.display = "";
          } else {
              labels[i].style.display = "none";
          }
      }
  }
  
  function updateSelection() {
      var dropdown = document.getElementById("myDropdown");
      var selectedList = document.getElementById("selectedList");
      var checkboxes = dropdown.querySelectorAll("input[type=checkbox]");
      var selectedEmployees = [];
  
      checkboxes.forEach(function(checkbox) {
          if (checkbox.checked) {
              var label = checkbox.nextElementSibling.textContent;
              selectedEmployees.push(label);
          }
      });
  
      selectedList.innerHTML = selectedEmployees.join('<br>');
  }
  
  // Close the dropdown if the user clicks outside of it
  window.onclick = function(event) {
      var dropdown = document.getElementById("myDropdown");
      if (!event.target.matches('.dropbtn') && !dropdown.contains(event.target)) {
          if (dropdown.classList.contains('show')) {
              dropdown.classList.remove('show');
          }
      }
  }
  
</script>
<style>
/* styles.css */
.dropdown {
    position: relative;
    display: inline-block;
}

.dropbtn {
    background-color: #4CAF50;
    color: white;
    padding: 10px;
    font-size: 16px;
    border: none;
    cursor: pointer;
}

.dropdown-content {
    display: none;
    position: absolute;
    background-color: #f9f9f9;
    min-width: 200px; /* Sesuaikan lebar sesuai kebutuhan */
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    z-index: 1;
}

.dropdown-content input[type=text] {
    box-sizing: border-box;
    width: 100%;
    padding: 10px;
    border: 1px solid #ddd;
    margin-bottom: 10px;
}

.dropdown-content label {
    display: block;
    padding: 8px 16px;
}

.dropdown-content input[type=checkbox] {
    margin-right: 10px;
}

.dropdown-content label:hover {
    background-color: #f1f1f1;
}

.dropdown-content.show {
    display: block;
}

#selectedEmployees {
    margin-top: 20px;
}

#selectedList {
    margin-top: 10px;
}

</style>

<!-- ... Kode HTML setelahnya ...
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script> -->

<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script>
  $(function() {
    $("#tanggal_pakai").datepicker({
      dateFormat: "yy-mm-dd",  // Format tanggal YYYY-MM-DD
      changeMonth: true,
      changeYear: true
    });
  });

  $(document).ready(function() {
    $('#ruanganSelect').change(function() {
      var selectedOption = $(this).find(':selected');
      var imagesString = selectedOption.data('images'); // Ambil string gambar
      var imageContainer = $('#imageContainer');

      imageContainer.empty(); // Kosongkan div sebelum menampilkan gambar baru

      if (imagesString) {
        var imageUrls = imagesString.split(','); // Ubah string menjadi array
        imageUrls.forEach(function(url) {
          if (url.trim() !== '') {
            var imgElement = $('<img>').attr('src', url.trim())
                                       .css({
                                         width: 'auto', 
                                         height: '150px', 
                                         objectFit: 'cover', 
                                         border: '1px solid #ccc', 
                                         padding: '5px',
                                         borderRadius: '10px'
                                       });
            imageContainer.append(imgElement);
          }
        });
      }
    });

    // Menampilkan gambar saat halaman pertama kali dimuat jika ada ruangan yang sudah dipilih
    $('#ruanganSelect').trigger('change');
  });
</script>
