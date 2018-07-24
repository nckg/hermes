@extends('layouts.app')

@section('content')
<div class="flex items-center px-6 md:px-0 h-screen">
    <div class="w-full max-w-sm md:mx-auto px-8 pt-6 pb-8">
        <form class="form-horizontal"
              method="POST"
              action="{{ route('login') }}">
            {{ csrf_field() }}
            <div class="flex flex-col">
                <div class="text-center text-2xl text-grey mb-4">
                    @svg('logo', 'h-6 fill-current')
                </div>

                <input id="email"
                       type="email"
                       placeholder="E-mail"
                       class="shadow appearance-none border rounded w-full py-4 px-6 text-grey-darker leading-tight mb-6 {{ $errors->has('email') ? 'border-red-dark' : 'border-grey-light' }}" name="email" value="{{ old('email') }}" required autofocus>
                <input id="password"
                       type="password"
                       placeholder="Password"
                       class="shadow appearance-none border rounded w-full py-4 px-6 text-grey-darker leading-tight mb-6 {{ $errors->has('password') ? 'border-red-dark' : 'border-grey-light' }}" name="password" required>

                <button type="submit"
                        class="bg-transparent hover:bg-blue text-blue-dark font-semibold hover:text-white py-4 px-6 mr-2 border border-blue hover:border-transparent rounded">
                    Login
                </button>

                <a class="no-underline hover:underline text-center mt-4 text-grey-dark mx-auto" href="{{ route('password.request') }}">
                    Forgot Your Password?
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
