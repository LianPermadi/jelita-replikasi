<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Survey extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
        $this->output->set_header("Cache-Control: post-check=0, pre-check=0", false);
        $this->output->set_header("Pragma: no-cache");
        $this->load->helper(['url', 'skm']); // skm_helper: foto(), MenuAtas(), MenuUtama(), etc
        $this->load->model(['Survei_model', 'Template_model']);
    }

    /**
     * Default list (equiv. SurveiList.php -> doList_fnc)
     * GET /survei?oc=...&ob=...&pg=...
     */
    public function index()
   {
        $data['terms']  = $this->Template_model->tampilCustomTabel('nama_tc', 'skm_tc', '');
        $data['menuAtas'] = menu_atas();
        $data['gambar'] = foto();
        $data['content']    = $this->Survei_model->get_form_add(); // return HTML string atau array komponen
        $data['csrf_name']  = $this->security->get_csrf_token_name();
        $data['csrf_hash']  = $this->security->get_csrf_hash();
        $data['recaptcha_sitekey']  = $this->security->get_csrf_hash();

        // var_dump($data['csrf_hash']);die();
        $this->load->view('skm/desain_skm_add', [
            'CONTENT'   => $this->load->view('partial/survei_form', $data, true),
            'GAMBAR'    => $data['gambar'],
            'TERMS'     => $data['terms'],
            'MENU_ATAS' => $data['menuAtas'],
        ]);
    }

    /**
     * Form tambah (equiv. SurveiAdd.php -> doAdd_fnc view)
     * GET /survei/add
     */

    
    public function add()
    {
        $data['terms']  = $this->Template_model->tampilCustomTabel('nama_tc', 'skm_tc', '');
        $data['menuAtas'] = menu_atas();
        $data['gambar'] = foto();
        $data['content']    = $this->Survei_model->get_form_add(); // return HTML string atau array komponen
        $data['csrf_name']  = $this->security->get_csrf_token_name();
        $data['csrf_hash']  = $this->security->get_csrf_hash();
        $data['recaptcha_sitekey']  = $this->security->get_csrf_hash();

        // var_dump($data['csrf_hash']);die();
        $this->load->view('skm/desain_skm_add', [
            'CONTENT'   => $this->load->view('partial/survei_form', $data, true),
            'GAMBAR'    => $data['gambar'],
            'TERMS'     => $data['terms'],
            'MENU_ATAS' => $data['menuAtas'],
        ]);
    }

    /**
     * Form tambah variasi 1 (equiv. SurveiAdd1.php)
     * GET /survei/add1
     */
    public function add1()
    {
        $data['terms']   = $this->Template_model->tampilCustomTabel('nama_tc', 'skm_tc', '');
        $data['menuAtas']  = MenuAtas();
        $data['menuUtama'] = MenuUtama();

        $this->load->view('skm/desain3', [
            'CONTENT'     => $this->load->view('skm/form_add1', $data, true),
            'MENU_UTAMA'  => $data['menuUtama'],
            'TERMS'       => $data['terms'],
            'MENU_ATAS'   => $data['menuAtas'],
        ]);
    }

    /**
     * Proses simpan (equiv. SurveiIns.php / SurveiIns1.php -> doInsert_fnc)
     * POST /survei/insert  (untuk add)
     * POST /survei/insert1 (untuk add1)
     */
    public function insert()
    {

        $payload = $this->input->post(NULL, true); // XSS filtering
          $gcaptcha = $this->input->post('g-recaptcha-response');
        $resi = $payload['resi'];

        // helper simple untuk kirim output + refresh CSRF (tanpa closure)
        $csrf_hash = $this->security->get_csrf_hash();
        $send_html = function($html, $self, $csrf_hash) {
            $self->output
                ->set_content_type('text/html; charset=utf-8')
                ->set_header('X-CSRF-Hash: '.$csrf_hash)
                ->set_output($html);
        };

    if ($resi === '') {
        $send_html('<div class="alert alert-warning">Masukkan nomor Resi / NIK dulu ya 🙏</div>', $this, $csrf_hash);
        return;
    }

    // ===== 1) LOOKUP DATA RESPONDEN =====
    $o = array(
        'id_pemohon'  => null,
        'izin'        => null,
        'trsektor_id' => null,
        'namaPemohon' => null,
        'telpPemohon' => null,
    );

    // a) utama: join portal + permohonan (by pendaftaran_id)
    $q0 = $this->db->select('*')
                   ->from('tmpemohon_portal t1')
                   ->join('tmpermohonan t2', 't1.id = t2.id_pemohon_portal', 'inner')
                   ->where('t2.pendaftaran_id', $resi)
                   ->limit(1)->get();

    if ($q0->num_rows() > 0) {
        $r0 = $q0->row_array();
    
        $o['id_pemohon']  = isset($r0['id']) ? $r0['id'] : null;
        $o['izin']        = isset($r0['izin']) ? $r0['izin'] : null;
        $o['trsektor_id'] = isset($r0['trsektor_id']) ? $r0['trsektor_id'] : null;
    }
    // fungsi kecil: cari nik di tabel (tanpa closure / modern syntax)
    $find_nik = function($table, $nik, $nama_col, $wa_col, $self) {
        $row = $self->db->select('*')->from($table)->where('nik', $nik)->limit(1)->get()->row_array();
        if (!$row) return null;
        return array(
            'nama' => isset($row[$nama_col]) ? $row[$nama_col] : null,
            'wa'   => isset($row[$wa_col]) ? $row[$wa_col] : null,
        );
    };

    // if ($o['namaPemohon'] === null) {
    //     $hit = $find_nik('public.pelayanan_gpt_2', $resi, 'nama', 'no_wa', $this);
    //     if ($hit) { $o['namaPemohon'] = $hit['nama']; $o['telpPemohon'] = $hit['wa']; }
    // }
    if ($o['namaPemohon'] === null) {
        $hit = $find_nik('public.pelayanan_gpt_4', $resi, 'nama', 'no_wa', $this);
        if ($hit) { $o['namaPemohon'] = $hit['nama']; $o['telpPemohon'] = $hit['wa']; }
    }
    if ($o['namaPemohon'] === null) {
        $hit = $find_nik('public.pelayanan_gpt_11_4_2025', $resi, 'nama', 'no_wa', $this);
        if ($hit) { $o['namaPemohon'] = $hit['nama']; $o['telpPemohon'] = $hit['wa']; }
    }
    if ($o['namaPemohon'] === null) {
        $hit = $find_nik('public.pelayanan_gpt_serambi', $resi, 'nama', 'no_wa', $this);
        if ($hit) { $o['namaPemohon'] = $hit['nama']; $o['telpPemohon'] = $hit['wa']; }
    }
    if ($o['namaPemohon'] === null) {
        $row6 = $this->db->select('*')->from('db_sicantik_backoffice.euis_bukutamu')->where('nik', $resi)->limit(1)->get()->row_array();
        if ($row6) {
            $o['namaPemohon'] = isset($row6['nama']) ? $row6['nama'] : null;
            $o['telpPemohon'] = isset($row6['telepon']) ? $row6['telepon'] : null;
        }
    }

    if ($o['trsektor_id'] === null && !empty($o['izin'])) {
        $o['trsektor_id'] = $this->db->select('trsektor_id')
                                     ->from('trperizinan_trsektor')
                                     ->where('trperizinan_id', $o['izin'])
                                     ->limit(1)->get()->row('trsektor_id');
    }
    if ($o['trsektor_id'] === null && !empty($o['id_pemohon'])) {
        $o['trsektor_id'] = $this->db->select('trsektor_id')->from('tmpermohonan')
                                     ->where('id_pemohon_portal', $o['id_pemohon'])
                                     ->order_by('id', 'DESC')->limit(1)->get()->row('trsektor_id');
    }

    // ===== 2) CEK SUDAH ISI =====
    $existing = $this->db->select('resi, flag_skm')
                         ->from('skm_data_skm')->where('resi', $resi)->limit(1)->get()->row_array();
    // if ($existing && isset($existing['flag_skm']) && (int)$existing['flag_skm'] === 1) {
    //     $html  = '<div class="alert alert-info">';
    //     $html .= 'Anda <strong>sudah</strong> mengisi survei untuk resi/NIK <code>'.htmlspecialchars($resi, ENT_QUOTES, 'UTF-8').'</code>.';
    //     $html .= '</div>';
    //     $send_html($html, $this, $csrf_hash);
    //     return;
    // }

    // ===== 3) SUBMIT DENGAN CAPTCHA (insert/update) =====
    if ($gcaptcha !== null && $gcaptcha !== '') {
        $secretKey = '6LdJzMgZAAAAAPovppwJu02lDQtIjX1DJ9VD7lEM'; // ganti dengan secret kamu
        $verifyUrl = 'https://www.google.com/recaptcha/api/siteverify?secret='
                   . urlencode($secretKey)
                   . '&response=' . urlencode($gcaptcha)
                   . '&remoteip=' . urlencode($this->input->ip_address());

        $resp = @file_get_contents($verifyUrl);
        $ok   = $resp ? json_decode($resp, true) : array('success' => false);

        if (!isset($ok['success']) || !$ok['success']) {
            $send_html('<div class="alert alert-danger">Gagal membaca Captcha. Coba lagi ya 🙏</div>', $this, $csrf_hash);
            return;
        }
        $Id_pemohon = $o['id_pemohon'];
        $nama       = $o['namaPemohon'] !== null ? $o['namaPemohon'] : '';
        $mobile     = $o['telpPemohon'] !== null ? $o['telpPemohon'] : '';
        $ijin       = $o['izin'] !== null ? $o['izin'] : '';
        $trsektor   = $o['trsektor_id'] !== null ? $o['trsektor_id'] : '';

        $dataInsert = array(
            'resi'           => $resi,
            'permohonan_id'  => $Id_pemohon,
            'nama_responden' => $nama,
            'mobile'         => $mobile,
            'sektor'         => $trsektor,
            'jenis_ijin'     => $ijin,
            'data_skm_id'    => '1,2,3,4,5,6,7,8,9,10',
            'data_skm_nilai' => '0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0',
            'total'          => '0',
            'rata'           => '0',
            'flag_skm'       => '1',
            'tgl_pengisian'  => date('Y-m-d H:i:s'),
        );

        $this->db->trans_start();
        if ($existing) {
            $this->db->where('resi', $resi)
                     ->update('skm_data_skm', array(
                         'nama_responden' => $nama,
                         'mobile'         => $mobile,
                         'tgl_pengisian'  => date('Y-m-d H:i:s'),
                     ));
        } else {
            $this->db->insert('skm_data_skm', $dataInsert);
        }
        
        $this->db->trans_complete();

        if (!$this->db->trans_status()) {
            $send_html('<div class="alert alert-danger">Gagal menyimpan data. Coba lagi ya.</div>', $this, $csrf_hash);
            return;
        }
        // var_dump($dataInsert);die();

        $nextUrl = site_url('survey/question').'?CODE='.rawurlencode($resi).'&url=3';
        // var_dump($resi);die();

        $html  = '<div class="alert alert-success">';
        $html .= 'Data tersimpan. Silakan lanjut ke langkah berikutnya.';
        $html .= '<div style="margin-top:8px"><a class="btn btn-primary" href="'.$nextUrl.'">Lanjut ke Survei</a></div>';
        $html .= '</div>';
        redirect('survey/question?CODE='.rawurlencode($resi).'&url=3', 'location');

        return;
    }

    // ===== 4) HANYA LOOKUP (tanpa captcha) =====
    if (($o['id_pemohon'] === null) && ($o['namaPemohon'] === null)) {
        $send_html('<div class="alert alert-danger">Gagal membaca data dari Resi/NIK tersebut.</div>', $this, $csrf_hash);
        return;
    }

        $this->Survei_model->insert($payload);
        redirect('survey'); // atau set flashdata & redirect ke detail
    }

    public function simpan()
    {
        // Pastikan hanya POST
        if ($this->input->method() !== 'post') {
            show_error('Metode tidak diizinkan', 405);
        }
   
        // ------ reCAPTCHA verify ------
        $gcaptcha = $this->input->post('g-recaptcha-response', true);

        
        $secretKey = '6LdJzMgZAAAAAPovppwJu02lDQtIjX1DJ9VD7lEM'; // ganti dengan secret kamu
        $verifyUrl = 'https://www.google.com/recaptcha/api/siteverify?secret='
                   . urlencode($secretKey)
                   . '&response=' . urlencode($gcaptcha)
                   . '&remoteip=' . urlencode($this->input->ip_address());

        $resp = @file_get_contents($verifyUrl);
        $ok   = $resp ? json_decode($resp, true) : array('success' => false);

        if (!isset($ok['success']) || !$ok['success']) {
            $send_html('<div class="alert alert-danger">Gagal membaca Captcha. Coba lagi ya 🙏</div>', $this, $csrf_hash);
            return;
        }

        // ------ Ambil input aman ------
        $nama            = $this->security->xss_clean($this->input->post('nama', true));
        $status_pemohon  = $this->input->post('status_pemohon', true);
        $hp              = $this->input->post('hp', true);
        $age             = (int)$this->input->post('age', true);
        $gender          = $this->input->post('gender', true);
        $pendidikan      = $this->input->post('pendidikan', true);
        $pekerjaan       = $this->input->post('pekerjaan', true);
        $layanan         = $this->input->post('layanan', true);
        $sektor          = $this->input->post('sektor', true);
        $ijin            = $this->input->post('ijin', true);
        $saran           = $this->input->post('saran', true);
        $komentar        = $this->input->post('komentar', true);
        $permohonan_id   = $this->input->post('permohonan_id', true);
        $kendala         = $this->input->post('kendala', true);

        if ($this->input->post('resi') == 'frontoffice') {
            $resi = $this->input->post('resi1', true);
        } else {
            $resi = $this->input->post('resi', true) ?: $this->input->post('resi1', true);
        }

        $required_fields = [
            'resi'          => 'resi1',
            'nama'          => 'Nama',
            'hp'            => 'hp',
            'layanan'       => 'Layanan',
            'pendidikan'    => 'Pendidikan',
            'pekerjaan'     => 'Pekerjaan',
            'age'           => 'Usia',
        ];

        // 🔁 Loop untuk cek mana yang kosong
        $errors = [];
        foreach ($required_fields as $field => $label) {
            if ($field === 'resi') {
                $value = $resi;
            } else {
                $value = trim($this->input->post($field, true));
            }
            if ($value === '' || $value === null) {
                $errors[] = $label . ' tidak boleh kosong';
            }
        }
        // var_dump($errors);die();

        // 🧱 Kalau ada error, tampilkan dan kembalikan ke form
        if (!empty($errors)) {
            // simpan data input user ke session
            $this->session->set_userdata('form_skm', $this->input->post());

            // simpan pesan error ke flashdata supaya bisa ditampilkan setelah redirect
            $this->session->set_flashdata('error', implode('<br>', $errors));

            // redirect ke halaman question
            redirect('survey/question?CODE='.rawurlencode($resi).'&url=3');
            return;
        }


        $sumber          = (int)$this->input->post('sumber', true);
        // ------ Siapkan daftar jawaban 20 pertanyaan ------
        $question = [];
        $Jumlah   = 0;
        for ($i = 0; $i <= 19; $i++) {
            $key = 'question_'.$i;
            $val = $this->input->post($key, true);
            if ($val !== null && $val !== '') {
                $question[] = (int)$val;
                $Jumlah++;
            } else {
                $question[] = 0;
            }
        }

        // ------ Hitung skor sama persis seperti logic lama ------
        $total        = array_sum($question);
        $total_nilai  = $total * 25; // sesuai script awal
        $rata         = $Jumlah > 0 ? ($total_nilai / $Jumlah) : 0;
        $data_nilai   = implode(',', $question);

        // Ambil data_skm_id yang aktif (status_quis = '2')
        $data_skm_ids = $this->Survei_model->get_active_data_quis_ids(); // string "1,2,3,..."
        $this->db->trans_start();
        // ------ Upsert ke skm_data_skm ------
        $exists = $this->Survei_model->get_by_resi($resi);
        // $data_insert = [
        //     'resi'           => $resi,
        //     'usia'           => $age,
        //     'gender'         => $gender,
        //     'pendidikan_id'  => $pendidikan,
        //     'pekerjaan_id'   => $pekerjaan,
        //     'permohonan_id'  => $permohonan_id,
        //     'nama_responden' => $nama,
        //     'mobile'         => $hp,
        //     'sektor'         => $sektor,
        //     'jenis_ijin'     => $ijin,
        //     'data_skm_id'    => $data_skm_ids,
        //     'data_skm_nilai' => $data_nilai,
        //     'total'          => $total_nilai,
        //     'rata'           => $rata,
        //     'saran'          => $saran,
        //     'keterangan'     => $komentar,
        //     'kendala'        => $kendala,
        //     'layanan_id'     => $layanan,
        //     'tgl_pengisian'  => date('Y-m-d H:i:s'),
        // ];
        if (empty($exists)) {
            // insert
            $this->Survei_model->insert_skm([
                'resi'           => $resi,
                'usia'           => $age,
                'gender'         => $gender,
                'pendidikan_id'  => $pendidikan,
                'pekerjaan_id'   => $pekerjaan,
                'permohonan_id'  => $permohonan_id,
                'nama_responden' => $nama,
                'mobile'         => $hp,
                'sektor'         => $sektor,
                'jenis_ijin'     => $ijin,
                'data_skm_id'    => $data_skm_ids,
                'data_skm_nilai' => $data_nilai,
                'total'          => $total_nilai,
                'rata'           => $rata,
                'saran'          => $saran,
                'keterangan'     => $komentar,
                'kendala'        => $kendala,
                'layanan_id'     => $layanan,
                'flag_skm'         => 1,
                'tgl_pengisian'  => date('Y-m-d H:i:s'),
            ]);

            // 💡 Ambil ID hasil insert
            $insert_id = $this->db->insert_id();
            // kalau perlu di-log biar gampang dicek

            log_message('debug', 'ID SKM baru: '.$insert_id);
            if (empty($resi)) {
                $resi = 'fo_' . $insert_id;
            }

            $this->Survei_model->update_skm_by_kode($insert_id, [
                 'resi'           => $resi,
            ]);
            $this->db->trans_complete();

            if ($this->db->trans_status() === false) {
                log_message('error', 'Gagal menyimpan SKM untuk resi '.$resi);
                $this->session->set_flashdata('error', 'Terjadi kendala saat menyimpan. Coba lagi ya 🙏');
                return redirect('survey/form');
            }

            // ------ Redirect tujuan ------
            if ($sumber === 1) {
                return redirect('survey/sukses');
            } else {
                return redirect('survey/sukses');
            }
        }


        // Update nilai lengkap
        $this->Survei_model->update_skm_by_resi($resi, [
            'status_responden' => $status_pemohon,
            'nama_responden'   => $nama,
            'usia'             => $age,
            'gender'           => $gender,
            'jenis_ijin'       => $ijin,
            'permohonan_id'    => $permohonan_id,
            'pendidikan_id'    => $pendidikan,
            'pekerjaan_id'     => $pekerjaan,
            'layanan_id'       => $layanan,
            'data_skm_id'      => $data_skm_ids,
            'data_skm_nilai'   => $data_nilai,
            'total'            => $total_nilai,
            'rata'             => $rata,
            'saran'            => $saran,
            'keterangan'       => $komentar,
            'kendala'          => $kendala,
            'flag_skm'         => 1,
        ]);

        $this->db->trans_complete();

        if ($this->db->trans_status() === false) {
            log_message('error', 'Gagal menyimpan SKM untuk resi '.$resi);
            $this->session->set_flashdata('error', 'Terjadi kendala saat menyimpan. Coba lagi ya 🙏');
            return redirect('survey/form');
        }
            // ------ Redirect tujuan ------
        if ($sumber === 1) {
            // redirect ke sicantik (aktifkan kalau sudah ready)
            // return redirect('https://dpmptsp.jabarprov.go.id/sicantik/main/user/permohonan');
            return redirect('survey/sukses'); // fallback sementara
        } else {
            return redirect('survey/sukses');
        }
    }

    /**
     * Halaman sukses (auto redirect 5 detik jika ingin)
     */
    public function sukses()
    {
        $redirect_url = site_url('/skm'); // ganti jika ada
        // var_dump($redirect_url);die();
        $delay_ms     = 5000; // 5 detik
        $this->load->view('skm/success', compact('redirect_url','delay_ms'));
    }

    /**
     * Form edit (equiv. SurveiEdit.php -> doEdit_fnc view)
     * GET /survei/edit/{id}
     */
    public function edit($id = null)
    {
        if (!$id) show_404();
        $data['terms']   = $this->Template_model->tampilCustomTabel('nama_tc', 'skm_tc', '');
        $data['menuAtas']  = MenuAtas();
        $data['menuUtama'] = MenuUtama();
        $data['row'] = $this->Survei_model->find($id);

        $this->load->view('skm/desain3', [
            'CONTENT'     => $this->load->view('skm/form_edit', $data, true),
            'MENU_UTAMA'  => $data['menuUtama'],
            'TERMS'       => $data['terms'],
            'MENU_ATAS'   => $data['menuAtas'],
        ]);
    }

    /**
     * Proses update (equiv. SurveiUpd.php -> doUpdate_fnc)
     * POST /survei/update/{id}
     */
    public function update($id = null)
    {
        if (!$id) show_404();
        $payload = $this->input->post(NULL, true);
        $this->Survei_model->update($id, $payload);
        redirect('survei');
    }

    /**
     * Hapus (equiv. VendorBarangDel.php -> doDelete_fnc)
     * POST /survei/delete/{id} atau GET kalau legacy
     */
    public function delete($id = null)
    {
        if (!$id) show_404();
        $this->Survei_model->delete($id);
        redirect('survei');
    }

    /**
     * Detail penawaran (equiv. VendorBarangPenawaranList.php -> doList_fnc)
     * GET /survei/dtl/{id}
     */
    public function dtl($id = null)
    {
        if (!$id) show_404();
        $data['terms']   = $this->Template_model->tampilCustomTabel('nama_tc', 'skm_tc', '');
        $data['menuAtas']  = MenuAtas();
        $data['menuUtama'] = MenuUtama();
        $data['penawaran'] = $this->Survei_model->get_penawaran_list($id);

        $this->load->view('skm/desain2', [
            'CONTENT'     => $this->load->view('skm/penawaran_list', $data, true),
            'MENU_UTAMA'  => $data['menuUtama'],
            'TERMS'       => $data['terms'],
            'MENU_ATAS'   => $data['menuAtas'],
        ]);
    }

    /**
     * Pencarian (equiv. VendorBarangAdd1.php -> doAdd_fnc view)
     * GET /survei/search?q=...
     */
    public function search()
    {
        $q = $this->input->get('q', true);
        $data['terms']   = $this->Template_model->tampilCustomTabel('nama_tc', 'skm_tc', '');
        $data['menuAtas']  = MenuAtas();
        $data['menuUtama'] = MenuUtama();
        $data['result']  = $this->Survei_model->search($q);

        $this->load->view('skm/desain2', [
            'CONTENT'     => $this->load->view('skm/form_add', $data, true), // atau view pencarian khusus
            'MENU_UTAMA'  => $data['menuUtama'],
            'TERMS'       => $data['terms'],
            'MENU_ATAS'   => $data['menuAtas'],
        ]);
    }

    /** Tampilkan form survei (pengganti doList_fnc) */
    public function form()
    {
        // kalau pakai CSRF CI3, otomatis ada di config; kita lempar token ke view
        $data['csrf_name']  = $this->security->get_csrf_token_name();
        $data['csrf_hash']  = $this->security->get_csrf_hash();

        // sitekey reCAPTCHA (pakai punyamu)
        $data['recaptcha_sitekey'] = '6LdJzMgZAAAAAOKKMaJ1L4GOb0f0qKsA1ZZhbfhu';
         $data['terms']  = $this->Template_model->tampilCustomTabel('nama_tc', 'skm_tc', '');
        $data['menuAtas'] = menu_atas();
        $data['gambar'] = foto();

        $this->load->view('skm/desain_skm_add', [
            'CONTENT'   => $this->load->view('partial/survei_form', $data, true),
            'GAMBAR'    => $data['gambar'],
            'TERMS'     => $data['terms'],
            'MENU_ATAS' => $data['menuAtas'],
        ]);
    }

    /** Endpoint AJAX pengganti get_info.php */
