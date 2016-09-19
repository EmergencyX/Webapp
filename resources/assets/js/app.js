import Vue from 'vue';
import ServerBrowser from './components/server-browser.vue';

import Centrifuge from 'centrifuge';

Vue.config.devtools = true;

let vm = new Vue(
    {
        el: 'body',
        components: {
            ServerBrowser
        },
        data: window.data || {}
    }
);

var request = new XMLHttpRequest();

request.open("GET", "http://fms.emergencyx.de:8080");
request.addEventListener('load', function(event) {
    if (request.status >= 200 && request.status < 300) {
        let sessions = JSON.parse(request.responseText);
        vm.$broadcast('masterserver_em4', sessions);
    } else {
        console.warn(request.statusText, request.responseText);
    }
});
request.send();


let centrifuge = new Centrifuge(window.data.centrifugo);
centrifuge.subscribe("masterserver_em4", function(message) {
    vm.$broadcast('masterserver_em4', message.data.sessions);
});
centrifuge.connect();



//Fu