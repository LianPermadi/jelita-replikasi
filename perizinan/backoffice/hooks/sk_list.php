<div id="content">
    <div class="post">
        <div class="title">
            <h2><?php echo $page_name; ?></h2>
        </div>
        <div class="entry">
            <fieldset id="half">
                <legend>Filter Data</legend>
                <?php
     			echo form_open('permohonan/sk');
                ?>
                <div id="statusRail">
                    <div id="leftRail">
                        <?php
                        echo form_label('Tgl Permohonan Awal','d_tahun');
                        ?>
                    </div>
                    <div id="rightRail">
                        <?php
                        $periodeawal_input = array(
                            'name'  => 'tgla',
                            'value' => $tgla,
                            'class' => 'input-wrc',
                            'class' => 'monbulan'
                        );
                        echo form_input($periodeawal_input);
                        ?>
                    </div>
                </div>
                <div id="statusRail">
                    <div id="leftRail">
                        <?php
                        echo form_label('Tgl Permohonan Akhir','d_tahun');
                        ?>
                    </div>
                    <div id="rightRail">
                        <?php
                        $periodeakhir_input = array(
                           'name'  => 'tglb',
                           'value' => $tglb,
                           'class' => 'input-wrc',
                           'class' => 'monbulan'
                        );
                        echo form_input($periodeakhir_input);
                        ?>
                    </div>
                </div>
                <div id="statusRail">
                    <div id="leftRail"></div>
                    <div id="rightRail">
                        <?php
                        $filter_data = array(
                            'name' => 'button',
                            'class' => 'button-wrc',
                            'content' => 'Filter',
                            'value' => 'Filter'
                        );
						$ctk_list = array(
                            'name' => 'button',
                            'content' => 'Cetak Nota Pengantar',
                            'value' => 'Cetak Nota Pengantar',
                            'class' => 'button-wrc',
                            'onclick' => 'parent.location=\''.site_url('permohonan/sk/cetak_nota/'.$tgla.'/'.$tglb).'\''
                        );
                        echo form_submit($filter_data);
						echo form_button($ctk_list);
                        ?>
                    </div>
                </div>
                <?php
                echo form_close();
                ?>
            </fieldset>
        </div>
        <div class="entry">
            <table cellpadding="0" cellspacing="0" border="0" class="display" id="sk">
                <thead>
                    <tr>
                        <th width="2%">No</th>
                        <th width="9%">No Pendaftaran<br>Tanggal Permohonan<br>Asal Permohonan</th>
	     	            <th width="15%">Pemohon</th>
                        <th width="40%">Jenis Izin</th>
                        <th width="20%">No Surat<br>Tanggal Surat</th>
			            <th width="8%">Status</th>
			            <th width="6%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    $results = mysql_query($list);
                    while ($rows = mysql_fetch_assoc(@$results)){
                        $no_surat = $rows['no_surat'];
                        $tgl_surat = $rows['tgl_surat'];
                        $c_cetak = $rows['c_cetak'];
						if($c_cetak == "0") {
						    $b = '<span style="color: Red">';
						    $be = '</span>';
                        } else {
						    $b = '';
						    $be = '';
						}
                    ?>
                        <tr>
                            <td valign='top'><?php echo $i; ?></td>
                            <td valign='top'><?php 
						            echo $b.$rows['pendaftaran_id'].$be."<br>";
					                if($rows['idjenis'] == '1') $b.$tgl_permohonan = $rows['d_terima_berkas']; 
                                    else if($rows['idjenis'] == '2') $tgl_permohonan = $rows['d_perubahan'];
                                    else if($rows['idjenis'] == '3') $tgl_permohonan = $rows['d_perpanjangan'];
                                    else if($rows['idjenis'] == '4') $tgl_permohonan = $rows['d_daftarulang'];
                                    if($tgl_permohonan){
                                        if($tgl_permohonan != '0000-00-00') echo $b.$this->lib_date->mysql_to_human($tgl_permohonan).$be."<br>";
                                    }
                                    echo $b.$rows['kd_gerai'].$be;
					            ?>
							</td>
                            <td valign='top'><?php echo $b.$rows['n_pemohon'].$be; ?></td>
                            <td valign='top'><?php echo $b.$rows['n_perizinan'].$be;?></td>
                            <td valign='top'><?php 
									             echo $b.$no_surat.$be."<br>";
								                 if($tgl_surat){
                                                     if($tgl_surat != '0000-00-00') echo $b.$this->lib_date->mysql_to_human($tgl_surat).$be;
                                                 }
           						             ?>
							</td>
                            <td valign='top'><?php
                                if($c_cetak == '0'){
                                    if($rows['c_status_bayar'] === '1' && $rows['trkelompok_perizinan_id'] === '4' || $rows['trkelompok_perizinan_id'] != '4'  )
										echo $b."Belum di-cetak".$be;
									else
									    echo $b."Belum Bayar Retribusi".$be;
                                } else {
                                    echo $b."<b>Dicetak ".$c_cetak." kali</b>".$be;
                                }
                                ?>
                            </td>
                            <td valign='top'>
                                <!--<center>-->
                                    <?php
									$img_lihat = array(
                                        'src' => base_url().'assets/images/icon/information.png',
                                        'alt' => 'Lihat Detail',
                                        'title' => 'Lihat Detail',
                                        'border' => '0',
                                    );
                                    $img_edit = array(
                                        'src' => base_url().'assets/images/icon/property.png',
                                        'alt' => 'Edit',
                                        'title' => 'Edit',
                                        'border' => '0',
                                    );
                                    $img_cetak = array(
                                        'src' => base_url().'assets/images/icon/clipboard.png',
                                        'alt' => 'Cetak Rekomendasi (Non Izin)',
                                        'title' => 'Cetak Rekomendasi (Non Izin)',
                                        'border' => '0',
                                    );
                                    $img_cetak2 = array(
                                        'src' => base_url().'assets/images/icon/clipboard-doc.png',
                                        'alt' => 'Cetak Izin (Keputusan) (Kabad)',
                                        'title' => 'Cetak Izin (Keputusan) (Kabad)',
                                        'border' => '0',
                                    );
                                     $img_cetak3 = array(
                                        'src' => base_url().'assets/images/icon/clipboard-doc.png',
                                        'alt' => 'Cetak Izin (Keputusan) (Gubernur)',
                                        'title' => 'Cetak Izin (Keputusan) (Gubernur)',
                                        'border' => '0',
                                    );
									$img_excel = array(
                                        'src' => base_url().'assets/images/icon/navigation-down.png',
                                        'alt' => 'Download Data Excel',
                                        'title' => 'Download Data Excel',
                                        'border' => '0',
                                    );
								
								// kondisi jika berbayar maka sk bisa di cetak jika sudah di bayar
								    //echo $rows['c_status_bayar'] .' == 1 && ' . $rows['trkelompok_perizinan_id'] . ' == 4 || ' . $rows['trkelompok_perizinan_id'] . ' != 4';
                                       echo anchor(site_url('arsip/edit') .'/L/'.$rows['id'].'/4', img($img_lihat))."&nbsp;";
                                    if($rows['c_status_bayar'] === '1' && $rows['trkelompok_perizinan_id'] === '4' || $rows['trkelompok_perizinan_id'] != '4'  ){
                                        
                                        if($rows['c_keputusan'] == '0'){
			    					    	if($rows['template']!=""){
												echo anchor(site_url('permohonan/sk/cetak') .'/'. $rows['id'].'/1', img($img_cetak2),['onClick' => 'reload1()','target'=>'_blank'])."&nbsp;";
											}else{
												// echo anchor(site_url('permohonan/sk#'), img($img_cetak2),array('onClick' => 'notif()'))."&nbsp;";
												echo anchor(site_url('permohonan/sk/cetak').'/'.$rows['id'].'/0', img($img_cetak2))."&nbsp;";
											}
											
											if($rows['template_gub']!=""){
												echo anchor(site_url('permohonan/sk/cetak') .'/'. $rows['id'].'/2', img($img_cetak3),['onClick' => 'reload()','target'=>'_blank'])."&nbsp;";
											}else{
												echo anchor(site_url('permohonan/sk/cetak').'/'.$rows['id'].'/0', img($img_cetak3))."&nbsp;";
											}
											
				    				    }
 
                                        if($rows['c_keputusan'] == '1'){
                                            //echo anchor(site_url('permohonan/keputusan/edit') .'/'. $rows['id'], img($img_edit))."&nbsp;";
											//echo anchor(site_url('arsip/edit') .'/L/'.$rows['id'].'/4', img($img_lihat))."&nbsp;";
											//switch ($rows['idizin']) {
                                            //    case '1':           // untuk SIUP
											//	    echo anchor(site_url('permohonan/keputusan/cetak') .'/'. $rows['id'], img($img_cetak2))."&nbsp;";
                                            //        break;
											//	case '2':           // untuk TDP
											//		echo anchor(site_url('permohonan/keputusan/cetak_tdp') .'/'. $rows['id'], img($img_cetak2))."&nbsp;";
											//		break;
											//	case '3':           // untuk HO
											//		echo anchor(site_url('permohonan/keputusan/cetak_ho') .'/'. $rows['id'], img($img_cetak2))."&nbsp;";
											//		break;
                                            //    default:
													//echo anchor(site_url('permohonan/keputusan/cetak') .'/'. $rows['id'], img($img_cetak2))."&nbsp;";
                                            //        break;
                                            //}
											if($rows['template']!=""){
																echo anchor(site_url('permohonan/keputusan/cetak') .'/'. $rows['id'].'/1', img($img_cetak2),['onClick' => 'reload()','target'=>'_blank'])."&nbsp;";
															}else{
																// echo anchor(site_url('permohonan/sk#'), img($img_cetak2),array('onClick' => 'notif()'))."&nbsp;";
																echo anchor(site_url('permohonan/keputusan/cetak').'/'.$rows['id'].'/0', img($img_cetak2))."&nbsp;";
															}
											if($rows['template_gub']!=""){
													echo anchor(site_url('permohonan/keputusan/cetak') .'/'. $rows['id'].'/2', img($img_cetak3),['onClick' => 'reload()','target'=>'_blank'])."&nbsp;";
												}else{
													echo anchor(site_url('permohonan/keputusan/cetak').'/'.$rows['id'].'/0', img($img_cetak3))."&nbsp;";
												}
										}
											echo anchor(site_url('permohonan/sk/cetak_excel') .'/'. $rows['id'], img($img_excel))."&nbsp;";
										
                                    }
                                    ?>
                                <!--</center>-->
                            </td>
                        </tr>
                        <?php
                        $i++;
                    }
					
                    ?>
                    <?php
