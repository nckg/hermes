<template>
    <input
        class="bg-white rounded flex flex-1 py-4 pl-12 text-grey-darker"
        placeholder="Search..."
        type="text"
        @input="updateValue" />
</template>

<script>
    import Hub from '../lib/Hub';

    export default {
        methods: {
            updateValue(event) {
                Hub.$emit("hermes:searching", event.target.value)
            },
        }
    };
</script>