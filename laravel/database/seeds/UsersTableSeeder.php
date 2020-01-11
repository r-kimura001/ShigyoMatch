<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Customer;
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

      $customers = factory(Customer::class, 15)->create();
      $customers->each(function($customer){
        factory('App\Models\User')->create(['customer_id' => $customer->id]);
      });
    }
}
