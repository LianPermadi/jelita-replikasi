<script>
  function cekstatuscheckbox(frmchk) {
    var chk=document.getElementById("chk"+frmchk);
    if(chk.checked == true) {
      document.getElementById("subchk1"+frmchk).disabled="";   
      document.getElementById("subchk2"+frmchk).disabled="";   
      document.getElementById("subchk3"+frmchk).disabled="";
		  document.getElementById("subchk4"+frmchk).disabled="";
		  document.getElementById("subchk5"+frmchk).disabled="";
		  document.getElementById("subchk6"+frmchk).disabled="";
      document.getElementById("subcmb"+frmchk).disabled="";
    } else {
      document.getElementById("subchk1"+frmchk).disabled="disabled";   
      document.getElementById("subchk2"+frmchk).disabled="disabled";   
      document.getElementById("subchk3"+frmchk).disabled="disabled";
		  document.getElementById("subchk4"+frmchk).disabled="disabled";
		  document.getElementById("subchk5"+frmchk).disabled="disabled";
		  document.getElementById("subchk6"+frmchk).disabled="disabled";
      document.getElementById("subcmb"+frmchk).disabled="disabled";
      document.getElementById("subchk1"+frmchk).checked=false;   
      document.getElementById("subchk2"+frmchk).checked=false;   
      document.getElementById("subchk3"+frmchk).checked=false;
		  document.getElementById("subchk4"+frmchk).checked=false;
		  document.getElementById("subchk5"+frmchk).checked=false;
		  document.getElementById("subchk6"+frmchk).checked=false;
      document.getElementById("subcmb"+frmchk).value="2";
    }
  }
</script>

