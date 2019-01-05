<?php
$mailRule  = '/^[a-z][a-z0-9]*(_[a-z0-9]+)*(\.[a-z0-9]+)*@[a-z0-9]([a-z0-9-][a-z0-9]+)*(\.[a-z]{2,4}){1,2}$/';
$phoneRule = '/^(09|012|016|018|019)[0-9]{8}$/';
$timeRule  = '/^(\d{2}):(\d{2})$/';
$seriRule = '/^[a-zA-Z0-9]{6}$/';
$nameRule = '/^[a-z\d_]{2,20}$/i';
$current_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
define('GUSER', '');
define('GPWD', '');
function smtpmailer($to, $from="", $from_name="", $subject, $body) {
    global $error;
    $mail = new PHPMailer();
    $mail->IsSMTP();
    $mail->SMTPDebug = 1;
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = 'ssl';
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 465;
    $mail->Username = GUSER;
    $mail->Password = GPWD;
    $mail->SetFrom($from, $from_name);
    $mail->Subject = $subject;
    $mail->Body = $body;
    $sql = "SELECT mail FROM ub0oi_sendmail";
	$query = mysql_query($sql);
	$data = mysql_fetch_assoc($query);
    while ($data = mysql_fetch_assoc($query)) {
    	$mail->AddAddress($data["mail"]);
    }
	$mail->addReplyTo($from, '');
    if(!$mail->Send()) {
        $error = 'Gởi mail bị lỗi: '.$mail->ErrorInfo;
    } else {
        $error = 'thư của bạn đã được gởi đi ';
    }
}



function cutString($string,$size,$type=' ...') {
    $string2 = strip_tags($string);
    $string = trim($string);
    $str_str = strlen($string);
    $str_str2 = strlen($string2);
    $size = ($str_str-$str_str2)+$size;
    $str = substr($string,$size,20);
    $exp = explode(" ",$str);
    $sum =  count($exp);
    $yes= "";
    for($i=0;$i<=$sum-1;$i++)
    {
        if($yes==""){
            $a = strlen($exp[$i]);
            if($a==0){ $yes="no"; $a=0;}
            if(($a>=1)&&($a<=12)){ $yes = "no"; $a;}
            if($a>12){ $yes = "no"; $a=12;}
        }
    }
    $sub = substr($string,0,$size+$a);
    if($str_str2-$size>0){ $sub.= $type;}
    return $sub;
}

function GetCategories_Langguage($lang, $prefix, $id,$ref_table,  $ref){
	//$ref = alias | title
	//$lang = 1:Eng		2:Vi-vn
	$qr = "
	SELECT F.value AS data FROM ".$prefix.$ref_table." AS C, ".$prefix."falang_content AS F
	WHERE C.id = F.reference_id
	AND C.id = $id
	AND reference_field = '$ref'
	AND reference_table='$ref_table'
	AND F.published=1
	AND F.language_id=$lang
	";
	$rows = mysql_query($qr);
	if(mysql_num_rows($rows)==1){
		$row = mysql_fetch_array($rows);
		$kq = $row["data"];
	}else{
		$qr = "
		SELECT * FROM rgvwk_".$ref_table."
		WHERE id='$id'
		";
		$rows = mysql_query($qr);
		$row = mysql_fetch_array($rows);
		$kq = $row["title"];
	}
	return $kq;
}

function layThamSo($images, $name){
	$images   = strstr($images, $name);
	$a        = strpos($images, ':"');
	$b        = strpos($images, '",');
	$dai      = $b - $a;
	$chuoimoi = substr($images, $a+2, $dai-2);
	return str_replace("\\", "", $chuoimoi);
}

function Download_Limit_Time_Khoaphp($local_file, $download_file, $download_rate) {
	set_time_limit(0);
	if(file_exists($local_file) && is_file($local_file)) {
		header('Cache-control: private');
		header('Content-Type: application/octet-stream');
		header('Content-Length: '.filesize($local_file));
		header('Content-Disposition: filename='.$download_file);
		flush();
		$file = fopen($local_file, "r");
		while (!feof($file)) {
			print fread($file, round($download_rate * 1024));
			flush();
			sleep(1);
		}
		fclose($file);
	} else {
		die('Loi: File '.$local_file.' Khong Ton Tai!');
	}
}
function download_ebook_pro ($path) {
	//$path = 'jquery-1.11.1.min.zip'; // the file made available for download via this PHP file
	$mm_type="application/octet-stream"; // modify accordingly to the file type of $path, but in most cases no need to do so

	header("Pragma: public");
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Cache-Control: public");
	header("Content-Description: File Transfer");
	header("Content-Type: " . $mm_type);
	header("Content-Length: " .(string)(filesize($path)) );
	header('Content-Disposition: attachment; filename="'.basename($path).'"');
	header("Content-Transfer-Encoding: binary\n");

	readfile($path); // outputs the content of the file

	exit();
}

