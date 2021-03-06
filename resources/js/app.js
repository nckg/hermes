
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
import FileList from './components/FileList.vue';
import FileListDetail from './components/FileListDetail.vue';
import Search from './components/Search.vue';
import Hub from './lib/Hub';

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.mixin({
    methods: {
        route: route, // eslint-disable-line
    },
});

Vue.component('file-list', FileList);
Vue.component('file-list-detail', FileListDetail);
Vue.component('search', Search);

Vue.component('tags-input', {
    props: ['value'],
    data() {
        return {
            newTag: '',
        };
    },
    methods: {
        addTag() {
            if (this.newTag.trim().length === 0 || this.value.includes(this.newTag.trim())) {
                return;
            }
            this.$emit('input', [...this.value, this.newTag.trim()]);
            this.newTag = '';
            console.log(this.value);
        },
        removeTag(tag) {
            this.$emit('input', this.value.filter(t => t !== tag))
        },
    },

    render() {
        return this.$scopedSlots.default({
            tags: this.value,
            addTag: this.addTag,
            removeTag: this.removeTag,
            inputAttrs: {
                value: this.newTag,
            },
            inputEvents: {
                input: (e) => { this.newTag = e.target.value },
                keydown: (e) => {
                    if (e.keyCode === 13) {
                        e.preventDefault();
                        this.addTag();
                    }
                },
            },
        });
    },
});


const app = new Vue({
    el: '#app',

    data() {
        return {
            file: null,
        };
    },

    created() {
        Hub.$on('hermes:detail', (value) => {
            this.file = value;
        });
    }
});