<div id="content">
  <div class="post">
    <div class="title">
      <h2><?php echo $page_name; ?></h2>
    </div>
    <div class="entry">
      <div id="tabs">
        <ul>
          <?php
          $open = FALSE;
          $cancel_syarat = array('name' => 'button',
                                 'class' => 'button-wrc',
                                 'content' => 'Batal',
                                 'onclick' => 'parent.location=\''. site_url('perizinan/persyaratanizin/detail') . "/" . $perizinan_id  . '\''
                                );
          if($save_method=='save') {
            $open = TRUE;
            ?>
            <li><a href="#tabs-1">Tambah Syarat Izin dari Database</a></li>
            <?php
          }
            ?>
          <li><a href="#tabs-2">Tambah Syarat Izin Baru</a></li>
        </ul>
        <?php
        if($open){
        ?>
          <div id="tabs-1">
            <ul id="data_list">
              <?php
              if($save_method=='save'){
                echo form_open('perizinan/persyaratanizin/' . $save_method. '_list');
                echo form_hidden('id', $id);
                echo form_hidden('perizinan_id', $perizinan_id);
              ?>
                <table cellpadding="0" cellspacing="0" border="0" class="display" id="syarat">
                  <thead>
                    <tr>
                      <th width="2%">&nbsp;</th>
                      <th width="55%">Nama Syarat</th>
                      <th width="3%">Link</th>
						          <th width="7%">Status</th>
                      <th width="5%">Izin Baru</th>
                      <th width="5%">Daftar Ulang</th>
                      <th width="5%">Perpanjangan Izin</th>
						          <th width="5%">Perubahan Izin</th>
						          <th width="5%">Pencabutan Izin</th>
						          <th width="5%">Penutupan Izin</th>
						          <th width="3%">Aksi</th>
                    </tr>
                  </thead>
                  <tbody> 
                    <?php
                    $i=1;
                    foreach ($syarat_list as $syarat) {
                      $showed = TRUE;
                      foreach ($perizinan_syarat as $izin_syarat) {
                        if($izin_syarat->id === $syarat->id) {
                          $showed = FALSE;
                          break;
                        }
                      }

                      if($showed) {
							          $hit_syarat = new trsyarat_perizinan();
               					$hit_syarat = $hit_syarat->where('v_syarat', $syarat->v_syarat)->count();
							          if($hit_syarat == 1){
                          $b = ''; $be = '';
              					}else{
                          $b = '<span style="color: Red">'; $be = '</span>';
			                  }

							          $show_syarat = new trperizinan_syarat();
          							$status_link = $show_syarat->where('trsyarat_perizinan_id', $syarat->id)->count();
                        echo "<tr>";
                        //Col 1
								        $set = array('name' => 'syarat[]',
                                     'value' => $syarat->id,
                                     "id"=>"chk".$i,
                                     "onclick"=>"cekstatuscheckbox('".$i."');"
                                    );
								        echo "<td>".form_checkbox($set)."</td>";
  								
								        //Col 2
								        echo "<td>".$b.$syarat->v_syarat.$be."</td>";
                                          
         								//Col 3
					        			echo "<td align='right'>".$b.$status_link.$be."</td>";
  			                    
								        //Col 4
                        $opsi_status = array('2'  => 'Tidak Wajib','1'  => 'Wajib');                            
                        echo "<td>".form_dropdown('status[]', $opsi_status,'2',' disabled="disabled" class = "input-select-all" id="subcmb'.$i.'"')."</td>";
                                          
								        //Col 5
								        $set_baru = array('name' => 'c_baru[]',
                                          'value' => $syarat->id,
                                          "disabled"=>"disabled",
                                          "id"=>"subchk1".$i
                                         );
                        echo "<td align='center'>".form_checkbox($set_baru)."</td>";
                                          
								        //Col 6
							          $set_daftar_ulang = array('name' => 'c_daftar_ulang[]',
                                                  'value' => $syarat->id,
                                                  "disabled"=>"disabled",
                                                  "id"=>"subchk2".$i
                                                 );
                        echo "<td align='center'>".form_checkbox($set_daftar_ulang)."</td>";
                                          
								        //Col 7
                        $set_perpanjangan = array('name' => 'c_perpanjangan[]',
                                                  'value' => $syarat->id,
                                                  "disabled"=>"disabled",
                                                  "id"=>"subchk3".$i
                                                 );
                        echo "<td align='center'>".form_checkbox($set_perpanjangan)."</td>";

								        //Col 8
                        $set_ubah = array('name' => 'c_ubah[]',
                                          'value' => $syarat->id,
                                          "disabled"=>"disabled",
                                          "id"=>"subchk4".$i
                                         );
                        echo "<td align='center'>".form_checkbox($set_ubah)."</td>";

								        //Col 9
                        $set_pencabutan = array('name' => 'c_pencabutan[]',
                                                'value' => $syarat->id,
                                                "disabled"=>"disabled",
                                                "id"=>"subchk5".$i
                                               );
                        echo "<td align='center'>".form_checkbox($set_pencabutan)."</td>";

								        //Col 10
                        $set_penutupan = array('name' => 'c_penutupan[]',
                                               'value' => $syarat->id,
                                               "disabled"=>"disabled",
                                               "id"=>"subchk6".$i
                                              );
                        echo "<td align='center'>".form_checkbox($set_penutupan)."</td>";
                                          
								        //Col 11
  								      $img_delete = array('src' => base_url() . 'assets/images/icon/cross.png',
                                            'alt' => 'Delete Syarat',
                                            'title' => 'Delete Syarat',
                                            'border' => '0',
                                           );
			  					      $confirm_text = 'Apakah Anda yakin akan menghapus syarat ini secara permanen?';
			  					      $img_info = array('src' => base_url() . 'assets/images/icon/information.png',
                                          'alt' => 'Lihat Nama Izin',
                                          'title' => 'Lihat Nama Izin',
                                          'border' => '0',
                                         );
		  						      if($status_link == 0) {
			  					        echo "<td align='center'>".anchor(site_url('perizinan/persyaratanizin/delete') . '/' . $perizinan_id . '/' .$syarat->id , img($img_delete), 'onClick="return confirm_link(\'' . $confirm_text . '\')"')."</td>";
  								      } else {
    								      echo "<td align='center'>".anchor(site_url('perizinan/persyaratanizin/dsp_izin') . '/' . $perizinan_id . '/' .$syarat->id , img($img_info))."</td>";
	  						      	}
							          echo "</tr>";
                      }
                      $i++;
                    }
                    ?>
                  </tbody>
                </table>
                <div class="contentForm" style="text-align: center; margin-top: 10px;">
                  <?php
                  $add_syarat = array('name' => 'submit',
                                      'class' => 'submit-wrc',
                                      'content' => 'Simpan',
                                      'type' => 'submit',
                                      'value' => 'Simpan'
                                     );
                  echo form_submit($add_syarat);
                  echo "<span></span>";
                  echo form_button($cancel_syarat);
                  echo form_close();
                  ?>
                </div>
		              <?php
		          }
			            ?>
            </ul>
          </div>
          <?php
        }
          ?>

        <div id="tabs-2">
          <?php
          $attr = array('id' => 'form');
          echo form_open('perizinan/persyaratanizin/' . $save_method,$attr);
          echo form_hidden('id', $id);
          echo form_hidden('si', $si);
          echo form_hidden('si2', $si2);
          echo form_hidden('perizinan_id', $perizinan_id);
          ?>
          <div class="contentForm">
            <?php
			      if($s_link == 1 || $user_id == 5) { // id 5 = PBS
              $v_syarat_input = array('name' => 'v_syarat',
                                      'value' => $v_syarat,
                                      'class' => 'input-area-wrc required',
                                      'style' => 'min-width:400pt'
                                     );
		        } else {
		    	    $v_syarat_input = array('name' => 'v_syarat',
                                      'value' => $v_syarat,
                                      'class' => 'input-area-wrc required',
    				                          'readOnly'=>TRUE,
                                      'style' => 'min-width:400pt'
                                     );
		        }
            echo form_label('Nama Syarat');
            echo form_textarea($v_syarat_input);
            ?>
          </div>
              
	      	<div class="contentForm">
            <?php
            $opsi_status = array('2'  => 'Tidak Wajib',
                                 '1'  => 'Wajib'
                                );
             
            echo form_label('Status');
            if ($status=="ok") {
              echo form_dropdown('status', $opsi_status,'2','class = "input-select-all"');
            } else {
              echo form_dropdown('status', $opsi_status,$status,'class = "input-select-all"');
            }
            ?>
          </div>

          <div style="clear: both"/>
          <div class="contentForm">
            <?php
            $sts_baru = array('0'  => 'Tidak',
                              '1'  => 'Ya'
                             );
            echo form_label('Pendaftaran Baru');
            if($c_baru=="ok") {
              echo form_dropdown('c_baru', $sts_baru,'1','class = "input-select-all"');
            } else {
              echo form_dropdown('c_baru', $sts_baru,$c_baru,'class = "input-select-all"');
            }
            ?>
            <div style="clear: both"/>
          </div>

			    <div class="contentForm">
            <?php
            $sts_daftar_ulang = array('0'  => 'Tidak',
                                      '1'  => 'Ya'
                                     );
            echo form_label('Daftar Ulang');
            if($c_daftar_ulang=="ok") {
              echo form_dropdown('c_daftar_ulang', $sts_daftar_ulang,'1','class = "input-select-all"');
            } else {
              echo form_dropdown('c_daftar_ulang', $sts_daftar_ulang,$c_daftar_ulang,'class = "input-select-all"');
            }
            ?>
            <div style="clear: both"/>
          </div>

          <div class="contentForm">
            <?php
            $sts_perpanjangan = array('0'  => 'Tidak',
                                      '1'  => 'Ya'
                                     );
            echo form_label('Perpanjangan Izin');
            if($c_perpanjangan=="ok") {
              echo form_dropdown('c_perpanjangan', $sts_perpanjangan,'1','class = "input-select-all"');
            } else {
              echo form_dropdown('c_perpanjangan', $sts_perpanjangan,$c_perpanjangan,'class = "input-select-all"');
            }
            ?>
            <div style="clear: both"/>
          </div>

          <div class="contentForm">
            <?php
            $sts_ubah = array('0'  => 'Tidak',
                              '1'  => 'Ya'
                             );
            echo form_label('Perubahan Izin');
            if($c_ubah=="ok") {
              echo form_dropdown('c_ubah', $sts_ubah,'1','class = "input-select-all"');
            } else {
              echo form_dropdown('c_ubah', $sts_ubah,$c_ubah,'class = "input-select-all"');
            }
            ?>
            <div style="clear: both"/>
          </div>

		    	<div class="contentForm">
            <?php
            $sts_pencabutan = array('0'  => 'Tidak',
                                    '1'  => 'Ya'
                                   );
            echo form_label('Pencabutan Izin');
            if($c_pencabutan=="ok") {
              echo form_dropdown('c_pencabutan', $sts_pencabutan,'1','class = "input-select-all"');
            } else {
              echo form_dropdown('c_pencabutan', $sts_pencabutan,$c_pencabutan,'class = "input-select-all"');
            }
            ?>
            <div style="clear: both"/>
          </div>

			    <div class="contentForm">
            <?php
            $sts_penutupan = array('0'  => 'Tidak',
                                   '1'  => 'Ya'                            
                                  );
            echo form_label('Penutupan Izin');
            if($c_penutupan=="ok") {
              echo form_dropdown('c_penutupan', $sts_penutupan,'1','class = "input-select-all"');
            } else {
              echo form_dropdown('c_penutupan', $sts_penutupan,$c_penutupan,'class = "input-select-all"');
            }
            ?>
            <div style="clear: both"/>
          </div>
          
          <br>
          <div class="contentForm">
            <?php
            echo form_label('Upload Formulir (.pdf)', 'up_pdf'); 
            echo anchor(site_url('perizinan/persyaratanizin/showform/'.$perizinan_id.'/'.$id), 'Ambil Formulir', 'class="link-wrc" rel="upload_box"');
            ?>
            <div style="clear: both"/>
          </div>

          <div style="clear: both"/>
          <div class="contentForm" style="text-align: center; margin-top: 10px;">
            <?php
            $add_syarat2 = array('name' => 'submit',
                                 'class' => 'submit-wrc',
                                 'content' => 'Simpan',
                                 'type' => 'submit',
                                 'value' => 'Simpan'
                                );
            echo form_submit($add_syarat2);
            echo "<span></span>";
            echo form_button($cancel_syarat);
            echo form_close();
            ?>
          </div>
        </div>
      </div>
    </div>
  </div>
  <br style="clear: both;" />
</div>