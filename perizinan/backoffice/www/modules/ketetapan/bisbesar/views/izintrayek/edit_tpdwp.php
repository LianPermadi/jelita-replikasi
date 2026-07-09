
<?php if(@$msg<>"") 
{
   if(@$msg == "sukses")
    {
    ?>
    <script>alert("Data Berhasil disimpan");//window.location.href='../../bisbesar/c_pengusaha'</script>

    <?php
   
    }else if(@$msg == "gagal"){
    ?>
    <script>alert("Data gagal disimpan");//window.location.href='../../bisbesar/c_pengusaha'</script>
    <?php
    }else{
    
}

}
?>
 <script type='text/javascript' src='<?php echo base_url();?>assets/autocomplete/js/jquery-1.8.2.min.js'></script>
    <script type='text/javascript' src='<?php echo base_url();?>assets/autocomplete/js/jquery.autocomplete.js'></script>
    <link href='<?php echo base_url();?>assets/autocomplete/js/jquery.autocomplete.css' rel='stylesheet' />
   <!--<link href='<?php  echo base_url();?>assets/autocomplete/css/default.css' rel='stylesheet' />-->

   <!-- <script type='text/javascript'>
    var u = jQuery.noConflict();
        var site = "<?php echo site_url();?>";
        u(function(){
            u('.autocomplete').autocomplete({
                serviceUrl: site+'/autocomplete/search_terminal',
                onSelect: function (suggestion) {
                    u('#id').val(''+suggestion.ID);
                }
            });
        });
    </script>-->
 
  
<?php
function tanggal_indo($tanggal)
{
  $bulan = array (1 =>   'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember'
      );
  $split = explode('-', $tanggal);
  return $split[2] . ' ' . $bulan[ (int)$split[1] ] . ' ' . $split[0];
}

$TERMINAL_I = "";
$NAMA_TERM3 = "";
$JARAK = "";
$PP1_1 = "";
$NOMOR_KP = "";
$TG_MULAI = "";
$TG_AKHIR = "";
$KODE_TRAYE = "";
$NAMA_TRAYE = "";
$NO_SK = "";
$TG_SK = "";
$JARAK = "";
$PP1_1 = "";
$PP1_2 = "";
$PP2_1 = "";
$PP2_2 = "";
$PP3_1 = "";
$PP3_2 = "";
$PP4_1 = "";
$PP4_2 = "";

$PP5_1 = "";
$PP5_2 = "";
$PP6_1 = "";
$PP6_2 = "";
$NO_MOBIL = "";
$NO_UJI = "";
$PIT_ID = "";
$KP_ID = "";
$PAU_ID ="";
$TRA_ID="";
foreach($bb_tpdwp as $u)
{
 $TERMINAL_I =  $u->TERMINAL_I;
 $NAMA_TERM3 = $u->NAMA_TERM3;
 $JARAK = $u->JARAK;
 //$PP1_1 = $u->PP1_1;

 //$KODE_TRAYE = $u->KODE_TRAYE;
 //$NAMA_TRAYE = $u->NAMA_TRAYE;

 $JARAK = $u->JARAK;
 $PP1_1 = $u->PP1_1;
 $PP1_2 = $u->PP1_2;
 $PP2_1 = $u->PP2_1;
 $PP2_2 = $u->PP2_2;
 $PP3_1 = $u->PP3_1;
 $PP3_2 = $u->PP3_2;
 $PP4_1 = $u->PP4_1;
 $PP4_2 = $u->PP4_2;
 $PP5_1 = $u->PP5_1;
 $PP5_2 = $u->PP5_2;
 $PP6_1 = $u->PP6_1;
 $PP6_2 = $u->PP6_2;
 $TPDWP_ID = $u->TPDWP_ID;
 //$PIT_ID = $u->PIT_ID;
  
}
foreach($bb_tpdwp_perus as $u)
{
 
 $TG_MULAI = $u->TG_MULAI;
 $TG_AKHIR = $u->TG_AKHIR;
 $NAMA_PERUS = $u->NAMA_PERUS;
 $ALAMAT_PER = $u->ALAMAT_PER;
 $NO_MOBIL = $u->NO_MOBIL;
 $NO_UJI = $u->NO_UJI;
 $KODE_TRAYE = $u->KODE_TRAYE;
 $NAMA_TRAYE = $u->NAMA_TRAYE;
 $NO_SK = $u->NO_SK;
 $TG_SK = $u->TG_SK;
 $NOMOR_KP = $u->NOMOR_KP;
 $PIT_ID = $u->PIT_ID;
 $KP_ID = $u->KP_ID;
 $PAU_ID = $u->PAU_ID;
 $TRA_ID = $u->TRA_ID;
  
}
//-----------------------------------------asli sebelum pecah
/*foreach($bb_tpdwp as $u)
{
 
 $TG_MULAI = $u->TG_MULAI;
 $TG_AKHIR = $u->TG_AKHIR;
 $NAMA_PERUS = $u->NAMA_PERUS;
 $ALAMAT_PER = $u->ALAMAT_PER;
 $NO_MOBIL = $u->NO_MOBIL;
 $NO_UJI = $u->NO_UJI;
 $KODE_TRAYE = $u->KODE_TRAYE;
 $NAMA_TRAYE = $u->NAMA_TRAYE;
 $NO_SK = $u->NO_SK;
 $TG_SK = $u->TG_SK;
 $NOMOR_KP = $u->NOMOR_KP;
 $PIT_ID = $u->PIT_ID;
 $KP_ID = $u->KP_ID;
 $PAU_ID = $u->PAU_ID;
 $TRA_ID = $u->TRA_ID;




 $TERMINAL_I =  $u->TERMINAL_I;
 $NAMA_TERM3 = $u->NAMA_TERM3;
 $JARAK = $u->JARAK;
 //$PP1_1 = $u->PP1_1;

 //$KODE_TRAYE = $u->KODE_TRAYE;
 //$NAMA_TRAYE = $u->NAMA_TRAYE;

 $JARAK = $u->JARAK;
 $PP1_1 = $u->PP1_1;
 $PP1_2 = $u->PP1_2;
 $PP2_1 = $u->PP2_1;
 $PP2_2 = $u->PP2_2;
 $PP3_1 = $u->PP3_1;
 $PP3_2 = $u->PP3_2;
 $PP4_1 = $u->PP4_1;
 $PP4_2 = $u->PP4_2;
 $PP5_1 = $u->PP5_1;
 $PP5_2 = $u->PP5_2;
 $PP6_1 = $u->PP6_1;
 $PP6_2 = $u->PP6_2;
 $TPDWP_ID = $u->TPDWP_ID;
 //$PIT_ID = $u->PIT_ID;
  
}*/
//-------------------------------------
/*foreach($bb_tpdwp2 as $u){

 $TERMINAL_I =  $u->TERMINAL_I;
 $NAMA_TERM3 = $u->NAMA_TERM3;
 $JARAK = $u->JARAK;
 $PP1_1 = $u->PP1_1;

 //$KODE_TRAYE = $u->KODE_TRAYE;
 //$NAMA_TRAYE = $u->NAMA_TRAYE;

 $JARAK = $u->JARAK;
 $PP1_1 = $u->PP1_1;
 $PP1_2 = $u->PP1_2;
 $PP2_1 = $u->PP2_1;
 $PP2_2 = $u->PP2_2;
 $PP3_1 = $u->PP3_1;
 $PP3_2 = $u->PP3_2;
 $PP4_1 = $u->PP4_1;
 $PP4_2 = $u->PP4_2;
 $PP5_1 = $u->PP5_1;
 $PP5_2 = $u->PP5_2;
 $PP6_1 = $u->PP6_1;
 $PP6_2 = $u->PP6_2;
 $TPDWP_ID = $u->TPDWP_ID;
 $PIT_ID = $u->PIT_ID;

}*/
 ?>
