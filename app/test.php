<?php
// Test the stickyness of filters using cookies instead of session variables
require(__DIR__."/../classes/thp_classes.php");
$page=new Page;
$page->start("Test sticky filters!");
$filter=new Filter;
$filter->start();
echo("<p>Toggle: ".$filter->toggle("toggle")."</p>\n");
echo("<p>Year: ".$filter->range("year",2008,2030)."</p>\n");
$pairs=array("1"=>"Apple","2"=>"Banana","3"=>"Tomato");
echo("<p>Fruit: ".$filter->pairs("fruit",$pairs)."</p>\n");
$filter->end();
$page->end();
