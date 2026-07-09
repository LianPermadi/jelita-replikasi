<?php 
// var_dump($anggota);die();
  if (!empty($program)) {
    $id_tim = "";
    $kegiatan = "";
    $renaksi = "";
    $target_aktivitas = "";
    $r_anggaran = "";
    $satuan = "";
    $keterangan = "";
    $tgl_rencana = "";
    $tgl_realisasi = "";
    $id_tim = $program->kd_tim;
    // var_dump($id_tim);
    // $id = $program->id;
    $aktivitas = $program->sasaran_program;
    $anggaran = $program->anggaran_tot;
  }
 ?>
<style>
        #myInput {
            display: none;
        }
    </style>
<div id="content">
  <div class="post">
    <div class="title">
      <?php echo $this->lib_date->view_title($page_name); ?>
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
    <form method="post" action="<?php echo site_url().'kegiatandpa/'.$step; ?>" enctype="multipart/form-data">
    <div class="entry">
      <div id="tabs">
        <ul>
          <li><a href="#tabs-1">Input Rincian Aktivitas</a></li>
          <li><a href="#tabs-2">Rincian Aktivitas Tim Of Tim</a></li>
        </ul>
        <div id="tabs-1">
        <?php 
          if ($step == "subrenaksi_update") { ?>
            <input type="hidden" name="id" value="<?php echo $id; ?>">
          <?php } else { ?>
            <input type="hidden" name="id" value="<?php echo $id; ?>">
          <?php } ?>
          <table cellpadding="0" cellspacing="0" border="0" class="display">
            <tbody>
              <tr>
                <td align="left" width="15%">
                  <b>Tim</b>
                </td>
                <td>
                  <select class="pilihan" name="id_tim" style="width:100%" disabled>
                    <?php foreach ($tim as $row) {
                    $ambil_ketua = $this->m_renaksi->get_ketua($row->ketua); ?>
                      <option value="<?php echo $row->id; ?>" <?php echo ($id_tim == $row->id ? "selected" : ""); ?>><?php echo $row->nama_tim." (Ketua Tim : ".$this->m_renaksi->get_ketua($row->ketua)." )"; ?></option>
                    <?php } ?>
                  </select>
                </td>
              </tr>
              <tr>
                <td align="left" width="15%" class="bg-grid">
                  <b>Kegiatan</b>
                </td>
                <td class="bg-grid">
                  <textarea name="aktivitas" style="width:100%" class="input-area-wrc" required readonly><?php echo $aktivitas; ?></textarea>
                </td>
              </tr>
              <tr>
                <td align="left" width="15%">
                  <b>Aktivitas</b>
                </td>
                <td>
                  <textarea name="renaksi" style="width:100%" class="input-area-wrc" required><?php echo $renaksi; ?></textarea>
                </td>
              </tr>
              <tr>
              <tr>
                <td align="left" width="15%">
                  <b>Jumlah Rincian Aktivitas</b><br>*diisi angka
                </td>
                <td>
                  <input type="number" name="rincian_aktv" id="jumlahInput" style="width:20%" class="input-wrc" required="required" min="1" onchange="generateInputs()">
                  <button type="button" class="button-wrc">Tambah</button>
                </td>
              </tr>
                <td align="left" width="15%"  class="bg-grid">
                  <b>Pelaksana Tugas</b>
                </td>
                <td  class="bg-grid">
                  <select class="pilihan" id="u_anggota" name="u_anggota[]" multiple="multiple" style="width: 100%;">
                      <?php foreach ($anggota as $row) { ?>
                      <option value="<?php echo $row->id_pegawai; ?>" <?php echo ($id_tim == $row->kd_tim); ?>><?php echo $this->m_renaksi->get_anggota_tim($row->id_pegawai); ?></option>
                    <?php } ?>
                  </select>
                  <span id="erorPeriksa" style=" clear: both; visibility: hidden;"></span>
                </td>
                <!-- <td class="bg-grid">        
                                <select id="anggota" name="anggota[]" multiple="multiple" style="width: 75%;">
                                    <?php
                                        if($step === "master_simpan") { 
                                          foreach ($list as $data) {
                                                echo "<option style='width:100%' value='".$data->id."'>".$data->n_pegawai." | ".$data->nip." |".
                                                     $data->pangkat_gol." | ".$data->n_jabatan." </option>";
                                            }
                                        } else {
                                            
                                        }
                                    ?>
                                </select>
                                <span id="erorPeriksa" style=" clear: both; visibility: hidden;"></span>
                            </td> -->
              </tr>
              <tr>
                <td align="left" width="15%">
                  <b>Anggaran</b><br>*diisi angka
                </td>
                <td>
                  <input type="text" name="anggaran" style="width:20%" class="input-wrc" value="<?php echo number_format($anggaran,0,',','.');?>" required="required" readonly>
                   <b>Realisasi Anggaran : </b><input type="number" name="r_anggaran" style="width:20%" class="input-wrc" value="<?php echo $r_anggaran; ?>" >
                </td>
              </tr>
              <tr>
                <td align="left" width="15%">
                  <b>Target Aktivitas</b><br>*diisi angka
                </td>
                <td>
                  <input type="number" name="target_aktivitas" style="width:20%" class="input-wrc" value="<?php echo $target_aktivitas; ?>" required="required">
                   <b>Satuan : </b><input type="text" name="satuan" style="width:20%" class="input-wrc" value="<?php echo $satuan; ?>" required="required">
                </td>
              </tr>
              <tr>
                <td align="left" width="15%">
                  <b>Tanggal Rencana</b>
                </td>
                <td>
                  <?php 
                    $tgl_input = array('name' => 'tgl_rencana',
                            'value' => ((!empty($tgl_rencana)) ? $tgl_rencana : date('Y-m-d')),
                            'class' => 'input-wrc',
                            'readOnly'=>TRUE,
                            'style' => "width:100%",
                            'class' => 'monbulan'
                           );
                    echo form_input($tgl_input);
                  ?>
                </td>
              </tr>
              <tr>
                <td align="left" width="15%">
                  <b>Tanggal Realisasi</b>
                </td>
                <td>
                  <label>
                    <input type="checkbox" id="toggleField"> Sudah Realisasi
                </label>

                <?php
                $tgl_input = array(
                    'name' => 'tgl_realisasi',
                    'id' => 'myInput',
                    'value' => $tgl_realisasi,
                    'class' => 'input-wrc',
                    'style' => "width:80%",
                    'class' => 'monbulan',
                    'readonly' => TRUE
                );
                echo form_input($tgl_input);
                ?>
                </td>
              </tr>
  
              <tr>
                <td align="left" width="15%"  class="bg-grid">
                  <b>Keterangan</b>
                </td>
                <td  class="bg-grid"> 
                  <div id="textareaKeterangan">
                    <!-- Tempat untuk menampilkan inputan dinamis -->
                </div>
                </td>
              </tr>
            </tbody>
          </table>
          <div class="entry" style="text-align: center;">
      <?php 
        if ($step == "subrenaksi_simpan") { ?>
          <input type="submit" name="submit" value="Simpan" class="submit-wrc" content="Simpan">
        <?php } else { ?>
          <input type="submit" name="submit" value="Ubah" class="submit-wrc" content="Ubah">
        <?php } ?>
      
      <span></span>
      <button name="button" type="button" class="button-wrc" onclick="parent.location='<?php echo site_url('kegiatandpa/aktivitas'); ?>'">Batal</button>
    </div>
  </form>
        </div>
        <div id="tabs-2">
          <?php 
          $ambil_id = $this->m_renaksi->get_program_id($id);
          $ambil_tim = $this->m_renaksi->get_kdtim_prog($id);
          $ketua_tim = $this->m_renaksi->get_id_ketua($ambil_tim);
          $ketua = $this->m_renaksi->get_ketua($ketua_tim);
          $program = $this->m_renaksi->get_sasaran($ambil_id);
          ?>

          <h3>Kegiatan : <?php echo $program; ?></h3>
          <h3>Ketua Tim : <?php echo $ketua; ?></h3>
        <table cellpadding="0" cellspacing="0" border="0" class="display" id="pendataan">
        <thead>
          <tr>
            <th>No</th>
            <th>Aktivitas</th>
            <th>Pelaksana Tugas</th>
            <th>Realisasi Anggaran</th>
            <th>Target Aktivitas</th>
            <th>Tgl Rencana</th>
            <th>Tgl Realisasi</th>
            <th>Keterangan</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php 
          $i = 1; 
          foreach ($rencana_aksi as $row) {
          ?>
          <tr>
            <td><?php echo $i; ?></td>
            <td><?php echo $row->sasaran_renaksi;?></td>
              <td><?php
            $no = 1;
            $nono = 1;
            $anggota1 = explode('^', $row->pic);
            // var_dump($anggota1); die();
                foreach ($anggota1 as $data){
                  echo $no.'. '.$this->m_renaksi->get_n_pegawai($data).'<br>';
                  $no++; 
                }
              ?>
            </td>
            <td><?php echo number_format($row->r_anggaran,0,',','.');?></td>
            <td><?php echo $row->target_aktivitas.' '.$row->satuan; ?></td>
            <td><?php echo $this->lib_date->mysql_to_human($row->tgl_rencana); ?></td>
            <td><?php echo $this->lib_date->mysql_to_human($row->tgl_realisasi); ?></td>
            <td><?php echo $row->keterangan; ?></td>
            <td>
              <?php 
                echo '<a href="'.base_url().'kegiatandpa/edit_rencana_aksi/'.$row->id.'/'.base64_encode($row->pic).'"><img src="'.base_url().'assets/images/icon/property.png" alt="Edit Data" title="Edit Data" border="0"></a>&nbsp;';
              ?>
              <!-- <?php 
                echo '<a href="'.base_url().'kegiatandpa/subrenaksi/'.$row->id.'"><img src="'.base_url().'assets/images/icon/arrow_biru.png" alt="Teruskan ke Anggota" title="Teruskan ke Anggota" border="0" height="50%" width="50%"></a>&nbsp;';
              ?> -->
              <a href="#" onclick="if (confirm('Yakin Hapus Data?')) parent.location='<?php echo  site_url('kegiatandpa/hapus_renaksi/'.$row->id.'/'.$id); ?>'"><img src="<?php echo base_url().'assets/images/icon/cross.png'; ?>" alt="Hapus Data" title="Hapus Data" border="0"></a>&nbsp;
            </td>
          </tr>
          <?php $i++; } ?>
        </tbody>
      </table>
            </div>
      </div>
        <label>&nbsp;</label>
        <div class="spacer"></div>
    </div>
  </div>
  <br style="clear: both;" />
