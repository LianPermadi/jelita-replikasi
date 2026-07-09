<div id="content">
  <div class="post"> 
    <div class="title">
      <h2><?php echo $page_name; ?></h2>
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
      <?php
      $ctk_list = array('name' => 'button',
                        'content' => 'Booking barang',
                        'value' => 'Booking barang',
                        'class' => 'button-wrc',
                        'onclick' => 'window.open(\''.site_url('permintaanbarang/add').'\')'
                       );
      echo form_button($ctk_list);  
      ?>
      <table cellpadding="0" cellspacing="0" border="0" class="display" id="pendataan">
        <thead>
          <tr>
            <th width="2%">No</th>
            <th width="20%">Label<br>Laptop</th>
            <th width="20%">Jenis<br>Laptop</th>
            <th width="14%">Status</th>
            <th width="15%">Nama<br>Peminjam</th>
            <th width="5%">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php 
          $iduser = $this->session->userdata('id_auth');
          $i = 1;
          
          //$now = $this->lib_date->get_date_now();
          $hari_ini = date('Y-m-d');//$this->lib_date->set_date($now, -1); //date('Y-m-d');
          foreach ($permintaan as $row) { 
            // $tgl = $row->tgl_req.' '.$row->req_acc;
            // $tanggal = $row->tgl_req;
            // $waktu_akhir = $row->req_acc;
            // $waktu_sekarang = date("G:i:s");
            ?>
            <tr>
              <td><?php echo $i; ?></td>
              <td><?php echo $row->label_laptop; ?></td>
              <td><?php echo $row->jenis_laptop; ?></td>
              <td><?php 
              if($row->status == 0){
                echo '<p>Laptop tersedia</p>';
              }else{
                echo '<p style="text: red">Laptop tidak tersedia</p>';
              }
              ?></td>
              <td><?php 
              if(!empty($row->user)){
                echo $this->m_permintaan->$row->user_peminjam;              
              }else{
                echo "-";
              }
               ?></td>
              <td><a href="pinjam/<?php echo $row->id ?>" target="_blank"><button class='button-wrc'>Pinjam</button></a></td>
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