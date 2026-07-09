<style>
  <!--
    #formData {
    font-family: verdana;
    width: auto;
  }
  --> 
</style>

<div id="content">
  <div class="post">
    <div class="title">
      <h2><?php echo $page_name; ?></h2>
    </div>
    <?php
    
    echo form_open(base_url().'pemohon/pemohon_online/simpanedit');
    echo form_hidden('jenis', $jenis);
    echo form_hidden('id', $user->id);
    ?>
    <div class="entry">
          <table cellpadding="0" cellspacing="0" border="0" class="display">
            <tr>
              <td align="left" width="4%"></td>
              <td align="left" width="20%"></td>
              <td align="left" width="75%"></td>
            </tr>
            <tr><td colspan="3" align="center"><h3>Data Pemohon</h2></td></tr>
            <?php
            if ($jenis == 'Pemohon') {
              echo "<tr>";
                  echo "<td width='13%'><b>Username</b></td>";   // Nomor Property
                  echo "<td align='right' width='2%'><b> : </b></td>";   // Nama Property
                  $property_input = array(
                      'name' => 'username',
                      'style'=>'width:90%',
                      'value' => $user->username,
                      'class' => 'input-wrc'
                  );
                  echo "<td align='left'>".form_input($property_input)."</td>";
                  echo "</tr>";

                  echo "<tr>";
                  echo "<td width='13%'><b>Password</b></td>";   // Nomor Property
                  echo "<td align='right' width='2%'><b> : </b></td>";   // Nama Property
                  $property_input = array(
                      'type' => 'password',
                      'name' => 'password',
                      'style'=>'width:90%',
                      'value' => '',
                      'class' => 'input-wrc'
                  );
                  echo "<td align='left' rowspan='2'>".form_input($property_input)."<br><small>*Kosongkan jika tidak akan diubah</small></td>";
                  echo "</tr>";

                  echo "<tr>";
                  echo "<td width='13%'>&nbsp;</td>";   // Nomor Property
                  echo "<td align='right' width='2%'>&nbsp;</td>";
                  echo "</tr>";

                  echo "<tr>";
                  echo "<td width='13%'><b>Nama Pemohon</b></td>";   // Nomor Property
                  echo "<td align='right' width='2%'><b> : </b></td>";   // Nama Property
                  $property_input = array(
                      'name' => 'nama_pemohon',
                      'style'=>'width:90%',
                      'value' => $user->namaPerusahaan,
                      'class' => 'input-wrc'
                  );
                  echo "<td align='left'>".form_input($property_input)."</td>";
                  echo "</tr>";

                  echo "<tr>";
                  echo "<td width='13%'><b>Nama Pemegang Kuasa</b></td>";   // Nomor Property
                  echo "<td align='right' width='2%'><b> : </b></td>";   // Nama Property
                  $property_input = array(
                      'name' => 'nama_pemegang_kuasa',
                      'style'=>'width:90%',
                      'value' => $user->namaPemohon,
                      'class' => 'input-wrc'
                  );
                  echo "<td align='left'>".form_input($property_input)."</td>";
                  echo "</tr>";

                  echo "<tr>";
                  echo "<td width='13%'><b>No KTP Pemohon</b></td>";   // Nomor Property
                  echo "<td align='right' width='2%'><b> : </b></td>";   // Nama Property
                  $property_input = array(
                      'name' => 'no_ktp_pemohon',
                      'style'=>'width:90%',
                      'value' => $user->ktpPerusahaan,
                      'class' => 'input-wrc'
                  );
                  echo "<td align='left'>".form_input($property_input)."</td>";
                  echo "</tr>";

                  echo "<tr>";
                  echo "<td width='13%'><b>No NPWP Pemohon</b></td>";   // Nomor Property
                  echo "<td align='right' width='2%'><b> : </b></td>";   // Nama Property
                  $property_input = array(
                      'name' => 'no_npwp_pemohon',
                      'style'=>'width:90%',
                      'value' => $user->npwpPerusahaan,
                      'class' => 'input-wrc'
                  );
                  echo "<td align='left'>".form_input($property_input)."</td>";
                  echo "</tr>";
                  
                  echo "<tr><td colspan='3' align='center'><h3>Kontak Pemohon</h2></td></tr>";

                  echo "<tr>";
                  echo "<td width='13%'><b>E-mail Pemohon</b></td>";   // Nomor Property
                  echo "<td align='right' width='2%'><b> : </b></td>";   // Nama Property
                  $property_input = array(
                      'name' => 'email_pemohon',
                      'style'=>'width:90%',
                      'value' => $user->emailPerusahaan,
                      'class' => 'input-wrc'
                  );
                  echo "<td align='left'>".form_input($property_input)."</td>";
                  echo "</tr>";
                  
                  echo "<tr>";
                  echo "<td width='13%'><b>HP Pemohon</b></td>";   // Nomor Property
                  echo "<td align='right' width='2%'><b> : </b></td>";   // Nama Property
                  $property_input = array(
                      'name' => 'hp_pemohon',
                      'style'=>'width:90%',
                      'value' => $user->telpPerusahaan,
                      'class' => 'input-wrc'
                  );
                  echo "<td align='left'>".form_input($property_input)."</td>";
                  echo "</tr>";
                  
                  echo "<tr>";
                  echo "<td width='13%'><b>HP Pemegang Kuasa</b></td>";   // Nomor Property
                  echo "<td align='right' width='2%'><b> : </b></td>";   // Nama Property
                  $property_input = array(
                      'name' => 'hp_pemegang_kuasa',
                      'style'=>'width:90%',
                      'value' => $user->telpPemohon,
                      'class' => 'input-wrc'
                  );
                  echo "<td align='left'>".form_input($property_input)."</td>";
                  echo "</tr>";
                  
            } else {

              echo "<tr>";
                  echo "<td width='13%'><b>Username</b></td>";   // Nomor Property
                  echo "<td align='right' width='2%'><b> : </b></td>";   // Nama Property
                  $property_input = array(
                      'name' => 'username',
                      'style'=>'width:90%',
                      'value' => $user->username,
                      'class' => 'input-wrc'
                  );
                  echo "<td align='left'>".form_input($property_input)."</td>";
                  echo "</tr>";

                  echo "<tr>";
                  echo "<td width='13%'><b>Password</b></td>";   // Nomor Property
                  echo "<td align='right' width='2%'><b> : </b></td>";   // Nama Property
                  $property_input = array(
                      'type' => 'password',
                      'name' => 'password',
                      'style'=>'width:90%',
                      'value' => '',
                      'class' => 'input-wrc'
                  );
                  echo "<td align='left' rowspan='2'>".form_input($property_input)."<br><small>*Kosongkan jika tidak akan diubah</small></td>";
                  echo "</tr>";

                  echo "<tr>";
                  echo "<td width='13%'>&nbsp;</td>";   // Nomor Property
                  echo "<td align='right' width='2%'>&nbsp;</td>";
                  echo "</tr>";

                  echo "<tr>";
                  echo "<td width='13%'><b>Nama Perusahaan</b></td>";   // Nomor Property
                  echo "<td align='right' width='2%'><b> : </b></td>";   // Nama Property
                  $property_input = array(
                      'name' => 'nama_perusahaan',
                      'style'=>'width:90%',
                      'value' => $user->namaPerusahaan,
                      'class' => 'input-wrc'
                  );
                  echo "<td align='left'>".form_input($property_input)."</td>";
                  echo "</tr>";

                  echo "<tr>";
                  echo "<td width='13%'><b>Nama Direktur</b></td>";   // Nomor Property
                  echo "<td align='right' width='2%'><b> : </b></td>";   // Nama Property
                  $property_input = array(
                      'name' => 'nama_direktur',
                      'style'=>'width:90%',
                      'value' => $user->nama_penanggung_jawab,
                      'class' => 'input-wrc'
                  );
                  echo "<td align='left'>".form_input($property_input)."</td>";
                  echo "</tr>";

                  echo "<tr>";
                  echo "<td width='13%'><b>Nama Pemegang Kuasa</b></td>";   // Nomor Property
                  echo "<td align='right' width='2%'><b> : </b></td>";   // Nama Property
                  $property_input = array(
                      'name' => 'nama_pemegang_kuasa',
                      'style'=>'width:90%',
                      'value' => $user->namaPemohon,
                      'class' => 'input-wrc'
                  );
                  echo "<td align='left'>".form_input($property_input)."</td>";
                  echo "</tr>";

                  echo "<tr>";
                  echo "<td width='13%'><b>No KTP Direktur</b></td>";   // Nomor Property
                  echo "<td align='right' width='2%'><b> : </b></td>";   // Nama Property
                  $property_input = array(
                      'name' => 'no_ktp_direktur',
                      'style'=>'width:90%',
                      'value' => $user->ktpPemohon,
                      'class' => 'input-wrc'
                  );
                  echo "<td align='left'>".form_input($property_input)."</td>";
                  echo "</tr>";

                  echo "<tr>";
                  echo "<td width='13%'><b>No NPWP Perusahaan</b></td>";   // Nomor Property
                  echo "<td align='right' width='2%'><b> : </b></td>";   // Nama Property
                  $property_input = array(
                      'name' => 'no_npwp_perusahaan',
                      'style'=>'width:90%',
                      'value' => $user->npwpPerusahaan,
                      'class' => 'input-wrc'
                  );
                  echo "<td align='left'>".form_input($property_input)."</td>";
                  echo "</tr>";

                  echo "<tr>";
                  echo "<td width='13%'><b>No Akta Perusahaan</b></td>";   // Nomor Property
                  echo "<td align='right' width='2%'><b> : </b></td>";   // Nama Property
                  $property_input = array(
                      'name' => 'no_akta_perusahaan',
                      'style'=>'width:90%',
                      'value' => $user->aktaPerusahaan,
                      'class' => 'input-wrc'
                  );
                  echo "<td align='left'>".form_input($property_input)."</td>";
                  echo "</tr>";
                  
                  echo "<tr><td colspan='3' align='center'><h3>Kontak Perusahaan</h2></td></tr>";

                  echo "<tr>";
                  echo "<td width='13%'><b>E-mail Perusahaan</b></td>";   // Nomor Property
                  echo "<td align='right' width='2%'><b> : </b></td>";   // Nama Property
                  $property_input = array(
                      'name' => 'email_perusahaan',
                      'style'=>'width:90%',
                      'value' => $user->emailPerusahaan,
                      'class' => 'input-wrc'
                  );
                  echo "<td align='left'>".form_input($property_input)."</td>";
                  echo "</tr>";

                  echo "<tr>";
                  echo "<td width='13%'><b>E-mail Direktur</b></td>";   // Nomor Property
                  echo "<td align='right' width='2%'><b> : </b></td>";   // Nama Property
                  $property_input = array(
                      'name' => 'email_direktur',
                      'style'=>'width:90%',
                      'value' => $user->emailPemohon,
                      'class' => 'input-wrc'
                  );
                  echo "<td align='left'>".form_input($property_input)."</td>";
                  echo "</tr>";
                  
                  echo "<tr>";
                  echo "<td width='13%'><b>Telp Perusahaan</b></td>";   // Nomor Property
                  echo "<td align='right' width='2%'><b> : </b></td>";   // Nama Property
                  $property_input = array(
                      'name' => 'telp_perusahaan',
                      'style'=>'width:90%',
                      'value' => $user->telpPerusahaan,
                      'class' => 'input-wrc'
                  );
                  echo "<td align='left'>".form_input($property_input)."</td>";
                  echo "</tr>";
                  
                  echo "<tr>";
                  echo "<td width='13%'><b>HP Pemegang Kuasa</b></td>";   // Nomor Property
                  echo "<td align='right' width='2%'><b> : </b></td>";   // Nama Property
                  $property_input = array(
                      'name' => 'hp_pemegang_kuasa',
                      'style'=>'width:90%',
                      'value' => $user->telp_penanggung_jawab,
                      'class' => 'input-wrc'
                  );
                  echo "<td align='left'>".form_input($property_input)."</td>";
                  echo "</tr>";

                  echo "<tr>";
                  echo "<td width='13%'><b>HP Direktur</b></td>";   // Nomor Property
                  echo "<td align='right' width='2%'><b> : </b></td>";   // Nama Property
                  $property_input = array(
                      'name' => 'hp_direktur',
                      'style'=>'width:90%',
                      'value' => $user->telpPemohon,
                      'class' => 'input-wrc'
                  );
                  echo "<td align='left'>".form_input($property_input)."</td>";
                  echo "</tr>";
                  
                  echo "<tr>";
                  echo "<td width='13%'><b>Fax Perusahaan</b></td>";   // Nomor Property
                  echo "<td align='right' width='2%'><b> : </b></td>";   // Nama Property
                  $property_input = array(
                      'name' => 'fax_perusahaan',
                      'style'=>'width:90%',
                      'value' => $user->faxPerusahaan,
                      'class' => 'input-wrc'
                  );
                  echo "<td align='left'>".form_input($property_input)."</td>";
                  echo "</tr>";
            }
                  
            ?>
          </table>

    <div class="entry" style="text-align: center;">
      <?php
      $add_daftar = array('name' => 'submit',
                         'class' => 'submit-wrc',
                         'content' => 'Simpan',
                         'type' => 'submit',
                         'value' => 'Simpan'
                         );
      $batal = 'Kembali';
      echo form_submit($add_daftar);
      echo "<span></span>";
      $cancel_daftar = array('name' => 'button',
                             'class' => 'button-wrc',
                             'content' => 'Batal',
                             'onclick' => 'parent.location=\''. site_url('pemohon/pemohon_online') . '\''
                             );
      echo form_button($cancel_daftar);
      echo form_close();
      ?>
    </div>
  </div>
  <br style="clear: both;" />
</div>