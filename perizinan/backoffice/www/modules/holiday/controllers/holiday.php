<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Description of holiday class
 *
 * @author  Dichi Al Faridi
 * @since   1.0
 *
 */

class Holiday extends WRC_AdminCont {

    public function __construct() {
        parent::__construct();
        $this->holiday = new tmholiday();

            $enabled = FALSE;
            $list_auths = $this->session_info['app_list_auth'];

            foreach ($list_auths as $list_auth) {
                if($list_auth->id_role === '3') {
                    $enabled = TRUE;
                }
            }

            if(!$enabled) {
                redirect('dashboard');
            }
    }

    public function index() {
        $holiday = new tmholiday();
//        $data['list'] = $holiday->order_by('date ASC')->get();
		$data['list'] = $holiday->get();
        $this->load->vars($data);

        $js =  "
                function confirm_link(text){
                    if(confirm(text)){ return true;
                    }else{ return false; }
                }
                $(document).ready(function() {
                        oTable = $('#holiday').dataTable({
                                \"bJQueryUI\": true,
                                \"sPaginationType\": \"full_numbers\"
                        });
                } );
                ";

        $this->template->set_metadata_javascript($js);
        
        $this->session_info['page_name'] = "Setting Hari Libur";
        $this->template->build('list', $this->session_info);
    }

    public function create() {
        $data['date']  = "";
        $data['description']  = "";
        $data['holiday_type']  = "";
        $data['save_method'] = "save";
        $data['id'] = "";
        $js_date = "
            $(document).ready(function() {
                    $('#form').validate();
                    $(\"#tabs\").tabs();
                } );
            $(function() {
                $(\"#holiday\").datepicker({
                    changeMonth: true,
                    changeYear: true,
                    dateFormat: 'yy-mm-dd',
                    closeText: 'X'
                });
            });
            ";
        $this->template->set_metadata_javascript($js_date);

        $this->load->vars($data);
        $this->session_info['page_name'] = "Tambah Hari Libur";
        $this->template->build('edit', $this->session_info);
    }

    public function create_sabtu_minggu() {
        $data['date']  = "";
        $data['description']  = "";
        $data['holiday_type']  = "";
        $data['save_method'] = "save_sm";
		$data['kd_kontak'] = '';
        $data['id'] = "";
        $js_date = "
            $(document).ready(function() {
                    $('#form').validate();
                    $(\"#tabs\").tabs();
                } );
            $(function() {
                $(\"#holiday\").datepicker({
                    changeMonth: true,
                    changeYear: true,
                    dateFormat: 'yy-mm-dd',
                    closeText: 'X'
                });
            });
            ";
        $this->template->set_metadata_javascript($js_date);

        $this->load->vars($data);
        $this->session_info['page_name'] = "Tambah Seluruh Hari Sabtu Minggu";
        $this->template->build('create_sm', $this->session_info);
    }

    public function edit($id_role = NULL) {
        $this->holiday->where('id', $id_role);
        $this->holiday->get();
        $js_date = "
            $(document).ready(function(){
                $(\"#tabs\").tabs();
                $('#form').validate();
            });
            $(function() {
                $(\"#holiday\").datepicker({
                    changeMonth: true,
                    changeYear: true,
                    dateFormat: 'yy-mm-dd',
                    closeText: 'X'
                });
            });
            ";
        $this->template->set_metadata_javascript($js_date);

        $data['date'] = $this->holiday->date;
        $data['holiday_type'] = $this->holiday->holiday_type;
        $data['description'] = $this->holiday->description;
        $data['save_method'] = "update";
        $data['id'] = $this->holiday->id;

        $this->load->vars($data);
        $this->session_info['page_name'] = "Edit Hari Libur";
        $this->template->build('edit', $this->session_info);
    }

    public function save() {
		$holiday = $this->holiday->where('date',$this->input->post('date'))->get();
    	if(!$holiday->description){ // jika tidak ditemukan
            $holiday->description = $this->input->post('description');
            $holiday->date = $this->input->post('date');
            $holiday->holiday_type = $this->input->post('holiday_type');
            if(! $holiday->save()) {
                echo '<p>' . $holiday->error->string . '</p>';
            }else{
                $u_ser = $this->session->userdata('username');
                $tgl = date("Y-m-d H:i:s");
                //$p = $this->db->query("call log ('Setting Umum','Insert hari libur','".$tgl."','".$u_ser."')");
                $this->index();
			}
        }else{
			$this->index();
		}
    }

