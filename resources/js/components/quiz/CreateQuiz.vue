<template>
  <v-app>
    <div>
      <div class="row">
        <div class="col-8">
          <div class="class-position">Creación de Encuesta</div>
        </div>
      </div>
      <v-app class="p-3">
        <v-card class="p-5" :outlined="true">
          <v-form ref="formAdd" v-model="validateForm">
            <div class="row">
              <div class="col-sm-2">
                <label>Nombre</label>
              </div>
              <div class="col-sm-4">
                <v-text-field v-model="form.name" dense solo></v-text-field>
              </div>
              <div class="col-sm-4">
                <v-btn @click="AddSection" dense>+ Agregar Seccion</v-btn>
              </div>
            </div>
            <v-card
              class="p-3 mt-2"
              v-for="(item, i) in form.structure"
              :key="i"
            >
              <div>
                <div class="row">
                  <div class="col-sm-2">
                    <label>{{ "Seccion " + (i + 1) }}</label>
                  </div>
                  <div class="col-sm-4">
                    <v-text-field v-model="item.name" dense solo>
                    </v-text-field>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-2">
                    <label for="">Escala de respuetas</label>
                  </div>
                  <div class="col-sm-6" v-if="item.response_scale.length">
                    <div
                      class="row"
                      v-for="(response, ir) in item.response_scale"
                      :key="ir"
                    >
                      <div class="col-7">
                        <v-text-field
                          v-model="response.value"
                          dense
                          solo
                        ></v-text-field>
                      </div>
                      <div class="col-3 pt-0">
                        <div class="row">
                          <div class="col-5 pt-0">
                            <label for="">Puntaje:</label>
                          </div>
                          <div class="col-7">
                            <v-text-field
                              v-model="response.point"
                              solo
                              type="number"
                              dense
                            ></v-text-field>
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-2">
                        <v-btn @click="deleteScale(i, ir)" color="error" dense
                          >-</v-btn
                        >
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-2">
                    <v-btn @click="generateScale(i)" dense>+</v-btn>
                  </div>
                </div>
                <div class="row" v-if="item.response_scale.length">
                  <div class="col-sm-2">
                    <label for="">Preguntas:</label>
                  </div>
                  <div class="col-sm-7" v-if="item.questions.length">
                    <div
                      class="row"
                      v-for="(question, iq) in item.questions"
                      :key="iq"
                    >
                      <div class="col-1">
                        <span>{{ iq + 1 }}</span>
                      </div>
                      <div class="col-9">
                        <v-text-field
                          v-model="question.value"
                          solo
                        ></v-text-field>
                      </div>
                      <div class="col-2 text-danger">
                        <v-btn
                          @click="deleteQuestion(i, iq)"
                          color="error"
                          dense
                          >-</v-btn
                        >
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-2">
                    <v-btn @click="generateQuestion(i)" dense>+</v-btn>
                  </div>
                </div>
                <div class="aling-right">
                  <v-btn @click="deleteSection(i)" color="error" dense
                    >Eliminar Seccion</v-btn
                  >
                </div>
              </div>
            </v-card>
            <div class="mt-5 aling-right">
              <v-btn class="mr-5 px-3" @click="save">Guardar</v-btn>
              <v-btn @click="cancelQuiz()">Cancelar</v-btn>
            </div>
          </v-form>
        </v-card>
      </v-app>
      <modal-section
        v-if="showSection"
        :show="showSection"
        @closeModalSection="closeModalSection"
        @addsection="generateSection"
      ></modal-section>
      <!--modal-escale  v-if="showScale" :position="position" :arrScales="imputeScales" :show="showScale" @closeModalScale="closeModalScale" @addScale="generateScale"></modal-escale-->
    </div>
  </v-app>
</template>

<script>
import helperValidation from ".././helpers/validations";
import alerts from ".././helpers/alerts";
import ModalSection from "./ModalSection.vue";
import ModalEscale from "./ModalEscale.vue";
export default {
  components: { ModalSection, ModalEscale },
  name: "CreateQuiz",
  props: {},
  data() {
    return {
      showSection: false,
      showScale: false,
      menu: false,
      validateForm: false,
      structure: [],
      imputeScales: [],
      position: "",
      name: "",
      form: {
        name: "",
        structure: [],
      },
    };
  },
  methods: {
    cancelQuiz() {
      swal({
        title: "Esta seguro?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      }).then((willDelete) => {
        if (willDelete) {
          location.href = "/quizzes";
        } else {
        }
      });
    },
    deleteSection(i) {
      swal({
        title: "Esta seguro?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      }).then((willDelete) => {
        if (willDelete) {
          this.form.structure.splice(i, 1);
        } else {
        }
      });
    },
    deleteQuestion(i, ind) {
      this.form.structure[i].questions.splice(ind, 1);
    },
    deleteScale(i, ind) {
      this.form.structure[i].response_scale.splice(ind, 1);
      if (this.form.structure[i].response_scale.length == 0) {
        this.form.structure[i].questions = [];
      }
    },
    generateQuestion(i) {
      this.form.structure[i].questions.push({ value: "", response: "" });
    },
    generateScale(i) {
      this.form.structure[i].response_scale.push({ value: "", point: "" });
    },
    generateSection(data) {
      this.form.structure.push(data);
    },
    AddSection() {
      this.showSection = true;
    },
    addScales(data, index) {
      this.showScale = true;
      let dd = data;
      this.imputeScales = [dd];
      this.position = index;
    },
    save() {
      axios
        .post("/quizzes/create", this.form)
        .then((response) => {
          alerts.alertSwal(response.data.message, "success");
          window.location.href = "/quizzes/list";
        })
        .catch((error) => {
          alerts.alertSwal(error.response.data.message, "error");
        });
    },
    onlyNumbers: function (evt) {
      evt = evt ? evt : window.event;
      let expect = evt.target.value.toString() + evt.key.toString();

      if (!/^[-+]?[0-9]*\.?[0-9]*$/.test(expect)) {
        evt.preventDefault();
      } else {
        return true;
      }
    },
    closeModalSection() {
      this.showSection = false;
    },
    closeModalScale() {
      this.showScale = false;
      this.imputeScales = [];
      this.position = "";
    },
  },
};
</script>

<style lang="scss">
@import "../../.././sass/app.scss";
#card-form {
  .v-card__title {
    padding: 0;
    .d-flex {
      border-radius: 20px 20px 0 0;
      label {
        font-size: 22px;
        margin-left: 10px;
        font-weight: bold;
      }
    }
  }
}
.content-item-form {
  border-bottom: 4px solid $color-azul;
  margin: 0 !important;

  &.-title {
    .d-flex {
      background: $color-celeste;
      label {
        font-size: 22px;
        margin-left: 10px;
        color: white;
        font-weight: bold;
      }
    }
  }

  &.-finish {
    border: none !important;
  }

  .d-flex {
    border-right: 4px solid $color-azul;
    label {
      font-size: 22px;
      margin-left: 10px;
      color: $color-azul;
      font-weight: bold;
    }
  }
}
.card-actions {
  box-shadow: unset !important;
  display: flex;
  justify-content: center;
  align-items: center;
}
.aling-center {
  text-align: center;
}
.aling-left {
  text-align: left;
}
.aling-right {
  text-align: right;
}
</style>