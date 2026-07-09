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
  </style>
  
<script src="https://code.responsivevoice.org/responsivevoice.js?key=jQZ2zcdq"></script>
</head>
<div id="content">
  <div class="post">
    <div class="title">
      <?php echo $this->lib_date->view_title($page_name); ?>
    </div>

    <div class="entry">
      <fieldset>
        <legend>Filter Data Tanggal Input NIB</legend>
        <?php
        echo form_open('pengembangan/nib/nib_tidak_langsung');
        $periodeawal_input = array('name'  => 'tgla',
                                   'value' => $tgla,
                                   'class' => 'input-wrc',
                                   'readOnly'=>TRUE,
                                   'class' => 'monbulan'
                                  );
        $periodeakhir_input = array('name'  => 'tglb',
                                    'value' => $tglb,
                                    'class' => 'input-wrc',
                                    'readOnly'=>TRUE,
                                    'class' => 'monbulan'
                                   );
        $filter_data = array('name' => 'button',
                             'class' => 'button-wrc',
                             'content' => 'Cari Data',
                             'value' => 'Cari Data'
                            );
        $img_cetak_excel = array('src' => base_url().'assets/images/icon/excel.png',
                                 'alt' => 'Cetak Excel',
                                 'title' => 'Cetak Excel'
                                 // 'onclick' => 'window.open(\''.site_url('pengembangan/cetak_excel').'\')'
                                );
        ?>
        
        <table>
          <tr width="100%">
            <td> <?php echo 'Tanggal Pakai Awal : ' . form_input($periodeawal_input); ?> </td>
            <td> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td> <?php echo 'Tanggal Pakai Akhir : '. form_input($periodeakhir_input); ?> </td>
            <td> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td width="55%"> <?php echo form_submit($filter_data);?> </td>
            <!-- <td> <?php echo form_submit($img_cetak_excel);?> </td> -->
            
            <?php $antrian = 23; ?>
            <?php
            $iduser = $this->session->userdata('id_auth');
            if ($iduser == 626 ) {
              
                echo anchor(site_url('pengembangan/cetak_excel'),img($img_cetak_excel));
            }
            echo form_hidden('kd_filter', '2');
            echo form_close();
            ?>
            <td> <h1 for="" style="text-align:right; color:red;"><a href="#" id="openModalBtn" title="Ubah Meja/Loket">Loket</a> <?php echo $this->m_nib->get_user_loket($iduser); ?></h1> <br></td>
            <div id="myModal" class="modal">
              <div class="modal-content">
                <span class="close">&times;</span>
                <form action="nib/edit_loket" method="POST">
                  <center>
                  <label for="ubah">Masukan Nomor Loket/Meja</label>
                  <input type="hidden" name="id" class="input-wrc" value="<?php echo $iduser; ?>">
                  <input type="number" name="loket" class="input-wrc" value="<?php $loket = $this->m_nib->get_user_loket($iduser); echo $loket; ?>"><br>
                  <input type="submit" class="button-wrc" value="Simpan">
                  </center>
                </form>
              </div>
            </div>
          </tr>
        </table>
        <!-- <a href=""><button class="button-wrc">Setting Meja</button></a> -->
      </fieldset>
    </div>
    
    <?php 
    $alert = $this->session->flashdata("sukses");
    if(!empty($alert)){
      ?>
      <br>
      <div style="color: green; font-size: 12px; margin-left: 20px; margin-bottom: 10px; font-weight: bold;"><center><?php echo $alert; ?></center></div>
      <?php
    }
    ?>

    <?php 
    $alert = $this->session->flashdata("gagal");
    if(!empty($alert)){
      ?>
      <br>
      <div style="color: red; font-size: 12px; margin-left: 20px; margin-bottom: 10px; font-weight: bold;"><center><?php echo $alert; ?></center></div>
      <?php
    }
    ?>
    
    <div class="entry">
    <div style="display: flex; flex-direction: row; align-items: center;">
        <div style="flex: 1;"> <!-- Bagian kiri, mengambil sebagian besar ruang -->
            <?php 
            $tipe_rekap = "";
            $id = "";
            $jenis_jumlah="";
            $img_cetak_excel = array(
                'src' => base_url().'assets/images/icon/excel.png',
                'alt' => 'Cetak Excel',
                'title' => 'Cetak Detail ke Excel'
            );
            echo "Export Data Pelayanan Pembuatan Nomor Induk Berusaha (Tidak Langsung) (Excel) <br>";
            echo anchor(site_url('pengembangan/nib/cetak_excel_nib_tidak_langsung').'/'.(!empty($tgla) && !empty($tglb) ? $tgla.'/'.$tglb : '0/0'), img($img_cetak_excel));
            ?>
        </div>
        <div style="margin-left: auto;"> <!-- Bagian kanan, tombol -->
            <button name="button" type="button" value="Checkout Barang" class="button-wrc" onclick="parent.location='https://dpmptsp.jabarprov.go.id/jelita/backoffice/pengembangan/nib'">Kembali Ke Halaman Sebelumnya</button>
        </div>
    </div>


     
      <table cellpadding="0" cellspacing="0" border="0" class="display" id="pendataan">
        <thead>
          <tr>
            <th width="">No</th>
            <th width="">KBLI<br>No. WhatsApp<br>Tanggal Input</th>
            <th width="">Nama<br>NIK<br>Email</th>
            <th width="">Tanggal Lahir<br>Alamat sesuai KTP<br> Kecamatan Sesuai KTP<br>Kelurahan Sesuai KTP</th>
            <th width="">Petugas KBLI<br>Petugas NIB<br>Lokasi Event</th>
            <th width="">Agen NIB<br>Petugas Pengubah Data<br>Tanggal<br>Layanan</th>
            <th width="">Kecamatan Tempat Usaha<br>Kelurahan Tempat Usaha<br>Kode Pos Tempat Usaha</th>
            <th width="">Foto KTP</th>
            <th width="">Action</th>
          </tr>
        </thead>
        <tbody>
          <?php 
          $i = 1;
          $belum = 1;
          foreach($list_pengembangan as $row){
            if($row->status_panggil == '0') {
              $b = '<span style="color: red">';
              $be = '</span>';
              $belum++; 
              //$c = '<br>Revisi : '.$row->revisi;
            }elseif($row->status_panggil == '1'){
              $b = '<span style="color: Blue">';
              $be = '</span>';
              // $c = '<br>'.$row->revisi; 
            }else{
              $b = '<span>';
              $be = '</span>';
              // $c = '<br>'.$row->revisi; 
            }
            ?>
            <tr>
              <td><?php echo  $i; ?></td>
              <td>
                <?php // echo $b.$row->nib; ?><br>
                <?php echo $b.$row->kbli; ?><br>
                <?php echo $b.$row->no_wa; ?><br>
                <?php echo $b.date("d F Y", strtotime($row->tanggal)); ?>
              </td>
              <td>
                <?php echo $b.$row->nama; ?><br>
                <?php echo $b.$row->nik; ?><br>
                <?php echo $b.$row->email; ?><br>
              </td>
              <td>
                <?php echo $b.$row->tanggal_lahir; ?><br>
                <?php echo $b.$row->alamat; ?><br>
                <?php echo $b.$row->kecamatan; ?><br>
                <?php echo $b.$row->kelurahan; ?><br>
              </td>
              <td>
                <?php echo $b.$this->m_nib->get_n_pegawai($row->petugas_kbli); ?><br>
                <?php echo $b.$this->m_nib->get_n_pegawai($row->petugas_nib); ?><br>
                <?php echo $b.$row->lokasi_event; ?><br>
              </td>
              <td>
                <?php echo $b.$row->Agen_Nib; ?><br>

                <?php echo $b.$this->m_pengembangan->get_n_user($row->user); ?><br>
                <?php // Tanggal awal dalam format string
                $dateString = $row->tanggal;
                $newFormat = '-';//date("d F Y H:i", strtotime($dateString));
                echo $b.$newFormat; // Output: 25 April 2024 10:35 ?><br>
                <?php echo $b.$row->layanan; ?><br>

              </td>
              <td>
                <?php echo $b.$row->kecamatan_usaha; ?><br>
                <?php echo $b.$row->kelurahan_usaha; ?><br>
                <?php echo $b.$row->kode_pos_tempat_usaha; ?><br>
              </td>
            
              <td>
                <?php
                if(file_exists($_SERVER['DOCUMENT_ROOT'] . "/nib/uploads/ktp/" . $row->file)){
                  ?>
                  <button class="openModalBtn" data-modal="<?php echo $i; ?>" style="background-color: transparent; border: 0;">
                  <img src="<?php echo "https://dpmptsp.jabarprov.go.id/nib/uploads/ktp/" . $row->file ?>" width="100px">
                  </button>
                  <!-- Modal -->
                  <div id="modal<?php echo $i; ?>" class="modal">
                    <div class="modal-content">
                      <span class="close" data-modal="<?php echo $i; ?>">&times;</span>
                      <center>
                      <img src="<?php echo "https://dpmptsp.jabarprov.go.id/nib/uploads/ktp/" . $row->file ?>" width="1050px">
                      </center>
                    </div>
                  </div>
                  <?php
                }
                ?>
              </td>
              <td>
                <?php if($row->user_manggil == $iduser || $row->user_manggil == NULL || $this->All || $this->enabled){ ?>
                <a href="/jelita/backoffice/pengembangan/nib/edit_nib_tidak_langsung/<?php echo $row->id; ?>"><img src="https://cdn-icons-png.flaticon.com/512/266/266146.png" alt="" width="20px"></a>
                <?php } ?>
                <?php
                    if($this->All){ 
                    $confirm_text = $this->session->userdata('username').', Apakah Anda yakin Menghapus Data? '.'?';
                    $img_sent = array('src' => 'https://cdn-icons-png.flaticon.com/512/860/860778.png',
                                        'width' => '20px', 
                                        'alt' => 'Hapus Data',
                                        'title' => 'Hapus Data',
                                        'border' => '0', 
                                        'onClick' => 'return confirm_link(\''.$confirm_text.'\')'
                                    );
                    echo anchor(site_url('pengembangan/nib/hapus_nib')."/".$row->id, img($img_sent))."&nbsp;";
                    ?>
                    <!--<a href="/jelita/backoffice/pengembangan/nib/hapus_nib/<?php echo $row->id; ?>"><img src="https://cdn-icons-png.flaticon.com/512/860/860778.png" alt="" width="20px"></a>-->
                    <?php
                    }
                ?>
                  <?php
                    if($this->All || $this->enabled){ 
                    // $confirm_text = $this->session->userdata('username').', Apakah Anda yakin Menghapus Data? '.'?';
                    $img_sent = array('src' => 'https://cdn.iconscout.com/icon/free/png-512/free-whatsapp-158-761636.png?f=webp&w=512',
                                        'width' => '20px', 
                                        'alt' => 'Kirim Pesan',
                                        'title' => 'Kirim Pesan',
                                        'border' => '0'
                                    );
                    echo anchor(site_url('pengembangan/nib/nib_tidak_langsung')."/".$row->id, img($img_sent))."&nbsp;";
                    ?>
                    <!--<a href="/jelita/backoffice/pengembangan/nib/hapus_nib/<?php echo $row->id; ?>"><img src="https://cdn-icons-png.flaticon.com/512/860/860778.png" alt="" width="20px"></a>-->
                    <?php
                    }
                ?>
              </td>
            </tr>
            <?php 
            $i++;
          }
          $jum=$i-1;
          $belum = $belum-1;
          echo '<div style="text-align:right">';
          if($belum == 0){
            echo '<span style="color: Blue"><b>'.'Jumlah Pemohon : '.$jum.',</b></span>&nbsp;&nbsp;';
            echo '<span style="color: Blue"><b>'.' Belum Dilayani : 0</b></span>&nbsp;&nbsp;';
          }else{
        	  echo '<span style="color: Blue"><b>'.'Jumlah Pemohon : '.$jum.',</b></span>&nbsp;&nbsp;';
        	  echo '<span style="color:  Red"><b>'.' Belum Dilayani : '.$belum.'</b></span>&nbsp;&nbsp;';
          }
          echo '</div>';
          ?>
        </tbody>
      </table>
    </div>
  </div>
  <br style="clear: both;" />
