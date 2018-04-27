@extends('layouts.app')

@section('content')
    <div class="flex">
        <div class="w-3/4">
            <div class="bg-white mb-4">
                <iframe src="{{ route('media.show', $model->id) }}" class="w-full h-screen"></iframe>
            </div>
        </div>

        <div class="w-1/4 ml-6 flex flex-col">
            <a href="{{ route('documents.index') }}"
               class="text-sm text-blue hover:text-blue-dark">
                {{ __('Overview') }}
            </a>

            <h1 class="font-normal text-2xl text-grey-darkest mt-2 mb-4">
                {{ $model->title }}
            </h1>

            <div class="flex mb-4 flex-wrap">
                @foreach($model->tags as $tag)
                    <a href="{{ route('documents.index', ['tag' => $tag->name]) }}"
                       class="tag mb-2 mr-2">{{ $tag->name }}</a>
                @endforeach
            </div>

            <dl class="flex flex-wrap">
                <dt class="py-2 w-1/4 font-semibold border-b border-grey-light">{{ __('Date') }}</dt>
                <dd class="py-2 w-3/4 text-right border-b border-grey-light">{{ $model->date->format('d/m/Y') }}</dd>
                <dt class="py-2 w-1/4 font-semibold border-b border-grey-light">{{ __('Created at') }}</dt>
                <dd class="py-2 w-3/4 text-right border-b border-grey-light">{{ $model->created_at->format('d/m/Y') }}</dd>
            </dl>

            <a href="{{ route('media.show', [$model->id, 'download']) }}"
               class="mt-4 button bg-green">
                Download
            </a>
        </div>
    </div>
@endsection
