
      <?php


      if($langkah == 1){
     if($button == 'laptop'){
      $ctk_list = array('name' => 'button',
                                          'content' => 'Tambah Laptop',
                                          'value' => 'Tambah Laptop',
                        'class' => 'button-wrc',
                                          'onclick' => 'parent.location=\''.site_url('peminjamanmobil/tambahlaptop').'\''
                       );
      echo form_button($ctk_list); 
        }elseif($button == 'mobil'){
      $ctk_list = array('name' => 'button',
                                          'content' => 'Tambah Mobil',
                                          'value' => 'Tambah Mobil',
                        'class' => 'button-wrc',
                                          'onclick' => 'parent.location=\''.site_url('peminjamanmobil/tambahmobil').'\''
                       );
      echo form_button($ctk_list); 
        }
      
     if($button == 'laptop'){
          if ($page == 1) {
                        $ctk_list = array('name' => 'button',
                                          'content' => 'List Laptop',
                                          'value' => 'List Laptop',
                                          'class' => 'button-wrc',
                                          'style' => 'background:gray;',
                        'onclick' => 'parent.location=\''.site_url('peminjamanmobil/laptop').'\''
                       );
          }else{
            $ctk_list = array('name' => 'button',
                                          'content' => 'List Laptop',
                                          'value' => 'List Laptop',
                                          'class' => 'button-wrc',
                        'onclick' => 'parent.location=\''.site_url('peminjamanmobil/laptop').'\''
                       );
          }
        }else{
          
          if ($page == 1) {
                        $ctk_list = array('name' => 'button',
                                          'content' => 'List Mobil',
                                          'value' => 'List Mobil',
                                          'class' => 'button-wrc',
                                          'style' => 'background:gray;',
                        'onclick' => 'parent.location=\''.site_url('peminjamanmobil/mobil').'\''
                       );
          }else{
            $ctk_list = array('name' => 'button',
                                          'content' => 'List Mobil',
                                          'value' => 'List Mobil',
                                          'class' => 'button-wrc',
                        'onclick' => 'parent.location=\''.site_url('peminjamanmobil/mobil').'\''
                       );
          }
        }

      echo form_button($ctk_list); 


     if($button == 'laptop'){
          if ($page == 2) {
      $ctk_list = array('name' => 'button',
                        'content' => 'List Peminjaman Laptop',
                        'value' => 'List Peminjaman Laptop',
                        'class' => 'button-wrc',
                        'style' => 'background:gray;',
                        'onclick' => 'parent.location=\''.site_url('peminjamanmobil/peminjam_laptop').'\''
                       );
          }else{
      $ctk_list = array('name' => 'button',
                        'content' => 'List Peminjaman Laptop',
                        'value' => 'List Peminjaman Laptop',
                        'class' => 'button-wrc',
                        'onclick' => 'parent.location=\''.site_url('peminjamanmobil/peminjam_laptop').'\''
                       );
          }
        }else{
          if ($page == 2) {
      $ctk_list = array('name' => 'button',
                        'content' => 'List Peminjaman Mobil',
                        'value' => 'List Peminjaman Mobil',
                        'class' => 'button-wrc',
                        'style' => 'background:gray;',
                        'onclick' => 'parent.location=\''.site_url('peminjamanmobil/peminjaman').'\''
                       );
          }else{
      $ctk_list = array('name' => 'button',
                        'content' => 'List Peminjaman Mobil',
                        'value' => 'List Peminjaman Mobil',
                        'class' => 'button-wrc',
                        'onclick' => 'parent.location=\''.site_url('peminjamanmobil/peminjaman').'\''
                       );
          }

        }
      echo form_button($ctk_list);  


     if($button == 'laptop'){
      if($page == 3){
      $ctk_list = array('name' => 'button',
                        'content' => 'Rekap Peminjaman Laptop',
                        'value' => 'Rekap Peminjaman Laptop',
                        'class' => 'button-wrc',
                        'style' => 'background:gray;',
                        'onclick' => 'parent.location=\''.site_url('peminjamanmobil/rekap_laptop').'\''
                       );
      echo form_button($ctk_list); 
      }else{
      $ctk_list = array('name' => 'button',
                        'content' => 'Rekap Peminjaman Laptop',
                        'value' => 'Rekap Peminjaman Laptop',
                        'class' => 'button-wrc',
                        'onclick' => 'parent.location=\''.site_url('peminjamanmobil/rekap_laptop').'\''
                       );
      echo form_button($ctk_list); 
      }
    }else{
      if($page == 3){
      $ctk_list = array('name' => 'button',
                        'content' => 'Rekap Peminjaman Mobil',
                        'value' => 'Rekap Peminjaman Mobil',
                        'class' => 'button-wrc',
                        'style' => 'background:gray;',
                        'onclick' => 'parent.location=\''.site_url('peminjamanmobil/rekap').'\''
                       );
      echo form_button($ctk_list); 
      }else{
      $ctk_list = array('name' => 'button',
                        'content' => 'Rekap Peminjaman Mobil',
                        'value' => 'Rekap Peminjaman Mobil',
                        'class' => 'button-wrc',
                        'onclick' => 'parent.location=\''.site_url('peminjamanmobil/rekap').'\''
                       );
      echo form_button($ctk_list); 
      }

    }


     if($button == 'laptop'){
      if($page == 4){
      $ctk_list = array('name' => 'button',
                        'content' => 'History Keseluruhan',
                        'value' => 'History Keseluruhan',
                        'class' => 'button-wrc',
                        'style' => 'background:gray;',
                        'onclick' => 'parent.location=\''.site_url('peminjamanmobil/history_laptop').'\''
                       );
      echo form_button($ctk_list); 
      }else{
      $ctk_list = array('name' => 'button',
                        'content' => 'History Keseluruhan',
                        'value' => 'History Keseluruhan',
                        'class' => 'button-wrc',
                        'onclick' => 'parent.location=\''.site_url('peminjamanmobil/history_laptop').'\''
                       );
      echo form_button($ctk_list); 
      }
    }else{
      if($page == 4){
      $ctk_list = array('name' => 'button',
                        'content' => 'History Keseluruhan',
                        'value' => 'History Keseluruhan',
                        'class' => 'button-wrc',
                        'style' => 'background:gray;',
                        'onclick' => 'parent.location=\''.site_url('peminjamanmobil/history').'\''
                       );
      echo form_button($ctk_list); 
      }else{
      $ctk_list = array('name' => 'button',
                        'content' => 'History Keseluruhan',
                        'value' => 'History Keseluruhan',
                        'class' => 'button-wrc',
                        'onclick' => 'parent.location=\''.site_url('peminjamanmobil/history').'\''
                       );
      echo form_button($ctk_list); 
      }

    }

    } else {
      if($page == '10'){

      // $ctk_list = array('name' => 'button',
      //                   'content' => 'Pesan Mobil',
      //                   'value' => 'Pesan Mobil',
      //                   'class' => 'button-wrc',
      //                   'onclick' => 'parent.location=\''.site_url('peminjamanmobil/pinjam_mobil/'.$id).'\''
      //                  );
      // echo form_button($ctk_list).'<br>'; 
      }else{

      // $ctk_list = array('name' => 'button',
      //                   'content' => 'Pesan Mobil Sekarang',
      //                   'value' => 'Pesan Mobil Sekarang',
      //                   'class' => 'button-wrc',
      //                   'onclick' => 'parent.location=\''.site_url('peminjamanmobil/booking').'\''
      //                  );
      // echo form_button($ctk_list).'<br>'; 
            }
      } 
                ?>