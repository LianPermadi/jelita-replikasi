<head>
    <style>
        /* CSS untuk modal */
        .modal {
            display: none;
            /* sembunyikan modal secara default */
            position: fixed;
            /* posisikan modal di atas konten */
            z-index: 1;
            /* jadikan modal paling atas */
            left: 0;
            top: 0;
            width: 100%;
            /* lebar modal 100% */
            height: 100%;
            /* tinggi modal 100% */
            overflow: auto;
            /* aktifkan scroll jika isi modal melebihi ukuran layar */
            background-color: rgba(0, 0, 0, 0.4);
            /* efek gelap pada background */
        }

        /* CSS untuk konten modal */
        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 30%;
        }

        /* CSS untuk tombol close */
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
        .btn {
  border: 2px solid black;
  background-color: white;
  color: black;
  padding: 14px 28px;
  font-size: 16px;
  cursor: pointer;
}

/* Green */
.success {
  border-color: #04AA6D;
  color: green;
}

.success:hover {
  background-color: #04AA6D;
  color: white;
}

/* Blue */
.info {
  border-color: #2196F3;
  color: dodgerblue;
}

.info:hover {
  background: #2196F3;
  color: white;
}

/* Orange */
.warning {
  border-color: #ff9800;
  color: orange;
}

.warning:hover {
  background: #ff9800;
  color: white;
}

/* Red */
.danger {
  border-color: #f44336;
  color: red;
}

.danger:hover {
  background: #f44336;
  color: white;
}

/* Gray */
.default {
  border-color: #e7e7e7;
  color: black;
}

.default:hover {
  background: #e7e7e7;
}
  

button{
  color: blue;
}

.dropbtn {
  background-color: #4CAF50;
  color: blue;
  font-size: 12px;
  border: none;
  cursor: pointer;
}

.dropdown {
  position: relative;
  display: inline-block;
/*  color: blue;*/
}

.dropdown-content {
  display: none;
  position: absolute;
  background-color: #f9f9f9;
  min-width: 160px;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  z-index: 1;
}

.dropdown-content a {
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
}

