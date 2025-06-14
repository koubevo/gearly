<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" href="{{ asset('storage/favicon.ico') }}" type="image/x-icon">

    <meta name="robots" content="index, follow">
    <link rel="canonical" href="{{ url()->current() }}">


    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Oxanium:wght@200..800&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
        rel="stylesheet">

    <!-- SEO -->
    <meta name="description"
        content="Gearly je online bazar pro prodej a nákup softballového a baseballového vybavení.">
    <meta name="keywords" content="softball, baseball, vybavení, gear, bazar, gearly">
    <meta name="author" content="Gearly Team">

    <!-- Open Graph -->
    <meta property="og:title" content="Gearly – bazar pro baseball a softball">
    <meta property="og:description" content="Najdi nebo prodej vybavení pro baseball a softball snadno a rychle.">
    <meta property="og:image" content="https://gearly.eu/storage/imgs/bg_green.png">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">

    <!-- Twitter Card  -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Gearly – bazar pro baseball a softball">
    <meta name="twitter:description" content="Najdi nebo prodej vybavení pro baseball a softball snadno a rychle.">
    <meta name="twitter:image" content="https://gearly.eu/storage/imgs/bg_green.png">

    <!-- Scripts -->
    @routes
    @vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])
    @inertiaHead
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.12.0/dist/cdn.min.js" defer></script>
</head>

<body class="font-sans antialiased text-gray-900" style="margin-bottom: 0 !important">
    @inertia
</body>

</html>