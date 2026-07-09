<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Istana Djaya Plaza</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i">
    <link rel="stylesheet" href="assets/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/fonts/fontawesome5-overrides.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
</head>
<div id="content">
    <div class="post">
        <div class="title">
          <?php echo $this->lib_date->view_title($page_name); ?>
        </div>

        <?php
        // foreach ($user as $row) {
                    $id_user = $user->id;
                    $nama = $user->n_pegawai;
                // }
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
            // include 'button.php';
            ?>
            <?php
            $ctk_list = array(
                'name' => 'button',
                'content' => 'Tambah Barang Baru',
                'value' => 'Tambah Barang Baru',
                'style' => 'background:#B0C4DE; color:black;',
                'class' => 'button-wrc',
                'onclick' => 'parent.location=\'' . site_url('permintaanbarang/addbarang') . '\''
            );
            echo form_button($ctk_list);
            ?>
            <?php
            $ctk_list = array(
                'name' => 'button',
                'content' => 'List Persediaan',
                'value' => '',
                'class' => 'button-wrc',
                'onclick' => 'parent.location=\'' . site_url('permintaanbarang/barang') . '\''
            );
            echo form_button($ctk_list);
            ?>
            <?php
            $ctk_list = array(
                'name' => 'button',
                'content' => 'List Permintaan barang',
                'value' => 'List Permintaan barang',
                'class' => 'button-wrc',
                'onclick' => 'parent.location=\'' . site_url('permintaanbarang/pengajuan') . '\''
            );
            echo form_button($ctk_list);
            ?>
            <?php
            $ctk_list = array(
                'name' => 'button',
                'content' => 'checkout Barang',
                'value' => 'checkout Barang',
                'class' => 'button-wrc',
                'onclick' => 'parent.location=\'' . site_url('permintaanbarang/checkout') . '\''
            );
            echo form_button($ctk_list);
            ?>  
      <?php
      $ctk_list = array('name' => 'button',
                        'content' => 'Barang Masuk',
                        'value' => 'Barang Masuk',
                        'class' => 'button-wrc',
                        'onclick' => 'parent.location=\''.site_url('permintaanbarang/activity').'\''
                       );
      echo form_button($ctk_list);  
      
        $routees        = str_replace('index.php', '', $_SERVER['SCRIPT_NAME']);
        $root           = rtrim($_SERVER['DOCUMENT_ROOT'], '/'); // buang trailing slash
        $routees        = ltrim($routees, '/');              // buang leading slash
        $routees_portal = str_replace('backoffice/index.php', '', $_SERVER['SCRIPT_NAME']); 
        $master_url     = $_SERVER['REQUEST_SCHEME'] .'://'. $_SERVER['HTTP_HOST'];
      ?>  
            <?php
            $ctk_list = array(
                'name' => 'button',
                'content' => 'Barang Keluar',
                'value' => 'Barang Keluar',
                'class' => 'button-wrc',
                'onclick' => 'parent.location=\'' . site_url('permintaanbarang/') . '\''
            );
            echo form_button($ctk_list);
