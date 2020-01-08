<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
class FileUploadService extends Service
{
  /** IDの桁数 */
  const ID_LENGTH = 12;

  /**
   * @param $fileData
   */
  public function assetRegister($fileData)
  {
    $this->upload('assets', $fileData);
  }

  /**
   * @param string $putPath
   * @param $fileData
   */
  protected function upload(string $putPath, $fileData)
  {
    $fileName = $putPath === 'assets' ? $fileData->getClientOriginalName() : $this->getRandomId() . '.' . $fileData->extension();
    Storage::cloud()->putFileAs($putPath, $fileData, $fileName, 'public');
  }

  /**
   * @param string $putPath
   * @param $fileData
   * @return string
   */
  public function uploadCustomerThumb(string $putPath, $fileData)
  {
    $fileName = $this->getRandomId().'.'.$fileData->extension();
    Storage::cloud()->putFileAs($putPath, $fileData, $fileName, 'public');
    $fileName = $putPath.'/'.$fileName;
    return $fileName;
  }

  /**
   * @param string $putPath
   */
  public function delete(string $putPath)
  {
    Storage::cloud()->delete($putPath);
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
