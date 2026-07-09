<?php	
$base_url=base_url().'assets/userassets/'; 
$otherdb  = $this->load->database('otherdb', TRUE);
?>
<style>
  .buton{
    font-weight:bold;
  }
  .buton:hover{
    text-decoration:none
  }
</style>
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
  <div class="row">
    <ol class="breadcrumb">
      <li><a href="#"><span class="glyphicon glyphicon-home"></span></a></li>
      <li class="active">Permohonan</li>
    </ol>
  </div><!--/.row-->
  
  <div class="row">
    <div class="col-lg-12">
      <!--h1 class="page-header"></h1-->
    </div>
  </div><!--/.row-->
  
  <div class="row">
    <div class="col-lg-12">
      <div class="panel panel-default">
        <div class="panel-heading">
          <div class="row">
            <div class="col-md-9">Petunjuk Penggunaan</div>
          </div>
        </div>
        <div class="panel-body">
          <div class="col-md-12">
            Jika sudah melengkapi dokumen legalitas, silahkan mengajukan permohonan perizinan dengan petunjuk sebagai berikut.<br>
          <ol type='1'>
            <li>Klik tombol <a class="buton">Permohonan Baru</a> kemudian pilih bidang perizinan yang akan anda ajukan kemudian klik <a class="buton">Lanjutkan</a></li>
            <li>Pilih jenis izin yang akan diajukan, klik <a class="buton">Lanjutkan</a></li>
            <li>Isi data teknis permohonan, klik <a class="buton">Lanjutkan</a></li>
            <li>Silakan mengunggah dokumen persyaratan, isi nomor, tanggal, dan masa berlaku jika terlampir pada dokumen. Dokumen yang diunggah harus berbentuk file <b>.pdf</b> berdasarkan hasil scan <b>DOKUMEN ASLI</b></li>
            <li>Mohon periksa kembali Dokumen Persyaratan yang diunggah.</li>
            <li>klik <a class="buton">Lanjutkan</a> apabila sudah yakin silahkan pilih <a class="buton">YA</a>.</li>
            <li>Permohonan diterima oleh DPMPTSP apabila nomor pendaftaran sudah diberikan oleh DPMPTSP yang dapat dilihat pada halaman <b>Status Proses</b></li> 
            <li>Jika Nomor Pendaftaran belum diberikan oleh DPMPTSP, maka akan diperlukan perbaikan persyaratan permohonan yang dikonfirmasi melalui SMS dan fitur messenger pada aplikasi</li>
            <li>Setelah mengajukan permohonan izin anda dapat mengajukan permohonan kembali. Pilih <a class="buton">YA</a> apabila ingin mengajukan permohonan lain atau pilih <a class="buton">Tidak</a> jika anda ingin menyelesaikan proses permohonan izin baru.</li>
            <li>Untuk izin berbasis Cetak Mandiri, sebelum dapat dicetak diharuskan untuk mengisi Survey Kepuasan Masyarakat (SKM) terlebih dahulu. Silahkan untuk <?php echo anchor('main/permohonan', 'Refresh Halaman'); ?> jika telah mengisi SKM.</li>
          </ol>
          </div>
        </div>
      </div>
      <div class="panel panel-default">
        <div class="panel-heading">
          <div class="row">
            <div class="col-md-9">
              Data Permohonan Izin
            </div>
            <div class="col-md-3">
              <?php echo anchor('main/permohonan/step1', 'Permohonan Baru',array("class"=>"btn btn-block btn-primary")) ?>
            </div>
          </div>
        </div>
        <div class="panel-body">
          <?php 
          $success 	= $this->session->flashdata("success");
          if(!empty($success)){
            ?>
            <div class="alert bg-success" role="alert" style="background:#7EB332;">
              <span class="glyphicon glyphicon-check"></span> <?php echo $success; ?>
            </div>
            <?php
          }
          $error 	= $this->session->flashdata("error");
          if(!empty($error)){
            ?>
            <div class="alert bg-danger" role="alert" style="">
              <span class="glyphicon glyphicon-check"></span> <?php echo $error; ?>
            </div>
            <?php
          }
          ?>
          <table data-toggle="table"   data-show-columns="true" data-search="true" data-select-item-name="toolbar1" data-pagination="true">
            <thead>
              <tr>
                <th data-field="nomor"  data-sortable="true" >Nomor Pendaftaran</th>
                <th data-field="name" data-sortable="true">Waktu - Tanggal</th>
                <th data-field="state"  data-sortable="true" >Jenis Perizinan</th>
                <th data-field="obj"  data-sortable="true" >Objek Izin</th>
                <th data-field="id"  data-sortable="true">Status</th>
                <th data-field="price" data-sortable="false"></th>
              </tr>
            </thead>
            <tbody>
              <?php
              foreach($permohonan as $data){
                  switch ($data->status2) {
                    case 0:
                      $statusreal = 'FRONT OFFICE';
                      break;
                    case 1:
                      $statusreal = 'EVALUASI ADMINISTRASI';
                      break;
                    case 2:
                      $statusreal = 'PENJADWALAN TINJAUAN LAPANGAN';
                      break;
                    case 3:
                      $statusreal = 'EVALUASI DATA HASIL PENINJAUAN LAPANGAN (TIM TEKNIS)';
                      break;
                    case 4:
                      $statusreal = 'PENYUSUNAN PERTIMBANGAN TEKNIS (TIM TEKNIS)';
                      break;
                    case 5:
                      $statusreal = 'PENETAPAN IZIN';
                      break;
                    case 6:
                      $statusreal = 'PENGESAHAN IZIN';
                      break;
                    case 7:
                      $statusreal = 'PENCETAKAN NASKAH IZIN';
                      break;
                    case 8:
                      $statusreal = 'PENGAMBILAN NASKAH IZIN';
                      break;
                    case 9:
                      $statusreal = 'SELESAI';
                      break;
                  }
                

                $sql 	= "select * from trperizinan where id=?";
                $nama	= $otherdb->query($sql, array($data->id_perizinan))->first_row();

                $sqlportalbo  = "select * from tmpemohon_portal where id_permohonan_portal = ?";
                $portalbo     = $otherdb->query($sqlportalbo, array($data->id))->first_row();
                $hidden       = (!empty($portalbo->hidden) ? $portalbo->hidden : 0);

                $no_resi = $data->no_permohonan;
                $permohonan	= $otherdb->get_where("tmpermohonan",array("pendaftaran_id"=>$no_resi))->num_rows();
                $isimohon = $otherdb->get_where("tmpermohonan",array("pendaftaran_id"=>$no_resi))->first_row();

                $tolaksurat = array();
                if (!empty($isimohon)) {
                	$sqltolak = "select * from persuratan_tmpermohonan where tmpermohonan_id=?";
                	$tolaksurat = $otherdb->query($sqltolak, array($isimohon->id))->first_row();
                }
                

                //var_dump($tolaksurat);die;

                if($permohonan != 0 || $data->status == 'Online') {
                  ?>
                  <tr>
                    <td>
                      <?php
                      echo $no_resi;
                      if($permohonan != 0) {
                        echo anchor('main/permohonan/cetak_resi/'.$data->id, 'Cetak Resi',array("class"=>"btn btn-block btn-primary"));
                      }
                      //echo '<script type="text/javascript">console.log("'.htmlentities($data->skm).'");</script>';
                      if ($data->status2 >= 6) {
                        if (($data->kelompok == 3 || $data->kelompok == 4)) { // Kelompok Bertarif
                          if ($data->retribusi == 1) {   // Jika sudah bayar Retribusi
                              if (file_exists('backoffice/assets/esignfile/SK_'.$no_resi.'.pdf')) {
                              	if ($data->approve == 2) {
                              		// if ($data->skm == 2) {
		                              //   echo anchor('https://dpmptsp.jabarprov.go.id/skm/skm_form.php?resi='.$no_resi, 'Belum Mengisi Survey',array("class"=>"btn btn-block btn-danger", "target" => "_blank"));
		                              // } else {
		                              // echo anchor('main/permohonan/cetak_sk/'.$data->id.'/1', 'Cetak SK',array("class"=>"btn btn-block btn-success")); //disable retribusi
		                              // }
                              	} else {
                              		if ($data->status_berkas != "Izin Ditolak") {
                              			if ($data->approve == 1) { ?>
		                                    <button class="btn btn-block btn-warning" onclick="alert('Cetak Mandiri izin menunggu Approval Eselon 4');">Eselon 4</button>
		                                  <?php } elseif($data->approve == 4) { ?>
		                                    <button class="btn btn-block btn-warning" onclick="alert('Cetak Mandiri izin menunggu Approval Eselon 3');">Eselon 3</button>
		                                  <?php } elseif($data->approve == 3) { ?>
		                                    <button class="btn btn-block btn-warning" onclick="alert('Cetak Mandiri izin menunggu Approval Eselon 2');">Eselon 2</button>
		                                  <?php } else {
		                                    echo "&nbsp;";
		                                }
                              		}
                                }
                            } else {
                                  if ($data->approve == 1) { ?>
                                    <button class="btn btn-block btn-warning" onclick="alert('Cetak Mandiri izin menunggu Approval Eselon 4');">Eselon 4</button>
                                  <?php } elseif($data->approve == 4) { ?>
                                    <button class="btn btn-block btn-warning" onclick="alert('Cetak Mandiri izin menunggu Approval Eselon 3');">Eselon 3</button>
                                  <?php } elseif($data->approve == 3) { ?>
                                    <button class="btn btn-block btn-warning" onclick="alert('Cetak Mandiri izin menunggu Approval Eselon 2');">Eselon 2</button>
                                  <?php } else {
                                    echo "&nbsp;";
                                  }
                                }
                            //elseif (file_exists('backoffice/assets/skpdf/SK_'.$no_resi.'.pdf')) {
                              //echo anchor('main/permohonan/cetak_sk/'.$data->id.'/2', 'Cetak SK',array("class"=>"btn btn-block btn-success"));
                            //}
                          }
                        } else {
                          if (file_exists('backoffice/assets/esignfile/SK_'.$no_resi.'.pdf')) {
                          	if ($data->approve == 2) {
                              // if ($data->skm == 2) {
                              //   echo anchor('https://dpmptsp.jabarprov.go.id/skm/skm_form.php?resi='.$no_resi, 'Belum Mengisi Survey',array("class"=>"btn btn-block btn-danger", "target" => "_blank"));
                              // } else {
                                echo anchor('main/permohonan/cetak_sk/'.$data->id.'/1', 'Cetak SK',array("class"=>"btn btn-block btn-success", "target" => "_blank"));
                              // }
                          	} else {
                                  if ($data->approve == 1) { ?>
                                    <button class="btn btn-block btn-warning" onclick="alert('Cetak Mandiri izin menunggu Approval Eselon 4');">Eselon 4</button>
                                  <?php } elseif($data->approve == 4) { ?>
                                    <button class="btn btn-block btn-warning" onclick="alert('Cetak Mandiri izin menunggu Approval Eselon 3');">Eselon 3</button>
                                  <?php } elseif($data->approve == 3) { ?>
                                    <button class="btn btn-block btn-warning" onclick="alert('Cetak Mandiri izin menunggu Approval Eselon 2');">Eselon 2</button>
                                  <?php } else {
                                    echo "&nbsp;";
                                  }
                                }
                          } else {
                                  if ($data->status_berkas != "Izin Ditolak") {
                              			if ($data->approve == 1) { ?>
		                                    <button class="btn btn-block btn-warning" onclick="alert('Cetak Mandiri izin menunggu Approval Eselon 4');">Eselon 4</button>
		                                  <?php } elseif($data->approve == 4) { ?>
		                                    <button class="btn btn-block btn-warning" onclick="alert('Cetak Mandiri izin menunggu Approval Eselon 3');">Eselon 3</button>
		                                  <?php } elseif($data->approve == 3) { ?>
		                                    <button class="btn btn-block btn-warning" onclick="alert('Cetak Mandiri izin menunggu Approval Eselon 2');">Eselon 2</button>
		                                  <?php } else {
		                                    echo "&nbsp;";
		                                }
                              		}
                                }
                          //elseif (file_exists('backoffice/assets/skpdf/SK_'.$no_resi.'.pdf')) {
                            //echo anchor('main/permohonan/cetak_sk/'.$data->id.'/2', 'Cetak SK',array("class"=>"btn btn-block btn-success"));
                          //}
                        }
                      }
                      
                      ?>
                    </td>
                    <td><?php echo date("H:i:s - d M y",strtotime($data->d_entry)); ?></td>
                    <td><?php echo $nama->n_perizinan; ?></td>
                    <td><?php echo $data->obj; ?></td>
                    <td>
                      <?php 
                      $status = $data->status;
                      if ($status == 'Online') {
                        if ($hidden == 1) {
                          $status = 'MELEBIHI MASA ASISTENSI';
                        } else {
                          $status = 'ASISTENSI';
                        }
                      } elseif ($status == 'IZIN DISETUJUI' || $status == 'IZIN DITOLAK') {
                        $status = $data->status.' - '.$statusreal;
                      } else {
                        $status = $statusreal;
                      }

                      echo $status;
                      if (!empty($data->status_berkas) && $data->status_berkas == "Izin Ditolak") {
                      	if (!empty($tolaksurat) && file_exists('backoffice/assets/esign-surat/SRT_'.$tolaksurat->persuratan_id.'.pdf')) {
                      		echo "<br>".anchor('main/permohonan/cetak_tolak/'.$tolaksurat->persuratan_id, 'Unduh Penolakan',array("style"=>"background:#1ebfae;color:white","class"=>"btn"));
                      	} else {
                      		echo "<br>".anchor('main/permohonan/detailpenolakan/'.$data->uuid, 'Detail Penolakan',array("style"=>"background:#1ebfae;color:white","class"=>"btn"));
                      	}
                      } 
                      ?>
                    </td>
                    <td>
                      <?php
                      $text = "Detail";
                      if($data->editable=="1" && $data->status!="DITOLAK"){
                        $text = "Ubah";
                        if(!empty($data->approve)){
                        $text = "Ubah";
                          if($data->approve == 2){
                            $text = "Detail";
                          }
                        }
                      }
                      ?>
                      <?php echo anchor('main/permohonan/detail/'.$data->uuid, $text,array("style"=>"background:#1ebfae;color:white","class"=>"btn")) ?>
                    </td>
                  </tr>
                  <?php
                }
              }
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div><!--/.row-->	
</div><!--/.main-->