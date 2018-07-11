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

            <edit-data url="{{ route('documents.update', $model->id) }}"
                       value="{{ $model->title }}">
                <div slot-scope="{ input, update, inputEvents, inputAttrs, save, editing, toggleEditing }">
                    <h1 class="font-normal text-2xl text-grey-darkest mt-2 mb-4"
                        v-if="!editing"
                        @click="toggleEditing">@{{ input }}</h1>
                    <div class="mt-2 mb-4"
                         v-if="editing">
                        <input type="text"
                               class="input"
                               v-on="inputEvents"
                               v-bind="inputAttrs" />
                        <button type="button"
                                class="button"
                                @click="save({ title: input })">{{ __('Save') }}</button>
                    </div>
                </div>
            </edit-data>

            <div class="flex mb-4 flex-wrap">
                {{--@foreach($model->tags as $tag)--}}
                    {{--<a href="{{ route('documents.index', ['tag' => $tag->name]) }}"--}}
                       {{--class="tag mb-2 mr-2">{{ $tag->name }}</a>--}}
                {{--@endforeach--}}

                {{--<edit-data url="{{ route('documents.update', $model->id) }}"--}}
                           {{--:value="{{ $model->tags->pluck('name') }}">--}}
                    {{--<div slot-scope="{ input, update, save, editing, toggleEditing }">--}}
                        {{--<tags-input v-model="input">--}}
                            {{--<div slot-scope="{ tags, addTag, removeTag, inputAttrs, inputEvents }"--}}
                                 {{--class="p-4 rounded border bg-white">--}}
                                {{--<div class="flex">--}}
                                    {{--<input class="text-input flex-1 mr-2"--}}
                                           {{--placeholder="New tag"--}}
                                           {{--v-on="inputEvents"--}}
                                           {{--v-bind="inputAttrs">--}}
                                    {{--<button type="button" class="btn btn-primary" @click="addTag">--}}
                                        {{--Add--}}
                                    {{--</button>--}}
                                {{--</div>--}}

                                {{--<ul v-show="tags.length > 0" class="mt-4 pl-6">--}}
                                    {{--<li v-for="tag in tags" class="mb-2">--}}
                                        {{--<span class="mr-2">@{{ tag }}</span>--}}
                                        {{--<button class="text-grey-dark hover:text-grey-darkest underline text-sm" @click="removeTag(tag)">Remove</button>--}}
                                    {{--</li>--}}
                                {{--</ul>--}}
                            {{--</div>--}}
                        {{--</tags-input>--}}
                    {{--</div>--}}
                {{--</edit-data>--}}
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
