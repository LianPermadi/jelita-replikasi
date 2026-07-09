<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Mkinerjaesdm extends Model
 {
 public function index(){

                    $i = NULL;
                    $query_data = "select id, n_perizinan, v_perizinan from trperizinan where kd_izin like '12%'";
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
                        //$persen=0;
                        $query = "select a.id jumlah from tmpermohonan a
                                 inner join tmpermohonan_trperizinan b on a.id = b.tmpermohonan_id
                                 LEFT JOIN tmpermohonan_trstspermohonan as t6 on a.id = t6.tmpermohonan_id
                                 LEFT JOIN trstspermohonan as t7 on t7.id = t6.trstspermohonan_id
								 
                                 where b.trperizinan_id = '".$data['id']."'
                                 and t7.id <> 1  
                                 and a.d_terima_berkas between '$tgla' and '$tglb'";
                        $hasil_data = mysql_query($query);
                        $jumlah_masuk = mysql_num_rows(@$hasil_data);
                        $query2 = "select a.id, a.c_izin_selesai, d.c_penetapan, d.status_bap from tmpermohonan a
                                inner join tmpermohonan_trperizinan b on a.id = b.tmpermohonan_id
                                inner join tmbap_tmpermohonan c on a.id = c.tmpermohonan_id
                                inner join tmbap d on d.id = c.tmbap_id
inner join trperizinan e on e.id = b.trperizinan_id
                                LEFT JOIN tmpermohonan_trstspermohonan as t6 on a.id = t6.tmpermohonan_id
                                LEFT JOIN trstspermohonan as t7 on t7.id = t6.trstspermohonan_id
                               
                                where b.trperizinan_id = '".$data['id']."' and d.c_penetapan = 1

                                and t7.id <> 1

                                and a.d_terima_berkas between '$tgla' and '$tglb'";
                        $hasil_data2 = mysql_query($query2);
                        while ($rows_data2 = mysql_fetch_assoc(@$hasil_data2)){
                            if($rows_data2['status_bap'] == "1"){
                                $jumlah_terbit++;
                                if($rows_data2['c_izin_selesai'] == "1") $terbit_ambil++;
                                else $terbit_proses++;
                            }else if($rows_data2['status_bap'] == "2"){
                                $jumlah_tolak++;
                                if($rows_data2['c_izin_selesai'] == "1") $tolak_ambil++;
                                else $tolak_proses++;
                            }
                        }
                        $jumlah_proses = $jumlah_masuk - ($jumlah_terbit + $jumlah_tolak);
						//$persen= 100*($jumlah_terbit / $jumlah_tolak);
						if( $jumlah_terbit != 0  or $jumlah_tolak != 0 or $jumlah_masuk!=0 ){
 $persen=(( $jumlah_terbit + $jumlah_tolak)/$jumlah_masuk)*100;
					}elseif( $jumlah_terbit == 0  && $jumlah_tolak == 0 ){
    $persen = 0;
} ;
            
                    }
                
 }
 public function sql(){
 $query_data = "select id, n_perizinan, v_perizinan from trperizinan where kd_izin like '12%'";
 
 }
}


?>