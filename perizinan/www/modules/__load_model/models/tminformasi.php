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
class Tminformasi extends DataMapper {

    var $table = 'informasi';
    var $key = 'id_informasi';

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


}

?>
