
<?php if(@$msg<>"") 
{
   if(@$msg == "sukses")
    {
    ?>
    <script>alert("Data Berhasil disimpan");
    window.location.href='../../../pengenalimpor/c_impor/'
    </script>

    <?php
   
    }else{
    ?>
    <script>alert("Data gagal disimpan");
    window.location.href='../../../pengenalimpor/c_impor/'
    </script>
    <?php

}
}
?>
<style type="text/css">
    table{
        border: 1px solid black;
        border-collapse: collapse;
        width: 100%;
    }
    th{
        border: 1px solid black;
    }
     td{
        border: 1px solid black;
    }
</style>
<div id="content">
    <div class="post">
        <div class="title">
            <h2><?php echo $page_name; ?></h2>
        </div>
<div class="entry">

<form action="<?php echo site_url('c_impor/update_multiple'); ?>" method="post">
<label>Nama Perusahaan : </label>
<select name="perusahaan" class="input-select-wrc valid">
 
  <?php
if (count($tbl_perusahaan_approve)>0) {
                    
                    foreach ($tbl_perusahaan_approve as $data_perusahaan): 
                      ?>
                       <option value="<?php echo $data_perusahaan->no_api;?>"><?php echo $data_perusahaan->namaPerusahaan;?></option>
                    
                    <?php
                       endforeach;
                     }else{

                        
                     }
                     ?>
</select>
<br>
<input type="submit" name="submit"  value="Approve"  class="submit-wrc">
<table border="0" id="myTable" >
            <thead>
                <tr>            
                    <th width="25px" rowspan="2"><!--<input type="checkbox" id="checkAll" name="checkAll">-->
                       Pilih Semua <input type="checkbox" id="checkAll" name="checkAll">
                        <!--<label  for="checkAll">No</label>-->
                    </th>
                 
                    <th  rowspan="2">No API</th>
                    <th rowspan="2">Perusahaan</th>
                   <th rowspan="2">Jenis</th>
                   <th rowspan="2">Uraian Barang</th>
                   <th rowspan="2">HS10Digit</th>
                   <th rowspan="2">Volume</th>
                   <th rowspan="2">Satuan</th>
                   <th rowspan="2">Harga Satuan</th>
                   <th rowspan="2">Nilai CIF</th>
                   <th rowspan="2">Nilai CNF</th>
                   <th rowspan="2"rowspan="2">Nilai FOB</th>
                 
                   <th rowspan="2">Mata Uang</th>
                   <th rowspan="2">Negara Asal</th>
                     <th rowspan="2">Pelabuhan Asal</th>
                   <th rowspan="2">Pelabuhan Tujuan</th>
                   <th colspan="2">LS</th>

                   <th colspan="2" >PIB</th>
                   <th rowspan="2">Status</th>
                </tr>
<tr>
      <th>No</th>
      <th>Tgl</th>
      <th>No</th>
      <th>Tgl</th>
    </tr>
            </thead>
            <tbody>
                <?php
                $i=1;
if (count($tabel_api)>0) {
                    
                    foreach ($tabel_api as $data):
                        ?>
                        <tr>
                            <td align="center"><input type="checkbox" name="msg[]" value="<?php echo $data->id; ?>">
                               <!-- <input type="checkbox" id="<?php echo $i;?>" name="msg[]" value="<?php echo $data->id; ?>">
                        <label style="font-size: 11px;" for="<?php echo $i;?>"><?php echo $i++;?></label>-->
                            </td>
                            <td><?php echo $data->no_api; ?></td>
                            <td><?php echo 'perusahaan'; ?></td>
                            <td><?php echo $data->jenis_api; ?></td>
                            <td><?php echo $data->uraian_barang; ?></td>
                            <td><?php echo $data->hs10digit; ?></td>
                            <td><?php echo $data->volume; ?></td>
                            <td><?php echo $data->satuan; ?></td>
                            <td><?php echo $data->harga_satuan; ?></td>
                            <td><?php echo $data->nilai_cif; ?></td>
                            <td><?php echo $data->nilai_cnf; ?></td>
                            <td><?php echo $data->nilai_fob; ?></td>
                            <td><?php echo $data->currency; ?></td>
                            
                            <td><?php echo $data->negara_asal; ?></td>
                            <td><?php echo $data->pelabuhan_asal; ?></td>
                            <td><?php echo $data->pelabuhan_tujuan; ?></td>
                            <td><?php echo $data->nomor_ls; ?></td>
                            <td><?php echo $data->tgl_ls; ?></td>
                            <td><?php echo $data->nomor_pib; ?></td>
                            <td><?php echo $data->tgl_pib; ?></td>
                            <td><?php echo $data->flag; ?></td>
                        
                           
                        </tr>
                        <?php
                    endforeach;
                    $i++;
                }

                else {
                    echo "<tr><td colspan=5>DATA KOSONG!!</td></tr>";
                }
                ?>
                <script type="text/javascript" src="<?php echo base_url(''); ?>assets/js/jquery-1.5.2.min.js"></script>
    <script type="text/javascript">
     var u = jQuery.noConflict();
        u(document).ready(function() {
            u("input[name='checkAll']").click(function() {
                var checked = u(this).attr("checked");
                u("#myTable tr td input:checkbox").attr("checked", checked);
            });
        });
    </script>
            </tbody>
        </table>
    </form>
<br style="clear: both" />
       </div>
       </div>
       </div>
