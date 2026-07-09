<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>


   <script type='text/javascript' src='<?php echo base_url();?>/assets/autocomplete/js/jquery-1.8.2.min.js'></script>
    <script type='text/javascript' src='<?php echo base_url();?>/assets/autocomplete/js/jquery.autocomplete.js'></script>
    <link href='<?php echo base_url();?>/assets/autocomplete/js/jquery.autocomplete.css' rel='stylesheet' />
   <!--<link href='<?php  echo base_url();?>assets/autocomplete/css/default.css' rel='stylesheet' />-->

   <!--<script type='text/javascript'>
        var site = "<?php echo site_url();?>";
        $(function(){
            $('.autocomplete').autocomplete({
                // serviceUrl berisi URL ke controller/fungsi yang menangani request kita
                serviceUrl: site+'/autocomplete/search',
                // fungsi ini akan dijalankan ketika user memilih salah satu hasil request
                onSelect: function (suggestion) {
                    $('#v_nim').val(''+suggestion.nim); // membuat id 'v_nim' untuk ditampilkan
                    $('#v_jurusan').val(''+suggestion.jurusan); // membuat id 'v_jurusan' untuk ditampilkan
                }
            });
        });
    </script>-->

 <script type='text/javascript'>
        var site = "<?php echo site_url();?>";
        $(function(){
            $('.autocomplete').autocomplete({
                serviceUrl: site+'/autocomplete/search_pengusaha',
                onSelect: function (suggestion) {
                    $('#v_nama_perus').val(''+suggestion.nama_perus);
                    $('#v_alamat_per').val(''+suggestion.alamat_per);
                    $('#v_kodya_id').val(''+suggestion.kodya_id);
                    $('#v_nama_pem').val(''+suggestion.nama_pem);
                    $('#v_alamat_pem').val(''+suggestion.alamat_pem);
                    $('#v_kodya').val(''+suggestion.kodya);

                }
            });
        });
    </script>

<script>
function hitung2() {
var a = $(".a2").val();
var b = $(".b2").val();
c = a * b; //a kali b
$(".c2").val(c);
}
function isNumberKey(evt){
 var charCode = (evt.which) ? evt.which : event.keyCode;
 if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57))
 return false;
 return true;
}
</script>


     


<script>
function tarif(data) {
if(data.value ==1){
document.getElementById ("tf").value = <?php echo $SK_BB;?>
}else if(data.value ==2){
document.getElementById ("tf").value = <?php echo $SK_BS;?>
}else if(data.value ==3){
document.getElementById ("tf").value = <?php echo $SK_BK;?>
}else if(data.value ==4){
document.getElementById ("tf").value = <?php echo $SK_MPU;?>
}else if(data.value ==5){
document.getElementById ("tf").value = '0'
}else if(data.value ==6){
document.getElementById ("tf").value = '0'
}
}
</script>
<!-- end auto complete -->



<div id="content">



<label>NOMOR INDUK</label>
            <input type="search" name ="NO_IP" class='autocomplete nama' id="autocomplete1" >

            <br style="clear: both" />
            <label>NAMA PERUSAHAAN</label>

            <input type="text" name ="NAMA_PERUS" readonly class="form-control" id="v_nama_perus"  > 
            <br style="clear: both" />
            <label>ALAMAT PERUSAHAAN</label>
            <textarea  name ="ALAMAT_PER" readonly id="v_alamat_per" class="input-area-wrc"></textarea>

            <br style="clear: both" />
            <label>KAB / KOTA</label>
            <input type="hidden" name ="KODYA_ID" id="v_kodya_id" class="form-control" readonly >
            <input type="text" name ="KOTA" id="v_kodya" class="form-control" readonly >
           

            <br style="clear: both" />
            <label>NAMA PIMPINAN</label>
            <input type="text" name ="PEMILIK" id="v_nama_pem" class="form-control" readonly >
           
            <br style="clear: both" />
            <label>ALAMAT PIMPINAN</label>
           <textarea  name ="ALAMAT_PEM" id="v_alamat_pem" class="input-area-wrc" readonly></textarea>
           

</div>

