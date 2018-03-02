<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="pusher-public-key" content="{{ config('broadcasting.connections.pusher.key') }}">

        <title>FACET</title>

        <link rel="stylesheet" href="{{ mix('/css/app.css') }}">
    </head>

    <body class="theme-page">
        <!-- Entry Point for Vue SPA -->
        <div id="app">
            <app></app>
        </div>

        <!-- Imports for JS files -->
        <script src="{{ mix('/js/manifest.js') }}"></script>
        <script src="{{ mix('/js/vendor.js') }}"></script>
        <script src="{{ mix('/js/app.js') }}"></script>
    </body>
</html>
