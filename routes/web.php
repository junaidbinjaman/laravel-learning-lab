<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return '<h2>Home</h2><a href="/About">Back to About</a>';
});

Route::get('/about', function () {
    return '<h2>About Page</h2><a href="/">Back to Home</a>';
});
