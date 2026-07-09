<div id="content">
  <div class="post">
    <div class="title">
      <h2><?php echo $page_name; ?></h2>
    </div>

    
    <?php 
        $alert = $this->session->flashdata("sukses");
        if(!empty($alert)){
      ?>
        <br>
        <div style="color: green; font-size: 12px; margin-left: 20px; margin-bottom: 10px; font-weight: bold;"><center><?php echo $alert; ?></center></div>
      <?php } ?>

      <?php 
        $alert = $this->session->flashdata("gagal");
        if(!empty($alert)){
      ?>
        <br>
        <div style="color: red; font-size: 12px; margin-left: 20px; margin-bottom: 10px; font-weight: bold;"><center><?php echo $alert; ?></center></div>
      <?php } ?>
    
    <div class="entry">
        <div id="tabs">
            <div id="tabs-1">
      <table cellpadding="0" cellspacing="0" border="0" class="display">
        <tbody>
          <tr>
            <td align="left" width="15%" >
              <b>Penerima</b>
            </td>
            <td >

    <form method="post" action="<?php echo site_url().'permintaanbarang/accept' ?>" enctype="multipart/form-data">
              <select class="pilihan" name="penerima" style="width:100%">
                <option value="-">-</option>
                <?php foreach ($user as $row) { ?>
                <option value="<?php echo $row->id; ?>">
                <?php echo $row->n_pegawai." - ".$row->n_jabatan; ?>
                </option>
                <?php } ?>
              </select>
              <input type="hidden" name="nama_barang" value="<?php foreach ($barang as $row) { echo '* '.($row->nama_barang.' Dengan Jumlah <b>'.$row->jumlah_barang.'</b><br>'); } ?>">
              <?php 
              // var_dump($pemberi);die();
              foreach ($pemberi as $row) {
                echo '<input type="hidden" name="pemberi" value="'.$row->id.'">';
              } ?>
              <input type="submit" class="button-wrc" value="Checkout">
    </form>
            </td>
          </tr>
          <tr>
            <td colspan="2">
              <table cellpadding="0" cellspacing="0" border="0" class="display" id="pendataan">
                <thead>
                  <tr>
                    <th width="5%">No</th>
                    <th width="75%">Nama Barang</th>
                    <th width="2%">Jumlah</th>
                    <th width="13%">satuan</th>
                    <th width="13%">Action</th>
                  </tr>
                </thead>
                <tbody>
                <?php 
                  $i = 1;
                  foreach ($barang as $row) { 
                    // var_dump($row->no_id);die();
            // $stat_tolak = $this->m_persuratan->get_data_tolak($row->id);
          	// if($row->hapus == 1) {
            //   $b = '<span style="color: Red">';
            //   $be = '</span>';
            // }else{
            //   $b = '';
            //   $be = '';
            // }
                  ?>
                  <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $row->nama_barang; ?></td>
                    <td><?php echo $row->jumlah_barang; ?></td>
                    <td><?php echo $row->satuan; ?></td>
                    <td>
                      <a href="hapus_checkout/<?php echo $row->no_id; ?>/<?php echo $row->jumlah_barang; ?>/<?php echo $row->id_barang; ?>"><button class="button-wrc">Hapus</button></a>  
                    </td>
                  </tr>
                    <?php $i++; } ?>
                </tbody>
              </table>
            </td>
          </tr>
          <tr>
            <td>
            </td>
          </tr>
        </tbody>
      </table>
            </div>
        </div>
    </div>
  </div>
  <br style="clear: both;" />
</div>