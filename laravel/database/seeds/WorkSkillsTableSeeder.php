<?php

use Illuminate\Database\Seeder;
use App\Repositories\WorkRepository;
use App\Models\WorkSkill;
class WorkSkillsTableSeeder extends Seeder
{
  protected $workRep;
  public function __construct(WorkRepository $workRepository)
  {
    $this->workRep = $workRepository;
  }

  /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('work_skills')->truncate();

      $works = $this->workRep->all(['professionType.selectables']);
      $works->each(function($work){
        $max = count($work->professionType->selectables) - 1;
        $randomKey = rand(0, $max);
        factory(WorkSkill::class)->create([
          'work_id' => $work->id,
          'skill_type_id' => $work->professionType->selectables[$randomKey]->id
        ]);
      });


    }
}
