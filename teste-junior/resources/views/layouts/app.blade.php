<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Home')</title>

    <!-- Fonts -->
    <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    @vite('resources/js/app.js')
    <style>
        body {
            font-family: 'Nunito', sans-serif;
        }

        .select2-container {
            width: auto !important;
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
        @sectionMissing('content')
            <h1>Zombie Ipsum</h1>
            Zombie ipsum reversus ab viral inferno nam rick de unrelenting de moveri, voodoo Romero fecimus et comedat
            Nigh animata terror ut attonitos Indeflexus, et apocalypsi et Fit Expansis Terror twenty-eight and locis
            serpere. Oculos in terram carnem and unrelenting plan aere vulnerum bello, guts Ut in ambulabat
            Sicut Forsitan quaeritis iam, zomby qui alypse Vivens epidemic in solum zombies.
        @endif
    </div>
</main>

<!-- Datatables -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
<script type="module" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script type="module" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.js"
        integrity="sha512-0XDfGxFliYJPFrideYOoxdgNIvrwGTLnmK20xZbCAvPfLGQMzHUsaqZK8ZoH+luXGRxTrS46+Aq400nCnAT0/w=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<!-- Select2 -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
<link rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css"/>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js" defer></script>

<!-- SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Global files -->
<script src="{{ asset('assets/js/all.js') }}" defer></script>
<script src="{{ asset('assets/js/events.js') }}" defer></script>

@stack('scripts')
</body>
</html>
