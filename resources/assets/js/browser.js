import Vue from 'vue'; //Framework für "Databinding" - am besten in server-browser.vue gucken
import 'centrifuge'; //Centrifugo Client - das ist ein Echtzeitserver, der die Updates verteilt
import ServerBrowser from './components/server-browser.vue'; //Der eigentliche Serverbrowser
import axios from "axios";

//Erweiterung "Vue Debugger" in Chrome, immer ganz hilfreich
Vue.config.devtools = true;

//Neue Vue Instanz erstellen, Component deklarieren
//window.data wird im entsprechenden View definiert (resources/views/multiplayer/browser.blade.php)
const vm = new Vue(ServerBrowser);
vm.$mount('#serverbrowser');

//Initiale Daten vom Server abholen
//Todo: Hier sollte lieber Centrifugo's "History" verwendet werden
axios.get("http://venus.emergencyx.de:8080")
    .then((response) => {
        vm.sessions = response.data
    })
    .catch(console.log);


//Verbindung zu Centrifugo aufnehmen, Updates abwarten (subscribe)
const centrifuge = new Centrifuge(window.centrifugo);
centrifuge.subscribe("masterserver_em4", function (message) {
    vm.sessions = message.data.sessions;
});
centrifuge.connect();