<?php
class Ikm extends WRC_AdminCont {

public function __construct() {
        parent::__construct();
		
        
		
    }


function tambahdata(){
if($this->input->post('submit')){
$this->load->model('mikm');
$this->mikm->tambah();
redirect('ikm/index');
}
$this->load->view('tambahikm');
$this->session_info['page_name'] = "Tambah Data IKM";
        $this->template->build('tambahikm', $this->session_info);
}
function index(){
$this->load->model('mikm');
$data['hasilikm'] = $this->mikm->ambildata();
$this->load->view('vnilai',$data);
 $this->session_info['page_name'] = "Data IKM";
        $this->template->build('vnilai', $this->session_info);
}

function updatedata($id){
if($_POST==NULL){
$this->load->model('mikm');
$data['hasilikm'] = $this->mikm->select($id);
$this->load->view('ubahikm',$data);
$this->session_info['page_name'] = "Ubah Data IKM";
        $this->template->build('ubahikm', $this->session_info);
}else{
$this->load->model('mikm');

$data['hasilikm'] = $this->mikm->update($id);
redirect('ikm/index');
 $this->session_info['page_name'] = "Ubah Data IKM";
        $this->template->build('ubahikm', $this->session_info);
}

}
function hapusdata($id){
$this->db->delete('tmikmnilai',array('id'=>$id));
redirect('ikm/index');
} 
function filterdata()
	{
	


        $this->session_info['page_name'] = " Index Kepuasan Masyarakat Perbidang";
        $this->template->build('list', $this->session_info);
    }
	 public function tampildata() {
        $tgla = $this->input->post('tgla');
        
            $data['tgla'] = $tgla;
           
        $this->load->vars($data);
      

        $this->session_info['page_name'] = "Index Kepuasan Masyarakat Perbidang";
        $this->template->build('view', $this->session_info);
    }
	public function lwview($id = null, $tgla = null) {  // per Sektor Ijin
        $d['page_name'] = "Index Kepuasan Masyarakat Perbidang";
        //$this->permohonan->where("date(d_entry) between '$tgla' and '$tglb'")->get();
		//$this->permohonan->where_related("trstspermohonan", 'id <> 1')->where("trsektor_id = '$id' AND d_terima_berkas between '$tgla' and '$tglb'")->get();
        //$d['list'] = $this->perizinan->where('id',$id)->get();
        $d['tgla'] = $tgla;
       // $d['tglb'] = $tglb;
        $d['sektor_id'] = $id;
		//$d['sektor'] = $sektor;
        $this->load->vars($d);
        $this->load->view('lwview', $d);
    }public function leview($id = null, $tgla = null) {  // per Sektor Ijin
        $d['page_name'] = "Index Kepuasan Masyarakat Perbidang";
        //$this->permohonan->where("date(d_entry) between '$tgla' and '$tglb'")->get();
		//$this->permohonan->where_related("trstspermohonan", 'id <> 1')->where("trsektor_id = '$id' AND d_terima_berkas between '$tgla' and '$tglb'")->get();
        //$d['list'] = $this->perizinan->where('id',$id)->get();
        $d['tgla'] = $tgla;
       // $d['tglb'] = $tglb;
        $d['sektor_id'] = $id;
		//$d['sektor'] = $sektor;
        $this->load->vars($d);
        $this->load->view('leview', $d);
    }
function filterdatasemuabidang()
	{
	


        $this->session_info['page_name'] = "Index Kepuasan Masyarakat Total";
        $this->template->build('listsemuabidang', $this->session_info);
    }
	 public function tampildatasemuabidang() {
        $tgla = $this->input->post('tgla');
        
            $data['tgla'] = $tgla;
           
        $this->load->vars($data);
      

        $this->session_info['page_name'] = "Index Kepuasan Masyarakat Total";
        $this->template->build('viewsemuabidang', $this->session_info);
    }
public function lwviewsemuabidang($id = null, $tgla = null) {  // per Sektor Ijin
        $d['page_name'] = "Index Kepuasan Masyarakat Total";
        //$this->permohonan->where("date(d_entry) between '$tgla' and '$tglb'")->get();
		//$this->permohonan->where_related("trstspermohonan", 'id <> 1')->where("trsektor_id = '$id' AND d_terima_berkas between '$tgla' and '$tglb'")->get();
        //$d['list'] = $this->perizinan->where('id',$id)->get();
        $d['tgla'] = $tgla;
       // $d['tglb'] = $tglb;
        $d['sektor_id'] = $id;
		//$d['sektor'] = $sektor;
        $this->load->vars($d);
        $this->load->view('lwviewsemuabidang', $d);
    }public function leviewsemuabidang($id = null, $tgla = null) {  // per Sektor Ijin
        $d['page_name'] = "Index Kepuasan Masyarakat Total";
        //$this->permohonan->where("date(d_entry) between '$tgla' and '$tglb'")->get();
		//$this->permohonan->where_related("trstspermohonan", 'id <> 1')->where("trsektor_id = '$id' AND d_terima_berkas between '$tgla' and '$tglb'")->get();
        //$d['list'] = $this->perizinan->where('id',$id)->get();
        $d['tgla'] = $tgla;
       // $d['tglb'] = $tglb;
        $d['sektor_id'] = $id;
		//$d['sektor'] = $sektor;
        $this->load->vars($d);
        $this->load->view('leviewsemuabidang', $d);
    }
	}

?>