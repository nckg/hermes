<template>
    <div>
        <!--<div class="max-w-lg mx-auto bg-white p-6 mb-4 -mt-20 rounded shadow">-->
            <!--<input class="bg-white border-2 border-grey-6 rounded w-full py-4 px-4 text-grey-3 leading-tight focus:outline-0"-->
                   <!--type="text"-->
                   <!--v-model="filter"-->
                   <!--placeholder="Search">-->
            <!--<div class="mt-4">-->
                <!--<span class="mr-2 text-grey-4">Popular tags:</span>-->
                <!--<a v-for="(tag, index) in tags"-->
                   <!--class="inline-block bg-grey-8 rounded-full px-3 py-1 text-sm font-semibold text-grey-2 mr-2 mb-2 cursor-pointer hover:bg-indigo-9 hover:text-indigo-3"-->
                   <!--v-if="index < 5 || (index > 5 && showTags)"-->
                   <!--@click="toggleTag(tag)"-->
                   <!--:class="{ 'bg-indigo text-white': selectedTags.filter(t => t.id === tag.id).length > 0 }">-->
                    <!--{{ tag.name }}-->
                <!--</a>-->
                <!--<button @click="showTags = true"-->
                        <!--v-if="!showTags"-->
                        <!--class="text-grey-4 text-sm focus:outline-0 hover:text-blue">Show all tags</button>-->
                <!--<button @click="showTags = false"-->
                        <!--v-if="showTags"-->
                        <!--class="text-grey-4 text-sm focus:outline-0 hover:text-blue">Hide all tags</button>-->
            <!--</div>-->
        <!--</div>-->

        <!--<div class="fixed flex items-center pin-b pin-x bg-white px-6 py-4 shadow-md"-->
             <!--v-if="selectedItems.length > 0">-->

            <!--<p class="text-grey-4">Selected items: {{ selectedItems.length }}</p>-->

            <!--<div class="ml-auto">-->
                <!--<button class="bg-transparent hover:bg-blue text-grey-4 font-semibold hover:text-white py-2 px-4 mr-2 border border-grey hover:border-transparent rounded"-->
                        <!--@click="deselectItems">-->
                    <!--Deselect items-->
                <!--</button>-->

                <!--<button class="bg-transparent hover:bg-blue text-blue-dark font-semibold hover:text-white py-2 px-4 mr-2 border border-blue hover:border-transparent rounded"-->
                        <!--@click="exportDocuments">-->
                    <!--Export items-->
                <!--</button>-->

                <!--<button class="bg-transparent hover:bg-red text-red-dark font-semibold hover:text-white py-2 px-4 border border-red hover:border-transparent rounded"-->
                        <!--@click="destroy">-->
                    <!--Delete items-->
                <!--</button>-->
            <!--</div>-->
        <!--</div>-->

        <empty
            class="flex flex-col w-full items-center text-grey"
            v-if="data.length === 0">
        </empty>

        <div
            v-if="!loading"
            class="px-2 w-full">
            <div class="w-full flex flex-1 flex-wrap -mx-4">
                <div
                    class="w-1/3 px-2 mb-8 flex items-stretch"
                    v-for="(item, index) in data"
                    :key="item.id">
                    <file-list-item
                        @select="showDetail"
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
    import debounce from 'lodash/debounce';
    import { Documents } from '../api';
    import FileListItem from './FileListItem.vue';
    import IconRefresh from '../../svg/icon-refresh.svg';
    import Empty from './Empty.vue';
    import Hub from '../lib/Hub';

    export default {
        props: ["tags"],

        components: {
            FileListItem,
            IconRefresh,
            Empty
        },

        data() {
            return {
                selectedTags: [],
                loading: false,
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
        },

        created() {
            Hub.$on("hermes:searching", debounce(async (value) => {
                await this.fetchData({ filter: value });
            }, 250));

            this.fetchData({ filter: '' });
        },

        methods: {
            showDetail(value) {
                Hub.$emit("hermes:detail", value);
            },

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

                this.loading = true;

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
                        this.loading = false;
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
                this.loading = true;

                // const tag = this.selectedTags.map(tag => tag.name);
                const { data } = await Documents.all({ filter });

                this.data = data;

                this.loading = false;
            },
        },
    };
</script>