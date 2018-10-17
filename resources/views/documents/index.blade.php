@extends('layouts.app')

@section('content')
    <file-list :tags='@json($tags)'
               class="w-full max-w-lg mx-auto"></file-list>
@endsection