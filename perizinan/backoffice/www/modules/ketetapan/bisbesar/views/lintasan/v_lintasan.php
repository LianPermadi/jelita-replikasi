<?php if(@$msg<>"") 
{
   if(@$msg == "sukses")
    {
    ?>
    <script>alert("Data Berhasil disimpan");window.location.href='../../bisbesar/c_lintasan'</script>

    <?php
   
    }else{
    ?>
    <script>alert("Data gagal disimpan");window.location.href='../../bisbesar/c_lintasan'</script>
    <?php

}

}
?>

 
<div id="content">

    <div class="post">
        <div class="title">
            <h2><?php echo $page_name; ?></h2>
        </div>

        
<div class="entry">

<!--<div class="popup">
  <div class="bg"></div>

  <div class="content">
 <div class="close">Close</div>
  <br>
  <br>
   <div class="content-text">
 <table cellpadding="0" cellspacing="0" border="0" class="display" id="lintasan" >
                <thead>
                    <tr>
                      <th width="" >NO</th>
                        <th width="">KODE TRAYEK</th>
                        <th width="">NAMA TRAYEK</th>
                        <th width="">AKSI</th>
                    </tr>
                </thead>
                <?php
        if($lintasan_table !== "")
        {

            //echo $lintasan_table;

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
 </div>
  
  </div> 
 </div>
   <br style="clear: both" />
   <br style="clear: both" />
   <br style="clear: both" />-->

<!--<div id="" style="width:100%"">
<div id="" style="width:50%;float:left;margin-left: 5%; ">-->
<div style="width: 40%; float:left;">
<form method = "POST" action = "<?php echo base_url();?>bisbesar/c_lintasan/update_aksi" enctype="multipart/form-data">
              <input type="hidden" name ="NO_MOBIL" class="form-control"  required>

            <br style="clear: both" />
            <label>KODE TRAYEK</label>
            <input type="text" name ="NO_MOBIL" class="form-control" v required  ><!--&nbsp;&nbsp;<a href="#" class="button-wrc popup-show" style="text-decoration: none;">Cari</a>-->

            <br style="clear: both" />
            <label>NAMA TRAYEK</label>
            <textarea name="NAMA_TRAYE" class="input-area-wrc" required></textarea>
            <br style="clear: both" />
            <label>VIA</label>
            <input type="text" name ="NO_MOBIL" class="form-control" v required>

            <br style="clear: both" />
            <label>KAPASITAS</label>
            <input type="text" name ="NO_MOBIL" class="form-control" v required>

            <br style="clear: both" />
            <label>TARIF EKONOMI</label>
            <input type="text" name ="NO_MOBIL" class="form-control" v required>

            <br style="clear: both" />
            <label>TARIF PATAS</label>
            <input type="text" name ="NO_MOBIL" class="form-control" v required>

            <br style="clear: both" />
            <label>KETERANGAN</label>
            <textarea name="KETERANGAN" class="input-area-wrc" ></textarea>
            
            <br style="clear: both" />

            <button class="button-wrc" style="margin-left: 100px;">Update</button>
            <a href = <?php echo base_url().'bisbesar/c_lintasan';?> class= 'button-wrc' style="text-decoration: none;" >Batal</a>
           
    </form>
    </div>
    <div style="width:55%; float:left;">
    <table cellpadding="0" cellspacing="0" border="0" class="display" id="lintasan2" >
                <thead>
                    <tr>
                      <th width="" >NO</th>
                       
                        <th width="">BERANGKAT DARI</th>
                        <th width="">TIBA DI</th>
                        <th width="">KM</th>
                    </tr>
                </thead>
                <?php
        if($lintasan2_table !== "")
        {

            //echo $lintasan2_table;

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
                <br>
                <br>
    </div>

    <br style="clear: both" /><br style="clear: both" />
<table cellpadding="0" cellspacing="0" border="0" class="display" id="lintasan" >
                <thead>
                    <tr>
                      <th width="" >NO</th>
                        <th width="">KODE TRAYEK</th>
                        <th width="">NAMA TRAYEK</th>
                        <th width="">AKSI</th>
                    </tr>
                </thead>
                <?php
        if($lintasan_table !== "")
        {

            echo $lintasan_table;

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
<div id="" style="width:30%; float:left; margin-left: 5%;border : 0px solid gray;">-->


   <!--</div>
   </div>
<br style="clear: both" />-->


       </div>

       <style>
  /* Letakkan Kode CSS di sini */
   .popup{
  display: none;
 }
 .bg{
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: rgba(0,0,0,0.5);
 }
 .content{
  position: relative;
  top:50px;
  width: 70%;
  margin: 0 auto;
  background: #fff;
  padding:  10px 20px 10px 20px;
 }
 .content-text{
   
 }
 .close{
  display: inline-block;
  padding: 7px 15px;
  cursor: pointer;
  background: #E74C3C;
  color: #fff;
 }
 .close:hover,.close:visited{
  background: #C0392B;
 }
 </style>


 
       </div>
       </div>
