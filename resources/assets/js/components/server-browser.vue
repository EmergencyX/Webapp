<template>
    <table class="table table-striped">
        <thead>
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

                {{ session.name }}
            </td>
            <td>{{ session.players }}</td>
            <td>{{ session.mod }}</td>
            <td>{{ session.nation }}</td>
            <td>{{ session.numpl }} / {{ session.maxpl }}</td>
        </tr>
        </tbody>
    </table>
</template>

<script>
    //Oben ist HTML mit Vuejs gemischt:
    //Das erlaubt es uns einfach hier "sessions" zu ändern und wir müssen
    //uns keine Gedanken machen, wie das im HTML umgesetzt wird

    //vm = ViewModel, Logik hinter dem "View" (oben) zusammenfassen
    let vm = {
        data() {
            return {
                sessions: []
            }
        }
    };

    //"Default" Instanz exportieren. Wird dann bei "Import" in app.js verwendet
    //Suche "ES6 Import"
    export default vm;
</script>