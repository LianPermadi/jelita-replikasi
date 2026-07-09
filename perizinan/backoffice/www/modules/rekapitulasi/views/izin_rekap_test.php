<html>
  <head>
    <title>Realisasi Penerimaan</title>
    <style type="text/css">
      .myButton {
        -moz-box-shadow:inset 0px 1px 0px 0px #54a3f7;
        -webkit-box-shadow:inset 0px 1px 0px 0px #54a3f7;
        box-shadow:inset 0px 1px 0px 0px #54a3f7;
        background:-webkit-gradient(linear, left top, left bottom, color-stop(0.05, #007dc1), color-stop(1, #0061a7));
        background:-moz-linear-gradient(top, #007dc1 5%, #0061a7 100%);
        background:-webkit-linear-gradient(top, #007dc1 5%, #0061a7 100%);
        background:-o-linear-gradient(top, #007dc1 5%, #0061a7 100%);
        background:-ms-linear-gradient(top, #007dc1 5%, #0061a7 100%);
        background:linear-gradient(to bottom, #007dc1 5%, #0061a7 100%);
        filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#007dc1', endColorstr='#0061a7',GradientType=0);
        background-color:#007dc1;
        -moz-border-radius:3px;
        -webkit-border-radius:3px;
        border-radius:3px;
        border:1px solid #124d77;
        display:inline-block;
        cursor:pointer;
        color:#ffffff;
        font-family:Arial;
        font-size:13px;
        padding:4px 12px;
        text-decoration:none;
        text-shadow:0px 1px 0px #154682;
      }
      .myButton:hover {
        background:-webkit-gradient(linear, left top, left bottom, color-stop(0.05, #0061a7), color-stop(1, #007dc1));
        background:-moz-linear-gradient(top, #0061a7 5%, #007dc1 100%);
        background:-webkit-linear-gradient(top, #0061a7 5%, #007dc1 100%);
        background:-o-linear-gradient(top, #0061a7 5%, #007dc1 100%);
        background:-ms-linear-gradient(top, #0061a7 5%, #007dc1 100%);
        background:linear-gradient(to bottom, #0061a7 5%, #007dc1 100%);
        filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#0061a7', endColorstr='#007dc1',GradientType=0);
        background-color:#0061a7;
      }
      .myButton:active {
        position:relative;
        top:1px;
      }
    </style>
  </head>
  
  <!--<body onLoad="window.print()">-->
  <body>
    <div id="content">
      <div class="post">
        <div class="title">
          <h2><?php echo $page_name;?></h2>
        </div>
        <!--<form name="form1" method="post"> -->
        <div class="entry">
          <div id="tabs">
            <?php if($list_state == '0') $ctk_asal = "Seluruhnya"; else $ctk_asal = $list_state; ?>
            <ul>
              <li><a href="#tabs-1"><b>REKAPITULASI PER SEKTOR</b></a></li>
              <li><a href="#tabs-2"><b>REKAPITULASI PER JENIS IZIN</b></a></li>
            </ul>
            
            <div id="tabs-1">
              <fieldset>
                <legend style="color: #045000" align="bottom">
                  <?php
                  echo 'Rekapitulasi Perizinan Periode '. (!empty($tgla && $tglb) ? $this->lib_date->mysql_to_human($tgla)." - ".$this->lib_date->mysql_to_human($tglb) : 'Seluruhnya')." ( Asal Permohonan : " . (isset($ctk_asal) ? $ctk_asal : "Seluruhnya") ." )";
                  ?>
                </legend>
                <table align=right>
                  <tr>
                    <td align="center">
                      <?php
                      $back_data = array('name' => 'button',
                                         'content' => 'Kembali',
                                         'value' => 'Kembali',
                                         'class' => 'button-wrc',
                                         'onclick' => 'parent.location=\''. site_url('rekapitulasi/izin') . '\''
                                        );
                      //echo form_button($back_data);
                      
                      $img_cetak = array('name' => 'button',
                                         'content' => 'Cetak PDF',
                                         'value' => 'Cetak PDF',
                                         'class' => 'button-wrc'
                                        );
                      //echo form_submit($img_cetak);
                      ?>
                    </td>
                  </tr>
                </table>
                <table align="center" width="90%" border="1" class="display" cellpadding="1" cellspacing="0" id="rev">
                  <tr class="title">
                    <th width="3%" rowspan="2"><font size="2" color="#1A1A1A"><b>No</b></font></th>
                    <th width="43%" rowspan="2"><font size="2" color="#1A1A1A"><b>Sektor Perizinan</b></font></th>
                    <th width="6%" rowspan="2"><font size="2" color="#1A1A1A"><b>Jumlah Permohonan</b></font></th>
                    <th width="6%"  rowspan="2"><font size="2" color="#1A1A1A"><b>Izin Ditolak FO</b></font></th>
                    <th colspan="3"><font size="2" color="#1A1A1A"><b>Izin Disetujui</b></font></th>
                    <th colspan="3"><font size="2" color="#1A1A1A"><b>Izin Ditolak</b></font></th>
                    <th width="6%" rowspan="2"><font size="2" color="#1A1A1A"><b><?php echo ($list_kat == 2 ? 'Izin Diluar Periode' : 'Izin Dalam Proses'); ?></b></font></th>
                  </tr>
                  <tr class="title">
                    <th width="6%" align="center"><font size="2" color="#1A1A1A"><b>Jumlah</b></font></th>
                    <th width="6%" align="center"><font size="2" color="#1A1A1A"><b>Diambil</b></font></th>
                    <th width="6%" align="center"><font size="2" color="#1A1A1A"><b>Belum Diambil</b></font></th>
                    <th width="6%" align="center"><font size="2" color="#1A1A1A"><b>Jumlah</b></font></th>
                    <th width="6%" align="center"><font size="2" color="#1A1A1A"><b>Diambil</b></font></th>
                    <th width="6%" align="center"><font size="2" color="#1A1A1A"><b>Belum Diambil</b></font></th>
                  </tr>
                  <tr>
                    <?php
                    $i = 1;
                    $totaljmlpermohonan = 0;
                    $totaljmltolakfo = 0;
                    $totaljmlsetujui = 0;
                    $totaljmlsetujuiambil = 0;
                    $totaljmlsetujuiblmambil = 0;
                    $totaljmltolak = 0;
                    $totaljmlproses = 0;

                    foreach ($result as $data){
                      ?>
                      <tr bgcolor="#FEF9BF">
                        <td align="center"><font size="2" color="#1A1A1A"><?php echo $i; ?></td>
                        <td align="left"> <font size="2" color="#1A1A1A"><?php echo $data->n_sektor; ?></font></td>
                        <td align="center">
                          <font size="2" color="#1A1A1A">
                            <?php
                            $img_jml_masuk = array('alt' => number_format($data->JMLPERMOHONAN,0,'.','.'),
                                                   'title' => 'Lihat Detail',
                                                   'border' => '0'
                                                  );
                            if($data->JMLPERMOHONAN == 0)
                              echo number_format($data->JMLPERMOHONAN,0,'.','.');
                            else
                              echo anchor(site_url('rekapitulasi/izin/list_data_test').'/0/'.$data->id.'/'.(!empty($list_state) ? str_replace(' ', '_', $list_state) : '0').'/'.(!empty($list_kat) ? $list_kat : '0').'/'.(!empty($tgla) && !empty($tglb) ? $tgla.'/'.$tglb : '0/0').'/1', '<button type="button" class="myButton" title="Lihat Detail">'.number_format($data->JMLPERMOHONAN,0,'.','.').'</button>', array('class' => 'link2-wrc', 'target' => '_blank'));
                              $totaljmlpermohonan += $data->JMLPERMOHONAN;
                            ?>
                          </font>
                        </td>
                        <td align="center">
                          <font size="2" color="#1A1A1A">
                            <?php
                            $img_jml_tolak_FO = array('alt' => number_format($data->JMLTOLAKFO,0,'.','.'),
                                                      'title' => 'Lihat Detail',
                                                      'border' => '0'
                                                     );
                            if($data->JMLTOLAKFO == 0)
                              echo number_format($data->JMLTOLAKFO,0,'.','.');
                            else
                              echo anchor(site_url('rekapitulasi/izin/list_data_test').'/0/'.$data->id.'/'.(!empty($list_state) ? str_replace(' ', '_', $list_state) : '0').'/'.(!empty($list_kat) ? $list_kat : '0').'/'.(!empty($tgla) && !empty($tglb) ? $tgla.'/'.$tglb : '0/0').'/2', '<button type="button" class="myButton" title="Lihat Detail">'.number_format($data->JMLTOLAKFO,0,'.','.').'</button>', array('class' => 'link2-wrc', 'target' => '_blank'));
                              $totaljmltolakfo += $data->JMLTOLAKFO;
                            ?>
                          </font>
                        </td>
                        <td align="center">
                          <font size="2" color="#1A1A1A">
                            <?php
                  	        $img_jml_terbit = array('alt' => number_format($data->JMLSETUJUI,0,'.','.'),
                                                    'title' => 'Lihat Detail',
                                                    'border' => '0'
                                                   );
                  	    	  if($data->JMLSETUJUI == 0)
                  	    	    echo number_format($data->JMLSETUJUI,0,'.','.');
                  	    	  else
                              echo anchor(site_url('rekapitulasi/izin/list_data_test').'/0/'.$data->id.'/'.(!empty($list_state) ? str_replace(' ', '_', $list_state) : '0').'/'.(!empty($list_kat) ? $list_kat : '0').'/'.(!empty($tgla) && !empty($tglb) ? $tgla.'/'.$tglb : '0/0').'/3', '<button type="button" class="myButton" title="Lihat Detail">'.number_format($data->JMLSETUJUI,0,'.','.').'</button>',  array('class' => 'link2-wrc', 'target' => '_blank'));
                              $totaljmlsetujui += $data->JMLSETUJUI;
                  	        ?>
                  	    
                  	      </font>
                        </td>
                        <td align="center">
                          <font size="2" color="#1A1A1A">
                	          <?php
                		        $img_terbit_ambil = array('alt' => number_format($data->JMLSETUJUIAMBIL,0,'.','.'),
                                                      'title' => 'Lihat Detail',
                                                      'border' => '0'
                                                     );
                		        if($data->JMLSETUJUIAMBIL == 0)
                		      	  echo number_format($data->JMLSETUJUIAMBIL,0,'.','.');
                		        else
                              echo anchor(site_url('rekapitulasi/izin/list_data_test').'/0/'.$data->id.'/'.(!empty($list_state) ? str_replace(' ', '_', $list_state) : '0').'/'.(!empty($list_kat) ? $list_kat : '0').'/'.(!empty($tgla) && !empty($tglb) ? $tgla.'/'.$tglb : '0/0').'/4', '<button type="button" class="myButton" title="Lihat Detail">'.number_format($data->JMLSETUJUIAMBIL,0,'.','.').'</button>', array('class' => 'link2-wrc', 'target' => '_blank'));
                              $totaljmlsetujuiambil += $data->JMLSETUJUIAMBIL;
                	          ?>
                	        </font>
                        </td>
                        <td align="center">
                          <font size="2" color="#1A1A1A">
                            <?php 
                            $img_terbit_proses = array('alt' => number_format($data->JMLSETUJUIBLMAMBIL,0,'.','.'),
                                                       'title' => 'Lihat Detail',
                                                       'border' => '0'
                                                      );
                            if($data->JMLSETUJUIBLMAMBIL == 0)
                              echo number_format($data->JMLSETUJUIBLMAMBIL,0,'.','.');
                            else
                              echo anchor(site_url('rekapitulasi/izin/list_data_test').'/0/'.$data->id.'/'.(!empty($list_state) ? str_replace(' ', '_', $list_state) : '0').'/'.(!empty($list_kat) ? $list_kat : '0').'/'.(!empty($tgla) && !empty($tglb) ? $tgla.'/'.$tglb : '0/0').'/5', '<button type="button" class="myButton" title="Lihat Detail">'.number_format($data->JMLSETUJUIBLMAMBIL,0,'.','.').'</button>', array('class' => 'link2-wrc', 'target' => '_blank'));
                              $totaljmlsetujuiblmambil += $data->JMLSETUJUIBLMAMBIL;
                            ?>
                          </font>
                        </td>
                        <td align="center">
                          <font size="2" color="#1A1A1A">
                            <?php
                            $img_jml_tolak = array('alt' => number_format($data->JMLTOLAK,0,'.','.'),
                                                   'title' => 'Lihat Detail',
                                                   'border' => '0'
                                                  );
                            if($data->JMLTOLAK == 0 )
                              echo number_format($data->JMLTOLAK,0,'.','.');
                            else
                              echo anchor(site_url('rekapitulasi/izin/list_data_test').'/0/'.$data->id.'/'.(!empty($list_state) ? str_replace(' ', '_', $list_state) : '0').'/'.(!empty($list_kat) ? $list_kat : '0').'/'.(!empty($tgla) && !empty($tglb) ? $tgla.'/'.$tglb : '0/0').'/6', '<button type="button" class="myButton" title="Lihat Detail">'.number_format($data->JMLTOLAK,0,'.','.').'</button>', array('class' => 'link2-wrc', 'target' => '_blank'));
                              $totaljmltolak += $data->JMLTOLAK;
                            ?>
                        	</font>
                        </td>
                        <td align="center"><font size="2" color="#1A1A1A"><?php echo number_format('0'); ?></font></td>
                        <td align="center"><font size="2" color="#1A1A1A"><?php echo number_format($data->JMLTOLAK); ?></font></td>
                        
                        <td align="center">
                          <font size="2" color="#1A1A1A">
                            <?php 
                            if ($filter3 == 1) {
                              $jmlproses = $data->JMLPERMOHONAN - ($data->JMLSETUJUI + $data->JMLTOLAK);
                            } else {
                              $jmlproses = $data->JMLPROSES;
                            }

                            $img_jml_proses = array('alt' => number_format($jmlproses,0,'.','.'),
                                                    'title' => 'Lihat Detail',
                                                    'border' => '0'
                                                   );
                            if($jmlproses == 0 )
                             echo number_format($jmlproses,0,'.','.'); 
                            else
                              echo anchor(site_url('rekapitulasi/izin/list_data_test').'/0/'.$data->id.'/'.(!empty($list_state) ? str_replace(' ', '_', $list_state) : '0').'/'.(!empty($list_kat) ? $list_kat : '0').'/'.(!empty($tgla) && !empty($tglb) ? $tgla.'/'.$tglb : '0/0').'/7', '<button type="button" class="myButton" title="Lihat Detail">'.number_format($jmlproses,0,'.','.').'</button>', array('class' => 'link2-wrc', 'target' => '_blank'));
                              $totaljmlproses += $jmlproses;
                        		?>
                        	</font>
                        </td>
                      </tr>
                  </tr>
                  <?php $i++; } ?>
                	<tr bgcolor bgcolor="#BFCFFE">
                	  <td align="right" colspan="2"> <font size="2" color="#1A1A1A"><b><?php echo 'TOTAL    '; ?></b></font></td>
                    <td align="center"><font size="2" color="#1A1A1A"><b><?php echo number_format($totaljmlpermohonan,0,'.','.'); ?></b></font></td> 
                	  <td align="center"><font size="2" color="#1A1A1A"><b><?php echo number_format($totaljmltolakfo,0,'.','.'); ?></b></font></td>
                    <td align="center"><font size="2" color="#1A1A1A"><b><?php echo number_format($totaljmlsetujui,0,'.','.'); ?></b></font></td>
                    <td align="center"><font size="2" color="#1A1A1A"><b><?php echo number_format($totaljmlsetujuiambil,0,'.','.'); ?></b></font></td> 
                    <td align="center"><font size="2" color="#1A1A1A"><b><?php echo number_format($totaljmlsetujuiblmambil,0,'.','.'); ?></b></font></td>
                    <td align="center"><font size="2" color="#1A1A1A"><b><?php echo number_format($totaljmltolak,0,'.','.'); ?></b></font></td> 
                    <td align="center"><font size="2" color="#1A1A1A"><b><?php echo number_format('0',0,'.','.'); ?></b></font></td>  
                    <td align="center"><font size="2" color="#1A1A1A"><b><?php echo number_format($totaljmltolak,0,'.','.'); ?></b></font></td> 
                    <td align="center"><font size="2" color="#1A1A1A"><b><?php echo number_format($totaljmlproses,0,'.','.'); ?></b></font></td>
                  </tr>
                </table>
              </fieldset>
            </div>
                
            <div id="tabs-2">
              <?php echo form_open('rekapitulasi/izin/cetak/'. $tgla.'/'.$tglb.'/'.$ctk_asal.'/2'); ?>
              <fieldset>
                <legend style="color: #045000" align="bottom">
                  <?php
                  echo 'Rekapitulasi Perizinan Periode '. $this->lib_date->mysql_to_human($tgla)." - ".$this->lib_date->mysql_to_human($tglb)." ( Asal Permohonan : " . (isset($ctk_asal) ? $ctk_asal : "Seluruhnya") ." )";
                  ?>
                </legend>
                <table align=right>
                  <tr>
                    <td align="center">
                      <?php
                      $back_data = array('name' => 'button',
                                         'content' => 'Kembali',
                                         'value' => 'Kembali',
                                         'class' => 'button-wrc',
                                         'onclick' => 'parent.location=\''. site_url('rekapitulasi/izin') . '\''
                                        );
                      //echo form_button($back_data);
                                 
                      $img_cetak = array('name' => 'button',
                                         'content' => 'Cetak PDF',
                                         'value' => 'Cetak PDF',
                                         'class' => 'button-wrc'
                                        );
                      //echo form_submit($img_cetak);
                      ?>
                    </td>
                  </tr>
                </table>
                <table align="center" width="90%" border="1" class="display" cellpadding="1" cellspacing="0" id="rev">
                  <tr class="title">
                    <th width="3%"  rowspan="2"><font size="2" color="#1A1A1A"><b>No</b></font></th>
                    <th width="58%" rowspan="2"><font size="2" color="#1A1A1A"><b>Jenis Izin</b></font></th>
                    <td width="7%"  rowspan="2"><font size="2" color="#1A1A1A"><b>Kode Izin</b></font></td>
                    <th width="4%"  rowspan="2"><font size="2" color="#1A1A1A"><b>Jumlah Permohonan</b></font></th>
                    <th width="4%"  rowspan="2"><font size="2" color="#1A1A1A"><b>Izin Ditolak FO</b></font></th>
                    <th             colspan="3"><font size="2" color="#1A1A1A"><b>Izin Disetujui</b></font></th>
                    <th             colspan="3"><font size="2" color="#1A1A1A"><b>Izin Ditolak</b></font></th>
                    <th width="4%"  rowspan="2"><font size="2" color="#1A1A1A"><b><?php echo ($list_kat == 2 ? 'Izin Diluar Periode' : 'Izin Dalam Proses'); ?></b></font></th>
                  </tr>
                  <tr class="title">
                    <th width="4%" align="center"><font size="2" color="#1A1A1A"><b>Jumlah</b></font></th>
                    <th width="4%" align="center"><font size="2" color="#1A1A1A"><b>Diambil</b></font></th>
                    <th width="4%" align="center"><font size="2" color="#1A1A1A"><b>Belum Diambil</b></font></th>
                    <th width="4%" align="center"><font size="2" color="#1A1A1A"><b>Jumlah</b></font></th>
                    <th width="4%" align="center"><font size="2" color="#1A1A1A"><b>Diambil</b></font></th>
                    <th width="4%" align="center"><font size="2" color="#1A1A1A"><b>Belum Diambil</b></font></th>
                  </tr>
                  <tr>
                    <?php
                    $i = 1;
                    $is = 1;
                    $prev = '';

                    $tot_all_permohonan = 0;
                    $tot_all_tolak_fo = 0;
                    $tot_all_setujui = 0;
                    $tot_all_setujui_ambil = 0;
                    $tot_all_setujui_blm_ambil = 0;
                    $tot_all_tolak = 0;
                    $tot_all_proses = 0;

                    foreach ($data_perizinan as $datap => $perp) {
                    ?>
                            <!-- <tr bgcolor="#FEF280">
                              <td align="right" colspan="3">
                                <font size="2" color="#1A1A1A"><?php echo '<b>'.$ket_cetak.'</b>'; ?></font>
                              </td>
                              <td align="center">
                                <font size="2" color="#1A1A1A"><?php echo '<b>'.number_format($g_jumlah_masuk,0,'.','.').'</b>'; ?></font>
                              </td>
                              <td align="center">
                                <font size="2" color="#1A1A1A"><?php echo '<b>'.number_format($g_tolak_FO,0,'.','.').'</b>'; ?></font>
                              </td>
                              <td align="center">
                                <font size="2" color="#1A1A1A"><?php echo '<b>'.number_format($g_jumlah_terbit,0,'.','.').'</b>'; ?></font>
                              </td>
                              <td align="center">
                                <font size="2" color="#1A1A1A"><?php echo '<b>'.number_format($g_terbit_ambil,0,'.','.').'</b>'; ?></font>
                              </td>
                              <td align="center">
                                <font size="2" color="#1A1A1A"><?php echo '<b>'.number_format($g_terbit_proses,0,'.','.').'</b>'; ?></font>
                              </td>
                              <td align="center">
                                <font size="2" color="#1A1A1A"><?php echo '<b>'.number_format($g_jumlah_tolak,0,'.','.').'</b>'; ?></font>
                              </td>
                              <td align="center">
                                <font size="2" color="#1A1A1A"><?php echo '<b>'.number_format($g_tolak_ambil,0,'.','.').'</b>'; ?></font>
                              </td>
                              <td align="center">
                                <font size="2" color="#1A1A1A"><?php echo '<b>'.number_format($g_tolak_proses,0,'.','.').'</b>'; ?></font>
                              </td>
                              <td align="center">
                                <font size="2" color="#1A1A1A"><?php echo '<b>'.number_format($g_jumlah_proses,0,'.','.').'</b>'; ?></font>
                              </td>
                            </tr> -->
                            <tr>
                              <td align="center" colspan="12"><font size="2" color="#1A1A1A"><?php echo ''; ?></font></td>
                            </tr>

                      <?php 
                        $anka_romawi = $this->terbilang->DecRomawi($is);
                        ?>
                          <tr bgcolor="#B2A100">
                            <td align="Left"> <font size="2" color="#1A1A1A"><?php echo '<b>'.$anka_romawi.'</b>'; ?></font> </td>
                            <td colspan="11">
                              <font size="2" color="#1A1A1A">
                                <?php echo '<b>PERIZINAN SEKTOR '.$datap.'</b>'; ?>
                              </font>
                            </td>
                          </tr>

                          <?php 
                          $i = 1; 
                          $tot_jml_mohon = 0;
                          $tot_jml_tolak_fo = 0;
                          $tot_jml_setujui = 0;
                          $tot_jml_setujui_ambil = 0;
                          $tot_jml_setujui_blm_ambil = 0;
                          $tot_jml_tolak = 0;
                          $tot_jml_proses = 0;

                          foreach ($perp as $keys => $values) {
                            $aktif = '';
                            $b = '';
                            $be = '';
                            $tmp_kd_izin = substr($values['kd_perizinan'],0,2).'.'.substr($values['kd_perizinan'],2,1).'.'.substr($values['kd_perizinan'],3,2).'.'.substr($values['kd_perizinan'],5);

                            if($values['c_aktif'] == '1' && $values['c_online'] == '1'){
                              $aktif = ' [Tidak Aktif]';
                              $b = '<span style="color: Red">';
                              $be = '</span>';
                            }
                           ?>
                            <tr bgcolor="#FEF9BF">
                              <td align="right"><font size="2" color="#1A1A1A"><?php echo $b.$i.$be; ?></font></td>
                              <td><font size="2" color="#1A1A1A"><?php echo $b.$values['n_perizinan'].$aktif.$be; ?></font></td>
                              <td><font size="2" color="#1A1A1A"><?php echo $b.$tmp_kd_izin.$be; ?></font></td>
                              <td align="center">
                                <font size="2" color="#1A1A1A">
                                  <?php
                                  $img_jml_masuk = array('alt' => number_format($values['jmlpermohonan'],0,'.','.'),
                                                         'title' => 'Lihat Detail',
                                                         'border' => '0'
                                                        );
                                  if($values['jmlpermohonan'] == 0)
                                    echo $b.number_format($values['jmlpermohonan'],0,'.','.').$be;
                                  else
                                    echo anchor(site_url('rekapitulasi/izin/list_data_test').'/1/'.$values['id'].'/'.(!empty($list_state) ? str_replace(' ', '_', $list_state) : '0').'/'.(!empty($list_kat) ? $list_kat : '0').'/'.(!empty($tgla) && !empty($tglb) ? $tgla.'/'.$tglb : '0/0').'/1', '<button type="button" class="myButton" title="Lihat Detail">'.number_format($values['jmlpermohonan'],0,'.','.').'</button>', array('class' => 'link2-wrc', 'target' => '_blank'));
                                  $tot_jml_mohon += $values['jmlpermohonan'];
                                  $tot_all_permohonan += $values['jmlpermohonan'];
                                  ?>
                                </font>
                              </td>
                              <td align="center">
                                <font size="2" color="#1A1A1A">
                                  <?php
                                  $img_jml_tolak_FO = array('alt' => number_format($values['jmltolakfo'],0,'.','.'),
                                                            'title' => 'Lihat Detail',
                                                            'border' => '0'
                                                           );
                                  if($values['jmltolakfo'] == 0)
                                    echo $b.number_format($values['jmltolakfo'],0,'.','.').$be;
                                  else
                                    echo anchor(site_url('rekapitulasi/izin/list_data_test').'/1/'.$values['id'].'/'.(!empty($list_state) ? str_replace(' ', '_', $list_state) : '0').'/'.(!empty($list_kat) ? $list_kat : '0').'/'.(!empty($tgla) && !empty($tglb) ? $tgla.'/'.$tglb : '0/0').'/2', '<button type="button" class="myButton" title="Lihat Detail">'.number_format($values['jmltolakfo'],0,'.','.').'</button>', array('class' => 'link2-wrc', 'target' => '_blank'));
                                  $tot_jml_tolak_fo += $values['jmltolakfo'];
                                  $tot_all_tolak_fo += $values['jmltolakfo'];
                                  ?>
                                </font>
                              </td>
                              <td align="center">
                                <font size="2" color="#1A1A1A">
                                  <?php
                                  $img_jml_terbit = array('alt' => number_format($values['jmlsetujui'],0,'.','.'),
                                                          'title' => 'Lihat Detail',
                                                          'border' => '0'
                                                         );
                                  if($values['jmlsetujui'] == 0)
                                    echo $b.number_format($values['jmlsetujui'],0,'.','.').$be;
                                  else
                                   echo anchor(site_url('rekapitulasi/izin/list_data_test').'/1/'.$values['id'].'/'.(!empty($list_state) ? str_replace(' ', '_', $list_state) : '0').'/'.(!empty($list_kat) ? $list_kat : '0').'/'.(!empty($tgla) && !empty($tglb) ? $tgla.'/'.$tglb : '0/0').'/3', '<button type="button" class="myButton" title="Lihat Detail">'.number_format($values['jmlsetujui'],0,'.','.').'</button>', array('class' => 'link2-wrc', 'target' => '_blank'));
                                 $tot_jml_setujui += $values['jmlsetujui'];
                                 $tot_all_setujui += $values['jmlsetujui'];
                                  ?>
                                </font>
                              </td>
                              <td align="center">
                                <font size="2" color="#1A1A1A">
                                  <?php
                                  $img_jml_terbit_ambil = array('alt' => number_format($values['jmlsetujuiambil'],0,'.','.'),
                                                                'title' => 'Lihat Detail',
                                                                'border' => '0'
                                                               );
                                  if($values['jmlsetujuiambil'] == 0)
                                    echo $b.number_format($values['jmlsetujuiambil'],0,'.','.').$be;
                                  else
                                    echo anchor(site_url('rekapitulasi/izin/list_data_test').'/1/'.$values['id'].'/'.(!empty($list_state) ? str_replace(' ', '_', $list_state) : '0').'/'.(!empty($list_kat) ? $list_kat : '0').'/'.(!empty($tgla) && !empty($tglb) ? $tgla.'/'.$tglb : '0/0').'/4', '<button type="button" class="myButton" title="Lihat Detail">'.number_format($values['jmlsetujuiambil'],0,'.','.').'</button>', array('class' => 'link2-wrc', 'target' => '_blank'));
                                  $tot_jml_setujui_ambil += $values['jmlsetujuiambil'];
                                  $tot_all_setujui_ambil += $values['jmlsetujuiambil'];
                                  ?>
                                </font>
                              </td>
                              <td align="center">
                                <font size="2" color="#1A1A1A">
                                  <?php
                                  $img_jml_terbit_proses = array('alt' => number_format($values['jmlsetujuiblmambil'],0,'.','.'),
                                                                 'title' => 'Lihat Detail',
                                                                 'border' => '0'
                                                                );
                                  if($values['jmlsetujuiblmambil'] == 0)
                                    echo $b.number_format($values['jmlsetujuiblmambil'],0,'.','.').$be;
                                  else
                                    echo anchor(site_url('rekapitulasi/izin/list_data_test').'/1/'.$values['id'].'/'.(!empty($list_state) ? str_replace(' ', '_', $list_state) : '0').'/'.(!empty($list_kat) ? $list_kat : '0').'/'.(!empty($tgla) && !empty($tglb) ? $tgla.'/'.$tglb : '0/0').'/5', '<button type="button" class="myButton" title="Lihat Detail">'.number_format($values['jmlsetujuiblmambil'],0,'.','.').'</button>', array('class' => 'link2-wrc', 'target' => '_blank'));
                                  $tot_jml_setujui_blm_ambil += $values['jmlsetujuiblmambil'];
                                  $tot_all_setujui_blm_ambil += $values['jmlsetujuiblmambil'];
                                  ?>
                                </font>
                              </td>
                              <td align="center">
                                <font size="2" color="#1A1A1A">
                                  <?php
                                  $img_jml_tolak = array('alt' => number_format($values['jmltolak'],0,'.','.'),
                                                         'title' => 'Lihat Detail',
                                                         'border' => '0'
                                                        );
                                  if($values['jmltolak'] == 0)
                                    echo $b.number_format($values['jmltolak'],0,'.','.').$be;
                                  else
                                    echo anchor(site_url('rekapitulasi/izin/list_data_test').'/1/'.$values['id'].'/'.(!empty($list_state) ? str_replace(' ', '_', $list_state) : '0').'/'.(!empty($list_kat) ? $list_kat : '0').'/'.(!empty($tgla) && !empty($tglb) ? $tgla.'/'.$tglb : '0/0').'/6', '<button type="button" class="myButton" title="Lihat Detail">'.number_format($values['jmltolak'],0,'.','.').'</button>', array('class' => 'link2-wrc', 'target' => '_blank'));
                                  $tot_jml_tolak += $values['jmltolak'];
                                  $tot_all_tolak += $values['jmltolak'];
                                  ?>
                                </font>
                              </td>
                              <td align="center">
                                <font size="2" color="#1A1A1A"><?php echo $b.number_format('0',0,'.','.').$be; ?></font>
                              </td>
                              <td align="center">
                                <font size="2" color="#1A1A1A"><?php echo $b.number_format($values['jmltolak'],0,'.','.').$be; ?></font>
                              </td>
                              <td align="center">
                                <font size="2" color="#1A1A1A">
                                  <?php
                                  if ($filter3 == 1) {
                                    $jmlprosesizin = $values['jmlpermohonan'] - ((!empty($values['jmlsetujui']) ? $values['jmlsetujui'] : 0) + (!empty($values['jmltolak']) ? $values['jmltolak'] : 0));
                                  } else {
                                    $jmlprosesizin = $values['jmlproses'];
                                  }
                                  $img_jml_proses = array('alt' => number_format($values['jmlproses'],0,'.','.'),
                                                          'title' => 'Lihat Detail',
                                                          'border' => '0'
                                                         );
                                  if($jmlprosesizin == 0)
                                    echo $b.number_format($values['jmlproses'],0,'.','.').$be;
                                  else
                                   echo anchor(site_url('rekapitulasi/izin/list_data_test').'/1/'.$values['id'].'/'.(!empty($list_state) ? str_replace(' ', '_', $list_state) : '0').'/'.(!empty($list_kat) ? $list_kat : '0').'/'.(!empty($tgla) && !empty($tglb) ? $tgla.'/'.$tglb : '0/0').'/7', '<button type="button" class="myButton" title="Lihat Detail">'.number_format($jmlprosesizin,0,'.','.').'</button>', array('class' => 'link2-wrc', 'target' => '_blank'));
                                 $tot_jml_proses += $jmlprosesizin;
                                 $tot_all_proses += $jmlprosesizin;
                                  ?>
                                </font>
                              </td>
                            </tr>
                          <?php $i++; } 
                          $i = 1;

                          ?>                                          
                  </tr>

                  <tr bgcolor="#FEF280">
                    <td align="right" colspan="3">
                      <font size="2" color="#1A1A1A">
                        <?php

                        $ket_cetak = 'JUMLAH PERMOHONAN IZIN SEKTOR '.$datap;
                        echo '<b>'.$ket_cetak.'</b>';
                        ?>
                      </font>
                    </td>
                    <td align="center"><font size="2" color="#1A1A1A"><?php echo '<b>'.number_format($tot_jml_mohon,0,'.','.') .'</b>';?></font></td>
                    <td align="center"><font size="2" color="#1A1A1A"><?php echo '<b>'.number_format($tot_jml_tolak_fo,0,'.','.') .'</b>';?></font></td>
                    <td align="center"><font size="2" color="#1A1A1A"><?php echo '<b>'.number_format($tot_jml_setujui,0,'.','.').'</b>';?></font></td>
                    <td align="center"><font size="2" color="#1A1A1A"><?php echo '<b>'.number_format($tot_jml_setujui_ambil,0,'.','.') .'</b>';?></font></td>
                    <td align="center"><font size="2" color="#1A1A1A"><?php echo '<b>'.number_format($tot_jml_setujui_blm_ambil,0,'.','.').'</b>';?></font></td>
                    <td align="center"><font size="2" color="#1A1A1A"><?php echo '<b>'.number_format($tot_jml_tolak,0,'.','.') .'</b>';?></font></td>
                    <td align="center"><font size="2" color="#1A1A1A"><?php echo '<b>'.number_format('0',0,'.','.')  .'</b>';?></font></td>
                    <td align="center"><font size="2" color="#1A1A1A"><?php echo '<b>'.number_format($tot_jml_tolak,0,'.','.') .'</b>';?></font></td>
                    <td align="center"><font size="2" color="#1A1A1A"><?php echo '<b>'.number_format($tot_jml_proses,0,'.','.').'</b>';?></font></td>
                  </tr>

                  <?php 
                  $is++; } ?>
                  <tr bgcolor="#BFCFFE">
                    <td align="right" colspan="3">
                      <font size="2" color="#1A1A1A">
                        <b>
                          <?php 
                          $tot_jns = $is -1;
                          $tot_cetak = 'TOTAL JENIS IZIN = '.$tot_jns.'; TOTAL PERMOHONAN';
                          echo $tot_cetak;
                          ?>
                        </b>
                      </font>
                    </td>
                    <td align="center"><font size="2" color="#1A1A1A"><?php echo '<b>'.number_format($tot_all_permohonan,0,'.','.') .'</b>';?></font></td>
                    <td align="center"><font size="2" color="#1A1A1A"><?php echo '<b>'.number_format($tot_all_tolak_fo,0,'.','.')     .'</b>';?></font></td>
                    <td align="center"><font size="2" color="#1A1A1A"><?php echo '<b>'.number_format($tot_all_setujui,0,'.','.').'</b>';?></font></td>
                    <td align="center"><font size="2" color="#1A1A1A"><?php echo '<b>'.number_format($tot_all_setujui_ambil,0,'.','.') .'</b>';?></font></td>
                    <td align="center"><font size="2" color="#1A1A1A"><?php echo '<b>'.number_format($tot_all_setujui_blm_ambil,0,'.','.').'</b>';?></font></td>
                    <td align="center"><font size="2" color="#1A1A1A"><?php echo '<b>'.number_format($tot_all_tolak,0,'.','.') .'</b>';?></font></td>
                    <td align="center"><font size="2" color="#1A1A1A"><?php echo '<b>'.number_format('0',0,'.','.')  .'</b>';?></font></td>
                    <td align="center"><font size="2" color="#1A1A1A"><?php echo '<b>'.number_format($tot_all_tolak,0,'.','.') .'</b>';?></font></td>
                    <td align="center"><font size="2" color="#1A1A1A"><?php echo '<b>'.number_format($tot_all_proses,0,'.','.').'</b>';?></font></td>
                  </tr>
                </table>
              </fieldset>
            </div>
          </div>
        </div>
        <!--</form>-->
      </div>
    </div>
  </body>
</html>