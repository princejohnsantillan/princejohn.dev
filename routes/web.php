<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/clear-visitors', function () {
    cache()->forget('visitors');
});

Route::get('/', function () {



    /** @var array @visitors */
    $visitors = cache()->get('visitors', null) ?? [];

    if(array_key_exists(request()->ip(), $visitors)){
        $visitors[request()->ip()] = $visitors[request()->ip()] + 1;
    }else{
        $visitors[request()->ip()] = 1;
    }


    cache()->forever('visitors',$visitors);

    return view('welcome');
});

Route::get('/visitors',fn () => cache('visitors'));
