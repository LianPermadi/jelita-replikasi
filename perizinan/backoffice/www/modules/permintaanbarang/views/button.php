 
            <?php
            $ctk_list = array(
                'name' => 'button',
                'content' => 'List Persediaan',
                'value' => '',
                'class' => 'button-wrc',
                'onclick' => 'parent.location=\'' . site_url('permintaanbarang/barang') . '\''
            );
            echo form_button($ctk_list);
            ?>
            <?php
            $ctk_list = array(
                'name' => 'button',
                'content' => 'List Permintaan barang',
                'value' => 'List Permintaan barang',
                'style' => 'background:#B0C4DE; color:black;',
                'class' => 'button-wrc',
                'onclick' => 'parent.location=\'' . site_url('permintaanbarang/pengajuan') . '\''
            );
            echo form_button($ctk_list);
            ?>
            <?php
            $ctk_list = array(
                'name' => 'button',
                'content' => 'Tambah Barang Baru',
                'value' => 'Tambah Barang Baru',
                'class' => 'button-wrc',
                'onclick' => 'parent.location=\'' . site_url('permintaanbarang/addbarang') . '\''
            );
            echo form_button($ctk_list);
            ?>
            <?php
            $ctk_list = array(
                'name' => 'button',
                'content' => 'checkout Barang',
                'value' => 'checkout Barang',
                'class' => 'button-wrc',
                'onclick' => 'parent.location=\'' . site_url('permintaanbarang/checkout') . '\''
            );
            echo form_button($ctk_list);
            ?>  
      <?php
      $ctk_list = array('name' => 'button',
                        'content' => 'Barang Masuk',
                        'value' => 'Barang Masuk',
                        'class' => 'button-wrc',
                        'onclick' => 'parent.location=\''.site_url('permintaanbarang/activity').'\''
                       );
      echo form_button($ctk_list);  
      ?>  
            <?php
            $ctk_list = array(
                'name' => 'button',
                'content' => 'Barang Keluar',
                'value' => 'Barang Keluar',
                'class' => 'button-wrc',
                'onclick' => 'parent.location=\'' . site_url('permintaanbarang/') . '\''
            );
            echo form_button($ctk_list);
?>