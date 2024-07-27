<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');



/**
 * Get a setting value
 *
 * @param string $setting_key
 * @param mixed $default
 * @return string
 */
function get_setting($setting_key, $default = '', $escape = false)
{
    $CI = &get_instance();
    $value = $CI->mdl_settings->setting($setting_key, $default);
    return $escape ? htmlsc($value) : $value;
}

/**
 * Get the settings for a payment gateway
 *
 * @param string $gateway
 * @return array
 */
function get_gateway_settings($gateway)
{
    $CI = &get_instance();
    return $CI->mdl_settings->gateway_settings($gateway);
}

/**
 * Compares the two given values and outputs selected="selected"
 * if the values match or the operation is true for the single value
 *
 * Examples
 * check_select($option_key, 'key_1')           Checks if $option_key equals (==) 'key_1'.
 * check_select($option_key, 'key_1', '!=')     Checks if $option_key not equals (!=) 'key_1'.
 * check_select($option_key)                    The same like if ($option_key) { ...
 * check_select($option_key, null, 'e')         Checks if the $option_key value is empty.
 * check_select($option_key != 'key_1')         If the first param is bool, it is used to validate the select
 *
 * @param string|integer $value1
 * @param string|integer|null $value2
 * @param string $operator
 * @param bool $checked
 * @return void
 */
function check_select($value1, $value2 = null, $operator = '==', $checked = false)
{
    $select = $checked ? 'checked="checked"' : 'selected="selected"';

    // Instant-validate if $value1 is a bool value
    if (is_bool($value1) && $value2 === null) {
        echo $value1 ? $select : '';
        return;
    }

    switch ($operator) {
        case '==':
            $echo_selected = $value1 == $value2 ? true : false;
            break;
        case '!=':
            $echo_selected = $value1 != $value2 ? true : false;
            break;
        case 'e':
            $echo_selected = empty($value1) ? true : false;
            break;
        case '!e':
            $echo_selected = empty($value1) ? true : false;
            break;
        default:
            $echo_selected = $value1 ? true : false;
            break;
    }

    echo $echo_selected ? $select : '';
}

function send_sms($mobile_no, $txt){
    $Textlocal = new Textlocal(false, false, 'miCiwVC0Qqw-AxwSFxyezeeBIhTd0ihCM7KL2CsbT9');
     
    $numbers = array($mobile_no);
    $sender = 'MECHTZ';
    $message = $txt;
 	$msg = $Textlocal->sendSms($numbers, $message, $sender);
    return $msg;

}

function send_notification($data, $target, $notification_mobile_data){
	//$data = array('notification_type'=>'offer','post_title'=>'AC Service', 'post_desc'=>'Full AC Service at 1499 only');

	//$target = array('c_KbOXR8vB4:APA91bEIJrG_rvdB78pXgLb8TJ-TrLjskSKegy9GGeJAAxCRJcWvffquZgmV6RjQa5kB8zVjF2gTnFkdxQuBym4KgxNp291wnD2eF4gZrYVDEZoT86spy7jFo_JO7Shtj-0wNNsO83-Z');
		//FCM api URL
		$url = 'https://fcm.googleapis.com/fcm/send';
		//api_key available in Firebase Console -> Project Settings -> CLOUD MESSAGING -> Server key
		$server_key = 'AAAAj4aTr0I:APA91bH2pkjqMJb1xFmSOi5uUxhCaym2KUb4W61Kd3RP6Fz-N63lF1knAjjmRm_xqQj5wPOcTvj7CJ5Bx6pS_a0a-6yIh_TELNcEG9aY9MyxxdMVwffiVCZ671fQyXfeesCunNO6fTQH';
					
		$fields = array();
		$fields['data'] = $data;
		$fields['notification'] = $notification_mobile_data;
		if(is_array($target)){
			$fields['registration_ids'] = $target;
		}else{
			$fields['to'] = $target;
		}
		//header with content_type api key
		$headers = array(
			'Content-Type:application/json',
		  	'Authorization:key='.$server_key.''
		);
				
		// print_r(json_encode($fields));

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
		$result = curl_exec($ch);
		//print_r($result);
		if ($result === FALSE) {
			die('FCM Send Error: ' . curl_error($ch));
		}
		curl_close($ch);
		//return $result;
}