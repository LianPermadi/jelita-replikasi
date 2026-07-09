<script>
  function warning(){
    alert('Data telah lebih dari 10 hari');
  }
</script>

<div id="content">
  <div class="post">
    <div class="title">
      <?php echo $this->lib_date->view_title($page_name); ?>
    </div>
    <?php
    echo "<font color='red'><b>" . $this->session->flashdata('warning') . "</b></font>";
    if($ket_syarat) {
      //echo "<div class='entry' align=center><b style='color: #FF0000;'>Persyaratan tidak lengkap !!</b></div>";
    }
    ?>
    <div class="entry">
      <?php 
      $settings = new settings();
      $app_web_service = $settings->where('name', 'web_service_penduduk')->get();
      $url = $app_web_service->value;
      //echo '<span style="color: Red">Merah: Belum Asistensi</span> &nbsp&nbsp&nbsp Hitam: Sudah Asistensi';
      ?>
      <table cellpadding="0" cellspacing="0" border="0" class="display" id="pendaftaran">
        <thead>
          <tr>
            <th width="2%">No</th>
            <th width="10%">NIB<br>Tanggal Daftar</th>
            <th width="33%">Kode Izin</th>
            <th width="30%">Nama Pemohon / Perusahaan<br>Alamat Perusahaan</th>
            <th width="20%">Lokasi / Objek</th>
            <th width="5%">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $i = 0;
          $jml_asistensi = 1;
          $results = mysql_query($list);
          while($rows = mysql_fetch_assoc(@$results)){
            if($jml_asistensi == 0){
              $b = '<span style="color: Red">'; $be = '</span>';
            }else{
              $b = ''; $be = '';
            }
            
              $i++;
              ?>
              <tr>
                <td valign='top'><?php echo $i; ?></td>
                <td valign='top'><?php echo $b. $rows['nib'].'<br>'.(!empty($rows['tgl_terbit_nib']) ? $this->lib_date->mysql_to_human($rows['tgl_terbit_nib']) : ' - ') .$be; ?></td>
                <td valign='top'><?php echo $b. $rows['kd_izin'].$be; ?></td>
                <td valign='top'><?php echo $b. $rows['nama_user_proses'].' / '.$rows['nama_perseroan'].'<br>'.(!empty($rows['alamat_perseroan']) ? $rows['alamat_perseroan'] : ' - ') .$be;?></td>
                <td valign='top'><?php echo $b. $rows['kelurahan_perseroan'].' RT/RW '. $rows['rt_rw_perseroan'] .$be; ?></td>
                <td valign='top'>
                  <?php
                  if($user_lokasi != 'OPD Teknis') $txt='Edit'; else $txt='Lihat';
                  $img_edit = array('src' => base_url() . 'assets/images/icon/property.png',
                                    'alt' => $txt,
                                    'title' => $txt,
                                    'border' => '0',
                                   );
                                             
                  $confirm_text = 'Apakah Anda yakin akan menghapusnya?';
                  $img_delete = array('src' => base_url() . 'assets/images/icon/cross.png',
                                      'alt' => 'Delete',
                                      'title' => 'Delete',
                                      'border' => '0',
                                      'onClick' => 'return confirm_link(\'' . $confirm_text . '\')',
                                     );
                    //echo anchor(site_url('pelayanan/komitmen_oss/edit') . '/' . $rows['id'], img($img_edit)) . "&nbsp;";
                  
                  if($aut_hapus)
                    //echo anchor(site_url('pelayanan/komitmen_oss/delete') . '/' . $rows['id'], img($img_delete)) . "&nbsp;";
                  ?>
                </td>
              </tr>
              <?php
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
  <br style="clear: both;" />
</div>