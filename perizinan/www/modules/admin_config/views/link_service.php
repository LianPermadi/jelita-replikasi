<div class="isi">
    <h1><?php echo $judul ?></h1>

<?php 
    $atr=array('id'=>'formID',
                'class'=>'formular');
    echo form_open('admin_config/update_link', $atr);?>    
    <table border="1" style="margin-left: 20px;">
        <tr>
            <td width="200">Alamat Web service Back-Office</td>
            <td>:</td>
            <td><input type="text" name="link" id="link" size="40"  class="validate[required] text-input" value="<?php echo $link->N_ALAMAT_WAP; ?>"/> </td>
        </tr>
    </table>

        
        <input type="submit" value="Simpan" class='button button-blue'  style="float: left; margin-right: 5px; margin-left: 20px;"/> &nbsp; &nbsp;

             
    </form>
    
</div>
