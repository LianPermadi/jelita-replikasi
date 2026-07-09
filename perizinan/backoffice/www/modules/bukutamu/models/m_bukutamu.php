<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Description of Pendaftaran class
 *
 * @author Jonas
 * Created : 22 Maret 2021
 *
 */

class M_bukutamu extends Model {

	public function get_data($tgla = NULL, $tglb = NULL) {
            // $sql = "SELECT * 
            //     FROM euis_bukutamu order by waktu desc";

            //     $result = $this->db->query($sql)->result();

                  $sql = "SELECT * 
                    FROM euis_bukutamu 
                    WHERE DATE(waktu) BETWEEN ? AND ?
                    
                    ORDER BY  waktu  DESC";
                    //var_dump($sql);die();
                    $result = $this->db->query($sql, array($tgla, $tglb))->result();
        
        return $result;
    }


    public function get_data_old($tgla = NULL, $tglb = NULL, $iduser = NULL, $admin = NULL) {
            $sql = "SELECT * 
                FROM euis_bukutamu order by waktu desc";

                $result = $this->db->query($sql)->result();
        
        return $result;
    }

    public function get_datakegiatan($id) {
        $kegiatan = $this->db->select('*')
                     ->from('euis_calendar')
                     ->where('id', $id)
                     ->get()->row();

        return $kegiatan;
    }
     public function get_sektor2() {
        $sql = "SELECT * from trsektor";
        $result = $this->db->query($sql)->result();

        return $result;
    }
    //   public function get_namampp() {
    //     $sql = "SELECT * from euis_bukutamu_mpp";
    //     $result = $this->db->query($sql)->result();

