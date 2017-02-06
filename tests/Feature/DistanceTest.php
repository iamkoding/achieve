<?php

namespace Tests\Feature;

use Distance;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class DistanceTest extends TestCase
{
	const CORRECT_LAT = "53.5264390";
	const CORRECT_LNG = "-2.2153680";

	const INCORRECT_LAT = "3.5264390";
	const INCORRECT_LNG = "-2.2153680";

    /**
     * Test Ummah Api is working.
     */
    public function distanceWithCorrectGeoCredentials()
    {
    	$distances = Distance::get($this::CORRECT_LAT, $this::CORRECT_LNG);

        $this->assertTrue((count($distances) > 0 ? true : false));
    }

    /**
     * @expectedException \Service\Mosque\DistanceEmptyException
     */
    public function testReturnsEmptyResult()
    {
    	$distances = Distance::get($this::INCORRECT_LAT, $this::INCORRECT_LNG);
    }
}
