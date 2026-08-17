<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ in_array(app()->getLocale(), ['ps','fa'], true) ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'EMIS') }}</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
</head>
<body class="bg-light min-vh-100 d-flex align-items-center justify-content-center p-3">
    <main class="card shadow-sm border-0 rounded-4 w-100" style="max-width: 460px">
        <div class="card-body p-4">{{ $slot }}</div>
    </main>
</body>
</html>
