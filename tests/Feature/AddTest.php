<?php

namespace Tests\Feature;

use App\Models\GreenHouse;
use App\Models\Sensor;
use App\Models\Zone;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AddTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    /** test */
    public function test_add_zone()
    {
        $this->withoutExceptionHandling();

        $zonecount = Zone::all()->count();
        $user = User::factory()->create();

        $response = $this->actingAs($user)
                         ->post(route('addzonePost'), [
            'name' => 'Tomate de Jedi2',
            'typeFood' => 'Tomate2',
            'description' => 'Miam Miam2',
            'img' => 'http://www.mayrand.ca/globalassets/mayrand/catalog-mayrand/fruit-et-legume/40734-tomate-en-serre-15-lb.jpg',
        ]);
        $response->assertRedirect();
        $this->assertCount($zonecount+1, Zone::all());
    }

    /** test */
    public function test_add_sensor()
    {
        $this->withoutExceptionHandling();

        $sensorcount = Sensor::all()->count();
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->post(route('addsensorPost'), [
                'name' => 'Sensor de test',
                'description' => 'Je détecte des animaux',
                'typeData' => 'Température',
            ]);
        $response->assertRedirect();
        $this->assertCount($sensorcount+1, Sensor::all());
    }

    /** test */
    public function test_add_greenhouse()
    {
        $this->withoutExceptionHandling();

        $greenhousecount = GreenHouse::all()->count();
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->post(route('addgreenhousePost'), [
                'name' => 'Sère de test',
                'img' => 'https://m.media-amazon.com/images/I/81OZxyZaD0S._AC_SL1500_.jpg',
                'description' => 'Je contient des légumes',
            ]);
        $response->assertRedirect();
        $this->assertCount($greenhousecount+1, GreenHouse::all());
    }
}
