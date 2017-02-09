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

        $prayers = ['fajr', 'dhuhr', 'asr', 'maghrib', 'isha'];

        foreach($prayers as $prayer) {
            \App\Prayer::create([
                'name' => $prayer
            ]);
        }	
        \App\City::create([
            'name' => 'manchester'
        ]);
        // $this->call(UsersTableSeeder::class);
    	// factory(App\City::class, 5)->create();
    }
}
