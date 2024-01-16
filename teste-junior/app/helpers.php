<?php

use Illuminate\Support\Facades\Route;

/** Check if current route matches to the update route nomenclature.
 * @param string $name
 * @return bool
 */
function isUpdatePath(string $name = ""): bool
{
    return Route::is("update_{$name}_form");
}

