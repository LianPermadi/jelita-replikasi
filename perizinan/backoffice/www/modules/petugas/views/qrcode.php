<div id="content">
  <div class="post">
    <div class="title">
      <h2><?php echo $page_name; ?></h2>
    </div>
    <h1>QR Code</h1>
    <img src="<?php echo $qr_code11; ?>" alt="QR Code" width="300px">
    <table>
        <tr>
            <td>
                Nama
            </td>
            <td>
                :
            </td>
            <td>
                <?php echo $n_pegawai; ?>
            </td>
        </tr>
        <tr>
            <td>
                NIK
            </td>
            <td>
                :
            </td>
            <td>
                <?php echo $nik; ?>
            </td>
        </tr>
        <tr>
            <td>
                NIP
            </td>
            <td>
                :
            </td>
            <td>
                <?php echo $nip; ?>
            </td>
        </tr>
        <tr>
            <td>
                pangkat golongan
            </td>
            <td>
                :
            </td>
            <td>
                <?php echo $pangkat_gol; ?>
            </td>
        </tr>
        <tr>
            <td>
                golongan
            </td>
            <td>
                :
            </td>
            <td>
                <?php echo $golongan; ?>
            </td>
        </tr>
        <tr>
            <td>
                <?php
                $post_SE = str_replace(' ', '', $nip);
                $img_edit = array('src' => 'uploads/logo/'.$post_SE.'.png',
                                  'height' => '20%',
                                  'width' => '20%',
                                  'border' => '0');
                             
                ?>
                <label class="label-wrc">Bentuk File ttd</label>
              </div>
            </td>
            <td>
                :
            </td>
            <td>
                <?php echo img($img_edit);   ?>
            </td>
        </tr>
        <tr>
            <td>
                tanggal jabatan
            </td>
            <td>
                :
            </td>
            <td>
                <?php echo $tgl_jabat; ?>
            </td>
        </tr>
    </table>
</div>
</div>