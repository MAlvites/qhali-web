<template>
    <div>
        <v-row justify="center" v-if="show">
            <v-app>
                <v-dialog
                v-model="show"
                persistent
                :max-width="maxWidth">
                    <v-card
                        max-width="1000"
                        class="mx-auto my-12 rounded-xl px-12 py-12"
                        style="border: 4px solid #042354"
                        >
                        <v-card-title class="justify-center mb-8">
                            Nueva Entrada al Historial Médico
                        </v-card-title>
                        <v-card-text>
                            <div>
                            <p> Fecha: 07/ 07/ 2021 </p>
                            <p> Paciente: Diego Martín Arce Cigueñas</p>
                            <p> Médico: Edwin Apaza</p>
                            </div>  
                            <div>
                                <v-form>
                                    <v-expansion-panels v-model="panel" multiple>
                                    <v-expansion-panel>
                                        <v-expansion-panel-header>
                                        <template>
                                            <v-row no-gutters>
                                            <v-col cols="4">
                                                Motivo de Consulta:
                                            </v-col>
                                            </v-row>
                                        </template>
                                        </v-expansion-panel-header>
                                        <v-expansion-panel-content>
                                        <v-textarea
                                            v-model="form.reason_consultation"
                                            outlined
                                            dense
                                            placeholder="Esribir...."
                                        ></v-textarea>
                                        </v-expansion-panel-content>
                                    </v-expansion-panel>

                                    <v-expansion-panel>
                                        <v-expansion-panel-header>
                                        <template>
                                            <v-row no-gutters>
                                            <v-col cols="4">
                                                Antecedentes de Importancia
                                            </v-col>
                                            </v-row>
                                        </template>
                                        </v-expansion-panel-header>
                                        <v-expansion-panel-content>
                                        <v-textarea
                                            v-model="form.important_background"
                                            outlined
                                            dense
                                            placeholder="Esribir...."
                                        ></v-textarea>
                                        </v-expansion-panel-content>
                                    </v-expansion-panel>

                                    <v-expansion-panel>
                                        <v-expansion-panel-header>
                                        <template>
                                            <v-row no-gutters>
                                            <v-col cols="4">
                                                Descripción Clínica:
                                            </v-col>
                                            </v-row>
                                        </template>
                                        </v-expansion-panel-header>
                                        <v-expansion-panel-content>
                                        <v-textarea
                                            v-model="form.clinical_description"
                                            outlined
                                            dense
                                            placeholder="Esribir...."
                                        ></v-textarea>
                                        </v-expansion-panel-content>
                                    </v-expansion-panel>

                                    <v-expansion-panel>
                                        <v-expansion-panel-header>
                                        <template>
                                            <v-row no-gutters>
                                            <v-col cols="4">
                                                Resultado del Cuestionario
                                            </v-col>
                                            </v-row>
                                        </template>
                                        </v-expansion-panel-header>
                                        <v-expansion-panel-content>
                                        <v-textarea
                                            v-model="form.questionnaire_result"
                                            outlined
                                            dense
                                            placeholder="Esribir...."
                                        ></v-textarea>
                                        </v-expansion-panel-content>
                                    </v-expansion-panel>

                                    <v-expansion-panel>
                                        <v-expansion-panel-header>
                                        <template>
                                            <v-row no-gutters>
                                            <v-col cols="4">
                                                Aproximación Diagnóstica
                                            </v-col>
                                            </v-row>
                                        </template>
                                        </v-expansion-panel-header>
                                        <v-expansion-panel-content>
                                        <v-textarea
                                            v-model="form.diagnostic_approach"
                                            outlined
                                            dense
                                            placeholder="Esribir...."
                                        ></v-textarea>
                                        </v-expansion-panel-content>
                                    </v-expansion-panel>

                                    <v-expansion-panel>
                                        <v-expansion-panel-header>
                                        <template>
                                            <v-row no-gutters>
                                            <v-col cols="4">
                                                Recomendaciones
                                            </v-col>
                                            </v-row>
                                        </template>
                                        </v-expansion-panel-header>
                                        <v-expansion-panel-content>
                                        <v-textarea
                                            v-model="form.recommendations"
                                            outlined
                                            dense
                                            placeholder="Esribir...."
                                        ></v-textarea>
                                        </v-expansion-panel-content>
                                    </v-expansion-panel>

                                    <v-expansion-panel>
                                        <v-expansion-panel-header>
                                        <template>
                                            <v-row no-gutters>
                                            <v-col cols="4">
                                                Reporte de Intervaciones
                                            </v-col>
                                            </v-row>
                                        </template>
                                        </v-expansion-panel-header>
                                        <v-expansion-panel-content>
                                        <v-textarea
                                            v-model="form.intervention_report"
                                            outlined
                                            dense
                                            placeholder="Esribir...."
                                        ></v-textarea>
                                        </v-expansion-panel-content>
                                    </v-expansion-panel>
                                    
                                    </v-expansion-panels>
                                </v-form>
                                <div class="text-center">
                                    <v-btn
                                        rounded
                                        color="primary"
                                        dark
                                        x-large
                                        class="mr-5 mt-10"
                                        @click="confirmSave()"
                                        >
                                            Guardar
                                    </v-btn>
                                     <v-btn
                                        rounded
                                        color="secondary"
                                        dark
                                        x-large
                                        class="mr-5 mt-10"
                                        @click="close"
                                        >
                                            Cancelar
                                    </v-btn>
                                </div>
                               
                            </div>
                        </v-card-text>
                    </v-card>
                </v-dialog>
            </v-app>
        </v-row>
    </div>
</template>

<script>
import alerts from '../../helpers/alerts';
export default {
    props: ['data', 'show'],
    data(){
      return {
        panel: [0],
        form: {
            patient_id: this.data.patient.id,
            reason_consultation: '',
            important_background: '',
            clinical_description: '',
            questionnaire_result: '',
            diagnostic_approach: '',
            recommendations: '',
            intervention_report: ''
        },
      }
    },
    methods: {
        close() {
            this.$emit('close')
        },
        confirmSave() {
            if (this.form.reason_consultation != '' || this.form.important_background != '' ||
                this.form.clinical_description != '' || this.form.questionnaire_result != '' ||
                this.form.diagnostic_approach != '' || this.form.recommendations != '' ||
                this.form.intervention_report != '') {
                    swal({
                        title: "¿Esta seguro que desea guardar la información?",
                        icon: "info",
                        buttons: true,
                        dangerMode: true,
                    })
                    .then((willDelete) => {
                        if (willDelete) {
                            this.save()
                        }
                    });
            } else {
                alerts.alertSwal('Debe llenar algun campo para continuar', 'info')
            }
        },
        save() {
            axios.post('/patients/save-medical-history', this.form)
            .then(response => {
                alerts.alertSwal(response.data.message, 'success')
                this.$emit('close')
            })
            .catch(error => {
                alerts.alertSwal(error.response.data.message, 'error')
            })
        },
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