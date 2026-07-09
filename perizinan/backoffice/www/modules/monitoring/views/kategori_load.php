<script language="javascript" type="text/javascript">
    $(function() {
        $("#periode1").datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: 'yy-mm-dd',
            closeText: 'X'
        });
        $("#periode2").datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: 'yy-mm-dd',
            closeText: 'X'
        });
		$('#jenis_trayek').multiselect({
            show:'blind',
            hide:'blind',
            multiple: false,
            header: 'Pilih salah satu',
            noneSelectedText: 'Pilih salah satu',
				minWidth: 500,
            selectedList: 1
        }).multiselectfilter();
    });

    function finishAjax(id, response){
        $('#'+id).html(unescape(response));
        $('#'+id).fadeIn();
    }
</script>

<div class="contentForm" id="show_<?php echo $katagori_1; ?>">
    <?php echo form_hidden('katagori', $katagori);?>
    <font size="2">
    <?php if($_REQUEST &&  $katagori != '6' && $katagori != '7' && $katagori != '8') { ?>  <!-- Khusus selain Tanggal dan ComboBoz-->
        <div id="leftRail">
            <?php echo form_label($kat_cari[$katagori]); ?>
        </div>
        <div id="rightRail">
            <input type="text" class="input-wrc required" name="kt_cari" id="kt_cari" value="<?php echo $kt_cari; ?>" />
        </div>
    <?php } else { 
            if($katagori == '8') {     // khusus Combo Box
	?>
                <div id="leftRail">
                    <?php echo form_label($kat_cari[$katagori]); ?>
                </div>
		        <div >
                    <?php
                        foreach ($list_trayek as $row){
		                    if($xgroup == 0) {
                                $opsi_trayek[$row->kode_trayek] = $row->kode_trayek.' '.$row->trayek;
							}else{
								$opsi_trayek[$row->KODE_TRAYE] = $row->KODE_TRAYE.' '.$row->NAMA_TRAYE;
							}
                        }
                        //echo form_hidden('paralel', 'no');
                        //echo form_hidden('jenis_permohonan', $jenis_id);
					    echo form_dropdown('kt_cari', $opsi_trayek, '','class = "input-select-wrc" id="jenis_trayek" multiple="multiple"');
                    ?>
                </div>
            <?php } else { ?>
                <div id="leftRail">
                    <?php echo form_label('Periode Awal', 'd_tahun'); ?>
                </div>
		        <div id="rightRail">
                    <?php
                        $periodeawal_input = array(
                            'name' => 'first_date',
                            'class' => 'input-wrc required',
                            'id' => 'periode1',
                            'readOnly' => TRUE,
                            'value' => $first_date
                        );
                        echo form_input($periodeawal_input);
                    ?>
                </div>

                <div style="clear: both" ></div>
         		<div id="leftRail">
		            <?php echo form_label('Periode Akhir', 'd_tahun'); ?>
                </div>
		        <div id="rightRail">
                    <?php
                        $periodeawal_input = array(
                            'name' => 'second_date',
                            'class' => 'input-wrc required',
                            'id' => 'periode2',
                            'readOnly' => TRUE,
                            'value' => $second_date
                        );
                        echo form_input($periodeawal_input);
                    ?>
                </div>
	        <?php }
		} ?>
    </font>
</div>