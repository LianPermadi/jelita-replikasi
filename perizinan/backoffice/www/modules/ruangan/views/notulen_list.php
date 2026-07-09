<div id="content">
  <div class="post"> 
    <div class="title">
      <?php echo $this->lib_date->view_title($page_name); ?>
    </div>
      <?php 
    $alert = $this->session->flashdata("sukses");
    if(!empty($alert)){
      ?>
      <br>
      <div style="color: green; font-size: 12px; margin-left: 20px; margin-bottom: 10px; font-weight: bold;"><center><?php echo $alert; ?></center></div>
      <?php
    }
    ?>

    <?php 
    $alert = $this->session->flashdata("gagal");
    if(!empty($alert)){
      ?>
      <br>
      <div style="color: red; font-size: 12px; margin-left: 20px; margin-bottom: 10px; font-weight: bold;"><center><?php echo $alert; ?></center></div>
      <?php
    }
    ?>
    <div class="entry">
    	<b>
    	<font size="5"><center>DAFTAR EVIDEN</center></font> 
    	</b>
      <?php
      $back_data = array('name' => 'button',
                         'content' => 'Kembali',
                         'value' => 'Kembali',
                         'class' => 'button-wrc',
                         'onclick' => 'parent.location=\''. site_url('ruangan/index') . '\''
                        );
      echo form_button($back_data);
    //   var_dump($data_ruangan[0]->user_id == $id_auth);
    //   echo $data_ruangan[0]->user_id .'=='. $id_auth;
      if($this->All || $data_ruangan[0]->user_id == $id_auth){
      $ctk_list = array('name' => 'button',
                        'content' => 'Tambah PJ Eviden',
                        'value' => 'Tambah PJ Eviden',
                        'class' => 'button-wrc',
                        'onclick' => 'parent.location=\''.site_url('ruangan/tambah_eviden'). '/' . $id_kegiatan .'\''
                       );
      //if($this->All){
      echo form_button($ctk_list);
      }
      //}
      ?>
      <table cellpadding="0" cellspacing="0" border="0" class="display" id="pendataan">
        <thead>
          <tr>
            <th width="4%">No</th>
            <th width="23%">Nama Notulensi</th>
            <th width="30%">Eviden</th>
            <th width="22%">Keterangan</th>
            <?php if($this->All || $data_ruangan[0]->user_id == $id_auth){ ?>
            <th width="4%">Aksi</th>
            <?php } ?>
          </tr>
        </thead>
        <tbody>
          <?php 
          $i = 1;
          foreach ($data_notulen as $row) { 
          	?>
            <tr>
              <td><?php echo $i; ?></td>
              <td><?php echo $this->m_ruangan->get_n_pegawai($row->id_pegawai); ?></td>
              <td>
                <?php
                        if (file_exists('assets/ruangan/notulen/NOTULEN_'.$id_kegiatan.'_'.$row->id_pegawai.'.pdf')) {
                          $isFile = True;
                          echo '<a href="'.base_url().'ruangan/unduh_notulen/'.$id_kegiatan.'/'.$row->id_pegawai.'">
                                  <img src="'.base_url().'assets/images/icon/notulensi.png" alt="Unduh Notulensi" title="Unduh Notulensi dari '.$this->m_ruangan->get_n_pegawai($row->id_pegawai).'" border="0">
                                </a><br>
                          &nbsp;';
                        } 
                ?>
              </td>
              <td><?php echo $row->ket; ?></td>
            <?php if($this->All || $data_ruangan[0]->user_id == $id_auth){ ?>
            <td>
                <a href="/jelita/backoffice/ruangan/hapus_eviden/<?php echo $row->id; ?>" onclick="return confirm('Cius mau ngehapus?');">
                    <img src="https://cdn3.iconfinder.com/data/icons/ui-super-basic-filled-line/32/delete-256.png" title="hapus penanggung jawab" border="0" width="25px">
                </a>
            </td>
            <?php } ?>
            </tr>
            <?php
            $i++;
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
  <br style="clear: both;" />
</div>