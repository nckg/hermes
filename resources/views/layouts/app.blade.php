<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name') }}</title>

    <meta name="csrf-param" content="_token">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="robots" content="noindex, nofollow" />
    <meta name="robots" content="none" />

    @routes

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">

    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>

</head>
<body class="font-source-sans antialiased leading-tight bg-grey-lighter @yield('bodyClass')">
    <div id="app"
         class="min-h-screen flex flex-col cloak-fade"
         v-cloak>

        @auth
            <header class="mx-auto w-full px-8 py-4 flex">
                <div class="relative flex flex-1 max-w-12">
                    <search
                        class=" bg-grey-lighter focus:bg-white border-2 border-transparent focus:border-brand rounded flex flex-1 py-4 pl-12 text-grey-darker focus:outline-none">
                        @input="
                    </search>

                    <div class="pointer-events-none absolute pin-y pin-l pl-3 flex items-center">
                        @svg("icon-search", "fill-current pointer-events-none text-grey-darker w-6 h-6")
                    </div>
                </div>
                <div class="ml-auto pl-8 py-4 flex items-center">
                    <a href="#" class="text-grey ml-auto hover:text-brand">Log out</a>
                </div>
            </header>
        @endauth

        @yield('content')

    </div>

    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="{{ mix('js/app.js') }}"></script>
</body>
</html>