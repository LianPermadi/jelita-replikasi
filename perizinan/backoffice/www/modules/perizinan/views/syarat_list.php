<div id="content">
  <div class="post">
    <div class="title">
      <h2><?php echo $page_name; ?></h2>
    </div>
    <div class="entry">
      <table cellpadding="0" cellspacing="0" border="0" class="display" id="syaratizin">
        <thead>
          <tr>
            <th width="2%">No</th>
		      	<th width="5%">Kode Izin</th>
            <th width="40%">Jenis Izin</th>
			      <th width="10%">Sektor</th>
            <th width="28%">Kelompok Perizinan</th>
			      <th width="5%">Data Pemohon</th>
            <th width="5%">Jumlah Syarat</th>
            <th width="5">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php
		      $ok=array();
          if($list_izin){
            foreach ($list_izin as $dt_urg) {
              $ok[]=$dt_urg->trperizinan_id;
            }
          }
          $i = null;
          foreach ($list as $data){
            $data->trkelompok_perizinan->get();
            $data->tralur_perizinan->get();
            $data->trsyarat_perizinan->get(); 
			      $data->trsektor->get();
            $i++;
			      if($data->trsyarat_perizinan->count() > 0) {
              $jml_syarat = $data->trsyarat_perizinan->count();
				      $jml_blue = $data->trsyarat_perizinan->where('status_new',0)->count();
				      $a = FALSE;
            }else{
              $jml_syarat = 'Kosong';
				      $jml_blue = 0;
				      $a = TRUE;
            }
			      if(in_array($data->id, $ok)){
              $aktif = 'Ada';
				      $a1 = TRUE;
            }else{
              $aktif = 'Kosong';
				      $a1 = FALSE;
		      	}
			      if($a && $a1) {
			        $b = '<span style="color: Red">';
			        $be = '</span>';
			      }else{
              $b = '';
			        $be = '';
	      		}
			      if($jml_blue > 0) {
			        $b = '<span style="color: Blue">';
			        $be = '</span>';
		      	}
			      if($a && !$a1) {
			        $b = '<span style="color: Red">';
			        $be = '</span>';
			      }
            ?>
            <tr>
              <td><?php echo $i; ?></td>
  				    <td><?php echo $b . $data->kd_izin . $be; ?></td>
              <td><?php echo $b . $data->n_perizinan . $be;?></td>
	  			    <td><?php echo $b . $data->trsektor->n_sektor . $be; ?></td>
              <td><?php echo $b . $data->trkelompok_perizinan->n_kelompok . $be; ?></td>
		  		    <td><?php echo "<center>". $b . $aktif . $be ."</center>"; ?></td>
              <td><?php echo "<center>". $b . $jml_syarat . $be ."</center>"; ?></td>
              <td>
              	<center>
                  <?php
                  $img_detail = array('src' => base_url().'assets/images/icon/property.png',
                                      'alt' => 'Detail',
                                      'title' => 'Detail',
                                      'border' => '0',
                                     );
                  echo anchor(site_url('perizinan/persyaratanizin/detail') .'/'. $data->id, img($img_detail));
                  echo "&nbsp;&nbsp;";
                  
                  /*$cek_dt = new trproperty();
                  $is_use_in_permohonan = $cek_dt->is_perizinan_used_in_permohonan($data->id);
                  if(!$is_use_in_permohonan){
                    $img_delete = array('src' => base_url().'assets/images/icon/cross.png',
                                        'alt' => 'Detail',
                                        'title' => 'Detail',
                                        'border' => '0',
                                       );
                    echo anchor(site_url('perizinan/persyaratanizin/delete') .'/'. $data->id.'/',img($img_delete));
                  }*/
                  ?>
				      	</center>
              </td>
            </tr>
            <?php
          }
            ?>
        </tbody>
        <tfoot>
          <tr>
            <th width="2%">No</th>
			      <th width="5%">Kode Izin</th>
            <th width="40%">Jenis Izin</th>
			      <th width="10%">Sektor</th>
            <th width="28%">Kelompok Perizinan</th>
			      <th width="5%">Data Pemohon</th>
            <th width="5%">Jumlah Syarat</th>
            <th width="5">Aksi</th>
          </tr>
        </tfoot>
      </table>
    </div>
  </div>
  <br style="clear: both;" />
</div>