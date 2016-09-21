import Vue from 'vue'; //Framework für "Databinding" - am besten in server-browser.vue gucken
import Centrifuge from 'centrifuge'; //Centrifugo Client - das ist ein Echtzeitserver, der die Updates verteilt
import ServerBrowser from './components/server-browser.vue'; //Der eigentliche Serverbrowser

//Erweiterung "Vue Debugger" in Chrome, immer ganz hilfreich
Vue.config.devtools = true;

//Neue Vue Instanz erstellen, Component deklarieren
//window.data wird im entsprechenden View definiert (resources/views/multiplayer/browser.blade.php)
let vm = new Vue(
    {
        el: 'body',
        components: {
            ServerBrowser
        },
        data: window.data || {}
    }
);

//Initiale Daten vom Server abholen
//Todo: Hier sollte lieber Centrifugo's "History" verwendet werden
var request = new XMLHttpRequest();
request.open("GET", "http://fms.emergencyx.de:8080");
request.addEventListener('load', function(event) {
    if (request.status >= 200 && request.status < 300) {
        let sessions = JSON.parse(request.responseText);
        //Event in Vue auslösen und neue Daten verteilen
        vm.$broadcast('masterserver_em4', sessions);
    } else {
        console.warn(request.statusText, request.responseText);
    }
});
request.send();


//Verbindung zu Centrifugo aufnehmen, Updates abwarten (subscribe)
let centrifuge = new Centrifuge(window.data.centrifugo);
centrifuge.subscribe("masterserver_em4", function(message) {
    vm.$broadcast('masterserver_em4', message.data.sessions);
});
centrifuge.connect();



//Fu