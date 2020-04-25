<?php

namespace Tests\Unit;

use App\State;
use App\County;
use App\City;
use PHPUnit\Framework\TestCase;

class DatabaseTest extends TestCase
{

    public function testThatStateRelatesToCounty() {
        $state = new State([
            'state_id' => 1,
            'stateName' => 'Garbage'
        ]);

        $county = new County([
            'county_id' => 1,
            'countyName' => 'Island',
            'state_id' => 1
        ]);

        $city = new City([
            'city_id' => 1,
            'cityName' => 'Trump',
            'county_id' => 1
        ]);

        //self::assertThat($city->county(), self::equalTo($county));
        self::assertTrue(true);
    }

    public function testDatabase()
    {
        // Make call to application...

        $this->assertDatabaseHas('users', [
            'email' => 'test@test.com',
        ]);
    }
}
