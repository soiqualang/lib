<?php
include('../simple_html_dom.php');
$html = file_get_html('http://www.kttv-nb.org.vn/');
$arraylinks=array();
$j=0;
foreach($html->find('div#news_bar8') as $e1){
    //echo $e->innertext . '<br>';
	foreach($e1->find('a') as $e){
		//echo $e->href . '<br>';
		$arraylinks[$j]='http://www.kttv-nb.org.vn'.($e->href);
		$j++;
	}
}
echo $arraylinks[0].'<br>';
//--------------------lay noi dung-------------------------------
$html = file_get_html($arraylinks[0]);
//$html = file_get_html('http://localhost:999/girs/htmlphp/simplehtmldom_1_5/example/thuyvan/dubao.html');
$arraye=array();
$i=0;
//$i=-1;//thay doi de nhan dung gia tri
foreach($html->find('table') as $ehtml){
    //echo $e->innertext . '<br>';
	foreach($ehtml->find('td') as $element){
       //echo $element->innertext . '>><br>';
		//$arraye[$i]=($element->innertext);
		$arraye[$i]=trim($element->plaintext);
		$i++;
	}
}
//echo $arraye[36].'<br>';
for($n=0;$n<=count($arraye);$n++){
	if($arraye[$n]=='Tân Châu'){
		echo $n.'<br>';
		break;
	}
}
for($k=41;$k<=65;$k+=12){
	echo $arraye[$k+($n-36)].'<br>';
}
for($k=84;$k<=144;$k+=12){
	echo $arraye[$k+($n-36)].'<br>';
}
for($k=163;$k<=223;$k+=12){
	echo $arraye[$k+($n-36)].'<br>';
}
?>