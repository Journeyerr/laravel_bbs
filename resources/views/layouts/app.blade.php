<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="description" content="{{config('web.seo.description')}}" />
    <meta name="keyword" content="{{config('web.seo.keyword')}}" />
    <title>AnYuan 进阶教程</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @yield('styles')
</head>

<body>
<div id="app" class="{{ route_class() }}-page">

    @include('layouts.header')

    <div class="container">

        @include('layouts.messages')
        @yield('content')

    </div>

    @include('layouts.footer')
</div>

    {{--@if (app()->isLocal())--}}
        {{--@include('sudosu::user-selector')--}}
    {{--@endif--}}

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    @yield('scripts')
</body>
</html>
