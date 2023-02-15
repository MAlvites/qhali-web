<template>
  <div>
    <v-row justify="center">
      <v-app>
        <v-dialog v-model="show" v-if="show" persistent :max-width="maxWidth">
          <v-card class="bg-green-secondary modal-register p-4">
            <div class="container-close-icon">
              <img
                class="cursor-pointer"
                src="/img/svg/close_black.svg"
                @click="closeSection()"
              />
            </div>
            <v-card-text>
              <p class="text-h4">Agregar Seccion</p>
            </v-card-text>
            <div class="row pl-4">
              <div class="col-3">
                <span>Seccion:</span>
              </div>
              <div class="col-9">
                <v-text-field v-model="textSection" dense solo> </v-text-field>
              </div>
            </div>
            <v-card-actions>
              <v-btn
                rounded
                color="primary"
                dark
                class="mr-5 px-5"
                @click="addSection()"
              >
                Guardar
              </v-btn>
              <v-btn
                rounded
                color="secondary"
                dark
                class="mr-5 px-5"
                @click="closeSection"
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
export default {
  name: "ModalSection",
  props: {
    show: {
      type: Boolean,
      default() {
        return false;
      },
    },
    data: {
      type: Object,
      default() {
        return {};
      },
    },
  },
  data() {
    return {
      textSection: "",
    };
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
  methods: {
    addSection() {
      let section = {
        name: this.textSection,
        response_scale: [],
        questions: [],
        response:null,
        score:""
      };
      this.$emit("addsection", section);
      this.closeSection();
    },
    closeSection() {
      this.$emit("closeModalSection", false);
    },
  },
};
</script>

<style>
</style>