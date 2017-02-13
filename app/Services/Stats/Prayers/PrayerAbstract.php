<?php

namespace Service\Stats\Prayers;

abstract class PrayerAbstract {

    public $count = 0;
    public $percentage = 0;
    public $comment = '';

    public function setCount($count)
    {
        $this->count = $count;
    }

    public function add()
    {
    	$this->count++;
    }

    public function calculatePercentage($days)
    {
		$this->percentage = (int) round($this->count / $days * 100); 
    }

    public function setText()
    {
        if($this->percentage > 99) $this->comment = $this->topScore();
        else if($this->percentage > 90) $this->comment = $this->nightyScore();
        else if($this->percentage > 60) $this->comment = $this->sixtyScore();
        else if($this->percentage > 30) $this->comment = $this->thirtyScore();
        else if($this->percentage > 5) $this->comment = $this->fiveScore();
        else $this->comment = $this->zeroScore();
    }

    protected function topScore()
    {
        return "The more we achieve the higher we climb.";   
    }

    protected function nightyScore()
    {
        return "Almost there, just need that extra push"; 
    }

    protected function sixtyScore()
    {
        return "We're getting there but we must try harder."; 
    }

    protected function thirtyScore()
    {
        return "Got past the starter hurdle but we must improve."; 
    }

    protected function fiveScore()
    {
        return "Great we're off the mark but must push on now."; 
    }

    protected function zeroScore()
    {
        return "Getting off the ground is always the hardest";
    }
}