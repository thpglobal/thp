<?php
// Test the stickyness of filters using cookies instead of session variables
require(__DIR__."/../classes/thp_classes.php");

$pairs=array("1"=>"Apple","2"=>"Banana","3"=>"Tomato");

$page=new Page;
$page->start("Test sticky filters!");
$filter=new Filter;
$filter->start();
$fruit=$filter->pairs("fruit",$pairs)
$year=$filter->range("year",2008,2030);
$toggle=$filter->toggle("toggle");
echo("<p>Toggle: $toggle</p>\n");
echo("<p>Year: $year</p>\n");
echo("<p>Fruit $fruit: ".$pairs[$fruit]."</p>\n");
$filter->end();
$page->end();
