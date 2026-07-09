<div class="isi">
    <h1><?php echo $judul ?></h1>
    
     <a href="<?php echo site_url('admin_user/tambah');?>" class='button button-blue' >Tambah Data Baru</a>

    <table id="laporan" class="display"  >
        <thead>
            <tr>
                <th>No</th>
                <th>User ID</th>
                <th>Otoritas</th>
                <th>Bagian</th>
                <th>Alamat Email</th>
                <th width="5%">Tindakan</th>
                
            </tr>            
        </thead>
        <tbody>
            <?php
                $n=0;
                $img_delete=$this->lib_button->delete_icon();
                $img_update=$this->lib_button->edit_icon();
                $reset_pass=$this->lib_button->reset_pass();
                foreach ($list as $data){
                    $n++;
                    $reset_password=anchor('admin_user/reset_password/'.$data->id, $reset_pass);
                    $link_hapus=  anchor('admin_user/delete/'.$data->id, $img_delete,array('onClick'=>'return confirm(\'Apa anda yakin akan menghapus data ini ?\');'));
                    $link_edit=anchor('admin_user/edit/'.$data->id, $img_update);
                   
                    echo '<tr>';
                        echo '<td>'.$n.'</td>';
                        echo '<td>'.$data->c_user.'</td>';
                        echo '<td>'.$data->n_otoritas.'</td>';
                        echo '<td>'.$data->c_dep.'</td>';
                        echo '<td>'.$data->email.'</td>';
                        echo "<td>$reset_password $link_edit $link_hapus</td>";
                    echo '</tr>';
                }

            ?>
            
<!--            <tr>
                <td>1</td>
                <td>2</td>
                <td>1</td>    
                <td>1</td>
                <td>2</td>
                <td>1</td>                 
                <td>&nbsp;</td>                
            </tr>-->
             
        </tbody>

    </table>    
</div>