?>
            <div id="tabs">
                <ul>
                    <li><a href="#tabs-1">Input Barang</a></li>
                </ul>
                <div id="tabs-1">
                    <form action="/<?= $routees ?>permintaanbarang/simpan" method="post" enctype="multipart/form-data">
                        <?php
                        if ($step == "update") { ?>
                            <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <?php } ?>
                        <table cellpadding="0" cellspacing="0" border="0" class="display">
                            <tbody>
                                <tr>
                                    <td align="left" width="15%" class="bg-grid">
                                        <b>Nama Barang</b>
                                    </td>
                                    <td class="bg-grid">
                                        <div id="selectContainer">
                                            <select class="pilihan" name="nama_barang" id="namaBarangSelect" style="width:100%" class="input-wrc" required onchange="toggleInput()">
                                                
                                                <option value="-">-</option>
                                                <option value="lainnya">Lainnya</option>
                                                <?php 
                                                    $katalog = $this->m_barang->get_katalog_barang();
                                                    foreach($katalog as $k){
                                                ?>
                                                    <option value="<?php echo $k->nama_barang; ?>"><?php echo $k->nama_barang; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>

                                        <input type="hidden" name="date" value="<?php echo date('Y-m-d G:i:s') ?>">
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" width="15%">
                                        <b>Merk</b>
                                    </td>
                                    <td>
                                        <input type="text" name="merk" style="width:100%" class="input-wrc" required>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" width="15%" class="bg-grid">
                                        <b>Jumlah</b>
                                    </td>
                                    <td class="bg-grid">
                                        <input type="number" name="jumlah" style="width:99%; background-color: white;  border: 1px solid blue;" class="input-wrc" required>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" width="15%">
                                        <b>Satuan</b>
                                    </td>
                                    <td>
                                        <select class="pilihan" name="satuan" style="width:100%" class="input-wrc" required>
                                            <option value="-">-</option>
                                            <option value="Box">Box</option>
                                            <option value="Buah">Buah</option>
                                            <option value="Bungkus">Bungkus</option>
                                            <option value="Dus">Dus</option>
                                            <option value="Dus Kecil">Dus Kecil</option>
                                            <option value="Galon">Galon</option>
                                            <option value="Jerigen">Jerigen</option>
                                            <option value="Kecil">Kecil</option>
                                            <option value="Lusin">Lusin</option>
                                            <option value="Pak">Pak</option>
                                            <option value="PCS">PCS</option>
                                            <option value="Rim">Rim</option>
                                            <option value="Roll">Roll</option>
                                            <option value="Set">Set</option>
                                            <option value="Unit">Unit</option>
                                        </select>
                                        <input type="hidden" name="date" value="<?php echo date('Y-m-d G:i:s') ?>">
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" width="15%" class="bg-grid">
                                        <b>Kategori</b>
                                    </td>
                                    <td class="bg-grid">
                                        <select class="pilihan" name="kategori" style="width:100%" class="input-wrc" required >
                                            <option value="-">-</option>
                                            <option value="1">BELANJA BAHAN-BAHAN BAKAR DAN PELUMAS</option>
                                            <option value="2">BELANJA BAHAN-BAHAN LAINNYA</option>
                                            <option value="3">BELANJA ALAT/BAHAN UNTUK KEGIATAN KANTOR ALAT TULIS KANTOR</option>
                                            <option value="4">BELANJA ALAT/BAHAN UNTUK KEGIATAN KANTOR-BAHAN CETAK</option>
                                            <option value="5">BELANJA ALAT/BAHAN UNTUK KEGIATAN KANTOR-PERABOTAN KANTOR</option>
                                            <option value="6">BELANJA ALAT/BAHAN UNTUK KEGIATAN KANTOR-PERABOT KANTOR</option>
                                            <option value="7">BELANJA ALAT/BAHAN UNTUK KEGIATAN KANTOR-ALAT LISTRIK</option>
                                            <option value="8">BELANJA ALAT/BAHAN UNTUK KEGIATAN KANTOR-SOUVENIR / CENDERAMATA</option>
                                            <option value="9">BELANJA ALAT/BAHAN UNTUK KEGIATAN KANTOR - ALAT/BAHAN UNTUK KEGIATAN KANTOR LAINNYA</option>
                                            <option value="10">BELANJA OBAT-OBATAN LAINNYA </option>
                                            <option value="11">BELANJA MAKANAN DAN MINUMAN RAPAT</option>
                                            <option value="12">BELANJA MAKANAN DAN MINUMAN TAMU</option>
                                        </select>
                                        <input type="hidden" name="date" value="<?php echo date('Y-m-d G:i:s') ?>">
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" width="15%">
                                        <b>Foto</b>
                                    </td>
                                    <td>
                                        <img class="img-preview img-fluid mb-3 col-sm-5" style="max-height: 250px; max-width: 250px;">
                                        <input type="file" class="submit-wrc" id="foto" onchange="previewImage()" name="foto1" style="width:100%;" accept=".jpg,.jpeg,.png,.JPG,.JPEG,.PNG" required="required">
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" width="15%" class="bg-grid">
                                        <b>Tempat Penyimpanan(RAK)</b>
                                    </td>
                                    <td class="bg-grid">
                                        <input type="hidden" name="id_user" value="<?php echo $id_user; ?>">
                                        <input type="hidden" name="nama" value="<?php echo $nama; ?>">
                                        <input type="text" name="rak" style="width:100%" class="input-wrc" required>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" width="15%">
                                        <b>Harga Satuan</b>
                                    </td><td><input type="currency" name="harga" style="width:100%; background-color: white; border: 1px solid blue;" class="input-wrc" required>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                </div>
            </div>
            <label>&nbsp;</label>
            <div class="spacer"></div>
        </div>
        <div class="entry" style="text-align: center;">
            <?php
            if ($step == "simpan") { ?>
                <input type="submit" name="submit" value="Simpan" class="submit-wrc" content="Simpan">
            <?php } else { ?>
                <input type="submit" name="submit" value="Ubah" class="submit-wrc" content="Ubah">
            <?php } ?>

            <span></span>
            <button name="button" type="button" class="button-wrc" onclick="parent.location='<?php echo site_url('permintaanbarang/barang'); ?>'">Batal</button>
        </div>
        </form>
    </div>
    <br style="clear: both;" />
</div>
<script>
    function previewImage() {
        const image = document.querySelector('#foto');
        const imgPreview = document.querySelector('.img-preview')

        imgPreview.style.display = 'block';

        const oFReader = new FileReader();
        oFReader.readAsDataURL(image.files[0]);
        oFReader.onload = function(oFREvent) {
            imgPreview.src = oFREvent.target.result;
        }
    }

    var currencyInput = document.querySelectorAll( 'input[type="currency"]' );

    for ( var i = 0; i < currencyInput.length; i++ ) {

        var currency = 'IDR'
        onBlur( {
            target: currencyInput[ i ]
        } )

        currencyInput[ i ].addEventListener( 'focus', onFocus )
        currencyInput[ i ].addEventListener( 'blur', onBlur )

        function localStringToNumber( s ) {
            return Number( String( s ).replace( /[^0-9.-]+/g, "" ) )
        }

        function onFocus( e ) {
            var value = e.target.value;
            e.target.value = value ? localStringToNumber( value ) : ''
        }

        function onBlur( e ) {
            var value = e.target.value

            var options = {
                maximumFractionDigits: 0,
                currency: currency,
                style: "currency",
                currencyDisplay: "symbol"
            }

            e.target.value = ( value || value === 0 ) ?
                localStringToNumber( value ).toLocaleString( undefined, options ) :
                ''
        }
    }
</script>

<script>
function toggleInput() {
    var selectBox = document.getElementById("namaBarangSelect");
    var selectedValue = selectBox.value;
    var container = document.getElementById("selectContainer");

    if (selectedValue === "lainnya") {
        container.innerHTML = '<select class="pilihan" style="width:100%" class="input-wrc" disabled> <option value="lainnya">Lainnya</option> </select><input type="text" name="nama_barang" style="width:100%" placeholder="Masukkan Nama Barang" required>';
    }
}
</script>