<?php 
 
  //   if(!empty($lokasi)){
  //    $lokasi       = print_r($lokasi[0]);
  //     // var_dump($lokasi);die();
  // }else{
  //     $lokasi       = "";
  // }
    // $iduser = $this->session->userdata('id_auth');
    // if($iduser == 680){
    // var_dump($analis_hukum);die();
    // }
 ?>

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
   
    <div class="entry">
    
      <!-- <span style="color:red;">*</span><h3>Tambahkan ${no_surat} pada SP Perjalanan Dinas untuk menambahkan Nomor Surat</h3> -->
        <div id="tabs">
          <ul>
                    <li><a href="#tabs-<?php echo $perdin_grup->id_pegawai?>">Penomoran Surat Perintah Perjalanan Dinas</a></li>

          </ul>
                
                    <div id="tabs-<?php echo $perdin_grup->id_pegawai?>">
                        <h2>Detail Pemberangkatan</h2>
                        <form method="post" action="<?php echo site_url().'perdin/update_penomoran/'.$perdin_grup->no_grup_perdin.'/'.$perdin_grup->id_tim; ?>" enctype="multipart/form-data">
                       

                                      <table cellpadding="0" cellspacing="0" border="0" class="display" id="pendataan"  readonly>
                                        <thead>
                                            <tr>
                                                <th style="border: 1px solid #ddd; padding: 8px;">
                                                    Nama Pegawai
                                                    <br>
                                                    NIP
                                                    <br> 
                                                    Pangkat/Gol
                                                    <br> 
                                                    Jabatan
                                                    <br>
                                                </th>
                                                <th style="border: 1px solid #ddd; padding: 8px;">Tanggal Keberangkatan</th>
                                                <th style="border: 1px solid #ddd; padding: 8px;">Tanggal Kepulangan</th>
                                                <th style="border: 1px solid #ddd; padding: 8px;">Maksud Pemberangkatan</th>
                                                <th style="border: 1px solid #ddd; padding: 8px;">Detail Tempat Pemberangkatan</th>
                                                <th style="border: 1px solid #ddd; padding: 8px;">Nama Tim</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if ($step === "update") {
                                                foreach ($perdin_no_grup as $rowlist) {
                                                    foreach ($list as $data) {
                                                        if ($rowlist->id_pegawai == $data->id) {
                                                            echo "<tr>
                                                                    <td style='border: 1px solid #ddd; padding: 8px;'>
                                                                        " . $data->n_pegawai . "<br>
                                                                        " . $data->nip . "<br>
                                                                        " . $data->pangkat_gol . "<br>
                                                                        " . $data->n_jabatan . "
                                                                    </td>
                                                                    <td style='border: 1px solid #ddd; padding: 8px;'>" . (!empty($rowlist->tanggal_keberangkatan) ? $rowlist->tanggal_keberangkatan : '-') . "</td>
                                                                    <td style='border: 1px solid #ddd; padding: 8px;'>" . (!empty($rowlist->tanggal_kembali) ? $rowlist->tanggal_kembali : '-') . "</td>
                                                                    <td style='border: 1px solid #ddd; padding: 8px;'>" . (!empty($rowlist->mksd_pemberangkatan) ? $rowlist->mksd_pemberangkatan : '-') . "</td>
                                                                    <td style='border: 1px solid #ddd; padding: 8px;'>" . (!empty($rowlist->detail_tempat_pemberangkatan) ? $rowlist->detail_tempat_pemberangkatan : '-') . "</td>
                                                                    <td style='border: 1px solid #ddd; padding: 8px;'>" . (!empty($rowlist->nama_tim) ? $rowlist->nama_tim : '-') . "</td>
                                                                </tr>";
                                                        }
                                                    }
                                                }
                                            } else {
                                                echo "<tr>
                                                        <td colspan='5' style='border: 1px solid #ddd; padding: 8px; text-align: center;'>No data available</td>
                                                    </tr>";
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                            <div class="entry" style="text-align: center;">
                              <div style="margin-bottom: 30px;">
                                <h2>Nomer Surat Perintah Perdin</h2>
                                <input type="text" name="no__sppd" class="input-wrc" 
                                      value="<?php echo isset($perdin_grup->no__sppd) && !empty($perdin_grup->no__sppd) ? $perdin_grup->no__sppd : ''; ?>" 
                                      required="required" style="height: 55px;width: 280px;font-size: 18px;">
                              </div>  
                            
                              <input type="submit" name="submit" value="Simpan" class="submit-wrc" content="Simpan">

                              
                              <span></span>
                              <button name="button" type="button" class="button-wrc" onclick="parent.location='<?php echo site_url('perdin/suratperintah'); ?>'">Batal</button>
                            </div>
                    </div>
                    <div id="tabs-2">
                    </div>

             
           
            
        </div>
        <label>&nbsp;</label>
        <div class="spacer"></div>
    </div>
    
      
  </form>
  </div>
  <br style="clear: both;" />
</div>
<script>
    $(document).ready(function() {
        $('select[name="kabupaten"]').select2({
            width: '100%'  // Pastikan lebar dropdown 100%
        });
    });
</script>
<script>
        $(document).ready(function () {
            $('#kode_rek_sub_req').select2({
            placeholder: "Pilih opsi", // Placeholder untuk dropdown
            allowClear: true,         // Menambahkan tombol untuk menghapus pilihan
            width: '100%',            // Lebar dropdown
            language: {
                noResults: function () {
                return "Tidak ada hasil ditemukan";
                }
            }
            });
        });
$(document).ready(function () {
  $('#listizin').multiselect({
    selectedText: '# dari # terpilih'
  }).multiselectfilter({
    show: 'blind',
    hide: 'blind'
  });

  $('#listizin').multiselect({
    click: function (event, ui) {
      // Ambil nilai checkbox yang dipilih
      let selectedValues = $(this).multiselect("getChecked").map(function () {
        return $(this).val();
      }).get();
      
      // Ambil nilai tanggal keberangkatan
      const tglBerangkat = $('input[name="tglberangkat"]').val();

      // Tampilkan atau sembunyikan file input jika lebih dari 4 checkbox terpilih
      if (selectedValues.length > 4) {
        $('#fileInputWrapper').show();
      } else {
        $('#fileInputWrapper').hide();
      }

      // Jika ada checkbox yang diceklis, lakukan pengecekan data
      if (ui.checked) {

        
        const selectedId = ui.value; // ID pegawai yang baru saja diceklis
        // console.log('ID dipilih:', selectedId);
        
        fetch("<?php echo site_url('perdin/check_data_pegawai_by_date'); ?>", {
          method: "POST",
          headers: {
            "Content-Type": "application/x-www-form-urlencoded"
          },
          body: `id=${encodeURIComponent(selectedId)}&tglberangkat=${encodeURIComponent(tglBerangkat)}`
        })
        .then(response => response.json())
        .then(data => {
          console.log(data.exists);
          
          if (data.exists == true) {
            alert(`Pegawai dengan indentitas ${ui.text} sudah memiliki jadwal Perjalanan dinas pada tanggal keberangkatan.`);

            // Cari checkbox berdasarkan value dan ubah statusnya
            const checkbox = $(`input[type="checkbox"][value="${selectedId}"]`);
            if (checkbox.length > 0) {
              checkbox.attr('checked', false); // Nonaktifkan dengan .attr()
              checkbox[0].checked = false; // Manipulasi DOM asli untuk kompatibilitas
              $('#listizin').multiselect("refresh"); // Segarkan tampilan multiselect
              console.log('Checkbox berhasil dinonaktifkan:', checkbox);
            } else {
              console.error('Checkbox tidak ditemukan.');
            }
          }
        })
        .catch(error => {
          console.error("Error:", error);
        });
      }
    }
  });
});


  


</script>

<script> 
$(document).ready(function(){
  $("#flip").click(function(){
    $("#panel").slideToggle("slow");
  });
});
</script>


<script type="text/javascript">
  function toggleFormFields() {
    var tipeUndangan = document.getElementById("tipe_undangan").value;

    // Show or hide fields based on selection
    var displayStyle = (tipeUndangan == "2") ? "table-row" : "none";
    document.getElementById("tgl_undangan_row").style.display = displayStyle;
    document.getElementById("nmr_undangan_row").style.display = displayStyle;
    document.getElementById("perihal_undangan_row").style.display = displayStyle;
    document.getElementById("kode_rek_sub_req_row").style.display = displayStyle;
    document.getElementById("srt_instansi_undangan_row").style.display = displayStyle;
  }

  // Call the function on page load
  document.addEventListener("DOMContentLoaded", function () {
    toggleFormFields(); // Set initial visibility
  });
</script>


<style> 
#panel, #flip {
  padding: 5px;
  text-align: center;
  background-color: #e5eecc;
  border: solid 1px #c3c3c3;
}

#panel {
  padding: 50px;
  display: none;
}
</style>