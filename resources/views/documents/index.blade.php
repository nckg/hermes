@extends('layouts.app')

@section('content')
    <overview inline-template
              :tags="{{ $tags }}">
        <div class="flex">
            <div class="w-3/4">
                <div class="shadow bg-white border border-grey-light rounded p-4">
                    <table-component
                            ref="table"
                            :data="fetchData"
                            :show-caption="false"
                            sort-by="created_at"
                            table-class="table is-hoverable is-fullwidth mt-4 mb-4"
                            filter-input-class="transition focus:outline-0 border border-transparent focus:bg-white focus:border-grey-light placeholder-grey-darkest rounded bg-grey-lighter py-2 px-4 block w-full appearance-none leading-normal ds-input mb-4"
                            sort-order="asc"
                    >
                        <table-column>
                            <template slot-scope="row">
                                <label class="label--checkbox">
                                    <input type="checkbox"
                                           class="checkbox"
                                           :value="row.id"
                                           v-model="selectedItems">
                                </label>
                            </template>
                        </table-column>
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
                                <a class="tag cursor-pointer"
                                   v-for="(tag, index) in row.tags"
                                   v-show="index < 4"
                                   :key="index"
                                   @click="selectedTags.push(tag)">
                                    @{{ tag.name.en }}
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
            <div class="w-1/4 ml-6 flex flex-col pb-4">
                <div class="shadow bg-white border border-grey-light rounded p-4"
                     v-if="selectedItems.length > 0">
                    <p class="text-grey-dark mb-4">@{{ selectedItems.length }} item(s) selected</p>

                    <button class="transition block w-full bg-green rounded text-white px-4 py-3 text-center hover:bg-green-dark mb-4"
                            @click="exportDocuments">
                        {{ __('Export items') }}
                    </button>

                    <button @click="destroy"
                            class="transition block w-full bg-red rounded text-white px-4 py-3 text-center hover:bg-red-dark">
                        {{ __('Delete items') }}
                    </button>
                </div>

                <a href="{{ route('documents.create') }}"
                   class="mt-4 transition block bg-blue rounded text-white px-4 py-3 text-center hover:bg-blue-dark">{{ __("Add file") }}</a>
                <h3 class="py-4 text-grey-darker uppercase text-sm mt-4">{{ __("Tags") }}</h3>
                <a @click="selectedTags = []"
                   :class="{ 'bg-white': selectedTags.length === 0 }"
                   class="transition p-2 text-grey-darker hover:text-blue rounded mb-2">
                    {{ __("All") }}
                </a>

                <div v-for="tag in tags"
                   class="transition flex cursor-pointer p-2 text-grey-darker hover:text-blue rounded mb-2 relative"
                   :class="{ 'bg-white': selectedTags.filter(t => t.id === tag.id).length > 0 }">
                    <a @click="selectedTags.push(tag)" class="flex-grow">@{{ tag.name.en }}</a>
                    <button class="text-grey w-6 absolute pin-r pin-t pin-b z-10"
                            v-if="selectedTags.filter(t => t.id === tag.id).length > 0"
                            @click="selectedTags.splice(selectedTags.indexOf(tag), 1)">×</button>
                </div>
            </div>
        </div>
    </overview>
@endsection
