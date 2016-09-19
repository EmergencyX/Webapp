<template>
    <table class="table table-striped">
    <thead class="thead-inverse">
        <tr>
            <th>Servername</th>
            <th>Spieler</th>
            <th>Mod</th>
            <th>Land</th>
            <th>Plätze</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="session in sessions">
            <td>
                <i v-show="session.password" class="fa fa-lock" aria-hidden="true"></i>
                <i v-show="session.started" class="fa fa-play" aria-hidden="true"></i>

                {{ session.name }}</td>
            <td>{{ session.players }}</td>
            <td>{{ session.mod }}</td>
            <td>{{ session.nation }}</td>
            <td>{{ session.numpl }} / {{ session.maxpl }}</td>
        </tr>
        </tbody>
    </table>
</template>

<script>

let vm = {
    data() {
        return {
            sessions: []
        }
    },
    computed: {
        serverList() {
            return this.sessions;
        }
    },
    events: {
        masterserver_em4(sessions) {
            this.sessions = sessions;
        }
    }
};

export default vm;
</script>