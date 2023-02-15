<template>
    <div>
        <div class="class-position">Busqueda de pacientes</div>
        <v-card
            max-width="1000"
            class="mx-auto my-12 rounded-xl"
            style="border: 4px solid #042354"
        >
            <v-card-title>
                <v-text-field
                    v-model="search"
                    append-icon="mdi-magnify"
                    label="Search"
                    single-line
                    hide-details
                    @keyup="allData"
                ></v-text-field>
            </v-card-title>
            <v-data-table
                class="table-patients"
                :headers="headers"
                :items="desserts"
                :loading="loadingData"
                :items-per-page="itemsPerPage"
                loading-text="Cargando"
                hide-default-footer
            >
                <template v-slot:[`item.uri`]="{ item }">
                    <v-btn class="primary" v-if="item.uri" @click="openHistory(item.uri)">Abrir historia</v-btn>
                </template>
                <template v-slot:[`item.editar`]="{ item }">
                    <v-btn class="primary" @click="editUser(item.id)">Editar</v-btn>
                </template>
            </v-data-table>
            <v-pagination
                total-visible="10"
                v-model="page"
                :length="pageCount"
                @next="allData"
                @previous="allData"
                @input="allData"
            ></v-pagination>
        </v-card>
    </div>
</template>

<script>
import alerts from '.././helpers/alerts';
export default {
    data () {
      return {
        search: '',
        headers: [
          {
            text: 'ID',
            align: 'start',
            sortable: false,
            value: 'id',
          },
          { text: 'Paciente', value: 'full_name',sortable: false, },
          { text: 'Historia Médica', value: 'uri', sortable: false },
          { text: 'Acciones', value: 'editar', sortable: false },
        ],
        desserts: [],
        loadingData: true,
        itemsPerPage: 15,
        page: 1,
        pageCount: 0
      }
    },

    methods: {
        editUser (id) {
            location.href = '/patients/edit/'+id;
        },
        openHistory(uri){
            window.open(uri,' _blank');
        },
        allData() {
            this.loadingData = true
            let json = {
                    page: this.page,
                    name: this.search
                }
            axios.post('/patients/search?page='+this.page, json)
            .then(response => {
                this.desserts = response.data.data.data
                this.page = response.data.data.current_page
                this.pageCount = response.data.data.last_page
                this.loadingData = false
            })
            .catch(error => {
                alerts.alertSwal(error.response.data.message, 'error')
            })
        },
    },

    created() {
        this.allData()
    }
}
</script>