<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');



/**
 * Class Admin_Controller
 */
class Admin_Controller extends User_Controller
{
    public function __construct()
    {
        parent::__construct('user_type', 1);
    }
}
