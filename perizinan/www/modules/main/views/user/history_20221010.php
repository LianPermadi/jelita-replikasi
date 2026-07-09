<?php	$base_url=base_url().'assets/userassets/'; ?>
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
          <table data-toggle="table"   data-show-columns="true" data-search="true" data-select-item-name="toolbar1" data-pagination="true" data-sort-name="name" data-sort-order="desc">
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
                $otherdb  = $this->load->database('otherdb', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
                $sql  = "select * from trperizinan where id='".$data->id_perizinan."'";
                $nama = $otherdb->query($sql)->first_row();
                $no_resi = $data->no_permohonan;
                $permohonan = $otherdb->get_where("tmpermohonan",array("pendaftaran_id"=>$no_resi))->num_rows();
                //if($permohonan != 0 || $data->status == 'Online') {
                  ?>
                  <tr>
                    <td>
                      <?php
                      if (empty($no_resi) && $data->status == 'Online') {
                        echo "Dalam Masa Asistensi";
                      } else {
                        echo $no_resi;
                      }
                      
                      if($permohonan != 0) {
                        echo anchor('main/permohonan/cetak_resi/'.$data->id, 'Cetak Resi',array("class"=>"btn btn-block btn-primary"));
                      }
                      ?>
                    </td>
                    <td><?php echo (!empty($nama->n_perizinan) ? $nama->n_perizinan : ' - '); ?></td>
                    <td><?php echo date("H:i:s - d M y",strtotime($data->d_entry)); ?></td>
                    <td>
                      <?php 
                      $status = $data->status;
                      if($status == 'Online') $status = 'Asistensi';
                      if($status == 'Penyerahan Izin') $status = 'Disetujui';
                      echo $status; 
                      ?>
                    </td>
                    <td>
                      <?php
                      $text = "Detail";
                      if($data->editable=="1" && ($data->status!="Ditolak" || $data->status!="Ditolak (Berkas Persyaratan tidak ter-upload dengan sempurna, silahkan ulangi Permohonan Perizinan)")){
                        $text = "Ubah";
                      }
                      ?>
                      <?php echo anchor('main/permohonan/detail/'.$data->uuid, $text,array("style"=>"background:#1ebfae;color:white","class"=>"btn")) ?>
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