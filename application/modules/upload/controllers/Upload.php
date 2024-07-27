<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');


class Upload extends Admin_Controller
{
    public $targetPath;

    public $ctype_default = "application/octet-stream";
    public $content_types = array(
        'gif' => 'image/gif',
        'jpg' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'pdf' => 'application/pdf',
        'png' => 'image/png',
        'txt' => 'text/plain',
        'xml' => 'application/xml',
    );

    /**
     * Upload constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('upload/mdl_uploads');
        $this->load->model('service_packages/mdl_service_package');
    }

    /**
     * @param $customerId
     * @param $url_key
     * @return bool
     */
    public function upload_file($entity_id,$entity_type, $url_key)
    {   
        if($entity_type == 'E'){
            $this->targetPath = UPLOADS_FOLDER . 'employee_files';     
        }else if($entity_type == 'pro'){
            $this->targetPath = UPLOADS_FOLDER . 'product_files';     
        }else if($entity_type == 'P'){
            $this->targetPath = UPLOADS_FOLDER . 'purchase_files';     
        }else if($entity_type == 'PO'){
            $this->targetPath = UPLOADS_FOLDER . 'purchase_order_files';     
        }else if($entity_type == 'J'){
            $this->targetPath = UPLOADS_FOLDER . 'jobcard_files';     
        }else if($entity_type == 'T'){
            $this->targetPath = UPLOADS_FOLDER . 'transaction_files';     
        }else{
            $this->targetPath = UPLOADS_FOLDER . 'customer_files';     
        }

        Upload::create_dir($this->targetPath . '/');

        if (!empty($_FILES)) {

            $tempFile = $_FILES['file']['tmp_name'];
            $fileName = preg_replace('/\s+/', '_', $_FILES['file']['name']);
            $targetFile = $this->targetPath . '/' . $url_key . '_' . $fileName;
            $file_exists = file_exists($targetFile);
            $tempFileName = $url_key . '_' . $fileName;

            $path_parts = pathinfo($targetFile);
            
            if(($path_parts['extension'] == 'jpeg' || $path_parts['extension'] == 'JPEG' || 
                $path_parts['extension'] == 'png' || $path_parts['extension'] == 'PNG' ||
                $path_parts['extension'] == 'jpg' || $path_parts['extension'] == 'JPG' ||
                $path_parts['extension'] == 'gif' || $path_parts['extension'] == 'GIF' ||
                $path_parts['extension'] == 'tiff' || $path_parts['extension'] == 'TIFF' ||
                $path_parts['extension'] == 'pdf' || $path_parts['extension'] == 'PDF' ||
                $path_parts['extension'] == 'bmp' || $path_parts['extension'] == 'BMP' ||
                $path_parts['extension'] =='tif' || $path_parts['extension'] =='TIF') && !$file_exists) {
                
                // If file does not exists then upload
                $data = array(
                    'entity_id' => $entity_id,
                    'entity_type' => $entity_type,
                    'document_name' => $this->input->post('document_name'),
                    'workshop_id' => $this->session->userdata('work_shop_id'),
                    'w_branch_id' => $this->session->userdata('branch_id'),
                    'url_key' => $url_key,
                    'upload_date_created' => date('Y-m-d'),
                    'upload_created_by' => $this->session->userdata('user_id'),
                    'upload_modified_by' => $this->session->userdata('user_id'),
                    'file_name_original' => $fileName,
                    'file_name_new' => $tempFileName
                );
                    
                    
                $uploaded_id = $this->mdl_uploads->create($data);
                    
                move_uploaded_file($tempFile, $targetFile);
                    
                echo json_encode([
                    'success' => true,
                    'temp_file_name' => $tempFileName,
                    'upload_id' => $uploaded_id,
                    'url_key' => $url_key
                ]);
                
            } else {
                
                // If file exists then echo the error and set a http error response
                echo json_encode([
                    'success' => false,
                    'message' => trans('error_duplicate_file')
                ]);
                //http_response_code(404);
            }

        } else {
            Upload::show_files($url_key, $customerId);
        }
    }

    public function create_dir($path, $chmod = '0777')
    {
        if (!(is_dir($path) || is_link($path))) {
            return mkdir($path, $chmod);
        } else {
            return false;
        }
    }

