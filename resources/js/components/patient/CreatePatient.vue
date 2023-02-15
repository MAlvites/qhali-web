<template>
    <div>
        <div class="class-position">Añadir paciente</div>
        <v-app>
            <v-card
                max-width="900"
                class="mx-auto my-12 rounded-xl"
                style="border: 4px solid #042354"
                id="card-form"
            >
                <v-card-title>
                    <v-row class="content-item-form -title">
                        <v-col cols="12" sm="12" class="d-flex justify-start align-center">
                            <label>Por favor, complete la siguiente
                                información personal: (Los Campos
                                marcados con * son obligatorios):</label>
                        </v-col>
                    </v-row>
                </v-card-title>
                <v-form
                    ref="formAdd"
                    v-model="validateForm"
                >
                    <v-row class="content-item-form">
                        <v-col cols="12" sm="5" class="d-flex justify-start align-center">
                            <label>Nombre(s) *</label>
                        </v-col>
                        <v-col cols="12" sm="7">
                            <v-text-field
                                v-model="form.name"
                                :rules="rules.name"
                                single-line
                            ></v-text-field>
                        </v-col>
                    </v-row>
                    <v-row  class="content-item-form">
                        <v-col cols="12" sm="5" class="d-flex justify-start align-center">
                            <label>Apellido Paterno*</label>
                        </v-col>
                        <v-col cols="12" sm="7">
                            <v-text-field
                                single-line
                                v-model="form.last_name"
                                :rules="rules.last_name"
                            ></v-text-field>
                        </v-col>
                    </v-row>
                    <v-row  class="content-item-form">
                        <v-col cols="12" sm="5" class="d-flex justify-start align-center">
                            <label>Apellido Materno*</label>
                        </v-col>
                        <v-col cols="12" sm="7">
                            <v-text-field
                                single-line
                                v-model="form.mother_last_name"
                                :rules="rules.mother_last_name"
                            ></v-text-field>
                        </v-col>
                    </v-row>
                    <v-row  class="content-item-form">
                        <v-col cols="12" sm="5" class="d-flex justify-start align-center">
                            <label>Nro. DNI / Pasaporte*</label>
                        </v-col>
                        <v-col cols="12" sm="7">
                            <v-text-field
                                single-line
                                v-model="form.nin"
                                :rules="rules.nin"
                            ></v-text-field>
                        </v-col>
                    </v-row>
                    <v-row  class="content-item-form">
                        <v-col cols="12" sm="5" class="d-flex justify-start align-center">
                            <label>Edad*</label>
                        </v-col>
                        <v-col cols="12" sm="7">
                            <v-text-field
                                single-line
                                v-model="form.age"
                                :rules="rules.age"
                                @keypress="onlyNumbers"
                                @paste.prevent="onlyNumbersPaste"
                            ></v-text-field>
                        </v-col>
                    </v-row>
                    <v-row  class="content-item-form">
                        <v-col cols="12" sm="5" class="d-flex justify-start align-center">
                            <label>Fecha de Nacimiento*</label>
                        </v-col>
                        <v-col cols="12" sm="7">
                            <v-menu
                                v-model="menu"
                                :close-on-content-click="false"
                                :nudge-right="40"
                                transition="scale-transition"
                                offset-y
                                min-width="auto"
                            >
                                <template v-slot:activator="{ on, attrs }">
                                <v-text-field
                                    v-model="form.date_birth"
                                    label="Picker without buttons"
                                    prepend-icon="mdi-calendar"
                                    readonly
                                    v-bind="attrs"
                                    v-on="on"
                                ></v-text-field>
                                </template>
                                <v-date-picker
                                v-model="form.date_birth"
                                @input="menu = false"
                                ></v-date-picker>
                            </v-menu>
                        </v-col>
                    </v-row>
                    <v-row  class="content-item-form">
                        <v-col cols="12" sm="5" class="d-flex justify-start align-center">
                            <label>Estado Civil*</label>
                        </v-col>
                        <v-col cols="12" sm="7">
                            <v-select
                                :items="itemsEstadoCivil"
                                label="Estado Civil"
                                v-model="form.civil_status"
                                :rules="rules.civil_status"
                            ></v-select>
                        </v-col>
                    </v-row>
                    <v-row  class="content-item-form">
                        <v-col cols="12" sm="5" class="d-flex justify-start align-center">
                            <label>Sexo de Nacimiento*</label>
                        </v-col>
                        <v-col cols="12" sm="7">
                            <v-select
                                :items="itemsSexo"
                                label="Sexo de Nacimiento"
                                v-model="form.birth_sex"
                                :rules="rules.birth_sex"
                            ></v-select>
                        </v-col>
                    </v-row>
                    <v-row  class="content-item-form">
                        <v-col cols="12" sm="5" class="d-flex justify-start align-center">
                            <label>Orientación Sexual</label>
                        </v-col>
                        <v-col cols="12" sm="7">
                            <v-select
                                :items="itemsOrientacion"
                                label="Orientación Sexual"
                                v-model="form.sex_orientation"
                                :rules="rules.sex_orientation"
                            ></v-select>
                        </v-col>
                    </v-row>
                    <v-row  class="content-item-form">
                        <v-col cols="12" sm="5" class="d-flex justify-start align-center">
                            <label>Nivel Académico</label>
                        </v-col>
                        <v-col cols="12" sm="7">
                            <v-select
                                :items="itemsNivelAcademico"
                                label="Nivel Académico"
                                v-model="form.academic_level"
                                :rules="rules.academic_level"
                            ></v-select>
                        </v-col>
                    </v-row>
                    <v-row  class="content-item-form">
                        <v-col cols="12" sm="5" class="d-flex justify-start align-center">
                            <label>Profesión</label>
                        </v-col>
                        <v-col cols="12" sm="7">
                            <v-text-field
                                single-line
                                v-model="form.profession"
                                :rules="rules.profession"
                            ></v-text-field>
                        </v-col>
                    </v-row>
                    <v-row  class="content-item-form">
                        <v-col cols="12" sm="5" class="d-flex justify-start align-center">
                            <label>Situación Laboral</label>
                        </v-col>
                        <v-col cols="12" sm="7">
                            <v-select
                                :items="itemsSituacion"
                                label="Situación Laboral"
                                v-model="form.employment_situation"
                                :rules="rules.employment_situation"
                            ></v-select>
                        </v-col>
                    </v-row>
                    <v-row  class="content-item-form">
                        <v-col cols="12" sm="5" class="d-flex justify-start align-center">
                            <label>Dirección*</label>
                        </v-col>
                        <v-col cols="12" sm="7">
                            <v-text-field
                                single-line
                                v-model="form.address"
                                :rules="rules.address"
                            ></v-text-field>
                        </v-col>
                    </v-row>
                    <v-row  class="content-item-form">
                        <v-col cols="12" sm="5" class="d-flex justify-start align-center">
                            <label>Distrito*</label>
                        </v-col>
                        <v-col cols="12" sm="7">
                            <v-text-field
                                single-line
                                v-model="form.district"
                                :rules="rules.district"
                            ></v-text-field>
                        </v-col>
                    </v-row>
                    <v-row  class="content-item-form">
                        <v-col cols="12" sm="5" class="d-flex justify-start align-center">
                            <label>Celular*</label>
                        </v-col>
                        <v-col cols="12" sm="7">
                            <v-text-field
                                single-line
                                v-model="form.phone_number"
                                :rules="rules.phone_number"
                                @keypress="onlyNumbers"
                                @paste.prevent="onlyNumbersPaste"
                            ></v-text-field>
                        </v-col>
                    </v-row>
                    <v-row  class="content-item-form -finish">
                        <v-col cols="12" sm="5" class="d-flex justify-start align-center">
                            <label>Correo Electrónico*</label>
                        </v-col>
                        <v-col cols="12" sm="7">
                            <v-text-field
                                single-line
                                v-model="form.email"
                                :rules="rules.email"
                            ></v-text-field>
                        </v-col>
                    </v-row>
                </v-form>
            </v-card>
            <v-card 
                max-width="900"
                class="card-actions mx-auto my-12 rounded-xl"
                style="border: none">
                <v-btn
                    rounded
                    color="primary"
                    dark
                    x-large
                    class="mr-5"
                    v-if="validateForm"
                    @click="save"
                    >
                        Agregar Paciente
                </v-btn>
                <v-btn
                    rounded
                    color="primary"
                    dark
                    x-large
                    class="mr-5"
                    v-else
                    >
                        Agregar Paciente
                </v-btn>
                <v-btn
                    rounded
                    color="secondary"
                    dark
                    x-large
                    class="mr-5"
                    @click="cancel"
                    >
                        Cancelar
                </v-btn>
            </v-card>
        </v-app>
    </div>
