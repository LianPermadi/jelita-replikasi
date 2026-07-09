<script type="text/javascript">
  function myfunction() {
    /*var total=""
      for(var i=0; i < document.form1.status.length; i++){
        if(document.form1.status[i].checked)
          total +=document.form1.status[i].value + "\n"
      }
      alert(total);
    */
    var nilai="";
    if(document.form1.status[0].checked==true) {
      nilai="apakah anda yakin akan melakukan penetapan izin.?";
    }else{
      nilai="apakah anda yakin akan melakukan penolakan izin.?";
    }
    if(confirm(nilai)==true) {
      return true;
    }else{
      return false;
    }
  }
</script>

<div id="content">
  <div class="post">
    <div class="title">
      <h2><?php echo $page_name; ?></h2>
    </div>
    <div class="entry">
      <?php 
      $attr = array('id' => 'form','name'=>'form1','onsubmit'=>'return myfunction()');
      echo form_open('permohonan/penetapan/save',$attr); 
			echo form_hidden('id_bap', $id_bap);
      echo form_hidden('id', $id);
			echo form_hidden('idjenis', $idjenis);
      echo form_hidden('jenislayanan', $jenislayanan);
      echo form_hidden('waktu_awal', $waktu_awal);
      echo form_hidden('akdp_tg_sk', $akdp_tg_sk);
   		echo form_hidden('akdp_tg_kp', $akdp_tg_kp);
   		echo form_hidden('e_ttd', $e_ttd);

      $izin = new trperizinan();
      $izin->get_by_id($idjenis);
      $kelompok = $izin->trkelompok_perizinan->get();
      ?>
      <fieldset>
        <legend>Daftar Berita acara</legend>
        <div id="statusMain">
          <div id="leftMain" class="bg-grid">
            <?php echo form_label('No pendaftaran', 'nama_izin'); ?>
          </div>
          <div id="rightMain" class="bg-grid">
            <?php 
            echo $nopendaftaran;
            echo form_hidden('nopendaftaran', $nopendaftaran);
            ?>
          </div>
        </div>

        <div id="statusMain">
          <div id="leftMain">
            <?php echo form_label('Jenis layanan', 'kelompok_izin'); ?>
          </div>
          <div id="rightMain">
            <?php echo $jenislayanan; ?>
          </div>
        </div>

        <div id="statusMain">
          <div id="leftMain" class="bg-grid">
            <?php echo form_label('Nama Pemohon', 'keterangan'); ?>
          </div>
          <div id="rightMain" class="bg-grid">
            <?php echo $namapemohon; ?>
          </div>
        </div>

        <div id="statusMain">
          <div id="leftMain">
            <?php echo form_label('Alamat Pemohon', 'jenis_permohonan'); ?>
          </div>
          <div id="rightMain">
            <?php echo $alamatpemohon; ?>
          </div>
        </div>

        <div id="statusMain">
          <div id="leftMain" class="bg-grid">
            <?php echo form_label('Nama Perusahaan', 'jenis_permohonan'); ?>
          </div>
          <div id="rightMain" class="bg-grid">
            <?php echo $namaperusahaan; ?>
          </div>
        </div>

        <div id="statusMain">
          <div id="leftMain">
            <?php echo form_label('Catatan'); ?>
  					<br><br>
          </div>
          <div id="rightMain">
            <?php
            echo $pesan;
            echo form_hidden('pesankomentar', $pesan);
            ?>
            <br><br>
          </div>
        </div>

        <div id="statusMain">
          <div id="leftMain" class="bg-grid">
            <?php echo form_label('No BAP', 'jenis_permohonan'); ?>
          </div>
          <div id="rightMain" class="bg-grid">
            <?php
            echo $nosk;
            echo form_hidden('nobap', $nosk);
            ?>
          </div>
        </div>

        <?php
        if($kelompok->id == "2" || $kelompok->id == "4"){
        ?>
          <div id="statusMain">
            <div id="leftMain">
              <?php echo form_label('Tanggal Peninjauan', 'jenis_permohonan'); ?>
            </div>
              <div id="rightMain">
                <?php echo $this->lib_date->mysql_to_human($tglperiksa); ?>
            </div>
          </div>
          <?php
        }
          ?>

        <div id="statusMain">
          <br>
          <table border="1" width="900" cellpadding="2px" cellspacing="0" align="center">
  			    <?php $jml_property = $this->lib_date->data_property($id_izin,'1'); ?>
            <tr>
	  					<td colspan="6" align="center" bgcolor="#CED9FE" height="33px"><b>PROPERTY</b></td>
            <tr>
            <tr>
            <?php 
            if($jml_property == '0'){ 
            ?>
				      <td colspan="3" align="center" height="25"><b>Data Property Belum Diseting</b></td>
            <?php } else { ?>
						  <td colspan="3" align="center" height="25"><b>Data Berkas Permohonan</b></td>
              <?php 
						}
            //if($kelompok->id == "2" || $kelompok->id == "4"){
              ?>
            <td colspan="3" align="center" height="25"><b>Data Tinjauan</b></td>
            <?php
			      //}
						?>
            <tr>
            <?php
						if($jml_property == '0') {
              $stat_property = FALSE;
		        }else {
              $i = 1;
							$stat_property = TRUE;
	            $text = $this->lib_date->data_property($id_izin,'2');
              if($jml_property > '1') {
						    $text = $this->lib_date->sort_property($id_izin, $text);
							}
              $list = explode (",",$text);
              foreach ($list as $data) {
         			  $nprop = $this->lib_date->array_property('1',$data);             // Nama Property
								$property_aktif = $this->lib_date->array_property('11',$data);   // Aktifasi Property
								$data_property = $this->lib_date->isi_property($id_daftar, $this->lib_date->array_property('0',$data), '1');
								$hitung = strlen($data_property);
                $cek_posisi = strpos($data_property,'^'); 
							  $hasil = substr($data_property,0,$cek_posisi);
							  $hasil2 = substr($data_property,$cek_posisi+1,$hitung);
                if($property_aktif == 'Ya') {
								  if($i % 2 == 0) {
                    $color = "#FFFFFF";
                  }else{
                    $color = "#CED9FE";
                  }

								  echo "<tr bgcolor='" . $color . "'>";
            ?>
			            <td><?php echo $nprop; ?></td>  
                  <td colspan="2"><?php echo $hasil; ?></td>
                  <?php
                  //if($kelompok->id == "2" || $kelompok->id == "4"){
                  ?>
                  <td><?php echo $nprop; ?></td>
                  <?php
                  //}
							    ?>
								  <td colspan="2"><?php echo $hasil2; ?></td>
                  <?php
								  echo "</tr>";
						      $i++;
                }
              }
						}
                  ?>
          </table>
          <br>
        </div>

        <?php 
				$kelompok = new trkelompok_perizinan_trperizinan();
        $kelompok->where('trperizinan_id', $id_izin)->get();
				if($kelompok->trkelompok_perizinan_id != '1' && $kelompok->trkelompok_perizinan_id != '5') { // untuk yang tidak bertarif dan workflow
				?>
          <div id="statusMain">
            <div id="leftMain">
              <?php echo form_label('Nilai Retribusi', 'nama_izin'); ?>
            </div>
            <div id="rightMain">
              <?php 
              //$total = $retribusi * $z;
              if($m_hitung=="1") {
                if(!empty($hitManualRet->v_tinjauan)) {
                  echo "Rp. ".$this->terbilang->nominal($hitManualRet->v_tinjauan, 2);
                  echo form_hidden('nilai_retribusi', $hitManualRet->v_tinjauan); 
                }else{
                  echo "Rp. ".$this->terbilang->nominal('0', 2);
                  echo form_hidden('nilai_retribusi', '0'); 
                }                        
              }else{
                if(empty($retribusi)) { $retribusi = 0; }
                $total = $retribusi;
                echo "Rp. ".$this->terbilang->nominal($total, 2).
								     "<span style='color:red;'><p><b>( &nbsp; Nilai retribusi belum di konfigurasi &nbsp; )</b></p></span>";
                //$z;
                echo form_hidden('nilai_retribusi', $total);  
              }
              ?>
              <br>
            </div>
          </div>
				  <?php 
				}
				  ?>

        <div id="statusMain">
          <div id="leftMain">
            <?php echo form_label('<b>Catatan TIM Teknis</b>'); ?>
          </div>
          <div id="rightMain">
            <?php echo '<b>'.$pesan.'</b>'; ?>
            <?php echo form_hidden('pesankomentar', $pesan); ?>
          </div>
        </div>
				
				<div id="statusMain">
          <h2>
					  <div id="leftMain">
              <?php echo form_label('Permohonan perizinan', 'nama_izin'); ?>
            </div>
            <div id="rightMain"> 
              <?php
              $cek = TRUE;
              $checked = FALSE;
              $status1 = array('name' => "status",
                               'value' => "1",
                               'id'=>'status',
                               'checked' => $cek,
							                 'onclick' => 'gantiStatus(this.value)'
                              );
              $status2 = array('name' => "status",
                               'value' => "2",
                               'id'=>'status',
                               'checked' => $checked,
							                 'onclick' => 'gantiStatus(this.value)'
                              );
              if($ditetapkan === "1"){
                echo "<b>";
                if($status === "1") echo "Diizinkan";
                else echo "Ditolak";
                echo "</b>";
              }else{
                echo form_radio($status1) . " Diizinkan";
                echo form_radio($status2) . " Ditolak";
              }
              ?>
              <br>
            </div>
          </h2>
        </div>
				<div style="display:block" id="diizinkan">
					<div id="statusMain">
				  	<!--	<div id="leftMain">
						<h2>-->
						<?php 
						if($idjenis == 89 || $idjenis == 91 || $idjenis == 92){
							//echo form_label('Nomor & Tanggal SK', 'nomor_izin');
							if($no_sk_awal == '')
								$simpan = FALSE;
							else
								$simpan = TRUE;
							$akdp = TRUE;
							$simpan = TRUE;  // sementara permintaan mang ACE
						}else{
							if($no_sk_awal == '' && $no_sk_akhir == '') {
								//echo form_label('No Penetapan ( belum di set)', 'nomor_izin');
								$simpan = TRUE;
								$no_sk_awal = '';
								//$no_sk_tengah = '';
								$no_sk_akhir = ' / ';
								//$no_sk_tahun = '';
							}else{
								//echo form_label('No Penetapan', 'nomor_izin'); 
								$simpan = TRUE;
							}
							$akdp = FALSE;
						}
						?>
  					<!--		</h2>
						</div> 
						<div id="rightMain">
						<h2> -->
							<?php
					    /*$Ino_sk_tengah = array(
									'style'=>'width:3%',
									'name' => 'no_sk_tengah',
									'value' => $no_sk_tengah,
									'class' => 'input-wrc required digits'
								);
								$Ino_sk_tahun = array(
									'style'=>'width:15%',
									'name' => 'no_sk_tahun',
									'value' => $no_sk_tahun,
									'class' => 'input-wrc required digits'
								);
								if($akdp){
									if($no_sk_awal == '')
										echo 'Data Tidak dapat disimpan, Nomor Kendaraan atau Nomor Uji Salah';
									else
										echo $no_sk_awal .' Tanggal : '. $this->lib_date->mysql_to_human($akdp_tg_sk);
								}else{
									echo $no_sk_awal;
									echo $no_sk_tengah; //echo form_input($Ino_sk_tengah);
									echo $no_sk_akhir;
									echo $no_sk_tahun; //echo form_input($Ino_sk_tahun);
								}
					   */
					  echo form_hidden('no_sk_awal', $no_sk_awal);
            echo form_hidden('no_sk_tengah', $no_sk_tengah);
						echo form_hidden('no_sk_akhir', $no_sk_akhir);
            echo form_hidden('no_sk_tahun', $no_sk_tahun);
						?>
						<!--</h2>
						</div>-->
					</div>

					<div id="statusMain">
						<div id="leftMain">
							<h2>
								<?php 
								if($akdp){
									if($no_sk_awal <> '')
										echo  form_label('Nomor & Tanggal KP', 'tgl_terbit_sk'); 
								}else{
									echo form_label('Tanggal Penetapan', 'tgl_terbit_sk'); 
								}
								?>
							</h2>
						</div>
						<div id="rightMain">
							<h2>
								<?php
								$tgl_terbit_sk = date('Y-m-d');
								$input_tgl_terbit_sk = array(
									'style'=>'width:10%',
									'name' => 'tgl_terbit_sk',
									'value' => $tgl_terbit_sk,
									'readOnly'=>TRUE,
									'class' => 'monbulan'
								);
								if($akdp){
									if($no_sk_awal <> '')
										echo $no_sk_akhir .' Tanggal : '. $this->lib_date->mysql_to_human($akdp_tg_kp);
								}else{
									echo $this->lib_date->mysql_to_human($tgl_terbit_sk); //echo form_input($input_tgl_terbit_sk);
									echo form_hidden('tgl_terbit_sk', $tgl_terbit_sk);
								}
								?>
							</h2>
						</div>
					</div>
					<?php 
					if($e_ttd == 2){ // metoda Upload 
					?>
						<div id="leftMain">
							<?php 
					    echo form_label('Upload Dokumen Word (.docx)', 'up_dok_sk'); 
							?>
						</div>
						<div id="rightMain">
							<?php
             	if(file_exists('naskah_izin/'.$nopendaftaran.'.docx')){
						    $ket = 'File Naskah Tersedia ';
						    $iicn = ' Perbaiki File Naskah ';
								$simpan1 = TRUE;
							}else{
								$ket = ' ';
						    $iicn = ' Ambil File Naskah Izin ';
								$simpan1 = FALSE;
							}
							echo $ket;
							if($stat_stop_esl2 == 1){
                echo anchor(site_url('permohonan/penetapan/showform/0/'.$id.'/'.$idjenis.'/'.$nopendaftaran), $iicn, 'class="link-wrc" rel="upload_box"');
              }else{
                echo 'TIDAK DIPERKENANKAN UPLOAD NASKAH !.. BELUM ADA PENETAPAN ESELON II ! ';
              }
							
							if($ket != ' '){
								echo '&nbsp'.anchor(site_url('permohonan/sk/cetak_sk/'.$id.'/3'), 'Lihat Naskah', 'class="link-wrc"');
							}
					    ?>
						</div>
					  <?php
					}else{
						$simpan1 = TRUE;
            if ($e_ttd == 1) { ?>
              <div id="leftMain">
              <?php 
              echo form_label('Preview Dokumen', 'prev_dok_sk'); 
              ?>
              </div>
              <div id="rightMain">
                <?php
                  echo '&nbsp';
                ?><a href="<?php echo base_url().'permohonan/sk/cetak_preview/'.$id.'/1/1'; ?>" class="link-wrc" onclick="$('#pageloader').fadeIn(); setTimeout(function() {
         window.location.reload();
      }, 39000);">Preview Naskah</a>
              </div>
            <?php }
					} 
					  ?>

					<table><tr><td colspan="6" align="center" height="33px"></td></tr></table>
					<table border="1" width="100%" cellpadding="2px" cellspacing="0" align="center">
            <tr>
						  <td colspan="6" align="center" bgcolor="#CED9FE" height="33px">
                <div class="entry" style="text-align: center;">
                  <?php
                  $save = array('name' => 'submit',
                                'class' => 'submit-wrc',
                                'content' => 'Simpan',
                                'type' => 'submit',
                                'value' => 'Simpan'
                               );
                  if($ditetapkan !== "1") {
                    if($simpan1) {
                    	if($stat_stop_esl2 == 1)
                        echo form_submit($save);
                      else
                        echo 'BELUM ADA PENETAPAN ESELON II ! ';  
       			  			}
	             		}
                  echo form_close();
                  echo "<span></span>";
                  $cancel_daftar = array('name' => 'button',
                                         'class' => 'button-wrc',
                                         'content' => 'Batal',
                                         'onclick' => 'parent.location=\''. site_url('permohonan/penetapan/index') . '\''     // OLD index_next
                                        );
                  echo form_button($cancel_daftar);
                  ?>
                </div>
					  	</td>
					  </tr>
          </table>
				</div>
				
				<div style="display:none" id="ditolak">
					<div id="statusMain">
						<div id="leftMain">
							<h2>Alasan Penolakan</h2>
						</div>
						<div id="rightMain">
							<p><br><a class="submit-wrc" id="addAlasan" style="margin-left:20px;">Tambah Alasan</a></p>
							<h4>Gunakan Tanda $1{ utk tab lv.1, $2{ utk tab lv.2, $3{ utk tab lv.3 </h4>
							<div id="alasan">
                <?php echo $alenia1; ?>
								<p>
							    <a class="text">1.</a>
									<textarea name="alasan[]" class="input-wrc required alasan" style="width:80%;height:60px;margin-top:10px" disabled required></textarea>
								</p>
							</div>
						</div>
					</div>

					<table><tr><td colspan="6" align="center" height="33px"></td></tr></table>
					<table border="1" width="100%" cellpadding="2px" cellspacing="0" align="center">
            <tr>
  						<td colspan="6" align="center" bgcolor="#CED9FE" height="33px">
                <div class="entry" style="text-align: center;">
                  <?php
                  $save = array('name' => 'submit',
                                'class' => 'submit-wrc',
                                'content' => 'Simpan',
                                'type' => 'submit',
                                'value' => 'Simpan'
                               );
                  if($ditetapkan !== "1") {
                    if($simpan) {
                      echo form_submit($save);
       			  			}
	             		}
                  echo form_close();
                  echo "<span></span>";
                  $cancel_daftar = array('name' => 'button',
                                         'class' => 'button-wrc',
                                         'content' => 'Batal',
                                         'onclick' => 'parent.location=\''. site_url('permohonan/penetapan/index') . '\''     // OLD index_next
                                        );
                  echo form_button($cancel_daftar);
                  ?>
                </div>
		  				</td>
			  		</tr>
          </table>
				</div>
                
				<!--
          <table><tr><td colspan="6" align="center" height="33px"></td></tr></table>
          <table border="1" width="100%" cellpadding="2px" cellspacing="0" align="center">
          <tr>
						<td colspan="6" align="center" bgcolor="#CED9FE" height="33px">
                            <div class="entry" style="text-align: center;">
                                <?php
                                $save = array('name' => 'submit',
                                              'class' => 'submit-wrc',
                                              'content' => 'Simpan',
                                              'type' => 'submit',
                                              'value' => 'Simpan'
                                              );
                                if($ditetapkan !== "1") {
                                    if($simpan) {
                                        echo form_submit($save);
            			  			}
			             		}
								echo $status2['value'];
                                echo form_close();
                                echo "<span></span>";
                                $cancel_daftar = array('name' => 'button',
                                                       'class' => 'button-wrc',
                                                       'content' => 'Batal',
                                                       'onclick' => 'parent.location=\''. site_url('permohonan/penetapan/index') . '\''     // OLD index_next
                                                       );
                                echo form_button($cancel_daftar);
                                ?>
                            </div>
						</td>
					</tr>
        		</table>
				-->
      </fieldset>
    </div>
    <br style="clear: both;" />
  </div>
</div>

<script>
	function gantiStatus(val){
    if(val=="1"){
      $('#diizinkan').show();
      $('#ditolak').hide();
      $(".alasan").attr('disabled', 'true');
    }else{
      $('#diizinkan').hide();
      $('#ditolak').show();
      $(".alasan").removeAttr('disabled');
    }
  }
    
	$(function() {
    var target = $('#alasan');
    var i = $('#alasan p').size() + 1;
    
    $('#addAlasan').live('click', 
      function() {
		    $('<p><a class="text">' + i + '. </a><textarea name="alasan[]" class="input-wrc required alasan" style="width:80%;height:60px;margin-top:10px" required></textarea> <a href="#" id="remove">Remove</a></p>').appendTo(target);
        i++;
        return false;
      });
        
      $('#remove').live('click', function() { 
        if( i > 2 ) {
          $(this).parents('p').remove();
          i--;
        }
        return false;
      }
    );
  });
</script>