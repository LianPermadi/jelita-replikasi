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
      <?php } 
      
        $routees        = str_replace('index.php', '', $_SERVER['SCRIPT_NAME']);
        $root           = rtrim($_SERVER['DOCUMENT_ROOT'], '/'); // buang trailing slash
        $routees        = ltrim($routees, '/');              // buang leading slash
        $routees_portal = str_replace('backoffice/index.php', '', $_SERVER['SCRIPT_NAME']); 
        $master_url     = $_SERVER['REQUEST_SCHEME'] .'://'. $_SERVER['HTTP_HOST'];
      ?>
    
    <div class="entry">
        <div id="tabs">
          <ul>
            <li><a href="#tabs-1">Ubah Jumlah Barang</a></li>
          </ul>
            <div id="tabs-1">
              <form method="post" action="/<?= $routees ?>permintaanbarang/edit_<?php echo $step; ?>" enctype="multipart/form-data">
                <table cellpadding="0" cellspacing="0" border="0" class="display">
                  <tbody>
                        <input type="hidden" name="jumlahawal" value="<?php echo $jumlah; ?>">
                        <input type="hidden" name="idpermintaan" value="<?php echo $idpermintaan; ?>">
                        <input type="hidden" name="idbarang" value="<?php echo $idbarang; ?>">
                        <input type="hidden" name="url" value="<?php echo $url; ?>">
                        <?php 
                        foreach ($barang as $row) { 
                          // var_dump($row->jumlah);die();
                          ?>
                          <input type="hidden" name="jumlahbarang" value="<?php echo $row->jumlah; ?>">
                        <?php } ?>
                      <tr>
                        <td width="15%">
                          Ubah Jumlah Permohonan Barang Menjadi
                        </td>
                        <td>
                          <input type="number" name="jumlahubah"  style="width:100%; background-color: white; border: 1px solid blue;" class="input-wrc" value="<?php echo $jumlah; ?>">
                        </td>
                      </tr>
                      <tr>
                        <td width="15%">
                          Keterangan
                        </td>
                        <td>
                          <input type="textarea" name="keterangan"  style="width:100%; background-color: white; border: 1px solid blue; height: 25px;" class="input-wrc">
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