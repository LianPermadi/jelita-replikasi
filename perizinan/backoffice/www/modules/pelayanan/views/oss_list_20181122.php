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
            <th width="33%">Nama Pemohon / Perusahaan<br>Alamat Perusahaan</th>
            <th width="30%">Jenis Komitmen</th>
            <th width="20%">Lokasi / Objek</th>
            <th width="5%">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $i = 0;
          $results = mysql_query($list);
          while($rows = mysql_fetch_assoc(@$results)){
            $otherdb = $this->load->database('otherdb', TRUE); // the TRUE paramater tells CI that you'd like to return the database object.
            $sql1 = "select username from tm_pemohon where id='".$rows['id_pemohon']."'";                                   // ambil pemohon
            $sql2 = "select id_permohonan from asistensi where id_permohonan='".$rows['id_permohonan_portal']."'";          // ambil asistensi
            $sql3  = "select tm_pemohon.username from tm_pemohon,tmpermohonan_portal where tmpermohonan_portal.id='".       // Ambil permohonan di BO
            $rows['id_permohonan_portal']."' and tmpermohonan_portal.id_pemohon=tm_pemohon.id";
            $jml_asistensi = count($otherdb->query($sql2)->result()); //jumlah asisteni
            if($jml_asistensi == 0){     // jika tidak pernah di asistensi
              $b = '<span style="color: Red">'; $be = '</span>';
            }else{
              $b = ''; $be = '';
            }
            if($all_view){
              $tampil = TRUE;
            }else{
              if(count($otherdb->query($sql1)->result()) == 0){
                $tampil = FALSE;
              }else{
                $tampil = TRUE;
              }
            }
            
            if($tampil){
              $i++;
              $n_perusahaan = $rows['namaPerusahaan'];
            	if($n_perusahaan == '') $n_perusahaan = '-';
              ?>
              <tr>
                <td valign='top'><?php echo $i; ?></td>
                <td valign='top'><?php echo $b. $rows['referensi'].'<br>'.$this->lib_date->mysql_to_human($rows['tglPermohonan']) .$be; ?></td>
                <td valign='top'><?php echo $b. $rows['namaPemohon'].' / '.$n_perusahaan.'<br>'.$rows['almtPerusahaan'] .$be;?></td>
                <td valign='top'><?php echo $b. $rows['isi_izin'].$be; ?></td>
                <td valign='top'><?php echo $b. $rows['lokasi_izin'].$be; ?></td>
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
                  if(count($otherdb->query($sql3)->result()) != 0)
                    //echo anchor(site_url('pelayanan/komitmen_oss/edit') . '/' . $rows['id'], img($img_edit)) . "&nbsp;";
                  
                  if($aut_hapus)
                    //echo anchor(site_url('pelayanan/komitmen_oss/delete') . '/' . $rows['id'], img($img_delete)) . "&nbsp;";
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