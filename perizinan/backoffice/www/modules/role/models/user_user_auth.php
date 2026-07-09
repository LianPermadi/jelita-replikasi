<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Description of role_mdl class
 *
 * @author  PBS
 * @since   29/01/2014
 *
 */

class user_user_auth extends DataMapper {

    var $table = 'user_user_auth';
    var $has_many = array('user_auth');

    public function __construct() {
        parent::__construct();
    }
}

// This is the end of role_mdl class
