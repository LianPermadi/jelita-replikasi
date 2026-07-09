<div class="isi">
    <h1><?php echo $judul ?></h1>

     <a href="<?php echo site_url('admin_jajak/tambah');?>" class='button button-blue' >Tambah Data Baru</a>

    <table id="laporan" class="display"  >
        <thead>
            <tr>
                <th>No</th>
                <th width="40%">Judul Jajak</th>        
                <th>Priode Awal</th>
                <th>Priode Akhir</th>
                <th>Status</th>
                <th>Hasil</th>
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
                    $link_hapus=  anchor('admin_jajak/delete/'.$data->C_JAJAK, $img_delete,array('onClick'=>'return confirm(\'Apa anda yakin akan menghapus data ini ?\');'));
                    $link_edit=anchor('admin_jajak/edit/'.$data->C_JAJAK, $img_update);
                    
                    $link_jajak=anchor('admin_jajak/hasil_jajak/'.$data->C_JAJAK, 'Lihat Hasil');
                    
                    if($data->STATUS){
                        $status='Aktif';
                    }
                    else $status='Tidak Aktif';
                    
                   
                    echo '<tr>';
                        echo '<td>'.$n.'</td>';
                        echo '<td>'.$data->N_TANYA.'</td>';
                        echo '<td>'.$data->D_PRD_AWAL.'</td>';
                        echo '<td>'.$data->D_PRD_AKHIR.'</td>';
                        echo '<td>'.$status.'</td>';
                        echo "<td> $link_jajak</td>";
                        echo "<td>$link_edit $link_hapus</td>";
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
