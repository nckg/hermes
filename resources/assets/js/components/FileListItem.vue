<template>
    <div>
        <file-list-detail v-model="item"
                          v-if="detail"
                          @close="detail = false"
                          class="fixed overflow-hidden pin bg-white flex h-screen"></file-list-detail>

        <div class="flex rounded overflow-hidden shadow-md bg-white mb-6">
            <div class="flex pl-6 items-center">
                <button v-if="!item.selected"
                        class="outline-none focus:outline-none border-0 text-grey hover:text-green"
                        @click="select">
                    <icon-plus-circle class="w-10 h-10 fill-current"></icon-plus-circle>
                </button>
                <button v-else
                        class="outline-none focus:outline-none border-0 text-green"
                        @click="deselect">
                    <icon-check-circle class="w-10 h-10 fill-current"></icon-check-circle>
                </button>
            </div>
            <div class="flex-1">
                <div class="px-6 pt-4">
                    <a class="font-bold text-lg hover:text-blue-dark cursor-pointer"
                       @click="detail = !detail">
                        {{ value.title }}
                    </a>

                    <div class="flex mt-1">
                        <p class="text-sm text-grey-dark flex items-center mr-4">
                            <icon-calendar class="fill-current text-grey w-4 h-4 mr-2 -mt-px"></icon-calendar>
                            <span>{{ value.date }}</span>
                        </p>
                        <p class="text-sm text-grey-dark flex items-center">
                            <icon-building class="fill-current text-grey w-4 h-4 mr-2 -mt-px"></icon-building>
                            <span>{{ value.sender }}</span>
                        </p>
                    </div>
                </div>
                <div class="px-6 py-4">
                       <!--:class="{ 'bg-blue text-white': selectedTags.filter(t => t.id === tag.id).length > 0 }"-->
                    <a class="inline-block bg-grey-lighter rounded-full px-3 py-1 text-sm font-semibold text-grey-darker mr-2 mb-2 cursor-pointer"
                       v-for="(tag, index) in value.tags"
                       :key="index">
                        {{ tag.name }}
                    </a>
                </div>
            </div>
            <div class="flex px-6 items-center">
                <a :href="route('media.show', { id: value.id, download: true })"
                   class="w-6 h-6 text-grey hover:text-blue-dark">
                    <icon-download class="w-6 h-6 fill-current"></icon-download>
                </a>
            </div>
        </div>
    </div>
</template>

<script>
    import IconCalendar from '../../svg/icon-calander.svg';
    import IconBuilding from '../../svg/icon-building.svg';
    import IconPlusCircle from '../../svg/icon-plus-circle.svg';
    import IconCheckCircle from '../../svg/icon-check-circle.svg';
    import IconDownload from '../../svg/icon-download.svg';
    import FileListDetail from "./FileListDetail";

    export default {
        props: ['value'],

        components: {
            FileListDetail,
            IconCalendar,
            IconBuilding,
            IconPlusCircle,
            IconCheckCircle,
            IconDownload,
        },

        data() {
            return {
                detail: false,
                item: this.value,
            };
        },

        methods: {
            select() {
                this.$set(this.item, "selected", true);
                this.$emit('input', this.item);
            },

            deselect() {
                this.$set(this.item, "selected", false);
                this.$emit('input', this.item);
            },
        }
    };
</script>