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
                @click="closeScale()"
              />
            </div>
            <v-card-text>
              <p class="mb-5 text-h4">Agregar Escala</p>
            </v-card-text>
            <div class="row">
              <div class="col-10">
                <div class="row" v-for="(item,i) in dataScales[0].response_scale" :key="i">
                  <div class="col-3">
                    <span>Escala:</span>
                  </div>
                  <div class="col-9">
                    <v-text-field v-model="item.value"> </v-text-field>
                  </div>
                </div>
              </div>
              <div class="col-2">
                <v-btn @click="generateScale">+</v-btn>
              </div>
            </div>
            <v-card-actions>
              <v-btn
                rounded
                color="primary"
                dark
                class="mr-5 px-5"
                @click="addScale()"
              >
                Guardar
              </v-btn>
              <v-btn
                rounded
                color="secondary"
                dark
                class="mr-5 px-5"
                @click="closeScale"
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
  name: "ModalEscale",
  props: {
    show: {
      type: Boolean,
      default() {
        return false;
      },
    },
    arrScales: {
      type: Array,
      default() {
        return [];
      },
    },
    position:{
      type:Number
    }
  },
  data() {
    return {
      dataScales: [...this.arrScales]
    };
  },
  watch:{
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
    generateScale(){
      this.dataScales[0].response_scale.push({value:''})
    },
    addScale() {
      this.$emit("addScale", this.dataScales);
      this.closeScale()
    },
    closeScale() {
      this.$emit("closeModalScale", false);
    },
  },
  mounted(){
    if(this.dataScales.length){
      this.dataScales[0].response_scale.push({value:''})
      //this.generateScale()
    }
  },
  created(){
    
  }
};
</script>

<style>
</style>