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

class M_perdin extends Model {

	public function get_data($tgla = NULL, $tglb = NULL, $admin=null, $iduser = NULL) {
            // $sql = "SELECT * 
            //     FROM euis_bukutamu order by waktu desc";

            //     $result = $this->db->query($sql)->result();
        if ($admin == 1 OR $iduser == 197 OR $iduser == 218 OR $iduser == 550 OR $iduser == 543) {
            $sql = "SELECT * 
                    FROM keu_perdin 
                    WHERE DATE(tanggal_berangkat) BETWEEN ? AND ?
                    OR no_grup_perdin IS NOT NULL
                    GROUP BY file_srt, no_grup_perdin
                    ORDER BY tanggal_berangkat DESC";
            $result = $this->db->query($sql, array($tgla, $tglb))->result();
        } else {
            $sql = "SELECT * 
                    FROM keu_perdin 
                    WHERE (DATE(tanggal_berangkat) BETWEEN ? AND ? 
                    AND (user_id = ? OR user_id = 443))
                    OR no_grup_perdin IS NOT NULL
                    GROUP BY file_srt, no_grup_perdin
                    ORDER BY tanggal_berangkat DESC";
            // var_dump($sql);die();
            $result = $this->db->query($sql, array($tgla, $tglb, $iduser))->result();
        }
        
        
                // var_dump($tglb);die();
        return $result;
    }
    public function get_rekap_sp_by_pegawai($tgla = NULL, $tglb = NULL) {
        // Pastikan parameter tanggal tidak kosong
        if (!$tgla || !$tglb) {
            return []; // Kembalikan array kosong jika parameter tidak valid
        }
    
        // Query untuk rekapitulasi SP berdasarkan id_pegawai
        $sql = "
                SELECT 
                    *,
                    id_pegawai, 
                    COUNT(no__sppd) AS total_sp, 
                    COUNT(DISTINCT no_grup_perdin) AS total_grup_perdin,
                    MIN(DATE(tanggal_berangkat)) AS tanggal_berangkat_awal,
                    MAX(DATE(tanggal_berangkat)) AS tanggal_berangkat_akhir
                FROM 
                    keu_perdin
                WHERE 
                    DATE(tanggal_berangkat) BETWEEN ? AND ?
                    AND no_grup_perdin IS NOT NULL
                GROUP BY 
                    id_pegawai,no__sppd
                ORDER BY 
                    total_sp DESC
            ";
    
    
        // Eksekusi query dengan parameter tanggal
        $result = $this->db->query($sql, array($tgla, $tglb))->result();
    
        return $result;
    }
    public function cekDataMingguSebelumSesudah($tanggal, $id_pegawai)
    {
        // Pastikan $tanggal tidak kosong dan valid
        if (empty($tanggal) || empty($id_pegawai)) {
            return []; // Kembalikan array kosong jika parameter tidak valid
        }
    
        $mingguSebelum = date('Y-m-d', strtotime($tanggal . ' -7 days'));
        $mingguSesudah = date('Y-m-d', strtotime($tanggal . ' +7 days'));
    
        return $this->db->where('tanggal_berangkat >=', $mingguSebelum)
                        ->where('tanggal_berangkat <=', $mingguSesudah)
                        ->where('id_pegawai', $id_pegawai) // Filter berdasarkan ID pegawai
                        ->get('keu_perdin')
                        ->result();
    }
    
    
    public function check_data_pegawai($ids, $tanggal_berangkat) {
        // Use implode() to safely convert the array of IDs into a comma-separated string
        $id_list = implode(',', $ids);
        
        // Query to retrieve employee data based on IDs and departure date
        $sql = "SELECT * 
                FROM keu_perdin 
                WHERE id_pegawai = '$id_list' 
                AND tanggal_berangkat = '$tanggal_berangkat'
                ORDER BY tanggal_berangkat DESC";
        // var_dump($sql);die();
        
        // Execute the query with the parameter
        $result = $this->db->query($sql)->result();
        
        // Check if any results are returned
        if (count($result) > 0) {
            return ['exists' => true, 'conflicts' => array_map(function($item) {
                return $item->id_pegawai; // Assuming you have id_pegawai in your result
            }, $result)];
        } else {
            return ['exists' => false];
        }
    }
    
    
    
    
    public function get_data_surat_perintah($tgla = NULL, $tglb = NULL, $admin=null, $iduser = NULL) {
            // $sql = "SELECT * 
            //     FROM euis_bukutamu order by waktu desc";

            //     $result = $this->db->query($sql)->result();
            // var_dump($iduser);die();
        if ($admin == 1 OR $iduser == 182) {
            $sql = "SELECT *, MAX(tanggal_berangkat) as tanggal_berangkat_terakhir, COUNT(*) as jumlah_perdin
                    FROM keu_perdin
                    WHERE DATE(tanggal_berangkat) BETWEEN ? AND ?
                     GROUP BY no_grup_perdin, id_tim 
                    ORDER BY tanggal_berangkat_terakhir DESC";
            $result = $this->db->query($sql, array($tgla, $tglb))->result();
        } else {
            $sql = "SELECT *, MAX(tanggal_berangkat) as tanggal_berangkat_terakhir, COUNT(*) as jumlah_perdin
                    FROM keu_perdin
                    WHERE DATE(tanggal_berangkat) BETWEEN ? AND ?
                    AND (user_id = ? OR user_id = 443)
                     GROUP BY no_grup_perdin, id_tim 
                    ORDER BY tanggal_berangkat_terakhir DESC";
            $result = $this->db->query($sql, array($tgla, $tglb, $iduser))->result();
        }
        
                // var_dump($tglb);die();
        return $result;
    }

    public function get_data_pegawai_sudah_perdin($date_value_pertama, $date_value_akhir, $id_pegawai = NULL) {
        $sql = "SELECT 
                   id,
                    id_pegawai,
                     lama_p_d,  
                     no_grup_perdin,  
                     id_pegawai,  
                     no_grup_perdin,  
                     id_tim,  
                     tanggal_berangkat, 
                    SUM(lama_p_d) AS total_lama_p_d,  -- Menggunakan SUM untuk menjumlahkan lama_p_d  
                    MAX(tanggal_berangkat) AS tanggal_berangkat_terakhir, 
                    COUNT(*) AS jumlah_perdin
                FROM keu_perdin
                WHERE DATE(tanggal_berangkat) BETWEEN ? AND ?";
        
        // Jika $id_pegawai diberikan, tambahkan filter ke query
        if ($id_pegawai) {
            $sql .= " AND id_pegawai = ?";
            $params = [$date_value_pertama, $date_value_akhir, $id_pegawai];
        } else {
            $params = [$date_value_pertama, $date_value_akhir];
        }
    
        $sql .= " GROUP BY id_pegawai 
                  ORDER BY tanggal_berangkat_terakhir DESC";
    
        return $this->db->query($sql, $params)->result();
    }
    
    
    
    
    
    public function get_data_preview($tgla = NULL, $tglb = NULL, $admin=null, $iduser = NULL) {
            // $sql = "SELECT * 
            //     FROM euis_bukutamu order by waktu desc";

            //     $result = $this->db->query($sql)->result();
        // var_dump($iduser);die();
        if ($admin == 1 OR $iduser == 197 OR $iduser == 218 OR $iduser == 550 OR $iduser == 543) {
            $sql = "SELECT * 
                    FROM keu_perdin 
                    WHERE DATE(tanggal_berangkat) BETWEEN ? AND ?
                    OR no_grup_perdin IS NOT NULL
                    GROUP BY file_srt, no_grup_perdin
                    ORDER BY tanggal_berangkat DESC";
            // var_dump($sql);die();
            $result = $this->db->query($sql, array($tgla, $tglb))->result();
        } else {
            $sql = "SELECT * 
                    FROM keu_perdin 
                    WHERE (DATE(tanggal_berangkat) BETWEEN ? AND ? 
                    AND (user_id = ? OR user_id = 443))
                    OR no_grup_perdin IS NOT NULL
                    GROUP BY file_srt, no_grup_perdin
                    ORDER BY tanggal_berangkat DESC";
            // var_dump($sql);die();
            $result = $this->db->query($sql, array($tgla, $tglb, $iduser))->result();
        }
        
        
                // var_dump($result);die();
        return $result;
    }
    
