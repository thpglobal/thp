<?php

class Chart{
	public $ncharts=0; // count
	public $color='white'; // default text color, defines regular page from dashboard dark page
	public $db=NULL;
	public $options="scales:{xAxes:[{gridLines:{color:'yellow'}}],yAxes:[{ticks:{beginAtZero:true},gridLines:{color:'yellow'}}]}\n";
	public function start($db=NULL, $color='white'){ // color not yet implmented
		$this->db=$db;
		$this->color=$color;
		echo("<script src=https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.min.js></script>\n");
		echo("<script>\n");
		echo("Chart.defaults.global.responsive = true;\n");
		echo("Chart.defaults.global.defaultColor = 'white';\n");
		echo("Chart.defaults.global.defaultFontColor = 'white';\n");
		echo("Chart.defaults.global.tooltips.backgroundColor = '#fff';\n");
		echo("Chart.defaults.global.tooltips.titleFontColor = 'black';\n");
		echo("Chart.defaults.global.tooltips.bodyFontColor = 'black';\n");
		echo("Chart.defaults.global.animation.duration = 1500;\n");
		echo("Chart.defaults.global.animation.easing = 'easeInOutQuart';\n");
		echo("Chart.defaults.global.maintainAspectRatio = true;\n");
		echo("Chart.defaults.global.legend.display = false;\n");
		echo("var ChartOptions = {".$this->options."};\n</script>\n");
		echo("<div class=pure-g>\n");
	}
	public function end() { echo("</div>\n"); }
	public function query($n,$title,$query) {
		if($this->db==NULL) Die("You forgot the Chart::start($db) method.");
		$pdo_stmt=$this->db->query($query);
		while($line=$pdo_stmt->fetch(PDO::FETCH_NUM)){ $x[]=$line[0];$y[]=$line[1];}	
		$this->make($n,$title,'bar',$x,$y);
	}
	public function make($n,$ctitle,$ctype,$x,$y){
		echo("<div class='pure-u-1-3'><h3>$ctitle</h3><canvas id=chart$n width=500 height=350></canvas></div>\n");
		echo("<script>\n");
		echo("var data$n = { \n");
		echo("  labels : ".json_encode($x).",\n");
		echo("  datasets : [{\n"); 
		echo("	label: '$ctitle',\n");
		if( 'line' == $ctype ){
			echo("	fill: false,\n");
    	}else{
    		echo("	fill: true,\n");
    	}
		echo("	backgroundColor: 'lightgreen',\n");
		echo("	borderWidth: 2,\n	borderColor: 'lightgreen',\n");
		echo("	pointBorderColor: 'lightgreen',\n");
		echo("	data: ".json_encode($y)."\n	} \n], \n}; \n");
		echo("var c$n = document.getElementById('chart".$n."').getContext('2d');\n");
 		echo("var cc$n = new Chart(c$n,{ type: '$ctype', data: data$n, options: ChartOptions } );\n");
 		echo("</script>\n");
	}
	public function show($title="Sample",$type="Radar",$data=array("A"=>1,"B"=>2,"C"=>3)) {
		if($this->ncharts==0) echo ("<script src=https://cdnjs.cloudflare.com/ajax/libs/Chart.js/1.1.1/Chart.min.js></script>\n");
		$this->ncharts++;
		$n=$this->ncharts; // handy shorthand
		echo("<div style='width:420; float:left;'><h3>$title</h3><canvas id=chart$n width=400 height=300></canvas></div>\n");
		echo("<script>\n");
		echo("var data$n = {\n");
		foreach($data as $key=>$value) {
			$labels[]=$key;
			$y[]=$value;
		}
		echo("labels : ".json_encode($labels).",\n");
		echo("datasets : [\n{\n");
		echo("label : ".json_encode($title).",\n");
		echo("fillColor : '{$this->fill}',\n");
		echo("strokeColor : '{$this->stroke}',\n");
		echo("pointColor : '{$this->point}',\n");
		echo("pointStrokeColor : '{$this->pointStroke}',\n");
		echo("data : ".json_encode($y)."\n}]}\n");
		echo("var c$n = document.getElementById('chart$n').getContext('2d');\n");
		echo("new Chart(c$n).$type(data$n);\n</script>\n");
	}
}
?>