<template>
  <div>
    <v-card>
      <v-card-title class="text-h5 lighten-2">
        <v-row>
          <v-col cols="12" sm="11">
            {{ realiceQuiz.name }}
          </v-col>
          <v-col cols="12" sm="1">
            <v-btn icon dark @click="close">
              <v-icon class="red">mdi-close</v-icon>
            </v-btn>
          </v-col>
        </v-row>
      </v-card-title>
      <v-card
        outlined
        color="transparent"
        class="p-4"
        style="height: calc(54vh - 0rem); overflow-x: auto"
      >
        <div class="box-loading" v-if="boxLoading">
          <v-progress-circular
            :size="50"
            color="primary"
            indeterminate
          ></v-progress-circular>
        </div>
        <div
          v-for="(item, i) in realiceQuiz.structure"
          :key="i"
          class="pt-5"
          v-show="!boxLoading"
        >
          <div
            class="row align-items-center"
            :class="
              item.response_scale.length && item.questions.length
                ? 'border-line-quiz'
                : ''
            "
          >
            <div class="col-6">
              <div>{{ item.name }}</div>
            </div>
            <div
              class="col-6"
              v-if="item.response_scale.length && item.questions.length"
            >
              <div class="row align-items-center">
                <div
                  class="col p-0"
                  v-for="(scale, s) in item.response_scale"
                  :key="s"
                >
                  <div>{{ scale.value }}</div>
                </div>
              </div>
            </div>
          </div>
          <div
            class="row border-line-quiz align-items-center"
            v-if="item.response_scale.length && item.questions.length == 0"
          >
            <div
              class="col p-0 aling-center"
              v-for="(scale, s) in item.response_scale"
              :key="s"
            >
              <div>{{ scale.value }}</div>
              <div>
                <input
                  type="radio"
                  :name="'scale' + i"
                  :value="scale.point"
                  v-model="item.response"
                  @change="sumQuestions"
                  :disabled="disabled"
                  required
                />
              </div>
            </div>
          </div>

          <div
            class="row border-line-quiz"
            v-for="(question, q) in item.questions"
            :key="q"
          >
            <div class="col-6">
              <div class="row">
                <div class="col-1 pr-0">
                  <strong>{{ q + 1 + "." }}</strong>
                </div>
                <div class="col-11 pl-0">
                  <div>{{ " " + question.value }}</div>
                </div>
              </div>
            </div>
            <div class="col-6">
              <div class="row">
                <div
                  class="col"
                  v-for="(scale, s) in item.response_scale"
                  :key="s"
                >
                  <input
                    type="radio"
                    :name="'scale' + i + '' + q"
                    :value="scale.point"
                    v-model="question.response"
                    @change="sumQuestions"
                    :disabled="disabled"
                    required
                  />
                </div>
              </div>
            </div>
          </div>
          <div
            class="row border-line-quiz"
            v-if="
              item.questions.length && !preview && data.user.role_id != 3
            "
          >
            <div class="col aling-right" colspan="5">
              <span>Totales</span>
            </div>
            <div class="col-7">
              <div class="row">
                <div
                  class="col aling-center"
                  v-for="(scale, s) in item.response_scale"
                  :key="s"
                >
                  <div class="sumScales">
                    {{ totalQuestions[i + "cant" + s] }}
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div
            class="row"
            v-if="
              item.questions.length == 0 &&
              !preview &&
              who_resolve == 'medico'
            "
          >
            <div class="col aling-right" colspan="5">
              <span>Total</span>
            </div>
            <div class="col" colspan="6">
              <div class="row">
                <div class="col aling-center">
                  <div class="sumScales">
                    {{ totalQuestions[i + "cant"] }}
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div
          class="row p-2"
          v-if="!preview && !boxLoading  && data.user.role_id != 3"
        >
          <div class="col aling-right" colspan="5">
            <span>Puntos Totales</span>
          </div>
          <div class="col  aling-center" colspan="5">
            <div class="sumScales">
              {{ form.score }}
            </div>
          </div>
          <div class="col" colspan="1"></div>
        </div>
      </v-card>
      <v-divider v-if="idQuizView == null && !preview"></v-divider>

      <v-card-actions v-if="idQuizView == null && !preview">
        <v-spacer></v-spacer>
        <v-btn color="primary" text @click="saveQuiz()" :disabled="boxLoading"> Guardar </v-btn>
        <v-btn color="primary" text @click="cancelQuiz()" :disabled="boxLoading"> Cancelar </v-btn>
      </v-card-actions>
    </v-card>
  </div>
