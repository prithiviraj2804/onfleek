<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require 'xlsClasses/PHPExcel/IOFactory.php';

class Excel_Import {

    function __construct()
    {
             $CI =& get_instance();

             //load libraries
             $CI->load->database();
             $CI->load->library("session");
    }
        public function get_array($filepath=FALSE)
    {   
        // Raise memory limit (for big files)
        ini_set('memory_limit', '512M');
                if(! file_exists($filepath))
        {   
            return FALSE;
        }
        $exceldata = [];
     
     	$inputfiletype = PHPExcel_IOFactory::identify($filepath);
    	$objReader = PHPExcel_IOFactory::createReader($inputfiletype);
    	$objPHPExcel = $objReader->load($filepath);
        $sheet = $objPHPExcel->getSheet(0); 
        $highestRow = $objPHPExcel->getActiveSheet()->getHighestDataRow('A');
        $highestColumn = $objPHPExcel->getActiveSheet()->getHighestDataColumn();
		PHPExcel_Calculation::getInstance()->disableCalculationCache();
        $j=0;
		foreach ($sheet->getRowIterator() as $row) {
  			$cellIterator = $row->getCellIterator();
  			$cellIterator->setIterateOnlyExistingCells(false);
  			$i=0;
  			foreach ($cellIterator as $cell) {
				if (strstr($cell,'=')==true){
				    
				    $exceldata[$j][$i] = $cell->getOldCalculatedValue();
				}else{
				    $exceldata[$j][$i] = $cell->getCalculatedValue();
				}   
    			$i++;
  			}
  			$j++;
		}
			//print_r($exceldata);  
			//exit();       
           	return $exceldata;
    }
    
    public function get_array_config($filepath=FALSE)
    {
        // Raise memory limit (for big files)
        ini_set('memory_limit', '512M');
        if(! file_exists($filepath))
        {
            return FALSE;
        }
        $exceldata = [];
        $main_array=array();
        $inputfiletype = PHPExcel_IOFactory::identify($filepath);
        $objReader = PHPExcel_IOFactory::createReader($inputfiletype);
        $objPHPExcel = $objReader->load($filepath);
        $sheetCount = $objPHPExcel->getSheetCount();
        $sheetNames=$objPHPExcel->getSheetNames();
        $highestRow = $objPHPExcel->getActiveSheet()->getHighestDataRow('A');
        $highestColumn = $objPHPExcel->getActiveSheet()->getHighestDataColumn();
        PHPExcel_Calculation::getInstance()->disableCalculationCache();
        $j=0;
        
        for($m=0;$m<$sheetCount;$m++)
        {
            $exceldata =array();
            $sheet = $objPHPExcel->getSheet($m);
            
            foreach ($sheet->getRowIterator() as $row) {
                $cellIterator = $row->getCellIterator();
                $cellIterator->setIterateOnlyExistingCells(false);
                $i=0;
                foreach ($cellIterator as $cell) {
                    if (strstr($cell,'=')==true){
                        
                        $exceldata[$j][$i] = $cell->getOldCalculatedValue();
                    }else{
                        $exceldata[$j][$i] = $cell->getCalculatedValue();
                    }
                    $i++;
                }
                if($j>$highestRow)
                {
                    break;
                }
                else
                {
                    continue;
                }
            }
            array_push($main_array,$exceldata);
        }
        return $main_array;
    }
    
    public function get_excel_details($filepath=FALSE,$type,$sheetValue=0)
    {
        // Raise memory limit (for big files)
        ini_set('memory_limit', '512M');
        if(! file_exists($filepath))
        {
            return FALSE;
        }
        $main_array=array();
        $exceldata =[];
        $inputfiletype = PHPExcel_IOFactory::identify($filepath);
        $objReader = PHPExcel_IOFactory::createReader($inputfiletype);
        $objPHPExcel = $objReader->load($filepath);
        $sheetCount = $objPHPExcel->getSheetCount();
        $sheetNames=$objPHPExcel->getSheetNames();
        $sheet = $objPHPExcel->getSheet($sheetValue);
        $highestRow = $objPHPExcel->getActiveSheet()->getHighestDataRow('A');
        $highestColumn = $objPHPExcel->getActiveSheet()->getHighestDataColumn();
        PHPExcel_Calculation::getInstance()->disableCalculationCache();
        if($type=="config")
        {
            $main_array['sheetCount']=$sheetCount;
            $main_array['sheetNames']=$sheetNames;
            return $main_array;
        }
        else if($type=="headers")
        {
            $j=0;
            foreach ($sheet->getRowIterator() as $row) {
                $cellIterator = $row->getCellIterator();
                $cellIterator->setIterateOnlyExistingCells(false);
                $i=0;
                foreach ($cellIterator as $cell) {
                    if (strstr($cell,'=')==true){
                        $exceldata[$j][$i] = $cell->getOldCalculatedValue();
                    }else{
                        $exceldata[$j][$i] = $cell->getCalculatedValue();
                    }
                    $i++;
                }
                if($j<=$highestRow-1)
                {
                    $j++;
                }
            }
            return $exceldata;
        }
    }
}
 ?>