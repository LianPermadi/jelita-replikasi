<div class="isi">
    <div class="clear"></div>
    
    <div id="entry">
       <h2><?php echo "$title" ?></h2>
       
       <div class="kiri">
           <div class="berita">
               
               
               <?php 
                    $des=  str_replace("assets/", "../assets/", $isi_informasi);
                    echo "$des" 
               ?>
               <div class="clear"></div>
           </div>
           
       </div>
       
       <div class="kanan">
            <?php echo "$menu" ?>
            <?php echo "$menu1" ?>
       </div>
       
       
    </div>
    <div class="clear"></div>
</div>
