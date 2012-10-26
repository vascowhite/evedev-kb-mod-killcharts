<?php
/*
 * $Date$
 * $Revision$
 * $HeadURL$
 */

//set up options
options::cat('Modules', 'KillCharts', 'Settings');

//$days = 25;					//No of days to chart: mod_killcharts_days
options::fadd('Number of days to trend', 'none', 'custom', array('kgraph', 'daysToTrend'));

//$killbarcol =	'#329F00';	//Colour of kill bars: mod_killcharts_killcol
options::fadd('Colour of Kill Bars', 'none', 'custom', array('kgraph', 'killBarColour'));

//$lossbarcol =	'#F90000';	//Colour of loss bars: mod_killcharts_losscol
options::fadd('Colour of Loss Bars', 'none', 'custom', array('kgraph', 'lossBarColour'));

//$bgcolour = 	'#555555';	//Background colour of flash chart: mod_killcharts_bgcol 
options::fadd('Background Colour', 'none', 'custom', array('kgraph', 'backGroundColour'));

//$chartType = 'table     //Chart type mod_killcharts_type
options::fadd('Chart Type', 'none', 'custom', array('kgraph', 'chartType'));

//reset defaults
options::cat('Modules', 'KillCharts', 'Reset');
options::fadd('Reset Default Values', 'none', 'custom', array('kgraph', 'resetDefaults'));

options::cat('Modules', 'KillCharts', 'About');
options::fadd('KillCharts for EDK3', 'none', 'custom', array('kgraph', 'about'));