</template>

<script>
import alerts from "../../helpers/alerts";
export default {
  props: {
    data: {
      type: Object,
      default() {
        return {};
      },
    },
    quizId: {
      type: Number,
      default() {
        return null;
      },
    },
    show: {
      type: Boolean,
      default() {
        return false;
      },
    },
    disabled: {
      type: Boolean,
      default() {
        return false;
      },
    },
    idQuizView: {
      type: Number,
      default() {
        return null;
      },
    },
    who_resolve: {
      type: String,
      default() {
        return "";
      },
    },
    preview: {
      type: Boolean,
      default() {
        return false;
      },
    },
  },
  data() {
    return {
      realiceQuiz: [],
      totalQuestions: {},
      form: {
        quiz_id: this.quizId,
        patient_id: Object.keys(this.data).length ? this.data.patient.id : null,
        user_id: Object.keys(this.data).length ? this.data.user.id : null,
        who_resolved: this.who_resolve,
        response: [],
        score: "",
      },
      boxLoading: false,
    };
  },
  watch: {},
  methods: {
    viewQuiz(id) {
      this.boxLoading = true;
      axios
        .get("/patient-quizzes/" + id)
        .then((response) => {
          this.realiceQuiz = JSON.parse(response.data.data.response);
          this.sumQuestions();
          this.boxLoading = false;
        })
        .catch((error) => {
          alerts.alertSwal(error.response.data.message, "error");
        });
    },
    cancelQuiz() {
      swal({
            title: "Esta seguro?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
          if (willDelete) {
            this.close()
          } else {
          }
        });
    },
    sum(arr, key) {
      return arr.reduce((a, b) => parseInt(a) + (parseInt(b[key]) || 0), 0);
    },
    sumQuestions() {
      let data = this.realiceQuiz;
      this.totalQuestions = {};
      let sum = 0;
      let total = 0;
      data.structure.map((value, index) => {
        total = 0;
        if (value.questions.length) {
          value.response_scale.map((scale, sindex) => {
            this.totalQuestions[index + "cant" + sindex] = 0;
            sum = 0;
            value.questions.map((question) => {
              if (scale.point == question.response) {
                sum += parseInt(question.response);
                this.totalQuestions[index + "cant" + sindex] = sum;
              }
            });
          });
          total = this.sum(value.questions, "response");
          value.score = total;
        } else {
          this.totalQuestions[index + "cant"] =
            value.response != null && value.response != ""
              ? parseInt(value.response)
              : 0;
        }
        this.sumTotalQuestions();
        return value;
      });
    },
    saveQuiz() {
      let confirm = true;
      this.realiceQuiz.structure.map((r) => {
        if (r.questions.length) {
          r.questions.map((question) => {
            if (question.response == "") {
              alerts.alertSwal("Debe contestar todas las preguntas", "warning");
              confirm = false;
            }
          });
        } else {
          if (r.response == null || r.response == "") {
            alerts.alertSwal("Debe contestar todas las preguntas", "warning");
            confirm = false;
          }
        }
      });

      if (confirm) {
        this.boxLoading = true;
        axios
          .post("/patient-quizzes/create", this.form)
          .then((response) => {
            alerts.alertSwal(response.data.message, "success");
            this.boxLoading = false;
            this.close();
          })
          .catch((error) => {
            alerts.alertSwal(error.response.data.message, "error");
          });
      }
    },
    sumTotalQuestions() {
      let data = this.realiceQuiz;
      let sum = 0;
      data.structure.map((r, i) => {
        let score, response;
        score = r.score != null && r.score != "" ? parseInt(r.score) : 0;
        response =
          r.response != null && r.response != "" ? parseInt(r.response) : 0;

        sum += score + response;
      });
      this.form.response = JSON.stringify(this.realiceQuiz);
      this.form.score = sum;
    },
    getQuiz() {
      this.boxLoading = true;

      axios
        .get("/quizzes/" + this.quizId)
        .then((response) => {
          this.realiceQuiz = response.data.data;
          this.boxLoading = false;
        })
        .catch((error) => {
          alerts.alertSwal(error.response.data.message, "error");
        });
    },
    close() {
      this.$emit("close");
    },
  },
  created() {
    if (this.idQuizView == null) {
      this.getQuiz();
    } else {
      this.viewQuiz(this.idQuizView);
    }
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
};
</script>