</div>


                      <script>
                      function speakText(no_antri) {
                        
                          // Pemanggilan fungsi speak dari ResponsiveVoice
                          responsiveVoice.speak("Nomor Antrian, " + no_antri + " , menuju, loket, <?php echo $loket; ?>", "Indonesian Female");
                      }
                      </script>
    <!-- Tambahkan jQuery dan JavaScript Bootstrap -->
    <script>
// Get the modal element
const modal = document.getElementById("myModal");

// Get the button element that opens the modal
const openModalButton = document.getElementById("openModalBtn");

// Get the <span> element that closes the modal
const closeModalSpan = document.getElementsByClassName("close")[0];

// When the user clicks on the button, open the modal
openModalButton.onclick = function() {
  modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
closeModalSpan.onclick = function() {
  modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target === modal) {
    modal.style.display = "none";
  }
}


      // Ambil semua tombol untuk menampilkan modal
var openModalBtns = document.querySelectorAll(".openModalBtn");

// Tambahkan event listener ke setiap tombol
openModalBtns.forEach(function(btn) {
    btn.addEventListener("click", function() {
        var modalId = this.getAttribute("data-modal");
        var modal = document.getElementById("modal" + modalId);
        modal.style.display = "block";
    });
});

// Ambil semua tombol untuk menutup modal
var closeBtns = document.querySelectorAll(".close");

// Tambahkan event listener ke setiap tombol penutup
closeBtns.forEach(function(btn) {
    btn.addEventListener("click", function() {
        var modalId = this.getAttribute("data-modal");
        var modal = document.getElementById("modal" + modalId);
        modal.style.display = "none";
    });
});
</script>
