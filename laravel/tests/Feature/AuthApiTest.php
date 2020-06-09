<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Customer;
use App\Models\User;

class AuthApiTest extends TestCase
{

  use RefreshDatabase;

  protected $customer;

  public function setUp(): void
  {
    parent::setUp();

    $this->customer = factory(Customer::class)->create([
      'pref_code' => null
    ]);
    $this->customer->user()->save(factory(User::class)->make());

  }

  /**
   * @test
   * @group userApi
   *
   */
  public function should_登録済みのユーザーを認証して返却する()
  {
    $response = $this->json('POST', route('login', [
      'login_id' => $this->customer->user->login_id,
      'password' => 'password'
    ]));


    $response
      ->assertStatus(200)
      ->assertJson([
        'name' => $this->customer->name
      ]);

    $this->assertAuthenticatedAs($this->customer->user);
  }

  /**
   * @test
   * @group userApi
   */
  public function should_認証済みのユーザーをログアウトさせる()
  {
    $response = $this->actingAs($this->customer->user)
                     ->json('POST', route('logout'));

    $response->assertStatus(200);
    $this->assertGuest();
  }

}
