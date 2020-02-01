<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Services\CustomerService;
use App\Services\ProfessionTypeService;
use App\Models\CustomerProfessionType;

class CustomerProfessionTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(
      CustomerService $customerService,
      ProfessionTypeService $professionTypeService
    )
    {
      DB::table('customer_profession_types')->truncate();
      $customers = $customerService->all([]);
      $customers->each( function($customer) {
        factory(CustomerProfessionType::class)->create(['customer_id' => $customer->id]);
      });
    }
}