function stripUnicode($str){
  if(!$str) return false;
   $unicode = array(
		'a' =>'á|à|ả|ã|ạ|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ',
		'A' =>'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ằ|Ẳ|Ẵ|Ặ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
		'd' =>'đ',
		'D' =>'Đ',
		'e' =>'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',
		'E' =>'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
		'i' =>'í|ì|ỉ|ĩ|ị',
		'I' =>'Í|Ì|Ỉ|Ĩ|Ị',
		'o' =>'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',
		'O' =>'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
		'u' =>'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',
		'U' =>'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
		'y' =>'ý|ỳ|ỷ|ỹ|ỵ',
		'Y' =>'Ý|Ỳ|Ỷ|Ỹ|Ỵ'
   );
	foreach($unicode as $khongdau=>$codau) {
		$arr=explode("|",$codau);
		$str = str_replace($arr,$khongdau,$str);
	}
	return $str;
}

function changeTitle($str){
	$str=trim($str);
	if ($str=="") return "";
	$str =str_replace('"','',$str);
	$str =str_replace("'",'',$str);
	$str = stripUnicode($str);
	$str = mb_convert_case($str,MB_CASE_LOWER,'utf-8');
	// MB_CASE_UPPER / MB_CASE_TITLE / MB_CASE_LOWER
	$str = str_replace(' ','-',$str);
	return $str;
}

function mail_utf8($to, $from_user, $from_email, $subject = '(No subject)', $message = ''){
	$from_user = "=?UTF-8?B?".base64_encode($from_user)."?=";
	$subject = "=?UTF-8?B?".base64_encode($subject)."?=";
	$headers = "From: $from_user <$from_email>\r\n".
               "MIME-Version: 1.0" . "\r\n" .
               "Content-type: text/html; charset=UTF-8" . "\r\n";
	return mail($to, $subject, $message, $headers);
}

