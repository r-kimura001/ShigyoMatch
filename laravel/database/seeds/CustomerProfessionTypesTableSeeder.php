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

      $now = Carbon::now();
      $customers = $customerService->all([]);
      $professionTypes = $professionTypeService->all();
      $customerId = 1;
      $professionId = 1;

      $selectableCount = 2; // customerが選べる資格の数

      $recordCount = count($customers) * $selectableCount;

      $customerProfessionTypes = factory(CustomerProfessionType::class, $recordCount)->create();

      foreach($customerProfessionTypes as $customerProfessionType){
        DB::table('customer_profession_types')
          ->where('id', $customerProfessionType->id)
          ->update([
            'customer_id' => $customerId,
            'profession_type_id' => $professionId,
          ]);
        $customerId = $customerId < count($customers) ? $customerId + 1 : 1;
        $professionId = $professionId < count($professionTypes) ? $professionId + 1 : 1;
      }
    }
}
