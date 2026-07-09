<div id="content">
  <div class="post">
    <div class="title">
      <h2><?php echo $page_name; ?></h2>
    </div>
    <div class="entry">
      <fieldset id="half">
        <legend>Filter Data</legend>
        <?php
        echo form_open('permohonan/revisisk');
        ?>
        <div id="statusRail">
          <div id="leftRail">
            <?php
            echo form_label('Tgl Permohonan Awal','d_tahun');
            ?>
          </div>
          <div id="rightRail">
            <?php
            $periodeawal_input = array('name'  => 'tgla',
                                       'value' => $tgla,
                                       'class' => 'input-wrc',
                                       'class' => 'monbulan'
                                      );
            echo form_input($periodeawal_input);
            ?>
          </div>
        </div>
        <div id="statusRail">
          <div id="leftRail">
            <?php
            echo form_label('Tgl Permohonan Akhir','d_tahun');
            ?>
          </div>
          <div id="rightRail">
            <?php
            $periodeakhir_input = array('name'  => 'tglb',
                                        'value' => $tglb,
                                        'class' => 'input-wrc',
                                        'class' => 'monbulan'
                                       );
            echo form_input($periodeakhir_input);
            ?>
          </div>
        </div>
        <div id="statusRail">
          <div id="leftRail"></div>
          <div id="rightRail">
            <?php
            $filter_data = array('name' => 'button',
                                 'class' => 'button-wrc',
                                 'content' => 'Filter',
                                 'value' => 'Filter'
                                );
            $ctk_list = array('name' => 'button',
                              'content' => 'Cetak Nota Pengantar',
                              'value' => 'Cetak Nota Pengantar',
                              'class' => 'button-wrc',
                              'onclick' => 'parent.location=\''.site_url('permohonan/sk/cetak_nota/'.$tgla.'/'.$tglb).'\''
                             );
            echo form_submit($filter_data);
            echo form_button($ctk_list);
            ?>
          </div>
        </div>
        <?php
        echo form_close();
        ?>
      </fieldset>
    </div>
    <div class="entry">
      <table cellpadding="0" cellspacing="0" border="0" class="display" id="sk">
        <thead>
          <tr>
            <th width="2%">No</th>
            <th width="9%">No Pendaftaran<br>Tanggal Permohonan<br>Asal Permohonan</th>
            <th width="15%">Pemohon</th>
            <th width="40%">Jenis Izin</th>
            <th width="20%">Tanggal Penetapan<br>No Surat Keputusan<br>Tanggal Surat Keputusan</th>
            <th width="8%">Status</th>
			      <th width="6%">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $i = 1;
          $results = mysql_query($list);
          while ($rows = mysql_fetch_assoc(@$results)){
            $no_surat = (!empty($rows['no_surat_edit']) ? $rows['no_surat_edit'] : $rows['no_surat']);
            $tgl_surat = (!empty($rows['tgl_surat_edit']) ? $rows['tgl_surat_edit'] : $rows['tgl_surat']);
            $c_cetak = $rows['c_cetak'];
            if($c_cetak == "0") {
              $b = '<span style="color: Red">';
              $be = '</span>';
            } else {
              $b = '';
              $be = '';
            }
          ?>
            <tr>
              <td valign='top'><?php echo $i; ?></td>
              <td valign='top'>
              	<?php 
                echo $b.$rows['pendaftaran_id'].$be."<br>";
                if($rows['idjenis'] == '1') $b.$tgl_permohonan = $rows['d_terima_berkas']; 
                else if($rows['idjenis'] == '2') $tgl_permohonan = $rows['d_perubahan'];
                  else if($rows['idjenis'] == '3') $tgl_permohonan = $rows['d_perpanjangan'];
                    else if($rows['idjenis'] == '4') $tgl_permohonan = $rows['d_daftarulang'];
                if($tgl_permohonan){
                  if($tgl_permohonan != '0000-00-00') echo $b.$this->lib_date->mysql_to_human($tgl_permohonan).$be."<br>";
                }
                echo $b.$rows['kd_gerai'].$be;
                ?>
              </td>
              <td valign='top'><?php echo $b.$rows['n_pemohon'].$be; ?></td>
              <td valign='top'><?php echo $b.$rows['n_perizinan'].$be;?></td>
              <td valign='top'>
              	<?php 
                echo $b.$this->lib_date->mysql_to_human($rows['tgl_penetapan']).$be."<br>";
								echo $b.$no_surat.$be."<br>";
								if($tgl_surat){
                  if($tgl_surat != '0000-00-00') 
								    echo $b.$this->lib_date->mysql_to_human($tgl_surat).$be;
								  else
								    echo $b.'-'.$be;
                }else{
								  echo $b.'-'.$be;
                }
           			?>
              </td>
              <td valign='top'>
              	<?php
                if($rows['e_ttd'] == 0) echo $b."ttd Basah".'<br>'.$be;
                if($rows['e_ttd'] == 1) echo $b."e-sign Templete".'<br>'.$be;
                if($rows['e_ttd'] == 2) echo $b."e-sign Upload".'<br>'.$be;
                if($c_cetak == '0'){
                  if($rows['c_status_bayar'] === '1' && $rows['trkelompok_perizinan_id'] === '4' || $rows['trkelompok_perizinan_id'] != '4'  )
								    echo $b."Belum di-cetak".$be;
								  else
								   echo $b."Belum Bayar Retribusi".$be;
                } else {
                  echo $b."<b>Dicetak ".$c_cetak." kali</b>".$be;
                }
                ?>
              </td>
              <td valign='top'>
                <?php

                $img_lihat = array('src' => base_url().'assets/images/icon/information.png',
                                     'alt' => 'Lihat Detail',
                                     'title' => 'Lihat Detail',
                                     'border' => '0');
                  echo anchor(site_url('arsip/edit') .'/L/'.$rows['id'].'/10', img($img_lihat))."&nbsp;";

                  $img_edit = array('src' => 'assets/images/icon/property.png',
                                  'alt' => 'Edit',
                                  'title' => 'Edit',
                                  'border' => '0',
                                 );


                //echo anchor(site_url('permohonan/revisiUpdate') .'/'.$rows['id'].'/4', img($img_edit))."&nbsp;";
                ?>
              </td>
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

<script>
  $(document).ready(function(){
    window.open(url, "_blank"); // will open new tab on document ready
    location.reload();
  });
  
  function notif(){
    alert("izin ini belum memiliki template Kabad !");
  }
  
  function notif2(){
      alert("izin ini belum memiliki template Gubernur !");
  }
</script>