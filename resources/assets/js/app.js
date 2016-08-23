import Vue from 'vue';
import Client from 'centrifuge';
import ServerBrowser from './components/server-browser.vue';

let test = new Client();
console.log(test);
Vue.config.debug = true;

new Vue(
    {
        el: 'body',
        components: {
            ServerBrowser
        },
        data: {
            list:  [{name:"Test", players: "noBlubb", mod:"BFEMP"}]
        }
    }
);

//Fu