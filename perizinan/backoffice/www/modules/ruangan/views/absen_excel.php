<table border="1" width="100%">
    <!-- Kop Surat -->

    <!-- Spasi kosong setelah kop surat -->
    <tr>
        <td colspan="4" style="height:20px;"></td>
    </tr>

    <!-- Header -->
    <tr>
        <th colspan="4" style="text-align:center;">DAFTAR HADIR</th>
    </tr>
    <tr>
        <td><strong>Hari / Tanggal</strong></td>
        <td colspan="3">
            : <?= $this->lib_date->get_day($data_acara->tanggal) . ' / ' . 
                 $this->lib_date->mysql_to_human($data_acara->tanggal) . 
                 "; " . $data_acara->waktu_awal . " - " . $data_acara->waktu_akhir ?>
        </td>
    </tr>
    <tr>
        <td><strong>Acara</strong></td>
        <td colspan="3">: <?= $data_acara->acara ?></td>
    </tr>
    <tr>
        <td><strong>Tempat</strong></td>
        <td colspan="3">
            : <?= $this->m_ruangan->get_nama($data_acara->id_ruangan) . ', ' . 
                 ($data_acara->keterangan ?: 'Lantai ' . $this->m_ruangan->get_lantai($data_acara->id_ruangan)) ?>
        </td>
    </tr>
    <tr>
        <td colspan="4"></td>
    </tr>

    <!-- Tabel Data -->
    <tr>
        <th style="text-align:center;">NO</th>
        <th style="text-align:center;">NAMA</th>
        <th style="text-align:center;">INSTANSI</th>
        <th style="text-align:center;">EMAIL</th>
        <th style="text-align:center;">NO TELP</th>
        <th style="text-align:center;">JABATAN</th>
        <!-- <th style="text-align:center;">TANDA TANGAN</th> -->
    </tr>
    <?php $no = 1; foreach ($data_absen as $row): ?>
    <tr>
        <td style="text-align:center;"><?= $no++ ?></td>
        <td><?= $row->nama ?></td>
        <td><?= $row->instansi ?></td>
        <td><?= $row->email ?></td>
        <td><?= $row->handphone ?></td>
        <td><?= $row->jabatan ?></td>
        <!-- <td></td> Kolom tanda tangan kosong -->
    </tr>
    <?php endforeach; ?>
</table>
