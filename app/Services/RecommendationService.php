<?php

namespace App\Services;

use App\Models\Recommendation;
use App\Models\Product;
use App\Http\Resources\ProductResource;
use App\Services\MeteoService;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class RecommendationService
{
    public function getRecommendations($city, $weather){
        $response = (object) array('city' => $city, 'recommendations' => []);
        foreach ($weather as $key => $value) {
            $day = (object) array('weather_forecast' => $value->forecast, 'date' => $value->day, 'products' =>  $this->getProducts($value, $city) );
            array_push($response->recommendations, $day);
        }
        return $response;     
    }

    public function getProducts($weather, $city){
            $recommendationId = Recommendation::where('name', '=', ($weather->forecast))->get();
            $key = $city . $weather->forecast . $weather->day ;
            return ProductResource::collection(Cache::remember($key, 60* 5, function() use ($recommendationId){
            return Product::where('recommendations_id', '=', ($recommendationId[0]->id))->inRandomOrder()->limit(2)->get();
            }));           
    }
}