<div id="content">
    <div class="post">
        <div class="title">
            <h2><?php echo $page_name; ?></h2>
        </div>
<div class="entry">

<!--<button onclick="goBack()" class="button-wrc">Kembali</button>-->
<!--<a href=<?php echo base_url()."bisbesar/c_izintrayek/tambahtpdwp/".$TPDWP_ID ;?> class="button-wrc" style ="text-decoration: none">Tambah tpdwp</a>-->
<a href=<?php echo base_url()."bisbesar/c_izintrayek/daftar_izintrayek/".$PIT_ID ;?> class="button-wrc" style ="text-decoration: none">KEMBALI</a>
 <br style="clear: both" />
 <br style="clear: both" />
<script>
function goBack() {
    window.history.back();
}
</script>

 <label>NAMA PERUSAHAAN</label> <?php //echo $NAMA_PERUS; ?>
             <input type="text" style="border-color:transparent;" name ="" class="form-control" value="<?php echo $NAMA_PERUS; ?>" readonly required>  
             <br style="clear: both" />
             <label>ALAMAT</label>  <?php //echo $ALAMAT_PER;?>
             <input type="text" style="border-color:transparent;width: 600px;" name ="" class="form-control" value="<?php echo $ALAMAT_PER; ?>" readonly required>
           <!-- <textarea  class="input-area-wrc" name = "ALAMAT_PER" readonly="true"><?php echo $ALAMAT_PER;?></textarea>-->
             <br style="clear: both" />

             <label>NO KENDARAAN / KONTROL </label>  <?php //echo $NO_MOBIL; ?><!-- / --><?php //echo $NO_UJI; ?>
             <input type="text" style="border-color:transparent;" name ="" class="form-control" value="<?php echo $NO_MOBIL; ?>" readonly required>  
               <input type="text" style="border-color:transparent;" name ="" class="form-control" value="<?php echo $NO_UJI; ?>" readonly required>
             <br style="clear: both" />

              <label>NO. KP </label>  <?php //echo $NOMOR_KP; ?>  <?php //echo $TG_MULAI; ?>  <?php //echo $TG_AKHIR;?>
              <input type="text" style="border-color:transparent;" name ="" class="form-control" value="<?php echo $NOMOR_KP; ?>" readonly required>
              <br style="clear: both" />
               <label>MASA BERLAKU</label>
             <input type="text" style="border-color:transparent;" name ="" class="form-control" value="<?php echo tanggal_indo($TG_MULAI); ?>" readonly required>
            
             <input type="text" style="border-color:transparent;" name ="" class="form-control" value="<?php echo tanggal_indo($TG_AKHIR);?>" readonly required>
             <br style="clear: both" />

             <label>KODE TRAYEK </label>  <?php //echo $KODE_TRAYE; ?>  <?php //echo $NAMA_TRAYE;?>
             <input type="text" style="border-color:transparent;" name ="" class="form-control" value="<?php echo $KODE_TRAYE; ?>" readonly required>

             <br style="clear: both" />

               <label>TRAYEK </label>
              <!-- <input type="text" style="border-color:transparent;width:600px;"  name ="" class="form-control" value="<?php echo $NAMA_TRAYE; ?>" readonly required>-->
             <textarea style="border-color:transparent;" rows="3" class="input-area-wrc" name = "NAMA_TRAYE" readonly="true"><?php echo $NAMA_TRAYE;?></textarea>

             <br style="clear: both" />
              
            <label>NO SK </label>  <?php //echo  $NO_SK; ?>
             <input type="text" name ="" style="border-color:transparent;" class="form-control" value="<?php echo  $NO_SK; ?>" readonly required>
             <br style="clear: both" />

             <label>TANGGAL SK </label>  <?php //echo $TG_SK; ?>
             <input type="text" style="border-color:transparent;" name ="" class="form-control" value="<?php echo $TG_SK; ?>" readonly required>
             <br style="clear: both" />

