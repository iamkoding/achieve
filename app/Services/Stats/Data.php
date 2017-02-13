<?php

namespace Service\Stats;

use Service\Stats\Prayers\Asr;
use Service\Stats\Prayers\Fajr;
use Service\Stats\Prayers\Isha;
use Service\Stats\Prayers\Dhuhr;
use Service\Stats\Prayers\Total;
use Service\Stats\Prayers\Maghrib;

class Data {

    private $prayer_array = [];

    public function get($times, $days)
    {
        $this->setUpPrayers();
        $this->calculateCount($times);
        $this->calculate($days);
        $this->calculateTotal($days * 5, $times->count()); 
        return $this->prayer_array;
    }

    private function calculateTotal($days, $count)
    {
        $this->prayer_array['total'] = new Total;
        $this->prayer_array['total']->setCount($count);
        $this->prayer_array['total']->calculatePercentage($days);
        $this->prayer_array['total']->setText();
    }

    private function setUpPrayers()
    {
        $this->prayer_array['fajr'] = new Fajr;
        $this->prayer_array['dhuhr'] = new Dhuhr;
        $this->prayer_array['asr'] = new Asr;
        $this->prayer_array['maghrib'] = new Maghrib;
        $this->prayer_array['isha'] = new Isha;
    }
    
    private function calculateCount($times)
    {
        foreach($times as $time) {
            $this->prayer_array[$time->prayer->name]->add();
        }
    }

    private function calculate($days)
    {
        foreach($this->prayer_array as $prayers) {
            $prayers->calculatePercentage($days);
            $prayers->setText();
        }
    }
}