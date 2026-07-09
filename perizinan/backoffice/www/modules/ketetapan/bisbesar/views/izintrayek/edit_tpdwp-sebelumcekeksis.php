
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

foreach($bb_tpdwp2 as $u){

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

}
 ?>
<div id="content">
    <div class="post">
        <div class="title">
            <h2><?php echo $page_name; ?></h2>
        </div>
<div class="entry">

<!--<button onclick="goBack()" class="button-wrc">Kembali</button>-->
<!--<a href=<?php echo base_url()."bisbesar/c_izintrayek/tambahtpdwp/".$TPDWP_ID ;?> class="button-wrc" style ="text-decoration: none">Tambah tpdwp</a>-->
<script>
function goBack() {
    window.history.back();
}
</script>

 <label>NAMA PERUSAHAAN</label>: <?php //echo $NAMA_PERUS; ?>
             <input type="text" name ="" class="form-control" value="<?php echo $NAMA_PERUS; ?>" readonly required>  
             <br style="clear: both" />
             <label>ALAMAT</label> : <?php //echo $ALAMAT_PER;?>
             <input type="text" style="width: 600px;" name ="" class="form-control" value="<?php echo $ALAMAT_PER; ?>" readonly required>
           <!-- <textarea  class="input-area-wrc" name = "ALAMAT_PER" readonly="true"><?php echo $ALAMAT_PER;?></textarea>-->
             <br style="clear: both" />

             <label>NO KENDARAAN / KONTROL </label> : <!--<?php //echo $NO_MOBIL; ?> / <?php //echo $NO_UJI; ?>-->
             <input type="text" name ="" class="form-control" value="<?php echo $NO_MOBIL; ?>" readonly required> &nbsp; / &nbsp; 
               <input type="text" name ="" class="form-control" value="<?php echo $NO_UJI; ?>" readonly required>
             <br style="clear: both" />

              <label>NO. KP / MASA BERLAKU</label> : <!--<?php //echo $NOMOR_KP; ?> / <?php //echo $TG_MULAI; ?> s/d <?php echo $TG_AKHIR;?>-->
              <input type="hidden" name ="" class="form-control" value="<?php echo $NOMOR_KP; ?>" readonly required>
             <input type="text"  name ="" class="form-control" value="<?php echo tanggal_indo($TG_MULAI); ?>" readonly required>
              s/d 
             <input type="text" name ="" class="form-control" value="<?php echo tanggal_indo($TG_AKHIR);?>" readonly required>
             <br style="clear: both" />

             <label>KODE TRAYEK </label>:  <!--<?php echo $KODE_TRAYE; ?> - <?php echo $NAMA_TRAYE;?>-->
             <input type="text" name ="" class="form-control" value="<?php echo $KODE_TRAYE; ?>" readonly required>
             <br style="clear: both" />

               <!--<label>TRAYEK </label>
             <textarea class="input-area-wrc" name = "NAMA_TRAYE" readonly="true"><?php echo $NAMA_TRAYE;?></textarea>

             <br style="clear: both" />-->
              
            <label>NO SK </label> : <?php //echo  $NO_SK; ?>
             <input type="text" name ="" class="form-control" value="<?php echo  $NO_SK; ?>" readonly required>
             <br style="clear: both" />

             <label>TANGGAL SK </label> : <?php //echo $TG_SK; ?>
             <input type="text" name ="" class="form-control" value="<?php echo $TG_SK; ?>" readonly required>
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
 <table cellpadding="0" cellspacing="0" border="0" class="display" id="izintrayek" >
   <thead>
                    <tr>
                         <!--<th width="">No</th>
                        <th width="">KODE TERMINAL</th>-->
                        <th >LINTASAN / KOTA / TERMINAL</th>
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
  $y=1;
   foreach($bb_tpdwp as $u2){
   $TP =  $u2->TPDWP_ID;
   $J = $u2->JARAK;
   ?> 

<tr>

   <form method = "POST" action = "<?php echo base_url();?>bisbesar/c_izintrayek/update_tpdwp" enctype="multipart/form-data">
   <!--<td><?php echo $y++;?></td>
   <td><input type="text" name="TERMINAL_I" id="" readonly="true" style=" width:50px;" value="<?php echo $u2->TERMINAL_I; ?>">
   </td>--><td>
<input type="text" name="NAMA_TERM3" class='autocomplete' id="autocomplete1" style=" width:150px;" value="<?php echo $u2->NAMA_TERM3; ?>">
            </td>
               <td><input name="TPDWP_ID" type="hidden" style=" width:40px;" value="<?php echo $u2->TPDWP_ID;?>">
        <input name="JARAK" type="text" style=" width:40px;" value="<?php echo $u2->JARAK;?>"></td>
 
         <td>
<input name="KP_ID" value="<?php echo $u2->KP_ID;?>" type="hidden" style=" width:40px;">
         <input name="PP1_1" value="<?php echo $u2->PP1_1;?>" class='autocompletex' id="autocomplete1x" type="text" style=" width:40px;"></td>
            <td><input name="PP1_2" value="<?php echo $u2->PP1_2;?>" type="text" style=" width:40px;"></td>
            <td><input name="PP2_1" value="<?php echo $u2->PP2_1;?>" type="text" style=" width:40px;"></td>
            <td><input name="PP2_2" value="<?php echo $u2->PP2_2;?>" type="text" style=" width:40px;"></td>
            <td><input name="PP3_1" value="<?php echo $u2->PP3_1;?>" type="text" style=" width:40px;"></td>
            <td><input name="PP3_2" value="<?php echo $u2->PP3_2;?>" type="text" style=" width:40px;"></td>
            <td><input name="PP4_1" value="<?php echo $u2->PP4_1;?>" type="text" style=" width:40px;"></td>
            <td><input name="PP4_2" value="<?php echo $u2->PP4_2;?>" type="text" style=" width:40px;"></td>
            <td><input name="PP5_1" value="<?php echo $u2->PP5_1;?>" type="text" style=" width:40px;"></td>
            <td><input name="PP5_2" value="<?php echo $u2->PP5_2;?>" type="text" style=" width:40px;"></td>
            <td><input name="PP6_1" value="<?php echo $u2->PP6_1;?>" type="text" style=" width:40px;"></td>
            <td><input name="PP6_2" value="<?php echo $u2->PP6_2;?>" type="text" style=" width:40px;">     
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
               
        <td><input type="text" name="xTERMINAL_I" id="id" readonly="true" style=" width:50px;"><input type="text" name="xNAMA_TERM3" class='autocomplete' id="autocomplete1" style=" width:150px;" required="true">
        </td>
                 <td><input name="TPDWP_ID" type="hidden" style=" width:40px;" >
        <input name="xJARAK" type="text" style=" width:40px;" ></td>
            <td><input name="xPP1_1" type="text" class='autocompletex' id="autocomplete1x" style=" width:40px;"></td>
            <td><input name="xPP1_2" class="auto_PP1_2" type="text" style=" width:40px;"></td>
            <td><input name="xPP2_1"  type="text" style=" width:40px;"></td>
            <td><input name="xPP2_2"  type="text" style=" width:40px;"></td>
            <td><input name="xPP3_1"  type="text" style=" width:40px;"></td>
            <td><input name="xPP3_2"  type="text" style=" width:40px;"></td>
            <td><input name="xPP4_1"  type="text" style=" width:40px;"></td>
            <td><input name="xPP4_2"  type="text" style=" width:40px;"></td>
            <td><input name="xPP5_1"  type="text" style=" width:40px;"></td>
            <td><input name="xPP5_2"  type="text" style=" width:40px;"></td>
            <td><input name="xPP6_1"  type="text" style=" width:40px;"></td>
            <td><input name="xPP6_2"  type="text" style=" width:40px;"></td>
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

 <!--<form method = "POST" action = "<?php echo base_url();?>bisbesar/c_izintrayek/tambah_tpdwp_aksi" enctype="multipart/form-data">
  


   <td><input type="text" name="xTERMINAL_I" id="id" readonly="true" style=" width:50px;">
   </td><td>
   
<input type="text" name="xNAMA_TERM3" class='autocomplete' id="autocomplete1" style=" width:150px;" required="true">
            </td>
               <td><input name="TPDWP_ID" type="hidden" style=" width:40px;" >
        <input name="xJARAK" type="text" style=" width:40px;" ></td>
 
         <td>
            <input name="xPP1_1" type="text" style=" width:40px;"></td>
            <td><input name="xPP1_2"  type="text" style=" width:40px;"></td>
            <td><input name="xPP2_1"  type="text" style=" width:40px;"></td>
            <td><input name="xPP2_2"  type="text" style=" width:40px;"></td>
            <td><input name="xPP3_1"  type="text" style=" width:40px;"></td>
            <td><input name="xPP3_2"  type="text" style=" width:40px;"></td>
            <td><input name="xPP4_1"  type="text" style=" width:40px;"></td>
            <td><input name="xPP4_2"  type="text" style=" width:40px;"></td>
            <td><input name="xPP5_1"  type="text" style=" width:40px;"></td>
            <td><input name="xPP5_2"  type="text" style=" width:40px;"></td>
            <td><input name="xPP6_1"  type="text" style=" width:40px;"></td>
            <td><input name="xPP6_2"  type="text" style=" width:40px;">     
           <br style="clear: both" />

<input type="text"  name ="xPIT_ID" class="form-control" value="<?php echo $PIT_ID; ?>" readonly >
<br style="clear: both" />
<input type="text" name ="xNO_SK" class="form-control" value="<?php echo $NO_SK; ?>" readonly >
<br style="clear: both" />
<input type="text" name ="xTG_SK" class="form-control" value="<?php echo $TG_SK; ?>" readonly >
<br style="clear: both" />
<input type="text" name ="xKP_ID" class="form-control" value="<?php echo $KP_ID; ?>" readonly >
<br style="clear: both" />
<input type="text" name ="xNOMOR_KP" class="form-control" value="<?php echo $NOMOR_KP; ?>" readonly >
<br style="clear: both" />
<input type="text" name ="xNO_MOBIL" class="form-control" value="<?php echo $NO_MOBIL; ?>" readonly >
<br style="clear: both" />
<input type="text" name ="xNO_UJI" class="form-control" value="<?php echo $NO_UJI; ?>" readonly >
<br style="clear: both" />
<input type="text" name ="xPAU_ID" class="form-control" value="<?php echo $PAU_ID; ?>" readonly >
<br style="clear: both" />
<input type="text" name ="xTRA_ID" class="form-control" value="<?php echo $TRA_ID; ?>" readonly >
<br style="clear: both" />
<input type="text" name ="xKODE_TRAYE" class="form-control" value="<?php echo $KODE_TRAYE; ?>" readonly >
<br style="clear: both" />
<input type="text" name ="xNAMA_TRAYE" class="form-control" value="<?php echo $NAMA_TRAYE; ?>" readonly >
<br style="clear: both" />

    
             <br style="clear: both" />
              <button class="button-wrc" );">SIMPAN</button></td>

              
</form>-->

      



    <script type='text/javascript'>
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

<br style="clear: both" />

              </div>
       </div>
       </div>