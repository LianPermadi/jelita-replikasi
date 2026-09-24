<?php 
  if (!empty($perdin)) {
      $id       = $perdin->id;
$bulan        = $perdin->bulan ;
$id_persuratan        = $perdin->id_persuratan ;
$id_pegawai       = $perdin->id_pegawai;
// var_dump($id_pegawai);die();
$no_bku       = $perdin->no_bku;
$uraian       = $perdin->uraian;
$mksd_pemberangkatan       = $perdin->mksd_pemberangkatan;
$tgl_pembayaran       = $perdin->tgl_pembayaran;
$tujuan       = $perdin->tujuan;
$nama_pelaksana       = $perdin->nama_pelaksana;
$skpd       = $perdin->skpd;
$no__sppd       = $perdin->no__sppd;
$lama_p_d       = $perdin->lama_p_d;
$tanggal_berangkat       = $perdin->tanggal_berangkat;
$tgl_surat       = $perdin->tgl_surat;
$tanggal_kembali       = $perdin->tanggal_kembali;
$uang_hari       = $perdin->uang_hari;
$harga_hari       = $perdin->harga_hari;
$jumlah_uang       = $perdin->jumlah_uang;
$representasi_hari       = $perdin->representasi_hari;
$representasi_harga       = $perdin->representasi_harga;
$jumlah_representasi       = $perdin->jumlah_representasi;
$uang_sakuhari       = $perdin->uang_sakuhari;
$uang_sakuharga       = $perdin->uang_sakuharga;
$uang_sku_p_j       = $perdin->uang_sku_p_j;
$penginapan_malam       = $perdin->penginapan_malam;
$penginapan_harga       = $perdin->penginapan_harga;
$penginapan_jumlah       = $perdin->penginapan_jumlah;
$tikettol_pulang       = $perdin->tikettol_pulang;
$tikettol_pergi       = $perdin->tikettol_pergi;
$tikettol_jumlah       = $perdin->tikettol_jumlah;
$s_t_k_asal_hari       = $perdin->s_t_k_asal_hari;
$s_t_k_asal_harga       = $perdin->s_t_k_asal_harga;
$s_t_k_asal_jumlah       = $perdin->s_t_k_asal_jumlah;
$s_t_k_tujuan_hari       = $perdin->s_t_k_tujuan_hari;
$s_t_k_tujuan_harga       = $perdin->s_t_k_tujuan_harga;
$s_t_k_tujuan_jumlah       = $perdin->s_t_k_tujuan_jumlah;
$sewa_kendaraan_hari       = $perdin->sewa_kendaraan_hari;
$sewa_kendaraan_harga       = $perdin->sewa_kendaraan_harga;
$sewa_kendaraan_jumlah       = $perdin->sewa_kendaraan_jumlah;
$bbm_liter       = $perdin->bbm_liter;
$bbm_harga       = $perdin->bbm_harga;
$bbm_jumlah       = $perdin->bbm_jumlah;
$swabdi_kota_asal       = $perdin->swabdi_kota_asal;
$swabdi_kota_tujuan       = $perdin->swabdi_kota_tujuan;
$swab_jumlah       = $perdin->swab_jumlah;
$jumlah_total       = $perdin->jumlah_total;
$itberangkat_maskapai       = $perdin->itberangkat_maskapai;
$itberangkat_no_tiket       = $perdin->itberangkat_no_tiket;
$itberangkat_kodebooking       = $perdin->itberangkat_kodebooking;
$itberangkat_no_penerbangan       = $perdin->itberangkat_no_penerbangan;
$itberangkat_asal_daerah       = $perdin->itberangkat_asal_daerah;
$itberangkat_tujuan       = $perdin->itberangkat_tujuan;
$itberangkat_tanggal       = $perdin->itberangkat_tanggal;
$itberangkat_kelas       = $perdin->itberangkat_kelas;
$itberangkat_harga_tiket       = $perdin->itberangkat_harga_tiket;
$itkembali_maskapai       = $perdin->itkembali_maskapai;
$itkembali_nama       = $perdin->itkembali_nama;
$itkembali_no_tiket       = $perdin->itkembali_no_tiket;
$itkembali_kode_booking       = $perdin->itkembali_kode_booking;
$itkembali_no_penerbangan       = $perdin->itkembali_no_penerbangan;
$itkembali_asal_daerah       = $perdin->itkembali_asal_daerah;
$itkembali_tujuan       = $perdin->itkembali_tujuan;
$itkembali_tanggal       = $perdin->itkembali_tanggal;
$itkembali_kelas       = $perdin->itkembali_kelas;
$itkembali_harga_tiket       = $perdin->itkembali_harga_tiket;
$nama_penginapan       = $perdin->nama_penginapan;
$keterangan       = $perdin->keterangan;


   // var_dump($perdin);die();
   
  } else {
    $id = "";
    $bulan  = "";
    $id_persuratan  = "";
    $id_pegawai = "";
    $no_bku = "";
    $uraian = "";
    $tujuan = "";
    $nama_pelaksana = "";
    $skpd = "";
    $tgl_pembayaran = "";
    $no__sppd = "";
    $lama_p_d = "";
    $tanggal_berangkat = "";
    $tgl_surat = "";
    $tanggal_kembali = "";
    $uang_hari = "";
    $harga_hari = "";
    $jumlah_uang = "";
    $representasi_hari = "";
    $representasi_harga = "";
    $jumlah_representasi = "";
    $uang_sakuhari = "";
    $uang_sakuharga = "";
    $uang_sku_p_j = "";
    $penginapan_malam = "";
    $penginapan_harga = "";
    $penginapan_jumlah = "";
    $tikettol_pulang = "";
    $tikettol_pergi = "";
    $tikettol_jumlah = "";
    $s_t_k_asal_hari = "";
    $s_t_k_asal_harga = "";
    $s_t_k_asal_jumlah = "";
    $s_t_k_tujuan_hari = "";
    $s_t_k_tujuan_harga = "";
    $s_t_k_tujuan_jumlah = "";
    $sewa_kendaraan_hari = "";
    $sewa_kendaraan_harga = "";
    $sewa_kendaraan_jumlah = "";
    $bbm_liter = "";
    $bbm_harga = "";
    $bbm_jumlah = "";
    $swabdi_kota_asal = "";
    $swabdi_kota_tujuan = "";
    $swab_jumlah = "";
    $jumlah_total = "";
    $itberangkat_maskapai = "";
    $itberangkat_no_tiket = "";
    $itberangkat_kodebooking = "";
    $itberangkat_no_penerbangan = "";
    $itberangkat_asal_daerah = "";
    $itberangkat_tujuan = "";
    $itberangkat_tanggal = "";
    $itberangkat_kelas = "";
    $itberangkat_harga_tiket = "";
    $itkembali_maskapai = "";
    $itkembali_nama = "";
    $itkembali_no_tiket = "";
    $itkembali_kode_booking = "";
    $itkembali_no_penerbangan = "";
    $itkembali_asal_daerah = "";
    $itkembali_tujuan = "";
    $itkembali_tanggal = "";
    $itkembali_kelas = "";
    $itkembali_harga_tiket = "";
    $nama_penginapan = "";
    $keterangan = "";



   
  }
 ?>

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
          <ul>
            <li><a href="#tabs-1">Data Satu</a></li>
            <li><a href="#tabs-2">Data Dua</a></li>
            <li><a href="#tabs-3">Data Tiga</a></li>
          </ul>
            <div id="tabs-1">

    <!-- <div class="entry">
        <div id="tabs"> -->
        <!--   <ul>
            <li><a href="#tabs-1">Edit Perjalanan Dinas</a></li>
            <li><a href="#tabs-2">Daftar Value</a></li>
          </ul> -->
            <div id="tabs-1">
              <form method="post" action="<?php echo site_url().'perdin/'.$step; ?>" enctype="multipart/form-data">
                <!-- <?php 
                  if ($step == "update_e_perdin") { ?>
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                  <?php } ?> -->
                <table cellpadding="0" cellspacing="0" border="0" class="display">
                  <tbody>
                  <!--   <tr>
                      <td align="left" width="15%">
                        <b>Bulan</b>
                      </td>
                      <td> -->
                     <!--    <input type="text" name="bulan" style="width:100%" class="input-wrc" value="<?php echo $bulan; ?>" > -->
                <!--         <input type="text" name="bulan" id="currency-field" pattern="^\$\d{1,3}(,\d{3})*(\.\d+)?$" value="<?php echo $bulan; ?>" data-type="currency" placeholder="$1,000,000.00" > -->
             <!--    <input type="text" id="amount1" name="amount1" pattern="\d+(\.\d{2})?" value="<?php echo $bulan; ?>" required> -->
          <!--    <input type='currency' class="uang" id="uang"  name="bulan" placeholder='Type a number & click outside' value="<?php echo $bulan; ?>" />
        
                      </td>
                    </tr> -->

                <?php 
                  if ($step == "update_e_perdin") { ?>
                  <input type="hidden" name="id" value="<?php echo $id; ?>">
                  <?php } ?>

                  <table cellpadding="0" cellspacing="0" border="0" class="display">
                  <tbody>

                    <?php if ($step == "simpan") { ?>
                        <tr>
                            <td valign='top' class="bg-grid"><label class="label-wrc">Tim yang berangkat</label></td>
                            <td class="bg-grid">        
                                <select id="listizin" name="listizin[]" multiple="multiple" style="width: 75%;">
                                    <?php
                                        if($step === "simpan") { 
                                            // foreach ($list as $data) {
                                            //     foreach ($idp as $data_p) {
                                            //         $selected= 'testing';
                                            //         if ($data_p->id == $data->id) {
                                            //             $selected= 'selected'; break;
                                            //         }
                                            //     }
                                            //     if ($selected=="selected") {
                                            //         $data->trunitkerja->get();
                                            //         echo "<option style='width:100%' value='".$data->id."'" . $selected . ">".$data->n_pegawai." | ".
                                            //              $data->nip." | ".$data->pangkat_gol." | ".$data->n_jabatan." </option>";
                                            //     } else {
                                            //         $data->trunitkerja->get();
                                            //         echo "<option style='width:100%' value='".$data->id."'>".$data->n_pegawai." | ".
                                            //              $data->nip." | ".$data->pangkat_gol." | ".$data->n_jabatan. "</option>";
                                            //     }   
                                            // }
                                          foreach ($list as $data) {
                                                echo "<option style='width:100%' value='".$data->id."'>".$data->n_pegawai." | ".$data->nip." |".
                                                     $data->pangkat_gol." | ".$data->n_jabatan." </option>";
                                            }
                                        } else {
                                            
                                        }
                                    ?>
                                </select>
                                <span id="erorPeriksa" style=" clear: both; visibility: hidden;"></span>
                            </td>
                        </tr>
                              <?php } ?>

                    <?php if ($step == "update_e_perdin") { ?>
                            <tr>
                      <td align="left" width="15%" >
                        <b>Nama</b>
                      </td>
                      <td >
                          <select class="pilihan" name="pegawai" style="width:100%">
                          <!-- <option>PILIH JENIS KELAMIN</option>  -->
                          <?php foreach ($pegawai as $rowlistpeg) {   ?>
                          <option value="<?php echo $rowlistpeg->id; ?>" <?php echo ($id_pegawai == $rowlistpeg->id ? "selected" : ""); ?>><?php echo $rowlistpeg->n_pegawai; ?></option>
                          <?php } ?>
                        </select>
                      </td>
                    </tr>
                     <?php } ?>

                    <tr>
                      <td align="left" width="15%" class="bg-grid">
                        <b>No.BKU</b>
                      </td>
                      <td class="bg-grid">
                        <input type="text" name="no_bku" style="width:100%" class="input-wrc" value="<?php echo $no_bku; ?>" >
                      </td>
                    </tr>
                      <tr>
                      <td align="left" width="15%" class="bg-grid">
                        <b>Uraian</b>
                      </td>
                         <td class="bg-grid">
                           <div   class="contentForm">
                                <?php
                                if (!empty($perdin->uraian)) {
                                  $uraian_mksd = $uraian;
                                } else {
                                  $uraian_mksd = 'Pembayaran'.' '.$mksd_pemberangkatan;
                                }
                                
                                $uraian_input = array('name' => 'uraian',
                                                      'value' => $uraian_mksd,
                                                      'style' => 'width:100%',
                                                      'class' => 'input-area-wrc'
                                                     );
                                echo form_textarea($uraian_input);
                                ?>
                             </div>
                           </td>
                    </tr>
                    
                    <tr>
                      <td align="left" width="15%" >
                        <b>Tujuan</b>
                      </td>
                      <td >
                          <select class="pilihan" name="kabupaten" style="width:100%">
                          <!-- <option>PILIH JENIS KELAMIN</option>  -->
                          <?php foreach ($kabupaten as $rowlist) {   ?>
                          <option value="<?php echo $rowlist->id; ?>" <?php echo ($tujuan == $rowlist->id ? "selected" : ""); ?>><?php echo $rowlist->n_kabupaten; ?></option>
                          <?php } ?>
                        </select>
                      </td>
                    </tr>

                    <!--  <tr>
                      <td align="left" width="15%" class="bg-grid">
                        <b>nama_pelaksana</b>
                      </td>
                      <td class="bg-grid">
                        <input type="text" name="nama_pelaksana" style="width:100%" class="input-wrc" value="<?php echo $nama_pelaksana; ?>" >
                      </td>
                    </tr> -->

                     <!-- <tr>
                      <td align="left" width="15%">
                        <b>SKPD</b>
                      </td>
                      <td>
                        <input type="text" name="skpd" style="width:100%" class="input-wrc" value="<?php echo $skpd; ?>" >
                      </td>
                    </tr> -->

                     <tr>
                      <td align="left" width="15%" class="bg-grid">
                        <b>No SPPD</b>
                      </td>
                      <td class="bg-grid">
                        <input type="text" name="no__sppd" style="width:100%" class="input-wrc" value="<?php echo $no__sppd; ?>" >
                      </td>
                    </tr>

                     <tr>
                      <td align="left" width="15%">
                        <b>Tanggal Pembayaran</b>
                      </td>
                       <td class="bg-grid">
                   <!--      <input type="text" name="tanggal_berangkat" style="width:100%" class="input-wrc" value="<?php echo $tanggal_berangkat; ?>" > -->
                         <?php 
                    $tgl_input = array('name' => 'tgl_pembayaran',
                            'value' => ((!empty($tgl_pembayaran)) ? $tgl_pembayaran : date('Y-m-d')),
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
                        <b>Tanggal Berangkat</b>
                      </td>
                       <td class="bg-grid">
                   <!--      <input type="text" name="tanggal_berangkat" style="width:100%" class="input-wrc" value="<?php echo $tanggal_berangkat; ?>" > -->
                         <?php 
                    $tgl_input = array('name' => 'tanggal_berangkat',
                            'value' => ((!empty($tanggal_berangkat)) ? $tanggal_berangkat : date('Y-m-d')),
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
                        <b>Tanggal Kembali</b>
                      </td>
                     <td class="bg-grid">
                      <!--   <input type="text" name="tanggal_kembali" style="width:100%" class="input-wrc" value="<?php echo $tanggal_kembali; ?>" > -->

                         <?php 
                    $tgl_input = array('name' => 'tanggal_kembali',
                            'value' => ((!empty($tanggal_kembali)) ? $tanggal_kembali : date('Y-m-d')),
                            'class' => 'input-wrc',
                            'readOnly'=>TRUE,
                            'style' => "width:100%",
                            'class' => 'monbulan'
                           );
                    echo form_input($tgl_input);
                  ?>

                      </td>
                    </tr>
                     
                   
                  </tbody>
                </table>
            </div>
</div>
<div id="tabs-2">
     <div class="entry">
    <!-- <div class="entry">
        <div id="tabs"> -->
         
              <table cellpadding="0" cellspacing="0" border="0" class="display">
                <tbody>

                   <tr>
                      <td align="left" width="15%" class="bg-grid">
                        <b>UANG HARIAN</b>
                      </td>       </td>           
                         <td align="left"  class="bg-grid">
                      </td>                 
                    </tr>

                    <tr>
                      <td align="left" width="15%">
                        <b>Hari</b>
                      </td>
                      <td>                  
                               <input type="number" name="uang_hari" style="width:100%" class="input-wrc" value="<?php echo $uang_hari; ?>" >
                      </td>
                    </tr> 
                    <tr>
                      <td align="left" width="15%">
                        <b>Harga</b>
                      </td>
                      <td>
                     <!--    <input type="text" name="no_bku" style="width:100%" class="input-wrc" value="<?php echo $no_bku; ?>" > -->
                        <input type='currency' name="harga_hari" placeholder='Type a number & click outside' value="<?php echo $harga_hari; ?>" />
                      </td>
                    </tr>
                      <div></div>
                      
                      <tr>
                      <td align="left" width="15%" class="bg-grid">
                        <b>REPRESENTASI</b>
                      </td>                  </td>           
                         <td align="left"  class="bg-grid">
                      </td>      
                    </tr>

                       <tr>
                          <td align="left" width="15%">
                            <b>Hari</b>
                          </td>
                          <td>
                            <input type="number" name="representasi_hari" style="width:100%" class="input-wrc" value="<?php echo $representasi_hari; ?>" >
                            <!-- <input type='currency' class="uang" id="uang"  name="harga_hari" placeholder='Type a number & click outside' value="<?php echo $harga_hari; ?>" /> -->
                          </td>
                        </tr>
                         <tr>
                          <td align="left" width="15%">
                            <b>Harga</b>
                          </td>
                          <td>
                         <!--    <input type="text" name="no_bku" style="width:100%" class="input-wrc" value="<?php echo $no_bku; ?>" > -->
                            <input type='currency' class="uang" id="uang"  name="representasi_harga" placeholder='Type a number & click outside' value="<?php echo $representasi_harga; ?>" />
                          </td>
                        </tr>
                    
                    <tr>
                      <td align="left" width="15%" class="bg-grid">
                        <b>Uang Saku Peserta</b>
                      </td>                       </td>           
                         <td align="left"  class="bg-grid">
                      </td> 
                    </tr>

                       <tr>
                          <td align="left" width="15%">
                            <b>Hari</b>
                          </td>
                          <td>
                            <input type="number" name="uang_sakuhari" style="width:100%" class="input-wrc" value="<?php echo $uang_sakuhari; ?>" >
                            <!-- <input type='currency' class="uang" id="uang"  name="harga_hari" placeholder='Type a number & click outside' value="<?php echo $harga_hari; ?>" /> -->
                          </td>
                        </tr>
                         <tr>
                          <td align="left" width="15%">
                            <b>Harga</b>
                          </td>
                          <td>
                         <!--    <input type="text" name="no_bku" style="width:100%" class="input-wrc" value="<?php echo $no_bku; ?>" > -->
                            <input type='currency' class="uang" id="uang"  name="uang_sakuharga" placeholder='Type a number & click outside' value="<?php echo $uang_sakuharga; ?>" />
                          </td>
                        </tr>
                     
                       <tr>
                      <td align="left" width="15%" class="bg-grid">
                        <b>PENGINAPAN</b>
                      </td>               </td>           
                         <td align="left"  class="bg-grid">
                      </td>         
                    </tr>

                       <tr>
                          <td align="left" width="15%">
                            <b>Malam</b>
                          </td>
                          <td>
                            <input type="number" name="penginapan_malam" style="width:100%" class="input-wrc" value="<?php echo $penginapan_malam; ?>" >
                            <!-- <input type='currency' class="uang" id="uang"  name="harga_hari" placeholder='Type a number & click outside' value="<?php echo $harga_hari; ?>" /> -->
                          </td>
                        </tr>
                         <tr>
                          <td align="left" width="15%">
                            <b>Harga</b>
                          </td>
                          <td>
                         <!--    <input type="text" name="no_bku" style="width:100%" class="input-wrc" value="<?php echo $no_bku; ?>" > -->
                            <input type='currency' class="uang" id="uang"  name="penginapan_harga" placeholder='Type a number & click outside' value="<?php echo $penginapan_harga; ?>" />
                          </td>
                        </tr>

                          <tr>
                      <td align="left" width="15%" class="bg-grid">
                        <b>Tiket/E-Tol</b>
                      </td>           
                         <td align="left"  class="bg-grid">
                      </td>            
                    </tr>

                       <tr>
                          <td align="left" width="15%">
                            <b>Pulang</b>
                          </td>
                          <td>
                            <!-- <input type="text" name="penginapan_malam" style="width:100%" class="input-wrc" value="<?php echo $penginapan_malam; ?>" > -->
                            <input type='currency' class="uang" id="uang"  name="tikettol_pulang" placeholder='Type a number & click outside' value="<?php echo $tikettol_pulang; ?>" />
                          </td>
                        </tr>
                         <tr>
                          <td align="left" width="15%">
                            <b>Pergi</b>
                          </td>
                          <td>
                         <!--    <input type="text" name="no_bku" style="width:100%" class="input-wrc" value="<?php echo $no_bku; ?>" > -->
                            <input type='currency' class="uang" id="uang"  name="tikettol_pergi" placeholder='Type a number & click outside' value="<?php echo $tikettol_pergi; ?>" />
                          </td>
                        </tr>

                   <tr>
                      <td align="left" width="15%" class="bg-grid">
                        <b>Sewa Taksi</b>
                      </td>    
                       <td align="left"  class="bg-grid">
                        <b>(Di Kota Asal)</b>
                      </td>                     
                    </tr>

                       <tr>
                          <td align="left" width="15%">
                            <b>Hari</b>
                          </td>
                          <td>
                            <input type="number" name="s_t_k_asal_hari" style="width:100%" class="input-wrc" value="<?php echo $s_t_k_asal_hari; ?>" >
                            <!-- <input type='currency' class="uang" id="uang"  name="tikettol_pulang" placeholder='Type a number & click outside' value="<?php echo $tikettol_pulang; ?>" /> -->
                          </td>
                        </tr>
                         <tr>
                          <td align="left" width="15%">
                            <b>Harga</b>
                          </td>
                          <td>
                         <!--    <input type="text" name="no_bku" style="width:100%" class="input-wrc" value="<?php echo $no_bku; ?>" > -->
                            <input type='currency' class="uang" id="uang"  name="s_t_k_asal_harga" placeholder='Type a number & click outside' value="<?php echo $s_t_k_asal_harga; ?>" />
                          </td>
                        </tr>


                          <tr>
                      <td align="left" width="15%" class="bg-grid">
                        <b>Sewa Taksi</b>
                      </td>    
                       <td align="left"  class="bg-grid">
                        <b>(Di Kota Tujuan)</b>
                      </td>                     
                    </tr>

                       <tr>
                          <td align="left" width="15%">
                            <b>Hari</b>
                          </td>
                          <td>
                            <input type="number" name="s_t_k_tujuan_hari" style="width:100%" class="input-wrc" value="<?php echo $s_t_k_tujuan_hari; ?>" >
                            <!-- <input type='currency' class="uang" id="uang"  name="tikettol_pulang" placeholder='Type a number & click outside' value="<?php echo $tikettol_pulang; ?>" /> -->
                          </td>
                        </tr>
                         <tr>
                          <td align="left" width="15%">
                            <b>Harga</b>
                          </td>
                          <td>
                         <!--    <input type="text" name="no_bku" style="width:100%" class="input-wrc" value="<?php echo $no_bku; ?>" > -->
                            <input type='currency' class="uang" id="uang"  name="s_t_k_tujuan_harga" placeholder='Type a number & click outside' value="<?php echo $s_t_k_tujuan_harga; ?>" />
                          </td>
                        </tr>


                      <tr>
                      <td align="left" width="15%" class="bg-grid">
                        <b>Sewa Kendaraan</b>
                      </td>           
                         <td align="left"  class="bg-grid">
                      </td>            
                    </tr>

                       <tr>
                          <td align="left" width="15%">
                            <b>Hari</b>
                          </td>
                          <td>
                            <input type="number" name="sewa_kendaraan_hari" style="width:100%" class="input-wrc" value="<?php echo $sewa_kendaraan_hari; ?>" >
                            <!-- <input type='currency' class="uang" id="uang"  name="sewa_kendaraan_hari" placeholder='Type a number & click outside' value="<?php echo $sewa_kendaraan_hari; ?>" /> -->
                          </td>
                        </tr>
                         <tr>
                          <td align="left" width="15%">
                            <b>Harga</b>
                          </td>
                          <td>
                         <!--    <input type="text" name="no_bku" style="width:100%" class="input-wrc" value="<?php echo $no_bku; ?>" > -->
                            <input type='currency' class="uang" id="uang"  name="sewa_kendaraan_harga" placeholder='Type a number & click outside' value="<?php echo $sewa_kendaraan_harga; ?>" />
                          </td>
                        </tr>

                         <tr>
                      <td align="left" width="15%" class="bg-grid">
                        <b>BBM</b>
                      </td>           
                         <td align="left"  class="bg-grid">
                      </td>            
                    </tr>

                       <tr>
                          <td align="left" width="15%">
                            <b>Liter (Masukkan hanya angka dan koma saja)</b>
                          </td>
                          <td>
                            <input type="number" step="any"  name="bbm_liter" style="width:100%" class="input-wrc" value="<?php echo $bbm_liter; ?>" >
                            <!-- <input type='currency' class="uang" id="uang"  name="sewa_kendaraan_hari" placeholder='Type a number & click outside' value="<?php echo $sewa_kendaraan_hari; ?>" /> -->
                          </td>
                        </tr>
                         <tr>
                          <td align="left" width="15%">
                            <b>Harga</b>
                          </td>
                          <td>
                         <!--    <input type="text" name="no_bku" style="width:100%" class="input-wrc" value="<?php echo $no_bku; ?>" > -->
                            <input type='currency' class="uang" id="uang"  name="bbm_harga" placeholder='Type a number & click outside' value="<?php echo $bbm_harga; ?>" />
                          </td>
                        </tr>
                      


                           <tr>
                      <td align="left" width="15%" class="bg-grid">
                        <b>SWAB</b>
                      </td>           
                         <td align="left"  class="bg-grid">
                      </td>            
                    </tr>

                       <tr>
                          <td align="left" width="15%">
                            <b>Di Kota Asal</b>
                          </td>
                          <td>
                            <!-- <input type="text" name="bbm_liter" style="width:100%" class="input-wrc" value="<?php echo $bbm_liter; ?>" > -->
                            <input type='currency' class="uang" id="uang"  name="swabdi_kota_asal" placeholder='Type a number & click outside' value="<?php echo $swabdi_kota_asal; ?>" />
                          </td>
                        </tr>
                         <tr>
                          <td align="left" width="15%">
                            <b>Di Kota Tujuan</b>
                          </td>
                          <td>
                         <!--    <input type="text" name="no_bku" style="width:100%" class="input-wrc" value="<?php echo $no_bku; ?>" > -->
                            <input type='currency' class="uang" id="uang"  name="swabdi_kota_tujuan" placeholder='Type a number & click outside' value="<?php echo $swabdi_kota_tujuan; ?>" />
                          </td>
                        </tr>
                </tbody>
              </table>
            </div>
        </div>

        <div id="tabs-3">
     <div class="entry">
    <!-- <div class="entry">
        <div id="tabs"> -->
         
              <table cellpadding="0" cellspacing="0" border="0" class="display">
                <tbody>

                   <tr>
                      <td align="left" width="15%" class="bg-grid">
                        <b>Informasi Tiket Perjalanan Dinas</b>
                      </td>       </td>           
                         <td align="left"  class="bg-grid">Berangkat
                      </td>                 
                    </tr>

                    <tr>
                      <td align="left" width="15%">
                        <b>Maskapai</b>
                      </td>
                      <td>                  
                               <input type="text" name="itberangkat_maskapai" style="width:100%" class="input-wrc" value="<?php echo $itberangkat_maskapai; ?>" >
                      </td>
                    </tr> 

                      <tr>
                      <td align="left" width="15%">
                        <b>No.Tiket</b>
                      </td>
                      <td>                  
                               <input type="text" name="itberangkat_no_tiket" style="width:100%" class="input-wrc" value="<?php echo $itberangkat_no_tiket; ?>" >
                      </td>
                    </tr> 

                      <tr>
                      <td align="left" width="15%">
                        <b>Kode Booking</b>
                      </td>
                      <td>                  
                               <input type="text" name="itberangkat_kodebooking" style="width:100%" class="input-wrc" value="<?php echo $itberangkat_kodebooking; ?>" >
                      </td>
                    </tr> 

                      <tr>
                      <td align="left" width="15%">
                        <b>No.Penerbangan</b>
                      </td>
                      <td>                  
                               <input type="text" name="itberangkat_no_penerbangan" style="width:100%" class="input-wrc" value="<?php echo $itberangkat_no_penerbangan; ?>" >
                      </td>
                    </tr> 

                    <tr>
                      <td align="left" width="15%" >
                           <b>Asal Daerah</b>
                      </td>
                      <td >
                          <select class="pilihan" name="itberangkat_asal_daerah1" style="width:100%">
                          <!-- <option>PILIH JENIS KELAMIN</option>  -->
                          <?php foreach ($itberangkat_asal_daerah1 as $rowlist) {   ?>
                          <option value="<?php echo $rowlist->id; ?>" <?php echo ($itberangkat_asal_daerah == $rowlist->id ? "selected" : ""); ?>><?php echo $rowlist->n_kabupaten; ?></option>
                          <?php } ?>
                        </select>
                      </td>
                    </tr>

                    <tr>
                      <td align="left" width="15%" >
                           <b>Tujuan</b>
                      </td>
                      <td >
                          <select class="pilihan" name="itberangkat_tujuan1" style="width:100%">
                          <!-- <option>PILIH JENIS KELAMIN</option>  -->
                          <?php foreach ($itberangkat_tujuan1 as $rowlist) {   ?>
                          <option value="<?php echo $rowlist->id; ?>" <?php echo ($itberangkat_tujuan == $rowlist->id ? "selected" : ""); ?>><?php echo $rowlist->n_kabupaten; ?></option>
                          <?php } ?>
                        </select>
                      </td>
                    </tr>

                      <tr>
                      <td align="left" width="15%">
                        <b>Tanggal</b>
                      </td>
                      <td>                  
                               <!-- <input type="text" name="itberangkat_tanggal" style="width:100%" class="input-wrc" value="<?php echo $itberangkat_tanggal; ?>" > -->
                                <?php 
                    $tgl_input = array('name' => 'itberangkat_tanggal',
                            // 'value' => ((!empty($itberangkat_tanggal)) ? $itberangkat_tanggal : date('Y-m-d')),
                             'value' => $itberangkat_tanggal,
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
                        <b>Kelas</b>
                      </td>
                      <td>                  
                               <input type="text" name="itberangkat_kelas" style="width:100%" class="input-wrc" value="<?php echo $itberangkat_kelas; ?>" >

                          
                      </td>
                    </tr> 
                      <tr>
                      <td align="left" width="15%">
                        <b>Harga Tiket</b>
                      </td>
                      <td>                  
                 

                               <input type='currency' class="uang" id="uang"  name="itberangkat_harga_tiket" placeholder='Type a number & click outside' value="<?php echo $itberangkat_harga_tiket; ?>" />
                      </td>
                    </tr> 

                      <tr>
                      <td align="left" width="15%" class="bg-grid">
                        <b>Informasi Tiket Perjalanan Dinas</b>
                      </td>                  </td>           
                         <td align="left"  class="bg-grid">Kembali
                      </td>      
                    </tr>

                        <tr>
                      <td align="left" width="15%">
                        <b>Maskapai</b>
                      </td>
                      <td>                  
                               <input type="text" name="itkembali_maskapai" style="width:100%" class="input-wrc" value="<?php echo $itkembali_maskapai; ?>" >
                      </td>
                    </tr> 

                      <tr>
                      <td align="left" width="15%">
                        <b>No.Tiket</b>
                      </td>
                      <td>                  
                               <input type="text" name="itkembali_no_tiket" style="width:100%" class="input-wrc" value="<?php echo $itkembali_no_tiket; ?>" >
                      </td>
                    </tr> 

                      <tr>
                      <td align="left" width="15%">
                        <b>Kode Booking</b>
                      </td>
                      <td>                  
                               <input type="text" name="itkembali_kode_booking" style="width:100%" class="input-wrc" value="<?php echo $itkembali_kode_booking; ?>" >
                      </td>
                    </tr> 

                      <tr>
                      <td align="left" width="15%">
                        <b>No.Penerbangan</b>
                      </td>
                      <td>                  
                               <input type="text" name="itkembali_no_penerbangan" style="width:100%" class="input-wrc" value="<?php echo $itkembali_no_penerbangan; ?>" >
                      </td>
                    </tr> 

                    <!--   <tr>
                      <td align="left" width="15%">
                        <b>Asal Daerah</b>
                      </td>
                      <td>                  
                               <input type="text" name="itkembali_asal_daerah" style="width:100%" class="input-wrc" value="<?php echo $itkembali_asal_daerah; ?>" >
                      </td>
                    </tr>  -->

                      <tr>
                      <td align="left" width="15%" >
                           <b>Asal Daerah</b>
                      </td>
                      <td >
                          <select class="pilihan" name="itkembali_asal_daerah1" style="width:100%">
                          <!-- <option>PILIH JENIS KELAMIN</option>  -->
                          <?php foreach ($itkembali_asal_daerah1 as $rowlist) {   ?>
                          <option value="<?php echo $rowlist->id; ?>" <?php echo ($itkembali_asal_daerah == $rowlist->id ? "selected" : ""); ?>><?php echo $rowlist->n_kabupaten; ?></option>
                          <?php } ?>
                        </select>
                      </td>
                    </tr>
                    <!--   <tr>
                      <td align="left" width="15%">
                        <b>Tujuan</b>
                      </td>
                      <td>                  
                               <input type="text" name="itkembali_tujuan" style="width:100%" class="input-wrc" value="<?php echo $itkembali_tujuan; ?>" >
                      </td>
                    </tr>  -->

                    <tr>
                      <td align="left" width="15%" >
                           <b>Tujuan</b>
                      </td>
                      <td >
                          <select class="pilihan" name="itkembali_tujuan1" style="width:100%">
                          <!-- <option>PILIH JENIS KELAMIN</option>  -->
                          <?php foreach ($itkembali_tujuan1 as $rowlist) {   ?>
                          <option value="<?php echo $rowlist->id; ?>" <?php echo ($itkembali_tujuan == $rowlist->id ? "selected" : ""); ?>><?php echo $rowlist->n_kabupaten; ?></option>
                          <?php } ?>
                        </select>
                      </td>
                    </tr>


                      <tr>
                      <td align="left" width="15%">
                        <b>Tanggal</b>
                      </td>
                      <td>                  
                               <!-- <input type="text" name="itkembali_tanggal" style="width:100%" class="input-wrc" value="<?php echo $itkembali_tanggal; ?>" > -->
                                <?php 
                    $tgl_input = array('name' => 'itkembali_tanggal',
                            // 'value' => ((!empty($itkembali_tanggal)) ? $itkembali_tanggal : date('Y-m-d')),
                          'value' => $itkembali_tanggal,
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
                        <b>Kelas</b>
                      </td>
                      <td>                  
                               <input type="text" name="itkembali_kelas" style="width:100%" class="input-wrc" value="<?php echo $itkembali_kelas; ?>" >
                      </td>
                    </tr> 
                      <tr>
                      <td align="left" width="15%">
                        <b>Harga Tiket</b>
                      </td>
                      <td>        
                               <input type='currency' class="uang" id="uang"  name="itkembali_harga_tiket" placeholder='Type a number & click outside' value="<?php echo $itkembali_harga_tiket; ?>" />
                      </td>
                    </tr> 

                    <tr>
                      <td align="left" width="15%" class="bg-grid">
                        <b>Nama Penginapan/Hotel</b>
                      </td>           
                         <td align="left"  class="bg-grid">
                          <input type="text" name="nama_penginapan" style="width:100%" class="input-wrc" value="<?php echo $nama_penginapan; ?>" > 
                      </td>            
                    </tr>


                           <tr>
                      <td align="left" width="15%" class="bg-grid">
                        <b>Keterangan</b>
                      </td>           
                         <td align="left"  class="bg-grid">
                          <input type="text" name="keterangan" style="width:100%" class="input-wrc" value="<?php echo $keterangan; ?>" > 
                      </td>            
                    </tr>


                </tbody>
              </table>
            </div>
        </div>


        <label>&nbsp;</label>
        <div class="spacer"></div>
    </div>
    <div class="entry" style="text-align: center;">
      <?php 
        if ($step == "simpan") { ?>
          <input type="submit" name="submit" value="Simpan" class="submit-wrc" content="Simpan">
        <?php } else { ?>
          <input type="submit" name="submit" value="Ubah" class="submit-wrc" content="Ubah">
        <?php } ?>
      
      <span></span>
      <button name="button" type="button" class="button-wrc" onclick="parent.location='<?php echo site_url('perdin'); ?>'">Batal</button>
    </div>
  </form>
  </div>
  <br style="clear: both;" />
</div>
<script>
//   var currencyInput = document.querySelector('input[type="currency"]')
//   // var currencyInput = document.querySelector('#uang')
// var currency = 'IDR' // https://www.currency-iso.org/dam/downloads/lists/list_one.xml

//  // format inital value
// onBlur({target:currencyInput})

// // bind event listeners
// currencyInput.addEventListener('focus', onFocus)
// currencyInput.addEventListener('blur', onBlur)


// function localStringToNumber( s ){
//   return Number(String(s).replace(/[^0-9.-]+/g,""))
// }

// function onFocus(e){
//   var value = e.target.value;
//   e.target.value = value ? localStringToNumber(value) : ''
// }

// function onBlur(e){
//   var value = e.target.value

//   var options = {
//       maximumFractionDigits : 0,  //jumlah angka dibelakang koma
//       currency              : currency,
//       style                 : "currency",
//       currencyDisplay       : "symbol"
//   }
  
//   e.target.value = (value || value === 0) 
//     ? localStringToNumber(value).toLocaleString(undefined, options)
//     : ''
// }

    var currencyInput = document.querySelectorAll( 'input[type="currency"]' );

    for ( var i = 0; i < currencyInput.length; i++ ) {

        var currency = 'IDR'
        onBlur( {
            target: currencyInput[ i ]
        } )

        currencyInput[ i ].addEventListener( 'focus', onFocus )
        currencyInput[ i ].addEventListener( 'blur', onBlur )

        function localStringToNumber( s ) {
            return Number( String( s ).replace( /[^0-9.-]+/g, "" ) )
        }

        function onFocus( e ) {
            var value = e.target.value;
            e.target.value = value ? localStringToNumber( value ) : ''
        }

        function onBlur( e ) {
            var value = e.target.value

            var options = {
                maximumFractionDigits: 0,
                currency: currency,
                style: "currency",
                currencyDisplay: "symbol"
            }

            e.target.value = ( value || value === 0 ) ?
                localStringToNumber( value ).toLocaleString( undefined, options ) :
                ''
        }
    }
</script>
