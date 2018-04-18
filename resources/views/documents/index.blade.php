@extends('layouts.app')

@section('content')
    <div class="flex">
        <div class="w-3/4">
            <div class="shadow bg-white border border-grey-light rounded p-4">
                <table-component
                        :data="{{ $models }}"
                        :show-caption="false"
                        sort-by="created_at"
                        table-class="table is-hoverable is-fullwidth mt-4 mb-4"
                        filter-input-class="transition focus:outline-0 border border-transparent focus:bg-white focus:border-grey-light placeholder-grey-darkest rounded bg-grey-lighter py-2 px-4 block w-full appearance-none leading-normal ds-input mb-4"
                        sort-order="asc"
                >
                    <table-column show="title"
                                  label="{{ __("Title") }}">
                        <template slot-scope="row">
                            <a :href="route('documents.show', { id: row.id })">@{{ row.title }}</a>
                        </template>
                    </table-column>
                    <table-column label="{{ __("Sender") }}"
                                  show="sender"></table-column>
                    <table-column show="date"
                                  label="{{ __("Date") }}"
                                  :filterable="false"
                                  data-type="date:DD/MM/YYYY"></table-column>
                    <table-column show="created_at"
                                  label="{{ __("Created at") }}"
                                  :filterable="false"
                                  data-type="date:DD/MM/YYYY"></table-column>
                    <table-column>
                        <template slot-scope="row">
                            <a class="tag"
                               v-for="(tag, index) in row.tags"
                               v-show="index < 4"
                               :key="index"
                               :href="route('documents.index', { tag: tag })">
                                @{{ tag }}
                            </a>
                            <span class="tag" v-if="row.tags.slice(4).length > 0">+ @{{ row.tags.slice(4).length }}</span>
                        </template>
                    </table-column>
                    <table-column>
                        <template slot-scope="row">
                            <a :href="row.originalUrl"
                               class="hover:text-blue-dark">@svg('icon-download', 'fill-current w-4 h-4')</a>
                        </template>
                    </table-column>
                </table-component>
            </div>
        </div>
        <div class="w-1/4 ml-6 flex flex-col py-4">
            <a href="{{ route('documents.create') }}"
               class="transition block bg-blue rounded text-white px-4 py-3 text-center hover:bg-blue-dark">{{ __("Add file") }}</a>
            <h3 class="py-4 text-grey-darker uppercase text-sm mt-4">{{ __("Tags") }}</h3>
            <a href="{{ route('documents.index') }}"
               class="transition p-2 text-grey-darker hover:text-blue rounded {{ !request()->has('tag') ? 'bg-white': null }}">
                {{ __("All") }}
            </a>
            @foreach ($tags as $tag)
                <a href="{{ route('documents.index', ['tag' => $tag->name]) }}"
                   class="transition p-2 text-grey-darker hover:text-blue rounded {{ request()->input('tag') === $tag->name ? 'bg-white': null }}">
                    {{ ucfirst($tag->name) }}
                </a>
            @endforeach
        </div>

    </div>
@endsection
