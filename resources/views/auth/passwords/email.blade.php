@extends('layouts.app')

@section('bodyClass', 'bg-blue-darkest')

@section('content')
    <div class="flex items-center px-6 md:px-0 h-screen">
        <div class="w-full max-w-xs md:mx-auto">
            <div class="flex items-center">
                @if (session('status'))
                    <div class="bg-green-lightest border border-green-light text-green-dark text-sm px-4 py-3 rounded mb-4">
                        {{ session('status') }}
                    </div>
                @endif

                <form class="w-full" method="POST" action="{{ route('password.email') }}">
                    {{ csrf_field() }}
                    <div class="flex flex-col">
                        @svg("logo", "fill-current text-white w-32 mx-auto mb-6")
                        <input id="email"
                           type="email"
                           placeholder="E-mail"
                           class="flex-grow p-4 border focus:outline-0 rounded {{ $errors->has('email') ? 'border-red-dark' : 'border-grey-light' }}" name="email" value="{{ old('email') }}" required autofocus>

                        <button type="submit"
                                class="transition mt-4 block w-full bg-green rounded text-white px-4 py-3 text-center hover:bg-green-dark">
                            Send Password Reset Link
                        </button>

                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection

