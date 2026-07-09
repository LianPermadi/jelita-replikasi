<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 *  @author  R; 
 */

class C_jenisizin extends Controller {
	public function __construct() {
        parent::__construct();
       $this->load->model("m_jenisizin");
   }
   public function index() {

        $data['content_view'] = 'v_jenisizin';
        $data['izintrayek_table'] = $this->create_jenis_izin();
        $this->load->vars($data);

 
       $this->load->view('v_jenisizin');
    }

    function create_jenis_izin()
    {
        $jenisizin = $this->m_jenisizin->get_all_jenisizin();
        $jenisizin_table = "";
$counter = 0;
        if(count($jenisizin) > 0)
        {
            foreach ($jenisizin as $key => $value)
            {
                $counter = $counter+1;
                $jenisizin_table .="<tr>";
                $jenisizin_table .="<td align='center'>{$counter}</td>";
               $jenisizin_table .="<td align=''>{$value->n_perizinan}</td>";
                 $jenisizin_table .="<td align='center'>{$value->v_hari}</td>";
             
               $jenisizin_table .="<td align='center'>
          
                <a href='".base_url()."jenisizin/c_jenisizin/detail_syarat/{$value->id}' title='lihat Persyaratan'><!--<img src=".base_url()."assets/images/icon/sk.png>-->
Lihat Persyaratan
                </a> 
</td>
<td>
                <a href='../../../spekta/main/jenis_perizinan/cetak_syarat/{$value->id}' title='lihat Persyaratan' target='_blank'><!--<img src=".base_url()."assets/images/icon/sk.png>-->
Cetak
                </a>
               
               </td>";
                $jenisizin_table .="</tr>";
            }
            return $jenisizin_table;
        }
    }

    function detail_syarat($id)
    { 

    $where = $id;
       $data['bb_izintrayek'] = $this->m_jenisizin->get_detail_syarat($where)->result();
        $this->load->vars($data);
        $this->load->view('v_syaratjenisizin');
    }

}