<template>
    <div>
        {{ value.name }}
    </div>
</template>

<script>
    export default {
        props: ['value', 'checked'],
    };
</script>