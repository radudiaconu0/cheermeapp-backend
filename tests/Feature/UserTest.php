<?php

namespace Tests\Feature;

use http\Client\Curl\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        Sanctum::actingAs(\App\Models\User::find(1));
//        $response = $this->post('/');
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Content' => 'application/json'
        ])->post('api/2/follow/');

        $response->assertStatus(200);
    }
}
