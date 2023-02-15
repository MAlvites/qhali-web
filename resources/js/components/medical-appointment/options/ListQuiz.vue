<template>
    <div>
        <v-row justify="center" v-if="show">
            <v-app>
                <v-dialog
                    v-model="show"
                    persistent
                    :max-width="maxWidth">
                    <v-card v-if="!viewQuiz">
                        <v-card-title class="text-h5 lighten-2">
                            <v-row>
                                <v-col
                                    cols="12"
                                    sm="11"
                                >
                                    Lista de encuestas
                                </v-col>
                                <v-col
                                    cols="12"
                                    sm="1"
                                >
                                    <v-btn
                                        icon
                                        dark
                                        @click="close"
                                    >
                                        <v-icon class="red">mdi-close</v-icon>
                                    </v-btn>
                                </v-col>
                            </v-row>
                        </v-card-title>

                        <v-card-text>

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
                                    <template v-slot:[`item.action`]="{ item }">
                                        <v-btn class="primary" @click="showQuiz(item)">Ver</v-btn>
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
                        </v-card-text>
                    </v-card>
                    <ResolveQuiz v-else :disabled="true" :idQuizView="idQuiz" :data="data"  @close="closeModalViewQuiz()"></ResolveQuiz>
                </v-dialog>
            </v-app>
        </v-row>
    </div>
</template>

<script>
import alerts from '../../helpers/alerts';
import ResolveQuiz from './ResolveQuiz.vue';
export default {
    props: ['data', 'show'],
    components:{ResolveQuiz},
    data(){
      return {
            search: '',
            headers: [
            {
                text: 'ID',
                align: 'start',
                sortable: false,
                value: 'id',
            },
            { text: 'Encuesta', value: 'quiz_name', sortable: false },
            { text: 'Reponsable', value: 'who_resolved', sortable: false },
            { text: 'Puntaje', value: 'score', sortable: false },
            { text: 'Fecha', value: 'date', sortable: false },
            { text: 'Acciones', value: 'action', sortable: false }
            ],
            desserts: [],
            loadingData: true,
            itemsPerPage: 15,
            page: 1,
            pageCount: 0,
            showQuizComponent: false,
            item: null,
            idQuiz:'',
            viewQuiz:false
      }
    },
    methods: {
        closeModalViewQuiz(){
            this.$emit('close')
        },
        hideQuiz() {
            this.showQuizComponent = false
        },
        showQuiz(data) {
            this.idQuiz = data.id
            this.viewQuiz = true
        },
        allData() {
            this.loadingData = true
            let json = {
                    page: this.page,
                    name: this.search,
                    patient_id: this.data.patient.id
                }
            axios.post('/patient-quizzes/search?page='+this.page, json)
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
        close() {
            this.$emit('close')
        }
    },
    created() {
        this.allData()
    },
    computed: {
        maxWidth(){
            switch (this.$vuetify.breakpoint.name) {
                case 'xs': return 480
                case 'sm': return 520
                case 'md': return 800
                case 'lg': return 1000
                case 'xl': return 1200
            }
        },
    }
}
</script>