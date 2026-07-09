<div id="content">
    <div class="post" style="background-color: #fffaf0;">
        <div class="title">
          <?php echo $this->lib_date->view_title($page_name); ?>
        </div>
    <div class="entry">
      <fieldset id="half">
        <legend>Filter Data Berdasarkan Tanggal</legend>
        <?php echo form_open('permintaanbarang'); ?>

        <div id="statusRail">
          <div id="leftRail">
            <?php echo form_label('Tanggal Awal','d_tahun'); ?>
          </div>
          <div id="rightRail">
            <?php
            $periodeawal_input = array('name'  => 'tgla',
                                       'value' => $tgla,
                                       'class' => 'input-wrc',
                                       'readOnly'=>TRUE,
                                       'class' => 'monbulan');
            echo form_input($periodeawal_input);
            ?>
          </div>
        </div>
        
        <div id="statusRail">
          <div id="leftRail">
            <?php echo form_label('Tanggal Akhir','d_tahun'); ?>
          </div>
          <div id="rightRail">
            <?php
            $periodeakhir_input = array('name'  => 'tglb',
                                        'value' => $tglb,
                                        'class' => 'input-wrc',
                                        'readOnly'=>TRUE,
                                        'class' => 'monbulan');
            echo form_input($periodeakhir_input);
            echo ' ';

            $filter_data = array('name' => 'button',
                                 'class' => 'button-wrc',
                                 'content' => 'Filter',
                                 'value' => 'Filter');
            echo form_submit($filter_data);
            ?>
          </div>
        </div>
        <?php
        echo form_hidden('kd_filter', '2');
        echo form_close();
        ?>
      </fieldset>
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
            if ($langkah == '1') {
                $ctk_list = array(
                    'name' => 'button',
                    'content' => 'Daftar Barang',
                    'value' => 'Daftar Barang',
                    'class' => 'button-wrc',
                    'onclick' => 'parent.location=\'' . site_url('permintaanbarang/pengajuan_barang') . '\''
                );
                echo form_button($ctk_list);
                ?>
                <?php
                $ctk_list = array(
                    'name' => 'button',
                    'content' => 'Checkout Barang',
                    'value' => 'Checkout Barang',
                    'class' => 'button-wrc',
                    'onclick' => 'parent.location=\'' . site_url('permintaanbarang/checkout_barang') . '\''
                );
                echo form_button($ctk_list);
                ?>
                <?php
                $ctk_list = array(
                    'name' => 'button',
                    'content' => 'List Permintaan Barang',
                    'value' => 'List Permintaan Barang',
                    'class' => 'button-wrc',
                    'onclick' => 'parent.location=\'' . site_url('permintaanbarang/list_permintaan') . '\''
                );
                echo form_button($ctk_list);
                ?>            
                <?php
            $ctk_list = array(
                'name' => 'button',
                'content' => 'History Permintaan barang',
                'value' => 'History Permintaan barang',
                'class' => 'button-wrc',
                    'style' => 'background:#B0C4DE; color:black;',
                'onclick' => 'parent.location=\'' . site_url('permintaanbarang/log_permintaan') . '\''
            );
            echo form_button($ctk_list);
            }else{
                ?>
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
                'style' => 'background:#B0C4DE; color:black;',
                'class' => 'button-wrc',
                'onclick' => 'parent.location=\'' . site_url('permintaanbarang/') . '\''
            );
            echo form_button($ctk_list);
        }
            ?>
            <table cellpadding="0" cellspacing="0" border="0" class="display" id="pendataan">
                <thead>
                    <tr>
                        <th width="4%">No</th>
                        <th width="31%">Nama Barang</th>
                        <th width="10%">Pemberi Barang</th>
                        <th width="10%">Penerima Barang</th>
                        <th width="22%">Tanggal Pengambilan Barang</th>
                        <th width="23%">Keterangan</th>
                        <th width="5%">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    foreach ($barang as $row) {
                        // $stat_tolak = $this->m_persuratan->get_data_tolak($row->id);
                        // if($row->hapus == 1) {
                        //   $b = '<span style="color: Red">';
                        //   $be = '</span>';
                        // }else{
                        //   $b = '';
                        //   $be = '';
                        // }
                        ?>
                        <tr>
                            <td>
                                <?php echo $i; ?>
                            </td>
                            <td>
                                <?php echo $row->nama_barang; ?>
                            </td>
                            <td>
                                <center><?php

                                $pegawai = $this->m_barang->get_pegawai_user_n_pegawai($row->pemberi_barang);
                                if (!empty($pegawai)) {
                                    echo $this->m_barang->get_data_user_n_pegawai($pegawai);
                                } else {
                                    echo $this->m_barang->get_pemberi_barang($row->pemberi_barang);
                                }
                                ?></center>
                            </td>
                            <td>
                                <center><?php
                                $pegawai = $this->m_barang->get_pegawai_user_n_pegawai($row->penerima_barang);
                                // var_dump($pegawai);die();
                                if ($pegawai == NULL) {
                                    echo $this->m_barang->get_penerima_barang($row->penerima_barang);
                                } else {
                                    echo $this->m_barang->get_data_user_n_pegawai($pegawai);
                                }
                                ?></center>
                            </td>
                            <td>
                                <center><?php
                                	$tgl = $this->lib_date->mysql_to_human(date("Y/m/d", strtotime($row->date)));
          	                      $jam = date("H:i:s a", strtotime($row->date));
                                  //echo $tgl.' , '.$jam;
                                  echo $row->date; 
                                  ?>
                                </center>
                            </td>
                            <td><?php echo $row->keterangan; ?></td>
                            <td>
                                <?php
                                if($this->All){ ?>
                                <a href="permintaanbarang/reload_ba/<?php echo $row->id; ?>"><img src="https://cdn-icons-png.flaticon.com/512/126/126502.png" width="25px" title="Reload Berita Acara"></a>
                                <?php
                                } 
                                ?>
                                <a href="permintaanbarang/ba/<?php echo $row->id; ?>" target="_blank"><img src="https://dpmptsp.jabarprov.go.id/jelita/backoffice/assets/images/icon/printer_ola.png" width="25px" title="Berita Acara"></a>
                            </td>
                        </tr>
                        <?php $i++;
                    } ?>
                </tbody>
            </table>
        </div>
    </div>
    <br style="clear: both;" />
</div>