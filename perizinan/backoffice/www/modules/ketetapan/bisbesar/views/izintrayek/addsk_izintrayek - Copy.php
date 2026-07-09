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
<!-- end auto complete -->

<div id="content">
    <div class="post">
        <div class="title">
            <h2><?php echo $page_name; ?></h2>
        </div>
<div class="entry">


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
            <input type="text" name ="TGL_BAND" class="form-control" readonly  id="datepicker" >
           
            <br style="clear: both" />
            <label>JENIS SK</label>
             <select name ="JENIS_SK" class="form-control select" style="width:207px;" >
            <option  value = 1 >DAFTAR ULANG</option>
            <option  value = 2 >PENGGANTIAN</option>
            <option  value = 3 >PELIMPAHAN</option>
            <option  value = 4 >PENAMBAHAN</option>
            <option  value = 5 >DUPLIKAT</option>
            </select> 
            
            <br style="clear: both" />

            <label>JENIS ANGKUTAN</label>
          <select name ="JENIS_ANGK" class="form-control select" style="width:207px;" >
            <option  value = 1 >BIS BESAR</option>
            <option  value = 2 >BIS SEDANG</option>
            <option  value = 3 >BIS KECIL</option>
            <option  value = 4 >ANGKOT</option>
            <option  value = 5 >TAKSI</option>
            <option  value = 6 >ANGK. KHUSUS</option>
</select>
          
            <br style="clear: both" />

            <label>TARIF BAND</label>
            <input type="number" name ="TARIF_BAND"  >
            <br style="clear: both" />

            <label>TAHUN</label>
            <input type="number" name ="TELAT_TH"  >
            <br style="clear: both" />

            <label>BULAN</label>
            <input type="number" name ="TELAT_BL"   >

              <br style="clear: both" />
            <label>DENDA</label>
            <input type="number" name ="DENDA_BAND"  >
           
            <br style="clear: both" />

            <label>NOMOR INDUK</label>
            <input type="search" name ="NO_IP" required class='autocomplete' id="autocomplete1" >

            <br style="clear: both" />
            <label>NAMA PERUSAHAAN</label>

            <input type="text" name ="NAMA_PERUS" readonly class="form-control" id="v_nama_perus"> 
            <br style="clear: both" />
            <label>ALAMAT PERUSAHAAN</label>
            <textarea  name ="ALAMAT_PER" readonly id="v_alamat_per" class="input-area-wrc"></textarea>

            <br style="clear: both" />
            <label>KAB / KOTA</label>
            <input type="text" name ="KODYA_ID" id="v_kodya_id" class="form-control" readonly >
            <input type="text" name ="KOTA" id="v_kodya" class="form-control" readonly >
           

            <br style="clear: both" />
            <label>NAMA PIMPINAN</label>
            <input type="text" name ="PEMILIK" id="v_nama_pem" class="form-control" readonly >
           
            <br style="clear: both" />
            <label>ALAMAT PIMPINAN</label>
           <textarea  name ="ALAMAT_PEM" id="v_alamat_pem" class="input-area-wrc" readonly></textarea>
           
            <br style="clear: both" />
            <label>NOMOR SK</label>
             <input type="text" name ="NO_SK" class="form-control" required >
              <br style="clear: both" />

            <label>MASA BERLAKU</label>
            <input type="text" name ="TG_SK"  class="form-control" readonly  id="datepicker1" style="width:82px"> s/d 
            
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

<!--<table cellpadding="0" cellspacing="0" border="0" class="display" id="izintrayek" >
                <thead>
                    <tr>
                      <th width="" >NO</th>
                       <th width="">TGL BAND</th>
                       <th width="">JENIS SK</th>
                        <th width="">JENIS ANGKUTAN</th>
                       <!-- <th width="">TARIF BAND</th>
                        <th width="">TLT THN</th>
                        <th width="">TLT BLN</th>-->

                        <!--<th width="">NIK</th>
                        <th width="">NAMA PERUSAHAAN</th>
                        <th width="">ALAMAT PERUSAHAAN</th>
                        <th width="">KAB / KOTA</th>-->
                       <!-- <th width="">NAMA PIMPINAN</th>
                        <th width="">ALAMAT PIMPINAN</th>-->

                      <!--  <th width="">NOMOR SK</th>
                        <th width="">TANGGAL</th>
                        <th width="">MASA BERLAKU</th>
                        <th width="">SK LAMA</th>
                        <th width="">TGL SK LAMA</th>

                        <th width="">AKSI</th>
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
