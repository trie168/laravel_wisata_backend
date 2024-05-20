<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.auth.login', ['type_menu' => 'home']);
});

