<div id="content">
    <div class="post">
        <div class="title">
            <h2><?php echo $page_name; ?></h2>
        </div>
        <div class="entry">
            <?php
                if($method !== 'editing') {
                    ?>

            <div id="tabs">
                <ul>
                    <li><a href="#tabs-2">Tambah Mengingat SK Baru</a></li>
                </ul>
                <div id="tabs-2">
                    <?php
                    $attr = array('id' => 'form');
                    echo form_open_multipart('mengingat/' . $save_method,$attr);
                    echo form_hidden('id_izin', $id_izin);
                    ?>
                    <br style="clear: both" />
<!--- ALI -->                    
                    <label class="label-wrc">Jenis</label>
                        <select name="jenis" class="input-wrc required" style="min-width:200pt;">
                            <option value="0*" selected>-</option>
                            <option value="1*Undang-undang Republik Indonesia">Undang-undang</option>
                            <option value="2*Peraturan Pemerintah Republik Indonesia">Peraturan Pemerintah</option>
                            <option value="3*Peraturan Presiden Republik Indonesia">Peraturan Presiden</option>
                            <option value="4*Peraturan Presiden Republik Indonesia">Ketetapan Presiden</option>
                            <option value="5*Peraturan Presiden Republik Indonesia">Instruksi Presiden</option>
                            <option value="6*Peraturan Mentri">Peraturan Mentri</option>
                            <option value="7*Peraturan Daerah Kabupaten Tasikmalaya">Peraturan Daerah</option>
                            <option value="8*Peraturan Gubernur Tasikmalaya">Peraturan Gubernur</option>
                        </select>
                    <br style="clear: both" />                    
                    <label class="label-wrc">Nomor</label>
                        <?php 
                        $nomor = array(
                            'name' => 'nomor',
                            'class' =>'input-wrc required',
                            'style' => 'width:400pt'
                        );
                        echo form_input($nomor);
                        ?>
                    <br style="clear: both" />
                    <label class="label-wrc">Tahun</label>
                        <?php 
                        $tahun = array(
                            'name' => 'tahun',
                            'class' =>'input-wrc required',
                            'style' => 'min-width:400pt'
                        );
                        echo form_input($tahun);
                        ?>
                    <br style="clear: both" />
                    <label class="label-wrc">Tentang</label>
                        <?php 
                        $tentang = array(
                            'name' => 'tentang',
                            'class' =>'input-wrc required',
                            'style' => 'min-width:400pt'
                        );
                        echo form_input($tentang);
                        ?>
                    <br style="clear: both" />
                    <label class="label-wrc">Tambahan</label>
                        <?php 
                        $tambahan = array(
                            'name' => 'tambahan',
                            'class' =>'input-area-wrc',
                            'style' => 'min-width:400pt'
                        );
                        echo form_textarea($tambahan);
                        ?>                        
                    <br style="clear: both" />
                    <label class="label-wrc">File</label>
<!--                         <?php 
                        $file = array(
                            'name' => 'fileToUpload',
                            'id' => 'fileToUpload',
                            'type' => 'file',
                            'class' =>'input-wrc',
                            'style' => 'min-width:400pt'
                        );
                        echo form_input($file);
                        ?>    --> 
                    <input type="file" name="fileToUpload" id="fileToUpload" class="input-wrc" value="Pilih file" style="min-width:190pt;">                        
                    <br style="clear: both" />                                         
<!--- ALI -->                                                        
                    <label class="label-wrc">Status</label>
                        <?php
                            $status = "<input type=\"radio\" name=\"status\" ";
                            $status_0 = "value=\"0\"";
                            $status_1 = "value=\"1\"";
                            if ($status_cont === '0') {
                                echo $status . $status_0 . "checked=\"checked\" />";
                                echo "SK";
                                echo $status . $status_1 . " />";
                                echo "SKRD";
                            } else {
                                echo $status . $status_0 . " />";
                                echo "SK";
                                echo $status . $status_1 . "checked=\"checked\" />";
                                echo "SKRD ";
                            }
                        ?>
                    <br style="clear: both;" />
                    <?php
                    $add = array(
                        'name' => 'submit',
                        'class' => 'submit-wrc',
                        'content' => 'Simpan',
                        'type' => 'submit',
                        'value' => 'Simpan'
                    );
                    echo form_submit($add);
                    echo "<span></span>";
                    $cancel_role = array(
                        'name' => 'button',
                        'class' => 'button-wrc',
                        'content' => 'Batal',
                        'onclick' => 'parent.location=\''. site_url('mengingat/detail') . "/" . $id_izin . '\''
                    );
                    echo form_button($cancel_role);
                    echo form_close();
                    echo form_close();
                    ?>
                </div>
            </div>

                    <?php
                } else {
                    ?>
            <div id="tabs">
                <ul>
                    <li><a href="#tabs-1">Edit Mengingat SK Baru</a></li>
                </ul>
                <div id="tabs-1">
                    <?php
                    $attr = array('id' => 'form');
                    echo form_open_multipart('mengingat/' . $save_method,$attr);
                    echo form_hidden('id_izin', $id_izin);
                    echo form_hidden('id_dasar_hukum', $id_dasar_hukum);
                    ?>
                    <br style="clear: both" />
<!--- ALI -->                    
                    <label class="label-wrc">Jenis</label>
                        <select name="jenis" class="input-wrc required" style="min-width:200pt;">
                            <option value="0*" selected>-</option>
                            <option value="1*Undang-undang Republik Indonesia" <?php if($jenis=="1*Undang-undang Republik Indonesia"){echo "selected";} ?>>Undang-undang</option>
                            <option value="2*Peraturan Pemerintah Republik Indonesia" <?=($jenis == "2*Peraturan Pemerintah Republik Indonesia")?'selected':'';?>>Peraturan Pemerintah</option>
                            <option value="3*Peraturan Presiden Republik Indonesia" <?=($jenis == "3*Peraturan Presiden Republik Indonesia")?'selected':'';?>>Peraturan Presiden</option>
                            <option value="4*Peraturan Presiden Republik Indonesia" <?=($jenis == "4*Peraturan Presiden Republik Indonesia")?'selected':'';?>>Ketetapan Presiden</option>
                            <option value="5*Peraturan Presiden Republik Indonesia" <?=($jenis == "5*Peraturan Presiden Republik Indonesia")?'selected':'';?>>Instruksi Presiden</option>
                            <option value="6*Peraturan Mentri" <?=($jenis == "6*Peraturan Mentri")?'selected':'';?>>Peraturan Mentri</option>
                            <option value="7*Peraturan Daerah Kabupaten Tasikmalaya" <?=($jenis == "7*Peraturan Daerah Kabupaten Tasikmalaya")?'selected':'';?>>Peraturan Daerah</option>
                            <option value="8*Peraturan Gubernur Tasikmalaya" <?=($jenis == "8*Peraturan Gubernur Tasikmalaya")?'selected':'';?>>Peraturan Gubernur</option>
                        </select>
                    <br style="clear: both" />                    
                    <label class="label-wrc">Nomor</label>
                        <?php 
                        $nomor = array(
                            'name' => 'nomor',
                            'value' => $nomor,
                            'class' =>'input-wrc required',
                            'style' => 'width:400pt'
                        );
                        echo form_input($nomor);
                        ?>
                    <br style="clear: both" />
                    <label class="label-wrc">Tahun</label>
                        <?php 
                        $tahun = array(
                            'name' => 'tahun',
                            'value' => $tahun,
                            'class' =>'input-wrc required',
                            'style' => 'min-width:400pt'
                        );
                        echo form_input($tahun);
                        ?>
                    <br style="clear: both" />
                    <label class="label-wrc">Tentang</label>
                        <?php 
                        $tentang = array(
                            'name' => 'tentang',
                            'value' => $tentang,
                            'class' =>'input-wrc required',
                            'style' => 'min-width:400pt'
                        );
                        echo form_input($tentang);
                        ?>
                    <br style="clear: both" />
                    <label class="label-wrc">Tambahan</label>
                        <?php 
                        $tambahan = array(
                            'name' => 'tambahan',
                            'value' => $tambahan,
                            'class' =>'input-area-wrc',
                            'style' => 'min-width:400pt'
                        );
                        echo form_textarea($tambahan);
                        ?>
                    <br style="clear: both" />                    
                    <label class="label-wrc">File</label>
<!--                         <?php 
                        $file = array(
                            'name' => 'fileToUpload',
                            'id' => 'fileToUpload',
                            'value' => $file,
                            'type' => 'file',
                            'class' =>'input-wrc',
                            'style' => 'min-width:400pt'
                        );
                        echo form_input($file);
                        ?>   -->  
                    <input type="file" name="fileToUpload" id="fileToUpload" class="input-wrc" value="Pilih  File" style="min-width:190pt;">                                       
<!--- ALI -->      
                    <br style="clear: both" />                   
                    <label class="label-wrc">Status</label>
                    <?php
                        $status = "<input type=\"radio\" name=\"status\" ";
                        $status_0 = "value=\"0\"";
                        $status_1 = "value=\"1\"";
                        if ($status_cont === '0') {
                            echo $status . $status_0 . "checked=\"checked\" />";
                            echo "SK";
                            echo $status . $status_1 . " />";
                            echo "SKRD";
                        } else {
                            echo $status . $status_0 . " />";
                            echo "Surat Izin ";
                            echo $status . $status_1 . "checked=\"checked\" />";
                            echo "SKRD ";
                        }
                    ?>
                    <br style="clear: both;" />
                    <?php
                    $add = array(
                        'name' => 'submit',
                        'class' => 'submit-wrc',
                        'content' => 'Simpan',
                        'type' => 'submit',
                        'value' => 'Simpan'
                    );
                    echo form_submit($add);
                    echo "<span></span>";
                    $cancel_role = array(
                        'name' => 'button',
                        'class' => 'button-wrc',
                        'content' => 'Batal',
                        'onclick' => 'parent.location=\''. site_url('mengingat/detail') . "/" . $id_izin . '\''
                    );
                    echo form_button($cancel_role);
                    echo form_close();
                    echo form_close();
                    ?>
                </div>
            </div>
                    <?php
                }
            ?>
        </div>
    </div>
    <br style="clear: both;" />
</div>
