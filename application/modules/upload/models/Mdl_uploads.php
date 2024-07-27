<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mdl_Uploads extends Response_Model
{
    public $table = 'ip_uploads';
    public $primary_key = 'ip_uploads.upload_id';
    public $date_modified_field = 'uploaded_date';

    public function default_order_by()
    {
        $this->db->order_by('ip_uploads.upload_id ASC');
    }

    public function create($db_array = null)
    {
        $upload_id = parent::save(null, $db_array);

        return $upload_id;
    }

    public function get_quote_uploads($id)
    {
        $this->load->model('quotes/mdl_quotes');
        $quote = $this->mdl_quotes->get_by_id($id);
        $query = $this->db->query("SELECT file_name_new,file_name_original FROM ip_uploads WHERE url_key = '" . $quote->quote_url_key . "'");

        $names = array();

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                array_push($names, array(
                    'path' => getcwd() . '/uploads/customer_files/' . $row->file_name_new,
                    'filename' => $row->file_name_original));
            }
        }

        return $names;
    }

    public function get_invoice_uploads($id)
    {
        $this->load->model('invoices/mdl_invoices');
        $invoice = $this->mdl_invoices->get_by_id($id);
        $query = $this->db->query("SELECT file_name_new,file_name_original FROM ip_uploads WHERE url_key = '" . $invoice->invoice_url_key . "'");

        $names = array();

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                array_push($names, array(
                    'path' => getcwd() . '/uploads/customer_files/' . $row->file_name_new,
                    'filename' => $row->file_name_original));
            }
        }

        return $names;
    }

    public function delete_file($url_key, $filename)
    {
        $this->db->where('url_key', $url_key);
        $this->db->where('file_name_original', $filename);
        $this->db->delete('ip_uploads');
    }

    public function by_client($client_id)
    {
        $this->filter_where('ip_uploads.client_id', $client_id);
        return $this;
    }

    public function getEmployeeDocuments($employee_id){
        return $this->db->select('*')->from('ip_uploads')->where('workshop_id', $this->session->userdata('work_shop_id'))->where('w_branch_id', $this->session->userdata('branch_id'))->where('entity_id', $employee_id)->where('entity_type', 'E')->get()->result();
    }

}