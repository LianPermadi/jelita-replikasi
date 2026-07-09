<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Description of WRC_AdminCont class
 *
 * @author  Dichi Al Faridi
 * @since   1.0
 *
 * 
 */

class WRC_statistik extends MY_Controller {

    var $session_info = array();

    public function __construct() {
        parent::__construct();
       


        $this->settings = new settings();
        
        $this->settings->where('name','app_name')->get();
        $this->session_info['app_name'] = $this->settings->value;

        $this->settings->where('name','app_right')->get();
        $this->session_info['app_footer'] = "Copyright ©" . date('Y') . " " . $this->settings->value;

        $this->settings->where('name','app_folder')->get();
        $folder = $this->settings->value . "/";
        $this->session_info['app_folder'] = $this->settings->value;

       
        $this->load->library('Menu_loader');
        // Setting up the template
        $this->template->set_layout('admin/layout');
        $this->template->enable_parser(FALSE); // default true

        $this->template
                ->set_style('css', 'facebox.css')
                ->set_style('css', $folder . 'user.css')
                ->set_style('css', $folder . 'form.css')
                ->set_style('css', $folder . 'default.css')
                ->set_style('css', $folder . 'dropdown.css')
                ->set_style('css', $folder . 'default.ultimate.css')
                ->set_style('css', $folder . 'demo_table.css')
                ->set_style('css', $folder . 'demo_table_jui.css')
                ->set_style('css', $folder . 'themes/smoothness/jquery-ui-1.8.2.custom.css')
                ->set_style('css', 'global.css')
                ->set_style('css', 'jquery.multiselect.css')
                ->set_style('css', 'jquery.multiselect.filter.css')
                ->set_style('js', 'base_url.js')
                ->set_style('js', 'jquery-1.4.2.min.js')
                ->set_style('js', 'jquery.dataTables.js')
                ->set_style('js', 'jsonp.js')
                ->set_style('js', 'facebox.js')
                ->set_style('js', 'jquery-ui-1.8.2.custom.min.js')
                ->set_style('js', 'jquery.multiselect.min.js')
                ->set_style('js', 'jquery.multiselect.filter.js')
                ->set_style('js', 'jquery.validate.js');

        
        $this->template->set_partial('header', 'user/partials/header', FALSE);
        $this->template->set_partial('title', 'user/partials/title', FALSE);
        $this->template->set_partial('navigation', 'user/partials/navigation', FALSE);
        $this->template->set_partial('footer', 'user/partials/footer', FALSE);

//        $this->output->cache(30);

    }

}

// This is the end of WRC_AdminCont class