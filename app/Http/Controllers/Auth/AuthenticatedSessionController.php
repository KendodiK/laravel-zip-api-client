<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // Bejelentkezünk az API-ba
        $response = Http::api()->post('/user/login', [
            'email' => $request->email,
            'password' => $request->password,
        ]);

        // Ha sikeres választ kaptunk, akkor elmentjük az adatokat a session-be
        if ($response->successful()) {
            // elmentjük a bejelentkezési adatokat a session-be.
            $responseBody = json_decode($response->body());
            if (empty($responseBody->user)) {
                return back()->withErrors([
                    'message' => 'ismeretlen hiba',
                ]);
            }
            // az, hogy a token és a többi milyen formában van a response-ban
            // az API programozójától függ, pl: "data" tömbön belül
            session([
                'api_token' => $responseBody->user->token,
                'user_name' => $responseBody->user->name,
                'user_email' => $responseBody->user->email,
            ]);

            return redirect()->route('welcome');
        }

        return back()->withErrors([
            'email' => 'Hibás bejelentkezési adatok.',
        ]);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        session()->forget('api_token');
        session()->forget('user_name');
        session()->forget('user_email');

        return redirect('/');
    }
}
