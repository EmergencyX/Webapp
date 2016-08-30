<template>
    <table>
        <thead>
        <tr>
            <th>Servername</th>
            <th>Spieler</th>
            <th>Mod</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="server in serverList">
            <td>{{ server.name }}</td>
            <td>{{ server.players }}</td>
            <td>{{ server.mod }}</td>
        </tr>
        </tbody>
    </table>
</template>

<script>
export default {
    props: ['servers'],
    computed: {
        serverList() {
            return this.servers;
        }
    }
}
</script>