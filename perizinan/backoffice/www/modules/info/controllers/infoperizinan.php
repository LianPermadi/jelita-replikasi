<?php

/**
   * Description of Informasi Perizinan
   * @author agusnur ; Created : 08 Okt 2010
   * @edit PBS       ; Created : 08 Apr 2015
*/

class InfoPerizinan extends WRC_AdminCont {

  public function __construct() {
    parent::__construct();
    $this->perizinan = new trperizinan();
    $this->syarat_izin = new trsyarat_perizinan();
    $this->load->library('fpdf');
    $enabled = FALSE;
    $list_auths = $this->session_info['app_list_auth'];
    
    //foreach ($list_auths as $list_auth) {
      //if($list_auth->id_role === '17') {
        $enabled = TRUE;
      //}
    //}
    
    if(!$enabled) {
      redirect('dashboard');
    }
  }

  public function index() {
    $data['list'] = $this->perizinan->where('c_online',0)->order_by('kd_izin', 'ASC')->get();
    $data['list_izin'] = $this->perizinan->get_list();
    $this->load->vars($data);
    $js =  "$(document).ready(function() {
               oTable = $('#perizinaninfo').dataTable({
                        \"bJQueryUI\": true,
                        \"sPaginationType\": \"full_numbers\"
               });
            } );
           ";
    $this->template->set_metadata_javascript($js);
    $this->session_info['page_name'] = "Informasi Perizinan/Non Perizinan";
    $this->template->build('infoperizinan_list', $this->session_info);
  }

    public function detail($no_izin = NULL) {
        $data_izin = $this->perizinan->get_by_id($no_izin);
        $data['data_izin'] = $data_izin;
        $data['list'] = $this->perizinan->where('id', $no_izin)->get();
        $trunitkerja = new trunitkerja();
			  $trunitkerja = $trunitkerja->where('id', $this->perizinan->dinas_pengelola)->get();
        $dinas_pengelola = $trunitkerja->n_unitkerja;
        $data['dinas_pengelola'] = $dinas_pengelola;
        $this->load->vars($data);

        $js =  "$(document).ready(function() {
                        oTable = $('#perizinandetail').dataTable({
                                \"bJQueryUI\": true,
                                \"sPaginationType\": \"full_numbers\"
                        });
                } );
                ";

        $this->template->set_metadata_javascript($js);
        $this->session_info['page_name'] = "Informasi Persyaratan Izin";
        $this->template->build('infoperizinan_detail', $this->session_info);
    }

	function cetak_syarat($no_izin = NULL, $var = NULL) {
		$data_izin = $this->perizinan->get_by_id($no_izin);
		$nama_jenisperizinan = $data_izin->n_perizinan;
        
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
        
        $alamat = $alamat . ' Tlp. ' . $tlp . ', Fax. ' . $fax . ' ' . $kota . ' ' . $kdpos;
        $alamat2 = 'Website: ' . $web . '   e-mail: ' . $e_mail;

		$pdf = new FPDF();
		$pdf->SetMargins(1,1);
		$pdf->AddPage();
		$pdf->SetFont('Arial','B',13);
		$pdf->Image($n_logo,10,7,18);
		$pdf->Ln(9); $pdf->Cell(0,0.5,$nama_prov,0,1,'C');
		$pdf->SetFont('Arial','B',12);
		$pdf->Ln(5); $pdf->Cell(0,0.5,$nama_badan,0,1,'C');
		$pdf->SetFont('Arial','B',10);
		$pdf->Ln(5); $pdf->Cell(0,0.5,$alamat,0,1,'C');
		$pdf->Ln(5); $pdf->Cell(0,0.5,$alamat2,0,1,'C');
        $pdf->SetLineWidth(0.5); $pdf->Line(10,30,200,30);
		$pdf->SetLineWidth(0.2);

        $pdf->Ln(13); $pdf->Cell(0,0.5,'DAFTAR PERSYARATAN',0,1,'C');
		$pdf->Cell(9);
		$pdf->Ln(5); $pdf->MultiCell( 207, 4, $nama_jenisperizinan, 0, 'C');
		$pdf->SetMargins(1,1);

		$header = array(
            array("label"=>"NO", "length"=>10, "align"=>"C"),
			array("label"=>"Status", "length"=>15, "align"=>"C"),
            array("label"=>"Nama Syarat", "length"=>165, "align"=>"C")
        );

        //perintah untuk mengambil data dari database
        $data = array();
        $i = null;
        $this->perizinan->trsyarat_perizinan->order_by('status', 'asc');
        $list = $this->perizinan->trsyarat_perizinan->get();
        foreach ($list as $list_syarat) {
            $nomor =  $i;
			$syarat = $list_syarat->v_syarat; 
            if($list_syarat->status == "1") $status_data = "Wajib"; else $status_data = "Tidak";

			$show_syarat = new trperizinan_syarat();
            $show_syarat->where('trsyarat_perizinan_id', $list_syarat->id)->where('trperizinan_id', $no_izin)->get();
            $var = $show_syarat->c_show_type;
			$stat_wajib = $show_syarat->status;

			$rule = strval(decbin($var));
            if($show_syarat->status_new == 1) $plv = 6; else $plv = 4; // penambahan pencabutan dan penutupan ditambah 00
            if (strlen($rule) < $plv) {
                $len = $plv - strlen($rule);
                $rule = str_repeat("0", $len) . $rule;
            }
            if($plv == 4) $rule = $rule.'00';                         // penambahan pencabutan dan penutupan ditambah 00
            $arr_rule = str_split($rule);
            if($plv == 4){
			    $c_baru         = $arr_rule[1];
                $c_daftar_ulang = $arr_rule[0];
			}else{
		        $c_baru         = $arr_rule[0];
                $c_daftar_ulang = $arr_rule[1];
            }
            $c_perpanjangan = $arr_rule[2];
            $c_ubah         = $arr_rule[3];
            $c_pencabutan   = $arr_rule[4];
            $c_penutupan    = $arr_rule[5];
            
            $syarat_status = $c_baru;
			//if($var != "0") {
            if ($var != "0" && $syarat_status == '1') {
				$i++;
				$row = array($i, $status_data, $syarat);
	    		array_push($data, $row);
			}
        }

        #buat header tabel
		$pdf->Ln(5);
        $pdf->Cell(9);
		$pdf->SetFont('Arial','','10');
        $pdf->SetFillColor(224,235,255);
        $pdf->SetTextColor(0);
        $pdf->SetDrawColor(0,0,0);
        foreach ($header as $kolom) {
            $pdf->Cell($kolom['length'], 5, $kolom['label'], 1, '0', $kolom['align'], true);
        }
        $pdf->Ln(6);

        #tampilkan data tabelnya
        $pdf->SetFillColor(224,235,255);
        $pdf->SetTextColor(0);
        $pdf->SetFont('');
        $fill=false;
		foreach ($data as $baris) {
            $i = 0;
			$pdf->Cell(9);
			$pdf->Cell($header[0]['length'], 5, $baris[0], 0, '0', 'L', $fill);
			$pdf->Cell($header[1]['length'], 5, $baris[1], 0, '0', 'L', $fill);
			$pdf->MultiCell( $header[2]['length'], 4, $baris[2], 0, 'L', $fill);
            $pdf->Ln(1);
        }
 
        #output file PDF
        $pdf->Output('syarat.pdf','D');
    }

    // Contoh penggunaan Autowarp Modif
    function Row($data) {
        $pdf = new FPDF();
        //Calculate the height of the row
        $nb=0;
        for($i=0;$i<count($data);$i++)
            $nb=max($nb,$this->NbLines($pdf->widths[$i],$data[$i]));
        $h=10*$nb;
            
		//Issue a page break first if needed
        $pdf->CheckPageBreak($h);

        //Draw the cells of the row
        for($i=0;$i<count($data);$i++) {
            $w=$pdf->widths[$i];
            $a=isset($pdf->aligns[$i]) ? $pdf->aligns[$i] : 'L';
                
		    //Save the current position
            $x=$pdf->GetX();
            $y=$pdf->GetY();

            //Draw the border
            $pdf->Rect($x,$y,$w,$h);

            //Print the text
            $pdf->MultiCell($w,10,$data[$i],0,$a);

            //Put the position to the right of the cell
            $pdf->SetXY($x+$w,$y);
        }
        //Go to the next line
        $pdf->Ln($h);
    }

	function NbLines($w,$txt) {
        $pdf = new FPDF();
        //Computes the number of lines a MultiCell of width w will take
        $cw=&$pdf->CurrentFont['cw'];
        if($w==0) {
            $w=$this->w-$pdf->rMargin-$this->x;
        }
		$wmax=($w-2*$pdf->cMargin)*1000/$pdf->FontSize;
        $s=str_replace("\r",'',$txt);
        $nb=strlen($s);
        if($nb>0 and $s[$nb-1]=="\n") {
            $nb--;
        }
		$sep=-1;
        $i=0;
        $j=0;
        $l=0;
        $nl=1;
        while($i<$nb) {
            $c=$s[$i];
            if($c=="\n") {
                $i++;
                $sep=-1;
                $j=$i;
                $l=0;
                $nl++;
                continue;
            }
            if($c==' ') {
                $sep=$i;
			}
            $l+=$cw[$c];
            if($l>$wmax) {
                if($sep==-1) {
                    if($i==$j) {
                        $i++;
					}
                } else {
                    $i=$sep+1;
				}
                $sep=-1;
                $j=$i;
                $l=0;
                $nl++;
            } else {
                $i++;
			}
        }
        return $nl;
    }

