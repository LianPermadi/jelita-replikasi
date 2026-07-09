<script>
 function ceksumber(sumber) {
        if(sumber=='PASSPORT') {
                $("input[name=referensi]").attr("class", 'validate[required] text-input');
                $("input[name=referensi]").focus();
        } else {
            $("input[name=referensi]").attr("class", 'validate[required, custom[integer]] text-input');
            $("input[name=referensi]").focus();
        }
    }
</script>

<style>
    table tr td{padding-bottom: 5px; padding-left: 10px;}
    .ti_table{
        font-weight: bold; font-size: 14px; padding-bottom: 5px; padding-left: -10px;
    }
    em{font-weight: normal; font-size: 12px;}
</style>

<div class="isi">
    <div id="entry">
        <h2>Pendaftaran Online</h2>
        <div class="kiri">
            <div id="pesan" style="color: red; font-size: 12px; margin-left: 20px; margin-bottom: 10px; font-weight: bold;"><?php echo $error ?></div>
            <form  method="post" name="form_saya" action="<?php echo base_url() . '/main/pendaftaran_online2/save_pendaftaran' ?>" enctype="multipart/form-data" id="formID" class="formular">
                <table border="1" style="margin-left: 10px;" width="95%" class="my_table_font">
                    
					<tr>
                        <td colspan="3" class="ti_table">Data Pemohon</td>
                    </tr>
                    
					<tr>
                        <td width="200">ID</td>
                        <td>:</td>
                        <td>
						    <input type="text" id="referensi" name="referensi" class="validate[required, custom[integer]] text-input" style="width: 200px" value="<?php echo $referensi ?>"/>
                            <?php
                            $opt_referensi['KTP']="KTP";
                            $opt_referensi['SIM']="SIM";
                            $opt_referensi['PASSPORT']="PASSPORT";
                            echo form_dropdown('cmbsource', $opt_referensi, '',"onchange=\"ceksumber(this.form.cmbsource.value);return false\"");
                            ?>
                        </td>
                    </tr>
                    
					<tr>
                        <td>Nama Pemohon </td>
                        <td>:</td>
                        <td><input type="text" id="namaPemohon" name="namaPemohon" class="validate[required] text-input" style="width: 200px" value="<?php echo $namaPemohon ?>"/> </td>
                    </tr>
                    
					<tr>
                        <td>Telpon / HP</td>
                        <td>:</td>
                        <td><input type="text"  id="telpPemohon" name="telpPemohon"  class="validate[required, custom[integer]] text-input" style="width: 200px" value="<?php echo $telpPemohon ?>"/> </td>
                    </tr>
                    
					<tr>
                        <td>Alamat Pemohon</td>
                        <td>:</td>
                        <td><input type="text" size="50" id="almtPemohon" name="almtPemohon" class="validate[required] text-input" style="width: 350px" value="<?php echo $almtPemohon ?>"/> </td>
                    </tr>
                    
					<tr>
                        <td>Provinsi</td>
                        <td>:</td>
                        <td>
                            <select name="propinsi1" id="provinsi1" class="validate[required] text-input">
                                <option value="">Pilih Provinsi : </option>
                                <?php
                                foreach ($list_prop as $row) {
                                    // echo "<option value='$row->id'>$row->n_propinsi </option>";
                                    $id=$row['id'];
                                    $nama_prop=$row['n_propinsi'];
                                    echo "<option value=$id> $nama_prop </option>";
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                    
					<tr>
                        <td>Kabupaten</td>
                        <td>:</td>
                        <td>
                            <?php
                            if($kabupaten1!=NULL) {
                            ?>
                                <script type="text/javascript">
                                    $(document).ready(function(){
                                        $("#provinsi1").val ('<?php echo $propinsi1;?>');
                                        $("#provinsi2").val ('<?php echo $propinsi2;?>');
                                        $.ajax({
                                            type: "POST",
                                            url: site+"main/pendaftaran_online2/list_daerah/1/"+"<?php echo $propinsi1;?>",
                                            data: "",
                                            cache: false,
                                            success: function(html){
                                                $("#kabupaten1").html(html);
                                                $("#kabupaten1").val('<?php echo $kabupaten1;?>');
                                            }                                        
                                        });
                                        $.ajax({
                                            type: "POST",
                                            url: site+'main/pendaftaran_online2/list_daerah/2/'+'<?php echo $kabupaten1;?>',
                                            data: "",
                                            cache: false,
                                            success: function(html){
                                                $("#kecamatan1").html(html);
                                                $("#kecamatan1").val('<?php echo $kecamatan1;?>');
                                            } 
                                        });
                                        $.ajax({
                                            type: "POST",
                                            url: site+'main/pendaftaran_online2/list_daerah/3/'+'<?php echo $kecamatan1;?>',
                                            data: "",
                                            cache: false,
                                            success: function(html){
                                                $("#kelurahan1").html(html);
                                                $("#kelurahan1").val('<?php echo $kelurahan1;?>');
                                            } 
                                        });                                            
                                        $.ajax({
                                            type: "POST",
                                            url: site+"main/pendaftaran_online2/list_daerah/1/"+"<?php echo $propinsi2;?>",
                                            data: "",
                                            cache: false,
                                            success: function(html){
                                                $("#kabupaten2").html(html);
                                                $("#kabupaten2").val('<?php echo $kabupaten2;?>');
                                            }                                        
                                        });
                                        $.ajax({
                                            type: "POST",
                                            url: site+'main/pendaftaran_online2/list_daerah/2/'+'<?php echo $kabupaten2;?>',
                                            data: "",
                                            cache: false,
                                            success: function(html){
                                                $("#kecamatan2").html(html);
                                                $("#kecamatan2").val('<?php echo $kecamatan2;?>');
                                            } 
                                        });
                                        $.ajax({
                                            type: "POST",
                                            url: site+'main/pendaftaran_online2/list_daerah/3/'+'<?php echo $kecamatan2;?>',
                                            data: "",
                                            cache: false,
                                            success: function(html){
                                                $("#kelurahan2").html(html);
                                                $("#kelurahan2").val('<?php echo $kelurahan2;?>');
                                            } 
                                        });
                                    });
                                </script>
                                <?php
                            }
                                ?>
                            <select name="kabupaten1" id="kabupaten1" class="validate[required] text-input">
                                <option value="">Pilih Kabupaten : </option>
                            </select>  
                        </td>
                    </tr>
                    
					<tr>
                        <td>Kecamatan</td>
                        <td>:</td>
                        <td>
                            <select name="kecamatan1" id="kecamatan1" class="validate[required] text-input">
                                <option value="">Pilih Kecamatan : </option>
                            </select>                             
                        </td>
                    </tr>
                    
					<tr>
                        <td>Kelurahan</td>
                        <td>:</td>
                        <td>
                            <select name="kelurahan1" id="kelurahan1" class="validate[required] text-input">
                                <option value="">Pilih Kelurahan : </option>
                            </select>  
                            <br/><br/><br/>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="3" class="ti_table" >Data Perusahaan</td>
                    </tr>

					<tr>
                        <td>NPWP Perusahaan</td>
                        <td>:</td>
                        <td><input type="text" id="npwpPerusahaan" name="npwpPerusahaan" style="width: 200px" value="<?php echo $npwpPerusahaan ?>"/> </td>
                    </tr>
                    
					<tr>
                        <td>Nomor Register</td>
                        <td>:</td>
                        <td><input type="text" id="regPerusahaan" name="regPerusahaan"  style="width: 200px" value="<?php echo $regPerusahaan ?>"/> </td>
                    </tr>
                    
					<tr>
                        <td>Nama Perusahaan</td>
                        <td>:</td>
                        <td><input type="text" id="namaPerusahaan" name="namaPerusahaan"  style="width: 200px" value="<?php echo $namaPerusahaan ?>"/> </td>
                    </tr>
                    
					<tr>
                        <td>Alamat Perusahaan</td>
                        <td>:</td>
                        <td><input size="" type="text" id="almtPerusahaan" name="almtPerusahaan"    style="width: 350px" value="<?php echo $almtPerusahaan ?>"/> </td>
                    </tr>
                    
					<tr>
                        <td>Telepon Perusahaan</td>
                        <td>:</td>
                        <td><input type="text" id="telpPerusahaan" name="telpPerusahaan"  style="width: 200px" value="<?php echo $telpPerusahaan ?>"/> </td>
                    </tr>

                    <tr>
                        <td>Provinsi</td>
                        <td>:</td>
                        <td>
                           <select name="propinsi2" id="provinsi2" text-input">
                                <option value="">Pilih Provinsi : </option>
                                <?php
                                foreach ($list_prop as $row) {
                                   // echo "<option value='$row->id'>$row->n_propinsi </option>";
                                    $id=$row['id'];
                                    $nama_prop=$row['n_propinsi'];
                                    echo "<option value=$id> $nama_prop </option>";
                                }
                                ?>
                            </select>
                        </td>
                    </tr>

					<tr>
                        <td>Kabupaten</td>
                        <td>:</td>
                        <td>
                            <select name="kabupaten2" id="kabupaten2"  text-input">
                                <option value="">Pilih Kabupaten : </option>
                            </select>                            
                        </td>
                    </tr>
                    
					<tr>
                        <td>Kecamatan</td>
                        <td>:</td>
                        <td>
                            <select name="kecamatan2" id="kecamatan2"  text-input">
                                <option value="">Pilih Kecamatan : </option>
                            </select>                             
                        </td>
                    </tr>
                    
					<tr>
                        <td>Kelurahan</td>
                        <td>:</td>
                        <td>
                            <select name="kelurahan2" id="kelurahan2" text-input">
                                <option value="">Pilih Kelurahan : </option>
                            </select>  

                            <br/><br/><br/>
                        </td>
                    </tr>

<!-- Create PBS untuk menonaktifkan upload File
                    <tr>
                        <td>Lampiran</td>
                        <td>:</td>
                        <td><input type="file" id="file_upload" name="file_upload" style="width: 200px" />
                            <p> * file ( jpg, png, pdf ) <br/>
                                * Maksimal file yang diupload 1 MB</p>
                            <br/><br/><br/>
                        </td>
                    </tr>
<!-- -->  
                    
					<tr>
                        <td colspan="3" class="ti_table" >Data Perizinan</td>
                    </tr>

					<tr>
                        <td>Jenis Izin</td>
						<td>:</td>
                        <td>
                            <?php
                            foreach ($list_trperizinan as $row) {
							    echo '<input type="hidden" name="gt' . $row['id'] . '" value="' . $row['jenis_perizinan'] . '"/>';
                                $opti_prz[$row['id']] = '('.$row['id'].')  - '.$row['jenis_perizinan'];
                            }
                            echo form_dropdown('izin', $opti_prz, $izin, 'style="width: 600px"');
//echo form_dropdown('jenis_izin', $opsi_prz, '','class = "input-select-wrc" id="jenis_izin" multiple="multiple"');
                            ?>
                        </td>
                    </tr>
                    
					<tr>
                        <td></td>
                        <td></td>
                        <td class="ti_table">
                            <table>
                                <tr>
                                    <td width="5"></td>
                                    <td> <span id="capcha">

                                        </span></td>
                                    <td width="5"></td>
                                    <td>
                                        <img src="<?php echo base_url() . '/assets/css/default/icon/reset.png' ?>" title="Reload" class="klic" onclick="reload_get()">
                                    </td>
                                </tr>
                            </table>
                            <br/>
                            <em>isi textbox sesuai dengan captcha yang anda lihat pada gambar diatas </em><br/>
                            &nbsp;&nbsp;<input type="text" id="isi_capca2" name="isi_capca2" style="width: 200px">
                            <br/>
                            <span id="isi_capca_error" style="color: red;"> </span>
                        </td>
                    </tr>

                    <tr>
                        <td></td>
                        <td><input type="hidden" id="error_data" ><input type="hidden" id="tglPermohonan"  name="tglPermohonan" value="<?php echo date("Y-m-d") ?>"></td>
                        <td><input type="submit" value="Simpan" class='button button-blue'  onclick="return ajaxFileUpload();" style="float: left; margin-right: 5px; margin-left: 0px;"/> </td>
                    </tr>
                </table>
            </form>

        </div>
        <div class="kanan">
            <?php echo "$menu" ?>
            <?php echo "$menu1" ?>
        </div>
        <div class="clear"></div>
    </div>
</div>
<script>
    function reload_get(){
        $("#capcha").load(site+'main/pendaftaran_online/get_capcha');
    }
    $(document).ready(function() {
        //ini config tiny
        $("#formID").submit(function(){
            $("#error_data").val('0');
            if ($("#isi_capca").val() != $("#isi_capca2").val()){
                $("#isi_capca_error").html("<p>Data Tidak Sama Dengan Gambar</p>");
                $("#capcha").load(site+'main/pendaftaran_online/get_capcha');
                $("#error_data").val('1');
            }
            if ($("#error_data").val() == 1){
                return false;
            }
        });
        $("#capcha").load(site+'main/pendaftaran_online/get_capcha');
    });
</script>


<script type="text/javascript">
    $(document).ready(function(){
        $("#provinsi1").change(function(){
            var id=$(this).val();
            var dataString="";
            $.ajax({
                type: "POST",
                        
                url: site+"main/pendaftaran_online2/list_daerah/1/"+id,
                data: dataString,
                cache: false,
                success: function(html){
                    $("#kabupaten1").html(html);
                    $("#kecamatan1").html("<option value=''>Pilih Kecamatan : </option> ");
                    $("#kelurahan1").html("<option value=''>Pilih Kelurahan : </option> ");
                } 
            });
        });
                
        $("#kabupaten1").change(function(){
            var id=$(this).val();
            var dataString="";
            $.ajax({
                type: "POST",
                        
                url: site+'main/pendaftaran_online2/list_daerah/2/'+id,
                data: dataString,
                cache: false,
                success: function(html){
                    $("#kecamatan1").html(html);
                    $("#kelurahan1").html("<option value=''>Pilih Kelurahan : </option> ");
                } 
            });
        });   
                
        $("#kecamatan1").change(function(){
            var id=$(this).val();
            var dataString="";
            $.ajax({
                type: "POST",
                        
                url: site+'main/pendaftaran_online2/list_daerah/3/'+id,
                data: dataString,
                cache: false,
                success: function(html){
                    $("#kelurahan1").html(html);
                } 
            });
        });               
                               
                
        $("#provinsi2").change(function(){
            var id=$(this).val();
            var dataString="";
            $.ajax({
                type: "POST",
                        
                url: site+"main/pendaftaran_online2/list_daerah/1/"+id,
                data: dataString,
                cache: false,
                success: function(html){
                    $("#kabupaten2").html(html);
                    $("#kecamatan2").html("<option value=''>Pilih Kecamatan : </option> ");
                    $("#kelurahan2").html("<option value=''>Pilih Kelurahan : </option> ");
                } 
            });
        });
                
        $("#kabupaten2").change(function(){
            var id=$(this).val();
            var dataString="";
            $.ajax({
                type: "POST",
                        
                url: site+'main/pendaftaran_online2/list_daerah/2/'+id,
                data: dataString,
                cache: false,
                success: function(html){
                    $("#kecamatan2").html(html);
                    $("#kelurahan2").html("<option value=''>Pilih Kelurahan : </option> ");
                } 
            });
        });   
                
        $("#kecamatan2").change(function(){
            var id=$(this).val();
            var dataString="";
            $.ajax({
                type: "POST",
                        
                url: site+'main/pendaftaran_online2/list_daerah/3/'+id,
                data: dataString,
                cache: false,
                success: function(html){
                    $("#kelurahan2").html(html);
                } 
            });
        });   
    });
</script>
