<?php

namespace App\Http\Controllers\APIControllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Http\Controllers\Controller;

use App\User;
use Hash;
use JWTAuth;


class MainController extends Controller
{
  public function register(Request $request)
  {
    $input = $request->all();
    $input['password'] = Hash::make($input['password']);
    User::create($input);
      return response()->json(['result'=>true]);
  }

  public function login(Request $request)
  {
    $input = $request->all();
    if (!$token = JWTAuth::attempt($input)) {
          return response()->json(['result' => 'Ai gresit userul sau parola.']);
      }
    
        return response()->json(['result' => $token]);
  }

  public function getUserInfo(Request $request)
  {
    $input = $request->all();
    $user = JWTAuth::toUser($input['token']);
      return response()->json(['result' => $user]);
  }
}
