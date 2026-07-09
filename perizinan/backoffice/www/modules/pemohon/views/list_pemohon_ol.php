<div id="content">
  <div class="post">
    <div class="title">
      <h2><?php echo $page_name; ?></h2>
    </div>
    <div class="entry">
      <fieldset id="half">
        <legend>Filter Data</legend>
        <?php
        $attr = array('class' => 'searchForm','id' => 'searchForm');
        echo form_open("pemohon/pemohon_online", $attr);
        ?>
        <div id="statusRail">
          <div id="leftRail">
            <?php
            echo form_label('Kategori Pencarian', 'label_pencarian');
    		    echo form_hidden('mark', 'next');
            ?>
    	    </div>
    	    <div id="rightRail">
    	      <?php
            $kat_cari = array('1' => 'NAMA PEMOHON',
                              '2' => 'NOMOR HP PEMOHON',
    		                      '3' => 'E-MAIL PEMOHON',
    		                      '4' => 'USERNAME');
            echo form_dropdown('list_state', $kat_cari, $list_state, 'class = "input-select-wrc" id="selector"');
            ?>
          </div>
        </div>

        <div id="statusRail">
          <div id="leftRail">
            <?php
              echo form_label('Kata Pencarian', 'kt_cari');
            ?>
          </div>
          <div id="rightRail">
            <input type="text" class="input-wrc required" name="kt_cari" id="kt_cari" value="<?php echo $kt_cari; ?>" />
          </div>
        </div>
        
        <div id="statusRail">
          <div id="rightRail">
            <?php
            $filter_data = array('name' => 'button',
                                 'class' => 'button-wrc',
                                 'content' => 'Cari Data',
                                 'value' => 'Cari Data'
                                );
            echo form_submit($filter_data);
            ?>
          </div>
        </div>
        <?php
        echo form_close();
        ?>
      </fieldset>
    </div>
    
    <div class="entry">
      <fieldset>
      	<legend>Filter Data Tanggal Daftar</legend>
        <?php
        $attr = array('class' => 'searchForm','id' => 'searchForm');
        echo form_open("pemohon/pemohon_online", $attr);
        $periodeawal_input = array('name' => 'first_date',
                                   'class' => 'monbulan',
                                   'id' => 'firstDateInput',
                                   'readOnly'=>TRUE,
                                   'value' => $first_date
                                  );
        $periodeakhir_input = array('name' => 'second_date',
                                    'class' => 'monbulan',
                                    'id' => 'secondDateInput',
                                    'readOnly'=>TRUE,
                                    'value' => $second_date
                                   );
        $cari = array('name' => 'submit',
                       'value'=>'Cari',
                       'class' => 'button-wrc',
                       'content' => 'Cari Data',
                       'type' => 'submit',
                       'onclick' => 'return validasi()'
                      );
        ?>
        <table>
          <tr>
            <td> <?php echo 'Tanggal Daftar Awal : ' . form_input($periodeawal_input); ?> </td>
            <td> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td> <?php echo 'Tanggal Daftar Akhir : '. form_input($periodeakhir_input); ?> </td>
            <td> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td> <?php echo form_button($cari);?> </td>
          </tr>
        </table>
        <?php
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
      <br>
      <?php
    }
      ?>  
       
    <div class="entry">
      <table cellpadding="0" cellspacing="0" border="0" class="display" id="monitoring">
        <thead>
          <tr>
            <th width="3%">No</th>
            <th width="23%">Nama Pemohon<br>Nomor HP Pemohon<br>E-Mail Pemohon</th>
            <th width="20%">Nama Pemegang Kuasa<br>Nomor HP Kuasa</th>
            <th width="12%">Tanggal Daftar<br>User Name<br>Token</th>
            <th width="5%">Jumlah<br>Permohonan</th>
            <th width="32%">Jenis Permohonan Terakhir</th>
            <th width="5%">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $i = 0;
          if($lokasi == 'OPD Teknis') {
            if($cek_sektor == '10') // khususu Perhubungan
              $lihat = TRUE;
            else
              $lihat = FALSE;
          }else{
            $lihat = TRUE;
          }
          if($lihat) {
            foreach ($list_data as $data) {
              $this->load->model('dbmodel_portal');
              $jns_izin = $this->dbmodel_portal->dbportal_sql("select * from tmpermohonan_portal where id_pemohon = '".$data->id."'"."ORDER BY `id` DESC");
              $jml_mhn = $this->dbmodel_portal->dbportal_sql_hit("select * from tmpermohonan_portal where id_pemohon = '".$data->id."'"."ORDER BY `id` DESC");
              if($jml_mhn==0){
                $jml_mhn='-';
                $n_izin = '-';
              }else{
                $perizinan = new trperizinan();
                $perizinan->get_by_id($jns_izin[0]->id_perizinan);
                $n_izin = $perizinan->n_perizinan;
              }
              
              $i++;
              if($data->username == ''){
                $b = '<span style="color: Red">'; $be = '</span>';
                $cek = TRUE;
              }else{
                $b = ''; $be = '';
                $cek = FALSE;
              }
              if($data->namaPerusahaan  == '') $namaPerusahaan  = '-'; else $namaPerusahaan  = $data->namaPerusahaan;
              if($data->telpPerusahaan  == '') $telpPerusahaan  = '-'; else $telpPerusahaan  = $data->telpPerusahaan;
              if($data->emailPerusahaan == '') $emailPerusahaan = '-'; else $emailPerusahaan = $data->emailPerusahaan;
              if($data->namaPemohon     == '') $namaPemohon     = '-'; else $namaPemohon     = $data->namaPemohon;
              if($data->telpPemohon     == '') $telpPemohon     = '-'; else $telpPemohon     = $data->telpPemohon;
              if($data->username        == '') $username        = '-'; else $username        = $data->username;
              ?>
              <tr>
                <td><?php echo $i; ?></td>
                <td valign='top'><?php echo $b . $namaPerusahaan .' ['. $data->id .'] <br>'. $telpPerusahaan .'<br>'. $emailPerusahaan .$be; ?></td>
                <td valign='top'><?php echo $b . $namaPemohon .'<br>'. $telpPemohon . $be; ?></td>
                <td valign='top'><?php echo $b . $this->lib_date->mysql_to_human($data->tgl_daftar).'<br>'.$username.'<br>'.$data->token.$be; ?></td>
                <td valign='top' align='center'><?php echo $b . $jml_mhn . $be; ?></td>
                <td valign='top'><?php echo $b . $n_izin . $be; ?></td>
                <td>
                  <?php
		              if($hak=="administrator"){
                    $img_detail = array('src' => base_url().'assets/images/icon/property.png',
                                        'alt' => 'Edit',
                                        'title' => 'Edit',
                                        'border' => '0',
                                       );
                    if($cek == FALSE) echo anchor(site_url('pemohon/pemohon_online/detail') .'/'. $data->id, img($img_detail));
		              }
                  $img_token = array('src' => base_url().'assets/images/icon/navigation.png',
                                     'alt' => 'Kirim E-mail Token',
                                     'title' => 'Kirim E-mail Token',
                                     'border' => '0',
                                    );
                  if($cek) echo anchor(site_url('pemohon/pemohon_online/token') .'/'. $data->token .'/'. $emailPerusahaan, img($img_token));
		              if($hak=="administrator"){
                    $confirm_text = 'Apakah Anda yakin akan menghapusnya ?';
                    $img_delete = array('src' => base_url().'assets/images/icon/cross.png',
                                        'alt' => 'Delete',
                                        'title' => 'Delete',
                                        'border' => '0',
                                        'onClick' => 'return confirm_link(\''.$confirm_text.'\')',
                                       );
                    if($cek) echo anchor(site_url('pemohon/pemohon_online/hapus') .'/'. $data->id, img($img_delete));
                  }
                  
    	            ?>
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