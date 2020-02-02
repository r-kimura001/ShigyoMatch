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

      $customer = factory(Customer::class, 1)->create(['name' => 'テストユーザー事務所']);
      factory('App\Models\User')->create([
        'customer_id' => 1,
        'login_id' => 'testuser',
        'email' => 'sample@example.com',
        'password' => \Hash::make('test1234'),
      ]);
      $customers = factory(Customer::class, 120)->create();
      $customers->each(function($customer){
        factory('App\Models\User')->create(['customer_id' => $customer->id]);
      });
    }
}