public function get_info()
{
    if (!$this->input->is_ajax_request()) {
        show_404();
    }

    $resi     = trim($this->input->post('resi', true));
    $gcaptcha = $this->input->post('g-recaptcha-response');

    // helper simple untuk kirim output + refresh CSRF (tanpa closure)
    $csrf_hash = $this->security->get_csrf_hash();
    $send_html = function($html, $self, $csrf_hash) {
        $self->output
             ->set_content_type('text/html; charset=utf-8')
             ->set_header('X-CSRF-Hash: '.$csrf_hash)
             ->set_output($html);
    };

    if ($resi === '') {
        $send_html('<div class="alert alert-warning">Masukkan nomor Resi / NIK dulu ya 🙏</div>', $this, $csrf_hash);
        return;
    }

    // ===== 1) LOOKUP DATA RESPONDEN =====
    $o = array(
        'id_pemohon'  => null,
        'izin'        => null,
        'trsektor_id' => null,
        'namaPemohon' => null,
        'telpPemohon' => null,
    );

    // a) utama: join portal + permohonan (by pendaftaran_id)
    $q0 = $this->db->select('*')
                   ->from('tmpemohon_portal t1')
                   ->join('tmpermohonan t2', 't1.id = t2.id_pemohon_portal', 'inner')
                   ->where('t2.pendaftaran_id', $resi)
                   ->limit(1)->get();
    if ($q0->num_rows() > 0) {
        $r0 = $q0->row_array();
        $o['id_pemohon']  = isset($r0['id_pemohon_portal']) ? $r0['id_pemohon_portal'] : null;
        $o['izin']        = isset($r0['izin']) ? $r0['izin'] : null;
        $o['trsektor_id'] = isset($r0['trsektor_id']) ? $r0['trsektor_id'] : null;
    }

    // fungsi kecil: cari nik di tabel (tanpa closure / modern syntax)
    $find_nik = function($table, $nik, $nama_col, $wa_col, $self) {
        $row = $self->db->select('*')->from($table)->where('nik', $nik)->limit(1)->get()->row_array();
        if (!$row) return null;
        return array(
            'nama' => isset($row[$nama_col]) ? $row[$nama_col] : null,
            'wa'   => isset($row[$wa_col]) ? $row[$wa_col] : null,
        );
    };

    // if ($o['namaPemohon'] === null) {
    //     $hit = $find_nik('public.pelayanan_gpt_2', $resi, 'nama', 'no_wa', $this);
    //     if ($hit) { $o['namaPemohon'] = $hit['nama']; $o['telpPemohon'] = $hit['wa']; }
    // }
    if ($o['namaPemohon'] === null) {
        $hit = $find_nik('public.pelayanan_gpt_3', $resi, 'nama', 'no_wa', $this);
        if ($hit) { $o['namaPemohon'] = $hit['nama']; $o['telpPemohon'] = $hit['wa']; }
    }
    if ($o['namaPemohon'] === null) {
        $hit = $find_nik('public.pelayanan_gpt_11_4_2025', $resi, 'nama', 'no_wa', $this);
        if ($hit) { $o['namaPemohon'] = $hit['nama']; $o['telpPemohon'] = $hit['wa']; }
    }
    if ($o['namaPemohon'] === null) {
        $hit = $find_nik('public.pelayanan_gpt_serambi', $resi, 'nama', 'no_wa', $this);
        if ($hit) { $o['namaPemohon'] = $hit['nama']; $o['telpPemohon'] = $hit['wa']; }
    }
    if ($o['namaPemohon'] === null) {
        $row6 = $this->db->select('*')->from('db_sicantik_backoffice.euis_bukutamu')->where('nik', $resi)->limit(1)->get()->row_array();
        if ($row6) {
            $o['namaPemohon'] = isset($row6['nama']) ? $row6['nama'] : null;
            $o['telpPemohon'] = isset($row6['telepon']) ? $row6['telepon'] : null;
        }
    }

    if ($o['trsektor_id'] === null && !empty($o['izin'])) {
        $o['trsektor_id'] = $this->db->select('trsektor_id')
                                     ->from('trperizinan_trsektor')
                                     ->where('trperizinan_id', $o['izin'])
                                     ->limit(1)->get()->row('trsektor_id');
    }
    if ($o['trsektor_id'] === null && !empty($o['id_pemohon'])) {
        $o['trsektor_id'] = $this->db->select('trsektor_id')->from('tmpermohonan')
                                     ->where('id_pemohon_portal', $o['id_pemohon'])
                                     ->order_by('id', 'DESC')->limit(1)->get()->row('trsektor_id');
    }

    // ===== 2) CEK SUDAH ISI =====
    $existing = $this->db->select('resi, flag_skm')
                         ->from('skm_data_skm')->where('resi', $resi)->limit(1)->get()->row_array();
    // if ($existing && isset($existing['flag_skm']) && (int)$existing['flag_skm'] === 1) {
    //     $html  = '<div class="alert alert-info">';
    //     $html .= 'Anda <strong>sudah</strong> mengisi survei untuk resi/NIK <code>'.htmlspecialchars($resi, ENT_QUOTES, 'UTF-8').'</code>.';
    //     $html .= '</div>';
    //     $send_html($html, $this, $csrf_hash);
    //     return;
    // }

    // ===== 3) SUBMIT DENGAN CAPTCHA (insert/update) =====
    if ($gcaptcha !== null && $gcaptcha !== '') {
        $secretKey = '6LdJzMgZAAAAAPovppwJu02lDQtIjX1DJ9VD7lEM'; // ganti dengan secret kamu
        $verifyUrl = 'https://www.google.com/recaptcha/api/siteverify?secret='
                   . urlencode($secretKey)
                   . '&response=' . urlencode($gcaptcha)
                   . '&remoteip=' . urlencode($this->input->ip_address());

        $resp = @file_get_contents($verifyUrl);
        $ok   = $resp ? json_decode($resp, true) : array('success' => false);

        if (!isset($ok['success']) || !$ok['success']) {
            $send_html('<div class="alert alert-danger">Gagal membaca Captcha. Coba lagi ya 🙏</div>', $this, $csrf_hash);
            return;
        }

        // if (($o['id_pemohon'] === null) && ($o['namaPemohon'] === null)) {
        //     $send_html('<div class="alert alert-danger">Gagal membaca data. Pastikan Resi/NIK benar.</div>', $this, $csrf_hash);
        //     return;
        // }

        $Id_pemohon = $o['id_pemohon'];
        $nama       = $o['namaPemohon'] !== null ? $o['namaPemohon'] : '';
        $mobile     = $o['telpPemohon'] !== null ? $o['telpPemohon'] : '';
        $ijin       = $o['izin'] !== null ? $o['izin'] : '';
        $trsektor   = $o['trsektor_id'] !== null ? $o['trsektor_id'] : '';

        $dataInsert = array(
            'resi'           => $resi,
            'permohonan_id'  => $Id_pemohon,
            'nama_responden' => $nama,
            'mobile'         => $mobile,
            'sektor'         => $trsektor,
            'jenis_ijin'     => $ijin,
            'data_skm_id'    => '1,2,3,4,5,6,7,8,9,10',
            'data_skm_nilai' => '0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0',
            'total'          => '0',
            'rata'           => '0',
            'flag_skm'       => '1',
            'tgl_pengisian'  => date('Y-m-d H:i:s'),
        );

        $this->db->trans_start();
        if ($existing) {
            $this->db->where('resi', $resi)
                     ->update('skm_data_skm', array(
                         'nama_responden' => $nama,
                         'mobile'         => $mobile,
                         'flag_skm'       => '1',
                         'tgl_pengisian'  => date('Y-m-d H:i:s'),
                     ));
        } else {
            $this->db->insert('skm_data_skm', $dataInsert);
        }
        $this->db->trans_complete();

        if (!$this->db->trans_status()) {
            $send_html('<div class="alert alert-danger">Gagal menyimpan data. Coba lagi ya.</div>', $this, $csrf_hash);
            return;
        }

        $nextUrl = site_url('survey/add').'?CODE='.rawurlencode($resi).'&url=3';
        $html  = '<div class="alert alert-success">';
        $html .= 'Data tersimpan. Silakan lanjut ke langkah berikutnya.';
        $html .= '<div style="margin-top:8px"><a class="btn btn-primary" href="'.$nextUrl.'">Lanjut ke Survei</a></div>';
        $html .= '</div>';
        $send_html($html, $this, $csrf_hash);
        return;
    }

    // ===== 4) HANYA LOOKUP (tanpa captcha) =====
    if (($o['id_pemohon'] === null) && ($o['namaPemohon'] === null)) {
        $send_html('<div class="alert alert-danger">Gagal membaca data dari Resi/NIK tersebut.</div>', $this, $csrf_hash);
        return;
    }

    $sektor_str = ($o['trsektor_id'] !== null && $o['trsektor_id'] !== '') ? (string)$o['trsektor_id'] : '-';
    $nama_str   = ($o['namaPemohon'] !== null && $o['namaPemohon'] !== '') ? $o['namaPemohon'] : '-';
    $wa_str     = ($o['telpPemohon'] !== null && $o['telpPemohon'] !== '') ? $o['telpPemohon'] : '-';

    $html  = '<div class="card" style="padding:12px;border:1px solid #eee;margin-top:8px;">';
    $html .= '<strong>Hasil Pencarian:</strong><br>';
    $html .= 'Resi/NIK: <code>'.htmlspecialchars($resi, ENT_QUOTES, 'UTF-8').'</code><br>';
    $html .= 'Nama: '.htmlspecialchars($nama_str, ENT_QUOTES, 'UTF-8').'<br>';
    $html .= 'WA/Telp: '.htmlspecialchars($wa_str, ENT_QUOTES, 'UTF-8').'<br>';
    $html .= 'Sektor: '.htmlspecialchars($sektor_str, ENT_QUOTES, 'UTF-8').'<br>';
    $html .= '<small>Silakan klik <em>Next Step</em> untuk menyimpan dan lanjut.</small>';
    $html .= '</div>';

    $send_html($html, $this, $csrf_hash);
}
public function question()
{
    // Ambil parameter GET
    $resi   = trim((string)$this->input->get('CODE', true));

    // var_dump($resi);die();
    $sumber = trim((string)$this->input->get('sumber', true));

        $data['error'] = $this->session->flashdata('error');
    // if ($sumber === '') {
    //     // fallback ke ?url=...
    //     $sumber = trim((string)$this->input->get('url', true));
    // }

    // if ($resi === '') {
    //     $this->output
    //          ->set_status_header(400)
    //          ->set_content_type('text/html; charset=utf-8')
    //          ->set_output('<div class="alert alert-warning">Parameter CODE (resi/NIK) kosong.</div>');
    //     return;
    // }
  $CI =& get_instance();
    $csrf_name = $CI->security->get_csrf_token_name();
    $csrf_hash = $CI->security->get_csrf_hash();

    if ($csrf_hash === null) {
        $csrf_hash = $CI->security->get_csrf_hash();
    }
    // Token CSRF
  
    // Panggil builder di model (pastikan cuma SATU versi fungsi ini di model)
    // $html = $this->Survei_model->build_add_form_html($resi, $sumber, $csrf_name, $csrf_hash);
    $data['CONTENT'] = $this->Survei_model->build_add_form_html($resi, $sumber, $csrf_name, $csrf_hash); // HTML utuh
    $this->load->view('skm/desain_skm_add', $data);

}




/**
 * Utility sederhana buat bikin <option>… dari tabel
 */



}
