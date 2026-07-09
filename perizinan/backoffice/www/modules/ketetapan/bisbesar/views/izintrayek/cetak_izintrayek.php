<style>
body{
  font-family: "Arial", Helvetica, sans-serif;
  font-size : 12px;
  
}
table {
  font-family: "Arial", Helvetica, sans-serif;
  font-size : 12px;
  
    border-collapse: collapse;

}
td,th{
   padding-left:5px;
   padding-right:5px;
}
.bold{
  font-weight: bold;
}
.kepalaright {
  width:400px;
  overflow:hidden;
  text-align: center;
  float:right;

}

.logo{
  width: 100px;
  height: 100px;
  float:left;
  margin-left:30px;
}
.judul{
  width:650px;
  overflow:hidden;
  float:left;
  margin:10px;
}
.underline{
  text-decoration: underline;;
}
@media print {
    #with_print {
        display: none;
    }
    @page { size: US-Legal landscape; margin: 0.4in }
}
</style>

<script>
  function close_window() {
  if (confirm("Keluar dari halaman ini ?")) {
    close();
  }
}
</script>


<button onclick="window.print()"  id="with_print" >Print</button>
<button onclick="close_window()"  id="with_print">Keluar</button>
<br><div class="judul">
<div class="logo"><img src="<?php echo base_url().'assets/images/icon/Logo_tasikmalaya_Clr.png' ?>" width="80%" height="90%"></div>

<!--<br>
<center class= "bold">LAMPIRAN KEPUTUSAN DINAS PENANAMAN MODAL DAN PELAYANAN TERPADU<br> SATU PINTU PROVINSI TASIKMALAYA </center> 
<br>-->


<?php 

function tanggal_indo($tanggal)
{
  $bulan = array (1 =>   'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember'
      );
  $split = explode('-', $tanggal);
  return $split[2] . ' ' . $bulan[ (int)$split[1] ] . ' ' . $split[0];
}

//echo tanggal_indo('2016-03-20');

$NO_SK = "";
$TG_SK = "";
$BERLAKU = "";
$NAMA_PERUS ="";
$PEMILIK = "";
$ALAMAT_PEM ="";
$ALAMAT_PER = "";
$NO_IP = "";
$BERLAKU = "";
$KETERANGAN ="";

$i=1;
foreach($bb_izintrayek as $u){
 $NO_SK =  $u->NO_SK;
 $TG_SK = $u->TG_SK;
 $BERLAKU = $u->BERLAKU;
 $NAMA_PERUS = $u->NAMA_PERUS;
 $PEMILIK = $u->PEMILIK;
 $ALAMAT_PEM = $u->ALAMAT_PEM;
 $ALAMAT_PER = $u->ALAMAT_PER;
 $NO_IP = $u->NO_IP;
 $BERLAKU =$u->BERLAKU;
 $KETERANGAN = $u->KETERANGAN;
}
 ?>

             <!--<label>Nomor &nbsp;&nbsp;&nbsp;</label> : &nbsp;&nbsp;&nbsp;<?php echo $NO_SK; ?>
             <br/>
              <label>Tanggal &nbsp;</label> : &nbsp;&nbsp;&nbsp;<?php echo $TG_SK;?> <!--s/d <?php echo $BERLAKU;?>-->
               <!--<br/>
            <label>Tentang &nbsp;</label> : &nbsp;&nbsp;&nbsp;Izin Trayek Angkutan Penumpang Umum di Wilayah Kabupaten Tasikmalaya
</div>
             <br style="clear: both" />-->
