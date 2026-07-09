<div id="content">
    <div class="post">
        <div class="title">
            <h2><?php echo $page_name;
//if($tgla == ''){$tgla=date('Y');};
//if($bidang == ''){$bidang = 'Pilih Salah Satu';};

            ?></h2>
        </div>
        		 <div class="entry">
                    <fieldset id="half">
                        <legend>Filter Data</legend>
                   <form action="laporan_arsip" method="post">
                <div id="statusRail">
                    <div id="leftRail">
                        <?php
                        echo form_label('Unit Kerja ', 'label_permohonan');
                        
                        ?>
                    </div>
                    <div id="rightRail"> 
                    <select class = "input-select-wrc" id="selector" name="bidang">
                    <option selected value="<?php echo $bidang;?>"><?php echo $bidang;?></option>
                    <?php
                    foreach ($list_bidang as $data){
                        ?>
                        <option value="<?php echo $data->n_sektor;?>"><?php echo $data->n_sektor;?></option>
                        <?php
                        };
                    ?>
                    </select>
                    
                    </div>
                </div>
                <div id="statusRail">
                    <div id="leftRail">
                        <?php
                        echo form_label('Tahun ', 'label_permohonan');
                        
                        ?>
                    </div>
                    <div id="rightRail"> 
                    <?php
                    $tahun = array(
                            'name'  => 'tgla',
                            'value' => $tgla,
                            'readOnly'=>TRUE,
                            'class' => 'input-wrc',
                            'class' => 'monbulan'
                        );
                        echo form_input($tahun);
                        ?>
                    </div>
                </div>

                <div id="statusRail">
                    <div id="leftRail">
                        <?php
                        echo form_label('Indeks ', '');
                        
                        ?>
                    </div>
                    <div id="rightRail"> 
                   <input type="text" name="jenisizin" value="<?php echo $jenisizin;?>" class="input-wrc">
                    </div>
                </div>

                <div id="statusRail">
                 
                    <input type="submit" name="filter" value="filter" class="button-wrc">
                    
                </div>
                    </fieldset>
                    </form>
                </div>
        <div class="entry">
		   
<form action="laporan_arsip/cetak" method="post" target="_blank">
<input type="submit" name="cetak" value="cetak" class="button-wrc" >
 <input type="hidden" name="jenisizin" value="<?php echo $jenisizin;?>" class="input-wrc">
<?php
                    $tahun = array(
                            'name'  => 'tgla',
                            'value' => $tgla,
                            'readOnly'=>TRUE,
                            'class' => 'input-wrc',
                            'class' => 'monbulan',
                            'style' => 'visibility:hidden;'
                        );
                        echo form_input($tahun);
                        ?>
 <select class = "input-select-wrc" id="selector" name="bidang" style="visibility: hidden">
                    <option selected value="<?php echo $bidang;?>"><?php echo $bidang;?></option>
                    </select>
</form>                    
            <table cellpadding="0" cellspacing="0" border="0" class="display" id="penyerahan">
                <thead>
                    <tr>
                        <th width="">No</th>
                        <th width="">Indeks</th>
                        <th width="">Klas</th>
                        <th width="">Uraian / Deskripsi</th>
                        <th width="">Tahun</th>
                        <th width="">Jml</th>
                        <th width="">Sampul</th>
                        <th width="">Box</th>
                        <th width="">Rak</th>
                        <th width="">Ket</th>
                    </tr>
                </thead>
                <tbody>
                  <?php
                  $i = 1;

                    if (count($list_arsip)>0) {
                    
                    foreach ($list_arsip as $data){
                         if($data->desc_arsip){
                                        $ket_arsip = $data->desc_arsip;
                                    } else {
                                        $ket_arsip = '-_^-_^-_^-_^-_';
                                    }
                        $arr_desc = explode("^",$ket_arsip);
                    ?>
                    <tr>
                <td align="center"><?php echo $i++;?></td>
                <td align="center"><?php echo $data->indeks;?></td>
                <td align="center"><?php echo $data->n_sektor;?></td>
                <td ><?php echo $data->n_perusahaan.'<br>'.$data->no_surat;?></td>
                <td align="center"><?php echo str_replace('-','',$arr_desc[0]);?></td>
                <td align="center"><?php echo str_replace('-','',$arr_desc[1]);?></td>
                <td align="center"><?php echo str_replace('-','',$arr_desc[2]);?></td>
                <td align="center"><?php echo str_replace('-','',$arr_desc[3]);?></td>
                <td align="center"><?php echo str_replace('-','',$arr_desc[4]);?></td>
                <td align="center"><?php echo '-';?></td>
                </tr>

                    <?php
                       };
                }
                  ?>
                </tbody>
            </table>
        </div>

    </div>
    <br style="clear: both;" />
</div>