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
  </style>

  
<!-- <script src="https://code.responsivevoice.org/responsivevoice.js?key=jQZ2zcdq"></script> -->
<script src="https://code.responsivevoice.org/responsivevoice.js?key=KQ3jY54s"></script>
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
        echo form_open('pengembangan/nib/');
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
            echo "Export Data Tamu (Excel) <br>";
            echo anchor(site_url('pengembangan/nib/cetak_excel').'/'.(!empty($tgla) && !empty($tglb) ? $tgla.'/'.$tglb : '0/0'), img($img_cetak_excel));
            ?>
        </div>
        <div style="margin-left: auto;"> <!-- Bagian kanan, tombol -->
            <button name="button" type="button" value="Checkout Barang" class="button-wrc" onclick="parent.location='https://dpmptsp.jabarprov.go.id/jelita/backoffice/pengembangan/nib/nib_tidak_langsung'">Pelayanan Pembuatan Nomor Induk Berusaha (NIB) (Tidak Langsung)</button>
        </div>
    </div>


     
      <table cellpadding="0" cellspacing="0" border="0" class="display" id="pendataan">
        <thead>
          <tr>
            <th width="2%">No</th>
            <th width="13%">KBLI<br>No. WhatsApp<br>Tanggal Input</th>
            <th width="10%">Nama<br>NIK<br>Email</th>
            <th width="20%">Petugas KBLI<br>Petugas NIB<br>Lokasi Event</th>
            <th width="35%">Petugas Pengubah Data<br>Tanggal<br>Layanan</th>
            <th width="5%">No Antri</th>
            <th width="10%">Foto KTP</th>
            <th width="5%">Action</th>
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
                <?php echo $b.$this->m_nib->get_n_pegawai($row->petugas_kbli); ?><br>
                <?php echo $b.$this->m_nib->get_n_pegawai($row->petugas_nib); ?><br>
                <?php echo $b.$row->lokasi_event; ?><br>
              </td>
              <td>
                <?php echo $b.$this->m_pengembangan->get_n_user($row->user); ?><br>
                <?php // Tanggal awal dalam format string
                $dateString = $row->tanggal;
                $newFormat = '-';//date("d F Y H:i", strtotime($dateString));
                echo $b.$newFormat; // Output: 25 April 2024 10:35 ?><br>
                <?php echo $b.$row->layanan; ?><br>
              </td>
              <td>
                <center>
                  <label for="">Antrian Ke : <b><?php echo $b.$row->no_antri; ?></b></label><br><br>
                  <?php
                  if($row->status_panggil != '2') {
                    // if($row->user_manggil == $iduser || $row->user_manggil == NULL){s
                    ?>
                      <!-- <form action="/jelita/backoffice/pengembangan/nib/status_mic/<?php echo $row->id; ?>/<?php echo $row->no_antri; ?>" method="POST">
                        <input type="hidden" name="tgla" value="<?= $tgla ?>">
                        <input type="hidden" name="tglb" value="<?= $tglb ?>">
                        <button type="submit" style="border: none; background: none; padding: 0;">
                            <img src="https://png.pngtree.com/png-clipart/20230510/original/pngtree-microphone-icon-illustration-cartoon-design-png-image_9155706.png" alt="" width="50px">
                        </button>
                    </form> -->
                    <button onclick="speakText(<?php echo $row->no_antri; ?>)" class="button-no-border"><img src="https://png.pngtree.com/png-clipart/20230510/original/pngtree-microphone-icon-illustration-cartoon-design-png-image_9155706.png" alt="" width="50px"></button>
                    <!-- <a href="/jelita/backoffice/pengembangan/nib/status_mic/<?php echo $row->id; ?>/<?php echo $row->no_antri; ?>"><img src="https://png.pngtree.com/png-clipart/20230510/original/pngtree-microphone-icon-illustration-cartoon-design-png-image_9155706.png" alt="" width="50px"></a> -->
                    <?php 
                    // $mic = $this->m_nib->on_mic($row->id);
                    // if($mic != NULL){ 
                      ?>
                    <!-- <a href="/jelita/backoffice/pengembangan/nib/mute_mic/<?php echo $mic; ?>"><img src="https://png.pngtree.com/png-vector/20220624/ourmid/pngtree-phone-microphone-off-mute-mic-png-image_5327162.png" alt="" width="50px"></a> -->
                    <?php
                  //   }
                  //   }else{
                  //   $panggil = $this->m_nib->cek_status($row->id, $iduser);
                  //   $idpegawai = $this->m_pengembangan->get_user_id($panggil);
                  //   $npegawai = $this->m_nib->get_n_pegawai($idpegawai);
                  //   echo $b."Peserta Sudah di panggil oleh ".$npegawai.$be;
                  // }
                  }
                  ?>
                </center>
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
                <?php if($row->user_manggil == $iduser || $row->user_manggil == NULL){ ?>
                <a href="/jelita/backoffice/pengembangan/nib/edit_nib/<?php echo $row->id; ?>"><img src="https://cdn-icons-png.flaticon.com/512/266/266146.png" alt="" width="20px"></a>
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
                        setInterval(fetchData, 15000);
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
      // Get the button elements that open the modal
      const openModalButtons = document.querySelectorAll(".openModalBtn");

      // Loop through each button and attach click event listener
      openModalButtons.forEach(function(btn) {
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
