<?php
/*
 * $Date$
 * $Revision$
 * $HeadURL$
 */

include_once 'class.vertBar.php';

class KillChart
{
    protected $kList;
    protected $lList;
    protected $days = 0;
    protected $dateFormat = 'd M Y';
    protected $startDate;
    protected $endDate;
    protected $kills = array();
    protected $losses = array();
    protected $label = '';
    protected $oneDaySecs = 86400;
    protected $maxKills = 0;
    protected $chartType = 'table';

    public function __construct()
    {
        $this->days = (int)Config::get('mod_killcharts_days');
        $this->chartType = Config::get('mod_killcharts_type');
        
        if($this->days > 30 || $this->days == 0) $this->days = 30;
        if($this->days > 0) $this->label = "for the last {$this->days} days";
        
        $date = time();
        $this->endDate = date($this->dateFormat, $date);
        $startDate = $date - ($this->oneDaySecs * $this->days);
        $this->startDate = date($this->dateFormat, $startDate);
        
        $this->kList = new KillList();
        $this->lList = new KillList();
        
        $this->kList->setStartDate($this->startDate . ' 00:00');
        $this->kList->setEndDate($this->endDate . ' 23:59');
        $this->kList->setPodsNoobShips(Config::get('podnoobs'));
        $this->lList->setStartDate($this->startDate . ' 00:00');
        $this->lList->setEndDate($this->endDate . ' 23:59');
        $this->lList->setPodsNoobShips(Config::get('podnoobs'));
        
        involved::load($this->kList, 'kill');
        involved::load($this->lList, 'loss');
        
        //build arrays
        $this->kills = $this->buildArray($this->kills);
        $this->losses = $this->buildArray($this->losses);
        
        //put kills in arrays
        $this->kList->rewind();
        while($kill = $this->kList->getKill()){
            $kDateStr = date($this->dateFormat, strtotime($kill->getTimeStamp()));
            $this->kills[$kDateStr][0] = $kDateStr;
            $this->kills[$kDateStr][1]++;
            if($this->kills[$kDateStr][1] > $this->maxKills) $this->maxKills = $this->kills[$kDateStr][1];
        }
        
        $this->lList->rewind();
        while($loss = $this->lList->getKill()){
            $lDateStr = date($this->dateFormat, strtotime($loss->getTimeStamp()));
            $this->losses[$lDateStr][0] = $lDateStr;
            $this->losses[$lDateStr][1]++;
            if($this->losses[$lDateStr][1] > $this->maxKills) $this->maxKills = $this->losses[$lDateStr][1];
        }
    }
    
    public function generate()
    {
        $html = "";
        $html .= "<div class=\"kb-kills-header\" style=\"margin-top:30px;\">Kill Trends {$this->label} ";
        $html .= "</div>\n";
        switch ($this->chartType){
            case 'table':
                $html .= $this->genTable();
                break;
            case 'bar':
                $html .= $this->genTable();
                break;
            case 'line':
                $html .= $this->genTable();
                break;
            default :
                $html .= $this->genTable();
                break;
        }
        return $html;
    }
    
