<div id="content">
    <div class="post">
        <div class="title">
            <h2><?php echo $page_name; ?></h2>
        </div>
        <div class="entry">
            <div id="tabs">
                <ul>
                    <li><a href="#tabs-1"><b>Hari Libur Sabtu Minggu</b></a></li>
                </ul>
                <div id="tabs-1">
                    <?php
                    $attr = array('id' => 'form');
                    echo form_open('holiday/' . $save_method, $attr);
                    echo form_hidden('id', $id);

                    $In_kd_kontak = array(
                        'name'  => 'kd_kontak',
                        'value' => $kd_kontak,
                        'class' => 'input-wrc required'
                    );
                    echo '<b>' . form_label('Tahun').'</b>';
                    echo form_input($In_kd_kontak);
                    echo form_error('kd_kontak', '<div class="field_error">', '</div>');
                    ?>
                    <br style='clear: both'/>
                </div>
            </div>
            <br>
            <?php
            $add_user = array(
                'name' => 'submit',
                'class' => 'submit-wrc',
                'content' => 'Proses',
                'type' => 'submit',
                'value' => 'Proses'
            );
            echo form_submit($add_user);

            echo "<span></span>";
            $cancel = array(
                'name' => 'button',
                'class' => 'button-wrc',
                'content' => 'Batal',
                'onclick' => 'parent.location=\'' . site_url('holiday') . '\''
            );
            echo form_button($cancel);
            echo "<span></span>";

            echo form_close();
            ?>
        </div>
    </div>
    <br style="clear: both;" />
</div>