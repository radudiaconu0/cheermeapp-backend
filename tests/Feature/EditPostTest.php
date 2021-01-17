<?php

namespace Tests\Feature;

use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class EditPostTest extends TestCase
{
    public function testBasic()
    {
        Sanctum::actingAs(User::find(1));
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Content' => 'application/json'
        ])->get('api/feed');

        $response->assertStatus(200);
    }
}
