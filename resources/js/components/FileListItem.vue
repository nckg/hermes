<template>
    <div class="flex rounded w-full overflow-hidden shadow bg-white">
        <div class="w-48 h-full bg-brand-darkest flex-none relative">
            <img :src="imageSrc" class="block w-48 h-full object-contain" />
        </div>
        <div class="flex flex-col flex-1 px-6 py-4">
            <a class="font-bold mb-2 hover:text-indigo-1 cursor-pointer"
               @click="$emit('select', value)">
                {{ value.title }}
            </a>
            <div class="flex justify-between text-grey-dark text-sm items-center mb-4">
                <div class="flex items-center">
                    <icon-building class="fill-current w-4 h-6 mr-1"></icon-building> {{ value.sender }}
                </div>
                <div class="flex items-center">
                    <icon-calendar class="fill-current w-4 h-6 mr-1"></icon-calendar> {{ value.date }}
                </div>
            </div>
            <div>
                <button
                    class="inline-block bg-grey-lighter rounded-full px-3 py-1 text-sm text-grey-darker mr-2 mb-2 cursor-pointer hover:bg-indigo-9 hover:text-indigo-3"
                    v-for="(tag, index) in value.tags"
                    :key="index">
                    {{ tag.name }}
                </button>
            </div>
            <div class="flex mt-auto justify-between">
                <button
                    v-if="!item.selected"
                    class="outline-none focus:outline-none border-0 text-grey hover:text-brand"
                    @click="select">
                    <icon-check-circle class="w-6 h-6 fill-current"></icon-check-circle>
                </button>
                <button
                    v-else
                    class="outline-none focus:outline-none border-0 text-brand"
                    @click="deselect">
                    <icon-check-circle class="w-6 h-6 fill-current"></icon-check-circle>
                </button>
                <a
                    :href="route('media.show', { id: value.id, download: true })"
                    class="w-6 h-6 text-grey hover:text-brand-dark">
                    <icon-download class="w-6 h-6 fill-current"></icon-download>
                </a>
            </div>
        </div>
    </div>

    <!--<div-->
        <!--class="flex rounded overflow-hidden shadow-md bg-white mb-6 border-2 border-white"-->
        <!--:class="{ 'border-primary': item.selected }">-->
        <!--<div class="flex pl-6 items-center">-->

        <!--</div>-->
        <!--<div class="flex-1">-->
            <!--<div class="px-6 pt-4">-->


                <!--<div class="flex mt-1">-->

                <!--</div>-->
            <!--</div>-->
            <!--<div class="px-6 py-4">-->
            <!--</div>-->
        <!--</div>-->
        <!--<div class="flex px-6 items-center">-->

        <!--</div>-->
    <!--</div>-->
</template>

<script>
    import IconCalendar from '../../svg/icon-calander.svg';
    import IconBuilding from '../../svg/icon-building.svg';
    import IconPlusCircle from '../../svg/icon-plus-circle.svg';
    import IconCheckCircle from '../../svg/icon-check-circle.svg';
    import IconDownload from '../../svg/icon-download.svg';
    import Tag from './Tag';

    export default {
        props: ['value'],

        components: {
            IconCalendar,
            IconBuilding,
            IconPlusCircle,
            IconCheckCircle,
            IconDownload,
            Tag,
        },

        data() {
            return {
                item: this.value,
            };
        },

        computed: {
            imageSrc() {
                return `/storage/${this.item.uid}.jpg`;
            },
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