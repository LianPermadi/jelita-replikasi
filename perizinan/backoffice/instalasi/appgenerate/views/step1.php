<?php
 $this->load->helper('file');
 $permision= octal_permissions(fileperms('../www/config/database.php'));
 $dapatditulis= is_writable('../www/config/database.php');
?>
<h1 class="pageTitle"><span>Step </span> Perkenalan</h1>
<p>Pastikan Sistem Requirements dan informasi database sudah terpenuhi untuk melakukan instalasi ini. Jika sudah anda dapat melanjutkan ke tahap selanjutnya.</p>

<h2>Kebutuhan Sistem :</h2>
<ul>
    <?php
    $array=gd_info ();
        foreach ($array as $key=>$val) 
        {
          if($key=="JPEG Support")
          {
              if ($val===true) 
              {
                $val="Enabled";
              }
              if ($val===false) 
              {
                $val="<i id='warning'>Disabled</i>";
              }
              echo "<li>".$key." : ". $val." </li>";
          }
        }
        echo '<li>display_errors = ' . (ini_get('display_errors')==1?'<i id="warning">On</i>':'Off').'</li>';
        echo '<li>register_globals = ' . (ini_get('register_globals')==1?'<i id="warning">On</i>':'Off').'</li>';
    ?>
  <li>PHP 5.2 (PHPCurl, PHPXml_RPC dan SimpleXML)</li>
  <li>Minimal MySQL 5.1.52 atau versi terbaru</li>
  <li>Apache 2.0 or IIS 5.0</li>
</ul>

<h2>Kewenangan :</h2>
<ul>
    <li>Permision file config/database.php adalah <?php echo $permision; ?></li>
    <?php
    $text="<i id='warning'>File tidak dapat ditulis, ubah kepemilikan file.</i>";
    if($dapatditulis==TRUE)
    {
        $text="dapat ditulis";
    }
        ?>
    <li>File config/database.php adalah <?php echo $text; ?></li>
</ul>
<h2>Informasi yang harus dimasukkan :</h2>
<ul>
    <script>
        function cekNilai(data)
        {
            if(data==true)
                {
                    window.location='<?php echo base_url(); ?>generate/step3';
                }
        }
    </script>
  <li>Database Host</li>
  <li>Database User</li>
  <li>Database Password</li>
  <li>Database Name</li>
  <li>Table Prefix</li>
</ul>

<h2>Langkah-langkah Instalasi :</h2>
<ol>
  <li>Perkenalan</li>
  <li>Konfigurasi Database</li>
  <li>Selesai</li>
</ol>
<a href="#" onClick='cekNilai("<?php echo $dapatditulis; ?>");return false;' class="nextbutton" title="Selanjutnya" >Selanjutnya</a>
