<div id="content">
    <div class="post">
        <div class="title">
            <h2><?php echo $page_name; ?></h2>
        </div>
        <?php
        $attr = array('id' => 'form');
        echo form_open('perusahaan/' . $save_method, $attr);
        echo form_hidden('id_perusahaan', $id_perusahaan);
        ?>
        <div class="entry">
            <div id="tabs">
                <ul>
                    <li><a href="#tabs-1">Data Perusahaan</a></li>
                </ul>

				<div id="tabs-1">
                    <?php
                    if ($save_method !== "update") {
                        ?>
                        <div class="contentForm">
                            <?php
                            //echo form_label('');
                            //echo anchor(base_url() . 'pelayanan/pendaftaran/daftar_perusahaan_list', 'Ambil Data Perusahaan', 'class="link-wrc" rel="perusahaan_box"');
                            ?>
                        </div>
                        <br style="clear: both" />
                        <?php
                    }
                    ?>
                    <div id="contentleft">
                        <div class="contentForm">
                            <?php
                            if ($save_method == "save") {
                                $id = 'npwp';
                            } else {
                                $id = 'npwp2';
                            }
                            $npwp_input = array(
							    'name' => 'npwp', 
							    'value' => $npwp,
								'class' => 'input-wrc'
							);
                            echo form_label('NPWP');
                            echo form_input($npwp_input);
                            ?>
                            &nbsp;
                        </div>

                        <div class="contentForm">
                            <?php
                            $nodaftar_input = array(
							    'name' => 'nodaftar',
                                'id' => 'nodaftar_id',
                                'value' => $nodaftar,
                                'class' => 'input-wrc'
                            );
                            echo form_label('No Register ');
                            echo form_input($nodaftar_input);
                            echo form_error('nodaftar', '<div class="field_error">', '</div>');
                            if ($statusOnline == "1") { 
							?>
                                <br>
							<?php } ?>
                            <!--<input style="margin-left: 22%;" type="button" onclick="show_npwp(this.form)" value="Cek NPWP dan No Daftar" class="button-wrc" >-->
                        </div>

                        <div class="contentForm">
                            <?php
                            $namaperusahaan_input = array(
                                'name' => 'nama_perusahaan',
                                'value' => $nama_perusahaan,
                                'class' => 'input-wrc',
                            );
                            echo form_label('Nama Perusahaan ');
                            echo form_input($namaperusahaan_input);
                            echo form_error('nama_perusahaan', '<div class="field_error">', '</div>');
                            ?>
                        </div>

                        <div class="contentForm">
                            <?php
                            $telp_input = array(
                                'name' => 'telp_perusahaan',
                                'value' => $telp_perusahaan,
                                'class' => 'input-wrc',
                            );
                            echo form_label('Telp Perusahaan ');
                            echo form_input($telp_input);
                            echo form_error('telp_perusahaan', '<div class="field_error">', '</div>');
                            ?>
                        </div>

						<div class="contentForm">
                            <?php
                            $fax_input = array(
                                'name' => 'fax',
                                'value' => $fax,
                                'class' => 'input-wrc digits',
                            );
                            echo form_label('Fax');
                            echo form_input($fax_input);
                            ?>
                        </div>

						<div class="contentForm">
                            <?php
                            $email_input = array(
                                'name' => 'email',
                                'value' => $email,
                                'class' => 'input-wrc email',
                            );
                            echo form_label('Email');
                            echo form_input($email_input);
                            ?>
                        </div>
                    </div>
                    
					<div id="contentright">
                        <div class="contentForm">
                            <b><?php echo form_label('Provinsi '); ?> </b>
                            <?php
                            $opsi_propinsi = array('0' => '-------Pilih data-------');
                            foreach ($list_propinsi as $row) {
                                $opsi_propinsi[$row->id] = $row->n_propinsi;
                            }

							if ($propinsi_usaha == " ") {
                                echo form_dropdown('propinsi_usaha', $opsi_propinsi, '0', 'class = "input-select-wrc" id="propinsi_usaha_id"');
                            } else {
                                echo form_dropdown('propinsi_usaha', $opsi_propinsi, $propinsi_usaha, 'class = "input-select-wrc" id="propinsi_usaha_id"');
                            }
                            ?>
                        </div>

                        <div style="clear: both" ></div>
                        <div class="contentForm">
                            <b>
                            <?php
                            echo form_label('Kabupaten/Kota ');
                            $opsi_kabupaten = array('0' => '-------Pilih data-------');
							$list_kabupaten = $this->kabupaten->order_by('n_kabupaten', 'ASC')->get();
                            foreach ($list_kabupaten as $row) {
                                $opsi_kabupaten[$row->id] = $row->n_kabupaten;
                            }
                            if ($kabupaten_usaha == NULL) {
                                echo "<div id='show_kabupaten_usaha'>Data Tidak Tersedia</div>";
                            } else {
								//if(!isset($opsi_kabupaten[$kabupaten_usaha])){
								//	echo $nkab_usaha;
								//}else{
                                    echo "<div id='show_kabupaten_usaha'><input type='hidden' value='" . $kabupaten_usaha . "' name='kabupaten_usaha' />" . $opsi_kabupaten[$kabupaten_usaha] . "</div>";
								//}
                            }
                            ?>
                        </div>

                        <div style="clear: both" ></div>
                        <div class="contentForm">
                            <b><?php
                            echo form_label('Kecamatan ');
                            $opsi_kecamatan = array('0' => '-------Pilih data-------');
                            foreach ($list_kecamatan as $row) {
                                $opsi_kecamatan[$row->id] = $row->n_kecamatan;
                            }
                            if ($kecamatan_usaha == NULL) {
                                echo "<div id='show_kecamatan_usaha'>Data Tidak Tersedia</div>";
                            } else {
    							//if($save_method == "update"){
								//	echo $nkec_usaha;
								//}else{
                                    echo "<div id='show_kecamatan_usaha'><input type='hidden' value='" . $kecamatan_usaha . "' name='kecamatan_usaha' />" . $opsi_kecamatan[$kecamatan_usaha] . "</div>";
								//}
                            }
                            ?>
                        </div>

                        <div style="clear: both" ></div>
                        <div class="contentForm">
                            <b><?php
                            echo form_label('Kelurahan ');
                            $opsi_kelurahan = array('0' => '-------Pilih data-------');
                            foreach ($list_kelurahan as $row) {
                                $opsi_kelurahan[$row->id] = $row->n_kelurahan;
                            }
                            if ($kelurahan_usaha == NULL) {
                                echo "<div id='show_kelurahan_usaha'>Data Tidak Tersedia</div>";
                            } else {
						    	//if($save_method == "update"){
								//	echo $nkel_usaha;
								//}else{
                                    echo "<div id='show_kelurahan_usaha'><input type='hidden' value='" . $kelurahan_usaha . "' name='kelurahan_usaha' />" . $opsi_kelurahan[$kelurahan_usaha] . "</div>";
								//}
                            }
                            ?>
                        </div>

                        <div style="clear: both" ></div>
                        <div class="contentForm">
                            <?php
                            $alamatusaha_input = array(
                                'name' => 'alamat_usaha',
                                'value' => $alamat_usaha,
                                'class' => 'input-area-wrc',
                            );

                            echo form_label('Alamat Perusahaan ');
                            echo form_textarea($alamatusaha_input);
                            echo form_error('alamat_usaha', '<div class="field_error">', '</div>');
                            ?>
                        </div>

                        <div class="contentForm">
                            <?php
                            foreach ($list_kegiatan as $row) {
                                $opsi_kegiatan[' '] = "------Pilih salah satu------";
                                $opsi_kegiatan[$row->id] = $row->n_kegiatan;
                            }
                            echo form_label('Jenis Kegiatan');
                            if ($jenis_kegiatan == "ok") {
                                echo form_dropdown('jenis_kegiatan', $opsi_kegiatan, ' ', 'class = "input-select-wrc" id="jenis_kegiatan"');
                            } else {
                                echo form_dropdown('jenis_kegiatan', $opsi_kegiatan, $jenis_kegiatan, 'class = "input-select-wrc" id="jenis_kegiatan"');
                            }
                            echo form_error('jenis_kegiatan', '<div class="field_error">', '</div>');
                            ?>
                            <p id="erorJ_kegiatan" align="right" style="visibility: hidden;"></p>
                        </div>

                        <div class="contentForm">
                            <?php
                            foreach ($list_investasi as $row) {
                                $opsi_investasi[' '] = "------Pilih salah satu------";
                                $opsi_investasi[$row->id] = $row->n_investasi;
                            }
                            echo form_label('Jenis Investasi ');
                            if ($jenis_investasi == "ok") {
                                echo form_dropdown('jenis_investasi', $opsi_investasi, ' ', 'class = "input-select-wrc" id="jenis_investasi"');
                            } else {
                                echo form_dropdown('jenis_investasi', $opsi_investasi, $jenis_investasi, 'class = "input-select-wrc" id="jenis_investasi"');
                            }
                            echo form_error('jenis_investasi', '<div class="field_error">', '</div>');
                            ?>
                            <p id="erorJ_investasi" align="right" style="visibility: hidden;"></p>
                        </div>
                    </div>
                    <br style="clear: both;" />
                </div>
            </div>
        </div>
        <div class="entry" style="text-align: center;">
            <?php
            $add_daftar = array(
                'name' => 'submit',
                'class' => 'submit-wrc',
                'content' => 'Simpan',
                'type' => 'submit',
                'value' => 'Simpan'
            );
            echo form_submit($add_daftar);
            echo "<span></span>";
            $cancel_daftar = array(
                'name' => 'button',
                'class' => 'button-wrc',
                'content' => 'Batal',
                'onclick' => 'parent.location=\'' . site_url('perusahaan') . '\''
            );
            echo form_button($cancel_daftar);
            echo form_close();
            ?>
        </div>
    </div>
    <br style="clear: both;" />
