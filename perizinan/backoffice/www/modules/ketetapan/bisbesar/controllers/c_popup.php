<?php


class C_popup extends WRC_AdminCont {
  

    public function __construct() {
        parent::__construct();
         $this->load->model("m_pengusaha");
        $enabled = FALSE;
            $list_auths = $this->session_info['app_list_auth'];

            foreach ($list_auths as $list_auth) {
                if($list_auth->id_role === '30') {
                    $enabled = TRUE;
                }
            }

            if(!$enabled) {
                redirect('dashboard');
            }
      
    }

    public function daftar_izin_list() {    // Ambil data pemohon
        $data['page_name'] = "Ambil Data Pengusaha";

        //$this->load->vars($data);
        //$this->load->view('izintrayek/popup_pengusaha', $data);

         $data['pau_table'] = $this->create_pau_table();
        $this->load->vars($data);

        $js =  "function confirm_link(text){
                    if(confirm(text)){ return true;
                    }else{ return false; }
                }
                $(document).ready(function() {
                        oTable = $('#izintrayek').dataTable({
                                \"bJQueryUI\": true,
                                \"sPaginationType\": \"full_numbers\"
                        });
                } );
                ";

        $this->template->set_metadata_javascript($js);
       $this->load->view('popup/popup_pengusaha', $data);
    }

     function create_pau_table()
    {
        $pau = $this->m_pengusaha->get_all_pau();
        $pau_table = "";
$counter = 0;
        if(count($pau) > 0)
        {
            
            
            foreach ($pau as $key => $value)
            {
                $counter = $counter+1;
                $pau_table .="<tr>";
                $pau_table .="<td>{$counter}</td>";
                $pau_table .="<td>{$value->NO_IP}</td>";
                $pau_table .="<td>{$value->NAMA_PERUS}</td>";
                $pau_table .="<td>{$value->NAMA_PEMIL}</td>";
              //  $pau_table .="<td>{$value->ALAMAT_PER}</td>";
               // $pau_table .="<td>{$value->TELPON_PER}</td>";
                

               $pau_table .="<td width=15%;>
               <a href='".base_url()."bisbesar/c_izintrayek/addsk2_izintrayek/{$value->PAU_ID}'>.</a>
             </td>";
                $pau_table .="</tr>";
            }
            return $pau_table;
        }
    }
    public function get_data_izin() {
        $obj = new tmpemohon();
        $columns = array(
            'n_pemohon',
            'no_referensi',
            'a_pemohon',
        );
        $obj->start_cache();
        $this->iTotalRecords = $obj->count();
        $this->sEcho = $this->input->post('sEcho');
        for ($i = 0; $i < 2; $i++) {
            /**
             * Filtering
             */
            if ($this->input->post('sSearch')) {
                foreach ($columns as $position => $column) {
                    if ($position == 0 && $position == 1) {
                        $obj->like($column, $this->input->post('sSearch'));
                    } else {
                        $obj->or_like($column, $this->input->post('sSearch'));
                    }
                }
            }
            if ($i === 0) {
                $this->iTotalDisplayRecords = $obj->count();
                
            } else if ($i === 1) {
                if ($this->input->post("iDisplayStart") && $this->input->post("iDisplayLength") != "-1") {
                    $this->iDisplayStart = $this->input->post("iDisplayStart");
                    $this->iDisplayLength = $this->input->post("iDisplayLength");

                    $obj->limit($this->iDisplayLength, $this->iDisplayStart);
                } else {
                    $this->iDisplayLength = $this->input->post("iDisplayLength");

                    if (empty($this->iDisplayLength)) {
                        $this->iDisplayLength = 10;
                        $obj->limit($this->iDisplayLength);
                    }
                    else
                        $obj->limit($this->iDisplayLength);
                }
            }
        }

        $peru = new tmpemohon;
        //$a = $peru->group_by('no_referensi')->get();
        $a = $obj->get();
        $obj->stop_cache();
        echo $this->get_data_izin_output($a);
    }

    public function get_data_izin_output($obj) {
        $aaData = array();

        $i = $this->iDisplayStart;

        foreach ($obj as $list) {
            $i++;

            $action = NULL;

            $action = NULL;
            $action .= '<a href="javascript:popup_link(\'' . base_url() . 'bisbesar/c_popup/pick_daftar_data/' . $list->id . '\',\'#tabs-1\')">';
            $action .= '<img src="' . base_url() . 'assets/images/icon/navigation-down.png" border="0" alt="Pilih Pemohon" class="klik_saya"/>';
            $action .= '</a>';
            
            $aaData[] = array(
                $i,
                $list->no_referensi,
                $list->n_pemohon,
                $list->a_pemohon,
                $action
            );
        }

        $sOutput = array
            (
            "sEcho" => intval($this->sEcho),
            "iTotalRecords" => $this->iTotalRecords,
            "iTotalDisplayRecords" => $this->iTotalDisplayRecords,
            "aaData" => $aaData
        );

        return json_encode($sOutput);
    }

   

}