	public function save_sm() {
        $year = $this->input->post('kd_kontak');
		$tg1 = 1;
		$list_hari = array('0'=>'Minggu', '1'=>'Senin', '2'=>'Selasa', '3'=>'Rabu', '4'=>'Kamis', '5'=>'Jumat', '6'=>'Sabtu');

        for($bl = 1; $bl <= 12; $bl++):
            $days_in_month = date('t',mktime(0,0,0,$bl,$tg1,$year));  // banyak hari
		    //echo $this->lib_date->set_month_name($bl,'id').' '.$year.' = '.$days_in_month.' Hari <br>';
    		for($tg = 1; $tg <= $days_in_month; $tg++):
				$hr = date('w',mktime(0,0,0,$bl,$tg,$year));
		        if($hr == 6){  // sabtu
				    $status = TRUE;
				    $ket = $list_hari[$hr];
					$hari = 'Libur';
			        $b = '<span style="color: Blue">'; $be = '</span>';
	            }else{
					if($hr == 0){  // minggu
					    $status = TRUE;
					    $ket = $list_hari[$hr];
						$hari = $ket;
    			        $b = '<span style="color: Red">'; $be = '</span>';
					}else{
						$status = FALSE;
						$ket = '';
						$hari = '';
						$b = ''; $be = '';
					}
                }
                //echo $b.$tg.'-'.$bl.'-'.$year.' || '.$ket.' || '.$be;
				if($status){
		    		$tanggal =  date($year.'-'.$bl.'-'.$tg);
                    $holiday = $this->holiday->where('date',$tanggal)->get();
    				if(!$holiday->description){ // jika tidak ditemukan
		                $holiday->date = $tanggal;
						$holiday->description = $ket;
                        $holiday->holiday_type = $hari;
						$holiday->save();
    				    //echo $holiday->date . ' || ';
				    }
				}
            endfor;
			//echo '<br><br>';
		endfor;
//		die;

        $u_ser = $this->session->userdata('username');
        $tgl = date("Y-m-d H:i:s");
        //$p = $this->db->query("call log ('Setting Umum','Insert hari libur','".$tgl."','".$u_ser."')");
        $this->index();
    }

    public function update() {
        $update = $this->holiday->where('id', $this->input->post('id'))
                                ->update(array('date' => $this->input->post('date'),
                                               'description' => $this->input->post('description'),
                                               'holiday_type' => $this->input->post('holiday_type')
                  ));
        if($update) {
            $u_ser = $this->session->userdata('username');
            $tgl = date("Y-m-d H:i:s");
            //$p = $this->db->query("call log ('Setting Umum','Update hari libur','".$tgl."','".$u_ser."')");

            redirect('holiday');
        }
    }

    public function delete($id = NULL) {
        $this->holiday->where('id', $id)->get();
        if($this->holiday->delete()) {

            $u_ser = $this->session->userdata('username');
            $tgl = date("Y-m-d H:i:s");
            //$p = $this->db->query("call log ('Setting Umum','Delete hari libur','".$tgl."','".$u_ser."')");
            redirect('holiday');
        }
    }

    public function get_new() {
        $setting = new settings();
        $setting->where('name','app_year')->get();
        $year = date('Y');
        
        if($setting->value !== $year) {
            
            for ($i=0;$i<12;$i++) {
                $month = $i+1;
                $timestamp = mktime(0,0,0,$month,1,$year);
                $firstday = date('D',$timestamp);
                echo $month . " -> " .$firstday . " --> " . date('w', $timestamp) . "<br />";

                $day_of = intval(date('w', $timestamp));
                $day_of = 7 - $day_of;
                $day = $day_of;

                while ($day < 32) {
                    for ($j=0;$j<2;$j++) {
                        $holiday = new tmholiday();
                        $new_day = strval($year) . "-" . strval($month) . "-" . strval($day+$j);
                        $holiday->date = $new_day;
                        $holiday->description = "Libur Akhir Pekan";
                        $holiday->holiday_type = "Minggu";
                        $holiday->save();
                        echo $new_day . "<br />";
                    }
                    $day = $day + 7;
                }
            }
            $holiday = new tmholiday();
            $holiday->date = strval($year) . "-01-01";
            $holiday->description = "Libur Tahun Baru";
            $holiday->holiday_type = "Libur";
            $holiday->save();

            $holiday = new tmholiday();
            $holiday->date = strval($year) . "-08-17";
            $holiday->description = "Libur HUT RI";
            $holiday->holiday_type = "Libur";
            $holiday->save();

            $holiday = new tmholiday();
            $holiday->date = strval($year) . "-12-25";
            $holiday->description = "Libur Natal";
            $holiday->holiday_type = "Libur";
            $holiday->save();
            $setting->where('name','app_year')->update('value', $year);
        }

        redirect('holiday');
    }
}

// This is the end of holiday class