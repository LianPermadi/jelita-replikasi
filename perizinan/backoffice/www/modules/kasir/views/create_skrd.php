<script language="javascript">
  function hanyaAngka(e, decimal) {
    var key;
    var keychar;
     if (window.event) {
         key = window.event.keyCode;
     }else
      if (e) {
        key = e.which;
     } else return true;
    
    keychar = String.fromCharCode(key);
    if ((key==null) || (key==0) || (key==8) ||  (key==9) || (key==13) || (key==27) ) {
        return true;
    } else
      if ((("0123456789").indexOf(keychar) > -1)) {
        return true;
    } else
      if (decimal && (keychar == ".")) {
        return true;
    } else return false;
  }
</script>

<div id="content">
  <div class="post">
    <div class="title">
      <h2><?php echo $page_name; ?></h2>
    </div>
    <div class="entry">
      <fieldset>
        <legend>Data Pemohon</legend>
        <?php
        $attr = array('class' => 'kasir', 'id' => 'kasir');
        echo form_open('kasir/view', $attr);
        echo form_hidden('id', $id);
        echo form_hidden('idbap', $idbap);
        echo form_hidden('idsk', $idsk);
        echo form_hidden('idizin', $idizin);
        echo form_hidden('tg_daftar', $tg_daftar);
        echo form_hidden('masa_laku', $masa_laku_sk);
        echo form_hidden('no_kend', $no_kend);
        
        ?>
        <div id="statusMain">
          <div id="leftMain" class="bg-grid">
            <?php echo form_label('No Pendaftaran / Tgl Daftar', 'no_pendaftaran'); ?>
          </div>
          <div id="rightMain" class="bg-grid">
            <?php echo $no_pendaftaran .' / '. $this->lib_date->mysql_to_human($tg_daftar); ?>
          </div>
          
          <div id="leftMain">
            <?php echo form_label('Nama Pemohon', 'nama_pemohon'); ?>
          </div>
          <div id="rightMain">
            <?php echo $nama_pendaftar; ?>
          </div>
          
          <div id="leftMain" class="bg-grid">
            <?php echo form_label('Jenis Perizinan', 'jenis_perizinan'); ?>
          </div>
          <div id="rightMain" class="bg-grid">
            <?php echo $jenis; ?>
          </div>
          
          <div id="leftMain">
            <?php echo form_label('Objek Ijin', 'objek_izin'); ?>
          </div>
          <div id="rightMain">
            <?php echo $a_izin; ?>
          </div>
          
          <div id="leftMain" class="bg-grid">
            <?php echo form_label('Nomor Kendaraan / No Uji', 'no_kend'); ?>
          </div>
          <div id="rightMain"class="bg-grid">
            <?php
            if($no_kend == ''){
              echo '<b>'.'KENDARAAN TIDAK TERDAFTAR'.'</b>';
              $nilai_retribusi = 0;
            }else{
              echo $no_kend .' / '. $no_uji;
              $nilai_retribusi = 82500;	
            }  
            ?>
          </div>
          
          <div id="leftMain">
            <?php echo form_label('Nomor SK Lama', 'no_sk_lama'); ?>
          </div>
          <div id="rightMain">
            <?php
            echo '<b>'.$no_sk_lama .'</b>'.' Berlaku : '. $this->lib_date->mysql_to_human($mulai_laku_sk).' s/d '. $this->lib_date->mysql_to_human($masa_laku_sk);
            ?>
          </div>
          
          <div id="leftMain" class="bg-grid">
            <?php echo form_label('Nomor KP Lama', 'no_kp_lama'); ?>
          </div>
          <div id="rightMain" class="bg-grid">
            <?php
            echo '<b>'.$no_kp_lama .'</b>'.' Berlaku : '. $this->lib_date->mysql_to_human($tg_kp_lama_awal) . ' s/d ' . $this->lib_date->mysql_to_human($tg_kp_lama_akhir);
            ?>
          </div>
          
          <!--<div id="leftMain">
            <?php echo form_label('Masa Berlaku Izin Lama', 'masa_laku'); ?>
          </div>
          <div id="rightMain">
            <?php
            echo $this->lib_date->mysql_to_human($masa_laku_sk);
            ?>
          </div>
          -->
          
          <div id="leftMain" class="bg-grid">
            <?php echo form_label('Retribusi', 'nil_ret'); ?>
          </div>
          <div id="rightMain" class="bg-grid">
            <?php
            echo number_format($nilai_retribusi,2,",",".");
            echo form_hidden('nilai_retribusi', $nilai_retribusi);
            ?>
          </div>
          
          <div id="leftMain">
            <?php echo form_label('Denda Keterlambatan', 'denda'); ?>
          </div>
          <div id="rightMain">
            <?php
            $denda = $jml_bulan * 0.002 * $nilai_retribusi;
            $text_denda = $jml_bulan . ' bulan x (2% x ' . number_format($nilai_retribusi,2,",",".") . ')';
            echo form_hidden('denda', $denda);
            echo form_hidden('text_denda', $text_denda);
            echo $text_denda . ' = '. number_format($denda,2,",",".");
            
            ?>
          </div>
                    
          <div id="leftMain" class="bg-grid">
            <?php echo form_label('Jumlah Retribusi', 'retribusi'); ?>
          </div>
          <div id="rightMain" class="bg-grid">
          	<?php 
          	  $retribusi = $nilai_retribusi + $denda;
          	  echo form_hidden('retribusi', $retribusi);
          	  echo 'Rp. '. number_format($retribusi,2,",","."); 
          	?>
            <!--<input type="text" class="input-wrc required" name="retribusi" id="retribusi" onkeypress="return hanyaAngka(event, false)" value="<?php echo $retribusi; ?>" />-->
          </div>
        </div>
        
        <div id="statusRail">
          <div id="leftRail">
            <label for="name_paralel"></label>
          </div>
          <div id="rightRail">
            <?php
            if(intval($status) === 0) {
              ?>
              <div id="money">
                <table border="0" align="right">
                  <tr>
                    <td>
                      <?php
                      $hit_retribusi = $v_lru * $v_ig * $v_il * $v_td;
                      $confirm_text = 'Apakah Anda yakin Retribusi Sudah Dibayar ?';
                      $img_ok = array('name' => 'submit',
                                      'class' => 'submit-wrc',
                                      'content' => 'View SKRD',
                                      'type' => 'submit',
                                      'value' => 'View SKRD',
                                      );//'onClick' => 'return confirm_link(\''.$confirm_text.'\')',);
                      if($no_kend != ''){                
                        echo form_submit($img_ok);
                      }
                      ?>
                      <!--<input type="image" src="<?php echo base_url();?>assets/images/icon/money.png" alt="Bayar Retribusi"
                             name="retribusi" title="Bayar Retribusi" onClick="return confirm('Apakan anda yakin saudara
                             <?php echo $nama_pendaftar ." / " . $this->input->post('v_lru') ?> sudah membayar biaya retribusi?')">
                      -->
                    </td>
                    <td align="right">
                      <?php
                      //$img_edit = array('src' => 'assets/images/icon/back_alt.png',
                      //                  'alt' => 'Kembali',
                      //                  'title' => 'Kembali',
                      //                  'border' => '0');
                      $img_back = array('name' => 'button',
                                        'class' => 'button-wrc',
                                        'content' => 'Kembali',
                                        'value' => 'Kembali',
                                        'onclick' => 'parent.location=\'' . site_url('kasir/index_next') . '\'');
                      echo form_button($img_back);
                      ?>
                      <!--<a class="page-help" href="<?php echo site_url('kasir/index_next'); ?>">
                        <?php echo img($img_edit); ?>
                      -->
                      </a>
                    </td>
                  </tr>
                </table>
              </div>
              <?php
            }else{
              ?>
              <div id="print">
                <!-- tambahan -->
                <table border="0" align="right">
                  <tr>
                    <td>
                    	<?php
                    	$confirm_text = 'Apakah Anda yakin Retribusi Sudah Dibayar ?';
                      $img_ok = array('name' => 'submit',
                                      'class' => 'submit-wrc',
                                      'content' => 'View SKRD',
                                      'type' => 'submit',
                                      'value' => 'View SKRD',
                                      'onClick' => 'return confirm_link(\''.$confirm_text.'\')',);
                      echo form_submit($img_ok);
                      ?>
                      <!--<input type="image" src="<?php echo base_url();?>assets/images/icon/money.png" alt="Bayar Retribusi"
                             name="retribusi" title="Bayar Retribusi" onClick="return confirm('Apakan anda yakin saudara
                             <?php echo $nama_pendaftar ." / " . $this->input->post('v_lru') ?> sudah membayar biaya retribusi?')">
                      -->
                      </a>
                    </td>
                    <td>
                      <?php
                      $img_back = array('name' => 'button',
                                        'class' => 'button-wrc',
                                        'content' => 'Kembali',
                                        'value' => 'Kembali',
                                        'onclick' => 'parent.location=\'' . site_url('kasir/index_next') . '\'');
                      echo form_button($img_back);
                      //$img_edit = array('src' => 'assets/images/icon/back_alt.png',
                      //                  'alt' => 'Kembali',
                      //                  'title' => 'Kembali',
                      //                  'border' => '0');
                      ?>
                      <!--<a class="page-help" href="<?php echo site_url('kasir/index_next'); ?>">
                        <?php echo img($img_edit); ?>
                      -->
                      </a>
                    </td>
                  </tr>
                </table>
              </div>
              <?php
            }
            ?>
          </div>
        </div>
        <?php
        echo form_close();
        ?>
      </fieldset>
    </div>
  </div>
  <br style="clear: both;" />
</div>