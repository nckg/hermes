@extends('layouts.app')

@section('content')
    <file-list :tags='@json($tags)'
               class="w-full max-w-lg mx-auto"></file-list>
    {{--<overview inline-template--}}
              {{--:tags='@json($tags)'>--}}
        {{--<div>--}}
            {{--<div class="flex">--}}
                {{--<div class="w-full max-w-lg mx-auto">--}}



                    {{--<div v-if="!isWorking"--}}
                         {{--v-for="item in data"--}}
                         {{--:key="item.id">--}}
                            {{--<detail v-if="item.showDetail"--}}
                                    {{--v-model="item"--}}
                                    {{--class="fixed overflow-hidden pin bg-white flex h-screen"--}}
                                    {{--@close="$set(item, 'showDetail', false)"></detail>--}}


                    {{--</div>--}}

                    {{--<div class="flex items-center justify-center py-12 text-grey-dark tracking-tight font-bold"--}}
                         {{--v-if="data.length === 0">--}}
                        {{--{{ __('No results') }}--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</overview>--}}
@endsection