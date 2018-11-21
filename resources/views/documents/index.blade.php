@extends('layouts.app')

@section('content')
    <file-list
        class="mx-auto w-full px-8 py-4 flex flex-wrap">
    </file-list>

    <file-list-detail
            class="flex fixed pin bg-white"
            v-if="file"
            v-model="file"
            @close="file = null">
    </file-list-detail>
@endsection