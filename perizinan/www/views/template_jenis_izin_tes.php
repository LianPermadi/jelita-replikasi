<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        
        <?php
        $base_url=base_url().'assets/';
        $this->load->view('parsing/set_js_base');
       $this->load->view('parsing/load_css_js');
        echo $this->lib_load_css_js->load_js($base_url,"js/default/","default.js");
        
        $tmbg=new Tmbg();
        $get=$tmbg->where("link_status = 1")->get();
        
       $template_name=$get->link_css;
        $template = "css/".$template_name."/";        
        //echo $template;
        $load_css_js = NULL;
        $load_css_js.=$this->lib_load_css_js->load_css($base_url,$template,"superfish.css");
        $load_css_js.=$this->lib_load_css_js->load_css($base_url,$template,"style_client.css");
        echo $load_css_js;
        ?>
        <title>Portal</title>
    </head>
    <body>
	<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>/dt/css/dt/jquery.dataTables.min.css">
	<script src="<?php echo $base_url;?>/dt/js/dt/jquery-1.12.0.min.js"></script>
	<script src="<?php echo $base_url;?>/dt/js/dt/jquery.dataTables.min.js"></script>
        <div class="container">
            <?php
            //$this->load->view('parsing/header');
            //$this->load->view('parsing/main_menu');
            $this->load->view($isi);
            //$this->load->view('parsing/footer');
            ?>
        </div>
    </body>
</html>
