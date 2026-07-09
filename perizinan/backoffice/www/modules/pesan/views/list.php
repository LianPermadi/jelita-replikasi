<div id="content">
    <div class="post">
        <div class="title">
            <h2><?php echo $page_name; ?></h2>
        </div>
        <div class="entry">        
            <fieldset id="half">
                <legend>Filter Per Status Pengaduan</legend>
                <?php echo form_open('pesan/filterdata'); ?>
         
                <div id="statusRail" align="left" >
                    <div id="leftRail">
                        <label>Status Pengaduan</label>
                    </div>
                  
                    <div id="rightRail">
                        <select class="input-select-wrc" name="sts_pesan">
                            <?php
                            echo "<option>-----Pilih Status Pengaduan-----</option>";
                            foreach ($liststspesan as $row){
                                echo "<option value=".$row->id.">".$row->n_sts_pesan."</option>";
                            }
                            ?>
                        </select>
                        <br>
                        <?php
                        $filter_data = array(
                            'name' => 'button',
                            'class' => 'button-wrc',
                            'content' => 'Filter',
                            'value' => 'Filter'
                        );
                        echo '&nbsp;&nbsp;'.form_submit($filter_data);

                        $add_pesan = array(
                            'name' => 'button',
                            'class' => 'button-wrc',
                            'content' => 'Tambah Pengaduan',
                            'onclick' => 'parent.location=\''. site_url('pesan/create') . '\''
                        );
                        echo form_button($add_pesan);
                        ?>
                    </div>
                </div>
          
                <? echo form_close(); ?>
            </fieldset>
        </div>
        
		<div class="entry" id="centre">
            <table cellpadding="0" cellspacing="0" border="0" class="display" id="pesan">
                <thead>
                    <tr>
                        <th width="3%">No</th>
						<th width="8%">Tanggal / Sumber Pengaduan</th>
                        <th width="36%">Isi Pengaduan</th>
                        <th width="10%">Nomor / Jenis Pengaduan</th>
                        <th width="15%">Nama & Alamat</th>
                        <th width="7%">Jenis Pengaduan</th>
                        <th width="4%">Tindak Lanjut</th>
                        <th width="7%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = null;
                    foreach ($list as $data){
                        $i++;
                        $kelurahan = new trkelurahan();
                        $kecamatan = new trkecamatan();
                        $kecamatan->where('id', $data->kecamatan)->get();
                        $kelurahan->where('id', $data->kelurahan)->get();
                        $data->trstspesan->get();
                        $data->trsumber_pesan->get();
						$alamat = $data->alamat;
						$jns = $data->pendaftaran_id;
						if($kelurahan->n_kelurahan != "-") $alamat = $alamat . '; Kel. ' . $kelurahan->n_kelurahan;
                        if($kecamatan->n_kecamatan != "-") $alamat = $alamat . '; Kec. ' . $kecamatan->n_kecamatan;
						if($data->laporan_kirim == "") $jwb_langsung = $data->c_tindak_lanjut; else $jwb_langsung = 'Jawab Langsung';
						if($data->jns_pengaduan != "") $jns = $jns .' / '. $data->trstspesan->n_sts_pesan;
                    ?>
                        <tr>
                            <td width="3%"><?php echo $i; ?></td>
							<td width="8%"><?php echo $this->lib_date->mysql_to_human($data->d_entry).' / '.$data->trsumber_pesan->name; ?></td>
                            <td width="36%"><?php echo $data->e_pesan; ?></td>
                            <td width="10%"><?php echo $jns; ?></td>
                            <td width="15%"><?php echo $data->nama . '; Alamat : ' . $alamat; ?></td>
                            <td width="7%"><?php echo $data->trstspesan->n_sts_pesan; ?></td>
                            <td width="4%"><?php echo $jwb_langsung; ?></td>
                            
                            <td width="7%">
                                <?php
                                $img_edit = array(
                                    'src' => base_url().'assets/images/icon/property.png',
                                    'alt' => 'Edit',
                                    'title' => 'Edit',
                                    'border' => '0',
                                );
                                echo anchor(site_url('pesan/edit') .'/1/0/'. $data->id,img($img_edit))."&nbsp;";
 
								if($data->laporan_kirim == "") {
								    $img_jawab = array(
                                        'src' => base_url().'assets/images/icon/email.png',
                                        'alt' => 'Belum Dijawab, Jawab Langsung ?',
                                        'title' => 'Belum Dijawab, Jawab Langsung ?',
                                        'border' => '0',
                                    );
                                    echo anchor(site_url('pesan/edit') .'/2/0/'. $data->id,img($img_jawab))."&nbsp;";
								} else {
					    			$img_jawab = array(
                                        'src' => base_url().'assets/images/icon/email.png',
                                        'alt' => 'Sudah Dijawab, Jawab Kembali ?',
                                        'title' => 'Sudah Dijawab, Jawab Kembali ?',
                                        'border' => '0',
                                    );
                                    echo anchor(site_url('pesan/edit') .'/2/0/'. $data->id,img($img_jawab))."&nbsp;";
								
								    $img_jawab = array(
                                        'src' => base_url().'assets/images/icon/tick.png',
                                        'alt' => 'Telah Dijawab',
                                        'title' => 'Telah Dijawab',
                                        'border' => '0',
                                    );
                                    echo anchor(site_url('pesan/edit') .'/2/1/'. $data->id,img($img_jawab))."&nbsp;";
                                }

								$confirm_text = 'Apakah Anda yakin akan menghapusnya ?';
								$img_hapus = array(
                                    'src' => base_url().'assets/images/icon/cross.png',
                                    'alt' => 'Hapus',
                                    'title' => 'Hapus',
                                    'border' => '0',
									'onClick' => 'return confirm_link(\''.$confirm_text.'\')',
                                );
                                echo anchor(site_url('pesan/tanda_hapus').'/'.$data->id,img($img_hapus))."&nbsp;";
								
                                ?>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th width="3%">No</th>
						<th width="8%">Tanggal / Sumber Pengaduan</th>
                        <th width="36%">Isi Pengaduan</th>
                        <th width="10%">Nomor / Jenis Pengaduan</th>
                        <th width="15%">Nama & Alamat</th>
                        <th width="7%">Jenis Pengaduan</th>
                        <th width="4%">Tindak Lanjut</th>
                        <th width="7%">Aksi</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    <br style="clear: both;" />
</div>
