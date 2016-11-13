<!doctype html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="tok" content="{{csrf_token()}}">
	<title>@yield('title')</title>
	<link rel="icon" href="/img/icono.png">
	<!-- Styles -->
    <link href="/css/app.css" rel="stylesheet">
    <link href="/mdl/material.min.css" rel="stylesheet">
    <link href="/mdl/mdl-icons/for-icons.css" rel="stylesheet">
    @yield('css')
</head>
<body>
@yield('body')
<!-- Scripts -->
<script src="/jQuery/jquery-3.1.0.min.js"></script>
<script src="/js/app.js"></script>
<script src="/mdl/material.min.js"></script>
@yield('js')
</body>
</html>