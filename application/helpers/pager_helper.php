<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

function pager($base_url, $model)
{

    $CI = &get_instance();
    $pager = '<span class="pageNationTotal">Showing '.(($CI->$model->next_offset - 15) + 1).' to ';

    if($CI->$model->get()->num_rows() > $CI->$model->next_offset ){ 
        $pagers = $CI->$model->next_offset;
    }else{ 
        $pagers = $CI->$model->get()->num_rows();
    }
    $pager .= $pagers.' of <span class="pageNationColor">'.$CI->$model->get()->num_rows().'</span> entries </span>';

    $pager .= '<div class="model-pager btn-group btn-group-sm">';
        
    if (($previous_page = $CI->$model->previous_offset) >= 0) {
        $pager .= '<a class="btn btn-default" href="' . $base_url . '/0" title="' . trans('first') . '"><i class="fa fa-fast-backward no-margin"></i></a>';
        $pager .= '<a class="btn btn-default" href="' . $base_url . '/' . $CI->$model->previous_offset . '" title="' . trans('prev') . '"><i class="fa fa-backward no-margin"></i></a>';
    } else {
        $pager .= '<a class="btn btn-default disabled" href="#" title="' . trans('first') . '"><i class="fa fa-fast-backward no-margin"></i></a>';
        $pager .= '<a class="btn btn-default disabled" href="#" title="' . trans('prev') . '"><i class="fa fa-backward no-margin"></i></a>';
    }
    if (($next_page = $CI->$model->next_offset) <= $CI->$model->last_offset) {
        $pager .= '<a class="btn btn-default" href="' . $base_url . '/' . $CI->$model->next_offset . '" title="' . trans('next') . '"><i class="fa fa-forward no-margin"></i></a>';
        $pager .= '<a class="btn btn-default" href="' . $base_url . '/' . $CI->$model->last_offset . '" title="' . trans('last') . '"><i class="fa fa-fast-forward no-margin"></i></a>';
    } else {
        $pager .= '<a class="btn btn-default disabled" href="#" title="' . trans('next') . '"><i class="fa fa-forward no-margin"></i></a>';
        $pager .= '<a class="btn btn-default disabled" href="#" title="' . trans('last') . '"><i class="fa fa-fast-forward no-margin"></i></a>';
    }
    $pager .= '</div>';

    return $pager;
}
