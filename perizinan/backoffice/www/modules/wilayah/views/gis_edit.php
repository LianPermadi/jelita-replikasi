<div id="content">
    <div class="post">
        <div class="title">
            <h2><?php echo $page_name; ?></h2>
        </div>
        <?php
        $attr = array('id' => 'form');
        echo form_open('wilayah/gis/' . $save_method, $attr);
        echo form_hidden('id', $id);
        ?>
        <div class="entry">
            <div id="tabs">
                <ul>
                    <li><a href="#tabs-1">Data Kategori</a></li>
                </ul>
                <div id="tabs-1">
                    <div id="contentleft">
                        <div class="contentForm">
                            <?php
                               $nama_input = array(
                                    'name' => 'nama_gis',
                                    'value' => $nama,
                                    'class' => 'input-wrc required'
                                );
                                echo form_label('Nama');
                                echo form_input($nama_input);                                
                                ?>
                        </div>
                        <div class="contentForm">
                            <?php
                               $nama_input = array(
                                    'name' => 'warna_gis',
                                    'value' => $warna,
                                    'class' => 'input-wrc required'
                                );
                                echo form_label('Warna');
                                echo form_input($nama_input);
                                echo br(4);                              
                                ?>
                        </div>   
                        <div class="contentForm" style="padding-left: 145px">
                                       
                        </div>
                    </div>
                    <div id="contentright">
              
                    </div>
                    <br style="clear: both;" />
                </div>
            </div>
            <br>
            <?php
            $add_daftar = array(
                'name' => 'submit',
                'class' => 'submit-wrc',
                'content' => ($save_method == 'save' ? 'Simpan' : 'Update'),
                'type' => 'submit',
                'value' => ($save_method == 'save' ? 'Simpan' : 'Update')
            );
            echo form_submit($add_daftar);
            echo "<span></span>";
            $cancel_daftar = array(
                'name' => 'button',
                'class' => 'button-wrc',
                'content' => 'Batal',
                'onclick' => 'parent.location=\''. site_url('wilayah/gis') . '\''
            );
            echo form_button($cancel_daftar);
            echo form_close();
            ?>
        </div>
        <div class="entry" style="text-align: center;">
           
        </div>
    </div>
    <br style="clear: both;" />
</div>
