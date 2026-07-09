<div class="isi">
    <h1><?php echo $judul ?></h1>
    <p style="color: red"><b><?php echo $error ?></b></p>
    
<!--    <form id="formID" class="formular" method="post" action="admin_user/tambah">-->
        
    <?php 
    $atr=array('id'=>'formID',
                'class'=>'formular');
    echo form_open('admin_user/save', $atr);?>    
    <input type="hidden" name="id" id="id"   value="<?php echo $id; ?>"/> 
    <table border="1" style="margin-left: 20px;">
        <tr>
            <td width="200"></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>        
        <tr>
            <td width="200">User</td>
            <td>:</td>
            <td><input type="text" name="user" id="user"  class="validate[required] text-input" value="<?php echo $c_user; ?>"/> </td>
        </tr>
        <?php
            if($id==""){
        ?>
        <tr>
            <td style="vertical-align: top">Password</td>
            <td style="vertical-align: top">:</td>
            <td><input type="password" name="password" id="password" class="validate[required,minSize[6]] text-input" /></td>
        </tr>   
        <tr>
            <td>Re-Password</td>
            <td>:</td>
            <td><input type="password" name="re_password" id="re_password" class="validate[required,equals[password]] text-input" /></td>
        </tr>   
        <?php
            }
        ?>
        <tr>
            <td>Bagian</td>
            <td>:</td>
            <td><input type="text" size="40" name="bagian" id="bagian" class="validate[required] text-input" value="<?php echo $c_dep ?>"/> </td>
        </tr>        
        <tr>
            <td>Alamat Email</td>
            <td>:</td>
            <td><input type="text" size="40" name="email" id="email" class="validate[required,custom[email]] text-input" value="<?php echo $email ?>" /> </td>
        </tr>      
        <tr>
            <td>Otoritas</td>
            <td>:</td>
            <td>
                <select name="n_otoritas" id="otoritas">
                    <?php 
                        if($n_otoritas=='Administrator'){
                            echo "<option value='Administrator' selected>Administrator</option>";
                            echo "<option value='Operator'>Operator</option>";
                        }
                        else{
                            echo "<option value='Administrator'>Administrator</option>";
                            echo "<option value='Operator' selected>Operator</option>";
                        }
                     ?>
                </select>
            </td>
        </tr>         
        
    </table>

        <input type="hidden" name="id" value="<?php echo $id ?>"/>
    
        <br/><br/>
        
        <input type="submit" value="Simpan" class='button button-blue'  style="float: left; margin-right: 5px; margin-left: 20px;"/> &nbsp; &nbsp;

        <a href="<?php echo site_url('admin_user');?>" class='button button-blue' style="float: left;" >Batal</a>     
        
    </form>
</div>
