<?php
// Test the stickyness of filters using cookies instead of session variables
require(__DIR__."/../classes/thp_classes.php");
$page=new Page;
$page->start("Test sticky filters!");
$filter=new Filter;
$filter->start();
$filter->toggle
$filter->end();
$page->end();
