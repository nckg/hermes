@extends('layouts.app')

@section('content')
    <div class="mx-auto max-w-md">
        <div class="mt-4 bg-white border border-grey-light rounded p-4">
            <h1 class="font-normal text-2xl text-grey-darker">@lang("Add document")</h1>
            {{ html()->form('post', route('documents.store'))->acceptsFiles()->class("pt-4")->open() }}
            {{ html()->file('file') }}
            <div class="flex justify-end">
                <a href="{{ route('documents.index') }}"
                   class="transition block bg-transparent rounded px-4 py-3 text-center hover:bg-blue-lightest mr-4">Cancel</a>
                {{ html()->submit(__('Submit'))->class('transition block bg-blue rounded text-white px-4 py-3 text-center hover:bg-blue-dark') }}
            </div>
            {{ html()->form()->close() }}
        </div>
    </div>
@endsection
