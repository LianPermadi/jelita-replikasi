<?php
$pesan='';
if ($jenis_list == 1) {
    
    echo "<option value=''>Pilih Kabupaten : </option>";  
    foreach ($list as $row) {
        echo "<option value='$row->id'>$row->n_kabupaten </option>";  
    }
   
} elseif ($jenis_list == 2) {
    
    echo "<option value=''>Pilih Kecamatan : </option>";  
    foreach ($list as $row) {
        echo "<option value='$row->id'>$row->n_kecamatan </option>";  
    }
    
} elseif($jenis_list == 3){
    
    echo "<option value=''>Pilih Kelurahan : </option>";  
    foreach ($list as $row) {
        echo "<option value='$row->id'>$row->n_kelurahan </option>";  
    }    

  
}

if ($jenis_list == 10) {

    if ($list) {
        $op_kab[0] = '--Pilih Salah Satu--';
        foreach ($list as $row) {
            $op_kab[$row->id] = $row->n_kabupaten;
        }
         echo form_dropdown('kabupaten2', $op_kab, '', "id=id_kabupaten2");
    } else {
        echo '<select name="kabupaten2" id="id_kabupaten2">
                                          <option align="center" value="0">--</option>
                                          </select>';
    }
   
} elseif ($jenis_list == 20) {
    if ($list) {
        $op_kec[0] = '--Pilih Salah Satu--';
        foreach ($list as $row) {
            $op_kec[$row->id] = $row->n_kecamatan;
        }
        echo form_dropdown('kecamatan2', $op_kec, '', "id=id_kecamatan2");
    } else {
      echo '<select  name="kecamatan2" id="id_kecamatan2"><option align="center" value="0">--</option></select>';
    }
    
}  elseif($jenis_list == 30){
    if ($list) {
        $op_kel[0] = '--Pilih Salah Satu--';
        foreach ($list as $row) {
            $op_kel[$row->id] = $row->n_kelurahan;
        }
        echo form_dropdown('kelurahan2', $op_kel,'', "id=id_kelurahan2");
    } else {
        echo '<select id="id_kelurahan2" name="kelurahan2"><option align="center" value="0">--</option></select>';
    }
    
}
?>

<script>
    $(document).ready(function() {
        var def_kec='<select  name="kecamatan1" id="id_kecamatan"><option align="center" value="0">--</option></select>';
        var def_kel='<select id="id_kelurahan" name="kelurahan1"><option align="center" value="0">--</option></select>';
        var def_kec2='<select  name="kecamatan2" id="id_kecamatan2"><option align="center" value="0">--</option></select>';
        var def_kel2='<select id="id_kelurahan2" name="kelurahan2"><option align="center" value="0">--</option></select>';
        
        $("#id_kabupaten").change(function(){
            var id=$("#id_kabupaten").val();
            $("#dt_Kecamatan").load(site+'main/pendaftaran_online/list_daerah/2/'+id);
            $("#dt_Kelurahan").html(def_kel);
            //
             $("#id_kabupaten_error").html("");
            $("#id_kecamatan_error").html("");
            $("#id_kelurahan_error").html("");
        });
        $("#id_kecamatan").change(function(){
            var id=$("#id_kecamatan").val();
            $("#dt_Kelurahan").load(site+'main/pendaftaran_online/list_daerah/3/'+id);
             //
            $("#id_kecamatan_error").html("");
            $("#id_kelurahan_error").html("");
        });
        $("#id_kabupaten2").change(function(){
            var id=$("#id_kabupaten2").val();
            $("#dt_Kecamatan2").load(site+'main/pendaftaran_online/list_daerah/20/'+id);
            $("#dt_Kelurahan2").html(def_kel2);
            //
             $("#id_kabupaten2_error").html("");
            $("#id_kecamatan2_error").html("");
            $("#id_kelurahan2_error").html("");
        });
        $("#id_kecamatan2").change(function(){
            var id=$("#id_kecamatan2").val();
            $("#dt_Kelurahan2").load(site+'main/pendaftaran_online/list_daerah/30/'+id);
             
            $("#id_kecamatan2_error").html("");
            $("#id_kelurahan2_error").html("");
        });

    });
</script>