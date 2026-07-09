<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Product_model extends CI_Model
{
    private $_table = "euis_slipgaji";

    public $id;
    public $thp;
    public $t_gaji_pokok;
    public $t_pasangan;
  public $t_anak; public $t_umum; public $t_struktural; public $t_beras; public $t_khususpph21; public $t_pembulatan; public $t_jumlah; public $rapel_gaji; public $ket_rapel_gaji; public $p_beras; public $p_iuranwajib; public $p_askes; public $p_pph; public $a_p_srumah; public $a_p_hutang; public $p_cicilanrumah; public $a_2_lainnya; public $p_cicilanbank; public $p_iurankoperasipemda; public $p_cicilankoperasipemda; public $jumlahpotongan; public $gajiterima; public $bp_ttpbruto; public $rapel_tol; public $bp_prosentasettp; public $bp_ttpnett; public $bp_pajakttp; public $t_jumlahttp; public $bp_zakatttp; public $bp_koperasipraja; public $bp_simpanankopraja; public $bp_koperasipemda; public $bp_bankttp; public $bp_lainnya; public $bp_jumlahpotonganttp; public $t_tpp; public $jlh_kompen; public $id_pegawai; public $bulan; 

    public function rules()
    {
        return [
           
            ['field' => 'price',
            'label' => 'Price',
            'rules' => 'numeric']
        ];
    }

    public function getAll()
    {
       // return $this->db->get($this->_table)->result();
       return $this->db->query(" SELECT A.*,  B.n_pegawai
        FROM euis_slipgaji A
        left join tmpegawai B on replace(B.nip,' ', '') = replace(A.id_pegawai,' ', '') ")->result();
    }
    
    public function getById($id)
    {
        return $this->db->get_where($this->_table, ["id" => $id])->row();
    }

    public function save()
    {
        $post = $this->input->post();
        $this->thp = $post["thp"];
        $this->id_pegawai = $post["id_pegawai"]; $this->bulan = $post["bulan"]; 
        $this->t_gaji_pokok = $post["t_gaji_pokok"];
        $this->t_pasangan = $post["t_pasangan"];
        $this->t_anak = $post["t_anak"]; $this->t_umum = $post["t_umum"]; $this->t_struktural = $post["t_struktural"]; $this->t_beras = $post["t_beras"]; $this->t_khususpph21 = $post["t_khususpph21"]; $this->t_pembulatan = $post["t_pembulatan"]; $this->t_jumlah = $post["t_jumlah"]; $this->rapel_gaji = $post["rapel_gaji"]; $this->ket_rapel_gaji = $post["ket_rapel_gaji"]; $this->p_beras = $post["p_beras"]; $this->p_iuranwajib = $post["p_iuranwajib"]; $this->p_askes = $post["p_askes"]; $this->p_pph = $post["p_pph"]; $this->a_p_srumah = $post["a_p_srumah"]; $this->a_p_hutang = $post["a_p_hutang"]; $this->p_cicilanrumah = $post["p_cicilanrumah"]; $this->a_2_lainnya = $post["a_2_lainnya"]; $this->p_cicilanbank = $post["p_cicilanbank"]; $this->p_iurankoperasipemda = $post["p_iurankoperasipemda"]; $this->p_cicilankoperasipemda = $post["p_cicilankoperasipemda"]; $this->jumlahpotongan = $post["jumlahpotongan"]; $this->gajiterima = $post["gajiterima"]; $this->bp_ttpbruto = $post["bp_ttpbruto"]; $this->rapel_tol = $post["rapel_tol"]; $this->bp_prosentasettp = $post["bp_prosentasettp"]; $this->bp_ttpnett = $post["bp_ttpnett"]; $this->bp_pajakttp = $post["bp_pajakttp"]; $this->t_jumlahttp = $post["t_jumlahttp"]; $this->bp_zakatttp = $post["bp_zakatttp"]; $this->bp_koperasipraja = $post["bp_koperasipraja"]; $this->bp_simpanankopraja = $post["bp_simpanankopraja"]; $this->bp_koperasipemda = $post["bp_koperasipemda"]; $this->bp_bankttp = $post["bp_bankttp"]; $this->bp_lainnya = $post["bp_lainnya"]; $this->bp_jumlahpotonganttp = $post["bp_jumlahpotonganttp"]; $this->t_tpp = $post["t_tpp"]; $this->jlh_kompen = $post["jlh_kompen"]; 
        $this->db->insert($this->_table, $this);
    }

    public function update()
    {
        $post = $this->input->post();
        $this->id = $post["id"];
        $this->thp = $post["thp"];
         $this->id_pegawai = $post["id_pegawai"];
        $this->t_pasangan = $post["t_pasangan"];
        $this->t_gaji_pokok = $post["t_gaji_pokok"];
        $this->t_anak = $post["t_anak"]; $this->t_umum = $post["t_umum"]; $this->t_struktural = $post["t_struktural"]; $this->t_beras = $post["t_beras"]; $this->t_khususpph21 = $post["t_khususpph21"]; $this->t_pembulatan = $post["t_pembulatan"]; $this->t_jumlah = $post["t_jumlah"]; $this->rapel_gaji = $post["rapel_gaji"]; $this->ket_rapel_gaji = $post["ket_rapel_gaji"]; $this->p_beras = $post["p_beras"]; $this->p_iuranwajib = $post["p_iuranwajib"]; $this->p_askes = $post["p_askes"]; $this->p_pph = $post["p_pph"]; $this->a_p_srumah = $post["a_p_srumah"]; $this->a_p_hutang = $post["a_p_hutang"]; $this->p_cicilanrumah = $post["p_cicilanrumah"]; $this->a_2_lainnya = $post["a_2_lainnya"]; $this->p_cicilanbank = $post["p_cicilanbank"]; $this->p_iurankoperasipemda = $post["p_iurankoperasipemda"]; $this->p_cicilankoperasipemda = $post["p_cicilankoperasipemda"]; $this->jumlahpotongan = $post["jumlahpotongan"]; $this->gajiterima = $post["gajiterima"]; $this->bp_ttpbruto = $post["bp_ttpbruto"]; $this->rapel_tol = $post["rapel_tol"]; $this->bp_prosentasettp = $post["bp_prosentasettp"]; $this->bp_ttpnett = $post["bp_ttpnett"]; $this->bp_pajakttp = $post["bp_pajakttp"]; $this->t_jumlahttp = $post["t_jumlahttp"]; $this->bp_zakatttp = $post["bp_zakatttp"]; $this->bp_koperasipraja = $post["bp_koperasipraja"]; $this->bp_simpanankopraja = $post["bp_simpanankopraja"]; $this->bp_koperasipemda = $post["bp_koperasipemda"]; $this->bp_bankttp = $post["bp_bankttp"]; $this->bp_lainnya = $post["bp_lainnya"]; $this->bp_jumlahpotonganttp = $post["bp_jumlahpotonganttp"]; $this->t_tpp = $post["t_tpp"]; $this->jlh_kompen = $post["jlh_kompen"];  $this->bulan = $post["bulan"]; 
        $this->db->update($this->_table, $this, array('id' => $post['id']));
    }

     public function duplikat($id)
    {
         $query =  $this->db->get_where($this->_table, ["id" => $id]);
         //var_dump($query);die();
         foreach ($query->result() as $row){
                $this->thp = $row->thp; $this->t_gaji_pokok = $row->t_gaji_pokok; $this->t_pasangan = $row->t_pasangan; $this->t_anak = $row->t_anak; $this->t_umum = $row->t_umum; $this->t_struktural = $row->t_struktural; $this->t_beras = $row->t_beras; $this->t_khususpph21 = $row->t_khususpph21; $this->t_pembulatan = $row->t_pembulatan; $this->t_jumlah = $row->t_jumlah; $this->rapel_gaji = $row->rapel_gaji; $this->ket_rapel_gaji = $row->ket_rapel_gaji; $this->p_beras = $row->p_beras; $this->p_iuranwajib = $row->p_iuranwajib; $this->p_askes = $row->p_askes; $this->p_pph = $row->p_pph; $this->a_p_srumah = $row->a_p_srumah; $this->a_p_hutang = $row->a_p_hutang; $this->p_cicilanrumah = $row->p_cicilanrumah; $this->a_2_lainnya = $row->a_2_lainnya; $this->p_cicilanbank = $row->p_cicilanbank; $this->p_iurankoperasipemda = $row->p_iurankoperasipemda; $this->p_cicilankoperasipemda = $row->p_cicilankoperasipemda; $this->jumlahpotongan = $row->jumlahpotongan; $this->gajiterima = $row->gajiterima; $this->bp_ttpbruto = $row->bp_ttpbruto; $this->rapel_tol = $row->rapel_tol; $this->bp_prosentasettp = $row->bp_prosentasettp; $this->bp_ttpnett = $row->bp_ttpnett; $this->bp_pajakttp = $row->bp_pajakttp; $this->t_jumlahttp = $row->t_jumlahttp; $this->bp_zakatttp = $row->bp_zakatttp; $this->bp_koperasipraja = $row->bp_koperasipraja; $this->bp_simpanankopraja = $row->bp_simpanankopraja; $this->bp_koperasipemda = $row->bp_koperasipemda; $this->bp_bankttp = $row->bp_bankttp; $this->bp_lainnya = $row->bp_lainnya; $this->bp_jumlahpotonganttp = $row->bp_jumlahpotonganttp; $this->t_tpp = $row->t_tpp; $this->jlh_kompen = $row->jlh_kompen; $this->id_pegawai = $row->id_pegawai; $this->bulan = $row->bulan; 
            }
        return   $this->db->insert($this->_table, $this);
    }

    public function delete($id)
    {
        return $this->db->delete($this->_table, array("id" => $id));
	}
	
	
}
