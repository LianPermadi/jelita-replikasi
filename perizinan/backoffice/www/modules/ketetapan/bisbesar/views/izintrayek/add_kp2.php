<?php if(@$msg<>"") 
{
   if(@$msg == "sukses")
    {
    ?>
    <script>alert("Data Berhasil disimpan");//window.location.href='../../bisbesar/c_izintrayek'</script>

    <?php
   
    }else{
    ?>
    <script>alert("Data gagal disimpan");//window.location.href='../../bisbesar/c_izintrayek'</script>
    <?php

}

}
?>
<?php 

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

foreach($bb_nosk as $u)
{
$NO_SK = $u->NO_SK;
$PIT_ID = $u->PIT_ID;
$PAU_ID = $u->PAU_ID;
$TG_SK = $u->TG_SK;
}
?>
<!------------------------ auto complete ---->
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


  <script type='text/javascript' src='<?php echo base_url();?>assets/autocomplete/js/jquery-1.8.2.min.js'></script>
    <script type='text/javascript' src='<?php echo base_url();?>assets/autocomplete/js/jquery.autocomplete.js'></script>
    <link href='<?php echo base_url();?>assets/autocomplete/js/jquery.autocomplete.css' rel='stylesheet' />
   <!--<link href='<?php  echo base_url();?>assets/autocomplete/css/default.css' rel='stylesheet' />-->

    <script type='text/javascript'>
        var site = "<?php echo site_url();?>";
        $(function(){
            $('.autocomplete').autocomplete({
                serviceUrl: site+'/autocomplete/search',
                onSelect: function (suggestion) {
                    $('#v_nim').val(''+suggestion.nama);
                    $('#v_jurusan').val(''+suggestion.jurusan);
                }
            });
        });
    </script>


    <script>
function tarif(data) {
if(data.value =="BIS BESAR"){
document.getElementById ("tf").value = <?php echo $BB;?>
}else if(data.value =="BIS SEDANG"){
document.getElementById ("tf").value = <?php echo $BS;?>
}else if(data.value =="BIS KECIL"){
document.getElementById ("tf").value = <?php echo $BK;?>
}else if(data.value =="ANGKOT"){
document.getElementById ("tf").value = '0'>
}else if(data.value =="TAKSI"){
document.getElementById ("tf").value = '0'
}else if(data.value =="ANGKUTAN KHUSUS"){
document.getElementById ("tf").value = '0'
}
}
</script>

<!-- end auto complete -->



<div id="content">
    <div class="post">
        <div class="title">
            <h2><?php echo $page_name; ?></h2>
        </div>
<div class="entry">

<form method = "POST" action = "<?php echo base_url();?>bisbesar/c_izintrayek/add_kp_aksi" enctype="multipart/form-data">


 <input type="text" name ="TG_SK" class="form-control" value="<?php echo $TG_SK;?>" required>
 <input type="text" name ="NO_SK" class="form-control" value="<?php echo $NO_SK;?>" required >
 <input type="text" name ="PAU_ID" class="form-control" value="<?php echo $PAU_ID;?>" required >
 <input type="text" name ="TRA_ID" id="v_jurusan" class='form-control autocomplete'  required>
 <input type="text" name ="PIT_ID"  class="form-control" value="<?php echo $PIT_ID;?>" >
 <input type="text" name ="NO_IK_KEY" class="form-control" >



            <br style="clear: both" />
            <label>TANGGAL</label>
            <input type="text" name ="TG_KP" class="form-control" value='<?php echo date("Y-m-d");?>' readonly  id="datepicker"  required>
            &nbsp;&nbsp;&nbsp;SP ke &nbsp;&nbsp;
            <input type="text" name ="SP_KE" class="form-control"  style="width:207px;" required >

            <br style="clear: both" />
            <label>JENIS KP</label>
             <select name ="JENIS_KP" class="form-control select" style="width:207px;" >           
            <option  value = 1 >DAFTAR ULANG</option>
            <option  value = 2 >PENGGANTIAN</option>
            <option  value = 3 >PELIMPAHAN</option>
            <option  value = 4 >PENAMBAHAN</option>
            <option  value = 5 >DUPLIKAT</option>
            </select> 
            &nbsp;&nbsp;&nbsp;Bln &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="text" name ="TELAT_BL" class="form-control" required>
            <br style="clear: both" />

            <label>JENIS ANGKUTAN / TARIF</label>
          <!--<select name ="JENIS" class="form-control select" style="width:207px;"  onchange="tarif(this)">
            <option value = 'BIS BESAR' >BIS BESAR</option>
            <option  value = 'BIS SEDANG' >BIS SEDANG</option>
            <option  value = 'BIS KECIL' >BIS KECIL</option>
            <option  value = 'ANGKOT' >ANGKOT</option>
            <option  value = 'TAKSI' >TAKSI</option>
            <option  value = 'ANGKUTAN KHUSUS' >ANGKUTAN KHUSUS</option>
            </select> -->

