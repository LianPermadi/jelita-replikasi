
<?php
$no_api = "";

							foreach ($data_noapi as $key => $value) {
								//echo $value->no_api;
								$no_api = $value->no_api;
							}
header( "Content-Type: application/vnd.ms-excel" );
header( "Content-disposition: attachment; filename=$no_api Revisi.xls" );
?>
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			

	
	<div class="row">
		<div class="col-lg-12">
			<!--<div class="panel panel-default">
				<div class="panel-heading">
					<div class="row">
						<div class="col-md-9">Nomor API :<a class="buton"> <?php echo $no_api;?></a></div>
					</div>
				</div>
				
			</div>-->
			
			<div class="panel panel-default">
			
				<div class="panel-body">
					<div class="col-md-12">
						
						
						
						
						
							<?php 
$jenis = $data->jenis;
//echo $jenis;
							if($jenis=="Pemohon"){ ?>
							

							<?php } ?>
						
						
						
							<?php 
								$error 	= $this->session->flashdata("error");
								if(!empty($error)){
							?>
							<div class="alert bg-danger" role="alert" style="">
								<span class="glyphicon glyphicon-check"></span> <?php echo $error; ?>
							</div>
							<?php } ?>
							<?php if($jenis=="perusahaan" || $jenis=="Perusahaan"){ ?>
							<?php
							
							if($no_api == ""){
								
							redirect('main/laporanapiuser/inputnoapi', 'refresh');
							}else{

							}

							} ?><!--
<br>
							<center><a class="buton"><?php echo $data->namaPerusahaan;?></a> 
<br>
<?php echo $data->almtPerusahaan .' Telepon : '. $data->telpPerusahaan;?>
</center>
<br>-->
<!--<center>Periode PIB : <?php echo date('d M Y',strtotime($tgl1)).' - '.date('d M Y',strtotime($tgl2));?></center><br>-->
						
<!--	<div class="form-group">
<div class="col-md-3">
								<a href="<?php echo base_url() . 'main/laporanapiuser/tambah_api'; ?>"><button type="submit" class="btn btn-block btn-primary">
										Tambah Data Baru
									</button></a>
									</div>
									</div>-->
								<div class="form-group">
						<table border="1" style="border-collapse: collapse;" >
						<thead>
						<tr>
							<th data-field="No"  data-sortable="true" >No</th>
							<th data-field="no_api"  data-sortable="true" >No Api</th>
							<th data-field="jenis_api"  data-sortable="true" >Jenis Api</th>
							<th data-field="uraian_barang"  data-sortable="true" >Uraian Barang</th>
							<th data-field="hs10digit"  data-sortable="true" >hs10digit</th>
							<th data-field="volume"  data-sortable="true" >Volume</th>
							<th data-field="satuan"  data-sortable="true" >Satuan</th>
							<th data-field="harga_satuan"  data-sortable="true" >Harga Satuan</th>
							<th data-field="nilai_cif"  data-sortable="true" >Nilai CIF</th>
							<th data-field="nilai_cnf"  data-sortable="true" >Nilai CNF</th>
							<th data-field="nilai_fob"  data-sortable="true" >Nilai FOB</th>
							<!--<th data-field="nilai_impor"  data-sortable="true" >Nilai Impor</th>-->
							<th data-field="currency"  data-sortable="true" >Mata Uang</th>
							<!--<th data-field="kurs"  data-sortable="true" >Kurs</th>-->
							<th data-field="negara_asal"  data-sortable="true" >Negara Asal</th>
							<th data-field="pelabuhan_asal"  data-sortable="true" >Pelabuhan Asal</th>
							<th data-field="pelabuhan_tujuan"  data-sortable="true" >Pelabuhan Tujuan</th>
							<th data-field="nomor_ls"  data-sortable="true" >No LS</th>
							<th data-field="tgl_ls"  data-sortable="true" >Tgl LS</th>
							<th data-field="nomor_pib"  data-sortable="true" >No PIB</th>
							<th data-field="tgl_pib"  data-sortable="true" >Tgl PIB</th>
							<th data-field="flag"  data-sortable="true" >Status</th>
						</tr>
						</thead>
						<tbody>
						<?php
						$i=1;
						foreach ($data_api as $key => $value) {
							echo '<tr>';
							echo '<td>'. $i++ .'</td>';
							echo '<td>'. $value->no_api .'</td>';
							echo '<td>'. $value->jenis_api .'</td>';
							echo '<td>'. $value->uraian_barang .'</td>';
							echo '<td>'. $value->hs10digit .'</td>';
							echo '<td>'. $value->volume .'</td>';
							echo '<td>'. $value->satuan .'</td>';
							echo '<td>'. $value->harga_satuan .'</td>';
							echo '<td>'. $value->nilai_cif .'</td>';
							echo '<td>'. $value->nilai_cnf .'</td>';
							echo '<td>'. $value->nilai_fob .'</td>';
							//echo '<td>'. $value->nilai_impor .'</td>';
							echo '<td>'. $value->currency .'</td>';
							//echo '<td>'. $value->kurs .'</td>';
							echo '<td>'. $value->negara_asal .'</td>';
							echo '<td>'. $value->pelabuhan_asal .'</td>';
							echo '<td>'. $value->pelabuhan_tujuan .'</td>';
							echo '<td>'. $value->nomor_ls .'</td>';
							if($value->tgl_ls != '0000-00-00'){
							echo '<td>'. $value->tgl_ls .'</td>';
							}else{
								echo '<td> </td>';
							}
							
							echo '<td>'. $value->nomor_pib .'</td>';
							if($value->tgl_pib != '0000-00-00'){
							echo '<td>'. $value->tgl_pib .'</td>';
							}else{
								echo '<td> </td>';
							}
							echo '<td>'. $value->flag .'</td>';
							echo '</tr>';
						}
						?>
						

						</tbody>
						</table>
						</div>
					</div>
				</div>
			</div>
		</div><!-- /.col-->
	</div><!-- /.row -->
	
</div><!--/.main-->
