<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;

abstract class Controller
{
    protected string $token;

    function __construct()
    {
        $this->token = Session::get('api_token', '');
    }

    function isAuthenticated()
    {
        return session()->has('api_token');
    }
}
