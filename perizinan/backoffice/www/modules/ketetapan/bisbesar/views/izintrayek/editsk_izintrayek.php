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
                serviceUrl: site+'autocomplete/search_pengusaha',
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

<?php 

$PIT_ID ="";
$TGL_BAND = "";
$JENIS_SK ="";
$JENIS_ANGK ="";
$TARIF_BAND ="";
$DENDA_BAND = "";
$NO_IP ="";
$NAMA_PERUS ="";
$ALAMAT_PER = "";
$PEMILIK = "";
$ALAMAT_PEM ="";
$NO_SK = "";
$TG_SK = "";
$BERLAKU = "";
$NO_SK_LAMA = "";
$TELAT_TH = "";
$TELAT_BL ="";
$KODYA_ID ="";
$KOTA = "";

foreach($bb_izintrayek as $u)
{
 
$PIT_ID = $u->PIT_ID;
$TGL_BAND = $u->TGL_BAND;
$JENIS_SK = $u->JENIS_SK;
$JENIS_ANGK = $u->JENIS_ANGK;
$TARIF_BAND = $u->TARIF_BAND;
$DENDA_BAND = $u->DENDA_BAND;
$NO_IP = $u->NO_IP;
$NAMA_PERUS = $u->NAMA_PERUS;
$ALAMAT_PER = $u->ALAMAT_PER;
$KODYA_ID = $u->KODYA_ID;
$KOTA = $u->KOTA;
$PEMILIK = $u->PEMILIK;
$ALAMAT_PEM = $u->ALAMAT_PEM;
$NO_SK = $u->NO_SK;
$TG_SK = $u->TG_SK;
$BERLAKU = $u->BERLAKU;
$NO_SK_LAMA = $u->NO_SK_LAMA;
$TG_SK_LAMA = $u->TG_SK_LAMA;
$TELAT_BL = $u->TELAT_BL;
$TELAT_TH = $u->TELAT_TH;
}
 
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
?>
<div id="content">
    <div class="post">
        <div class="title">
            <h2><?php echo $page_name; ?></h2>
        </div>
<div class="entry">




<form method = "POST" action = "<?php echo base_url();?>bisbesar/c_izintrayek/update_sk_aksi" enctype="multipart/form-data">
             
<input type="hidden" name ="PIT_ID" class="form-control" value = "<?php echo $PIT_ID;?>" >
            <br style="clear: both" />
            <label>TANGGAL</label>
            <input type="text" name ="TGL_BAND" class="form-control" value =" <?php echo $TGL_BAND; ?>" readonly  id="datepicker" >
           
            <br style="clear: both" />
            <label>JENIS SK</label>
             <select name ="JENIS_SK" class="form-control select" style="width:207px;" >
            
            <option selected value = "<?php echo $JENIS_SK; ?>" >
                <?php
                if ($JENIS_SK == '1'){
                    echo 'DAFTAR ULANG';
                } else  if ($JENIS_SK == '2'){
                    echo 'PENGGANTIAN';
                } if ($JENIS_SK == '3'){
                    echo 'PELIMPAHAN';
                } if ($JENIS_SK == '4'){
                    echo 'PENAMBAHAN';
                } if ($JENIS_SK == '5'){
                    echo 'DUPLIKAT';
                }
                ?>

            </option>
            <option  value = 1 >DAFTAR ULANG</option>
            <option  value = 2 >PENGGANTIAN</option>
            <option  value = 3 >PELIMPAHAN</option>
            <option  value = 4 >PENAMBAHAN</option>
            <option  value = 5 >DUPLIKAT</option>
            </select> 
             TAHUN  &nbsp;<input type="number" name ="TELAT_TH" min="0" value ="<?php echo $TELAT_TH;?>" >
            <br style="clear: both" />

            <label>JENIS ANGKUTAN</label>
          <select name ="JENIS_ANGK" class="form-control select" style="width:207px;" onchange="tarif(this)">
            <option selected value = "<?php echo $JENIS_SK; ?>" >
                <?php
                if ($JENIS_SK == '1'){
                    echo 'BIS BESAR';
                } else  if ($JENIS_SK == '2'){
                    echo 'BIS SEDANG';
                } if ($JENIS_SK == '3'){
                    echo 'BIS KECIL';
                } if ($JENIS_SK == '4'){
                    echo 'ANGKOT';
                } if ($JENIS_SK == '5'){
                    echo 'TAKSI';
                }if ($JENIS_SK == '6'){
                    echo 'ANGK. KHUSUS';
                }
                ?>
            </option>
            <option  value = 1 >BIS BESAR</option>
            <option  value = 2 >BIS SEDANG</option>
            <option  value = 3 >BIS KECIL</option>
            <option  value = 4 >ANGKOT</option>
            <option  value = 5 >TAKSI</option>
            <option  value = 6 >ANGK. KHUSUS</option>
