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
class Tmbg extends DataMapper {

    var $table = 'tmbg';
    var $key = 'link_id';

    function __construct() {
        parent::__construct();
    }

    //put your code here
    function insert($form) {
        $this->db->insert($this->table, $form);
    }

    function delete($id) {
        $this->db->where($this->key, $id);
        $this->db->delete($this->table);
    }
    
    function update($id, $form) {
        $this->db->where($this->key, $id);
        $this->db->update($this->table, $form);
    }    
    
    function update_all($form) {
        $this->db->update($this->table, $form);
    }       


}

?>
