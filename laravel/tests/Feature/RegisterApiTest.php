<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Customer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterApiTest extends TestCase
{
  use RefreshDatabase;

  /**
   * user register
   * @test
   * @group userApi
   * @return void
   */
  public function should_新しいユーザーを作成して返却する()
  {
    $expects = [
      'name' => 'UnitTest事務所',
      'email' => 'unit-test@example.com',
      'registerNumbers' => json_encode([
        2 => 3333
      ]),
      'professionIds' => 2,
      'password' => 'password',
      'password_confirmation' => 'password'
    ];

    $response = $this->json('POST', route('register', $expects));

    $this->assertDatabaseHas('customers', [
      'name' => $expects['name']
    ]);

    $this->assertDatabaseHas('users', [
      'email' => $expects['email']
    ]);

    $response
      ->assertStatus(201)
      ->assertJson(['name' => $expects['name']]);
  }

}
