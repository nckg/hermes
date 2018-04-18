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
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,400i,600,600i,700,700i" rel="stylesheet">
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">

    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>

</head>
<body class="font-source-sans antialiased leading-tight bg-grey-lighter">
    <div id="app" class="min-h-screen flex flex-col min-w-md cloak-fade" v-cloak>
        <div class="flex bg-white border-b border-grey-light h-16 items-center mb-6 shadow">
            <div class="w-full max-w-screen-xl relative mx-auto px-6">
                <div class="flex items-center -mx-6">
                    <div class="lg:w-1/4 xl:w-1/5 pl-6 pr-6 lg:pr-8">
                        <div class="flex items-center">
                            <a href="/" class="block font-black text-lg tracking-tight text-grey hover:text-grey-darker">
                                {{ config("app.name") }}
                            </a>
                        </div>
                    </div>
                    @auth
                    <div class="lg:w-3/4 xl:w-4/5 pl-6 pr-6 lg:pr-8 flex justify-end">
                        <a href="{{ route('logout') }}"
                           class="text-grey hover:text-grey-darker"
                           onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                            {{ __('Log out') }}
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </div>
                    @endauth
                </div>
            </div>
        </div>
        <div class="flex">
            <div class="w-full max-w-screen-xl relative mx-auto px-6 mb-12">
                @yield('content')
            </div>
        </div>
    </div>

    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="{{ mix('js/app.js') }}"></script>
</body>
</html>