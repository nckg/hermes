@extends('layouts.app')

@section('bodyClass', 'bg-blue-darkest')

@section('content')
<div class="flex items-center px-6 md:px-0 h-screen">
    <div class="w-full max-w-xs md:mx-auto">
        <form class="form-horizontal"
              method="POST"
              action="{{ route('login') }}">
            {{ csrf_field() }}
            <div class="flex flex-col">
                @svg("logo", "fill-current text-white w-32 mx-auto mb-6")
                <input id="email"
                       type="email"
                       placeholder="E-mail"
                       class="flex-grow p-4 border focus:outline-0 rounded-tl rounded-tr {{ $errors->has('email') ? 'border-red-dark' : 'border-grey-light' }}" name="email" value="{{ old('email') }}" required autofocus>
                <input id="password"
                       type="password"
                       placeholder="Password"
                       class="flex-grow p-4 focus:outline-0 rounded-bl rounded-br border {{ $errors->has('password') ? 'border-red-dark' : 'border-grey-light' }}" name="password" required>

                <div class="flex my-4">
                    <div class="w-1/2">
                        <button type="submit"
                                class="transition block w-full bg-green rounded text-white px-4 py-3 text-center hover:bg-green-dark">
                            Login
                        </button>
                    </div>
                    <div class="w-1/2 ml-4 flex items-center">
                        <label>
                            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> <span class="text-grey"> Remember Me</span>
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
