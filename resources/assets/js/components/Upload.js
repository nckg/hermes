import axios from 'axios';

export default {
    data() {
        return {
            isWorking: false,
            input: null,
        };
    },

    methods: {
        select() {
            document.getElementById('hermes-upload').click();
        },

        onFileInputChange(event) {
            const { target: { files: selectedFiles } } = event;

            if (selectedFiles.length === 0) {
                return;
            }

            this.isWorking = true;

            const fileUploadFormData = new FormData();
            for (let i = 0; i < selectedFiles.length; i++) {
                fileUploadFormData.append('file[]', selectedFiles[i]);
            }

            axios({
                method: 'post',
                url: this.route('documents.store'),
                data: fileUploadFormData,
            }).then(() => {
                this.isWorking = false;
            });

            document.getElementById('hermes-upload').value = null;
        }
    },

    created() {
        const input = document.createElement('input');

        input.type = 'file';
        input.id = 'hermes-upload';
        input.style.display = 'none';
        input.onchange = this.onFileInputChange;
        input.multiple = true;

        document.body.appendChild(input);
    }
};