<?php 

header("Content-type: application/octet-stream");

header("Content-Disposition: attachment; filename=$title.xls");

header("Pragma: no-cache");

header("Expires: 0");

// echo "<table width='100%' border='0' font-size:16px;'>";
//     echo $jdl_laporan;
//     echo "<tr>PERIODE : ".$this->lib_date->mysql_to_human($tgla)." - ".$this->lib_date->mysql_to_human($tglb)."</tr>";
//     echo "</table>";
?>

<table border="1" width="100%">
    <thead>
        <tr>
            <th rowspan="3">NO</th>
            <th rowspan="3">SASARAN STRATEGIS RPJMD</th>
            <th rowspan="3">IKU GUBERNUR</th>
            <th rowspan="3">TARGET</th>
            <th rowspan="3">SATUAN</th>
            <th rowspan="3">SASARAN STRATEGIS<br>PERANGKAT DAERAH</th>
            <th rowspan="3">INDIKATOR KINERJA</th>
            <th rowspan="3">TARGET</th>
            <th rowspan="3">SATUAN</th>
            <th colspan="4">TARGET PERTRIWULAN</th>
            <th rowspan="3">NO</th>
            <th rowspan="3">PENGAMPU OUTCOME<br>/ KETUA TIM</th>
            <th rowspan="3">NAMA<br>TIM OF TIM</th>
            <th rowspan="3">URUTAN<br>TIM OF TIM</th>
            <th rowspan="3">ANGGARAN TIM OF TIM</th>
            <th rowspan="3">NAMA ANGGOTA TIM OF TIM</th>
            <th rowspan="3">NO</th>
            <th rowspan="3">SASARAN PROGRAM<br>/KEGIATAN<br>/SUB KEGIATAN (TOT)</th>
            <th rowspan="3">NO</th>
            <th rowspan="3">INDIKATOR KINERJA</th>
            <th rowspan="3">JUMLAH TARGET<br>PER-TAHUN</th>
            <th rowspan="3">SATUAN</th>
            <th colspan="12">JUMLAH TARGET KINERJA PER BULAN</th>
            <th colspan="12">JUMLAH REALISASI KINERJA PER BULAN</th>
            <th rowspan="3">NO</th>
            <th rowspan="3">AKTIVITAS / RENCANA AKSI<br>(ROW DAPAT DITAMBAH SESUAI BANYAKNYA AKTIVITAS)</th>
            <!-- <th rowspan="3">INDIKATOR AKTIVITAS<br>/RENCANA AKSI</th> -->
            <th rowspan="3">JUMLAH TARGET<br>RENCANA AKSI PER-TAHUN</th>
            <th rowspan="3">SATUAN</th>
            <th colspan="12">JUMLAH TARGET RENCANA AKSI PER-BULAN</th>
            <th colspan="12">JUMLAH REALISASI RENCANA AKSI PER-BULAN</th>
        </tr>
        <tr>
            <th rowspan="2">TW I</th>
            <th rowspan="2">TW II</th>
            <th rowspan="2">TW III</th>
            <th rowspan="2">TW IV</th>
            <th colspan="3">TW I</th>
            <th colspan="3">TW II</th>
            <th colspan="3">TW III</th>
            <th colspan="3">TW IV</th>
            <th colspan="3">TW I</th>
            <th colspan="3">TW II</th>
            <th colspan="3">TW III</th>
            <th colspan="3">TW IV</th>
            <th colspan="3">TW I</th>
            <th colspan="3">TW II</th>
            <th colspan="3">TW III</th>
            <th colspan="3">TW IV</th>
            <th colspan="3">TW I</th>
            <th colspan="3">TW II</th>
            <th colspan="3">TW III</th>
            <th colspan="3">TW IV</th>

        </tr>
        <tr>
            <th>1</th>
            <th>2</th>
            <th>3</th>
            <th>4</th>
            <th>5</th>
            <th>6</th>
            <th>7</th>
            <th>8</th>
            <th>9</th>
            <th>10</th>
            <th>11</th>
            <th>12</th>
            <th>1</th>
            <th>2</th>
            <th>3</th>
            <th>4</th>
            <th>5</th>
            <th>6</th>
            <th>7</th>
            <th>8</th>
            <th>9</th>
            <th>10</th>
            <th>11</th>
            <th>12</th>
            <th>1</th>
            <th>2</th>
            <th>3</th>
            <th>4</th>
            <th>5</th>
            <th>6</th>
            <th>7</th>
            <th>8</th>
            <th>9</th>
            <th>10</th>
            <th>11</th>
            <th>12</th>
            <th>1</th>
            <th>2</th>
            <th>3</th>
            <th>4</th>
            <th>5</th>
            <th>6</th>
            <th>7</th>
            <th>8</th>
            <th>9</th>
            <th>10</th>
            <th>11</th>
            <th>12</th>
        </tr>
    </thead>
    <tbody>
       
