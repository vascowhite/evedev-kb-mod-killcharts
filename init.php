<?php
/*
 * $Date$
 * $Revision$
 * $HeadURL$
 */

$modInfo['killcharts']['name'] = "killcharts by vasco di (V3.0)";
$modInfo['killcharts']['abstract'] = "Adds a graph of recent kills/losses to front page.";
$modInfo['killcharts']['about'] = "<a href='http://eve-id.net/forum/viewtopic.php?f=505&t=16828'>EveDev forum page</a><br>";
$modInfo['killcharts']['about'] .= "<a href='http://code.google.com/p/evedev-kb-mod-killcharts/'>Google Code</a><br/>";
$modInfo['killcharts']['about'] .= "<a href='http://www.rgraph.net' target='_blank'>Utilises the RGraph javascript charts library</a>";

include_once 'class.killchart.php';
event::register('home_assembling', 'kgraph::add');

class kgraph{
	
    static public function add($home){
    	$home->addBehind("contracts", "kgraph::generate");
    }
  	
  function generate(){
  		$killchart = new KillChart();
  		$html = $killchart->generate();
  		return $html;
  }

	//$days = 25;					//No of days to chart: mod_killcharts_days
  function daysToTrend(){
  	$html = '';
  	if(isset($_POST['option_mod_killcharts_days'])){
  		Config::set('mod_killcharts_days', $_POST['option_mod_killcharts_days']);
  	}
  	$days = Config::get('mod_killcharts_days');
  	if($days === nul){
  		Config::set('mod_killcharts_days', 30);
  		$days = 30;
  	}
  	$html .= "<input type='text' id='option_mod_killcharts_days' name='option_mod_killcharts_days' value='$days'/> Set to 0 to use board default limits";
  	return $html;
  }
  
	//$killbarcol =	'#329F00';	//Colour of kill bars: mod_killcharts_killcol
  function killBarColour(){
  	$html = '';
  	if(isset($_POST['option_mod_killcharts_killcol'])){
  		Config::set('mod_killcharts_killcol', $_POST['option_mod_killcharts_killcol']);
  	}
  	$killbarcol = Config::get('mod_killcharts_killcol');
  	if(!$killbarcol){
  		Config::set('mod_killcharts_killcol', '#329F00');
  		$killbarcol = '#329F00';
  	}
  	$html .= "<input type='text' id='option_mod_killcharts_killcol' name='option_mod_killcharts_killcol' value='$killbarcol' />";
  	return $html;
  }
  
	//$lossbarcol =	'#F90000';	//Colour of loss bars: mod_killcharts_losscol
  function lossBarColour(){
  	$html = '';
  	if(isset($_POST['option_mod_killcharts_losscol'])){
  		Config::set('mod_killcharts_losscol', $_POST['option_mod_killcharts_losscol']);
  	}
  	$lossbarcol = Config::get('mod_killcharts_losscol');
  	if(!$lossbarcol){
  		Config::set('mod_killcharts_losscol', '#F90000');
  		$lossbarcol = '#F90000';
  	}
  	$html .= "<input type='text' id='option_mod_killcharts_losscol' name='option_mod_killcharts_losscol' value='$lossbarcol' />";
  	return $html;
  }
  
	//$bgcolour = 	'#555555';	//Background colour: mod_killcharts_bgcol
  function backGroundColour(){
  	$html = '';
  	if(isset($_POST['option_mod_killcharts_bgcol'])){
  		Config::set('mod_killcharts_bgcol', $_POST['option_mod_killcharts_bgcol']);
  	}
  	$bgcolour = Config::get('mod_killcharts_bgcol');
  	if(!$bgcolour){
  		Config::set('mod_killcharts_bgcol', '#555555');
  		$bgcolour = '#555555';
  	}
  	$html .= "<input type='text' id='option_mod_killcharts_bgcol' name='option_mod_killcharts_bgcol' value='$bgcolour' />";
  	return $html;
  }
  
  //$chartType = 'table     //Chart type mod_killcharts_type
  function chartType(){
  	$html = '';
  	if(isset($_POST['option_mod_killcharts_type'])){
  		Config::set('mod_killcharts_type', $_POST['option_mod_killcharts_type']);
  	}
  	$chartType = Config::get('mod_killcharts_type');
  	if(!$chartType){
  		Config::set('mod_killcharts_type', 'table');
  		$chartType = 'table';
  	}
  	$html .= "<select id='option_mod_killcharts_type' name='option_mod_killcharts_type' value='$chartType'>";
        $html .= "<option value='table'";
        if($chartType == 'table') $html .= " selected='selected'";
        $html .= ">table</option>";
        $html .= "<option value='bar'";
        if($chartType == 'bar') $html .= " selected='selected'";
        $html .= ">bar</option>";
        $html .= "<option value='line'";
        if($chartType == 'line') $html .= " selected='selected'";
        $html .= ">line</option>";
        $html .= "</select>";
  	return $html;
  }

  function resetDefaults(){
		$html = '';
	  	if(isset($_POST['option_mod_killcharts_reset'])){
	  		Config::set('mod_killcharts_days', 30);
			Config::set('mod_killcharts_killcol', '#329F00');
			Config::set('mod_killcharts_losscol', '#F90000');
			Config::set('mod_killcharts_bgcol', '#555555');
			Config::set('mod_killcharts_textcol', '#FFFFFF');
			Config::set('mod_killcharts_reset', 0);
	  	}
	  	$html .= "<input type='checkbox' id='option_mod_killcharts_reset' name='option_mod_killcharts_reset' />";
	  	return $html;
  }
  
  function about(){
  	$html = '<p>';
  	$html .= "by vasco di (Paul White 2011)";
  	$html .= '</p>';
  	$html .= "<p>Detailed instructions,support and updates are available on the <a  target='_blank' href='http://eve-id.net/forum/viewtopic.php?f=505&t=16828'>EVE Development Network</a>";
        $html .= " and now also on  <a target='_blank' href='http://code.google.com/p/evedev-kb-mod-killcharts'>google code</a></p>";
  	return $html;
  }
}