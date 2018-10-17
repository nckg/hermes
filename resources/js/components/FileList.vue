<template>
    <div>
        <div class="bg-white p-6 mb-4 -mt-20 rounded shadow">
            <input class="bg-white border-2 border-grey-6 rounded w-full py-4 px-4 text-grey-3 leading-tight focus:outline-0"
                   type="text"
                   v-model="filter"
                   placeholder="Search">
            <div class="mt-4">
                <span class="mr-2 text-grey-4">Popular tags:</span>
                <a v-for="(tag, index) in tags"
                   class="inline-block bg-grey-8 rounded-full px-3 py-1 text-sm font-semibold text-grey-2 mr-2 mb-2 cursor-pointer hover:bg-indigo-9 hover:text-indigo-3"
                   v-if="index < 5 || (index > 5 && showTags)"
                   @click="toggleTag(tag)"
                   :class="{ 'bg-indigo text-white': selectedTags.filter(t => t.id === tag.id).length > 0 }">
                    {{ tag.name }}
                </a>
                <button @click="showTags = true"
                        v-if="!showTags"
                        class="text-grey-4 text-sm focus:outline-0 hover:text-blue">Show all tags</button>
                <button @click="showTags = false"
                        v-if="showTags"
                        class="text-grey-4 text-sm focus:outline-0 hover:text-blue">Hide all tags</button>
            </div>
        </div>

        <div class="fixed flex items-center pin-b pin-x bg-white px-6 py-4 shadow-md"
             v-if="selectedItems.length > 0">

            <p class="text-grey-4">Selected items: {{ selectedItems.length }}</p>

            <div class="ml-auto">
                <button class="bg-transparent hover:bg-blue text-grey-4 font-semibold hover:text-white py-2 px-4 mr-2 border border-grey hover:border-transparent rounded"
                        @click="deselectItems">
                    Deselect items
                </button>

                <button class="bg-transparent hover:bg-blue text-blue-dark font-semibold hover:text-white py-2 px-4 mr-2 border border-blue hover:border-transparent rounded"
                        @click="exportDocuments">
                    Export items
                </button>

                <button class="bg-transparent hover:bg-red text-red-dark font-semibold hover:text-white py-2 px-4 border border-red hover:border-transparent rounded"
                        @click="destroy">
                    Delete items
                </button>
            </div>
        </div>

        <div class="flex items-center justify-center py-12 text-grey-4 tracking-tight font-bold"
             v-if="data.length === 0">
            No results
        </div>

        <div
            v-if="!working"
            class="px-2">
            <div class="flex flex-wrap -mx-4">
                <div class="w-1/2 px-2 mb-4"
                     v-for="(item, index) in data"
                     :key="item.id">
                    <file-list-item
                        v-model="data[index]">
                    </file-list-item>
                </div>
            </div>

        </div>
        <div v-else
             class="flex items-center justify-center py-12">
            <icon-refresh class="spin fill-current text-grey-4"></icon-refresh>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';
    import { findIndex } from 'lodash';
    import FileListItem from './FileListItem.vue';
    import IconRefresh from '../../svg/icon-refresh.svg';

    export default {
        props: ["tags"],

        components: {
            FileListItem,
            IconRefresh
        },

        data() {
            return {
                filter: '',
                selectedTags: [],
                working: false,
                data: [],
                showTags: false,
            };
        },

        computed: {
            selectedItems() {
                return this.data.filter(({ selected }) => selected);
            },
        },

        watch: {
            selectedTags() {
                this.fetchData({ filter: this.filter });
            },

            filter(val) {
                this.fetchData({ filter: val });
            },
        },

        created() {
            this.fetchData({ filter: '' });
        },

        methods: {
            toggleTag(tag) {
                const index = findIndex(this.selectedTags, { id: tag.id });

                if (index > -1) {
                    this.selectedTags.splice(index, 1);
                } else {
                    this.selectedTags.push(tag);
                }
            },

            destroy() {
                if (!confirm('Destroy these documents?')) {
                    return;
                }

                this.working = true;

                axios({
                    method: 'delete',
                    url: this.route('api::documents.destroy'),
                    data: { id: this.selectedItems.map(({ id }) => id) },
                })
                    .then(() => {
                        this.fetchData({ filter: this.filter });
                        this.selectedItems = [];
                    })
                    .catch(() => {})
                    .finally(() => {
                        this.working = false;
                    });
            },

            exportDocuments() {
                const form = document.createElement("form");
                form.setAttribute("method", "post");
                form.setAttribute("action", this.route('api::export.store'));

                this.selectedItems.forEach(({ id }) => {
                    const hiddenField = document.createElement("input");
                    hiddenField.setAttribute("type", "hidden");
                    hiddenField.setAttribute("name", "id[]");
                    hiddenField.setAttribute("value", id);
                    form.appendChild(hiddenField);
                });

                document.body.appendChild(form);

                form.submit();
            },

            deselectItems() {
                this.data.forEach((item) => {
                    this.$set(item, 'selected', false);
                });
            },

            async fetchData({ filter }) {
                this.working = true;

                const tag = this.selectedTags.map(tag => tag.name);
                const { data } = await axios.get(this.route('api::documents.index', { filter, tag }));

                this.data = data;

                this.working = false;
            },
        },
    };
</script>