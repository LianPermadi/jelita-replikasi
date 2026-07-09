<div id="content">
    <div class="post">
        <div class="title">
          <?php echo $this->lib_date->view_title($page_name); ?>
        </div>
        <?php
        $alert = $this->session->flashdata("sukses");
        if (!empty($alert)) {
            ?>
            <br>
            <div style="color: green; font-size: 12px; margin-left: 20px; margin-bottom: 10px; font-weight: bold;">
                <center>
                    <?php echo $alert; ?>
                </center>
            </div>
        <?php } ?>

        <?php
        $alert = $this->session->flashdata("gagal");
        if (!empty($alert)) {
            ?>
            <br>
            <div style="color: red; font-size: 12px; margin-left: 20px; margin-bottom: 10px; font-weight: bold;">
                <center>
                    <?php echo $alert; ?>
                </center>
            </div>
        <?php } ?>
        <div class="entry">
            <?php
            $ctk_list = array(
                'name' => 'button',
                'content' => 'Tambah Barang Baru',
                'value' => 'Tambah Barang Baru',
                'class' => 'button-wrc',
                'onclick' => 'parent.location=\'' . site_url('permintaanbarang/addbarang') . '\''
            );
            echo form_button($ctk_list);
            ?>
            <?php
            $ctk_list = array(
                'name' => 'button',
                'content' => 'List Persediaan',
                'value' => '',
                'class' => 'button-wrc',
                'onclick' => 'parent.location=\'' . site_url('permintaanbarang/barang') . '\''
            );
            echo form_button($ctk_list);
            ?>
            <?php
            $ctk_list = array(
                'name' => 'button',
                'content' => 'List Permintaan barang',
                'value' => 'List Permintaan barang',
                'style' => 'background:#B0C4DE; color:black;',
                'class' => 'button-wrc',
                'onclick' => 'parent.location=\'' . site_url('permintaanbarang/pengajuan') . '\''
            );
            echo form_button($ctk_list);
            ?>
            <?php
            $ctk_list = array(
                'name' => 'button',
                'content' => 'checkout Barang',
                'value' => 'checkout Barang',
                'class' => 'button-wrc',
                'onclick' => 'parent.location=\'' . site_url('permintaanbarang/checkout') . '\''
            );
            echo form_button($ctk_list);
            ?>  
      <?php
      $ctk_list = array('name' => 'button',
                        'content' => 'Barang Masuk',
                        'value' => 'Barang Masuk',
                        'class' => 'button-wrc',
                        'onclick' => 'parent.location=\''.site_url('permintaanbarang/activity').'\''
                       );
      echo form_button($ctk_list);  
      ?>  
            <?php
            $ctk_list = array(
                'name' => 'button',
                'content' => 'Barang Keluar',
                'value' => 'Barang Keluar',
                'class' => 'button-wrc',
                'onclick' => 'parent.location=\'' . site_url('permintaanbarang/') . '\''
            );
            echo form_button($ctk_list);