    public function get_data_preview_preview($tgla = NULL, $tglb = NULL, $admin=null, $iduser = NULL) {
        // $sql = "SELECT * 
        //     FROM euis_bukutamu order by waktu desc";

        //     $result = $this->db->query($sql)->result();
        // var_dump($iduser);die();
    if ($admin == 1 OR $iduser == 197 OR $iduser == 218 OR $iduser == 550 OR $iduser == 543) {
        $sql = "SELECT * 
                FROM keu_perdin 
                WHERE DATE(tanggal_berangkat) BETWEEN ? AND ?
                OR no_grup_perdin IS NOT NULL
                GROUP BY file_srt, no_grup_perdin
                ORDER BY tanggal_berangkat DESC";
        // var_dump($sql);die();
        $result = $this->db->query($sql, array($tgla, $tglb))->result();
    } else {
        $sql = "SELECT * 
                FROM keu_perdin 
                WHERE (DATE(tanggal_berangkat) BETWEEN ? AND ? 
                AND (user_id = ? OR user_id = 443))
                GROUP BY file_srt, no_grup_perdin

                OR no_grup_perdin IS NOT NULL
              
                ORDER BY tanggal_berangkat DESC";
        // var_dump($sql);die();
        $result = $this->db->query($sql, array($tgla, $tglb, $iduser))->result();
    }
    
    
            // var_dump($tglb);die();
    return $result;
}
    public function get_data_rekap($tgla = NULL, $tglb = NULL, $admin=null, $iduser = NULL) {
            // $sql = "SELECT * 
            //     FROM euis_bukutamu order by waktu desc";

            //     $result = $this->db->query($sql)->result();
        // var_dump($iduser);die();
                //  if ($admin == 1 OR $iduser ==197 OR $iduser ==218 OR $iduser ==550 OR $iduser== 543) {
                //     $sql = "SELECT * ,count(nomor) as nomor_surat
                //     FROM surat_perintah 
                //     WHERE DATE(tanggal) BETWEEN ? AND ?
                    
                //     ORDER BY  tanggal  DESC";
                //     // var_dump($sql);die();
                //     $result = $this->db->query($sql, array($tgla, $tglb))->result();
                // }
                // else {
                //     $sql = "SELECT * ,count(nomor) as nomor_surat
                //     FROM surat_perintah 
                //     WHERE DATE(tanggal) BETWEEN ? AND ?
                //     AND user_id = ?
                //     ORDER BY  tanggal  DESC";
                //     // var_dump($sql);die();
                //     $result = $this->db->query($sql, array($tgla, $tglb, $iduser))->result();
                // }
                $sql = "SELECT * ,count(nomor) as nomor_surat
                FROM surat_perintah 
                WHERE DATE(tanggal) BETWEEN ? AND ?
                
                ORDER BY  tanggal  DESC";
                // var_dump($sql);die();
                $result = $this->db->query($sql, array($tgla, $tglb))->result();
        return $result;
    }

