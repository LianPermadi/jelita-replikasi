<div class="isi">
    <h1><?php echo $judul ?></h1>
    
    <?php
    $atr = array(
        'id' => 'formID',
        'class' => 'formular'
    );
    echo form_open_multipart('admin_galeri/'.$action, $atr);
    echo $error;?>
    <input type="hidden" name="id" value="<?php echo $id; ?>"/>
    <input type="hidden" name="file_uploaded" value="<?php echo $file; ?>"/>

    <table border="1" style="margin-left: 20px;">
        <tr>
            <td width="200">File Galeri</td>
            <td>:</td>
            <td><input type="file" name="xfile" id="file"/>
                    <?php
                if ($file != NULL) {
                    echo anchor(base_url() . 'uploads/galeri/' . $file, 'Download');
                }
                ?>
            </td>
        </tr>
        <tr>
            <td style="vertical-align: top">Keterangan</td>
            <td style="vertical-align: top">:</td>
            <td><textarea name="keterangan" id="keterangan"  style="width: 400px; height: 50px; margin-left: 2px;"><?php echo $keterangan;?></textarea></td>
        </tr>
        <tr>
            <td>Status Galeri</td>
            <td>:</td>
            <td style="padding-top: 5px;">
                <select name="status">
                    <?php
                    if ($status) {
                        echo "<option value='1' selected>Diterbitkan</option>";
                        echo "<option value='0'>Tidak Diterbitkan</option>";
                    } else {
                        echo "<option value='1' >Diterbitkan</option>";
                        echo "<option value='0' selected>Tidak Diterbitkan</option>";
                    }
                    ?>
                </select>
            </td>
        </tr>     
    </table>

    <br/><br/>
    <input type="submit" value="Simpan" class='button button-blue'  style="float: left; margin-right: 5px; margin-left: 20px;"/> &nbsp; &nbsp;

    <a href="<?php echo site_url('admin_galeri'); ?>" class='button button-blue' style="float: left;" >Batal</a>
</div>
<?php echo form_close()?>