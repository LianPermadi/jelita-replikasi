<h1 class="pageTitle"><span>Step 2:</span> Pengecekan server</h1>
<p>
    <ul>
    <?php
        $array=gd_info ();
        foreach ($array as $key=>$val) 
        {
          if ($val===true) 
          {
            $val="Enabled";
          }
          if ($val===false) 
          {
            $val="Disabled";
          }
          if($key=="JPG Support")
          {
              $hasil=$val;
          }echo "<li>$key: $val <li>";
        }
         
          
    ?>
   </ul>
</p>    
<a href="<?php echo base_url(); ?>generate" class="nextbutton" title="Sebelumnya">Sebelumnya</a>
&nbsp;&nbsp;&nbsp;
<a href="<?php echo base_url(); ?>generate/step3" class="nextbutton" title="Selanjutnya">Selanjutnya</a>

