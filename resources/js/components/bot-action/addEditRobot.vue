<template>
    <div>
        <v-row justify="center">
            <v-app>
                <v-dialog
                v-model="show"
                v-if="show"
                persistent
                :max-width="maxWidth">
                    <v-card class="bg-green-secondary modal-register p-4 " :style="{ 'height' : maxHeight }">
                        <div class="container-close-icon">
                            <img class="cursor-pointer" src="/img/svg/close_black.svg" @click="close()">
                        </div>
                        <v-card-text>
                            <p class="mb-5 text-h4" >{{`${typeAction} robot`}}</p>
                        </v-card-text>
                        <v-form ref="formAdd" v-model="validateForm">
                            <v-row>
                                <v-col cols="12">
                                    <v-text-field
                                        v-model="nameRobot"
                                        :rules="rules.name"
                                        label="Nombre"
                                        outlined
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="12">
                                    <v-text-field
                                        v-model="url"
                                        :rules="rules.url"
                                        label="Url"
                                        outlined
                                    ></v-text-field>
                                </v-col>
                                <v-col>
                                    <v-file-input
                                        v-model="file"
                                        type="file"
                                        show-size
                                        counter
                                        accept="image/*"
                                        @change="onFileChange"
                                        label="Cargar imagen"
                                    ></v-file-input>
                                </v-col>
                                <v-col cols="12" v-if="viewPreview">
                                    <img :src="`${imgEdit}`" alt="" width="100">
                                </v-col>
                                <v-col cols="12" v-else>
                                    <img :src="imgEdit" alt="" width="100">
                                </v-col>
                                <v-col cols="12">
                                    <v-radio-group
                                        class="mt-0 rd-add"
                                        v-model="type"
                                        :rules="rules.type"
                                        row
                                    >
                                        <v-radio
                                            label="Accion"
                                            value="action"
                                        ></v-radio>
                                        <v-radio
                                            label="Movimiento"
                                            value="move"
                                        ></v-radio>
                                    </v-radio-group>
                                </v-col>
                            </v-row>
                        </v-form>
                        <v-card-actions>
                            <v-btn
                                rounded
                                color="primary"
                                dark
                                class="mr-5 px-5"
                                v-if="validateForm"
                                @click="saveForm"
                                >
                                    {{typeAction}}
                            </v-btn>
                            <v-btn
                                rounded
                                color="primary"
                                dark
                                class="mr-5 px-5"
                                v-else
                                >
                                    {{typeAction}}
                            </v-btn>
                            <v-btn
                                rounded
                                color="secondary"
                                dark
                                class="mr-5 px-5"
                                @click="close"
                                >
                                    Cancelar
                            </v-btn>
                        </v-card-actions>
                    </v-card>
                </v-dialog>
            </v-app>
        </v-row>
    </div>
</template>

<script>
import alerts from '../helpers/alerts';
export default {
    props:{
        typeAction:{
            type: String
        },
        show: {
            type: Boolean,
            default: false
        },
        formRobot:{

        }
    },
    data(){
        return{
            validateForm: false,
            show1:false,
            rules: {
                name: [
                    value => !!value || 'No puede estar vacío.'
                ],
                url: [
                    value => !!value || 'No puede estar vacío.'
                ],
                type: [
                    value => !!value || 'No puede estar vacío.'
                ]
            },
            type: '',
            file: null,
            nameRobot: '',
            url: '',
            id: '',
            imgEdit: '',
            viewPreview: false
        }
    },
    computed: {
        maxWidth(){
            switch (this.$vuetify.breakpoint.name) {
                case 'xs': return 280
                case 'sm': return 280
                case 'md': return 420
                case 'lg': return 420
                case 'xl': return 420
            }
        },
        maxHeight(){
            switch (this.$vuetify.breakpoint.name) {
                case 'xs': return "322px"
                case 'sm': return "322px"
                case 'md': return "740px"
                case 'lg': return "740px"
                case 'xl': return "740px"
            }
        },
    },
    methods:{
        editRobot(formData) {
            axios.post('/bot-actions/update', formData)
            .then(response => {
                alerts.alertSwal(response.data.message, 'success')
                this.$emit('close')
            })
            .catch(error => {
                alerts.alertSwal(error.response.data.message, 'error')
            })
        },
        saveRobot(formData) {
            axios.post('/bot-actions/create', formData)
            .then(response => {
                alerts.alertSwal(response.data.message, 'success')
                this.$emit('close')
            })
            .catch(error => {
                alerts.alertSwal(error.response.data.message, 'error')
            })
        },
        saveForm(){
            let formData = new FormData()
            formData.append('img',this.file)
            formData.append('name',this.nameRobot)
            formData.append('url',this.url)
            formData.append('type',this.type)

            if(this.id !== ''){
                formData.append('id',this.id)
            }

            let res
            if(this.id !== ''){
                this.editRobot(formData)
            }else{
                this.saveRobot(formData)
            }
        },
        close(){
            this.$emit('close')
        },
        onFileChange(file){
            if(!file){
                return;
            }
            this.createImage(file)
        },
        createImage(file) {
            this.viewPreview = false
            const reader = new FileReader();

            reader.onload = e => {
                this.imgEdit = e.target.result;
            };
            reader.readAsDataURL(file);
        },
    },
    mounted () {
        if(this.formRobot.id !== ''){
            this.nameRobot = this.formRobot.name
            this.url = this.formRobot.url
            this.imgEdit = this.formRobot.img
            this.id = this.formRobot.id
            this.type = this.formRobot.type
            this.viewPreview = true
        }
    }
}
</script>

<style lang="scss">
    .modal-register{
        border-radius: 20px !important;
        .container-close-icon{
            display: flex;
            justify-content: flex-end;
            margin-top: 17px;
            padding: 0 15px;
            img{
                cursor: pointer;
            }
        }
        .container-central-icon{
            display: flex;
            justify-content: center;
            margin-bottom: 40px;
            padding: 0 24px;
            .central-icon{
                width: 80px;
            }
        }
        .container-title-custom{
            display: flex;
            justify-content: center;
            margin-bottom: 16px;
            .title-custom{
                font-size: 24px;
                font-weight: 600;
                color: #000000;
            }
        }
        .container-message{
            display: flex;
            justify-content: center;
            margin-bottom:25px;
            .sub-container-message{
                max-width: 340px;
                .message{
                    font-size: 16px;
                    margin: 0;
                    color: #000000;
                    text-align: center;
                    font-weight: 500;
                }
            }
        }

        .rd-add{
            label{
                margin-bottom: 0;
            }
        }
    }
    @media (max-width: 959px) {
        .modal-register{
            .container-close-icon{
                margin-top: 0;
                padding: 0;
            }
            .container-central-icon{
                margin-bottom: 10px;
                padding: 0;
                .central-icon{
                    width: 44px;
                }
            }
            .container-title-custom{
                margin-bottom: 16px;
                .title-custom{
                    line-height: 1.3;
                    font-size: 18px;
                }
            }
            .container-message{
                margin-bottom: 16px;
                .sub-container-message{
                    max-width: 220px;
                    .message{
                        line-height: 1.3;
                        font-size: 14px;
                        font-weight: 400;
                    }
                }
            }
        }
    }
</style>