/* Contoh penggunaan Autowarp

    require_once("fpdf17/fpdf.php");
 
    class FPDF_AutoWrapTable extends FPDF {
        private $data = array();
        private $options = array(
            'filename' => '',
            'destinationfile' => '',
            'paper_size'=>'F4',
            'orientation'=>'P'
        );
 
        function __construct($data = array(), $options = array()) {
            parent::__construct();
            $this->data = $data;
            $this->options = $options;
        }
 
        public function rptDetailData () {
        //
            $border = 0;
            $this->AddPage();
            $this->SetAutoPageBreak(true,60);
            $this->AliasNbPages();
            $left = 25;
 
            //header
            $this->SetFont("", "B", 15);
            $this->MultiCell(0, 12, 'PT. ACHMATIM DOT NET');
            $this->Cell(0, 1, " ", "B");
            $this->Ln(10);
            $this->SetFont("", "B", 12);
            $this->SetX($left); $this->Cell(0, 10, 'LAPORAN DATA KARYAWAN', 0, 1,'C');
            $this->Ln(10);
 
            $h = 13;
            $left = 40;
            $top = 80;

            #tableheader
            $this->SetFillColor(200,200,200);
            $left = $this->GetX();
            $this->Cell(20,$h,'NO',1,0,'L',true);
            $this->SetX($left += 20); $this->Cell(75, $h, 'NIP', 1, 0, 'C',true);
            $this->SetX($left += 75); $this->Cell(100, $h, 'NAMA', 1, 0, 'C',true);
            $this->SetX($left += 100); $this->Cell(150, $h, 'ALAMAT', 1, 0, 'C',true);
            $this->SetX($left += 150); $this->Cell(100, $h, 'EMAIL', 1, 0, 'C',true);
            $this->SetX($left += 100); $this->Cell(100, $h, 'WEBSITE', 1, 1, 'C',true);
            //$this->Ln(20);
 
            $this->SetFont('Arial','',9);
            $this->SetWidths(array(20,75,100,150,100,100));
            $this->SetAligns(array('C','L','L','L','L','L'));
            $no = 1; $this->SetFillColor(255);
            foreach ($this->data as $baris) {
                $this->Row( array($no++,
                                $baris['nip'],
                                $baris['nama'],
                                $baris['alamat'],
                                $baris['email'],
                                $baris['website']
                ));
            }
        }
 
        public function printPDF () {
            if ($this->options['paper_size'] == "F4") {
                $a = 8.3 * 72; //1 inch = 72 pt
                $b = 13.0 * 72;
                $this->FPDF($this->options['orientation'], "pt", array($a,$b));
            } else {
                $this->FPDF($this->options['orientation'], "pt", $this->options['paper_size']);
            }
            
			$this->SetAutoPageBreak(false);
            $this->AliasNbPages();
            $this->SetFont("helvetica", "B", 10);
            //$this->AddPage();
 
            $this->rptDetailData();
 
            $this->Output($this->options['filename'],$this->options['destinationfile']);
        }
 
        private $widths;
        private $aligns;
 
        function SetWidths($w) {
            //Set the array of column widths
            $this->widths=$w;
        }
 
        function SetAligns($a) {
            //Set the array of column alignments
            $this->aligns=$a;
        }
 
        function Row($data) {
            //Calculate the height of the row
            $nb=0;
            for($i=0;$i<count($data);$i++)
                $nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
            $h=10*$nb;
            
			//Issue a page break first if needed
            $this->CheckPageBreak($h);

            //Draw the cells of the row
            for($i=0;$i<count($data);$i++) {
                $w=$this->widths[$i];
                $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
                
				//Save the current position
                $x=$this->GetX();
                $y=$this->GetY();

                //Draw the border
                $this->Rect($x,$y,$w,$h);

                //Print the text
                $this->MultiCell($w,10,$data[$i],0,$a);

                //Put the position to the right of the cell
                $this->SetXY($x+$w,$y);
            }
            //Go to the next line
            $this->Ln($h);
        }
 
        function CheckPageBreak($h) {
            //If the height h would cause an overflow, add a new page immediately
            if($this->GetY()+$h>$this->PageBreakTrigger)
                $this->AddPage($this->CurOrientation);
        }
 
        function NbLines($w,$txt) {
            //Computes the number of lines a MultiCell of width w will take
            $cw=&$this->CurrentFont['cw'];
            if($w==0)
                $w=$this->w-$this->rMargin-$this->x;
            $wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
            $s=str_replace("\r",'',$txt);
            $nb=strlen($s);
            if($nb>0 and $s[$nb-1]=="\n")
                $nb--;
            $sep=-1;
            $i=0;
            $j=0;
            $l=0;
            $nl=1;
            while($i<$nb) {
                $c=$s[$i];
                if($c=="\n") {
                    $i++;
                    $sep=-1;
                    $j=$i;
                    $l=0;
                    $nl++;
                    continue;
                }
                if($c==' ')
                    $sep=$i;
                $l+=$cw[$c];
                if($l>$wmax) {
                    if($sep==-1) {
                        if($i==$j)
                            $i++;
                    } else
                        $i=$sep+1;
                    $sep=-1;
                    $j=$i;
                    $l=0;
                    $nl++;
                } else
                    $i++;
            }
            return $nl;
        }
    } //end of class
 
    //contoh penggunaan
    $data = array(
                array(
                    'nip'	=> '0111500382',
                    'nama' => 'ACHMAD SOLICHIN',
                    'alamat' => 'Jalan Ciledug Raya No 99, Petukangan Utara, Jakarta Selatan 12260, DKI Jakarta',
                    'email' => 'achmatim@gmail.com',
                    'website' => 'http://achmatim.net'
                ),

                array(
                    'nip'	=> '0411500101',
                    'nama' => 'CHOTIMATUL MUSYAROFAH',
                    'alamat' => 'Komplek Japos RT 002/015 Kelurahan Peninggilan, Kec. Ciledug, Tangerang',
                    'email' => 'chotimatul.musyarofah@gmail.com',
                    'website' => 'http://contohprogram.info'
                ),
                
				array(
                    'nip'	=> '1111500200',
                    'nama' => 'MUHAMMAD LINTANG',
                    'alamat' => 'Jl. Raya Caplin, Kec. Ciledug, Tangerang, Banten',
                    'email' => 'achmatim@yahoo.com',
                    'website' => 'http://ebook.achmatim.net'
                )
    );
 
    //pilihan
    $options = array(
                   'filename' => '', //nama file penyimpanan, kosongkan jika output ke browser
                   'destinationfile' => '', //I=inline browser (default), F=local file, D=download
                   'paper_size'=>'F4',	//paper size: F4, A3, A4, A5, Letter, Legal
                   'orientation'=>'P' //orientation: P=portrait, L=landscape
    );
 
    $tabel = new FPDF_AutoWrapTable($data, $options);
    $tabel->printPDF();
*/ // EOF() AutoWarp

}