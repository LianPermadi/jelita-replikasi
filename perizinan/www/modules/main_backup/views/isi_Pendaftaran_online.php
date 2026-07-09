<script>
    jQuery(document).ready(function(){
        // binds form submission and fields to the validation engine
        jQuery("#formID").validationEngine();
    });
</script>
<?php $base = base_url() . 'assets/js/uploadifty'; ?>

<style>
    .ti_table{
        padding: 5px; background: #cccccc; font-size: 14px; border: 1px solid #666666
    }
</style>

<div class="isi">
    <div id="entry">
        <div id="loading"></div>
        <div id="pesan"></div>
        
        <script type="text/javascript" src="<?php echo base_url() . 'assets/js/upload/' ?>ajaxfileupload.js"></script>
        <form  method="post" name="form_saya" action="<?php echo base_url() . '/main/pendaftaran_online/save' ?>" enctype="multipart/form-data" id="formID" class="formular">
            <table border="1" style="margin-left: 10px;" width="75%" class="my_table_font">
                <tr>
                    <td colspan="3" class="ti_table" >Data Pemohon</td>
                </tr>
                <tr>
                    <td width="200">ID Pemohon(SIM/KTP/Pasport)</td>
                    <td>:</td>
                    <td><input type="text" id="referensi" name="referensi" class="validate[required] text-input" style="width: 200px"/> </td>
                </tr>
                <tr>
                    <td>Nama Pemohon </td>
                    <td>:</td>
                    <td><input type="text" id="namaPemohon" name="namaPemohon" class="validate[required] text-input" style="width: 200px"/> </td>
                </tr>
                <tr>
                    <td>Telpon / HP</td>
                    <td>:</td>
                    <td><input type="text"  id="telpPemohon" name="telpPemohon"  class="validate[required, custom[integer]] text-input" style="width: 200px"/> </td>
                </tr>
                <tr>
                    <td>Alamat Pemohon</td>
                    <td>:</td>
                    <td><input type="text" id="almtPemohon" name="almtPemohon" class="validate[required] text-input" style="width: 200px"/> </td>
                </tr>
                <tr>
                    <td>Propinsi</td>
                    <td>:</td>
                    <td>
                        <?php
                        $op_propinsi[0] = '--Pilih Salah Satu--';
                        foreach ($list_propinsi as $row) {
                            $op_propinsi[$row->id] = $row->n_propinsi;
                        }
                        echo form_dropdown('propinsi1', $op_propinsi, '', "id=id_propinsi");
                        ?>
                        <span id="id_propinsi_error" style="color: red;"></span>
                    </td>
                </tr>
                <tr>
                    <td>Kabupaten</td>
                    <td>:</td>
                    <td>
                        <div style="padding:5px 0px;">
                            <span id="dt_Kabupaten" > 
                                <select name="kabupaten1" id="id_kabupaten">
                                    <option align="center" value="0">--</option>
                                </select>
                            </span>
                            <span id="id_kabupaten_error" style="color: red;"></span>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>Kecamatan</td>
                    <td>:</td>
                    <td>
                        <div style="padding:5px 0px;">
                            <span id="dt_Kecamatan" >
                                <select  name="kabupaten1" id="id_kecamatan">
                                    <option align="center" value="0">--</option>
                                </select>
                            </span>
                            <span id="id_kecamatan_error" style="color: red;"></span>
                        </div>

                    </td>
                </tr>
                <tr>
                    <td>Kelurahan</td>
                    <td>:</td>
                    <td>
                        <div style="padding:5px 0px;">
                            <span id="dt_Kelurahan" >
                                <select id="id_kelurahan" name="kelurahan1">
                                    <option align="center" value="0">--</option>
                                </select>
                            </span>
                            <span id="id_kelurahan_error" style="color: red;"></span>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="3" class="ti_table" >Data Perusahaan</td>
                </tr>
                <tr>
                    <td>NPWP Perusahaan</td>
                    <td>:</td>
                    <td><input type="text" id="npwpPerusahaan" name="npwpPerusahaan"class="validate[required] text-input" style="width: 200px"/> </td>
                </tr>
                <tr>
                    <td>Nomor Register</td>
                    <td>:</td>
                    <td><input type="text" id="regPerusahaan" name="regPerusahaan" class="validate[required] text-input" style="width: 200px"/> </td>
                </tr>
                <tr>
                    <td>Nama Perusahaan</td>
                    <td>:</td>
                    <td><input type="text" id="namaPerusahaan" name="namaPerusahaan" class="validate[required] text-input" style="width: 200px"/> </td>
                </tr>
                <tr>
                    <td>Alamat Perusahaan</td>
                    <td>:</td>
                    <td><input type="text" id="almtPerusahaan" name="almtPerusahaan" class="validate[required] text-input" style="width: 200px"/> </td>
                </tr>
                <tr>
                    <td>Telpon Perusahaan</td>
                    <td>:</td>
                    <td><input type="text" id="telpPerusahaan" name="telpPerusahaan"class="validate[required] text-input" style="width: 200px"/> </td>
                </tr>

                <tr>
                    <td>Propinsi</td>
                    <td>:</td>
                    <td>
                        <?php
                        $op_propinsi[0] = '--Pilih Salah Satu--';
                        foreach ($list_propinsi as $row) {
                            $op_propinsi[$row->id] = $row->n_propinsi;
                        }
                        echo form_dropdown('propinsi2', $op_propinsi, '', "id=id_propinsi2");
                        ?>
                        <span id="id_propinsi2_error" style="color: red;"></span>
                    </td>
                </tr>
                <tr>
                    <td>Kabupaten</td>
                    <td>:</td>
                    <td>
                        <div style="padding:5px 0px;">
                            <span id="dt_Kabupaten2" > 
                                <select name="id_kabupaten2" id="id_kabupaten2">
                                    <option align="center" value="0">--</option>
                                </select>
                            </span>
                            <span id="id_kabupaten2_error" style="color: red;"></span>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>Kecamatan</td>
                    <td>:</td>
                    <td>
                        <div style="padding:5px 0px;">
                            <span id="dt_Kecamatan2" >
                                <select name="id_kecamatan2" id="id_kecamatan2">
                                    <option align="center" value="0">--</option>
                                </select>
                            </span>
                            <span id="id_kecamatan2_error" style="color: red;"></span>
                        </div>

                    </td>
                </tr>
                <tr>
                    <td>Kelurahan</td>
                    <td>:</td>
                    <td>
                        <div style="padding:5px 0px;">
                            <span id="dt_Kelurahan2" >
                                <select name="id_kelurahan2" id="id_kelurahan2">
                                    <option align="center" value="0">--</option>
                                </select>
                            </span>
                            <span id="id_kelurahan2_error" style="color: red;"></span>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>Lampiran</td>
                    <td>:</td>
                    <td><input type="file" id="file_upload" name="file_upload" style="width: 200px"/></td>
                </tr>
                <tr>
                    <td colspan="3" class="ti_table" >Data Perizinan</td>
                </tr>
                <tr>
                    <td>Jenis Izin</td>
                    <td>:</td>
                    <td>
                        <select name="izin">
                        <?php
                        foreach ($list_trperizinan as $row) {
                            
                            echo "<option value='".$row['id']."'>".$row['jenis_perizinan']."</option>";                      
                            
                            
                            //$opti_prz["$row->id"] = "$row->n_perizinan";
                        }
                        //echo form_dropdown('izin', $opti_prz);
                        ?>
                        </select>
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
                        &nbsp;&nbsp;isi textbox sesuai dengan captcha yang anda lihat pada gambar diatas<br/>
                        &nbsp;&nbsp;<input type="text" id="isi_capca2" name="isi_capca2" class="validate[required] text-input" style="width: 200px">
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
</div>

