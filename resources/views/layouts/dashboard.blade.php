<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@yield('title')</title>

        <!-- Fonts -->
        <!-- <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css"> -->
        <link rel="stylesheet" href="{{mix('css/app.css')}}">
    </head>
    <body>
        @include('layouts.mainNav')
        @include('layouts.mainNav')
        <div class="container-fluid">
            <div class="row">
            <div class="col-sm-3 col-md-2 sidebar">
                
            </div>
            <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
                <h1 class="page-header">@yield('</h1>
                <h2 class="sub-header">Section title</h2>
                <div class="table-responsive">
                </div>
            </div>
            </div>
        </div>
        <script src="{{ mix('js/app.js') }}"></script>
    </body>
</html>