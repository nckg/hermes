<template>
    <div>
        <button class="absolute pin-r pin-t mr-4 mt-4 text-grey text-2xl"
                @click="$emit('close')">&times;</button>

        <div class="w-3/4 flex flex-1">
            <div class="flex w-full items-center justify-center py-12"
                 v-if="loading">
                <icon-refresh class="spin fill-current text-grey-dark"></icon-refresh>
            </div>

            <iframe :src="route('media.show', { id: value.id })"
                    ref="iframe"
                    @load="loading = false"
                    class="w-full flex-1"></iframe>
        </div>
        <div class="w-1/4 py-6 px-4">
            <p class="font-bold text-lg">{{ value.title }}</p>

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
    </div>
</template>

<script>
    import IconRefresh from '../../svg/icon-refresh.svg';
    import IconCalendar from '../../svg/icon-calander.svg';
    import IconBuilding from '../../svg/icon-building.svg';

    export default {

        props: ['value'],

        components: { IconRefresh, IconCalendar, IconBuilding },

        data() {
            return {
                loading: true,
            };
        },
    };
</script>