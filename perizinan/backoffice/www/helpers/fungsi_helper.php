<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('tgl_indo'))
{
	function tgl_indo($tgl)
	{
		$ubah = gmdate($tgl, time()+60*60*8);
		$pecah = explode("-",$ubah);
		$tanggal = $pecah[2];
		$bulan = bulan($pecah[1]);
		$tahun = $pecah[0];
		return $tanggal.' '.$bulan.' '.$tahun;
	}
}

if ( ! function_exists('bulan'))
{
	function bulan($bln)
	{
		switch ($bln)
		{
			case 1:
				return "Januari";
				break;
			case 2:
				return "Februari";
				break;
			case 3:
				return "Maret";
				break;
			case 4:
				return "April";
				break;
			case 5:
				return "Mei";
				break;
			case 6:
				return "Juni";
				break;
			case 7:
				return "Juli";
				break;
			case 8:
				return "Agustus";
				break;
			case 9:
				return "September";
				break;
			case 10:
				return "Oktober";
				break;
			case 11:
				return "November";
				break;
			case 12:
				return "Desember";
				break;
		}
	}
}

if ( ! function_exists('nama_hari'))
{
	function nama_hari($tanggal)
	{
		$ubah = gmdate($tanggal, time()+60*60*8);
		$pecah = explode("-",$ubah);
		$tgl = $pecah[2];
		$bln = $pecah[1];
		$thn = $pecah[0];

		$nama = date("l", mktime(0,0,0,$bln,$tgl,$thn));
		$nama_hari = "";
		if($nama=="Sunday") {$nama_hari="Minggu";}
		else if($nama=="Monday") {$nama_hari="Senin";}
		else if($nama=="Tuesday") {$nama_hari="Selasa";}
		else if($nama=="Wednesday") {$nama_hari="Rabu";}
		else if($nama=="Thursday") {$nama_hari="Kamis";}
		else if($nama=="Friday") {$nama_hari="Jumat";}
		else if($nama=="Saturday") {$nama_hari="Sabtu";}
		return $nama_hari;
	}
}

if ( ! function_exists('hitung_mundur'))
{
	function hitung_mundur($wkt)
	{
		$waktu=array(	365*24*60*60	=> "tahun",
						30*24*60*60		=> "bulan",
						7*24*60*60		=> "minggu",
						24*60*60		=> "hari",
						60*60			=> "jam",
						60				=> "menit",
						1				=> "detik");

		$hitung = strtotime(gmdate ("Y-m-d H:i:s", time () +60 * 60 * 8))-$wkt;
		$hasil = array();
		if($hitung<5)
		{
			$hasil = 'kurang dari 5 detik yang lalu';
		}
		else
		{
			$stop = 0;
			foreach($waktu as $periode => $satuan)
			{
				if($stop>=6 || ($stop>0 && $periode<60)) break;
				$bagi = floor($hitung/$periode);
				if($bagi > 0)
				{
					$hasil[] = $bagi.' '.$satuan;
					$hitung -= $bagi*$periode;
					$stop++;
				}
				else if($stop>0) $stop++;
			}
			$hasil=implode(' ',$hasil).' yang lalu';
		}
		return $hasil;
	}
}

function timeAgo($timestamp){
	    $time = time() - $timestamp;

	    if ($time < 60)
	    return ( $time > 1 ) ? $time . ' detik yang lalu' : 'satu detik';
	    elseif ($time < 3600) {
	    $tmp = floor($time / 60);
	    return ($tmp > 1) ? $tmp . ' menit yang lalu' : ' satu menit yang lalu';
	    }
	    elseif ($time < 86400) {
	    $tmp = floor($time / 3600);
	    return ($tmp > 1) ? $tmp . ' jam yang lalu' : ' satu jam yang lalu';
	    }
	    elseif ($time < 2592000) {
	    $tmp = floor($time / 86400);
	    return ($tmp > 1) ? $tmp . ' hari lalu' : ' satu hari lalu';
	    }
	    elseif ($time < 946080000) {
	    $tmp = floor($time / 2592000);
	    return ($tmp > 1) ? $tmp . ' bulan lalu' : ' satu bulan lalu';
	    }
	    else {
	    $tmp = floor($time / 946080000);
	    return ($tmp > 1) ? $tmp . ' years' : ' a year';
	    }
    }

