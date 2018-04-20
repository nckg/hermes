import axios from 'axios';

export default {
    props: ["tags"],

    data() {
        return {
            selectedItems: [],
            selectedTags: [],
        };
    },

    watch: {
        selectedTags() {
            this.$refs.table.refresh();
        },
    },

    methods: {
        destroy() {
            axios({
                method: 'delete',
                url: this.route('api::documents.destroy'),
                data: {id: this.selectedItems},
            })
                .then(() => {
                    this.$refs.table.refresh();
                    this.selectedItems = [];
                })
                .catch(() => {});
        },

        exportDocuments() {
            const form = document.createElement("form");
            form.setAttribute("method", "post");
            form.setAttribute("action", this.route('api::export.store'));

            this.selectedItems.forEach((id) => {
                const hiddenField = document.createElement("input");
                hiddenField.setAttribute("type", "hidden");
                hiddenField.setAttribute("name", "id[]");
                hiddenField.setAttribute("value", id);
                form.appendChild(hiddenField);
            });

            document.body.appendChild(form);

            form.submit();
        },

        async fetchData({ filter }) {
            const tag = this.selectedTags.map(tag => tag.name.en);
            const response = await axios.get(this.route('api::documents.index', { filter, tag }));

            // An object that has a `data` and an optional `pagination` property
            return response;
        },
    },
}