<!--<form method = "POST" action = "<?php echo base_url();?>bisbesar/c_pengusaha/update_aksi" enctype="multipart/form-data">
 <input type="hidden" name ="PAU_ID" class="form-control" value="<?php echo $PAU_ID; ?>" readonly 
            <br style="clear: both" />
            <label>NOMOR IP</label>
             <input type="text" name ="NO_IP" class="form-control" value="<?php echo $NO_IP; ?>" readonly required>

            <br style="clear: both" />
            <label>NAMA PERUSAHAAN</label>
            <input type="text" name ="NAMA_PERUS" class="form-control" value="<?php echo $NAMA_PERUS;?>" required>

           <br style="clear: both" />
            <label>NAMA PEMILIK</label>
            <input type="text" name ="NAMA_PEMIL" class="form-control" value="<?php echo $NAMA_PEMIL;?>" required>

            <br style="clear: both" />
            <label>ALAMAT PERUSAHAAN</label>
            <!--<input type="text" name ="ALAMAT_PER" class="form-control" value="<?php echo $ALAMAT_PER;?>" required>-->
           <!-- <textarea name ="ALAMAT_PER" class="input-area-wrc" ><?php echo $ALAMAT_PER;?></textarea>

            <br style="clear: both" />
            <label>TELEPON PERUSAHAAN</label>
            <input type="text" name ="TELPON_PER" class="form-control" value="<?php echo $TELPON_PER;?>" required>

            <br style="clear: both" />
            <label>ALAMAT PEMILIK</label>
            <!--<input type="text" name ="ALAMAT_PEM" class="form-control" value="<?php echo $ALAMAT_PEM;?>" required>-->
          <!--  <textarea name ="ALAMAT_PEM" class="input-area-wrc" ><?php echo $ALAMAT_PEM;?></textarea>

            <br style="clear: both" />
            <label>TELEPON PEMILIK</label>
            <input type="text" name ="TELPON_PEM" class="form-control" value="<?php echo $TELPON_PEM;?>" required>

            <br style="clear: both" />
             <label>KODYA / KAB</label>
            <select name ="KODYA_ID_P" class="form-control select" required>
            
            <option selected value = '<?php echo $KODYA_ID;?>' ><?php echo $NAMA_KODYA;?></option>
            <?php echo $kodya; ?>
            </select> 

            <br style="clear: both" />
            <button class="button-wrc" style="margin-left: 100px;">Update</button>
            <a href = <?php echo base_url().'bisbesar/c_pengusaha';?> class= 'button-wrc' style="text-decoration: none;" >Batal</a>
           
    </form>-->
   <!-- <br style="clear: both" />
