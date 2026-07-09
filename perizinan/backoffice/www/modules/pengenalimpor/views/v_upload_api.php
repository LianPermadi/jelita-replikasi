<?php if(@$msg<>"") 
{
   if(@$msg == "sukses")
    {
    ?>
    <script>alert("Data Berhasil disimpan");
    window.location.href='pengenalimpor/c_impor/'
    </script>

    <?php
   
    }else{
    ?>
    <script>alert("Data gagal disimpan");
    window.location.href='pengenalimpor/c_impor/'
    </script>
    <?php

}
}
?>
<link rel="stylesheet" href="<?php echo base_url();?>assets/autocomplete/js/jquery-ui.css"> 
<script src="<?php echo base_url();?>assets/autocomplete/js/jquery-1.10.2.js"></script> 
<script src="<?php echo base_url();?>assets/autocomplete/js/jquery-ui.js"></script>
<script type="application/javascript">

  function isnumeric(evt)
      {
      var charCode = (evt.which) ? evt.which : event.keyCode
          if (charCode != 46 && charCode > 31
            && (charCode < 48 || charCode > 57))
             return false;

          return true;
      }

</script>

<script type="text/javascript"> 
var f=jQuery.noConflict();
<!-- akhir auto complete -->
f(function() { 
 var date = f('#datepicker').datepicker({ dateFormat: 'yy-mm-dd' }).val();
}); 
</script>

<div id="content">
    <div class="post">
        <div class="title">
            <h2><?php echo $page_name; ?></h2>
        </div>
<div class="entry">
  
<form action="<?php echo base_url();?>pengenalimpor/c_impor/upload/" method="post" enctype="multipart/form-data">
			
		

           <label>NOMOR API</label>
            <input type="text" name ="NOMOR_API" class="form-control"  onkeypress="return isnumeric(event)" maxlength="15" required>
            <br style="clear: both" />

            <label>NAMA PERUSAHAAN</label>
            <input type="text" name ="NAMA_PERUSAHAAN" class="form-control"  required>
            <br style="clear: both" />

            <label>ALAMAT PERUSAHAAN</label>
            <input type="text" name ="ALAMAT" class="form-control"  required>
            <br style="clear: both" />

            <label>JENIS API</label>
           <select name ="JENIS" class="form-control select" required>
            
            <option selected value = 'API-P' >PRODUSEN</option>
            <option selected value = 'API-U' >UMUM</option>
          
            </select> 
            <br style="clear: both" />

            <label>NOMOR API</label>
            <input type="text" name ="NOMOR_API" class="form-control"  required>
            <br style="clear: both" />

            <label>TANGGAL API</label>
             <input type="text" name ="TG_API" class="form-control" value =" <?php echo date("Y-m-d"); ?>" readonly  id="datepicker" >
            <br style="clear: both" />


			<label>UPLOAD EXCEL</label>
   			<input type="file" name="file" required />
   			<br style="clear: both" />
   			<br style="clear: both" />
   			<label> </label>
    		<input type="submit" value="KIRIM"/>
</form>
<br style="clear: both" />
       </div>
       </div>
       </div>