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
class Info_publik extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->tminfopublic =new tminfopublic();
    }
    function index()
    {
        $this->beritalist() ;
    }

    function beritalist() 
    {
        $this->load->library('pagination');
        $data['isi'] = 'isi_info_publik';
        $data['title'] = 'Daftar Info Publik';
        
        

        $config['base_url'] = base_url().'main/info_publik/beritalist';
        $config['total_rows'] = $this->tminfopublic->where("C_STATUS_BERITA = 1")->count();
        $config['per_page'] = 5;
        $config['uri_segment'] = 4;
        $config['full_tag_open'] = '<p class="paging">';
        $config['full_tag_close'] = '</p>';
        $this->pagination->initialize($config);

        $data['link_pagging']= $this->pagination->create_links();


        $hal=$this->uri->segment(4,0);
        $data['berita'] = $this->tminfopublic->where("C_STATUS_BERITA = 1 order by D_BERITA desc")->limit(5, $hal)->get();
        
        $data['menu']=  $this->load->view('parsing/menu_right','',true);
        $data['menu1']=  $this->load->view('parsing/menu_right_2','',true);
        
        $this->load->view('template', $data);
    }
    
    function search(){
        $id=$this->input->post('id');
        
        
        $this->load->library('pagination');
        $data['isi'] = 'isi_info_publik';
        $data['title'] = 'Daftar Info Publik ';
        
        

        $config['base_url'] = base_url().'main/info_publik/search';
        $config['total_rows'] = $this->tminfopublic->where("C_STATUS_BERITA = 1 AND N_JUDUL_BERITA like'%".$id."%'")->count();
        $config['per_page'] = 5;
        $config['uri_segment'] = 4;
        $config['full_tag_open'] = '<p class="paging">';
        $config['full_tag_close'] = '</p>';
        $this->pagination->initialize($config);

        $data['link_pagging']= $this->pagination->create_links();


        $hal=$this->uri->segment(4,0);
        $data['berita'] = $this->tminfopublic->where("C_STATUS_BERITA = 1 AND N_JUDUL_BERITA like '%".$id."%' order by D_BERITA desc")->limit(5, $hal)->get();
        
        $data['menu']=  $this->load->view('parsing/menu_right','',true);
        $data['menu1']=  $this->load->view('parsing/menu_right_2','',true);
        
        $this->load->view('template', $data);        
    }


    function lihat_detail($ke){
        $data['isi'] = 'isi_info_publik_det';
        $data['title'] = 'Daftar Info Publik';
        
        $data['berita'] = $this->tminfopublic->where("C_BERITA = $ke")->get();
        
        $data['menu']=  $this->load->view('parsing/menu_right','',true);
        $data['menu1']=  $this->load->view('parsing/menu_right_2','',true);
        
        $this->load->view('template', $data);
    }

  //   public function testmail() {
  //       $sendE = FALSE;
  //       $base_url         = 'assets/pendaftaran/';
  //         $host             = "mail.jabarprov.go.id";
  //         $emailpengirim    = "dpmptsp-online@jabarprov.go.id"; //sebelumnya dpmptspjabar@gmail.com
  //         $namapengirim     = "DPMPTSP JABAR";
  //         $password         = "~jabarjuara2019";
  //         $targetpengiriman = "nirwan.nrs@gmail.com";
  //         require("".$base_url."back/plugins/phpmailer/class.phpmailer.php");
  //         require("".$base_url."back/plugins/phpmailer/class.smtp.php");
  //         $mailer = new PHPMailer();
  //         $mailer->CharSet = "UTF-8";
  //         $mailer->IsSMTP();
  //         $mailer->SMTPSecure = 'tls';
  //         $mailer->Host =$host;
  //         $mailer->Port =587;
  //         $mailer->SMTPAuth = true;
  //         $mailer->Username = $emailpengirim;
  //         $mailer->Password = $password;
  //         $mailer->FromName = $namapengirim;
  //         $mailer->From = $emailpengirim;
  //         $mailer->AddAddress($targetpengiriman,$targetpengiriman);
  //         $mailer->Subject = 'Testing';
  //         $isi  = "<p>Terima Kasih</p>";
  //         $mailer->Body = $isi;
  //         $mailer->AltBody = $isi;
  //         if($mailer->Send()) $sendE = TRUE;

  //         if ($sendE) {
  //             echo "OK";die;
  //         } else {
  //           echo $mailer->ErrorInfo;die;
  //         }
  // }

    
}

?>
