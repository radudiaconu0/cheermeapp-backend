<?php

namespace Tests\Feature;

use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class EditPostTest extends TestCase
{
    public function testBasic()
    {
        Sanctum::actingAs(User::find(2));
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Content' => 'application/json'
        ])->put('api/posts/1', [
            'text' => 'Hello world'
        ]);

        $response->assertStatus(403);
    }
}
