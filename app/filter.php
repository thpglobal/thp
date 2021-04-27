<?php
require(__DIR__."/../classes/thp_classes.php"); // Load the classes
$page=new Page;
$page->start("Demo Filter and Form");
$filter=new Filter;
$filter->start();
$pairs=["1"=>"One","2"=>"Two","3"=>"Three"];
$filter->pairs("first",$pairs);
$filter->pairs("second",$pairs);
$filter->pairs("third",$pairs);
$filter->end();

$form=new Form();
$form->text("First Name");
$form->text("Last Name");
$form->date("Date of Birth");
$form->end();
$page->end();
