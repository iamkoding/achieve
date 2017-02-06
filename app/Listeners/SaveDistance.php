<?php

namespace App\Listeners;

use App\Mosque;
use App\Distance;
use App\Events\DistanceReceived;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SaveDistance //implements ShouldQueue
{
    //use InteractsWithQueue;

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
     * @param  DistanceReceived  $event
     * @return void
     */
    public function handle(DistanceReceived $event)
    {
        $mosque = Mosque::create([
            'name' => $event->mosque['masjidName'],
            'address' => $event->mosque['address'],
            'city' => $event->mosque['city'],
            'postcode' => $event->mosque['zip'],
            'telephone' => $event->mosque['phone']
        ]);

        $mosque->distances()->attach($event->distance, array('distance' => $event->mosque['distance']));
    }
}
