<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\GreenHouse;
use App\Models\Sensor;
use App\Models\Zone;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UpdateTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    /** test */
    public function test_update_zone()
    {
        $this->withoutExceptionHandling();

        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('addzonePost'), [
                'name' => 'name1',
                'typeFood' => 'typefood1',
                'description' => 'desc1',
                'img' => 'img1',
            ]);

        $zone = Zone::orderBy('idZone', 'desc')->first();

        $this->actingAs($user)
             ->put(route('editzonePut', $zone->idZone),  [
                 'name' => 'name2',
                 'typeFood' => 'typefood2',
                 'description' => 'desc2',
                 'img' => 'img2',
        ]);

        $zone = Zone::orderBy('idZone', 'desc')->first();

        $this->assertEquals('name2', $zone->name);
        $this->assertEquals('typefood2', $zone->typeFood);
        $this->assertEquals('desc2', $zone->description);
        $this->assertEquals('img2', $zone->img);
    }
    /** test */
    public function test_update_sensor()
    {
        $this->withoutExceptionHandling();

        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('addsensorPost'), [
                'name' => 'name1',
                'description' => 'desc1',
                'typeData' => 'type1',
            ]);

        $sensor = Sensor::orderBy('idSensor', 'desc')->first();

        $this->actingAs($user)
            ->put(route('editsensorPut', $sensor->idSensor),  [
                'name' => 'name2',
                'description' => 'desc2',
                'typeData' => 'type2',
            ]);

        $sensor = Sensor::orderBy('idSensor', 'desc')->first();

        $this->assertEquals('name2', $sensor->name);
        $this->assertEquals('desc2', $sensor->description);
        $this->assertEquals('type2', $sensor->typeData);
    }
    /** test */
    public function test_update_greenhouse()
    {
        $this->withoutExceptionHandling();

        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('addgreenhousePost'), [
                'name' => 'name1',
                'img' => 'img1',
                'description' => 'desc1',
            ]);

        $greenhouse = GreenHouse::orderBy('idGreenhouse', 'desc')->first();

        $this->actingAs($user)
            ->put(route('editgreenhousePut', $greenhouse->idGreenHouse),  [
                'name' => 'name2',
                'img' => 'img2',
                'description' => 'desc2',
            ]);

        $greenhouse = GreenHouse::orderBy('idGreenhouse', 'desc')->first();

        $this->assertEquals('name2', $greenhouse->name);
        $this->assertEquals('img2', $greenhouse->img);
        $this->assertEquals('desc2', $greenhouse->description);
    }
}
