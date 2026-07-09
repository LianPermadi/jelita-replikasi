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
        $attr = array('class' => 'kasir',
                      'id' => 'kasir');
        echo form_open('kasir/save', $attr);
        echo form_hidden('id', $id);
        echo form_hidden('idbap', $idbap);
        echo form_hidden('idsk', $idsk);
        echo form_hidden('indeks', $indeks);
        ?>
        <div id="statusMain">
          <div id="leftMain" class="bg-grid">
            <?php echo form_label('No Pendaftaran', 'no_pendaftaran'); ?>
          </div>
          <div id="rightMain" class="bg-grid">
            <?php echo $no_pendaftaran; ?>
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
            <?php echo form_label('Nomor SK', 'no_sk'); ?>
          </div>
          <div id="rightMain"class="bg-grid">
          	<!--<input type="text" class="input-wrc required" name="no_surat" id="no_surat" value="<?php echo $no_surat; ?>" />-->
            <?php echo $no_surat; ?>
          </div>
          
          <div id="leftMain">
            <?php echo form_label('Tanggal SK', 'tgl_sk'); ?>
          </div>
          <div id="rightMain">
            <?php
            //$tglSK_in = array('name'  => 'tgl_surat',
            //                  'value' => $tgl_surat,
            //                  'class' => 'input-wrc',
            //                  'readOnly'=>TRUE,
            //                  'class' => 'monbulan');
            //echo form_input($tglSK_in);
            echo $this->lib_date->mysql_to_human($tgl_surat);
            ?>
          </div>
          
          <!--
          <div id="leftMain" class="bg-grid">
            <?php echo form_label('Masa Berlaku SK', 'masa_laku_sk'); ?>
          </div>
          <div id="rightMain" class="bg-grid">
            <?php
            //$berlakuSK_in = array('name'  => 'tglb',
            //                      'value' => $tglb,
            //                      'class' => 'input-wrc',
            //                      'readOnly'=>TRUE,
            //                      'class' => 'monbulan');
            //echo form_input($berlakuSK_in);
            echo $this->lib_date->mysql_to_human($tglb);
            ?>
          </div>
          -->
          
          <div id="leftMain" class="bg-grid">
            <?php echo form_label('Besar Retribusi', 'retribusi'); ?>
          </div>
          <div id="rightMain" class="bg-grid">
          	<?php echo 'Rp. '; ?>
            <input type="text" class="input-wrc required" name="retribusi" id="retribusi" onkeypress="return hanyaAngka(event, false)" value="<?php echo $retribusi; ?>" />
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
                                      'content' => 'Bayar Retribusi',
                                      'type' => 'submit',
                                      'value' => 'Bayar Retribusi',
                                      'onClick' => 'return confirm_link(\''.$confirm_text.'\')',);
                      echo form_submit($img_ok);
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
                                      'content' => 'Bayar Retribusi',
                                      'type' => 'submit',
                                      'value' => 'Bayar Retribusi',
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