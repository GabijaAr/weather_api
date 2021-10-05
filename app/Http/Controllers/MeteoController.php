<?php

namespace App\Http\Controllers;

use App\Services\Meteo\MeteoClient;
use Illuminate\Http\Request;

class MeteoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(MeteoClient $meteoClient, Request $request, $city)
    {
        $data = [
            $meteoClient->getCity($city),
        ];

       return $data;  
    }
}