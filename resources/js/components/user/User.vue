<template>
    <div>
        <div class="class-position">Lista de Usuarios</div>
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
                <v-btn @click="openModal" class="primary">Agregar Usuario</v-btn>
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
        <AddEditUSer :show="showModal" @close="closeModal" @saveForm="saveForm" @changeProp="changeProp"  :formUser="formUser"  :typeAction="typeAction"/>
    </div>
</template>

<script>
import AddEditUSer from './addEditUser';
import alerts from '../helpers/alerts';
export default {
    components:{
        AddEditUSer,
    },
    props: ['data'],
    data(){
        return {
            headers: [
            {
                text: 'ID',
                align: 'start',
                sortable: false,
                value: 'id',
            },
            { text: 'Rol', value: 'role_name',sortable: false, },
            { text: 'Nombres', value: 'name',sortable: false, },
            { text: 'Email', value: 'email',sortable: false, },
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
            formUser: {
                email: '',
                id: '',
                name: '',
                password: '',
                role_id: "null",
            },
            typeModal: '',
            itemDel: {}
        }
    },
    methods: {
        deleteEnterprise(id) {
            axios.delete('/users/'+id)
            .then(response => {
                this.allData()
            })
            .catch(error => {
                console.log('error', error)
            })
        },
        openDelete(item){
            swal({
                title: "¿Eliminar Usuario?",
                text: "¡Se Eliminara de forma permanente!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    this.deleteEnterprise(item.id)
                }
            });
        },
        validateResponse(value){
            let r = value
            if(!r.password){
                r.password = ''
            }
            if(!r.role_id){
                r.role_id = this.formUser.role_id
            }
            return r
        },
        editItem(item){
            this.typeAction = 'Editar'
            this.formUser = this.validateResponse(item)
            this.showModal = true
        },
        changeProp(index, value){
            this.formUser[index] = value
        },
        editUser() {
            axios.post('/users/update', this.formUser)
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
            axios.post('/users/create', this.formUser)
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
                 this.saveUser(this.formUser)
            }else{
                this.editUser(this.formUser)
            }
            
        },
        allData() {
            this.loadingData = true
            let json = {
                    page: this.page,
                    name: this.search
                }
            axios.post('/users/search?page='+this.page, json)
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
            this.formUser = {
                email: '',
                id: '',
                name: '',
                password: '',
                role_id: "",
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