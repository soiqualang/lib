<?php

/**
 * @author Jackie Do
 * @copyright 2013
 */

function fix_upload_name($filename) {
    $text = mb_strtolower($filename, "UTF-8");
    $text = str_replace(" ", "_", $text);
    $text = time()."_".$text;
    return $text;
}

?>