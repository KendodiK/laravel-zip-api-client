<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CountyController extends Controller
{
    private string $ROUTE_BASE = 'county';

    public function index()
    {
        $response = Http::api()->get('county');

        $counties = $this->getCounties($response);

        return view('county.index', compact('counties'));
    }

    public function show($id)
    {
        $response = Http::api()->get($this->ROUTE_BASE . "/{$id}");

        if ($response->failed()) {
            $message = $response->json('message') ?? 'ismeretlen hiba';
            return redirect()->back()->with('error', "Hiba történt: $message");
        }

        $county = json_decode($response->body(), false)->county[0] ?? null;

        if($county == null){
            return redirect()->back()->with('error', "A megye adatai nem érhetőek el");
        }

        return view('county.modify', compact('county'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string'
        ]);

        $response = Http::api()
            ->withToken($this->token)
            ->post($this->ROUTE_BASE, ['name' => $request->name]);

        if ($response->failed()) {
            $message = $response->json('message') ?? 'ismeretlen hiba';
            return redirect()->back()->with('error', "Hiba történt: $message");
        }

        return redirect()->back()->with('success', "Megye feltöltve");
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string'
        ]);

        $response = Http::api()
            ->withToken($this->token)
            ->put($this->ROUTE_BASE . "/{$id}", ['name' => $request->name]);

        if ($response->failed()) {
            $message = $response->json('message') ?? 'ismeretlen hiba';
            return redirect()->back()->with('error', "Hiba történt: $message");
        }

        return redirect()->back()->with('success', "Megye módosítva");
    }

    public function destroy($id)
    {
        $response = Http::api()
            ->withToken($this->token)
            ->delete($this->ROUTE_BASE . "/{$id}");

        if ($response->failed()) {
            $message = $response->json('message') ?? 'ismeretlen hiba';
            return redirect()->back()->with('error', "Hiba történt: $message");
        }

        return redirect()->back()->with('success', "Megye törölve");
    }

    public function exportPdf(Request $request)
    {
        $response = Http::api()->get($this->ROUTE_BASE);
        $counties = $this->getCounties($response);
        $pdf = Pdf::loadView('pdf.counties', ['entities' => $counties]);

        return $pdf->download('counties.pdf');
    }

    static public function getCounties($response)
    {
        $responseBody = json_decode($response->body(), false);
        $data = $responseBody->counties ?? null;
        $results = [];

        if (!empty($data)) {
            foreach ($data as $county) {
                $results[] = $county;
            }
        }

        return $results;
    }

    public function exportCsv(Request $request)
    {
        //$needle = $request->get('needle');

        try {
            //$url = $needle ? "counties?needle=" . urlencode($needle) : "counties";

            $response = Http::api()->get($this->ROUTE_BASE);

            if ($response->failed()) {
                $message = $response->json('message') ?? 'Ismeretlen hiba történt.';
                return redirect()
                    ->route('counties.index')
                    ->with('error', "Hiba történt a lekérdezés során: $message");
            }

            $counties = $this->getCounties($response);

            $csv = "ID,Név\n";
            foreach ($counties as $county) {
                $csv .= "{$county->id},{$county->name}\n";
            }

            return response($csv)
                ->header('Content-Type', 'text/csv')
                ->header('Content-Disposition', 'attachment; filename="counties.csv"');

        } catch (\Exception $e) {
            return redirect()
                ->route('counties.index')
                ->with('error', "Nem sikerült betölteni a megyéket: " . $e->getMessage());

        }
    }
}

