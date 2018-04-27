@extends('layouts.app')

@section("bodyClass", "bg-blue-dark")

@section('content')
<div class="flex items-center px-6 md:px-0 h-screen">
    <div class="w-full max-w-sm md:mx-auto bg-white rounded p-6 shadow">
        <form class="form-horizontal"
              method="POST"
              action="{{ route('login') }}">
            {{ csrf_field() }}
            <div class="flex flex-col">
                @svg("logo", "fill-current text-blue-dark w-24 mx-auto mb-8 mt-4")
                <input id="email"
                       type="email"
                       placeholder="E-mail"
                       class="input rounded-bl-none rounded-br-none {{ $errors->has('email') ? 'border-red-dark' : 'border-grey-light' }}" name="email" value="{{ old('email') }}" required autofocus>
                <input id="password"
                       type="password"
                       placeholder="Password"
                       class="input rounded-tl-none rounded-tr-none {{ $errors->has('password') ? 'border-red-dark' : 'border-grey-light' }}" name="password" required>

                <div class="flex my-4">
                    <div class="w-1/2">
                        <button type="submit"
                                class="button block w-full">
                            Login
                        </button>
                    </div>
                    <div class="w-1/2 ml-4 flex items-center">
                        <label>
                            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> <span class="text-grey-darker"> Remember Me</span>
                        </label>
                    </div>
                </div>

                <a class="no-underline hover:underline text-grey-dark mx-auto" href="{{ route('password.request') }}">
                    Forgot Your Password?
                </a>

            </div>



        </form>
    </div>
</div>
@endsection
