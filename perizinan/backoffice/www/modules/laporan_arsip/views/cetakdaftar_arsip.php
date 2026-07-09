<?php
    $filename =$bidang.'-'.$tgla.'.xls';
    header('Content-type: application/ms-excel');
    header('Content-Disposition: attachment; filename='.$filename);
?>
<!DOCTYPE html>
<html>
<body>
<table></table>
            <h3><?php echo '<center>DAFTAR ARSIP SIMPAN</center><br></h3>';
            echo 'Instansi &nbsp &nbsp; &nbsp;: DPMPTSP PROVINSI TASIKMALAYA<br>';
            echo 'Unit Kerja : '.$bidang.'<br>';
            echo 'Tahun &nbsp; &nbsp; &nbsp; &nbsp;: '.$tgla.'<br>';
            echo 'Jenis Izin : '.$jenisizin;
            ?>
<br><br>

        
            <table border="1" width="100%">
                <thead>
                    <tr>
                        <th width="">No</th>
                        <th width="">Indeks</th>
                        <th width="">Klas</th>
                        <th width="">Uraian / Deskripsi</th>
                        <th width="">Tahun</th>
                        <th width="">Jml</th>
                        <th width="">Sampul</th>
                        <th width="">Box</th>
                        <th width="">Rak</th>
                        <th width="">Ket</th>
                    </tr>
                </thead>
                <tbody>
               
                  <?php
                  $i = 1;

                    if (count($list_arsip)>0) {
                    
                    foreach ($list_arsip as $data){
                         if($data->desc_arsip){
                                        $ket_arsip = $data->desc_arsip;
                                    } else {
                                        $ket_arsip = '-_^-_^-_^-_^-_';
                                    }
                        $arr_desc = explode("^",$ket_arsip);
                    ?>
                    <tr>
                <td align="center"><?php echo $i++;?></td>
                <td align="center"><?php echo $data->indeks;?></td>
                <td align="center"><?php echo $data->n_sektor;?></td>
                <td ><?php echo $data->n_perusahaan.'<br>'.$data->no_surat;?></td>
                <td align="center"><?php echo str_replace('-','',$arr_desc[0]);?></td>
                <td align="center"><?php echo str_replace('-','',$arr_desc[1]);?></td>
                <td align="center"><?php echo str_replace('-','',$arr_desc[2]);?></td>
                <td align="center"><?php echo str_replace('-','',$arr_desc[3]);?></td>
                <td align="center"><?php echo str_replace('-','',$arr_desc[4]);?></td>
                <td align="center"><?php echo '-';?></td>
                </tr>

                    <?php
                       };
                };
                  ?>
                </tbody>
            </table>
        </body>
        </html>