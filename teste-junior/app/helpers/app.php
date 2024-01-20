<?php

use Illuminate\Support\Facades\Route;

/**
 * Check if current route matches to the update route nomenclature.
 * @param string $name
 * @return bool
 */
function isUpdatePath(string $name = ""): bool
{
    return Route::is("update_{$name}_form");
}

/**
 * Convert formatted currency value into an intenger to search the stored price.
 * If it doesn't match any number returns false
 * @param string $price
 * @return int|bool
 */
function convertPriceToInteger(string $price): int|bool
{
    // Use a regex to get only numbers from the received string.
    preg_match_all('/[0-9]/', $price, $matches);
    $formattedPrice = implode("", $matches[0]);

    if (empty($formattedPrice)) return false;

    return (int) $formattedPrice;
}

