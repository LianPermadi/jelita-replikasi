<script>
    //edited by mucktar
    function cekstatuscheckbox(frmchk) {
        var chk=document.getElementById("chk"+frmchk);
        if(chk.checked == true) {
                document.getElementById("subchk1"+frmchk).disabled="";   
                document.getElementById("subchk2"+frmchk).disabled="";   
                document.getElementById("subchk3"+frmchk).disabled="";
                document.getElementById("subchk4"+frmchk).disabled="";
                document.getElementById("subcmb"+frmchk).disabled="";
                document.getElementById("inputtxt1"+frmchk).disabled="";
                document.getElementById("input_parent"+frmchk).disabled="";
                document.getElementById("satuan"+frmchk).disabled="";
        } else {
                document.getElementById("subchk1"+frmchk).disabled="disabled";   
                document.getElementById("subchk2"+frmchk).disabled="disabled";   
                document.getElementById("subchk3"+frmchk).disabled="disabled";
                document.getElementById("subchk4"+frmchk).disabled="disabled";
                document.getElementById("subcmb"+frmchk).disabled="disabled";
                document.getElementById("inputtxt1"+frmchk).disabled="disabled";
                document.getElementById("subchk1"+frmchk).checked=false;   
                document.getElementById("subchk2"+frmchk).checked=false;   
                document.getElementById("subchk3"+frmchk).checked=false;
                document.getElementById("subchk4"+frmchk).checked=false;
                document.getElementById("subcmb"+frmchk).value="";
                document.getElementById("inputtxt1"+frmchk).value="";
                document.getElementById("input_parent"+frmchk).disabled="disabled";
                document.getElementById("satuan"+frmchk).disabled="disabled";
        }
    }
