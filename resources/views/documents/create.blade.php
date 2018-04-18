@extends('layouts.app')

@section('content')
    <div class="mx-auto max-w-md">
        <a href="{{ route('documents.index') }}"
           class="text-sm text-blue hover:text-blue-dark">{{ __("Overview") }}</a>
        <div class="mt-4 bg-white border border-grey-light rounded p-4">
            <h1 class="font-normal text-2xl text-grey-darker">@lang("Add document")</h1>
            {{ html()->form('post', route('documents.store'))->acceptsFiles()->open() }}
            {{ html()->file('file') }}
            {{ html()->submit(__('Submit'))->class('transition block bg-blue rounded text-white px-4 py-3 text-center hover:bg-blue-dark') }}
            <a href="{{ route('documents.index') }}"
               class="transition block bg-transparent rounded px-4 py-3 text-center hover:bg-blue-lightest">Cancel</a>
            {{ html()->form()->close() }}
        </div>
    </div>
@endsection
