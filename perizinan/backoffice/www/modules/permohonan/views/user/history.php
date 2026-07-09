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
      <li class="active">History</li>
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
            <div class="col-md-9">
              History Permohonan Izin
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
                <th data-field="state"  data-sortable="true" >Jenis Perizinan</th>
                <th data-field="name" data-sortable="true">Waktu - Tanggal Pengajuan</th>
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

                $sql  = "select * from trperizinan where id='".$data->id_perizinan."'";
                $nama = $otherdb->query($sql)->first_row();

                $sqlportalbo  = "select * from tmpemohon_portal where id_permohonan_portal = ?";
                $portalbo     = $otherdb->query($sqlportalbo, array($data->id))->first_row();
                $hidden       = (!empty($portalbo->hidden) ? $portalbo->hidden : 0);

                $no_resi = $data->no_permohonan;
                $permohonan = $otherdb->get_where("tmpermohonan",array("pendaftaran_id"=>$no_resi))->num_rows();
                //if($permohonan != 0 || $data->status == 'Online') {
                  ?>
                  <tr>
                    <td>
                      <?php
                      
                        echo $no_resi;
                      
                        if($permohonan != 0) {
                        echo anchor('main/permohonan/cetak_resi/'.$data->id, 'Cetak Resi',array("class"=>"btn btn-block btn-primary"));
                        }
	                        if ($data->status2 == 8) {
		                        if (($data->kelompok == 3 || $data->kelompok == 4)) {
		                          if ($data->retribusi == 1) {
		                              if (file_exists('backoffice/assets/esignfile/SK_'.$no_resi.'.pdf')) {
		                              echo anchor('main/permohonan/cetak_sk/'.$data->id.'/1', 'Cetak SK',array("class"=>"btn btn-block btn-success"));
		                            } 
                                //elseif (file_exists('backoffice/assets/skpdf/SK_'.$no_resi.'.pdf')) {
		                              //echo anchor('main/permohonan/cetak_sk/'.$data->id.'/2', 'Cetak SK',array("class"=>"btn btn-block btn-success"));
		                            //}
		                          }  
		                        } else {
		                          if (file_exists('backoffice/assets/esignfile/SK_'.$no_resi.'.pdf')) {
		                            echo anchor('main/permohonan/cetak_sk/'.$data->id.'/1', 'Cetak SK',array("class"=>"btn btn-block btn-success"));
		                          } 
                              //elseif (file_exists('backoffice/assets/skpdf/SK_'.$no_resi.'.pdf')) {
		                            //echo anchor('main/permohonan/cetak_sk/'.$data->id.'/2', 'Cetak SK',array("class"=>"btn btn-block btn-success"));
		                          //}
		                        }
		                      }

                      ?>
                    </td>
                    <td><?php echo $nama->n_perizinan; ?></td>
                    <td><?php echo date("H:i:s - d M y",strtotime($data->d_entry)); ?></td>
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
                      } elseif($data->gagal == 1) {
                        $status = $data->status;
                      } else {
                        $status = $statusreal;
                      }

                      echo $status;
                      if (!empty($data->status_berkas) && $data->status_berkas == "Izin Ditolak") {
                        echo "<br>".anchor('main/permohonan/detailpenolakan/'.$data->uuid, 'Detail Penolakan',array("style"=>"background:#1ebfae;color:white","class"=>"btn"));
                      } 
                      ?>
                    </td>
                    <td>
                      <?php
                      $text = "Detail";
                      if($data->editable=="1" && ($data->status!="Ditolak")){
                        $text = "Ubah";
                      }
                      ?>
                      <?php echo anchor('main/permohonan/detail/'.$data->uuid, $text,array("style"=>"background:#1ebfae;color:white","class"=>"btn")); ?>
                    </td>
                  </tr>
                  <?php
                //}
              }
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div><!--/.row-->	
</div><!--/.main-->