<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Customer;
use App\Models\User;

class FollowApiTest extends TestCase
{
  use RefreshDatabase;

  protected $follower;
  protected $followee;

  public function setUp(): void
  {
    parent::setUp();

    // prefecturesテーブルが空だと$prefecture->nameが
    // "Trying to get property 'name' of non-object"と言われるため、
    // prefecturesテーブルにレコードを入れておく
    $this->seed('PrefecturesTableSeeder');

    $followPair = factory(Customer::class, 2)->create();

    $followPair->each(function ($customer) {
      $customer->user()->save(factory(User::class)->make());
    });
    $this->follower = $followPair[0];
    $this->followee = $followPair[1];
  }

  /**
   * @test
   * @group followApi
   */
  public function should_フォローをして相手方のデータ返却する()
  {
    $response = $this->actingAs($this->follower->user)
      ->json('PUT', route('customer.follow', $this->followee->id));

    $response->assertStatus(200)->assertJson([
      'id' => $this->followee->id
    ]);

    $this->assertDatabaseHas('follows', [
      'follower_id' => $this->follower->id,
      'followee_id' => $this->followee->id,
    ]);
  }

  /**
   * @test
   * @group followApi
   */
  public function should_2回フォローしてもフォロワー2人にならない()
  {
    $this->actingAs($this->follower->user)
      ->json('PUT', route('customer.follow', $this->followee->id));

    $this->actingAs($this->follower->user)
      ->json('PUT', route('customer.follow', $this->followee->id));

    $this->assertEquals($this->followee->followers->count(), 1);
    $this->assertEquals($this->follower->followees->count(), 1);
  }

  /**
   * @test
   * @group followApi
   */
  public function should_フォローの解除をして相手方のデータを返す()
  {
    // フォロー
    $this->actingAs($this->follower->user)
      ->json('PUT', route('customer.follow', $this->followee->id));

    // フォロー解除
    $this->actingAs($this->follower->user)
      ->json('DELETE', route('customer.unfollow', $this->followee->id));

    // フォロワーゼロ
    $this->assertEquals($this->followee->followers->count(), 0);
    // フォローゼロ
    $this->assertEquals($this->follower->followees->count(), 0);
  }

}
