<?php

/**
 * @author Jackie Do
 * @copyright 2013
 */

function get_file_ext($filename) {
    $dot_pos = strrpos($filename, ".");
    $ext = substr($filename, $dot_pos+1);
    $ext = strtolower($ext);
    return $ext;
}

?>