//                    $i=1;
//
//                    foreach ($list as $data){
//                        $data->tmpemohon->get();
//                        $data->trperizinan->get();
//                        $data->tmsk->get();
//                        $bap = new tmbap();
//                        $bap->where_related($data)->get();
//                        if($bap->status_bap === $c_bap){
//                            $cetak_skrd = $bap->c_skrd;
                    ?>
<!--                    <tr>
                        <td><?php echo $i; ?></td>
                        <td><?php echo $data->pendaftaran_id;?></td>
                        <td><?php echo $data->tmpemohon->n_pemohon;?></td>
                        <td><?php echo $data->trperizinan->n_perizinan;?></td>
			<td>
                        <?php
                        if($data->d_entry){
                            if($data->d_entry != '0000-00-00') echo $this->lib_date->mysql_to_human($data->d_entry);
                        }
                        ?>
                        </td>
                        <td><?php echo $data->tmsk->no_surat;?></td>
                        <td>
                            <?php
                                if($data->tmsk->c_cetak){
                                    echo "<b>Dicetak ".$data->tmsk->c_cetak." kali</b>";
                                } else {
                                    echo "Belum di-cetak";
                                }
                            ?>
                        </td>
                         <td><center>
                          <?php
                                $img_edit = array(
                                    'src' => base_url().'assets/images/icon/property.png',
                                    'alt' => 'Edit',
                                    'title' => 'Edit',
                                    'border' => '0',
                                );
                                $img_cetak = array(
                                    'src' => base_url().'assets/images/icon/clipboard.png',
                                    'alt' => 'Cetak Surat Izin',
                                    'title' => 'Cetak Surat Izin',
                                    'border' => '0',
                                );
                                $img_cetak2 = array(
                                    'src' => base_url().'assets/images/icon/clipboard-doc.png',
                                    'alt' => 'Cetak SK',
                                    'title' => 'Cetak SK',
                                    'border' => '0',
                                );
