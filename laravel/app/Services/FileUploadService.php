<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class FileUploadService extends Service
{
  /** IDの桁数 */
  const ID_LENGTH = 12;

  public function assetRegister($fileData)
  {
    $this->upload('assets', $fileData);
  }

  protected function upload($putPath, $fileData)
  {
    $fileName = $fileData->getClientOriginalName();
    Storage::cloud()->putFileAs($putPath, $fileData, $fileName, 'public');
  }


  /**
   * ランダムなID値を生成する
   * @return string
   */
  private function getRandomId()
  {
    $characters = array_merge(
      range(0, 9), range('a', 'z'),
      range('A', 'Z'), ['-', '_']
    );

    $length = count($characters);
    $id = "";

    for ($i = 0; $i < self::ID_LENGTH; $i++) {
      $id .= $characters[random_int(0, $length - 1)];
    }

    return $id;
  }

}
