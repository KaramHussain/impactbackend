<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel')}}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/master.css') }}" rel="stylesheet">

</head>

<body>

    <!-- <template id="app"> -->

        <div id="app">
            @include('layouts.navbar')
            <main class="container py-4">
                @yield('content')
            </main>
        </div>

    <!-- </template> -->

</body>
<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('js/back-parts.js') }}"></script>
<script src="{{ asset('js/back-spots.js') }}"></script>
<script src="{{ asset('js/front-parts.js') }}"></script>
<script src="{{ asset('js/front-spots.js') }}"></script>
<script src="{{ asset('js/interact-script.js')}}"></script>
<script src="{{ asset('js/dependencies/maps.js')}}"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBKKGOquRJaJKpo5XuSrlCD-cPtJgXXd24=places&callback=initMap"
        async></script>
</html>
