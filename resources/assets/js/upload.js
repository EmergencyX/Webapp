import Vue from 'vue';
import ModUploader from './components/mod-uploader';

Vue.config.devtools = true;

const vm = new Vue(ModUploader);
vm.$mount('#moduploader');