<?php
// application/models/Skm_model.php

defined('BASEPATH') or exit('No direct script access allowed');

class Skm_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    // ==== CRUD CORE ====
    public function insert()
    {
        $data = [
            // TODO: map field dari form add
            // 'field' => $this->input->post('field', true),
        ];
        return $this->db->insert('skm_survei', $data);
    }

    public function insert_variant()
    {
        $data = [
            // TODO: map field khusus varian
        ];
        return $this->db->insert('skm_survei', $data);
    }

    public function update($id)
    {
        $data = [
            // TODO: map field update
        ];
        return $this->db->where('id', $id)->update('skm_survei', $data);
    }

    public function delete_by_id($id)
    {
        return $this->db->where('id', $id)->delete('skm_survei');
    }

    // ==== VIEW PROVIDERS (pengganti doAdd_fnc, doEdit_fnc, dll) ====
    public function get_form_add()
    {
        // Bisa return HTML siap render, atau array utk blade-like parser
        // Demi kompatibilitas cepat, return string HTML sederhana.
        return $this->load->view('skm/partials/form_add', [], true);
    }

    public function get_form_add1()
    {
        return $this->load->view('skm/partials/form_add1', [], true);
    }

    public function get_form_edit($id)
    {
        $row = $this->db->get_where('skm_survei', ['id' => $id])->row();
        return $this->load->view('skm/partials/form_edit', ['row' => $row], true);
    }

    public function get_detail_list($id)
    {
        // TODO: ambil list/relasi detail
        $rows = $this->db->get_where('skm_penawaran', ['survei_id' => $id])->result();
        return $this->load->view('skm/partials/detail_list', ['rows' => $rows], true);
    }

    public function search_view($keyword = null)
    {
        if ($keyword) {
            $this->db->like('nama', $keyword);
            $this->db->or_like('keterangan', $keyword);
        }
        $rows = $this->db->get('skm_survei')->result();
        return $this->load->view('skm/partials/search_list', ['rows' => $rows, 'keyword' => $keyword], true);
    }


    public function get_statistik_content()
    {
        // --- helpers kecil pengganti getBulan1/getBulan ---
        $getBulan1 = function ($bln) {
            // kembalikan nama bulan 3 huruf sesuai input 1-12
            $map = [1=>'Jan',2=>'Feb',3=>'Mar',4=>'Apr',5=>'May',6=>'Jun',7=>'Jul',8=>'Aug',9=>'Sep',10=>'Oct',11=>'Nov',12=>'Dec'];
            return isset($map[(int)$bln]) ? $map[(int)$bln] : 'Jan';
        };
        $getBulan = function ($nBulan3) {
            // ubah 3 huruf ke nama lengkap bhs Indo (optional)
            $map = ['Jan'=>'Januari','Feb'=>'Februari','Mar'=>'Maret','Apr'=>'April','May'=>'Mei','Jun'=>'Juni','Jul'=>'Juli','Aug'=>'Agustus','Sep'=>'September','Oct'=>'Oktober','Nov'=>'November','Dec'=>'Desember'];
            return isset($map[$nBulan3]) ? $map[$nBulan3] : $nBulan3;
        };

        // --- Ambil input GET aman ---
        $username = $this->input->get('code_list', true);
        $usernick = $this->input->get('name_list', true);
        $nTahun   = $this->input->get('thnskm', true);
        $idDinas  = $this->input->get('stsd', true);
        $token    = (int)$this->input->get('token', true);

        if (empty($nTahun)) $nTahun = date('Y');
        $dblnskg = 12;
        if ((string)$nTahun === date('Y')) $dblnskg = (int)date('m');
        $viewThn = (int)date('Y');

        // --- combobox Tahun ---
        $combothn  = '<select name="thnskm" method="GET" style="width:300px; height: 40px" readonly>';
        for ($i=0; $i<5; $i++) {
            $selected = ($viewThn == (int)$nTahun) ? ' selected' : '';
            $combothn .= '<option value="'.$viewThn.'"'.$selected.'>Tahun '.$viewThn.'</option>';
            $viewThn--;
        }
        $combothn .= '</select>';

        // --- combobox Perangkat Daerah (trunitkerja) ---
        $combobox = '<select name="stsd" method="GET" style="width:300px; height: 40px" readonly>';
        if ((int)$idDinas === 0) {
            $combobox .= '<option value="0" selected>-- Seluruh Perangkat Daerah --</option>';
        } else {
            $combobox .= '<option value="0">-- Seluruh Perangkat Daerah --</option>';
        }

        $qUnit = $this->db->query("
            SELECT DISTINCT t1.dinas_pengelola, t2.n_unitkerja
            FROM trperizinan t1
            INNER JOIN trunitkerja t2 ON t2.id = t1.dinas_pengelola
        ")->result_array();
        foreach ($qUnit as $row) {
            $id   = (int)$row['dinas_pengelola'];
            $nunitOpt = $row['n_unitkerja'];
            $sel  = ((int)$idDinas === $id) ? ' selected' : '';
            $combobox .= '<option value="'.$id.'"'.$sel.'>'.htmlspecialchars($nunitOpt, ENT_QUOTES, 'UTF-8').'</option>';
        }
        $combobox .= '</select>';

        // --- filter label & join tambahan bila stsd dipilih ---
        $nunit = 'Seluruh Perangkat Daerah';
        $cekDinas = '';
        $ceksektorJoin = ''; // join trsektor hanya kalau perlu (sebagian case lama)

        if (!empty($idDinas)) {
            $rowUnit = $this->db->get_where('trunitkerja', ['id' => (int)$idDinas])->row_array();
            if (!empty($rowUnit)) {
                $nunit = $rowUnit['n_unitkerja'];
                $cekDinas = ' AND t3.id = '.(int)$idDinas.' ';
                $ceksektorJoin = ' INNER JOIN trsektor t4 ON t4.id = t1.sektor ';
            }
        }

        // ===== Util: hitung NRR dari field data_skm_nilai =====
        $calcNRRFromDataSkm = function(array $rows) {
            $jumlahData = 0;
            $jumlahNilai = 0.0;
            foreach ($rows as $r) {
                $str = isset($r['data_skm_nilai']) ? $r['data_skm_nilai'] : '';
                // pad ke 10 komponen (sesuai logic lama)
                // lalu pecah dan rata-rata nilai!=0 dikali 25
                $str = substr($str, 0, 255);
                $parts = explode(',', $str);
                $vals = [];
                foreach ($parts as $p) {
                    $p = trim($p);
                    if ($p !== '' && $p != '0') {
                        $vals[] = (float)$p * 25.0;
                    }
                }
                if (!empty($vals)) {
                    $rata = array_sum($vals) / count($vals);
                    $jumlahData++;
                    $jumlahNilai += $rata;
                }
            }
            if ($jumlahData === 0) $jumlahData = 1;
            return $jumlahNilai / $jumlahData; // NRR
        };

        // ====== CASE builder per token ======
        // catatan: sebagian case lama pakai t1.rata. Kita konsisten pakai data_skm_nilai->konversi,
        // sesuai patch di kode lama (lebih akurat).
        $DataIKM = []; $DataIKMP = []; $DataIKM1=[]; $DataIKM2=[]; $DataIKM3=[]; $DataIKM4=[]; $DataIKM5=[]; $DataIKM6=[];
        $check1=$check2=$check3=$check4=$check5=$check6='';
        $DataAkhir = ''; $sektor_n = '';

        switch ($token) {
            case 1: // Jenis Kelamin
                $check1='checked';
                for ($d=1; $d<=12; $d++) {
                    $nBulan3 = $getBulan1($d);
                    $awal  = date('Y-m-01', strtotime('01-'.$nBulan3.'-'.$nTahun));
                    $akhir = date('Y-m-t',  strtotime('01-'.$nBulan3.'-'.$nTahun));

                    // Laki-laki
                    $sql = "
                        SELECT CONCAT(SUBSTRING_INDEX(t1.data_skm_nilai, ',', 10), ',0,0,0,0,0,0,0,0,0,0') AS data_skm_nilai
                        FROM skm_data_skm t1
                        LEFT JOIN trperizinan t2 ON t2.id = t1.jenis_ijin
                        LEFT JOIN trunitkerja t3 ON t3.id = t2.dinas_pengelola
                        {$ceksektorJoin}
                        WHERE DATE_FORMAT(t1.tgl_pengisian, '%Y-%m-%d') BETWEEN ? AND ?
                        AND t1.gender = '1' {$cekDinas}
                    ";
                    $rows = $this->db->query($sql, [$awal,$akhir])->result_array();
                    $DataIKM[] = number_format($calcNRRFromDataSkm($rows), 2, '.', '');

                    // Perempuan
                    $sql = "
                        SELECT CONCAT(SUBSTRING_INDEX(t1.data_skm_nilai, ',', 10), ',0,0,0,0,0,0,0,0,0,0') AS data_skm_nilai
                        FROM skm_data_skm t1
                        LEFT JOIN trperizinan t2 ON t2.id = t1.jenis_ijin
                        LEFT JOIN trunitkerja t3 ON t3.id = t2.dinas_pengelola
                        {$ceksektorJoin}
                        WHERE DATE_FORMAT(t1.tgl_pengisian, '%Y-%m-%d') BETWEEN ? AND ?
                        AND t1.gender = '2' {$cekDinas}
                    ";
                    $rows = $this->db->query($sql, [$awal,$akhir])->result_array();
                    $DataIKMP[] = number_format($calcNRRFromDataSkm($rows), 2, '.', '');
                }
                break;

            case 2: // Usia
                $check2='checked';
                $range = [
                    'DataIKM1' => 't1.usia < 17',
                    'DataIKM2' => 't1.usia BETWEEN 17 AND 25',
                    'DataIKM3' => 't1.usia BETWEEN 26 AND 35',
                    'DataIKM4' => 't1.usia BETWEEN 36 AND 45',
                    'DataIKM5' => 't1.usia BETWEEN 46 AND 55',
                    'DataIKM6' => 't1.usia BETWEEN 56 AND 65',
                ];
                for ($d=1; $d<=12; $d++) {
                    $nBulan3 = $getBulan1($d);
                    $awal  = date('Y-m-01', strtotime('01-'.$nBulan3.'-'.$nTahun));
                    $akhir = date('Y-m-t',  strtotime('01-'.$nBulan3.'-'.$nTahun));

                    foreach ($range as $key => $whereUsia) {
                        $sql = "
                            SELECT CONCAT(SUBSTRING_INDEX(t1.data_skm_nilai, ',', 10), ',0,0,0,0,0,0,0,0,0,0') AS data_skm_nilai
                            FROM skm_data_skm t1
                            LEFT JOIN trperizinan t2 ON t2.id = t1.jenis_ijin
                            LEFT JOIN trunitkerja t3 ON t3.id = t2.dinas_pengelola
                            {$ceksektorJoin}
                            WHERE DATE_FORMAT(t1.tgl_pengisian, '%Y-%m-%d') BETWEEN ? AND ?
                            AND {$whereUsia} {$cekDinas}
                        ";
                        $rows = $this->db->query($sql, [$awal,$akhir])->result_array();
                        $val  = number_format($calcNRRFromDataSkm($rows), 2, '.', '');
                        ${$key}[] = $val;
                    }
                }
                break;

            case 3: // Pendidikan
                $check3='checked';
                $pend = [
                    'DataIKM1' => "t1.pendidikan_id = '1'", // SD
                    'DataIKM2' => "t1.pendidikan_id = '2'", // SMP
                    'DataIKM3' => "t1.pendidikan_id = '3'", // SMA
                    'DataIKM4' => "t1.pendidikan_id = '4'", // Diploma
                    'DataIKM5' => "t1.pendidikan_id = '5'", // Sarjana
                    'DataIKM6' => "t1.pendidikan_id = '6'", // Pasca
                ];
                for ($d=1; $d<=12; $d++) {
                    $nBulan3 = $getBulan1($d);
                    $awal  = date('Y-m-01', strtotime('01-'.$nBulan3.'-'.$nTahun));
                    $akhir = date('Y-m-t',  strtotime('01-'.$nBulan3.'-'.$nTahun));

                    foreach ($pend as $key => $wherePend) {
                        $sql = "
                            SELECT CONCAT(SUBSTRING_INDEX(t1.data_skm_nilai, ',', 10), ',0,0,0,0,0,0,0,0,0,0') AS data_skm_nilai
                            FROM skm_data_skm t1
                            LEFT JOIN trperizinan t2 ON t2.id = t1.jenis_ijin
                            LEFT JOIN trunitkerja t3 ON t3.id = t2.dinas_pengelola
                            {$ceksektorJoin}
                            WHERE DATE_FORMAT(t1.tgl_pengisian, '%Y-%m-%d') BETWEEN ? AND ?
                            AND {$wherePend} {$cekDinas}
                        ";
                        $rows = $this->db->query($sql, [$awal,$akhir])->result_array();
                        $val  = number_format($calcNRRFromDataSkm($rows), 2, '.', '');
                        ${$key}[] = $val;
                    }
                }
                break;

            case 4: // Pekerjaan
                $check4='checked';
                $pek = [
                    'DataIKM1' => "t1.pekerjaan_id = '1'", // PNS/TNI/POLRI
                    'DataIKM2' => "t1.pekerjaan_id = '2'", // Pegawai Swasta
                    'DataIKM3' => "t1.pekerjaan_id = '3'", // Wirausaha
                    'DataIKM4' => "t1.pekerjaan_id = '4'", // Pelajar/Mahasiswa
                    'DataIKM5' => "t1.pekerjaan_id = '5'", // Lainnya
                ];
                for ($d=1; $d<=12; $d++) {
                    $nBulan3 = $getBulan1($d);
                    $awal  = date('Y-m-01', strtotime('01-'.$nBulan3.'-'.$nTahun));
                    $akhir = date('Y-m-t',  strtotime('01-'.$nBulan3.'-'.$nTahun));

                    foreach ($pek as $key => $wherePek) {
                        $sql = "
                            SELECT CONCAT(SUBSTRING_INDEX(t1.data_skm_nilai, ',', 10), ',0,0,0,0,0,0,0,0,0,0') AS data_skm_nilai
                            FROM skm_data_skm t1
                            LEFT JOIN trperizinan t2 ON t2.id = t1.jenis_ijin
                            LEFT JOIN trunitkerja t3 ON t3.id = t2.dinas_pengelola
                            {$ceksektorJoin}
                            WHERE DATE_FORMAT(t1.tgl_pengisian, '%Y-%m-%d') BETWEEN ? AND ?
                            AND {$wherePek} {$cekDinas}
                        ";
                        $rows = $this->db->query($sql, [$awal,$akhir])->result_array();
                        $val  = number_format($calcNRRFromDataSkm($rows), 2, '.', '');
                        ${$key}[] = $val;
                    }
                }
                break;

            case 5: // Sektor
                $check5='checked';
                $sektorRows = $this->db->query("SELECT id, n_sektor FROM trsektor")->result_array();
                $sektorLabels = [];
                foreach ($sektorRows as $sr) $sektorLabels[] = "'".$sr['n_sektor']."'";

                $DataIKMB = [];
                for ($d=1; $d<=12; $d++) {
                    $nBulan3 = $getBulan1($d);
                    $nmBulan = $getBulan($nBulan3);
                    $awal  = date('Y-m-01', strtotime('01-'.$nBulan3.'-'.$nTahun));
                    $akhir = date('Y-m-t',  strtotime('01-'.$nBulan3.'-'.$nTahun));

                    $DataIKMTemp = [];
                    foreach ($sektorRows as $sr) {
                        $sql = "
                            SELECT CONCAT(SUBSTRING_INDEX(t1.data_skm_nilai, ',', 10), ',0,0,0,0,0,0,0,0,0,0') AS data_skm_nilai
                            FROM skm_data_skm t1
                            LEFT JOIN trperizinan t2 ON t2.id = t1.jenis_ijin
                            LEFT JOIN trunitkerja t3 ON t3.id = t2.dinas_pengelola
                            {$ceksektorJoin}
                            WHERE DATE_FORMAT(t1.tgl_pengisian, '%Y-%m-%d') BETWEEN ? AND ?
                            AND t1.sektor = ? {$cekDinas}
                        ";
                        $rows = $this->db->query($sql, [$awal,$akhir,(int)$sr['id']])->result_array();
                        $val  = number_format($calcNRRFromDataSkm($rows), 2, '.', '');
                        $DataIKMTemp[] = $val;
                    }

                    $DataSKMB = implode(',', $DataIKMTemp);
                    $BLNS = $nmBulan.' '.$nTahun;
                    $DataIKMB[] = "{ name: '".$BLNS."', data: [".$DataSKMB."] }";
                }
                $DataAkhir = implode(',', $DataIKMB);
                $sektor_n  = implode(',', $sektorLabels);
                break;

            default: // Keseluruhan
                $check6='checked';
                for ($d=1; $d<=12; $d++) {
                    $nBulan3 = $getBulan1($d);
                    $awal  = date('Y-m-01', strtotime('01-'.$nBulan3.'-'.$nTahun));
                    $akhir = date('Y-m-t',  strtotime('01-'.$nBulan3.'-'.$nTahun));
                    $sql = "
                        SELECT CONCAT(SUBSTRING_INDEX(t1.data_skm_nilai, ',', 10), ',0,0,0,0,0,0,0,0,0,0') AS data_skm_nilai
                        FROM skm_data_skm t1
                        LEFT JOIN trperizinan t2 ON t2.id = t1.jenis_ijin
                        LEFT JOIN trunitkerja t3 ON t3.id = t2.dinas_pengelola
                        {$ceksektorJoin}
                        WHERE DATE_FORMAT(t1.tgl_pengisian, '%Y-%m-%d') BETWEEN ? AND ?
                        AND flag_skm = '1' {$cekDinas}
                    ";
                    $rows = $this->db->query($sql, [$awal,$akhir])->result_array();
                    $DataIKM[] = number_format($calcNRRFromDataSkm($rows), 2, '.', '');
                }
                break;
        }

        // ===== Rata2 IKM (sidebar) =====
        $JumlahNilai2 = 0.0;
        $DataIKM_RataBulanan = [];
        for ($d=1; $d<=12; $d++) {
            $nBulan3 = $getBulan1($d);
            $awal  = date('Y-m-01', strtotime('01-'.$nBulan3.'-'.$nTahun));
            $akhir = date('Y-m-t',  strtotime('01-'.$nBulan3.'-'.$nTahun));
            $sql = "
                SELECT CONCAT(SUBSTRING_INDEX(t1.data_skm_nilai, ',', 10), ',0,0,0,0,0,0,0,0,0,0') AS data_skm_nilai
                FROM skm_data_skm t1
                LEFT JOIN trperizinan t2 ON t2.id = t1.jenis_ijin
                LEFT JOIN trunitkerja t3 ON t3.id = t2.dinas_pengelola
                {$ceksektorJoin}
                WHERE DATE_FORMAT(t1.tgl_pengisian, '%Y-%m-%d') BETWEEN ? AND ?
                AND flag_skm = '1' {$cekDinas}
            ";
            $rows = $this->db->query($sql, [$awal,$akhir])->result_array();
            $NRR  = $calcNRRFromDataSkm($rows);
            $JumlahNilai2 += $NRR;
            $DataIKM_RataBulanan[] = number_format($NRR, 2, '.', '');
        }
        if ($dblnskg <= 0) $dblnskg = 1;
        $rataskm = $JumlahNilai2 / $dblnskg;

        // ===== Build HTML (persis pola lama) =====
        $strReturn = '
        <main id="general_page">
        <div class="container margin_60_35">
            <div class="row">
            <div class="col-lg-8">
                <div class="box_style_2">
                <center><img src="'.base_url('assets/images/skm.png').'" width="450" alt="SKM"></center>
                </div>
                <br>
                <script src="'.base_url('assets/chart/code/highcharts.js').'"></script>
                <script src="'.base_url('assets/chart/code/modules/series-label.js').'"></script>
                <script src="'.base_url('assets/chart/code/modules/exporting.js').'"></script>
                <script src="'.base_url('assets/chart/code/modules/export-data.js').'"></script>
                <div><div id="message-contact"></div><div id="container"></div></div>
            </div>
            <aside class="col-lg-4">
                <div class="box_style_2">
                <h4>Nilai IKM</h4>
                <p><center><font size="+5">'.number_format($rataskm,2).'</font></center></p>
                <hr class="styled">
                <h4>Tampil Data</h4>
                <p>
                    <form id="wrapped" method="GET" name="FRM1" enctype="multipart/form-data">
                    '.$combothn.$combobox.'
                    <div class="form-group radio_input">
                        <label class="container_radio">Jenis Kelamin
                        <input type="radio" name="token" value="1" '.$check1.'><span class="checkmark"></span>
                        </label>
                        <label class="container_radio">Usia
                        <input type="radio" name="token" value="2" '.$check2.'><span class="checkmark"></span>
                        </label>
                    </div>
                    <div class="form-group radio_input">
                        <label class="container_radio">Pendidikan
                        <input type="radio" name="token" value="3" '.$check3.'><span class="checkmark"></span>
                        </label>
                        <label class="container_radio">Pekerjaan
                        <input type="radio" name="token" value="4" '.$check4.'><span class="checkmark"></span>
                        </label>
                    </div>
                    <div class="form-group radio_input">
                        <label class="container_radio">Sektor
                        <input type="radio" name="token" value="5" '.$check5.'><span class="checkmark"></span>
                        </label>
                        <label class="container_radio">Keseluruhan
                        <input type="radio" name="token" value="6" '.$check6.'><span class="checkmark"></span>
                        </label>
                    </div>
                    <div id="bottom-wizard">
                        <button type="submit" name="proses" class="submit" value="tampil">Tampil Data</button>
                    </div>
                    </form>
                </p>
                <h4>Kontak Kami</h4>
                <p>
                    Jl. Windu No.26,<br>Kota Bandung, Jawa Barat 40263
                    <a href="#">info@dpmptsp.jabarprov.go.id</a>
                </p>
                </div>
            </aside>
            </div>
        </div>
        </main>
        ';

        // ===== Inject Highcharts sesuai token ====
        $cats = "'Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'";

        if ($token === 1) {
            $strReturn .= '
            <script>
            Highcharts.chart("container", {
            chart: { type: "column" },
            title: { text: "Per Jenis Kelamin" },
            subtitle: { text: "'.htmlspecialchars($nunit,ENT_QUOTES,'UTF-8').'<br>Tahun '.$nTahun.'" },
            xAxis: { categories: ['.$cats.'], crosshair: true },
            yAxis: { min: 0, title: { text: "Nilai Rata-Rata SKM" } },
            tooltip: { headerFormat:\'<span style="font-size:10px">{point.key}</span><table>\',
                        pointFormat:\'<tr><td style="color:{series.color};padding:0">{series.name}: </td><td style="padding:0"><b>{point.y:.1f} &nbsp;</b></td></tr>\',
                        footerFormat:\'</table>\', shared:true, useHTML:true },
            plotOptions: { column: { pointPadding:0.2, borderWidth:0 } },
            series: [{
                name: "Laki-Laki",
                data: ['.implode(',', $DataIKM).']
            }, {
                name: "Perempuan",
                data: ['.implode(',', $DataIKMP).']
            }]
            });
            </script>';
        } elseif ($token === 2) {
            $strReturn .= '
            <script>
            Highcharts.chart("container", {
            chart: { type: "column" },
            title: { text: "Per Rentang Usia" },
            subtitle: { text: "'.htmlspecialchars($nunit,ENT_QUOTES,'UTF-8').'<br>Tahun '.$nTahun.'" },
            xAxis: { categories: ['.$cats.'], crosshair: true },
            yAxis: { min: 0, title: { text: "Nilai Rata-Rata SKM" } },
            tooltip: { headerFormat:\'<span style="font-size:10px">{point.key}</span><table>\',
                        pointFormat:\'<tr><td style="color:{series.color};padding:0">{series.name}: </td><td style="padding:0"><b>{point.y:.1f} &nbsp;</b></td></tr>\',
                        footerFormat:\'</table>\', shared:true, useHTML:true },
            plotOptions: { column: { pointPadding:0.2, borderWidth:0 } },
            series: [
                { name:"0-16th",   data:['.implode(',', $DataIKM1).'] },
                { name:"17-25th",  data:['.implode(',', $DataIKM2).'] },
                { name:"26-35th",  data:['.implode(',', $DataIKM3).'] },
                { name:"36-45th",  data:['.implode(',', $DataIKM4).'] },
                { name:"46-55th",  data:['.implode(',', $DataIKM5).'] },
                { name:"56-65th",  data:['.implode(',', $DataIKM6).'] }
            ]
            });
            </script>';
        } elseif ($token === 3) {
            $strReturn .= '
            <script>
            Highcharts.chart("container", {
            chart: { type: "column" },
            title: { text: "Per Jenis Pendidikan" },
            subtitle: { text: "'.htmlspecialchars($nunit,ENT_QUOTES,'UTF-8').'<br>Tahun '.$nTahun.'" },
            xAxis: { categories: ['.$cats.'], crosshair: true },
            yAxis: { min: 0, title: { text: "Nilai Rata-Rata SKM" } },
            tooltip: { headerFormat:\'<span style="font-size:10px">{point.key}</span><table>\',
                        pointFormat:\'<tr><td style="color:{series.color};padding:0">{series.name}: </td><td style="padding:0"><b>{point.y:.1f} &nbsp;</b></td></tr>\',
                        footerFormat:\'</table>\', shared:true, useHTML:true },
            plotOptions: { column: { pointPadding:0.2, borderWidth:0 } },
            series: [
                { name:"SD",            data:['.implode(',', $DataIKM1).'] },
                { name:"SMP",           data:['.implode(',', $DataIKM2).'] },
                { name:"SMA",           data:['.implode(',', $DataIKM3).'] },
                { name:"DIPLOMA",       data:['.implode(',', $DataIKM4).'] },
                { name:"SARJANA",       data:['.implode(',', $DataIKM5).'] },
                { name:"PASCA SARJANA", data:['.implode(',', $DataIKM6).'] }
            ]
            });
            </script>';
        } elseif ($token === 4) {
            $strReturn .= '
            <script>
            Highcharts.chart("container", {
            chart: { type: "column" },
            title: { text: "Per Jenis Pekerjaan" },
            subtitle: { text: "'.htmlspecialchars($nunit,ENT_QUOTES,'UTF-8').'<br>Tahun '.$nTahun.'" },
            xAxis: { categories: ['.$cats.'], crosshair: true },
            yAxis: { min: 0, title: { text: "Nilai Rata-Rata SKM" } },
            tooltip: { headerFormat:\'<span style="font-size:10px">{point.key}</span><table>\',
                        pointFormat:\'<tr><td style="color:{series.color};padding:0">{series.name}: </td><td style="padding:0"><b>{point.y:.1f} &nbsp;</b></td></tr>\',
                        footerFormat:\'</table>\', shared:true, useHTML:true },
            plotOptions: { column: { pointPadding:0.2, borderWidth:0 } },
            series: [
                { name:"PNS/TNI/POLRI",        data:['.implode(',', $DataIKM1).'] },
                { name:"PEGAWAI SWASTA",       data:['.implode(',', $DataIKM2).'] },
                { name:"WIRASWASTA / USAHAWAN",data:['.implode(',', $DataIKM3).'] },
                { name:"PELAJAR / MAHASISWA",  data:['.implode(',', $DataIKM4).'] },
                { name:"LAINNYA",              data:['.implode(',', $DataIKM5).'] }
            ]
            });
            </script>';
        } elseif ($token === 5) {
            $strReturn .= '
            <script>
            Highcharts.chart("container", {
            chart: { type: "bar" },
            title: { text: "Data SKM per Sektor" },
            subtitle: { text: "'.htmlspecialchars($nunit,ENT_QUOTES,'UTF-8').'<br>Tahun '.$nTahun.'" },
            xAxis: { categories: ['.$sektor_n.'], title: { text: null } },
            yAxis: { min: 0, title: { text: "Nilai (SKM)", align: "high" }, labels:{ overflow:"justify" } },
            tooltip: { valueSuffix: " " },
            plotOptions: { bar: { dataLabels: { enabled: true } } },
            legend: { layout:"vertical", align:"right", verticalAlign:"top", x:-40, y:80, floating:true, borderWidth:1, backgroundColor:"#FFFFFF", shadow:true },
            credits: { enabled:false },
            series: ['.$DataAkhir.']
            });
            </script>';
        } else {
            // default keseluruhan (line)
            $strReturn .= '
            <script>
            Highcharts.chart("container", {
            chart: { type:"line" },
            title: { text: "Nilai SKM Perizinan Provinsi Jawa Barat " },
            subtitle: { text: "'.htmlspecialchars($nunit,ENT_QUOTES,'UTF-8').'<br>Tahun '.$nTahun.'" },
            xAxis: { categories: ['.$cats.'] },
            yAxis: { title: { text: "Nilai SKM DPMPTSP JABAR" } },
            plotOptions: { line: { dataLabels: { enabled:true }, enableMouseTracking:false } },
            series: [{ name:"IKM", data: ['.implode(',', $DataIKM).'] }]
            });
            </script>';
        }

        return $strReturn;
    }

}