</template>

<script>
import helperValidation from '.././helpers/validations';
import alerts from '.././helpers/alerts';
export default {
    data(){
        return{
            menu: false,
            validateForm: false,
            form: {
                name: '',
                last_name: '',
                mother_last_name: '',
                nin: '',
                age: '',
                date_birth: '',
                civil_status: null,
                birth_sex: null,
                sex_orientation: null,
                academic_level: null,
                profession: '',
                employment_situation: null,
                address: '',
                district: '',
                phone_number: '',
                email: '',
            },
            rules: {
                name: [
                    value => !!value || 'No puede estar vacío.'
                ],
                last_name: [
                    value => !!value || 'No puede estar vacío.'
                ],
                mother_last_name: [
                    value => !!value || 'No puede estar vacío.'
                ],
                nin: [
                    value => !!value || 'No puede estar vacío.'
                ],
                age: [
                    value => !!value || 'No puede estar vacío.',
                    value => value > 0 || 'La edad ingresada es incorrecta'
                ],
                date_birth: [
                    value => !!value || 'No puede estar vacío.'
                ],
                civil_status: [
                    value => !!value || 'No puede estar vacío.'
                ],
                birth_sex: [
                    value => !!value || 'No puede estar vacío.'
                ],
                sex_orientation: [
                    value => !!value || 'No puede estar vacío.'
                ],
                academic_level: [
                    value => !!value || 'No puede estar vacío.'
                ],
                profession: [
                    value => !!value || 'No puede estar vacío.'
                ],
                employment_situation: [
                    value => !!value || 'No puede estar vacío.'
                ],
                address: [
                    value => !!value || 'No puede estar vacío.'
                ],
                district: [
                    value => !!value || 'No puede estar vacío.'
                ],
                phone_number: [
                    value => !!value || 'No puede estar vacío.',
                    value => value.length <= 9 || 'No es un número válido.',
                    value => value.length > 8 || 'No es un número válido.'
                ],
                email: [
                    value => !!value || 'No puede estar vacío.',
                    value =>  helperValidation.isEmailValid(value) || 'No es un email válido.'
                ]
            },
            items: ['Foo', 'Bar', 'Fizz', 'Buzz'],
            itemsEstadoCivil: ['Soltero', 'Casado', 'Divorsiado', 'Viudo'],
            itemsSexo: ['Masculino' , 'Femenino'],
            itemsOrientacion: ['Masculino' , 'Femenino' , 'Lesbiana' , 'Gay' ,'Transgénero' , 'Bisexual' , 'Intersexual' ,'Otro'],
            itemsNivelAcademico: ['Primaria' ,'Secundaria' ,'Universitario' ,'Técnica' ,'Pedagógica' ,'Otro'],
            itemsSituacion: ['Empleado' , 'Desempleado' , 'Independiente' , 'Otro'],
            showModal: false
        }
    },
    methods: {
        cancel() {
            window.location.href = '/patients'
        },
        save() {
            axios.post('/patients/create', this.form)
            .then(response => {
                alerts.alertSwal(response.data.message, 'success')
                window.location.href = '/patients/list'
            })
            .catch(error => {
                alerts.alertSwal(error.response.data.message, 'error')
            })
        },
        onlyNumbers: function(evt) {
            evt = (evt) ? evt : window.event;
            let expect = evt.target.value.toString() + evt.key.toString();
        
            if (!/^[-+]?[0-9]*\.?[0-9]*$/.test(expect)) {
                evt.preventDefault();
            } else {
                return true;
            }
        },
}
}
</script>

<style lang="scss">
@import '../../.././sass/app.scss';
    #card-form {
        .v-card__title{
            padding: 0;
            .d-flex {
                border-radius: 20px 20px 0 0;
                label{
                    font-size: 22px;
                    margin-left: 10px;
                    font-weight: bold;
                }
            }
        }
    }
    .content-item-form{
        border-bottom: 4px solid $color-azul;
        margin: 0 !important;

        &.-title{
            .d-flex {
                background: $color-celeste;
                label{
                    font-size: 22px;
                    margin-left: 10px;
                    color: white;
                    font-weight: bold;
                }
            }
        }

        &.-finish{
            border: none !important;
        }

        .d-flex {
            border-right: 4px solid $color-azul;
            label{
                font-size: 22px;
                margin-left: 10px;
                color: $color-azul;
                font-weight: bold;
            }
        }
    }
    .card-actions{
        box-shadow: unset !important;
        display: flex;
        justify-content: center;
        align-items: center;
    }
</style>