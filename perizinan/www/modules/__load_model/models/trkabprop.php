<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of manipulasi
 *
 * @author Obi
 */
class trkabprop extends DataMapper {

    var $table = 'trkabprop';
    var $key = 'id';

    function __construct() {
        parent::__construct();
    }

    //put your code here
    function insert($form) {
        $this->db->insert($this->table, $form);
    }

    function update($id, $form) {
        $this->db->where($this->key, $id);
        $this->db->update($this->table, $form);
    }

    function delete($id) {
        $this->db->where($this->key, $id);
        $this->db->delete($this->table);
    }
    //===========================================================================

    function sql(){
        $sql="
            SELECT t2.* FROM
            trkabupaten_trpropinsi as t1
            JOIN trkabupaten as t2 on t1.trkabupaten_id=t2.id
            JOIN trpropinsi as t3 on t1.trpropinsi_id=t3.id
            ";
        return $sql;
    }

    function get_result($id){
        $sql=$this->sql();
        $sql.="where t3.id = $id";
        $query = $this->db->query($sql);
        return $query->result();
    }
    
    

    function get_row($id){
        $sql=$this->sql();
        $sql.="where t3.id = $id";
        $query = $this->db->query($sql);
        return $query->row();
    }
    function get_jumlah_data($id){
        $sql=$this->sql();
        $sql.="where t3.id = $id";
        $query = $this->db->query($sql);
        return $query->num_rows();
    }

}

?>
