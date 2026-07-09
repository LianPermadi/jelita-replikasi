<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Description of Permohonan sementara portal class
 *
 * @author pbs
 * Created : 22 Juli 2014
 *
 */

class tmpemohon_portal extends DataMapper {

    var $table = 'tmpemohon_portal';   

    //var $has_one = array('tmpemohon', 'trperizinan', 'trjenis_permohonan','tmpemohon_sementara',
    //'tmperusahaan', 'tmperusahaan_sementara', 'trsyarat_perizinan', 'trstspermohonan', 'tmbap', 
    //    'tmsurat_permohonan', 'tmsurat_rekomendasi', 'tmsk', 'trtanggal_survey',
    //    'tmkeringananretribusi', 'tmsurat_keputusan');

    //var $has_many = array('tmproperty_jenisperizinan', 'tmtrackingperizinan',
    //    'tmproperty_klasifikasi', 'tmproperty_prasarana', 'tmretribusi_rinci_imb');

    public function __construct() {
        parent::__construct();
    }

}
