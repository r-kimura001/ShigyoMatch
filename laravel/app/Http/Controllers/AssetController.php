<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Services\FileUploadService;

class AssetController extends Controller
{
  protected $fileUploadService;

  public function __construct(FileUploadService $fileUploadService)
  {
    $this->fileUploadService = $fileUploadService;
  }

  public function register(Request $request)
  {
    $this->fileUploadService->assetRegister($request->asset);
  }
}