    //     return $result;
    // }
    public function get_namampp() {
        $sql = "SELECT * FROM `trkabupaten` WHERE `kd_prov` = 12";
        $result = $this->db->query($sql)->result();

        return $result;
    }
     public function getperingkatnegara()
    {
        $sql = "SELECT * ,sum(jum_rp) as Total from euis_rinv_negara group by id_negara ORDER BY Total DESC "; //LIMIT 10
        // var_dump($sql);die();
        $result = $this->db->query($sql);
        return $result->result();
    }
     public function getsektor($tgla = NULL, $tglb = NULL)
    {
        $sql = "SELECT * ,count(bidang) as Total from euis_bukutamu  WHERE DATE(waktu) BETWEEN '$tgla' AND '$tglb' group by bidang ORDER BY Total DESC "; //LIMIT 10
        $result = $this->db->query($sql);
        return $result->result();
    }
    public function gettujuandatang($tgla = NULL, $tglb = NULL)
    {
        $sql = "SELECT * ,count(tujuan) as Totaltujuan from euis_bukutamu  WHERE DATE(waktu) BETWEEN '$tgla' AND '$tglb' group by tujuan ORDER BY Totaltujuan DESC "; //LIMIT 10
        $result = $this->db->query($sql);
        return $result->result();
    }
    public function getlokasimpp($tgla = NULL, $tglb = NULL)
    {
        $sql = "SELECT * ,count(lokasi) as lok from euis_bukutamu WHERE DATE(waktu) BETWEEN '$tgla' AND '$tglb' group by lokasi ORDER BY lok DESC "; //LIMIT 10
        $result = $this->db->query($sql);
        return $result->result();
    }
    public function getnamalokasimpp()
    {
        $sql = "SELECT * ,count(lokasi) as lok from euis_bukutamu group by lokasi ORDER BY lok DESC "; //LIMIT 10
        $result = $this->db->query($sql);
        return $result->result();
    }
    public function getpetugas($tgla = NULL, $tglb = NULL)
    {
        $sql = "SELECT * ,count(nama_petugas) as petugas from euis_bukutamu WHERE DATE(waktu) BETWEEN '$tgla' AND '$tglb' group by nama_petugas ORDER BY petugas DESC "; //LIMIT 10
        $result = $this->db->query($sql);
        // var_dump($sql);die();
        return $result->result();
    }
     public function getmpp(){
        $sql = "SELECT  
                    count(IF(lokasi='JIH DPMPTSP Jabar', lokasi, NULL)) AS jdpmptsp,
                    count(IF(lokasi='Lobby DPMPTSP Jabar', lokasi, NULL)) AS ldpmptsp,
                    count(IF(lokasi='MPP Kota Bandung', lokasi, NULL)) AS mkotabandung,
                    count(IF(lokasi='GPP Kota Bandung', lokasi, NULL)) AS gkotabandung,
                    count(IF(lokasi='MPP Kab. Bandung', lokasi, NULL)) AS kabbandung,
                    count(IF(lokasi='GPP Kota Cirebon', lokasi, NULL)) AS kotacirebon,
                    count(IF(lokasi='GPP Kab. Cirebon', lokasi, NULL)) AS kabcirebon,
                    count(IF(lokasi='MPP Kota Tasikmalaya', lokasi, NULL)) AS kotatasik,
                    count(IF(lokasi='GPP Kab. Garut', lokasi, NULL)) AS kabgarut,
                    count(IF(lokasi='MPP Kab. Purwakarta', lokasi, NULL)) AS kabpurwakarta,
                    count(IF(lokasi='MPP Kab. Karawang', lokasi, NULL)) AS kabkarawang,
                    count(IF(lokasi='MPP Kota Bekasi', lokasi, NULL)) AS kotabekasi,
                    count(IF(lokasi='MPP Kab. Bekasi', lokasi, NULL)) AS kabbekasi,
                    count(IF(lokasi='MPP Kota Bogor', lokasi, NULL)) AS kotabogor,
                    count(IF(lokasi='GPP Plasa Cibubur', lokasi, NULL)) AS cibubur,
                    count(IF(lokasi='MPP Kab. Sumedang', lokasi, NULL)) AS sumedang
                  


                    FROM euis_bukutamu 
    ";
    // var_dump($sql);die();
    $result = $this->db->query($sql);
        return $result->row();
    }
       public function getSum2019TW1(){
    $sql = "SELECT  SUM(IF(tw='1', proyek, 0)) AS proyek,
                    SUM(IF(tw='1', total_invest, 0)) AS total_invest,
                    SUM(IF(tw='1', tenaga_kerja, 0)) AS naker,
                    SUM(IF(tw='2', proyek, 0)) AS proyek2,
                    SUM(IF(tw='2', total_invest, 0)) AS total_invest2,
                    SUM(IF(tw='2', tenaga_kerja, 0)) AS naker2,
                    SUM(IF(tw='3', proyek, 0)) AS proyek3,
                    SUM(IF(tw='3', total_invest, 0)) AS total_invest3,
                    SUM(IF(tw='3', tenaga_kerja, 0)) AS naker3,
                    SUM(IF(tw='4', proyek, 0)) AS proyek4,
                    SUM(IF(tw='4', total_invest, 0)) AS total_invest4,
                    SUM(IF(tw='4', tenaga_kerja, 0)) AS naker4 FROM euis_investratio where tahun = '2019'
    ";
    $result = $this->db->query($sql);
        return $result->row();
    }
     public function getSum2021PMA(){
     $sql = "SELECT  SUM(IF(tw='1', proyek, 0)) AS proyek,
                    SUM(IF(tw='1', total_invest, 0)) AS total_invest,
                    SUM(IF(tw='1', tenaga_kerja, 0)) AS naker,
                    SUM(IF(tw='2', proyek, 0)) AS proyek2,
                    SUM(IF(tw='2', total_invest, 0)) AS total_invest2,
                    SUM(IF(tw='2', tenaga_kerja, 0)) AS naker2,
                    SUM(IF(tw='3', proyek, 0)) AS proyek3,
                    SUM(IF(tw='3', total_invest, 0)) AS total_invest3,
                    SUM(IF(tw='3', tenaga_kerja, 0)) AS naker3,
                    SUM(IF(tw='4', proyek, 0)) AS proyek4,
                    SUM(IF(tw='4', total_invest, 0)) AS total_invest4,
                    SUM(IF(tw='4', tenaga_kerja, 0)) AS naker4 FROM euis_investratio where tahun = '2021'and jenis = 'pma'
    ";
    $result = $this->db->query($sql);
        return $result->row();
    }
    public function get_bukutamu($id) {
        $kegiatan = $this->db->select('*')
                     ->from('euis_bukutamu')
                     ->where('id', $id)
                     ->get()->row();
        //var_dump($kegiatan);die();
        return $kegiatan;
    }

