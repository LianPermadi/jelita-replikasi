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

        .right-align {
            text-align: right;
        }
        /* Aturan untuk margin cetak */
        @page {
            margin: 5cm;
            /* Ukuran margin dalam satuan yang Anda inginkan, seperti cm, mm, in, atau px */

            .justify {
                text-align: justify;
            }

            .center {
                text-align: center;
            }
            .margin {
                padding-left: 20%;
                padding-right: 20%;
            }

            p {
                margin-bottom: 2px;
                font-size: 23px;
                text-align: justify;
            }
        }

        /* Aturan untuk tampilan cetak */
        @media print {

            /* Pengaturan margin pada elemen-elemen yang akan dicetak */
            body {
                margin: 25;
                /* Menghapus margin pada badan dokumen */
            }

            .justify {
                text-align: justify;
            }

            .center {
                text-align: center;
            }
            .margin {
                padding-left: 20%;
                padding-right: 20%;
            }

            p {
                margin-bottom: 2px;
                font-size: 23px;
                text-align: justify;
            }

            /* Aturan lainnya untuk tampilan cetak */
        }

        .justify {
            text-align: justify;
        }

        .center {
            text-align: center;
        }
        .margin {
            padding-left: 20%;
            padding-right: 20%;
        }

        p {
            margin-bottom: 2px;
            font-size: 23px;
            text-align: justify;
        }
    </style>
</head>

