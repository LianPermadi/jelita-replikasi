<div id="content">
    <div class="post">
        <div class="title">
          <h2> <center><?php echo ' DATA PERUSAHAAN API';?></center></h2>
        </div>
<div class="entry">
 <?php //echo 'Pesan : '?>
  <div class="dropdown"><a href="<?php echo base_url() . 'main/laporanapiuser/pesan'; ?>"><span class="glyphicon glyphicon-home"></span></a>
  <a style="text-decoration: none;" href="#"> Pesan Masuk </a><span  id="load_row" style="border-radius:5px 5px 5px 5px; width:50px;height: 20px; background: red;"><?php echo '   '.$jlhnotif;?></span>
  <div class="dropdown-content" role="menu" id="load_data">
  
                <?php 
                $no=0;
                if ($notifikasi != null) {
                foreach($notifikasi as $rnotif){ 
                  $no++;
                    if($no % 2==0){$cl='strip1';}else{$cl='strip2';}
                ?>
                <a href="pesan/<?php echo $rnotif->id_tmpemohon;?>" style="text-decoration: none;">
                <div  class="<?php echo $cl;?>">
                <div  style="text-indent: 10px;color: red;"><?php echo $rnotif->oleh. ' : '.substr($rnotif->pesan,0,12).' ...';?></div>
                 <div style="text-indent: 10px; "><small><?php echo timeAgo($rnotif->tanggal);?></small></div>
                </div>
                </a>

              
                <?php }
                }?>
              
                
  </div>
</div>
         <br style="clear: both" /> 
 <br style="clear: both" />
<table cellpadding="0" cellspacing="0" border="0" class="display" id="dataapi" >
                <thead>
                    <tr>
                      <th width="" >No</th>
                      <th width="" >Nama Perusahaan</th>
                      <th width="" >Alamat</th>
                       <th width="">No API</th>
                       <th width="">NPWP Perusahaan</th>
                        <th width="">Kabupaten/Kota</th>
                        <th width="">Telepon</th>
                        <th width="">Fax</th>
                        <th width="">Email</th>
                        <th width="">Aksi</th>
                       
                    </tr>
                </thead>
                <tbody>
                	 <?php
        if($api_table !== "")
        {

            echo $api_table;

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

<br style="clear: both" />
       </div>
       </div>
       </div>
       <!--<link href="<?php echo base_url()?>assets/roynotif/css/bootstrap.min.css" rel="stylesheet">-->
<link href="<?php echo base_url()?>assets/roynotif/css/style.css" rel="stylesheet">
<!-- jquery core -->
<script src="<?php echo base_url()?>assets/roynotif/js/jquery.min.js"></script>
<!-- Bootstrap core JavaScript -->
<script src="<?php echo base_url()?>assets/roynotif/js/bootstrap.min.js"></script>
              <script>
             var jq = $.noConflict();
setInterval(function(){
jq("#load_row").load('<?php base_url()?>pengenalimpor/c_pengenalimpor/load_row')
}, 1000);
setInterval(function(){
jq("#load_data").load('<?php base_url()?>pengenalimpor/c_pengenalimpor/load_data')
}, 1000);
</script>
<style type="text/css">
  .text{
    padding-top:7px!important;
    text-align:right;
  }
  
  .buton{
    font-weight:bold;
  }
  .buton:hover{
    text-decoration:none
  }
 




 
.strip1 {


}
 
.strip2 {
   
    
}


.dropdown {
    position: relative;
    display: inline-block;
    margin-left: 30px;
}

.dropdown-content {
    display: none;
    position: absolute;
    background-color: #f9f9f9;
    min-width: 160px;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    padding: 12px 16px;
    z-index: 1;
    text-indent: 10px;

}

.dropdown:hover .dropdown-content {
    display: block;
    width: 230px;

}
.strip2:hover {
    background-color: gray;
    width: 200px;
}
.strip1:hover {
    background-color: gray;
    width: 200px;
}
</style>