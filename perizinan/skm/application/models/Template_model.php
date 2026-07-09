<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Template_model extends CI_Model
{
    public function tampilCustomTabel($kolom, $tabel, $where = '')
    {
        if ($where) $this->db->where($where);
        $this->db->select($kolom);
        $q = $this->db->get($tabel)->result();
        // render jadi HTML select/options atau komponen lain sesuai kebutuhan view
        $html = '';
        foreach ($q as $row) {
            $val = isset($row->$kolom) ? $row->$kolom : '';
            $html .= '<option value="'.htmlspecialchars($val, ENT_QUOTES, 'UTF-8').'">'.$val.'</option>';
        }
        return $html;
    }
}
