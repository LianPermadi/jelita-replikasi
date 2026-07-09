<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of welcome
 *
 * @author Obi
 */
class Admin_jajak extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->tmjajak =new tmjajak();
        $this->tmjajak_det =new tmjajak_det();
         $login= $this->session->userdata('login');
        $peran= $this->session->userdata('n_otoritas');
        if (!$login) {
            redirect('admin');
        }
        if ($peran != 'Administrator'){
            redirect('admin');
        }
    }

    function index(){
        $data['isi']='isi';
        $data['title']='Mengelola Jajak';
        $data['judul']='Mengelola Jajak';
        $data['list']=  $this->tmjajak->get();
        
        $this->load->view('template_admin',$data);
    }

    function tambah(){
        
        $data['C_JAJAK']='';
        $data['D_PRD_AWAL']='';
        $data['D_PRD_AKHIR']='';
        $data['N_TANYA']='';
        
 
        $data['N_PILIHAN1']='';
        $data['N_PILIHAN2']='';    
        $data['N_PILIHAN3']='';
        $data['N_PILIHAN4']='';        
        $data['N_PILIHAN5']='';        
        
        $data['ID_PILIHAN1']='';
        $data['ID_PILIHAN2']='';    
        $data['ID_PILIHAN3']='';
        $data['ID_PILIHAN4']='';        
        $data['ID_PILIHAN5']='';         
        
        
        
        $data['isi']='form';
        $data['title']='Tambah Data Jajak';
        $data['judul']='Tambah Data Jajak';
        $this->load->view('template_admin',$data);        
    }   
   
    function edit($id=null){
        
        $dt =  $this->tmjajak->where("C_JAJAK = '$id'")->get();
        
        $data['C_JAJAK']=$dt->C_JAJAK;
        $data['D_PRD_AWAL']=$dt->D_PRD_AWAL;
        $data['D_PRD_AKHIR']=$dt->D_PRD_AKHIR;
        $data['N_TANYA']=$dt->N_TANYA;
        $data['I_ENTRY']=$dt->I_ENTRY;
        $data['D_ENTRY']=$dt->D_ENTRY;
        $data['C_KATEGORI']=$dt->C_KATEGORI;
        $data['STATUS']=$dt->STATUS;    
        
        //DETAIL
        
        $data['ID_PILIHAN1']='';
        $data['ID_PILIHAN2']='';    
        $data['ID_PILIHAN3']='';
        $data['ID_PILIHAN4']='';        
        $data['ID_PILIHAN5']=''; 
        
        $data['N_PILIHAN1']='';
        $data['N_PILIHAN2']='';    
        $data['N_PILIHAN3']='';
        $data['N_PILIHAN4']='';        
        $data['N_PILIHAN5']=''; 
        
        
        $list_pilihan =  $this->tmjajak_det->where("C_JAJAK = '$id'")->get();

        $i=1;
        foreach ($list_pilihan as $value) {
             $data["ID_PILIHAN$i"]=$value->C_PILJAJAK;
             $data["N_PILIHAN$i"]=$value->N_PILIHAN;
             $i++;
        }
        
        
        $data['isi']='form';
        $data['title']='Edit Data Jajak';
        $data['judul']='Edit Data Jajak';
        $this->load->view('template_admin',$data);        
    }   
    
    function delete($id){
        $this->tmjajak->delete($id); 
        
        $this->tmjajak_det->delete($id);
        
        redirect('admin_jajak');
    }    
    
    function save(){
        
            $id=$this->input->post('C_JAJAK');
            
            if($this->input->post('status')=="1")
            {
                    $this->tmjajak->nonactive_all();
            }
            if($id==""){
                
                $n=$this->tmjajak->get_max();
                $pri=$n->max+1;      
                
                $data = array(
                        'C_JAJAK'       =>$pri,
                        'D_PRD_AWAL'    =>$this->input->post('tgl1'),
                        'D_PRD_AKHIR'   =>$this->input->post('tgl2'),
                        'N_TANYA'       =>$this->input->post('judul'),
                        'I_ENTRY'       =>'admin',
                        'D_ENTRY'       =>date('Y-m-d H:i:s'),
                        'STATUS'        =>$this->input->post('status')
                );
                $this->tmjajak->insert($data);    
                
                
                $data2 = array(
                        'C_JAJAK'     =>$pri, 'N_PILIHAN'=>$this->input->post('pil1'), 'C_PILIHAN' => 0
                );
                $this->tmjajak_det->insert($data2);  
                
                $data2 = array(
                        'C_JAJAK'     =>$pri, 'N_PILIHAN'=>$this->input->post('pil2'), 'C_PILIHAN' => 0
                );
                $this->tmjajak_det->insert($data2); 
                
                $data2 = array(
                        'C_JAJAK'     =>$pri, 'N_PILIHAN'=>$this->input->post('pil3'), 'C_PILIHAN' => 0
                );
                $this->tmjajak_det->insert($data2); 
                
                $data2 = array(
                        'C_JAJAK'     =>$pri, 'N_PILIHAN'=>$this->input->post('pil4'), 'C_PILIHAN' => 0
                );
                $this->tmjajak_det->insert($data2); 
                
                $data2 = array(
                        'C_JAJAK'     =>$pri, 'N_PILIHAN'=>$this->input->post('pil5'), 'C_PILIHAN' => 0
                );
                $this->tmjajak_det->insert($data2);                 
            }
            else{
                $data = array(
                        'D_PRD_AWAL'    =>$this->input->post('tgl1'),
                        'D_PRD_AKHIR'   =>$this->input->post('tgl2'),
                        'N_TANYA'       =>$this->input->post('judul'),
                        'I_ENTRY'       =>'admin',
                        'D_ENTRY'       =>date('Y-m-d H:i:s'),
                        'STATUS'        =>$this->input->post('status')
                );
                $this->tmjajak->update($id, $data);  
                
                //update
                $id=$this->input->post('ID_PILIHAN1');
                $data2 = array(
                        'N_PILIHAN'=>$this->input->post('pil1'), 'C_PILIHAN' => 0
                );
                $this->tmjajak_det->update($id, $data2);  
                
                //update
                $id=$this->input->post('ID_PILIHAN2');
                $data2 = array(
                         'N_PILIHAN'=>$this->input->post('pil2'), 'C_PILIHAN' => 0
                );
                $this->tmjajak_det->update($id, $data2); 
                
                //update
                $id=$this->input->post('ID_PILIHAN3');
                $data2 = array(
                       'N_PILIHAN'=>$this->input->post('pil3'), 'C_PILIHAN' => 0
                );
                $this->tmjajak_det->update($id, $data2); 
                
                //update
                $id=$this->input->post('ID_PILIHAN4');
                $data2 = array(
                        'N_PILIHAN'=>$this->input->post('pil4'), 'C_PILIHAN' => 0
                );
                $this->tmjajak_det->update($id, $data2); 
                
                //update
                $id=$this->input->post('ID_PILIHAN5');
                $this->tmjajak_det->update($id, $data2);  
                $data2 = array(
                       'N_PILIHAN'=>$this->input->post('pil5'), 'C_PILIHAN' => 0
                );
                $this->tmjajak_det->update($id, $data2);                   
                
                
                
            }
            
            redirect('admin_jajak');        
    }
    
    
    function hasil_jajak($id){
        $data['isi']='isi_jajak';
        $data['title']='Hasil Data Jajak';
        $data['judul']='Hasil Data Jajak';
        $data['id']=$id;
        
        $this->load->view('template_admin',$data);
    }    
}

?>