if ( ! function_exists('buang'))
{
	function buang($buang)
{
	$buang=str_replace("-","",$buang);
	$buang=str_replace("/","",$buang);
	$buang=str_replace("?","",$buang);
	$buang=str_replace(":","",$buang);
	$buang=str_replace(".","",$buang);
	$buang=str_replace("@","",$buang);
	$buang=str_replace("&","",$buang);
	$buang=str_replace("#","",$buang);
	$buang=str_replace("(","",$buang);
	$buang=str_replace(")","",$buang);
	$buang=str_replace("*","",$buang);
	$buang=str_replace("!","",$buang);
	$buang=str_replace("~","",$buang);
	$buang=str_replace("+","",$buang);
	$buang=str_replace(",","",$buang);
	$buang=str_replace("`","",$buang);
	$buang=str_replace(";","",$buang);
    $buang=str_replace(" ","_",$buang);
	//$buang=str_replace(" ","",$buang);
	$buang=strtolower($buang);
	return $buang;
}
}

if(!  function_exists('get_extension'))
{
    function get_extension($str) {
         $i = strrpos($str,".");
         if (!$i) { return ""; }
         $l = strlen($str) - $i;
         $ext = substr($str,$i+1,$l);
         return $ext;
 }
}

if(! function_exists('selectData')){
    function selectData($nilai,$def)
    {
	    if($nilai==$def)
	    {
		    echo "selected=\"selected\"";
	    }
    }
}

if(! function_exists('chekData')){
    function chekData($nilai,$def)
    {
	    if($nilai==$def)
	    {
		    echo "checked=\"checked\"";
	    }
    }
}

if(! function_exists('cekaktif')){
    function cekaktif($nilai,$def)
    {
	    if($nilai==$def)
	    {
		    echo "active-menu";
	    }
    }
}

if(! function_exists('memberstatus')){
    function memberstatus($nilai)
    {
	    if($nilai=='0')
	    {
		    $status="Pending";
	    }elseif($nilai=='1'){
	        $status="Aktif";
	    }
        return $status;
    }
}

if(! function_exists('imgstatus')){
    function imgstatus($nilai)
    {
	    if($nilai=='0')
	    {
		    $status="Tidak Aktif";
	    }elseif($nilai=='1'){
	        $status="Aktif";
	    }
        return $status;
    }
}

if(! function_exists('artikelstatus')){
    function artikelstatus($nilai)
    {
	    if($nilai=='0')
	    {
		    $status="Draf";
	    }elseif($nilai=='1'){
	        $status="Published";
	    }
        return $status;
    }
}

if(! function_exists('testimonistatus')){
    function testimonistatus($nilai)
    {
	    if($nilai=='0')
	    {
		    $status="Pending";
	    }elseif($nilai=='1'){
	        $status="Published";
	    }
        return $status;
    }
}

if(! function_exists('rupiah')){
    function rupiah($nilai, $pecahan = 0) {
        return number_format($nilai, $pecahan, ',', '.');
    }
}

if(! function_exists('rupiah2')){
    function rupiah2($harga)
{
	$a=(string)$harga; //membuat $harga menjadi string
	$len=strlen($a); //menghitung panjang string $a

	if ( $len <=18 )
	{
		$ratril=$len-3-1;
		$ramil=$len-6-1;
		$rajut=$len-9-1; //untuk mengecek apakah ada nilai ratusan juta (9angka dari belakang)
		$juta=$len-12-1; //untuk mengecek apakah ada nilai jutaan (6angka belakang)
		$ribu=$len-15-1; //untuk mengecek apakah ada nilai ribuan (3angka belakang)

		$angka='';
		for ($i=0;$i<$len;$i++)
		{
			if ( $i == $ratril )
			{
				$angka=$angka.$a[$i].".";
			}
			else if ($i == $ramil )
			{
				$angka=$angka.$a[$i].".";
			}
			else if ( $i == $rajut )
			{
				$angka=$angka.$a[$i]."."; //meletakkan tanda titik setelah 3angka dari depan
			}
			else if ( $i == $juta )
			{
				$angka=$angka.$a[$i]."."; //meletakkan tanda titik setelah 6angka dari depan
			}
			else if ( $i == $ribu )
			{
				$angka=$angka.$a[$i]."."; //meletakkan tanda titik setelah 9angka dari depan
			}
			else
			{
				$angka=$angka.$a[$i];
			}
		}
	}

	echo $angka.",-";
	}
}

