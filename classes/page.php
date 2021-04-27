<?php
// START CLASS PAGE
class Page {
	public $datatable = FALSE;
	public $addStickyHeader = TRUE;
	public $css=array("https://storage.googleapis.com/thp/thp.css"); // default used by all
	public $preh1=""; // used for dashboard colorbar etc
	public $time_start; // used to measure length for process
	public $links=array("print"=>"'javascript:window.print();'");
	public $hints=array("print"=>"Print this page");
	public $appendTitle='';
	public function debug($message,$values) {
		echo("<p>$message".":"); print_r($values); echo("</p>\n");
	}

	public function datatable(){
		$this->datatable=TRUE;
	}
	public function disableStickyHeader(){
		$this->addStickyHeader=FALSE;
	}

/* dynamic property setter/getter for this class */
	public function get($prop){
		if(isset($this->$prop)){
			return $this->$prop;
		}
		return NULL;
	}
	public function set($prop, $value){
		if(isset($this->$prop)){
			$this->$prop = $value;
		}
	}
	public function menu() { // new responsive version
		$menu=$_SESSION["menu"];
		if(isset($_SESSION["menu"]) and sizeof($menu)>0) { 
		?>
	<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
	<?php
foreach($menu as $key=>$item){
	if(is_array($item) ){
		echo('<li class="nav-item dropdown">');
        echo('<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">');
		echo($key."</a>\n");
		echo('<ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">');
		foreach($item as $b=>$a) echo("\t<li><a class='dropdown-item' href='$a'>".$b."</a></li>\n");
		echo("</ul>\n</li>\n");
	}else{
		echo("<li class='nav-item'><a class='nav-link' href='$item'>$key</a></li>\n");
	}
}
?>
	</ul>
	</div><!-- end collapsible bits -->
	</nav>
</div><!-- end container -->
<?php
		}
}	

public function start_light($title="THP",$lang="en") { // no menu, no icons, no datatable, no extras
	$this->time_start=microtime(true);
?>
<!DOCTYPE html>
<html lang=<?php echo $lang;?> >
<head>
	<meta name=viewport content='width=device-width, initial-scale=1'>
	<title><?php echo $title?></title>
	<meta name='description' content='$title built on opensource github.com/thpglobal/thpclasses'/>
	<link rel='shortcut icon' href='/static/favicon.png'>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
	<meta charset='utf-8'>
</head>
<body>
	<div class="container">
	<h1><?php $title?></h1>
	<?php
	} // end start_light


	public function start($title="THP",$lang="en"){
		$this->time_start=microtime(true);
		?>
		<!DOCTYPE html>
		<html lang=<?php echo $lang;?> >
		<head>
			<meta name=viewport content='width=device-width, initial-scale=1'>
			<title><?php echo $title?></title>
			<meta name='description' content='Built on opensource github.com/thpglobal/thp'/>
			<link rel='shortcut icon' href='/static/favicon.png'>
			<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
			<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css">
			<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
			<meta charset='utf-8'>
		</head>
		<body>
		<?php
		$this->menu();
        echo("<div class=container>\n");
//		echo($this->preh1); //used for dashboard colorbar or whatever
        echo("<h1>$title <span class=hidden-print>");
		foreach($this->links as $key=>$link) {
            $hint=$this->hints[$key];
            echo("<a href=$link class='bi bi-$key' title='$hint'></a>\n");
        }
        echo($this->appendTitle."</span></h1>\n");
		$reply=$_SESSION["reply"];
		if($reply>''){
			unset($_SESSION["reply"]); 
				$color="green";
				if(substr($reply,0,5)=="Error") $color="red";
			echo("<p style='text-align:center;color:white;background-color:".$color."'>$reply</p>\n");
		}
		
		echo("<div id='google_translate_element' style='position:absolute; top:4em; right:1em;'></div> 
			<script type='text/javascript'> 
				function googleTranslateElementInit() { 
					new google.translate.TranslateElement({pageLanguage: '$lang'}, 'google_translate_element'); 
				} 
			</script> 
		<script type='text/javascript' src='//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit'></script>");
	
	}
	public function icon($type="edit",$link="/edit",$hint="Edit this record"){
		$this->links[$type]=$link;
		$this->hints[$type]=$hint;
	}
	public function toggle($name,$on_msg='On',$off_msg='Off'){
		$now=$_SESSION[$name];
		if($now<>'off') $now='on'; // default is ON
		$then=($now=='on' ? 'off' : 'on');
		$this->appendTitle.="<a class='bi bi-toggle-$now' href='?$name=$then'></a> ";
		$this->appendTitle .= ($now=='on' ? $on_msg : $off_msg) ;
	}
	
	public function end($message=""){
		$time=microtime(true)-($this->time_start);
		echo("<p><i>$message Run time: $time</i></p>\n");
		echo("</div>\n");
        echo("</body></html>\n");
    }
}
// END CLASS PAGE
