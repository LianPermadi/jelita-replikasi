<div id="content">
  <div class="post">
    <div class="title">
      <h2><?php echo $page_name; ?></h2>
    </div>
    <div class="entry">
      <?php
      $attr = array('id' => 'form');
      echo form_open('unitkerja/' . $save_method,$attr);
      echo form_hidden('id', $id);
      ?>
      <div class="contentForm">
        <label class="label-wrc">Unit Kerja</label>
           <?php
          $n_unitkerja_input = array('name' => 'n_unitkerja',
                                     'value' => $n_unitkerja,
                                     'class' => 'input-wrc required');
          echo form_textarea($n_unitkerja_input);
          ?>
      </div>
      <br style="clear: both;"/>
      
      <div class="contentForm">
        <label class="label-wrc">Upload File Cap (.PNG 250x250 px)</label>
        <?php
        if($nm_cap == ''){
          echo anchor(site_url('unitkerja/showform/'.$id), 'Upload File', 'class="link-wrc" rel="upload_box"')."&nbsp;";
        }else{
          echo $nm_cap .' '. anchor(site_url('unitkerja/showform/'.$id), 'Perbaiki Cap Dinas', 'class="link-wrc" rel="upload_box"')."&nbsp;";
        }
        ?>
      </div>
      <br style="clear: both;"/>
      
      <div class="contentForm">
        <label class="label-wrc">Bentuk Cap Dinas</label>
        <?php
        $img_edit = array('src' => 'uploads/logo/'.$nm_cap,
                          'height' => '10%',
                          'width' => '10%',
                          'border' => '0');
        echo img($img_edit);               
        ?>
      </div>
      <br style="clear: both;"/>
      
      <br style="clear: both;"/>
      <br style="clear: both;"/>
      <div id="statusRail">
        <div id="leftRail">
        </div>
        <div id="rightRail">
          <?php
          $add_role = array('name' => 'submit',
                            'class' => 'submit-wrc',
                            'content' => 'Simpan',
                            'type' => 'submit',
                            'value' => 'Simpan');
          echo form_submit($add_role);
          echo "<span></span>";
          $cancel_role = array('name' => 'button',
                               'class' => 'button-wrc',
                               'content' => 'Batal',
                               'onclick' => 'parent.location=\''. site_url('unitkerja') . '\'');
          echo form_button($cancel_role);
          echo form_close();
          ?>
        </div>
      </div>
      <br />
      <label>&nbsp;</label>
      <div class="spacer"></div>
      </div>
  </div>
  <br style="clear: both;" />
</div>