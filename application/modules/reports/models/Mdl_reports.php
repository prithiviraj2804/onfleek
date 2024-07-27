<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mdl_Reports extends CI_Model
{
    public function customer_due_report($from_date = null, $to_date = null, $branch_id = null) {
        $workshop_id = $this->session->userdata('work_shop_id');
        if ($from_date and $to_date) {
            $from_date = date_to_mysql($from_date);
            $to_date = date_to_mysql($to_date);
            if($this->session->userdata('plan_type') != 3){ 
                if($branch_id == 'ALL'){
                    $query = $this->db->query("SELECT SUM(inv.grand_total) AS grand_total, SUM(inv.total_due_amount) AS total_due_amount, SUM(inv.total_paid_amount) AS total_paid_amount, cli.client_id, cli.client_name, inv.invoice_date FROM mech_invoice AS inv INNER JOIN mech_clients cli ON cli.client_id = inv.customer_id WHERE inv.invoice_date BETWEEN '".$from_date."' and '".$to_date."' and inv.workshop_id='".$this->session->userdata('work_shop_id')."' AND inv.customer_id != 0 AND inv.status = 'A' AND inv.invoice_status NOT IN('D') AND total_due_amount > 0 GROUP BY inv.invoice_date,inv.customer_id");	
                }else{
                    $query = $this->db->query("SELECT SUM(inv.grand_total) AS grand_total, SUM(inv.total_due_amount) AS total_due_amount, SUM(inv.total_paid_amount) AS total_paid_amount, cli.client_id, cli.client_name, inv.invoice_date FROM mech_invoice AS inv INNER JOIN mech_clients cli ON cli.client_id = inv.customer_id WHERE inv.invoice_date BETWEEN '".$from_date."' and '".$to_date."' and inv.workshop_id='".$this->session->userdata('work_shop_id')."' AND inv.branch_id ='".$branch_id."' AND inv.customer_id != 0 AND inv.status = 'A' AND inv.invoice_status NOT IN('D') AND total_due_amount > 0 GROUP BY inv.invoice_date,inv.customer_id");	
                }
            }else{
                if($branch_id == 'ALL'){
                    $query = $this->db->query("SELECT SUM(inv.grand_total) AS grand_total, SUM(inv.total_due_amount) AS total_due_amount, SUM(inv.total_paid_amount) AS total_paid_amount, cli.client_id, cli.client_name, inv.invoice_date FROM spare_invoice AS inv INNER JOIN mech_clients cli ON cli.client_id = inv.customer_id WHERE inv.invoice_date BETWEEN '".$from_date."' and '".$to_date."' and inv.workshop_id='".$this->session->userdata('work_shop_id')."' AND inv.customer_id != 0 AND inv.status = 'A' AND inv.invoice_status NOT IN('D') AND total_due_amount > 0 GROUP BY inv.invoice_date,inv.customer_id");	
                }else{
                    $query = $this->db->query("SELECT SUM(inv.grand_total) AS grand_total, SUM(inv.total_due_amount) AS total_due_amount, SUM(inv.total_paid_amount) AS total_paid_amount, cli.client_id, cli.client_name, inv.invoice_date FROM spare_invoice AS inv INNER JOIN mech_clients cli ON cli.client_id = inv.customer_id WHERE inv.invoice_date BETWEEN '".$from_date."' and '".$to_date."' and inv.workshop_id='".$this->session->userdata('work_shop_id')."' AND inv.branch_id ='".$branch_id."' AND inv.customer_id != 0 AND inv.status = 'A' AND inv.invoice_status NOT IN('D') AND total_due_amount > 0 GROUP BY inv.invoice_date,inv.customer_id");	
                }
            }
            return $query->result();
        }	
    }
    //vehicle history
    public function vehicle_service_history($vehicle_no = null){

        $result = array();
        $workshop_id = $this->session->userdata('work_shop_id');
        if ($vehicle_no) {

            $invoice_customer_list = array();

            $this->db->select('mech_owner_car_list.car_list_id,mech_owner_car_list.workshop_id,
            mech_owner_car_list.w_branch_id,mech_owner_car_list.owner_id,mech_owner_car_list.entity_type,
            mech_owner_car_list.model_type,mech_owner_car_list.car_reg_no,mech_owner_car_list.car_brand_id,
            mech_owner_car_list.car_brand_model_id,mech_owner_car_list.car_model_year,mech_owner_car_list.car_variant,
            mech_owner_car_list.fuel_type,mech_owner_car_list.engine_number,mech_owner_car_list.vin,mech_owner_car_list.total_mileage,mech_owner_car_list.daily_mileage,
            mech_owner_car_list.engine_oil_type,mech_owner_car_list.steering_type,mech_owner_car_list.air_conditioning,
            mech_owner_car_list.car_drive_type,mech_owner_car_list.transmission_type');

            $this->db->from('mech_owner_car_list');

            // cb.brand_name,cm.model_name,cv.variant_name,cl.client_name,cl.client_contact_no,cl.client_email_id,add.customer_street_1,add.customer_street_2,
            // add.area,add.zip_code,city.city_name,state.state_name,country.name
            // $this->db->join('mech_car_brand_details cb', 'cb.brand_id=mech_owner_car_list.car_brand_id', 'LEFT');
            // $this->db->join('mech_car_brand_models_details cm', 'cm.model_id = mech_owner_car_list.car_brand_model_id', 'LEFT');
            // $this->db->join('mech_brand_model_variants cv', 'cv.brand_model_variant_id = mech_owner_car_list.car_variant', 'LEFT');
            // $this->db->join('mech_clients cl', 'cl.client_id = mech_owner_car_list.owner_id', 'LEFT');
            // $this->db->join('mech_user_address as add','add.user_address_id = cl.client_id','LEFT');
            // $this->db->join('city_lookup as city','city.city_id = add.customer_city','LEFT');
            // $this->db->join('mech_state_list as state','state.state_id = add.customer_state','LEFT');
            // $this->db->join('country_lookup as country','country.id = add.customer_country','LEFT');

            

            $this->db->where('mech_owner_car_list.status', 1);    
            $this->db->where('mech_owner_car_list.car_reg_no',$vehicle_no);
            $this->db->where('mech_owner_car_list.workshop_id',$workshop_id);

            $vehicle_info = $this->db->get()->result(); 

            foreach($vehicle_info as $vehicle_info_key => $vehicle_info_lists){

                $invoice_customer_list = $this->mdl_mech_invoice->where('mech_invoice.customer_id',$vehicle_info_lists->owner_id)->where('mech_invoice.customer_car_id',$vehicle_info_lists->car_list_id)->where('mech_invoice.workshop_id',$workshop_id)->where('mech_invoice.status','A')->order_by('invoice_id','desc')->get()->result();

                foreach($invoice_customer_list as $invoice_customer_key => $invoice){
                    
                $invoice_customer_list[$invoice_customer_key]->customer_details = $this->mdl_clients->get_by_id($invoice->customer_id);
                $invoice_customer_list[$invoice_customer_key]->service_list = $this->mdl_mech_invoice->get_user_quote_service_item($invoice->invoice_id, $invoice->customer_id);
                $invoice_customer_list[$invoice_customer_key]->service_package_list = $this->mdl_mech_invoice->get_user_quote_service_package_item($invoice->invoice_id, $invoice->customer_id);
                $invoice_customer_list[$invoice_customer_key]->product_list = $this->mdl_mech_invoice->get_user_quote_product_item($invoice->invoice_id, $invoice->customer_id);
                    if(!empty($invoice)){
                        array_push($result,$invoice);
                    }
                }

            }
        }       
        return $result;
    }
    public function service_by_summary($from_date = null, $to_date = null, $branch_id = null)
    {
        $workshop_id = $this->session->userdata('work_shop_id');
        if ($from_date and $to_date) {
            $from_date = date_to_mysql($from_date);
            $to_date = date_to_mysql($to_date);
            if($branch_id == 'ALL'){
                $query = $this->db->query("SELECT count(customer_car_id) as vehiclecount,SUM(item.item_total_amount) as total_amount, item.is_from, inv.invoice_id, inv.invoice_date, cat.service_item_name FROM mech_invoice as inv left JOIN mech_invoice_item item ON item.invoice_id = inv.invoice_id left join mech_service_item_dtls cat ON cat.msim_id = item.service_item WHERE inv.invoice_date BETWEEN '".$from_date."' AND '".$to_date."' AND inv.workshop_id = '".$workshop_id."' AND inv.status = 'A' AND inv.invoice_status NOT IN('D') AND item.is_from = 'invoice_service' group by inv.invoice_date,item.service_item ORDER BY invoice_date ASC");
            }else{
                $query = $this->db->query("SELECT count(customer_car_id) as vehiclecount,SUM(item.item_total_amount) as total_amount, item.is_from, inv.invoice_id, inv.invoice_date, cat.service_item_name FROM mech_invoice as inv left JOIN mech_invoice_item item ON item.invoice_id = inv.invoice_id left join mech_service_item_dtls cat ON cat.msim_id = item.service_item WHERE inv.invoice_date BETWEEN '".$from_date."' AND '".$to_date."' AND inv.workshop_id = '".$workshop_id."' AND  inv.branch_id = '".$branch_id."' AND item.is_from = 'invoice_service' group by inv.invoice_date,item.service_item ORDER BY invoice_date ASC");
            }
            return $query->result();
        }
    } 
    
    public function sales_by_summary($from_date = null, $to_date = null, $branch_id = null)
    {
        $workshop_id = $this->session->userdata('work_shop_id');
        if ($from_date and $to_date) {
            $from_date = date_to_mysql($from_date);
            $to_date = date_to_mysql($to_date);
            if($this->session->userdata('plan_type') != 3){
                if($branch_id == 'ALL'){
                    $query = $this->db->query("SELECT invoice_id, invoice_date, count(invoice_id) as cnt, SUM(grand_total) as total FROM mech_invoice WHERE invoice_date BETWEEN '".$from_date."' AND '".$to_date."' AND workshop_id = '".$workshop_id."' AND status = 'A' AND invoice_status NOT IN('D') GROUP BY invoice_date ORDER BY invoice_date ASC");
                }else{
                    $query = $this->db->query("SELECT invoice_id, invoice_date, count(invoice_id) as cnt, SUM(grand_total) as total FROM mech_invoice WHERE invoice_date BETWEEN '".$from_date."' AND '".$to_date."' AND  branch_id = '".$branch_id."' AND workshop_id = '".$workshop_id."' AND status = 'A' AND invoice_status NOT IN('D') GROUP BY invoice_date ORDER BY invoice_date ASC");
                }
            }else{
                if($branch_id == 'ALL'){
                    $query = $this->db->query("SELECT invoice_id, invoice_date, count(invoice_id) as cnt, SUM(grand_total) as total FROM spare_invoice WHERE invoice_date BETWEEN '".$from_date."' AND '".$to_date."' AND workshop_id = '".$workshop_id."' AND status = 'A' AND invoice_status NOT IN('D') GROUP BY invoice_date ORDER BY invoice_date ASC");
                }else{
                    $query = $this->db->query("SELECT invoice_id, invoice_date, count(invoice_id) as cnt, SUM(grand_total) as total FROM spare_invoice WHERE invoice_date BETWEEN '".$from_date."' AND '".$to_date."' AND  branch_id = '".$branch_id."' AND workshop_id = '".$workshop_id."' AND status = 'A' AND invoice_status NOT IN('D') GROUP BY invoice_date ORDER BY invoice_date ASC");
                }
            }
            
            return $query->result();
        }
    } 

    public function sales_by_product($from_date = null, $to_date = null, $branch_id = null) {
        $workshop_id = $this->session->userdata('work_shop_id');
        if ($from_date and $to_date) {
            $from_date = date_to_mysql($from_date);
            $to_date = date_to_mysql($to_date);
            if($this->session->userdata('plan_type') != 3){ 
                if($branch_id == 'ALL'){
                    $query = $this->db->query("select sum(items.item_qty) as qty, sum(items.item_total_amount) as amt, sum(items.igst_amount) as igst_amt,sum(items.cgst_amount) as cgst_amt,sum(items.sgst_amount) as sgst_amt, prod.product_id, prod.product_category_id, prod.product_name, prod.default_cost_price, prod.default_sale_price, fam.family_id, fam.family_name, inv.invoice_date, items.service_item, items.service_type, items.category_type, items.is_from from mech_invoice as inv left join mech_invoice_item items ON items.invoice_id = inv.invoice_id left join mech_products prod ON prod.product_id = items.service_item left join ip_families fam ON fam.family_id = prod.product_category_id WHERE inv.invoice_date between '".$from_date."' and '".$to_date."' and prod.parent_id != 1 and inv.workshop_id='".$this->session->userdata('work_shop_id')."' AND items.is_from ='invoice_product'  AND inv.status ='A' and inv.invoice_status not in ('D') group by items.service_item");
                }else{
                    $query = $this->db->query("select sum(items.item_qty) as qty, sum(items.item_total_amount) as amt, sum(items.igst_amount) as igst_amt,sum(items.cgst_amount) as cgst_amt,sum(items.sgst_amount) as sgst_amt, prod.product_id, prod.product_category_id, prod.product_name, prod.default_cost_price, prod.default_sale_price, fam.family_id, fam.family_name, inv.invoice_date, items.service_item, items.service_type, items.category_type, items.is_from from mech_invoice as inv left join mech_invoice_item items ON items.invoice_id = inv.invoice_id left join mech_products prod ON prod.product_id = items.service_item left join ip_families fam ON fam.family_id = prod.product_category_id WHERE inv.invoice_date between '".$from_date."' and '".$to_date."' and prod.parent_id != 1 and inv.workshop_id='".$this->session->userdata('work_shop_id')."' AND inv.branch_id ='".$branch_id."' AND items.is_from ='invoice_product' AND inv.status ='A' and inv.invoice_status not in ('D') group by items.service_item");
                }
            }else{
                if($branch_id == 'ALL'){
                    $query = $this->db->query("select sum(items.item_qty) as qty, sum(items.item_total_amount) as amt, sum(items.igst_amount) as igst_amt,sum(items.cgst_amount) as cgst_amt,sum(items.sgst_amount) as sgst_amt, prod.product_id, prod.product_category_id, prod.product_name, prod.default_cost_price, prod.default_sale_price, fam.family_id, fam.family_name, inv.invoice_date, items.service_item, items.service_type, items.category_type, items.is_from from spare_invoice as inv left join spare_invoice_item items ON items.invoice_id = inv.invoice_id left join mech_products prod ON prod.product_id = items.service_item left join ip_families fam ON fam.family_id = prod.product_category_id WHERE inv.invoice_date between '".$from_date."' and '".$to_date."' and prod.parent_id != 1 and inv.workshop_id='".$this->session->userdata('work_shop_id')."' AND items.is_from ='invoice_product'  AND inv.status ='A' and inv.invoice_status not in ('D') group by items.service_item");
                }else{
                    $query = $this->db->query("select sum(items.item_qty) as qty, sum(items.item_total_amount) as amt, sum(items.igst_amount) as igst_amt,sum(items.cgst_amount) as cgst_amt,sum(items.sgst_amount) as sgst_amt, prod.product_id, prod.product_category_id, prod.product_name, prod.default_cost_price, prod.default_sale_price, fam.family_id, fam.family_name, inv.invoice_date, items.service_item, items.service_type, items.category_type, items.is_from from spare_invoice as inv left join spare_invoice_item items ON items.invoice_id = inv.invoice_id left join mech_products prod ON prod.product_id = items.service_item left join ip_families fam ON fam.family_id = prod.product_category_id WHERE inv.invoice_date between '".$from_date."' and '".$to_date."' and prod.parent_id != 1 and inv.workshop_id='".$this->session->userdata('work_shop_id')."' AND inv.branch_id ='".$branch_id."' AND items.is_from ='invoice_product' AND inv.status ='A' and inv.invoice_status not in ('D') group by items.service_item");
                }
            }
            return $query->result();
        }	
    }

    public function service_category($from_date = null, $to_date = null, $branch_id = null) {
        $workshop_id = $this->session->userdata('work_shop_id');
        if ($from_date and $to_date) {
            $from_date = date_to_mysql($from_date);
            $to_date = date_to_mysql($to_date);
            if($branch_id == 'ALL'){
                $query = $this->db->query("SELECT count(items.item_id) AS qty, SUM(items.item_total_amount) AS amt, serv.msim_id, serv.service_category_id, serv.service_item_name, sercat.service_cat_id, sercat.category_name, inv.invoice_date, items.service_item, items.service_type, items.category_type, items.is_from FROM mech_invoice AS inv LEFT JOIN mech_invoice_item items ON items.invoice_id = inv.invoice_id LEFT JOIN mech_service_item_dtls serv ON serv.msim_id = items.service_item LEFT JOIN mechanic_service_category_list sercat ON sercat.service_cat_id = serv.service_category_id WHERE inv.invoice_date BETWEEN '".$from_date."' AND '".$to_date."' AND inv.workshop_id = '".$this->session->userdata('work_shop_id')."' AND inv.status ='A' AND inv.invoice_status NOT IN ('D') AND items.is_from = 'invoice_service' GROUP BY serv.service_category_id");	
            }else{
                $query = $this->db->query("SELECT count(items.item_id) AS qty, SUM(items.item_total_amount) AS amt, serv.msim_id, serv.service_category_id, serv.service_item_name, sercat.service_cat_id, sercat.category_name, inv.invoice_date, items.service_item, items.service_type, items.category_type, items.is_from FROM mech_invoice AS inv LEFT JOIN mech_invoice_item items ON items.invoice_id = inv.invoice_id LEFT JOIN mech_service_item_dtls serv ON serv.msim_id = items.service_item LEFT JOIN mechanic_service_category_list sercat ON sercat.service_cat_id = serv.service_category_id WHERE inv.invoice_date BETWEEN '".$from_date."' AND '".$to_date."' AND inv.workshop_id = '".$this->session->userdata('work_shop_id')."' AND inv.branch_id ='".$branch_id."' AND inv.status ='A' AND inv.invoice_status NOT IN ('D') AND items.is_from = 'invoice_service' GROUP BY serv.service_category_id");	
            }
            return $query->result();
        }	
    }
    
    public function sales_product_by_client($from_date = null, $to_date = null, $branch_id = null) {
        $workshop_id = $this->session->userdata('work_shop_id');
        if ($from_date and $to_date) {
            $from_date = date_to_mysql($from_date);
            $to_date = date_to_mysql($to_date);
            if($this->session->userdata('plan_type') != 3){ 
                if($branch_id == 'ALL'){
                    $query = $this->db->query("SELECT SUM(items.item_qty) AS qty, SUM(items.item_total_amount) AS amt, cli.client_id, cli.client_name, cli.client_contact_no, inv.invoice_date, items.service_item, items.service_type, items.category_type, items.is_from FROM mech_invoice AS inv LEFT JOIN mech_invoice_item items ON items.invoice_id = inv.invoice_id LEFT JOIN mech_clients cli ON cli.client_id = inv.customer_id WHERE inv.invoice_date BETWEEN '".$from_date."' and '".$to_date."' and inv.workshop_id='".$this->session->userdata('work_shop_id')."' AND inv.customer_id != 0 AND inv.status = 'A' AND inv.invoice_status NOT IN('D') GROUP BY inv.customer_id");	
                }else{
                    $query = $this->db->query("SELECT SUM(items.item_qty) AS qty, SUM(items.item_total_amount) AS amt, cli.client_id, cli.client_name, cli.client_contact_no, inv.invoice_date, items.service_item, items.service_type, items.category_type, items.is_from FROM mech_invoice AS inv LEFT JOIN mech_invoice_item items ON items.invoice_id = inv.invoice_id LEFT JOIN mech_clients cli ON cli.client_id = inv.customer_id WHERE inv.invoice_date BETWEEN '".$from_date."' and '".$to_date."' and inv.workshop_id='".$this->session->userdata('work_shop_id')."' AND inv.branch_id ='".$branch_id."' AND inv.customer_id != 0 AND inv.status = 'A' AND inv.invoice_status NOT IN('D') GROUP BY inv.customer_id");	
                }
            }else{
                if($branch_id == 'ALL'){
                    $query = $this->db->query("SELECT SUM(items.item_qty) AS qty, SUM(items.item_total_amount) AS amt, cli.client_id, cli.client_name, cli.client_contact_no, inv.invoice_date, items.service_item, items.service_type, items.category_type, items.is_from FROM spare_invoice AS inv LEFT JOIN spare_invoice_item items ON items.invoice_id = inv.invoice_id LEFT JOIN mech_clients cli ON cli.client_id = inv.customer_id WHERE inv.invoice_date BETWEEN '".$from_date."' and '".$to_date."' and inv.workshop_id='".$this->session->userdata('work_shop_id')."' AND inv.customer_id != 0 AND inv.status = 'A' AND inv.invoice_status NOT IN('D') GROUP BY inv.customer_id");	
                }else{
                    $query = $this->db->query("SELECT SUM(items.item_qty) AS qty, SUM(items.item_total_amount) AS amt, cli.client_id, cli.client_name, cli.client_contact_no, inv.invoice_date, items.service_item, items.service_type, items.category_type, items.is_from FROM spare_invoice AS inv LEFT JOIN spare_invoice_item items ON items.invoice_id = inv.invoice_id LEFT JOIN mech_clients cli ON cli.client_id = inv.customer_id WHERE inv.invoice_date BETWEEN '".$from_date."' and '".$to_date."' and inv.workshop_id='".$this->session->userdata('work_shop_id')."' AND inv.branch_id ='".$branch_id."' AND inv.customer_id != 0 AND inv.status = 'A' AND inv.invoice_status NOT IN('D') GROUP BY inv.customer_id");	
                }
            }
            return $query->result();
        }	
    }

    public function sales_service_by_client($from_date = null, $to_date = null, $branch_id = null) {
        $workshop_id = $this->session->userdata('work_shop_id');
        if ($from_date and $to_date) {
            $from_date = date_to_mysql($from_date);
            $to_date = date_to_mysql($to_date);
            if($branch_id == 'ALL'){
                $query = $this->db->query("SELECT SUM(items.item_qty) AS qty, SUM(items.item_total_amount) AS amt, cli.client_id, cli.client_name, inv.invoice_date, items.service_item, items.service_type, items.category_type, items.is_from FROM mech_invoice AS inv LEFT JOIN mech_invoice_item items ON items.invoice_id = inv.invoice_id LEFT JOIN mech_clients cli ON cli.client_id = inv.customer_id WHERE inv.invoice_date BETWEEN '".$from_date."' and '".$to_date."' and inv.workshop_id='".$this->session->userdata('work_shop_id')."' AND inv.customer_id != 0 AND items.is_from = 'invoice_service' AND inv.status = 'A' AND inv.invoice_status NOT IN('D') GROUP BY inv.invoice_date,inv.customer_id");	
            }else{
                $query = $this->db->query("SELECT SUM(items.item_qty) AS qty, SUM(items.item_total_amount) AS amt, cli.client_id, cli.client_name, inv.invoice_date, items.service_item, items.service_type, items.category_type, items.is_from FROM mech_invoice AS inv LEFT JOIN mech_invoice_item items ON items.invoice_id = inv.invoice_id LEFT JOIN mech_clients cli ON cli.client_id = inv.customer_id WHERE inv.invoice_date BETWEEN '".$from_date."' and '".$to_date."' and inv.workshop_id='".$this->session->userdata('work_shop_id')."' AND inv.branch_id ='".$branch_id."' AND inv.customer_id != 0 AND items.is_from = 'invoice_service' AND inv.status = 'A' AND inv.invoice_status NOT IN('D') GROUP BY inv.invoice_date,inv.customer_id");	
            }
            return $query->result();
        }	
    }
    
    public function expense_detail($from_date = null, $to_date = null, $branch_id = null, $shift = null)
    {
        $workshop_id = $this->session->userdata('work_shop_id');
        if ($from_date and $to_date) {
            $from_date = date_to_mysql($from_date);
            $to_date = date_to_mysql($to_date);
            $branch_list = array();
            $expense_list = array();
            $this->db->select('workshop_branch_details.w_branch_id,workshop_branch_details.display_board_name');
            $this->db->where('workshop_branch_details.workshop_id',$workshop_id);
            if (in_array("ALL", $branch_id)) {
            }else{
                $this->db->where_in('workshop_branch_details.w_branch_id',$branch_id);
            }
            $branch_list = $this->db->get('workshop_branch_details')->result();

            foreach ($branch_list as $branch_list_key => $branchlist) {
                $expense_list = $this->db->query("SELECT exp.shift,exp.grand_total,exp.expense_date,cat.expense_category_name FROM mech_expense as exp left JOIN mech_expense_categories cat ON cat.expense_category_id = exp.expense_head_id where exp.expense_date BETWEEN '".$from_date."' AND '".$to_date."' AND  exp.workshop_id = '".$workshop_id."' AND exp.branch_id = '".$branchlist->w_branch_id."' AND exp.status = 1 ")->result();
                $branch_list[$branch_list_key]->expense_list = $expense_list;
            }    
            return $branch_list;
        }
    } 

    public function expense_by_category($from_date = null, $to_date = null, $branch_id = null, $shift = null, $expense_head_id = null)
    {
        $workshop_id = $this->session->userdata('work_shop_id');
        if ($from_date and $to_date) {
            $from_date = date_to_mysql($from_date);
            $to_date = date_to_mysql($to_date);
            if($branch_id == 'ALL'){
                $query = $this->db->query("SELECT exp.shift,sum(exp.grand_total) as grand_total,count(exp.expense_head_id) as expensehead,exp.expense_date,cat.expense_category_name FROM mech_expense as exp left JOIN mech_expense_categories cat ON cat.expense_category_id = exp.expense_head_id where exp.expense_date BETWEEN '".$from_date."' AND '".$to_date."' AND  exp.workshop_id = '".$workshop_id."' AND exp.status = 1 group by exp.expense_head_id ORDER BY exp.expense_date ASC");
            }else{
                $query = $this->db->query("SELECT exp.shift,sum(exp.grand_total) as grand_total,count(exp.expense_head_id) as expensehead,exp.expense_date,cat.expense_category_name FROM mech_expense as exp left JOIN mech_expense_categories cat ON cat.expense_category_id = exp.expense_head_id where exp.expense_date BETWEEN '".$from_date."' AND '".$to_date."' AND  exp.workshop_id = '".$workshop_id."' AND  exp.branch_id = '".$branch_id."' AND exp.status = 1 group by exp.expense_head_id ORDER BY exp.expense_date ASC");
            }
            return $query->result();
        }
    } 

    public function todaysreportinvoice($from_date = null, $to_date = null, $branch_id = null){
        $workshop_id = $this->session->userdata('work_shop_id');
        if ($from_date && $to_date) {
            $from_date = date_to_mysql($from_date);
            $to_date = date_to_mysql($to_date);
        
            $this->db->select('workshop_branch_details.w_branch_id,workshop_branch_details.display_board_name');
            $this->db->where('workshop_branch_details.workshop_id',$workshop_id);
            if (in_array("ALL", $branch_id)) {
            }else{
                $this->db->where_in('workshop_branch_details.w_branch_id',$branch_id);
            }
            $branch_list = $this->db->get('workshop_branch_details')->result();

            foreach ($branch_list as $branch_list_key => $branch_lists){
                if($this->session->userdata('plan_type') != 3){ 
                    $invoice = $this->db->query("SELECT count(invoice_id) AS total_vehicle, sum(grand_total) AS grand_total FROM mech_invoice WHERE workshop_id = '".$workshop_id."' AND branch_id = '".$branch_lists->w_branch_id."' AND invoice_date BETWEEN '".$from_date."' AND '".$to_date."'  AND status = 'A' AND invoice_status NOT IN('D') GROUP BY branch_id ")->result();
                }else{
                    $invoice = $this->db->query("SELECT count(invoice_id) AS total_vehicle, sum(grand_total) AS grand_total FROM spare_invoice WHERE workshop_id = '".$workshop_id."' AND branch_id = '".$branch_lists->w_branch_id."' AND invoice_date BETWEEN '".$from_date."' AND '".$to_date."'  AND status = 'A' AND invoice_status NOT IN('D') GROUP BY branch_id ")->result();
                }
                foreach ($invoice as $invoicelist){
                    if(!empty($invoicelist)){
                        $branch_list[$branch_list_key]->total_vehicle = $invoicelist->total_vehicle;
                        $branch_list[$branch_list_key]->grand_total = $invoicelist->grand_total;
                    }
                }
                $expense = $this->db->query("SELECT sum(grand_total) AS expense_grand_total FROM  mech_expense WHERE workshop_id = '".$workshop_id."' AND branch_id = '".$branch_lists->w_branch_id."' AND expense_date BETWEEN '".$from_date."' AND '".$to_date."' AND status = 1 GROUP BY branch_id ")->result();
                foreach ($expense as $expenselist){
                    if(!empty($expenselist)){
                        $branch_list[$branch_list_key]->expense_grand_total = $expenselist->expense_grand_total;
                    }
                }
            }
            return $branch_list;
        }
    }

    public function reference_type_report($from_date = null, $to_date = null, $branch_id = null, $ref_type = null, $ref_by = null) {
        
        $workshop_id = $this->session->userdata('work_shop_id');
        $from_date = date_to_mysql($from_date);
        $to_date = date_to_mysql($to_date);
       
        $this->db->select('inv.invoice_date, count(inv.invoice_id) as invoice_count, sum(inv.grand_total) as grand_total, ref.refer_name');
        if($ref_by){
            if($ref_type == 1 || $ref_type == '1'){
                $this->db->select('cli.client_name as entity_name');
                $this->db->join('mech_clients as cli','cli.client_id = inv.refered_by_id','left');
            }else if($ref_type == 2 || $ref_type == '2'){
                $this->db->select('emp.employee_name as entity_name');
                $this->db->join('mech_employee as emp','emp.employee_id = inv.refered_by_id','left');
            }else if($ref_type == 3 || $ref_type == '3'){
                $this->db->select('sup.supplier_name as entity_name');
                $this->db->join('mech_suppliers as sup','sup.supplier_id = inv.refered_by_id','left');
            }
        }
        if($this->session->userdata('plan_type') != 3){ 
            $this->db->from('mech_invoice as inv');
        }else{
            $this->db->from('spare_invoice as inv');
        }
        $this->db->join('mech_reference_dtls as ref','ref.refer_type_id = inv.refered_by_type','left');
        $this->db->where('inv.workshop_id' , $this->session->userdata('work_shop_id'));
        $this->db->where('inv.invoice_date >=', $from_date);
        $this->db->where('inv.invoice_date <=', $to_date);
        if($branch_id != "ALL"){
            $this->db->where('inv.branch_id', $branch_id);
        }
        if(!empty($ref_type)){
            $this->db->where('inv.refered_by_type' , $ref_type );
        }
        if(!empty($ref_by)){
            $this->db->where('inv.refered_by_id' , $ref_by );
        }
        $this->db->where('inv.status' , 'A');
        $this->db->where('inv.status !=' , 'D');
        $this->db->where('inv.invoice_status !=' , 'D');
        $this->db->group_by('inv.invoice_date');
        if(!empty($ref_type)){
            $this->db->group_by('inv.refered_by_type');
        }
        if(!empty($ref_by)){
            $this->db->group_by('inv.refered_by_id');
        }
        return $this->db->get()->result();
        
    }
    public function customer_ledger($from_date = null, $to_date = null, $branch_id = null, $customer_id = null) {
        $workshop_id = $this->session->userdata('work_shop_id');
        $from_date = date_to_mysql($from_date);
        $to_date = date_to_mysql($to_date);
       
        $this->db->select('inv.invoice_id,inv.invoice_date,inv.invoice_date_due,inv.in_days,inv.invoice_no,inv.total_due_amount,inv.total_paid_amount,inv.grand_total,cli.client_name');
        if($this->session->userdata('plan_type') != 3){ 
            $this->db->from('mech_invoice as inv');
        }else{
            $this->db->from('spare_invoice as inv');
        }
        
        $this->db->join('mech_clients as cli','cli.client_id = inv.customer_id','left');
        $this->db->where('inv.workshop_id' , $this->session->userdata('work_shop_id'));
        $this->db->where('inv.invoice_date >=', $from_date);
        $this->db->where('inv.invoice_date <=', $to_date);
        $this->db->where('inv.customer_id', $customer_id);

        if($branch_id != "ALL"){
            $this->db->where('inv.branch_id', $branch_id);
        }
        $this->db->where('inv.status' , 'A');
        $this->db->where('inv.status !=' , 'D');
        $this->db->where('inv.invoice_status !=' , 'D');
        $this->db->group_by('inv.invoice_no');
        $this->db->order_by('inv.invoice_date');
        return $this->db->get()->result();
    }
    public function customernameledger($customer_id = null){

            $this->db->select('add.user_address_id,cli.client_name,cli.client_contact_no,add.customer_street_1,add.customer_street_2,
            add.area,add.zip_code,city.city_name,state.state_name,country.name');
            $this->db->from('mech_clients as cli');
            $this->db->join('mech_user_address as add','add.user_address_id = cli.client_id','left');
            $this->db->join('city_lookup as city','city.city_id = add.customer_city','left');
            $this->db->join('mech_state_list as state','state.state_id = add.customer_state','left');
            $this->db->join('country_lookup as country','country.id = add.customer_country','left');
            $this->db->where('cli.client_id', $customer_id);
            return $this->db->get()->result();   
    }

    public function supplier_ledger($from_date = null, $to_date = null, $branch_id = null, $supplier_id = null) {
        $workshop_id = $this->session->userdata('work_shop_id');
        $from_date = date_to_mysql($from_date);
        $to_date = date_to_mysql($to_date);
       
        $this->db->select('pur.purchase_id,pur.purchase_date_created,pur.purchase_date_due,pur.in_days, pur.purchase_no,pur.total_due_amount,pur.total_paid_amount,pur.grand_total,sup.supplier_name');
        $this->db->from('mech_purchase as pur');
        $this->db->join('mech_suppliers as sup','sup.supplier_id = pur.supplier_id','left');
        $this->db->where('pur.workshop_id' , $this->session->userdata('work_shop_id'));
        $this->db->where('pur.purchase_date_created >=', $from_date);
        $this->db->where('pur.purchase_date_created <=', $to_date);
        $this->db->where('pur.supplier_id', $supplier_id);

        if($branch_id != "ALL"){
            $this->db->where('pur.branch_id', $branch_id);
        }
        $this->db->where('pur.status' , 'A');
        $this->db->where('pur.status !=' , 'D');
        $this->db->where('pur.purchase_status !=' , 'D');
        $this->db->group_by('pur.purchase_no');
        $this->db->order_by('pur.purchase_date_created');
        return $this->db->get()->result();
        
    }
    public function suppliernameledger($supplier_id = null){

            $this->db->select('sup.supplier_name,sup.supplier_contact_no,sup.supplier_street,
            sup.supplier_pincode,city.city_name,state.state_name,country.name');       
            $this->db->from('mech_suppliers as sup');
            $this->db->join('city_lookup as city','city.city_id = sup.supplier_city','left');
            $this->db->join('mech_state_list as state','state.state_id = sup.supplier_state','left');
            $this->db->join('country_lookup as country','country.id = sup.supplier_country','left');
            $this->db->where('sup.supplier_id', $supplier_id);
            return $this->db->get()->result();   
    }

    public function product_ledger($from_date = null, $to_date = null, $branch_id = null, $product_id = null) {
        $workshop_id = $this->session->userdata('work_shop_id');
        $from_date = date_to_mysql($from_date);
        $to_date = date_to_mysql($to_date);
       
        $this->db->select('pur.purchase_id,pur.purchase_date_created,pur.purchase_no,puritm.item_price,puritm.item_amount,puritm.item_qty,puritm.item_total_amount,sup.supplier_name');
        $this->db->from('mech_purchase as pur');
        $this->db->join('mech_purchase_item as puritm','puritm.purchase_id = pur.purchase_id','left');
        $this->db->join('mech_suppliers as sup','sup.supplier_id = pur.supplier_id','left');
        $this->db->where('pur.workshop_id' , $this->session->userdata('work_shop_id'));
        $this->db->where('pur.purchase_date_created >=', $from_date);
        $this->db->where('pur.purchase_date_created <=', $to_date);
        $this->db->where('puritm.product_id', $product_id);

        if($branch_id != "ALL"){
            $this->db->where('pur.branch_id', $branch_id);
        }
        $this->db->where('pur.status' , 'A');
        $this->db->where('pur.status !=' , 'D');
        $this->db->where('pur.purchase_status !=' , 'D');
        $this->db->group_by('pur.purchase_no');
        $this->db->order_by('pur.purchase_date_created');
        return $this->db->get()->result();	
    }
    public function productnameledger($product_id = null){

        $this->db->select('pro.product_name,prli.cost_price,prli.sale_price,ipfam.family_name');    
        $this->db->from('mech_products as pro');
        $this->db->join('mech_product_price_list as prli', 'prli.product_id = pro.product_id and prli.workshop_id = '. $this->session->userdata('work_shop_id'), 'left');
        $this->db->join('ip_families as ipfam', 'ipfam.family_id = pro.product_category_id and ipfam.status = "A"', 'left');

        $this->db->where('pro.product_id', $product_id);
        return $this->db->get()->result();   
    }
    public function product_ledger_salesreport($from_date = null, $to_date = null, $branch_id = null, $product_id = null) {
        $workshop_id = $this->session->userdata('work_shop_id');
        $from_date = date_to_mysql($from_date);
        $to_date = date_to_mysql($to_date);
        
        $this->db->select('inv.invoice_id,inv.invoice_date,inv.invoice_no,invitm.user_item_price,invitm.mech_item_price,invitm.item_qty,invitm.item_amount,cli.client_name');
        if($this->session->userdata('plan_type') != 3){ 
            $this->db->from('mech_invoice as inv');
            $this->db->join('mech_invoice_item as invitm','invitm.invoice_id = inv.invoice_id','left');
        }else{
            $this->db->from('spare_invoice as inv');
            $this->db->join('spare_invoice_item as invitm','invitm.invoice_id = inv.invoice_id','left');    
        }
        $this->db->join('mech_clients as cli','cli.client_id = inv.customer_id','left');
        $this->db->where('inv.workshop_id' , $this->session->userdata('work_shop_id'));
        $this->db->where('inv.invoice_date >=', $from_date);
        $this->db->where('inv.invoice_date <=', $to_date);
        $this->db->where('invitm.service_item', $product_id);

        if($branch_id != "ALL"){
            $this->db->where('inv.branch_id', $branch_id);
        }
        $this->db->where('invitm.is_from', 'invoice_product');
        $this->db->where('inv.status' , 'A');
        $this->db->where('inv.status !=' , 'D');
        $this->db->where('inv.invoice_status !=' , 'D');
        $this->db->group_by('inv.invoice_no');
        $this->db->order_by('inv.invoice_date');
        return $this->db->get()->result();
	
    }

    public function purchase_by_summary($from_date = null, $to_date = null, $branch_id = null)
    {
        $workshop_id = $this->session->userdata('work_shop_id');
        if ($from_date and $to_date) {
            $from_date = date_to_mysql($from_date);
            $to_date = date_to_mysql($to_date);
            if($branch_id == 'ALL'){
                $query = $this->db->query("SELECT purchase_id,purchase_date_created,purchase_no,purchase_date_due,grand_total,total_paid_amount,total_due_amount FROM mech_purchase WHERE purchase_date_created BETWEEN '".$from_date."' AND '".$to_date."' AND workshop_id = '".$workshop_id."' AND status = 'A' AND purchase_status NOT IN('D') GROUP BY purchase_date_created ORDER BY purchase_date_created ASC");
            }else{
                $query = $this->db->query("SELECT purchase_id,purchase_date_created,purchase_no,purchase_date_due,grand_total,total_paid_amount,total_due_amount FROM mech_purchase WHERE purchase_date_created BETWEEN '".$from_date."' AND '".$to_date."' AND  w_branch_id = '".$branch_id."' AND workshop_id = '".$workshop_id."' AND status = 'A'  AND purchase_status NOT IN('D') GROUP BY purchase_date_created ORDER BY purchase_date_created ASC");
            }
            return $query->result();
        }
    }

    public function product_inventory_hand($product_name = Null,$product_category = Null){
        
        $workshop_id = $this->session->userdata('work_shop_id');

        if ($product_category || $product_name) {
    
            $this->db->select('mech_products.product_id,mech_products.workshop_id, mech_products.w_branch_id, mech_products.product_name,
                               ip_families.family_id, ip_families.family_name,mech_product_stock_details.balance_stock');

            $this->db->from('mech_products');

            $this->db->join('ip_families', 'ip_families.family_id = mech_products.product_category_id', 'left');
            $this->db->join('mech_product_stock_details', 'mech_product_stock_details.product_id = mech_products.product_id and mech_product_stock_details.workshop_id = '.$workshop_id, 'left');

            if($product_category && $product_name){
                $this->db->where('mech_products.product_category_id',$product_category);
                $this->db->where('mech_products.product_name',$product_name);
            }else if($product_category && ($product_name == '' || $product_name == 0)){
                $this->db->where('mech_products.product_category_id',$product_category);
            }else if(($product_category == '' || $product_category == 0)  && $product_name){
                $this->db->where('mech_products.product_name',$product_name);
            }
            $this->db->where_in('mech_products.workshop_id', array('1',$workshop_id));
            $this->db->where('mech_products.status', 'A');
            $result = $this->db->get()->result();

            return $result;
        }else{
            $result = array();
        }
   
    }

    public function product_inventory_lowstock($product_name = Null,$product_category = Null){
        
        $workshop_id = $this->session->userdata('work_shop_id');

        if ($product_category || $product_name) {

            $this->db->select('a.product_id, a.product_name, a.part_number,a.reorder_quantity, b.balance_stock, c.sale_price, c.cost_price, c.mrp_price, ip_families.family_name');
            $this->db->from('mech_products as a');
            $this->db->join('mech_product_price_list as c','c.product_id = a.product_id','left');
            $this->db->join('ip_families', 'ip_families.family_id = a.product_category_id', 'left');
            $this->db->join('mech_product_stock_details as b','b.product_id = a.product_id and b.workshop_id = '.$workshop_id,'left');

            if($product_category && $product_name){
                $this->db->where('a.product_category_id',$product_category);
                $this->db->where('a.product_name',$product_name);
            }else if($product_category && ($product_name == '' || $product_name == 0)){
                $this->db->where('a.product_category_id',$product_category);
            }else if(($product_category == '' || $product_category == 0)  && $product_name){
                $this->db->where('a.product_name',$product_name);
            }

            $this->db->where('b.balance_stock <= a.reorder_quantity');
            $this->db->where_in('a.workshop_id', array('1',$workshop_id));
            $this->db->where('a.status', 'A');
            $result = $this->db->get()->result();

            return $result;
        }else{
            $result = array();
        }
   
    }

}
