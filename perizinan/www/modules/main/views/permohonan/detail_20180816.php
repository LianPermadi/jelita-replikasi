<?php 
	$base_url	= "assets/userassets/pemohon/".$username."/pengajuan/".$permohonan->id."/";
?>
<style>
  .text{
    *padding-top:7px!important;
    text-align:right;
  }
  .text2{
    padding-top:7px!important;
    text-align:right;
  }
</style>
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
  <div class="row">
    <ol class="breadcrumb">
      <li><a href="#"><span class="glyphicon glyphicon-home"></span></a></li>
      <li >Permohonan</li>
      <li class="active">Detail</li>
    </ol>
  </div><!--/.row-->
  
  <div class="row">
    <div class="col-lg-12">
      <!--h1 class="page-header"></h1-->
    </div>
  </div>
  
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
            Pada halaman ini ditampilkan detail data permohonan yang telah Anda ajukan sebelumnya.<br>
          </div>
        </div>
      </div>
      <div class="panel panel-default">
        <div class="panel-heading">
          <div class="row">
            <div class="col-md-10">Detail Permohonan</div>
            <div class="col-md-2">
            	<?php
            	if($his == 'his')
                echo anchor('main/user/history', 'Kembali',array("class"=>"btn btn-block btn-primary"));
            	else
                echo anchor('main/user/permohonan', 'Kembali',array("class"=>"btn btn-block btn-primary"));
            	?>
            </div>
          </div>
        </div>
        <div class="panel-body">
          <form role="form">
            <div class="form-group">
              <div class="col-md-12">
                <?php 
                $success 	= $this->session->flashdata("success");
                if(!empty($success)){
                  ?>
                  <div class="alert bg-success" role="alert" style="background:#7EB332;">
                    <span class="glyphicon glyphicon-check"></span> <?php echo $success; ?>
                  </div>
                  <?php
                }
                ?>
                <?php 
                $error 	= $this->session->flashdata("error");
                if(!empty($error)){
                  ?>
                  <div class="alert bg-danger" role="alert" style="">
                    <span class="glyphicon glyphicon-check"></span> <?php echo $error; ?>
                  </div>
                  <?php
                }
                ?>
              </div>
            </div>
            <div class="form-group">
              <div class="col-md-12">
                <label class="col-md-3 text">Nomor Pendaftaran :</label>
                <label class="col-md-9" class="text2">
                  <?php 
                  if($permohonan->no_permohonan == '')
                    echo 'Permohonan dalam tahap ASISTENSI';
                  else
                    echo $permohonan->no_permohonan; 
                  ?>
                </label>
              </div>
            </div>
            <div class="form-group">
              <div class="col-md-12">
                <label class="col-md-3 text">Perizinan yang Dipilih :</label>
                <label class="col-md-9" class="text2"><?php echo $nama; ?></label>
              </div>
            </div>
            <div class="form-group">
              <div class="col-md-12">
                <label class="col-md-3 text">Tanggal Pengajuan :</label>
                <label class="col-md-9" class="text2"><?php echo date("d - M - Y",strtotime($permohonan->d_entry)) ?></label>
              </div>
            </div>
            <div class="form-group">
              <div class="col-md-12">
                <label class="col-md-3 text">Status :</label>
                <label class="col-md-9" class="text2"><?php echo $status; ?></label>
              </div>
            </div>
          </form>

          <!-- MENAMPILKAN ISI SYARAT -->
          <table data-toggle="table"   data-show-columns="true" data-search="true" data-select-item-name="toolbar1" data-pagination="true" data-sort-name="name" data-sort-order="desc">
            <thead>
              <tr>
                <th data-field="no"  data-sortable="true" >No</th>
                <th data-field="state"  data-sortable="true" >Syarat</th>
                <th data-field="id" data-sortable="true">Status Upload</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $no = 0;
              foreach($persyaratan as $data){ 
                $no++;
                ?>
                <tr>
                  <td>
                    <?php echo $no; ?>
                  </td>
                  <td>
                    <?php echo $data->v_syarat; ?>
                  </td>
                  <td>
                    <?php 
                    // echo $data->id .".pdf"; 
                    echo anchor($base_url.$data->id.".pdf", "Download",array("target"=>"_blank")); 
                    ?></a>
                  </td>
                </tr>
                <?php
              }
              ?>
            </tbody>
          </table>
          
          <!-- MENAMPILKAN DATA TEKNIS -->
          <table data-toggle="table"   data-show-columns="true" data-search="true" data-select-item-name="toolbar1" data-pagination="true" data-sort-name="name" data-sort-order="desc">
            <thead>
              <tr>
                <th data-field="state"  data-sortable="true" >Data Teknis</th>
                <th data-field="id" data-sortable="true">Keterangan</th>
              </tr>
            </thead>
            <tbody>
              <?php 
              $no=1;
              $jumlah_semua = 1;
              while($no<=100){
                $tek = "var_teknis".$no;
                $prop = $property[$tek];
                if(empty($prop)){
                  break;
                }
                $array = explode("^",$prop);
                if($array[11]=="Ya"){ 
                  $dt_tek  = "dt_teknis".$array[0];
                  $cek_posisi = strpos($permohonan->$dt_tek,'^'); 
                  $cek_data = substr($permohonan->$dt_tek,0,$cek_posisi);
                  ?>
                  <tr>
              		  <td width="20%">
              		    <?php echo $array[1]; ?>
              		  </td>
              		  <td width="80%">
              		    <?php
                      echo $cek_data;
                      ?>
              		  </td>
                  </tr>
                  <?php 
                }
                $no++;
              }
              ?>
            </tbody>
          </table>
        </div>	
      </div>
      
      <?php
      if($track!=0){ 
        ?>
        <div class="panel panel-default">
          <div class="panel-heading">
            <div class="row">
              <div class="col-md-10">Tracking Permohonan Anda</div>
              <div class="col-md-2">
              </div>
            </div>
          </div>
          <div class="panel-body">
        	  <table data-toggle="table"  data-search="true" data-pagination="true" data-sort-name="tanggal" data-sort-order="desc">
        	    <thead>
        	      <tr>
        	        <th data-field="name"  data-sortable="true" >Proses Izin</th>
        	        <th data-field="tanggal"  data-sortable="true" >Tanggal</th>
        	        <th data-field="waktu"  data-sortable="true" >Waktu</th>
        	      </tr>
        	    </thead>
        	    <tbody>
        	      <?php
        	      foreach($track as $trac){ 
        	        ?>
        	        <tr>
        	          <td>
        	            <?php echo $trac->tr_activiti; ?>
        	          </td>
        	          <td>
        	            <?php echo date("d m Y",strtotime($trac->d_entry)); ?>
        	          </td>
        	          <td>
        	            <?php echo date("H:i:s",strtotime($trac->d_entry)); ?>
        	          </td>
        	        </tr>
        	        <?php
        	      } 
        	      ?>
        	    </tbody>
        	  </table>
        	</div>	
        </div>
        <?php
      }
      ?>
      
      <div class="panel panel-default">
        <div class="panel-heading">
          <div class="row">
            <div class="col-md-10">Asistensi Perizinan</div>
            <div class="col-md-2">
            </div>
          </div>
        </div>
        <div class="panel-body">
          <?php
          if(empty($permohonan->no_permohonan) && $belakang==1){ 
          ?>
            <form action="<?php echo base_url() . 'main/permohonan/addasistensi'; ?>#" method="post">
              <div class="row">						
                <div class="form-group">
                  <label class="col-md-2 text">Pesan Anda :</label>
                  <div class="col-md-8"><input type="text" name="pesan" class="form-control" ></div>
                  <input type="hidden" value="<?php echo $pemohon; ?>" name="pemohon">
                  <input type="hidden" value="<?php echo $permohonan->uuid; ?>" name="uuid">
                  <div class="col-md-2"><input type="submit" class="btn btn-block btn-primary" value="Kirim"></div>
                </div>
              </div>
            </form>
            <?php
          }
          ?>
          
          <table data-toggle="table"  data-search="true" data-pagination="true" data-sort-name="tanggal" data-sort-order="desc">
            <thead>
            <tr>
              <th data-field="name"  data-sortable="true" >Pesan</th>
              <th data-field="tanggal"  data-sortable="true" >Tanggal</th>
              <th data-field="oleh"  data-sortable="true" >Oleh</th>
            </tr>
            </thead>
            <tbody>
              <?php
              foreach($asistensi as $pesan){ 
                ?>
                <tr>
                  <td>
                    <?php echo $pesan->pesan; ?>
                  </td>
                  <td>
                    <?php echo date("h:i:s",strtotime($pesan->tanggal))." ".date("d M y",strtotime($pesan->tanggal)); ?>
                  </td>
                  <td>
                    <?php echo $pesan->oleh; ?>
                  </td>
                </tr>
                <?php
              }
              ?>
            </tbody>
          </table>
        </div>	
      </div>
    </div><!-- /.col-->
  </div><!-- /.row -->
</div><!--/.main-->
