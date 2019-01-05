<?php
/* // example of how to use basic selector to retrieve HTML contents
include('../simple_html_dom.php');
 
// get DOM from URL or file
$html = file_get_html('http://www.google.com/');

// find all link
foreach($html->find('a') as $e) 
    echo $e->href . '<br>';

// find all image
foreach($html->find('img') as $e)
    echo $e->src . '<br>';

// find all image with full tag
foreach($html->find('img') as $e)
    echo $e->outertext . '<br>';

// find all div tags with id=gbar
foreach($html->find('div#gbar') as $e)
    echo $e->innertext . '<br>';

// find all span tags with class=gb1
foreach($html->find('span.gb1') as $e)
    echo $e->outertext . '<br>';

// find all td tags with attribite align=center
foreach($html->find('td[align=center]') as $e)
    echo $e->innertext . '<br>';
    
// extract text from table
echo $html->find('td[align="center"]', 1)->plaintext.'<br><hr>';

// extract text from HTML
echo $html->plaintext; */

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
foreach($html->find('table[width=581]') as $ehtml){
    //echo $e->innertext . '<br>';
	foreach($ehtml->find('td') as $element){
       //echo $element->innertext . '>><br>';
		//$arraye[$i]=($element->innertext);
		$arraye[$i]=trim($element->plaintext);
		$i++;
	}
}
//echo $arraye[36];
for($k=0;$k<=count($arraye);$k++){
	echo $k.'--'.$arraye[$k].'<br>';
}
	
/* foreach($html->find('table[height=864]') as $e){
    echo $e->outertext . '<br>';
	} */

/* // Find all images 
foreach($html->find('img') as $element) 
       echo $element->src . '<br>';
 */
// Find all links
/* foreach($html->find('td') as $element) 
       echo $element->innertext . '>><br>'; */
?>