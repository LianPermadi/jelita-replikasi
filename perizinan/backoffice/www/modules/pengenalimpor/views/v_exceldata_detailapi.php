<?php
 foreach ($perusahaan as $row) {
   $no_api =  $row->no_api;
   $namaPerusahaan =  $row->namaPerusahaan;
   $alamat =  $row->almtPerusahaan;
   $namaKabupaten = $row->namaKabupaten;
   $telepon = $row->telpPerusahaan;
   $fax = $row->faxPerusahaan;
 }

header( "Content-Type: application/vnd.ms-excel" );
header( "Content-disposition: attachment; filename=$no_api $namaPerusahaan $tgl1 sd $tgl2.xls" );

?>
<br>
  <br>
    <center>
      <b>
        <?php echo $namaPerusahaan;?>
      </b>
    </center>
    <center>
      <?php echo $alamat;?>
    </center>
    <center>
      <?php echo 'Tlp : '.$telepon .' Fax : '.$fax;?>
    </center>
    <br>
 Periode : 
      <?php echo  date('d M Y', strtotime($tgl1)).' s/d '. date('d M Y', strtotime($tgl2));?>
      <br>
        <br>
          <table border="1">
            <thead >
              <tr>
                <th>No</th>
                <th>Nomor API</th>
                <th>Jenis API</th>
                <th >Uraian Barang</th>
                <th >HS10digit</th>
                <th >Volume</th>
                <th >Satuan</th>
                <th >Harga Satuan</th>
                <th >Nilai CIF</th>
                <th >Nilai CNF</th>
                <th >Nilai FOB</th>
                <th >Mata Uang</th>
                <th >Negara Asal</th>
                <th >Pelabuhan Asal</th>
                <th >Pelabuhan Tujuan</th>
                <th>No L/S</th>
                <th>Tgl L/S</th>
                <th>No PIB</th>
                <th>Tgl PIB</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              <?php
        if($api_table !== "")
        {
            echo $api_table;

        }
        else
        {
        ?>
              <tr>
                <td colspan="6">
                  <center>Tidak ada data</center>
                </td>
              </tr>
              <?php } ?>
            </tbody>
          </table>

