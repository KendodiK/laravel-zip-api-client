<!doctype html>
<html lang="hu">
<head>
    <meta charset="utf-8">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'ZipCodes') }}</title>
    <!--
        olyan fontkészletet adjunk meg, amelyik helyesen jeleníti meg
        a magyar ékezetes betűket.
    -->
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
        }
        .odd {
            background-color: lightgrey;
        }
        .even {
            background-color: grey;
        }
    </style>
</head>
<body>
<div class="center">
    <main>
        @yield('content')
    </main>

    <footer>
        {{ config('app.name', 'ZipCodes') }} v{{ env('APP_VERSION') }} (PHP v{{ PHP_VERSION }})
    </footer>
</div>
</body>
</html>
