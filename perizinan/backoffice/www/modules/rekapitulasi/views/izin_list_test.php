<div id="content">
  <div class="post">
    <div class="title">
      <h2><?php echo $page_name; ?></h2>
    </div>
    <div class="entry">
          <fieldset id="half">
            <legend>Daftar Per Periode</legend>
            <?php 
            echo form_open('rekapitulasi/izin/rekaplist');
                    
            //$asal_permohonan = array('0' => '------ Seluruhnya ------','Pusat' => 'Pusat'); // Untuk daerah lain
            $asal_permohonan = array('0' => '-------- Seluruhnya --------','BPPT Prov. tasikmalaya' => 'BPPT Prov. tasikmalaya','BPMPT Prov. tasikmalaya' => 'BPMPT Prov. tasikmalaya',
                                     'DPMPTSP Prov. tasikmalaya' => 'DPMPTSP Prov. tasikmalaya','Gerai Bogor' => "Gerai Bogor",'Gerai Purwakarta' => 'Gerai Purwakarta',
                                     'Gerai Garut' => "Gerai Garut",'Gerai Cirebon' => "Gerai Cirebon",'SMS' => "SMS",'Surat' => "Surat",'OnLine' => "OnLine");
            ?>
            <div id="statusRail">
              <div id="leftRail"> 
                <?php 
                echo form_label('Asal Permohonan', 'label_permohonan');
                echo form_hidden('mark', 'tanda');
                ?>
              </div>
              <div id="rightRail"> <?php
                if($mark == "tanda") {
                  echo form_dropdown('list_state', $asal_permohonan, $list_state, 'class = "input-select-wrc" id="selector"');
                }else{
                  echo form_dropdown('list_state', $asal_permohonan, '0', 'class = "input-select-wrc" id="selector"');
                }
                ?>
              </div>
            </div>
            
            <div style="clear: both" ></div>
            <div id="statusRail">
              <div id="leftRail">
                <?php
                echo form_label('Pilih Katagori');
                ?>
              </div>
              <div id="rightRail">
                <?php
                echo form_dropdown('list_kat', $kat_cari, $list_kat, 'class = "input-select-wrc" id="katagori_id"');
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
                                           'value' => (!empty($tgla) ? $tgla : $this->lib_date->set_date(date('Y-m-d'), -2)),
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
                                            'value' => (!empty($tglb) ? $tglb : $this->lib_date->set_date(date('Y-m-d'), 0)),
                                            'class' => 'input-wrc',
                                            'readOnly'=>TRUE,
                                            'class' => 'monbulan'
                                           );
                echo form_input($periodeakhir_input);
                ?>
              </div>
            </div>
            
            <div id="statusRail">
              <div id="rightRail">
                <?php
                $filter_data = array('name' => 'button',
                                     'class' => 'button-wrc',
                                     'content' => 'Filter',
                                     'value' => 'Filter'
                                    );
                $reset_data = array('name' => 'button',
                                    'content' => 'Reset Filter',
                                    'value' => 'Reset Filter',
                                    'class' => 'button-wrc',
                                    'onclick' => 'parent.location=\''. site_url('rekapitulasi/izin') . '\''
                                );
                echo form_submit($filter_data);
                echo form_button($reset_data);
                ?>
              </div>
            </div>
            <?php
            echo form_close();
            ?>
          </fieldset>
          <br>
        </div>
  </div>
  <br style="clear: both;" />
</div>
