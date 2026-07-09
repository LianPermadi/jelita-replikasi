<div id="content">
  <div class="post">
    <div class="title">
      <?php echo $this->lib_date->view_title($page_name); ?>
    </div>

    <!-- <div class="entry">
      <fieldset>
        <legend>Filter Data Tanggal Surat Awal</legend>
        <?php
        echo form_open('persuratan');
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
            <td> <?php echo 'Tanggal Surat Awal : ' . form_input($periodeawal_input); ?> </td>
            <td> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td> <?php echo 'Tanggal Surat Akhir : '. form_input($periodeakhir_input); ?> </td>
            <td> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td> <?php echo form_submit($filter_data);?> </td>
          </tr>
        </table>
        <?php
        echo form_hidden('kd_filter', '2');
        echo form_close();
        ?>
      </fieldset>
    </div> -->
    
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
      <?php
      $ctk_list = array('name' => 'button',
                        'content' => 'Tambah Data',
                        'value' => 'Tambah Data',
                        'class' => 'button-wrc',
                        'onclick' => 'parent.location=\''.site_url('jdih/add').'\''
                       );
      echo form_button($ctk_list);  
      ?>
      <table cellpadding="0" cellspacing="0" border="0" class="display" id="pendataan">
        <thead>
          <tr>
            <th  width="2%">No</th>
            <th width="20%">Hukum <br> Status  <br> Institusi</th>
            <th width="20%">Tentang </th>
            <th  width="40%">Status </th>
            <th  width="18%">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php 
          $i = 1;
          foreach ($jdih as $row) { 
         
            ?>
            <tr>
              <td ><?php echo $i; ?></td>
              <td ><?php echo $this->m_jdih->get_kategori($row->kategori)." Nomor ".$row->nomor." Tahun ".$row->tahun."<br> ".$this->m_jdih->get_status($row->status)."<br>".$this->m_jdih->get_institusi($row->institusi); ?></td>
              <td style="font-size:10px"> <?php echo $row->tentang; ?></td>
              <td style="font-size:10px">
               <?php echo "MENCABUT : <br>".$row->mencabut."<br>MENGUBAH : <br>".$row->mengubah."<br>DICABUT : <br>".$row->dicabut."<br>DIUBAH : <br>".$row->dirubah; ?>
              </td>
              <td >
                <?php 
               
                 if (file_exists('assets/jdih/hukum/HUKUM_'.$row->id.'.pdf')) {
                 echo '<a href="'.base_url().'jdih/unduh_pdf/'.$row->id.'"><img src="'.base_url().'assets/images/icon/print1.png" alt="Unduh Hukum" title="Unduh Hukum" border="0"></a>
                &nbsp;';
              }
              if (file_exists('assets/jdih/abstrak/ABSTRAK_'.$row->id.'.pdf')) {
                 echo '<a href="'.base_url().'jdih/unduh_abstrak/'.$row->id.'"><img src="'.base_url().'assets/images/icon/print1.png" alt="Unduh Abstrak" title="Unduh Abstrak" border="0"></a>
                &nbsp;';
              }

             

                echo '<a href="'.base_url().'jdih/ubah/'.$row->id.'"><img src="'.
                            base_url().'assets/images/icon/property.png" alt="Edit Hukum" title="Edit Hukum" border="0"></a>
                            &nbsp;';
                // echo '<a href="'.base_url().'pajak/hapus/'.$row->id.'"><img src="'.base_url().'assets/images/icon/cross.png" alt="Hapus Pajak Permanen" title="Hapus Pajak Permanen" border="0"></a>'; 
               $confirm_text = $this->session->userdata('username').', Apakah Anda yakin menghapus data '.'?';
                   $img_delete = array('src' => 'assets/images/icon/cross.png',
                                        'alt' => 'Ajukan Penghapusan',
                                        'title' => 'Ajukan Penghapusan',
                                        'border' => '0',
                                        'onClick' => 'return confirm_link(\''.$confirm_text.'\')'
                                       );
                    echo anchor(site_url('jdih/hapus')."/".$row->id, img($img_delete))."&nbsp; <br>";


              /*Start List Lampiran*/
              $directory = 'assets/jdih/lampiran/'.$row->id."/";
              $filecount = 0;
              $files = glob($directory . "*.pdf");
              foreach ($files as $value) {
                echo "<br><a href='".base_url().$value."' style='color:blue;' target='_blank' title='Unduh Berkas'>"."<img src='".base_url()."assets/images/icon/print1.png' alt='$value' title='$value' border='0'>"."</a>&nbsp;"; 
              }
              /*End List Lampiran*/

                // $confirm_text = $this->session->userdata('username').', Apakah Anda hendak upload file lampiran? '.'?';
                //    $img_upload = array('src' => 'assets/images/icon/plus.png',
                //                         'alt' => 'Upload Lampiran',
                //                         'title' => 'Upload Lampiran',
                //                         'border' => '0',
                //                         'onClick' => 'return confirm_link(\''.$confirm_text.'\')'
                //                        );
                //     echo anchor(site_url('jdih/uploadlampiran')."/".$row->id, img($img_upload))." Upload Lampiran&nbsp; ";
                
                ?>
                <br>
                <?php 
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