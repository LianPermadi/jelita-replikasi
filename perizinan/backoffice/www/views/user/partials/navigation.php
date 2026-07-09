<div id="navigation">
    <ul id="nav" class="dropdown dropdown-horizontal">
        <li><a href="../../../">BERANDA</a></li>
        <li><a href="<?php echo site_url('durasiizin2/izin'); ?>">KETEPATAN PERBIDANG</a></li>
        <li><a href="<?php echo site_url('kinerjaizin2/izin'); ?>">PENYELESAIAN PERBIDANG</a></li>
        <li><a href="<?php echo site_url('durasisemuabidang2'); ?>">KETEPATAN SEMUA BIDANG</a></li>
        <li><a href="<?php echo site_url('kinerjasemuabidang2'); ?>">PENYELESAIAN SEMUA BIDANG</a></li>
        <li><a href="<?php echo site_url('resume2'); ?>">RESUME</a></li>
        <?php
            if($this->session->userdata('Instalator')) {
                echo $this->menu_loader->install();
            } else {
              //  echo $this->menu_loader->create_menu($this->session_info['app_list_auth']);
            }
        ?>
        <!-- <li><a href="<?php echo site_url('pengguna/password/'.$this->session_info['realname']); ?>"><?php echo "Ganti Password"; ?></a></li> -->
        <li><a href="<?php echo site_url('login/logoff'); ?>"><?php //echo "Logoff sebagai " . $this->session_info['realname']; ?></a></li>
    </ul>
</div>