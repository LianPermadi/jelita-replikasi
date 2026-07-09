              <head>
              <style>
                /* Gaya umum */
                .modal {
                    display: none;
                    position: fixed;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 100%;
                    background-color: rgba(0, 0, 0, 0.7);
                }

                .modal-content {
                    background-color: #fff;
                    margin: 15% auto;
                    padding: 20px;
                    border-radius: 5px;
                    width: 60%;
                }

                .close {
                    float: right;
                    font-size: 20px;
                    font-weight: bold;
                    cursor: pointer;
                }
              </style>
              </head>
<div id="content">
  <div class="post">
    <div class="title">
      <?php echo $this->lib_date->view_title($page_name); ?>
    </div>
    
    <div class="entry">
      <fieldset id="half">
        <legend>Filter2 Data Berdasarkan Tanggal Permohonan</legend>
        <?php
        echo form_open('pelayanan/komitmen_oss/index');
        $esselon_id = array('0' => '-------- Seluruhnya --------',
                            '1' => 'Esselon 4',
                            '4' => 'Esselon 3',
                            '3' => 'Esselon 2',
                            '2' => "Selesai Jelita",
                            '9' => 'Selesai OSS RBA',
                            '10' => 'Belum Approve Ess.3 di OSSRBA');
        ?>
        <div id="statusRail">
          <div id="leftRail"> 
            <?php 
            echo form_label('Status Izin', 'label_permohonan');
            ?>
          </div>
          <div id="rightRail"> <?php
            echo form_dropdown('statusizin', $esselon_id, $statusizin, 'class = "input-select-wrc" id="selector"');
            ?>
          </div>
        </div>
        <div id="statusRail">
          <div id="leftRail">
            <?php echo form_label('Periode Awal','d_tahun'); ?>
          </div>
          <div id="rightRail">
            <?php
            $periodeawal_input = array('name'  => 'tgla',
                                       'value' => $tgla,
                                       'class' => 'input-wrc',
                                       'readOnly'=>TRUE,
                                       'class' => 'monbulan'
                                      );
            echo form_input($periodeawal_input);
            ?>
          </div>
        </div>
        
        <div id="statusRail">
          <div id="leftRail">
            <?php echo form_label('Periode Akhir','d_tahun'); ?>
          </div>
          <div id="rightRail">
            <?php
            $periodeakhir_input = array('name'  => 'tglb',
                                        'value' => $tglb,
                                        'class' => 'input-wrc',
                                        'readOnly'=>TRUE,
                                        'class' => 'monbulan'
                                       );
            echo form_input($periodeakhir_input);
            ?>
          </div>
        </div>
        
        <?php 
        $filter_data = array('name' => 'button',
                             'class' => 'button-wrc',
                             'content' => 'Cari Data',
                             'value' => 'Cari Data'
                            );
        ?>
        <div id="statusRail">
          <div id="rightRail">
            <?php
            echo form_submit($filter_data);
            echo form_close();
            ?>
          </div>
        </div>
      </fieldset>
    </div> 
    
    <?php 
    $alert = $this->session->flashdata("sukses");
    if(!empty($alert)){
      ?>
      <br>
      <div style="color: green; font-size: 12px; margin-left: 20px; margin-bottom: 10px; font-weight: bold;"><center><?php echo $alert; ?></center></div>
      <?php
    }
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
                        'content' => 'Tambah Data',
                        'value' => 'Tambah Data',
                        'class' => 'button-wrc',
                        'onclick' => 'parent.location=\''.site_url('pelayanan/komitmen_oss/add').'\''
                       );
      echo form_button($ctk_list);  
      
       $img_cetak_excel = array('src' => base_url().'assets/images/icon/excel.png',
                                     'alt' => 'Cetak Excel',
                                     'title' => 'Cetak Detail ke Excel'
                                    );
        echo "<br>Export Data OSS RBA (Excel) ";
        // var_dump($admin);die();
            echo anchor(site_url('pelayanan/komitmen_oss/cetak_excel').'/'.(!empty($tgla) && !empty($tglb) ? $tgla.'/'.$tglb : '0/0').'/'.$statusizin.'/'.$admin, img($img_cetak_excel));
           
      
      ?>
      <table cellpadding="0" cellspacing="0" border="0" class="display" id="pendataan">
        <thead>
          <tr>
            <th width="2%">No</th>
            <th width="15%"><b>PENGINPUT<b><br>Fiktif Positif<br>Status<br>Nomor Permohonan <br>Tanggal Permohonan</th>
            <th width="25%"><b>DATA USAHA: <b><br>NIB - Tanggal NIB<br>SEKTOR - KBLI - Turunan KBLI<br> Jenis Perusahaan - Nama Perusahaan/Perorangan<br> Modal Usaha <br>Alamat <br>Jenis Proyek</th>
            <th width="15%"><b>Nama Perizinan<br>Tipe Aplikasi</th>
            <th width="15%">Skala Usaha<br> Tingkat Risiko <br> Masa Berlaku Izin (Bulan)</th>
            <th width="14%">DATA OPTIONAL <br>No. - Tgl Dokumen <br> NPWP <br>Nomor Telepon <br>Alamat Lokasi Usaha<br>Kab/Kota Lokasi Usaha </th>
            <th width="14%">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php 
          $i = 1;
          foreach ($ossrba as $row) { 
            if($row->warning == 1) {
              $b = '<span style="color: Red">';
              $be = '</span>';
              $c = '<br>Revisi : '.$row->revisi;
            }else{
              $b = '';
              $be = '';
              $c = '<br>'.$row->revisi; 
            }
            
            ?>
            <tr>
              <td><?php echo $i; ?></td>
              <td><?php echo $b.$this->m_ossrba->get_n_user($row->id_user)."<br>".$this->m_ossrba->get_fiktifpositif($row->fiktif_positif)."<br>".$this->m_ossrba->get_status($row->status)."<br>".$row->nomorpermohonan."<br>".$this->lib_date->mysql_to_human($row->tanggalpermohonan); ?></td>
              <td><?php echo $b.$row->nib." - ".$this->lib_date->mysql_to_human($row->tgl_nib)."<br>".$this->m_ossrba->get_n_sektor($row->sektor)." - ".$row->kbli." - ".$row->turunan_kbli."<br>".$this->m_ossrba->get_jenisperusahaan($row->jenis_perusahaan)." - ".$row->nama_perusahaan."<br>Rp".number_format($row->modal_usaha,0,',','.')."<br>".$row->alamat."<br>".$row->jenis_proyek; ?></td>
              <td>
                <?php 
                if($row->tipe_aplikasi == '1'){
                  echo $b.$this->m_ossrba->get_namaperizinan($row->nama_perizinan)."<br><span  style='font-weight: bold; color : red;'>".$this->m_ossrba->get_n_tipeapp($row->tipe_aplikasi)."</span>"; 
                }elseif($row->tipe_aplikasi == '2'){
                  echo $b.$this->m_ossrba->get_namaperizinan($row->nama_perizinan)."<br><span  style='font-weight: bold; color : blue;'>".$this->m_ossrba->get_n_tipeapp($row->tipe_aplikasi)."</span>"; 
                }elseif($row->tipe_aplikasi == '3'){
                  echo $b.$this->m_ossrba->get_namaperizinan($row->nama_perizinan)."<br><span style='color : #008B8B;'>".$this->m_ossrba->get_n_tipeapp($row->tipe_aplikasi)."</span>"; 
                }else{
                  echo $b.$this->m_ossrba->get_namaperizinan($row->nama_perizinan)."<br>".$this->m_ossrba->get_n_tipeapp($row->tipe_aplikasi); 
                }
                ?>
              </td>
              <td><?php echo $b.$row->skala_usaha."<br>".$this->m_ossrba->get_risiko($row->risiko)."<br>".$row->masaberlakuizin; ?></td>
              <td><?php echo $b.$row->no_dokumen." - ".$this->lib_date->mysql_to_human($row->tgl_dokumen)."<br>".$row->npwp."<br>".$row->no_telp."<br>".$row->alamat_usaha."<br>".$this->m_ossrba->get_n_kabupaten($row->kab_usaha).$be;   ?></td>
              <td> 
                <?php 
            if($row->esselon == 5) {
                // if($iduser == 680){
                  ?>
            <?php
            $id_mobil = $row->id;
            // echo $id_mobil.' = '.$idpegawai;
                  
                    $confirm_text = $this->session->userdata('username').', Apakah Anda yakin mengirim ke Struktural? '.'?';
                    $img_sent = array('src' => 'assets/images/icon/tick.png',
                                      'alt' => 'Kirim ke Struktural',
                                      'title' => 'Kirim ke Struktural',
                                      'border' => '0',
                                      'onClick' => 'return confirm_link(\''.$confirm_text.'\')'
                                    );
                    echo anchor(site_url('pelayanan/komitmen_oss/keterangan_ky')."/".$row->id, img($img_sent))."&nbsp;";
            ?>            
    <?php
                // }
                }
                if($row->esselon == 1){
                  echo '<img src="'.base_url().'assets/images/icon/esl4mrh.png" alt="Esselon 4" title="Esselon 4" border="0"></a>
                  &nbsp;';
                }
                if($row->esselon == 4){
                  echo '<img src="'.base_url().'assets/images/icon/esl3mrh.png" alt="Esselon 3" title="Esselon 3" border="0"></a>
                  &nbsp;';
                }               
                if($row->esselon == 3){
                  echo '<img src="'.base_url().'assets/images/icon/kepalamrh.png" alt="Kepala Dinas" title="Kepala Dinas" border="0"></a>
                  &nbsp;';
                }
                if($row->esselon == 2){              
                  echo '<img src="'.base_url().'assets/images/icon/Selesaiossrba.png" alt="Selesai" title="Selesai" border="0"></a>
                  &nbsp;';
                }
                if($row->esselon == 9){
                  echo '<img src="'.base_url().'assets/images/icon/Selesaiossrba.png" alt="Selesai" title="Selesai" border="0"></a>
                  &nbsp;';
                }
                if($row->esselon == 0){
                  echo '<a href="'.site_url('pelayanan/komitmen_oss/keterangan_ky')."/".$row->id.'"><img src="'.base_url().'assets/images/icon/chk.png" alt="Kirim ke Struktural" title="Kirim ke Struktural" border="0"></a>
                  &nbsp;';
                }
                if($row->esselon == 2 && $this->All){
                  $img_up2 = array('src' => 'assets/images/icon/warningPemohon.png',
                                   'alt' => 'Kirim Warning / Revisi',
                                   'title' => 'Kirim Warning / Revisi',
                                   'border' => '0');
                  echo anchor(site_url('pelayanan/komitmen_oss/showform')."/".$row->id, img($img_up2),'rel="upload_box"')."&nbsp;";
                }
                
                echo '<a href="'.base_url().'pelayanan/komitmen_oss/ubah/'.$row->id.'"><img src="'.
                      base_url().'assets/images/icon/property.png" alt="Edit Data" title="Edit Data" border="0"></a>
                      &nbsp;';
                if($row->esselon != 9 or $this->All){
                  $confirm_text = $this->session->userdata('username').', Apakah Anda yakin menghapus data '.'?';
                  $img_delete = array('src' => 'assets/images/icon/cross.png',
                                       'alt' => 'Hapus Data',
                                       'title' => 'Hapus Data',
                                       'border' => '0',
                                       'onClick' => 'return confirm_link(\''.$confirm_text.'\')'
                                      );
                  echo anchor(site_url('pelayanan/komitmen_oss/hapus')."/".$row->id, img($img_delete))."&nbsp;";
                }
                if($row->warning == 1){
                  $confirm_text = $this->session->userdata('username').', Apakah Anda yakin sudah Menyelesaikan Revisi '.'?';
                  $img_delete = array('src' => 'assets/images/icon/refresh.png',
                                      'alt' => 'Sudah Revisi',
                                      'title' => 'Sudah Revisi',
                                      'border' => '0',
                                      'onClick' => 'return confirm_link(\''.$confirm_text.'\')'
                                     );
                  echo anchor(site_url('pelayanan/komitmen_oss/approveoss')."/".$row->id, img($img_delete))."&nbsp;";
                }
                if($this->All){
                   echo "<br>id = ".$row->id." (Admin Only)";
                }
                if(file_exists('assets/ossrba/naskah/NASKAH_'.$row->id.'.pdf')) {
                  if($this->All){
                  echo "<br><a href='".base_url()."pelayanan/komitmen_oss/unduh_naskah/".$row->id."' style='color:blue;' target='_blank' title='Unduh Naskah'>NASKAH SIAP</a>&nbsp;"; 
                  }else{
                    echo "<br><a href='".base_url()."pelayanan/komitmen_oss/unduh_naskah/".$row->id."' style='color:blue;' target='_blank' title='Unduh Naskah'>NASKAH SIAP</a>&nbsp;"; 
                  }
                }
                echo $b.$c;
                ?>
                <br>                    
                <?php 
                $confirm_text = $this->session->userdata('username').', Apakah Anda yakin mengirim ke Struktural? '.'?';
                    $img_sent = array('src' => 'assets/images/icon/tick.png',
                                      'alt' => 'Kirim ke Struktural',
                                      'title' => 'Kirim ke Struktural',
                                      'border' => '0',
                                      'onClick' => 'return confirm_link(\''.$confirm_text.'\')'
                                    );
                    // echo anchor(site_url('pelayanan/komitmen_oss/kirim')."/".$row->id, img($img_sent))."&nbsp;";
                    echo anchor(site_url('pelayanan/komitmen_oss/keterangan_ky')."/".$row->id, img($img_sent))."&nbsp;";
                    ?>
              </td>
            </tr>
<?php
    $i++;
}
?>

        </tbody>
      </table>

      
            <?php
                // if($iduser == 680){
                  // echo $row->id.'<br>';
                  // echo $i.'<br>';
            ?>            
            <!-- ... (kode HTML sebelumnya) -->
            <!-- <button id="showModalBtn<?php echo $i; ?>" class="button-wrc">Keterangan</button>
            
            <form action="pelayanan/komitmen_oss" method="post">
              <div id="myModal<?php echo $i; ?>" class="modal">
                <div class="modal-content">
                  <span class="close<?php echo $i; ?>">&times;</span>
                  <center>
                    Keterangan
                    <input type="hidden" value="<?php echo $this->session->userdata('id_auth'); ?>" name="id_user">
                    <textarea name="keterangan_ky"></textarea>
                    <br>
                    <input type="submit" name="submit" autofocus required value="Proses" class="btn">
                  </center>
                </div>
              </div>
            </form>

            <script>
              document.addEventListener("DOMContentLoaded", function () {
                var showModalBtn = document.getElementById("showModalBtn<?php echo $i; ?>");
                var modal = document.getElementById("myModal<?php echo $i; ?>");
                var closeBtn = document.querySelector(".close<?php echo $i; ?>");

                showModalBtn.addEventListener("click", function () {
                  modal.style.display = "block";
                });

                closeBtn.addEventListener("click", function () {
                  modal.style.display = "none";
                });

                window.addEventListener("click", function (event) {
                  if (event.target == modal) {
                    modal.style.display = "none";
                  }
                });
              });
            </script> -->
    <?php
                // } else {
                    // $confirm_text = $this->session->userdata('username').', Apakah Anda yakin mengirim ke Struktural? '.'?';
                    // $img_sent = array('src' => 'assets/images/icon/tick.png',
                    //                   'alt' => 'Kirim ke Struktural',
                    //                   'title' => 'Kirim ke Struktural',
                    //                   'border' => '0',
                    //                   'onClick' => 'return confirm_link(\''.$confirm_text.'\')'
                    //                 );
                    // echo anchor(site_url('pelayanan/komitmen_oss/kirim')."/".$row->id, img($img_sent))."&nbsp;";
                // }
                ?>
    </div>
  </div>
  <br style="clear: both;" />
</div>
<!-- Your PHP loop to generate modals -->
