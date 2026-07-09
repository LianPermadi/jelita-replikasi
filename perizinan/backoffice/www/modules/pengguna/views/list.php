<div id="content">
    <div class="post">
        <div class="title">
            <h2><?php echo $page_name; ?></h2>
        </div>
        <?php 
		$nama = $this->session_info['realname'];
        $user = New user();
        $user->where('realname', $nama)->get();
        $group = $user->group;
		if($cek_adm != 0) { 
		?>
		    <div class="entry">
    		    <fieldset>
	    	        <legend>Filter Data</legend>
                    <?php
                    $attr = array('class' => 'searchForm',
                                  'id' => 'searchForm'
                                 );
                    echo form_open("pengguna/index", $attr);

	    		    if ($list_data) {
                        foreach ($list_data as $row) {
                            $opsi_auth['0'] = "-- Mengabaikan Hak Akses --";
                            $opsi_auth[$row->id] = $row->description;
                        }
                    } else {
                        $opsi_auth[0] = "";
                    }

			        $cari = array('name' => 'submit',
                                  'value'=>'Cari',
                                  'class' => 'button-wrc',
                                  'content' => 'Cari',
                                  'type' => 'submit',
                                  'onclick' => 'return validasi()'
                                 );
		            ?>
		            <table>
                        <tr>
                            <td> <?php echo form_label('Hak Aksess', 'label_permohonan');
                                echo form_hidden('mark', 'tanda'); ?>
	    	                </td>
                            <td> <?php
                                if ($mark == "tanda") {
                                    echo form_dropdown('list_auth', $opsi_auth, $auth, 'class = "input-select-wrc" id="selector"');
                                } else {
                                    echo form_dropdown('list_auth', $opsi_auth, '0', 'class = "input-select-wrc" id="selector"');
                                }
                                 ?>
                            </td>
                        </tr>
                        <?php
	    		            If ($xgroup == '9'){$cek0 =  TRUE; $cek1 = FALSE; $cek2 = FALSE; $cek3 = FALSE; $cek4 = FALSE; $cek5 = FALSE;}
							If ($xgroup == '0'){$cek0 = FALSE; $cek1 =  TRUE; $cek2 = FALSE; $cek3 = FALSE; $cek4 = FALSE; $cek5 = FALSE;}
							If ($xgroup == '1'){$cek0 = FALSE; $cek1 = FALSE; $cek2 =  TRUE; $cek3 = FALSE; $cek4 = FALSE; $cek5 = FALSE;}
							If ($xgroup == '2'){$cek0 = FALSE; $cek1 = FALSE; $cek2 = FALSE; $cek3 =  TRUE; $cek4 = FALSE; $cek5 = FALSE;}
							If ($xgroup == '3'){$cek0 = FALSE; $cek1 = FALSE; $cek2 = FALSE; $cek3 = FALSE; $cek4 =  TRUE; $cek5 = FALSE;}
							If ($xgroup == '4'){$cek0 = FALSE; $cek1 = FALSE; $cek2 = FALSE; $cek3 = FALSE; $cek4 = FALSE; $cek5 = TRUE; }
                            $status0 = array('name' => "status", 'value' => '9', 'id'=>'status', 'checked' => $cek0 );
							$status1 = array('name' => "status", 'value' => '0', 'id'=>'status', 'checked' => $cek1 );
			            	$status2 = array('name' => "status", 'value' => '1', 'id'=>'status', 'checked' => $cek2 );
                            $status3 = array('name' => "status", 'value' => "2", 'id'=>'status', 'checked' => $cek3 );
							$status4 = array('name' => "status", 'value' => "3", 'id'=>'status', 'checked' => $cek4 );
							$status5 = array('name' => "status", 'value' => "4", 'id'=>'status', 'checked' => $cek5 );
                            echo form_radio($status0) . " -None-; ";
							echo form_radio($status1) . " User; ";
                            echo form_radio($status2) . " Administrator; ";
                			echo form_radio($status3) . " Struktural; "; //" Supervisor"
				            echo form_radio($status4) . " Entry Pendaftaran; ";
							echo form_radio($status5) . " Evaluator; ";
                        ?>
		                <tr>
	    			        <td>
						        <?php 
    							echo form_button($cari);
                                echo form_close(); 
                                if($group == "1") {
									// catatan : tambah data diarahkan untuk selalu tambah pegawai dan tidak ke site_url('pengguna/create')
                                    $add_role = array('name' => 'button',
                                                      'class' => 'button-wrc',
                                                      'content' => 'Tambah Pengguna',
                                                      'onclick' => 'parent.location=\''. site_url('petugas') . '\''
                                                     );
                                    echo form_button($add_role);
                                    if($ket_exist){
                                        echo "<div class='entry' align=center><b style='color: #FF0000;'>Username \"".$ket_exist."\" sudah digunakan !!</b></div>";
                                    }
                                }
                                ?>
                            </td>
		                </tr>
			    	</table>
                </fieldset>
            </div>
        <?php } ?>

        <div class="entry">
            
            <table cellpadding="0" cellspacing="0" border="0" class="display" id="user">
                <thead>
                    <tr>
                        <th width ="4%">No</th>
						<th width ="9%">User ID<br>User Name</th>
						<th width ="20%">Nama Asli<br>Nama Expose</th>
						<th width ="15%">Lokasi Pengguna<br>Badang Perizinan</th>
						<th width ="15%">Nomor HP<br>Alamat E-Mail</th>
                        <th width ="31%">KD Log<br>Log Masuk Terakhir</th>
                        <th width ="6%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
				    $nou = 0;
                    foreach ($list as $data){
						$sektor = new trsektor();
						$sektor = $sektor->where('id', $data->sektor)->get();
						if($sektor->n_sektor == '') $n_sektor = '.....'; else $n_sektor = $sektor->n_sektor;
						$user_id = $data->id;
						$kd_auth = new user_user_auth();
						$kd_auth = $kd_auth->where('user_id', $user_id)->where('user_auth_id', $auth)->get();
						$hit_user = new user();
						$hit_user = $hit_user->where('username', $data->username)->count();
						$hit_pegawai = new tmpegawai_user();
						$hit_pegawai = $hit_pegawai->where('user_id', $user_id)->get();
						$id_pegawai = $hit_pegawai->tmpegawai_id;
						if(!$id_pegawai) $id_pegawai = '..';
                        if($hit_user == 1){
                            $b = ''; $be = '';
						}else{
                            $b = '<span style="color: Red">'; $be = '</span>';
						}
						if(($auth == 0 || $auth == $kd_auth->user_auth_id ) && ($data->group == $xgroup || $xgroup == '9' )){
		    				$nou++;
                    ?>
                            <tr>
				    	        <td valign='top'><?php echo $nou; ?></td>
                                <td valign='top'>
	    				    	    <?php
                                        $u_id = strlen($user_id);
                                        for ($i = 3; $i > $u_id; $i--) {
                                            $user_id = "0" . $user_id;
                                        }
					                    echo $b.$user_id.'<br>'.$data->username.$be;
			                        ?>
    						    </td>
	    						<td valign='top'><?php echo $b.$data->oriname.'<br>'.$data->realname.$be; ?></td>
		    					<td valign='top'><?php echo $b.$data->lokasi.'<br>'.$n_sektor.$be; ?></td>
			    			    <td valign='top'><?php echo $b.$data->no_hp.'<br>'.$data->email.$be; ?></td>
				    			<!--<td valign='top'><?php echo $b.$data->last_login.$be; ?></td>-->
                                <td valign='top'>
						    	    <?php
							    	    echo $b.$data->last_login.'<br>'.$be;
								        if($data->last_login){
								            echo $b.timespan($data->last_login).$be;
    							        }else{
	    									echo $b."0 Menit".$be;
		    							}
			    				    ?>
				    			</td>
                                <td valign='top'>
                                        <?php
                                        $img_edit = array('src' => 'assets/images/icon/property.png',
                                                          'alt' => 'Edit'.' -> '.$data->realname,
                                                          'title' => 'Edit'.' -> '.$data->realname,
                                                          'border' => '0',
                                                          );
				    		            $confirm_text = 'Apakah Anda yakin akan menghapus '.$data->username.'?';

                                        $img_synkron = array('src' => 'assets/images/icon/status.png',
                                                          'alt' => $user_id.' <-> '.$id_pegawai.' Sinkron',
                                                          'title' => $user_id.' <-> '.$id_pegawai.' Sinkron',                  
                                                          'border' => '0',
                                                          );

										$img_unsyn = array('src' => 'assets/images/icon/status-busy.png',
                                                          'alt' => 'Sinkronisasi '.$user_id.' <-> '.$id_pegawai,
                                                          'title' => 'Sinkronisasi '.$user_id.' <-> '.$id_pegawai,                  
                                                          'border' => '0',
                                                          );

                                        $img_delete = array('src' => 'assets/images/icon/cross.png',
                                                            'alt' => 'Delete'.' -> '.$data->realname,
                                                            'title' => 'Delete'.' -> '.$data->realname,
                                                            'border' => '0',
                                                            'onClick' => 'return confirm_link(\''.$confirm_text.'\')',
                                                            );
	    			    				if($group == "1") {
											echo anchor(site_url('pengguna/edit')."/".$data->id, img($img_edit))."&nbsp;";
											if($id_pegawai == '..'){
                                                echo anchor(site_url('petugas/index')."/".$data->id."/1", img($img_unsyn))."&nbsp;";   // 1 jika masuk dari menu petugas
											}else{
											    echo img($img_synkron)."&nbsp;";
											}

							    	        if($data->id !== 1){
												echo anchor(site_url('pengguna/delete')."/".$data->id, img($img_delete))."&nbsp;";
								            }
		    						    } else { 
			    						    if($data->realname == $nama) {
												echo anchor(site_url('pengguna/edit')."/".$data->id, img($img_edit))."&nbsp;";
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
                <tfoot>
                    <tr>
                        <th>No</th>
						<th>User ID<br>User Name</th>
						<th>Nama Asli<br>Nama Expose</th>
						<th>Lokasi Pengguna<br>Badang Perizinan</th>
						<th>Nomor HP<br>Alamat E-Mail</th>
                        <th>Log Masuk Terakhir</th>
                        <th>Aksi</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    <br style="clear: both;" />
</div>