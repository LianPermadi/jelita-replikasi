<div id="content">
  <div class="post">
    <div class="title">
      <h2><?php echo $page_name; ?></h2>
    </div>

    <div class="entry">
      <fieldset>
        <legend>Filter Data Tanggal d|sign</legend>
        <?php
        echo form_open('settings/webservice/logEsign');
        $periodeawal_input = array('name'  => 'tgla',
                                   'value' => $tgla,
                                   'class' => 'input-wrc',
                                   'readOnly'=>TRUE,
                                   'class' => 'monbulan'
                                  );
        $periodeakhir_input = array('name'  => 'tglb',
                                    'value' => $tglb,
                                    'class' => 'input-wrc',
                                    'readOnly'=>TRUE,
                                    'class' => 'monbulan'
                                   );
        $filter_data = array('name' => 'button',
                             'class' => 'button-wrc',
                             'content' => 'Cari Data',
                             'value' => 'Cari Data'
                            );
        ?>
        <table>
          <tr>
            <td> <?php echo 'Tanggal d|sign Awal : ' . form_input($periodeawal_input); ?> </td>
            <td> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td> <?php echo 'Tanggal d|sign Akhir : '. form_input($periodeakhir_input); ?> </td>
            <td> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td> <?php echo form_submit($filter_data);?> </td>
          </tr>
        </table>
        <?php
        echo form_hidden('kd_filter', '2');
        echo form_close();
        ?>
      </fieldset>
    </div>
    
    <?php 
        $alert = $this->session->flashdata("sukses");
        if(!empty($alert)){
      ?>
        <br>
        <div style="color: green; font-size: 12px; margin-left: 20px; margin-bottom: 10px; font-weight: bold;"><center><?php echo $alert; ?></center></div>
      <?php } ?>

      <?php 
        $alert = $this->session->flashdata("gagal");
        if(!empty($alert)){
      ?>
        <br>
        <div style="color: red; font-size: 12px; margin-left: 20px; margin-bottom: 10px; font-weight: bold;"><center><?php echo $alert; ?></center></div>
      <?php } ?>
    
    <div class="entry">
      <table cellpadding="0" cellspacing="0" border="0" class="display" id="pendataan">
        <thead>
          <tr>
            <th width="5%">No</th>
            <th width="15%">Tanggal : Jam d|sign</th>
            <th width="20%">Penandatangan</th>
            <th width="15%">Dokumen</th>
            <th width="40%">Status</th> 
            <th width="5%">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php 
          $i = 1;
          foreach ($surat as $row) { 
          	$nfile = '';
          	$nsize = '';
          	switch(substr($row->dokumen,0,2)){ 
              case 'SR' : // jika persurata
                //$nfile = base_url().'assets/esign-surat/'.$row->dokumen;
                break;
              case 'SK' : // jika SK
                //$nfile = base_url().'assets/esignfile/'.$row->dokumen;
                break;
              case 'KP' : // jika KP
                //$nfile = base_url().'assets/esignfile/'.$row->dokumen;
                break;  
            }
            if($nfile != '') $nsize = round((filesize($nfile)) / 1024 / 1024, 3) ." MB.<br>";
            
          	if($row->status == 1) { 
              $b = '<span style="color: Red">';
              $be = '</span>';
            }else{
              $b = '';
              $be = '';
            }?>
            <tr>
              <td><?php echo $i; ?></td>
              <td><?php echo $b.$this->lib_date->mysql_to_human($row->tgl_ttd).' : '.substr($row->tgl_ttd, 10).$be; ?></td>
              <td><?php echo $b.$this->m_webservice->get_namauser($row->nik).$be; ?></td>
              <td><?php echo $b.$row->dokumen.' '.$nsize.$be; ?></td>
              <td><?php echo $b.($row->status == 0 ? "<span style='color: Green'>Sukses</span>" : "Gagal ".$row->info).$be; ?></td>
              <td>
                <?php 
                  $img_parent = array('src' => base_url().'assets/images/icon/information.png',
                                      'alt' => 'Detail',
                                      'title' => 'Detail',
                                      'border' => '0',
                                     );

                  echo anchor('settings/webservice/logEsignDetail/'.$row->id, img($img_parent))."&nbsp;";
                 ?>
              </td>
            </tr>
          <?php $i++; } ?>
        </tbody>
      </table>
    </div>
  </div>
  <br style="clear: both;" />
</div>