<?php
require ('phpQuery.php');
header("Content-type: text/html; charset=utf-8");

//$url = "new2.html";
$url = "dt.htm";
$page_content = file_get_contents($url);

$html = phpQuery::newDocument($page_content);
$divs =  $html->find('div.itemlist-item-text-wrapper');
foreach($divs as $div){
	$div_link = pq($div) ;
	$title = $div_link->find('span.itemlist-item-title-text')->text();
	$person = $div_link->find('span.itemlist-item-person a')->text();
	$tdate = $div_link->find('span.itemlist-item-date-title')->text();
	$type = $div_link->find('span.itemlist-item-category')->text();
	echo $title." - ".$person." - ".$tdate." - ".$type."<br>";
}
?>