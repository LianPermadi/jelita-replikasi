<?php

/* Description of Perusahaan
 * @author agusnur Created : 16 Aug 2010
 * edit PBS November 2016
 */
class Perusahaan extends WRC_AdminCont {

    var $obj;

    /* Variable for generating JSON. */
    var $iTotalRecords;
    var $iTotalDisplayRecords;

    /* Variable that taken form input. */
    var $iDisplayStart;
    var $iDisplayLength;
    var $iSortingCols;
    var $sSearch;
    var $sEcho;

    public function __construct() {
        parent::__construct();
        $this->perusahaan = new tmperusahaan();
        $this->propinsi = new trpropinsi();
        $this->kabupaten = new trkabupaten();
        $this->kecamatan = new trkecamatan();
        $this->kelurahan = new trkelurahan();
        $this->kegiatan = new trkegiatan();
        $this->investasi = new trinvestasi();

        $enabled = FALSE;
        $list_auths = $this->session_info['app_list_auth'];

        foreach ($list_auths as $list_auth) {
            if ($list_auth->id_role === '9') {
                $enabled = TRUE;
            }
        }

        if (!$enabled) {
            redirect('dashboard');
        }
    }

    function _funcwilayah() {
        $data['list_propinsi'] = $this->propinsi->order_by('n_propinsi', 'ASC')->get();
        $data['list_kabupaten'] = $this->kabupaten->order_by('n_kabupaten', 'ASC')->get();
        $data['list_kecamatan'] = $this->kecamatan->order_by('n_kecamatan', 'ASC')->get();
        $data['list_kelurahan'] = $this->kelurahan->order_by('n_kelurahan', 'ASC')->get();

        //Data Pendukung Perusahaan
        $data['list_kegiatan'] = $this->kegiatan->order_by('n_kegiatan', 'ASC')->get();
        $data['list_investasi'] = $this->investasi->order_by('n_investasi', 'ASC')->get();

        return $data;
    }

    public function index() {
		$data['list'] = $this->perusahaan->order_by('id', 'DESC')->limit(2000)->get();
        $this->load->vars($data);

        $js = "
                function confirm_link(text){
                    if(confirm(text)){ return true;
                    }else{ return false; }
                }
                ";

        $this->template->set_metadata_javascript($js);
        $this->session_info['page_name'] = "Data Pemohon";
        $this->template->build('perusahaan_list', $this->session_info);
    }

    public function getDataTables() {
        $obj = new tmperusahaan();
        $obj->start_cache();
        $columns = array('n_perusahaan', 'npwp', 'a_perusahaan');
        $this->iTotalRecords = $obj->count();
        $this->sEcho = $this->input->post('sEcho');
        for ($i = 0; $i < 2; $i++) {
            /* Filtering */
            if ($this->input->post('sSearch')) {
                foreach ($columns as $position => $column) {
                    if ($position == 0) {
                        $obj->like($column, $this->input->post('sSearch'));
                    } else {
                        $obj->or_like($column, $this->input->post('sSearch'));
                    }
                }
            }

            if ($i === 0) {
                $this->iTotalDisplayRecords = $obj->count();
            } else if ($i === 1) {
                if ($this->input->post("iDisplayStart") && $this->input->post("iDisplayLength") != "-1") {
                    $this->iDisplayStart = $this->input->post("iDisplayStart");
                    $this->iDisplayLength = $this->input->post("iDisplayLength");
                    $obj->limit($this->iDisplayLength, $this->iDisplayStart);
                } else {
                    $this->iDisplayLength = $this->input->post("iDisplayLength");
                    if (empty($this->iDisplayLength)) {
                        $this->iDisplayLength = 10;
                        $obj->limit($this->iDisplayLength);
                    }
                    else
                        $obj->limit($this->iDisplayLength);
                }
                $peru = new tmperusahaan;
                $a = $peru->select('n_perusahaan,npwp,a_perusahaan')->distinct()->get();
                $obj->stop_cache();
                echo $this->getDataTablesOutput($obj->get());
            }
        }
    }

