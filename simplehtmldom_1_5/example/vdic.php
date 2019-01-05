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


<div id="tandp">
<div class="word_title">
	rabbit</div>

<div class="pronunciation">
<object type="application/x-shockwave-flash" data="http://static.vdict.com/assets/audioplayer.swf" width="152" height="21" id="flashcontent" style="visibility: visible;"><param name="wmode" value="transparent"><param name="allowFullScreen" value="false"><param name="flashvars" value="snd=http://static.vdict.com/audio/en/a/ada40cedfb6d22edc068b250f89dea2f.mp3&amp;title=listen"></object>
<div class="pronounce">/'ræbit/</div>
</div>
</div>