if(! function_exists('sBase15')){
  function sBase15($substr)
  {
  	$kecil=substr($substr,0,15);
  	$kecil=stripslashes($kecil);
  	$kecil=strip_tags($kecil);
  	return $kecil;

  }
}
if(! function_exists('sBase30')){
  function sBase30($substr)
  {
  	$kecil=substr($substr,0,30);
  	$kecil=stripslashes($kecil);
  	$kecil=strip_tags($kecil);
    $count=strlen($substr);
        if($count>30){
            $varnya=$kecil." ...";
        }else{
            $varnya=$kecil;
        }
  	return $varnya;

  }
}

if(! function_exists('sBase50')){
  function sBase50($substr)
  {
  	$kecil=substr($substr,0,50);
  	$kecil=stripslashes($kecil);
  	$kecil=strip_tags($kecil);
  	return $kecil ." ...";

  }
}

if(! function_exists('sBase100')){
  function sBase100($substr)
  {
  	$kecil=substr($substr,0,100);
  	$kecil=stripslashes($kecil);
  	$kecil=strip_tags($kecil);
  	return $kecil ." ...";

  }
}
if(! function_exists('sBase150')){
  function sBase150($substr)
  {
  	$kecil=substr($substr,0,150);
  	$kecil=stripslashes($kecil);
  	$kecil=strip_tags($kecil);
  	return $kecil ." ...";

  }
}

if(! function_exists('sBase200')){
  function sBase200($substr)
  {
  	$kecil=substr($substr,0,200);
  	$kecil=stripslashes($kecil);
  	$kecil=strip_tags($kecil);
  	return $kecil ." ...";

  }
}

if(! function_exists('sBase400')){
  function sBase400($substr)
  {
  	$kecil=substr($substr,0,400);
  	$kecil=stripslashes($kecil);
  	$kecil=strip_tags($kecil);
  	return $kecil ." ...";

  }
}