<script>
    $(document).ready(function() {
        //ini config tiny
        $("#formID").submit(function(){
            $("#error_data").val('0');

            if ($("#referensi").val()==''){
                $("#error_data").val('1');
            }
            if ($("#namaPemohon").val()==''){
                $("#error_data").val('1');
            }
            if ($("#telpPemohon").val()==''){
                $("#error_data").val('1');
            }
            if ($("#almtPemohon").val()==''){
                $("#error_data").val('1');
            }
            if ($("#npwpPerusahaan").val()==''){
                $("#error_data").val('1');
            }
            if ($("#regPerusahaan").val()==''){
                $("#error_data").val('1');
            }
            if ($("#namaPerusahaan").val()==''){
                $("#error_data").val('1');
            }
            if ($("#almtPerusahaan").val()==''){
                $("#error_data").val('1');
            }
            if ($("#telpPerusahaan").val()==''){
                $("#error_data").val('1');
            }


            if ($("#id_propinsi").val()==0){
                $("#id_propinsi_error").html("Data Belum Terpilih");
                $("#error_data").val('1');
            }

            if ($("#id_kabupaten").val()==0){
                $("#id_kabupaten_error").html("Data Belum Terpilih");
                $("#error_data").val('1');
            }
            if ($("#id_kecamatan").val()==0){
                $("#id_kecamatan_error").html("Data Belum Terpilih");
                $("#error_data").val('1');
            }
            if ($("#id_kelurahan").val()==0){
                $("#id_kelurahan_error").html("Data Belum Terpilih");
                $("#error_data").val('1');
            }
            if ($("#id_propinsi2").val()==0){
                $("#id_propinsi2_error").html("Data Belum Terpilih");
                $("#error_data").val('1');
            }
            if ($("#id_kabupaten2").val()==0){
                $("#id_kabupaten2_error").html("Data Belum Terpilih");
                $("#error_data").val('1');
            }
            if ($("#id_kecamatan2").val()==0){
                $("#id_kecamatan2_error").html("Data Belum Terpilih");
                $("#error_data").val('1');
            }
            if ($("#id_kelurahan2").val()==0){
                $("#id_kelurahan2_error").html("Data Belum Terpilih");
                $("#error_data").val('1');
            }

            if ($("#isi_capca").val() != $("#isi_capca2").val()){
                $("#isi_capca_error").html("Data Tidak Sama Dengan Gambar");
                $("#capcha").load(site+'main/pendaftaran_online/get_capcha');
                $("#error_data").val('1');
            }

            if ( $("#error_data").val()==0){
                $("#loading")
                .ajaxStart(function(){
                    $(this).show();
                })
                .ajaxComplete(function(){
                    $(this).hide();
                });

                $.ajaxFileUpload({
                    url:site+"main/pendaftaran_online/save",
                    secureuri:false,
                    fileElementId:'file_upload',
                    dataType: 'json',
                    data:{
                        referensi:document.form_saya.referensi.value,
                        namaPemohon:document.form_saya.namaPemohon.value,
                        telpPemohon:document.form_saya.telpPemohon.value,
                        almtPemohon:document.form_saya.almtPemohon.value,
                        propinsi1:document.form_saya.propinsi1.value,
                        kabupaten1:document.form_saya.kabupaten1.value,
                        kecamatan1:document.form_saya.kecamatan1.value,
                        kelurahan1:document.form_saya.kelurahan1.value,
                        npwpPerusahaan:document.form_saya.npwpPerusahaan.value,
                        regPerusahaan:document.form_saya.regPerusahaan.value,
                        namaPerusahaan:document.form_saya.namaPerusahaan.value,
                        almtPerusahaan:document.form_saya.almtPerusahaan.value,
                        telpPerusahaan:document.form_saya.telpPerusahaan.value,
                        tglPermohonan:document.form_saya.tglPermohonan.value,
                        propinsi2:document.form_saya.propinsi2.value,
                        kabupaten2:document.form_saya.kabupaten2.value,
                        kecamatan2:document.form_saya.kecamatan2.value,
                        kelurahan2:document.form_saya.kelurahan2.value,
                        izin:document.form_saya.izin.value
                    },
                    success: function (data, status)
                    {
                        if(typeof(data.error) != 'undefined')
                        {
                            if(data.status == 'error')
                            {
                                alert(data.msg);
                                alert("eror1");
                            }else{
                                ("#entry").html(data.isi);
                                alert("eror2");
                            }
                            alert("eror3");
                        }else{
                            alert(data.status);
                            alert("eror4");
                            //alert(data.isi);
                        }
                        alert("eror5");
                       // alert(data.status);
                        
                    }
                });
                 alert("eror5");
                }
            return false;
        });
        $("#capcha").load(site+'main/pendaftaran_online/get_capcha');

        $("#id_propinsi").change(function(){
            var id=$("#id_propinsi").val();
            $("#dt_Kabupaten").load(site+'main/pendaftaran_online/list_daerah/1/'+id);
            $("#dt_Kecamatan").html('--');
            $("#dt_Kelurahan").html('--');
            //
            $("#id_propinsi_error").html("");
            $("#id_kabupaten_error").html("");
            $("#id_kecamatan_error").html("");
            $("#id_kelurahan_error").html("");
        });
        $("#id_propinsi2").change(function(){
            var id=$("#id_propinsi2").val();
            $("#dt_Kabupaten2").load(site+'main/pendaftaran_online/list_daerah/10/'+id);
            $("#dt_Kecamatan2").html('--');
            $("#dt_Kelurahan2").html('--');
            //
            $("#id_propinsi2_error").html("");
            $("#id_kabupaten2_error").html("");
            $("#id_kecamatan2_error").html("");
            $("#id_kelurahan2_error").html("");
        });
    });
    function reload_get(){
        $("#capcha").load(site+'main/pendaftaran_online/get_capcha');
    }

    $("#isi_capca2").change(function(){
        $("#isi_capca_error").html('');
         
    });

    

    function ajaxFileUpload()
    {
       
        
    }
            
       
        
    
</script>