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
class Tmjajak extends DataMapper {

    var $table = 'tmjajak';
    var $key = 'c_jajak';

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
    
    function nonactive_all() {
        $sql="update tmjajak set STATUS='0'";
        $query=$this->db->query($sql);}
    

    function delete($id) {
        $this->db->where($this->key, $id);
        $this->db->delete($this->table);
    }
    
    
    function get_max(){
        $sql="select max(C_JAJAK)as max from tmjajak";
        $query=$this->db->query($sql);
        return $query->row();
    }
}

?>
