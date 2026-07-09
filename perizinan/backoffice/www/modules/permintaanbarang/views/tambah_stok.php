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
              <form method="post" action="/jelita/backoffice/permintaanbarang/<?php echo $step; ?>" enctype="multipart/form-data">
                <table cellpadding="0" cellspacing="0" border="0" class="display">
                  <tbody>
                    <?php foreach ($barang as $row) { ?>
                    <tr>
                      <td align="left" width="15%" class="bg-grid">
                        <b>Nama Barang</b>
                      </td>
                      <td class="bg-grid">
                        <input type="text" name="barang" style="width:100%" class="input-wrc" value="<?php echo $row->nama_barang; ?>" readonly>
                      </td>
                    </tr>
                    <tr>
                      <td align="left" width="15%">
                        <b>Merk</b>
                      </td>
                      <td>
                        <input type="text" name="merk" style="width:100%" class="input-wrc" value="<?php echo $row->merk; ?>" readonly>
                      </td>
                    </tr>
                    <tr>                      
                      <td align="left" width="15%" class="bg-grid">
                        <b>Jumlah Saat Ini</b>
                      </td>
                      <td class="bg-grid">
                        <input type="text" name="" style="width:100%" class="number-wrc" value="<?php echo $row->jumlah; ?>" readonly>
                        <input type="hidden" name="jumlahawal" value="<?php echo $row->jumlah; ?>">
                      </td>
                      <td align="left" width="15%" rowspan="2">
                        <b>Jumlah Yang ingin di tambah</b>
                      </td>
                      <td class="bg-grid" rowspan="2">
                        <input type="text" name="jumlahmasuk" style="width:100%" class="number-wrc" >
                      </td>
                    </tr>
                    <tr>
                      <td align="left" width="15%">
                        <b>Satuan</b>
                      </td>
                      <td>
                        <input type="hidden" name="satuan" value="<?php echo $row->satuan; ?>">
                        <select class="pilihan" style="width:100%" class="input-wrc" disabled>
                          <option value="-">-</option>
                          <option value="Box" <?php if($row->satuan == "Box"){ echo 'selected'; } ?>>Box</option>
                          <option value="Buah" <?php if($row->satuan == "Buah"){ echo 'selected'; } ?>>Buah</option>
                          <option value="Bungkus" <?php if($row->satuan == "Bungkus"){ echo 'selected'; } ?>>Bungkus</option>
                          <option value="Dus" <?php if($row->satuan == "Dus"){ echo 'selected'; } ?>>Dus</option>
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
                        <input type="hidden" name="id_user" value="<?php echo $id_user; ?>">
                        <input type="hidden" name="nama" value="<?php echo $nama; ?>">
                        <input type="hidden" name="id" value="<?php echo $row->id; ?>">
                        <input type="text" name="rak" style="width:100%" class="input-wrc" value="<?php echo $row->simpan; ?>" readonly>
                      </td>
                      <td class="bg-grid" colspan="2">
                        <b>Harga Sebelum nya</b><input type="currency" name="harga" class="uang" id="uang" style="width:100%; background-color: white; border: 1px solid blue;" class="input-wrc" value="<?php echo $row->harga; ?>">
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
          <input type="submit" name="submit" value="Tambah" class="submit-wrc" content="Ubah">
        <?php } ?>
      
      <span></span>
      <button name="button" type="button" class="button-wrc" onclick="parent.location='<?php echo site_url('permintaanbarang/barang'); ?>'">Batal</button>
    </div>
  </form>
  </div>
  <br style="clear: both;" />
</div>

<script>
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