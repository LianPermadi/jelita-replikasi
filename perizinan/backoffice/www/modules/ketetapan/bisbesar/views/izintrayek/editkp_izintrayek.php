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
<!-- end auto complete -->
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
?>
<?php 

$NO_SK = "";
$TG_SK = "";
$NAMA_PERUS ="";
$ALAMAT_PER = "";
$JENIS = "";
$JENIS_KP = "";

$KODE_TRAYE = "";
$NAMA_TRAYE = "";


$NAMA_PEMIL = "";
$ALAMAT_PEM = "";
$CATATAN = "";
$HISTORI = "";
$NO_IK = "";
$MERK = "";
$TAHUN_PEMB = "";
$DA_ORANG = "";
$DA_BARANG = "";
$BBM = "";
$NO_UJI ="";
$NO_MOBIL = "";
$AC = "";
$TOILET ="";
$RCSET = "";
$SP = "";
$PELAYANAN = "";
$TG_KP ="";
$TG_KPSK="";
$TG_MULAI = "";
$TG_AKHIR = "";
$EX_NO_MOBI ="";
$EX_NO_UJI = "";
$TARIF_BAND = "";
$TELAT_TH = "";
$TELAT_BL = "";
$DENDA_BAND ="";
$SP = "";
$SP_KE = "";
$TARIF ="";
$NOMOR_KP ="";
$PIT_ID = "";
$TRA_ID = "";

foreach($bb_izintrayek as $u)
{
 /*$NO_SK =  $u->NO_SK;
 $TG_SK = $u->TG_SK;
 $NAMA_PERUS = $u->NAMA_PERUS;
 $ALAMAT_PER = $u->ALAMAT_PER;
*/
$TRA_ID = $u->TRA_ID;
$KODE_TRAYE = $u->KODE_TRAYE;
$NAMA_TRAYE = $u->NAMATRAYEK;
$NOMOR_KP = $u->NOMOR_KP;
$NO_IK = $u->NO_IK;
$MERK = $u->MERK;
$TAHUN_PEMB = $u->TAHUN_PEMB;
$JENIS = $u->JENIS;
$JENIS_KP = $u->JENIS_KP;

$NAMA_STNK = $u->NAMA_STNK;
$ALAMAT_PEM = $u->ALAMAT_STN;
$CATATAN = $u->CATATAN;
$HISTORI = $u->HISTORI;
$DA_ORANG = $u->DA_ORANG;
$DA_BARANG = $u->DA_BARANG;
$BBM = $u->BBM;
$NO_UJI = $u->NO_UJI;
$NO_MOBIL = $u->NO_MOBIL;

$AC = $u->AC;
$TOILET = $u->TOILET;
$RCSET = $u->RCSET;
$SP = $u->SP;
$SP_KE = $u->SP_KE;
$PELAYANAN = $u->PELAYANAN;
$TG_KP = $u->TG_KP;
$TG_KPSK = $u->TG_KPSK;
$TG_MULAI = $u->TG_MULAI;
$TG_AKHIR = $u->TG_AKHIR;
$EX_NO_MOBI = $u->EX_NO_MOBI;
$EX_NO_UJI = $u->EX_NO_UJI;
$TARIF_BAND = $u->TARIF_BAND;
$TELAT_TH = $u->TELAT_TH;
$TELAT_BL = $u->TELAT_BL;
$DENDA_BAND = $u->DENDA_BAND;
$TARIF = $u->TARIF;
$PIT_ID = $u->PIT_ID;
}
 ?>

<div id="content">
    <div class="post">
        <div class="title">
            <h2><?php echo $page_name; ?></h2>
        </div>
<div class="entry">
<form method = "POST" action = "<?php echo base_url();?>bisbesar/c_izintrayek/update_kp_aksi" enctype="multipart/form-data">
<input type="hidden" name ="TRA_ID" id="v_jurusan" class='form-control autocomplete' value="<?php echo $TRA_ID;?>"  >
              <input type="hidden" name ="PIT_ID"  class="form-control" value ="<?php echo $PIT_ID; ?>" >
