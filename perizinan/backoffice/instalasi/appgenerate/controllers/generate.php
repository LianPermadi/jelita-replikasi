<?php

class generate extends CI_Controller {
    public function __construct() {
        parent::__construct();
    }
    function index()
    {
       $data['title']="Generate Aplikasi.";
       $data['cekconfig']="Generate Aplikasi.";
       $data['isikontent']=$this->load->view('step1', '', true);
       $this->load->view('header',$data);
    }
    function step2()
    {
        $data['title']="Step 2, Cek requirment";
        $data['isikontent']=$this->load->view('step2', '', true);
        $this->load->view('header',$data);
    }
    function step3()
    {
       $data['title']="Step 3, Cek requirment";
       $data['isikontent']=$this->load->view('step3', '', true);
       $this->load->view('header',$data);
    }
    function step4()
    {
            $data['title']="Step 4, Selesai";
            $data['isikontent']=$this->load->view('step4', '', true);
            $this->load->view('header',$data); 
    }
     function error()
    {

            $data['title']="Redirect Proses";
            $data['isikontent']=$this->load->view('error', '', true);
            $this->load->view('header',$data);       
    }
    function prosescek()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('txthost', 'Nama Host', 'trim|required|xss_clean');
        $this->form_validation->set_rules('txtusername', 'User Name database', 'trim|required|xss_clean');
        $this->form_validation->set_rules('txtpasswd', 'Password database', 'trim|xss_clean');
        $this->form_validation->set_rules('txtnmdb', 'Nama database', 'trim|required|xss_clean');
        $this->form_validation->set_rules('txtprefdb', 'Prefik database', 'trim|required|xss_clean');
        $this->form_validation->set_rules('txtgenerate', 'Status Generate database', 'trim|required|xss_clean');
        
        if ($this->form_validation->run() == FALSE)
        {
            echo validation_errors();
        }
        else
        {
            $host=$this->input->post('txthost', TRUE);
            $username=$this->input->post('txtusername', TRUE);
            $passdb=$this->input->post('txtpasswd', TRUE);
            $nmdb=$this->input->post('txtnmdb', TRUE);
            $prefikdb=$this->input->post('txtprefdb', TRUE);
            $statusdatabase=$this->input->post('txtgenerate', TRUE);
            $linkidentifier=@mysql_connect($host, $username, $passdb);
            if($linkidentifier)
            {
                if($statusdatabase==1)
                {
                    @mysql_query("drop database if exists ".$nmdb);
                    @mysql_query("Create database ".$prefikdb.$nmdb);
                    @mysql_select_db($prefikdb.$nmdb,$linkidentifier);
                    $this->__hidenquery($host,$username,$passdb,$nmdb,$prefikdb); 
                    echo "sukses";
                }
                else
                {
                    if(@mysql_select_db($prefikdb.$nmdb,$linkidentifier))
                    {
                        $this->__hidenquery($host,$username,$passdb,$nmdb,$prefikdb);                        
                        echo "sukses";
                    }
                    else
                    {
                        echo "Database Belum tersedia.";
                    }
                }
                
            }
            else
            {
                echo "Username dan Password database login salah.";
            }
        }
    }
    function __hidenquery($host,$username,$passdb,$nmdb,$prefikdb)
    {
       $this->load->helper('file');
       define('BASE_PATH',realpath('.'));
       $alamat= getcwd();
        $linkidentifier=@mysql_connect($host, $username, $passdb);
        @mysql_select_db($prefikdb.$nmdb,$linkidentifier);
        $file_content = file($alamat.'/alp.sql');
        $query = "";
        foreach($file_content as $sql_line)
        {                        
             if(trim($sql_line) != "" && strpos($sql_line, "--") === false)
             {
                    $query .= $sql_line;
                    if (substr(rtrim($query), -1) == ';')
                    {
                           $result = @mysql_query($query);
                           $query = "";
                    }
             }
        }
        $querystring="";
	if (is_file($alamat.'/Trigger.sql')) 
	{
		$file = @fopen($alamat."/Trigger.sql", "r");  
		while(!feof($file))   
		{  
		     $datafile=fgets($file,28192);
		     $querystring .= $datafile;
		     if(strpos($querystring,";;"))
		     {
			@mysql_query($querystring);
			$querystring="";
		     }
		}  
		fclose($file);  
	}
        
       $parentparentdir= explode(DIRECTORY_SEPARATOR,BASE_PATH);
       $url="";
       $data="<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');".chr(13);
       $data.="/* App Koneksi Generate By sistem */". chr(13);
       $data.="\$active_group = 'default';". chr(13);
       $data.="\$active_record = TRUE;". chr(13);
       $data.="\$db['default']['hostname'] = '".$host."';;". chr(13);
       $data.="\$db['default']['username'] = '".$username."';". chr(13);
       $data.="\$db['default']['password'] = '".$passdb."';". chr(13). chr(13). chr(13). chr(13);
       $data.="\$db['default']['database'] = '".$prefikdb.$nmdb."';". chr(13);
       $data.="\$_SESSION['my_db']=\$db['default']['database'];". chr(13);
       $data.="\$db['default']['dbdriver'] = 'mysql';". chr(13);
       $data.="\$db['default']['dbprefix'] = '';". chr(13);
       $data.="\$db['default']['pconnect'] = FALSE;". chr(13);
       $data.="\$db['default']['db_debug'] = FALSE;". chr(13);
       $data.="\$db['default']['cache_on'] = FALSE;". chr(13);
       $data.="\$db['default']['cachedir'] = '';". chr(13);
       $data.="\$db['default']['char_set'] = 'utf8';". chr(13);
       $data.="\$db['default']['dbcollat'] = 'utf8_general_ci';". chr(13). chr(13). chr(13). chr(13). chr(13);
       $data.="/* End of file database.php */". chr(13);
       $data.="/* Location: ./system/application/config/database.php */". chr(13);

        for($i=0;$i<count($parentparentdir)-1;$i++)
        {
            $url .=$parentparentdir[$i]."/";
            
        }
                chmod($url.DIRECTORY_SEPARATOR."www".DIRECTORY_SEPARATOR."config".DIRECTORY_SEPARATOR."database.php", 0777);
                write_file($url.'/www/config/database.php', $data);
                $path['path']="/".$parentparentdir[count($parentparentdir)-2];
                $file_contents= $this->load->view('htaccess', $path, true);
                write_file($url.'/.htaccess', $file_contents);
    }
}

?>
