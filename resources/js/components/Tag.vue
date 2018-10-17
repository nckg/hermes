<template>
    <div
        class="inline-block bg-grey-8 rounded-full px-3 py-1 text-sm font-semibold text-grey-2 mr-2 mb-2 cursor-pointer hover:bg-indigo-9 hover:text-indigo-3">
        {{ value.name }}
    </div>
</template>

<script>
    export default {
        props: ['value', 'checked'],
    };
</script>