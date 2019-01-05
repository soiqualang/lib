<?php
include('../simple_html_dom.php');
// Create DOM from URL or file
//--------------lay duong dan-------------------
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
//foreach($html->find('table[width=581]') as $ehtml){
foreach($html->find('table') as $ehtml){
    //echo $e->innertext . '<br>';
	foreach($ehtml->find('td') as $element){
       //echo $element->innertext . '>><br>';
		$arraye[$i]=($element->innertext);
		$i++;
	}
}
for($l=0;$l<=count($arraye);$l++){
	if($arraye[$l]=='Tân Châu'){
		echo $l.'<br>';
		break;
	}
}
//echo $arraye[36].'<br>';
for($k=0;$k<=count($arraye);$k++){
	echo $k.'--'.$arraye[$k+($l-36)].'<br>';
}
?>