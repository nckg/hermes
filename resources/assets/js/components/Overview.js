import axios from 'axios';
import { findIndex } from 'lodash';

export default {
    props: ["tags"],

    data() {
        return {
            selectedItems: [],
            selectedTags: [],
            isWorking: false,
        };
    },

    watch: {
        selectedTags() {
            this.$refs.table.refresh();
        },
    },

    methods: {
        toggleTag(tag) {
            const index = findIndex(this.selectedTags, { id: tag.id });

            if (index > -1) {
                this.selectedTags.splice(index, 1);
            } else {
                this.selectedTags.push(tag);
            }
        },

        destroy() {
            this.isWorking = true;

            axios({
                method: 'delete',
                url: this.route('api::documents.destroy'),
                data: {id: this.selectedItems},
            })
                .then(() => {
                    this.$refs.table.refresh();
                    this.selectedItems = [];
                })
                .catch(() => {})
                .finally(() => {
                    this.isWorking = false;
                });
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
            this.isWorking = true;

            const tag = this.selectedTags.map(tag => tag.name);
            const response = await axios.get(this.route('api::documents.index', { filter, tag }));

            this.isWorking = false;
            // An object that has a `data` and an optional `pagination` property
            return response;
        },
    },
}