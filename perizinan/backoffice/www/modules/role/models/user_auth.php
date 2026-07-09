<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Description of role_mdl class
 *
 * @author  Dichi Al Faridi
 * @since   1.0
 *
 */

class user_auth extends DataMapper {

    var $table = 'user_auth';
    var $has_many = array('tralur_perizinan', 'user', 'user_user_auth');

    public function __construct() {
        parent::__construct();
    }

}

// This is the end of role_mdl class
