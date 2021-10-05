<?php

namespace App\Services\Meteo;

use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use App\Models\Forecast;
use Illuminate\Support\Facades\DB;

class MeteoClient
{
        private function getStandartWeather($code) {
                switch ($code) {
                        case "scattered-clouds":
                        case "overcast":
                                return "cloudy";
                        case "light-rain":
                        case "moderate-rain":
                        case "heavy-rain":       
                        case "sleet":
                                return "rain";
                        case "light-snow":
                        case "moderate-snow":
                        case "heavy-snow":        
                                return "snow";   
                        case "fog":
                                return "fog";      
                        case "isolated-clouds":
                        case "clear":
                                return "clear";
                    }
        }

        private function getDailyForecast($day){
                $weatherCondition = '';
                foreach ($day->conditionCodes as $key => $value)  {
                        if($weatherCondition == ''){
                                $weatherCondition = $key;
                        }else if($value > $day->conditionCodes->$weatherCondition){
                                $weatherCondition = $key;
                        }
                }

                if($weatherCondition ==  "clear" && $day->temperature > 10 ){
                        return "sunny";
                } else if($weatherCondition ==  "clear" && $day->temperature < 10){
                        return "clear";
                }

                return $weatherCondition;
        }
                
        private function getWheatherFromDB($city){
                $forecast = Forecast::where('city', '=', ($city))->get();
               return $forecast;
        }

        public function getCity($city){
                $respDB = $this->getWheatherFromDB($city); 
                if(count($respDB) > 0) {
                        return $respDB;          
                     }

                $httpClient = new \GuzzleHttp\Client();
                $request =
                $httpClient
                ->get("https://api.meteo.lt/v1/places/${city}/forecasts/long-term");
               

                $response = json_decode($request->getBody()->getContents());

                $weatherData =  (object) [];
                $today = Carbon::now()->toDateString();
                $tomorrow = Carbon::tomorrow()->toDateString();
                $dayaftertomorrow = Carbon::now()->addDays(2)->toDateString();

                foreach ($response->forecastTimestamps as $value)  {
                        $day = explode(" ", $value->forecastTimeUtc)[0];
                        if($day == $today || $day == $tomorrow || $day == $dayaftertomorrow){
                                $conditions =  (object) [];

                                if(property_exists($weatherData, $day)){
                                        $temp =  $weatherData->$day->temperature + $value->airTemperature;
                                        $weatherData->$day->temperature = round($temp /2, 1);
                                        $conditionCode = $this->getStandartWeather($value->conditionCode);

                                if(property_exists($weatherData->$day->conditionCodes, $conditionCode)){
                                        $weatherData->$day->conditionCodes->$conditionCode += 1;
                                } else {

                                        $weatherData->$day->conditionCodes->$conditionCode = 1;
                                }

                                } else{
                                        $conditions->temperature = $value->airTemperature;
                                        $conditionCode = $this->getStandartWeather($value->conditionCode);
                                        $conditions->conditionCodes = (object)[$conditionCode => 1];
                                        $weatherData->$day = $conditions;
                                }

                        }
                };

                $response = (object) [];
                foreach ($weatherData as $key => $value)  {
                        $weather = $this->getDailyForecast($value);
                        $response->$key = $weather;
                }

        $this->insertData($response, $city);

        return $this->getWheatherFromDB($city);
        }

        private function insertData($weatherForecast, $city){


                foreach($weatherForecast as $key => $value){
               DB::table('forecasts')->insert([
                        'city' => $city, 
                        'day' => $key,
                        'forecast'=> $value,
                        'created_at' => Carbon::now('GMT+3'),
                    ]);                        
                }
 
        }

}