<?php

namespace Tests\Feature;

use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class GetCommentsTest extends TestCase
{
    public function testBasic()
    {
        Sanctum::actingAs(User::find(2));
        $response = $this->postJson('api/user/1/block/');
        $this->postJson('/api/posts/1/comments', [
           'text' => 'hello world'
        ]);
        $response = $this->getJson('/api/posts/1/comments');
        $response->assertStatus(200);
    }
}
