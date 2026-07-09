<?php
class Mrevisi extends Model {

    var $tabel = 'api_pesan';

    function __construct() {
        parent::__construct();
    }
	function update_revisi() {
        
        
           /* $update = $this->input->post('msg');
            $jenis = $this->input->post('jenis');
            $uraian_barang = $this->input->post('uraian_barang');
*/
$update = $this->input->post('msg');
$jenis_api = $this->input->post('jenis_api');
$uraian_barang = $this->input->post('uraian_barang');
$hs10digit = $this->input->post('hs10digit');
$volume = $this->input->post('volume');
$satuan = $this->input->post('satuan');
$harga_satuan = $this->input->post('harga_satuan');
$nilai_cif = $this->input->post('nilai_cif');
$nilai_cnf = $this->input->post('nilai_cnf');
$nilai_fob = $this->input->post('nilai_fob');
$currency = $this->input->post('currency');
$negara_asal = $this->input->post('negara_asal');
$pelabuhan_asal = $this->input->post('pelabuhan_asal');
$pelabuhan_tujuan = $this->input->post('pelabuhan_tujuan');
$nomor_ls = $this->input->post('nomor_ls');
$tgl_ls = $this->input->post('tgl_ls');
$nomor_pib = $this->input->post('nomor_pib');
$tgl_pib = $this->input->post('tgl_pib');
$status = $this->input->post('status');

$x=0;
           for ($i=0; $i < count($update) ; $i++) {  

                    $data = array(
                        'jenis_api'=>$jenis_api[$x],
                        'uraian_barang'=>$uraian_barang[$x],
                        'hs10digit'=>$hs10digit[$x],
                        'volume'=>$volume[$x],
                        'satuan'=>$satuan[$x],
                        'harga_satuan'=>$harga_satuan[$x],
                        'nilai_cif'=>$nilai_cif[$x],
                        'nilai_cnf'=>$nilai_cnf[$x],
                        'nilai_fob'=>$nilai_fob[$x],
                        'currency'=>$currency[$x],
                        'negara_asal'=>$negara_asal[$x],
                        'pelabuhan_asal'=>$pelabuhan_asal[$x],
                        'pelabuhan_tujuan'=>$pelabuhan_tujuan[$x],
                        'nomor_ls'=>$nomor_ls[$x],
                        'tgl_ls'=>$tgl_ls[$x],
                        'nomor_pib'=>$nomor_pib[$x],
                        'tgl_pib'=>$tgl_pib[$x],
                        'flag'=>$status[$x],
                        ); 
                $this->db->where('id', $update[$i]);
                $this->db->update('api_realisasi_import',$data);
                $x++;
            }
             
    }

        
           
}
?>