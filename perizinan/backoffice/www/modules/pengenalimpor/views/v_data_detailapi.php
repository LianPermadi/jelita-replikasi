<div id="content">
    <div class="post">
        <div class="title">
            <h2><?php echo $page_name; ?></h2>
        </div>
<div class="entry">
 <br style="clear: both" />
 <?php
 foreach ($perusahaan as $row) {
   $no_api =  $row->no_api;
   $namaPerusahaan =  $row->namaPerusahaan;
   $alamat =  $row->almtPerusahaan;
   $namaKabupaten = $row->namaKabupaten;
 }
 ?>
 <form method="POST" action = "<?php echo base_url();?>pengenalimpor/c_pengenalimpor/detail_api_perusahaan/<?php echo  $no_api;?>" enctype="multipart/form-data">
<label>Nomor API  </label>
<input type="text" name="no_api" class="input-wrc" value="<?php echo $no_api;?>" readonly>
 <br style="clear: both" />
<label>Nama Perusahaan  </label>
<input type="text" name="perusahaan" class="input-wrc" value="<?php echo $namaPerusahaan;?>" readonly>
 <br style="clear: both" />
<label>Alamat Perusahaan  </label>
<input type="text" name="alamat" style="width: 500px;" class="input-wrc" value="<?php echo $alamat;?>" readonly>
 <br style="clear: both" />
 <label>Kota / Kabupaten  </label>
<input type="text" name="namakabupaten" class="input-wrc" value="<?php echo $namaKabupaten;?>" readonly>
 <br style="clear: both" />
<label>Periode PIB  </label>
<input type="text" name="tgl1" id="datepicker"  class="input-wrc" readonly value="<?php echo $tgl1;?>"> - <input type="text" name="tgl2"  id="datepicker1" class="input-wrc" value="<?php echo $tgl2;?>" readonly>
 <br style="clear: both" />
 <label> </label>
<button type="submit" class="button-wrc" >CARI</button>
</form>

<form method="POST" action = "<?php echo base_url();?>pengenalimpor/c_pengenalimpor/exceldetail_api_perusahaan/<?php echo  $no_api;?>" enctype="multipart/form-data">

<input type="hidden" name="tgl11"lass="input-wrc" readonly value="<?php echo $tgl1;?>"><input type="hidden" name="tgl22"  class="input-wrc" value="<?php echo $tgl2;?>" readonly>
 <br style="clear: both" />
<button type="submit" class="button-wrc" >Download Excel</button>
</form>
<table cellpadding="0" cellspacing="0" border="0" class="display" id="dataapi" >
                <thead>
                    <tr>
                      <th width="" >No</th>
                      <th width="" >Nomor API</th>
                      <th width="" >Jenis API</th>
                       <th width="">Uraian Barang</th>
                       <th width="">HS10digit</th>
                        <th width="">Volume</th>
                        <th width="">Satuan</th>
                        <th width="">Harga Satuan</th>
                        <th width="">Nilai CIF</th>
                        <th width="">Nilai CNF</th>
                        <th width="">Nilai FOB</th>
                        <th width="">Mata Uang</th>
                        <th width="">Negara Asal</th>
                        <th width="">Pelabuhan Asal</th>
                         <th width="">Pelabuhan Tujuan</th>
                        <th width="" >No L/S</th>
                        <th width="" >Tgl L/S</th>
                        <th width="" >No PIB</th>
                        <th width="" >Tgl PIB</th>
                        <th width="" >Status</th>
                    </tr>
                </thead>
                <tbody>
                	 <?php
        if($api_table != "")
        {
            echo $api_table;

        }
       ?>

                </tbody>
                </table>

<br style="clear: both" />
       </div>
       </div>
       </div>

<script src="<?php echo base_url();?>assets/autocomplete/js/jquery-1.10.2.js"></script> 
<script src="<?php echo base_url();?>assets/autocomplete/js/jquery-ui.js"></script>
<script type="text/javascript"> 
var f=jQuery.noConflict();
<!-- akhir auto complete -->
f(function() { 
 var date = f('#datepicker').datepicker({ dateFormat: 'yy-mm-dd' }).val();
 var date = f('#datepicker1').datepicker({ dateFormat: 'yy-mm-dd' }).val();
}); 
</script>