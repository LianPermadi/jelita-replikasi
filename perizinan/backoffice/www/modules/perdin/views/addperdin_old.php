<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title></title>
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
      <h2><span style="font-family: Cursive; color: navy;"><?php echo $page_name; ?></span></h2>
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
        // var_dump($perdin);die();
        $alert = $this->session->flashdata("gagal");
        if (!empty($alert)) {
        ?>
            <br>
            <div style="color: red; font-size: 12px; margin-left: 20px; margin-bottom: 10px; font-weight: bold;">
                <center><?php echo $alert; ?></center>
            </div>
        <?php } ?>

        <div class="entry">

            <div id="tabs">
                <ul>
                    <li><a href="#tabs-1">Input Barang</a></li>
                </ul>
                <div id="tabs-1">
                    <form action="/jelita/backoffice/perdin/inputrekapperdin" method="post" enctype="multipart/form-data">
                        <table cellpadding="0" cellspacing="0" border="0" class="display">
                            <tbody>
                                <tr>
                                    <td align="left" width="15%">
                                        <b>Nomor Surat</b>
                                    </td>
                                    <td>
                                        <input type="text" name="nomor_surat" style="width:100%" class="input-wrc" value="">
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" width="15%" class="bg-grid">
                                        <b>Dasar</b>
                                    </td>
                                    <td class="bg-grid">
                                        <input type="text" name="dasar" style="width:100%" class="input-wrc" value="">
                                    </td>
                                </tr>
                        <tr>
                            <td><label class="label-wrc">Kepada</label></td>
                            <td>        
                                <select id="listizin" name="kepada[]" multiple="multiple" >
                                    <?php
                                    if($save_method === "update") {
                                        foreach ($list as $data) {
                                            foreach ($idp as $data_p) {
                                                $selected= 'testing';
                                                if ($data_p->id == $data->id) {
                                                    $selected= 'selected'; break;
                                                }
                                            }
                                            if ($selected=="selected") {
                                                $data->trunitkerja->get();
                                                echo "<option style='width:100%' value='".$data->id."'" . $selected . ">".$data->n_pegawai." | ".
                                                     $data->nip." | ".$data->pangkat_gol." | ".$data->n_jabatan." </option>";
                                            } else {
                                                $data->trunitkerja->get();
                                                echo "<option style='width:100%' value='".$data->id."'>".$data->n_pegawai." | ".
                                                     $data->nip." | ".$data->pangkat_gol." | ".$data->n_jabatan. "</option>";
                                            }   
                                        }
                                    } else {
                                        foreach ($list as $data) {
                                            echo "<option style='width:100%' value='".$data->id."'>".$data->n_pegawai." | ".$data->nip." |".
                                                 $data->pangkat_gol." | ".$data->n_jabatan." </option>";
                                        }
                                    }
                                    ?>
                                </select>
                                <span id="erorPeriksa" style=" clear: both; visibility: hidden;"></span>
                            </td>
                        </tr>
                                <tr>
                                    <td align="left" width="15%" class="bg-grid">
                                        <b>Untuk</b>
                                    </td>
                                    <td class="bg-grid">
                                        <input type="text" name="untuk" style="width:100%" class="input-wrc" value="">
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" width="15%">
                                        <b>Tanggal Ditetapkan</b>
                                    </td>
                                    <td>
                                        <input type="date" name="tanggal" style="width:30%" class="input-wrc" value="">
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" width="15%" class="bg-grid">
                                        <b>TTD Surat</b>
                                    </td>
                                    <td class="bg-grid">
                                        <select class="pilihan" name="ttd" style="width:100%" class="input-wrc" required>
                                            <option value="-">-</option>
                                            <option value="1">Kepala Dinas</option>
                                            <option value="2">Sekertaris Dinas</option>
                                        </select>
                                        <input type="hidden" name="date" value="<?php echo date('Y-m-d G:i:s'); ?>">
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
                <input type="submit" name="submit" value="Simpan" class="submit-wrc" content="Simpan">

            <span></span>
            <button name="button" type="button" class="button-wrc" onclick="parent.location='<?php echo site_url('perdin/rekap'); ?>'">Batal</button>
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
$(document).ready(function(){
  $("#flip").click(function(){
    $("#panel").slideToggle("slow");
  });
});
</script>
<style> 
#panel, #flip {
  padding: 5px;
  text-align: center;
  background-color: #e5eecc;
  border: solid 1px #c3c3c3;
}

#panel {
  padding: 50px;
  display: none;
}
</script>