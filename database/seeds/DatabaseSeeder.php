<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

    	factory(App\Mosque::class, 3)->create()->each(function ($u) {
    		factory(App\Distance::class, 3)->create()->each(function($d) use ($u) {
    			App\DistanceMosque::create([
    				'distance_id' => $d->id,
    				'mosque_id' => $u->id,
    				'distance' => 1.2
    			]);
    		});
	    });
        // $this->call(UsersTableSeeder::class);
    	// factory(App\City::class, 5)->create();
    }
}
