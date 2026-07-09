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
class Tmwcm extends DataMapper {

    var $table = 'tmwcm';
    var $key = 'C_ID';

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
    
    
    function get_max(){
        $sql="select max(C_JAJAK)as max from tmjajak";
        $query=$this->db->query($sql);
        return $query->row();
    }
}

?>
