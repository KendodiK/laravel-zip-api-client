<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CountyController extends Controller
{
    private string $ROUTE_BASE = 'county';
    public function index(){
        $response = Http::api()->get($this->ROUTE_BASE);

        if ($response->failed()) {
            $message = $response->json('message') ?? 'Ismeretlen hiba történt.';
            return redirect()->back()->with('error', "Hiba történt: $message");
        }

        $counties = $response->json()['counties'];

        return view('county.index', compact('counties'));
    }

    public function show($id){

    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required|string'
        ]);

        $response = Http::api()->post($this->ROUTE_BASE, [$request->name]);

        if ($response->failed()) {
            $message = $response->json('message') ?? 'ismeretlen hiba';
            return redirect()->back()->with('error', "Hiba történt: $message");
        }

        return redirect()->back()->with('success', "Megye feltöltve");
    }

    public function update(Request $request, $id){

    }

    public function destroy($id){

    }
}
