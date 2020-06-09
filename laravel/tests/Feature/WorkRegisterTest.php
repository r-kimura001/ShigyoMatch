<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Customer;
use App\Models\User;
use App\Models\Work;

class WorkRegisterTest extends TestCase
{
  use RefreshDatabase;

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
   * @group workApi
   */
  public function should_新しい案件を登録して返却する()
  {
    $expects = [
      'title' => 'testJob',
      'body' => 'quarity',
      'fee' => '50000',
      'customer_id' => $this->customer->id,
      'profession_type_id' => 1
    ];

    $response = $this->actingAs($this->customer->user)
      ->json('POST', route('work.store', $expects));

    $this->assertDatabaseHas('works', [
      'title' => $expects['title']
    ]);

    $response->assertStatus(201)
      ->assertJson([
        'title' => $expects['title']
      ]);
  }

  /**
   * @test
   * @group workApi
   * authミドルウェアの設定をしているルート定義に未認証でアクセスすると
   * 401が返ってくる
   */
  public function should_ゲストは案件登録できない()
  {
    $unExpects = [
      'title' => str_random(30),
      'body' => str_random(3000),
      'fee' => '50000',
      'customer_id' => $this->customer->id,
      'profession_type_id' => 1
    ];

    $response = $this->json('POST', route('work.store', $unExpects));

    $this->assertDatabaseMissing('works', [
      'title' => $unExpects['title']
    ]);

    $response->assertStatus(401);

  }

  /**
   * @test
   * @group workApi
   * title: 30文字
   * body: 3000文字
   * fee: 1,000,000円
   */
  public function should_各属性が最大値を超えるとエラーになる()
  {
    $unexpects = [
      'title' => str_random(31),
      'body' => str_random(3001),
      'fee' => 1000000,
      'customer_id' => $this->customer->id,
      'profession_type_id' => 1
    ];

    $response = $this->actingAs($this->customer->user)
                     ->json('POST', route('work.store', $unexpects));

    $response->assertStatus(422)
             ->assertJsonValidationErrors(['title', 'body', 'fee']);


    $this->assertDatabaseMissing('works', [
      'body' => $unexpects['body']
    ]);

  }

}