</div>

<!-- Menambahkan rule untuk opsi jika value-nya = 0 -->
<script type="text/javascript">
    $.validator.addMethod('notSelect', function(value, element) {
        return (value != 0);
    }, 'Pilih opsi yang tersedia.')
    
    $.validator.addMethod('alphaOnly', function(value, element) {
        return this.optional(element) || /^[a-z. ]+$/i.test(value);
    }, 'Hanya diisi oleh huruf.');
    
    var site = '<?php echo base_url(); ?>';
    
    $("#form").validate({
        onkeyup: false,
        rules:{
            npwp:{
                remote:{
                    url: site + "perusahaan/register_npwp_exist",
                    type:"post",
                    data:{
                        npwp: function(){
                            return $("#npwp").val();
                        }
                    }
                }
            }
        }, 
       
        messages:{
            npwp:{
                remote:'No NPWP sudah digunakan!'
            }
        }
    })
    
    //$(document).ready(function(){
//      $('#form').submit(function(){
//        $.ajax({
//            type: 'POST',
//            url: site + 'perusahaan/register_npwp_exist',
//            data: $(this).serialize(),
//            success: function(data) {
//                if(data == "1"){
//                     $('#alert').html('No NPWP sudah digunakan!');
//                } else {
//                     $.ajax({
//                        type: 'POST',
//                        url: site + 'perusahaan/save',
//                        data: $('#form').serialize(),
//                        success: function() {
//                            
//                        }                        
//                     })   
//                }
//            }
//        })
//        return false;
//    });  
//         
//        $("#npwp").keypress(function(){
//            $('#alert').html('');
//        });
//    }) 
</script>
