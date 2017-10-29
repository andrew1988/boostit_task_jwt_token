<?php

namespace App\Http\Controllers\APIControllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Cities;
use App\User;
use JWTAuth;

class ManageCities extends Controller
{
  public function addCity(Request $request){
        $city = new Cities;
        $city->city = $request->city;
        $city->user_id = $request->user_id;
        $city->measuring_unit = $request->unitate_masura;

        $save = $city->save();
        return response()->json(['result'=>$save]);
    }
}
