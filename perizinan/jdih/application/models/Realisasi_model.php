<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Realisasi_model extends CI_Model
{
    private $_table = "euis_realisasiDPA";

 public $kode1;
    public function getAll()
    {
        //return $this->db->get($this->_table)->result();
       /*return $this->db->query(" SELECT A.*,  B.n_pegawai
FROM euis_slipgaji4 A
left join tmpegawai B on replace(B.nip,' ', '') = replace(A.id_pegawai,' ', '') ")->result();*/
return $this->db->query(" SELECT kode1 from euis_realisasiDPA ")->result();
    }

    public function getSekre(){
        return $this->db->query(" SELECT *
FROM euis_realisasiDPA where bidang = 'SEKRETARIAT' ")->result();
    }
    
    public function getDatin(){
        return $this->db->query(" SELECT *
FROM euis_realisasiDPA where bidang = 'DATIN' ")->result();
    }
     public function getEsda(){
        return $this->db->query(" SELECT *
FROM euis_realisasiDPA where bidang = 'ESDA' ")->result();
    }
    public function getInsos(){
        return $this->db->query(" SELECT *
FROM euis_realisasiDPA where bidang = 'INSOS' ")->result();
    }
     public function getBangprom(){
        return $this->db->query(" SELECT *
FROM euis_realisasiDPA where bidang = 'BANGPROM' ")->result();
    }
    public function getPengendalian(){
        return $this->db->query(" SELECT *
FROM euis_realisasiDPA where bidang = 'PENGENDALIAN' ")->result();
    }

    public function getSekreJan(){
        return $this->db->query(" SELECT *
FROM euis_realisasiDPA where bidang = 'SEKRETARIAT' AND bulan = 'JANUARI' ")->result();
    }
    public function getDatinJan(){
        return $this->db->query(" SELECT *
FROM euis_realisasiDPA where bidang = 'DATIN' AND bulan = 'JANUARI' ")->result();
    }
    public function getEsdaJan(){
        return $this->db->query(" SELECT *
FROM euis_realisasiDPA where bidang = 'ESDA' AND bulan = 'JANUARI' ")->result();
    }
    public function getInsosJan(){
        return $this->db->query(" SELECT *
FROM euis_realisasiDPA where bidang = 'INSOS' AND bulan = 'JANUARI' ")->result();
    }
    public function getBangpromJan(){
        return $this->db->query(" SELECT *
FROM euis_realisasiDPA where bidang = 'BANGPROM' AND bulan = 'JANUARI' ")->result();
    }
    public function getPengendalianJan(){
        return $this->db->query(" SELECT *
FROM euis_realisasiDPA where bidang = 'PENGENDALIAN' AND bulan = 'JANUARI' ")->result();
    }

    public function getSekreFeb(){
        return $this->db->query(" SELECT *
FROM euis_realisasiDPA where bidang = 'SEKRETARIAT' AND bulan = 'FEBRUARI' ")->result();
    }
    public function getDatinFeb(){
        return $this->db->query(" SELECT *
FROM euis_realisasiDPA where bidang = 'DATIN' AND bulan = 'FEBRUARI' ")->result();
    }
    public function getEsdaFeb(){
        return $this->db->query(" SELECT *
FROM euis_realisasiDPA where bidang = 'ESDA' AND bulan = 'FEBRUARI' ")->result();
    }
    public function getInsosFeb(){
        return $this->db->query(" SELECT *
FROM euis_realisasiDPA where bidang = 'INSOS' AND bulan = 'FEBRUARI' ")->result();
    }
    public function getBangpromFeb(){
        return $this->db->query(" SELECT *
FROM euis_realisasiDPA where bidang = 'BANGPROM' AND bulan = 'FEBRUARI' ")->result();
    }
    public function getPengendalianFeb(){
        return $this->db->query(" SELECT *
FROM euis_realisasiDPA where bidang = 'PENGENDALIAN' AND bulan = 'FEBRUARI' ")->result();
    }

    // MARET

    public function getSekreMar(){
        return $this->db->query(" SELECT *
FROM euis_realisasiDPA where bidang = 'SEKRETARIAT' AND bulan = 'MARET' ")->result();
    }
    public function getDatinMar(){
        return $this->db->query(" SELECT *
FROM euis_realisasiDPA where bidang = 'DATIN' AND bulan = 'MARET' ")->result();
    }
    public function getEsdaMar(){
        return $this->db->query(" SELECT *
FROM euis_realisasiDPA where bidang = 'ESDA/INSOS' AND bulan = 'MARET' ")->result();
    }
    public function getInsosMar(){
        return $this->db->query(" SELECT *
FROM euis_realisasiDPA where bidang = 'INSOS' AND bulan = 'MARET' ")->result();
    }
    public function getBangpromMar(){
        return $this->db->query(" SELECT *
FROM euis_realisasiDPA where bidang = 'BANGPROM' AND bulan = 'MARET' ")->result();
    }
    public function getPengendalianMar(){
        return $this->db->query(" SELECT *
FROM euis_realisasiDPA where bidang = 'PENGENDALIAN' AND bulan = 'MARET' ")->result();
    }

// APRIL

    public function getSekreApr(){
        return $this->db->query(" SELECT *
FROM euis_realisasiDPA where bidang = 'SEKRETARIAT' AND bulan = 'APRIL' ")->result();
    }
    public function getDatinApr(){
        return $this->db->query(" SELECT *
FROM euis_realisasiDPA where bidang = 'DATIN' AND bulan = 'APRIL' ")->result();
    }
    public function getEsdaApr(){
        return $this->db->query(" SELECT *
FROM euis_realisasiDPA where bidang = 'ESDA/INSOS' AND bulan = 'APRIL' ")->result();
    }
    public function getInsosApr(){
        return $this->db->query(" SELECT *
FROM euis_realisasiDPA where bidang = 'INSOS' AND bulan = 'APRIL' ")->result();
    }
    public function getBangpromApr(){
        return $this->db->query(" SELECT *
FROM euis_realisasiDPA where bidang = 'BANGPROM' AND bulan = 'APRIL' ")->result();
    }
    public function getPengendalianApr(){
        return $this->db->query(" SELECT *
FROM euis_realisasiDPA where bidang = 'PENGENDALIAN' AND bulan = 'APRIL' ")->result();
    }

    public function getSekreMei(){
        return $this->db->query(" SELECT *
FROM euis_realisasiDPA where bidang = 'SEKRETARIAT' AND bulan = 'MEI' ")->result();
    }
    public function getDatinMei(){
        return $this->db->query(" SELECT *
FROM euis_realisasiDPA where bidang = 'DATIN' AND bulan = 'MEI' ")->result();
    }
    public function getEsdaMei(){
        return $this->db->query(" SELECT *
FROM euis_realisasiDPA where bidang = 'ESDA/INSOS' AND bulan = 'MEI' ")->result();
    }
    public function getInsosMei(){
        return $this->db->query(" SELECT *
FROM euis_realisasiDPA where bidang = 'INSOS' AND bulan = 'MEI' ")->result();
    }
    public function getBangpromMei(){
        return $this->db->query(" SELECT *
FROM euis_realisasiDPA where bidang = 'BANGPROM' AND bulan = 'MEI' ")->result();
    }
    public function getPengendalianMei(){
        return $this->db->query(" SELECT *
FROM euis_realisasiDPA where bidang = 'PENGENDALIAN' AND bulan = 'MEI' ")->result();
    }

//Juni

    public function getSekreJuni(){
        return $this->db->query(" SELECT *
FROM euis_realisasiDPA where bidang = 'SEKRETARIAT' AND bulan = 'JUNI' ")->result();
    }
    public function getDatinJuni(){
        return $this->db->query(" SELECT *
FROM euis_realisasiDPA where bidang = 'DATIN' AND bulan = 'JUNI' ")->result();
    }
    public function getEsdaJuni(){
        return $this->db->query(" SELECT *
FROM euis_realisasiDPA where bidang = 'ESDA/INSOS' AND bulan = 'JUNI' ")->result();
    }
    public function getInsosJuni(){
        return $this->db->query(" SELECT *
FROM euis_realisasiDPA where bidang = 'INSOS' AND bulan = 'JUNI' ")->result();
    }
    public function getBangpromJuni(){
        return $this->db->query(" SELECT *
FROM euis_realisasiDPA where bidang = 'BANGPROM' AND bulan = 'JUNI' ")->result();
    }
    public function getPengendalianJuni(){
        return $this->db->query(" SELECT *
FROM euis_realisasiDPA where bidang = 'PENGENDALIAN' AND bulan = 'JUNI' ")->result();
    }

    //Juli

    public function getSekreJuli(){
        return $this->db->query(" SELECT *
FROM euis_realisasiDPA where bidang = 'SEKRETARIAT' AND bulan = 'JULI' ")->result();
    }
    public function getDatinJuli(){
        return $this->db->query(" SELECT *
FROM euis_realisasiDPA where bidang = 'DATIN' AND bulan = 'JULI' ")->result();
    }
    public function getEsdaJuli(){
        return $this->db->query(" SELECT *
FROM euis_realisasiDPA where bidang = 'ESDA/INSOS' AND bulan = 'JULI' ")->result();
    }
    public function getInsosJuli(){
        return $this->db->query(" SELECT *
FROM euis_realisasiDPA where bidang = 'INSOS' AND bulan = 'JULI' ")->result();
    }
    public function getBangpromJuli(){
        return $this->db->query(" SELECT *
FROM euis_realisasiDPA where bidang = 'BANGPROM' AND bulan = 'JULI' ")->result();
    }
    public function getPengendalianJuli(){
        return $this->db->query(" SELECT *
FROM euis_realisasiDPA where bidang = 'PENGENDALIAN' AND bulan = 'JULI' ")->result();
    }

     //Agustus

    public function getSekreAgustus(){
        return $this->db->query(" SELECT *
FROM euis_realisasiDPA where bidang = 'SEKRETARIAT' AND bulan = 'AGUSTUS' ")->result();
    }
    public function getDatinAgustus(){
        return $this->db->query(" SELECT *
FROM euis_realisasiDPA where bidang = 'DATIN' AND bulan = 'AGUSTUS' ")->result();
    }
    public function getEsdaAgustus(){
        return $this->db->query(" SELECT *
FROM euis_realisasiDPA where bidang = 'ESDA/INSOS' AND bulan = 'AGUSTUS' ")->result();
    }
    public function getInsosAgustus(){
        return $this->db->query(" SELECT *
FROM euis_realisasiDPA where bidang = 'INSOS' AND bulan = 'AGUSTUS' ")->result();
    }
    public function getBangpromAgustus(){
        return $this->db->query(" SELECT *
FROM euis_realisasiDPA where bidang = 'BANGPROM' AND bulan = 'AGUSTUS' ")->result();
    }
    public function getPengendalianAgustus(){
        return $this->db->query(" SELECT *
FROM euis_realisasiDPA where bidang = 'PENGENDALIAN' AND bulan = 'AGUSTUS' ")->result();
    }

    public function getSumAll(){
    $sql = "SELECT  SUM(dpa_perubahan) AS dpa_total,
            SUM(realisasi) AS real_total,
            SUM(sisa_anggaran) AS sisa_total FROM euis_realisasiDPA 
    ";
    $result = $this->db->query($sql);
        return $result->row();
    }
    
     //September

    public function getSekreSeptember(){
        return $this->db->query(" SELECT *
FROM euis_realisasiDPA where bidang = 'SEKRETARIAT' AND bulan = 'SEPTEMBER' ")->result();
    }
    public function getDatinSeptember(){
        return $this->db->query(" SELECT *
FROM euis_realisasiDPA where bidang = 'DATIN' AND bulan = 'SEPTEMBER' ")->result();
    }
    public function getEsdaSeptember(){
        return $this->db->query(" SELECT *
FROM euis_realisasiDPA where bidang = 'ESDA/INSOS' AND bulan = 'SEPTEMBER' ")->result();
    }
    public function getInsosSeptember(){
        return $this->db->query(" SELECT *
FROM euis_realisasiDPA where bidang = 'INSOS' AND bulan = 'SEPTEMBER' ")->result();
    }
    public function getBangpromSeptember(){
        return $this->db->query(" SELECT *
FROM euis_realisasiDPA where bidang = 'BANGPROM' AND bulan = 'SEPTEMBER' ")->result();
    }
    public function getPengendalianSeptember(){
        return $this->db->query(" SELECT *
FROM euis_realisasiDPA where bidang = 'PENGENDALIAN' AND bulan = 'SEPTEMBER' ")->result();
    }

     //Oktober

    public function getSekreOktober(){
        return $this->db->query(" SELECT *
FROM euis_realisasiDPA where bidang = 'SEKRETARIAT' AND bulan = 'OKTOBER' ")->result();
    }
    public function getDatinOktober(){
        return $this->db->query(" SELECT *
FROM euis_realisasiDPA where bidang = 'DATIN' AND bulan = 'OKTOBER' ")->result();
    }
    public function getEsdaOktober(){
        return $this->db->query(" SELECT *
FROM euis_realisasiDPA where bidang = 'ESDA/INSOS' AND bulan = 'OKTOBER' ")->result();
    }
    public function getInsosOktober(){
        return $this->db->query(" SELECT *
FROM euis_realisasiDPA where bidang = 'INSOS' AND bulan = 'OKTOBER' ")->result();
    }
    public function getBangpromOktober(){
        return $this->db->query(" SELECT *
FROM euis_realisasiDPA where bidang = 'BANGPROM' AND bulan = 'OKTOBER' ")->result();
    }
    public function getPengendalianOktober(){
        return $this->db->query(" SELECT *
FROM euis_realisasiDPA where bidang = 'PENGENDALIAN' AND bulan = 'OKTOBER' ")->result();
    }

    // public function getSumAll(){
    // $sql = "SELECT  SUM(dpa_perubahan) AS dpa_total,
    //         SUM(realisasi) AS real_total,
    //         SUM(sisa_anggaran) AS sisa_total FROM euis_realisasiDPA 
    // ";
    // $result = $this->db->query($sql);
    //     return $result->row();
    // }

    public function getSumSekre(){
    $sql = "SELECT  SUM(IF(bidang='SEKRETARIAT', dpa_perubahan, 0)) AS dpa_sekre,
                    SUM(IF(bidang='SEKRETARIAT', realisasi, 0)) AS realisasi_sekre,
                    SUM(IF(bidang='SEKRETARIAT', sisa_anggaran, 0)) AS sisa_sekre FROM euis_realisasiDPA 
    ";
    $result = $this->db->query($sql);
        return $result->row();
    }
    public function getSumDatin(){
    $sql = "SELECT  SUM(IF(bidang='DATIN', dpa_perubahan, 0)) AS dpa_datin,
                    SUM(IF(bidang='DATIN', realisasi, 0)) AS realisasi_datin,
                    SUM(IF(bidang='DATIN', sisa_anggaran, 0)) AS sisa_datin FROM euis_realisasiDPA 
    ";
    $result = $this->db->query($sql);
        return $result->row();
    }

public function getSumEsda(){
    $sql = "SELECT  SUM(IF(bidang='ESDA', dpa_perubahan, 0)) AS dpa_esda,
                    SUM(IF(bidang='ESDA', realisasi, 0)) AS realisasi_esda,
                    SUM(IF(bidang='ESDA', sisa_anggaran, 0)) AS sisa_esda FROM euis_realisasiDPA 
    ";
    $result = $this->db->query($sql);
        return $result->row();
    }

public function getSumInsos(){
    $sql = "SELECT  SUM(IF(bidang='INSOS', dpa_perubahan, 0)) AS dpa_insos,
                    SUM(IF(bidang='INSOS', realisasi, 0)) AS realisasi_insos,
                    SUM(IF(bidang='INSOS', sisa_anggaran, 0)) AS sisa_insos FROM euis_realisasiDPA 
    ";
    $result = $this->db->query($sql);
        return $result->row();
    }

public function getSumBangprom(){
    $sql = "SELECT  SUM(IF(bidang='BANGPROM', dpa_perubahan, 0)) AS dpa_bangprom,
                    SUM(IF(bidang='BANGPROM', realisasi, 0)) AS realisasi_bangprom,
                    SUM(IF(bidang='BANGPROM', sisa_anggaran, 0)) AS sisa_bangprom FROM euis_realisasiDPA 
    ";
    $result = $this->db->query($sql);
        return $result->row();
    }

   public function getSumPengendalian(){
    $sql = "SELECT  COUNT(IF(bidang='PENGENDALIAN', persentase, 0)) AS persen_pengendalian,
                    SUM(IF(bidang='PENGENDALIAN', dpa_perubahan, 0)) AS dpa_pengendalian,
                    SUM(IF(bidang='PENGENDALIAN', realisasi, 0)) AS realisasi_pengendalian,
                    SUM(IF(bidang='PENGENDALIAN', persentase, 0)) AS persentase_pengendalian,
                    SUM(IF(bidang='PENGENDALIAN', sisa_anggaran, 0)) AS sisa_pengendalian FROM euis_realisasiDPA 
    ";

    $result = $this->db->query($sql);
        return $result->row(); 
    }

    // JANUARI
    public function getSumAllJan(){
    $sql = "SELECT  SUM(dpa_perubahan) AS dpa_total,
            SUM(realisasi) AS real_total,
            SUM(sisa_anggaran) AS sisa_total FROM euis_realisasiDPA where bulan = 'JANUARI'
    ";
    $result = $this->db->query($sql);
        return $result->row();
    }

    public function getSumSekreJan(){
    $sql = "SELECT  SUM(IF(bidang='SEKRETARIAT', dpa_perubahan, 0)) AS dpa_sekre,
                    SUM(IF(bidang='SEKRETARIAT', realisasi, 0)) AS realisasi_sekre,
                    SUM(IF(bidang='SEKRETARIAT', sisa_anggaran, 0)) AS sisa_sekre FROM euis_realisasiDPA where bulan = 'JANUARI'
    ";
    $result = $this->db->query($sql);
        return $result->row();
    }
    public function getSumDatinJan(){
    $sql = "SELECT  SUM(IF(bidang='DATIN', dpa_perubahan, 0)) AS dpa_datin,
                    SUM(IF(bidang='DATIN', realisasi, 0)) AS realisasi_datin,
                    SUM(IF(bidang='DATIN', sisa_anggaran, 0)) AS sisa_datin FROM euis_realisasiDPA where bulan = 'JANUARI'
    ";
    $result = $this->db->query($sql);
        return $result->row();
    }

public function getSumEsdaJan(){
    $sql = "SELECT  SUM(IF(bidang='ESDA', dpa_perubahan, 0)) AS dpa_esda,
                    SUM(IF(bidang='ESDA', realisasi, 0)) AS realisasi_esda,
                    SUM(IF(bidang='ESDA', sisa_anggaran, 0)) AS sisa_esda FROM euis_realisasiDPA where bulan = 'JANUARI'
    ";
    $result = $this->db->query($sql);
        return $result->row();
    }

public function getSumInsosJan(){
    $sql = "SELECT  SUM(IF(bidang='INSOS', dpa_perubahan, 0)) AS dpa_insos,
                    SUM(IF(bidang='INSOS', realisasi, 0)) AS realisasi_insos,
                    SUM(IF(bidang='INSOS', sisa_anggaran, 0)) AS sisa_insos FROM euis_realisasiDPA where bulan = 'JANUARI'
    ";
    $result = $this->db->query($sql);
        return $result->row();
    }

public function getSumBangpromJan(){
    $sql = "SELECT  SUM(IF(bidang='BANGPROM', dpa_perubahan, 0)) AS dpa_bangprom,
                    SUM(IF(bidang='BANGPROM', realisasi, 0)) AS realisasi_bangprom,
                    SUM(IF(bidang='BANGPROM', sisa_anggaran, 0)) AS sisa_bangprom FROM euis_realisasiDPA where bulan = 'JANUARI'
    ";
    $result = $this->db->query($sql);
        return $result->row();
    }

   public function getSumPengendalianJan(){
    $sql = "SELECT  COUNT(IF(bidang='PENGENDALIAN', persentase, 0)) AS persen_pengendalian,
                    SUM(IF(bidang='PENGENDALIAN', dpa_perubahan, 0)) AS dpa_pengendalian,
                    SUM(IF(bidang='PENGENDALIAN', realisasi, 0)) AS realisasi_pengendalian,
                    SUM(IF(bidang='PENGENDALIAN', persentase, 0)) AS persentase_pengendalian,
                    SUM(IF(bidang='PENGENDALIAN', sisa_anggaran, 0)) AS sisa_pengendalian FROM euis_realisasiDPA where bulan = 'JANUARI'
    ";

    $result = $this->db->query($sql);
        return $result->row(); 
    }

    // FEBRUARI

    public function getSumAllFeb(){
    $sql = "SELECT  SUM(dpa_perubahan) AS dpa_total,
            SUM(realisasi) AS real_total,
            SUM(sisa_anggaran) AS sisa_total FROM euis_realisasiDPA where bulan = 'FEBRUARI'
    ";
    $result = $this->db->query($sql);
        return $result->row();
    }

    public function getSumSekreFeb(){
    $sql = "SELECT  SUM(IF(bidang='SEKRETARIAT', dpa_perubahan, 0)) AS dpa_sekre,
                    SUM(IF(bidang='SEKRETARIAT', realisasi, 0)) AS realisasi_sekre,
                    SUM(IF(bidang='SEKRETARIAT', sisa_anggaran, 0)) AS sisa_sekre FROM euis_realisasiDPA where bulan = 'FEBRUARI'
    ";
    $result = $this->db->query($sql);
        return $result->row();
    }
    public function getSumDatinFeb(){
    $sql = "SELECT  SUM(IF(bidang='DATIN', dpa_perubahan, 0)) AS dpa_datin,
                    SUM(IF(bidang='DATIN', realisasi, 0)) AS realisasi_datin,
                    SUM(IF(bidang='DATIN', sisa_anggaran, 0)) AS sisa_datin FROM euis_realisasiDPA where bulan = 'FEBRUARI'
    ";
    $result = $this->db->query($sql);
        return $result->row();
    }

public function getSumEsdaFeb(){
    $sql = "SELECT  SUM(IF(bidang='ESDA', dpa_perubahan, 0)) AS dpa_esda,
                    SUM(IF(bidang='ESDA', realisasi, 0)) AS realisasi_esda,
                    SUM(IF(bidang='ESDA', sisa_anggaran, 0)) AS sisa_esda FROM euis_realisasiDPA where bulan = 'FEBRUARI'
    ";
    $result = $this->db->query($sql);
        return $result->row();
    }

public function getSumInsosFeb(){
    $sql = "SELECT  SUM(IF(bidang='INSOS', dpa_perubahan, 0)) AS dpa_insos,
                    SUM(IF(bidang='INSOS', realisasi, 0)) AS realisasi_insos,
                    SUM(IF(bidang='INSOS', sisa_anggaran, 0)) AS sisa_insos FROM euis_realisasiDPA where bulan = 'FEBRUARI'
    ";
    $result = $this->db->query($sql);
        return $result->row();
    }

public function getSumBangpromFeb(){
    $sql = "SELECT  SUM(IF(bidang='BANGPROM', dpa_perubahan, 0)) AS dpa_bangprom,
                    SUM(IF(bidang='BANGPROM', realisasi, 0)) AS realisasi_bangprom,
                    SUM(IF(bidang='BANGPROM', sisa_anggaran, 0)) AS sisa_bangprom FROM euis_realisasiDPA where bulan = 'FEBRUARI'
    ";
    $result = $this->db->query($sql);
        return $result->row();
    }

   public function getSumPengendalianFeb(){
    $sql = "SELECT  COUNT(IF(bidang='PENGENDALIAN', persentase, 0)) AS persen_pengendalian,
                    SUM(IF(bidang='PENGENDALIAN', dpa_perubahan, 0)) AS dpa_pengendalian,
                    SUM(IF(bidang='PENGENDALIAN', realisasi, 0)) AS realisasi_pengendalian,
                    SUM(IF(bidang='PENGENDALIAN', persentase, 0)) AS persentase_pengendalian,
                    SUM(IF(bidang='PENGENDALIAN', sisa_anggaran, 0)) AS sisa_pengendalian FROM euis_realisasiDPA where bulan = 'FEBRUARI'
    ";

    $result = $this->db->query($sql);
        return $result->row(); 
    }

    // MARET

    public function getSumAllMar(){
    $sql = "SELECT  SUM(dpa_perubahan) AS dpa_total,
            SUM(realisasi) AS real_total,
            SUM(sisa_anggaran) AS sisa_total FROM euis_realisasiDPA where bulan = 'MARET'
    ";
    $result = $this->db->query($sql);
        return $result->row();
    }

    public function getSumSekreMar(){
    $sql = "SELECT  SUM(IF(bidang='SEKRETARIAT', dpa_perubahan, 0)) AS dpa_sekre,
                    SUM(IF(bidang='SEKRETARIAT', realisasi, 0)) AS realisasi_sekre,
                    SUM(IF(bidang='SEKRETARIAT', sisa_anggaran, 0)) AS sisa_sekre FROM euis_realisasiDPA where bulan = 'MARET'
    ";
    $result = $this->db->query($sql);
        return $result->row();
    }
    public function getSumDatinMar(){
    $sql = "SELECT  SUM(IF(bidang='DATIN', dpa_perubahan, 0)) AS dpa_datin,
                    SUM(IF(bidang='DATIN', realisasi, 0)) AS realisasi_datin,
                    SUM(IF(bidang='DATIN', sisa_anggaran, 0)) AS sisa_datin FROM euis_realisasiDPA where bulan = 'MARET'
    ";
    $result = $this->db->query($sql);
        return $result->row();
    }

public function getSumEsdaMar(){
    $sql = "SELECT  SUM(IF(bidang='ESDA/INSOS', dpa_perubahan, 0)) AS dpa_esda,
                    SUM(IF(bidang='ESDA/INSOS', realisasi, 0)) AS realisasi_esda,
                    SUM(IF(bidang='ESDA/INSOS', sisa_anggaran, 0)) AS sisa_esda FROM euis_realisasiDPA where bulan = 'MARET'
    ";
    $result = $this->db->query($sql);
        return $result->row();
    }

public function getSumInsosMar(){
    $sql = "SELECT  SUM(IF(bidang='INSOS', dpa_perubahan, 0)) AS dpa_insos,
                    SUM(IF(bidang='INSOS', realisasi, 0)) AS realisasi_insos,
                    SUM(IF(bidang='INSOS', sisa_anggaran, 0)) AS sisa_insos FROM euis_realisasiDPA where bulan = 'MARET'
    ";
    $result = $this->db->query($sql);
        return $result->row();
    }

public function getSumBangpromMar(){
    $sql = "SELECT  SUM(IF(bidang='BANGPROM', dpa_perubahan, 0)) AS dpa_bangprom,
                    SUM(IF(bidang='BANGPROM', realisasi, 0)) AS realisasi_bangprom,
                    SUM(IF(bidang='BANGPROM', sisa_anggaran, 0)) AS sisa_bangprom FROM euis_realisasiDPA where bulan = 'MARET'
    ";
    $result = $this->db->query($sql);
        return $result->row();
    }

   public function getSumPengendalianMar(){
    $sql = "SELECT  COUNT(IF(bidang='PENGENDALIAN', persentase, 0)) AS persen_pengendalian,
                    SUM(IF(bidang='PENGENDALIAN', dpa_perubahan, 0)) AS dpa_pengendalian,
                    SUM(IF(bidang='PENGENDALIAN', realisasi, 0)) AS realisasi_pengendalian,
                    SUM(IF(bidang='PENGENDALIAN', persentase, 0)) AS persentase_pengendalian,
                    SUM(IF(bidang='PENGENDALIAN', sisa_anggaran, 0)) AS sisa_pengendalian FROM euis_realisasiDPA where bulan = 'MARET'
    ";

    $result = $this->db->query($sql);
        return $result->row(); 
    }

    // APRIL
    public function getSumAllApr(){
    $sql = "SELECT  SUM(dpa_perubahan) AS dpa_total,
            SUM(realisasi) AS real_total,
            SUM(sisa_anggaran) AS sisa_total FROM euis_realisasiDPA where bulan = 'APRIL'
    ";
    $result = $this->db->query($sql);
        return $result->row();
    }

    public function getSumSekreApr(){
    $sql = "SELECT  SUM(IF(bidang='SEKRETARIAT', dpa_perubahan, 0)) AS dpa_sekre,
                    SUM(IF(bidang='SEKRETARIAT', realisasi, 0)) AS realisasi_sekre,
                    SUM(IF(bidang='SEKRETARIAT', sisa_anggaran, 0)) AS sisa_sekre FROM euis_realisasiDPA where bulan = 'APRIL'
    ";
    $result = $this->db->query($sql);
        return $result->row();
    }
    public function getSumDatinApr(){
    $sql = "SELECT  SUM(IF(bidang='DATIN', dpa_perubahan, 0)) AS dpa_datin,
                    SUM(IF(bidang='DATIN', realisasi, 0)) AS realisasi_datin,
                    SUM(IF(bidang='DATIN', sisa_anggaran, 0)) AS sisa_datin FROM euis_realisasiDPA where bulan = 'APRIL'
    ";
    $result = $this->db->query($sql);
        return $result->row();
    }

public function getSumEsdaApr(){
    $sql = "SELECT  SUM(IF(bidang='ESDA/INSOS', dpa_perubahan, 0)) AS dpa_esda,
                    SUM(IF(bidang='ESDA/INSOS', realisasi, 0)) AS realisasi_esda,
                    SUM(IF(bidang='ESDA/INSOS', sisa_anggaran, 0)) AS sisa_esda FROM euis_realisasiDPA where bulan = 'APRIL'
    ";
    $result = $this->db->query($sql);
        return $result->row();
    }

public function getSumInsosApr(){
    $sql = "SELECT  SUM(IF(bidang='INSOS', dpa_perubahan, 0)) AS dpa_insos,
                    SUM(IF(bidang='INSOS', realisasi, 0)) AS realisasi_insos,
                    SUM(IF(bidang='INSOS', sisa_anggaran, 0)) AS sisa_insos FROM euis_realisasiDPA where bulan = 'APRIL'
    ";
    $result = $this->db->query($sql);
        return $result->row();
    }

public function getSumBangpromApr(){
    $sql = "SELECT  SUM(IF(bidang='BANGPROM', dpa_perubahan, 0)) AS dpa_bangprom,
                    SUM(IF(bidang='BANGPROM', realisasi, 0)) AS realisasi_bangprom,
                    SUM(IF(bidang='BANGPROM', sisa_anggaran, 0)) AS sisa_bangprom FROM euis_realisasiDPA where bulan = 'APRIL'
    ";
    $result = $this->db->query($sql);
        return $result->row();
    }

   public function getSumPengendalianApr(){
    $sql = "SELECT  COUNT(IF(bidang='PENGENDALIAN', persentase, 0)) AS persen_pengendalian,
                    SUM(IF(bidang='PENGENDALIAN', dpa_perubahan, 0)) AS dpa_pengendalian,
                    SUM(IF(bidang='PENGENDALIAN', realisasi, 0)) AS realisasi_pengendalian,
                    SUM(IF(bidang='PENGENDALIAN', persentase, 0)) AS persentase_pengendalian,
                    SUM(IF(bidang='PENGENDALIAN', sisa_anggaran, 0)) AS sisa_pengendalian FROM euis_realisasiDPA where bulan = 'APRIL'
    ";

    $result = $this->db->query($sql);
        return $result->row(); 
    }

    public function getSumAllMei(){
    $sql = "SELECT  SUM(dpa_perubahan) AS dpa_total,
            SUM(realisasi) AS real_total,
            SUM(sisa_anggaran) AS sisa_total FROM euis_realisasiDPA where bulan = 'MEI'
    ";
    $result = $this->db->query($sql);
        return $result->row();
    }

    public function getSumSekreMei(){
    $sql = "SELECT  SUM(IF(bidang='SEKRETARIAT', dpa_perubahan, 0)) AS dpa_sekre,
                    SUM(IF(bidang='SEKRETARIAT', realisasi, 0)) AS realisasi_sekre,
                    SUM(IF(bidang='SEKRETARIAT', sisa_anggaran, 0)) AS sisa_sekre FROM euis_realisasiDPA where bulan = 'MEI'
    ";
    $result = $this->db->query($sql);
        return $result->row();
    }
    public function getSumDatinMei(){
    $sql = "SELECT  SUM(IF(bidang='DATIN', dpa_perubahan, 0)) AS dpa_datin,
                    SUM(IF(bidang='DATIN', realisasi, 0)) AS realisasi_datin,
                    SUM(IF(bidang='DATIN', sisa_anggaran, 0)) AS sisa_datin FROM euis_realisasiDPA where bulan = 'MEI'
    ";
    $result = $this->db->query($sql);
        return $result->row();
    }

public function getSumEsdaMei(){
    $sql = "SELECT  SUM(IF(bidang='ESDA/INSOS', dpa_perubahan, 0)) AS dpa_esda,
                    SUM(IF(bidang='ESDA/INSOS', realisasi, 0)) AS realisasi_esda,
                    SUM(IF(bidang='ESDA/INSOS', sisa_anggaran, 0)) AS sisa_esda FROM euis_realisasiDPA where bulan = 'MEI'
    ";
    $result = $this->db->query($sql);
        return $result->row();
    }

public function getSumInsosMei(){
    $sql = "SELECT  SUM(IF(bidang='INSOS', dpa_perubahan, 0)) AS dpa_insos,
                    SUM(IF(bidang='INSOS', realisasi, 0)) AS realisasi_insos,
                    SUM(IF(bidang='INSOS', sisa_anggaran, 0)) AS sisa_insos FROM euis_realisasiDPA where bulan = 'MEI'
    ";
    $result = $this->db->query($sql);
        return $result->row();
    }

public function getSumBangpromMei(){
    $sql = "SELECT  SUM(IF(bidang='BANGPROM', dpa_perubahan, 0)) AS dpa_bangprom,
                    SUM(IF(bidang='BANGPROM', realisasi, 0)) AS realisasi_bangprom,
                    SUM(IF(bidang='BANGPROM', sisa_anggaran, 0)) AS sisa_bangprom FROM euis_realisasiDPA where bulan = 'MEI'
    ";
    $result = $this->db->query($sql);
        return $result->row();
    }

   public function getSumPengendalianMei(){
    $sql = "SELECT  COUNT(IF(bidang='PENGENDALIAN', persentase, 0)) AS persen_pengendalian,
                    SUM(IF(bidang='PENGENDALIAN', dpa_perubahan, 0)) AS dpa_pengendalian,
                    SUM(IF(bidang='PENGENDALIAN', realisasi, 0)) AS realisasi_pengendalian,
                    SUM(IF(bidang='PENGENDALIAN', persentase, 0)) AS persentase_pengendalian,
                    SUM(IF(bidang='PENGENDALIAN', sisa_anggaran, 0)) AS sisa_pengendalian FROM euis_realisasiDPA where bulan = 'MEI'
    ";

    $result = $this->db->query($sql);
        return $result->row(); 
    }

    public function getSumAllJuni(){
    $sql = "SELECT  SUM(dpa_perubahan) AS dpa_total,
            SUM(realisasi) AS real_total,
            SUM(sisa_anggaran) AS sisa_total FROM euis_realisasiDPA where bulan = 'JUNI'
    ";
    $result = $this->db->query($sql);
        return $result->row();
    }

    public function getSumSekreJuni(){
    $sql = "SELECT  SUM(IF(bidang='SEKRETARIAT', dpa_perubahan, 0)) AS dpa_sekre,
                    SUM(IF(bidang='SEKRETARIAT', realisasi, 0)) AS realisasi_sekre,
                    SUM(IF(bidang='SEKRETARIAT', sisa_anggaran, 0)) AS sisa_sekre FROM euis_realisasiDPA where bulan = 'JUNI'
    ";
    $result = $this->db->query($sql);
        return $result->row();
    }
    public function getSumDatinJuni(){
    $sql = "SELECT  SUM(IF(bidang='DATIN', dpa_perubahan, 0)) AS dpa_datin,
                    SUM(IF(bidang='DATIN', realisasi, 0)) AS realisasi_datin,
                    SUM(IF(bidang='DATIN', sisa_anggaran, 0)) AS sisa_datin FROM euis_realisasiDPA where bulan = 'JUNI'
    ";
    $result = $this->db->query($sql);
        return $result->row();
    }

public function getSumEsdaJuni(){
    $sql = "SELECT  SUM(IF(bidang='ESDA/INSOS', dpa_perubahan, 0)) AS dpa_esda,
                    SUM(IF(bidang='ESDA/INSOS', realisasi, 0)) AS realisasi_esda,
                    SUM(IF(bidang='ESDA/INSOS', sisa_anggaran, 0)) AS sisa_esda FROM euis_realisasiDPA where bulan = 'JUNI'
    ";
    $result = $this->db->query($sql);
        return $result->row();
    }

public function getSumInsosJuni(){
    $sql = "SELECT  SUM(IF(bidang='INSOS', dpa_perubahan, 0)) AS dpa_insos,
                    SUM(IF(bidang='INSOS', realisasi, 0)) AS realisasi_insos,
                    SUM(IF(bidang='INSOS', sisa_anggaran, 0)) AS sisa_insos FROM euis_realisasiDPA where bulan = 'JUNI'
    ";
    $result = $this->db->query($sql);
        return $result->row();
    }

public function getSumBangpromJuni(){
    $sql = "SELECT  SUM(IF(bidang='BANGPROM', dpa_perubahan, 0)) AS dpa_bangprom,
                    SUM(IF(bidang='BANGPROM', realisasi, 0)) AS realisasi_bangprom,
                    SUM(IF(bidang='BANGPROM', sisa_anggaran, 0)) AS sisa_bangprom FROM euis_realisasiDPA where bulan = 'JUNI'
    ";
    $result = $this->db->query($sql);
        return $result->row();
    }

   public function getSumPengendalianJuni(){
    $sql = "SELECT  COUNT(IF(bidang='PENGENDALIAN', persentase, 0)) AS persen_pengendalian,
                    SUM(IF(bidang='PENGENDALIAN', dpa_perubahan, 0)) AS dpa_pengendalian,
                    SUM(IF(bidang='PENGENDALIAN', realisasi, 0)) AS realisasi_pengendalian,
                    SUM(IF(bidang='PENGENDALIAN', persentase, 0)) AS persentase_pengendalian,
                    SUM(IF(bidang='PENGENDALIAN', sisa_anggaran, 0)) AS sisa_pengendalian FROM euis_realisasiDPA where bulan = 'JUNI'
    ";

    $result = $this->db->query($sql);
        return $result->row(); 
    }

    public function getSumAllJuli(){
    $sql = "SELECT  SUM(dpa_perubahan) AS dpa_total,
            SUM(realisasi) AS real_total,
            SUM(sisa_anggaran) AS sisa_total FROM euis_realisasiDPA where bulan = 'JULI'
    ";
    $result = $this->db->query($sql);
        return $result->row();
    }

    public function getSumSekreJuli(){
    $sql = "SELECT  SUM(IF(bidang='SEKRETARIAT', dpa_perubahan, 0)) AS dpa_sekre,
                    SUM(IF(bidang='SEKRETARIAT', realisasi, 0)) AS realisasi_sekre,
                    SUM(IF(bidang='SEKRETARIAT', sisa_anggaran, 0)) AS sisa_sekre FROM euis_realisasiDPA where bulan = 'JULI'
    ";
    $result = $this->db->query($sql);
        return $result->row();
    }
    public function getSumDatinJuli(){
    $sql = "SELECT  SUM(IF(bidang='DATIN', dpa_perubahan, 0)) AS dpa_datin,
                    SUM(IF(bidang='DATIN', realisasi, 0)) AS realisasi_datin,
                    SUM(IF(bidang='DATIN', sisa_anggaran, 0)) AS sisa_datin FROM euis_realisasiDPA where bulan = 'JULI'
    ";
    $result = $this->db->query($sql);
        return $result->row();
    }

public function getSumEsdaJuli(){
    $sql = "SELECT  SUM(IF(bidang='ESDA/INSOS', dpa_perubahan, 0)) AS dpa_esda,
                    SUM(IF(bidang='ESDA/INSOS', realisasi, 0)) AS realisasi_esda,
                    SUM(IF(bidang='ESDA/INSOS', sisa_anggaran, 0)) AS sisa_esda FROM euis_realisasiDPA where bulan = 'JULI'
    ";
    $result = $this->db->query($sql);
        return $result->row();
    }

public function getSumInsosJuli(){
    $sql = "SELECT  SUM(IF(bidang='INSOS', dpa_perubahan, 0)) AS dpa_insos,
                    SUM(IF(bidang='INSOS', realisasi, 0)) AS realisasi_insos,
                    SUM(IF(bidang='INSOS', sisa_anggaran, 0)) AS sisa_insos FROM euis_realisasiDPA where bulan = 'JULI'
    ";
    $result = $this->db->query($sql);
        return $result->row();
    }

public function getSumBangpromJuli(){
    $sql = "SELECT  SUM(IF(bidang='BANGPROM', dpa_perubahan, 0)) AS dpa_bangprom,
                    SUM(IF(bidang='BANGPROM', realisasi, 0)) AS realisasi_bangprom,
                    SUM(IF(bidang='BANGPROM', sisa_anggaran, 0)) AS sisa_bangprom FROM euis_realisasiDPA where bulan = 'JULI'
    ";
    $result = $this->db->query($sql);
        return $result->row();
    }

    function getSumPengendalianJuli(){
    $sql = "SELECT  COUNT(IF(bidang='PENGENDALIAN', persentase, 0)) AS persen_pengendalian,
                    SUM(IF(bidang='PENGENDALIAN', dpa_perubahan, 0)) AS dpa_pengendalian,
                    SUM(IF(bidang='PENGENDALIAN', realisasi, 0)) AS realisasi_pengendalian,
                    SUM(IF(bidang='PENGENDALIAN', persentase, 0)) AS persentase_pengendalian,
                    SUM(IF(bidang='PENGENDALIAN', sisa_anggaran, 0)) AS sisa_pengendalian FROM euis_realisasiDPA where bulan = 'JULI'
    ";

    $result = $this->db->query($sql);
        return $result->row(); 
    }

    public function getSumAllAgustus(){
    $sql = "SELECT  SUM(dpa_perubahan) AS dpa_total,
            SUM(realisasi) AS real_total,
            SUM(sisa_anggaran) AS sisa_total FROM euis_realisasiDPA where bulan = 'AGUSTUS'
    ";
    $result = $this->db->query($sql);
        return $result->row();
    }

    public function getSumSekreAgustus(){
    $sql = "SELECT  SUM(IF(bidang='SEKRETARIAT', dpa_perubahan, 0)) AS dpa_sekre,
                    SUM(IF(bidang='SEKRETARIAT', realisasi, 0)) AS realisasi_sekre,
                    SUM(IF(bidang='SEKRETARIAT', sisa_anggaran, 0)) AS sisa_sekre FROM euis_realisasiDPA where bulan = 'AGUSTUS'
    ";
    $result = $this->db->query($sql);
        return $result->row();
    }
    public function getSumDatinAgustus(){
    $sql = "SELECT  SUM(IF(bidang='DATIN', dpa_perubahan, 0)) AS dpa_datin,
                    SUM(IF(bidang='DATIN', realisasi, 0)) AS realisasi_datin,
                    SUM(IF(bidang='DATIN', sisa_anggaran, 0)) AS sisa_datin FROM euis_realisasiDPA where bulan = 'AGUSTUS'
    ";
    $result = $this->db->query($sql);
        return $result->row();
    }

public function getSumEsdaAgustus(){
    $sql = "SELECT  SUM(IF(bidang='ESDA/INSOS', dpa_perubahan, 0)) AS dpa_esda,
                    SUM(IF(bidang='ESDA/INSOS', realisasi, 0)) AS realisasi_esda,
                    SUM(IF(bidang='ESDA/INSOS', sisa_anggaran, 0)) AS sisa_esda FROM euis_realisasiDPA where bulan = 'AGUSTUS'
    ";
    $result = $this->db->query($sql);
        return $result->row();
    }

public function getSumInsosAgustus(){
    $sql = "SELECT  SUM(IF(bidang='INSOS', dpa_perubahan, 0)) AS dpa_insos,
                    SUM(IF(bidang='INSOS', realisasi, 0)) AS realisasi_insos,
                    SUM(IF(bidang='INSOS', sisa_anggaran, 0)) AS sisa_insos FROM euis_realisasiDPA where bulan = 'AGUSTUS'
    ";
    $result = $this->db->query($sql);
        return $result->row();
    }

public function getSumBangpromAgustus(){
    $sql = "SELECT  SUM(IF(bidang='BANGPROM', dpa_perubahan, 0)) AS dpa_bangprom,
                    SUM(IF(bidang='BANGPROM', realisasi, 0)) AS realisasi_bangprom,
                    SUM(IF(bidang='BANGPROM', sisa_anggaran, 0)) AS sisa_bangprom FROM euis_realisasiDPA where bulan = 'AGUSTUS'
    ";
    $result = $this->db->query($sql);
        return $result->row();
    }

   public function getSumPengendalianAgustus(){
    $sql = "SELECT  COUNT(IF(bidang='PENGENDALIAN', persentase, 0)) AS persen_pengendalian,
                    SUM(IF(bidang='PENGENDALIAN', dpa_perubahan, 0)) AS dpa_pengendalian,
                    SUM(IF(bidang='PENGENDALIAN', realisasi, 0)) AS realisasi_pengendalian,
                    SUM(IF(bidang='PENGENDALIAN', persentase, 0)) AS persentase_pengendalian,
                    SUM(IF(bidang='PENGENDALIAN', sisa_anggaran, 0)) AS sisa_pengendalian FROM euis_realisasiDPA where bulan = 'AGUSTUS'
    ";

    $result = $this->db->query($sql);
        return $result->row(); 
    }

    //September
    
    public function getSumAllSeptember(){
    $sql = "SELECT  SUM(dpa_perubahan) AS dpa_total,
            SUM(realisasi) AS real_total,
            SUM(sisa_anggaran) AS sisa_total FROM euis_realisasiDPA where bulan = 'SEPTEMBER'
    ";
    $result = $this->db->query($sql);
        return $result->row();
    }

    public function getSumSekreSeptember(){
    $sql = "SELECT  SUM(IF(bidang='SEKRETARIAT', dpa_perubahan, 0)) AS dpa_sekre,
                    SUM(IF(bidang='SEKRETARIAT', realisasi, 0)) AS realisasi_sekre,
                    SUM(IF(bidang='SEKRETARIAT', sisa_anggaran, 0)) AS sisa_sekre FROM euis_realisasiDPA where bulan = 'SEPTEMBER'
    ";
    $result = $this->db->query($sql);
        return $result->row();
    }
    public function getSumDatinSeptember(){
    $sql = "SELECT  SUM(IF(bidang='DATIN', dpa_perubahan, 0)) AS dpa_datin,
                    SUM(IF(bidang='DATIN', realisasi, 0)) AS realisasi_datin,
                    SUM(IF(bidang='DATIN', sisa_anggaran, 0)) AS sisa_datin FROM euis_realisasiDPA where bulan = 'SEPTEMBER'
    ";
    $result = $this->db->query($sql);
        return $result->row();
    }

public function getSumEsdaSeptember(){
    $sql = "SELECT  SUM(IF(bidang='ESDA/INSOS', dpa_perubahan, 0)) AS dpa_esda,
                    SUM(IF(bidang='ESDA/INSOS', realisasi, 0)) AS realisasi_esda,
                    SUM(IF(bidang='ESDA/INSOS', sisa_anggaran, 0)) AS sisa_esda FROM euis_realisasiDPA where bulan = 'SEPTEMBER'
    ";
    $result = $this->db->query($sql);
        return $result->row();
    }

public function getSumInsosSeptember(){
    $sql = "SELECT  SUM(IF(bidang='INSOS', dpa_perubahan, 0)) AS dpa_insos,
                    SUM(IF(bidang='INSOS', realisasi, 0)) AS realisasi_insos,
                    SUM(IF(bidang='INSOS', sisa_anggaran, 0)) AS sisa_insos FROM euis_realisasiDPA where bulan = 'SEPTEMBER'
    ";
    $result = $this->db->query($sql);
        return $result->row();
    }

public function getSumBangpromSeptember(){
    $sql = "SELECT  SUM(IF(bidang='BANGPROM', dpa_perubahan, 0)) AS dpa_bangprom,
                    SUM(IF(bidang='BANGPROM', realisasi, 0)) AS realisasi_bangprom,
                    SUM(IF(bidang='BANGPROM', sisa_anggaran, 0)) AS sisa_bangprom FROM euis_realisasiDPA where bulan = 'SEPTEMBER'
    ";
    $result = $this->db->query($sql);
        return $result->row();
    }

   public function getSumPengendalianSeptember(){
    $sql = "SELECT  COUNT(IF(bidang='PENGENDALIAN', persentase, 0)) AS persen_pengendalian,
                    SUM(IF(bidang='PENGENDALIAN', dpa_perubahan, 0)) AS dpa_pengendalian,
                    SUM(IF(bidang='PENGENDALIAN', realisasi, 0)) AS realisasi_pengendalian,
                    SUM(IF(bidang='PENGENDALIAN', persentase, 0)) AS persentase_pengendalian,
                    SUM(IF(bidang='PENGENDALIAN', sisa_anggaran, 0)) AS sisa_pengendalian FROM euis_realisasiDPA where bulan = 'SEPTEMBER'
    ";

    $result = $this->db->query($sql);
        return $result->row(); 
    }

    //September

    public function getSumAllOktober(){
    $sql = "SELECT  SUM(dpa_perubahan) AS dpa_total,
            SUM(realisasi) AS real_total,
            SUM(sisa_anggaran) AS sisa_total FROM euis_realisasiDPA where bulan = 'OKTOBER'
    ";
    $result = $this->db->query($sql);
        return $result->row();
    }

    public function getSumSekreOktober(){
    $sql = "SELECT  SUM(IF(bidang='SEKRETARIAT', dpa_perubahan, 0)) AS dpa_sekre,
                    SUM(IF(bidang='SEKRETARIAT', realisasi, 0)) AS realisasi_sekre,
                    SUM(IF(bidang='SEKRETARIAT', sisa_anggaran, 0)) AS sisa_sekre FROM euis_realisasiDPA where bulan = 'OKTOBER'
    ";
    $result = $this->db->query($sql);
        return $result->row();
    }
    public function getSumDatinOktober(){
    $sql = "SELECT  SUM(IF(bidang='DATIN', dpa_perubahan, 0)) AS dpa_datin,
                    SUM(IF(bidang='DATIN', realisasi, 0)) AS realisasi_datin,
                    SUM(IF(bidang='DATIN', sisa_anggaran, 0)) AS sisa_datin FROM euis_realisasiDPA where bulan = 'OKTOBER'
    ";
    $result = $this->db->query($sql);
        return $result->row();
    }

public function getSumEsdaOktober(){
    $sql = "SELECT  SUM(IF(bidang='ESDA/INSOS', dpa_perubahan, 0)) AS dpa_esda,
                    SUM(IF(bidang='ESDA/INSOS', realisasi, 0)) AS realisasi_esda,
                    SUM(IF(bidang='ESDA/INSOS', sisa_anggaran, 0)) AS sisa_esda FROM euis_realisasiDPA where bulan = 'OKTOBER'
    ";
    $result = $this->db->query($sql);
        return $result->row();
    }

public function getSumInsosOktober(){
    $sql = "SELECT  SUM(IF(bidang='INSOS', dpa_perubahan, 0)) AS dpa_insos,
                    SUM(IF(bidang='INSOS', realisasi, 0)) AS realisasi_insos,
                    SUM(IF(bidang='INSOS', sisa_anggaran, 0)) AS sisa_insos FROM euis_realisasiDPA where bulan = 'OKTOBER'
    ";
    $result = $this->db->query($sql);
        return $result->row();
    }

public function getSumBangpromOktober(){
    $sql = "SELECT  SUM(IF(bidang='BANGPROM', dpa_perubahan, 0)) AS dpa_bangprom,
                    SUM(IF(bidang='BANGPROM', realisasi, 0)) AS realisasi_bangprom,
                    SUM(IF(bidang='BANGPROM', sisa_anggaran, 0)) AS sisa_bangprom FROM euis_realisasiDPA where bulan = 'OKTOBER'
    ";
    $result = $this->db->query($sql);
        return $result->row();
    }

   public function getSumPengendalianOktober(){
    $sql = "SELECT  COUNT(IF(bidang='PENGENDALIAN', persentase, 0)) AS persen_pengendalian,
                    SUM(IF(bidang='PENGENDALIAN', dpa_perubahan, 0)) AS dpa_pengendalian,
                    SUM(IF(bidang='PENGENDALIAN', realisasi, 0)) AS realisasi_pengendalian,
                    SUM(IF(bidang='PENGENDALIAN', persentase, 0)) AS persentase_pengendalian,
                    SUM(IF(bidang='PENGENDALIAN', sisa_anggaran, 0)) AS sisa_pengendalian FROM euis_realisasiDPA where bulan = 'OKTOBER'
    ";

    $result = $this->db->query($sql);
        return $result->row(); 
    }

    public function getById($id)
    {
        return $this->db->get_where($this->_table, ["id" => $id])->row();
    }

    public function delete($id)
    {
        return $this->db->delete($this->_table, array("id" => $id));
	}
	
     public function getTgl()
    {
         return $this->db->query(" SELECT * FROM euis_realisasiDPAtanggal where id = '1' ")->row();
    }

    function get_subBulan($bulan){
        $hasil=$this->db->query("SELECT * FROM euis_realisasiDPA WHERE bulan='$bulan'");
        return $hasil->result();
    }
	
}