<?php $i=1; $x=1;$prev_sasaran_program = "";
foreach($pakai as $pakai) { ?>
<tr>
 <td><?php echo $i; ?></td>
 <td>Meningkatnya Nilai Investasi dan Kualitas usaha yang disertai dengan meningkatnya daya saing dan penempatan Tenaga Kerja</td>
 <td>Pembentukan Modal Tetap Bruto (PMTB) ADHB</td>
 <td>532,22</td>
 <td>Trilyun</td>
 <td>Meningkatnya realisasi investasi</td>
 <td>Nilai realisasi investasi</td>
 <td>176,31</td>
 <td>Trilyun Rupiah</td>
 <td>44,08</td>
 <td>44,08</td>
 <td>44,08</td>
 <td>44,08</td>
 <td>I</td>
 <td><?php echo $this->m_renaksi->get_pengampu($pakai->pengampu).'<br>'.$this->m_renaksi->get_ketua($pakai->ketua);?></td> 
 <td>1</td>
 <td><?php echo $pakai->nama_tim;?></td>
 <td><?php echo $pakai->anggaran;?></td>
 <td><?php
            $no = 1;
            $nono = 1;
            // $anggota1 = explode('^', $row->anggota);
            // foreach ($anggota1 as $data1){
            //   echo $nono.'. '.$this->m_renaksi->get_n_pegawai($data1).'<br>';
            //       $nono++; 
            // }
            $anggota = $this->m_renaksi->get_anggota_tim2($pakai->id);
                foreach ($anggota as $data){
                  echo $no.'. '.$this->m_renaksi->get_n_pegawai($data->id_pegawai).'<br>';
                  $no++; 
                }
              ?>
            </td>
 <?php if ($pakai->sasaran_program != $prev_sasaran_program) {
        $x = 1; } ?>
 <td><?php echo $x; ?></td>
 <td><?php echo $pakai->sasaran_program;?></td>
 <td>1</td>
 <td><?php echo $pakai->indikator_program;?></td>
 <td><?php echo $pakai->target_tahun;?></td>
 <td><?php echo $pakai->satuan;?></td>
 <td><?php echo $pakai->t1;?></td>
 <td><?php echo $pakai->t2;?></td>
 <td><?php echo $pakai->t3;?></td>
 <td><?php echo $pakai->t4;?></td>
 <td><?php echo $pakai->t5;?></td>
 <td><?php echo $pakai->t6;?></td>
 <td><?php echo $pakai->t7;?></td> 
 <td><?php echo $pakai->t8;?></td>
 <td><?php echo $pakai->t9;?></td>
 <td><?php echo $pakai->t10;?></td>
 <td><?php echo $pakai->t11;?></td>
 <td><?php echo $pakai->t12;?></td>
 <td><?php echo $pakai->r1;?></td>
 <td><?php echo $pakai->r2;?></td>
 <td><?php echo $pakai->r3;?></td>
 <td><?php echo $pakai->r4;?></td>
 <td><?php echo $pakai->r5;?></td>
 <td><?php echo $pakai->r6;?></td>
 <td><?php echo $pakai->r7;?></td>
 <td><?php echo $pakai->r8;?></td>
 <td><?php echo $pakai->r9;?></td>
 <td><?php echo $pakai->r10;?></td>
 <td><?php echo $pakai->r11;?></td>
 <td><?php echo $pakai->r12;?></td>
 <td>1</td> 
 <td><?php echo $pakai->sasaran_renaksi;?></td>
 <td><?php echo $pakai->target_aktivitas;?></td>
 <td><?php echo $pakai->satuan;?></td>
  <?php
            $bulan = date('n', strtotime($pakai->tgl_rencana)); // Ambil bulan dari tanggal_rencana
            for ($j = 1; $j <= 12; $j++) {
                if ($j == $bulan) {
                    echo "<td>" . $pakai->tgl_rencana . "</td>";
                } else {
                    echo "<td></td>"; // Jika bukan bulan yang ditentukan, biarkan sel kosong
                }
            }
    ?>
<!--     <?php
            if (!empty($pakai->tgl_realiasai)) {
                $bulan = date('n', strtotime($pakai->tgl_realiasai)); // Mendapatkan bulan dari tanggal rencana
                for ($b = 1; $b <= 12; $b++) {
                    if ($bulan == $b) {
                        echo "<td>" . $pakai->tgl_realiasai . "</td>";
                    } else {
                        echo "<td></td>";
                    }
                }
            } else {
                // Jika tanggal rencana kosong, menampilkan sel kosong di semua kolom
                for ($b = 0; $b < 12; $b++) {
                    echo "<td></td>";
                }
            }
            ?> -->

    <?php
            if ($pakai->tgl_realisasi != '0000-00-00') {
            $bulan = date('n', strtotime($pakai->tgl_realisasi)); // Ambil bulan dari tanggal_rencana
            for ($b = 1; $b <= 12; $b++) {
                if ($b == $bulan) {
                    echo "<td>" . $pakai->tgl_realisasi . "</td>";
                } else {
                    echo "<td></td>"; // Jika bukan bulan yang ditentukan, biarkan sel kosong
                }
            }
        }
        else {
                // Jika tanggal rencana kosong, menampilkan sel kosong di semua kolom
                for ($b = 0; $b < 12; $b++) {
                    echo "<td></td>";
                }
            }
    ?>
<?php $prev_sasaran_program = $pakai->sasaran_program; $i++; $x++; } ?>

</tbody>

</table>