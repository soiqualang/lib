<?php
set_time_limit(0);
$timezone = "Asia/Ho_Chi_Minh";
if(function_exists('date_default_timezone_set')) date_default_timezone_set($timezone);
include('../simple_html_dom.php');
function convert_vi_to_en($str) {
	$str = preg_replace("/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/", 'a', $str);
	$str = preg_replace("/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/", 'e', $str);
	$str = preg_replace("/(ì|í|ị|ỉ|ĩ)/", 'i', $str);
	$str = preg_replace("/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/", 'o', $str);
	$str = preg_replace("/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/", 'u', $str);
	$str = preg_replace("/(ỳ|ý|ỵ|ỷ|ỹ)/", 'y', $str);
	$str = preg_replace("/(đ)/", 'd', $str);
	$str = preg_replace("/(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)/", 'a', $str);
	$str = preg_replace("/(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)/", 'E', $str);
	$str = preg_replace("/(Ì|Í|Ị|Ỉ|Ĩ)/", 'I', $str);
	$str = preg_replace("/(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)/", 'o', $str);
	$str = preg_replace("/(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)/", 'U', $str);
	$str = preg_replace("/(Ỳ|Ý|Ỵ|Ỷ|Ỹ)/", 'Y', $str);
	$str = preg_replace("/(Đ)/", 'D', $str);
	//$str = str_replace(" ", "-", str_replace("&*#39;","",$str));
	 
	return $str;	 
}
function laytin($host,$url,$key){
//$host=http://www.dost.danang.gov.vn
//$url=http://www.dost.danang.gov.vn/danh-sach-tin?idcat=12538
//$key=div.tintuc_body_head
	$arr1=array('mo thau','dau thau','chao gia','goi thau','gis','tuyen chon','to chuc','ca nhan','chu tri','nhiem vu','chon lua','dat hang','de xuat','xay dung','de tai','kh&cn');
	$html = file_get_html($url);
	$j=0;
	foreach($html->find($key) as $e){
		foreach($e->find('a') as $e1){
			$atxt=$e1->plaintext;
			$alink=$e1->href;
			for($i=0;$i<count($arr1);$i++){
				if (preg_match("/$arr1[$i]/", convert_vi_to_en($atxt), $matches)){
					//echo $matches[0];
					echo '<a href='.$host.$alink.' target="_blank">'.$atxt.'</a><br>';
					$j++;
					if($j=1){
						break;
						$j=0;
					}
				}
			}
		}
	}
}

laytin('http://www.dost.danang.gov.vn','http://www.dost.danang.gov.vn/danh-sach-tin?idcat=12538','div.tintuc_body_head');
laytin('','https://www.dost-dongnai.gov.vn/Pages/default.aspx','div#ctl00_ctl28_g_a48d72ca_b191_4033_b3f8_710e25f03499_ctl02_UpdatePanel1');
laytin('','http://ngheandost.gov.vn/','div.lstmarquee');
//laytin('http://sokhcn.angiang.gov.vn','http://sokhcn.angiang.gov.vn/wps/portal/','div.wpsPortletBody');

?>

