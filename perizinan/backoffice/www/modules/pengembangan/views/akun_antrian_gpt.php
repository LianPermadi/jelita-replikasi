<div id="content">
    <div class="post">
        <div class="title">
            <?php echo $this->lib_date->view_title($page_name); 
            $loket = $this->m_nib->get_user_loket($id_user); ?>
        </div>
    <div class="entry">
      <fieldset>
        <legend>Alert</legend>
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
      </fieldset>
    </div>
    <div class="entry">
      <table cellpadding="0" cellspacing="0" border="0" class="display" id="pendataan">
        <thead>
          <tr>
            <th width="2%">No</th>
            <th width="13%">Event Akun</th>
            <th width="10%">Lokasi</th>
            <th width="20%">Username</th>
            <th width="35%">Password</th>
            <th width="5%">Level</th>
            <th width="10%">session token</th>
            <th width="5%">Action</th>
          </tr>
        </thead>
        <tbody>
          <?php 
          $i = 1;
          $belum = 1;
          foreach($akun_antrian as $row){
            if($row->session_token != '') {
              $b = '<span style="color: red">';
              $be = '</span>';
              $belum++; 
              //$c = '<br>Revisi : '.$row->revisi;
            }else{
              $b = '<span>';
              $be = '</span>';
              // $c = '<br>'.$row->revisi; 
            }
            ?>
            <tr>
              <td><?php echo  $i; ?></td>
              <td>
                <?php // echo $b.$row->nib; ?><br>
                <?php echo $b.$row->n_event; ?><br>
              </td>
              <td>
                <?php echo $b.$row->lokasi; ?><br>
              </td>
              <td>
                <?php echo $b.$row->username; ?><br>
              </td>
              <td>
                <?php echo $b . str_repeat('*', strlen($row->password)); ?><br>
              </td>
              <td>
                <center>
                  <label for=""><b><?php 
                  $layanan_gpt = $this->m_nib->layanan_gpt($row->level);
                  if(!empty($layanan_gpt)){
                  echo $b.$layanan_gpt->instansi_lembaga;
                  }else{
                    echo 'Admin';
                  }
                  ?></b></label><br><br>
                </center>
              </td>
              <td>
                <?php 
                if($row->session_token != ''){
                    $session_token = 'Masih Login';
                    ?>
                    <a href="refresh_akun/<?php echo $row->id ?>"><button class="button-wrc">Refresh Akun</button></a>
                    <?php 
                }else{
                    $session_token = 'Tidak Login';
                }
                echo $b.$session_token; 
                ?><br>
              </td>
              <td>
                <a href="/jelita/backoffice/pengembangan/gpt/edit_akun_gpt/<?php echo $row->id; ?>"><img src="https://cdn-icons-png.flaticon.com/512/266/266146.png" alt="" width="20px"></a>
                <?php
                if($this->All){ 
                  $confirm_text = $this->session->userdata('username').', Apakah Anda yakin Menghapus Data? '.'?';
                  $img_sent = array('src' => 'https://cdn-icons-png.flaticon.com/512/860/860778.png',
                                    'width' => '20px', 
                                    'alt' => 'Hapus Data',
                                    'title' => 'Hapus Data',
                                    'border' => '0', 
                                    'onClick' => 'return confirm_link(\''.$confirm_text.'\')'
                                  );
                  echo anchor(site_url('pengembangan/gpt/hapus_akun_gpt')."/".$row->id, img($img_sent))."&nbsp;";
                  ?>
                  <!--<a href="/jelita/backoffice/pengembangan/nib/hapus_nib/<?php echo $row->id; ?>"><img src="https://cdn-icons-png.flaticon.com/512/860/860778.png" alt="" width="20px"></a>-->
                  <?php
                }
                ?>
              </td>
            </tr>
            <?php 
            $i++;
          }
          $jum=$i-1;
          $belum = $belum-1;
          echo '<div style="text-align:right">';
          if($belum == 0){
            echo '<span style="color: Blue"><b>'.'Jumlah Pemohon : '.$jum.',</b></span>&nbsp;&nbsp;';
            echo '<span style="color: Blue"><b>'.' Belum Dilayani : 0</b></span>&nbsp;&nbsp;';
          }else{
        	  echo '<span style="color: Blue"><b>'.'Jumlah Pemohon : '.$jum.',</b></span>&nbsp;&nbsp;';
        	  echo '<span style="color:  Red"><b>'.' Belum Dilayani : '.$belum.'</b></span>&nbsp;&nbsp;';
          }
          echo '</div>';
          ?>
        </tbody>
      </table>
    </div>
    </div>
    <br style="clear: both;" />
</div>