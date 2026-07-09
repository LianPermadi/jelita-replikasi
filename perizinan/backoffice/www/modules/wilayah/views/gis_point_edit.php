<div id="content">
    <div class="post">
        <div class="title">
            <h2><?php echo $page_name; ?></h2>
        </div>
        <?php
        $attr = array('id' => 'form');
        echo form_open('wilayah/gis/' . $save_method, $attr);
        echo form_hidden('id', $id);
        echo form_hidden('kode', $kode);
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
                                    'name' => 'judul',
                                    'value' => $judul,
                                    'class' => 'input-wrc required'
                                );
                                echo form_label('Judul');
                                echo form_input($nama_input);                                
                                ?>
                        </div>
                        <div class="contentForm">
                            <?php echo form_label('Maps'); ?>
                            <div id="map_div" style="height: 300px;"></div>
                        </div>
                        <div class="contentForm">
                            <?php
                               $nama_input = array(
                                    'name' => 'lon_point',
                                    'value' => $lon_point,
                                    'id'    => 'maps_longitude',
                                    'class' => 'input-wrc required'
                                );
                                echo form_label('Longitude');
                                echo form_input($nama_input); 
                                ?>
                        </div>
                        <div class="contentForm">
                            <?php
                               $nama_input = array(
                                    'name' => 'lat_point',
                                    'value' => $lat_point,
                                    'id'    => 'maps_latitude',
                                    'class' => 'input-wrc required'
                                );
                                echo form_label('Latitude');
                                echo form_input($nama_input);
                                echo br(4);                              
                                ?>
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
                'content' => ($save_method == 'save_point' ? 'Simpan' : 'Update'),
                'type' => 'submit',
                'value' => ($save_method == 'save_point' ? 'Simpan' : 'Update')
            );
            echo form_submit($add_daftar);
            echo "<span></span>";
            $cancel_daftar = array(
                'name' => 'button',
                'class' => 'button-wrc',
                'content' => 'Batal',
                'onclick' => 'parent.location=\''. site_url('wilayah/gis/list_point') . '/' . $id . '\''
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
