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
        <div id="tabs">
          <ul>
            <li><a href="#tabs-1">Input Barang</a></li>
          </ul>
            <div id="tabs-1">
              <form method="post" action="/jelita/backoffice/permintaanbarang/save" enctype="multipart/form-data">
                <table cellpadding="0" cellspacing="0" border="0" class="display">
                  <tbody>
                    <?php foreach ($barang as $row) { ?>
                    <tr>
                      <td align="left" width="15%" class="bg-grid">
                        <b>Nama Barang</b>
                      </td>
                      <td class="bg-grid">
                        <?php 
                        $id_log = $this->m_barang->find_id_log($row->nama_barang, $row->merk);
                        // var_dump($id_log);die();
                        foreach($id_log as $log){
                          echo '<input type="hidden" name="barang_log[]" value="'.$log->id.'">';
                        } 
                      ?>
                        <input type="text" name="barang" style="width:100%" class="input-wrc" value="<?php echo $row->nama_barang; ?>">
                      </td>
                    </tr>
                    <tr>
                      <td align="left" width="15%">
                        <b>Merk</b>
                      </td>
                      <td>
                        <input type="text" name="merk" style="width:100%" class="input-wrc" value="<?php echo $row->merk; ?>">
                      </td>
                    </tr>
                    <tr>
                      <td align="left" width="15%" class="bg-grid">
                        <b>Jumlah</b>
                      </td>
                      <td class="bg-grid">
                        <input type="text" name="jumlah" class="input-wrc" value="<?php echo $row->jumlah; ?>" readonly>
                      </td>
                    </tr>
                    <tr>
                      <td align="left" width="15%">
                        <b>Satuan</b>
                      </td>
                      <td>
                        <select class="pilihan" name="satuan" style="width:100%" class="input-wrc">
                          <option value="-">-</option>
                          <option value="Box" <?php if($row->satuan == "Box"){ echo 'selected'; } ?>>Box</option>
                          <option value="Buah" <?php if($row->satuan == "Buah"){ echo 'selected'; } ?>>Buah</option>
                          <option value="Bungkus" <?php if($row->satuan == "Bungkus"){ echo 'selected'; } ?>>Bungkus</option>
                          <option value="Dus" <?php if($row->satuan == "Dus"){ echo 'selected'; } ?>>Dus</option>
                          <option value="Dus Kecil" <?php if($row->satuan == "Dus Kecil"){ echo 'selected'; } ?>>Dus Kecil</option>
                          <option value="Galon" <?php if($row->satuan == "Galon"){ echo 'selected'; } ?>>Galon</option>
                          <option value="Jerigen" <?php if($row->satuan == "Jerigen"){ echo 'selected'; } ?>>Jerigen</option>
                          <option value="Kecil" <?php if($row->satuan == "Kecil"){ echo 'selected'; } ?>>Kecil</option>
                          <option value="Lusin" <?php if($row->satuan == "Lusin"){ echo 'selected'; } ?>>Lusin</option>
                          <option value="Pak" <?php if($row->satuan == "Pak"){ echo 'selected'; } ?>>Pak</option>
                          <option value="PCS" <?php if($row->satuan == "PCS"){ echo 'selected'; } ?>>PCS</option>
                          <option value="Rim" <?php if($row->satuan == "Rim"){ echo 'selected'; } ?>>Rim</option>
                          <option value="Roll" <?php if($row->satuan == "Roll"){ echo 'selected'; } ?>>Roll</option>
                          <option value="Set" <?php if($row->satuan == "Set"){ echo 'selected'; } ?>>Set</option>
                          <option value="Unit" <?php if($row->satuan == "Unit"){ echo 'selected'; } ?>>Unit</option>
                        </select>
                        <input type="hidden" name="date" value="<?php echo date('Y-m-d G:i:s') ?>">
                      </td>
                    </tr>
                    <tr>
                      <td align="left" width="15%" class="bg-grid">
                        <b>Tempat Penyimpanan(RAK)</b>
                      </td>
                      <td class="bg-grid">
                        <input type="hidden" name="id" value="<?php echo $row->id; ?>">
                        <input type="text" name="rak" style="width:100%" class="input-wrc" value="<?php echo $row->simpan; ?>">
                      </td>
                    </tr>
                      <tr>
                      <td>
                        <b>Harga Sebelum nya</b>
                      </td>
                      <td>
                        <?php 
                        $id_log_harga = $this->m_barang->find_id_log_harga($row->nama_barang, $row->merk);
                        foreach($id_log_harga as $log_harga){
                          echo '<input type="hidden" name="barang_log_harga" value="'.$log_harga->id.'">';
                        } 
                        ?>
                        <input type="currency" name="harga" class="uang" id="uang" style="width:100%; background-color: white; border: 1px solid blue;" class="input-wrc" value="<?php echo $row->harga; ?>">
                      </td>
                    </tr>
                                <tr>
                                    <td align="left" width="15%" class="bg-grid">
                                        <b>Foto</b>
                                    </td>
                                    <td class="bg-grid" style="padding:10px;">
                                      <input type="hidden" name="oldfoto" value="<?php echo $row->foto; ?>">
                                      <?php if ($row->foto) { ?>
                                        <img 
                                        src="https://dpmptsp.jabarprov.go.id/jelita/backoffice/www/modules/permintaanbarang/views/barang/<?php echo $row->foto; ?>"
                                        class="img-preview img-fluid mb-3 col-sm-5"  
                                        style="max-height: 250px; max-width: 250px;"
                                        >
                                      <?php }else{ ?>
                                        <img 
                                        class="img-preview img-fluid mb-3 col-sm-5" 
                                        style="max-height: 250px; max-width: 250px;"
                                        >
                                      <?php } ?>
                                        <input type="file" class="submit-wrc" id="foto" onchange="previewImage()" name="foto1" style="width:100%;" accept=".jpg,.jpeg,.png,.JPG,.JPEG,.PNG" value="">
                                        <!-- <input type="text"  value="<?php echo $row->foto; ?>"> -->
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" width="15%">
                                        <b>Kategori</b>
                                    </td>
                                    <td>
                                        <select class="pilihan" name="kategori" style="width:100%" class="input-wrc">
                                            <option value="-">-</option>
                                            <option value="1" <?php if($row->kategori == "1"){ echo 'selected'; } ?>>BELANJA BAHAN-BAHAN BAKAR DAN PELUMAS</option>
                                            <option value="2" <?php if($row->kategori == "2"){ echo 'selected'; } ?>>BELANJA BAHAN-BAHAN LAINNYA</option>
                                            <option value="3" <?php if($row->kategori == "3"){ echo 'selected'; } ?>>BELANJA ALAT/BAHAN UNTUK KEGIATAN KANTOR ALAT TULIS KANTOR</option>
                                            <option value="4" <?php if($row->kategori == "4"){ echo 'selected'; } ?>>BELANJA ALAT/BAHAN UNTUK KEGIATAN KANTOR-BAHAN CETAK</option>
                                            <option value="5"<?php if($row->kategori == "5"){ echo 'selected'; } ?>>BELANJA ALAT/BAHAN UNTUK KEGIATAN KANTOR-PERABOTAN KANTOR</option>
                                            <option value="6" <?php if($row->kategori == "6"){ echo 'selected'; } ?>>BELANJA ALAT/BAHAN UNTUK KEGIATAN KANTOR-PERABOT KANTOR</option>
                                            <option value="7" <?php if($row->kategori == "7"){ echo 'selected'; } ?>>BELANJA ALAT/BAHAN UNTUK KEGIATAN KANTOR-ALAT LISTRIK</option>
                                            <option value="8" <?php if($row->kategori == "8"){ echo 'selected'; } ?>>BELANJA ALAT/BAHAN UNTUK KEGIATAN KANTOR-SOUVENIR / CENDERAMATA</option>
                                            <option value="9" <?php if($row->kategori == "9"){ echo 'selected'; } ?>>BELANJA ALAT/BAHAN UNTUK KEGIATAN KANTOR - ALAT/BAHAN UNTUK KEGIATAN KANTOR LAINNYA</option>
                                            <option value="10" <?php if($row->kategori == "10"){ echo 'selected'; } ?>>BELANJA OBAT-OBATAN LAINNYA </option>
                                            <option value="11" <?php if($row->kategori == "11"){ echo 'selected'; } ?>>BELANJA MAKANAN DAN MINUMAN RAPAT</option>
                                            <option value="12" <?php if($row->kategori == "12"){ echo 'selected'; } ?>>BELANJA MAKANAN DAN MINUMAN TAMU</option>
                                        </select>
                                        <input type="hidden" name="date" value="<?php echo date('Y-m-d G:i:s') ?>">
                                    </td>
                                </tr>
                    <?php 
                      // code...
                    } ?>
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
  </form>
      <button name="button" type="button" class="button-wrc" onclick="parent.location='<?php echo site_url('permintaanbarang/barang'); ?>'">Batal</button>
    </div>
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