<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\RecommendationService;
use App\Services\MeteoService;
use App\Models\Product;
use App\Http\Resources\ProductResource;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ProductResource::collection(Product::all());
    }

    public function recommend(MeteoService $meteoService, RecommendationService $recommendationService, Request $request, $city)
    {
            $weather = $meteoService->getCityWeather($city);
            $recommendations= $recommendationService->getRecommendations($city, $weather);            
            return $recommendations;
    }

}
