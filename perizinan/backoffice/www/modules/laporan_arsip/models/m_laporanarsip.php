<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class M_laporanarsip extends Model {


    function databidang() {
		$this->db->select('n_sektor');
		$this->db->from('trsektor');
		//$this->db->where('tmpegawai_user.user_id',$userid);
  		$ambildata = $this->db->get();

		if($ambildata->num_rows() > 0) {
		    foreach ($ambildata->result() as $data) {
		    $list_bidang[] = $data;
		}
		    return $list_bidang;
		}
    }

    function dataarsip($bidang,$tahun,$jenisizin) {
		$this->db->select('a.kd_indeks , a.indeks , i.n_sektor , e.n_perusahaan , g.no_surat , c.desc_arsip , a.indeks');
		$this->db->from('trperizinan a');
		$this->db->join('tmpermohonan_trperizinan b' , 'a.id = b.trperizinan_id','left');
		$this->db->join('tmpermohonan  c' , 'b.tmpermohonan_id = c.id ','left');
		$this->db->join('tmpermohonan_tmperusahaan d' , 'b.tmpermohonan_id = d.tmpermohonan_id','left');
		$this->db->join('tmperusahaan e' , 'd.tmperusahaan_id = e.id','left');
		$this->db->join('tmpermohonan_tmsk f' , 'c.id = f.tmpermohonan_id','left');
		$this->db->join('tmsk g' , 'f.tmsk_id = g.id','left');
		$this->db->join('trperizinan_trsektor h' , 'a.id = h.trperizinan_id','left');
		$this->db->join('trsektor i' , 'h.trsektor_id = i.id','left');
		//$this->db->where('g.no_surat <>','Belum Penomoran');
		$this->db->where('g.no_surat <>','Ditolak');
		$this->db->where('i.n_sektor',$bidang);
		$this->db->like('c.desc_arsip',$tahun);
		$this->db->like('a.indeks',$jenisizin);
  			
  		$ambildata = $this->db->get();

		if($ambildata->num_rows() > 0) {
		    foreach ($ambildata->result() as $data) {
		    $list_arsip[] = $data;
		}
		    return $list_arsip;
		}
    }


}
