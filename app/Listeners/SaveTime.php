<?php

namespace App\Listeners;

use App\Time;
use App\Events\TimeReceived;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SaveTime
{
    private $date;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  TimeReceived  $event
     * @return void
     */
    public function handle(TimeReceived $event)
    {
        foreach($event->day as $prayer_name => $time) {

            if($prayer_name === 'date_for') $this->date = $time;

            $prayer_id = $this->getPrayerId($prayer_name, $event->prayers);
            if(!$prayer_id) continue;

            $datetime = date('Y-m-d H:i:s',strtotime($this->date.' '.$time));
            
            Time::create([
                'datetime' => $datetime,
                'prayer_id' => $prayer_id,
                'city_id' => $event->city_id
            ]);
        }
    }

    public function getPrayerId($name, $prayers) 
    {
        foreach($prayers as $prayer) {
            if($prayer->name == $name) return $prayer->id;
        }
        return false;
    }
}
