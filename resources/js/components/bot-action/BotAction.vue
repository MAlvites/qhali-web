<template>
    <div>
        <div class="class-position">Acciones del Robot</div>
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
                <v-spacer></v-spacer>
                <v-btn @click="openModal" class="primary">Agregar Acción</v-btn>
            </v-card-title>
            <v-data-table
                class="table-pacientes"
                :headers="headers"
                :items="desserts"
                :loading="loadingData"
                :items-per-page="itemsPerPage"
                loading-text="Cargando"
                hide-default-footer
            >
                <template v-slot:[`item.img`]="{ item }">
                    <v-img :src="item.img" :alt="item.name" height="100px" width="100px"></v-img>
                </template>
                <template v-slot:[`item.actions`]="{ item }">
                    <v-icon
                        small
                        class="mr-2"
                        @click="editItem(item)"
                    >
                        mdi-pencil
                    </v-icon>
                    <v-icon
                        small
                        @click="openDelete(item)"
                    >
                        mdi-delete
                    </v-icon>
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
        <addEditRobot v-if="showModal" :show="showModal" @close="closeModal" @saveForm="saveForm" @changeProp="changeProp"  :formRobot="formRobot"  :typeAction="typeAction"/>
    </div>
</template>

<script>
import addEditRobot from './addEditRobot';
import alerts from '../helpers/alerts';
export default {
    components:{
        addEditRobot,
    },
    props: ['data'],
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
            { text: 'Nombres', value: 'name',sortable: false, },
            { text: 'URL', value: 'url',sortable: false, },
            { text: 'Icono', value: 'img',sortable: false, },
            { text: 'Acciones', value: 'actions', sortable: false },
            ],
            desserts: [],
            loadingData: true,
            itemsPerPage: 15,
            page: 1,
            pageCount: 0,
            showModal: false,
            showConfirmacion: false,
            typeAction: '',
            formRobot: {
                id: '',
                name: '',
                url: '',
                img: {},
            },
            typeModal: '',
            itemDel: {}
        }
    },
    methods: {
        deleteBotAction(id) {
            axios.delete('/bot-actions/'+id)
            .then(response => {
                this.allData()
            })
            .catch(error => {
                console.log('error', error)
            })
        },
        openDelete(item){
            swal({
                title: "¿Eliminar Acción?",
                text: "¡Se Eliminara de forma permanente!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    this.deleteBotAction(item.id)
                }
            });
        },
       
        editItem(item){
            this.typeAction = 'Editar'
            this.formRobot = item
            this.showModal = true
        },
        changeProp(index, value){
            this.formRobot[index] = value
        },
        editUser() {
            axios.post('/bot-actions/update', this.formRobot)
            .then(response => {
                this.allData()
                alerts.alertSwal(response.data.message, 'success')
                this.showModal = false
            })
            .catch(error => {
                alerts.alertSwal(error.response.data.message, 'error')
            })
        },
        saveUser() {
            axios.post('/bot-actions/create', this.formRobot)
            .then(response => {
                this.allData()
                alerts.alertSwal(response.data.message, 'success')
                this.showModal = false
            })
            .catch(error => {
                alerts.alertSwal(error.response.data.message, 'error')
            })
        },
        saveForm(type) {
           if(type == 1){
                 this.saveUser(this.formRobot)
            }else{
                this.editUser(this.formRobot)
            }
            
        },
        allData() {
            this.loadingData = true
            let json = {
                    page: this.page,
                    name: this.search
                }
            axios.post('/bot-actions/search?page='+this.page, json)
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
        openModal(){
            this.typeAction = 'Agregar'
            this.formRobot = {
                id: '',
                name: '',
                url: '',
                img: '',
            }
            this.showModal = true
        },
        closeModal(){
            this.showModal = false
            this.allData()
        },
    },
    created() {
        this.allData()
    }
}
</script>