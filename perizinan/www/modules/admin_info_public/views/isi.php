<div class="isi">
    <h1><?php echo $judul ?></h1>

    <a href="<?php echo site_url('admin_info_public/tambah');?>" class='button button-blue' >Tambah Data Baru</a>

    <table id="laporan" class="display"  >
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th width="50%">Judul</th>
                <th>Status</th>
                <th width="10%">Tindakan</th>
                
            </tr>            
        </thead>
        <tbody>
            
        <?php
                $n=0;
                $img_delete=$this->lib_button->delete_icon();
                $img_update=$this->lib_button->edit_icon();
                
                $status="";
                
                foreach ($list as $data){
                    $n++;
                    $link_hapus=  anchor('admin_info_public/delete/'.$data->C_BERITA, $img_delete,array('onClick'=>'return confirm(\'Apa anda yakin akan menghapus data ini ?\');'));
                    $link_edit=anchor('admin_info_public/edit/'.$data->C_BERITA, $img_update);
                   
                    if($data->C_STATUS_BERITA){
                        $status="Diterbitkan";
                    }
                    else
                        $status="Tidak Diterbitkan";
                    
                    echo '<tr>';
                        echo '<td>'.$n.'</td>';
                        echo '<td>'.$data->D_BERITA.'</td>';
                        echo '<td>'.$data->N_JUDUL_BERITA.'</td>';
                        echo '<td>'.$status.'</td>';
                        echo "<td>$link_edit $link_hapus</td>";
                    echo '</tr>';
                }

            ?>           
            
             
        </tbody>

    </table>    
</div>
