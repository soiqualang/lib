<?php

/**
 * @author Jackie Do
 * @copyright 2013
 */

// Kiểm tra quyền admin
session_start();
if (!isset($_SESSION["phpcb75_level"]) || $_SESSION["phpcb75_level"] != 1) {
    header("location: login.php");
    exit();
}

?>