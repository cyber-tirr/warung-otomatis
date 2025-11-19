<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Warung Kopi Otomatis')</title>
    <link href="{{ asset('assets/css/bootstrap.min.css') }}?v={{ time() }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-icons.css') }}?v={{ time() }}">
    @stack('styles')
</head>
<body>
    @yield('content')

    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    @stack('scripts')
</body>
</html>
