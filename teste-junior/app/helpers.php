<?php

use Illuminate\Support\Facades\Route;

function isUpdateRoute($routeName = ""): bool
{
    $fullRoute = "update_{$routeName}_form";
    if (!Route::has($fullRoute)) return false;

    return Route::is($fullRoute);
}

