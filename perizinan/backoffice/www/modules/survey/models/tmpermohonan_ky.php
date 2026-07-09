<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Description of survey_mdl class
 *
 * @author  Dichi Al Faridi
 * @since   1.0
 *
 */

class tmpermohonan_ky extends DataMapper {

    var $table = 'tmpermohonan_ky';

    var $has_one = array('tmpermohonan');

    public function __construct() {
        parent::__construct();
    }
}

// This is the end of survey_mdl class