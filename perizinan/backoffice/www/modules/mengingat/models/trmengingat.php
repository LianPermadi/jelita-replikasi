<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Description of trmemperhatikan class
 *
 * @author  agusnur
 * Created : 19 Dec 2010
 *
 */

class trmemperhatikan extends DataMapper {

    var $table = "trmemperhatikan";
    var $has_many = array('trperizinan');

    public function __construct() {
        parent::__construct();
    }

}
