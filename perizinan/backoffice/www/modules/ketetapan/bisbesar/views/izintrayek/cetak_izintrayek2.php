<style>
body{
  font-family: "Arial", Helvetica, sans-serif;
  font-size : 12px;
  
}
table {
  font-family: "Arial", Helvetica, sans-serif;
  font-size : 11px;
  
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
#line{
  width:100%;
  float:left;
  border:1px solid black;
  margin-top: 10px;
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


<!--<button onclick="window.print()"  id="with_print" >Print</button>
<button onclick="close_window()"  id="with_print">Keluar</button>
<br><div class="judul">
<div class="logo"><img src="<?php echo base_url().'assets/images/icon/Logo_tasikmalaya_Clr.png' ?>" width="65%" height="65%"></div>


PEMERINTAH PROVINSI TASIKMALAYA<br> 
DINAS PENANAMAN MODAL DAN PELAYANAN TERPADU SATU PINTU
<br>
Jalan Sumatera Nomor 50 Telepon (022) 4237369 Faksimile (022) 4237081
<br>
Website : www.spekta.tasikmalayakab.go.id email : dpmptsp@tasikmalayakab.go.id
TASIKMALAYA - 40115-->

<table border="0" width="100%">
  <tr>
  <td width="15px"> </td>
    <td width="55px" height="60px" style="margin-left: 10px">
<img src="<?php echo base_url().'assets/images/icon/Logo_tasikmalaya_Clr.png' ?>" width="90%" height="100%">
    </td>
   
    <td style=" vertical-align: top;" align="">
   <center style="font-size : 16px; font-weight: bold;">PEMERINTAH PROVINSI TASIKMALAYA<br> 
DINAS PENANAMAN MODAL DAN PELAYANAN TERPADU SATU PINTU
<br>
</center><center style="font-size : 12px;">Jalan Sumatera Nomor 50 Telepon (022) 4237369 Faksimile (022) 4237081
<br>
Website : www.spekta.tasikmalayakab.go.id email : dpmptsp@tasikmalayakab.go.id
<br>TASIKMALAYA - 40115
</center>
   </td>
    <td width="1px"> </td>
   </tr>
   <tr><td colspan="4"><div id="line"> </div></td></tr>
   </table>

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
             <br style="clear: both" />
             <br style="clear: both" />
             <br style="clear: both" />
<?php echo br(0);?>
             <center  style="font-size : 14px;" class= "bold">KEPUTUSAN
 <br style="clear: both" />
  <br style="clear: both" /></center>
   <center  style="font-size : 12px;" class= "bold">
 KEPALA DINAS PENANAMAN MODAL DAN PELAYANAN TERPADU SATU PINTU PROVINSI TASIKMALAYA<br>
 NOMOR : <?php echo $NO_SK; ?>
             </center>
             <br>   <br>
             <center>TENTANG</center>
              <br style="clear: both" />
              <center>IZIN TRAYEK / IZIN OPERASI ANGKUTAN PENUMPANG UMUM<br>
             DI WILAYAH PROVINSI TASIKMALAYA</center>
         
 <br style="clear: both" />


 <table border="0" width="95%">
   <tr>
    <td width="50px"> Menimbang</td>
    <td> a. </td>
    <td colspan="3">Bahwa Pelayanan angkutan orang dengan kendaraan umum wajib memiliki izin trayek atau izin operasi;
    </td>
     </tr>
     <tr>
    <td></td>
    <td> b. </td>
    <td colspan="3">
        Bahwa izin trayek atau izin operasi sebagaimana dimaksud huruf (a) diatas diberikan dalam bentuk Keputusan Kepala Dinas Penanaman Modal dan Pelayanan Terpadu Satu Pintu Kabupaten Tasikmalaya
    </td>
   </tr>

    <tr>
    <td>Mengingat</td>
    <td width="5px"> 1. </td>
    <td colspan="3">Peraturan Pemerintah Republik Indonesia Nomor 74 Tahun 2014 Tentang Angkutan Jalan;</td>
   </tr>
   <tr>
    <td></td>
    <td width="5px"> 2. </td>
    <td colspan="3">Keputusan Menteri Perhubungan Nomor KM.35 Tahun 2003 Tentang Penyelenggaraan Angkutan Orang Di Jalan dengan Kendaraan Umum;</td>
   </tr>
   <tr>
    <td></td>
    <td width="5px"> 3. </td>
    <td colspan="3">Peraturan Daerah Kabupaten Tasikmalaya Nomor 7 Tahun 2010 Tentang Penyelenggaraan Pelayanan Perizinan Terpadu;</td>
   </tr>
   <tr>
    <td></td>
    <td width="5px"> 4. </td>
    <td colspan="3">Peraturan Daerah Kabupaten Tasikmalaya Nomor 3 Tahun 2011 Tentang Penyelenggaraan Perhubungan;</td>
   </tr>
   <tr>
    <td></td>
    <td width="5px"> 5. </td>
    <td colspan="3">Peraturan Daerah Kabupaten Tasikmalaya Nomor 14 Tahun 2011 Tentang Retribusi Daerah;</td>
   </tr>
   <tr>
    <td></td>
    <td width="5px" style="vertical-align: text-top;"> 6. </td>
    <td colspan="3">Peraturan Daerah Kabupaten Tasikmalaya Nomor 4 Tahun 2014 Tentang Perubahan Kedua atas Peraturan Daerah Kabupaten Tasikmalaya Nomor 24 Tahun 2009 Tentang Organisasi dan Tata Kerja Lembaga Lain Kabupaten Tasikmalaya;</td>
   </tr>
   <tr>
    <td></td>
    <td width="5px" style="vertical-align: text-top;"> 7. </td>
    <td colspan="3">Peraturan Gubernur Kabupaten Tasikmalaya Nomor 47 Tahun 2006 Tentang Penyelenggaraan Angkutan Orang Di Jalan Dengan Kendaraan Umum;</td>
   </tr>
   <tr>
    <td></td>
    <td width="5px" style="vertical-align: text-top;"> 8. </td>
    <td colspan="3">Peraturan Gubernur Kabupaten Tasikmalaya Nomor 31 Tahun 2016 tentang Petunjuk Pelaksanaan Perturan Daerah Kabupaten Tasikmalaya Nomor 7 Tahun 2010 Tentang Penyelenggaraan Pelayanan Perizinan Terpadu;</td>
   </tr>


   <tr>
    <td>Memperhatikan </td>
    <td width="5px"> a. </td>
    <td colspan="3"> Surat Permohonan</td>
 </tr>

    <tr>
    <td> </td>
    <td width="5px"> b. </td>
    <td colspan="3"> Surat Ketua Tim Teknis Bidang Perhubungan Darat Nomor <?php echo $NO_SK; ?></td>
   </tr>
   <tr>
   <td> </td>
    <td></td>
    <td colspan="3">Tanggal <?php echo tanggal_indo($TG_SK);?></td>
   </tr>
   <tr>
     <td colspan="5"><br>MEMUTUSKAN<br> <br></td>
   </tr>

   <tr>
    <td style="vertical-align: text-top;">Menetapkan </td>
    <td style="vertical-align: text-top;"> : </td>
    <td colspan="3"> KEPUTUSAN KEPALA DINAS PENANAMAN MODAL DAN PELAYANAN TERPADU SATU PINTU PROVINSI TASIKMALAYA TENTANG IZIN TRAYEK/OPERASI ANGKUTAN PENUMPANG UMUM DIWILAYAH PROVINSI TASIKMALAYA.</td>
 </tr>

 
 <tr>
    <td style="vertical-align: text-top;">PERTAMA </td>
    <td style="vertical-align: text-top;"> : </td>
    <td width="150px"> Nama Perusahaan</td>
    <td width="5px"> :</td>
    <td><?php echo $NAMA_PERUS;?> </td>
 </tr>

<tr>
    <td style="vertical-align: text-top;"> </td>
    <td style="vertical-align: text-top;">  </td>
    <td width="150px"> Nama Pimp. Perusahaan</td>
    <td width="5px"> :</td>
    <td><?php echo $PEMILIK;?> </td>
 </tr>

 <tr>
    <td style="vertical-align: text-top;"> </td>
    <td style="vertical-align: text-top;">  </td>
    <td width="150px"> Alamat Perusahaan</td>
    <td width="5px"> :</td>
    <td><?php echo $ALAMAT_PER;?> </td>
 </tr>
 <tr>
    <td style="vertical-align: text-top;"> </td>
    <td style="vertical-align: text-top;"> </td>
    <td width="150px"> Alamat Pimp. Perusahaan</td>
    <td width="5px"> :</td>
    <td><?php echo $ALAMAT_PEM;?> </td>
 </tr>
 <tr>
    <td style="vertical-align: text-top;"> </td>
    <td style="vertical-align: text-top;">  </td>
    <td width="150px"> Nomor Induk Perusahaan</td>
    <td width="5px"> :</td>
    <td><?php echo $NO_IP;?> </td>
 </tr>
 <tr>
    <td style="vertical-align: text-top;"> </td>
    <td style="vertical-align: text-top;">  </td>
    <td width="150px"> Masa Berlaku Izin</td>
    <td width="5px"> :</td>
    <td><?php echo tanggal_indo($BERLAKU);?> </td>
 </tr>
 <tr>
    <td style="vertical-align: text-top;"> </td>
    <td style="vertical-align: text-top;">  </td>
    <td width="150px"> Keterangan</td>
    <td width="5px"> :</td>
    <td><?php echo $KETERANGAN;?> </td>
 </tr>
 
  <tr>
    <td style="vertical-align: text-top;"> KEDUA </td>
    <td style="vertical-align: text-top;"> : </td>
    <td width="" colspan="3"> Rincian / daftar kode trayek, data kendaraan dan jenis pelayanan dalam Diktum Pertama sebagaimana terlampir;</td>
   
 </tr>
  <tr>
    <td style="vertical-align: text-top;"> KETIGA </td>
    <td style="vertical-align: text-top;"> : </td>
    <td width="" colspan="3"> Mewajibkan kepada pemegang Izin Trayek / Izin Opersi pada Diktum Pertama untuk memenuhi ketentuan sebagaimana tercantum dibalik keputasan ini;</td>
   
 </tr>
  <tr>
    <td style="vertical-align: text-top;"> KEEMPAT </td>
    <td style="vertical-align: text-top;"> : </td>
    <td width="" colspan="3"> Untuk kepentingan pembinaan, pengawasan, dan pengendalian lapangan dilakukan oleh Dinas Perhubungan Kabupaten Tasikmalaya;</td>
   
 </tr>
  <tr>
    <td style="vertical-align: text-top;"> KELIMA </td>
    <td style="vertical-align: text-top;"> : </td>
    <td width="" colspan="3"> Keputusan ini mulai berlaku pada tanggal ditetapkan dengan ketentuan akan diubah dan / atau diperbaiki sebagaimana mestinya apabila dipandang perlu.</td>
   
 </tr>
  <tr>
    <td style="vertical-align: text-top;">  </td>
    <td style="vertical-align: text-top;">  </td>
    <td></td>
    <td></td>
    <td width=""  align=""> 
    <br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
Ditetapkan &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
: Tasikmalaya
  <br>
  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  Pada Tanggal &nbsp;&nbsp;: <?php echo tanggal_indo($TG_SK);?>
  <u><center>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  </center></u>
    <br>
    <br>

<center>KEPALA BADAN PENANAMAN MODAL DAN PERIJINAN TERPADU <br> PROVINSI TASIKMALAYA

<br><br>
<img src="<?php echo base_url().'assets/images/icon/ttd.png' ?>" width="100px" height="40px">
<br>
  <u><b>Dr. Ir. H. DADANG MOHAMMAD, MSCE</b></u><br>
Pembina Utama Madya
<br>NIP 19601217 196511 1 002</center>
    </td>
   
 </tr>
 </table>













 <!--<table border="0">

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

