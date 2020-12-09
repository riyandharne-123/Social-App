<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <title>Vue-Laravel</title>
 
    <link href="{{ secure_asset('css/app.css') }}" rel="stylesheet" />
    </head>
    <body>
      <div id="app">
      <App />
      </div>
    </body>

   <script src="{{ secure_asset('js/app.js') }}" defer></script>

</html>
