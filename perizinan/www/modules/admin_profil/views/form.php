<div class="isi">
    <h1><?php echo $judul ?></h1>
    
 <?php 
    $atr=array('id'=>'formID',
                'class'=>'formular');
    echo form_open('admin_profil/update', $atr);
    echo $this->session->flashdata('konf')."<br />";
    ?>
        
    <table border="1" style="margin-left: 20px;">
        <tr>
            <td width="200">User Name</td>
            <td>:</td>
            <td><?php echo $c_user; ?></td>
        </tr>
        <tr>
            <td style="vertical-align: top">Password Lama</td>
            <td style="vertical-align: top">:</td>
            <td><input type="password" name="passwordL" id="passwordL"  class="validate[required,minSize[6]] text-input"  /></td>
        </tr>
        <tr>
            <td style="vertical-align: top">Password baru</td>
            <td style="vertical-align: top">:</td>
            <td><input type="password" name="password" id="password"  class="validate[required,minSize[6]] text-input"  /></td>
        </tr>   
        <tr>
            <td>Password Konfirmasi</td>
            <td>:</td>
            <td><input type="password" name="re_password" id="re_password"  class="validate[required,equals[password]] text-input" /></td>
        </tr>   
     <!-- 
        <tr>
            <td>Alamat Email</td>
            <td>:</td>
            <td><input type="text" size="40" name="email" id="email" class="validate[required,custom[email]] text-input"  value="<?php echo $email; ?>" /> </td>
        </tr>      
        -->
    </table>

        <br/><br/>
        
        <input type="submit" value="Simpan" class='button button-blue'  style="float: left; margin-right: 5px; margin-left: 20px;"/> &nbsp; &nbsp;

        <a href="<?php echo site_url('admin_user');?>" class='button button-blue' style="float: left;" >Batal</a>     
        
    </form>
</div>
