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
class Tmlink extends DataMapper {

    var $table = 'tmwcm';
    var $key = 'C_ID';

    function __construct() {
        parent::__construct();
    }

    
    function update($id, $form) {
        $this->db->where($this->key, $id);
        $this->db->update($this->table, $form);
    }    


    
    


}

?>
