<?php

namespace Tests\Feature;

use App\Models\GreenHouse;
use App\Models\Sensor;
use App\Models\Zone;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DeleteTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    /** test */
    public function test_delete_zone()
    {
        $this->withoutExceptionHandling();

        $user = User::factory()->create();

            $this->actingAs($user)
            ->post(route('addzonePost'), [
                'name' => 'Tomate de Jedi2',
                'typeFood' => 'Tomate2',
                'description' => 'Miam Miam2',
                'img' => 'http://www.mayrand.ca/globalassets/mayrand/catalog-mayrand/fruit-et-legume/40734-tomate-en-serre-15-lb.jpg',
            ]);

        $zone = Zone::orderBy('idZone', 'desc')->first();

        $response = $this->actingAs($user)
                         ->call('DELETE', route('deletezone', $zone->idZone), ['_token' => csrf_token()]);
        $this->assertEquals(302, $response->getStatusCode());
        $this->assertDatabaseMissing('tblzone', ['name' => null, 'idZone' => $zone]);
    }

    /** test */
    public function test_delete_greenhouse()
    {
        $this->withoutExceptionHandling();

        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('addgreenhousePost'), [
                'name' => 'Sère de test',
                'img' => 'https://m.media-amazon.com/images/I/81OZxyZaD0S._AC_SL1500_.jpg',
                'description' => 'Je contient des légumes',
            ]);

        $greenhouse = GreenHouse::orderBy('idGreenHouse', 'desc')->first();

        $response = $this->actingAs($user)
            ->call('DELETE', route('deletegreenhouse', $greenhouse->idGreenHouse), ['_token' => csrf_token()]);
        $this->assertEquals(302, $response->getStatusCode());
        $this->assertDatabaseMissing('tblgreenhouse', ['name' => null, 'idGreenHouse' => $greenhouse]);
    }

    /** test */
    public function test_delete_sensor()
    {
        $this->withoutExceptionHandling();

        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('addsensorPost'), [
                'name' => 'Sensor de test',
                'description' => 'Je détecte des animaux',
                'typeData' => 'Température',
            ]);

        $sensor = Sensor::orderBy('idSensor', 'desc')->first();

        $response = $this->actingAs($user)
            ->call('DELETE', route('deletesensor', $sensor->idSensor), ['_token' => csrf_token()]);
        $this->assertEquals(302, $response->getStatusCode());
        $this->assertDatabaseMissing('tblsensor', ['name' => null, 'idSensor' => $sensor]);
    }
}
