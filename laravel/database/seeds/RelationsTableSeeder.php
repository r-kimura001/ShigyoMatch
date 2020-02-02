<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Repositories\WorkRepository;
use App\Repositories\CustomerRepository;
use App\Services\CustomerService;
use Faker\Generator as Faker;
use App\Models\Apply;

class RelationsTableSeeder extends Seeder
{
  protected $workRep;
  protected $customerRep;
  protected $customerService;

  public function __construct(
    WorkRepository $workRep,
    CustomerRepository $customerRep,
    CustomerService $customerService
  )
  {
    $this->workRep = $workRep;
    $this->customerRep = $customerRep;
    $this->customerService = $customerService;
  }

  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    DB::table('scouts')->truncate();
    DB::table('applies')->truncate();
    DB::table('reviews')->truncate();
    DB::table('favorites')->truncate();
    $faker = \Faker\Factory::create('ja_JP');
    $testUser = $this->customerService->customerById(['professionTypes'], 1);
    $professionTypes = $testUser->professionTypes->map(function($professionType){
      return ['professionTypeId' => $professionType->id];
    });

    $sourceWorks = collect($this->workRep->worksByProfession([], $professionTypes[0])->filter(function($work){
      return $work->customer->id !== 1;
    })->all());

    // scouts追加
    $workIds = $sourceWorks->random(10)->pluck('id');
    $workIds->each(function($workId) use ($faker, $testUser){
      $testUser->scoutedWorks()->attach([
        $workId => [
          'title' => $faker->sentence(3),
          'body' => $faker->text,
        ]
      ]);
    });

    // applies追加
    $workIds = $workIds->random(5);
    $workIds->each(function($workId) use ($faker, $testUser){
      return $testUser->applyWorks()->attach([
        $workId => [
          'pr' => $faker->text,
          'match_flag' => 1
        ]
      ]);
    });

    // reviews追加
    $applies = Apply::all();
    $applies->each(function($apply) use ($faker, $testUser){
      $apply->reviewers()->attach([
        $testUser->id => [
          'comment' => $faker->text,
          'reviewee_id' => $apply->work->customer->id,
          'point' => $faker->numberBetween(1, 5)
        ]
      ]);
    });

    // favorites追加
    // 「気になる」した
    $workIds = $sourceWorks->random(5)->pluck('id')->toArray();
    $testUser->favorites()->sync($workIds);

    // 「気になる」された
    $customerIds = $this->customerService->idsByProfessionType($professionTypes[0]['professionTypeId']);
    $sourceUsers = collect($this->customerRep->customersByProfession([], $professionTypes[0], $customerIds)->filter(function($user){
      return $user->id !== 1;
    })->all());
    $testUser->works->each(function($work) use ($sourceUsers){
      $work->favorites()->sync(collect($sourceUsers)->random()->id);
    });

    // 申込を受ける
    $testUser->works->each(function($work) use ($faker, $sourceUsers){
      $work->appliers()->sync([
        collect($sourceUsers)->random()->id => [
          'pr' => $faker->text
        ]
      ]);
    });
  }

}