<?php echo br(9);?>
             <center class= "bold">KEPUTUSAN
 <br style="clear: both" />
  <br style="clear: both" />
 KEPALA DINAS PENANAMAN MODAL DAN PELAYANAN TERPADU SATU PINTU PROVINSI TASIKMALAYA<br>
 NOMOR : <?php echo $NO_SK; ?>
             </center>
             <br>
             <center>TENTANG</center>
              <br style="clear: both" />
              <center>IZIN TRAYEK / IZIN OPERASI ANGKUTAN PENUMPANG UMUM<br>
             DI WILAYAH PROVINSI TASIKMALAYA</center>
         
 <br style="clear: both" />
 <table>
   <tr>
    <td> Menimbang</td>
    <td> a. </td>
    <td>Bahwa Pelayanan angkutan orang dengan kendaraan umum wajib memiliki izin trayek atau izin operasi;
    </td>
     </tr>
     <tr>
    <td></td>
    <td> b. </td>
    <td>
        Bahwa izin trayek atau izin operasi sebagaimana dimaksud huruf (a) diatas diberikan dalam bentuk Keputusan Kepala Dinas Penanaman Modal dan Pelayanan Terpadu Satu Pintu Kabupaten Tasikmalaya
    </td>
   </tr>

    <tr>
    <td>Mengingat</td>
    <td> 1. </td>
    <td>Peraturan Pemerintah Republik Indonesia Nomor 74 Tahun 2014 Tentang Angkutan Jalan;</td>
   </tr>
   <tr>
    <td></td>
    <td> 2. </td>
    <td>Keputusan Menteri Perhubungan Nomor KM.35 Tahun 2003 Tentang Penyelenggaraan Angkutan Orang Di Jalan dengan Kendaraan Umum;</td>
   </tr>
   <tr>
    <td></td>
    <td> 3. </td>
    <td>Peraturan Daerah Kabupaten Tasikmalaya Nomor 7 Tahun 2010 Tentang Penyelenggaraan Pelayanan Perizinan Terpadu;</td>
   </tr>
   <tr>
    <td></td>
    <td> 4. </td>
    <td>Peraturan Daerah Kabupaten Tasikmalaya Nomor 3 Tahun 2011 Tentang Penyelenggaraan Perhubungan;</td>
   </tr>
   <tr>
    <td></td>
    <td> 5. </td>
    <td>Peraturan Daerah Kabupaten Tasikmalaya Nomor 14 Tahun 2011 Tentang Retribusi Daerah;</td>
   </tr>
   <tr>
    <td></td>
    <td> 6. </td>
    <td>Peraturan Daerah Kabupaten Tasikmalaya Nomor 4 Tahun 2014 Tentang Perubahan Kedua atas Peraturan Daerah Kabupaten Tasikmalaya Nomor 24 Tahun 2009 Tentang Organisasi dan Tata Kerja Lembaga Lain Kabupaten Tasikmalaya;</td>
   </tr>
   <tr>
    <td></td>
    <td> 7. </td>
    <td>Peraturan Gubernur Kabupaten Tasikmalaya Nomor 47 Tahun 2006 Tentang Penyelenggaraan Angkutan Orang Di Jalan Dengan Kendaraan Umum;</td>
   </tr>
   <tr>
    <td></td>
    <td> 8. </td>
    <td>Peraturan Gubernur Kabupaten Tasikmalaya Nomor 31 Tahun 2016 tentang Petunjuk Pelaksanaan Perturan Daerah Kabupaten Tasikmalaya Nomor 7 Tahun 2010 Tentang Penyelenggaraan Pelayanan Perizinan Terpadu;</td>
   </tr>


   <tr>
    <td>Memperhatikan </td>
    <td> a. </td>
    <td> Surat Permohonan</td>
   </tr>

    <tr>
    <td> </td>
    <td> b. </td>
    <td> Surat Ketua Tim Teknis Bidang Perhubungan Darat Nomor <?php echo $NO_SK; ?></td>
   </tr>
   <td> </td>
    <td></td>
    <td>Tanggal <?php echo tanggal_indo($TG_SK);?></td>
   </tr>
 </table>
 <br style="clear: both" />
 &nbsp;&nbsp;MEMUTUSKAN
 <table border="0">

   <tr>
   <td width="90px">Menetapkan</td>
    <td>:</td>
    <td>KEPUTUSAN KEPALA DINAS PENANAMAN MODAL DAN PELAYANAN TERPADU SATU PINTU PROVINSI TASIKMALAYA TENTANG IZIN TRAYEK/OPERASI ANGKUTAN PENUMPANG UMUM DIWILAYAH PROVINSI TASIKMALAYA.</td>
   </tr>
   </table>
   <table border="0" width="100%">
 <tr>
 <th width="90px"></th>
  <th  width="4px"></th>
   <th colspan="3"></th>
 </tr>
    <tr>
   <td>PERTAMA</td>
    <td>:</td>
    <td width="150px" align="left">Nama Perusahaan</td>
    <td  width="10px">:</td>
    <td><?php echo $NAMA_PERUS;?></td>
   </tr>
   <tr>
   <td></td>
    <td></td>
    <td width="150px" align="left">Nama Pimp. Perusahaan</td>
    <td  width="10px">:</td>
    <td><?php echo $PEMILIK;?></td>
   </tr>
   <tr>
   <td></td>
    <td></td>
    <td width="150px" align="left">Alamat Perusahaan</td>
    <td  width="10px">:</td>
    <td><?php echo $ALAMAT_PER;?></td>
   </tr>
    <tr>
   <td></td>
    <td></td>
    <td width="150px" align="left">Alamat Pimp. Perusahaan</td>
    <td  width="10px">:</td>
    <td><?php echo $ALAMAT_PEM;?></td>
   </tr>
      <tr>
   <td></td>
    <td></td>
    <td width="150px" align="left">Nomor Induk Perusahaan</td>
    <td  width="10px">:</td>
    <td><?php echo $NO_IP;?></td>
   </tr>
   <tr>
   <td></td>
    <td></td>
    <td width="150px" align="left">Masa Berlaku Izin</td>
    <td  width="10px">:</td>
    <td><?php echo tanggal_indo($BERLAKU);?></td>
   </tr>
   <tr>
   <td></td>
    <td></td>
    <td width="150px" align="left">Keterangan</td>
    <td  width="10px">:</td>
    <td><?php echo $KETERANGAN;?></td>
   </tr>
 </table>
 <table border="0">

   <tr>
   <td width="90px">KEDUA</td>
    <td>:</td>
    <td>Rincian / daftar kode trayek, data kendaraan dan jenis pelayanan dalam Diktum Pertama sebagaimana terlampir;</td>
   </tr>
    <tr>
   <td width="90px">KETIGA</td>
    <td>:</td>
    <td>Mewajibkan kepada pemegang Izin Trayek / Izin Opersi pada Diktum Pertama untuk memenuhi ketentuan sebagaimana tercantum dibalik keputasan ini;</td>
   </tr>
    <tr>
   <td width="90px">KEEMPAT</td>
    <td>:</td>
    <td>untuk kepentingan pembinaan, pengawasan, dan pengendalian lapangan dilakukan oleh Dinas Perhubungan Kabupaten Tasikmalaya;</td>
   </tr>
      <tr>
   <td width="90px">KELIMA</td>
    <td>:</td>
    <td>Keputusan ini mulai berlaku pada tanggal ditetapkan dengan ketentuan akan diubah dan / atau diperbaiki sebagaimana mestinya apabila dipandang perlu.</td>
   </tr>
   </table>
   <br style="clear: both" /><br style="clear: both" />
   <div class="kepalaright" style="text-align: left;">
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Ditetapkan &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: Tasikmalaya
  <br>
  &nbsp;&nbsp;&nbsp;&nbsp; Pada Tanggal : <?php echo tanggal_indo($TG_SK);?>
   </div>
   <br style="clear: both" />
    <div class="kepalaright" style="text-align: left; border-bottom: 1px solid black;margin-top: 5px;"></div>
    <br style="clear: both" />
  <div class="kepalaright ">KEPALA BADAN PENANAMAN MODAL DAN PERIJINAN TERPADU <br> PROVINSI TASIKMALAYA

<br>
<br>
<br>
<br>
<br>
<br>
<br>
  <div class="bold underline">Dr. Ir. H. DADANG MOHAMMAD, MSCE</div>
<div class="bold">Pembina Utama Madya
<br>NIP 19601217 196511 1 002</div>
  </div>

