<?php

/**
 * @author Jackie Do
 * @copyright 2013
 */

function valid_user($text) {
    global $user_min_len, $invalid_char;
    if (mb_strlen($text,"UTF-8") < $user_min_len) {
        return false;
    }
    foreach ($invalid_char as $item) {
        if (mb_strpos($text, $item, 0, "UTF-8") !== false) {
            return false;
            break;
        }
    }
    return true;
}

?>