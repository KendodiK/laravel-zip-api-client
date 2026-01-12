<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Zip</title>
</head>
<body>
<header>
    <nav>
        <ul>
            <li><a href="{{ route('cities.index') }}">Városok</a></li>
            <li><a href="{{ route('counties.index') }}">Megyék</a></li>
            <li><a href="{{ route('dashboard') }}">Bejelentkezés</a>
                <a
                    style="color:
                @if(Session::has('user_name'))
                    green
                @else
                    red
                @endif
                "
                >*</a>
            </li>
        </ul>
    </nav>
</header>
    @if (session('success'))
        <div class="success">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="error">{{ session('error') }}</div>
    @endif
    @yield('content')
</body>
</html>
