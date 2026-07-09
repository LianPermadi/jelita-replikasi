<div class="isi">
    <div class="clear"></div>
    
    <div id="entry">
       <h2><?php echo "$title" ?></h2>
       
       <div class="kiri">
           <div class="berita">
                <?php
                    echo "<p><b> $berita->N_JUDUL_BERITA </b> </p>";
                    
                    $pecah = explode(' ',$berita->D_BERITA);
                    $new_date=date('d M Y ', strtotime($pecah[0]));  
                    
                    $namahari=date('l', strtotime($pecah[0])); 
                    
                    $jam=  substr($berita->D_BERITA, 10,9);
                    
                    if ($namahari == "Sunday") $namahari = "Minggu";
                    else if ($namahari == "Monday") $namahari = "Senin";
                    else if ($namahari == "Tuesday") $namahari = "Selasa";
                    else if ($namahari == "Wednesday") $namahari = "Rabu";
                    else if ($namahari == "Thursday") $namahari = "Kamis";
                    else if ($namahari == "Friday") $namahari = "Jumat";
                    else if ($namahari == "Saturday") $namahari = "Sabtu";                   
                       
                    //echo "<p><em>$new_date - $pecah[1]</em></p>";
                         echo "<p><em>$namahari, $new_date  -- $jam </em></p>";
                         $des=  str_replace("../../assets/", "../../../assets/", $berita->N_ISI_BERITA);
					echo "$des";
                ?>
               <br/>
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
