<script>
    function printPDF() {
        var originalContents = document.body.innerHTML;

        // Mengganti konten halaman dengan konten PDF yang akan dicetak
        var printContents = document.getElementById("pdfContent").innerHTML;
        document.body.innerHTML = printContents;

        // Mengatur media print ke PDF
        var printWindow = window.open('', '', 'height=400,width=800');
        printWindow.document.write('<html><head><title>PDF Print</title>');
        printWindow.document.write('</head><body >');
        printWindow.document.write(printContents);
        printWindow.document.write('</body></html>');
        printWindow.document.close();
        printWindow.print();

        // Mengembalikan kembali konten halaman asli
        document.body.innerHTML = originalContents;
    }
</script>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
    <style>
        /* Aturan untuk margin cetak */
        @page {
            margin: 5cm;
            /* Ukuran margin dalam satuan yang Anda inginkan, seperti cm, mm, in, atau px */
        }

        /* Aturan untuk tampilan cetak */
        @media print {

            /* Pengaturan margin pada elemen-elemen yang akan dicetak */
            body {
                margin: 25;
                /* Menghapus margin pada badan dokumen */
            }

            /* Aturan lainnya untuk tampilan cetak */
        }
    </style>
</head>

<body>
    <?php
        $protocol = $_SERVER['REQUEST_SCHEME'];
        $domain = $_SERVER['http_host'];
        $script_filename = $_SERVER["PHP_SELF"];
            // Cek apakah "index.php" ada di dalam string
        if (strpos($script_filename, 'index.php') !== false) {
                // Hapus "index.php" dari string
            $clean_path = str_replace('index.php', '', $script_filename);
        } else {
            $clean_path = $script_filename;
        }
    ?>
    <style type="text/css">
        .justify {
            text-align: justify;
        }

        .top {
            text-align: top;
        }

        .margin {
            padding-left: 20%;
            padding-right: 20%;
        }

        p {
            margin-bottom: 2px;
            font-size: 14px;
            text-align: justify;
        }

        .text-container {
            position: relative;
            z-index: 2;
        }

        table {
            position: relative;
            z-index: 1;
        }
    </style>
    <div id="content">
        <div class="title">
            <h2>
                <span style="font-family: Cursive; color: navy;">
                    <b>
                        <?php
                        echo $page_name; 
                        foreach($list as $data){
                            $nomor = $data->nomor;
                            $untuk = $data->untuk;
                            $dasar = $data->dasar;
                            $tanggal = $data->tanggal;
                        }
                        ?>
                    </b>
                </span>
            </h2>
        </div>
        <div class="post">
            <center>
                <button onclick="printDiv('tag-id')" target="_blank" class="submit-wrc">Cetak Surat</button>
            </center>
            <div id="tag-id" style="margin: 10%;">
                <div class="post margin">
                    <img src="<?= $protocol."://".$domain.$clean_path  ?>www/modules/perdin/views/image/cop_surat.png" width="100%">
                    <center>
                        <h1>
                            <b>
                                SURAT PERINTAH
                            </b>
                        </h1>
                    </center>
                    <center>
                        <h2>
                            Nomor : <?php echo $nomor; ?>
                        </h2>
                    </center>
                    <table>
                      <tr>
                        <td width="10%" style="vertical-align: top;">
                          <p>
                            Dasar  :
                          </p>
                        </td>
                        <td align="justify">
                          <p>
                            <?php echo $dasar; ?>
                          </p>
                        </td>
                      </tr>
                    </table>
                    <center>
                        <h2>
                    M E M E R I N T A H K A N
                        </h2>
                    </center>
                    <center>
                    <table>
                      <tr>
                        <td width="10%" style="vertical-align: top;">
                          <p>
                    Kepada :
                          </p>
                        </td>
                        <td>
                            <table>
                    <?php
                    $no = 1;
                    foreach ($search as $row) {
                    ?>
                    <tr>
                        <td width="4%" style="vertical-align: top;"><p><?php echo $no.". "; ?></p></td><td><p> N a m a </p></td><td><p>  : </p> </td><td><p> <?php echo $this->m_perdin->get_n_pegawai($row->kepada); ?></p></td>
                    </tr>
                    <tr>
                        <td width="4%" style="vertical-align: top;"></td><td><p>Pangkat/golongan</p></td><td><p> : </p></td><td><p><?php echo $this->m_perdin->get_n_nip($row->kepada); ?></p></td>
                    </tr>
                    <tr>
                        <td width="4%" style="vertical-align: top;"></td><td><p>Nomor Induk Pegawai</p></td><td><p> : </p></td><td><p><?php echo $this->m_perdin->get_n_pangkat($row->kepada); ?> (<?php echo $this->m_perdin->get_n_gol($row->kepada); ?>)</p></td>
                    </tr>
                    <tr>
                        <td width="4%" style="vertical-align: top;"></td><td><p>J a b a t a n</p></td><td><p> :</p></td><td><p><?php echo $this->m_perdin->get_n_jabatan($row->kepada); ?>
                          </p></td>
                      </tr>
                      <tr><td colspan="4"><br></td></tr>
                    <?php $no++; } ?></table>
                </td>
            </tr>
                    </table>
                    </center>
                    <table>
                      <tr>
                        <td width="10%" style="vertical-align: top;">
                          <p>
                    Untuk : 
                          </p>
                        </td>
                        <td><p><?php echo $untuk; ?></p>
                </td>
            </tr>
                    </table>

                    
                          <p>Demikian surat perintah ini, dibuat untuk dilaksanakan sebagaimana mestinya dengan penuh rasa tanggung jawab.
                          </p>
<br>
                    <table style="float: right;">
                      <tr>
                        <td style="vertical-align: top;">
                          <p>
                    Ditetapkan di : </p></td><td><p>
                    B A N D U N G </p></td></tr><tr><td><p>
                    pada tanggal : </p></td><td><p>
                    <?php echo $tanggal; ?> </p>
                </td>
            </tr>
            <tr>
                <td>
                <td>
                   <br><b>
                    <p style="text-align:center;">a.n. KEPALA DINAS PENANAMAN MODAL <br>DAN PELAYANAN TERPADU SATU PINTU</p>
                    <p style="text-align:center;"> PROVINSI JAWA BARAT</p>
                    <p style="text-align:center;">SEKRETARIS,</p>
                </b>
                </td>
</tr>
</table>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>



                </div>
            </div>
        </div>
    </div>
</body>

</html>
<script type="text/javascript">
    function printDiv(divId) {
        var divToPrint = document.getElementById(divId);
        var originalContents = document.body.innerHTML;
        var printContents = '<html><head><title>Cetak Tag</title></head><body>' + divToPrint.innerHTML + '</body></html>';
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
    }
</script>