<select name ="JENIS" class="form-control select" style="width:207px;"onchange="tari(this)" >
            <option  value = "BIS BESAR" >BIS BESAR</option>
            <option  value = "BIS SEDANG" >BIS SEDANG</option>
            <option  value = "BIS KECIL" >BIS KECIL</option>
            <option  value = "ANGKOT" >ANGKOT</option>
            <option  value = "TAKSI" >TAKSI</option>
            <option  value = "ANGKUTAN KHUSUS" >ANGK. KHUSUS</option>

</select>


            &nbsp;&nbsp;&nbsp;Denda &nbsp;
            <input type="text" name ="DENDA_BAND" class="form-control"   required>

            <br style="clear: both" />
            <label>TARIF BAND</label>
<input type="number" name ="TARIF"   onkeyup="hitung2();" id="tfx" value="<?php echo $BB;?>" onkeypress="return isNumberKey(event)" class="a2"  style="width:92px;">
            <!--<input type="number" name ="TARIF"   onkeyup="hitung2();" id="tf" value="<?php echo $BB;?>" onkeypress="return isNumberKey(event)" class="a2"  style="width:92px;">-->
             x 
            <input type="number" onkeyup="hitung2();" onkeypress="return isNumberKey(event)" class="b2" name ="TELAT_TH" style="width:92px;" required="true"  >
             &nbsp;&nbsp;&nbsp;Total &nbsp;&nbsp;&nbsp;
            <input type="text" name ="TARIF_BAND" class="c2" readonly="true"  required  >
            <br style="clear: both" />
            <label>NOMOR INDUK / NOMOR KP</label>
            <input type="text" name ="NOMOR_KP" class="form-control" required>

            <br style="clear: both" />
            <label>NOMOR POLISI</label>
            <input type="text" name ="NO_MOBIL" class="form-control" style="width:94px;" required>
             
            <input type="text" name ="EX_NO_MOBI" class="form-control" style="width:94px;"  > 
            <br style="clear: both" />
            <label>NOMOR UJI</label>
           <input type="text" name ="NO_UJI" class="form-control" style="width:94px;" required>
             
            <input type="text" name ="EX_NO_UJI" class="form-control" style="width:94px;"> 

            <br style="clear: both" />
            <label>MERK / TAHUN</label>
            <input type="text" name ="MERK" class="form-control" style="width:138px;" required>
            <input type="text" name ="TAHUN_PEMB" class="form-control" style="width:50px;" required>
            <br style="clear: both" />
            <label>BAHAN BAKAR</label>
             <select name ="BBM" class="form-control select" style="width:207px;" >
           
          <option  value = '1' >BENSIN</option>
            <option  value = '2' >SOLAR</option>
            <option  value = '3' >GAS</option>
            <option  value = '4' >PREMIX</option>
            </select> 

            <!--<br style="clear: both" />
            <label>JENIS KENDARAAN</label>
            <input type="text" name ="" class="form-control" value="<?php echo $JENIS ;?> " >-->

            <br style="clear: both" />
            <label>DA ORANG / BRNG</label>
             <input type="number" min ="0" name ="DA_ORANG" class="form-control" style="width:94px;" required >
             
            <input type="number"  min ="0" name ="DA_BARANG" class="form-control" style="width:94px;" required> 

            <br style="clear: both" />
            <label>JENIS PELAYANAN</label>
            
           <select name ="PELAYANAN" class="form-control select" style="width:207px;" >
            
          <option  value = '1' >AKDP</option>
            <option  value = '2' >DALAM KOTA</option>
            <option  value = '3' >DOOR TO DOOR SERV</option>
            <option  value = '4' >ANGKUTAN KHUSUS</option>
            </select>

            <br style="clear: both" />
             <label>SIFAT / FASILITAS</label>
             <input type="checkbox" name="AC" value ='1'>AC
             <input type="checkbox" name="TOILET" value ='1'>Toilet
             <input type="checkbox" name="RCSET" value ='1'>RC Set
             <br style="clear: both" />
            <label>SIFAT PERJALANAN</label>
            <select name ="SP" class="form-control select" style="width:207px;" >
           
          <option value = '1' >PATAS</option>
            <option  value = '2' >EKONOMI</option>
            </select>

           <!-- <br style="clear: both" />
            <label>NOMOR KP</label>
            <input type="text" name ="" class="form-control" value = "<?php echo $NOMOR_KP;?>" >-->
           
           <br style="clear: both" />

            <label>TANGGAL</label>
            <input type="text" name ="TG_KP" class="form-control" style="width:82px;" id="datepicker1" value="<?php echo date("Y-m-d");?>" readonly required> s/d
            <input type="text" name ="TG_KPSK" class="form-control" style="width:82px;" id="datepicker2" readonly required>
            <br style="clear: both" />

            <label>MASA BERLAKU</label>
           <input type="text" name ="TG_MULAI" value="<?php echo date("Y-m-d");?>" class="form-control" style="width:82px;" id="datepicker3"  readonly required> s/d
            <input type="text" name ="TG_AKHIR" class="form-control" style="width:82px;" id="datepicker4"  readonly required>
            <br style="clear: both" />

            <label>KODE TRAYEK</label>
            <input type="search" name ="KODE_TRAYE" class='autocomplete' id="autocomplete1" required="true" >
            <br style="clear: both" />

            <label>NAMA TRAYEK</label>
           <!-- <input type="search" name =""  class='autocomplete' style="width: 800px; " id="autocomplete1" value="<?php echo $NAMA_TRAYE; ?>" >-->
           <textarea type="text" name="NAMA_TRAYE"  class='form-control autocomplete' id="v_nim"  cols="50" rows="4" readonly ></textarea>
            <br style="clear: both" />

            <label>PEMILIK</label>
            <input type="text" name ="NAMA_STNK"  class="form-control"  required>
            <br style="clear: both" />

            <label>ALAMAT</label>
           <textarea class="input-area-wrc" name="ALAMAT_STN" required></textarea>
            <br style="clear: both" />

            <label>CATATAN</label>
           <textarea class="input-area-wrc" name="CATATAN"></textarea>
            <br style="clear: both" />

            <label>HISTORY</label>
             <textarea class="input-area-wrc" name ="HISTORI"></textarea>
            <br style="clear: both" />



            <button class="button-wrc" style="margin-left: 100px;" onclick="return confirm('Apakah benar data akan disimpan?');">Simpan</button>
            <a href = <?php echo base_url().'bisbesar/c_izintrayek';?> class= 'button-wrc' style="text-decoration: none;" >Batal</a>
           
    </form>










 <script>
function tari(data) {
if(data.value =="BIS BESAR"){
document.getElementById ("tfx").value = <?php echo $BB;?>
}else if(data.value =="BIS SEDANG"){
document.getElementById ("tfx").value = <?php echo $BS;?>
}else if(data.value =="BIS KECIL"){
document.getElementById ("tfx").value = <?php echo $BK;?>
}else if(data.value =="ANGKOT"){
document.getElementById ("tfx").value = <?php echo '0';?>
}else if(data.value =="TAKSI"){
document.getElementById ("tfx").value = '0'
}else if(data.value =="ANGKUTAN KHUSUS"){
document.getElementById ("tfx").value = '0'
}
}
</script>
 
  

<br style="clear: both" />
       </div>
       </div>
       </div>
