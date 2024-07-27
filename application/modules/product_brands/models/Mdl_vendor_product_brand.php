<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class Mdl_Mech_Car_Brand_Details
 */
class Mdl_vendor_product_brand extends Response_Model
{
    public $table = 'vendor_product_brand';
    public $primary_key = 'vendor_product_brand.vpb.id';
	public $date_created_field = 'created_on';
    public $date_modified_field = 'modified_on';

    public function default_select()
    {
        $this->db->select('SQL_CALC_FOUND_ROWS *', false);
    }
	public function default_join()
    {
    //    $this->db->join('mechanic_service_category_list uad', 'uad.service_cat_id = mechanic_service_category_items.service_category_id', 'left');
    }

    public function default_where()
    {
        $this->db->where('vendor_product_brand.status', 'A');
    }

    /**
     * @return array
     */
    public function validation_rules()
    {
        return array(
            'prd_brand_name' => array(
                'field' => 'prd_brand_name',
                'label' => 'Product Brand',
                'rules' => ''
            ),
            '_mm_csrf' => array(
                'field' => '_mm_csrf'
            )
        );
    }
	
	public function db_array()
    {
        $db_array = parent::db_array();
		unset($db_array['_mm_csrf']);
        return $db_array;
    }

	public function save($id = null, $db_array = null)
    {
        $db_array = ($db_array) ? $db_array : $this->db_array();

        $id = parent::save($id, $db_array);

        return $id;
    }
}
