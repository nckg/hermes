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
<body class="font-source-sans antialiased leading-tight bg-grey-10 @yield('bodyClass')">
    <div id="app"
         class="min-h-screen flex flex-col min-w-md cloak-fade"
         v-cloak>

        @auth
        <div class="heading flex h-48 items-center mb-2 bg-indigo-3 pb-12 relative overflow-hidden">
            <div class="w-full max-w-screen-xl relative mx-auto px-6">
                <div class="flex items-center -mx-6">
                    <div class="flex items-center mx-auto">
                        <a href="/" class="block text-white tracking-tight font-black hover:text-blue">
                            @svg('logo', 'h-6 fill-current')
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endauth
        <div class="flex z-20">
            <div class="w-full max-w-screen-xl mx-auto px-6 mb-12">
                @yield('content')
            </div>
        </div>
    </div>

    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="{{ mix('js/app.js') }}"></script>
</body>
</html>