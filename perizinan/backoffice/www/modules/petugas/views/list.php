<div id="content">
  <div class="post">
    <div class="title">
      <h2><?php echo $page_name; ?></h2>
    </div>
    <div class="entry">
      <?php
      $nama = $this->session_info['realname'];
      $user = New user();
      $user->where('realname', $nama)->get();
      $group = $user->group;
      if($group == 1 || $set_pegawai) {
        $add_petugas = array('name' => 'button',
                             'class' => 'button-wrc',
                             'content' => 'Tambah Pegawai',
                             'onclick' => 'parent.location=\''. site_url('petugas/create') . '\'');
        if($menu != 1) echo form_button($add_petugas);
        if($ket_exist){
          echo "<div class='entry' align=center><b style='color: #FF0000;'>Nama pegawai \"".$ket_exist."\" sudah digunakan !!</b></div>";
        }
      }
      if($menu == 1){
        $user1 = New user();
        $user1->where('id', $uid)->get();
        echo '<fieldset>';
        echo  '<legend>Data Pengguna</legend>';
        echo  '<table>';
        echo   '<tr>';
        echo    '<td>' . form_label('Nama Asli', 'nama') . '</td>';
        echo    '<td>' . $user1->oriname . '</td>';
        echo   '</tr>';
        echo   '<tr>';
        echo    '<td>' . form_label('Nama Publik', 'namap') . '</td>';
        echo    '<td>' . $user1->realname . '</td>';
        echo   '</tr>';
        echo   '<tr>';
        echo    '<td>' . form_label('User', 'user') . '</td>';
        echo    '<td>' . $user1->username . '</td>';
        echo   '</tr>';
        echo   '<tr>';
        echo    '<td>' . form_label('', 'syn') . '</td>';
        echo    '<td>' . 'Akan di Sinkronisasikan dengan Nama Pegawai Berikut ini :' . '</td>';
        echo   '</tr>';
        echo  '</table>';
        echo '</fieldset>';
      }
      ?>
      
      <table cellpadding="0" cellspacing="0" border="0" class="display" id="petugas">
        <thead>
          <tr>
            <th width="2%">NO</th>
            <th width="17%">NIK<br>NIP<br>NAMA</th>
            <th width="30%">JABATAN<br>UNIT KERJA</th>
            <th width="12">ESELON<br>PANGKAT / GOLONGAN</th>
            <th width="5%">TTD SK<br>DPMPTSP</th>
            <th width="5%">TTD<br>NOTA<br>DPMPTSP</th>
            <th width="5%">TTD<br>PENOLAKAN<br>DPMPTSP</></th>
            <th width="5%">TTD<br>SARTEK<br>OPD TEKNIS</></th>
            <th width="14%">USERNAME<br>E-MAIL</th>
            <th width="5%">AKSI</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $no = 1;
          foreach($list as $data){
            $data->user->get();
            $data->trunitkerja->get();
            $showed = FALSE;
            $id_user = $data->user->id;
            if($data->user->username === NULL && $menu == 1) $showed = TRUE;
            if($menu == '') $showed = TRUE;
            if($showed){
              switch($data->eselon) {
                case ''  : $eselon = '';           break;
                case '1' : $eselon = 'Eselon I';   break;
                case '2' : $eselon = 'Eselon II';  break;
                case '5' : $eselon = 'sekdis';  break;
                case '3' : $eselon = 'Eselon III'; break;
                case '4' : $eselon = 'Eselon IV';  break;
                case '9' : $eselon = 'Pelaksana';  break;
              }
              $nm_file = str_replace(' ', '', $data->nip).'.png';
              if(file_exists('uploads/logo/'.$nm_file)){
                $b = '';
                $be = '';
              }else{
                $b = '<span style="color: Red">';
                $be = '<br>File ttd NULL</span>';
              }
              ?>
              <tr>
                <td valign='top'><?php echo $no++; ?></td>
                <td valign='top'><?php echo $data->nik.'<br>'.$data->nip.'<br>'.$data->n_pegawai; ?></td>
                <td valign='top'><?php echo $data->n_jabatan.'<br>'.$data->trunitkerja->n_unitkerja; ?></td>
                <td valign='top'><?php echo $eselon.'<br>'.$data->pangkat_gol.' / '.$data->golongan; ?></td>
                <td valign='top' align='center'>
                  <?php if($data->status == '1') echo $b.'Ya'.$be; else echo 'Tidak';?>
                </td>
                <td valign='top' align='center'>
                  <?php if($data->status == '2') echo $b.'Ya'.$be; else echo 'Tidak';?>
                </td>
                <td valign='top' align='center'>
                  <?php if($data->ttd_penolakan == '0') echo 'Tidak'; else echo $b.'Ya'.$be;?>
                </td>
                <td valign='top' align='center'>
                  <?php if($data->ttd_sartek == '0') echo 'Tidak'; else echo $b.'Ya'.$be;?>
                </td>
                <td valign='top'><?php echo $data->user->username.'<br>'.$data->e_mail; ?></td>
                <td valign='top'>
                  <?php
                  $img_edit = array('src' => 'assets/images/icon/property.png',
                                    'alt' => 'Edit',
                                    'title' => 'Edit',
                                    'border' => '0');
                  $confirm_text = 'Apakah Anda yakin akan menghapus '.$data->n_pegawai.'?';
                  $img_delete = array('src' => 'assets/images/icon/cross.png',
                                      'alt' => 'Delete',
                                      'title' => 'Delete',
                                      'border' => '0',
                                      'onClick' => 'return confirm_link(\''.$confirm_text.'\')');
                  $img_users = array('src' => 'assets/images/icon/users.png',
                                     'alt' => 'Jadikan Pengguna',
                                     'title' => 'Jadikan Pengguna',
                                     'border' => '0',
                                     'onClick' => 'return confirm_link(\'Setelah membuatkan pengguna\nLangkah selanjutnya adalah mengkonfigurasi Pengguna.\')');
                  $img_pengguna = array('src' => 'assets/images/aksespengguna2.png',
                                        'alt' => 'Ke Setting Pengguna',
                                        'title' => 'Ke Setting  Pengguna',
                                        'border' => '0',
                                        'width' => '16',
                                        'height' => '16');
                  $img_syn = array('src' => 'assets/images/icon/tick.png',
                                   'alt' => 'Sinkronkan',
                                   'title' => 'Sinkronkan',
                                   'border' => '0');
                  
                  if($group == "1") {
                    if($menu == 1){
                      echo anchor(site_url('pengguna/sinkron') .'/' . $uid . '/'. $data->id, img($img_syn)).' - '.$data->id."&nbsp;";
                    }else{
                      echo anchor(site_url('petugas/edit') .'/'. $data->id, img($img_edit))."&nbsp;";
                      if(strval($data->level_pegawai) !== "0"){
                        echo anchor(site_url('petugas/delete') .'/'. $data->id, img($img_delete))."&nbsp;";
                      }
                      
                      if($data->user->username === NULL) {
                        echo anchor(site_url('petugas/insertAsUser') .'/'. $data->id, img($img_users))."&nbsp;";  
                      }else{
                        echo anchor(site_url('pengguna/edit') .'/'. $id_user, img($img_pengguna))."&nbsp;";
                      }
                    }
                  }else{
                    if($set_pegawai) echo anchor(site_url('petugas/edit') .'/'. $data->id, img($img_edit))."&nbsp;";
                  }
                  echo '<br>id.'.$data->id;
                  ?>
                </td>
              </tr>
              <?php
            }
          }
          ?>
        </tbody>
        <tfoot>
          <tr>
            <th>NO</th>
            <th>NIP<br>NAMA</th>
            <th>JABATAN<br>UNIT KERJA</th>
            <th>PANGKAT<br>GOLONGAN</th>
            <th>TTD SK</th>
            <th>TTD<br>NOTA</th>
            <th>TTD<br>PENOLAKAN</th>
            <th>TTD<br>SARTEK<br>OPD TEKNIS</></th>
            <th>USERNAME<br>E-MAIL</th>
            <th>AKSI</th>
          </tr>
        </tfoot>
      </table>
    </div>
  </div>
  <br style="clear: both;" />
</div>