     public function get_n_sektor($id) {
        $data = " - ";
        if($id==2){
            $data = 'ESDM';
        }
        else if($id==1){
            $data = 'PUPR';
        }
        else if($id==22){
            $data = 'KUKM';
        }
        else{
            $sektor = $this->db->select('n_sektor')
                         ->from('trsektor')
                         ->where('id', $id)
                         ->get()->row();

            if (!empty($sektor->n_sektor)) {
                $data = $sektor->n_sektor;
            }
        }
        return $data;
    }
    public function get_n_mpp($id) {
        $data = " - ";
       
            $mpp = $this->db->select('nama_mpp')
                         ->from('euis_bukutamu_mpp')
                         ->where('id', $id)
                         ->get()->row();

            if (!empty($mpp->nama_mpp)) {
                $data = $mpp->nama_mpp;
            }
        
        return $data;
    }
    public function get_n_user($id) {
        $data = " - BELUM DIINISIASI -";
        $pegawai = $this->db->select('oriname')
                     ->from('user')
                     ->where('id', $id)
                     ->get()->row();

        if (!empty($pegawai->oriname)) {
            $data = $pegawai->oriname;
        }
        
        return $data;
    }
     public function get_namabidang() {
         $sql = "select * from euis_cal_bidang";
        $result = $this->db->query($sql)->result();

        return $result;
    }
     public function update_data($id,  $nama,   $email,   $instansi,   $keperluan,    $esselon,   $lokasi,   $bidang,   $solusi,   $telepon, $nib, $jenis_izin, $nama_petugas, $Keterangan, $tujuan) {
        $timeline = $this->get_datakegiatan($id);

        // switch ($namabidang) {
        //         case '3': //DATIN
        //             $warna = "#0071c5";
        //             break;
        //         case '1': //SEKRETARIAT
        //             $warna = "#40E0D0";
        //             break;
        //         case '2': //BANGPROM
        //             $warna = "#008000";
        //             break;
        //         case '4': //PENGENDALIAN
        //             $warna = "#FFD700";
        //             break;
        //         case '5': //ESDA
        //             $warna = "#FF8C00";
        //             break;
        //         case '6': //INSOS
        //             $warna = "#FF0000";
        //             break;
        //         default:
        //             $warna = "";
        //             break;
        //         }
        $data = array(
                       // 'user_id'       => $id_user,
                       'nama'        => $nama,
                        'email'        => $email,
                        'instansi'        => $instansi,
                        'keperluan'        => $keperluan,
                        
                        'esselon'        => $esselon,
                        'lokasi'        => $lokasi,
                        'bidang'        => $bidang,
                        'solusi'        => $solusi,
                        'nib'        => $nib,
                        'jenis_izin'        => $jenis_izin,
                        'nama_petugas'        => $nama_petugas,
                        'Keterangan'        => $Keterangan,
                        'tujuan'        => $tujuan,
                        'telepon'        => $telepon

                      
                     );
        $this->db->where('id', $id);
        $save = $this->db->update('euis_bukutamu', $data);

        if ($save) {
            $return = true;
        } else {
            $return = false;
        }

        return $return;
    }
    public function get_tujuan($nomor) {
        switch ($nomor) {
            
            case '1':
                $data = "Informasi";
                break;
            case '2':
                $data = "OSS";
                break;
            case '3':
                $data = "LKPM";
                break;
            case '4':
                $data = "Pengaduan";
                break;
           case '5':
                $data = "HAKI";
                break;
            case '6':
                $data = "SNI";
                break;
            case '7':
                $data = "BPOM";
                break;
            case '8':
                $data = "HALAL";
                break;

            default:
                $data = " - BELUM DIINISIASI - ";
                break;
        }
        return $data;
    }


     public function save_data($id, $id_user, $title, $description, $bidang,$namabidang, $start_date, $end_date, $startdate) {
          switch ($namabidang) {
                case '3': //DATIN
                    $warna = "#0071c5";
                    break;
                case '1': //SEKRETARIAT
                    $warna = "#40E0D0";
                    break;
                case '2': //BANGPROM
                    $warna = "#008000";
                    break;
                case '4': //PENGENDALIAN
                    $warna = "#FFD700";
                    break;
                case '5': //ESDA
                    $warna = "#FF8C00";
                    break;
                case '6': //INSOS
                    $warna = "#FF0000";
                    break;
                default:
                    $warna = "";
                    break;
                }
        $data = array(
                       // 'user_id'       => $id_user,
                        'title'          => $title,
                        'description'    => $description,
                        'namabidang'        => $namabidang,
                        'start_date'  => $start_date,
                        //'startdate'          => $startdate,
                       // 'enddate'          => $enddate,
                         'create_by'          => $id_user,
                        'color' => $warna,
                        'end_date'   => $end_date,
                        'create_at'     => date('Y-m-d H:i:s')
                      
                     );
        $save = $this->db->insert('euis_calendar', $data);

        if ($save) {
            $return = $this->db->insert_id();
        } else {
            $return = 0;
        }

        return $return;
    }

    public function delete_bukutamu($id) {
     
            $del = $this->db->delete('euis_bukutamu', array('id' => $id));
            if ($del) {
                return true;
            } else {
                return false;
            }
        
    }
}
