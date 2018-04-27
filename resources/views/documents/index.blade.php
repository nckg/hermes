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
                            table-class="table w-full mt-4 mb-4"
                            filter-input-class="input w-full"
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
                                <a class="text-blue hover:text-blue-dark" :href="route('documents.show', { id: row.id })">@{{ row.title }}</a>
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
                            <template slot-scope="{ tags }">
                                <a class="tag hover:bg-blue hover:text-white mr-2 cursor-pointer"
                                   v-for="(tag, index) in tags"
                                   v-show="index < 4"
                                   :key="index"
                                   :class="{ 'bg-blue text-white': selectedTags.filter(t => t.id === tag.id).length > 0 }"
                                    @click="toggleTag(tag)">
                                    @{{ tag.name.en }}
                                </a>
                                <span class="tag" v-if="tags.slice(4).length > 0">+ @{{ row.tags.slice(4).length }}</span>
                            </template>
                        </table-column>
                        <table-column>
                            <template slot-scope="{ id }">
                                <a :href="route('media.show', { id, download: true })"
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

                    <button class="button block w-full mb-4"
                            @click="exportDocuments">
                        {{ __('Export items') }}
                    </button>

                    <button @click="destroy"
                            class="button block w-full bg-orange">
                        {{ __('Delete items') }}
                    </button>
                </div>

                <upload inline-template>
                    <a class="button bg-green mt-4"
                       :class="{ 'is-loading': isWorking }"
                       @click="select">{{ __("Add file(s)") }}</a>
                </upload>
                <h3 class="py-4 text-silver uppercase text-sm mt-4">{{ __("Tags") }}</h3>

                <div>
                    <a v-for="tag in tags"
                       class="tag hover:bg-blue hover:text-white mr-2 mb-2 cursor-pointer relative"
                       @click="toggleTag(tag)"
                       :class="{ 'bg-blue text-white': selectedTags.filter(t => t.id === tag.id).length > 0 }">
                        @{{ tag.name.en }}
                    </a>
                </div>
            </div>
        </div>
    </overview>
@endsection
