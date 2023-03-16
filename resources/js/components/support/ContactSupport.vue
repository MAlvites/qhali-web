<template>
    <div>
        <div class="row">
            <div class="col-8 pr-30px">
                <div class="class-position">Soporte Técnico</div>
                <v-card
                    max-width="1200"
                    class="mx-auto my-12 rounded-xl"
                    style="border: unset ; box-shadow: none"
                >
                    <v-row class="pt-5">
                        <v-col cols="12 padding-support">
                            <v-alert
                                dense
                                text
                                type="success"
                                v-if="alertSend"
                                >
                                Correo enviado con exito!
                            </v-alert>
                            <v-form
                                ref="formLogin"
                                v-model="validateForm"
                                class="mt-16"
                            >  
                                <v-row>
                                    <v-col cols="2" class="pt-6">
                                        <span class="color-secondary" style="font-weight: bold; font-size: 19px">Usuraio: </span>
                                    </v-col>
                                    <v-col cols="9">
                                        <v-text-field
                                            :value="data.user.name"
                                            class="capitalize"
                                            readonly
                                            outlined
                                            rounded
                                        />
                                    </v-col>
                                </v-row> 
                                <v-row> 
                                    <v-col cols="2">
                                        <span class="color-secondary" style="font-weight: bold; font-size: 19px">Mensaje: </span>
                                    </v-col>
                                    <v-col cols="9">
                                        <v-textarea
                                            outlined
                                            auto-grow
                                            name="input-7-4"
                                            v-model="form.content"
                                            :rules="rules.content"
                                            rounded
                                            rows="5"
                                        ></v-textarea>
                                    </v-col>
                                </v-row> 
                            </v-form>
                            <v-card 
                                max-width="900"
                                class="card-actions mx-auto my-12 rounded-xl"
                                style="border: none">
                                <v-btn
                                    rounded
                                    color="primary"
                                    dark
                                    class="mr-5 px-5"
                                    v-if="validateForm"
                                    @click="send"
                                    >
                                        Enviar
                                </v-btn>
                                <v-btn
                                    rounded
                                    color="primary"
                                    dark
                                    class="mr-5 px-5"
                                    v-else
                                    >
                                        Enviar
                                </v-btn>
                                <v-btn
                                    rounded
                                    color="secondary"
                                    dark
                                    class="mr-5 px-5"
                                    @click="clean"
                                    >
                                        Borrar
                                </v-btn>
                            </v-card>
                        </v-col>
                    </v-row>
                </v-card>
            </div>
            <div class="col-3">
                <div style="background: #042354; color: white; border-radius: 15%; padding: 50px 40px">
                    <div class="text-center mb-10" style="border-bottom: 2px solid white;font-size: 25px">
                        Datos de contacto
                    </div>

                    <div class="mb-8">
                        <span style="font-size: 20px">Teléfono:</span><br>
                        <span style="margin: 0 10px">Central telefónica 626 -2000 <br>
                        Desde Provincias 0800-1-7827 <br>
                        (servicio gratuito)</span>
                    </div>

                    <div class="mb-8">
                        <span style="font-size: 20px">Ubicación:</span><br>
                        <span>Campus principal<br>
                        Av. Univeritaria 1801, San Miguel<br>
                        Lima 32, Perú</span>
                    </div>

                    <div class="text-center mb-10" style="border-bottom: 2px solid white;font-size: 25px">
                        VER MAPA
                    </div>
                    <div class="mb-8">
                        <span style="font-size: 20px">Horas de atención:</span><br>
                        <span>De Lunes a viernesd de 8:00 a.m.<br>
                        a 7:30 p.m.</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import alerts from '.././helpers/alerts';
export default {
    props: ['data'],
    data(){
        return {
            validateForm: false,
            usuario: '',
            form: {
                content: ''
            },
            rules: {
                content: [
                    value => !!value || 'No puede estar vacio.'
                ],
            },
            alertSend: false
        }
    },

    methods: {
        send(){
             axios.post('/supports/send-mail', this.form)
            .then(response => {
                this.form.content = ''
                alerts.alertSwal(response.data.message, 'success')
            })
            .catch(error => {
                alerts.alertSwal(error.response.data.message, 'error')
            })
        },
        clean(){
            this.form.content = ''
        }
    }
}
</script>