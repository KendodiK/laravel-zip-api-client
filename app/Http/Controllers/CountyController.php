<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CountyController extends Controller
{
    private string $ROUTE_BASE = 'county';

    public static function getAllCounties()
    {
        $response = Http::api()->get('county');

        if ($response->failed()) {
            $message = $response->json('message') ?? 'Ismeretlen hiba történt.';
            return redirect()->back()->with('error', "Hiba történt: $message");
        }

        return $response->json()['counties'];
    }
    public function index(){
        $counties = self::getAllCounties();

        return view('county.index', compact('counties'));
    }

    public function show($id){
        $response = Http::api()->get($this->ROUTE_BASE . "/{$id}");

        if ($response->failed()) {
            $message = $response->json('message') ?? 'ismeretlen hiba';
            return redirect()->back()->with('error', "Hiba történt: $message");
        }

        $county = $response->json();

        return view('county.modify', compact('county'));
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required|string'
        ]);

        $response = Http::api()
            ->withToken($this->token)
            ->post($this->ROUTE_BASE, [$request->name]);

        if ($response->failed()) {
            $message = $response->json('message') ?? 'ismeretlen hiba';
            return redirect()->back()->with('error', "Hiba történt: $message");
        }

        return redirect()->back()->with('success', "Megye feltöltve");
    }

    public function update(Request $request, $id){
        $request->validate([
            'name' => 'required|string'
        ]);

        $response = Http::api()
            ->withToken($this->token)
            ->put($this->ROUTE_BASE . "/{$id}", [$request->name]);

        if ($response->failed()) {
            $message = $response->json('message') ?? 'ismeretlen hiba';
            return redirect()->back()->with('error', "Hiba történt: $message");
        }

        return view('county.index', with('success', "Megye módosítva"));
    }

    public function destroy($id){
        $response = Http::api()
            ->withToken($this->token)
            ->delete($this->ROUTE_BASE . "/{$id}");

        if ($response->failed()) {
            $message = $response->json('message') ?? 'ismeretlen hiba';
            return redirect()->back()->with('error', "Hiba történt: $message");
        }

        return redirect()->back()->with('success', "Megye törölve");
    }
}
