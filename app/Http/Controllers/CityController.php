<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CityController extends Controller
{
    private string $ROUTE_BASE = 'city';
    public function index(){
        $response = Http::api()->get($this->ROUTE_BASE);

        if ($response->failed()) {
            $message = $response->json('message') ?? 'Ismeretlen hiba történt.';
            return redirect()->route('products.index')->with('error', "Hiba történt: $message");
        }

        $cities = $response->json();

        return view('city.index', compact('cities'));
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