<center><a href="<?php echo base_url().'bisbesar/c_izintrayek';?>"" class= 'button-wrc' style="text-decoration: none;">Tambah Perjalanan</a></center></center>
<br style="clear: both" />
<br style="clear: both" />-->
<br style="clear: both" />
 <table cellpadding="0" cellspacing="0" border="1" class="display" id="izintrayekx" >
   <thead>
                    <tr style="background: skyblue;">
                         <!--<th width="">No</th>
                        <th width="">KODE TERMINAL</th>-->
                        <th >LINTASAN/KOTA/TERMINAL</th>
                        <th width="">JARAK</th>
                        <th width="">PP - 1</th>
                        <th width="">PP - 1</th>
                        <th width="">PP - 2</th>
                        <th width="">PP - 2</th>
                        <th width="">PP - 3</th>
                        <th width="">PP - 3</th>
                        <th width="">PP - 4</th>
                        <th width="">PP - 4</th>
                        <th width="">PP - 5</th>
                        <th width="">PP - 5</th>
                        <th width="">PP - 6</th>
                        <th width="">PP - 6</th>
                        <th width="">AKSI</th>
                        </tr>
                        </thead>
                       <tbody>
  <?php
  $y=0;
  $x =1;

   foreach($bb_tpdwp as $u2){
   $TP =  $u2->TPDWP_ID;
   $J = $u2->JARAK;

   ?> 
   
<tr>

   <form method = "POST" action = "<?php echo base_url();?>bisbesar/c_izintrayek/update_tpdwp" enctype="multipart/form-data">
   <!--<td><?php echo $y++;?></td>
   <td><input type="text" name="TERMINAL_I" id="" readonly="true" style=" width:50px;" value="<?php echo $u2->TERMINAL_I; ?>">
   </td>-->

   <td>
<script type='text/javascript'>
 var u = jQuery.noConflict();
        var site = "<?php echo site_url();?>";
        u(function(){
            u('<?php echo '.'.$y;?>').autocomplete({
                serviceUrl: site+'/autocomplete/search_terminal',
                onSelect: function (suggestion) {
                    u('<?php echo '#'.$y;?>').val(''+suggestion.ID);
                   
                }
            });
        });
        
    </script>
   

   <input type="text" name="TERMINAL_I" id="<?php echo $y;?>" readonly="true" style=" width:30px;border-color: transparent;color:black;" value="<?php echo $u2->TERMINAL_I; ?>">
<input type="search" name="NAMA_TERM3" class='<?php echo $y;?>' id="autocomplete1" style=" width:150px; border-color: transparent;color:black;" value="<?php echo $u2->NAMA_TERM3; ?>">
            </td>
               <td><input name="TPDWP_ID" type="hidden" style=" width:42px;" value="<?php echo $u2->TPDWP_ID;?>">
        <input name="JARAK" type="text" style=" width:42px; border-color: transparent;color:black;" value="<?php echo $u2->JARAK;?>" ></td>
 
         <td>
<input name="KP_ID" value="<?php echo $u2->KP_ID;?>" type="hidden" style=" width:42px; border-color: transparent;color:black;">
         <input name="PP1_1" value="<?php echo $u2->PP1_1;?>" maxlength="7"  id="<?php echo 'pp1_1'.$y;?>" type="text" style=" width:42px; border-color: transparent;color:black;">
<span id="<?php echo 'pesan'.$y;?>"></span>
         </td>
            <td><input name="PP1_2" value="<?php echo $u2->PP1_2;?>" maxlength="7" id="<?php echo 'pp1_2'.$y;?>" type="text" style=" width:42px; border-color: transparent;color:black;">
                <span id="<?php echo 'pesan1_2'.$y;?>"></span>
            </td>
            <td>
                <input name="PP2_1" value="<?php echo $u2->PP2_1;?>" maxlength="7" id="<?php echo 'pp2_1'.$y;?>" type="text" style=" width:42px; border-color: transparent;color:black;">
                <span id="<?php echo 'pesan2_1'.$y;?>"></span>
            </td>
            <td>
                <input name="PP2_2" value="<?php echo $u2->PP2_2;?>" maxlength="7" id="<?php echo 'pp2_2'.$y;?>" type="text" style=" width:42px; border-color: transparent;color:black;">
                <span id="<?php echo 'pesan2_2'.$y;?>"></span>
            </td>
            <td>
                <input name="PP3_1" value="<?php echo $u2->PP3_1;?>" maxlength="7" id="<?php echo 'pp3_1'.$y;?>" type="text" style=" width:42px; border-color: transparent;color:black;">
                 <span id="<?php echo 'pesan3_1'.$y;?>"></span>

            </td>
            <td>
                <input name="PP3_2" value="<?php echo $u2->PP3_2;?>" maxlength="7" id="<?php echo 'pp3_2'.$y;?>" type="text" style=" width:42px; border-color: transparent;color:black;">
                <span id="<?php echo 'pesan3_2'.$y;?>"></span>
            </td>
            <td>
                <input name="PP4_1" value="<?php echo $u2->PP4_1;?>" maxlength="7" type="text" id="<?php echo 'pp4_1'.$y;?>" style=" width:42px; border-color: transparent;color:black;">
                <span id="<?php echo 'pesan4_1'.$y;?>"></span>
            </td>
                <td><input name="PP4_2" value="<?php echo $u2->PP4_2;?>" maxlength="7" id="<?php echo 'pp4_2'.$y;?>" type="text" style=" width:42px; border-color: transparent;color:black;">
                <span id="<?php echo 'pesan4_2'.$y;?>"></span>
            </td>
            <td>
                <input name="PP5_1" value="<?php echo $u2->PP5_1;?>" maxlength="7" id="<?php echo 'pp5_1'.$y;?>" type="text" style=" width:42px; border-color: transparent;color:black;">
                <span id="<?php echo 'pesan5_1'.$y;?>"></span>
            </td>
            <td>
                <input name="PP5_2" value="<?php echo $u2->PP5_2;?>" maxlength="7" id="<?php echo 'pp5_2'.$y;?>" type="text" style=" width:42px; border-color: transparent;color:black;">
                <span id="<?php echo 'pesan5_2'.$y;?>"></span>
            </td>
            <td>
                <input name="PP6_1" value="<?php echo $u2->PP6_1;?>" maxlength="7" id="<?php echo 'pp6_1'.$y;?>" type="text" style=" width:42px; border-color: transparent;color:black;">
                <span id="<?php echo 'pesan6_1'.$y;?>"></span>
            </td>
            <td>
                <input name="PP6_2" value="<?php echo $u2->PP6_2;?>" maxlength="7" id="<?php echo 'pp6_2'.$y;?>" type="text" style=" width:42px; border-color: transparent;color:black;">  
                <span id="<?php echo 'pesan6_2'.$y;?>"></span>
            </td>   
            <td><button class="button-wrc" >Update</button>
            <a href="<?php echo base_url();?>bisbesar/c_izintrayek/hapus_tpdwp/<?php echo $u2->TPDWP_ID;?>/<?php echo $u2->KP_ID;?>" class="button-wrc" onclick="return confirm('Apakah benar data akan dihapus ?');" style="text-decoration: none;">Hapus</a></td>
        <!--<td>
         <button class="button-wrc" style="margin-left: 100px;" onclick="return confirm('Apakah benar data dengan NO. INDUK <?php //echo $NO_IP;?> akan diupdate?');">Update</button>-->
   
         <!--</td>-->

 </form>
 </tr>
     <?php
}

        ?>
        </tbody>
        <tfoot>
         <form method = "POST" action = "<?php echo base_url();?>bisbesar/c_izintrayek/tambah_tpdwp_aksi/<?php echo $KP_ID; ?>" enctype="multipart/form-data">
<tr style="background: skyblue;">
               
        <td><!--<input type="text" name="xTERMINAL_I" id="id" readonly="true" style=" width:50px;">-->

<input type="text" name="xTERMINAL_I" id="t" readonly="true" style=" width:30px; border-color: transparent;color:black;">
        <input type="search" name="xNAMA_TERM3" class='autocomplete' id="autocomplete1" style=" width:150px;border-color: transparent;color:black;" required="true">
        </td>
                 <td><input name="TPDWP_ID" type="hidden" style=" width:42px;" >
        <input name="xJARAK" type="text" style=" width:42px; border-color: transparent;color:black;" ></td>
            <td><!--<input name="xPP1_1" type="text" class='autocompletex' id="autocomplete1x" style=" width:42px; border-color: transparent;color:black;">-->
            <input name="xPP1_1" maxlength="7" type="text"  id="a1" style=" width:42px; border-color: transparent;color:black;">
 <span id="p1"></span>  
            </td>
            <td><!--<input name="xPP1_2" class="auto_PP1_2" type="text" style=" width:42px; border-color: transparent;color:black;">-->
                <input name="xPP1_2" id="a2" type="text" style=" width:42px; border-color: transparent;color:black;">
                <span style="color:red;" id="p2"></span>  

            </td>
            <td><input name="xPP2_1" maxlength="7" id="a3"  type="text" style=" width:42px; border-color: transparent;color:black;"> <span  id="p3"></span></td>
            <td><input name="xPP2_2" maxlength="7" id="a4" type="text" style=" width:42px; border-color: transparent;color:black;"> <span  id="p4"></span></td>
            <td><input name="xPP3_1" maxlength="7" id="a5" type="text" style=" width:42px; border-color: transparent;color:black;"> <span id="p5"></span></td>
            <td><input name="xPP3_2" maxlength="7" id="a6" type="text" style=" width:42px; border-color: transparent;color:black;"> <span  id="p6"></span></td>
            <td><input name="xPP4_1" maxlength="7" id="a7" type="text" style=" width:42px; border-color: transparent;color:black;"> <span  id="p7"></span></td>
            <td><input name="xPP4_2" maxlength="7" id="a8" type="text" style=" width:42px; border-color: transparent;color:black;"> <span  id="p8"></span></td>
            <td><input name="xPP5_1" maxlength="7" id="a9" type="text" style=" width:42px; border-color: transparent;color:black;"> <span  id="p9"></span></td>
            <td><input name="xPP5_2" maxlength="7" id="a10" type="text" style=" width:42px; border-color: transparent;color:black;"> <span  " id="p10"></span></td>
            <td><input name="xPP6_1" maxlength="7" id="a11" type="text" style=" width:42px; border-color: transparent;color:black;"> <span  id="p11"></span></td>
            <td><input name="xPP6_2" maxlength="7" id="a12" type="text" style=" width:42px; border-color: transparent;color:black;"> <span  id="p12"></span></td>
            <td>
            <input type="hidden"  name ="xPIT_ID" class="form-control" value="<?php echo $PIT_ID; ?>" readonly >
<input type="hidden" name ="xNO_SK" class="form-control" value="<?php echo $NO_SK; ?>" readonly >
<input type="hidden" name ="xTG_SK" class="form-control" value="<?php echo $TG_SK; ?>" readonly >
<input type="hidden" name ="xKP_ID" class="form-control" value="<?php echo $KP_ID; ?>" readonly >
<input type="hidden" name ="xNOMOR_KP" class="form-control" value="<?php echo $NOMOR_KP; ?>" readonly >
<input type="hidden" name ="xNO_MOBIL" class="form-control" value="<?php echo $NO_MOBIL; ?>" readonly >
<input type="hidden" name ="xNO_UJI" class="form-control" value="<?php echo $NO_UJI; ?>" readonly >
<input type="hidden" name ="xPAU_ID" class="form-control" value="<?php echo $PAU_ID; ?>" readonly >
<input type="hidden" name ="xTRA_ID" class="form-control" value="<?php echo $TRA_ID; ?>" readonly >
<input type="hidden" name ="xKODE_TRAYE" class="form-control" value="<?php echo $KODE_TRAYE; ?>" readonly >
<input type="hidden" name ="xNAMA_TRAYE" class="form-control" value="<?php echo $NAMA_TRAYE; ?>" readonly >
                <button class="button-wrc" );">SIMPAN</button></td>

              </tr>
              </form>
              </tfoot>
       </table>



    <script type='text/javascript'>
 var u = jQuery.noConflict();
        var site = "<?php echo site_url();?>";
        u(function(){
            u('.autocomplete').autocomplete({
                serviceUrl: site+'/autocomplete/search_terminal',
                onSelect: function (suggestion) {
                    u('#t').val(''+suggestion.ID);
                   
                }
            });
        });
        
    </script>

    <script type='text/javascript'>
 var u = jQuery.noConflict();
        var site = "<?php echo site_url();?>";
        u(function(){
            u('.autocompletex').autocomplete({
                serviceUrl: site+'/autocomplete/search_PP1_1',
                onSelect: function (suggestion) {
                    u('#id').val(''+suggestion.ID);
                   
                }
            });

           u('.auto_PP1_2').autocomplete({
                serviceUrl: site+'/autocomplete/search_PP1_2',
                onSelect: function (suggestion) {
                    u('#id').val(''+suggestion.ID);
                   
                }
            });       
        });


    </script>
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script> 
 
