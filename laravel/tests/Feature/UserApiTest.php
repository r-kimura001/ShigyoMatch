<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Customer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserApiTest extends TestCase
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
    $data = [
      'name' => '森司法事務所',
      'email' => 'mori@example.com',
      'registerNumbers' => json_encode([
        2 => 3333
      ]),
      'professionIds' => 2,
      'password' => 'password',
      'password_confirmation' => 'password'
    ];

    $response = $this->json('POST', route('register', $data));

    $customer = Customer::first();
    $this->assertEquals($data['name'], $customer->name);

    $response
      ->assertStatus(201)
      ->assertJson(['name' => $customer->name]);
  }

}
