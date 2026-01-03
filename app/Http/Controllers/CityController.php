<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class CityController extends Controller
{
    private string $ROUTE_BASE = 'city';

    public function showBasePage()
    {
        if (!Session::has('counties')) {
            $counties = CountyController::getAllCounties();
            Session::put('counties', $counties);
        }

        return view('city.index');
    }

    public function getAbc(Request $request)
    {
        $abc = [];
        $cities = $this->index();
        $countyId = $request->county;
        foreach ($cities as $city) {
            if ($countyId == $city['countyId']) {
                $char = mb_substr($city['name'], 0, 1);
                if (!in_array($char, $abc)) {
                    $abc[] .= $char;
                }
            }
        }
        Session::put('abc', $abc);
        Session::put('selectedCounty', $countyId);

        return view('city.index');
    }

    public function showByCharAndCounty($char)
    {
        $citiesAll = $this->index();
        $cities = [];
        foreach ($citiesAll as $city) {
            $nameFirstLet = mb_substr($city['name'], 0, 1);
            if ($char == $nameFirstLet && Session::get('selectedCounty') == $city['countyId']) {
                $cities[] = $city;
            }
        }

        return view('city.index', compact('cities'));
    }
    public function index(){
        $response = Http::api()->get($this->ROUTE_BASE);

        if ($response->failed()) {
            $message = $response->json('message') ?? 'Ismeretlen hiba történt.';
            return redirect()->route('products.index')->with('error', "Hiba történt: $message");
        }

        return $response->json();
    }

    public function show($id){

    }

    public function store(Request $request){

    }

    public function update(Request $request, $id){

    }

    public function destroy($id){

    }
}
