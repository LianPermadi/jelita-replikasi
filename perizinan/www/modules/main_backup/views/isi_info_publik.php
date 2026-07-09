<style>
    .paging a{color: #0066FF;text-decoration: none;border: 1px solid #0073ea;padding: 2px;background-color: #F0F0EE;}
    .paging a:hover{color: #fbcb09;text-decoration: none;background-color: #BDD2FF;}
    .paging strong {color: #fbcb09;border: 1px solid #0073ea;padding: 2px;background-color: #F0F0EE;}
</style>
    
<div class="isi">
    <div class="clear"></div>
    
    <div id="entry">
       <h2><?php echo "$title" ?></h2>
       
       <div class="kiri">
           
           <?php
                foreach ($berita as $data){
                    
                    echo "<div class='berita'>";
                        echo "<p><b> $data->N_JUDUL_BERITA </b> </p>";
                        
                    $pecah = explode(' ',$data->D_BERITA);
                    $new_date=date('d M Y ', strtotime($pecah[0]));  
                    
                    $namahari=date('l', strtotime($pecah[0])); 
                    
                    $jam=  substr($data->D_BERITA, 10,9);
                    
                    if ($namahari == "Sunday") $namahari = "Minggu";
                    else if ($namahari == "Monday") $namahari = "Senin";
                    else if ($namahari == "Tuesday") $namahari = "Selasa";
                    else if ($namahari == "Wednesday") $namahari = "Rabu";
                    else if ($namahari == "Thursday") $namahari = "Kamis";
                    else if ($namahari == "Friday") $namahari = "Jumat";
                    else if ($namahari == "Saturday") $namahari = "Sabtu";                   
                       
                    //echo "<p><em>$new_date - $pecah[1]</em></p>";
                         echo "<p><em>$namahari, $new_date  -- $jam </em></p>";
                        
                        $berita=$data->N_ISI_BERITA;
                        
                        if(strlen($berita)>400){
                            $berita=substr($berita, 0, 400);
                            echo strip_tags($berita)."........"; 
                        }
                        else{
                             echo strip_tags($berita);  
                        }
                        
                        echo "<br/><br/><p><a href='".base_url()."main/info_publik/lihat_detail/".$data->C_BERITA."' >Baca selengkapnya »</a>";
                    echo "</div>";
                }
                echo "<center>".$link_pagging."</center>";
                echo "<br/><br/>";
           ?>
       </div>
       
       <div class="kanan">
            <?php echo "$menu" ?>
            <?php echo "$menu1" ?>
       </div>
       
       
    </div>
    <div class="clear"></div>
</div>
