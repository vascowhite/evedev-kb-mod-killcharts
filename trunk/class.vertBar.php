<?php
/*
 * $Date$
 * $Revision$
 * $HeadURL$
 */

class vertBar
{
    protected $percentage;
    protected $kill;
  
    public function __construct($max = 100, $ht = 100, $kill = 'kill')
    {
        $this->kill = $kill;
        if($max == 0 || $ht == 0){
            $this->percentage = 0;
            return;
        }
        $this->percentage = (($ht/$max)*100);
        return;
    }
 
    public function getBar()
    {
        if($this->kill == 'kill') {
            $align = 'left';
        } else {
            $align = 'right';
        }
        $html = "<div class='grow vertbar{$this->kill}' style='height:{$this->percentage}%;'></div>\n";
        return $html;
    }
}