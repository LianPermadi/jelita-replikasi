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
class Tmjajak_det extends DataMapper {

    var $table = 'tmpiljajak';
    var $key = 'C_PILJAJAK';

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
        $this->db->where('C_JAJAK', $id);
        $this->db->delete($this->table);
    }
    
   

}

?>
