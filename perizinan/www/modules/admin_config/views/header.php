<div class="isi">
    <h1><?php echo $judul ?></h1>
    
   <?php
    $atr = array(
        'id' => 'formID',
        'class' => 'formular'
    );
    echo form_open_multipart('admin_config/save_header', $atr);
    ?>
    
    <table border="1" style="margin-left: 20px;">
        
        <tr>
            <td width="200">Nama Header</td>
            <td>:</td>
            <td><input type="text" name="nama_header" id="nama_header" size="40" class="validate[required] text-input" />
            </td>
        </tr>        
        <tr>
            <td width="200">File Header</td>
            <td>:</td>
            <td><input type="file" name="xfile" id="file" class="validate[required] text-input"/>
            </td>
        </tr>
         <tr>
             <td width="200"><input type="submit" value="Simpan Data" class='button button-blue' style="float: left;"/></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>       
        
           
    </table>
    
    
    <table id="laporan" class="display"  >
        <thead>
            <tr>
                <th>Nama Header</th>
                <th width="70%">File Header</th>   
                <th width="10%">Status</th>
                <th width="5%">Tindakan</th>
            </tr>            
        </thead>
        <tbody>
            
<?php           
            
                $img_delete=$this->lib_button->ubah_notifikasi_header("cross.png","Hapus Header Ini");
                $img_update=$this->lib_button->ubah_notifikasi_header("detail.png","Aktifkan Header Ini");
                foreach ($list as $data){
                    
                    $link_hapus= anchor('admin_config/delete/'.$data->c_bground, $img_delete,array('onClick'=>'return confirm(\'Apa anda yakin akan menghapus data ini ?\');'));
                    $link_edit=anchor('admin_config/update/'.$data->c_bground, $img_update,array('onClick'=>'return confirm(\'Apa anda yakin akan mengaktifkan header ini ?\');'));
                    
                    if($data->c_status){
                        $status='Header Aktif';
                        $link_edit="";
                    }
                    else $status='Header Tidak Aktif';
                    
                   
                    echo '<tr>';
                        echo "<td style='vertical-align: top';>".$data->n_judul."</td>";
                        echo "<td style='vertical-align: top' align:center;> <img width='500' src='".base_url().'uploads/header_file/'.$data->n_image."'</td>";
                        echo "<td style='vertical-align: top';>".$status."</td>";
                        echo "<td style='vertical-align: top';> $link_edit &nbsp; $link_hapus</td>";
                    echo '</tr>';
                }
?>            
        </tbody>

    </table>   
    
</div>
