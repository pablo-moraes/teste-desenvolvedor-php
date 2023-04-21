<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @vite('resources/js/app.js')
    <style>
        body {
            font-family: 'Nunito', sans-serif;
        }
    </style>
    @yield('styles')
</head>
<body>
@include('layouts.header')

<main class="container">
    <div class="d-flex justify-content-between flex-row border-bottom my-3 py-2 border-gray">
        <h1 class="title font-bolder text-dark   h3">@yield('title', 'Home')</h1>
        @hasSection('btn-route')
            <a class="btn btn-primary" href="@yield('btn-route')">
                @yield('btn-text')
            </a>
        @endif
    </div>

    <div class="my-3 p-3 bg-white rounded box-shadow shadow-sm">
        @yield('content')
    </div>
</main>
@stack('scripts')
</body>
</html>
