<div id="content">
    <div class="post">
        <div class="title">
            <h2><?php echo $page_name; ?></h2>
        </div>
        <div class="entry">
            <fieldset id="half">
                <legend>Daftar Per Periode</legend>
                <?php
		        echo form_open('durasiizin/izin/esdm');
				if($lokasi != 'OPD Teknis'){
                    ?>
                	<div id="statusRail">
	                    <div id="leftRail">
	                        <?php
                            echo form_label('Bidang');
                            ?>
                        </div>
                        <div id="rightRail">
                            <?php  
			                $this->db->select('id');
			                $this->db->select('n_sektor');
                            $anggota = $this->db->get('trsektor');
                            //foreach($anggota->result() as $row){
						    foreach ($list_data as $row) {
								if(substr($row->n_sektor, 0, 1) != '*')
                                    $hasil[$row->id] = $row->n_sektor;
                            }
                            $pilih = array($anggota);
                            echo form_dropdown('id',$hasil,$pilih);
						    echo br();
                            ?>
                        </div>
                    </div>
                    <?php
                }
                    ?>

                <div id="statusRail">
                    <div id="leftRail">
                        <?php
                        echo form_label('Tgl Daftar Awal','d_tahun');
                        ?>
                    </div>
                    <div id="rightRail">
                        <?php
                        $periodeawal_input = array(
                            'name'  => 'tgla',
                            'value' => $this->lib_date->set_date(date('Y-m-d'), -2),
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
                        <?php
                        echo form_label('Tgl Daftar Akhir','d_tahun');
                        ?>
                    </div>
                    <div id="rightRail">
                        <?php
                        $periodeakhir_input = array(
                            'name'  => 'tglb',
                            'value' => $this->lib_date->set_date(date('Y-m-d'), 0),
                            'class' => 'input-wrc',
                            'readOnly'=>TRUE,
                            'class' => 'monbulan'
                        );
                        echo form_input($periodeakhir_input);
                        ?>
                    </div>
                </div>
         
                <div id="statusRail">
                    <div id="leftRail"></div>
                    <div id="rightRail">
                        <?php
                            $filter_data = array(
                                'name' => 'button',
                                'class' => 'button-wrc',
                                'content' => 'Filter',
                                'value' => 'Filter'
                            );
                    
	    		    		$reset_data = array(
                                'name' => 'button',
                                'content' => 'Reset Filter',
                                'value' => 'Reset Filter',
                                'class' => 'button-wrc',
                                'onclick' => 'parent.location=\''. site_url('durasiizin/izin') . '\''
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
            <div class="contentForm"> </div>
        </div>
    </div>
    <br style="clear: both;" />
</div>