    public function show_files($url_key, $customerId = null)
    {
        $result = array();
        $path = $this->targetPath;

        $files = scandir($path);

        if ($files !== false) {

            foreach ($files as $file) {
                if (in_array($file, array(".", ".."))) {
                    continue;
                }
                if (strpos($file, $url_key) !== 0) {
                    continue;
                }
                if (substr(realpath($path), realpath($file) == 0)) {
                    $obj['name'] = substr($file, strpos($file, '_', 1) + 1);
                    $obj['fullname'] = $file;
                    $obj['size'] = filesize($path . '/' . $file);
                    $obj['fullpath'] = $path . '/' . $file;
                    $result[] = $obj;
                }
            }

        } else {
            return;
        }

        echo json_encode($result);
    }

    public function delete_file($url_key)
    {
        $path = $this->targetPath;
        $fileName = $_POST['name'];

        $this->mdl_uploads->delete_file($url_key, $fileName);

        // AVOID TREE TRAVERSAL!
        $finalPath = $path . '/' . $url_key . '_' . $fileName;

        if (strpos(realpath($path), realpath($finalPath)) == 0) {
            unlink($path . '/' . $url_key . '_' . $fileName);
        }
    }

    public function get_file($filename)
    {
        $base_path = UPLOADS_FOLDER . 'customer_files/';
        $file_path = $base_path . $filename;

        if (strpos(realpath($base_path), realpath($file_path)) != 0) {
            show_404();
            exit;
        }

        $path_parts = pathinfo($file_path);
        $file_ext = $path_parts['extension'];

        if (file_exists($file_path)) {
            $file_size = filesize($file_path);

            $save_ctype = isset($this->content_types[$file_ext]);
            $ctype = $save_ctype ? $this->content_types[$file_ext] : $this->ctype_default;

            header("Expires: -1");
            header("Cache-Control: public, must-revalidate, post-check=0, pre-check=0");
            header("Content-Disposition: attachment; filename=\"$filename\"");
            header("Content-Type: " . $ctype);
            header("Content-Length: " . $file_size);

            echo file_get_contents($file_path);
            exit;
        }

        show_404();
        exit;
    }
    
    public function getDeleteUploadData(){
        $upload_id = $this->input->post('upload_id');
        $upload_type = $this->input->post('upload_type');
        $entity_id = $this->input->post('entity_id');
        $entity_type = $this->input->post('entity_type');
        $url_key = $this->input->post('url_key');
        $fileName = $this->input->post('file_name');
        
        if($upload_type == 'D'){

            $path = $this->targetPath;    
            $this->mdl_uploads->delete_file($url_key, $fileName);
    
            // AVOID TREE TRAVERSAL!
            $finalPath = $path . '/' . $url_key . '_' . $fileName;

            if (strpos(realpath($path), realpath($finalPath)) == 0) {
                unlink($path . '/' . $url_key . '_' . $fileName);
            }

            $this->db->where('upload_id', $upload_id);
            $this->db->delete('ip_uploads');
        }
        
        $result = $this->db->select('*')->from('ip_uploads')->where('workshop_id', $this->session->userdata('work_shop_id'))->where('w_branch_id', $this->session->userdata('branch_id'))->where('entity_type', $entity_type)->where('url_key', $url_key)->order_by('upload_id', 'desc' )->get()->result();
        
        $response = array(
            'success' => 1,
            'doclist' => $result
        );
        
        echo json_encode($response);
    }