<body>
    <?php
    // $barang = $this->m_barang->get_barang_master($id);
    ?>
    <?php foreach ($mobil as $row) {


        setlocale(LC_TIME, 'id_ID');
        $tanggal = $row->tanggal; // Tanggal dalam format YYYY-MM-DD
        $tahun = date("Y", strtotime($tanggal)); // Mengambil tahun dari tanggal
        // echo "Tahun: " . $tahun; // Output: Tahun: 2023
        $bulan = strftime("%B", strtotime($tanggal)); // Mengambil tahun dari tanggal
        $day = date("d", strtotime($tanggal)); // Mengambil tahun dari tanggal

        // $tanggal = "2023-04-03"; // Tanggal dalam format YYYY-MM-DD

        // Set bahasa lokal ke Indonesia

        // Mengambil hari dalam bahasa Indonesia
        $hari = strftime("%A", strtotime($tanggal));
        // var_dump($hari);die();

        // echo "Hari: " . $hari; // Output: Hari: Minggu
    ?>
        <div id="content">
            <div class="title">
                <?php echo $this->lib_date->view_title($page_name); ?>
            </div>
            <div class="post">
                <br>
                <br>
                <center>
                    <button onclick="printDiv('tag-id')" target="_blank" class="submit-wrc">Cetak Surat</button>
                </center>
                <div id="tag-id" style="margin: 16%;">
                    <div class="post margin">
                        <center>
                            <h3><b>BERITA ACARA <br> PEMINJAMAN KENDARAAN DINAS</b></h3>
                        </center><br><br>
                        <p class="justify">
                            Yang bertanda tangan dibawah ini :
                            <table>
                                <tr>
                                    <td><p>1.</p></td><td><p>Nama</p></td><td><p>:</p></td><td><p>Gita Wirantika, S.E., MM</p></td>
                                </tr>
                                <tr>
                                    <td height="20px" width="40px"></td><td><p>Jabatan</p></td><td><p>:</p></td><td><p>Kepala Sub Bagian Tata Usaha</p></td>
                                </tr>
                                <tr>
                                    <td colspan="4"><p class="center">( PIHAK KESATU )</p></td>
                            </table>
                            <table>
                                <tr>
                                    <td><p>2.</p></td><td><p>Nama</p></td><td><p>:</p></td><td><p><?php echo $this->m_mobil->get_nama_user($row->peminjam); ?></p></td>
                                </tr>
                                <tr>
                                    <td height="20px" width="40px"></td><td><p>Jabatan</p></td><td><p>:</p></td><td><p><?php echo $this->m_mobil->get_nama_jabatan($row->peminjam); ?></p></td>
                                </tr>
                                <tr>
                                    <td height="20px" width="40px"></td><td><p>Unit</p></td><td><p>:</p></td><td><p><?php 
                                    $unitkerja = $this->m_mobil->get_nama_unit($row->peminjam); 
                                    echo $this->m_mobil->get_unitkerja($unitkerja); 
                                ?></p></td>
                                </tr>
                                <tr>
                                    <td colspan="4"><p class="center">( PIHAK KEDUA )</p></td>
                            </table>
                        </p>
                        <br>
                        <br>
                        <br>
                        <?php

                            setlocale(LC_TIME, 'id_ID');
                            $startDate = date('Y-m-d', strtotime($row->tanggal_pinjam));
                            $endDate = date('Y-m-d', strtotime($row->tanggal_kembali));
                            $startTime = strtotime($startDate);
                            $endTime = strtotime($endDate);

                            $daysDiff = ($endTime - $startTime) / (60 * 60 * 24);
                            $start = date('d F Y', strtotime($row->tanggal_pinjam));
                            $end = date('d F Y', strtotime($row->tanggal_kembali));
                            $haristart = strftime('%A', strtotime($row->tanggal_pinjam));
                        ?>
                        <br>
                        <p>
                            Pihak kedua meminjam kendaraan dinas roda 4 (empat) dengan no. Pol <b><?php echo $this->m_mobil->get_platnomor_id($row->mobil); ?></b> Selama <b>
                            <?php 
                            if($daysDiff == '0'){
                                $daysDiff = '1';
                            }
                            echo $daysDiff;
                            ?>
                            </b> hari, pada tanggal <b>
                            <?php 
                            echo $start; 
                            ?>
                            </b> s/d tanggal <b>
                                <?php 
                                echo $end; 
                                ?>
                            </b> 
                            di hari 
                            <b>
                                <?php 
                                echo $haristart; 
                                ?>
                                </b>
                                 tujuan ke Kabupaten/kota : 
                                 <b>
                                    <?php echo $row->tujuan; ?> </b>Untuk kepentingan Pribadi / Dinas dengan ketentuan sebagai berikut :
                        </p>
                        <br>
                        <br>

                        <ul>
                            <li><p>Bertanggung jawab penuh atas kehilangan, kerusakan dan hal-hal lain yang tidak Diinginkan selama peminjaman.</p></li>
                            <li><p>Mengembalikan kendaraan dinas sesuai jadwal waktu peminjaman.</p></li>
                            <li><p>Mengembalikan kendaraan dinas dalam keadaan BERSIH.</p></li>
                            <li><p>Mengembalikan kendaraan dinas dengan BBM terisi seperti semula.</p></li>
                        </ul>
                        <br>
                        <table>
                            <tr>
                                <td width="40%">
                                    <table>
                                        <tr>
                                            <td height="20px" width="100%"><p>Kondisi BBM Saat berangkat:</p></td>
                                        </tr>
                                        <tr>
                                            <td height="20px" width="100%"></td>
                                        </tr>
                                        <tr>
                                            <td height="20px" width="100%"><p style="text-align: right;">E</p></td>
                                        </tr>
                                        <tr>
                                            <td height="20px" width="100%"></td>
                                        </tr>
                                        <tr>
                                            <td height="20px" width="100%"></td>
                                        </tr>
                                    </table>
                                </td>
                                <td width="10%">
                                    <table border="1" style="border-style: solid;">
                                        <tr>
                                            <td height="20px" width="100px"></td>
                                        </tr>
                                        <tr>
                                            <td height="20px" width="100px"></td>
                                        </tr>
                                        <tr>
                                            <td height="20px" width="100px"></td>
                                        </tr>
                                        <tr>
                                            <td height="20px" width="100px"></td>
                                        </tr>
                                        <tr>
                                            <td height="20px" width="100px"></td>
                                        </tr>
                                    </table>
                                </td>
                                <td width="40%">
                                    <table>
                                        <tr>
                                            <td height="20px" width="100%"><p>Kondisi BBM Saat berangkat:</p></td>
                                        </tr>
                                        <tr>
                                            <td height="20px" width="100%"></td>
                                        </tr>
                                        <tr>
                                            <td height="20px" width="100%"></td>
                                        </tr>
                                        <tr>
                                            <td height="20px" width="100%"></td>
                                        </tr>
                                        <tr>
                                            <td height="20px" width="100%"></td>
                                        </tr>
                                    </table>
                                    
                                </td>
                                <td width="10%">
                                    <table border="1" style="border-style: solid;">
                                        <tr>
                                            <td height="20px" width="100px"></td>
                                        </tr>
                                        <tr>
                                            <td height="20px" width="100px"></td>
                                        </tr>
                                        <tr>
                                            <td height="20px" width="100px"></td>
                                        </tr>
                                        <tr>
                                            <td height="20px" width="100px"></td>
                                        </tr>
                                        <tr>
                                            <td height="20px" width="100px"></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>                     
                        <br>
                        <br>
                        <br>
                        <p>Demikian Berita acara peminjaman ini dibuat dengan penuh rasa tanggung jawab.</p>
                        <br>
                        <br>
                        <br>
            <table style="width:100%;">
                <tr>
                    <td>
                        <table>
                            <tr>
                                <td>
                                    <p class="center">PIHAK KESATU</p>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <p class="center">Kasubag Tata Usaha</p>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <br>
                                    <br>
                                    <br>
                                    <br>
                                    <br>
                                    <p class="center">(Gita Wirantika, S.E., MM)</p>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <p class="center">Nip. 19810125 201101 2 002</p>
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table>
                            <tr>
                                <td>
                                    <p class="center">Mengetahui</p>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <p class="center">Pengadministrasi Umum</p>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <br>
                                    <br>
                                    <br>
                                    <br>
                                    <br>
                                    <p class="center">(Cucun Suherman)</p>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <p class="center">Nip. 19810908 200801 1 002</p>
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table>
                            <tr>
                                <td>
                                    <p class="center">PIHAK KEDUA</p>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <p class="center"><?php echo $this->m_mobil->get_nama_jabatan($row->peminjam); ?></p>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <br>
                                    <br>
                                    <br>
                                    <br>
                                    <br>
                                    <p class="center">(<?php echo $this->m_mobil->get_nama_user($row->peminjam); ?>)</p>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <?php
                                    $nip = $this->m_mobil->get_penerima_nip($row->peminjam);
                                        if($nip != '-'){
                                    ?>
                                    <p class="center">NIP. <?php echo $this->m_mobil->get_penerima_nip($row->peminjam); ?></p>
                                    <?php
                                        }else{
                                    ?>
                                    <p class="center">NIP. <?php echo $this->m_mobil->get_penerima_nik($row->peminjam); ?></p>
                                    <?php
                                        }
                                    ?>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>




                    <?php } ?>

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