.dropdown-content a:hover {background-color: #f1f1f1}

.dropdown:hover .dropdown-content {
  display: block;
}

.dropdown:hover .dropbtn {
  color: #3e8e41;
}
    </style>
</head>
<?php
$id_user      = $this->session->userdata('id_auth');
foreach ($check as $checks) {
    $user = $checks->id_user;
    $sta  = $checks->status;
}
if (!empty($user)) {
} else {
    $user = '0';
}

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


        <?php
        $alert = $this->session->flashdata("sukses");
        if (!empty($alert)) {
        ?>
            <br>
            <div style="color: green; font-size: 12px; margin-left: 20px; margin-bottom: 10px; font-weight: bold;">
                <center><?php echo $alert; ?></center>
            </div>
        <?php } ?>

        <?php
        $alert = $this->session->flashdata("gagal");
        if (!empty($alert)) {
        ?>
            <br>
            <div style="color: red; font-size: 12px; margin-left: 20px; margin-bottom: 10px; font-weight: bold;">
                <center><?php echo $alert; ?></center>
            </div>
        <?php } ?>
        <div class="entry">
            <?php
            $ctk_list = array(
                'name' => 'button',
                'content' => 'Daftar Barang',
                'value' => 'Daftar Barang',
                'class' => 'button-wrc',
                    'style' => 'background:#B0C4DE; color:black;',
                'onclick' => 'parent.location=\'' . site_url('permintaanbarang/pengajuan_barang') . '\''
            );
            echo form_button($ctk_list);
            ?>
            <?php
            $ctk_list = array(
                'name' => 'button',
                'content' => 'Checkout Barang',
                'value' => 'Checkout Barang',
                'class' => 'button-wrc',
                'onclick' => 'parent.location=\'' . site_url('permintaanbarang/checkout_barang') . '\''
            );
            echo form_button($ctk_list);
            ?>
            <?php
            $ctk_list = array(
                'name' => 'button',
                    'content' => 'List Permintaan Barang',
                    'value' => 'List Permintaan Barang',
                'class' => 'button-wrc',
                'onclick' => 'parent.location=\'' . site_url('permintaanbarang/list_permintaan') . '\''
            );
            echo form_button($ctk_list);
            ?>
            <?php
            $ctk_list = array(
                'name' => 'button',
                'content' => 'History Permintaan barang',
                'value' => 'History Permintaan barang',
                'class' => 'button-wrc',
                'onclick' => 'parent.location=\'' . site_url('permintaanbarang/log_permintaan') . '\''
            );
            echo form_button($ctk_list);
            ?>

            <div id="barang">
                <!--       <table>
        <tr>
        <td width="50%"> -->
            <?php
            // var_dump($ss);die();
            if($ss == '2' ||$ss == '1'){
            $ctk_list = array(
                'name' => 'button',
                'content' => '<< Back',
                'value' => '<< Back',
                'class' => 'button-wrc',
                'onclick' => 'parent.location=\'' . site_url('permintaanbarang/pengajuan_barang') . '\''
            );
            echo form_button($ctk_list);
          }
            ?>
                <table cellpadding="0" cellspacing="0" border="0" class="display" id="pendataan">
                    <thead>
                        <tr>
                            <th width="1%">No</th>
                            <th width="60%">Nama Barang</th>
                            <th width="10%">Merk</th>
                            <th width="10%">Jumlah</th>
                            <th width="19%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $id_user = $this->session->userdata('id_auth');
                        $i = 1;
                        foreach ($barang as $row) {
                            if($row->kategori == '6' && $id_user != 519){ // id 519 pak dadang ridwan
                                continue; // Skip this iteration of the loop
                            }else{
                        ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <!-- <td><a href="#" id="myBtn<?php echo $row->id; ?>"><?php echo $row->nama_barang;  ?></a></td> -->
                                <td><?php if ($ss == '0' || $ss == '1') { ?>
                                      <a href="/<?php echo $routees; ?>permintaanbarang/search_barang/<?php echo $row->nama_barang; ?>/1"><?php echo $row->nama_barang; ?></a>
                                    <?php }else{ 
                                      echo $row->nama_barang;
                                    } ?>

                                </td>
                                <td>
                                    <center>
                                      <!-- <a href="#" id="myBtn<?php echo $row->id; ?>"><?php echo $row->merk;  ?></a> -->
                                      <?php 
                                                  $options = array(
                                                                        '<p>
                        <img src="'.$master_url.'/'.$routees.'www/modules/permintaanbarang/views/barang/'.$row->foto.'" width="100px" height="100px">
                    </p>
                    <p>Nama Barang : '.$row->nama_barang.'</p>
                    <p>Merk : '.$row->merk.'</p>
                    <p>Stok : '.$row->jumlah.'</p>'
                                                  );
                                                  ?><center>
                                                  <div class="dropdown">
                                                      <button class="dropbtn" style="background: transparent; border-color: transparent;" disable><?php echo $row->merk; ?></button>
                                                      <div class="dropdown-content">
                                                  <?php
                                                  foreach($options as $option) {
                                                      echo '<p><center>' . $option . '</center></p>';
                                                    }
                                                    ?>
                                                </div>
                                        <?php
                                        // if (!empty($row->merk)) {
                                        //     if ($ss == '0' || $ss == '2') {
                                        //         echo '<a href="/spekta/backoffice/permintaanbarang/search/' . $row->merk . '">' . $row->merk . '</a>';
                                        //     echo '<a href="#" id="myBtn'.$row->id.'">'.$row->merk.'</a>';
                                        //     } else {
                                        //     echo '<a href="#" id="myBtn'.$row->id .'">'. $row->merk .'</a>';
                                        //     }
                                        // } else {
                                        //     echo '-';
                                        // } 
                                        ?>
                                </td>
                                <td>
                                    <center><span><?php echo $row->jumlah; ?> <?php echo $row->satuan; ?></span></center>
                                </td>
                                <td>
                                    <center><?php if ($row->jumlah == '0') { ?>
                                            <span style="color:red;">Barang Habis</span>
                                            <?php } else {
                                                // foreach ($check as $checks) {
                                                // var_dump($checks->id_user);die();
                                                if ($user == $id_user) {
                                                    if ($sta == '2' || $sta == '3' || $sta == '4' || $sta == '5' || $sta == '6') { ?>
                                                    <h4 style="color:red;">Selesaikan Permintaan anda terlebih dahulu</h4>
                                                <?php } else { ?>
                                                    <a href="<?= $master_url.'/'.$routees ?>permintaanbarang/pinjam_user/<?php echo $row->id; ?>"><img src="https://i.pinimg.com/originals/4a/38/7b/4a387bda853bca3782d73234c786a150.png" width="35px" height="35px"></a>
                                                <?php }
                                                } else {
                                                ?>
                                                <a href="<?= $master_url.'/'.$routees ?>permintaanbarang/pinjam_user/<?php echo $row->id; ?>"><img src="https://i.pinimg.com/originals/4a/38/7b/4a387bda853bca3782d73234c786a150.png" width="35px" height="35px"></a>
                                        <?php
                                                }
                                            } ?>
                                    </center>
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

    <!-- tambahkan modal setelah tabel -->
    <?php
    foreach ($barang as $row) {
    ?>
        <div id="myModal<?php echo $row->id; ?>" class="modal">
            <div class="modal-content">
                <button class="close<?php echo $row->id; ?> button-wrc">&times;</button>
                <center>
                    <p>
                        <img src="<?= $root.'/'.$routees ?>www/modules/permintaanbarang/views/barang/<?php echo $row->foto; ?>" width="100px" height="100px">
                    </p>
                    <p>Nama Barang : <?php echo $row->nama_barang;  ?></p>
                    <p>Merk : <?php echo $row->merk;  ?></p>
                    <p>Stok : <?php echo $row->jumlah;  ?></p>
            </div>
            </center>
        </div>
    <?php } ?>

    <!-- tambahkan JavaScript untuk menampilkan modal -->
    <?php
    foreach ($barang as $row) {
    ?>
        <script>
            // ambil elemen tombol dan modal
            var modal = document.getElementById("myModal<?php echo $row->id; ?>");
            var btn = document.getElementById("myBtn<?php echo $row->id; ?>");

            // ambil elemen tombol close
            var span = document.getElementsByClassName("close<?php echo $row->id; ?>")[0];

            // ketika tombol di klik, tampilkan modal
            btn.onclick = function() {
                modal.style.display = "block";
            }

            // ketika tombol close di klik, sembunyikan modal
            span.onclick = function() {
                modal.style.display = "none";
            }

            // ketika user mengklik area di luar modal, sembunyikan modal
            window.onclick = function(event) {
                if (event.target == modal) {
                    modal.style.display = "none";
                }
            }
        </script>
    <?php } ?>