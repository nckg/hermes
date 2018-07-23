<template>
    <div>
        <input class="shadow appearance-none rounded w-full py-4 px-6 text-grey-darker leading-tight mb-6"
               type="text"
               v-model="filter"
               placeholder="Search">

        <div class="fixed flex items-center pin-t pin-x bg-white px-6 py-4 shadow-md"
             v-if="selectedItems.length > 0">

            <p class="text-grey-dark">Selected items: {{ selectedItems.length }}</p>

            <div class="ml-auto">
                <button class="bg-transparent hover:bg-blue text-grey-dark font-semibold hover:text-white py-2 px-4 mr-2 border border-grey hover:border-transparent rounded"
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

        <div class="mb-4">
            <span class="mr-2 text-grey-dark">Popular tags:</span>
            <a v-for="(tag, index) in tags"
               class="inline-block bg-grey-light rounded-full px-3 py-1 text-sm font-semibold text-grey-darker mr-2 mb-2 cursor-pointer hover:bg-blue-lighter"
               v-if="index < 5 || (index > 5 && showTags)"
               @click="toggleTag(tag)"
               :class="{ 'bg-blue text-white': selectedTags.filter(t => t.id === tag.id).length > 0 }">
                {{ tag.name }}
            </a>
            <button @click="showTags = true"
                    v-if="!showTags"
                    class="text-grey-dark text-sm focus:outline-0 hover:text-blue">Show all tags</button>
            <button @click="showTags = false"
                    v-if="showTags"
                    class="text-grey-dark text-sm focus:outline-0 hover:text-blue">Hide all tags</button>
        </div>
        <div class="flex items-center justify-center py-12 text-grey-dark tracking-tight font-bold"
             v-if="data.length === 0">
            No results
        </div>

        <div v-if="!working">
            <file-list-item v-for="(item, index) in data"
                            :key="item.id"
                            v-model="data[index]"></file-list-item>
        </div>
        <div v-else
             class="flex items-center justify-center py-12">
            <icon-refresh class="spin fill-current text-grey-dark"></icon-refresh>
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