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
    $this->middleware('auth')->except(['index', 'show']);
    $this->workService = $workService;
    $this->fileUploadService = $fileUploadService;
  }

  /**
   * @param Request $request
   * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    return response($this->workService->worksByProfession($request->all()), 200);
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
    if(empty($data['file_name'])){
      unset($data['file_name']);
    }
    $putPath = 'works';

    DB::beginTransaction();

    try{
      if(!empty($data['file_name']??'')){
        $deleteSrc = $work->file_name;
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
      if(!empty($data['file_name']??'')){
        $this->fileUploadService->delete($data['file_name']);
      }
      throw $exception;
    }

    if(!empty($deleteSrc ?? '')){
      $this->fileUploadService->delete($deleteSrc);
    }

    return $this->workService->workById($id);
  }

  /**
   * @param int $id
   * @return mixed
   */
  public function show(int $id)
  {
    return $this->workService->workById($id);
  }

  /**
   * @param int $id
   * @return mixed
   */
  public function favorite(int $id)
  {
    $work = $this->workService->workById($id);
    $work->favorites()->sync([Auth::user()->customer_id]);
    return $work;
  }

  /**
   * @param int $id
   */
  public function unfavorite(int $id)
  {
    $work = $this->workService->workById($id);
    $work->favorites()->detach(Auth::user()->customer_id);
    return $work;
  }

  /**
   * @param int $id
   * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
   * @throws \Exception
   */
  public function destroy(int $id)
  {
    DB::beginTransaction();

    try{
      $work = $this->workService->workById($id);
      $fileName = $work->file_name;
      $work->deleteByUser();
      DB::commit();
    }catch(\Exception $exception){
      DB::rollback();
      throw $exception;
    }
    if(!empty($fileName??'')){
      $this->fileUploadService->delete($fileName);
    }
    return response('', 204);
  }

}
