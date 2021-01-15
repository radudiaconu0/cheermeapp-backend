<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class DeletePostTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        Sanctum::actingAs(User::find(2));
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Content' => 'application/json'
        ])->delete('api/posts/1', [
            'text' => 'Hello world'
        ]);

        $response->assertStatus(403);

    }
}
