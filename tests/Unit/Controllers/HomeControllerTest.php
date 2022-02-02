<?php

namespace Tests\Unit\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HomeControllerTest extends TestCase
{
    
    // non auth user can access home "/"
    public function testuserCanAccessHome()
    {
        //$user = factory(User::class)->create();

        //$response = $this->actingAs($user)->get('/');
        //$response->assertStatus(302);
        //$response = $this->get(route('/'));
        $this->withoutExceptionHandling();
        $response = $this->get(url('/home'));
        //dd($response);
        //$response->assertStatus(302);
        $response->assertOk();
        //$response->assertViewHas(['item_from_view', 'another_item_from_view']);
    }
}