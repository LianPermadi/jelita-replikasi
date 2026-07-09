<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <?php
        $base_url = base_url().'assets/';
        $this->load->view('parsing/set_js_base');
        $this->load->view('parsing/load_css_js_admin');
        echo $this->lib_load_css_js->load_js($base_url,"js/default/","default_admin.js");
        
        //$tmbg=new Tmbg();
        //$get=$tmbg->where("link_status = 1")->get();
        
        //$template_name=$get->link_css;
        $template = "css/default/";  
        
        echo $this->lib_load_css_js->load_css($base_url, $template, "style_admin.css");
        ?>
        <title>Portal</title>
    </head>
    <body>

        <?php
        $this->load->view('parsing/admin/header_admin');
        $this->load->view('parsing/admin/main_menu');
        $this->load->view($isi);
        $this->load->view('parsing/admin/footer');
        ?>


    </body>
</html>
