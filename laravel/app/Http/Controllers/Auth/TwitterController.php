<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Services\CustomerService;
use App\Models\Customer;
use Auth;
use App\Models\User;

class TwitterController extends Controller
{

  protected $customerService;

  public function __construct(CustomerService $customerService)
  {
    $this->customerService = $customerService;
  }

  // ログイン
  public function redirectToProvider(){
    $redirectUrl = Socialite::driver('twitter')->redirect()->getTargetUrl();

    return response()->json([
      'redirect_url' => $redirectUrl
    ]);
  }

  // コールバック
  public function handleProviderCallback(){
    try {
      $twitterUser = Socialite::driver('twitter')->user();
    } catch (Exception $e) {
      exit;
      return redirect('auth/twitter');
    }

    // ログイン処理
    $user = User::firstOrNew([
      'twitter_id' => $twitterUser->getId()
    ]);

    if($user->exists) {
      Auth::login($user);
      $createdCustomer = $this->customerService->customerById(Customer::RELATIONS_ARRAY, $user->customer_id);
    } else {
      $createdCustomer = $this->customerService->firstRegister([
        'twitter_id' => $twitterUser->getId(),
        'name' => $twitterUser->getName(),
      ]);
    }
    $author = $this->customerService->customerById(Customer::RELATIONS_ARRAY, $createdCustomer->id);
    return response($author, 201);
  }

  // ログアウト
  public function logout(Request $request)
  {
    // 各自ログアウト処理
    // 例
    // Auth::logout();
    return redirect('/');
  }
}