</div>

<script>
        function generateInputs() {
            // Mendapatkan nilai dari input jumlahInput
            var jumlahInput = document.getElementById('jumlahInput').value;
            jumlahInput = Math.min(jumlahInput, 12);

            // Mengosongkan container input
            // document.getElementById('inputContainer').innerHTML = '';

            // // Membuat inputan sebanyak jumlahInput
            // for (var i = 1; i <= jumlahInput; i++) {
            //     var inputElement = document.createElement('input');
            //     inputElement.type = 'text';
            //     inputElement.name = 'input_' + i;
            //     inputElement.placeholder = 'Input ' + i;

            //     // Menambahkan input ke dalam container
            //     document.getElementById('inputContainer').appendChild(inputElement);

            //     // Menambahkan newline (baris baru) setelah setiap input
            //     document.getElementById('inputContainer').appendChild(document.createElement('br'));
            // }

            // Mengosongkan container input
            document.getElementById('textareaKeterangan').innerHTML = '';
            for (var i = 1; i <= jumlahInput; i++) {
                var inputElement = document.createElement('textarea');
                inputElement.name = 'keterangan[]';
                inputElement.style = 'width:100%';
                inputElement.class = 'input-area-wrc';

                var input = document.createElement('input');
                inputElement.name = 'keterangan[]';
                inputElement.style = 'width:100%';
                inputElement.class = 'input-area-wrc';

                var inputE = document.createElement('input');
                inputElement.name = 'keterangan[]';
                inputElement.style = 'width:100%';
                inputElement.class = 'input-area-wrc';

                // Menambahkan input ke dalam container
                document.getElementById('textareaKeterangan').appendChild(inputElement);
                document.getElementById('textareaKeterangan').appendChild(input);
                document.getElementById('textareaKeterangan').appendChild(inputE);

                // Menambahkan newline (baris baru) setelah setiap input
                document.getElementById('textareaKeterangan').appendChild(document.createElement('br'));
            }
        }
    </script>