</script>
<div id="content">
    <div class="post">
        <div class="title">
            <h2><?php echo $page_name; ?></h2>
        </div>
        <div class="entry">
            <?php
            if ($method !== 'editing') {
            ?>
                <div id="tabs">
                    <ul>
                        <li><a href="#tabs-1">Tambah Property Baru</a></li>
                    </ul>
                    <div id="tabs-1">
                        <?php
                        $attr = array('id' => 'form');
                        echo form_open('property/master/save_property',$attr);
                        echo form_hidden('id_izin', $id_izin);
                        echo form_hidden('id_property', $id_property);
						echo form_hidden('combo_item', $combo_item);
                        echo form_hidden('c_aktif', $c_aktif);
						echo form_hidden('stat_in', 'Add');
						//echo form_hidden('no_field', $no_field);
                        ?>
                        <fieldset>

                            <div id="statusMain">
                                <div id="leftMain">
                                    <label class="label-wrc">Nama Property</label>
                                </div>
                                <div id="rightMain">
                                    <?php
                                    $user_name_input = array(
                                        'name' => 'n_property',
                                        'value' => $n_property,
                                        'class' => 'input-wrc required',
                                        'id' => 'property_name',                                
                                        'style' => 'min-width:400pt'
                                    );
                                    echo form_input($user_name_input);
                                    ?>
                                </div>
                            </div>

                            <div id="statusMain">
                                <div id="leftMain" class="bg-grid" style="min-height: 27pt;">
                                    <label class="label-wrc">Kategori</label>
                                </div>
                                <div id="rightMain" class="bg-grid">
                                    <select name="c_parent" class="input-select-wrc">
                                        <option value="" selected="selected">---------Pilih salah satu---------</option>
                                        <?php
                                        $selected = NULL;
                                        foreach ($property_list2 as $property_data) {
                                            //edited 08-04-2013
                                            /*
                                            if (strval($property_data->id) === strval($c_parent)) {
                                                $selected = ' selected="selected" ';
                                            } else {
                                                $selected = null;
                                            }*/
                                            echo "<option value=\"" . $property_data->n_property . "\"" . $selected . ">"
                                                . $property_data->n_property . "</option>\n" ;
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div id="statusMain">
                                <div id="leftMain">
                                    <label class="label-wrc">Urutan Parent</label>
                                </div>
                                <div id="rightMain">
                                    <?php
                                    $parent_order_input = array(
                                        'name' => 'c_parent_order',
                                        'value' => $c_parent_order,
                                        'class' => 'input-wrc required digits',
                                        'id' => 'c_parent_order'
                                    );
                                    echo form_input($parent_order_input);
                                    ?>
                                </div>
                            </div>

                            <div id="statusMain">
                                <div id="leftMain" class="bg-grid" style="min-height: 22pt">
                                    <label class="label-wrc">Urutan</label>
                                </div>
                                <div id="rightMain" class="bg-grid">
                                    <?php
                                    $order_input = array(
                                        'name' => 'c_order',
                                        'value' => $c_order,
                                        'class' => 'input-wrc required digits',
                                        'id' => 'c_order'
                                    );
                                    echo form_input($order_input);
                                    ?>
                                </div>
                            </div>

                            <div id="statusMain">
                                <div id="leftMain">
                                    <label class="label-wrc">Kode Retribusi</label>
                                </div>
                                <div id="rightMain">
                                    <?php
                                    $data_0 = array(
                                        'name' => 'c_retribusi',
                                        'type' => 'radio',
                                        'checked'=>TRUE,
                                        'value'=> 'Tidak'
                                    );
                                    $data_1 = array(
                                        'name' => 'c_retribusi',
                                        'type' => 'radio',
                                        'value'=> 'Ada'
                                    );
                                    echo form_checkbox($data_0); echo "Tidak";
                                    echo form_checkbox($data_1); echo "Ada";
                                    ?>
                                </div>
                            </div>

                            <div id="statusMain">
                                <div id="leftMain" class="bg-grid">
                                    <label class="label-wrc">Tampilkan di Surat Izin</label>
                                </div>
                                <div id="rightMain" class="bg-grid">
                                    <?php
                                    $data_0a = array(
                                        'name' => 'c_sk_id',
                                        'type' => 'radio',
                                        'checked'=>TRUE,
                                        'value'=> 'Tidak'
                                    );
                                    $data_1a = array(
                                        'name' => 'c_sk_id',
                                        'type' => 'radio',
                                        'value'=> 'Ya'
                                    );
                                    echo form_checkbox($data_0a); echo "Tidak";
                                    echo form_checkbox($data_1a); echo "Ya";
                                    ?>
                                </div>
                            </div>

                            <div id="statusMain">
                                <div id="leftMain">
                                    <label class="label-wrc">Tampilkan di SKRD</label>
                                </div>
                                <div id="rightMain">
                                    <?php
                                    $data_0ab = array(
                                        'name' => 'c_skrd_id',
                                        'type' => 'radio',
                                        'checked'=>TRUE,
                                        'value'=> 'Tidak'
                                    );
                                    $data_1ab = array(
                                        'name' => 'c_skrd_id',
                                        'type' => 'radio',
                                        'value'=> 'Ya'
                                    );
                                    echo form_checkbox($data_0ab); echo "Tidak";
                                    echo form_checkbox($data_1ab); echo "Ya";
                                    ?>
                                </div>
                            </div>

                            <div id="statusMain">
                                <div id="leftMain" class="bg-grid">
                                    <b>Tampilkan di Tinjauan Lapangan/BAP</b>
                                </div>
                                <div id="rightMain" class="bg-grid">
                                    <?php
                                    $data_0b = array(
                                        'name' => 'c_tl_id',
                                        'type' => 'radio',
                                        'checked'=>TRUE,
                                        'value' => 'Tidak'
                                    );
                                    $data_1b = array(
                                        'name' => 'c_tl_id',
                                        'type' => 'radio',
                                        'value' => 'Ya'
                                    );
                                    echo form_checkbox($data_0b); echo "Tidak";
                                    echo form_checkbox($data_1b); echo "Ya";
                                    ?>
                                </div>
                            </div>

                            <div id="statusMain">
                                <div id="leftMain">
                                    <label class="label-wrc">Tipe Property</label>
                                </div>
                                <div id="rightMain">
                                    <?php
                                    $arr = array(
                                        'TextBox' => 'TextBox',                              // 0
							            'Integer' => 'Integer',
                                        'ComboBox' => 'ComboBox',                            // 1
                                        'Tanggal' => 'Tanggal'                               // 4
//                                        '2' => 'Tanggal',
//                                        '3' => 'Boolean'
                                    );
                                    echo form_dropdown('c_type', $arr,'0', 'class="input-select-wrc"');
                                    ?>
                                </div>
                            </div>
                   
                            <div id="statusMain">
                                <div id="leftMain">
                                </div>
                                <div id="rightMain">
                                    <?php
                                    $add_property = array(
                                        'name' => 'submit',
                                        'class' => 'submit-wrc',
                                        'content' => 'Simpan',
                                        'type' => 'submit',
                                        'value' => 'Simpan'
                                    );
                                    echo form_submit($add_property);
                                    echo "<span></span>";
                                    $cancel = array(
                                        'name' => 'button',
                                        'class' => 'button-wrc',
                                        'content' => 'Batal',
//                                        'onclick' => 'parent.location=\''. site_url('property/master/detail') . "/" . $id_izin . '\''
									    'onclick' => 'parent.location=\''. site_url('property/master') . '\''
                                    );
                                    echo form_button($cancel);
                                    echo form_close();
                                    ?>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </div>
                <?php

            } else {       // mulai tampil di edit

                $attr = array('id' => 'form');
                echo form_open('property/master/save_property',$attr);
                echo form_hidden('id_izin', $id_izin);
                echo form_hidden('id_property', $id_property);
                echo form_hidden('c_parent', $c_parent);
				echo form_hidden('stat_in', 'Edit');
                ?>
                <fieldset>                    
                    <div id="statusMain">
                        <div id="leftMain">
                            <label class="label-wrc">Nama Property</label>
                        </div>
                        <div id="rightMain">
                            <?php
                            $user_name_input = array(
                                'name' => 'n_property',
                                'value' => $n_property,
                                'class' => 'input-wrc required',
                                'id' => 'property_name',
                                'style' => 'min-width:400pt'
                            );
                            echo form_input($user_name_input);
                            ?>
                        </div>
                    </div>

					<div id="statusMain">
                        <div id="leftMain" class="bg-grid" style="min-height: 22pt">
                            <label class="label-wrc">Kategori</label>
                        </div>
                        <div id="rightMain" class="bg-grid">
                            <?php
                            $c_parent_input = array(
                                'name' => 'c_parent',
                                'value' => $c_parent,
                                'class' => 'input-wrc required',
                                'id' => 'c_parent'
                            );
                            echo form_input($c_parent_input);
                            ?>
                        </div>
                    </div>

                    <div id="statusMain">
                        <div id="leftMain">
                            <label class="label-wrc">Urutan Parent</label>
                        </div>
                        <div id="rightMain">
                            <?php
                            $parent_order_input = array(
                                'name' => 'c_parent_order',
                                'value' => $c_parent_order,
                                'class' => 'input-wrc required digits',
                                'id' => 'c_parent_order'
                            );
                            echo form_input($parent_order_input);
                            ?>
                        </div>
                    </div>

                    <div id="statusMain">
                        <div id="leftMain" class="bg-grid" style="min-height: 22pt">
                            <label class="label-wrc">Urutan</label>
                        </div>
                        <div id="rightMain" class="bg-grid">
                            <?php
                            $order_input = array(
                                'name' => 'c_order',
                                'value' => $c_order,
                                'class' => 'input-wrc required digits',
                                'id' => 'c_order'
                            );
                            echo form_input($order_input);
                            ?>
                        </div>
                    </div>

                    <div id="statusMain">
                        <div id="leftMain">
                            <label class="label-wrc">Kode Retribusi</label>
                        </div>
                        <div id="rightMain">
                            <?php
                            if($ret_choise === "Tidak") {
                                $code_choise_0 = 'checked';
                                $code_choise_1 = '';
                            } else {
                                $code_choise_1 = 'checked';
                                $code_choise_0 = '';
                            }
                            $data_0 = array(
                                'name' => 'c_retribusi',
                                'type' => 'radio',
                                'checked' => $code_choise_0,
                                'value'=> 'Tidak'
                            );
                            $data_1 = array(
                                'name' => 'c_retribusi',
                                'type' => 'radio',
                                'checked' => $code_choise_1,
                                'value'=> 'Ada'
                            );
                            echo form_checkbox($data_0); echo "Tidak";
                            echo form_checkbox($data_1); echo "Ada";
                            ?>
                        </div>
                    </div>

                    <div id="statusMain">
                        <div id="leftMain" class="bg-grid">
                            <label class="label-wrc">Tampilkan di Surat Izin</label>
                        </div>
                        <div id="rightMain" class="bg-grid">
                            <?php
                            if($c_sk_id === "Tidak") {
                                $code_choise_0a = 'checked';
                                $code_choise_1a = '';
                            } else {
                                $code_choise_1a = 'checked';
                                $code_choise_0a = '';
                            }
                            $data_0a = array(
                                'name' => 'c_sk_id',
                                'type' => 'radio',
                                'checked' => $code_choise_0a,
                                'value'=> 'Tidak'
                            );
                            $data_1a = array(
                                'name' => 'c_sk_id',
                                'type' => 'radio',
                                'checked' => $code_choise_1a,
                                'value'=> 'Ya'
                            );
                            echo form_checkbox($data_0a); echo "Tidak";
                            echo form_checkbox($data_1a); echo "Ya";
                            ?>
                        </div>
                    </div>

                    <div id="statusMain">
                        <div id="leftMain">
                            <label class="label-wrc">Tampilkan di SKRD</label>
                        </div>
                        <div id="rightMain">
                            <?php
                            if($c_skrd_id === "Tidak") {
                                $code_choise_0 = 'checked';
                                $code_choise_1 = '';
                            } else {
                                $code_choise_1 = 'checked';
                                $code_choise_0 = '';
                            }
                            $data_0ab = array(
                                'name' => 'c_skrd_id',
                                'type' => 'radio',
                                'checked' => $code_choise_0,
                                'value'=> 'Tidak'
                            );
                            $data_1ab = array(
                                'name' => 'c_skrd_id',
                                'type' => 'radio',
                                'checked' => $code_choise_1,
                                'value'=> 'Ya'
                            );
                            echo form_checkbox($data_0ab); echo "Tidak";
                            echo form_checkbox($data_1ab); echo "Ya";
                            ?>
                        </div>
                    </div>

                    <div id="statusMain">
                        <div id="leftMain" class="bg-grid">
                            <b>Tampilkan di Tinjauan Lapangan/BAP</b>
                        </div>
                        <div id="rightMain" class="bg-grid">
                            <?php
                            if ($c_tl_id === "Tidak") {
                                $code_choise_0 = 'checked';
                                $code_choise_1 = '';
                            } else {
                                $code_choise_1 = 'checked';
                                $code_choise_0 = '';
                            }
                            $data_0b = array(
                                'name' => 'c_tl_id',
                                'type' => 'radio',
                                'checked' => $code_choise_0,
                                'value' => 'Tidak'
                            );
                            $data_1b = array(
                                'name' => 'c_tl_id',
                                'type' => 'radio',
                                'checked' => $code_choise_1,
                                'value' => 'Ya'
                            );
                            echo form_checkbox($data_0b); echo "Tidak";
                            echo form_checkbox($data_1b); echo "Ya";
                            ?>
                        </div>
                    </div>

                    <div id="statusMain">
                        <div id="leftMain">
                            <label class="label-wrc">Tipe Property</label>
                        </div>
                        <div id="rightMain">
                            <?php
                            $arr = array(
                                'TextBox' => 'TextBox',                              // 0
                                'Integer' => 'Integer',                            
                                'ComboBox' => 'ComboBox',                            // 1
                                'Tanggal' => 'Tanggal'                               // 4
//                                '2' => 'Tanggal',
//                                '3' => 'Boolean'
                            );
                            if($c_type == 1 | $c_type == 0 | $c_type == 4 ) {
                                echo form_dropdown('c_type', $arr, $c_type,'class="input-select-wrc"');
                            } else {
                                echo form_dropdown('c_type', $arr,'Belum di seting','class="input-select-wrc"');
                            }
	                        ?>
                        </div>
                    </div>

					<div id="statusMain">
                        <div id="leftMain" class="bg-grid" style="min-height: 22pt">
                            <label class="label-wrc">Combo Item</label>
                        </div>
                        <div id="rightMain" class="bg-grid">
                            <?php
                            $combo_item_input = array(
                                'name' => 'combo_item',
                                'value' => $combo_item,
                                'class' => 'input-wrc required',
                                'id' => 'combo_item'
                            );
                            echo form_input($combo_item_input);
                            ?>
                        </div>
                    </div>

					<div id="statusMain">
                        <div id="leftMain">
                            <label class="label-wrc">Aktif Property</label>
                        </div>
                        <div id="rightMain">
                            <?php
                            if ($c_aktif === "Tidak") {
                                $code_choise_0 = 'checked';
                                $code_choise_1 = '';
                            } else {
                                $code_choise_1 = 'checked';
                                $code_choise_0 = '';
                            }
                            $data_0b = array(
                                'name' => 'c_aktif',
                                'type' => 'radio',
                                'checked' => $code_choise_0,
                                'value' => 'Tidak'
                            );
                            $data_1b = array(
                                'name' => 'c_aktif',
                                'type' => 'radio',
                                'checked' => $code_choise_1,
                                'value' => 'Ya'
                            );
                            echo form_checkbox($data_0b); echo "Tidak";
                            echo form_checkbox($data_1b); echo "Ya";
                            ?>
                        </div>
                    </div>

                    <div id="statusMain">
                        <div id="leftMain">
                        </div>
                        <div id="rightMain">
                            <?php
                            $add_property = array(
                                'name' => 'submit',
                                'class' => 'submit-wrc',
                                'content' => 'Simpan',
                                'type' => 'submit',
                                'value' => 'Simpan'
                            );
                            echo form_submit($add_property);
                            echo "<span></span>";
                            $cancel = array(
                                'name' => 'button',
                                'class' => 'button-wrc',
                                'content' => 'Batal',
                                'onclick' => 'parent.location=\''. site_url('property/master/detail') . "/" . $id_izin . '\''
                            );
                            echo form_button($cancel);
                            echo form_close(); 
			}
                            ?>
			            </div>
				    </div>
			    </fieldset>
        </div>
    </div>
    <br style="clear: both;" />
</div>