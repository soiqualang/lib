<?php

/**
 * @author Jackie Do
 * @copyright 2013
 */

// Kết nối MySQL DBMS
$conn = mysql_connect($hostname, $user_db, $pass_db);
mysql_select_db($db_name, $conn);
mysql_query("SET NAMES 'utf8'");
?>