    private function getDataTablesOutput($obj) {
        $aaData = array();
        $i = $this->iDisplayStart;
        foreach ($obj as $list) {
            $i++;

            /* Adding new a column for taking data action */
            // ----------
            $action = NULL;
            $img_edit = array(
                'src' => base_url() . 'assets/images/icon/property.png',
                'alt' => 'Edit',
                'title' => 'Edit',
                'border' => '0',
            );
            $confirm_text = 'Apakah Anda yakin akan menghapusnya?';
            $img_delete = array(
                'src' => base_url() . 'assets/images/icon/minus.png',
                'alt' => 'Delete',
                'title' => 'Delete',
                'border' => '0',
                'onClick' => 'return confirm_link(\'' . $confirm_text . '\')',
            );
            $action .= anchor(site_url('perusahaan/edit') . '/' . $list->id, img($img_edit)) . "&nbsp;";
            $relasi = new tmpermohonan_tmperusahaan();
            $relasi->where('tmperusahaan_id', $list->id)->get();
            if (!$relasi->id)
                $action .= anchor(site_url('perusahaan/delete') . '/' . $list->id, img($img_delete)) . "&nbsp;";
            // ----------

            $aaData[] = array(
                $i,
                $list->n_perusahaan,
                $list->npwp,
                $list->a_perusahaan,
                $action
            );
        }

        $sOutput = array("sEcho" => intval($this->sEcho),
                         "iTotalRecords" => $this->iTotalRecords,
                         "iTotalDisplayRecords" => $this->iTotalDisplayRecords,
                         "aaData" => $aaData
                   );
        return json_encode($sOutput);
    }

    /* create is a method to show page for creating data */

    public function create() {
        $data = $this->_funcwilayah();
        $data['save_method'] = "save";
        $data['id_perusahaan'] = "";
        $data['nama_perusahaan'] = "";
        $data['reg_perusahaan'] = "";
        $data['npwp'] = "";
        $data['telp_perusahaan'] = "";
        $data['alamat_usaha'] = "";
        $data['propinsi_usaha'] = NULL;
        $data['kabupaten_usaha'] = NULL;
        $data['kecamatan_usaha'] = NULL;
        $data['kelurahan_usaha'] = NULL;
        $data['jenis_kegiatan'] = "ok";
        $data['jenis_investasi'] = "ok";

        $js = "
                $(document).ready(function() {
                    $('#form').validate();
                    $(\"#tabs\").tabs();
                } );

                $(function() {
                    $(\"#inputTanggal1\").datepicker({
                        changeMonth: true,
                        changeYear: true,
                        dateFormat: 'yy-mm-dd',
                        closeText: 'X'
                    });
                    $(\"#inputTanggal2\").datepicker({
                        changeMonth: true,
                        changeYear: true,
                        dateFormat: 'yy-mm-dd',
                        closeText: 'X'
                    });
                });

                $(document).ready(function() {
                        $('#propinsi_usaha_id').change(function(){
                            $.post('" . base_url() . "pelayanan/pendaftaran/kabupaten_usaha', { propinsi_id: $('#propinsi_usaha_id').val() },
                                function(data) {
                                    $('#show_kabupaten_usaha').html(data);
                                    $('#show_kecamatan_usaha').html('Data Tidak tersedia');
                                    $('#show_kelurahan_usaha').html('Data Tidak tersedia');
                                });
                        });
                });

                function finishAjax(id, response){
                  $('#'+id).html(unescape(response));
                  $('#'+id).fadeIn();
                }
            ";

        $this->template->set_metadata_javascript($js);
        $this->load->vars($data);
        $this->session_info['page_name'] = "Tambah Data Perusahaan";
        $this->template->build('perusahaan_edit', $this->session_info);
    }

    /* edit is a method to show page for updating data */

    public function edit($id_perusahaan = NULL) {
        $u_perusahaan = $this->perusahaan->get_by_id($id_perusahaan);
        $u_kelurahan  = $u_perusahaan->trkelurahan->get();
        $u_kecamatan  = $u_perusahaan->trkelurahan->trkecamatan->get();
        $u_kabupaten  = $u_perusahaan->trkelurahan->trkecamatan->trkabupaten->get();
        $u_propinsi   = $u_perusahaan->trkelurahan->trkecamatan->trkabupaten->trpropinsi->get();
//		$u_kelurahan = $this->perusahaan->trkelurahan->get();
//        $u_kecamatan = $this->perusahaan->trkelurahan->trkecamatan->get();
//        $u_kabupaten = $this->perusahaan->trkelurahan->trkecamatan->trkabupaten->get();
//        $u_propinsi = $this->perusahaan->trkelurahan->trkecamatan->trkabupaten->trpropinsi->get();

        $u_kegiatan =  $u_perusahaan->trkegiatan->get();
        $u_investasi =  $u_perusahaan->trinvestasi->get();

        $data = $this->_funcwilayah();
        $data['save_method'] = "update";
        $data['id_perusahaan'] = $id_perusahaan;
        $data['nama_perusahaan'] = $u_perusahaan->n_perusahaan;
        $data['reg_perusahaan'] = $u_perusahaan->no_reg_perusahaan;
        $data['npwp'] = $u_perusahaan->npwp;
        $data['telp_perusahaan'] = $u_perusahaan->i_telp_perusahaan;
        $data['alamat_usaha'] = $u_perusahaan->a_perusahaan;
		$data['nodaftar'] = $u_perusahaan->no_reg_perusahaan;
        $data['statusOnline'] = 0;
		$data['fax'] = $u_perusahaan->fax;
		$data['email'] = $u_perusahaan->email;
        $data['propinsi_usaha'] = $u_propinsi->id;
        $data['kabupaten_usaha'] = $u_kabupaten->id;
        $data['kecamatan_usaha'] = $u_kecamatan->id;
        $data['kelurahan_usaha'] = $u_kelurahan->id;
        $data['jenis_kegiatan'] = $u_kegiatan->id;
        $data['jenis_investasi'] = $u_investasi->id;

        $js = "
                $(document).ready(function() {
                    $('#form').validate();
                    $(\"#tabs\").tabs();
                } );

                $(function() {
                    $(\"#inputTanggal1\").datepicker({
                        changeMonth: true,
                        changeYear: true,
                        dateFormat: 'yy-mm-dd',
                        closeText: 'X'
                    });
                    $(\"#inputTanggal2\").datepicker({
                        changeMonth: true,
                        changeYear: true,
                        dateFormat: 'yy-mm-dd',
                        closeText: 'X'
                    });
                });

                $(document).ready(function() {
                        $('#propinsi_usaha_id').change(function(){
                            $.post('" . base_url() . "perusahaan/kabupaten_usaha', { propinsi_id: $('#propinsi_usaha_id').val() },
                                function(data) {
                                    $('#show_kabupaten_usaha').html(data);
                                    $('#show_kecamatan_usaha').html('Data Tidak tersedia');
                                    $('#show_kelurahan_usaha').html('Data Tidak tersedia');
                                });
                        });
                });

                function finishAjax(id, response){
                  $('#'+id).html(unescape(response));
                  $('#'+id).fadeIn();
                }
            ";
