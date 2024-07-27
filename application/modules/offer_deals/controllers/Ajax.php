<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Ajax extends Admin_Controller
{
    public $ajax_controller = true; 
  
	public function __construct()
    {
        parent::__construct();
        $this->load->model('offer_deals/mdl_offer_deals');
        $this->targetPath = UPLOADS_FOLDER . 'offers_image';	
	}
	
    public function create()
    { 
        $offer_id = $this->input->post('offer_id');
        $btn_submit = $this->input->post('btn_submit');

        Ajax::create_dir($this->targetPath . '/');
                
                if (count($_FILES) > 0) {
                    if(isset($_FILES['iconfile'])){
                        $icontempFile = $_FILES['iconfile']['tmp_name'][0];
                        $iconfileName = preg_replace('/\s+/', '_', $_FILES['iconfile']['name'][0]);
                        $six_digit_random_icon = mt_rand(100000, 999999);
                        $icontargetFile = $this->targetPath . '/' . $six_digit_random_icon . '_'. $iconfileName;
                        $iconfile_exists = file_exists($icontargetFile);
                        $icontempFileName = $six_digit_random_icon . '_' . $iconfileName;
                        $path_parts = pathinfo($icontargetFile);
                        if(($path_parts['extension'] == 'jpeg' || $path_parts['extension'] == 'JPEG' || 
                            $path_parts['extension'] == 'png' || $path_parts['extension'] == 'PNG' ||
                            $path_parts['extension'] == 'jpg' || $path_parts['extension'] == 'JPG' ||
                            $path_parts['extension'] == 'gif' || $path_parts['extension'] == 'GIF' ||
                            $path_parts['extension'] == 'tiff' || $path_parts['extension'] == 'TIFF' ||
                            $path_parts['extension'] == 'pdf' || $path_parts['extension'] == 'PDF' ||
                            $path_parts['extension'] == 'bmp' || $path_parts['extension'] == 'BMP' ||
                            $path_parts['extension'] == 'tif' || $path_parts['extension'] =='TIF') && !$file_exists) {
                            move_uploaded_file($icontempFile, $icontargetFile);
                            $_POST['offer_banner_image'] = 'uploads/offers_image/' .$icontempFileName;
                        }
                    }
                }
                    if ($this->mdl_offer_deals->run_validation('deal_validation_rules')) {

                        $offer_id = $this->mdl_offer_deals->save($offer_id);
                        $featurename = $this->input->post('column_name');
                        $feature_id = $this->input->post('feature_id');
                        
                        if(count($featurename) > 0){
                            $insert_array = array();
                            $update_array = array();
                            for ($i = 0; $i < count($featurename); $i++) {
                                    for ($j = 0; $j < count($feature_id); $j++) {
                                    if($featurename[$i]){    
                                        if($feature_id[$j]){
                                            $update_array[] = array(
                                                'feature_id' => $feature_id[$j],
                                                'entity_id' => $offer_id,
                                                'entity_type' => 'off',
                                                'name' => $featurename[$i],
                                                'created_by' => $this->session->userdata('user_id'),
                                                'modified_by' => $this->session->userdata('user_id')
                                            );
                                        }else{
                                            $insert_array[] = array(
                                                'entity_id' => $offer_id,
                                                'entity_type' => 'off',
                                                'name' => $featurename[$i],
                                                'workshop_id' => $this->session->userdata('work_shop_id'),
                                                'created_on' => date('Y-m-d H:m:s'),
                                                'created_by' => $this->session->userdata('user_id'),
                                                'modified_by' => $this->session->userdata('user_id')
                                            );
                                        }    
                                    }$i++;
                                }    
                            }
                            
                        }
    
                        if(count($insert_array) > 0){
                            $this->db->insert_batch('mech_service_feature_dtls', $insert_array);    
                        }

                        if(count($update_array) > 0){
                            $this->db->update_batch('mech_service_feature_dtls', $update_array,'feature_id');    
                        } 
                          

                        $response = array(
                            'success' => 1,
                            'offer_id'=>$offer_id,
                            'btn_submit' => $btn_submit
                        );
                } else {
                    $this->load->helper('json_error');
                        $response = array(
                            'success' => 0,
                            'validation_errors' => json_errors()
                        );
                }

                echo json_encode($response);
    }
    public function create_dir($path, $chmod = '0777')
    {
        if (!(is_dir($path) || is_link($path))) {
            return mkdir($path, $chmod);
        } else {
            return false;
        }
    }

    public function get_offer_package_filter_list(){

        $start = !empty($this->input->post('page'))?$this->input->post('page'):0;
        $limit = 15;

        if($this->input->post('offer_from_date')){  
            $this->mdl_offer_deals->where('mech_service_offer_dtls.start_date >=',date_to_mysql($this->input->post('offer_from_date')));
        }
        
        if($this->input->post('offer_to_date')){
            $this->mdl_offer_deals->where('mech_service_offer_dtls.start_date <=',date_to_mysql($this->input->post('offer_to_date')));
        }

        if($this->input->post('offer_title')){
            $this->mdl_offer_deals->like('offer_title', trim($this->input->post('offer_title')));
        }
        if($this->input->post('service_category_id')){
            $this->mdl_offer_deals->like('service_category_id', trim($this->input->post('service_category_id')));
        }
        
        $rowCount = $this->mdl_offer_deals->get()->result();
        $rowCount = count($rowCount);
        $pagConfig = array(
            'currentPage' => $start,
            'totalRows' => $rowCount,
            'perPage' => $limit,
            'link_func' => 'searchFilter'
        );
        $pagination =  new Pagination($pagConfig);
        $createLinks = $pagination->createLinks();

        if($this->input->post('offer_from_date')){  
            $this->mdl_offer_deals->where('mech_service_offer_dtls.start_date >=',date_to_mysql($this->input->post('offer_from_date')));
        }
        
        if($this->input->post('offer_to_date')){
            $this->mdl_offer_deals->where('mech_service_offer_dtls.start_date <=',date_to_mysql($this->input->post('offer_to_date')));
        }

        if($this->input->post('offer_title')){
            $this->mdl_offer_deals->like('offer_title', trim($this->input->post('offer_title')));
        }
        if($this->input->post('service_category_id')){
            $this->mdl_offer_deals->like('service_category_id', trim($this->input->post('service_category_id')));
        }

        $this->mdl_offer_deals->limit($limit,$start);
        $mech_offer_package = $this->mdl_offer_deals->get()->result();
        $response = array(
            'success' => 1,
            'mech_offer_package' => $mech_offer_package, 
            'createLinks' => $createLinks,
        );
        echo json_encode($response);
    }

    public function deletefeatureData(){
        
        $feature_id = $this->input->post('feature_id');
        $this->db->set('status','D');
        $this->db->where('feature_id',$feature_id);
        $this->db->update('mech_service_feature_dtls');

        $response = array(
            'success' => 1
        );

        echo json_encode($response);
    }
                        
}

	
	
    
