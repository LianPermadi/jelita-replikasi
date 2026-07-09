<?php
$login= $this->session->userdata('login');
$peran= $this->session->userdata('n_otoritas');
if ($login){
?>
<div class="nav">
<ul class="sf-menu">

 <?php
        if ($peran == "Operator"){
            ?>
                <li><a href="<?php echo site_url('admin_profil');?>">Ganti Password</a> </li>
                <li><a href="<?php echo site_url('admin/logout');?>">LogOut</a> </li>
            <?php
        }else{
        ?>
        
  
            
        <li><a href="<?php echo site_url('admin_config/link_service');?>">Pengaturan Alamat Web Service</a></li>
        <li><a href="<?php echo site_url('admin_user');?>">Admin User</a> </li>
        <li><a href="<?php echo site_url('admin/logout');?>">LogOut</a> </li>
        <?php }?>

</ul>

    <!--<ul class="sf-menu">
        <?php
        if ($peran == "Operator"){
            ?>
                <li><a href="<?php echo site_url('admin_home');?>">Halaman Utama</a></li>
                <li><a href="<?php echo site_url('admin_info_public');?>">Info Publik</a> </li>
                 <li><a href="<?php echo site_url('admin_profil');?>">Ganti Password</a> </li>
                <li><a href="<?php echo site_url('admin/logout');?>">LogOut</a> </li>
            <?php
        }else{
        ?>
        <li><a href="<?php echo site_url('admin_home');?>">Halaman Utama</a></li>
        <li><a href="<?php echo site_url('admin_info_public');?>">Info Publik</a> </li>
        <li><a href="<?php echo site_url('admin_profil_daerah');?>">Profil Daerah</a> </li>
        <li><a href="<?php echo site_url('admin_download');?>">Download</a> </li>
        <li><a href="<?php echo site_url('admin_galeri');?>">Galeri</a> </li>	
        <li><a href="<?php echo site_url('admin_kontak');?>">Kontak Kami</a> </li>
        <li>
            <a href="#"  class="current">Pengaturan Website</a> 
            <ul style="margin-top: 4px;">
                <li><a href="<?php echo site_url('admin_config');?>">Mengelola Header</a></li>
                <li><a href="<?php echo site_url('admin_config/template_css');?>">Template Website</a></li>
                <li><a href="<?php echo site_url('admin_config/link_service');?>">Alamat Web Service</a></li>
            </ul>                        
        </li>
        <li><a href="<?php echo site_url('admin_jajak');?>">Jajak</a> </li>
        <li><a href="<?php echo site_url('admin_user');?>">Admin User</a> </li>
        <li><a href="<?php echo site_url('admin/logout');?>">LogOut</a> </li>
        <?php }?>
    </ul>-->
</div>
<?php }?>