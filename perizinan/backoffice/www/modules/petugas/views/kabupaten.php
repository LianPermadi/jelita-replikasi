<div id="content">
    <div class="post">
        <div class="title">
            <h2><?php echo $page_name; ?></h2>
        </div>
        <div class="entry">
            <?php
            $dataproperti=array('name'=>'frmperan','id'=>'frmperan');
            echo form_open('petugas/flush',$dataproperti);
            echo form_hidden('id', $id);
            //echo form_hidden('backto', $backto);
            //$checked = FALSE;
            ?>

            <ul id="data_list">
                <li><label>Nama Pegawai</label></li>
                <li><label><b><?php echo $real_name; ?></b></label></li>
            </ul>
            <br style="clear: both;"/>
            <br/>
            <!-- <ul id="data_list">
                <li><label>Username</label></li>
                <li><label><b><?php //echo $user_name; ?></b></label></li>
            </ul> -->
            <br/><br/><br/>
            <div id="tabs">
                <ul>
                    <?php
                        echo "<li><a href='#tabs-1'>Lokasi Kabupaten</a></li>";
                echo "</ul>";
                    ?>                
                    <div id="tabs-1">
                        <ul id="data_list">
                            <li><a href='#' style="color: #00C632;font-size: 12px;font-style: italic;" onClick='check_uncheckAll(document.frmperan.peran,true);return false;'>Check All</a>&nbsp;&nbsp;&nbsp;<a href='#' style="color: #00C632;font-size: 12px;font-style: italic;"  onClick='check_uncheckAll(document.frmperan.peran,false);return false;'>Uncheck All</a>
					    	</li>
                            <?php
                            foreach ($list as $data) {
                                $showed = TRUE;
                            ?>
                                <li>
                                    <?php
                                    foreach ($kabupaten as $kab) {
                                        if($kab === $data->id) {
                                            $showed = FALSE;
                                            break;
                                        }
                                    }
                                    if($showed) {
                                        $set = array( 
                                            'name' => 'kabupaten[]','id' =>'peran','value' => $data->id
                                        );
                                        echo form_checkbox($set);
                                        echo $data->n_kabupaten;
                                    }
                                    ?>
                                </li>
                                <?php
                            }
                                ?>
                        </ul>
                    </div>
            </div>            
            <div style="clear:both;"/>
                <div class="spacer"></div>
                <br />
                <?php
                $add_user = array(
                    'name' => 'submit',
                    'class' => 'submit-wrc',
                    'content' => 'Simpan',
                    'type' => 'submit',
                    'value' => 'Simpan'
                );
                echo form_submit($add_user);
                echo "<span></span>";
                $alamaturl="";
                if($this->uri->segment(4)=="yes") {
                    $url=site_url('petugas');
                } else {
                    $url=site_url('petugas/edit/'.$id);
                }
                $cancel = array(
                    'name' => 'button',
                    'class' => 'button-wrc',
                    'content' => 'Batal',
                    'onclick' => 'parent.location=\'' . $url . '\''
                );
                echo form_button($cancel);
                echo form_close();
                ?>
            </div>
        </div>
    <br style="clear: both;" />
</div>
