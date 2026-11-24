<?php

use App\Models\Visit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::get('/', function (Request $request) {
    Visit::create(['path' => '/'.ltrim($request->path(), '/')]);

    return view('home', [
        'visits' => Visit::count(),
        'database' => DB::scalar('select version()'),
    ]);
});
