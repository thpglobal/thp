<?php
// This is used only when the package is used standalone 

/* Sample Menu items */
$menu=["Home"=>"/",
	"Test Dropdown"=>["Test 1"=>"1","Test 2"=>"2","Test 3"=>"3"],
	"Countries"=>"countries",
	"Three"=>"three",
	"Export"=>"export",
	"Import"=>"upload",
	"Query"=>"query",
	"Session"=>"session",
	"List"=>"list"
];
$_SESSION["menu"]=$menu;