function PhatSinhRandomKey(){
	$s = "";
	$m = array(0,1,2,3,4,5,6,7,8,9,"a", "b", "c", "d", "e", "f", "g","h","i");
	for($i=1; $i<=32; $i++){
		$r = rand(0, count($m)-1);
		$s = $s . $m[$r];
	}
	return $s;
}
function testString ($str) {
	$chuoi = trim(mysql_real_escape_string(strip_tags($str)));
	return $chuoi;
}
function fetchRow ($sql) {
	$query = mysql_query($sql);
	$data = mysql_fetch_assoc($query);
	return $data;
}
function fetchData ($sql) {
	$query = mysql_query($sql);
	$data = array();
	while ($row = mysql_fetch_assoc($query)) {
		$data[] = $row;
	}
	return $data;
}
function changeStr ($str) {
	$str = ucwords(mb_strtolower($str,'utf8'));
	return $str;
}
function check_ext ($filename = "0150823_114415.jpg") {
	$pos = strrpos(".", $filename) + 1;
	$ext = substr($filename, $pos);
	return $ext;
}
function get_time ($datetime,$muigio = 7) {
	$datetime = gmdate("H:i:s | d-m-Y ", $datetime + 3600*($muigio+date("I")));
	return $datetime;
}
function getExt ($file) {
	$pos = strrpos(".", $file) + 1;
	$ext = substr($pos, $pos);
	$ext_array = array("jpg","png","jpeg");
	if (!in_array($ext_array,$ext)) {
		echo "1";
	} else {
		echo "2";
	}
}
/************************************************************************************************************************/
function nav () {
	$sql = "SELECT * FROM category WHERE parent_id = 0 ORDER BY pos ASC";
	return fetchData($sql);
}
function navlv2 ($id) {
	$sql = "SELECT * FROM category WHERE parent_id = $id ORDER BY pos ASC";
	return fetchData($sql);
}
function news_loaitin ($id) {
	$sql = "SELECT * FROM category WHERE cate_id = $id";
	return fetchRow($sql);
}
function loaitin ($id,$par1,$par2) {
	$sql = "SELECT * FROM news WHERE cate_id = $id AND news_public = 'Y' OR cate_id in (SELECT cate_id FROM category WHERE parent_id = $id) ORDER BY news_id DESC LIMIT $par1,$par2";
	return fetchData($sql);
}
function page_loaitin ($id) {
	$sql = "SELECT COUNT(*) as tong FROM news WHERE cate_id = $id AND news_public = 'Y' OR cate_id in (SELECT cate_id FROM category WHERE parent_id = $id) ORDER BY news_id DESC";
	return fetchRow($sql);
}
function chitiettin ($id) {
	$sql = "SELECT * FROM news WHERE news_id = $id AND news_public = 'Y'";
	return fetchRow($sql);
}
function trangchu () {
	$sql = "SELECT * FROM news WHERE news_public = 'Y' ORDER BY news_id DESC LIMIT 6";
	return fetchData($sql);
}
function random_news () {
	$sql = "SELECT * FROM news WHERE news_public = 'Y' ORDER BY rand() LIMIT 5";
	return fetchData($sql);
}
function news_feature_top () {
	$sql = "SELECT * FROM news WHERE news_public = 'Y' AND news_feature = 1 ORDER BY news_id DESC LIMIT 1";
	return fetchRow($sql);
}
function news_feature_recent () {
	$sql = "SELECT * FROM news WHERE news_public = 'Y' AND news_feature = 1 ORDER BY news_id DESC LIMIT 1,4";
	return fetchData($sql);
}
function timkiem ($key,$lang) {
	$sql = "SELECT * FROM news WHERE news_title_$lang REGEXP '$key' OR news_intro_$lang REGEXP '$key' OR news_full_$lang REGEXP '$key' ORDER BY news_id DESC";
	return fetchData($sql);
}
function tongtintimkiem ($key,$lang) {
	$sql = "SELECT COUNT(*) as tong FROM news WHERE news_title_$lang REGEXP  '$key' OR news_intro_$lang REGEXP '$key' ORDER BY news_id DESC";
	return fetchRow($sql);
}
function breadcrumb_loaitin ($id) {
	$sql = "SELECT * FROM category WHERE cate_id = $id";
	return fetchRow($sql);
}
function breadcumb_tin ($id) {
	$sql = "SELECT * FROM news WHERE news_id = $id";
	return fetchRow($sql);
}
function list_cv () {
	$sql = "SELECT * FROM user ORDER BY user_id DESC";
	return fetchData($sql);
}
function chitiet_cv ($id) {
	$sql = "SELECT * FROM user WHERE user_id = $id";
	return fetchRow($sql);
}
function login ($user,$pass,$lang) {
	$sql = "SELECT * FROM user WHERE username = '$user' AND password = '$pass'";
	$query = mysql_query($sql);
	if (mysql_num_rows($query) == 0) {
		if ($lang == "en") {
			echo "<script>alert('This Account Not Exist')</script>";
		} else {
			echo "<script>alert('Tài Khoản Này Không Tồn Tại')</script>";
		}
	} else {
		$data_user = mysql_fetch_assoc($query);
		$_SESSION["user"] = $data_user["username"];
		$_SESSION["level"] = $data_user["level"];
		$_SESSION["hoten_vi"] = $data_user["hoten_vi"];
		$_SESSION["hoten_en"] = $data_user["hoten_en"];
		$_SESSION["idUser"] = $data_user["user_id"];
		header("Refresh:0");
		exit();
	}
}
function data_update ($id) {
	// Lấy thông tin người được sửa
	$sql_info = 'SELECT * FROM user WHERE user_id=' .$id;
	$query_info = mysql_query($sql_info);
	$data_info = mysql_fetch_assoc($query_info);
	return $data_info;
}
function banner () {
	$sql = "SELECT * FROM banner WHERE id = 1";
	return fetchRow($sql);
}
function lienhe () {
	$sql = "SELECT * FROM contact WHERE id = 1";
	return fetchRow($sql);
}
function menu_sub ($id) {
	$sql = "SELECT * FROM category WHERE parent_id = $id";
	return fetchData($sql);

}
?>