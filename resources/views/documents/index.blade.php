@extends('layouts.app')

@section('content')
    <overview inline-template
              :tags='@json($tags)'>
        <div>
            <div class="flex">
                <div class="w-full max-w-lg mx-auto">
                    <input class="shadow appearance-none rounded w-full py-4 px-6 text-grey-darker leading-tight mb-6"
                           type="text"
                           v-model="filter"
                           placeholder="{{ __('Search') }}">

                    <upload inline-template>
                        <button @click="select"
                                class="shadow-md rounded-full fixed pin-r pin-b h-10 w-10 mb-4 mr-4 bg-green text-center rounded-full p-2 hover:bg-green-dark">
                            @svg("icon-plus", "fill-current w-6 h-6 text-white")
                        </button>
                    </upload>

                    <div class="fixed flex items-center pin-t pin-x bg-white px-6 py-4 shadow-md"
                         v-if="selectedItems.length > 0">

                        <p class="text-grey-dark">{{ __('Selected items') }}: @{{ selectedItems.length }}</p>

                        <div class="ml-auto">
                            <button class="bg-transparent hover:bg-blue text-grey-dark font-semibold hover:text-white py-2 px-4 mr-2 border border-grey hover:border-transparent rounded"
                                    @click="selectedItems = []">
                                {{ __('Deselect items') }}
                            </button>

                            <button class="bg-transparent hover:bg-blue text-blue-dark font-semibold hover:text-white py-2 px-4 mr-2 border border-blue hover:border-transparent rounded"
                                    @click="exportDocuments">
                                {{ __('Export items') }}
                            </button>

                            <button class="bg-transparent hover:bg-red text-red-dark font-semibold hover:text-white py-2 px-4 border border-red hover:border-transparent rounded"
                                    @click="destroy">
                                {{ __('Delete items') }}
                            </button>
                        </div>
                    </div>

                    <div class="mb-4">
                        <span class="mr-2 text-grey-dark">{{ __('Popular tags') }}:</span>
                        <a v-for="tag in tags"
                           class="inline-block bg-grey-light rounded-full px-3 py-1 text-sm font-semibold text-grey-darker mr-2 mb-2 cursor-pointer"
                           @click="toggleTag(tag)"
                           :class="{ 'bg-blue text-white': selectedTags.filter(t => t.id === tag.id).length > 0 }">
                            @{{ tag.name }}
                        </a>
                    </div>

                    <div class="flex items-center justify-center py-12"
                         v-if="isWorking">
                        @svg("icon-refresh", "spin fill-current text-grey-dark")
                    </div>
                    <div v-if="!isWorking"
                         v-for="item in data"
                         :key="item.id">
                            <div v-if="item.showDetail"
                                 class="fixed overflow-hidden pin bg-white flex h-screen">
                                <button class="absolute pin-r pin-t mr-4 mt-4 text-grey text-2xl"
                                        @click="$set(item, 'showDetail', !item.showDetail)">&times;</button>
                                <div class="w-3/4 flex flex-1">
                                    <iframe :src="route('media.show', { id: item.id })"
                                            class="w-full flex-1"></iframe>
                                </div>
                                <div class="w-1/4 py-6 px-4">
                                    <p class="font-bold text-lg">@{{ item.title }}</p>

                                    <div class="flex mt-1">
                                        <p class="text-sm text-grey-dark flex items-center mr-4">
                                            @svg("icon-calander", "fill-current text-grey w-4 h-4 mr-2 -mt-px")
                                            <span>@{{ item.date }}</span>
                                        </p>
                                        <p class="text-sm text-grey-dark flex items-center">
                                            @svg("icon-building", "fill-current text-grey w-4 h-4 mr-2 -mt-px")
                                            <span>@{{ item.sender }}</span>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="flex rounded overflow-hidden shadow-md bg-white mb-6">
                                <div class="flex pl-6 items-center">
                                    <button v-if="selectedItems.indexOf(item.id) === -1"
                                            class="outline-none focus:outline-none border-0 text-grey hover:text-green"
                                            @click="selectedItems.push(item.id)">
                                        @svg("icon-plus-circle", "w-10 h-10 fill-current")
                                    </button>
                                    <button v-else
                                            class="outline-none focus:outline-none border-0 text-green"
                                            @click="selectedItems.splice(selectedItems.indexOf(item.id), 1)">
                                        @svg("icon-check-circle", "w-10 h-10 fill-current")
                                    </button>
                                </div>
                                <div class="flex-1">
                                    <div class="px-6 pt-4">
                                        <a class="font-bold text-lg hover:text-blue-dark cursor-pointer"
                                           @click="$set(item, 'showDetail', !item.showDetail)">
                                            @{{ item.title }}
                                        </a>

                                        <div class="flex mt-1">
                                            <p class="text-sm text-grey-dark flex items-center mr-4">
                                                @svg("icon-calander", "fill-current text-grey w-4 h-4 mr-2 -mt-px")
                                                <span>@{{ item.date }}</span>
                                            </p>
                                            <p class="text-sm text-grey-dark flex items-center">
                                                @svg("icon-building", "fill-current text-grey w-4 h-4 mr-2 -mt-px")
                                                <span>@{{ item.sender }}</span>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="px-6 py-4">
                                        <a class="inline-block bg-grey-lighter rounded-full px-3 py-1 text-sm font-semibold text-grey-darker mr-2 mb-2 cursor-pointer"
                                           v-for="(tag, index) in item.tags"
                                           :key="index"
                                           :class="{ 'bg-blue text-white': selectedTags.filter(t => t.id === tag.id).length > 0 }"
                                           @click="toggleTag(tag)">
                                            @{{ tag.name }}
                                        </a>
                                    </div>
                                </div>
                                <div class="flex px-6 items-center">
                                    <a :href="route('media.show', { id: item.id, download: true })"
                                       class="w-6 h-6 text-grey hover:text-blue-dark">
                                        @svg('icon-download', 'w-6 h-6 fill-current')
                                    </a>
                                </div>
                            </div>
                    </div>

                    <div class="flex items-center justify-center py-12 text-grey-dark tracking-tight font-bold"
                         v-if="data.length === 0">
                        {{ __('No results') }}
                    </div>
                </div>
            </div>
        </div>
    </overview>
@endsection