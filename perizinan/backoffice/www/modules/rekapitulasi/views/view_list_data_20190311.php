<div id="content">
  <div class="post">
    <div class="title">
      <h2><?php echo $page_name; ?></h2>
    </div>
    <!--<script type="text/javascript">
      $(document).ready(function() {
        $('#info_list').dataTable ( {
          'bServerSide'    : true,
          'bAutoWidth'     : false,
          'sPaginationType': 'full_numbers',
          'sAjaxSource'    : '<?php echo base_url(); ?>rekapitulasi/izin/datatables_viewdata',
          'aoColumns'      : [ {'bSearchable':false, 'bVisible':true, 'bSortable':false},
                               null,
                               null,
                               null,
                               null,
                               null,
                               null,
                               {'bSearchable':false, 'bVisible':true, 'bSortable':false}
                             ],
          'fnServerData'   : function(sSource, aoData, fnCallback) {
            $.ajax ({
              'dataType': 'json',
              'type'    : 'POST',
              'url'     : sSource,
              'data'    : aoData,
              'success' : fnCallback
            });
          }
        });
      });
    </script>-->
    <div class="entry">
      <?php 
      if($gerai=='0') $n_gerai = 'SELURUHNYA'; else $n_gerai = $gerai; 
  	  ?>
      <h2 align="center">
        <?php 
        echo 'DATA PERMOHONAN SEKTOR ' . $bidang;
        if($izin != '')
        echo '<br>'.'JENIS ' . $izin;
        
        echo '<br>'.$n_menu . ', '.strtoupper($katagori).', PERIODE : '. $this->lib_date->mysql_to_human($tgla)." - ".$this->lib_date->mysql_to_human($tglb);
        echo '<br>'.'ASAL PERMOHONAN : '. $n_gerai;
        ?>
      </h2>
      <table align=left>
        <tr>
          <td align="center">
            <?php
            $Back_data = array('src' => base_url().'assets/images/icon/back_alt.png',
                               'alt' => 'Lihat di HTML to Openoffice',
                               'title' => 'Kembali'
                              );
            echo anchor(site_url('rekapitulasi/izin/rekap_next'), img($Back_data));
                             
            $img_cetak_pdf = array('src' => base_url().'assets/images/icon/pdf.png',
                                   'alt' => 'Cetak PDF',
                                   'title' => 'Cetak Detail ke PDF'
                                  );
            echo anchor(site_url('rekapitulasi/izin/cetak_list') .'/'. $id_key.'/'.$menu, img($img_cetak_pdf));
            
            $img_cetak_excel = array('src' => base_url().'assets/images/icon/excel.png',
                                     'alt' => 'Cetak Excel',
                                     'title' => 'Cetak Detail ke Excel'
                                    );
            echo anchor(site_url('rekapitulasi/izin/cetak_list_excel') .'/'. $id_key.'/'.$menu, img($img_cetak_excel));
            ?>
          </td>
        </tr>
      </table>
      
      <table cellpadding="0" cellspacing="0" border="0" class="display" id="listdataizin">
        <thead>
          <tr>
            <th width="3%">No</th>
            <th width="20%">No Pendaftaran<br>Nama Pemohon<br>Nama Perusahaan</th>
            <th width="9%">Asal Pendaftaran<br>Tanggal Daftar<br>Target Selesai</th>
            <th width="22%">Jenis Izin</th>
            <th width="21%">Objek Izin</th>
            <th width="9%">Masa Berlaku<br>Retribusi</th>
            <th width="12%">Status Terakhir</th>
            <th width="3%">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $jml_chr = strlen($list);
          $list = substr($list,0,$jml_chr-1);
          $obj = explode('^',$list);
          $a=0;
          foreach($obj as $xlist) {
          	$a++;
      	    $list = new tmpermohonan();
            $list->where('id', $xlist)->get();
            $pemohon = $list->tmpemohon->get();
            $tmsk = $list->tmsk->get();            
            $perusahaan = $list->tmperusahaan->get();
            $perizinan = $list->trperizinan->get();
            $kel_izin = $perizinan->trkelompok_perizinan->get();
            $status = '';
            if($list->status_berkas == 'proses') {
              if($kel_izin->id != '1' && $kel_izin->id != '3' && $kel_izin->id != '5')
                $status = $this->terbilang->cek_status($list->kd_status);
              else
                $status = $this->terbilang->cek_status('5');
            }else{
              if($list->desc_arsip == '') {
               $b1 = '<span style="color: Red">';
                $be1 = '</span>';
              }else{
                if($list->nama_file == '') {
                  $b1 = '<span style="color: Blue">';
                  $be1 = '</span>';
                }else{
                  $b1 = '';
                  $be1 = '';
                }
              }
              $status = '- '.$list->status_berkas;
              if($list->status_berkas != 'Izin Ditolak FO') {
                if($list->kd_status < 7){ 
                  if($list->c_izin_selesai == 1){
                    $status .= '<br>'.'- '.$this->terbilang->cek_status('9');
                  }else{
                    $status .= '<br>'.'- '.'Penyusunan Berkas';
                  }
                }else{
                  $status .= '<br>'.'- '.$this->terbilang->cek_status($list->kd_status);
                }
                $status .= $b1.'<br>'.'- '.' ARSIP '.$be1;
              }
            }
            ?>
            <tr>
              <td><?php echo $a; ?></td>
              <td><?php echo $list->pendaftaran_id.'<br>'.$pemohon->n_pemohon.'<br>'.$perusahaan->n_perusahaan ?></td>
              <td>
                <?php
                //echo $list->kd_gerai.'<br>'.$this->lib_date->mysql_to_human($list->d_terima_berkas).'<br>'.$this->lib_date->mysql_to_human($list->d_selesai_proses);
                echo $list->kd_gerai.'<br>'.$this->lib_date->mysql_to_human($list->d_terima_berkas).'<br>'.$this->lib_date->mysql_to_human($tmsk->tgl_penetapan);
                ?>
              </td>
              <td><?php echo $perizinan->n_perizinan; ?></td>
              <td><?php echo $list->a_izin; ?> </td>
              <td><?php echo $this->lib_date->mysql_to_human($list->d_berlaku_izin).'<br>'.'';?></td>
              <td><?php echo $status; ?> </td>
              <td>
                <?php
                $img_info = array('src' => base_url().'assets/images/icon/information.png',
                                  'alt' => 'Lihat Detail',
                                  'title' => 'Lihat Detail',
                                  'border' => '0',
                                 );
                echo anchor(site_url('arsip/edit') .'/L/'. $list->id.'/3', img($img_info))."&nbsp;";
                ?>
              </td>
            </tr>
            <?php
          }
          ?>
        </tbody>
        <!--<tbody>
          <tr>
            <td colspan="8" align="center">Loading data from server.</td>
          </tr>
        </tbody>-->
      </table>
    </div>
    <div class="entry">
      <table align=left>
        <tr>
          <td align="left">
            <?php
            $Back_data = array('src' => base_url().'assets/images/icon/back_alt.png',
                               'alt' => 'Lihat di HTML to Openoffice',
                               'title' => 'Kembali'
                              );
            echo anchor(site_url('rekapitulasi/izin/rekap_next'), img($Back_data));
                             
            $img_cetak = array('src' => base_url().'assets/images/icon/pdf.png',
                               'alt' => 'Cetak',
                               'title' => 'CetaK Detail ke PDF'
                              );
            echo anchor(site_url('rekapitulasi/izin/cetak_list') .'/'. $id_key.'/'.$menu, img($img_cetak));
            
            $img_cetak_excel = array('src' => base_url().'assets/images/icon/excel.png',
                                     'alt' => 'Cetak Excel',
                                     'title' => 'Cetak Detail ke Excel'
                                    );
            echo anchor(site_url('rekapitulasi/izin/cetak_list_excel') .'/'. $id_key.'/'.$menu, img($img_cetak_excel));
            ?>
          </td>
        </tr>
      </table>
    </div>
  </div>
  <br style="clear: both;" />
</div>