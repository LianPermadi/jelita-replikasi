<?php
/*------------------------------------------------------------------------
 Tittle		: Master Tarif List
 Author 	: Rizki Firmansyah
 @created	: 23-August-2007 
 -----------------------------------------------------------------------*/
function doAdd_fnc () 
{

	global $oConn, $APP_VARS, $sURLVar;
	global $n_pglen, $n_pg, $oc, $ob;

	//$arrKategory 	= arrayPoli_fnc () ;
	//$arrPasien	 	= arrayJenisPasien_fnc () ;
	//$arrShift 	    = arrayShift_fnc ();
	$resi     		= $_GET["CODE"] ;
	$sumber     	= $_GET["sumber"] ;
	$sSQL = "
		SELECT * FROM skm_data_skm WHERE resi = '$resi'
	";

	$oRS = mysql_query ( $sSQL );
	$oRow = mysql_fetch_array ( $oRS ) ;
	
	$sSQLA = "
	
		SELECT *
		  FROM skm_grup_quis AS t1
		 WHERE 1
		   AND status_quis = '2'
	  " ;
	if ( $oRSA = mysql_query ( $sSQLA ) ) 
	{
		
		if ( mysql_num_rows ( $oRSA ) != 0 ) 
		{


				
			for ( $i = 0 ; $i < mysql_num_rows ( $oRSA ) ; $i++ ) 
			{

				$oRowA = mysql_fetch_array ( $oRSA ) ;
				$jmlD = mysql_num_rows ( $oRSA )+2;
				$data_grup = explode(',',$oRowA['data_quis']);
				$DataIsi = '';
				for ( $ig = 0 ; $ig < count ( $data_grup ) ; $ig++ ) 
				{
					if ($data_grup[$ig]<>0){
						$nomor = $ig+1;
						$nomor = $nomor + 1;
						$KodeQ = $data_grup[$ig];
						$Pertanyaannya = tampilCustomTabel('judul_quis','skm_quisioner', " AND kode_quis = '".$KodeQ."'");
						$sSQLQ = "SELECT * FROM skm_pertanyaan WHERE 1 AND kode_quis = '$KodeQ'";
						$oRSQ = mysql_query($sSQLQ);
						$Jawaban = '';
						
						for ( $ix = 0 ; $ix < mysql_num_rows ( $oRSQ ) ; $ix++ ) 
						{
				
							$oRowQ = mysql_fetch_array ( $oRSQ ) ;
							$nilai = $ix+1;
							if ($ix == 0){
								$KodeA = 'A. ';
							}elseif ($ix == 1){
								$KodeA = 'B. ';
							}elseif ($ix == 2){
								$KodeA = 'C. ';
							}else{
								$KodeA = 'D. ';
							}
							//$Jawaban .= $KodeA.$oRowQ['pertanyaan'].'<br>';
							$Jawaban .= '
									<div class="form-group">
										<label class="container_radio version_2">'.$KodeA.$oRowQ['pertanyaan'].'
											<input type="radio" name="question_'.$ig.'" value="'.$nilai.'" class="required" onchange="getVals(this, \'question_'.$ig.'\');">
											<span class="checkmark"></span>
										</label>
									</div>
							';
						}
						//$DataIsi = $nomor.'.&nbsp;'.$Pertanyaannya .'<br>'.$Jawaban;
						$DataIsi .= '
								<div class="step">	
									<h3 class="main_question">
										<strong>'.$nomor.'/11</strong>
										'.$Pertanyaannya.'
									</h3>
									'.$Jawaban.'
								</div>';
						
					}
				}
				
			}
		}
	}
	
	$nomor = $nomor + 1;

	if (!isset($_GET['CODE']) || empty($_GET['CODE'])) {
		header("Location: index.php");
		exit;
	}
	
	$code = $_GET['CODE'];
	$isDisabled = ($code != 'frontoffice') ? 'disabled' : '';
	
	$strReturn = '
		<div class="col-lg-6 content-right" id="start">
			<div id="wizard_container">
				<div id="top-wizard">
					<div id="progressbar"></div>
				</div>
	
				<form id="wrapped" method="POST" name="FRM1" enctype="multipart/form-data">
					<input id="website" name="website" type="text" value="">
					<div id="middle-wizard">
						<div class="step">
							<h3 class="main_question"><strong>1/11</strong>Data Masyarakat (Responden)</h3>
							<div class="form-group">
								<input type="text" name="resi1" class="form-control" placeholder="Nomor Resi / NIK / NIB" value="' . $oRow['resi'] . '" ' . $isDisabled . '>
								<span for="nama" class="error" id="resi-error" style="display: none;"></span>
								<input type="hidden" name="resi" class="form-control" value="' . $oRow['resi'] . '">
								<input type="hidden" name="sumber" class="form-control" value="' . $sumber . '">
							</div>
					
							<div class="form-group">
								<input type="text" name="nama" class="form-control required" placeholder="Masukan Nama Responden" value="' . $oRow['nama_responden'] . '">
							</div>
	
							<div class="form-group">
								<div class="form-group radio_input">
									<label class="container_radio">Pemohon
										<input type="radio" name="status_pemohon" value="1" class="required" checked>
										<span class="checkmark"></span>
									</label>
									<label class="container_radio">Non Pemohon
										<input type="radio" name="status_pemohon" value="2" class="required">
										<span class="checkmark"></span>
									</label>
								</div>
							</div>
	
							<div class="form-group">
								<input type="text" name="hp" class="form-control required" placeholder="No. HP" value="' . $oRow['mobile'] . '">
							</div>
	
							<div class="row">
								<div class="col-3">
									<div class="form-group">
										<input type="text" name="age" class="form-control required" placeholder="Usia" value="' . $oRow['usia'] . '">
									</div>
								</div>
								<div class="col-9">
									<div class="form-group radio_input">
										<label class="container_radio">Laki-laki
											<input type="radio" name="gender" value="1" class="required">
											<span class="checkmark"></span>
										</label>
										<label class="container_radio">Perempuan
											<input type="radio" name="gender" value="2" class="required">
											<span class="checkmark"></span>
										</label>
									</div>
								</div>
							</div>
	
							<div class="form-group">
								<div class="styled-select clearfix">
									<select class="wide required" name="pendidikan">
										' . cekCustomSelect('kode_pendidikan, nama_pendidikan', 'skm_pendidikan', '', $oRow['pendidikan_id'], 'kode_pendidikan', 'nama_pendidikan') . '
									</select>
								</div>
							</div>
	
							<div class="form-group">
								<div class="styled-select clearfix">
									<select class="wide required" name="pekerjaan">
										' . cekCustomSelect('kode_pekerjaan, nama_pekerjaan', 'skm_pekerjaan', '', $oRow['pekerjaan_id'], 'kode_pekerjaan', 'nama_pekerjaan') . '
									</select>
								</div>
							</div>
							' . (
								(isset($_GET['CODE']) && strtolower($_GET['CODE']) === 'frontoffice')
								? '
								<div class="form-group">
									<div class="styled-select clearfix">
										<select class="wide required" name="layanan">
											' . cekCustomSelect('kode_layanan, nama_layanan', 'skm_layanan', '', $oRow['layanan_id'], 'kode_layanan', 'nama_layanan') . '
										</select>
									</div>
								</div>'
								: ''
							) . '

						</div>
	
						' . $DataIsi . '
	
						<div class="submit step">
							<h3 class="main_question"><strong>' . $nomor . '/' . $jmlD . '</strong>Saran Anda untuk perbaikan pelayanan Dinas PMPTSP</h3>
							<div class="form-group">
								<textarea name="saran" style="height:80px;width:300px;" required></textarea>
							</div>
							<h3 class="main_question">Komentar Positif(Apresiasi) Anda Atas pelayanan yang telah diberikan oleh Dinas PMPTSP</h3>
							<div class="form-group">
								<textarea name="komentar" style="height:80px;width:300px;"></textarea>
							</div>
							<h3 class="main_question">Kendala yang Dihadapi</h3>
							<div class="form-group">
								<textarea name="kendala" style="height:80px;width:300px;" required></textarea>
							</div>
	
							<div class="g-recaptcha" data-sitekey="6LdJzMgZAAAAAOKKMaJ1L4GOb0f0qKsA1ZZhbfhu" data-callback="enableBtn" data-expired-callback="disableBtn"></div>
						</div>
					</div>
	
					<div id="bottom-wizard">
						<button type="button" name="backward" class="backward">Prev</button>
						<button type="button" name="forward" class="forward">Next</button>
						<button type="submit" name="process" class="submit">Submit</button>
					</div>
				</form>
			</div>
		</div>
		<script src="https://www.google.com/recaptcha/api.js" async defer></script>
	
		<script>
		document.addEventListener("DOMContentLoaded", function() {
			var forwardButton = document.querySelector(".forward");
	
			forwardButton.addEventListener("click", function(e) {
				var resiInput = document.querySelector("input[name=\'resi1\']");
				var resi = resiInput.value.trim();
				var errorDiv = document.getElementById("resi-error");
				var code = "' . $code . '";
				var valid = false;
	
				errorDiv.textContent = ""; // clear previous errors
				errorDiv.style.display = "none"; // Sembunyikan dulu setiap kali tombol diklik
				if (code === "frontoffice") {
					if (/^\d{16}$/.test(resi)) {
						valid = true;
					} else {
						errorDiv.textContent = "Masukkan NIK yang valid (16 digit).";
						errorDiv.style.display = "block";
					}
				} else {
					if (/^\d{19}$/.test(resi)) {
						valid = true;
					} else {
						errorDiv.textContent = "Masukkan nomor resi yang valid (19 digit).";
						errorDiv.style.display = "block";
					}
				}
	
				if (!valid) {
					e.preventDefault();
					resiInput.focus();
				}
			});
		});
		</script>
	';
	
	return $strReturn;

}

?>
