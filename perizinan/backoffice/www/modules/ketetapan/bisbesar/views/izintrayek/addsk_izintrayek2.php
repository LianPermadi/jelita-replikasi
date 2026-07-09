<?php if(@$msg<>"") 
{
   if(@$msg == "sukses")
    {
    ?>
    <script>alert("Data Berhasil disimpan");window.location.href='../../bisbesar/c_izintrayek'</script>

    <?php
   
    }else{
    ?>
    <script>alert("Data gagal disimpan");window.location.href='../../bisbesar/c_izintrayek'</script>
    <?php

}

}
$NO_IP = "";
$NAMA_PERUS = "";
$NAMA_PEMIL = "";
$ALAMAT_PER = "";
$ALAMAT_PEM = "";
$KODYA_ID_P = "";
$NAMA_KODYA = "";

foreach($bb_tarif as $u)
{
$BK = $u->BK;
$BS = $u->BS;
$BB = $u->BB;
$TAXI = $u->TAXI;

$SK_BK = $u->SK_BK;
$SK_BS = $u->SK_BS;
$SK_BB = $u->SK_BB;
$SK_MPU = $u->SK_MPU;
}


foreach($bb_pengusaha as $u)
{
$NO_IP = $u->NO_IP;
$NAMA_PERUS = $u->NAMA_PERUS;
$NAMA_PEMIL = $u->NAMA_PEMIL;
$ALAMAT_PER = $u->ALAMAT_PER;
$ALAMAT_PEM =$u->ALAMAT_PEM;
$KODYA_ID_P = $u->KODYA_ID_P;
$NAMA_KODYA = $u->NAMA_KODYA;
}
?>
<div id="content">
    <div class="post">
        <div class="title">
            <h2><?php echo $page_name; ?></h2>
        </div>
<div class="entry">
<div class="contentForm">
                                    <?php
                                    echo form_label('');
                                 //   echo anchor(site_url('pelayanan/pendaftaran/daftar_izin_list'), 'Ambil Data Pemohon Izin', 'class="link-wrc" rel="daftar_box"');
                                      echo anchor(site_url('bisbesar/c_popup/daftar_izin_list'), 'Ambil Data Pengusaha', 'class="link-wrc" rel="daftar_box"');
                                    ?>
                                </div>
                                <br style="clear: both" />

 <form method = "POST" action = "<?php echo base_url();?>bisbesar/c_izintrayek/tambahSK_aksi" enctype="multipart/form-data">
             
<!--<input type="hidden" name ="PIT_ID" class="form-control" value = "<?php echo $PIT_ID;?>" >
            <br style="clear: both" />-->
            <label>KATEGORI PERIZINAN</label>
             <select name ="BAGIAN" class="form-control select" style="width:207px;" >
            <option  value = 1 >PERIZINAN BIS</option>
            <option  value = 2 >PERIZINAN NON BIS</option>
            <option  value = 3 >PERIZINAN ANGKUTAN KHUSUS</option>
            </select> 
            
            <br style="clear: both" />

            <label>TANGGAL</label>
            <input type="text" name ="TGL_BAND" class="form-control" readonly  id="datepicker" value="<?php echo date("Y-m-d");?>" >
           
            <br style="clear: both" />
            <label>JENIS SK</label>
             <select name ="JENIS_SK" class="form-control select" style="width:207px;" >
            <option  value = 1 >DAFTAR ULANG</option>
            <option  value = 2 >PENGGANTIAN</option>
            <option  value = 3 >PELIMPAHAN</option>
            <option  value = 4 >PENAMBAHAN</option>
            <option  value = 5 >DUPLIKAT</option>
            </select> TAHUN <input type="number" name ="TELAT_TH" value="1" min="0" >
            
            <br style="clear: both" />

            <label>JENIS ANGKUTAN</label>
          <select name ="JENIS_ANGK" class="form-control select" style="width:207px;"onchange="tarif(this)" >
            <option  value = 1 >BIS BESAR</option>
            <option  value = 2 >BIS SEDANG</option>
            <option  value = 3 >BIS KECIL</option>
            <option  value = 4 >ANGKOT</option>
            <option  value = 5 >TAKSI</option>
            <option  value = 6 >ANGK. KHUSUS</option>