if(! function_exists('tgldikit')){
    function tgldikit($tgl)
    {
    	$inttime=date('Y-m-d H:i:s',$tgl);

    	$arr_bulan=array("","Jan","Feb","Mar","Apr","Mei","Jun","Jul","Agu","Sep","Okt","Nov","Des");
     	$tglBaru=explode(" ",$inttime);
     	$tglBaru1=$tglBaru[0];$tglBaru2=$tglBaru[1];
     	$tglBarua=explode("-",$tglBaru1);
     	$tgl=$tglBarua[2]; $bln=$tglBarua[1]; $thn=$tglBarua[0];
     	if(substr($bln,0,1)=="0") $bln=substr($bln,1,1);
     	$bln=substr($arr_bulan[$bln],0,10);
     	$ubahTanggal="$tgl $bln $thn";

	    return $ubahTanggal;
    }
}
if( ! function_exists('tgllengkap')){
function tgllengkap($tgl)
{
	$inttime=date('Y-m-d H:i:s',$tgl);

	$arr_bulan=array("","Jan","Feb","Mar","Apr","Mei","Jun","Jul","Agu","Sep","Okt","Nov","Des");
 	$tglBaru=explode(" ",$inttime);
 	$tglBaru1=$tglBaru[0];$tglBaru2=$tglBaru[1];
 	$tglBarua=explode("-",$tglBaru1);
 	$tgl=$tglBarua[2]; $bln=$tglBarua[1]; $thn=$tglBarua[0];
 	if(substr($bln,0,1)=="0") $bln=substr($bln,1,1);
 	$bln=substr($arr_bulan[$bln],0,10);
 	$ubahTanggal="$tgl $bln $thn | $tglBaru2 ";

	return $ubahTanggal;
}
}
if( ! function_exists('tglsemua')){
function tglsemua($tgl)
{
	$inttime=date('Y-m-d H:i:s',$tgl);

	$arr_bulan=array("","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
 	$tglBaru=explode(" ",$inttime);
 	$tglBaru1=$tglBaru[0];$tglBaru2=$tglBaru[1];
 	$tglBarua=explode("-",$tglBaru1);
 	$tgl=$tglBarua[2]; $bln=$tglBarua[1]; $thn=$tglBarua[0];
 	if(substr($bln,0,1)=="0") $bln=substr($bln,1,1);
 	$bln=substr($arr_bulan[$bln],0,10);
 	$ubahTanggal="$tgl $bln $thn | $tglBaru2 ";

	return $ubahTanggal;
}
}

if( ! function_exists('get_first_image_url')){
    function get_first_image_url($data, $default_url = null) {

    // Matched with `![alt text](IMAGE URL)` from Markdown file
    if(preg_match_all('/\!\[.*?\]\((.*?)\)/', $data, $matches)) {
        return $matches[1][0];
    }

    // Matched with...
    // 1. `<img src="IMAGE URL">`
    // 2. `<img foo="bar" src="IMAGE URL">`
    // 3. `<img src="IMAGE URL" foo="bar">`
    // 4. `<img src="IMAGE URL"/>`
    // 5. `<img foo="bar" src="IMAGE URL"/>`
    // 6. `<img src="IMAGE URL" foo="bar"/>`
    // 7. `<img src="IMAGE URL" />`
    // 8. `<img foo="bar" src="IMAGE URL" />`
    // 9. `<img src="IMAGE URL" foo="bar" />`
    // ... and the uppercased version of them, and the single-quoted version of them
    if(preg_match_all('/<img (.*?)?src=(\'|\")(.*?)(\'|\")(.*?)? ?\/?>/i', $data, $matches)) {
        return $matches[3][0];
    }

    return $default_url; // Default image URL if nothing matched
}
}


if( ! function_exists('recursive_list')){
    function recursive_list($data)
    {
        $str = "";
        if(empty($data)){
           $str .="";
        }else{
        foreach($data as $list)
          {
              $str .= "<li><a href=".$list['ilink'].">".$list['nama']."</a>";
              $subchild = recursive_list($list['child']);
              if($subchild != '')
                  $str .= "<ul>".$subchild."</ul>";
              $str .= "</li>";
          }

        $str .= "</ul>";
        }
        return $str;
    }
}


if( ! function_exists('recursive_count')){
    function recursive_count($data)
    {
        $str = "";
        if(empty($data)){
         echo"</a>";
        }else{
           echo"</a><ul>";
        }
        //$str = "</ul>";
        return $str;
    }
}

if(! function_exists('menuaktif')){
    function menuaktif($nilai="",$def="")
    {
	    if($nilai==$def)
	    {
		    echo "class=\"active\"";
	    }else{

		}
    }
}

if(! function_exists('smenuaktif')){
    function smenuaktif($nilai="",$def="")
    {
	    if($nilai==$def)
	    {
		    echo "current";
	    }else{

		}
    }
}

function gli($tabel, $field_kunci, $pad) {
	$CI 	=& get_instance();
	$nama	= $CI->db->query("SELECT max($field_kunci) AS last FROM $tabel")->row();
	$data	= (intval($nama->last)) + 1;
	$last	= str_pad($data, $pad, '0', STR_PAD_LEFT);
	return $last;
}
function gval($tabel, $field_kunci, $diambil, $where) {
	$CI =& get_instance();
	$nama	= $CI->db->query("SELECT $diambil FROM $tabel WHERE $field_kunci = '$where'")->row();
	$data	= empty($nama) ? "-" : $nama->$diambil;
	return $data;
}

function konversi_level($id) {
	if ($id == "1") {
		echo "Admin Super";
	} else {
		echo "Admin Pos";
	}
}

function getjenisnilai($id) {
	$CI =& get_instance();
	$nama	= $CI->db->query("SELECT nama FROM tr_jenis_nilai WHERE id = '$id'")->row();
	$data	= empty($nama) ? "-" : $nama->nama;
	return $data;
}

function getmapel($id) {
	$CI =& get_instance();
	$nama	= $CI->db->query("SELECT nama FROM tr_mapel WHERE id = '$id'")->row();
	$data	= empty($nama) ? "-" : $nama->nama;
	return $data;
}

function getkelas($id) {
	$CI =& get_instance();
	$nama	= $CI->db->query("SELECT nama FROM tr_kelas WHERE id = '$id'")->row();
	$data	= empty($nama) ? "-" : $nama->nama;
	return $data;
}

function getguru($id) {
	$CI =& get_instance();
	$nama	= $CI->db->query("SELECT nama FROM tr_guru WHERE id = '$id'")->row();
	$data	= empty($nama) ? "-" : $nama->nama;
	return $data;
}
function getsiswa($id) {
	$CI =& get_instance();
	$nama	= $CI->db->query("SELECT nama FROM tr_siswa WHERE id = '$id'")->row();
	$data	= empty($nama) ? "-" : $nama->nama;
	return $data;
}

/* fungsi non database */
function tgl_jam_sql ($tgl) {
	$pc_satu	= explode(" ", $tgl);
	if (count($pc_satu) < 2) {
		$tgl1		= $pc_satu[0];
		$jam1		= "";
	} else {
		$jam1		= $pc_satu[1];
		$tgl1		= $pc_satu[0];
	}

	$pc_dua		= explode("-", $tgl1);
	$tgl		= $pc_dua[2];
	$bln		= $pc_dua[1];
	$thn		= $pc_dua[0];


	if ($bln == "01") { $bln_txt = "Jan"; }
	else if ($bln == "02") { $bln_txt = "Feb"; }
	else if ($bln == "03") { $bln_txt = "Mar"; }
	else if ($bln == "04") { $bln_txt = "Apr"; }
	else if ($bln == "05") { $bln_txt = "Mei"; }
	else if ($bln == "06") { $bln_txt = "Jun"; }
	else if ($bln == "07") { $bln_txt = "Jul"; }
	else if ($bln == "08") { $bln_txt = "Ags"; }
	else if ($bln == "09") { $bln_txt = "Sep"; }
	else if ($bln == "10") { $bln_txt = "Okt"; }
	else if ($bln == "11") { $bln_txt = "Nov"; }
	else if ($bln == "12") { $bln_txt = "Des"; }
	else { $bln_txt = ""; }

	return $tgl." ".$bln_txt." ".$thn."  ".$jam1;
}

/* penyederhanaan fungsi */
function _page($total_row, $per_page, $uri_segment, $url) {
	$CI 	=& get_instance();
	$CI->load->library('pagination');
	$config['base_url'] 	= $url;
	$config['total_rows'] 	= $total_row;
	$config['uri_segment'] 	= $uri_segment;
	$config['per_page'] 	= $per_page;
	$config['num_tag_open'] = '<li>';
	$config['num_tag_close']= '</li>';
	$config['prev_link'] 	= '&lt;';
	$config['prev_tag_open']='<li>';
	$config['prev_tag_close']='</li>';
	$config['next_link'] 	= '&gt;';
	$config['next_tag_open']='<li>';
	$config['next_tag_close']='</li>';
	$config['cur_tag_open']='<li class="active disabled"><a href="#"  style="background: #e3e3e3">';
	$config['cur_tag_close']='</a></li>';
	$config['first_tag_open']='<li>';
	$config['first_tag_close']='</li>';
	$config['last_tag_open']='<li>';
	$config['last_tag_close']='</li>';

	$CI->pagination->initialize($config);
	return $CI->pagination->create_links();
}

function _print_pdf($file, $data) {
	require_once('h2p/html2fpdf.php');          // agar dapat menggunakan fungsi-fungsi html2pdf
	ob_start();                            		// memulai buffer
	error_reporting(1);                     	// turn off warning for deprecated functions
	$pdf= new HTML2FPDF();                  	// membuat objek HTML2PDF
	$pdf->DisplayPreferences('Fullscreen');

	$html = $data;               		// mengambil data dengan format html, dan disimpan di variabel
	ob_end_clean();                         	// mengakhiri buffer dan tidak menampilkan data dalam format html
	$pdf->addPage();                        	// menambah halaman di file pdf
	$pdf->WriteHTML($html);                 	// menuliskan data dengan format html ke file pdf
	return $pdf->Output($file,'D');
}

function slug($str){
	$str = strtolower(trim($str));
	$str = preg_replace('/[^a-z0-9-]/', '-', $str);
	$str = preg_replace('/-+/', "-", $str);
	return $str;
}

function slug2($text)
{
    // replace non letter or digits by -
    $text = preg_replace('~[^\\pL\d]+~u', '-', $text);

    // trim
    $text = trim($text, '-');

    // transliterate
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

    // lowercase
    $text = strtolower($text);

    // remove unwanted characters
    $text = preg_replace('~[^-\w]+~', '', $text);

    if (empty($text))
    {
        return 'n-a';
    }

    return $text;
}