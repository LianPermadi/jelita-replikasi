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
class Tm_pemohon extends DataMapper {

    var $table = 'tm_pemohon';
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

    function get_urut(){
        $sql="SELECT MAX(urut) as urut FROM tm_pemohon";
        $query=$this->db->query($sql);
        return $query->row();
    }

}

?>
