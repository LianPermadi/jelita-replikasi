<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Description of Pendaftaran class
 *
 * @author agusnur
 * Created : 06 Aug 2010
 *
 */

class trkelompok_perizinan extends DataMapper {

    var $table = 'trkelompok_perizinan';

    var $has_many = array('trperizinan');

    public function __construct() {
        parent::__construct();
    }

}

// This is the end of user class
