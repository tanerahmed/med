<!DOCTYPE html>
<html dir="ltr" lang="en-US">
<head>

	<meta http-equiv="content-type" content="text/html; charset=utf-8">
	<meta http-equiv="x-ua-compatible" content="IE=edge">
	<meta name="author" content="Taner Ahmed">
	<meta name="description" content="Medical Journal.">

	<!-- Font Imports -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:ital@0;1&display=swap" rel="stylesheet">

	<!-- Core Style -->
	<link rel="stylesheet" href="{{asset('../assets/css/style.css') }}">

	<!-- Font Icons -->
	<link rel="stylesheet" href=" {{asset('../assets/css/css/font-icons.css') }}">

	<!-- Custom CSS -->
	<link rel="stylesheet" href="{{asset('../assets/css/css/customs.css') }}">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- Document Title
	============================================= -->
	<title>Medical Journal</title>

	<style>
	.device-down-md .oc-item {
		height: 60vh;
	}
	</style>

</head>

<body class="stretched">

	<!-- Document Wrapper
	============================================= -->
	<div id="wrapper">

        <!-- Header -->
        @include('canva.header')
        <!-- Header END -->

        @yield('content')

        <!-- Footer -->
        @include('canva.footer')
        <!-- Footer END -->

	</div><!-- #wrapper end -->

	<!-- Go To Top
	============================================= -->
	<div id="gotoTop" class="uil uil-angle-up"></div>

	<!-- JavaScripts
	============================================= -->
	<script src="{{ asset('../assets/js/js/plugins.min.js') }}"></script>
	<script src="{{ asset('../assets/js/js/functions.bundle.js') }}"></script>

</body>
</html>