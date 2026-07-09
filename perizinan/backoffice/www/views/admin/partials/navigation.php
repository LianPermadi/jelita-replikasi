<div id="navigation">
  <ul id="nav" class="dropdown dropdown-horizontal">
    <li><a href="<?php echo site_url(); ?>">HOME</a></li>
    <?php
    $username = new user();
    $username->where('username', $this->session->userdata('username'))->get();
    if($username->lokasi == 'OPD Teknis') $opd=TRUE; else $opd=FALSE;
    if($this->session->userdata('Instalator')) {
      echo $this->menu_loader->install();
    }else{
      if($this->session->userdata('status_login')){
        echo $this->menu_loader->create_menu($this->session_info['app_list_auth'],$opd, $this->session_info['realname'],$this->session->userdata('lokasi'),$this->session->userdata('level'),$this->session->userdata('status_login'));
      }else{
        echo $this->menu_loader->create_menu($this->session_info['app_list_auth'],$opd, $this->session_info['realname'],$this->session->userdata('lokasi'),$this->session->userdata('level'));
      }
    }
    ?>
    <!-- <li><a href="<?php echo site_url('pengguna/password/'.$this->session_info['realname']); ?>"><?php echo "Ganti Password"; ?></a></li> -->
    <!-- <li><a href="<?php echo site_url('login/logoff'); ?>"><?php echo "Logoff sebagai " . $this->session_info['realname']; ?></a></li> -->
    <?php
    if($this->session->userdata('level') != NULL){
      ?>
      <li><a href="<?php echo site_url('login/logoff_gpt'); ?>">
        <?php echo "Logoff sebagai " . $this->session_info['realname'] . ' (' . $this->session->userdata('lokasi') . ')'; ?>
      </a></li>
      <?php
    }else{
      ?>
      <li><a href="<?php echo site_url('login/logoff'); ?>">
        <?php echo "Logoff sebagai " . $this->session_info['realname'] . ' (' . $this->session->userdata('lokasi') . ')'; ?>
      </a></li>
      <?php
    }
    ?>
  </ul>
</div>