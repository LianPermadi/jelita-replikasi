<div id="content">
    <div class="post">
        <div class="title">
            <h2><?php echo $page_name; ?></h2>
        </div>
        <?php
        $attr = array('id' => 'form');
        echo form_open('perusahaan/investasi/' . $save_method, $attr);
        echo form_hidden('id', $id);
        ?>
        <div class="entry">
            <div id="tabs">
                <ul>
                    <li><a href="#tabs-1">Data Investasi</a></li>
                </ul>
                <div id="tabs-1">
                    <div id="contentleft">
                        <div class="contentForm">
                            <?php
                                $nama_input = array(
                                    'name' => 'nama',
                                    'value' => $nama,
                                    'class' => 'input-wrc required'
                                );
                                echo form_label('Nama Jenis Investasi');
                                echo form_input($nama_input);
                            ?>
                        </div>
                        <div class="contentForm">
                                <?php
                                $desc_input = array(
                                    'name' => 'keterangan',
                                    'value' => $keterangan,
                                    'class' => 'input-area-wrc required'
                                );
                                echo form_label('Keterangan');
                                echo form_textarea($desc_input);
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
                'content' => 'Simpan',
                'type' => 'submit',
                'value' => 'Simpan'
            );
            echo form_submit($add_daftar);
            echo "<span></span>";
            $cancel_daftar = array(
                'name' => 'button',
                'class' => 'button-wrc',
                'content' => 'Batal',
                'onclick' => 'parent.location=\''. site_url('perusahaan/investasi') . '\''
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