</select> BULAN &nbsp;<input type="number" name ="TELAT_BL" value="1" min="0">

          
            <br style="clear: both" />

            <label>TARIF BAND</label>
            <input type="number" name ="TARIF_BAND" style="width:204px;" id="tf" value="<?php echo $SK_BB;?>"> DENDA 
            <input type="number" name ="DENDA_BAND" value="0" min="0">
            <br style="clear: both" />

            <!--<label>TAHUN</label>
            <input type="number" name ="TELAT_TH" value="1" min="0" >
            <br style="clear: both" />-->

            <!--<label>BULAN</label>
            <input type="number" name ="TELAT_BL" value="1" min="0">

              <br style="clear: both" />-->
            <!--<label>DENDA</label>
            <input type="number" name ="DENDA_BAND" value="0" min="0">
           
            <br style="clear: both" />-->

            <label>NOMOR INDUK</label>
            <input type="text" name ="NO_IP" readonly required class='autocomplete' id="autocomplete1" value="<?php echo $NO_IP;?>">

            <br style="clear: both" />
            <label>NAMA PERUSAHAAN</label>

            <input type="text" name ="NAMA_PERUS" readonly class="form-control" id="v_nama_perus" value="<?php echo $NAMA_PERUS;?>"> 
            <br style="clear: both" />
            <label>ALAMAT PERUSAHAAN</label>
            <textarea  name ="ALAMAT_PER" readonly id="v_alamat_per" class="input-area-wrc" ><?php echo $ALAMAT_PER;?></textarea>

            <br style="clear: both" />
            <label>KAB / KOTA</label>
            <input type="hidden" name ="KODYA_ID" id="v_kodya_id" class="form-control" readonly value="<?php echo $KODYA_ID_P;?>">
            <input type="text" name ="KOTA" id="v_kodya" class="form-control" readonly value= "<?php echo $NAMA_KODYA;?>" >
           

            <br style="clear: both" />
            <label>NAMA PIMPINAN</label>
            <input type="text" name ="PEMILIK" id="v_nama_pem" class="form-control" readonly value="<?php echo $NAMA_PEMIL;?>">
           
            <br style="clear: both" />
            <label>ALAMAT PIMPINAN</label>
           <textarea  name ="ALAMAT_PEM" id="v_alamat_pem" class="input-area-wrc" readonly><?php echo $ALAMAT_PEM;?></textarea>
           
            <br style="clear: both" />
            <label>NOMOR SK</label>
             <input type="text" name ="NO_SK" class="form-control" required >
              <br style="clear: both" />

            <label>MASA BERLAKU</label>
            <input type="text" name ="TG_SK"  class="form-control" readonly  id="datepicker1" style="width:82px" value="<?php echo date("Y-m-d");?>"> s/d 
            
            <input type="text" name ="BERLAKU" class="form-control" readonly  id="datepicker2" style="width:82px">
            <br style="clear: both" />

            <label>MENCABUT SK NOMOR</label>
            <input type="text" name ="NO_SK_LAMA"  class="form-control" >
            <br style="clear: both" />

            <label>TANGGAL SK LAMA</label>
            <input type="text" name ="TG_SK_LAMA"  class="form-control"  readonly id="datepicker3" >
            <br style="clear: both" />


            <button class="button-wrc" style="margin-left: 100px;" onclick="return confirm('Apakah benar data dengan akan ditambahkan?');">Simpan</button>
            <a href = <?php echo base_url().'bisbesar/c_izintrayek';?> class= 'button-wrc' style="text-decoration: none;" >Batal</a>
           
    </form>


<br style="clear: both" />
       </div>
       </div>
       </div>
<link rel="stylesheet" href="<?php echo base_url();?>assets/autocomplete/js/jquery-ui.css"> 
<script src="<?php echo base_url();?>assets/autocomplete/js/jquery-1.10.2.js"></script> 
<script src="<?php echo base_url();?>assets/autocomplete/js/jquery-ui.js"></script>
<script type="text/javascript"> 
var f=jQuery.noConflict();
<!-- akhir auto complete -->
f(function() { 
 var date = f('#datepicker').datepicker({ dateFormat: 'yy-mm-dd' }).val();
 var date = f('#datepicker1').datepicker({ dateFormat: 'yy-mm-dd' }).val();
 var date = f('#datepicker2').datepicker({ dateFormat: 'yy-mm-dd' }).val();
 var date = f('#datepicker3').datepicker({ dateFormat: 'yy-mm-dd' }).val();
 var date = f('#datepicker4').datepicker({ dateFormat: 'yy-mm-dd' }).val();
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
<!--<script type='text/javascript' src='<?php echo base_url();?>assets/autocomplete/js/jquery-1.8.2.min.js'></script>
    <script type='text/javascript' src='<?php echo base_url();?>assets/autocomplete/js/jquery.autocomplete.js'></script>
    <link href='<?php echo base_url();?>assets/autocomplete/js/jquery.autocomplete.css' rel='stylesheet' />-->
   <!--<link href='<?php  echo base_url();?>assets/autocomplete/css/default.css' rel='stylesheet' />-->

   <!-- <script type='text/javascript'>
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
    </script>-->

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