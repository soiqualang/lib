<?php
include('../simple_html_dom.php');
// Create DOM from URL or file
$html = file_get_html('http://vdict.com/rabbit,1,0,0.html');
/* foreach($html->find('script[type=text/javascript]') as $e){
    echo $e->outertext . '<br>';
	}
foreach($html->find('div#tandp') as $e)
    echo $e->outertext . '<br>';
foreach($html->find('div.pronunciation') as $e)
    echo $e->outertext . '<br>'; */
foreach($html->find('div#lookup-contents-wrap') as $e)
    echo $e->outertext . '<br>';
?>