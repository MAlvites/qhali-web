<template>
    <div>
        <v-row justify="center">
        <v-app>
            <v-dialog
            v-model="show"
            persistent
            :max-width="maxWidth">
                <v-card class="bg-green-secondary modal-register p-4 " :style="{ 'height' : maxHeight }">
                    <div class="container-close-icon">
                        <img class="cursor-pointer" src="/img/svg/close_black.svg" @click="close()">
                    </div>
                    <v-card-text>
                        <p class="mb-5 text-h4" >{{`${typeAction} usuario`}}</p>
                    </v-card-text>
                    <v-form ref="formAdd" v-model="validForm">
                        <v-row>
                            <v-col cols="12">
                                <v-text-field
                                    v-model="nameUser"
                                    :rules="rules.name"
                                    label="Nombre"
                                    outlined
                                ></v-text-field>
                            </v-col>
                            <v-col cols="12">
                                <v-text-field
                                    outlined
                                    label="Email"
                                    v-model="email"
                                    :rules="rules.email"
                                ></v-text-field>
                            </v-col>
                            <v-col cols="12" v-if="typeAction === 'Agregar'">
                                <v-text-field
                                    v-model="password"
                                    :append-icon="show1 ? 'mdi-eye' : 'mdi-eye-off'"
                                    :rules="rules.password"
                                    :type="show1 ? 'text' : 'password'"
                                    label="Contraseña"
                                    name="input-10-1"
                                    outlined
                                    @click:append="show1 = !show1"
                                ></v-text-field>
                            </v-col>
                            <v-col cols="12">
                                <v-radio-group
                                    class="mt-0 rd-add"
                                    v-model="role_id"
                                    :rules="rules.role_id"
                                    row
                                >
                                    <v-radio
                                        label="Admin"
                                        value="1"
                                    ></v-radio>
                                    <v-radio
                                        label="User"
                                        value="2"
                                    ></v-radio>
                                    <v-radio
                                        label="Robot"
                                        value="3"
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
                            v-if="validForm"
                            @click="savePacie"
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
import helperValidation from '.././helpers/validations';
export default {
    props:{
        typeAction:{
            type: String
        },
        show: {
            type: Boolean,
            default: false
        },
        formUser: {
            type: Object
        }
    },
    data(){
        return{
            validForm: false,
            show1:false,
            rules: {
                name: [
                    value => !!value || 'No puede estar vacío.'
                ],
                email: [
                    value => !!value || 'No puede estar vacío.',
                    value =>  helperValidation.isEmailValid(value) || 'No es un email válido.'
                ],
                password: [
                    value => !!value || "No puede estar vacío.",
                    value => value.length > 8 || "Minimo 8 caracteres"
                ],
                role_id: [
                    value => !!value || 'No puede estar vacío.'
                ]
            },
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
                case 'md': return "620px"
                case 'lg': return "620px"
                case 'xl': return "620px"
            }
        },
        nameUser:{  
            get: function(){
                return this.formUser.name
            },
            set: function(value){
                this.$emit('changeProp', 'name', value)
            }
        },
        email:{  
            get: function(){
                return this.formUser.email
            },
            set: function(value){
                this.$emit('changeProp', 'email', value)
            }
        },
        password:{  
            get: function(){
                return this.formUser.password
            },
            set: function(value){
                this.$emit('changeProp', 'password', value)
            }
        },
        role_id:{  
            get: function(){
                let vl = this.formUser.role_id
                return vl.toString()
            },
            set: function(value){
                this.$emit('changeProp', 'role_id', value)
            }
        },
        id: {
            get: function(){
                return this.formUser.id
            },
            set: function(value){
                this.$emit('changeProp', 'id', value)
            }
        }
    },
    methods:{
         savePacie(){
            if(this.typeAction === 'Agregar'){
                this.$emit('saveForm', 1)
            }else{
                this.$emit('saveForm', 2)
            }
        },
        close(){
            this.$emit('close')
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