<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');



/**
 * Returns all errors prepared for JSON
 * @return array
 */
function json_errors()
{
    // Think of a better name for this function. It doesn't return
    // json itself but is called from something which will.
    $return = array();

    foreach (array_keys($_POST) as $key) {
        if (form_error($key)) {
            $return[$key] = form_error($key);
        }
    }

    return $return;
}
