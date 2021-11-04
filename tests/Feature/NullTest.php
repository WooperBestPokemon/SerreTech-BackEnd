<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class NullTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    /** test */
    public function test_null_greenhouse_name()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->post(route('addgreenhousePost'), [
                'name' => '',
                'img' => 'https://m.media-amazon.com/images/I/81OZxyZaD0S._AC_SL1500_.jpg',
                'description' => 'Je contient des légumes',
            ]);
        $response->assertSessionHasErrors('name');
    }
    /** test */
    public function test_null_greenhouse_description()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->post(route('addgreenhousePost'), [
                'name' => 'Les légumes',
                'img' => 'https://m.media-amazon.com/images/I/81OZxyZaD0S._AC_SL1500_.jpg',
                'description' => '',
            ]);
        $response->assertSessionHasErrors('description');
    }
    /** test */
    public function test_null_greenhouse_img()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->post(route('addgreenhousePost'), [
                'name' => 'Les légumes',
                'img' => '',
                'description' => 'Je contient des légumes',
            ]);
        $response->assertSessionHasErrors('img');
    }
    /** test */
    public function test_null_zone_name()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->post(route('addzonePost'), [
                'name' => '',
                'typeFood' => 'Tomate2',
                'description' => 'Miam Miam2',
                'img' => 'http://www.mayrand.ca/globalassets/mayrand/catalog-mayrand/fruit-et-legume/40734-tomate-en-serre-15-lb.jpg',
            ]);
        $response->assertSessionHasErrors('name');
    }
    /** test */
    public function test_null_zone_typeFood()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->post(route('addzonePost'), [
                'name' => 'Zone',
                'typeFood' => '',
                'description' => 'Miam Miam2',
                'img' => 'http://www.mayrand.ca/globalassets/mayrand/catalog-mayrand/fruit-et-legume/40734-tomate-en-serre-15-lb.jpg',
            ]);
        $response->assertSessionHasErrors('typeFood');
    }
    /** test */
    public function test_null_zone_description()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->post(route('addzonePost'), [
                'name' => 'Zone',
                'typeFood' => 'Tomate',
                'description' => '',
                'img' => 'http://www.mayrand.ca/globalassets/mayrand/catalog-mayrand/fruit-et-legume/40734-tomate-en-serre-15-lb.jpg',
            ]);
        $response->assertSessionHasErrors('description');
    }
    /** test */
    public function test_null_zone_img()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->post(route('addzonePost'), [
                'name' => 'Zone',
                'typeFood' => 'Tomate',
                'description' => '',
                'img' => '',
            ]);
        $response->assertSessionHasErrors('img');
    }
    /** test */
    public function test_null_sensor_name()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->post(route('addsensorPost'), [
                'name' => '',
                'description' => 'Je détecte des animaux',
                'typeData' => 'Température',
            ]);
        $response->assertSessionHasErrors('name');
    }
    /** test */
    public function test_null_sensor_description()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->post(route('addsensorPost'), [
                'name' => 'Sensor 1',
                'description' => '',
                'typeData' => 'Température',
            ]);
        $response->assertSessionHasErrors('description');
    }
    /** test */
    public function test_null_sensor_typeData()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->post(route('addsensorPost'), [
                'name' => 'Sensor 1',
                'description' => 'Sensor 1 desc',
                'typeData' => '',
            ]);
        $response->assertSessionHasErrors('typeData');
    }
}
