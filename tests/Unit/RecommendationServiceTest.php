<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\RecommendationService;

class RecommendationServiceTest extends TestCase
{

    public function test_get_product(){
        $city = 'Vilnius';
        $weatherObj = (object) ['id'=>85, 'city'=>"vilnius", 'forecast'=>"sunny", 'day'=>"2021-10-09", 'created_at'=>"2021-10-09T21:16:52.000000Z"];

        $response = (new RecommendationService())->getProducts($weatherObj, $city);

        $this->assertIsObject($response[0]);
        $this->assertEquals(1, $response[0]->recommendations_id);
        $this->assertArrayHasKey('recommendations_id', $response[0]);        
        $this->assertArrayHasKey('sku', $response[0]);
        $this->assertArrayHasKey('name', $response[0]);
        $this->assertArrayHasKey('price', $response[0]);
    }

    public function test_get_recommendations()
    {
        $city = 'vilnius';
        $weatherArray = [];
        $weather = (object) ['id'=>85, 'city'=>"vilnius", 'forecast'=>"sunny", 'day'=>"2021-10-09", 'created_at'=>"2021-10-09T21:16:52.000000Z"];
        array_push($weatherArray, $weather);
        $responseRec = (new RecommendationService())->getRecommendations($city, $weatherArray);

        $this->assertIsObject($responseRec);
        $this->assertEquals('vilnius', $responseRec->city);        
        $this->assertObjectHasAttribute('weather_forecast', $responseRec->recommendations[0]);
        $this->assertObjectHasAttribute('date', $responseRec->recommendations[0]);
        $this->assertObjectHasAttribute('products', $responseRec->recommendations[0]);
        $this->assertIsArray($responseRec->recommendations);
        $this->assertCount(2, $responseRec->recommendations[0]->products);
    }
}