    private function genTable()
    {
        $bgColour = Config::get('mod_killcharts_bgcol');
        $kbarColour = Config::get('mod_killcharts_killcol');
        $lbarColour = Config::get('mod_killcharts_losscol');
        $dates = array_keys($this->kills);
        $kills = $this->kills;
        $losses = $this->losses;
        $numDays = count($kills);
        
        foreach($dates as $date){
            if(strtotime($date) > strtotime($this->startDate)){
                //generate top row
                $topRow = '';
                $topRow .= "<td title='{$kills[$date][0]} ({$kills[$date][1]} kills)'>";
                $dayNum = date('d', strtotime($kills[$date][0]));
                $topRow .= "<small>$dayNum</small></td>";
                
                //generate bottom row
                $botRow = '';
                $botRow .= "<td title='{$losses[$date][0]} ({$losses[$date][1]} Losses)'>";
                $dayNum = date('d', strtotime($losses[$date][0]));
                $botRow .= "<small>$dayNum</small></td>";
                
                //generate graph
                $graph = '';
                $graph .= "<td onclick=\"window.location.href='" . KB_HOST . "?a=killcharts&d={$kills[$date][0]}';\"";
                $graph .= " style='cursor:pointer;padding:0;' ";
                $graph .= "title='{$kills[$date][0]} ({$kills[$date][1]} kills : {$losses[$date][1]} losses)'>\n";
                $graph .= "<div style='height:150px; width:100%; position:relative; padding:0; margin:0;'>\n";
                $bar = new vertBar($this->maxKills, $kills[$date][1], 'kill');
                $graph .= $bar->getBar();
                $bar = new vertBar($this->maxKills, $losses[$date][1], 'loss');
                $graph .= $bar->getBar();
                $graph .= "</div></td>\n";
            }
        }
        
        //style
        $html = '';
        $html .= "<style>\n";
	$html .= ".vertbarkill{position:absolute; bottom:0; left:0; background:$kbarColour; font-size: 4px;width:49%;}\n";
	$html .= ".vertbarloss{position:absolute; bottom:0; right:0; background:$lbarColour; font-size: 4px;width:49%;}\n";
        $html .= ".killchart-table td{text-align:center;}\n";
	$html .= "</style>\n";
        
        //table
	$html .= "<table style='background:$bgColour;' class='kb-table killchart-table' width='98%' cellspacing='1' align='center'>\n";
        
        //Top date row
        $html .= "<tr class='kb-table-header'>";
        $html .= $topRow;
        $html .= "</tr>\n";
        //graph
        $html .= "<tr style='height:150px;'>\n";
        $html .= $graph;
        $html .= "</tr>\n";
        //Bottom date row
        $html .= "<tr class='kb-table-header'>";
        $html .= $botRow;
        $html .= "</tr>\n";
       
	$html .= "</table>\n";
        
        return $html;
    }
    
    private function buildArray(array $array)
    {
        //build array with required dates as keys
        $endDate = strtotime($this->endDate);
        $startDate = strtotime($this->startDate);
        $currDay = $startDate;
        while($currDay <= $endDate){
            $dayStr = date($this->dateFormat, $currDay);
            $array[$dayStr][0] = $dayStr;
            $array[$dayStr][1] = 0;
            $currDay = $currDay + $this->oneDaySecs;
        }
        return $array;
    }
    
    private function hex2RGB($hexStr, $returnAsString = false, $seperator = ',')
    {
        $hexStr = preg_replace("/[^0-9A-Fa-f]/", '', $hexStr); // Gets a proper hex string
        $rgbArray = array();
        if (strlen($hexStr) == 6) { //If a proper hex code, convert using bitwise operation. No overhead... faster
            $colorVal = hexdec($hexStr);
            $rgbArray['red'] = 0xFF & ($colorVal >> 0x10);
            $rgbArray['green'] = 0xFF & ($colorVal >> 0x8);
            $rgbArray['blue'] = 0xFF & $colorVal;
        } elseif (strlen($hexStr) == 3) { //if shorthand notation, need some string manipulations
            $rgbArray['red'] = hexdec(str_repeat(substr($hexStr, 0, 1), 2));
            $rgbArray['green'] = hexdec(str_repeat(substr($hexStr, 1, 1), 2));
            $rgbArray['blue'] = hexdec(str_repeat(substr($hexStr, 2, 1), 2));
        } else {
            return false; //Invalid hex color code
        }
        return $returnAsString ? implode($seperator, $rgbArray) : $rgbArray; // returns the rgb string or the associative array
    }
    
    private function makeToolTip($date)
    {
        $data = array();
        $ticks = array();
        
        $kills = $this->killList($date);
        $i = 0;
        foreach($kills as $pilot => $kill){
            if(!isset($kill['kills'])){
                $data[$i][] = 0;
            } else $data[$i][] = $kill['kills'];
            if(!isset($kill['losses'])){
                $data[$i][] = 0;
            } else $data[$i][] = $kill['losses'];
            $ticks[] = $pilot;
            $i++;
        }
        
        return array('data' => $data, 'ticks' => $ticks);
    }
    
    private function killList($date) 
    {
        $result = array();
        
        $klist = new KillList();
        $klist->setStartDate($date . ' 00:00');
        $klist->setEndDate($date . '23:59');
        $klist->setPodsNoobShips(Config::get('podnoobs'));
        involved::load($klist, 'kill');
        
        $llist = new KillList();
        $llist->setStartDate($date . ' 00:00');
        $llist->setEndDate($date . '23:59');
        $llist->setPodsNoobShips(Config::get('podnoobs'));
        involved::load($llist, 'loss');
        
        while($kill = $klist->getKill()){
            if($kill) $result[$kill->getFBPilotName()]['kills']++;
        }
        while($loss = $llist->getKill()){
            if($loss) $result[$loss->getVictimName()]['losses']++;
        }
        return $result;
    }
}