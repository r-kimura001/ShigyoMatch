<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Selectable;
use App\Services\ProfessionTypeService;
use App\Services\SkillTypeService;
class SelectablesTableSeeder extends Seeder
{

  protected $professionTypeService;
  protected $skillTypeService;

  const PROFESSION_IDS_ARRAY = [
    '弁護士' => 1,
    '司法書士' => 2,
    '行政書士' => 3,
    '税理士' => 4,
  ];

  public function __construct(
    ProfessionTypeService $professionTypeService,
    SkillTypeService $skillTypeService
  )
  {
    $this->professionTypeService = $professionTypeService;
    $this->skillTypeService = $skillTypeService;
  }

  /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('selectables')->truncate();

      $pairs = [
        self::PROFESSION_IDS_ARRAY['弁護士'] => [
          '債権回収',
          '交通事故',
          '労働問題',
          '離婚・交際問題',
          '刑事事件',
          '遺言・相続',
          '株主総会',
          '契約',
          '合併・M&A',
          '会社設立',
          'その他企業法務',
          '成年後見',
          '知的財産',
          'その他',
        ],
        self::PROFESSION_IDS_ARRAY['司法書士'] => [
          '債務整理',
          '不動産取引',
          '遺言・相続',
          '離婚・交際問題',
          '刑事事件',
          '会社設立',
          '役員変更',
          '供託',
          '成年後見',
          'その他',
        ],
        self::PROFESSION_IDS_ARRAY['行政書士'] => [
          '営業届出',
          '建設・環境',
          'その他'
        ],
        self::PROFESSION_IDS_ARRAY['税理士'] => [
          '確定申告',
          '贈与',
          '法人決算',
          '税務調査'
        ]
      ];

      foreach($pairs as $key => $value){
        for($i = 0; $i < count($value); $i++){
          $skillSets[] = [
            'profession_type_id' => $key,
            'skill_type_id' => $this->skillTypeService->idByBody($value[$i])
          ];
        }
      }

      foreach($skillSets as $skillSet){
        factory(Selectable::class)->create($skillSet);
      }
    }
}
