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

  
<!-- <script src="https://code.responsivevoice.org/responsivevoice.js?key=jQZ2zcdq"></script> -->
<script src="https://code.responsivevoice.org/responsivevoice.js?key=KQ3jY54s"></script>
</head>
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
    <div style="margin: 10px">
        <a href="invesment/landing_page"><button class="button-wrc">Setting Landing Page</button></a>
    </div>
    <div id="tabs">
      <ul>
        <li><a href="#tabs-1">List Content</a></li>
        <li><a href="#tabs-2">Setting Event</a></li>
        <li><a href="#tabs-3">attendance list</a></li>
        <li><a href="#tabs-4">Data WJIS</a></li>

      </ul>
        <div id="tabs-1">
            <div id="content">
                  <div class="post">
                    <div class="title">
                      <?php echo $this->lib_date->view_title($page_name); ?>
                    </div>
                    <div class="entry">
                        <div style="display: flex; flex-direction: row; align-items: center;">
                            <div style="margin-left: auto;"> <!-- Bagian kanan, tombol -->
                                <button name="button" type="button" value="Checkout Barang" class="button-wrc" onclick="parent.location='<?= $master_url ?>/<?= $routees ?>info/invesment/create'">Tambah Data</button>
                            </div>
                        </div>
                        <table cellpadding="0" cellspacing="0" border="0" class="display" id="pendataan">
                          <thead>
                            <tr>
                              <th width="2%">No</th>
                              <th width="13%">Judul Investasi</th>
                              <th width="40%">Mini Deskripsi</th>
                              <th width="20%">Lokasi</th>
                              <th width="10%">Long<br>Lat</></th>
                              <th width="10%">Image</th>
                              <th width="5%">Action</th>
                            </tr>
                          </thead>
                          <tbody id="table-body">
                            <?php
                            // Misalkan $data adalah array yang berisi data investasi
                            foreach ($data as $index => $investasi) {
                              ?>
                              <tr>
                                <td><?php echo $index + 1; ?></td>
                                <td><?php echo $investasi->judul_investasi; ?></td>
                                <td><?php echo $investasi->mini_deskripsi; ?></td>
                                <td><?php echo $investasi->lokasi; ?></td>
                                <td><?php echo $investasi->long.'<br>'.$investasi->lat; ?></td>
                                <td>
                                  <button class="openModalBtn" data-modal="<?php echo $index; ?>" style="background-color: transparent; border: 0;">
                                      <img src="<?php echo "$master_url/$routees_portal"."investasi-jabar/src/assets/invest/thumbnail/" . $investasi->image ?>" width="100px">
                                  </button>
                                  <!-- Modal -->
                                  <div id="modal<?php echo $index; ?>" class="modal">
                                      <div class="modal-content">
                                          <span class="close" data-modal="<?php echo $index; ?>">&times;</span>
                                          <center>
                                              <img src="<?php echo "$master_url"."$routees_portal"."investasi-jabar/src/assets/invest/thumbnail/" . $investasi->image ?>" width="1050px">
                                          </center>
                                      </div>
                                  </div>
                                </td>
                                <td><button class="action-button">Action</button></td>
                              </tr>
                            <?php } ?>
                          </tbody>
                        </table>
                    </div>
                  <br style="clear: both;" />
                </div>
           </div>
        </div>
        <div id="tabs-2">
            <div class="title">
              <?php echo $this->lib_date->view_title($page_name_setting); ?>
            </div>
            <div class="entry">
                <div style="display: flex; flex-direction: row; align-items: center;">
                    <div style="margin-left: auto;"> <!-- Bagian kanan, tombol -->
                        <button name="button" type="button" value="Checkout Barang" class="button-wrc" onclick="parent.location='<?= $master_url ?>/<?= $routees ?>info/invesment/create_event_setting'">Tambah Data</button>
                    </div>
                </div>
                <table cellpadding="0" cellspacing="0" border="0" class="display" id="setting" style="text-align: center;">
                    <thead>
                        <tr>
                            <th width="2%">No</th>
                            <th width="13%">Nama Event</th>
                            <th width="40%">Status Izin</th>
                            <th width="40%">Jumlah</th>
                            <th width="40%">aksi</th>
                            </tr>
                    </thead>
                    <tbody id="table-body">
                    <?php foreach ($data_setting as $index => $investasi) { ?>
                        <tr>
                            <td><?php echo $index + 1; ?></td>
                            <td><?php echo $investasi->nama_event; ?></td>

                            <td>
                                <input type="checkbox" class="izin-checkbox" data-id="1" <?php echo $investasi->status_setting_event ? 'checked' : ''; ?>>
                            </td>
                            <td><?php echo $investasi->jumlah; ?></td>
                            <td valign='center'>
                                <?php
                                $img_edit = array('src' => 'assets/images/icon/property.png',
                                                  'alt' => 'Edit'.' -> '.$investasi->nama_event,
                                                  'title' => 'Edit'.' -> '.$investasi->nama_event,
                                                  'border' => '0',
                                                 );
                                // $confirm_text = 'Apakah Anda yakin akan menghapus '.$investasi->full_name.'?';
                                // $img_delete = array('src' => 'assets/images/icon/cross.png',
                                //                     'alt' => 'Delete'.' -> '.$investasi->full_name,
                                //                     'title' => 'Delete'.' -> '.$investasi->full_name,
                                //                     'border' => '0',
                                //                     'onClick' => 'return confirm_link(\''.$confirm_text.'\')',
                                //                    );
                                    echo anchor(site_url('info/invesment/edit_event_setting')."/".$investasi->id, img($img_edit))."&nbsp;";
                                    // echo anchor(site_url('info/invesment/delete')."/".$investasi->id, img($img_delete))."&nbsp;";

                                ?>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>

            </div>
        </div>
         <div id="tabs-3">
            <div class="title">
              <?php echo $this->lib_date->view_title($page_name_attedance); ?>
            </div>
            <div class="entry">
                <div style="display: flex; flex-direction: row; align-items: center;">
                    <div style="margin-left: auto;"> <!-- Bagian kanan, tombol -->
                        <button name="button" type="button" value="Checkout Barang" class="button-wrc" onclick="parent.location='<?= $master_url ?>/<?= $routees ?>info/invesment/create'">Tambah Data</button>
                    </div>
                </div>
                <table cellpadding="0" cellspacing="0" border="0" class="display" id="get_attedance" style="text-align: center;">
                    <thead>
                        <tr>
                            <th width="2%">No</th>
                            <th width="13%">Full Name</th>
                            <th width="40%">email</th>
                            <th width="40%">aksi</th>


                        </tr>
                    </thead>
                    <tbody id="table-body">
                    <?php foreach ($data_attedance as $index => $investasi) { ?>
                        <tr>
                            <td><?php echo $index + 1; ?></td>
                            <td><?php echo $investasi->full_name; ?></td>
                            <td><?php echo $investasi->email; ?></td>
                            <td valign='top'>
                                <?php
                                $img_edit = array('src' => 'assets/images/icon/property.png',
                                                  'alt' => 'Edit'.' -> '.$investasi->full_name,
                                                  'title' => 'Edit'.' -> '.$investasi->full_name,
                                                  'border' => '0',
                                                 );
                                $confirm_text = 'Apakah Anda yakin akan menghapus '.$investasi->full_name.'?';
                                $img_delete = array('src' => 'assets/images/icon/cross.png',
                                                    'alt' => 'Delete'.' -> '.$investasi->full_name,
                                                    'title' => 'Delete'.' -> '.$investasi->full_name,
                                                    'border' => '0',
                                                    'onClick' => 'return confirm_link(\''.$confirm_text.'\')',
                                                   );
                                    echo anchor(site_url('info/invesment/edit')."/".$investasi->id, img($img_edit))."&nbsp;";
                                    echo anchor(site_url('info/invesment/delete')."/".$investasi->id, img($img_delete))."&nbsp;";

                                ?>
                            </td>

                        </tr>
                    <?php } ?>
                    </tbody>
                </table>

            </div>
        </div>
        <div id="tabs-4"> <!--Project-->
            <div id="content">
            <div class="post">
                <div class="entry">
                <div style="display: flex; flex-direction: row; align-items: center;">
                    <div style="margin-left: auto;"> <!-- Bagian kanan, tombol -->
                    <button name="button" type="button" value="Checkout Barang" class="button-wrc" onclick="parent.location='https://dpmptsp.jabarprov.go.id/jelita/backoffice/info/invesment/create'">Tambah Data</button>
                    </div>
                </div>
                <table cellpadding="0" cellspacing="0" border="0" class="display" id="Project">
                    <thead>
                    <tr>
                        <th width="2%">No</th>
                        <th width="13%">Judul Investasi</th>
                        <th width="40%">Mini Deskripsi</th>
                        <th width="20%">Lokasi</th>
                        <th width="10%">Long<br>Lat</></th>
                        <th width="10%">Image</th>
                        <th width="5%">Action</th>
                    </tr>
                    </thead>
                    <tbody id="table-body">
                    <?php
                    foreach ($data as $index => $investasi) {
                        ?>
                        <tr>
                        <td valign='top'><?php echo $index + 1; ?></td>
                        <td valign='top'><?php echo $investasi->judul_investasi; ?></td>
                        <td valign='top'><?php echo $investasi->mini_deskripsi; ?></td>
                        <td valign='top'><?php echo $investasi->lokasi; ?></td>
                        <td valign='top'><?php echo $investasi->long.'<br>'.$investasi->lat; ?></td>
                        <td valign='top'>
                            <button class="openModalBtn" data-modal="<?php echo $index; ?>" style="background-color: transparent; border: 0;">
                            <img src="<?php echo "$master_url/$routees_portal/investasi-jabar/src/assets/invest/thumbnail/" . $investasi->image ?>" width="100px">
                            </button>
                            <!-- Modal -->
                            <div id="modal<?php echo $index; ?>" class="modal">
                            <div class="modal-content">
                                <span class="close" data-modal="<?php echo $index; ?>">&times;</span>
                                <center>
                                <img src="<?php echo "$master_url/$routees_portal/investasi-jabar/src/assets/invest/thumbnail/" . $investasi->image ?>" width="1050px">
                                </center>
                            </div>
                            </div> 
                        </td>
                        
                        <td valign='top'>
                            <input type="checkbox" class="izin-content" data-id="<?php echo $investasi->invest_id ?>" <?php echo $investasi->status_content ? 'checked' : ''; ?>>
                        </td>
                        </tr>
                        <?php
                    }
                    ?>
                    </tbody>
                </table>
                </div>
                <br style="clear: both;" />
            </div>
            </div>
        </div>
  <br style="clear: both;" />
</div>
<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
<script>
$(document).ready(function() {
    // Event listener untuk checkbox
    $('.izin-checkbox').change(function() {
        var id = 1; // ID yang Anda inginkan, bisa diganti dengan logika atau data lain
        var checked = $(this).is(':checked') ? 1 : 0;

        console.log('ID:', id); // Tambahkan ini untuk debug
        console.log('Status Izin:', checked); // Tambahkan ini untuk debug

        // URL sesuai dengan pola yang diinginkan
        var url = '<?= $master_url ?>/<?= $routees ?>info/invesment/update_setting_event/' + id + '/' + checked;
        console.log('url:', url); // Tambahkan ini untuk debug

        // Kirim data ke server menggunakan AJAX
        $.ajax({
            url: url,
            type: 'POST', // Atau sesuaikan dengan metode yang dibutuhkan
            success: function(response) {
                if (response === 'success') {
                    alert('Status izin telah diperbarui.');
                } else {
                    alert('Gagal memperbarui status izin: ' + response);
                }
            },
            error: function(xhr, status, error) {
                alert('Terjadi kesalahan: ' + error);
            }
        });
    });
});
</script>

<script>
$(document).ready(function() {
    // Event listener untuk checkbox
    $('.izin-content').change(function() {
        var id = 1; // ID yang Anda inginkan, bisa diganti dengan logika atau data lain
        var checked = $(this).is(':checked') ? 1 : 0;

        console.log('ID:', id); // Tambahkan ini untuk debug
        console.log('Status Izin:', checked); // Tambahkan ini untuk debug

        // URL sesuai dengan pola yang diinginkan
        var url = '<?= $master_url ?>/<?= $routees ?>info/invesment/update_status_content/' + id + '/' + checked;
        console.log('url:', url); // Tambahkan ini untuk debug

        // Kirim data ke server menggunakan AJAX
        $.ajax({
            url: url,
            type: 'POST', // Atau sesuaikan dengan metode yang dibutuhkan
            success: function(response) {
                if (response === 'success') {
                    alert('Status izin telah diperbarui.');
                } else {
                    alert('Gagal memperbarui status izin: ' + response);
                }
            },
            error: function(xhr, status, error) {
                alert('Terjadi kesalahan: ' + error);
            }
        });
    });
});
</script>


<script>
  // Temukan semua elemen dengan kelas "openModalBtn" dan tambahkan event listener
var modalBtns = document.querySelectorAll('.openModalBtn');

modalBtns.forEach(function(btn) {
    btn.addEventListener('click', function() {
        var modalId = btn.getAttribute('data-modal'); // Dapatkan ID modal dari atribut data-modal

        // Temukan modal dengan ID yang sesuai
        var modal = document.getElementById('modal' + modalId);

        // Tampilkan modal
        modal.style.display = "block";

        // Saat pengguna mengklik tombol penutup, sembunyikan modal
        var closeBtn = modal.querySelector('.close');
        closeBtn.addEventListener('click', function() {
            modal.style.display = "none";
        });

        // Saat pengguna mengklik di luar modal, sembunyikan modal
        window.addEventListener('click', function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        });
    });
});

</script>