    public function upload_multiple_file($s_pack_id,$package_type, $url_key)
    {
        if($package_type == 'SP'){
            $this->targetPath = UPLOADS_FOLDER . 'service_package';     
        }
        Upload::create_dir($this->targetPath . '/');
        
        if (count($_FILES) > 0) {
            if(isset($_FILES['iconfile'])){
                $icontempFile = $_FILES['iconfile']['tmp_name'][0];
                $iconfileName = preg_replace('/\s+/', '_', $_FILES['iconfile']['name'][0]);
                $icontargetFile = $this->targetPath . '/' . $url_key . '_' . $iconfileName;
                $iconfile_exists = file_exists($icontargetFile);
                $icontempFileName = $url_key . '_' . $iconfileName;
                $path_parts = pathinfo($icontargetFile);
                if(($path_parts['extension'] == 'jpeg' || $path_parts['extension'] == 'JPEG' || 
                    $path_parts['extension'] == 'png' || $path_parts['extension'] == 'PNG' ||
                    $path_parts['extension'] == 'jpg' || $path_parts['extension'] == 'JPG' ||
                    $path_parts['extension'] == 'gif' || $path_parts['extension'] == 'GIF' ||
                    $path_parts['extension'] == 'tiff' || $path_parts['extension'] == 'TIFF' ||
                    $path_parts['extension'] == 'pdf' || $path_parts['extension'] == 'PDF' ||
                    $path_parts['extension'] == 'bmp' || $path_parts['extension'] == 'BMP' ||
                    $path_parts['extension'] =='tif' || $path_parts['extension'] =='TIF') && !$iconfile_exists) {

                    if($package_type == 'SP'){
                        $data = array(
                            'icon_image'  => 'uploads/service_package/'.$icontempFileName,
                        );
                    }
                        
                    $uploaded_id = $this->mdl_service_package->save($s_pack_id,$data);
                    move_uploaded_file($icontempFile, $icontargetFile);
                }
            }

            if(isset($_FILES['bannerfile'])){
                $bannertempFile = $_FILES['bannerfile']['tmp_name'][0];
                $bannerfileName = preg_replace('/\s+/', '_', $_FILES['bannerfile']['name'][0]);
                $bannertargetFile = $this->targetPath . '/' . $url_key . '_' . $bannerfileName;
                $bannerfile_exists = file_exists($bannertargetFile);
                $bannertempFileName = $url_key . '_' . $bannerfileName;
                $path_parts = pathinfo($bannertargetFile);
                if(($path_parts['extension'] == 'jpeg' || $path_parts['extension'] == 'JPEG' || 
                    $path_parts['extension'] == 'png' || $path_parts['extension'] == 'PNG' ||
                    $path_parts['extension'] == 'jpg' || $path_parts['extension'] == 'JPG' ||
                    $path_parts['extension'] == 'gif' || $path_parts['extension'] == 'GIF' ||
                    $path_parts['extension'] == 'tiff' || $path_parts['extension'] == 'TIFF' ||
                    $path_parts['extension'] == 'pdf' || $path_parts['extension'] == 'PDF' ||
                    $path_parts['extension'] == 'bmp' || $path_parts['extension'] == 'BMP' ||
                    $path_parts['extension'] =='tif' || $path_parts['extension'] =='TIF') && !$bannerfile_exists) {

                    if($package_type == 'SP'){
                        $data = array(
                            'banner_image'  => 'uploads/service_package/'.$bannertempFileName,
                        );
                    }

                    $uploaded_id = $this->mdl_service_package->save($s_pack_id,$data);
                    move_uploaded_file($bannertempFile, $bannertargetFile);
                }
            }
            echo json_encode([
                'success' => true,
                's_pack_id' => $s_pack_id,
            ]);
        }else{
            echo json_encode([
                'success' => false,
                'message' => trans('error_duplicate_file')
            ]);
        }
    }

    public function upload_offer_file($offer_id,$package_type, $url_key)
    {
        Upload::create_dir($this->targetPath . '/');
        if (count($_FILES) > 0) {
            if(isset($_FILES['offerfile'])){
                $offertempFile = $_FILES['offerfile']['tmp_name'][0];
                $offerfileName = preg_replace('/\s+/', '_', $_FILES['offerfile']['name'][0]);
                $offertargetFile = $this->targetPath . '/' . $url_key . '_' . $offerfileName;
                $offerfile_exists = file_exists($offertargetFile);
                $offertempFileName = $url_key . '_' . $offerfileName;
                $path_parts = pathinfo($offertargetFile);
                if(($path_parts['extension'] == 'jpeg' || $path_parts['extension'] == 'JPEG' || 
                    $path_parts['extension'] == 'png' || $path_parts['extension'] == 'PNG' ||
                    $path_parts['extension'] == 'jpg' || $path_parts['extension'] == 'JPG' ||
                    $path_parts['extension'] == 'gif' || $path_parts['extension'] == 'GIF' ||
                    $path_parts['extension'] == 'tiff' || $path_parts['extension'] == 'TIFF' ||
                    $path_parts['extension'] == 'pdf' || $path_parts['extension'] == 'PDF' ||
                    $path_parts['extension'] == 'bmp' || $path_parts['extension'] == 'BMP' ||
                    $path_parts['extension'] =='tif' || $path_parts['extension'] =='TIF') && !$offerfile_exists) {
                    $data = array(
                        'offer_image'  => base_url().'uploads/customer_files/'.$offertempFileName,
                    );
                    $uploaded_id = $this->mdl_offer_deals->save($offer_id,$data);
                    move_uploaded_file($offertempFile, $offertargetFile);
                }
            }
            echo json_encode([
                'success' => true,
                'offer_id' => $offer_id,
            ]);
        }else{
            echo json_encode([
                'success' => false,
                'message' => trans('error_duplicate_file')
            ]);
        }
    }
}
