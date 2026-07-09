<style>
   
</style>

<div class="isi">
    <div id="entry">
        <h2>Pengaduan Online</h2>
        <div class="kiri">
            <!-- <form  method="post" action="<?php echo base_url() . '/main/pengaduan/save' ?>" enctype="multipart/form-data" id="formID" class="formular"> -->
                <?php 
                $attributes = array('id' => 'formID',
                                    'class' => 'formular');

                echo form_open_multipart('main/pengaduan/save', $attributes); ?>
                <table  style="margin-left: 15px;" width="95%" class="my_table_font table">
                    <tr>
                        <td colspan="3">
			    		    <p>
							    Media online untuk mengirimkan pengaduan berkaitan dengan layanan perizinan : <br/> <br/>
                            </p>
    					</td>
                    </tr>
                   
			    	<tr>
                        <td width="200">Jenis Pengaduan</td>
                        <td>:</td>
                        <td>
							<select name="jenis" id="jenis" class="validate[required] text-input">
    							<option value="">Pilih Jenis Pengaduan</option>
							    <?php
                                foreach ($list_status as $row) {
									if($row['status'] == 1)
                                       echo "<option value=".$row['id'].">".$row['n_status']."</option>";
                                }
                                ?>
            <!--                    <option value="" selected="selected">Pilih Jenis Pengaduan</option>
                                <option value="1">Januari</option>
                                <option value="2">Februari</option>
                                <option value="3">Maret</option>
                                <option value="4">April</option>
                                <option value="5">Mei</option>
                                <option value="6">Juni</option>
                                <option value="7">Juli</option>
                                <option value="8">Agustus</option>
                                <option value="9">September</option>
                                <option value="10">Oktober</option>
                                <option value="11">November</option>
                                <option value="12">Desember</option>
			-->
                            </select>
						</td>
                    </tr>

					<tr>
                        <td width="200">Nomor Pendaftaran</td>
                        <td>:</td>
                        <td>
                            <input type="text" name="nomor" id="nomor" class="validate[required] text-input" style="width: 200px"/>
                                * Nomor Pendaftaran sesuai lembaran ceklist
                        </td>
                    </tr>

					<tr>
                        <td width="200">Nama Lengkap</td>
                        <td>:</td>
                        <td><input type="text" name="nama" id="nama" class="validate[required] text-input" style="width: 200px"/> </td>
                    </tr>
				
    				<tr>
                        <td width="200">Kontak Person/Telp </td>
                        <td>:</td>
                        <td><input type="text" name="kontak_person" id="kontak" class="validate[required] text-input" style="width: 200px"/> </td>
                    </tr>
                    
					<tr>
                        <td width="200">Nomor HP </td>
                        <td>:</td>
                        <td><input type="text" name="no_hp" id="no_hp" class="validate[required] text-input" style="width: 200px"/> </td>
                    </tr>

					<tr>
                        <td width="200">Kontak e-mail </td>
                        <td>:</td>
                        <td><input type="email" name="n_email" id="n_email" class="validate[required] email-input" style="width: 300px"/> </td>
                    </tr>
                
    				<tr>
                        <td>Alamat </td>
                        <td>:</td>
                        <td><input type="text" name="alamat" id="alamat" class="validate[required] text-input" style="width: 450px"/> </td>
                    </tr>
                
    				<tr>
                        <td>Provinsi</td>
                        <td>:</td>
                        <td>
                            <select name="propinsi1" id="provinsi2" class="validate[required] text-input">
                                <option value="">Pilih Provinsi : </option>
                                <?php
                                foreach ($list_propinsi as $row) {
                                    $id=$row['id'];
                                    $nama=$row['n_propinsi'];
                                    echo "<option value=$id> $nama</option>";
                                }         
                                ?>
                            </select>
                        </td>
                    </tr>
                
			    	<tr>
                        <td>Kabupaten</td>
                        <td>:</td>
                        <td>
                            <select name="kabupaten1" id="kabupaten2" class="validate[required] text-input">
                                <option value="">Pilih Kabupaten : </option>
                            </select>                            
                        </td>
                    </tr>
                 
	    			<tr>
                        <td>Kecamatan</td>
                        <td>:</td>
                        <td>
                            <select name="kecamatan1" id="kecamatan2" class="validate[required] text-input">
                                <option value="">Pilih Kecamatan : </option>
                            </select>                             
                        </td>
                    </tr>
                
	    			<tr>
                        <td>Kelurahan</td>
                        <td>:</td>
                        <td>
                            <select name="kelurahan1" id="kelurahan2" class="validate[required] text-input">
                                <option value="">Pilih Kelurahan : </option>
                            </select>  
                        </td>
                    </tr>

                    <tr>
                        <td style="vertical-align:top;">Deskripsi Pengaduan</td>
                        <td style="vertical-align:top;">:</td>
                        <td>
				    	    <textarea cols="40" rows="7" name="e_pesan" id="e_pesan" class="validate[required] text-input"></textarea>
                        </td>
	    			</tr>
                    
					<tr>
                        <td></td>
                        <td></td>
                        <td>
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
                        <td></td>
                        <td style="vertical-align:top;">
		    			    Mohon isi data dengan benar dan selengkap mungkin, Obyek Izin yang diadukan harap ditulis secara jelas pada kolom Deskripsi Pengaduan agar Kami dapat menindaklanjuti pengaduan dengan cepat.
    					</td>
                    </tr>

                    <tr>
                        <td></td>
                        <td><input type="hidden" name="honeypot" value=""><input type="hidden" id="error_data" ></td>
                        <td><?php echo form_submit('submit', 'Kirim'); ?> </td>
                    </tr>
                </table>
            <?php echo form_close(); ?>
        </div>
        <div class="kanan">
            <?php echo "$menu" ?>
            <?php echo "$menu1" ?>
        </div>
        <div style="clear: both;"></div>
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