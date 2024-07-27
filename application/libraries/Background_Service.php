<?php  
if (!defined('BASEPATH')) exit('No direct script access allowed');
 
class Background_Service
{
    public function __construct()
    {
        $this->ci =& get_instance();
    }
 
    function do_in_background($url, $params)
    {
        $post_string = http_build_query($params);
        $parts = parse_url($url);
            $errno = 0;
        $errstr = "";
 
        $isSecure = false;
        if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') {
        	$isSecure = true;
        }
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https' || !empty($_SERVER['HTTP_X_FORWARDED_SSL']) && $_SERVER['HTTP_X_FORWARDED_SSL'] == 'on') {
        	$isSecure = true;
        }

        if($isSecure)
        {
        	$fp = fsockopen('ssl://' . $parts['host'], isset($parts['port']) ? $parts['port'] : 443, $errno, $errstr, 30);
        }
        else 
        {
        	$fp = fsockopen($parts['host'], isset($parts['port']) ? $parts['port'] : 80, $errno, $errstr, 30);
        }
        
        if(!$fp)
        {
            echo "Some thing Problem";    
        }
        $out = "POST ".$parts['path']." HTTP/1.1\r\n";
        $out.= "Host: ".$parts['host']."\r\n";
        $out.= "Content-Type: application/x-www-form-urlencoded\r\n";
        $out.= "Content-Length: ".strlen($post_string)."\r\n";
        $out.= "Connection: Close\r\n\r\n";
        if (isset($post_string)) $out.= $post_string;
        fwrite($fp, $out);
        fclose($fp);
  }
}
?>