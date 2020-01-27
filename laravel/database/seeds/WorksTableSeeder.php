<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Services\CustomerService;
use App\Services\ProfessionTypeService;
use App\Models\Work;
use App\Models\CustomerProfessionType;

class WorksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(CustomerService $customerService)
    {
      DB::table('works')->truncate();
      $customers = $customerService->all(['professionTypes']);

      $customers->each(function($customer){
        $customer->professionTypes->each(function($professionType) use ($customer){
          factory(Work::class)->create([
            'customer_id' => $customer->id,
            'profession_type_id' => $professionType->id,
          ]);
        });
      });
    }
}
