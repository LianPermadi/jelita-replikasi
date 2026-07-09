<div class="isi">
    <h1><?php echo $judul ?></h1>
    
    
    <?php 
    $atr=array('id'=>'formID',
                'class'=>'formular');
    echo form_open('admin_jajak/save', $atr);?>  
   
    
    <table border="1" style="margin-left: 20px;">
        <tr>
            <td width="200">Judul Jajak</td>
            <td>:</td>
            <td><input type="text" size="70" name="judul" id="judul" class="validate[required] text-input" value="<?php echo $N_TANYA; ?>"/></td>
        </tr>
        <tr>
            <td>Priode Awal</td>
            <td>:</td>
            <td><input type="text"  id="tanggal" name="tgl1" class="validate[custom[date],validate[required]] text-input" value="<?php echo $D_PRD_AWAL; ?>"/></td>
        </tr>   
        <tr>
            <td>Priode Akhir</td>
            <td>:</td>
            <td><input type="text"  id="tanggal2" name="tgl2" class="validate[custom[date],validate[required]] text-input" value="<?php echo $D_PRD_AKHIR; ?>"/></td>
        </tr>        
        
        <tr>
            <td>Pilihan 1</td>
            <td>:</td>
            <td style="padding-top: 5px;"><input type="text" size="40" name="pil1" id="pil1" class="validate[required] text-input" value="<?php echo $N_PILIHAN1; ?>"/><td>
        </tr>        
        
        <tr>
            <td>Pilihan 2</td>
            <td>:</td>
            <td style="padding-top: 5px;"><input type="text" size="40" name="pil2" id="pil2" class="validate[required] text-input" value="<?php echo $N_PILIHAN2; ?>"/><td>
        </tr>   
        
        <tr>
            <td>Pilihan 3</td>
            <td>:</td>
            <td style="padding-top: 5px;"><input type="text" size="40" name="pil3" id="pil3"  value="<?php echo $N_PILIHAN3; ?>"/><td>
        </tr>   
        
        <tr>
            <td>Pilihan 4</td>
            <td>:</td>
            <td style="padding-top: 5px;"><input type="text" size="40" name="pil4" id="pil4" value="<?php echo $N_PILIHAN4; ?>"/><td>
        </tr>   
        
        <tr>
            <td>Pilihan 5</td>
            <td>:</td>
            <td style="padding-top: 5px;"><input type="text" size="40" name="pil5" id="pil5" value="<?php echo $N_PILIHAN5; ?>"/><td>
        </tr>   
        
        <tr>
            <td>Status</td>
            <td>:</td>
            <td style="padding-top: 5px;">
                <select name="status">
                    <?php
                        if($STATUS==1){
                            echo "<option value='1' selected>Aktif</option>";
                            echo "<option value='0'>Tidak Aktif</option>";
                        }
                        else{
                            echo "<option value='1' >Aktif</option>";
                            echo "<option value='0' selected>Tidak Aktif</option>";                            
                        }
                    ?>
                </select>
            <td>
        </tr>         
        
    </table>
    
    <input type="hidden" size="40" name="C_JAJAK" id="C_JAJAK" value="<?php echo $C_JAJAK; ?>"/>
    
    <input type="hidden" size="40" name="ID_PILIHAN1" id="ID_PILIHAN1" value="<?php echo $ID_PILIHAN1; ?>"/>
    <input type="hidden" size="40" name="ID_PILIHAN2" id="ID_PILIHAN2" value="<?php echo $ID_PILIHAN2; ?>"/>
    <input type="hidden" size="40" name="ID_PILIHAN3" id="ID_PILIHAN3" value="<?php echo $ID_PILIHAN3; ?>"/>
    <input type="hidden" size="40" name="ID_PILIHAN4" id="ID_PILIHAN4" value="<?php echo $ID_PILIHAN4; ?>"/>
    <input type="hidden" size="40" name="ID_PILIHAN5" id="ID_PILIHAN5" value="<?php echo $ID_PILIHAN5; ?>"/>
        
    
<br/><br/>
        <input type="submit" value="Simpan" class='button button-blue'  style="float: left; margin-right: 5px; margin-left: 20px;"/> &nbsp; &nbsp;

        <a href="<?php echo site_url('admin_jajak/');?>" class='button button-blue' style="float: left;" >Batal</a>     

        <form/>
</div>
