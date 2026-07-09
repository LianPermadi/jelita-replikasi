<div id="content">
    <div class="post">
        <div class="title">
            <h2><?php echo $page_name; ?></h2>
        </div>
        <div class="entry">
        <fieldset id="half">
            <legend>Daftar Per Periode</legend>
            <?php
			//$option =  array(
			
			//'Esdm'=>'Bidang ESDM',
			//'pengairan'=>'Bidang Pengairan');
              // echo form_dropdown('data[group]',$option); 
			   
			   ?>
			  <!-- <select name = "bidangizin">
			   <option value="Esdm">Bidang Esdm</option>
			   <option value="sosial">Bidang sosial</option>
			   <option value="perkebunan">Bidang Perkebunan</option>
			   <option value="perikanan">Bidang Perikanan</option>
			   <option value="kehutanan">Bidang Kehutanan</option>
			   <option value="perhubungan">Bidang Perhubungan</option>
			   <option value="Pendididkan">Bidang Pendidikan</option>
			   <option value="peternakan">Bidang Peternakan</option>
			   <option value="binamarga">Bidang Kebinamargaan</option>
			   <option value="tenagakerja">Bidang Ketenagakerjaan</option>
			   <option value="modal">Bidang Penanaman Modal</option>
			   <option value="ruang">Bidang Penataan Ruang</option>
			   <option value="lingkungan">Bidang Lingkungan Hidup</option>
			   <option value="Industri">Bidang Industri dan Perdagangan</option>
			   <option value="komunikasi">Bidang Komunikasi dan Informasi</option>
			   <option value="pengairan">Bidang Pengairan (PSDA)</option>
			   
			   </select>-->
			   
			   <?php
			   //$bidangizin=$this->input->post('bidangizin');
			   //echo form_hidden('bidangizin',$bidangizin);
			   //if ($bidangizin == 'Esdm'){
			   // echo form_open('kinerjaizin/izin/esdm');
			   //}else {
			   echo form_open('kinerjaizin/izin/esdm');
			   //}
            ?>
			

      <div id="statusRail">
	  <div id="leftRail">
	  <?php
                    echo form_label('Bidang');
            ?>
              </div>
 <div id="rightRail">
 <?php  
			$this->db->select('id');
			$this->db->select('n_sektor');
			$anggota = $this->db->get('trsektor');
	foreach($anggota->result() as $row){
	$hasil[$row->id] = $row->n_sektor;
}
	$pilih = array($anggota);
	echo form_dropdown('id',$hasil,$pilih);
	echo br();
	
	//echo form_input('',$id);
	
	/* atau
	$this->db->select(‘idanggota’);
$this->db->select(‘nama’);
$anggota = $this->db->get(‘anggota’);

echo “<select name=’idanggota’>”;
foreach($anggota->result() as $row){
echo “<options value=’”.$row->idanggota.”‘>”.$row->nama.”</options>
}
echo “</select>”;
	*/
?>
 </div>
