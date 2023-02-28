<template>
  <div>
    <v-row justify="center" v-if="show">
      <v-app>
        <v-dialog v-model="show" persistent :max-width="maxWidth" >
          <v-card v-if="dialog" >
            <v-card-title class="text-h5 lighten-2">
              <v-row>
                <v-col cols="12" sm="11"> Realizar Encuesta </v-col>
                <v-col cols="12" sm="1">
                  <v-btn icon dark @click="close">
                    <v-icon class="red">mdi-close</v-icon>
                  </v-btn>
                </v-col>
              </v-row>
            </v-card-title>

            <v-card-text>
              <div>
                <v-autocomplete
                  v-model="quizId"
                  :items="quizzes"
                  item-text="name"
                  item-value="id"
                  filled
                  rounded
                  dense
                  solo
                  class="font-size-12"
                  label="Seleccionar"
                  no-data-text="No encontrado"
                ></v-autocomplete>
              </div>
            </v-card-text>

            <v-divider></v-divider>

            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="primary" text @click="performMedical()">
                Realizar Medico
              </v-btn>
              <v-btn color="primary" text @click="performPatient()">
                Realizar Paciente
              </v-btn>
            </v-card-actions>
          </v-card>
          <ResolveQuiz v-else  :data="data" @close="closeResolveQuiz()" :quizId="quizId" :who_resolve="who_resolve"></ResolveQuiz>
        </v-dialog>
      </v-app>
    </v-row>
  </div>
</template>

<script>
import alerts from "../../helpers/alerts";
import ResolveQuiz from './ResolveQuiz.vue';
export default {
  components: { ResolveQuiz },
  name: "RegisterQuiz",
  props: ["data", "show"],
  data() {
    return {
      quizId: null,
      quizzes: [],
      dialog: true,
      who_resolve:''
    };
  },
  methods: {
    close() {
      this.$emit("close");
    },
    closeResolveQuiz() {
      this.dialog = true;
      this.close()
    },
    performMedical() {
      this.who_resolve = 'medico'
      this.dialog = false;
    },
    performPatient(){
      let form = {
        'quiz_id': this.quizId,
        'patient_id': this.data.patient.id,
        'bot_id': this.data.botId,
      }
      axios.post('/patient-quizzes/relize-quiz', form)
      .then((response) => {
        if (response.status === 200) {
          alerts.alertSwal('La encuesta sera realizada por el paciente.', 'success');
          this.$emit("close");
        }
      })
      .catch((error) => {
        alerts.alertSwal(error.response.data.message, "error");
      });
    },
    getQuizzes() {
      this.loadingData = true;
      axios.post("/quizzes/list")
      .then((response) => {
        this.quizzes = response.data.data;
        this.loadingData = false;
      })
      .catch((error) => {
        alerts.alertSwal(error.response.data.message, "error");
      });
    },
  },
  computed: {
    maxWidth() {
      switch (this.$vuetify.breakpoint.name) {
        case "xs":
          return 480;
        case "sm":
          return 520;
        case "md":
          return 800;
        case "lg":
          return 1000;
        case "xl":
          return 1200;
      }
    },
  },
  created() {
    this.getQuizzes();
  },
};
</script>