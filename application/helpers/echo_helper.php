<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');



/**
 * Shorthand for htmlspecialchars()
 * @param $output
 * @return string
 */
function htmlsc($output)
{
    return htmlspecialchars($output, ENT_QUOTES);
}

/**
 * Echo something with escaped HTML special chars
 *
 * @param mixed $output
 */
function _htmlsc($output)
{
    echo htmlspecialchars($output, ENT_QUOTES);
}

/**
 * Echo something with escaped HTML entities
 *
 * @param mixed $output
 */
function _htmle($output)
{
    echo htmlentities($output);
}

/**
 * Echo a language string with the trans helper
 *
 * @param string $line
 * @param string $id
 * @param null|string $default
 */
function _trans($line, $id = '', $default = null)
{
    echo trans($line, $id, $default);
}