?>
            <div id="barang">
                <table cellpadding="0" cellspacing="0" border="0" class="display" id="pendataan">
                    <thead>
                        <tr>
                            <th width="1%">No</th>
                            <!-- <th width="20%">Nama Barang</th> -->
                            <th width="20%">Nama Permintaan</th>
                            <th width="20%">Status</th>
                            <th width="10%">Keterangan</th>
                            <th width="20%">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        foreach ($barang as $row) {
                            // $a = $this->m_barang->get_pegawai_user($row->id_user); 
                            // var_dump($a);die();
                            ?>
                            <tr>
                                <td>
                                    <?php echo $i; ?>
                                </td>
                                <!--               <td>
              <table>
                <tr>
                  <td><?php echo $this->m_barang->get_barang_user($row->id_user); ?></td>
                </tr>
              </table> 
            </td> -->
                                <td><a href="check/<?php echo $row->id_user; ?>">
                                        <?php
                                        $pegawai = $this->m_barang->get_pegawai_user_n_pegawai($row->id_user);
                                        echo $this->m_barang->get_data_user_n_pegawai($pegawai);
                                        ?></a></td>
                                <?php 
                                $check = $this->m_barang->get_check($row->id_user);
                                // foreach($check as $as){
                                    if(!empty($row->status)) { ?>
                                <td>
                                    <?php if ($row->status == '1') {
                                        echo '<b>Barang Sedang Di siapkan</b>';
                                    } elseif ($row->status == '2') {
                                        echo '<b style="color:#CC2311;">Menunggu Approve</b>';
                                    } elseif ($row->status == '3') {
                                        echo '<b style="color:#CC2311;">Sedang Di kirim</b>';
                                    } elseif ($row->status == '6') {
                                        echo '<b style="color:#CC2311;">Sedang Di kirim</b>';
                                    } elseif ($row->status == '5') {
                                        echo '<b style="color:#CC2311;">Menunggu Konfirmasi User</b>';
                                    } elseif ($row->status == '6') {
                                        echo '<b style="color:#CC2311;">Pengajuan Pengembalian User</b>';
                                    } else {
                                        echo '<b style="color:#009900;">Diterima</b>';
                                    } ?>
                                </td>
                                <td>
                                    <?php echo $row->keterangan; ?>
                                </td>
                                <td>
                                    <?php 
                                    $tgl_masuk = $this->lib_date->mysql_to_human(date("Y/m/d", strtotime($row->date)));
          	                        $jam_masuk = date("H:i:s a", strtotime($row->date));
          	                        if($row->tanggal_approve != ''){
          	                          $tgl_approve = $this->lib_date->mysql_to_human(date("Y/m/d", strtotime($row->tanggal_approve))).' , ';
          	                          $jam_approve = date("H:i:s a", strtotime($row->tanggal_approve));
          	                        }else{
          	                          $tgl_approve = '';
          	                          $jam_approve = '<b style="color:#CC2311;">-- Menunggu Proses --</b>';
          	                        }
          	                        if($row->tanggal_kirim != ''){
          	                          $tgl_kirim = $this->lib_date->mysql_to_human(date("Y/m/d", strtotime($row->tanggal_kirim))).' , ';
          	                          $jam_kirim = date("H:i:s a", strtotime($row->tanggal_kirim));
          	                        }else{
          	                          $tgl_kirim = '';
          	                          $jam_kirim = '<b style="color:#CC2311;">-- Menunggu Proses --</b>';
          	                        }
          	                        if($row->tanggal_terima != ''){
          	                          $tgl_terima = $this->lib_date->mysql_to_human(date("Y/m/d", strtotime($row->tanggal_terima))).' , ';
          	                          $jam_terima = date("H:i:s a", strtotime($row->tanggal_terima));
          	                        }else{
          	                          $tgl_terima = '';
          	                          $jam_terima = '<b style="color:#CC2311;">-- Menunggu Proses --</b>';
          	                        }
          	                        $masuk = $tgl_masuk.' , '.$jam_masuk;
          	                        $approve = $tgl_approve.$jam_approve;
                                    $kirim = $tgl_kirim.$jam_kirim;
                                    $terima = $tgl_terima.$jam_terima;
                                    //echo '<span style="color:#009900;">Tanggal Masuk </span>'.$masuk; 
                                    //echo '<br><span style="color:#009900;">Tanggal Approve </span>'.$approve;  
                                    //echo '<br><span style="color:#009900;">Tanggal kirim </span>'.$kirim;  
                                    //echo '<br><span style="color:#009900;">Tanggal terima </span>'.$terima;
                                    echo '<span style="color:#009900; display: inline-block; width: 105px;">Tanggal Masuk </span>'.$masuk;
                                    echo '<br><span style="color:#009900; display: inline-block; width: 105px;">Tanggal Approve </span>'.$approve;  
                                    echo '<br><span style="color:#009900; display: inline-block; width: 105px;">Tanggal Kirim </span>'.$kirim;  
                                    echo '<br><span style="color:#009900; display: inline-block; width: 105px;">Tanggal Terima </span>'.$terima;
                                    ?>
                                </td>
                            <?php }else{ ?>
                                <td><a href=""><button>Hapus</button></a></td> 
                            <?php 
                        // }
                            } ?>
                            </tr>
                            <?php $i++;
                        } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <br style="clear: both;" />
</div>