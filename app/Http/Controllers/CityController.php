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
            $response = Http::api()->get('county');

            $counties = CountyController::getCounties($response);

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
        try {
            $response = Http::api()->get("/city/$id");

            if ($response->failed()) {
                $message = $response->json('message') ?? 'A város nem található vagy hiba történt.';
                return redirect()
                    ->route('cities.index')
                    ->with('error', "Hiba: $message");
            }
            $city = $this->getCity($response);

            if (!$city) {
                return redirect()
                    ->route('cities.index')
                    ->with('error', "A város adatai nem érhetők el.");
            }

            return view('city.modify', ['entity' => $city]);

        } catch (\Exception $e) {
            return redirect()
                ->route('cities.index')
                ->with('error', "Nem sikerült betölteni a város adatait: " . $e->getMessage());
        }
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required|string',
            'countyId' => 'required|integer|min:1',
            'postalCode' => 'numeric|required|min:1000|max:9999',
        ]);
        $name = $request->get('name');
        $countyId = $request->get('countyId');
        $postalCode = $request->get('postalCode');

        try {
            $response = Http::api()
                ->withToken($this->token)
                ->post('/city', ['name' => $name, 'county_id' => $countyId, 'postal_code' => $postalCode]);

            if ($response->failed()) {
                $message = $response->json('message') ?? 'Nem sikerült létrehozni a város.';
                return redirect()
                    ->route('cities.index')
                    ->with('error', "Hiba: $message");
            }

            return redirect()
                ->route('cities.index')
                ->with('success', "$name város sikeresen létrehozva!");

        } catch (\Exception $e) {
            return redirect()
                ->route('cities.index')
                ->with('error', "Nem sikerült kommunikálni az API-val: " . $e->getMessage());
        }
    }

    public function edit($id)
    {
        try {
            $response = Http::api()->get("/city/$id");

            if ($response->failed()) {
                $message = $response->json('message') ?? 'A város nem található vagy hiba történt.';
                return redirect()
                    ->back()
                    ->with('error', "Hiba: $message");
            }

            $city = json_decode($response->body(), false);

            if (!$city) {
                return redirect()
                    ->back()
                    ->with('error', "A város adatai nem érhetők el.");
            }

            return view('city.modify', ['entity' => $city]);

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', "Nem sikerült betölteni a város szerkesztő nézetét: " . $e->getMessage());
        }
    }

    public function update(Request $request, $id){
//        $request->validate([
//            'name' => 'required|string',
//            'countyId' => 'required|numeric:|min:1',
//            'postalCode' => 'required|numeric|min:1000|max:9999',
//        ]);
        $name = $request->get('name');
        $countyId = $request->get('countyId');
        $postalCode = $request->get('postalCode');

        try {
            $response = Http::api()
                ->withToken($this->token)
                ->put("/city/$id", ['name' => $name, 'county_id' => $countyId, 'postal_code' => $postalCode]);

            if ($response->successful()) {
                return redirect()
                    ->back()
                    ->with('success', "$name Város sikeresen frissítve!");
            }

            $errorMessage = $response->json('message') ?? 'Ismeretlen hiba történt.';
            return redirect()
                ->back()
                ->with('error', "Hiba történt: $errorMessage");

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', "Nem sikerült frissíteni: " . $e->getMessage());
        }
    }

    public function destroy($id){
        try {
            $response = Http::api()
                ->withToken($this->token)
                ->delete("/city/$id", ['id' => $id]);

            if ($response->failed()) {
                $message = $response->json('message') ?? 'Nem sikerült törölni a város.';
                return redirect()
                    ->route('cities.index')
                    ->with('error', "Hiba: $message");
            }

            return redirect()
                ->route('cities.index')
                ->with('success', "Város sikeresen törölve!");

        } catch (\Exception $e) {
            return redirect()
                ->route('cities.index')
                ->with('error', "Nem sikerült kommunikálni az API-val: " . $e->getMessage());
        }
    }

    private function getCity($response)
    {
        $responseBody = json_decode($response->body(), false);
        $data = $responseBody ?? null;
        $result = [];

        if (!empty($data)) {
            $result = $data->name ?? [];
        }

        return $result;
    }
}
