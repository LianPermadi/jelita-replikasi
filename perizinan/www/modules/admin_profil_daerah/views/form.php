<div class="isi">
   
    <h1><?php echo $judul ?></h1>
    
    <?php 
    $atr=array('id'=>'formID',
                'class'=>'formular');
    echo form_open('admin_profil_daerah/save', $atr);?>    
    
    <table border="1" style="margin-left: 20px;">
        <tr>
            <td width="200">Nama Profil</td>
            <td>:</td>
            <td><input type="text" size="60" name="judul_informasi" value="<?php echo $judul_informasi; ?>"/> </td>
        </tr>
        <tr>
            <td style="vertical-align: top">Isi Profil</td>
            <td style="vertical-align: top">:</td>
            <td><textarea name="isi_informasi" id="my_editor" style="width: 400px; height: 50px; margin-left: 2px;"><?php echo $isi_informasi; ?></textarea></td>
        </tr>   
             
      
        
        
    </table>
    <input type="hidden" name="id" value="1"/>
<br/><br/>
        <input type="submit" value="Ubah Profil Daerah" class='button button-blue'  style="float: left; margin-right: 5px; margin-left: 20px;"/> &nbsp; &nbsp;

        <a href="<?php echo site_url('admin_info_public');?>" class='button button-blue' style="float: left;" >Batal</a>     
        
    </form>
    <div class="clear"></div>
</div>
