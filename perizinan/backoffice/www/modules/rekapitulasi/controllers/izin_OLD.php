<?php
/* To change this template, choose Tools | Templates and open the template in the editor. */

/**
 * Description of penjadwalan
 * @author Eva
 */

class Izin extends WRC_AdminCont {

    public function __construct() {
		    //require_once("fpdf17/fpdf.php");
        parent::__construct();
        $this->permohonan      = new tmpermohonan();
        $this->status    = new trstspermohonan();
        $this->perizinan = new trperizinan();
        $this->mohonstatus = new tmpermohonan_trstspermohonan();

        $this->load->library('fpdf');
        $enabled = FALSE;
        $list_auths = $this->session_info['app_list_auth'];
        $this->izin = NULL;
        
        foreach ($list_auths as $list_auth) {
            if($list_auth->id_role === '10') {
                $enabled = TRUE;
                $this->izin = new user_auth();
            }
        }
        
		    //$kat_cari 
		    $this->kat_cari = array('0'=>'Tanggal Permohonan','1'=>'Tanggal Selesai');
        //EOF() kat_cari

        if(!$enabled) {
            redirect('dashboard');
        }
    }

    public function index() {  // pertama masuk saat klik menu
        $refresh = $this->input->post('refresh');
		$list_kat = $this->input->post('list_kat');
		$data['list_kat'] = $list_kat;
		$data['kat_cari']   = $this->kat_cari;
		if($refresh == NULL) $data['refresh'] = FALSE; else $data['refresh'] = $refresh;
		$data['range'] = '';
		$mark = $this->input->post('mark');
		$data['mark'] = $mark;
        $data['list'] = $this->perizinan->limit(0)->get();
        $this->load->vars($data);

        $js =  "
                $(document).ready(function() {
                    $(\"#tabs\").tabs();
                    $('a[rel*=pendaftar_box]').facebox();
                    $('a[rel*=perusahaan_box]').facebox();
                    oTable = $('#izin').dataTable({
                               \"bJQueryUI\": true,
                               \"sPaginationType\": \"full_numbers\"
                    });
                } );

                $(function() {
                    $(\".monbulan\").datepicker({
                        changeMonth: true,
                        changeYear: true,
                        dateFormat: 'yy-mm-dd',
                        closeText: 'X'
                    });
                });
               ";
        $this->template->set_metadata_javascript($js);
        $this->session_info['page_name'] = "Rekapitulasi Perizinan";
        $this->template->build('izin_list', $this->session_info);
    }

	public function index_next() {
		$refresh = $this->input->post('refresh');
		$list_kat = $this->input->post('list_kat');
		$data['list_kat'] = $list_kat;
		if($refresh == NULL) $data['refresh'] = FALSE; else $data['refresh'] = $refresh;
		$username = new user();
        $username->where('username', $this->session->userdata('username'))->get();
		$tgla = $username->gvar1;
        $tglb = $username->gvar2;
		$gerai = $username->gvar3;

		$data['tgla'] = $tgla;
        $data['tglb'] = $tglb;
        $data['list_state'] = $gerai;

        $data['range'] = '';
		$mark = $this->input->post('mark');
		$data['mark'] = $mark;
        $data['list'] = $this->perizinan->limit(0)->get();
        $this->load->vars($data);

        $js =  "
                $(document).ready(function() {
                    $(\"#tabs\").tabs();
                    $('a[rel*=pendaftar_box]').facebox();
                    $('a[rel*=perusahaan_box]').facebox();
                    oTable = $('#izin').dataTable({
                               \"bJQueryUI\": true,
                               \"sPaginationType\": \"full_numbers\"
                    });
                } );

                $(function() {
                    $(\".monbulan\").datepicker({
                        changeMonth: true,
                        changeYear: true,
                        dateFormat: 'yy-mm-dd',
                        closeText: 'X'
                    });
                });
               ";
        $this->template->set_metadata_javascript($js);
        $this->session_info['page_name'] = "Rekapitulasi Perizinan";
        $this->template->build('izin_list', $this->session_info);
    }

    public function rekap() { // masuk setelah klik filter
        $tgla = $this->input->post('tgla');
        $tglb = $this->input->post('tglb');
		$list_kat = $this->input->post('list_kat');
		$list_state = $this->input->post('list_state');
        $now = $this->lib_date->get_date_now();
        $tgl_before = date("Y-m-d", mktime(0, 0, 0, date("m"), 1, date("Y")));
        $tgl_after = date("Y-m-d", mktime(0, 0, 0, date("m")+1, 0, date("Y")));

        if($tgla && $tglb) {
            $data['tgla'] = $tgla;
            $data['tglb'] = $tglb;
        } else {
            $tgla = $tgl_before;
            $tglb = $tgl_after;
            $data['tgla'] = $tgla;
            $data['tglb'] = $tglb;
        }

		$data['list_state'] = $list_state;
		$data['list_kat'] = $list_kat;
		$username = new user();
        $username->where('username', $this->session->userdata('username'))->get();
        $data['iduser'] = $username->id;
		$data['lokasi'] = $username->lokasi;
        $data['cek_sektor'] = $username->sektor;
		$this->lib_date->post_variable($username->id, $tgla, $tglb, $list_state, '', '', '', '', '', $list_kat, '');   // post variable
        $this->load->vars($data);
        $js =  "
                $(document).ready(function() {
					$(\"#tabs\").tabs();
					$('a[rel*=rekapitulasi_box]').facebox();
                    $('a[rel*=realisasi_box]').facebox();
                    oTable = $('#realisasi').dataTable({
                                \"bJQueryUI\": true,
                                \"sPaginationType\": \"full_numbers\"
                    });
                } );
                ";

        $this->template->set_metadata_javascript($js);

        $this->session_info['page_name'] = "Rekapitulasi Perizinan Berdasar ".$this->kat_cari[$list_kat];
        $this->template->build('izin_rekap', $this->session_info);
    }

	public function rekap_next() {
        $username = new user();
        $username->where('username', $this->session->userdata('username'))->get();
		$tgla = $username->gvar1;
        $tglb = $username->gvar2;
		$gerai = $username->gvar3;
        $list_kat = $username->gvar9;

		$data['lokasi'] = $username->lokasi;
        $data['cek_sektor'] = $username->sektor;
		$data['tgla'] = $tgla;
        $data['tglb'] = $tglb;
        $data['list_state'] = $gerai;
		$data['list_kat'] = $list_kat;
        $this->load->vars($data);
        $js =  "
                $(document).ready(function() {
					$(\"#tabs\").tabs();
					$('a[rel*=rekapitulasi_box]').facebox();
                    $('a[rel*=realisasi_box]').facebox();
                    oTable = $('#realisasi').dataTable({
                                \"bJQueryUI\": true,
                                \"sPaginationType\": \"full_numbers\"
                    });
                } );
                ";

        $this->template->set_metadata_javascript($js);

        $this->session_info['page_name'] = "Rekapitulasi Perizinan Berdasar ".$this->kat_cari[$list_kat];
        $this->template->build('izin_rekap', $this->session_info);
    }

    public function filter() {
        $permohonan = new tmpermohonan();
        $izin = new trperizinan();
        $permohonan->where_join_field('tmpermohonan_trperizinan','trperizinan_id')
                   ->where('c_izin_selesai',1)->get();

        $periodeakhir = $this->input->post('periodeakhir');
        $periodeawal = $this->input->post('periodeawal');
        $s = $permohonan->where("d_perpanjangan BETWEEN '$periodeawal' AND '$periodeakhir'")->get();
        $data['periodeakhir'] = $this->input->post('periodeakhir');
        $data['periodeawal'] = $this->input->post('periodeawal');
        $data['list'] = $s->$izin->get();

        $this->load->vars($data);

        $js =  "
                $(document).ready(function() {
                        oTable = $('#izin').dataTable({
                                \"bJQueryUI\": true,
                                \"sPaginationType\": \"full_numbers\"
                        });
                } );

                $(function() {
                $(\".tarif\").datepicker({
                    changeMonth: true,
                    changeYear: true,
                    dateFormat: 'yy-mm-dd',
                    closeText: 'X'
                });
            });
                ";

        $this->template->set_metadata_javascript($js);

        $this->session_info['page_name'] = "Rekapitulasi Perizinan";
        $this->template->build('view_izin', $this->session_info);
    }

    public function view() {
        $permohonan = new tmpermohonan();
        $perizinan = new trperizinan();
        $status = new trstspermohonan();
        $data['periodeakhir'] = $this->input->post('periodeakhir');
        $data['periodeawal']  = $this->input->post('periodeawal');
        $data['range'] = '';

        $periodeakhir = $this->input->post('periodeakhir');
        $periodeawal  = $this->input->post('periodeawal');
        $data['list_tahun'] = $this->izin->group_by('d_tahun','ASC')->get();
        $data['list'] = $this->perizinan->get();
        $data['listlist']=$permohonan->where("d_entry BETWEEN '$periodeawal' AND '$periodeakhir'")->get();
        $data['jum1']  = $this->status->where('id',14)->get();
        $data['jum13'] = $this->status->where('id', 13)->count();
        $data['jum14'] = $this->status->where('id', 14)->count();


        $this->load->vars($data);

        $js =  "
		        $(document).ready(function() {
                    $(\"#tabs\").tabs();

                    $('a[rel*=rekapitulasi_box]').facebox();
                    $('a[rel*=realisasi_box]').facebox();
                } );

                $(document).ready(function() {
                        oTable = $('#izin').dataTable({
                                \"bJQueryUI\": true,
                                \"sPaginationType\": \"full_numbers\"
                        });
                } );

                $(function() {
                $(\".tarif\").datepicker({
                    changeMonth: true,
                    changeYear: true,
                    dateFormat: 'yy-mm-dd',
                    closeText: 'X'
                });
            });
                ";


        $this->template->set_metadata_javascript($js);

        $this->session_info['page_name'] = "Rekapitulasi Perizinan";
        $this->template->build('view_izin', $this->session_info);
    }

    public function list_data($id_key = null, $menu = null) {
		    $sql = $this->sql_info_viewdata();
        $sql .= $this->kat_filter();
		    $sql .= $this->menu_filter('1', $menu);
		    //echo $sql; die;
		    $username = new user();
        $username->where('username', $this->session->userdata('username'))->get();
		    $tgla = $username->gvar1;
        $tglb = $username->gvar2;
		    $gerai = $username->gvar3;
		    $list_kat = $username->gvar9;
		    $kat_cari = $this->kat_cari[$list_kat];
		    $this->lib_date->post_variable($username->id, $tgla, $tglb, $gerai, $id_key, '', '', '', '', $list_kat, $menu);   // post variable

        if($menu >= 8){ // info per jenis izin
		        $kd_sektor = new trperizinan_trsektor();
            $kd_sektor->where('trperizinan_id', $id_key)->get();
            $kd_sektor = $kd_sektor->trsektor_id; 
            $sektor = new trsektor();
            $sektor->get_by_id($kd_sektor);
			      $perizinan = new trperizinan();
			      $perizinan->get_by_id($id_key);
			      $jdl_bidang = $sektor->n_sektor;
			      $jdl_izin = $perizinan->n_perizinan;
        }else{
			      $this->sektor = new trsektor();
		        $jdl_bidang = $this->sektor->get_by_id($id_key)->n_sektor;
			      $jdl_izin = '';
	      }

        $data['tgla'] = $tgla;
        $data['tglb'] = $tglb;
		    $data['gerai'] = $gerai;
		    $data['list_kat'] = $list_kat;
		    $data['bidang'] = $jdl_bidang;
		    $data['izin'] = $jdl_izin;
		    $data['katagori'] = 'BERDASAR '.$kat_cari;
        $data['n_menu'] = $this->menu_filter('2', $menu);
        $data['list'] ='';
		
        $this->load->vars($data);

        $js =  "$(document).ready(function() {
                        oTable = $('#listdataizin').dataTable({
                                \"bJQueryUI\": true,
                                \"sPaginationType\": \"full_numbers\"
                        });
                } );
                ";

