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
    <div class="overlay">
      <div class="loading">
        <div class="loading-bar"></div>
        <div class="loading-bar"></div>
        <div class="loading-bar"></div>
        <div class="loading-bar"></div>
      </div>
    </div>
<style>
.loading {
  position: absolute;
  top: 50%;
  left: 50%;
}
.overlay {
  position: absolute; /* Sit on top of the page content */
  display:none;
  width: 100%; /* Full width (cover the whole page) */
  height: 100%; /* Full height (cover the whole page) */
  top: 0; 
  left: 0;
  right: 0;
  bottom: 0;
  background-color: rgba(0,0,0,0.5); /* Black background with opacity */
  z-index: 99999999999 !important; /* Specify a stack order in case you're using a different order for other elements */
  cursor: not-allowed; /* Add a pointer on hover */
}
.loading-bar {
  display: inline-block;
  width: 4px;
  height: 18px;
  border-radius: 4px;
  animation: loading 1s ease-in-out infinite;
}
.loading-bar:nth-child(1) {
  background-color: #3498db;
  animation-delay: 0;
}
.loading-bar:nth-child(2) {
  background-color: #c0392b;
  animation-delay: 0.09s;
}
.loading-bar:nth-child(3) {
  background-color: #f1c40f;
  animation-delay: .18s;
}
.loading-bar:nth-child(4) {
  background-color: #27ae60;
  animation-delay: .27s;
}



@keyframes loading {
  0% {
    transform: scale(1);
  }
  20% {
    transform: scale(1, 2.2);
  }
  40% {
    transform: scale(1);
  }
}
</style>
        @include('menu.dashboard')
        
        <div class="container-fluid">
          <div id="app" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            @yield('content')
          </div>
        </div>
        <script>
        window.Laravel = {
          csrftoken : "{{ csrf_token() }}",
        };
        </script>
        <script src="{{ mix('js/app.js') }}"></script>
        
        <!-- <script src="{{ URL::to('js/custom.js') }}"></script> -->
        @yield('readyJS')


    </body>
</html>