    public function get_data_rekap_detail($nomor_surat) {
            // $sql = "SELECT * 
            //     FROM euis_bukutamu order by waktu desc";

            //     $result = $this->db->query($sql)->result();
                    $sql = "SELECT * 
                    FROM surat_perintah 
                    WHERE nomor LIKE '$nomor_surat'
                    
                    ORDER BY  tanggal  DESC";
                    // var_dump($sql);die();
                    $result = $this->db->query($sql)->result();
                
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
      public function get_namampp() {
        $sql = "SELECT * from euis_bukutamu_mpp";
        $result = $this->db->query($sql)->result();

        return $result;
    }
      public function get_data_rekap_id($id) {
        $sql = "SELECT * from surat_perintah WHERE id LIKE '$id'";
        $result = $this->db->query($sql)->result();

        return $result;
    }
     public function getperingkatnegara()
    {
        $sql = "SELECT * ,sum(jum_rp) as Total from euis_rinv_country group by id_negara ORDER BY Total DESC "; //LIMIT 10
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
   
    public function get_perdin($id, $id_tim) {
        // var_dump($id_tim);die();

        $kegiatan = $this->db->select('*')
                             ->from('keu_perdin')
                             ->where('no_grup_perdin', $id)
                             ->where('id_tim', $id_tim)

                             ->get();
        
        if (!$kegiatan) {
            // Log the query error or print the last query executed
            echo $this->db->last_query();
            die('Query failed');
        }
    
        return $kegiatan->result();
    }
    public function get_perdin_ubah($id) {
        // var_dump($id_tim); die();
    
        $kegiatan = $this->db->select('*')
                             ->from('keu_perdin')
                             ->where('id', $id)
                             ->get();
        
        if (!$kegiatan) {
            // Log the query error or print the last query executed
            echo $this->db->last_query();
            die('Query failed');
        }
        
        return $kegiatan->row(); // Use row() to fetch a single row
    }
    
    public function get_perdin_by_pegawai($id, $id_tim,$id_pegawai) {
        // var_dump($id_tim);die();

        $kegiatan = $this->db->select('*')
                             ->from('keu_perdin')
                             ->where('no_grup_perdin', $id)
                             ->where('id_tim', $id_tim)
                             ->where('id_pegawai', $id_pegawai)

                             ->get();
        
        if (!$kegiatan) {
            // Log the query error or print the last query executed
            echo $this->db->last_query();
            die('Query failed');
        }
    
        return $kegiatan->result();
    }
    public function get_tujuan_keberangkatan_perdin($no_grup_perdin, $id_tim) {
        // Pastikan id_tim adalah integer
        $id_tim = intval($id_tim);
    
   
    
        $kegiatan = $this->db->select('*')
                             ->from('tujuan_keberangkatan_perdin')
                             ->where('keu_perdin_id', $no_grup_perdin)
                             ->where('id_tim', $id_tim)  // Gunakan $id_tim sebagai integer
                             ->get();
        
        if (!$kegiatan) {
            // Log the query error or print the last query executed
            echo $this->db->last_query();
            die('Query failed');
        }
    
        return $kegiatan->result();
    }
    
    public function get_kode_reg() {
        $kegiatan = $this->db->select('id,kode_sub_ring, uraian_sub_kegiatan')
                             ->from('anggaran_kodering_sub_kegiatan')
                             ->get();
        
        if (!$kegiatan) {
            // Log the query error or print the last query executed
            echo $this->db->last_query();
            die('Query failed');
        }
    
        return $kegiatan->result();
    }
    public function get_list_tim() {
        $kegiatan = $this->db->select('*')
                             ->from('ketua_tot')
                             ->where('thn_anggaran', 2025)  // Menambahkan filter thn_anggaran = 2025
                             ->get();
        
        if (!$kegiatan) {
            // Log the query error or print the last query executed
            echo $this->db->last_query();
            die('Query failed');
        }
    
        return $kegiatan->result();
    }
    public function get_list_tim_by_id($id) {
        // Query database untuk mendapatkan data berdasarkan 'thn_anggaran' dan 'id'
        $kegiatan = $this->db->select('*')
                             ->from('ketua_tot')
                             ->where('thn_anggaran', 2025)  // Filter tahun anggaran 2025
                             ->where('id', $id)  // Filter berdasarkan ID
                             ->get();
        
        // Cek apakah query menghasilkan hasil
        if ($kegiatan->num_rows() == 0) {
            // Jika tidak ada hasil, tampilkan query terakhir yang dijalankan
            echo $this->db->last_query();
            die('Query failed, no data found');
        }
        
        // Mengembalikan hasil query sebagai array
        return $kegiatan->result();
    }
    
    
    public function get_perdin_sp($id) {
        $kegiatan = $this->db->select('*')
                             ->from('keu_perdin')
                             ->where('id', $id)
                             ->get();
    
        if (!$kegiatan) {
            // Log the query error atau cetak query terakhir yang dijalankan
            echo $this->db->last_query();
            die('Query failed');
        }
    
        // Mengambil satu data saja
        return $kegiatan->row();
    }

    public function get_perdin_join_tim_tot($id, $id_tim) {
        // var_dump($id_tim);die();

        $kegiatan = $this->db->select('keu_perdin.*, ketua_tot.nama_tim') // Pilih semua kolom dari keu_perdin dan nama_tim dari ketua_tot
                             ->from('keu_perdin')
                             ->join('ketua_tot', 'keu_perdin.id_tim = ketua_tot.id', 'left') // Menambahkan JOIN dengan tabel ketua_tim
                             ->where('no_grup_perdin', $id)
                             ->where('id_tim', $id_tim)
                             ->get();
        
        if (!$kegiatan) {
            // Log the query error or print the last query executed
            echo $this->db->last_query();
            die('Query failed');
        }
    
        return $kegiatan->result();
    }
    
    public function get_perdin_file_sp($id,$id_pegawai) {
        $kegiatan = $this->db->select('*')
                             ->from('keu_perdin')
                             ->where('no_grup_perdin', $id)
                             ->where('id_pegawai', $id_pegawai)
                             ->get();
    
        if (!$kegiatan) {
            // Log the query error atau cetak query terakhir yang dijalankan
            echo $this->db->last_query();
            die('Query failed');
        }
    
        // Mengambil satu data saja
        return $kegiatan->row();
    }
    
    
    public function get_perdin_sppd($no__sppd)
    {
        // $sql = "SELECT * FROM keu_perdin WHERE no__sppd LIKE ".$no__sppd.""; //LIMIT 10
        // $result = $this->db->query($sql)->result();
        // // var_dump($sql);die();
        // return $result;
        $sql = "SELECT * FROM keu_perdin WHERE no__sppd LIKE '$no__sppd'";
        $result = $this->db->query($sql)->result();
        return $result;
    }

    public function get_no_sppd($id) {
        $kegiatan = $this->db->select('no__sppd')
                     ->from('keu_perdin')
                     ->where('id', $id)
                     ->get()->row();
        //var_dump($kegiatan);die();
            if (!empty($kegiatan->no__sppd)) {
                $kegiatan = $kegiatan->no__sppd;
            }
        return $kegiatan;
    }

    public function get_nomor_surat($id) {
        $kegiatan = $this->db->select('nomor')
                     ->from('surat_perintah')
                     ->where('id', $id)
                     ->get()->row();
        //var_dump($kegiatan);die();
            if (!empty($kegiatan->nomor)) {
                $kegiatan = $kegiatan->nomor;
            }
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

     public function get_n_pegawai($id) {
        $data = " - ";

        if ($data != "0") {
            $pegawai = $this->db->select('n_pegawai')
                         ->from('tmpegawai')
                         ->where('id', $id)
                         ->get()->row();

            if (!empty($pegawai->n_pegawai)) {
                $data = $pegawai->n_pegawai;
            }
        }
        
        return $data;
    }

    public function get_n_pegawai_perdin($id) {
        $data = " - ";
    
        if ($data != "0") {
            $pegawai = $this->db->select('n_pegawai, pangkat_gol, nip, golongan, telepon') // Tambahkan kolom baru
                                 ->from('tmpegawai')
                                 ->where('id', $id)
                                 ->get()
                                 ->row();
    
            if (!empty($pegawai)) {
                $data = [
                    'n_pegawai' => $pegawai->n_pegawai, // Kolom pertama
                    'pangkat_gol' => $pegawai->pangkat_gol,  // Kolom tambahan
                    'golongan' => $pegawai->golongan,  // Kolom tambahan
                    'telepon' => $pegawai->telepon  // Kolom tambahan

                ];
            }
        }
        
        return $data;
    }

     public function get_data_per_month_old($id, $bulan, $tgla, $tglb) {
       $kembalikan ='';
       $sql = "SELECT SUM(jumlah_uang) as jumlah_uang FROM keu_perdin 
                where MONTH(tanggal_berangkat) = $bulan  and  DATE(tanggal_berangkat) BETWEEN  $tgla  AND $tglb
                and id_pegawai = $id
                    ";
            
            foreach ($this->db->query($sql)->result() as $data2) {
                        $kembalikan =  $data2->jumlah_uang;
            }
            if($kembalikan != ''){
                return $kembalikan;
            }
            else{
                return '0';
            }     
    }
    public function get_data_per_month($id, $bulan, $tgla, $tglb) {
       $kembalikan ='';
       $sql = "SELECT SUM(uang_hari) as jumlah_uang FROM keu_perdin 
                where MONTH(tanggal_berangkat) = $bulan  and  DATE(tanggal_berangkat) BETWEEN  '$tgla'  AND '$tglb'
                and id_pegawai = $id AND YEAR(tanggal_berangkat) = year(curdate())";
        // $sql = "SELECT 
        //             SUM(uang_hari) AS jumlah_uang
        //         FROM 
        //             keu_perdin 
        //         WHERE 
        //             id_pegawai = '.$id.'
        //             AND DATE(tanggal_berangkat) BETWEEN '$tgla' AND '$tglb'
        //             AND MONTH(tanggal_berangkat) = $bulan
        //         GROUP BY 
        //             YEAR(tanggal_berangkat), 
        //             MONTH(tanggal_berangkat)";
        $sql = "SELECT MONTH(tanggal_berangkat) as bulan, year(tanggal_berangkat) as tahun, SUM(uang_hari) as jumlah_uang 
                FROM keu_perdin 
                WHERE id_pegawai = $id 
                AND MONTH(tanggal_berangkat) = $bulan 
                AND DATE(tanggal_berangkat) 
                BETWEEN '$tgla' AND '$tglb' 
                GROUP BY tahun, bulan";
            //  var_dump($sql);die();
            foreach ($this->db->query($sql)->result() as $data2) {
                        $kembalikan =  $data2->jumlah_uang;
            }
            // if($bulan  == 5){
            // var_dump($kembalikan);die();
            // }
            if($kembalikan != ''){
                return $kembalikan;
            }
            else{
                return '0';
            }     
    }
    public function get_total_uangperjalanan($id, $tgla, $tglb) {
       $kembalikan ='';
    //    $sql = "SELECT SUM(jumlah_uang) as jumlah_uang FROM keu_perdin 
    //             where id_pegawai = $id  and  DATE(tanggal_berangkat) BETWEEN  '$tgla'  AND '$tglb' AND YEAR(tanggal_berangkat) = year(curdate())
    //                 ";
        $sql = "SELECT MONTH(tanggal_berangkat) as bulan, year(tanggal_berangkat) as tahun, SUM(jumlah_uang) as jumlah_uang FROM keu_perdin WHERE id_pegawai = $id AND DATE(tanggal_berangkat) BETWEEN '$tgla' AND '$tglb'";
                    // 
            foreach ($this->db->query($sql)->result() as $data2) {
                        $kembalikan =  $data2->jumlah_uang;
            }
            if($kembalikan != ''){
                return $kembalikan;
            }
            else{
                return '0';
            }     
    }
    public function get_total_jumlahperjalanan($id, $tgla, $tglb) {
       $kembalikan ='';
    //    $sql = "SELECT SUM(uang_hari) as jumlah_uang FROM keu_perdin 
    //             where  id_pegawai = $id and  DATE(tanggal_berangkat) BETWEEN  '$tgla'  AND '$tglb' AND YEAR(tanggal_berangkat) = year(curdate())
    //                 ";
        $sql = "SELECT MONTH(tanggal_berangkat) as bulan, year(tanggal_berangkat) as tahun, SUM(uang_hari) as jumlah_uang 
        FROM keu_perdin 
        WHERE id_pegawai = $id 
        AND DATE(tanggal_berangkat) 
        BETWEEN '$tgla' 
        AND '$tglb'";
                    // 
            foreach ($this->db->query($sql)->result() as $data2) {
                        $kembalikan =  $data2->jumlah_uang;
            }
            if($kembalikan != ''){
                return $kembalikan;
            }
            else{
                return '0';
            }     
    }
    public function get_total_jumlahperjalanan_semua( $tgla, $tglb) {
        $kembalikan ='';
        $sql = "SELECT SUM(jumlah_uang) as jumlah_uang FROM keu_perdin where DATE(tanggal_berangkat) BETWEEN '$tgla' AND '$tglb' AND YEAR(tanggal_berangkat) = year(curdate())";
        $sql = "SELECT SUM(jumlah_uang) as jumlah_uang 
                FROM keu_perdin 
                where DATE(tanggal_berangkat) 
                BETWEEN '$tgla' AND '$tglb' ";
                    // 
            foreach ($this->db->query($sql)->result() as $data2) {
                        $kembalikan =  $data2->jumlah_uang;
            }
            if($kembalikan != ''){
                return $kembalikan;
            }
            else{
                return '0';
            }     
    }

    public function get_data_perbulan($bulan, $tgla, $tglb) {

        $kembalikan ='';
        // $sql = "SELECT SUM(uang_hari) as jumlah_uang FROM keu_perdin 
        //         WHERE MONTH(tanggal_berangkat) = $bulan  
        //         AND  DATE(tanggal_berangkat) 
        //         BETWEEN '$tgla'  AND '$tglb' 
        //         AND YEAR(tanggal_berangkat) = year(curdate())";

        $sql = "SELECT MONTH(tanggal_berangkat) as bulan, year(tanggal_berangkat) as tahun, SUM(uang_hari) as jumlah_uang 
                FROM keu_perdin 
                WHERE MONTH(tanggal_berangkat) = $bulan
                AND DATE(tanggal_berangkat) 
                BETWEEN '$tgla' 
                AND '$tglb'";

        foreach ($this->db->query($sql)->result() as $data2) {
            $kembalikan =  $data2->jumlah_uang;
        }
            if($kembalikan != ''){
                return $kembalikan;
            }
            else{
                return '0';
            }     
    }
      public function get_data_perbulan_jumlah($tgla, $tglb) {
       $kembalikan ='';
       $sql = "SELECT SUM(uang_hari) as jumlah_uang FROM keu_perdin 
               where DATE(tanggal_berangkat) BETWEEN  '$tgla'  AND '$tglb'
              AND YEAR(tanggal_berangkat) = year(curdate())
                    ";
                    // 
            foreach ($this->db->query($sql)->result() as $data2) {
                        $kembalikan =  $data2->jumlah_uang;
            }
            if($kembalikan != ''){
                return $kembalikan;
            }
            else{
                return '0';
            }     
    }
    

    public function get_n_nip($id) {
        $data = " - ";

        if ($data != "") {
            $pegawai = $this->db->select('nip')
                         ->from('tmpegawai')
                         ->where('id', $id)
                         ->get()->row();

            if (!empty($pegawai->nip)) {
                $data = $pegawai->nip;
            }
        }
        
        return $data;
    }

    public function get_n_pangkat($id) {
        $data = " - ";

        if ($data != "") {
            $pegawai = $this->db->select('pangkat_gol')
                         ->from('tmpegawai')
                         ->where('id', $id)
                         ->get()->row();

            if (!empty($pegawai->pangkat_gol)) {
                $data = $pegawai->pangkat_gol;
            }
        }
        
        return $data;
    }
    public function get_n_gol($id) {
        $data = " - ";

        if ($data != "") {
            $pegawai = $this->db->select('golongan')
                         ->from('tmpegawai')
                         ->where('id', $id)
                         ->get()->row();

            if (!empty($pegawai->golongan)) {
                $data = $pegawai->golongan;
            }
        }
        
        return $data;
    }

    public function get_kabupaten() {
        $sql = "SELECT * from trkabupaten";
        
        $result = $this->db->query($sql)->result();
        return $result;
    }
    public function get_kabupaten_name($id) {
        // Menambahkan klausa WHERE untuk memfilter berdasarkan id
        $sql = "SELECT n_kabupaten FROM trkabupaten WHERE id = ?";
        
        // Menjalankan query dengan parameter binding untuk menghindari SQL injection
        $result = $this->db->query($sql, array($id))->result();
        
        // Mengembalikan hasil query
        return $result;
    }
    
    public function get_pegawai() {
        $sql = "SELECT * from tmpegawai";
        
        $result = $this->db->query($sql)->result();
    // where kd_prov = '12' ";
        return $result;
    }


     function get_number($number){
    // var_dump($number);die();
    $result =  filter_var($number, FILTER_SANITIZE_NUMBER_INT);
    return $result;
  }

     public function get_n_kabupaten($id) {
        $data = " - ";

        if ($data != "") {
            $pegawai = $this->db->select('n_kabupaten')
                         ->from('trkabupaten')
                         ->where('id', $id)
                         ->get()->row();

            if (!empty($pegawai->n_kabupaten)) {
                $data = $pegawai->n_kabupaten;
            }
        }
        
        return $data;
    }
     public function get_n_nik($id) {
        $data = " - ";

        if ($data != "") {
            $pegawai = $this->db->select('nik')
                         ->from('tmpegawai')
                         ->where('id', $id)
                         ->get()->row();

            if (!empty($pegawai->nik)) {
                $data = $pegawai->nik;
            }
        }
        
        return $data;
    }
    public function get_n_jabatan($id) {
        $data = " - ";

        if ($data != "") {
            $pegawai = $this->db->select('n_jabatan')
                         ->from('tmpegawai')
                         ->where('id', $id)
                         ->get()->row();

            if (!empty($pegawai->n_jabatan)) {
                $data = $pegawai->n_jabatan;
            }
        }
        
        return $data;
    }

     public function get_namabidang() {
         $sql = "select * from euis_cal_bidang";
        $result = $this->db->query($sql)->result();

        return $result;
    }
     public function update_data($tgl_pembayaran, $user_id,  $lama_p_d,$id,$id_pegawai, $no_bku, $uraian, $tujuan, $skpd, $no__sppd, $tanggal_berangkat, $tgl_surat, $tanggal_kembali, $uang_hari, $harga_hari, $jumlah_uang, $representasi_hari, $representasi_harga, $jumlah_representasi, $uang_sakuhari, $uang_sakuharga, $uang_sku_p_j, $penginapan_malam, $penginapan_harga, $penginapan_jumlah, $tikettol_pulang, $tikettol_pergi, $tikettol_jumlah, $s_t_k_asal_hari, $s_t_k_asal_harga, $s_t_k_asal_jumlah, $s_t_k_tujuan_hari, $s_t_k_tujuan_harga, $s_t_k_tujuan_jumlah, $sewa_kendaraan_hari, $sewa_kendaraan_harga, $sewa_kendaraan_jumlah, $bbm_liter, $bbm_harga, $bbm_jumlah, $swabdi_kota_asal, $swabdi_kota_tujuan, $swab_jumlah, $jumlah_total, $itberangkat_maskapai, $itberangkat_no_tiket, $itberangkat_kodebooking, $itberangkat_no_penerbangan, $itberangkat_asal_daerah, $itberangkat_tujuan, $itberangkat_tanggal, $itberangkat_kelas, $itberangkat_harga_tiket, $itkembali_maskapai, $itkembali_nama, $itkembali_no_tiket, $itkembali_kode_booking, $itkembali_no_penerbangan, $itkembali_asal_daerah, $itkembali_tujuan, $itkembali_tanggal, $itkembali_kelas, $itkembali_harga_tiket, $nama_penginapan, $keterangan) {
        // $timeline = $this->get_datakegiatan($id);

        $data = array(
                       // 'user_id'       => $id_user,
                       'id' => $id,
                       'lama_p_d' => $lama_p_d,
                        'no_bku' => $no_bku,
                        'uraian' => $uraian,
                        'tujuan' => $tujuan,
                        'user_id' => $user_id,
                        'skpd' => $skpd,
                        'tgl_pembayaran' => $tgl_pembayaran,
                        'id_pegawai' => $id_pegawai,
                        'no__sppd' => $no__sppd,
                        'tanggal_berangkat' => $tanggal_berangkat,
                        'tgl_surat' => $tgl_surat,
                        'tanggal_kembali' => $tanggal_kembali,
                        'uang_hari' => $uang_hari,
                        'harga_hari' => $harga_hari,
                        'jumlah_uang' => $jumlah_uang,
                        'representasi_hari' => $representasi_hari,
                        'representasi_harga' => $representasi_harga,
                        'jumlah_representasi' => $jumlah_representasi,
                        'uang_sakuhari' => $uang_sakuhari,
                        'uang_sakuharga' => $uang_sakuharga,
                        'uang_sku_p_j' => $uang_sku_p_j,
                        'penginapan_malam' => $penginapan_malam,
                        'penginapan_harga' => $penginapan_harga,
                        'penginapan_jumlah' => $penginapan_jumlah,
                        'tikettol_pulang' => $tikettol_pulang,
                        'tikettol_pergi' => $tikettol_pergi,
                        'tikettol_jumlah' => $tikettol_jumlah,
                        's_t_k_asal_hari' => $s_t_k_asal_hari,
                        's_t_k_asal_harga' => $s_t_k_asal_harga,
                        's_t_k_asal_jumlah' => $s_t_k_asal_jumlah,
                        's_t_k_tujuan_hari' => $s_t_k_tujuan_hari,
                        's_t_k_tujuan_harga' => $s_t_k_tujuan_harga,
                        's_t_k_tujuan_jumlah' => $s_t_k_tujuan_jumlah,
                        'sewa_kendaraan_hari' => $sewa_kendaraan_hari,
                        'sewa_kendaraan_harga' => $sewa_kendaraan_harga,
                        'sewa_kendaraan_jumlah' => $sewa_kendaraan_jumlah,
                        'bbm_liter' => $bbm_liter,
                        'bbm_harga' => $bbm_harga,
                        'bbm_jumlah' => $bbm_jumlah,
                        'swabdi_kota_asal' => $swabdi_kota_asal,
                        'swabdi_kota_tujuan' => $swabdi_kota_tujuan,
                        'swab_jumlah' => $swab_jumlah,
                        'jumlah_total' => $jumlah_total,
                        'itberangkat_maskapai' => $itberangkat_maskapai,
                        'itberangkat_no_tiket' => $itberangkat_no_tiket,
                        'itberangkat_kodebooking' => $itberangkat_kodebooking,
                        'itberangkat_no_penerbangan' => $itberangkat_no_penerbangan,
                        'itberangkat_asal_daerah' => $itberangkat_asal_daerah,
                        'itberangkat_tujuan' => $itberangkat_tujuan,
                        'itberangkat_tanggal' => $itberangkat_tanggal,
                        'itberangkat_kelas' => $itberangkat_kelas,
                        'itberangkat_harga_tiket' => $itberangkat_harga_tiket,
                        'itkembali_maskapai' => $itkembali_maskapai,
                        'itkembali_nama' => $itkembali_nama,
                        'itkembali_no_tiket' => $itkembali_no_tiket,
                        'itkembali_kode_booking' => $itkembali_kode_booking,
                        'itkembali_no_penerbangan' => $itkembali_no_penerbangan,
                        'itkembali_asal_daerah' => $itkembali_asal_daerah,
                        'itkembali_tujuan' => $itkembali_tujuan,
                        'itkembali_tanggal' => $itkembali_tanggal,
                        'itkembali_kelas' => $itkembali_kelas,
                        'itkembali_harga_tiket' => $itkembali_harga_tiket,
                        'nama_penginapan' => $nama_penginapan,
                        'keterangan' => $keterangan


                      
                     );
                     
                    //  if($user_id == 680){
                    // }
        $this->db->where('id', $id);
        $save = $this->db->update('keu_perdin', $data);

        if ($save) {
            $return = true;
        } else {
            $return = false;
        }

        return $return;
    }
    public function save_e_perdin($data) {
        // Debug: Menampilkan data yang akan disimpan jika log debug diaktifkan
        log_message('debug', 'Data yang akan disimpan: ' . print_r($data, true));
        // var_dump($data);die();
        // Cek apakah data yang dikirimkan valid
        if (empty($data)) {
            log_message('error', 'Data kosong!');
            return false;  // Mengembalikan false jika data kosong
        }
        // var_dump($data);die;
    
        // Menyimpan data ke tabel keu_perdin
        $insert = $this->db->insert('keu_perdin', $data);
    
        // Mengecek apakah query berhasil
        if ($insert) {
            // Mengambil ID data yang baru saja disimpan
            $insertedId = $this->db->insert_id();
        
    
            // Mengembalikan ID data yang baru saja disimpan
            return $insertedId;
        } else {
            // Debug: Menampilkan error jika insert gagal
            log_message('error', 'Gagal menyimpan data ke tabel keu_perdin.');
            log_message('error', 'Error Code: ' . $this->db->_error_number());
            echo 'Error Message: ' . $this->db->_error_message();
            return false;
        }
    }
    public function save_e_perdin_tujuan_pemberangkatan($data) {
        // Debug: Menampilkan data yang akan disimpan jika log debug diaktifkan
        log_message('debug', 'Data yang akan disimpan: ' . print_r($data, true));
        // Cek apakah data yang dikirimkan valid
        if (empty($data)) {
            log_message('error', 'Data kosong!');
            return false;  // Mengembalikan false jika data kosong
        }
    
        // Menyimpan data ke tabel keu_perdin
        $insert = $this->db->insert('tujuan_keberangkatan_perdin', $data);
        // var_dump($data);die();

    
        // Mengecek apakah query berhasil
        if ($insert) {
            // Mengambil ID data yang baru saja disimpan
            $insertedId = $this->db->insert_id();
        
    
            // Mengembalikan ID data yang baru saja disimpan
            return $insertedId;
        } else {
            // Debug: Menampilkan error jika insert gagal
            log_message('error', 'Gagal menyimpan data ke tabel keu_perdin.');
            log_message('error', 'Error Code: ' . $this->db->_error_number());
            log_message('error', 'Error Message: ' . $this->db->_error_message());
            return false;
        }
    }
    public function hapus_perdin($id_pegawai,$no_grup_perdin)
    {
        $this->db->where('id_pegawai', $id_pegawai); // Tambahkan kondisi berdasarkan id_pegawai
        $this->db->where('no_grup_perdin', $no_grup_perdin); // Tambahkan kondisi berdasarkan id_pegawai
        $this->db->delete('keu_perdin'); // Ganti 'nama_tabel' dengan nama tabel Anda
    }

    public function hapus_perdin_by_id($id_pegawai,$no_grup_perdin)
    {
        $this->db->where('id_pegawai', $id_pegawai); // Tambahkan kondisi berdasarkan id_pegawai
        $this->db->delete('keu_perdin'); // Ganti 'nama_tabel' dengan nama tabel Anda
    }
    public function hapus_perdin_by_no_grup_perdin($no_grup_perdin, $id_tim)
    {
        log_message('debug', 'Memulai hapus_perdin_by_no_grup_perdin: no_grup_perdin = ' . $no_grup_perdin . ', id_tim = ' . $id_tim);
    
        // Mulai transaksi database
        $this->db->trans_start();
    
        // Hapus dari keu_perdin
        $this->db->where('no_grup_perdin', $no_grup_perdin);
        $this->db->where('id_tim', $id_tim);
        if (!$this->db->delete('keu_perdin')) {
            log_message('error', 'Gagal menghapus dari keu_perdin. Error: ' . $this->db->_error_number() . ' - ' . $this->db->_error_message());
        }
    
        // Hapus dari tujuan_keberangkatan_perdin
        $this->db->where('keu_perdin_id', $no_grup_perdin);
        $this->db->where('id_tim', $id_tim);
        if (!$this->db->delete('tujuan_keberangkatan_perdin')) {
            echo 'Gagal menghapus dari tujuan_keberangkatan_perdin. Error: ' . $this->db->_error_number() . ' - ' . $this->db->_error_message();
        }
    
        // Selesaikan transaksi
        $this->db->trans_complete();
    
        // Periksa status transaksi
        $status = $this->db->trans_status();
        log_message('debug', 'Status transaksi hapus_perdin_by_no_grup_perdin: ' . ($status ? 'BERHASIL' : 'GAGAL'));
    
        return $status;
    }
    
    
    
    public function hapus_tujuan_by_no_grup_perdin($no_grup_perdin, $id_tim)
    {
        $this->db->where('no_grup_perdin', $no_grup_perdin); // Tambahkan kondisi berdasarkan id_pegawai
        $this->db->where('id_tim', $id_tim); // Tambahkan kondisi berdasarkan id_pegawai
        $this->db->delete('tujuan_keberangkatan_perdin'); // Ganti 'nama_tabel' dengan nama tabel Anda
    }
    public function get_no_grup_terakhir() {
        $query = $this->db->select('MAX(no_grup_perdin) as no_grup_terakhir')
                          ->from('keu_perdin')
                          ->get();
    
        if ($query->num_rows() > 0) {
            return $query->row()->no_grup_terakhir; // Mengembalikan nilai nomor grup terakhir
        }
        return null; // Mengembalikan null jika tidak ada data
    }
    public function get_no_grup_by_id_tim($id_tim) {
        $query = $this->db->select('MAX(no_grup_perdin) as no_grup_perdin')
                          ->from('keu_perdin')
                          ->where('id_tim', $id_tim)
                          ->get();
    
        if ($query->num_rows() > 0) {
            return $query->row()->no_grup_perdin; // Mengembalikan nomor grup sebelumnya
        }
    
        return null; // Mengembalikan null jika tidak ada data
    }
    public function get_kode_tim($id_tim) {

        $query = $this->db->select('kode_tim')
                          ->from('ketua_tot')
                          ->where('id', $id_tim)
                          ->get();
    
        if ($query->num_rows() > 0) {
            return $query->row()->kode_tim; // Mengembalikan nomor grup sebelumnya
        }
    
        return null; // Mengembalikan null jika tidak ada data
    }
    public function get_tim_details($id_tim) {
        $query = $this->db->select('ketua_tot.nama_tim as nama_tim_ketua, ketua_tot.kode_tim as kode_tim_ketua, koor_tot.nama_tim as nama_tim_koor, koor_tot.kode_tim as kode_tim_koor')
                          ->from('ketua_tot')
                          ->join('koor_tot', 'ketua_tot.id_koor = koor_tot.id')
                          ->where('ketua_tot.id', $id_tim)
                          ->get();
    
        if ($query->num_rows() > 0) {
            return $query->row(); // Returns the row as an object
        }
    
        return null; // Returns null if no data is found
    }
    
    public function update_e_perdin($id, $data) {
        // var_dump($id);die();
         
         // Debug: Menampilkan data yang akan diupdate jika log debug diaktifkan
         log_message('debug', 'Data yang akan diupdate: ' . print_r($data, true));
         
         // Cek apakah data yang dikirimkan valid
         if (empty($data) || empty($id)) {
             log_message('error', 'Data kosong atau ID tidak ada!');
             return false;  // Mengembalikan false jika data kosong atau ID tidak ada
         }
     
         // Memperbarui data di tabel keu_perdin berdasarkan ID
         $this->db->where('id', $id);
         $update = $this->db->update('keu_perdin', $data);
         // Mengecek apakah query berhasil
         if ($update) {
             // Debug: Jika update berhasil, beri tahu di log (jika diperlukan)
             log_message('debug', 'Data berhasil diperbarui di tabel keu_perdin. ID: ' . $id);
             return true;
         } else {
             // Debug: Menampilkan error jika update gagal
             log_message('error', 'Gagal memperbarui data di tabel keu_perdin. ID: ' . $id);
             log_message('error', 'Error Code: ' . $this->db->_error_number());
             log_message('error', 'Error Message: ' . $this->db->_error_message());
             return false;
         }
    }
    public function hapus_file_perdin($no_grup_perdin, $id_tim, $data) {
        log_message('debug', 'Data yang akan diupdate: ' . print_r($data, true));
    
        // Cek apakah data yang dikirimkan valid
        if (empty($data) || empty($no_grup_perdin) || empty($id_tim)) {
            log_message('error', 'Data kosong atau parameter tidak lengkap!');
            return false;
        }
    
        // Memperbarui data di tabel keu_perdin berdasarkan no_grup_perdin dan id_tim
        $this->db->where('no_grup_perdin', $no_grup_perdin);
        $this->db->where('id_tim', $id_tim);
        $update = $this->db->update('keu_perdin', $data);
    
        if ($update) {
            log_message('debug', 'Data berhasil diperbarui di tabel keu_perdin.');
            return true;
        } else {
            log_message('error', 'Gagal memperbarui data di tabel keu_perdin.');
            log_message('error', 'Error Code: ' . $this->db->error()['code']);
            log_message('error', 'Error Message: ' . $this->db->error()['message']);
            return false;
        }
    }
    
    public function update_e_perdin_file($id, $data) {
        // var_dump($id);die();
         
         // Debug: Menampilkan data yang akan diupdate jika log debug diaktifkan
         log_message('debug', 'Data yang akan diupdate: ' . print_r($data, true));
         
         // Cek apakah data yang dikirimkan valid
         if (empty($data) || empty($id)) {
             log_message('error', 'Data kosong atau ID tidak ada!');
             return false;  // Mengembalikan false jika data kosong atau ID tidak ada
         }
     
         // Memperbarui data di tabel keu_perdin berdasarkan ID
         $this->db->where('id', $id);
         
         $update = $this->db->update('keu_perdin', $data);
         // Mengecek apakah query berhasil
         if ($update) {
             // Debug: Jika update berhasil, beri tahu di log (jika diperlukan)
             log_message('debug', 'Data berhasil diperbarui di tabel keu_perdin. ID: ' . $id);
             return true;
         } else {
             // Debug: Menampilkan error jika update gagal
             log_message('error', 'Gagal memperbarui data di tabel keu_perdin. ID: ' . $id);
             log_message('error', 'Error Code: ' . $this->db->_error_number());
             log_message('error', 'Error Message: ' . $this->db->_error_message());
             return false;
         }
     }
        public function update_e_perdin_by_no_grup_perdin($id,$id_tim,$data) {
            // var_dump($id);die();
            
            // Debug: Menampilkan data yang akan diupdate jika log debug diaktifkan
            log_message('debug', 'Data yang akan diupdate: ' . print_r($data, true));
            
            // Cek apakah data yang dikirimkan valid
            if (empty($data) || empty($id)) {
                log_message('error', 'Data kosong atau ID tidak ada!');
                return false;  // Mengembalikan false jika data kosong atau ID tidak ada
            }
        
            // Memperbarui data di tabel keu_perdin berdasarkan ID
            $this->db->where('no_grup_perdin', $id);
            $this->db->where('id_tim', $id_tim);
            $update = $this->db->update('keu_perdin', $data);
            // Mengecek apakah query berhasil
            if ($update) {
                // Debug: Jika update berhasil, beri tahu di log (jika diperlukan)
                log_message('debug', 'Data berhasil diperbarui di tabel keu_perdin. ID: ' . $id);
                return true;
            } else {
                // Debug: Menampilkan error jika update gagal
                log_message('error', 'Gagal memperbarui data di tabel keu_perdin. ID: ' . $id);
                log_message('error', 'Error Code: ' . $this->db->_error_number());
                log_message('error', 'Error Message: ' . $this->db->_error_message());
                return false;
            }
        }
        public function update_tujuan_berangkat($id,$id_tim, $data) {
            // var_dump($data);die();
            
            // Debug: Menampilkan data yang akan diupdate jika log debug diaktifkan
            log_message('debug', 'Data yang akan diupdate: ' . print_r($data, true));
            
            // Cek apakah data yang dikirimkan valid
            if (empty($data) || empty($id)) {
                log_message('error', 'Data kosong atau ID tidak ada!');
                return false;  // Mengembalikan false jika data kosong atau ID tidak ada
            }
        
            // Memperbarui data di tabel keu_perdin berdasarkan ID
            $this->db->where('keu_perdin_id', $id);
            $this->db->where('id_tim', $id_tim);
            $update = $this->db->update('tujuan_keberangkatan_perdin', $data);
            // Mengecek apakah query berhasil
            if ($update) {
                // Debug: Jika update berhasil, beri tahu di log (jika diperlukan)
                log_message('debug', 'Data berhasil diperbarui di tabel keu_perdin. ID: ' . $id);
                return true;
            } else {
                // Debug: Menampilkan error jika update gagal
                log_message('error', 'Gagal memperbarui data di tabel keu_perdin. ID: ' . $id);
                log_message('error', 'Error Code: ' . $this->db->_error_number());
                log_message('error', 'Error Message: ' . $this->db->_error_message());
                return false;
            }
        }
        public function update_perjalanan_dinas($id,$id_tim, $data) {
            // var_dump($data);die();
            
            // Debug: Menampilkan data yang akan diupdate jika log debug diaktifkan
            log_message('debug', 'Data yang akan diupdate: ' . print_r($data, true));
            
            // Cek apakah data yang dikirimkan valid
            if (empty($data) || empty($id)) {
                log_message('error', 'Data kosong atau ID tidak ada!');
                return false;  // Mengembalikan false jika data kosong atau ID tidak ada
            }
        
            // Memperbarui data di tabel keu_perdin berdasarkan ID
            $this->db->where('keu_perdin_id', $id);
            $this->db->where('id_tim', $id_tim);
            $update = $this->db->update('keu_perdin', $data);
            // Mengecek apakah query berhasil
            if ($update) {
                // Debug: Jika update berhasil, beri tahu di log (jika diperlukan)
                log_message('debug', 'Data berhasil diperbarui di tabel keu_perdin. ID: ' . $id);
                return true;
            } else {
                // Debug: Menampilkan error jika update gagal
                log_message('error', 'Gagal memperbarui data di tabel keu_perdin. ID: ' . $id);
                log_message('error', 'Error Code: ' . $this->db->_error_number());
                log_message('error', 'Error Message: ' . $this->db->_error_message());
                return false;
            }
        }
     public function save_data($tgl_pembayaran, $user_id, $tmpegawai, $lama_p_d,$no_bku, $uraian, $tujuan, $skpd, $no__sppd, $tanggal_berangkat, $tgl_surat, $tanggal_kembali, $uang_hari, $harga_hari, $jumlah_uang, $representasi_hari, $representasi_harga, $jumlah_representasi, $uang_sakuhari, $uang_sakuharga, $uang_sku_p_j, $penginapan_malam, $penginapan_harga, $penginapan_jumlah, $tikettol_pulang, $tikettol_pergi, $tikettol_jumlah, $s_t_k_asal_hari, $s_t_k_asal_harga, $s_t_k_asal_jumlah, $s_t_k_tujuan_hari, $s_t_k_tujuan_harga, $s_t_k_tujuan_jumlah, $sewa_kendaraan_hari, $sewa_kendaraan_harga, $sewa_kendaraan_jumlah, $bbm_liter, $bbm_harga, $bbm_jumlah, $swabdi_kota_asal, $swabdi_kota_tujuan, $swab_jumlah, $jumlah_total, $itberangkat_maskapai, $itberangkat_no_tiket, $itberangkat_kodebooking, $itberangkat_no_penerbangan, $itberangkat_asal_daerah, $itberangkat_tujuan, $itberangkat_tanggal, $itberangkat_kelas, $itberangkat_harga_tiket, $itkembali_maskapai, $itkembali_nama, $itkembali_no_tiket, $itkembali_kode_booking, $itkembali_no_penerbangan, $itkembali_asal_daerah, $itkembali_tujuan, $itkembali_tanggal, $itkembali_kelas, $itkembali_harga_tiket, $nama_penginapan, $keterangan) {
        // $timeline = $this->get_datakegiatan($id);

        $data = array(
                       // 'user_id'       => $id_user,
                         'id_pegawai'      => $tmpegawai,
                        'lama_p_d' => $lama_p_d,
                        'no_bku' => $no_bku,
                        'uraian' => $uraian,
                        'tujuan' => $tujuan,
                        'user_id' => $user_id,
                        'skpd' => $skpd,
                        'no__sppd' => $no__sppd,
                        'tanggal_berangkat' => $tanggal_berangkat,
                        'tgl_pembayaran' => $tgl_pembayaran,
                        'tgl_surat' => $tgl_surat,
                        'tanggal_kembali' => $tanggal_kembali,
                        'uang_hari' => $uang_hari,
                        'harga_hari' => $harga_hari,
                        'jumlah_uang' => $jumlah_uang,
                        'representasi_hari' => $representasi_hari,
                        'representasi_harga' => $representasi_harga,
                        'jumlah_representasi' => $jumlah_representasi,
                        'uang_sakuhari' => $uang_sakuhari,
                        'uang_sakuharga' => $uang_sakuharga,
                        'uang_sku_p_j' => $uang_sku_p_j,
                        'penginapan_malam' => $penginapan_malam,
                        'penginapan_harga' => $penginapan_harga,
                        'penginapan_jumlah' => $penginapan_jumlah,
                        'tikettol_pulang' => $tikettol_pulang,
                        'tikettol_pergi' => $tikettol_pergi,
                        'tikettol_jumlah' => $tikettol_jumlah,
                        's_t_k_asal_hari' => $s_t_k_asal_hari,
                        's_t_k_asal_harga' => $s_t_k_asal_harga,
                        's_t_k_asal_jumlah' => $s_t_k_asal_jumlah,
                        's_t_k_tujuan_hari' => $s_t_k_tujuan_hari,
                        's_t_k_tujuan_harga' => $s_t_k_tujuan_harga,
                        's_t_k_tujuan_jumlah' => $s_t_k_tujuan_jumlah,
                        'sewa_kendaraan_hari' => $sewa_kendaraan_hari,
                        'sewa_kendaraan_harga' => $sewa_kendaraan_harga,
                        'sewa_kendaraan_jumlah' => $sewa_kendaraan_jumlah,
                        'bbm_liter' => $bbm_liter,
                        'bbm_harga' => $bbm_harga,
                        'bbm_jumlah' => $bbm_jumlah,
                        'swabdi_kota_asal' => $swabdi_kota_asal,
                        'swabdi_kota_tujuan' => $swabdi_kota_tujuan,
                        'swab_jumlah' => $swab_jumlah,
                        'jumlah_total' => $jumlah_total,
                        'itberangkat_maskapai' => $itberangkat_maskapai,
                        'itberangkat_no_tiket' => $itberangkat_no_tiket,
                        'itberangkat_kodebooking' => $itberangkat_kodebooking,
                        'itberangkat_no_penerbangan' => $itberangkat_no_penerbangan,
                        'itberangkat_asal_daerah' => $itberangkat_asal_daerah,
                        'itberangkat_tujuan' => $itberangkat_tujuan,
                        'itberangkat_tanggal' => $itberangkat_tanggal,
                        'itberangkat_kelas' => $itberangkat_kelas,
                        'itberangkat_harga_tiket' => $itberangkat_harga_tiket,
                        'itkembali_maskapai' => $itkembali_maskapai,
                        'itkembali_nama' => $itkembali_nama,
                        'itkembali_no_tiket' => $itkembali_no_tiket,
                        'itkembali_kode_booking' => $itkembali_kode_booking,
                        'itkembali_no_penerbangan' => $itkembali_no_penerbangan,
                        'itkembali_asal_daerah' => $itkembali_asal_daerah,
                        'itkembali_tujuan' => $itkembali_tujuan,
                        'itkembali_tanggal' => $itkembali_tanggal,
                        'itkembali_kelas' => $itkembali_kelas,
                        'itkembali_harga_tiket' => $itkembali_harga_tiket,
                        'nama_penginapan' => $nama_penginapan,
                        'keterangan' => $keterangan

                     );

        $save = $this->db->insert('keu_perdin', $data);
        // var_dump($data);die();
        if ($save) {
            $return = $this->db->insert_id();
        } else {
            $return = 0;
        }

        return $return;


    }

    public function insert_surat_perintah($row, $nomor_surat, $dasar, $untuk, $tanggal, $ttd)
    {
        $data = array(
                       // 'user_id'       => $id_user,
                        'nomor'      => $nomor_surat,
                       'dasar' => $dasar,
                        'kepada' => $row,
                        'untuk' => $untuk,
                        'tanggal' => $tanggal,
                        'ttd' => $ttd
                    );
        $save = $this->db->insert('surat_perintah', $data);
        if ($save) {
            $return = $this->db->insert_id();
        } else {
            $return = 0;
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
           
            default:
                $data = " - BELUM DIINISIASI - ";
                break;
        }
        return $data;
    }


    

    public function delete_perdin($id) {
     
            $del = $this->db->delete('keu_perdin', array('id' => $id));
            if ($del) {
                return true;
            } else {
                return false;
            }
        
    }
    function formatNomorTelepon($n_hp) {
        // Menghapus karakter selain angka
        $n_hp = preg_replace('/\D/', '', $n_hp);

        // Tentukan kode negara Indonesia
        $kode_negara_indonesia = '62';

        // Cek awalan nomor
        if (substr($n_hp, 0, 1) == '+') {
            $n_hp = substr($n_hp, 1);  // Menghapus tanda "+"
        } elseif (substr($n_hp, 0, 1) == '0') {
            $n_hp = $kode_negara_indonesia . substr($n_hp, 1);  // Mengganti '0' dengan '62'
        } elseif (substr($n_hp, 0, 2) == '62') { 
            // Jika sudah dalam format Indonesia, biarkan
        } else {
            $n_hp = $kode_negara_indonesia . $n_hp;  // Menambahkan kode negara Indonesia
        }

        // Periksa dan pastikan nomor memiliki panjang yang valid
        if (strlen($n_hp) < 9) {
            return false;
        }

        return $n_hp;
    }
    public function postWaSms($n_hp = null, $n_pesan = null, $campaign = null){ // jika dikirim dari Backoffice
        $n_pesan = str_replace("\n", " ", $n_pesan);
          //echo '#'.$n_hp.'#<br>#'.$n_pesan.'#<br>#'.$campaign.'#'; //die();
        $settings = new settings();
        $settings->where('name', 'smsGateway')->get();
        $statsms = $settings->status;
        if($statsms == '1'){
          // URL API Mekari Qontak
          $apiUrl = "https://service-chat.qontak.com/api/open/v1/broadcasts/whatsapp/direct";
    
          // API Key Anda
          $apiKey = "FrUHtaND1Hbfs32MfUwdISCtFeg61NREHNFhjy6Hku8";
          $pesan_id = "2a8e4466-eae6-4cbc-8b81-0b3d21dea5c9";
          $isi_pesan = $n_pesan;  // Pesan yang akan dikirim
    
          // Nomor telepon (contoh)
          $n_hp = $n_hp;
    
          // Fungsi format nomor telepon
    
          //echo '#'.$n_hp.'#<br>'; //die();
            // Memformat nomor telepon
            $formatted_number = $this->formatNomorTelepon($n_hp);
            if (!$formatted_number) {
                echo "Nomor telepon tidak valid.";
                return false;
            }
    
            // Data untuk pengiriman pesan
            $data = [
                "to_name" => "Lian",
                "to_number" => $formatted_number,
                "message_template_id" => $pesan_id,
                "channel_integration_id" => "a845467d-b887-4790-90b4-ab6e230a9c41",
                "language" => ["code" => "id"], // Bahasa Indonesia
                "parameters" => [
                    "body" => [
                        [
                            "key" => "1",
                            "value_text" => $isi_pesan,
                            "value" => "lian_permadi" // Identifikasi pengirim
                        ]
                    ]
                ]
            ];
            // Inisialisasi cURL
            var_dump($data);
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $apiUrl);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                "Content-Type: application/json",
                "Authorization: Bearer $apiKey"
            ]);
    
            // Eksekusi cURL dan tangani respons
            $response = curl_exec($ch);
            $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    
            if (curl_errno($ch)) {
                echo "Error: " . curl_error($ch);
                curl_close($ch);
                return false;
            }
    
            curl_close($ch);
    
            // Evaluasi respons API
            $response_data = json_decode($response, true);
            if (($http_code === 200 || $http_code === 201) && isset($response_data['status']) && $response_data['status'] === 'success') {
                echo "Pesan berhasil dikirim.";
        // var_dump($http_code);die();
                return true;
            } else {
                echo "Gagal mengirim pesan. Respons: " . $response;die();
                echo '<br>#'.$formatted_number.'#<br>';
        // var_dump($http_code);die();
                return false;
            }
          }
    }

    
}
