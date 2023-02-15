<template>
  <div>
    <div class="class-position">Lista de Encuestas</div>
    <v-card
      max-width="1000"
      class="mx-auto my-12 rounded-xl"
      style="border: 4px solid #042354"
    >
      <v-card-title>
        <v-text-field
          v-model="search"
          append-icon="mdi-magnify"
          label="Search"
          single-line
          hide-details
          @keyup="allData"
        ></v-text-field>
      </v-card-title>
      <v-data-table
        class="table-patients"
        :headers="headers"
        :items="desserts"
        :loading="loadingData"
        :items-per-page="itemsPerPage"
        loading-text="Cargando"
        hide-default-footer
      >
        <template v-slot:[`item.action`]="{ item }">
          <v-btn class="primary" @click="showQuiz(item)">Ver</v-btn>
          <v-btn class="primary" @click="EditQuiz(item)">Editar</v-btn>
          <v-btn class="danger" @click="deleteQuiz(item)">Eliminar</v-btn>
        </template>
      </v-data-table>
      <v-pagination
        total-visible="10"
        v-model="page"
        :length="pageCount"
        @next="allData"
        @previous="allData"
        @input="allData"
      ></v-pagination>
    </v-card>
    <v-row justify="center" v-if="viewQuiz">
      <v-app>
        <v-dialog
          v-if="viewQuiz"
          v-model="viewQuiz"
          persistent
          :max-width="maxWidth"
        >
          <ResolveQuiz
            :disabled="true"
            :quizId="idQuiz"
            :data="data"
            :preview="true"
            @close="closeModalViewQuiz()"
          ></ResolveQuiz>
        </v-dialog>
      </v-app>
    </v-row>
  </div>
</template>

<script>
import alerts from ".././helpers/alerts";
import ResolveQuiz from "../medical-appointment/options/ResolveQuiz.vue";
export default {
  props: ["data", "show"],
  components: { ResolveQuiz },
  data() {
    return {
      search: "",
      headers: [
        {
          text: "ID",
          align: "start",
          sortable: true,
          value: "id",
        },
        { text: "Encuesta", value: "name", sortable: true },
        { text: "Acciones", value: "action", sortable: false },
      ],
      desserts: [],
      loadingData: true,
      itemsPerPage: 15,
      page: 1,
      pageCount: 0,
      item: null,
      idQuiz: "",
      viewQuiz: false,
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
    deleteQuiz(data) {
      swal({
        title: "Esta seguro?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      }).then((willDelete) => {
        if (willDelete) {
          axios
            .post("/quizzes/delete/" + data.id)
            .then((response) => {
              this.allData();
              alerts.alertSwal(response.data.message, "success");
            })
            .catch((error) => {
              alerts.alertSwal(error.response.data.message, "error");
            });
        } else {
        }
      });
    },
    showQuiz(data) {
      this.idQuiz = data.id;
      this.viewQuiz = true;
    },
    closeModalViewQuiz() {
      this.viewQuiz = false;
    },
    allData() {
      this.loadingData = true;
      let json = {
        page: this.page,
        name: this.search,
      };
      axios
        .post("/quizzes/search?page=" + this.page, json)
        .then((response) => {
          this.desserts = response.data.data.data;
          this.page = response.data.data.current_page;
          this.pageCount = response.data.data.last_page;
          this.loadingData = false;
        })
        .catch((error) => {
          alerts.alertSwal(error.response.data.message, "error");
        });
    },
    EditQuiz(item){
      console.log(item)
      window.location.href ="/quizzes/edit/" + item.id
    }
  },

  created() {
    this.allData();
  },
};
</script>