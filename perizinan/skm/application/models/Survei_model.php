<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Survei_model extends CI_Model
{
     protected $table = 'skm_data_skm'; // ganti kalau nama tabel beda

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Ambil list data dengan pagination & sorting.
     * - $oc: selector kolom order (dipetakan di map_oc_to_column)
     * - $ob: ASC|DESC
     * - $pg: halaman (1-based)
     * - $per_page: jumlah per halaman
     */
    public function get_list($oc = '1', $ob = 'ASC', $pg = 1, $per_page = 20)
    {
        $offset = max(0, ((int)$pg - 1) * (int)$per_page);
        $ob     = strtoupper($ob) === 'DESC' ? 'DESC' : 'ASC';

        // Tentukan kolom order dari parameter oc
        $order_col = $this->map_oc_to_column($oc);

        // Safety: kalau kolom nggak ada di tabel, fallback ke 'kode'
        if (!$this->column_exists($order_col)) {
            $order_col = 'kode';
        }

        return $this->db->from($this->table)
                        ->order_by($order_col, $ob)
                        ->limit((int)$per_page, (int)$offset)
                        ->get()
                        ->result();
    }

    /* =========================
       UTIL (pastikan HANYA ADA SEKALI)
       ========================= */

    /**
     * Map nilai 'oc' ke nama kolom riil.
     * Silakan sesuaikan mapping ini sama skema tabel kamu.
     */
    private function map_oc_to_column($oc)
    {
        $map = [
            '1' => 'kode',        // default order by 'kode'
            '2' => 'nama_buku',   // contoh kolom
            '3' => 'created_at',  // contoh kolom
        ];
        return isset($map[$oc]) ? $map[$oc] : 'kode';
    }

    /**
     * Cek apakah kolom ada di tabel.
     */
    private function column_exists($col)
    {
        if (!$col) return false;
        $fields = $this->db->list_fields($this->table);
        return in_array($col, $fields, true);
    }

    public function insert($payload)
    {
        // TODO: sesuaikan field
        return $this->db->insert($this->table, $payload);
    }

    public function insert_variant($payload)
    {
        // variasi insert (SurveiIns1.php)
        return $this->db->insert($this->table, $payload);
    }

    public function find($id)
    {
        return $this->db->get_where($this->table, ['id' => $id])->row();
    }

    public function update($id, $payload)
    {
        return $this->db->update($this->table, $payload, ['id' => $id]);
    }

    public function delete($id)
    {
        return $this->db->delete($this->table, ['id' => $id]);
    }

    public function search($q)
    {
        if ($q) {
            $this->db->like('nama_buku', $q);
            $this->db->or_like('kategory', $q);
            // tambahkan like lainnya sesuai kebutuhan
        }
        return $this->db->get($this->table)->result();
    }

    public function get_penawaran_list($survei_id)
    {
        // mapping dari VendorBarangPenawaranList.php
        return $this->db->get_where('vendor_penawaran', ['survei_id' => $survei_id])->result();
    }

    public function get_form_add()
    {
        // Bisa return HTML siap render, atau array utk blade-like parser
        // Demi kompatibilitas cepat, return string HTML sederhana.
        return $this->load->view('partial/survei_form', [], true);
    }
    public function build_add_form_html($resi, $sumber, $csrf_name, $csrf_hash)
    {
        // Amanin input minimal

        $resi   = trim((string)$resi);
        $sumber = trim((string)$sumber);

        // if ($resi === '') {
        //     return '<div class="alert alert-warning">Parameter CODE (resi/NIK) kosong.</div>';
        // }

        // === 1) Ambil data responden dari skm_data_skm ===
        $row = $this->db->select('t1.*, t2.*')
                    ->from('tmpemohon_portal AS t1')
                    ->join('tmpermohonan AS t2', 't1.id = t2.id_pemohon_portal', 'inner')
                    ->where('t2.pendaftaran_id', $resi)
                    ->limit(1)
                    ->get()
                    ->row_array();
        // var_dump($row);die();
        if ($resi != 'frontoffice') {
            if (!$row) {
                $tables = [
                    ['name' => 'public.pelayanan_gpt', 'telp' => 'no_wa'],
                    ['name' => 'public.pelayanan_gpt_4', 'telp' => 'no_wa'],
                    ['name' => 'public.pelayanan_gpt_11_4_2025', 'telp' => 'no_wa'],
                    ['name' => 'public.pelayanan_gpt_serambi', 'telp' => 'no_wa'],
                    ['name' => 'db_sicantik_backoffice.euis_bukutamu', 'telp' => 'telepon']
                ];

                foreach ($tables as $tbl) {
                    $res = $this->db->select('*')
                                    ->from($tbl['name'])
                                    ->where('nik', $resi)
                                    ->limit(1)
                                    ->get()
                                    ->row_array();

                    if ($res) {
                        $row = [
                            'namaPemohon' => isset($res['nama']) ? $res['nama'] : '',
                            'resi'        => isset($res['referensi']) ? $res['referensi'] : '',
                            'sektor'      => isset($res['trsektor_id']) ? $res['trsektor_id'] : '',
                            'telpPemohon' => isset($res[$tbl['telp']]) ? $res[$tbl['telp']] : '',
                            '_source_table' => $tbl['name'] // tambahkan informasi sumber tabel
                        ];
                        break;
                    }
                }
            }
        }
         
        // var_dump($row);die();
        // Tampilkan resi dan dari tabel mana datanya ditemukan
      


        
        // if (!$row) {
        //     return '<div class="alert alert-danger">Data SKM untuk resi/NIK <code>'.htmlspecialchars($resi, ENT_QUOTES, 'UTF-8').'</code> tidak ditemukan.</div>';
        // }

        // === 2) Ambil grup quis aktif ===
        $grup = $this->db->select('*')
                        ->from('skm_grup_quis')
                        ->where('status_quis', '2')
                        ->get()->result_array();

        // === 3) Bangun daftar pertanyaan (steps) ===
        $steps_html   = '';
        $q_index      = 0; // index global pertanyaan agar name radio unik
        $total_q      = 0; // total pertanyaan
        // var_dump($row);die();
        
        for ($i = 0; $i < count($grup); $i++) {
            $g = $grup[$i];
            $data_grup = explode(',', (string)$g['data_quis']);

            for ($ig = 0; $ig < count($data_grup); $ig++) {
                $kodeQ = trim($data_grup[$ig]);
                if ($kodeQ === '' || $kodeQ === '0') continue;

                // judul_quis
                $judul = $this->db->select('judul_quis')
                                ->from('skm_quisioner')
                                ->where('kode_quis', $kodeQ)
                                ->limit(1)->get()->row('judul_quis');
                if ($judul === null) $judul = 'Pertanyaan';

                // opsi jawaban (A..D) dari skm_pertanyaan
                $rowsA = $this->db->select('*')
                                ->from('skm_pertanyaan')
                                ->where('kode_quis', $kodeQ)
                                ->get()->result_array();

                $answers_html = '';
                for ($ix = 0; $ix < count($rowsA); $ix++) {
                    $rA = $rowsA[$ix];
                    $kodeA = 'D. ';
                    if ($ix === 0) $kodeA = 'A. ';
                    elseif ($ix === 1) $kodeA = 'B. ';
                    elseif ($ix === 2) $kodeA = 'C. ';

                    $answers_html .=
                        '<div class="form-group">'.
                            '<label class="container_radio version_2">'.
                                htmlspecialchars($kodeA.$rA['pertanyaan'], ENT_QUOTES, 'UTF-8').
                                '<input type="radio" name="question_'.($q_index).'" value="'.($ix+1).'" class="required" onchange="getVals(this, \'question_'.($q_index).'\');">'.
                                '<span class="checkmark"></span>'.
                            '</label>'.
                        '</div>';
                }

                $total_q++;
                // step num: 1 (data responden) + q_index+1 (pertanyaan ini)
                // total steps final = 1 + total_q + 1
                $steps_html .=
                    '<div class="step">'.
                        '<h3 class="main_question">'.
                            '<strong>'.(1 + $q_index + 1).'/__TOTAL_STEPS__</strong>'.
                            htmlspecialchars($judul, ENT_QUOTES, 'UTF-8').
                        '</h3>'.
                        $answers_html.
                    '</div>';

                $q_index++;
            }
        }

        $total_steps = 1 + $total_q + 1; // 1: data responden, N: pertanyaan, 1: saran/akhir
        // ganti placeholder __TOTAL_STEPS__ ke angka sebenarnya
        $steps_html = str_replace('__TOTAL_STEPS__', (string)$total_steps, $steps_html);

        // === 4) Options dropdown (pendidikan/pekerjaan/layanan) ===
        $pendidikan_options = $this->_select_options_plain('skm_pendidikan', 'kode_pendidikan', 'nama_pendidikan',
                                    isset($row['pendidikan_id']) ? $row['pendidikan_id'] : '');
        $pekerjaan_options  = $this->_select_options_plain('skm_pekerjaan', 'kode_pekerjaan', 'nama_pekerjaan',
                                    isset($row['pekerjaan_id']) ? $row['pekerjaan_id'] : '');
        $layanan_options    = $this->_select_options_plain('skm_layanan', 'kode_layanan', 'nama_layanan',
                                    isset($row['layanan_id']) ? $row['layanan_id'] : '');

        // === 5) Logic frontoffice untuk disable field resi1 ===
        $isDisabled = (strtolower($resi) !== 'frontoffice') ? 'disabled' : '';
        // === 6) Bangun HTML final (mengikuti struktur lama) ===
        // var_dump($row);die();
            $form_vals = $this->session->userdata('form_skm');

            if ($form_vals) {
                // masukkan ke data yang dikirim ke view
                $data['form_values'] = $form_vals;
                // kemudian hapus session itu agar tidak terus dipakai
                $this->session->unset_userdata('form_skm');
            } else {
                $data['form_values'] = [];  // default kosong
            }
                $error = $this->session->flashdata('error');
        $html  = "";


        $html .= '<div class="col-lg-6 content-right" id="start">';
        $html .= '  <div id="wizard_container">';
        $html .= '    <div id="top-wizard"><div id="progressbar"></div></div>';
        $html .= '    <form method="POST" enctype="multipart/form-data" action="'.site_url('survey/simpan').'">';
        if (!empty($error)) {
            $html .= '<div class="alert alert-danger">';
            $html .= htmlspecialchars($error); // aman dari XSS
            $html .= '</div>';
        }

        $html .= '      <input type="hidden" name="'.htmlspecialchars($csrf_name, ENT_QUOTES, 'UTF-8').'" value="'.htmlspecialchars($csrf_hash, ENT_QUOTES, 'UTF-8').'">';
        $html .= '<input type="hidden" name="sektor" value="'.
                    htmlspecialchars(isset($row['trsektor_id']) ? $row['trsektor_id'] : 'null', ENT_QUOTES, 'UTF-8').'">';
        $html .= '<input type="hidden" name="ijin" value="'.
                    htmlspecialchars(isset($row['izin']) ? $row['izin'] : 'null', ENT_QUOTES, 'UTF-8').'">';
        $html .= '<input type="hidden" name="permohonan_id" value="'.
                    htmlspecialchars(isset($row['id']) ? $row['id'] : '', ENT_QUOTES, 'UTF-8').'">';

        $html .= '      <input id="website" name="website" type="text" value="">';
        $html .= '      <div id="middle-wizard">';

        // Step 1: Data responden
        $html .= '        <div class="step">';
        $html .= '          <h3 class="main_question"><strong>1/'.(int)$total_steps.'</strong>Data Masyarakat (Responden)</h3>';
        $html .= '          <div class="form-group">';
        // ambil nilai CODE sekali saja
        $code = $this->input->get('CODE', TRUE);

        // if ($code !== 'frontoffice') {
        $html .= ' <input type="text" name="resi1" class="form-control"
            placeholder="Nomor Resi / NIK / NIB"
            value="' . htmlspecialchars(
                ($code === 'frontoffice')                      // 💡 cek dulu
                    ? ''                                       // kalau frontoffice, kosongin
                    : (
                        isset($row['referensi']) && $row['referensi'] !== ''
                            ? $row['referensi']
                            : $code
                    ),
                ENT_QUOTES,
                'UTF-8'
            ) . '" ' . $isDisabled . '>';

        // }


        $html .= '            <span for="nama" class="error" id="resi-error" style="display:none;"></span>';
        $html .= '            <input type="hidden" name="resi"   value="'.htmlspecialchars($resi,   ENT_QUOTES, 'UTF-8').'">';
        $html .= '            <input type="hidden" name="sumber" value="'.htmlspecialchars($sumber, ENT_QUOTES, 'UTF-8').'">';
        $html .= '          </div>';

        $html .= '          <div class="form-group">';
        $html .= '<input type="text" name="nama" class="form-control required" placeholder="Masukan Nama Responden" value="'.
            htmlspecialchars(isset($row['namaPemohon']) ? $row['namaPemohon'] : '', ENT_QUOTES, 'UTF-8').'" '.
            (!empty($row['namaPemohon']) ? 'readonly' : '').
            '>';


        $html .= '          </div>';

        $html .= '          <div class="form-group">';
        $html .= '            <div class="form-group radio_input">';
        $html .= '              <label class="container_radio">Pemohon'.
                        '<input type="radio" name="status_pemohon" value="1" class="required" checked>'.
                        '<span class="checkmark"></span>'.
                    '</label>';
        $html .= '              <label class="container_radio">Non Pemohon'.
                        '<input type="radio" name="status_pemohon" value="2" class="required">'.
                        '<span class="checkmark"></span>'.
                    '</label>';
        $html .= '            </div>';
        $html .= '          </div>';

        $html .= '          <div class="form-group">';
        $html .= '            <input type="text" name="hp" class="form-control required" placeholder="No. HP" value="'.
                        htmlspecialchars(isset($row['telpPemohon'])?$row['telpPemohon']:'', ENT_QUOTES, 'UTF-8').'">';
        $html .= '          </div>';

        $html .= '          <div class="row">';
        $html .= '            <div class="col-3">';
        $html .= '              <div class="form-group">';
        $html .= '                <input type="text" name="age" class="form-control required" placeholder="Usia" value="'.
                            htmlspecialchars(isset($row['usia'])?$row['usia']:'', ENT_QUOTES, 'UTF-8').'">';
        $html .= '              </div>';
        $html .= '            </div>';
        $html .= '            <div class="col-9">';
        $html .= '              <div class="form-group radio_input">';
        $html .= '                <label class="container_radio">Laki-laki'.
                            '<input type="radio" name="gender" value="1" class="required">'.
                            '<span class="checkmark"></span>'.
                        '</label>';
        $html .= '                <label class="container_radio">Perempuan'.
                            '<input type="radio" name="gender" value="2" class="required">'.
                            '<span class="checkmark"></span>'.
                        '</label>';
        $html .= '              </div>';
        $html .= '            </div>';
        $html .= '          </div>';

        // Pendidikan
        $html .= '          <div class="form-group">';
        $html .= '            <div class="styled-select clearfix">';
        $html .= '              <select class="wide required" name="pendidikan">'.$pendidikan_options.'</select>';
        $html .= '            </div>';
        $html .= '          </div>';

        // Pekerjaan
        $html .= '          <div class="form-group">';
        $html .= '            <div class="styled-select clearfix">';
        $html .= '              <select class="wide required" name="pekerjaan">'.$pekerjaan_options.'</select>';
        $html .= '            </div>';
        $html .= '          </div>';

        // Layanan (khusus frontoffice)
        // if (strtolower($resi) === 'frontoffice') {
        //     $html .= '      <div class="form-group">';
        //     $html .= '        <div class="styled-select clearfix">';
        //     $html .= '          <select class="wide required" name="layanan">'.$layanan_options.'</select>';
        //     $html .= '        </div>';
        //     $html .= '      </div>';
        // }
        // var_dump(htmlspecialchars($layanan_options));
        if (strtolower($resi) === 'frontoffice') {
            $html .= '      <div class="form-group">';
            $html .= '        <div class="styled-select clearfix">';
            $html .= '          <select class="wide required" name="layanan">'.$layanan_options.'</select>';
            $html .= '        </div>';
            $html .= '      </div>';
        }else{
            $html .= '<input type="hidden" name="layanan" value="0">';
        }
        

        $html .= '        </div>'; // end step 1

        // Pertanyaan (steps 2..N)
        $html .= $steps_html;

        // Step terakhir: saran/komentar/kendala + captcha
        $html .= '        <div class="submit step">';
        $html .= '          <h3 class="main_question"><strong>'.(int)$total_steps.'/'.(int)$total_steps.
                '</strong>Saran Anda untuk perbaikan pelayanan Dinas PMPTSP</h3>';
        $html .= '          <div class="form-group"><textarea name="saran" style="height:80px;width:300px;" required></textarea></div>';

        $html .= '          <h3 class="main_question">Komentar Positif (Apresiasi) Anda atas pelayanan yang telah diberikan oleh Dinas PMPTSP</h3>';
        $html .= '          <div class="form-group"><textarea name="komentar" style="height:80px;width:300px;"></textarea></div>';

        $html .= '          <h3 class="main_question">Kendala yang Dihadapi</h3>';
        $html .= '          <div class="form-group"><textarea name="kendala" style="height:80px;width:300px;" required></textarea></div>';

        $html .= '          <div class="g-recaptcha" data-sitekey="6LdJzMgZAAAAAOKKMaJ1L4GOb0f0qKsA1ZZhbfhu" data-callback="enableBtn" data-expired-callback="disableBtn"></div>';
        $html .= '        </div>'; // end submit step

        $html .= '      </div>'; // end middle-wizard

        $html .= '      <div id="bottom-wizard">';
        $html .= '        <button type="button" name="backward" class="backward">Prev</button>';
        $html .= '        <button type="button" name="forward"  class="forward">Next</button>';
        $html .= '        <button type="submit" name="process"  class="submit">Submit</button>';
        $html .= '      </div>';

        $html .= '    </form>';
        $html .= '  </div>';
        $html .= '</div>';

        // captcha script + validasi resi
        $html .= '<script src="https://www.google.com/recaptcha/api.js" async defer></script>';
        $html .= '<script>
        document.addEventListener("DOMContentLoaded", function(){
            var forwardButton = document.querySelector(".forward");
            if (!forwardButton) return;

            forwardButton.addEventListener("click", function(e){
                var resiInput = document.querySelector("input[name=\'resi1\']");
                if (!resiInput) return;
                var resiVal = (resiInput.value || "").trim();
                var err = document.getElementById("resi-error");
                if (err) { err.textContent = ""; err.style.display = "none"; }

                var code = "'.htmlspecialchars($resi, ENT_QUOTES, 'UTF-8').'";
                var valid = false;

                if (code.toLowerCase() === "frontoffice") {
                    // NIK 16 digit
                    if (/^\\d{16}$/.test(resiVal)) valid = true;
                    else {
                        if (err) { err.textContent = "Masukkan NIK yang valid (16 digit)."; err.style.display = "block"; }
                    }
                } else {
                    // Resi 19 digit
                    if (/^\\d{19}$/.test(resiVal)) valid = true;
                    else {
                        if (err) { err.textContent = "Masukkan nomor resi yang valid (19 digit)."; err.style.display = "block"; }
                    }
                }

                if (!valid) { e.preventDefault(); resiInput.focus(); }
            });
        });
        </script>';

        return $html;
    }
    private function _select_options_plain($table, $val_col, $label_col, $selected)
    {
        $rows = $this->db->select($val_col.','.$label_col)->from($table)->get()->result_array();
        $html = '';
        for ($i = 0; $i < count($rows); $i++) {
            $v = isset($rows[$i][$val_col]) ? $rows[$i][$val_col] : '';
            $l = isset($rows[$i][$label_col]) ? $rows[$i][$label_col] : '';
            $sel = ((string)$selected !== '' && (string)$selected === (string)$v) ? ' selected' : '';
            $html .= '<option value="'.htmlspecialchars($v, ENT_QUOTES, 'UTF-8').'"'.$sel.'>'.
                    htmlspecialchars($l, ENT_QUOTES, 'UTF-8').'</option>';
        }
        return $html;
    }

    public function get_by_resi($resi)
    {
        return $this->db->get_where($this->table, ['resi' => $resi])->row_array();
    }

    public function insert_skm($data)
    {
        return $this->db->insert($this->table, $data);
    }

    public function update_skm_by_resi($resi, $data)
    {
        $this->db->where('resi', $resi);
        return $this->db->update($this->table, $data);
    }
    public function update_skm_by_kode($kode, $data)
    {
        $this->db->where('kode', $kode);
        return $this->db->update($this->table, $data);
    }

    /**
     * Ambil daftar ID quis aktif (status_quis = '2') lalu concat menjadi string comma-separated.
     * Meniru fungsi `tampilCustomTabel('data_quis','skm_grup_quis',' AND status_quis = 2')`.
     */
    public function get_active_data_quis_ids()
    {
        $rows = $this->db->select('data_quis')
                         ->from('skm_grup_quis')
                         ->where('status_quis', '2')
                         ->get()->result();
        $list = [];
        foreach ($rows as $r) {
            $list[] = $r->data_quis;
        }
        // Jika di kolom "data_quis" sudah berupa CSV, gabungkan saja semua
        $csv = implode(',', $list);
        // Normalisasi: hapus spasi ganda
        $csv = preg_replace('/\s+/', '', $csv);
        return $csv !== '' ? $csv : '0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0';
    }
}
