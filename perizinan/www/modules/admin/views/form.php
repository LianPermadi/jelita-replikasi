<div class="isi">
    <div class="login">
        <h1>Dinas Penanaman Modal dan Pelayanan Terpadu Satu Pintu Provinsi Jawa Barat <br/>
        Content Management System</h1>
        
        <?php 
            $atr=array('id'=>'formID',
                        'class'=>'formular');
            echo form_open('admin/proses_login', $atr)?>
        <p style="color: red"><?php echo $error;?></p>
        <p><label> User Login </label>: <input type="text" name="username" id="username" class="validate[required] text-input"/> </p>
        <p><label> Password </label>: <input type="password" name="password" id="password" class="validate[required] text-input"/> </p>
            <input type="submit" value="     Login    " class='button button-blue' style="float: left;"/>
        <?php echo form_close();?>
        <em>* Silakan isi username dan password Anda</em>
    </div>
</div>
