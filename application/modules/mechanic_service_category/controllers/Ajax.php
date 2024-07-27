<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Ajax extends Admin_Controller
{
    public $ajax_controller = true;
    public $targetPath;


    public function __construct()
    {
        parent::__construct();
        $this->load->model('mechanic_service_category/mdl_mechanic_service_category_list');
        $this->targetPath = UPLOADS_FOLDER . 'service_category';

    }

    public function create()
    {
        $service_cat_id = $this->input->post('service_cat_id');
        Ajax::create_dir($this->targetPath . '/');
        if($this->mdl_mechanic_service_category_list->run_validation()){
            $category_name = $this->mdl_mechanic_service_category_list->checkCategoryNameExist($this->input->post('category_name'));
            
            if($category_name == TRUE){
                if (count($_FILES) > 0) {
                    if(isset($_FILES['iconfile'])){
                        $icontempFile = $_FILES['iconfile']['tmp_name'][0];
                        $iconfileName = preg_replace('/\s+/', '_', $_FILES['iconfile']['name'][0]);
                        $six_digit_random_icon = mt_rand(100000, 999999);
                        $icontargetFile = $this->targetPath . '/' . $six_digit_random_icon . '_' . $iconfileName;
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
                            $path_parts['extension'] == 'tif' || $path_parts['extension'] =='TIF' || $path_parts['extension'] =='') && !$file_exists) {
                            if($iconfileName){ 
                            move_uploaded_file($icontempFile, $icontargetFile);  
                            $_POST['service_icon_image'] = 'uploads/service_category/'.$icontempFileName;
                            }
                        }
                        else{
                            echo json_encode([
                                'success' => 2,
                            ]);
                            exit();
                        }
                    }
        
                    if(isset($_FILES['bannerfile'])){
                        $bannertempFile = $_FILES['bannerfile']['tmp_name'][0];
                        $bannerfileName = preg_replace('/\s+/', '_', $_FILES['bannerfile']['name'][0]);
                        $six_digit_random_banner = mt_rand(100000, 999999);
                        $bannertargetFile = $this->targetPath . '/' . $six_digit_random_banner . '_' . $bannerfileName;
                        $bannerfile_exists = file_exists($bannertargetFile);
                        $bannertempFileName = $six_digit_random_banner . '_' . $bannerfileName;
                        $path_parts = pathinfo($bannertargetFile);
                        if(($path_parts['extension'] == 'jpeg' || $path_parts['extension'] == 'JPEG' || 
                            $path_parts['extension'] == 'png' || $path_parts['extension'] == 'PNG' ||
                            $path_parts['extension'] == 'jpg' || $path_parts['extension'] == 'JPG' ||
                            $path_parts['extension'] == 'gif' || $path_parts['extension'] == 'GIF' ||
                            $path_parts['extension'] == 'tiff' || $path_parts['extension'] == 'TIFF' ||
                            $path_parts['extension'] == 'pdf' || $path_parts['extension'] == 'PDF' ||
                            $path_parts['extension'] == 'bmp' || $path_parts['extension'] == 'BMP' ||
                            $path_parts['extension'] == 'tif' || $path_parts['extension'] == 'TIF' || $path_parts['extension'] == '') && !$file_exists) {
                            if($bannerfileName){ 
                            move_uploaded_file($bannertempFile, $bannertargetFile);   
                            $_POST['service_image'] = 'uploads/service_category/'.$bannertempFileName;
                            }
                        }else{
                            echo json_encode([
                                'success' => 2,
                            ]);
                            exit();
                        }

                    }
                }

                $service_cat_id = $this->mdl_mechanic_service_category_list->save($service_cat_id);

                $response = array(
                    'success' => 1,
                    'service_cat_id' => $service_cat_id,
                );
            }else{
                $response = array(
                    'success' => 3,
                    'msg' => 'Category Name already exist',
                );
            }
        }else {
            $this->load->helper('json_error');
            $response = array(
                'success' => 0,
                'validation_errors' => json_errors()
            );
        }
        
        echo json_encode($response);
        exit();
    }

    public function get_filter_list(){

        $workshop_id = $this->session->userdata('work_shop_id');
        $category_owner = $this->input->post('category_owner');

        $start = !empty($this->input->post('page'))?$this->input->post('page'):0;
        $limit = 15;
        if($this->input->post('category_name')){
            $this->mdl_mechanic_service_category_list->like('category_name', trim($this->input->post('category_name')));
        }
        if($this->input->post('service_short_description')){
            $this->mdl_mechanic_service_category_list->like('service_short_description', trim($this->input->post('service_short_description')));
        }
        if($this->input->post('service_description')){
            $this->mdl_mechanic_service_category_list->like('service_description', trim($this->input->post('service_description')));
        }

        if($category_owner == 'O'){
            $this->mdl_mechanic_service_category_list->where('workshop_id', $workshop_id);
        }elseif($category_owner == 'A'){
            $this->mdl_mechanic_service_category_list->where('workshop_id', 1);
        }

        $rowCount = $this->mdl_mechanic_service_category_list->get()->result();
        $rowCount = count($rowCount);
        $pagConfig = array(
            'currentPage' => $start,
            'totalRows' => $rowCount,
            'perPage' => $limit,
            'link_func' => 'searchFilter'
        );
        $pagination =  new Pagination($pagConfig);
        $createLinks = $pagination->createLinks();

        if($this->input->post('category_name')){
            $this->mdl_mechanic_service_category_list->like('category_name', trim($this->input->post('category_name')));
        }
        if($this->input->post('service_short_description')){
            $this->mdl_mechanic_service_category_list->like('service_short_description', trim($this->input->post('service_short_description')));
        }
        if($this->input->post('service_description')){
            $this->mdl_mechanic_service_category_list->like('service_description', trim($this->input->post('service_description')));
        }

        if($category_owner == 'O'){
            $this->mdl_mechanic_service_category_list->where('workshop_id', $workshop_id);
        }elseif($category_owner == 'A'){
            $this->mdl_mechanic_service_category_list->where('workshop_id', 1);
        }

        $this->mdl_mechanic_service_category_list->limit($limit,$start);
        $mechanic_service_category_list = $this->mdl_mechanic_service_category_list->get()->result();           

        $response = array(
            'success' => 1,
            'mechanic_service_category_list' => $mechanic_service_category_list, 
            'createLinks' => $createLinks,
        );
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
    
}