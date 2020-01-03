<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('users')->truncate();
      DB::table('customers')->truncate();

      $customers = factory('App\Models\Customer', 5)->create();
      $customers->each(function($customer){
        factory('App\Models\User')->create(['customer_id' => $customer->id]);
      });
    }
}
