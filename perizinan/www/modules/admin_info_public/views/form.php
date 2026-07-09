<div class="isi">
   
    <h1><?php echo $judul ?></h1>
    
    <?php 
    $atr=array('id'=>'formID',
                'class'=>'formular');
    echo form_open('admin_info_public/save', $atr);?>    
    
    <table border="1" style="margin-left: 20px;">
        <tr>
            <td width="200">Judul Info Publik</td>
            <td>:</td>
            <td><input type="text" size="60" name="judul_berita" value="<?php echo $judul_berita; ?>" id="judul_berita" class="validate[required] text-input"/> </td>
        </tr>
        <tr>
            <td style="vertical-align: top">Isi Info Publik</td>
            <td style="vertical-align: top">:</td>
            <td><textarea name="deskipsi" id="my_editor" style="width: 400px; height: 50px; margin-left: 2px;"><?php echo $deskipsi; ?></textarea></td>
        </tr>   
        <tr>
            <td>Status  Info Publik </td>
            <td>:</td>
            <td>
                <select name="status">
                 <?php
                    if($status){
                        echo "<option value='1' selected>Diterbitkan</option>";
                        echo "<option value='0'>Tidak Diterbitkan</option>";
                    }
                    else{
                         echo "<option value='1' >Diterbitkan</option>";
                        echo "<option value='0' selected>Tidak Diterbitkan</option>";
                    }
                 ?>
                </select>
            </td>
        </tr>       
      
        
        
    </table>
    <input type="hidden" name="id" value="<?php echo $id; ?>"/>
<br/><br/>
        <input type="submit" value="Simpan" class='button button-blue'  style="float: left; margin-right: 5px; margin-left: 20px;"/> &nbsp; &nbsp;

        <a href="<?php echo site_url('admin_info_public');?>" class='button button-blue' style="float: left;" >Batal</a>     
        
    </form>
    <div id="clear" style="clear: both;" ></div>
</div>
