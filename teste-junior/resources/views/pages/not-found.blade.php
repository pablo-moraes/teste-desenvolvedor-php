<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Page not found</title>
    @vite('resources/js/app.js')
    <style>
        .btn {
            max-width: 300px;
            min-width: 200px;
        }
    </style>
    @yield('styles')
</head>
<body>
<main class="container">
    <div class="d-flex flex-column align-items-center">
        <h2 class="text-center text-danger mt-5 pt-3 font-weight-bolder">404 - Page Not found</h2>
        <a class="btn btn-outline-primary" href="{{ route('home') }}">Go to home</a>
    </div>
</main>
</body>
</html>
