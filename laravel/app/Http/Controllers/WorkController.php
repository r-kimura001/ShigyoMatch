<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Work\UpdateRequest;
use App\Http\Requests\Work\StoreRequest;
use App\Services\WorkService;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Services\FileUploadService;

class WorkController extends Controller
{
  protected $workService;
  protected $fileUploadService;

  public function __construct(
    WorkService $workService,
    FileUploadService $fileUploadService
  )
  {
    $this->workService = $workService;
    $this->fileUploadService = $fileUploadService;
  }

  public function index()
  {
    return response($this->workService->paginate(), 200);
  }

  /**
   * @param StoreRequest $request
   * @return WorkService
   * @throws \Exception
   */
  public function store(StoreRequest $request)
  {
    $data = $request->all();

    DB::beginTransaction();

    try{
      if(!empty($data['file_name']??'')){
        $putPath = 'works';
        $data['file_name'] = $this->fileUploadService->uploadThumb($putPath, $data['file_name']);
      }
      $work = $this->workService->store($data);
      DB::commit();
    }catch(\Exception $exception){
      DB::rollback();
      if(!empty($data['file_name']??'')){
        $this->fileUploadService->delete($data['file_name']);
      }
      throw $exception;
    }
    return response($this->workService->workById($work->id), 201);
  }

  /**
   * @param UpdateRequest $request
   * @param int $id
   * @return WorkService
   * @throws \Exception
   */
  public function update(UpdateRequest $request, int $id)
  {
    $work = $this->workService->workById($id);
    $data = $request->all();
    $putPath = 'customers/'.$id;

    DB::beginTransaction();

    try{
      if(isset($data['file_name'])){
        $data['file_name'] = $this->fileUploadService->uploadThumb($putPath, $data['file_name']);
      }
      if($data['deleteFlag'] === '1'){
        $deleteSrc = $work->file_name;
        $data['file_name'] = '';
      }
      $this->workService->update($work, $data);
      DB::commit();
    }catch(\Exception $exception){
      DB::rollback();
      if(isset($data['file_name'])){
        $this->fileUploadService->delete($data['file_name']);
      }
      throw $exception;
    }

    if($data['deleteFlag'] === '1'){
      $this->fileUploadService->delete($deleteSrc);
    }

    return $this->workService->workById($id);
  }

  public function show(int $id)
  {
    return $this->workService->workById($id);
  }
}