</select>
          BULAN  &nbsp; <input type="number" min="0" name ="TELAT_BL"  value ="<?php echo $TELAT_BL;?>" >
            <br style="clear: both" />

            <label>TARIF BAND</label>
            <input type="number" name ="TARIF_BAND" style="width:203px;" min="0" value ="<?php echo $TARIF_BAND;?>"  id="tf">
            DENDA &nbsp;<input type="number" min="0" name ="DENDA_BAND" value="<?php echo $DENDA_BAND;?>"   >
            <br style="clear: both" />

           <!-- <label>TAHUN</label>
            <input type="number" name ="TELAT_TH"  value ="<?php echo $TELAT_TH;?>" >
            <br style="clear: both" />

            <label>BULAN</label>
            <input type="number" name ="TELAT_BL"  value ="<?php echo $TELAT_BL;?>" >

              <br style="clear: both" />
            <label>DENDA</label>
            <input type="number" name ="DENDA_BAND" value="<?php echo $DENDA_BAND;?>"   >
           
            <br style="clear: both" />-->

            <label>NOMOR INDUK</label>
            <input type="search" name ="NO_IP" class='autocomplete' id="autocomplete1" value = "<?php echo $NO_IP;?>" >

            <br style="clear: both" />
            <label>NAMA PERUSAHAAN</label>

            <input type="text" name ="NAMA_PERUS" readonly class="form-control" id="v_nama_perus" value = "<?php echo $NAMA_PERUS;?>" > 
            <br style="clear: both" />
            <label>ALAMAT PERUSAHAAN</label>
            <textarea  name ="ALAMAT_PER" readonly id="v_alamat_per" class="input-area-wrc"><?php echo $ALAMAT_PER;?></textarea>

            <br style="clear: both" />
            <label>KAB / KOTA</label>
            <input type="hidden" name ="KODYA_ID" id="v_kodya_id" class="form-control" readonly value = "<?php echo $KODYA_ID; ?>">
            <input type="text" name ="KOTA" id="v_kodya" class="form-control" readonly value = "<?php echo $KOTA; ?>">
           

            <br style="clear: both" />
            <label>NAMA PIMPINAN</label>
            <input type="text" name ="PEMILIK" id="v_nama_pem" class="form-control" readonly value = "<?php echo $PEMILIK; ?>" >
           
            <br style="clear: both" />
            <label>ALAMAT PIMPINAN</label>
           <textarea  name ="ALAMAT_PEM" id="v_alamat_pem" class="input-area-wrc" readonly><?php echo $ALAMAT_PEM;?></textarea>
           
            <br style="clear: both" />
            <label>NOMOR SK</label>
             <input type="text" name ="NO_SK" class="form-control"  value="<?php echo $NO_SK; ?>" >
              <br style="clear: both" />

            <label>MASA BERLAKU</label>
            <input type="text" name ="TG_SK"  class="form-control" readonly value = "<?php echo $TG_SK;?>" id="datepicker1" style="width:82px"> s/d 
            
            <input type="text" name ="BERLAKU" class="form-control" readonly value="<?php echo $BERLAKU; ?>" id="datepicker2" style="width:82px">
            <br style="clear: both" />

            <label>MENCABUT SK NOMOR</label>
            <input type="text" name ="NO_SK_LAMA"  class="form-control" value ="<?php echo $NO_SK_LAMA; ?>" >
            <br style="clear: both" />

            <label>TANGGAL SK LAMA</label>
            <input type="text" name ="TG_SK_LAMA"  class="form-control" value ="<?php echo $TG_SK_LAMA; ?>" readonly id="datepicker3" >
            <br style="clear: both" />


            <button class="button-wrc" style="margin-left: 100px;" onclick="return confirm('Apakah benar data dengan NO. INDUK <?php echo $NO_IP;?> akan diupdate?');">Update</button>
            <a href = <?php echo base_url().'bisbesar/c_izintrayek';?> class= 'button-wrc' style="text-decoration: none;" >Batal</a>
           
    </form>
<!--<div id="" style="width:100%"">
<div id="" style="width:50%;float:left;margin-left: 5%; ">-->
<!--<table cellpadding="0" cellspacing="0" border="0" class="display" id="izintrayek" >
                <thead>
                    <tr>
                      <th width="" >NO</th>
                       <th width="">NOMOR INDUK</th>
                       <th width="">NOMOR SK</th>
                        <th width="">TANGGAL BAND</th>
                        <th width="">JENIS SK</th>
                        <!--<th width="">TAHUN</th>
                        <th width="">BULAN</th>-->
                       <!-- <th width="">JENIS ANGKUTAN</th>
                        <!--<th width="">TARIF BAND</th>
                        <th width="">DENDA</th>-->

                        
                       <!-- <th width="">NAMA PERUSAHAAN</th>
                        <th width="">ALAMAT PERUSAHAAN</th>
                        <!--<th width="">KABUPATEN / KOTA</th>
                        <th width="">NAMA PIMPINAN</th>
                        <th width="">ALAMAT PIMPINAN</th>-->

                       <!-- <th width="">AKSI</th>
                    </tr>
                </thead>
                <?php
        if($izintrayek_table !== "")
        {

            echo $izintrayek_table;

        }
        else
        {
        ?>

            <tr>
            <td colspan="6"><center>Tidak ada data</center></td>
            </tr>
            <?php } ?>
        </tbody>
                </table>
<!--</div>
<div id="" style="width:30%; float:left; margin-left: 5%;border : 0px solid gray;">
-->

  <!-- </div>
   </div>-->
<br style="clear: both" />
       </div>
       </div>
       </div>