//			base_url() . "pelayanan/pendaftaran/kabupaten_usaha',

        $this->template->set_metadata_javascript($js);
        $this->load->vars($data);
        $this->session_info['page_name'] = "Edit Data Perusahaan";
        $this->template->build('perusahaan_edit', $this->session_info);
    }

    /* Save and update for manipulating data. */
    public function save() {
        $perusahaan = new tmperusahaan();
        $perusahaan->get_by_id($this->input->post('id_perusahaan'));
        $perusahaan->no_reg_perusahaan = $this->input->post('reg_perusahaan');
        $perusahaan->n_perusahaan = $this->input->post('nama_perusahaan');
        $perusahaan->npwp = $this->input->post('npwp');
        $perusahaan->i_telp_perusahaan = $this->input->post('telp_perusahaan');
        $perusahaan->a_perusahaan = $this->input->post('alamat_usaha');
        $kelurahan_u = new trkelurahan();
        $kelurahan_u->get_by_id($this->input->post('kelurahan_usaha'));
        $kegiatan = new trkegiatan();
        $kegiatan->get_by_id($this->input->post('jenis_kegiatan'));
        $investasi = new trinvestasi();
        $investasi->get_by_id($this->input->post('jenis_investasi'));

        if (!$perusahaan->save(array($kelurahan_u, $kegiatan, $investasi))) {
            echo '<p>' . $perusahaan->error->string . '</p>';
        } else {
            $tgl = date("Y-m-d H:i:s");
            $u_ser = $this->session->userdata('username');
            $g = $this->sql($u_ser);
//         $jam = date("H:i:s A");
            //$p = $this->db->query("call log ('Perusahaan','Input data perusahaan','" . $tgl . "','" . $u_ser . "')");
            redirect('perusahaan');
        }
    }

    public function update() {
		$id_per = $this->input->post('id_perusahaan');
        $perusahaan = new tmperusahaan();
        $perusahaan->get_by_id($id_per);
        $perusahaan->n_perusahaan = $this->input->post('nama_perusahaan');
        $perusahaan->no_reg_perusahaan = $this->input->post('reg_perusahaan');
        $perusahaan->npwp = $this->input->post('npwp');
        $perusahaan->i_telp_perusahaan = $this->input->post('telp_perusahaan');
        $perusahaan->a_perusahaan = $this->input->post('alamat_usaha');
        $perusahaan->no_reg_perusahaan = $this->input->post('nodaftar');
        $perusahaan->fax = $this->input->post('fax');
        $perusahaan->email = $this->input->post('email');
        $perusahaan->save();

        $perusahaan_lurah = new tmperusahaan_trkelurahan();
        $perusahaan_lurah->where('tmperusahaan_id', $id_per)->get();
		if(!$perusahaan_kegiatan->trkegiatan_id){
            $perusahaan_lurah = new tmperusahaan_trkelurahan();
			$perusahaan_lurah->tmperusahaan_id = $id_per;
		}
        $perusahaan_lurah->trkelurahan_id = $this->input->post('kelurahan_usaha');
        $perusahaan_lurah->save();

        $perusahaan_kegiatan = new tmperusahaan_trkegiatan();
        $perusahaan_kegiatan->where('tmperusahaan_id', $id_per)->get();
		if(!$perusahaan_kegiatan->trkegiatan_id){
            $perusahaan_kegiatan = new tmperusahaan_trkegiatan();
            $perusahaan_kegiatan->tmperusahaan_id = $id_per;
		}
        $perusahaan_kegiatan->trkegiatan_id = $this->input->post('jenis_kegiatan');
        $perusahaan_kegiatan->save();

        $perusahaan_investasi = new tmperusahaan_trinvestasi();
        $perusahaan_investasi->where('tmperusahaan_id', $id_per)->get();
		if(!$perusahaan_investasi->trinvestasi_id){
            $perusahaan_investasi = new tmperusahaan_trinvestasi();
            $perusahaan_investasi->tmperusahaan_id = $id_per;
		}
        $perusahaan_investasi->trinvestasi_id = $this->input->post('jenis_investasi');
		$perusahaan_investasi->save();

        $tgl = date("Y-m-d H:i:s");
        $u_ser = $this->session->userdata('username');
        $g = $this->sql($u_ser);
//      $jam = date("H:i:s A");
        //$p = $this->db->query("call log ('Perusahaan','Edit data perusahaan','" . $tgl . "','" . $u_ser . "')");
        redirect('perusahaan');
    }

    public function delete($uid = NULL) {
        $kelurahan = new tmperusahaan_trkelurahan();
        $kelurahan->where('tmperusahaan_id', $uid);
        $kelurahan->delete();
        $investasi = new tmperusahaan_trinvestasi();
        $investasi->where('tmperusahaan_id', $uid);
        $investasi->delete();
        $kegiatan = new tmperusahaan_trkegiatan();
        $kegiatan->where('tmperusahaan_id', $uid);
        $kegiatan->delete();

        $perusahaan = new tmperusahaan();
        $perusahaan->get_by_id($uid);
        $perusahaan->delete();

        $tgl = date("Y-m-d H:i:s");
        $u_ser = $this->session->userdata('username');
        $g = $this->sql($u_ser);
//      $jam = date("H:i:s A");
        //$p = $this->db->query("call log ('Perusahaan','Hapus data perusahaan','" . $tgl . "','" . $u_ser . "')");
        redirect('perusahaan');
    }

    public function sql($u_ser) {
        $query = "select a.description from user_auth as a
                  inner join user_user_auth as  x on a.id = x.user_auth_id
                  inner join user as b on b.id = x.user_id
                  where b.id = (select id from user where username='" . $u_ser . "')";
        $hasil = $this->db->query($query);
        return $hasil->row();
    }

	 public function kabupaten_usaha() {     // masuk setelah pilih Provinsi => data perusahaan
        $data['kabupaten_id'] = 'kabupaten_usaha';
        $data['kecamatan_id'] = 'kecamatan_usaha';
        $data['kelurahan_id'] = 'kelurahan_usaha';
        $data['kelurahan_link'] = 'kelurahan_usaha_idKab';

        $this->load->vars($data);
        $this->load->view('kabupaten_load_perusahaan', $data);
    }

    public function kecamatan_usaha() {      // masuk setelah pilih Kabupaten => data perusahaan
        $data['kecamatan_id'] = 'kecamatan_usaha';
        $data['kelurahan_id'] = 'kelurahan_usaha';

        $this->load->vars($data);
        $this->load->view('kecamatan_load_perusahaan', $data);
    }

    public function kelurahan_usaha() {     // masuk setelah pilih Kecamatan => data perusahaan
        $data['kelurahan_id'] = 'kelurahan_usaha';

        $this->load->vars($data);
        $this->load->view('kelurahan_load_perusahaan', $data);
    }

    //Fungsi untuk mencari id pemohon apakah sudah ada atau tidak
    public function npwp_exist($npwp) {
        //$this->db->debug=1;
        $this->db->where('npwp', $npwp);
        $query = $this->db->get('tmperusahaan');
        if ($query->num_rows() > 0) {
            echo "1";
        }else{
            echo "0";
        }
    }

    public function register_npwp_exist(){
        $npwp = mysql_real_escape_string($_POST['npwp']);
        $sql = "SELECT npwp FROM tmperusahaan WHERE npwp = '$npwp'";
        $hasil = $this->db->query($sql);
        $result = $hasil->row();
        if($result) {
            $output = false;
        } else {
            $output = true;
        }
        echo json_encode($output);
    }
}