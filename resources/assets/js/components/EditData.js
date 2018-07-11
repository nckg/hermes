import axios from 'axios';

export default {
    props: ['value', 'url'],

    data() {
        return {
            input: this.value,
            editing: false,
        };
    },

    watch: {
        value(value) {
            this.input = value;
        },
        input(value) {
            return this.$emit('input', value);
        },
    },

    methods: {
        save(value) {
            axios.put(this.url, value)
                .then(() => {
                    this.editing = false;
                });
        },
    },

    render() {
        return this.$scopedSlots.default({
            input: this.input,
            inputAttrs: {
                value: this.input,
            },
            inputEvents: {
                input: (e) => { this.input = e.target.value },
            },
            editing: this.editing,
            toggleEditing: () => {
                this.editing = !this.editing;
            },
            save: this.save,
        });
    },
};