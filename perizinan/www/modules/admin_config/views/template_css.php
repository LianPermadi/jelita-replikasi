<div class="isi">
    <h1><?php echo $judul ?></h1>
    
    
    
    <table id="laporan" class="display"  >
        <thead>
            <tr>
                <th>Nama Template</th>
                <!--<th width="70%">Preview</th> -->
                <th width="50%">Status</th>
                <th width="15%">Tindakan</th>
            </tr>            
        </thead>
        <tbody>
            
<?php           
            
                $img_delete=$this->lib_button->ubah_notifikasi_header("cross.png","Hapus Header Ini");
                $img_update=$this->lib_button->ubah_notifikasi_header("detail.png","Aktifkan Header Ini");
                foreach ($list as $data){
                    
                    $link_hapus= anchor('admin_config/delete/'.$data->link_id, $img_delete,array('onClick'=>'return confirm(\'Apa anda yakin akan menghapus data ini ?\');'));
                    $link_edit=anchor('admin_config/update_css/'.$data->link_id, $img_update,array('onClick'=>'return confirm(\'Apa anda yakin akan mengaktifkan template ini ?\');'));
                    
                    if($data->link_status){
                        $status='Template Aktif';
                        $link_edit="";
                    }
                    else $status='Template Tidak Aktif';
                    
                   
                    echo '<tr>';
                        echo "<td style='vertical-align: top';>".$data->link_name."</td>";
                        //echo "<td style='vertical-align: top' align:center;> <img width='500' src='".base_url().'uploads/header_file/'.$data->link_css."'</td>";
                        echo "<td style='vertical-align: top';>".$status."</td>";
                        echo "<td style='vertical-align: top';> $link_edit &nbsp; $link_hapus</td>";
                    echo '</tr>';
                }
?>            
        </tbody>

    </table>   
    
</div>
