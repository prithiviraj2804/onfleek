<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');



/**
 * Class Mdl_Versions
 */
class Mdl_Versions extends Response_Model
{
    public $table = 'ip_versions';
    public $primary_key = 'ip_versions.version_id';

    public function default_select()
    {
        $this->db->select('SQL_CALC_FOUND_ROWS *', false);
    }

    public function default_order_by()
    {
        $this->db->order_by('ip_versions.version_date_applied DESC, ip_versions.version_file DESC');
    }

}
