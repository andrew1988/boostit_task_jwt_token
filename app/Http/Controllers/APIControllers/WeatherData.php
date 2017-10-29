<?php

namespace App\Http\Controllers\APIControllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Cities;
use File;

class WeatherData extends Controller
{
    public function getWeatherForUser(Request $request){
      $citiesList = Cities::where('user_id',$request->user_id)->orderBy('id','desc')->get();
      $cityResponse = array();
      foreach($citiesList as $city){
        $query = "select * from weather.forecast where woeid in (select woeid from geo.places(1) where text='".$city->city."')";
        $lnk = "https://query.yahooapis.com/v1/public/yql?q=".urlencode($query)."&format=json";
        $json = file_get_contents($lnk);
        $decodeResponse = json_decode($json);
        $cityResponse[$city->id]['oras'] = $city->city;
        if($city->measuring_unit == 'c'){
            $originalTemp = $decodeResponse->query->results->channel->item->condition->temp;
            $toCelsius = ($originalTemp - 32) * 5/9;
            $cityResponse[$city->id]['temperatura']    = floor($toCelsius);
            $cityResponse[$city->id]['unitate_masura'] = $city->measuring_unit;
        }else{
            $cityResponse[$city->id]['temperatura']    = $decodeResponse->query->results->channel->item->condition->temp;
            $cityResponse[$city->id]['unitate_masura'] = $decodeResponse->query->results->channel->units->temperature;
        }
        $cityResponse[$city->id]['data']    = $decodeResponse->query->results->channel->item->condition->date;
        $cityResponse[$city->id]['text']    = $decodeResponse->query->results->channel->item->condition->text;
        if($cityResponse[$city->id]['text'] == 'Rain'){
          $this->weatherNotifications($city->city);
        }
      }
      return response()->json($cityResponse);
    }
    public function weatherNotifications($city){
            //write to file
            $string = 'Warning it\'s raining in:'.$city ."\n";
            //Storage::disk('local')->put('public/warnings.txt',$string);
            File::append(storage_path('app/public/warnings.txt'),$string);
    }

}
