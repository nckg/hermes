<template>
    <div>
        <empty-image class="max-w-md"></empty-image>
        <p class="text-2xl mt-4 text-grey-dark">No files found</p>
    </div>
</template>

<script>
    import EmptyImage from '../../svg/document-illustration.svg';

    export default {
        components: {
            EmptyImage
        },
    };
</script>