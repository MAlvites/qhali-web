<template>
    <div>
        <v-btn class="btn-general mb-4">Encuesta</v-btn>
        <div>
            <div @click="openModalListQuiz()" class="attent-sub-title">Ver Encuestas</div>
            <div @click="openModalRegisterQuiz()" class="attent-sub-title" >Registrar Encuesta</div>
        </div>
        <RegisterQuiz v-if="showModalRegisterQuiz"  :data="data" :show="showModalRegisterQuiz" @close="closeModalRegisterQuiz()"></RegisterQuiz>
        <ListQuiz v-if="showModalListQuiz" :data="data" :show="showModalListQuiz" @close="closeModalListQuiz()"></ListQuiz>
    </div>
</template>

<script>
import RegisterQuiz from './RegisterQuiz';
import ListQuiz from './ListQuiz';
export default {
    components:{
        RegisterQuiz,
        ListQuiz
    },
    props: ['type', 'user_id', 'data'],
    data () {
      return {
            showModalListQuiz: false,
            showModalRegisterQuiz: false,
            showModalViewQuiz:false,
      }
    },
    methods: {
        closeModalRegisterQuiz() {
            this.showModalRegisterQuiz = false
        },
        openModalRegisterQuiz() {
            this.showModalRegisterQuiz = true
        },
        openModalListQuiz(){
            this.showModalListQuiz = true
        },
        closeModalListQuiz(){
            this.showModalListQuiz = false
        }
    },
    created() {
    }
}
</script>