<div id="content">
  <div class="post">
    <div class="title">
      <?php echo $this->lib_date->view_title($page_name); ?>
    </div>
    <div class="entry">
      <?php 
      $attr = array('id' => 'form','name'=>'form1');
      echo form_open('persuratan/update_penomoran',$attr); 
      ?>
      <?php echo form_hidden('id', $surat->id); ?>
      <fieldset>
        <legend>Data-Data Surat</legend>
        <div id="statusMain">
          <div id="leftMain" class="bg-grid">
            <?php echo "<b>". form_label('Eselon 2', 'ess2') . "</b>"; ?>
          </div>
          <div id="rightMain" class="bg-grid">
            <?php echo $this->m_persuratan->get_n_eselon($surat->ess2); ?>
          </div>
        </div>
  
        <div id="statusMain">
          <div id="leftMain">
            <?php echo "<b>". form_label('Eselon 3', 'ess3') . "</b>"; ?>
          </div>
          <div id="rightMain">
            <?php echo $this->m_persuratan->get_n_eselon($surat->ess3); ?>
          </div>
        </div>
  
        <div id="statusMain">
          <div id="leftMain" class="bg-grid">
            <?php echo "<b>". form_label('Eselon 4', 'ess4') . "</b>"; ?>
          </div>
          <div id="rightMain" class="bg-grid">
            <?php echo $this->m_persuratan->get_n_eselon($surat->ess4); ?>
          </div>
        </div>
  
        <div id="statusMain">
          <div id="leftMain">
            <?php echo "<b>". form_label('Tanggal Entri', 'tgl_entri') . "</b>"; ?>
          </div>
          <div id="rightMain">
            <?php echo $surat->tgl_entry; ?>
          </div>
        </div>
                
        <div id="statusMain">
          <div id="leftMain" class="bg-grid">
            <?php echo "<b>". form_label('Sifat Surat', 'sifat_surat') . "</b>"; ?>
          </div>
          <div id="rightMain" class="bg-grid">
            <?php echo $surat->sifat_surat; ?>
          </div>
        </div>
                
        <div id="statusMain">
          <div id="leftMain">
            <?php echo "<b>". form_label('Lampiran', 'lampiran') . "</b>"; ?>
          </div>
          <div id="rightMain">
            <?php echo $surat->lampiran; ?>
          </div>
        </div>
        
        <div id="statusMain">
          <div id="leftMain" class="bg-grid">
            <?php echo "<b>". form_label('Hal', 'hal') . "</b>"; ?>
          </div>
          <div id="rightMain" class="bg-grid">
            <?php echo $surat->hal; ?>
          </div>
        </div>
        
        <div id="statusMain">
          <div id="leftMain">
            <?php echo "<b>". form_label('Kepada', 'kepada') . "</b>"; ?>
          </div>
          <div id="rightMain">
            <?php echo $surat->kepada; ?>
          </div>
        </div>

        <div id="statusMain">
          <div id="leftMain" class="bg-grid">
            <?php echo "<b>". form_label('Preview Surat', 'surat_prev') . "</b>"; ?>
          </div>
          <div id="rightMain" class="bg-grid">
            <?php 
              if (file_exists('assets/docx-surat/SRT_'.$surat->id.'.docx')) {
                echo "<a href='".base_url()."persuratan/unduh_docx/".$surat->id."' style='color:blue;' target='_blank' title='Unduh Berkas'>Lihat Surat</a>&nbsp;";
              }
            ?>
          </div>
        </div>

        <div id="statusMain">
          <h2>
            <div id="leftMain">
              <?php
              echo "<b>". form_label('Tanggal Surat', 'tgl_surat') . "</b>";
              ?>
            </div>
            <div id="rightMain">
              <?php
              $tglsk_input = array('name' => 'tgl_surat',
                          'value' => ((!empty($surat->tgl_surat)) ? $surat->tgl_surat : date("Y-m-d")),
                          'class' => 'input-wrc',
                          'readOnly'=>TRUE,
                          'class' => 'monbulan'
                         );
                echo form_input($tglsk_input);
              ?>
            </div>
          </h2>
        </div>  
                
        <div id="statusMain">
          <h2>
            <div id="leftMain">
              <?php echo "<b>". form_label('Nomor Surat ', 'no_surat') . "</b>"; ?>
            </div>
            <div id="rightMain">
              <?php
              $nosk_input = array('name' => 'no_surat',
                                  'id' => 'no_surat',
                                  'value' => (!empty($surat->nomor_surat) ? $surat->nomor_surat : ""),
                                  'class' => 'input-wrc required'
                                 );

              echo form_input($nosk_input);
              $simpan = 'Simpan';
              ?>
            </div>
          </h2>
        </div>

        <div class="entry" style="text-align: center;">
        <br>
        <br>   
        </div>

              
        <div class="entry" style="text-align: center;">
          <?php
  			  $batal = 'Batal';
  			  $set_no_izin = array('name' => 'button',
                               'class' => 'button-wrc',
                               'content' => 'Seting Nomor Izin',
                               'value' => 'Simpan'
                               );
          echo "<span></span>";
  
          echo "<span></span>";
  
          $cancel_daftar = array('name' => 'button',
                                 'class' => 'button-wrc',
                                 'content' => $batal,
                                 'onclick' => 'parent.location=\''. site_url('permohonan/penetapan/index') . '\''     // OLD index_next
                                );

          echo form_submit($set_no_izin);
          echo form_button($cancel_daftar);
          echo form_close();
          ?>
        </div>
      </fieldset>
    </div>
    <br style="clear: both;" />
  </div>
</div>