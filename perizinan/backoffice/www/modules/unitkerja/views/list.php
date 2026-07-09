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
      if($group == "1") {
        $add_role = array('name' => 'button',
                          'class' => 'button-wrc',
                          'content' => 'Tambah Unit Kerja',
                          'onclick' => 'parent.location=\''. site_url('unitkerja/create') . '\'');
        echo form_button($add_role);
      }
      ?>
      <table cellpadding="0" cellspacing="0" border="0" class="display" id="unitkerja">
        <thead>
          <tr>
            <th width="3%">No</th>
            <th width="80%">Deskripsi</th>
            <th width="10%">Cap Instansi</th>
            <th width="7%">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $no = 0;
          foreach ($list as $data){
          	$no++;
            ?>
            <tr>
              <td><?php echo $no; ?></td>
              <td><?php echo $data->n_unitkerja; ?></td>
              <td align='right'><?php echo $data->nm_cap; ?></td>
              <td>
                <center>
                  <?php
                  if($group == "1") {
                    $img_edit = array('src' => 'assets/images/icon/property.png',
                                      'alt' => 'Edit',
                                      'title' => 'Edit',
                                      'border' => '0');
                    $confirm_text = 'Apakah Anda yakin akan menghapus '. $data->n_unitkerja.'?';
                    $img_delete = array('src' => 'assets/images/icon/cross.png',
                                        'alt' => 'Delete',
                                        'title' => 'Delete',
                                        'border' => '0',
                                        'onClick' => 'return confirm_link(\''.$confirm_text.'\')');
                    ?>
                    <a class="page-help" href="<?php echo site_url('unitkerja/edit'."/".$data->id) ?>"
                    ><?php echo img($img_edit); ?></a>
                    <a class="page-help" href="<?php echo site_url('unitkerja/delete'."/".$data->id) ?>"
                    ><?php echo img($img_delete); ?></a>
                    <?php
                  }
                  ?>
                </center>
              </td>
            </tr>
            <?php
          }
          ?>
        </tbody>
        <tfoot>
          <tr>
            <th>No</th>
            <th>Deskripsi</th>
            <th>Cap Instansi</th>
            <th>Aksi</th>
          </tr>
        </tfoot>
      </table>
    </div>
  </div>
  <br style="clear: both;" />
</div>
