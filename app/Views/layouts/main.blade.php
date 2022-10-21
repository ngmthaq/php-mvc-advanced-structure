<!DOCTYPE html>
<html lang="{{ locale() }}">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @meta
    @stack('meta')
    <title>@yield('title')</title>
    <link rel="shortcut icon" href="{{ assets('img/favicon.ico') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ assets('libs/bootstrap/dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ assets('libs/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ assets('css/index.css') }}">
    @stack('css')
</head>

<body>
    <div class="main">
        @yield('main')
    </div>

    <script>
        function trans(key, replace = {}) {
            let translations = @php echo $_lang @endphp;
            let translation = translations[key] || key;
            for (var placeholder in replace) {
                translation = translation.replace(`:${placeholder}`, replace[placeholder]);
            }

            return translation;
        }
    </script>

    <script src="{{ assets('libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ assets('libs/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <script src="{{ assets('libs/fontawesome/js/all.min.js') }}"></script>
    <script src="{{ assets('js/index.js') }}"></script>

    @stack('js')
</body>

</html>
