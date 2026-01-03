<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CountyController extends Controller
{
    public function index(){
        $cities = redirect('localhost:8000/cities')->get();

        dd($cities);

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
