<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Solicita tu Credito por CBU hasta $150.000 online">
    <link rel="apple-touch-icon" sizes="57x57" href="{!! asset('images/apple-icon-57x57.png') !!}">
    <link rel="apple-touch-icon" sizes="60x60" href="{!! asset('images/apple-icon-60x60.png') !!}">
    <link rel="apple-touch-icon" sizes="72x72" href="{!! asset('images/apple-icon-72x72.png') !!}">
    <link rel="apple-touch-icon" sizes="76x76" href="{!! asset('images/apple-icon-76x76.png') !!}">
    <link rel="apple-touch-icon" sizes="114x114" href="{!! asset('images/apple-icon-114x114.png') !!}">
    <link rel="apple-touch-icon" sizes="120x120" href="{!! asset('images/apple-icon-120x120.png') !!}">
    <link rel="apple-touch-icon" sizes="144x144" href="{!! asset('images/apple-icon-144x144.png') !!}">
    <link rel="apple-touch-icon" sizes="152x152" href="{!! asset('images/apple-icon-152x152.png') !!}">
    <link rel="apple-touch-icon" sizes="180x180" href="{!! asset('images/apple-icon-180x180.png') !!}">
    <link rel="icon" type="image/png" sizes="192x192"  href="{!! asset('images/android-icon-192x192.png') !!}">
    <link rel="icon" type="image/png" sizes="32x32" href="{!! asset('images/favicon-32x32.png') !!}">
    <link rel="icon" type="image/png" sizes="96x96" href="{!! asset('images/favicon-96x96.png') !!}">
    <link rel="icon" type="image/png" sizes="16x16" href="{!! asset('images/favicon-16x16.png') !!}">
    <link rel="manifest" href="{!! asset('images/manifest.json') !!}">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="{!! asset('images/ms-icon-144x144.png') !!}">
    <meta name="theme-color" content="#ffffff">
    <meta name='keywords' content='Credito por internet, Credito online, Credito por CBU, Credito en el día, Credito argentino, Credito Buenos Aires, Credito jubilados,  Credito empleados, Credito personal, Credito con o sin veraz.'>
    <title>Creditos online</title>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!-- Custom styles for this template -->
    @section('head')@show
    <link href="{!! asset('css/styles.min.css') !!}" rel="stylesheet">
    <link href="{!! asset('css/styles_id.css') !!}" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Rubik:400,500,700&display=swap" rel="stylesheet">
    <link href="{!! asset('css/featherfont.css') !!}" rel="stylesheet">
    
  </head>

  <body class="{{isset($body_class) ? $body_class : ''}}">
    @section('header')@show
    
    @yield("content")
    @section('footer')@show
    
    @include("front.includes.scripts")
    <script type="text/javascript">
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });

      
    </script>

    @section('foot')@show
  </body>
</html>