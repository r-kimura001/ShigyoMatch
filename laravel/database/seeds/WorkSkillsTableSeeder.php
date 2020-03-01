<?php

use Illuminate\Database\Seeder;
use App\Repositories\WorkRepository;
use App\Repositories\SkillTypeRepository;
use App\Models\WorkSkill;
use App\Models\Work;
class WorkSkillsTableSeeder extends Seeder
{
  protected $workRep;
  protected $skillRep;
  public function __construct(
    WorkRepository $workRepository,
    SkillTypeRepository $skillRepository
  )
  {
    $this->workRep = $workRepository;
    $this->skillRep = $skillRepository;
  }

  /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('work_skills')->truncate();

      // title一覧作成

      $skillTypes = $this->skillRep->all([]);
      $arr = $skillTypes->map(function ($skillType) {

        if (mb_strpos($skillType->body, 'その他') === 0) {
          $body = mb_substr( $skillType->body, mb_strlen('その他') );
        } else {
          $body = $skillType->body;
        }

        return [
          $skillType->id => "{$body}経験者募集"
        ];
      })->toArray();

      $titles = [];
      foreach($arr as $array){
        foreach($array as $key => $value){
          $titles[$key] = $value;
        }
      }

//      dd($titles);

      // body一覧作成
      $bodies = [
        "官公庁とのやり取り経験のある方\nコミュニケーション能力に自信のある方",
        "能動的に仕事が出来る方\n有資格者尚可",
        "コミュニケーション能力に自信のある方\n３年以上の経験がある方",
      ];
      // 募集案件一覧
      $works = $this->workRep->all(['professionType.selectables']);
      $works->each(function(Work $work) use ($titles, $bodies) {
        $max = count($work->professionType->selectables) - 1;
        $randomKey = rand(0, $max);
        $skillTypeId = $work->professionType->selectables[$randomKey]->id;
        $bodyKey = rand(0, count($bodies) - 1);

        // 募集案件更新
        $data = [
          'title' => $titles[$skillTypeId],
          'body' => $bodies[$bodyKey]
        ];
        $work->updateByUser($data);

        // 募集案件に紐づくタグ挿入
        factory(WorkSkill::class)->create([
          'work_id' => $work->id,
          'skill_type_id' => $skillTypeId
        ]);
      });


    }
}
