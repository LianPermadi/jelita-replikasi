<div id="content">
    <div class="post">
        <div class="title">
            <h2><?php echo $page_name; ?></h2>
        </div>
        <div class="entry">
            <?php
			//echo form_hidden('id_user', $id_user);
			$nama = $this->session_info['realname'];
			$user = New user();
            $user->where('realname', $nama)->get();
			$user_group = $user->group;
            $attr = array('id' => 'form');
            if($save_method === 'save') {       // Untuk Tambah Pengguna Baru
                echo form_open('pengguna/'. $save_method, $attr);
                
				echo "<label class='label-wrc'>Nama Asli</label>";
                $realname_input = array(
                    'name' => 'real_name',
                    'class' => 'input-wrc required'
                );
                echo form_input($realname_input);
                
				echo "<br style='clear:both' />";
                echo "<label class='label-wrc'>Username</label>";
                $username_input = array(
                    'name' => 'user_name_',
                    'class' => 'input-wrc required'
                );
                echo form_input($username_input);

                echo "<br style='clear:both' />";
                echo "<label class='label-wrc'>Password</label>";
                $password_input = array(
                    'name' => 'password',
                    'class' => 'input-wrc required'
                );
                echo form_password($password_input);

                // Create PBS
                echo "<br style='clear:both' />";
                echo "<label class='label-wrc'>Lokasi Pengguna</label>";
                //$lokasi_input = array('' => '------ Pilih Salah Satu ------','Pusat' => 'Pusat');  // Untuk daerah lain
                $lokasi_input = array('' => '------ Pilih Salah Satu ------','DPMPTSP Prov. tasikmalaya' => 'DPMPTSP Prov. tasikmalaya',
                                      'Gerai Bogor' => "Gerai Bogor",'Gerai Purwakarta' => 'Gerai Purwakarta','Gerai Garut' => "Gerai Garut",
									  'Gerai Cirebon' => "Gerai Cirebon",'SMS' => "SMS",'Surat' => "Surat",'OPD Teknis' => "OPD Teknis");
				echo form_dropdown('lokasi', $lokasi_input, $lokasi, 'class = "input-select-wrc" id="selector"');

                echo "<br style='clear:both' />";
                echo "<label class='label-wrc'>Group</label>";
                $status1 = array('name' => "status", 'value' => "0", 'id'=>'status', 'checked' => TRUE );
				$status2 = array('name' => "status", 'value' => "1", 'id'=>'status', 'checked' => FALSE );
				$status3 = array('name' => "status", 'value' => "2", 'id'=>'status', 'checked' => FALSE );
				$status4 = array('name' => "status", 'value' => "3", 'id'=>'status', 'checked' => FALSE );
				$status5 = array('name' => "status", 'value' => "4", 'id'=>'status', 'checked' => FALSE );
				echo form_radio($status1) . " User; ";
                echo form_radio($status2) . " Administrator; ";
                echo form_radio($status3) . " Struktural; "; //" Supervisor"
				echo form_radio($status4) . " Entry Pendaftaran; ";
				echo form_radio($status5) . " Evaluator; ";
				// EOF PBS

                echo "<br style='clear:both' />";
                $save_form = array(
                    'name' => 'submit',
                    'class' => 'submit-wrc',
                    'content' => 'Simpan',
                    'type' => 'submit',
                    'value' => 'Simpan'
                );
                echo form_submit($save_form);
                
				echo "<span></span>";
                $cancel = array(
                    'name' => 'button',
                    'class' => 'button-wrc',
                    'content' => 'Batal',
                    'onclick' => 'parent.location=\''. site_url('pengguna') . '\''
                );
                echo form_button($cancel);
                echo form_close();
            } else {    // Untuk Edit Pengguna
                ?>
                <label class="label-wrc">Username</label>
                <?php
                    echo $user_name;
                ?><br /><br />

                <div id="tabs">
                    <ul>
					    <?php if($user_group == "1") { ?>
                            <li><a href="#tabs-1">List Izin</a></li>
						<?php } ?>
                        <li><a href="#tabs-2">Ganti Nama</a></li>
                        <li><a href="#tabs-3">Ganti Password</a></li>
                        <?php if($user_group == "1") { ?>
                            <li><a href="#tabs-4">List Peran</a></li>
						<?php } ?>
                    </ul>
					<?php
                    if($user_group == "1") {
                    ?>
                        <div id="tabs-1">
                            <?php
                            echo form_open(site_url('pengguna/roles'));
                            echo form_hidden('id', $id);
							echo form_hidden('i_izin', $izin_list);
                            $set_all = array(
                                'name' => 'cek_all',
                                'value' => 'yes',
                                'checked' => 'TRUE'
                            );
							echo form_submit('button','Tambah Izin','class="button-wrc"');
							
                            $hapus = array(
                                'name' => 'hapus_all',
                                'class' => 'button-wrc',
                                'id' => 'hapus_all',
                                'content' => 'Hapus Semua Peran Izin',
                                'type' => 'button',
    							'onclick' => 'parent.location=\'' . site_url('pengguna/deleteizin_all/'.$id_user).'\''
                            );
                            echo form_button($hapus);
                            //echo form_checkbox($set_all)."&nbsp;Cek Semua Izin&nbsp;";

                            echo form_close();
                            ?>
                            <br />
                            <table cellpadding="0" cellspacing="0" border="0" class="display" id="izin_list">
                                <thead>
                                    <tr>
                                        <th width="2%">No</th>
										<th width="5%">Kode Izin</th>
                                        <th width="60%">Nama Izin</th>
				         	    		<th width="10%">Bidang</th>
										<th width="20%">Unit Kerja</th>
                                        <th width="3%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 0;
                                    foreach ($izin_list as $izin) {
                                        $i++;
								        // Create PBS 
								        $perizinan_trunitkerja = new trperizinan_trunitkerja();
										//$perizinan_trunitkerja->get_by_id($izin->id);
										$perizinan_trunitkerja->where('trperizinan_id', $izin->id)->get();
                                        $kd_unitkerja = $perizinan_trunitkerja->trunitkerja_id;
                                        $unitkerja = new trunitkerja();
                                        $unitkerja->get_by_id($kd_unitkerja);
										$izin->trsektor->get();
									    // EOF PBS
                                    ?>
								        <tr>
                                            <td><?php echo $i; ?></td>
											<td><?php echo $izin->kd_izin; ?></td>
                                            <td><?php echo $izin->n_perizinan; ?></td>
											<td><?php echo $izin->trsektor->n_sektor; ?></td>
									        <td><?php echo $unitkerja->n_unitkerja; ?></td>
                                            <td>
									    	    <center>
                                                    <?php
                                                    $img_delete = array(
                                                        'src' => 'assets/images/icon/cross.png',
                                                        'alt' => 'Delete',
                                                        'title' => 'Delete',
                                                        'border' => '0'
                                                    );
//                                                    echo "<a href='". site_url('pengguna/deleteizin') .'/'. $id .'/'. $izin->id."' onClick='return confirm(\"Apakah Anda yakin akan menghapusnya?\");'>".img($img_delete)."</a>";
//													echo "<a href='". site_url('pengguna/deleteizin') .'/'. $id .'/'. $izin->id."' onClick='return'>".img($img_delete)."</a>";
													echo anchor(site_url('pengguna/deleteizin') .'/'. $id .'/'. $izin->id, img($img_delete))."&nbsp;";
                                                    ?>
												</center>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                        ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th width="2%">No</th>
										<th width="5%">Kode Izin</th>
                                        <th width="65%">Nama Izin</th>
										<th width="10%">Bidang</th>
								    	<th width="25%">Unit Kerja</th>
                                        <th width="3%">Aksi</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
					    <?php
					}
                        ?>
                    <div id="tabs-2">
                        <?php
                            $attr = array('id' => 'form');
                            echo form_open('pengguna/' . $save_method . "/editName",$attr);
                            echo form_hidden('id', $id);
							                            
							echo "<br style='clear:both' />";
                            echo "<label class='label-wrc'>Nama Asli</label>";
							if($id == 5 ){
                                $oriname_input = array(
                                    'name' => 'ori_name',
                                    'value' => $ori_name,
                                    'class' => 'input-wrc required'
                                );
                                echo form_input($oriname_input);
							}else{
								 echo form_hidden('ori_name', $ori_name);
                                 echo $ori_name;
							}

							echo "<br style='clear:both' />";
                            echo "<label class='label-wrc'>Nama Expose</label>";
                            $realname_input = array(
                                'name' => 'real_name',
                                'value' => $real_name,
                                'class' => 'input-wrc required'
                            );
                            echo form_input($realname_input);
                            
							echo "<br style='clear:both' />";
                            echo "<label class='label-wrc'>Username</label>";
							$username_input = array(
                                'name' => 'user_name',
                                'value' => $user_name,
                                'class' => 'input-wrc required'
                            );
                            echo form_input($username_input);

							echo "<br style='clear:both' />";
                            echo "<label class='label-wrc'>Nomor HP</label>";
                            $no_hp_input = array(
                                'name' => 'no_hp',
                                'value' => $no_hp,
                                'class' => 'input-wrc required'
                            );
                            echo form_input($no_hp_input);
							echo ' masukkan No HP yang Aktif untuk media komunikasi';

							echo "<br style='clear:both' />";
                            echo "<label class='label-wrc'>E-Mail</label>";
                            $email_input = array(
                                'name' => 'email',
                                'value' => $email,
                                'class' => 'input-wrc required'
                            );
                            echo form_input($email_input);
							echo ' masukkan e-mail yang Aktif untuk media komunikasi';
                            
							// Create PBS
							if($user_group == "1") {
                                echo "<br style='clear:both' />";
                                echo "<label class='label-wrc'>Lokasi Pengguna</label>";
								//$lokasi_input = array('' => '------ Pilih Salah Satu ------','Pusat' => 'Pusat','OPD Teknis' => "OPD Teknis");  // Untuk daerah lain
                                $lokasi_input = array('' => '------ Pilih Salah Satu ------','DPMPTSP Prov. tasikmalaya' => 'DPMPTSP Prov. tasikmalaya',
                                      'Gerai Bogor' => "Gerai Bogor",'Gerai Purwakarta' => 'Gerai Purwakarta','Gerai Garut' => "Gerai Garut",
									  'Gerai Cirebon' => "Gerai Cirebon",'SMS' => "SMS",'Surat' => "Surat",'OPD Teknis' => "OPD Teknis");
                                echo form_dropdown('lokasi', $lokasi_input, $lokasi, 'class = "input-select-wrc" id="selector"');

                                if($lokasi == "OPD Teknis"){
									echo "<br style='clear:both' />";
                                    echo "<label class='label-wrc'>Bidang Perizinan</label>";
									if ($list_data) {
                                        foreach ($list_data as $row) {
                                            $opsi_sektor['0'] = "------Pilih salah satu------";
                                            $opsi_sektor[$row->id] = $row->n_sektor;
                                        }
                                    } else {
                                        $opsi_sektor[0] = "";
                                    }
									echo form_dropdown('list_sektor', $opsi_sektor, $sektor, 'class = "input-select-wrc" id="selector"');
								}
                                
                                echo "<br style='clear:both' />";
                                echo "<label class='label-wrc'>Group</label>";
								$cek1 =  TRUE; $cek2 = FALSE; $cek3 = FALSE; $cek4 = FALSE; $cek5 = FALSE;
	    		             	If ($group == '0'){$cek1 =  TRUE; $cek2 = FALSE; $cek3 = FALSE; $cek4 = FALSE; $cek5 = FALSE;}
								If ($group == '1'){$cek1 = FALSE; $cek2 =  TRUE; $cek3 = FALSE; $cek4 = FALSE; $cek5 = FALSE;}
								If ($group == '2'){$cek1 = FALSE; $cek2 = FALSE; $cek3 =  TRUE; $cek4 = FALSE; $cek5 = FALSE;}
								If ($group == '3'){$cek1 = FALSE; $cek2 = FALSE; $cek3 = FALSE; $cek4 = TRUE; $cek5 = FALSE;}
								If ($group == '4'){$cek1 = FALSE; $cek2 = FALSE; $cek3 = FALSE; $cek4 = FALSE; $cek5 = TRUE;}
                                $status1 = array('name' => "status", 'value' => '0', 'id'=>'status', 'checked' => $cek1 );
			            	    $status2 = array('name' => "status", 'value' => '1', 'id'=>'status', 'checked' => $cek2 );
                                $status3 = array('name' => "status", 'value' => "2", 'id'=>'status', 'checked' => $cek3 );
								$status4 = array('name' => "status", 'value' => "3", 'id'=>'status', 'checked' => $cek4 );
								$status5 = array('name' => "status", 'value' => "4", 'id'=>'status', 'checked' => $cek5 );
                                echo form_radio($status1) . " User; ";
                                echo form_radio($status2) . " Administrator; ";
                				echo form_radio($status3) . " Struktural; "; //" Supervisor"
				                echo form_radio($status4) . " Entry Pendaftaran; ";
								echo form_radio($status5) . " Evaluator; ";
							} else {
							    echo form_hidden('lokasi', $lokasi);
								echo form_hidden('group', $group);
			                }
            				// EOF PBS

                            echo "<br />";
                            $edit_realname = array(
                                'name' => 'submit',
                                'class' => 'submit-wrc',
                                'content' => 'Simpan',
                                'type' => 'submit',
                                'value' => 'Simpan Nama'
                            );
                            echo form_submit($edit_realname);
                            echo "<span></span>";
                            $cancel = array(
                                'name' => 'button',
                                'class' => 'button-wrc',
                                'content' => 'Batal',
                                'onclick' => 'parent.location=\''. site_url('pengguna') . '\''
                            );
                            echo form_button($cancel);
                            echo form_close();
                        ?><br />
                    </div>

                    <div id="tabs-3">
                        <!-- edited 12-04-2013 -->
                        <?php
                        
                        $attr = array('id' => 'form_password');
                        echo form_open('pengguna/' . $save_method . "/editPassword",$attr);
                        echo form_hidden('id', $id);
						echo form_hidden('lokasi', $lokasi);
						echo form_hidden('group', $group);
                            
                        $password_lbl = array(
                             'class' => 'label-wrc',
                        );
                        
						
						if($usr_login == '5'){
                             echo form_label('OLD Password','',$password_lbl);
							 echo $old_pass;
        				     echo "<br style='clear:both' />";
                        }

						echo form_label('New Password','',$password_lbl);

						$password_input = array(
                             'name' => 'password1',
                             'class' => 'input-wrc required'
                        );
                        echo form_password($password_input)."<br>";
                            
                        ?><br />
                        <?php
                        $edit_password = array(
                            'name' => 'submit',
                            'class' => 'submit-wrc',
                            'content' => 'Simpan',
                            'type' => 'submit',
                            'value' => 'Simpan Password'
                        );
                        echo form_submit($edit_password);
                        echo "<span></span>";
                        
						$cancel = array(
                            'name' => 'button',
                            'class' => 'button-wrc',
                            'content' => 'Batal',
                            'onclick' => 'parent.location=\''. site_url('pengguna') . '\''
                        );
                        echo form_button($cancel);
                        echo form_close();
                        ?><br />
                        <!-- End edit -->
                    </div>
                    <?php
					if($user_group == "1") {
                    ?>
                        <div id="tabs-4">
                            <?php
                            echo form_open(site_url('pengguna/roles'));
                            echo form_hidden('id', $id);
                            $set_all = array(
                                'name' => 'cek_all',
                                'value' => 'yes',
                                'checked' => 'TRUE'
                            );
                            echo form_submit('button','Tambah Peran','class="button-wrc"');
                           // echo form_checkbox($set_all)."&nbsp;Cek Semua Izin&nbsp;";
                            echo form_close();
                            ?>
                            <br />
                            <table cellpadding="0" cellspacing="0" border="0" class="display" id="peran_list">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Peran</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 0;
                                    foreach ($peran_list as $peran) {
                                        $i++;
                                    ?>
                                        <tr>
                                            <td><?php echo $i; ?></td>
                                            <td><?php echo $peran->description; ?></td>
                                            <td>
											    <center>
                                                    <?php
                                                    $img_delete = array(
                                                        'src' => 'assets/images/icon/cross.png',
                                                        'alt' => 'Delete',
                                                        'title' => 'Delete',
                                                        'border' => '0'
                                                    );
                                                    echo "<a href='". site_url('pengguna/deleterole') .'/'. $id .'/'. $peran->id."' onClick='return confirm(\"Apakah Anda yakin akan menghapusnya?\");'>".img($img_delete)."</a>";
                                                    ?>
												</center>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                        ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Peran</th>
                                        <th>Aksi</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
					    <?php
					}
                        ?>
                </div>
                <label>&nbsp;</label>
                <div class="spacer"></div>
                <?php
            }
                ?>
        </div>
    </div>
    <br style="clear: both;" />
</div>