</div>
<div id="statusRail">
              <div id="leftRail">
            <?php
                    echo form_label('Tgl Daftar Awal','d_tahun');
            ?>
              </div>
              <div id="rightRail">
                <?php
                $periodeawal_input = array(
                'name'  => 'tgla',
                'value' => $this->lib_date->set_date(date('Y-m-d'), -2),
                'class' => 'input-wrc',
                     'readOnly'=>TRUE,
                'class' => 'monbulan'
                );
                echo form_input($periodeawal_input);
                ?>
              </div>
      </div>

      <div id="statusRail">
              <div id="leftRail">
           <?php
                    echo form_label('Tgl Daftar Akhir','d_tahun');
                ?>
              </div>
              <div id="rightRail">
               <?php
                $periodeakhir_input = array(
                'name'  => 'tglb',
                'value' => $this->lib_date->set_date(date('Y-m-d'), 0),
                'class' => 'input-wrc',
                     'readOnly'=>TRUE,
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

                     $reset_data = array(
                                    'name' => 'button',
                                    'content' => 'Reset Filter',
                                    'value' => 'Reset Filter',
                                    'class' => 'button-wrc',
                                    'onclick' => 'parent.location=\''. site_url('kinerjaizin/izin') . '\''
                    );

                    echo form_submit($filter_data);
                    echo form_button($reset_data);
                    ?>
              </div>
            </div>
            <?php
                echo form_close();
            ?>
        </fieldset>
       <br>
<div class="contentForm">
                          
                        </div>
<!--<table cellpadding="0" cellspacing="0" border="0" class="display" id="izin">
                <thead>
                 
                   <tr>
               <th rowspan="2">No</th>
               <th rowspan="2">jenis Izin</th>
               <th rowspan="2">Izin Masuk</th>
               
               <th colspan="3" class="bg-grid">Izin Terbit</th>
               <th rowspan="2">&nbsp;</th>
               <th colspan="3" class="bg-grid">Izin Ditolak</th>
               <th rowspan="2">Izin Dalam proses</th>

                 </tr>
                      <tr>

               <th>Jumlah</th>
               <th>Diambil</th>
               <th>Belum Diambil</th>
               <th>Jumlah</th>
               <th>Diambil</th>
               <th>Belum Diambil</th>
                     </tr>
                </thead>
                <tbody>-->
                <?php
//                 $i = NULL;
//                    foreach ($list as $data){
//                        $i++;$jumx = 0;
//                        $a = 0;$juma = 0;
//                        $b = 0;$jumb = 0;
//                        $c = 0;$jumc = 0;
//                        $d = 0;$jumd = 0;
//                        $relasi = new tmpermohonan_trperizinan();
//                        $bap = new tmbap();
//                        $permohonan = new tmpermohonan();
//                        $mohonbap = new tmbap_tmpermohonan();
//                        $permohonan->get();
//                        $jumlah = $relasi->where('trperizinan_id',$data->id)->count();
//                        $list_jumlah = $relasi->where('trperizinan_id',$data->id)->limit(0)->get();
//
//                        $tot = $mohonbap->where('tmpermohonan_id', $permohonan->id)->count();
//
//
//
//                              // izin terbit dan izin tolak
//                        foreach ($list_jumlah as $data_relasi){
//
//                            $permohonan->get_by_id($data_relasi->tmpermohonan_id);
//                            $iddaftar = $permohonan->id;
//                            $mohonbap->where('tmpermohonan_id',$iddaftar)->get();
//                            $iddaftarbap = $mohonbap->tmbap_id;
//
//                            $terbit = $bap->where('id',$iddaftarbap)->get();
//                            //izin terbit
//                            if($terbit->id){
//
//                                if($terbit->status_bap === '1'){
//
//                                        $juma = $juma;
//                                        $juma++;
//                                        echo form_hidden('zzz',$terbit->id);
//                                        //diambil
//                                          if($permohonan->c_izin_selesai === '1'){
//                                                $c++;
//                                                $jumc = $c;
//                                           }
//
//                                }
//                                else if($terbit->status_bap === '0')  //izin ditolak sesuai
//                                {
//
//                                       $jumb = $jumb;
//                                       $jumb++;
//                                        //diambil
//                                          if($permohonan->c_izin_selesai === '1'){
//                                                $d++;
//                                                $jumd = $d;
//                                           }
//                                }
//
//                            }
//                            else
//                            {
//                                $jumx = $jumx;
//                                $jumx++;
//                            }
//                        }
                       
                        
                        
                  

                    
                ?>
<!--                    <tr>
                        <td><?php  echo $i; ?></td>
                        <td align="left"><?php echo $data->n_perizinan; ?></td>
                        <td align="right"> <?php echo anchor(site_url('kinerjaizin/izin/pick_pendaftar_list'.'/'.$data->id), $juma+$jumb+$jumx, 'class="link2-wrc" rel="pendaftar_box"');?></td>
                        <td align="right"><?php echo anchor(site_url('kinerjaizin/izin/pick_pendaftar2_list'.'/'.$data->id),$juma,'class="link2-wrc" rel="pendaftar_box"');?></td>
                        <td align="right"><?php echo $jumc;?></td>
                        <td align="right"><?php echo $juma - $jumc;?></td>
                        <td align="right">&nbsp;</td>
                        <td align="right"><?php echo anchor(site_url('kinerjaizin/izin/pick_pendaftar3_list'.'/'.$data->id),$jumb,'class="link2-wrc" rel="pendaftar_box"');?></td>
                        <td align="right"><?php echo $jumd;?></td>
                        <td align="right"><?php echo $jumb - $jumd;?></td>
                        <td align="right"><?php echo $jumx;?></td>
                    </tr>-->
                <?php
//                  }
                ?>
<!--                </tbody>
            </table>-->
        </div>
    </div>
    <br style="clear: both;" />
</div>
