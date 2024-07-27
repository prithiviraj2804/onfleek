<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');



/**
 * Output the amount as a currency amount, e.g. 1.234,56 €
 *
 * @param $amount
 * @return string
 */
function format_currency($amount)
{
    global $CI;
    $currency_symbol = $CI->mdl_settings->setting('currency_symbol');
    $currency_symbol_placement = $CI->mdl_settings->setting('currency_symbol_placement');
    $thousands_separator = $CI->mdl_settings->setting('thousands_separator');
    $decimal_point = $CI->mdl_settings->setting('decimal_point');

    if ($currency_symbol_placement == 'before') {
        return $currency_symbol . number_format($amount, ($decimal_point) ? 2 : 0, $decimal_point, $thousands_separator);
    } elseif ($currency_symbol_placement == 'afterspace') {
        return number_format($amount, ($decimal_point) ? 2 : 0, $decimal_point, $thousands_separator) . '&nbsp;' . $currency_symbol;
    } else {
        return number_format($amount, ($decimal_point) ? 2 : 0, $decimal_point, $thousands_separator) . $currency_symbol;
    }
}

/**
 * Output the amount as a currency amount, e.g. 1.234,56
 *
 * @param null $amount
 * @return null|string
 */
function format_amount($amount = null)
{
    if ($amount) {
        $CI =& get_instance();
        $thousands_separator = $CI->mdl_settings->setting('thousands_separator');
        $decimal_point = $CI->mdl_settings->setting('decimal_point');

        return number_format($amount, ($decimal_point) ? 2 : 0, $decimal_point, $thousands_separator);
    }
    return null;
}

/**
 * Standardize an amount based on the system settings
 *
 * @param $amount
 * @return mixed
 */
function standardize_amount($amount)
{
    $CI =& get_instance();
    $thousands_separator = $CI->mdl_settings->setting('thousands_separator');
    $decimal_point = $CI->mdl_settings->setting('decimal_point');

    $amount = str_replace($thousands_separator, '', $amount);
    $amount = str_replace($decimal_point, '.', $amount);

    return $amount;
}

function format_money($num,$decimal_point) {
    
    if($num==0)
    {
        $num="0";
    }
    
    if($num != ''){
        $sign = NULL;
        if($num == 0 || $num == '0'){
            $num = '0.00';
        }
        if($decimal_point == '' || $decimal_point == '0' || $decimal_point == 0 || $decimal_point == NULL){
            $decimal_point = 2;
        }
        $tokens = array();
        if($decimal_point == 3){
            $append_decimal = '000';
        }else{
            $append_decimal = '00';
        }
        
        $s=substr($num,0,1);
        if ($s=='-') {
            $sign= '-';
            $num = substr($num,1);
        }
        $num=explode('.',$num);
        if (count($num)>1){
            $append_decimal=explode('.',number_format('.'.$num[1],$decimal_point))[1];
        }
        if (strlen($num[0])<4) return $sign . $num[0] . '.' . $append_decimal;
        $hundreds=substr($num[0],-3);
        $thousands=substr($num[0],0,-3);
        while(strlen($thousands)>0){
            $tokens[]=substr($thousands,-2);
            $thousands=substr($thousands,0,-2);
        }
        return $sign.implode(',',array_reverse($tokens)).','.$hundreds.'.'.$append_decimal;
    }else{
        return "";
    }
    
}
