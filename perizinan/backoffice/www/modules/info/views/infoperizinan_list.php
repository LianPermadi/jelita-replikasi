<div id="content">
  <div class="post">
    <div class="title">
      <?php echo $this->lib_date->view_title($page_name); ?>
    </div>
    <div class="entry">
      <table cellpadding="0" cellspacing="0" border="0" class="display" id="perizinaninfo">
        <thead>
          <tr>
            <th width="2%">No</th>
            <th width="4%">Kode Izin</th>
            <th width="41%">Nama Layanan Publik</th>
            <th width="30%">Dinas Pengelola Layanan</th>
            <th width="8%">Durasi Pengerjaan (Hari)</th>
            <th width="8%">Masa Berlaku Izin (Tahun)</th>
            <th width="3%">Status</th>
            <th width="4%">Aksi</th>
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
          
          $i = 0;
          foreach ($list as $data){
          	if($data->kd_izin != 999999){
              $berlaku = $data->v_berlaku_tahun;
              if($berlaku <> '1000') {
                if($berlaku >= 12) {
                  $berlaku = number_format($data->v_berlaku_tahun/12, 1, ',', '.') . ' Thn';
                }else{
                  $berlaku = $data->v_berlaku_tahun . ' Bln';
                }
              }else{
                $berlaku = 'Tidak Terbatas';
              }
              
              if($data->c_online == 0){
                $status = 'Aktif';
                $b = '';
                $be = '';
              }else{
                $status = 'Tidak';
                $b = '<span style="color: Red">';
                $be = '</span>';
              }
              $i++;
              $kd_izin = substr($data->kd_izin,0,2).'.'.substr($data->kd_izin,2,1).'.'.substr($data->kd_izin,3,2).'.'.substr($data->kd_izin,5);
              $trunitkerja = new trunitkerja();
			        $trunitkerja = $trunitkerja->where('id', $data->dinas_pengelola)->get();
              $dinas_pengelola = $trunitkerja->n_unitkerja; 
              ?>
              <tr>
                <td><?php echo $i; ?></td>
                <td><?php echo $b . $kd_izin . $be; ?></td>
                <td><?php echo $b . strtoupper($data->n_perizinan) . $be; ?></td>
                <td><?php echo $b . $dinas_pengelola . $be; ?></td>
                <td><center><?php echo $b . $data->v_hari . $be; ?></center></td>
                <td><?php echo $b . $berlaku . $be; ?></td>
                <td><center><?php echo $b . $status . $be; ?></center></td>
                <td><center>
                  <?php
                  $img_info = array('src' => base_url().'assets/images/icon/information.png',
                                    'alt' => 'Lihat Persyaratan',
                                    'title' => 'Lihat Persyaratan',
                                    'border' => '0',
                                   );
                  echo anchor(site_url('info/infoperizinan/detail') .'/'. $data->id, img($img_info))."&nbsp;";
                  ?>
                  </center>
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
  <br style="clear: both;" />
</div>