<input type="hidden" name ="NO_IK_KEY" class="form-control" value = "<?php echo $NO_IK;?>" >
            <br style="clear: both" />
            <label>TANGGAL</label>
            <input type="text" name ="TG_KP" class="form-control" value =" <?php echo date("Y-m-d"); ?>" readonly  id="datepicker" >
            &nbsp;&nbsp;&nbsp;SP ke &nbsp;&nbsp;
            <input type="text" name ="SP_KE" class="form-control" value = "<?php echo $SP_KE; ?>"  style="width:207px;"  >

            <br style="clear: both" />
            <label>JENIS KP</label>
             <select name ="JENIS_KP" class="form-control select" style="width:207px;" >
            
            <option selected value = "<?php echo $JENIS_KP; ?>" >
                <?php
                if ($JENIS_KP == '1'){
                    echo 'DAFTAR ULANG';
                } else  if ($JENIS_KP == '2'){
                    echo 'PENGGANTIAN';
                } if ($JENIS_KP == '3'){
                    echo 'PELIMPAHAN';
                } if ($JENIS_KP == '4'){
                    echo 'PENAMBAHAN';
                } if ($JENIS_KP == '5'){
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
            &nbsp;&nbsp;&nbsp;Bln &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="text" name ="TELAT_BL" class="form-control" value = "<?php echo $TELAT_BL ?>"   >
            <br style="clear: both" />

            <label>JENIS ANGKUTAN / TARIF</label>
          <!--<select name ="JENIS" class="form-control select" style="width:207px;" >
            <option selected value = '<?php echo $JENIS;?>' ><?php echo $JENIS;?></option>
            <option value = 'BIS BESAR' >BIS BESAR</option>
            <option  value = 'BIS SEDANG' >BIS SEDANG</option>
            <option  value = 'BIS KECIL' >BIS KECIL</option>
            <option  value = 'ANGKOT' >ANGKOT</option>
            <option  value = 'TAKSI' >TAKSI</option>
            <option  value = 'ANGKUTAN KHUSUS' >ANGKUTAN KHUSUS</option>
            </select> -->
            <select name ="JENIS" class="form-control select" style="width:207px;"onchange="tari(this)" >
             <option selected value = '<?php echo $JENIS;?>' ><?php echo $JENIS;?></option>
            <option  value = "BIS BESAR" >BIS BESAR</option>
            <option  value = "BIS SEDANG" >BIS SEDANG</option>
            <option  value = "BIS KECIL" >BIS KECIL</option>
            <option  value = "ANGKOT" >ANGKOT</option>
            <option  value = "TAKSI" >TAKSI</option>
            <option  value = "ANGKUTAN KHUSUS" >ANGK. KHUSUS</option>

</select>

            &nbsp;&nbsp;&nbsp;Denda &nbsp;
            <input type="text" name ="DENDA_BAND" class="form-control" value="<?php echo $DENDA_BAND; ?>"   >

            <br style="clear: both" />
            <label>TARIF BAND</label>
            <input type="number" name ="TARIF" id="tfx"  value ="<?php echo $TARIF;?>" onkeyup="hitung2();" onkeypress="return isNumberKey(event)" class="a2"  style="width:92px;">
             x 
            <input type="number" onkeyup="hitung2();" onkeypress="return isNumberKey(event)" class="b2" name ="TELAT_TH" style="width:92px;" value="<?php echo $TELAT_TH;?>"   >
             &nbsp;&nbsp;&nbsp;Total &nbsp;&nbsp;&nbsp;
            <input type="text" name ="TARIF_BAND" class="c2" readonly="true" value = "<?php echo $TARIF_BAND; ?>"   >
            <br style="clear: both" />
            <label>NOMOR INDUK / NOMOR KP</label>
            <input type="text" name ="NOMOR_KP" class="form-control" value = "<?php echo $NO_IK;?>" >

            <br style="clear: both" />
            <label>NOMOR POLISI</label>
            <input type="text" name ="NO_MOBIL" class="form-control" style="width:94px;" value = "<?php echo $NO_MOBIL;?>" >
             
            <input type="text" name ="EX_NO_MOBI" class="form-control" style="width:94px;" value="<?php echo $EX_NO_MOBI; ?>" > 
            <br style="clear: both" />
            <label>NOMOR UJI</label>
           <input type="text" name ="NO_UJI" class="form-control" style="width:94px;" value = "<?php echo $NO_UJI;?>" >
             
            <input type="text" name ="EX_NO_UJI" class="form-control" style="width:94px;" value="<?php echo $EX_NO_UJI; ?>" > 

            <br style="clear: both" />
            <label>MERK / TAHUN</label>
            <input type="text" name ="MERK" class="form-control" style="width:138px;" value = "<?php echo $MERK; ?>" >
            <input type="text" name ="TAHUN_PEMB" class="form-control" style="width:50px;" value = "<?php echo $TAHUN_PEMB; ?>" >
            <br style="clear: both" />
            <label>BAHAN BAKAR</label>
             <select name ="BBM" class="form-control select" style="width:207px;" >
             <option selected value = "<?php echo $BBM ;?>"  >
             <?php 
             if($BBM == 1){
                echo 'BENSIN';
             }else if($BBM == 2){
                echo 'SOLAR';
             }else if($BBM == 3){
                echo 'GAS';
             }else if ($BBM == 4){
                echo 'PREMIX';
             }
              
             ?>
                 
             </option>
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
             <input type="number" min ="0" name ="DA_ORANG" class="form-control" style="width:94px;" value="<?php echo $DA_ORANG; ?>" >
             
            <input type="number"  min ="0" name ="DA_BARANG" class="form-control" style="width:94px;" value="<?php echo $DA_BARANG; ?>" > 

            <br style="clear: both" />
            <label>JENIS PELAYANAN</label>
            
           <select name ="PELAYANAN" class="form-control select" style="width:207px;" >
             <option selected value = '<?php echo $PELAYANAN;?>' >
             <?php 
             if($PELAYANAN == 1){ echo 'AKDP';} 
                else if($PELAYANAN == 2){ echo 'DALAM KOTA';}
                 else if($PELAYANAN == 3){ echo 'DOOR TO DOOR SERV';}
                 else if($PELAYANAN == 4){ echo 'ANGKUTAN KHUSUS';}

             ?>
                 
             </option>
          <option  value = '1' >AKDP</option>
            <option  value = '2' >DALAM KOTA</option>
            <option  value = '3' >DOOR TO DOOR SERV</option>
            <option  value = '4' >ANGKUTAN KHUSUS</option>
            </select>

            <br style="clear: both" />
             <label>SIFAT / FASILITAS</label>
             <input type="checkbox" name="AC" value ='1' <?php if($AC == '1'){ ?> checked <?php }?>>AC
             <input type="checkbox" name="TOILET" value ='1' <?php if($TOILET == '1'){ ?> checked <?php } ?>>Toilet
             <input type="checkbox" name="RCSET" value ='1' <?php if($RCSET == '1'){ ?> checked <?php } ?>>RC Set
             <br style="clear: both" />
            <label>SIFAT PERJALANAN</label>
            <select name ="SP" class="form-control select" style="width:207px;" >
            <option selected value = '<?php echo $SP; ?>' ><?php if( $SP == '1'){ echo 'PATAS'; }else{ echo 'EKONOMI';} ?></option>
          <option value = '1' >PATAS</option>
            <option  value = '2' >EKONOMI</option>
            </select>

           <!-- <br style="clear: both" />
            <label>NOMOR KP</label>
            <input type="text" name ="" class="form-control" value = "<?php echo $NOMOR_KP;?>" >-->
           
           <br style="clear: both" />

            <label>TANGGAL</label>
            <input type="text" name ="TG_KP" class="form-control" style="width:82px;" id="datepicker1" value ="<?php echo $TG_KP;?>" readonly > s/d
            <input type="text" name ="TG_KPSK" class="form-control" style="width:82px;" id="datepicker2" value ="<?php echo $TG_KPSK;?>" readonly >
            <br style="clear: both" />

            <label>MASA BERLAKU</label>
           <input type="text" name ="TG_MULAI" class="form-control" style="width:82px;" id="datepicker3" value ="<?php echo $TG_MULAI;?>" readonly > s/d
            <input type="text" name ="TG_AKHIR" class="form-control" style="width:82px;" id="datepicker4" value ="<?php echo $TG_AKHIR;?>" readonly >
            <br style="clear: both" />

            <label>KODE TRAYEK</label>
            <input type="hidden" name ="TRA_ID" id="v_jurusan" class='form-control autocomplete'  required>
            <input type="search" name ="KODE_TRAYE" class='autocomplete' id="autocomplete1"  class='form-control autocomplete' value = "<?php echo $KODE_TRAYE;?>" required>
            <br style="clear: both" />

            <label>NAMA TRAYEK</label>
           <!-- <input type="search" name =""  class='autocomplete' style="width: 800px; " id="autocomplete1" value="<?php echo $NAMA_TRAYE; ?>" >-->
           <textarea type="search" name="" id="v_nim"  readonly cols="50" rows="4" ><?php echo $NAMA_TRAYE;?></textarea>
            <br style="clear: both" />

            <label>PEMILIK</label>
            <input type="text" name ="NAMA_STNK"  class="form-control" value ="<?php echo $NAMA_STNK; ?>" >
            <br style="clear: both" />

            <label>ALAMAT</label>
           <textarea class="input-area-wrc" name="ALAMAT_STN"><?php echo $ALAMAT_PEM ; ?></textarea>
            <br style="clear: both" />

            <label>CATATAN</label>
           <textarea class="input-area-wrc" name="CATATAN"><?php echo $CATATAN ; ?></textarea>
            <br style="clear: both" />

            <label>HISTORY</label>
             <textarea class="input-area-wrc" name ="HISTORI"><?php echo $HISTORI ; ?></textarea>
            <br style="clear: both" />



            <button class="button-wrc" style="margin-left: 100px;" onclick="return confirm('Apakah benar data dengan NO. INDUK <?php echo $NO_IK;?> akan diupdate?');">Update</button>
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