//                                echo anchor(site_url('permohonan/sk/edit') .'/'. $data->id, img($img_edit))
//                                     ."&nbsp;";
//                                if($data->tmsk->c_status !== "1")
                                //if($cetak_skrd)
                                echo anchor(site_url('permohonan/sk/cetak') .'/'. $data->id, img($img_cetak))."&nbsp;";
                                if($data->trperizinan->c_keputusan == 1){
                                    echo anchor(site_url('permohonan/keputusan/cetak') .'/'. $data->id, img($img_cetak2))."&nbsp;";
                                    echo anchor(site_url('permohonan/keputusan/edit') .'/'. $data->id, img($img_edit))."&nbsp;";
                                }
                            ?>
                             </center>
                        </td>
                    </tr>-->
                    <?php
//                        $i++;
//                        }
//                    }  
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <br style="clear: both;" />
</div>


<script>
  $(document).ready(function(){
      window.open(url, "_blank"); // will open new tab on document ready
      
      location.reload();
  });
  
  function notif(){
      alert("izin ini belum memiliki template Kabad !");
  }
  
  function notif2(){
      alert("izin ini belum memiliki template Gubernur !");
  }
  
  function reload1(){
	  
	  // setTimeout(function(){ window.location = "<?=base_url();?>permohonan/sk/index_next"},700);
	  setTimeout(function(){ window.location = "<?=base_url();?>permohonan/sk"},700);
		  
  }
  
  function reload(){
	  
	  setTimeout(function(){ window.location = "<?=base_url();?>permohonan/sk"},700);
		  
  }
  
</script>