        $this->template->set_metadata_javascript($js);
        $this->session_info['page_name'] = "List Data Perizinan Berdasar ".$kat_cari;
        $this->template->build('view_list_data', $this->session_info);
    }

	public function list_data_next() {
		$username = new user();
        $username->where('username', $this->session->userdata('username'))->get();
		$tgla = $username->gvar1;
        $tglb = $username->gvar2;
		$gerai = $username->gvar3;
        $id_key = $username->gvar4;
		$menu = $username->gvar10;

        if($menu >= 8){ // info per jenis izin
		    $kd_sektor = new trperizinan_trsektor();
            $kd_sektor->where('trperizinan_id', $id_key)->get();
            $kd_sektor = $kd_sektor->trsektor_id; 
            $sektor = new trsektor();
            $sektor->get_by_id($kd_sektor);
			$jdl_bidang = $sektor->n_sektor;
            $perizinan = new trperizinan();
			$perizinan->get_by_id($id_key);
			$jdl_bidang = $sektor->n_sektor;
			$jdl_izin = $perizinan->n_perizinan;
        }else{
			$this->sektor = new trsektor();
		    $jdl_bidang = $this->sektor->get_by_id($id_key)->n_sektor;
			$jdl_izin = '';
		}

        $data['tgla'] = $tgla;
        $data['tglb'] = $tglb;
		$data['gerai'] = $gerai;
		$data['bidang'] = $jdl_bidang;
		$data['izin'] = $jdl_izin;
		$data['n_menu'] =  $this->menu_filter('2', $menu);
        $data['list'] ='';
        $data['id_key'] = $id_key;
        $this->load->vars($data);

        $js =  "$(document).ready(function() {
                        oTable = $('#info_list').dataTable({
                                \"bJQueryUI\": true,
                                \"sPaginationType\": \"full_numbers\"
                        });
                } );
                ";

        $this->template->set_metadata_javascript($js);
        $this->session_info['page_name'] = "List Data Perizinan next";
        $this->template->build('view_list_data', $this->session_info);
    }
	
	public function datalist() {
        $this->izin->get();
        $this->izin->set_json_content_type();
        echo $this->izin->json_for_data_table();
    }

    public function cetak($tgl_a = null, $tgl_b = null, $ctk_asal = null, $tab = null) { // cetak rekap per sektor ke PDF
		$username = new user();
        $username->where('username', $this->session->userdata('username'))->get();
        $user = $username->realname;
		$tgla = $username->gvar1;
        $tglb = $username->gvar2;
		$gerai = $username->gvar3;
		$list_kat = $username->gvar9;
        if($gerai == '0') $c_asal = "Seluruhnya"; else $c_asal = $gerai;
		$list_state = $gerai;
				
        // Ambil Logo
		$this->tr_instansi = new Tr_instansi();
        $logo = $this->tr_instansi->get_by_id(23);
        $n_logo = base_url(). 'uploads/logo/logo.png';

		// Ambil Pemerintah 
        $this->tr_instansi = new Tr_instansi();
        $nama_prov = $this->tr_instansi->get_by_id(17)->value;

        // Ambil Badan
        $this->tr_instansi = new Tr_instansi();
        $nama_badan = $this->tr_instansi->get_by_id(9)->value;

        // Ambil Alamat
        $this->tr_instansi = new Tr_instansi();
        $alamat = $this->tr_instansi->get_by_id(12)->value;

		// Ambil Telpon
        $this->tr_instansi = new Tr_instansi();
        $tlp = $this->tr_instansi->get_by_id(10)->value;

        // Ambil Fax
        $this->tr_instansi = new Tr_instansi();
        $fax = $this->tr_instansi->get_by_id(13)->value;

		// Ambil Kota
        $this->tr_instansi = new Tr_instansi();
        $kota = $this->tr_instansi->get_by_id(19)->value;

		// Ambil Kode Pos
        $this->tr_instansi = new Tr_instansi();
        $kdpos = $this->tr_instansi->get_by_id(20)->value;

		// Ambil web
        $this->tr_instansi = new Tr_instansi();
        $web = $this->tr_instansi->get_by_id(21)->value;

		// Ambil e-mail
        $this->tr_instansi = new Tr_instansi();
        $e_mail = $this->tr_instansi->get_by_id(22)->value;
        
        $alamat = $alamat . ' Tlp. ' . $tlp . ', Fax. ' . $fax;
        $alamat2 = 'Website: ' . $web . '   e-mail: ' . $e_mail;
		$alamat3 = strtoupper($kota) . ' - ' . $kdpos;
        $judul1 = 'Rekapitulasi Perizinan Berdasar '.$this->kat_cari[$list_kat].', Periode '.$this->lib_date->mysql_to_human($tgla).' - '.$this->lib_date->mysql_to_human($tglb);
		$judul2 = 'Asal Permohonan : ' . $c_asal;

//		$pdf = new FPDF({P/L},{pt/mm/cm/in},{A3/A4/A5/LETTER/LEGAL});
		$pdf = new FPDF('P','mm','A4'); //('a3'=>array(841.89,1190.55), 'a4'=>array(595.28,841.89), 'a5'=>array(420.94,595.28), 'letter'=>array(612,792), 'legal'=>array(612,1008));
		$pdf->SetMargins(1,1);
		$pdf->AddPage();
		$pdf->Image($n_logo,2,5,22);
		$pdf->SetFont('Arial','',14);
		$pdf->Ln(9); $pdf->Cell(0,0.5,$nama_prov,0,1,'C');
		$pdf->SetFont('Arial','',13);
		$pdf->Ln(5); $pdf->Cell(0,0.5,$nama_badan,0,1,'C');
		$pdf->SetFont('Arial','',11);
		$pdf->Ln(5); $pdf->Cell(0,0.5,$alamat,0,1,'C');
		$pdf->Ln(4); $pdf->Cell(0,0.5,$alamat2,0,1,'C');
		$pdf->Ln(4); $pdf->Cell(0,0.5,$alamat3,0,1,'C');
        $pdf->SetLineWidth(0.1); $pdf->Line(1,33,209,33);
		$pdf->SetLineWidth(0.5); $pdf->Line(1,34,209,34);

        $pdf->SetFont('Arial','',11);
		$pdf->Ln(13); $pdf->Cell(0,0.5,$judul1,0,1,'C');
		$pdf->Ln(5); $pdf->Cell(0,0.5,$judul2,0,1,'C');
		$pdf->SetMargins(1,1);
        
		//cetak isi tabel ke pdf
		if ($tab == 1) {
			//Ambil data array dari view
		    $data1 = explode('&',$this->input->post('data1'));
		    $data2 = array();
            foreach ($data1 as &$value) {
                $temp = explode(';',$value);
			    array_push($data2, $temp); //tambahkan isi temp ke array data2
            }
    		//EOF() Ambil data array dari view

            $l_col = array(10,54,23,15,15,15,15,15,15,15,15); // total 207 utk A4 P
            $align = array('R','L','R','R','R','R','R','R','R','R','R');
            $pdf->SetFont('Arial','B',8);
            $pdf->Ln(10);
            $brs = 0;
	        foreach ($data2 as &$isi) {
                $brs++;
                $space = 5;
   		        $nb=0;
                for($i=0;$i<count($isi);$i++)
                    $nb=max($nb,$pdf->NbLines($l_col[$i],$isi[$i]));
                $h=$space*$nb;
                //Issue a page break first if needed
                $pdf->CheckPageBreak($h);
                //Draw the cells of the row
                for($i=0;$i<count($isi);$i++) {
                    $w=$l_col[$i];
		    		if($brs == 1){
                        $a='C';
				    }else{
				        $a=isset($align[$i]) ? $align[$i] : 'L';
					}
                    //Save the current position
                    $x=$pdf->GetX();
                    $y=$pdf->GetY();

					$loncat = 0;
		    		if($isi[1] == 'TOTAL'){ // jika ditemukan total
					    if($i == 0){
							$loncat = $l_col[1];
							$i++;
							$pdf->Rect($x,$y,$w+$loncat,$h);  //Draw the border
 	    			        $pdf->MultiCell($w+$loncat,$space,$isi[$i],0,'R');
							$pdf->SetXY($x+$w+$loncat,$y);
    					}else{
							$pdf->Rect($x,$y,$w,$h);  //Draw the border
	    				    $pdf->MultiCell($w,$space,$isi[$i],0,$a);
		    			}
                    }else{   // jika ditemukan isi tabel
					    $pdf->Rect($x,$y,$w,$h);  //Draw the border
    				    if($i == 0){
                            $pdf->MultiCell($w,$space,$isi[$i].'. ',0,$a);
    	    		    }else{
	    	    		    $pdf->MultiCell($w,$space,$isi[$i],0,$a);
		    	    	}
    				}
                    //Put the position to the right of the cell
                    $pdf->SetXY($x+$w+$loncat,$y);
                }
                //Go to the next line
                $pdf->Ln($h);
		    }
		}else{
			//Ambil data array dari view
		    $data1 = explode('~',$this->input->post('data11'));
		    $data2 = array();
            foreach ($data1 as &$value) {
                $temp = explode('|',$value);
			    array_push($data2, $temp); //tambahkan isi temp ke array data2
            }
    		//EOF() Ambil data array dari view
			$l_col = array(10,65,15,13,13,13,13,13,13,13,13,13); // total 207 utk A4 P
            $align = array('R','L','R','R','R','R','R','R','R','R','R','R');
            $pdf->SetFont('Arial','B',7);
            $pdf->Ln(10);
            $brs = 0;
	        foreach ($data2 as &$isi) {
                $brs++;
				if($isi[0]=='' && $isi[1]==''&& $isi[2]=='') $space = 3; else $space = 5;
   		        $nb=0;
                for($i=0;$i<count($isi);$i++)
                    $nb=max($nb,$pdf->NbLines($l_col[$i],$isi[$i]));
                $h=$space*$nb;
                //Issue a page break first if needed
                $pdf->CheckPageBreak($h);
                //Draw the cells of the row
                for($i=0;$i<count($isi);$i++) {
                    $w=$l_col[$i];
		    		if($brs == 1)
                        $a='C';
				    else
				        $a=isset($align[$i]) ? $align[$i] : 'L';
                    //Save the current position
                    $x=$pdf->GetX();
                    $y=$pdf->GetY();
                    
                    //Print the text
					$loncat = 0;
		    		if($isi[0] == ''){  // jika ditemukan jumlah dan total
					    if($i == 0){
							$loncat = $l_col[1]+$l_col[2];
							$i = $i + 2;
							if($space == 5) $pdf->Rect($x,$y,$w+$loncat,$h);  //Draw the border
 	    			        $pdf->MultiCell($w+$loncat,$space,$isi[$i-1],0,'R');
							$pdf->SetXY($x+$w+$loncat,$y);
    					}else{
							if($space == 5) $pdf->Rect($x,$y,$w,$h); //Draw the border
	    				    $pdf->MultiCell($w,$space,$isi[$i],0,$a);
		    			}
                    }else{ // jika ditemukan isi tabel
                        if($i == 1 && $isi[3]==''){
							$loncat = $l_col[2]+$l_col[3]+$l_col[4]+$l_col[5]+$l_col[6]+$l_col[7]+$l_col[8]+$l_col[9]+$l_col[10]+$l_col[11];
							if($space == 5) $pdf->Rect($x,$y,$w+$loncat,$h); //Draw the border
							$pdf->MultiCell($w+$loncat,$space,$isi[$i],0,$a);
                            $i = 11;
						}else{ // cetak normal
    					    if($space == 5) $pdf->Rect($x,$y,$w,$h); //Draw the border
        				    if($i == 0){
								if($isi[3] != '')
                                    $pdf->MultiCell($w,$space,$isi[$i].'. ',0,$a);
								else
									$pdf->MultiCell($w,$space,$isi[$i],0,'L');
    	        		    }else{
	    	        		    $pdf->MultiCell($w,$space,$isi[$i],0,$a);
		    	        	}
						}
    				}
                    //Put the position to the right of the cell
                    $pdf->SetXY($x+$w+$loncat,$y);
                }
                //Go to the next line
                $pdf->Ln($h);
		    }
		}
		//EOF() cetak isi tabel ke pdf
        
		$pdf->SetFont('Arial','',8);
		$pdf->Ln(20); $pdf->SetX(150); $pdf->Cell(0,0.5,$kota.', '.$this->lib_date->mysql_to_human($this->lib_date->get_date_now()),0,1,'L');
		
        #output file PDF {I:ViewStd ;D:Download ;F:SaveLocalFile S:ReturnString}
        $pdf->Output('Rekap_izin.pdf','D');
	}

	public function cetak_perjenis($tgla = null, $tglb = null) { // cetak ODT 
        $this->settings = new settings();
        $this->settings->where('name','app_folder')->get();
        $app_folder = $this->settings->value . "/";
        $app_city = $this->settings->where('name','app_city')->get();

        // path of the template file
        $nama_surat = "cetak_rekapizin";
        $this->load->plugin('odf');
        $odf = new odf('assets/odt/'.$nama_surat.'.odt');

        // $odf->setImage('header', 'assets/css/' . $app_folder . '/images/dinas_1.jpg', '17.5', '4.5');
        $odf->setVars('rangeawal',$this->lib_date->mysql_to_human($tgla));
        $odf->setVars('rangeakhir',$this->lib_date->mysql_to_human($tglb));

        //logo
        $this->tr_instansi = new Tr_instansi();
        $logo = $this->tr_instansi->get_by_id(14);
        $odf->setImage('logo', 'uploads/logo/' . $logo->value, '2.3', '2.8');

        //badan
        $this->tr_instansi = new Tr_instansi();
        $nama_bdan = $this->tr_instansi->get_by_id(9);
        $odf->setVars('badan', strtoupper($nama_bdan->value));

		//provinsi
        $this->tr_instansi = new Tr_instansi();
        $nama_prov = $this->tr_instansi->get_by_id(17);
        $odf->setVars('provinsi', strtoupper($nama_prov->value));

        //telpon
        $this->tr_instansi = new Tr_instansi();
        $tlp = $this->tr_instansi->get_by_id(10);
        $odf->setVars('tlp', $tlp->value);

        //fax
        $this->tr_instansi = new Tr_instansi();
        $tlp = $this->tr_instansi->get_by_id(13);
        $odf->setVars('fax', $tlp->value);

		//web
        $this->tr_instansi = new Tr_instansi();
        $web = $this->tr_instansi->get_by_id(21);
        $odf->setVars('web', $web->value);

		//email
        $this->tr_instansi = new Tr_instansi();
        $email = $this->tr_instansi->get_by_id(22);
        $odf->setVars('email', $email->value);

		//kota
        $this->tr_instansi = new Tr_instansi();
        $kota = $this->tr_instansi->get_by_id(19);
        $odf->setVars('kota', strtoupper($kota->value));

		//kdpos
        $this->tr_instansi = new Tr_instansi();
        $kdpos = $this->tr_instansi->get_by_id(20);
        $odf->setVars('kdpos', $kdpos->value);
        
        //alamat
        $this->tr_instansi = new Tr_instansi();
        $alamat = $this->tr_instansi->get_by_id(12);
        $odf->setVars('alamat', ucwords(strtolower($alamat->value)));

        $tgl_skr = $this->lib_date->get_date_now();
        $odf->setVars('tanggal', $this->lib_date->mysql_to_human($tgl_skr));
        $i = NULL;
        $query_data = "select id, n_perizinan, v_perizinan from trperizinan";
        $results = mysql_query($query_data);
        while ($data = mysql_fetch_assoc(@$results)){
            $i++;
            $jumlah_masuk = 0;
            $jumlah_terbit = 0;
            $terbit_ambil = 0;
            $terbit_proses = 0;
            $jumlah_tolak = 0;
            $tolak_ambil = 0;
            $tolak_proses = 0;

            $jumlah_proses = 0;

            $query = "select a.id jumlah from tmpermohonan a
                     inner join tmpermohonan_trperizinan b on a.id = b.tmpermohonan_id
                     where b.trperizinan_id = '".$data['id']."'
                     and a.d_terima_berkas between '$tgla' and '$tglb'";
            $hasil_data = mysql_query($query);
            $jumlah_masuk = mysql_num_rows(@$hasil_data);
            $query2 = "select a.id, a.c_izin_selesai, d.c_penetapan, d.status_bap from tmpermohonan a
                    inner join tmpermohonan_trperizinan b on a.id = b.tmpermohonan_id
                    inner join tmbap_tmpermohonan c on a.id = c.tmpermohonan_id
                    inner join tmbap d on d.id = c.tmbap_id
                     where b.trperizinan_id = '".$data['id']."'
                     and a.d_terima_berkas between '$tgla' and '$tglb'";
            $hasil_data2 = mysql_query($query2);
            while ($rows_data2 = mysql_fetch_assoc(@$hasil_data2)){
                if($rows_data2['status_bap'] == "1"){
                    $jumlah_terbit++;
                    if($rows_data2['c_izin_selesai'] == "1") $terbit_ambil++;
                    else $terbit_proses++;
                } else if($rows_data2['status_bap'] == "2"){
                    $jumlah_tolak++;
                    if($rows_data2['c_izin_selesai'] == "1") $tolak_ambil++;
                    else $tolak_proses++;
                }
            }
            $jumlah_proses = $jumlah_masuk - ($jumlah_terbit + $jumlah_tolak);

            $listeArticles3 = array(
                array(	'property' =>$i,
                        'content' =>  $data['n_perizinan'],
                        'content1' => $jumlah_masuk,
                        'content2' =>  $jumlah_terbit,
                        'content3' =>  $terbit_ambil,
                        'content4' =>  $terbit_proses,
                        'content5' =>  $jumlah_tolak,
                        'content6' =>  $tolak_ambil,
                        'content7' =>  $tolak_proses,
                        'content8' =>  $jumlah_proses,
                ),

            );

            // if($listeArticles3){

            $article3 = $odf->setSegment('articles3');
            foreach($listeArticles3 AS $element) {

                $article3->titreArticle3($element['property']);
                $article3->texteArticle3($element['content']);
                $article3->texteArticle4($element['content1']);
                $article3->texteArticle5($element['content2']);
                $article3->texteArticle6($element['content3']);
                $article3->texteArticle7($element['content4']);
                $article3->texteArticle8($element['content5']);
                $article3->texteArticle9($element['content6']);
                $article3->texteArticle10($element['content7']);
                $article3->texteArticle11($element['content8']);
                $article3->merge();
            }
        }
        $odf->mergeSegment($article3);
    
        //export the file
        $odf->exportAsAttachedFile($nama_surat.'.odt');
    }

    public function pick_pendaftar_list($idizin = NULL) {
        $ss = $this->perizinan->where('id',$idizin)->get();
        $data['page_name'] ='<b>'.$ss->n_perizinan.'</b>' ;

        $data['list'] = $ss;

        $this->load->vars($data);
        $this->load->view('listpendaftaran_load', $data);
    }

    public function pick_pendaftar2_list($idizin = NULL) {
        $ss = $this->perizinan->where('id',$idizin)->get();
        $data['page_name'] ='<b>'.$ss->n_perizinan.'</b>' ;

        $data['list'] = $ss;

        $this->load->vars($data);
        $this->load->view('listpendaftaran2_load', $data);
    }

    public function pick_pendaftar3_list($idizin = NULL) {
        $ss = $this->perizinan->where('id',$idizin)->get();
        $data['page_name'] ='<b>'.$ss->n_perizinan.'</b>' ;

        $data['list'] = $ss;

        $this->load->vars($data);
        $this->load->view('listpendaftaran3_load', $data);
    }

    public function cetak_list($tgl_a = null, $tgl_b = null, $ctk_asal = null) { // cetak list per sektor ke PDF
        $username = new user();
        $username->where('username', $this->session->userdata('username'))->get();
        $user = $username->realname;
		$tgla = $username->gvar1;
        $tglb = $username->gvar2;
		$gerai = $username->gvar3;
		$id_key = $username->gvar4;
        $list_kat = $username->gvar9;
		$menu = $username->gvar10;

		if($menu >= 8){ // info per jenis izin
		    $kd_sektor = new trperizinan_trsektor();
            $kd_sektor->where('trperizinan_id', $id_key)->get();
            $kd_sektor = $kd_sektor->trsektor_id; 
            $sektor = new trsektor();
            $sektor->get_by_id($kd_sektor);
			$perizinan = new trperizinan();
			$perizinan->get_by_id($id_key);
			$bidang = $sektor->n_sektor;
			$jdl_izin = $perizinan->n_perizinan;
        }else{
			$this->sektor = new trsektor();
		    $bidang = $this->sektor->get_by_id($id_key)->n_sektor;
			$jdl_izin = '';
		}

        if($gerai == '0') $c_asal = "Seluruhnya"; else $c_asal = $gerai;
		$list_state = $gerai;

        // Ambil Logo
		$this->tr_instansi = new Tr_instansi();
        $logo = $this->tr_instansi->get_by_id(23);
        $n_logo = base_url(). 'uploads/logo/logo.png';

		// Ambil Pemerintah 
        $this->tr_instansi = new Tr_instansi();
        $nama_prov = $this->tr_instansi->get_by_id(17)->value;

        // Ambil Badan
        $this->tr_instansi = new Tr_instansi();
        $nama_badan = $this->tr_instansi->get_by_id(9)->value;

        // Ambil Alamat
        $this->tr_instansi = new Tr_instansi();
        $alamat = $this->tr_instansi->get_by_id(12)->value;

		// Ambil Telpon
        $this->tr_instansi = new Tr_instansi();
        $tlp = $this->tr_instansi->get_by_id(10)->value;

        // Ambil Fax
        $this->tr_instansi = new Tr_instansi();
        $fax = $this->tr_instansi->get_by_id(13)->value;

		// Ambil Kota
        $this->tr_instansi = new Tr_instansi();
        $kota = $this->tr_instansi->get_by_id(19)->value;

		// Ambil Kode Pos
        $this->tr_instansi = new Tr_instansi();
        $kdpos = $this->tr_instansi->get_by_id(20)->value;

		// Ambil web
        $this->tr_instansi = new Tr_instansi();
        $web = $this->tr_instansi->get_by_id(21)->value;

		// Ambil e-mail
        $this->tr_instansi = new Tr_instansi();
        $e_mail = $this->tr_instansi->get_by_id(22)->value;
        
        $alamat = $alamat . ' Tlp. ' . $tlp . ', Fax. ' . $fax;
        $alamat2 = 'Website: ' . $web . '   e-mail: ' . $e_mail;
		$alamat3 = strtoupper($kota) . ' - ' . $kdpos;
        $judul  = 'DATA PERMOHONAN SEKTOR ' . $bidang;
		$judul_izin = 'JENIS ' . $jdl_izin;
		$judul1 = $this->menu_filter('2', $menu) . ', PERIODE '. $this->lib_date->mysql_to_human($tgla).' - '.$this->lib_date->mysql_to_human($tglb);
		$judul2 = 'Asal Permohonan : ' . $c_asal;

//		$pdf = new FPDF({p/l},{pt/mm/cm/in},{a3/a4/a5/letter/legal});
		$pdf = new FPDF('l','mm','f4'); //('a3'=>array(841.89,1190.55), 'a4'=>array(595.28,841.89), 'a5'=>array(420.94,595.28), 'letter'=>array(612,792), 'legal'=>array(612,1108));
		$pdf->SetMargins(1,1);
		$pdf->AddPage();
		$pdf->Image($n_logo,2,5,22);
		$pdf->SetFont('Arial','B',15);
		$pdf->Ln(9); $pdf->Cell(0,0.5,$nama_prov,0,1,'C');
		$pdf->SetFont('Arial','B',16);
		$pdf->Ln(5); $pdf->Cell(0,0.5,$nama_badan,0,1,'C');
		$pdf->SetFont('Arial','B',11);
		$pdf->Ln(5); $pdf->Cell(0,0.5,$alamat,0,1,'C');
		$pdf->Ln(4); $pdf->Cell(0,0.5,$alamat2,0,1,'C');
		$pdf->Ln(4); $pdf->Cell(0,0.5,$alamat3,0,1,'C');
        $pdf->SetLineWidth(0.1); $pdf->Line(1,33,438,33);
		$pdf->SetLineWidth(0.5); $pdf->Line(1,34,438,34);

        $pdf->SetFont('Arial','',11);
		$pdf->Ln(13); $pdf->Cell(0,0.5,$judul,0,1,'C');
        if($menu >= 8){
			$pdf->Ln(5); $pdf->Cell(0,0.5,$judul_izin,0,1,'C');
		}
		$pdf->Ln(5); $pdf->Cell(0,0.5,$judul1,0,1,'C');
		$pdf->Ln(5); $pdf->Cell(0,0.5,$judul2,0,1,'C');
		$pdf->SetMargins(1,1);
        
		//Mencetak judul dengan tinggi bervariasi
		$judul = array('NO','NOMOR PENDAFTARAN','TANGGAL DAFTAR','NAMA PEMOHON / PERUSAHAAN','OBJEK IZIN','NOMOR SK',
			           'TANGGAL DITETAPKAN','TANGGAL DITERIMA ADM','TANGGAL DIAMBIL','KONTAK PERSON');
		$l_col = array(10,32,30,85,90,50,30,30,30,50); // total 438 utk legal L
		$align = array('C','C','C','C','C','C','C','C','C','C','C');
		$hit_judul = count($judul);
        $pdf->SetFont('Arial','B',8);
		$pdf->Ln(10);
        $space = 5;
		$nb=0;
        for($i=0;$i<count($judul);$i++)
            $nb=max($nb,$pdf->NbLines($l_col[$i],$judul[$i]));
        $h=$space*$nb;
        //Issue a page break first if needed
        $pdf->CheckPageBreak($h);
        //Draw the cells of the row
        for($i=0;$i<count($judul);$i++) {
            $w=$l_col[$i];
            $a=isset($align[$i]) ? $align[$i] : 'L';
            //Save the current position
            $x=$pdf->GetX();
            $y=$pdf->GetY();
            //Draw the border
            $pdf->Rect($x,$y,$w,$h);
            //Print the text
            $pdf->MultiCell($w,$space,$judul[$i],0,$a);
            //Put the position to the right of the cell
            $pdf->SetXY($x+$w,$y);
        }
        //Go to the next line
        $pdf->Ln($h);
        //EOF(Mencetak judul dengan tinggi bervariasi)

        //perintah untuk mengambil data dari database
		$sql = $this->sql_info_viewdata();
        $sql .= $this->kat_filter();
		$sql .= $this->menu_filter('1', $menu);
        //EOF() perintah untuk mengambil data dari database

        $obj=$this->db->query($sql)->result();
		$no = 0;
        if ($obj){
            foreach ($obj as $list) {
                $no++;
                //cetak isi tabel ke pdf
				$permohonan_tmperusahaan = new tmpermohonan_tmperusahaan();
				$tmpermohonan_id = $permohonan_tmperusahaan->where('tmpermohonan_id', $list->id)->get()->tmperusahaan_id;
				$a = $tmpermohonan_id;
                $perusahaan = new tmperusahaan();
				$n_perusahaan = $perusahaan->where('id', $tmpermohonan_id)->get()->n_perusahaan;
				if($n_perusahaan=='')
					$n_pemohon = $list->n_pemohon;
				else
				    $n_pemohon = $list->n_pemohon .' / '. $n_perusahaan;

                $permohonan_tmsk = new tmpermohonan_tmsk();
				$tmpermohonan_id = $permohonan_tmsk->where('tmpermohonan_id', $list->id)->get()->tmsk_id;
				$b = $tmpermohonan_id;
                $tmsk = new tmsk();
				$tmsk = $tmsk->where('id', $tmpermohonan_id)->get();
                $no_surat = $tmsk->no_surat_edit;
				if($no_surat == '') $no_surat = $tmsk->no_surat;

				//$tgl_surat = $tmsk->tgl_surat_edit;
				//if($tgl_surat == '0000-00-00') $tgl_surat = $tmsk->tgl_surat;
				$tgl_surat = $tmsk->tgl_surat;

				$tgl_ambil1 = $tmsk->tgl_ambil1;
				$kontak = $tmsk->kontak;
                $tgl_terima = $this->lib_date->mysql_to_human($list->d_terima_berkas);
				$tgl_siap = $this->lib_date->mysql_to_human($list->tgl_siap_serah);
				$tgl_surat = $this->lib_date->mysql_to_human($tgl_surat);
                $tgl_ambil1 = $this->lib_date->mysql_to_human($tgl_ambil1);
                
			    $isi = array($no.'.',$list->pendaftaran_id,$tgl_terima,$n_pemohon,$list->a_izin,
					         $no_surat,$tgl_surat,$tgl_siap,$tgl_ambil1,$kontak);
    			$align = array('R','L','L','L','L','L','L','L','L','L');
                $space = 5;
    	    	$nb=0;
                for($i=0;$i<count($isi);$i++)
                    $nb=max($nb,$pdf->NbLines($l_col[$i],$isi[$i]));
                $h=$space*$nb;
                //Issue a page break first if needed
                $pdf->CheckPageBreak($h);
                //Draw the cells of the row
                for($i=0;$i<count($isi);$i++) {
                    $w=$l_col[$i];
                    $a=isset($align[$i]) ? $align[$i] : 'L';
                    //Save the current position
                    $x=$pdf->GetX();
                    $y=$pdf->GetY();
                    //Draw the border
                    $pdf->Rect($x,$y,$w,$h);
                    //Print the text
                    $pdf->MultiCell($w,$space,$isi[$i],0,$a);
                    //Put the position to the right of the cell
                    $pdf->SetXY($x+$w,$y);
                }
                //Go to the next line
                $pdf->Ln($h);
	    		// EOF(cetak isi tabel ke pdf)
            }
	    }
        #output file PDF
        $pdf->Output('List_izin.pdf','D');
	}

    public function cetak_list_excel_OLD($tgl_a = null, $tgl_b = null, $ctk_asal = null) { // cetak list per izin ke Excel
	    header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=dataxl.xls");
        header("Pragma: no-cache");
        header("Expires: 0");
        
		$username = new user();
        $username->where('username', $this->session->userdata('username'))->get();
		$tgla = $username->gvar1;
        $tglb = $username->gvar2;
		$gerai = $username->gvar3;
        $id_key = $username->gvar4;
		$menu = $username->gvar10;
        
        if($menu >= 8){ // info per jenis izin
		    $kd_sektor = new trperizinan_trsektor();
            $kd_sektor->where('trperizinan_id', $id_key)->get();
            $kd_sektor = $kd_sektor->trsektor_id; 
            $sektor = new trsektor();
            $sektor->get_by_id($kd_sektor);
            $izin = new trperizinan();
			$izin->get_by_id($id_key);
			$jdl_bidang = $sektor->n_sektor;
			$jdl_izin = $izin->n_perizinan;
        }else{
			$this->sektor = new trsektor();
			$izin = $this->sektor->get_by_id($id_key);
		    $jdl_bidang = $this->sektor->get_by_id($id_key)->n_sektor;
			$jdl_izin = '';
		}
        
        $ngerai = $gerai;
        if($gerai === '0') $ngerai = 'SELURUHNYA';
        if($menu >= 8){ // info per jenis izin
		    $jdl_laporan = "<tr>LAPORAN PERIZINAN : ".$jdl_izin."</tr>";
            if ($gerai === '0') {
			    $data_pendaftaran = $this->permohonan->where_related("trstspermohonan", 'id <> 1')
                                         ->where("d_terima_berkas between '$tgla' and '$tglb'")
                                         ->where_related($izin)->get();
            } else {
			    $data_pendaftaran = $this->permohonan->where_related("trstspermohonan", 'id <> 1')
                                         ->where("kd_gerai = '$gerai' AND d_terima_berkas between '$tgla' and '$tglb'")
                                         ->where_related($izin)->get();
            }
        }else{
			$jdl_laporan = "<tr>LAPORAN SEKTOR : ".$jdl_bidang."</tr>";
	        if ($gerai === '0') {
			    $data_pendaftaran = $this->permohonan->where_related("trstspermohonan", 'id <> 1')
                                         ->where("d_terima_berkas between '$tgla' and '$tglb' AND trsektor_id = '".$id_key."'")->get();
            } else {
                $data_pendaftaran = $this->permohonan->where_related("trstspermohonan", 'id <> 1')
                                         ->where("kd_gerai = '$gerai' AND d_terima_berkas between '$tgla' and '$tglb' AND trsektor_id = '".$id_key."'")->get();
            }
        }
        
		$jdl = "<tr>
                 <td>".'NOMOR'."</td>
			     <td>".'NOMOR PENDAFTARAN'."</td>
    			 <td>".'ASAL PERMOHONAN'."</td>
                 <td>".'TANGGAL DAFTAR'."</td>
				 <td>".'JAM DAFTAR'."</td>
                 <td>".'NAMA PEMOHON'."</td>
			     <td>".'TELPON PEMOHON'."</td>
				 <td>".'ALAMAT PEMOHON'."</td>
				 <td>".'PROVINSI'."</td>
				 <td>".'KABUPATEN/KOTA'."</td>
				 <td>".'KECAMATAN'."</td>
   				 <td>".'DESA/KELURAHAN'."</td>
				 <td>".'NAMA PERUSAHAAN'."</td>
    			 <td>".'NAMA PIMPINAN'."</td>
	    		 <td>".'ALAMAT PERUSAHAAN'."</td>
 
                 <td>".'PERMOHONAN IZIN'."</td>
	    		 <td>".'KODE IZIN'."</td>
		    	 <td>".'STATUS BERKAS'."</td>
                 <td>".'TANGGAL SELESAI'."</td>
				 <td>".'DURASI'."</td>
				 <td>".'NOMOR SURAT'."</td>
			     <td>".'OBJEK IZIN'."</td>
				 <td>".'PROVINSI'."</td>
				 <td>".'KABUPATEN/KOTA'."</td>
				 <td>".'KECAMATAN'."</td>
   				 <td>".'DESA/KELURAHAN'."</td>
				 <td>".'KETERANGAN'."</td>
    			 <td>".'KONTAK PERSON'."</td>";

		//Menambahkan judul property
		$hitproperty = 0;
        $no_field = array('');
		for ($i = 0; $i <= 100; $i++) {
			$var = "var_teknis".$i;
            if($izin->$var <> '' ){
				$aktif = $this->lib_date->array_property('11',$izin->$var);      // Aktifasi Property
				if($aktif == 'Ya') {
                    $hitproperty++;
                    $nfield = $this->lib_date->array_property('0',$izin->$var);// ambil no Data Field property 
                    if($hitproperty == 1) {
                        $no_field = array($nfield);
                    } else {
				        $tempArray = array($nfield);
                        $no_field = array_merge ($no_field, $tempArray);
                    }
		    		$njdl = $this->lib_date->array_property('1',$izin->$var);// ambil judul property 
			    	$jdl = $jdl."<td>".$njdl."</td>";
				}
            }
        }

        $jdl = $jdl . "</tr>";

        echo "<table width='100%' border='0' font-size:16px;'>";
		echo $jdl_laporan;
		echo "<tr>PERIODE : ".$this->lib_date->mysql_to_human($tgla)." - ".$this->lib_date->mysql_to_human($tglb)."</tr>";
		echo "<tr>ASAL PERMOHONAN : ".$ngerai."</tr>";
		echo "</table>";
		echo "<table width='100%' cellspacing='0' cellpadding='0' border='1' style='border-style:solid; border-width:thin;font-size:10px;'>";
	    echo $jdl; 

	    $i=0;
		foreach ($data_pendaftaran as $row){
            $row->tmpemohon->get();
            $row->trstspermohonan->get();
            $row->tmperusahaan->get();
			$row->trperizinan->get();
			$row->tmsk->get();
			$row->tmpemohon->trkelurahan->get();
			$row->tmpemohon->trkelurahan->trkecamatan->get();
			$row->tmpemohon->trkelurahan->trkecamatan->trkabupaten->get();
			$row->tmpemohon->trkelurahan->trkecamatan->trkabupaten->trpropinsi->get();
			
			$wil_lok = new trkelurahan();
            $wil_lok->where('id', $row->trkelurahan_id)->get();
			$n_kelurahan = $wil_lok->n_kelurahan;
            $wil_lok->trkecamatan->get();
			$wil_lok->trkecamatan->trkabupaten->get();
			$wil_lok->trkecamatan->trkabupaten->trpropinsi->get();

			if($row->status_berkas == "proses")
				$n_status = $row->trstspermohonan->n_sts_permohonan;
            else
				$n_status = $row->status_berkas;
            
			$tgl_selesai = $row->tmsk->tgl_surat_edit;
			$no_surat = $row->tmsk->no_surat_edit;
			if($no_surat === '') {
				$tgl_selesai = $row->tmsk->tgl_surat;
			    $no_surat = $row->tmsk->no_surat;
			}

			if($tgl_selesai == '') {
				$durasi = '-';
            } else {
			    $durasi = $this->lib_date->lama_durasi($row->d_terima_berkas, $tgl_selesai);
			}

			$i++;

			$isi = "<tr>
                    <td>".$i."</td>
			        <td>'".$row->pendaftaran_id."</td>
					<td>".$row->kd_gerai."</td>
            		<td>".$row->d_terima_berkas."</td>
					<td>".substr($row->d_entry,11,8)."</td>
                    <td>".$row->tmpemohon->n_pemohon."</td>
					<td>".$row->tmpemohon->telp_pemohon."</td>
					<td>".$row->tmpemohon->a_pemohon."</td>
					<td>".$row->tmpemohon->trkelurahan->trkecamatan->trkabupaten->trpropinsi->n_propinsi."</td>
					<td>".$row->tmpemohon->trkelurahan->trkecamatan->trkabupaten->n_kabupaten."</td>
					<td>".$row->tmpemohon->trkelurahan->trkecamatan->n_kecamatan."</td>
					<td>".$row->tmpemohon->trkelurahan->n_kelurahan."</td>
					<td>".$row->tmperusahaan->n_perusahaan."</td>
					<td>".$row->tmperusahaan->nama_pimpinan."</td>
					<td>".$row->tmperusahaan->a_perusahaan."</td>

                    <td>".$row->trperizinan->n_perizinan."</td>
					<td>".$row->trperizinan->kd_izin."</td>
					<td>".$n_status."</td>
                    <td>".$tgl_selesai."</td>
                    <td>".$durasi."</td>
					<td>".$no_surat."</td>
                    <td>".$row->a_izin."</td>
                    <td>".$wil_lok->trkecamatan->trkabupaten->trpropinsi->n_propinsi."</td>
					<td>".$wil_lok->trkecamatan->trkabupaten->n_kabupaten."</td>
					<td>".$wil_lok->trkecamatan->n_kecamatan."</td>
					<td>".$n_kelurahan."</td>
					<td>".$row->keterangan."</td>
					<td>".$row->kontak_person."</td>";

            //Menambahkan judul property
			foreach ($no_field as $cek_syarat) {
	    		$var = "dt_teknis".$cek_syarat;
				$nisi = '-';
				if ($row->$var <> '') {
			    	$nisi = $row->$var;    // ambil nilai data property
					$hitung = strlen($nisi);
               		$cek_posisi = strpos($nisi,'^'); 
					$cekisi = substr($nisi,$cek_posisi+1,$hitung);
					if($cekisi == '' || $cekisi == '-') {
    					$nisi = substr($nisi,0,$cek_posisi);
					    if($nisi == '' || $nisi == '-') $nisi = '-';
					} else {
					    $nisi = $cekisi;
					}
				}
				$isi = $isi."<td>".$nisi."</td>";
            }

            $isi = $isi . "</tr>";

            echo $isi;
        }
        echo "</table>";
	}

    public function cetak_list_excel($tgl_a = null, $tgl_b = null, $ctk_asal = null) { // cetak list per izin ke Excel
	    header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=dataxl.xls");
        header("Pragma: no-cache");
        header("Expires: 0");
        
		$username = new user();
        $username->where('username', $this->session->userdata('username'))->get();
		$tgla = $username->gvar1;
        $tglb = $username->gvar2;
		$gerai = $username->gvar3;
        $id_key = $username->gvar4;
		$list_kat = $username->gvar9;
		$menu = $username->gvar10;
        
        if($menu >= 8){ // info per jenis izin
		    $kd_sektor = new trperizinan_trsektor();
            $kd_sektor->where('trperizinan_id', $id_key)->get();
            $kd_sektor = $kd_sektor->trsektor_id; 
            $sektor = new trsektor();
            $sektor->get_by_id($kd_sektor);
            $izin = new trperizinan();
			$izin->get_by_id($id_key);
			$jdl_bidang = $sektor->n_sektor;
			$jdl_izin = $izin->n_perizinan;
        }else{
			$this->sektor = new trsektor();
			$izin = $this->sektor->get_by_id($id_key);
		    $jdl_bidang = $this->sektor->get_by_id($id_key)->n_sektor;
			$jdl_izin = '';
		}
        
        $ngerai = $gerai;
        if($gerai === '0') $ngerai = 'SELURUHNYA';
        if($menu >= 8){ // info per jenis izin
		    $jdl_laporan = "<tr>LAPORAN PERIZINAN : ".$jdl_izin."</tr>";
        }else{
			$jdl_laporan = "<tr>LAPORAN PERIZINAN SEKTOR : ".$jdl_bidang."</tr>";
        }
	    $katagori = "<tr>BERDASARKAN : ".strtoupper($this->kat_cari[$list_kat])."</tr>";
        
		//perintah untuk mengambil data dari database
		$sql = $this->sql_info_viewdata();
        $sql .= $this->kat_filter();
		$sql .= $this->menu_filter('1', $menu);
        //EOF() perintah untuk mengambil data dari database
        $data_pendaftaran=$this->db->query($sql)->result();

		$jdl = "<tr>
                 <td>".'NOMOR'."</td>
			     <td>".'NOMOR PENDAFTARAN'."</td>
    			 <td>".'ASAL PERMOHONAN'."</td>
                 <td>".'TANGGAL DAFTAR'."</td>
				 <td>".'JAM DAFTAR'."</td>
                 <td>".'NAMA PEMOHON'."</td>
			     <td>".'TELPON PEMOHON'."</td>
				 <td>".'ALAMAT PEMOHON'."</td>
				 <td>".'PROVINSI'."</td>
				 <td>".'KABUPATEN/KOTA'."</td>
				 <td>".'KECAMATAN'."</td>
   				 <td>".'DESA/KELURAHAN'."</td>
				 <td>".'NAMA PERUSAHAAN'."</td>
    			 <td>".'NAMA PIMPINAN'."</td>
	    		 <td>".'ALAMAT PERUSAHAAN'."</td>
 
                 <td>".'PERMOHONAN IZIN'."</td>
	    		 <td>".'KODE IZIN'."</td>
		    	 <td>".'STATUS BERKAS'."</td>
                 <td>".'TANGGAL SELESAI'."</td>
				 <td>".'DURASI'."</td>
				 <td>".'NOMOR SURAT'."</td>
			     <td>".'OBJEK IZIN'."</td>
				 <td>".'PROVINSI'."</td>
				 <td>".'KABUPATEN/KOTA'."</td>
				 <td>".'KECAMATAN'."</td>
   				 <td>".'DESA/KELURAHAN'."</td>
				 <td>".'KETERANGAN'."</td>
    			 <td>".'KONTAK PERSON'."</td>";

		//Menambahkan judul property
		$hitproperty = 0;
        $no_field = array('');
		for ($i = 0; $i <= 100; $i++) {
			$var = "var_teknis".$i;
            if($izin->$var <> '' ){
				$aktif = $this->lib_date->array_property('11',$izin->$var);      // Aktifasi Property
				if($aktif == 'Ya') {
                    $hitproperty++;
                    $nfield = $this->lib_date->array_property('0',$izin->$var);// ambil no Data Field property 
                    if($hitproperty == 1) {
                        $no_field = array($nfield);
                    } else {
				        $tempArray = array($nfield);
                        $no_field = array_merge ($no_field, $tempArray);
                    }
		    		$njdl = $this->lib_date->array_property('1',$izin->$var);// ambil judul property 
			    	$jdl = $jdl."<td>".$njdl."</td>";
				}
            }
        }

        $jdl = $jdl . "</tr>";

        echo "<table width='100%' border='0' font-size:16px;'>";
		echo $jdl_laporan;
		echo $katagori;
		echo "<tr>PERIODE : ".$this->lib_date->mysql_to_human($tgla)." - ".$this->lib_date->mysql_to_human($tglb)."</tr>";
		echo "<tr>ASAL PERMOHONAN : ".$ngerai."</tr>";
		echo "</table>";
		echo "<table width='100%' cellspacing='0' cellpadding='0' border='1' style='border-style:solid; border-width:thin;font-size:10px;'>";
	    echo $jdl; 

	    $i=0;
		foreach ($data_pendaftaran as $row){
            
			$permohonan = new tmpermohonan();
            $permohonan->where('id', $row->id)->get();
            $permohonan->tmpemohon->get();
            $permohonan->trstspermohonan->get();
            $permohonan->tmperusahaan->get();
			$permohonan->trperizinan->get();
			$permohonan->tmsk->get();
			$permohonan->tmpemohon->trkelurahan->get();
			$permohonan->tmpemohon->trkelurahan->trkecamatan->get();
			$permohonan->tmpemohon->trkelurahan->trkecamatan->trkabupaten->get();
			$permohonan->tmpemohon->trkelurahan->trkecamatan->trkabupaten->trpropinsi->get();

            $wil_lok = new trkelurahan();
            $wil_lok->where('id', $permohonan->trkelurahan_id)->get();
			$n_kelurahan = $wil_lok->n_kelurahan;
            $wil_lok->trkecamatan->get();
			$wil_lok->trkecamatan->trkabupaten->get();
			$wil_lok->trkecamatan->trkabupaten->trpropinsi->get();


			if($row->status_berkas == "proses")
				$n_status = $permohonan->trstspermohonan->n_sts_permohonan;
            else
				$n_status = $row->status_berkas;
            
			$tgl_selesai = $permohonan->tmsk->tgl_surat_edit;
			$no_surat = $permohonan->tmsk->no_surat_edit;
			if($no_surat === '') {
				$tgl_selesai = $permohonan->tmsk->tgl_surat;
			    $no_surat = $permohonan->tmsk->no_surat;
			}

			if($tgl_selesai == '') {
				$durasi = '-';
            } else {
			    $durasi = $this->lib_date->lama_durasi($row->d_terima_berkas, $tgl_selesai);
			}

			$i++;

			$isi = "<tr>
                    <td>".$i."</td>
			        <td>'".$row->pendaftaran_id."</td>
					<td>".$row->kd_gerai."</td>
            		<td>".$row->d_terima_berkas."</td>
					<td>".substr($permohonan->d_entry,11,8)."</td>
                    <td>".$permohonan->tmpemohon->n_pemohon."</td>
					<td>".$permohonan->tmpemohon->telp_pemohon."</td>
					<td>".$permohonan->tmpemohon->a_pemohon."</td>
					<td>".$permohonan->tmpemohon->trkelurahan->trkecamatan->trkabupaten->trpropinsi->n_propinsi."</td>
					<td>".$permohonan->tmpemohon->trkelurahan->trkecamatan->trkabupaten->n_kabupaten."</td>
					<td>".$permohonan->tmpemohon->trkelurahan->trkecamatan->n_kecamatan."</td>
					<td>".$permohonan->tmpemohon->trkelurahan->n_kelurahan."</td>
					<td>".$permohonan->tmperusahaan->n_perusahaan."</td>
					<td>".$permohonan->tmperusahaan->nama_pimpinan."</td>
					<td>".$permohonan->tmperusahaan->a_perusahaan."</td>

                    <td>".$permohonan->trperizinan->n_perizinan."</td>
					<td>".$permohonan->trperizinan->kd_izin."</td>
					<td>".$n_status."</td>
                    <td>".$tgl_selesai."</td>
                    <td>".$durasi."</td>
					<td>".$no_surat."</td>
                    <td>".$row->a_izin."</td>
                    <td>".$wil_lok->trkecamatan->trkabupaten->trpropinsi->n_propinsi."</td>
					<td>".$wil_lok->trkecamatan->trkabupaten->n_kabupaten."</td>
					<td>".$wil_lok->trkecamatan->n_kecamatan."</td>
					<td>".$n_kelurahan."</td>
					<td>".$permohonan->keterangan."</td>
					<td>".$permohonan->kontak_person."</td>";

            //Menambahkan judul property
			foreach ($no_field as $cek_syarat) {
	    		$var = "dt_teknis".$cek_syarat;
				$nisi = '-';
				if ($permohonan->$var <> '') {
			    	$nisi = $permohonan->$var;    // ambil nilai data property
					$hitung = strlen($nisi);
               		$cek_posisi = strpos($nisi,'^'); 
					$cekisi = substr($nisi,$cek_posisi+1,$hitung);
					if($cekisi == '' || $cekisi == '-') {
    					$nisi = substr($nisi,0,$cek_posisi);
					    if($nisi == '' || $nisi == '-') $nisi = '-';
					} else {
					    $nisi = $cekisi;
					}
				}
				$isi = $isi."<td>".$nisi."</td>";
            }

            $isi = $isi . "</tr>";

            echo $isi;
        }
        echo "</table>";
	}

	function datatables_viewdata(){
        $iDisplayStart=$this->input->post('iDisplayStart');
        $obj=$this->get_list_viewdata();
        $total=$this->get_total_viewdata();
        if ($obj){
            $img_info = array(
                'src' => base_url().'assets/images/icon/information.png',
                'alt' => 'Lihat Detail',
                'title' => 'Lihat Detail',
                'border' => '0',
            );
            $i=$iDisplayStart;
			$listID = '';
            foreach ($obj as $list) {
                $listID = $listID.$list->id.';';
                //$action = anchor(site_url('info/infotracking/detail') .'/'. $list->id, img($img_info));
				$action = anchor(site_url('arsip/edit') .'/L/'. $list->id.'/3', img($img_info))."&nbsp;";
                $i++;
                if($list->idjenis == '1') $tgl_permohonan = $list->d_terima_berkas;
                if($list->idjenis == '2') $tgl_permohonan = $list->d_perubahan;
                if($list->idjenis == '3') $tgl_permohonan = $list->d_perpanjangan;
                if($list->idjenis == '4') $tgl_permohonan = $list->d_daftarulang;
				$kelompok = new trkelompok_perizinan_trperizinan();
                $kelompok->where('trperizinan_id', $list->idizin)->get();
				$kel_izin = $kelompok->trkelompok_perizinan_id;
                
				$status = '';
				if($list->status_berkas == 'proses') {
                    if($kel_izin != '1' && $kel_izin != '3' && $kel_izin != '5')
                        $status = $this->terbilang->cek_status($list->kd_status);
                    else
                        $status = $this->terbilang->cek_status('5');
				}else{
                    if($list->desc_arsip == '') {
                        $b1 = '<span style="color: Red">';
                        $be1 = '</span>';
                    } else {
                        if($list->nama_file == '') {
                            $b1 = '<span style="color: Blue">';
                            $be1 = '</span>';
                        } else {
                            $b1 = '';
                            $be1 = '';
                        }
                    }
    				$status = '- '.$list->status_berkas;
					if($list->status_berkas != 'Izin Ditolak FO') {
                        if($list->kd_status < 7){ 
							if($list->c_izin_selesai == 1){
							    $status .= '<br>'.'- '.$this->terbilang->cek_status('9');
                            }else{
                                $status .= '<br>'.'- '.'Penyusunan Berkas';
							}
                        }else{
                            $status .= '<br>'.'- '.$this->terbilang->cek_status($list->kd_status);
						}
                        $status .= $b1.'<br>'.'- '.' ARSIP '.$be1;
					}
				}
                
				if($list->nilai_retribusi == 0)
					$nret = '';
				else
                    $nret = 'Rp. '.number_format($list->nilai_retribusi,2);

                $aaData[] = array(
                    $i,
                    $list->pendaftaran_id.'<br>'.$list->n_pemohon.'<br>'.$list->n_perusahaan,
                    $list->kd_gerai.'<br>'.$this->lib_date->mysql_to_human($tgl_permohonan).'<br>'.$this->lib_date->mysql_to_human($list->d_selesai_proses),
                    $list->n_perizinan,
                    $list->a_izin,
					$this->lib_date->mysql_to_human($list->d_berlaku_izin).'<br>'.$nret,
                    $status,
                    $action
                );
            }
        } else {
            $aaData=array();
        }
        $sOutput = array (
            "sEcho" => $this->input->post('sEcho'),
            "iTotalRecords" => $total,
            "iTotalDisplayRecords" => $total,
            "aaData" => $aaData
        );
        echo json_encode($sOutput);
    }

	function get_list_viewdata(){
		$username = new user();
        $username->where('username', $this->session->userdata('username'))->get();
		$tgla = $username->gvar1;
        $tglb = $username->gvar2;
		$gerai = $username->gvar3;
		$id_key = $username->gvar4;
		$list_kat = $username->gvar9;
		$menu = $username->gvar10;

        $sSearch = $this->input->post('sSearch');
        $iDisplayLength = $this->input->post('iDisplayLength');
        $iDisplayStart = $this->input->post('iDisplayStart');

		// Untuk di filter
        $sql = $this->sql_info_viewdata();
        $sql .= $this->kat_filter();
		$sql .= $this->menu_filter('1', $menu);
        // EOF() Untuk di filter

        if($sSearch != NULL){
            $colum = array("t1.pendaftaran_id", "t1.d_berlaku_izin", "t9.nilai_retribusi,", "t3.n_perizinan","t1.a_izin", "t5.n_pemohon", "t13.n_permohonan" ,"t7.n_sts_permohonan");
            $sql .= $this->lib_query->add_searching($colum, 'AND', $sSearch);
        }
        $sql .=" LIMIT  $iDisplayStart,$iDisplayLength";
        return $this->db->query($sql)->result();
    }

	function get_total_viewdata(){
		$username = new user();
        $username->where('username', $this->session->userdata('username'))->get();
		$tgla = $username->gvar1;
        $tglb = $username->gvar2;
		$gerai = $username->gvar3;
		$id_key = $username->gvar4;
		$list_kat = $username->gvar9;
		$menu = $username->gvar10;
     
        $sSearch = $this->input->post('sSearch');

        // Untuk di filter
		$sql = $this->sql_info_viewdata();
        $sql .= $this->kat_filter();
		$sql .= $this->menu_filter('1', $menu);
        // EOF() Untuk di filter

		if($sSearch != NULL){
            $colum = array("t1.pendaftaran_id", "t1.d_berlaku_izin", "t9.nilai_retribusi,", "t3.n_perizinan","t1.a_izin", "t5.n_pemohon", "t13.n_permohonan" ,"t7.n_sts_permohonan");
            $sql .= $this->lib_query->add_searching($colum, 'AND', $sSearch);
        }
        return $this->db->query($sql)->num_rows();
    }

    function kat_filter(){
		$username = new user();
        $username->where('username', $this->session->userdata('username'))->get();
		$tgla = $username->gvar1;
        $tglb = $username->gvar2;
		$gerai = $username->gvar3;
		$id_key = $username->gvar4;
		$list_kat = $username->gvar9;
		$menu = $username->gvar10;
        $sql = "";
		if($menu <= 7) {              // info per sektor
		    if ($list_kat === '1'){   // per tanggal Permohonan
			    if ($gerai === '0') { // seluruh data
	    	        $sql .= " WHERE t7.id <> 1 AND t1.trsektor_id = '$id_key' AND t1.d_terima_berkas between '$tgla' and '$tglb' ";
        		} else {
	        	    $sql .= " WHERE t7.id <> 1 AND t1.kd_gerai = '$gerai' AND t1.trsektor_id = '$id_key' AND t1.d_terima_berkas between '$tgla' and '$tglb' ";
		        }
			}else{                    // per tanggal selesai
			    $sql .= " LEFT JOIN tmpermohonan_tmsk as t16 on t2.tmpermohonan_id = t16.tmpermohonan_id ";
                $sql .= " LEFT JOIN tmsk as t17 on t17.id = t16.tmsk_id ";
                if ($gerai === '0') { // seluruh data
	    	        $sql .= " WHERE t7.id <> 1 AND t1.trsektor_id = '$id_key' AND ( t17.tgl_surat between '$tgla' and '$tglb' or t17.tgl_surat_edit between '$tgla' and '$tglb') ";
    		    } else {
		            $sql .= " WHERE t7.id <> 1 AND t1.kd_gerai = '$gerai' AND t1.trsektor_id = '$id_key' 
					          AND ( t17.tgl_surat between '$tgla' and '$tglb' or t17.tgl_surat_edit between '$tgla' and '$tglb') ";
		        }
			}
		}else{                        // info per jenis izin
		    if ($list_kat === '1'){   // per tanggal Permohonan
			    if ($gerai === '0') { // seluruh data
	    	        $sql .= " WHERE t7.id <> 1 AND t2.trperizinan_id  = '$id_key' AND t1.d_terima_berkas between '$tgla' and '$tglb' ";
    		    } else {
		            $sql .= " WHERE t7.id <> 1 AND t1.kd_gerai = '$gerai' AND t2.trperizinan_id = '$id_key' AND t1.d_terima_berkas between '$tgla' and '$tglb' ";
		        }
			}else{                    // per tanggal selesai
                $sql .= " LEFT JOIN tmpermohonan_tmsk as t16 on t2.tmpermohonan_id = t16.tmpermohonan_id ";
                $sql .= " LEFT JOIN tmsk as t17 on t17.id = t16.tmsk_id ";
				if ($gerai === '0') { // seluruh data
	    	        $sql .= " WHERE t7.id <> 1 AND t2.trperizinan_id  = '$id_key' 
					          AND ( t17.tgl_surat between '$tgla' and '$tglb' or t17.tgl_surat_edit between '$tgla' and '$tglb') ";
    		    } else {
		            $sql .= " WHERE t7.id <> 1 AND t1.kd_gerai = '$gerai' AND t2.trperizinan_id = '$id_key' 
					          AND ( t17.tgl_surat between '$tgla' and '$tglb' or t17.tgl_surat_edit between '$tgla' and '$tglb') ";
		        }
			}
	    }
        return $sql;
	}

    function menu_filter($kd = NULL, $menu = NULL){
		$sql = "";
		switch ($menu) {
            case 1 : // Jumlah Seluruh Permohonan per sektor
                $n_menu = "SELURUH PERMOHONAN";
				$sql = "";
                break;
            case 2 : // Jumlah Izin Terbit per sektor
			    $n_menu = "IZIN YANG TELAH DITERBITKAN";
                $sql = " AND t1.status_berkas = 'Izin Disetujui' ";
                break;
			case 3 : // Jumlah Terbit Diambil per sektor
			    $n_menu = "IZIN TERBIT YANG TELAH DIAMBIL";
                $sql = " AND t1.status_berkas = 'Izin Disetujui' AND t1.d_ambil_izin IS NOT NULL ";
                break;
			case 4 : // Jumlah Terbit Belum Diambil per sektor
			    $n_menu = "IZIN TERBIT YANG BELUM DIAMBIL";
                $sql = " AND t1.status_berkas = 'Izin Disetujui' AND t1.d_ambil_izin IS NULL ";
                break;
            case 5 : // Jumlah Izin Ditolak per sektor
			    $n_menu = "IZIN YANG DITOLAK";
                $sql = " AND t1.status_berkas = 'Izin Ditolak' ";
                break;
			case 6 : // Jumlah Izin Ditolak FO per sektor
			    $n_menu = "IZIN YANG DITOLAK DI FO";
                $sql = " AND t1.status_berkas = 'Izin Ditolak FO' ";
                break;
			case 7 : // Jumlah Izin dalam proses per sektor
			    $n_menu = "IZIN YANG MASIH DALAM PROSES";
                $sql = " AND t1.status_berkas = 'proses' ";
                break;
			case 8 : // Jumlah Seluruh Permohonan per jenis izin
                $n_menu = "SELURUH PERMOHONAN";
				$sql = "";
                break;
			case 9 : // Jumlah Izin Terbit per jenis izin
			    $n_menu = "IZIN YANG TELAH DITERBITKAN";
                $sql = " AND t1.status_berkas = 'Izin Disetujui' ";
                break;
			case 10 : // Jumlah Terbit Diambil per jenis izin
			    $n_menu = "IZIN TERBIT YANG TELAH DIAMBIL";
                $sql = " AND t1.status_berkas = 'Izin Disetujui' AND t1.d_ambil_izin IS NOT NULL ";
                break;
			case 11 : // Jumlah Terbit Belum Diambil per jenis izin
			    $n_menu = "IZIN TERBIT YANG BELUM DIAMBIL";
                $sql = " AND t1.status_berkas = 'Izin Disetujui' AND t1.d_ambil_izin IS NULL ";
                break;
            case 12 : // Jumlah Izin Ditolak per jenis izin
			    $n_menu = "IZIN YANG DITOLAK";
                $sql = " AND t1.status_berkas = 'Izin Ditolak' ";
                break;
			case 13 : // Jumlah Izin Ditolak FO per jenis izin
			    $n_menu = "IZIN YANG DITOLAK DI FO";
                $sql = " AND t1.status_berkas = 'Izin Ditolak FO' ";
                break;
			case 14 : // Jumlah Izin dalam proses per jenis izin
			    $n_menu = "IZIN YANG MASIH DALAM PROSES";
                $sql = " AND t1.status_berkas = 'proses' ";
                break;
        }
		if($kd == '1'){
			$sql .= " ORDER BY t1.id DESC ";
			return $sql;
		}else{
			return $n_menu;
		}
	}

	function sql_info_viewdata(){ // ambil semua data
		$sql=" select  t1.id, t1.pendaftaran_id, t1.a_izin, t1.trsektor_id, t1.d_terima_berkas, t1.kd_gerai, t1.status_berkas, t1.trsektor_id, t1.tgl_siap_serah, 
			   t1.d_selesai_proses, t1.status_berkas, t1.d_ambil_izin, t1.kd_status, t1.desc_arsip, t1.nama_file, t1.c_izin_selesai, t1.d_berlaku_izin,
			   t3.n_perizinan, t3.id idizin, t5.n_pemohon, t7.n_sts_permohonan, t9.nilai_retribusi, t13.id idjenis, t13.n_permohonan,
			   t15.n_perusahaan
			   FROM tmpermohonan as t1
		       LEFT JOIN tmpermohonan_trperizinan as t2 on t1.id = t2.tmpermohonan_id
               LEFT JOIN trperizinan as t3 on t3.id = t2.trperizinan_id
			   LEFT JOIN tmpemohon_tmpermohonan as t4 on t4.tmpermohonan_id = t1.id
               LEFT JOIN tmpemohon as t5 on t5.id = t4.tmpemohon_id
               LEFT JOIN tmpermohonan_trstspermohonan as t6 on t1.id = t6.tmpermohonan_id
               LEFT JOIN trstspermohonan as t7 on t7.id = t6.trstspermohonan_id
               LEFT JOIN tmbap_tmpermohonan t8 ON t1.id = t8.tmpermohonan_id
               LEFT JOIN tmbap t9 ON t8.tmbap_id = t9.id
			   LEFT JOIN tmpermohonan_trjenis_permohonan as t12 on t1.id = t12.tmpermohonan_id
               LEFT JOIN trjenis_permohonan as t13 on t12.trjenis_permohonan_id = t13.id
			   LEFT JOIN tmpermohonan_tmperusahaan as t14 on t14.tmpermohonan_id = t1.id
               LEFT JOIN tmperusahaan as t15 on t15.id = t14.tmperusahaan_id
             ";
        return $sql;
    }
}