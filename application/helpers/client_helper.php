<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');



/**
 * @param object $client
 * @return string
 */
function format_client($client)
{
    if ($client->client_surname != "") {
        return $client->client_name . " " . $client->client_surname;
    }

    return $client->client_name;
}

/**
 * @param string $gender
 * @return string
 */
function format_gender($gender)
{
    if ($gender == 0) {
        return trans('gender_male');
    }

    if ($gender == 1) {
        return trans('gender_female');
    }

    return trans('gender_other');
}

function getCustomerSupplierName($entity_id,$entity_type)
{
	$CI = get_instance();
	if($entity_type == "invoice" || $entity_type == "jobcard"){
		$CI->load->model('clients/mdl_clients', 'cli');
    	$values = $CI->cli->where_in('client_id', $entity_id)->get()->row();
		$name = $values->client_name;
	}elseif($entity_type == "purchase"){
		$CI->load->model('suppliers/mdl_suppliers', 'sup');
    	$values = $CI->sup->where_in('mech_suppliers.supplier_id', $entity_id)->get()->row();
		$name = $values->supplier_name;
	}elseif($entity_type == "expense"){
		$CI->load->model('mech_employee/mdl_mech_employee', 'emp');
    	$values = $CI->emp->where_in('mech_employee.employee_id', $entity_id)->get()->row();
		$name = $values->employee_name;
	}
    return $name;
}