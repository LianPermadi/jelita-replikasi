<div class="isi">
    <h1><?php echo $judul ?></h1>
    

    <a href="<?php echo site_url('admin_galeri/tambah');?>" class='button button-blue' >Tambah Data Baru</a>

    <table id="laporan" class="display"  >
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th width="60%">Keterangan</th>        
                <th>Status</th>
                <th width="5%">Tindakan</th>
                
            </tr>            
        </thead>
        <tbody>
            
            <?php
                $n=0;
                $img_delete=$this->lib_button->delete_icon();
                $img_update=$this->lib_button->edit_icon();
                foreach ($list as $data){
                    $n++;
                    $link_hapus=  anchor('admin_galeri/delete/'.$data->C_GALLERY, $img_delete,array('onClick'=>'return confirm(\'Apa anda yakin akan menghapus data ini ?\');'));
                    $link_edit=anchor('admin_galeri/edit/'.$data->C_GALLERY, $img_update);
                    
                    if($data->C_STATUS_LINK){
                        $status='Diterbitkan';
                    }
                    else $status='Tidak Diterbitkan';
                    
                   
                    echo '<tr>';
                        echo '<td>'.$n.'</td>';
                        echo '<td>'.$data->D_GALLERY.'</td>';
                        echo '<td>'.$data->N_KETERANGAN_GALLERY.'</td>';
                        echo '<td>'.$status.'</td>';
                        echo "<td>$link_edit $link_hapus</td>";
                    echo '</tr>';
                }

            ?>             
            
<!--            <tr>
                <td>1</td>
                <td>2</td>
                <td>1</td>     
                <td>1</td>    
                <td>&nbsp;</td>                
            </tr>-->
             
        </tbody>

    </table>    
</div>