<?php 
for($no=1;$no<=$y;$no++){
  ?>

 <script>  
 $(document).ready(function(){  
      $('<?php echo '#pp1_1'.$no;?>').change(function(){  
           var V1 = $('<?php echo '#pp1_1'.$no;?>').val(); 
           //var V2 = $('#y').val(); 
           var V2 = $('<?php echo '#'.$no;?>').val();  
           if(V1 != '' && V2 != '')  
           {  
                $.ajax({  
                     url:"<?php echo site_url();?>bisbesar/cek/check_eksis",  
                     method:"POST",  
                     data:{V1:V1,V2:V2},  
                     success:function(data){  
                          $('<?php echo '#pesan'.$no;?>').html(data);  
                     }  
                });  
           }  
      }); 
      $('<?php echo '#pp1_2'.$no;?>').change(function(){  
           var V1 = $('<?php echo '#pp1_2'.$no;?>').val(); 
           //var V2 = $('#y').val(); 
           var V2 = $('<?php echo '#'.$no;?>').val();  
           if(V1 != ''  && V2 != '')  
           {  
                $.ajax({  
                     url:"<?php echo site_url();?>bisbesar/cek/check_eksis",  
                     method:"POST",  
                     data:{V1:V1,V2:V2},  
                     success:function(data){  
                          $('<?php echo '#pesan1_2'.$no;?>').html(data);  
                     }  
                });  
           }  
      });

       $('<?php echo '#pp2_1'.$no;?>').change(function(){  
           var V1 = $('<?php echo '#pp2_1'.$no;?>').val(); 
           //var V2 = $('#y').val(); 
           var V2 = $('<?php echo '#'.$no;?>').val();  
           if(V1 != ''  && V2 != '')  
           {  
                $.ajax({  
                     url:"<?php echo site_url();?>bisbesar/cek/check_eksis",  
                     method:"POST",  
                     data:{V1:V1,V2:V2},  
                     success:function(data){  
                          $('<?php echo '#pesan2_1'.$no;?>').html(data);  
                     }  
                });  
           }  
      }); 
        $('<?php echo '#pp2_2'.$no;?>').change(function(){  
           var V1 = $('<?php echo '#pp2_2'.$no;?>').val(); 
           //var V2 = $('#y').val(); 
           var V2 = $('<?php echo '#'.$no;?>').val();  
           if(V1 != ''  && V2 != '')  
           {  
                $.ajax({  
                     url:"<?php echo site_url();?>bisbesar/cek/check_eksis",  
                     method:"POST",  
                     data:{V1:V1,V2:V2},  
                     success:function(data){  
                          $('<?php echo '#pesan2_2'.$no;?>').html(data);  
                     }  
                });  
           }  
      });
      $('<?php echo '#pp3_1'.$no;?>').change(function(){  
           var V1 = $('<?php echo '#pp3_1'.$no;?>').val(); 
           //var V2 = $('#y').val(); 
           var V2 = $('<?php echo '#'.$no;?>').val();  
           if(V1 != ''  && V2 != '')  
           {  
                $.ajax({  
                     url:"<?php echo site_url();?>bisbesar/cek/check_eksis",  
                     method:"POST",  
                     data:{V1:V1,V2:V2},  
                     success:function(data){  
                          $('<?php echo '#pesan3_1'.$no;?>').html(data);  
                     }  
                });  
           }  
      });
    $('<?php echo '#pp3_2'.$no;?>').change(function(){  
           var V1 = $('<?php echo '#pp3_2'.$no;?>').val(); 
           //var V2 = $('#y').val(); 
           var V2 = $('<?php echo '#'.$no;?>').val();  
           if(V1 != ''  && V2 != '')  
           {  
                $.ajax({  
                     url:"<?php echo site_url();?>bisbesar/cek/check_eksis",  
                     method:"POST",  
                     data:{V1:V1,V2:V2},  
                     success:function(data){  
                          $('<?php echo '#pesan3_2'.$no;?>').html(data);  
                     }  
                });  
           }  
      });
    $('<?php echo '#pp4_1'.$no;?>').change(function(){  
           var V1 = $('<?php echo '#pp4_1'.$no;?>').val(); 
           //var V2 = $('#y').val(); 
           var V2 = $('<?php echo '#'.$no;?>').val();  
           if(V1 != ''  && V2 != '')  
           {  
                $.ajax({  
                     url:"<?php echo site_url();?>bisbesar/cek/check_eksis",  
                     method:"POST",  
                     data:{V1:V1,V2:V2},  
                     success:function(data){  
                          $('<?php echo '#pesan4_1'.$no;?>').html(data);  
                     }  
                });  
           }  
      });
     $('<?php echo '#pp4_2'.$no;?>').change(function(){  
           var V1 = $('<?php echo '#pp4_2'.$no;?>').val(); 
           //var V2 = $('#y').val(); 
           var V2 = $('<?php echo '#'.$no;?>').val();  
           if(V1 != ''  && V2 != '')  
           {  
                $.ajax({  
                     url:"<?php echo site_url();?>bisbesar/cek/check_eksis",  
                     method:"POST",  
                     data:{V1:V1,V2:V2},  
                     success:function(data){  
                          $('<?php echo '#pesan4_2'.$no;?>').html(data);  
                     }  
                });  
           }  
      });
    $('<?php echo '#pp5_1'.$no;?>').change(function(){  
           var V1 = $('<?php echo '#pp5_1'.$no;?>').val(); 
           //var V2 = $('#y').val(); 
           var V2 = $('<?php echo '#'.$no;?>').val();  
           if(V1 != ''  && V2 != '')  
           {  
                $.ajax({  
                     url:"<?php echo site_url();?>bisbesar/cek/check_eksis",  
                     method:"POST",  
                     data:{V1:V1,V2:V2},  
                     success:function(data){  
                          $('<?php echo '#pesan5_1'.$no;?>').html(data);  
                     }  
                });  
           }  
      });
    $('<?php echo '#pp5_2'.$no;?>').change(function(){  
           var V1 = $('<?php echo '#pp5_2'.$no;?>').val(); 
           //var V2 = $('#y').val(); 
           var V2 = $('<?php echo '#'.$no;?>').val();  
           if(V1 != ''  && V2 != '')  
           {  
                $.ajax({  
                     url:"<?php echo site_url();?>bisbesar/cek/check_eksis",  
                     method:"POST",  
                     data:{V1:V1,V2:V2},  
                     success:function(data){  
                          $('<?php echo '#pesan5_2'.$no;?>').html(data);  
                     }  
                });  
           }  
      });
    $('<?php echo '#pp6_1'.$no;?>').change(function(){  
           var V1 = $('<?php echo '#pp6_1'.$no;?>').val(); 
           //var V2 = $('#y').val(); 
           var V2 = $('<?php echo '#'.$no;?>').val();  
           if(V1 != ''  && V2 != '')  
           {  
                $.ajax({  
                     url:"<?php echo site_url();?>bisbesar/cek/check_eksis",  
                     method:"POST",  
                     data:{V1:V1,V2:V2},  
                     success:function(data){  
                          $('<?php echo '#pesan6_1'.$no;?>').html(data);  
                     }  
                });  
           }  
      });
    $('<?php echo '#pp6_2'.$no;?>').change(function(){  
           var V1 = $('<?php echo '#pp6_2'.$no;?>').val(); 
           //var V2 = $('#y').val(); 
           var V2 = $('<?php echo '#'.$no;?>').val();  
           if(V1 != ''  && V2 != '')  
           {  
                $.ajax({  
                     url:"<?php echo site_url();?>bisbesar/cek/check_eksis",  
                     method:"POST",  
                     data:{V1:V1,V2:V2},  
                     success:function(data){  
                          $('<?php echo '#pesan6_2'.$no;?>').html(data);  
                     }  
                });  
           }  
      });

      });
 
      </script>
      <?php  
}
for($c=1;$c<=12;$c++){
 
    ?>
    <script>  
 $(document).ready(function(){ 
       $('<?php echo '#a'.$c;?>').change(function(){  
           var V1 = $('<?php echo '#a'.$c;?>').val(); 
           var V2 = $('#t').val();   
           if(V1 != '' && V2 != '')  
           {  
                $.ajax({  
                     url:"<?php echo site_url();?>bisbesar/cek/check_eksis",  
                     method:"POST",  
                    data:{V1:V1,V2:V2},  
                     success:function(data){  
                          $('<?php echo '#p'.$c;?>').html(data);  
                     }  
                });  
           }
      });
        });
        </script>
       <?php
}
?>

       <!--<script>  
 $(document).ready(function(){ 
       $('#a').change(function(){  
           var V1 = $('#a').val(); 
           var V2 = $('#b').val();   
           if(V1 != '')  
           {  
                $.ajax({  
                     url:"<?php echo site_url();?>bisbesar/cek/check_eksis",  
                     method:"POST",  
                    data:{V1:V1,V2:V2},  
                     success:function(data){  
                          $('#pesan2').html(data);  
                     }  
                });  
           }  
      });  

        $('#a1').change(function(){  
           var V1 = $('#a1').val(); 
           var V2 = $('#t').val();   
           if(V1 != '')  
           {  
                $.ajax({  
                     url:"<?php echo site_url();?>bisbesar/cek/check_eksis",  
                     method:"POST",  
                    data:{V1:V1,V2:V2},  
                     success:function(data){  
                          $('#p1').html(data);  
                     }  
                });  
           }  
      });
      $('#a2').change(function(){  
           var V1 = $('#a2').val(); 
           var V2 = $('#t').val();   
           if(V1 != '')  
           {  
                $.ajax({  
                     url:"<?php echo site_url();?>bisbesar/cek/check_eksis",  
                     method:"POST",  
                    data:{V1:V1,V2:V2},  
                     success:function(data){  
                          $('#p2').html(data);  
                     }  
                });  
           }  
      });
      $('#a3').change(function(){  
           var V1 = $('#a3').val(); 
           var V2 = $('#t').val();   
           if(V1 != '')  
           {  
                $.ajax({  
                     url:"<?php echo site_url();?>bisbesar/cek/check_eksis",  
                     method:"POST",  
                    data:{V1:V1,V2:V2},  
                     success:function(data){  
                          $('#p3').html(data);  
                     }  
                });  
           }  
      });   
$('#a4').change(function(){  
           var V1 = $('#a4').val(); 
           var V2 = $('#t').val();   
           if(V1 != '')  
           {  
                $.ajax({  
                     url:"<?php echo site_url();?>bisbesar/cek/check_eksis",  
                     method:"POST",  
                    data:{V1:V1,V2:V2},  
                     success:function(data){  
                          $('#p4').html(data);  
                     }  
                });  
           }  
      }); 
$('#a5').change(function(){  
           var V1 = $('#a5').val(); 
           var V2 = $('#t').val();   
           if(V1 != '')  
           {  
                $.ajax({  
                     url:"<?php echo site_url();?>bisbesar/cek/check_eksis",  
                     method:"POST",  
                    data:{V1:V1,V2:V2},  
                     success:function(data){  
                          $('#p5').html(data);  
                     }  
                });  
           }  
      }); 
$('#a6').change(function(){  
           var V1 = $('#a6').val(); 
           var V2 = $('#t').val();   
           if(V1 != '')  
           {  
                $.ajax({  
                     url:"<?php echo site_url();?>bisbesar/cek/check_eksis",  
                     method:"POST",  
                    data:{V1:V1,V2:V2},  
                     success:function(data){  
                          $('#p6').html(data);  
                     }  
                });  
           }  
      }); 
$('#a7').change(function(){  
           var V1 = $('#a7').val(); 
           var V2 = $('#t').val();   
           if(V1 != '')  
           {  
                $.ajax({  
                     url:"<?php echo site_url();?>bisbesar/cek/check_eksis",  
                     method:"POST",  
                    data:{V1:V1,V2:V2},  
                     success:function(data){  
                          $('#p7').html(data);  
                     }  
                });  
           }  
      }); 
$('#a8').change(function(){  
           var V1 = $('#a8').val(); 
           var V2 = $('#t').val();   
           if(V1 != '')  
           {  
                $.ajax({  
                     url:"<?php echo site_url();?>bisbesar/cek/check_eksis",  
                     method:"POST",  
                    data:{V1:V1,V2:V2},  
                     success:function(data){  
                          $('#p8').html(data);  
                     }  
                });  
           }  
      }); 
$('#a9').change(function(){  
           var V1 = $('#a9').val(); 
           var V2 = $('#t').val();   
           if(V1 != '')  
           {  
                $.ajax({  
                     url:"<?php echo site_url();?>bisbesar/cek/check_eksis",  
                     method:"POST",  
                    data:{V1:V1,V2:V2},  
                     success:function(data){  
                          $('#p9').html(data);  
                     }  
                });  
           }  
      }); 
$('#a10').change(function(){  
           var V1 = $('#a10').val(); 
           var V2 = $('#t').val();   
           if(V1 != '')  
           {  
                $.ajax({  
                     url:"<?php echo site_url();?>bisbesar/cek/check_eksis",  
                     method:"POST",  
                    data:{V1:V1,V2:V2},  
                     success:function(data){  
                          $('#p10').html(data);  
                     }  
                });  
           }  
      }); 
$('#a11').change(function(){  
           var V1 = $('#a11').val(); 
           var V2 = $('#t').val();   
           if(V1 != '')  
           {  
                $.ajax({  
                     url:"<?php echo site_url();?>bisbesar/cek/check_eksis",  
                     method:"POST",  
                    data:{V1:V1,V2:V2},  
                     success:function(data){  
                          $('#p11').html(data);  
                     }  
                });  
           }  
      }); 
$('#a12').change(function(){  
           var V1 = $('#a12').val(); 
           var V2 = $('#t').val();   
           if(V1 != '')  
           {  
                $.ajax({  
                     url:"<?php echo site_url();?>bisbesar/cek/check_eksis",  
                     method:"POST",  
                    data:{V1:V1,V2:V2},  
                     success:function(data){  
                          $('#p12').html(data);  
                     }  
                });  
           }  
      }); 
 });


 </script>  -->


  <!--<script>  
 $(document).ready(function(){  
      $('#pp1').change(function(){  
           var V1 = $('#pp1').val(); 
           var V2 = $('#kode').val();   
           if(V1 != '')  
           {  
                $.ajax({  
                     url:"<?php echo site_url();?>bisbesar/cek/check_eksis",  
                     method:"POST",  
                     data:{V1:V1,V2:V2},  
                     success:function(data){  
                          $('#pesanpp11').html(data);  
                     }  
                });  
           }  
      });
      } 
      </script>-->
<br style="clear: both" />
              </div>
       </div>
       </div>