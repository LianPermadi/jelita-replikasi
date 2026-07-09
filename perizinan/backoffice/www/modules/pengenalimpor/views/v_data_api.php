<div id="content">
    <div class="post">
        <div class="title">
            <h2><?php echo $page_name; ?></h2>
        </div>
<div class="entry">
 <br style="clear: both" />
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
                        <th width="" >Flag</th>
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
            <td colspan="6"><center>Tidak ada data</center></td>
            </tr>
            <?php } ?>

                </tbody>
                </table>

<br style="clear: both" />
       </div>
       </div>
       </div>