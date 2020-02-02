<?php

use Illuminate\Database\Seeder;
use App\Services\CustomerService;
use Illuminate\Support\Facades\DB;
class FollowsTableSeeder extends Seeder
{
  protected $customerService;

  public function __construct(CustomerService $customerService)
  {
    $this->customerService = $customerService;
  }

  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    DB::table('follows')->truncate();
    $testUser = $this->customerService->customerById(['professionTypes'], 1);
    $professionTypes = $testUser->professionTypes->pluck('id')->toArray();
    $customers = $this->customerService->all([])->shift()->all();
    $customers = collect($customers)->filter(function($customer) use ($professionTypes){
      return $customer->professionTypes->contains(function($professionType) use ($professionTypes){
        return $professionType->id === $professionTypes[0];
      });
    });
    $followeesArr = collect( $customers->random(10) )->pluck('id')->toArray();
    $followersArr = collect( $customers->random(10) )->pluck('id')->toArray();
    $testUser->followees()->sync($followeesArr);
    $testUser->followers()->sync($followersArr);
  }
}
