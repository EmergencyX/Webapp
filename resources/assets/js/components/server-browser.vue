<template>
    <table class="table table-striped">
    <thead class="thead-inverse">
        <tr>
            <th>Servername</th>
            <th>Spieler</th>
            <th>Mod</th>
            <th>Plätze</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="server in serverList">
            <td>{{ server.name }}</td>
            <td>{{ server.players }}</td>
            <td>{{ server.mod }}</td>
            <td>{{ server.player_count }} / {{ server.max_player_count }}</td>
        </tr>
        </tbody>
    </table>
</template>

<script>
import Centrifuge from 'centrifuge';

let vm = {
    props: ['servers'],
    computed: {
        serverList() {
            return this.servers;
        }
    },
    methods: {
        update(message) {

        }
    }
};

let centrifuge = new Centrifuge(window.data.centrifugo);
/*let centrifuge = new Centrifuge({
    url: 'http://fms.emergencyx.de:8000/connection',
    user: "",
    timestamp: "1474233843",
    token: "85716be8538b30513fda43b76195a0a26c1a4a5beba523b0666128536ca6c68c"
});*/

centrifuge.subscribe("masterserver_em4", function(message) {
    console.log(message);
        //vm.update(message);
});
centrifuge.connect();


export default vm;
</script>