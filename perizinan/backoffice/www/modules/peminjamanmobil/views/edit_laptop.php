<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Istana Djaya Plaza</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i">
    <link rel="stylesheet" href="assets/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/fonts/fontawesome5-overrides.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
</head>
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
      <div style="color: green; font-size: 12px; margin-left: 20px; margin-bottom: 10px; font-weight: bold;">
        <center><?php echo $alert; ?></center>
      </div>
      <?php
    }
    $alert = $this->session->flashdata("gagal");
    if(!empty($alert)){
      ?>
      <br>
      <div style="color: red; font-size: 12px; margin-left: 20px; margin-bottom: 10px; font-weight: bold;">
        <center><?php echo $alert; ?></center>
      </div>
      <?php
    }
    ?>
    
    <form action="/jelita/backoffice/peminjamanmobil/editlaptop/<?php echo $id; ?>" method="post" enctype="multipart/form-data">
      <div class="entry">
        <div id="tabs">
          <ul>
            <li><a href="#tabs-1">Data Laptop</a></li>
          </ul>
          <div id="tabs-1">
            <table cellpadding="0" cellspacing="0" border="0" class="display">
              <tbody>
                <?php
                echo form_hidden('ketegori_jenis', 'laptop');
                foreach($mobil as $row){
                  ?>
                  <tr>
                    <td align="left" width="15%" class="bg-grid">
                      <b>Merek Laptop</b>
                    </td>
                    <td class="bg-grid">
                      <input type="text" name="nama_mobil" style="width:10%" class="input-wrc" value="<?php echo $row->nama_mobil; ?>" required>
                    </td>
                  </tr>
                  <tr>
                    <td align="left" width="15%">
                      <b>Nomor Seri</b>
                    </td>
                    <td>
                      <input type="text" name="plat" style="width:10%" class="input-wrc" value="<?php echo $row->plat; ?>"  required>
                    </td>
                  </tr>
                  <tr>
                    <td align="left" width="15%" class="bg-grid">
                      <b>Spesifikasi</b>
                    </td>
                    <td class="bg-grid">
                      <input type="text" name="kapasitas" style="width:50%" class="input-wrc" value="<?php echo $row->kapasitas; ?>" required>
                      <input type="hidden" name="status"  value="<?php echo $row->status; ?>" >
                    </td>
                  </tr>
                  <tr>
                    <td align="left" width="15%">
                      <b>Tahun Pembelian</b>
                    </td>
                    <td>
                      <input type="number" name="tahun" style="width:10%; background-color: white;  border: 1px solid blue;" class="input-wrc" value="<?php echo $row->tahun; ?>"  required>
                    </td>
                  </tr>
                  <tr>
                    <td align="left" width="15%" class="bg-grid">
                      <b>Kondisi</b>
                    </td>
                    <td class="bg-grid">
                      <select class="pilihan" name="kondisi" style="width:20%" class="input-wrc" required onchange="showInput(this)">
                        <option value="-" >-</option>
                        <option value="0" <?php if($row->kondisi == "0"){ echo 'selected'; } ?>><span style="color:red;">Dalam Kondisi Tidak Baik (OFF)</span></option>
                        <option value="1" <?php if($row->kondisi == "1"){ echo 'selected'; } ?>><span style="color:green;">Dalam Kondisi Baik (ON)</span></option>
                      </select>
                    </td>
                  </tr>
                  <tr>
                    <td align="left" width="15%">
                      <b>Harga Satuan</b>
                    </td>
                    <td>
                      <input type="number" name="harga" style="width:10%; background-color: white;  border: 1px solid blue;" class="input-wrc" value="<?php echo $row->harga; ?>"  required>
                    </td>
                  </tr>
                  <tr>
                    <td align="left" width="15%" class="bg-grid">
                      <b>Jumlah</b>
                    </td>
                    <td class="bg-grid">
                      <input type="number" name="jumlah" style="width:10%; background-color: white;  border: 1px solid blue;" class="input-wrc" value="<?php echo $row->jumlah; ?>"  required>
                    </td>
                  </tr>
                  <tr>
                    <td align="left" width="15%" >
                        <b>Foto</b>
                    </td>
                    <td style="padding:10px;">
                      <input type="hidden" name="oldfoto" value="<?php echo $row->foto; ?>">
                      <?php
                      if ($row->foto) {
                      	?>
                        <img src="https://dpmptsp.jabarprov.go.id/jelita/backoffice/www/modules/peminjamanmobil/assets/img/<?php echo $row->foto; ?>"
                        class="img-preview img-fluid mb-3 col-sm-5" style="max-height: 250px; max-width: 250px;">
                        <?php
                      }else{
                      	?>
                        <img class="img-preview img-fluid mb-3 col-sm-5" style="max-height: 250px; max-width: 250px;">
                        <?php
                      }
                      ?>
                      <br>
                      <input type="file" class="submit-wrc" id="foto" onchange="previewImage()" name="gambar" style="width:20%;" accept=".jpg,.jpeg,.png,.JPG,.JPEG,.PNG" value="">
                      <!-- <input type="text"  value="<?php echo $row->foto; ?>"> -->
                    </td>
                  </tr>
                  <tr>
                    <td align="left" width="15%" class="bg-grid">
                      <b>Keterangan</b>
                    </td>
                    <td class="bg-grid">
                      <input type="text" name="kategori" style="width:50%" class="input-wrc"  value="<?php echo $row->bahan_bakar; ?>" required>
                    </td>
                  </tr>
                  <tr <?php if($row->kondisi == '2'){ ?>id="inputBaru" style="display:none;"<?php } ?>>
                    <td align="left" width="15%" class="bg-grid">
                      <b>Peminjam</b>
                    </td>
                    <td class="bg-grid">
                      <select class="pilihan" name="peminjam_laptop" style="width:100%" class="input-wrc" required onchange="showInput(this)" <?php if($row->kondisi != '2'){ ?>id="inputBaru"<?php } ?>>
                        <option value="-" >-</option>
                        <?php foreach($koor_tot as $roow){ ?>
                        <option value="<?php echo $roow->id; ?>" <?php if($row->peminjam_laptop == $roow->id){ echo 'selected'; } ?>><span style="color:red;"><?php echo $roow->n_pegawai.' || '.$roow->n_jabatan; ?></span></option>
                        <?php } ?>
                      </select>
                    </td>
                  </tr>
                  <tr <?php if($row->kondisi == '2'){ ?>id="inputBaru" style="display:none;"<?php } ?>>
                    <td align="left" width="15%" class="bg-grid">
                      <b>Tanggal Pinjam</b>
                    </td>
                    <td class="bg-grid">
                      <input type="date" class="input-wrc" name="tanggal_pinjam" value="<?php echo $row->tanggal_pinjam; ?>">
                    </td>
                  </tr>
                  <tr <?php if($row->kondisi == '2'){ ?>id="inputBaru" style="display:none;"<?php } ?>>
                    <td align="left" width="15%" class="bg-grid">
                      <b>Tanggal Kembali</b>
                    </td>
                    <td class="bg-grid">
                      <input type="date" class="input-wrc" name="tanggal_kembali" value="<?php echo $row->tanggal_kembali; ?>" readonly>
                    </td>
                  </tr>
                  <tr <?php if($row->kondisi != '2'){ ?>id="inputBaru" style="display:none;"<?php } ?>>
                    <td align="left">
                      <b>Tim Pengelola</b>
                    </td>
                    <td>
                      <select class="pilihan" name="tim" style="width:100%" class="input-wrc" required onchange="showInput(this)" <?php if($row->kondisi != '2'){ ?>id="inputBaru"<?php } ?>>
                        <option value="-" >-</option>
                        <?php foreach($koor_tot as $roow){ ?>
                        <option value="<?php echo $roow->id; ?>" <?php if($row->tot == $roow->id){ echo 'selected'; } ?>><span style="color:red;"><?php echo $this->m_mobil->get_nama_user($roow->id_pegawai).' || '.$roow->nama_tim; ?></span></option>
                        <?php } ?>
                      </select>
                      <!-- <input type="text" name="tim" value="<?php echo $row->tot ?>" <?php if($row->kondisi != '2'){ ?>id="inputBaru"<?php } ?>> -->
                    </td>
                  </tr>
                   <?php 
                    if($this->All){
                      ?> 
                      
                      <tr>
                        <td align="left" width="15%">
                          <b>Status Aktif & non aktif</b>
                        </td>
                        <td>
                          <select class="pilihan" name="on_off" style="width:100%" class="input-wrc" required>
                            <option value="-" >-</option>
                            <option value="1" <?php if($row->on_off == "1"){ echo 'selected'; } ?>><span style="color:red;">Laptop Masih Layak Di Gunakan</span></option>
                            <option value="0" <?php if($row->on_off == "0"){ echo 'selected'; } ?>><span style="color:green;">Laptop Masih Layak Tidak Bisa Gunakan</span></option>
                          </select>
                        </td>
                      </tr>
                    
                      <?php 
                    }
                } 
                ?>
              </tbody>
            </table>
          </div>
        </div>
        <label>&nbsp;</label>
        <div class="spacer"></div>
      </div>
      <div class="entry" style="text-align: center;">
        <input type="submit" name="submit" value="Ubah" class="submit-wrc" content="Ubah">
        <span></span>
        <button name="button" type="button" class="button-wrc" onclick="parent.location='<?php echo site_url('peminjamanmobil/laptop'); ?>'">Batal</button>
      </div>
    </form>
  </div>
  <br style="clear: both;" />
</div>

<script>
  function showInput(select) {
    var selectedValue = select.value;
    var inputBaru = document.getElementById("inputBaru");
    
    if(selectedValue === "2"){
        inputBaru.style.display = "table-row";
    }else{
        inputBaru.style.display = "none";
    }
  }
</script>

<script type="text/javascript">
  function previewImage(){
    const image = document.querySelector('#foto');
    const imgPreview = document.querySelector('.img-preview')
          imgPreview.style.display = 'block';
    const oFReader = new FileReader();
          oFReader.readAsDataURL(image.files[0]);
          oFReader.onload = function(oFREvent) {
            imgPreview.src = oFREvent.target.result;
          }
  }
</script>