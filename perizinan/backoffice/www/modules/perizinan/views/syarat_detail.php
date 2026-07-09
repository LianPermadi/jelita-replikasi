<div id="content">
  <div class="post">
    <div class="title">
      <h2><?php echo $page_name; ?></h2>
    </div>
    <div class="entry">
      <fieldset id="half">
        <legend>Jenis Perizinan</legend>
        <div id="statusRail">
          <div id="leftRail" class="bg-grid">
            <?php
            echo 'Nama Perizinan';
            ?>
          </div>
          <div id="rightRail" class="bg-grid">
            <?php
            foreach ($list as $data) {
              echo $data->n_perizinan;
            }
            ?>
          </div>
        </div>
        <br style="clear: both">
        <p style="text-align: right">
          <?php
          $img_edit = array('src' => 'assets/images/icon/plus.png',
                            'alt' => 'Tambah Syarat Izin',
                            'title' => 'Tambah Syarat Izin',
                            'border' => '0',
                           );
          ?>
          <a class="page-help" href="<?php echo site_url('perizinan/persyaratanizin/create/' . $id); ?>">
            <?php echo img($img_edit); ?>
          </a>
          <?php
          $img_edit = array('src' => 'assets/images/icon/back_alt.png',
                            'alt' => 'Back',
                            'title' => 'Back',
                            'border' => '0',
                           );
          ?>
          <a class="page-help" href="<?php echo site_url('perizinan/persyaratanizin/'); ?>">
            <?php echo img($img_edit); ?>
          </a>
        </p>
      </fieldset>
    </div>

        <?php 
            $alert = $this->session->flashdata("sukses");
            if(!empty($alert)){
          ?>
            <br>
            <div style="color: green; font-size: 12px; margin-left: 20px; margin-bottom: 10px; font-weight: bold;"><center><?php echo $alert; ?></center></div>
            <br>
          <?php } ?>

          <?php 
            $alert = $this->session->flashdata("gagal");
            if(!empty($alert)){
          ?>
            <br>
            <div style="color: red; font-size: 12px; margin-left: 20px; margin-bottom: 10px; font-weight: bold;"><center><?php echo $alert; ?></center></div>
            <br>
          <?php } ?>

    <div class="entry">
      <?php
            $attr = array('name' => 'form', 'id' => 'form');
        echo form_open('perizinan/persyaratanizin/saveurut', $attr);
        ?>
        <input type="hidden" class = "input-wrc" value="<?php echo $id; ?>" name="idizin" style="width: 70%; text-align: center;">
      <table cellpadding="0" cellspacing="0" border="0" class="display" id="syaratizin_detail">
        <thead>
          <tr>
		      	<th width="3%">No</th>
            <th width="47%">Nama Syarat Izin</th>
            <th width="5%">Jumlah Link</th>
            <th width="5%">Urutan</th>
    		  	<th width="5%">Status</th>
            <th width="5%">Izin Baru</th>
            <th width="5%">Daftar Ulang</th>
            <th width="5%">Perpanjangan Izin</th>
				    <th width="5%">Perubahan Izin</th>
				    <th width="5%">Pencabutan Izin</th>
				    <th width="5%">Penutupan Izin</th>
				    <th width="5%">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php
          foreach ($list as $data) { 
            $i = null;

            $trsyarat = $data->trsyarat_perizinan;
                        $trsyarat->order_by('status ASC, (urutan * -1) DESC, urutan = 0, urutan');
                        $datatrsyarat = $trsyarat->get();

            foreach ($datatrsyarat as $list_syarat) {
              $i++;
					    $show_syarat = new trperizinan_syarat();
					    $status_link = $show_syarat->where('trsyarat_perizinan_id', $list_syarat->id)->count();
              $show_syarat->where('trsyarat_perizinan_id', $list_syarat->id)
                          ->where('trperizinan_id', $data->id)->get();

					    $var = $show_syarat->c_show_type;
              $rule = strval(decbin($var));
					    if($show_syarat->status_new == 1) $plv = 6; else $plv = 4; // penambahan pencabutan dan penutupan ditambah 00
              if (strlen($rule) < $plv) {
                $len = $plv - strlen($rule);
                $rule = str_repeat("0", $len) . $rule;
              }
              if($plv == 4) $rule = $rule.'00';                         // penambahan pencabutan dan penutupan ditambah 00
					    $arr_rule = str_split($rule);
              if($plv == 4){
					      $c_baru         = $arr_rule[1];
                $c_daftar_ulang = $arr_rule[0];
					    }else{
						    $c_baru         = $arr_rule[0];
                $c_daftar_ulang = $arr_rule[1];
					    }
              $c_perpanjangan = $arr_rule[2];
              $c_ubah         = $arr_rule[3];
              $c_pencabutan   = $arr_rule[4];
              $c_penutupan    = $arr_rule[5];

              $opsi_ya = "Ya";
              $opsi_tidak = "Tidak";
					    if($show_syarat->status_new == 1){
						    $old = '';
						    $b = '';
				        $be = '';
					    }else{
						    $old = ' ( Old )';
						    $b = '<span style="color: Blue">';
  					    $be = '</span>';
					    }
              ?>
              <tr>
                <td><?php echo $i; ?></td>
                <td><?php echo $b.$list_syarat->v_syarat.$be; ?></td>
						    <td>
						      <center>
							      <?php 
					          echo $b.$status_link . ' Link'.$be; 
					          ?>
							    </center>
					    	</td>
                <td>
                  <center>
                    <?php 
                    if($show_syarat->status == "1") { 
                    	?>
                      <input type="number" class = "input-wrc" value="<?php echo $list_syarat->urutan; ?>" name="urutan[]" style="width: 70%; text-align: center;">
                      <input type="hidden" class = "input-wrc" value="<?php echo $list_syarat->id; ?>" name="idurutan[]" style="width: 70%; text-align: center;">
                      <?php
                    }else{
                    	?>
                      <input type="text" class = "input-wrc" value="" name="urutread" style="width: 70%; text-align: center;" readonly>
                      <?php
                    }
                    ?>
                  </center>
                </td>
                <td>
						      <center>
                    <?php
								    if ($show_syarat->status == "1")
									    $status_data1 = "Wajib";
                    else
                      $status_data1 = "Tidak Wajib";
								    echo $b.$status_data1.$old.$be;
                    ?>
						    	</center>
                </td>
                <td>
  						    <center>
	  						    <?php if($c_baru == "1") echo $b.$opsi_ya.$be; else echo $b.$opsi_tidak.$be; ?>
		    					</center>
				    		</td>
					    	<td>
						      <center>
							      <?php if($c_daftar_ulang == "1") echo $b.$opsi_ya.$be; else echo $b.$opsi_tidak.$be; ?>
							    </center>
					    	</td>
                <td>
						      <center>
							      <?php if($c_perpanjangan == "1")echo $b.$opsi_ya.$be; else echo $b.$opsi_tidak.$be; ?>
							    </center>
					    	</td>
						    <td>
						      <center>
							      <?php if($c_ubah == "1")echo $b.$opsi_ya.$be; else echo $b.$opsi_tidak.$be; ?>
							    </center>
					    	</td>
					    	<td>
						      <center>
							      <?php if($c_pencabutan == "1")echo $b.$opsi_ya.$be; else echo $b.$opsi_tidak.$be; ?>
							    </center>
					    	</td>
						    <td>
						      <center>
							      <?php if($c_penutupan == "1")echo $b.$opsi_ya.$be; else echo $b.$opsi_tidak.$be; ?>
							    </center>
					    	</td>
                
                <td>
                  <?php
                  $img_edit = array('src' => base_url() . 'assets/images/icon/property.png',
                                    'alt' => 'Edit',
                                    'title' => 'Edit',
                                    'border' => '0',
                                   );
                  $img_delete = array('src' => base_url() . 'assets/images/icon/cross.png',
                                      'alt' => 'Delete Link Syarat',
                                      'title' => 'Delete Link Syarat',
                                      'border' => '0',
                                     );
                  $img_download = array('src' => base_url() . 'assets/images/icon/clipboard.png',
                                        'alt' => 'Download Formulir',
                                        'title' => 'Download Formulir',
                                        'border' => '0',
                                       );
                  echo anchor(site_url('perizinan/persyaratanizin/edit').'/'.$data->id.'/'.$list_syarat->id.'/'.$status_link, img($img_edit));
                  echo "&nbsp;";
                  $confirm_text = 'Apakah Anda yakin akan menghapusnya dari Link?';
                  echo anchor(site_url('perizinan/persyaratanizin/delete_link') . '/' . $data->id . '/' . $list_syarat->id, img($img_delete), ' onClick="return confirm_link(\'' . $confirm_text . '\');"');
                  echo "&nbsp;";
                  $data_permohonan_izin = new trproperty();
                  $status_daftar = $data_permohonan_izin->is_perizinan_used_in_permohonan($data->id);
                  if($list_syarat->nama_formulir != ''){
                  	if(file_exists('../assets/userassets/formulir/'.$list_syarat->nama_formulir)){	
                      //die('file tersedia');
											echo anchor('../assets/userassets/formulir/'.$list_syarat->nama_formulir, img($img_download),array("target"=>"_blank","style"=>"color:blue")); 
                    }
                  }
                  ?> 
                </td>
              </tr>
              <?php
            }
          }
              ?>
        </tbody>
        <?php 
                $link = site_url('perizinan/persyaratanizin');
                $add_daftar = array(
                    'name' => 'submit',
                    'class' => 'submit-wrc',
                    'content' => 'Simpan Urutan',
                    'type' => 'submit',
                    'value' => 'Edit Urutan'
                    );

                $cancel_daftar = array(
                    'name' => 'button',
                    'class' => 'button-wrc',
                    'content' => 'Batal',
                    'onclick' => 'parent.location=\'' . $link . '\''
                );
                ?>
        <tfoot>
          <tr>
            <th>No</th>
            <th>Nama Syarat Izin</th>
            <th>Jumlah Link</th>
            <th><?php echo form_submit($add_daftar);?></th>
     			  <th>Status</th>
            <th>Izin Baru</th>
            <th>Daftar Ulang</th>
            <th>Perpanjangan Izin</th>
			    	<th>Perubahan Izin</th>
				    <th>Pencabutan Izin</th>
				    <th>Penutupan Izin</th>
				    <th>Aksi</th>
          </tr>
        </tfoot>
      </table>
      <?php
            echo form_close(); ?>
    </div>
  </div>
  <br style="clear: both;" />
</div>