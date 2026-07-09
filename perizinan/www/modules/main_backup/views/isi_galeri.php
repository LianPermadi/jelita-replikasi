<?php
    $base = base_url() . 'assets/css/default/';
    $base_url = base_url() . 'assets/';
    echo $this->lib_load_css_js->load_js($base_url, "js/fancybox/", "jquery.mousewheel-3.0.4.pack.js");
    echo $this->lib_load_css_js->load_js($base_url, "js/fancybox/", "jquery.fancybox-1.3.4.pack.js");
    echo $this->lib_load_css_js->load_css($base_url,"js/fancybox/", "jquery.fancybox-1.3.4.css");
?>

<script type="text/javascript">
        $(document).ready(function() {
                $("a#example7").fancybox({
                        'titlePosition'	: 'inside'
                });
        });
</script>
<style>
    .paging a{color: #0066FF;text-decoration: none;border: 1px solid #0073ea;padding: 2px;background-color: #F0F0EE;}
     .paging a:hover{color: #fbcb09;text-decoration: none;background-color: #BDD2FF;}
     .paging strong {color: #fbcb09;border: 1px solid #0073ea;padding: 2px;background-color: #F0F0EE;}
</style>

<div class="isi">
    <div id="entry">
        <h2><?php echo "$title" ?></h2>
        
        <div class="kiri">
            <div class="galeri">
                <ul>
                    <?php
                        foreach ($data_galeri as $data){
                            
                            echo"<li>
                                <a id='example7' href='".base_url()."uploads/galeri/$data->N_ALAMAT_GALLERY' id='example7' title='$data->N_KETERANGAN_GALLERY'>
                                <img src='".base_url()."uploads/galeri/". $data->N_ALAMAT_GALLERY." 'width='200' height='150'/></a></li>";
                        }
                        echo "<div class='clear'></div>";
                        echo "<center>".$link_pagging."</center>";
                        echo "<br/><br/>";
                    ?>     
                   
                </ul>
            </div>
        </div>

        <div class="kanan">
            <?php echo "$menu" ?>
            <?php echo "$menu1" ?>
        </div>
        
    </div>
    
    <div class="clear"></div>

</div>
