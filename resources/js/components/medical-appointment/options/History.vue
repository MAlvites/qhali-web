<template>
    <div>
        <v-btn class="btn-general mb-4">Historia:</v-btn>
        <div>
            <div @click="openMedicalHistory()" class="attent-sub-title">Ver historia médica</div>
            <div @click="openModalMedicalHistory()" class="attent-sub-title" >Agregar información de cita</div>
        </div>
        <AddMedicalHistory :data="data" :show="showModalMedicalHistory" @close="closeModalMedicalHistory()"></AddMedicalHistory>
    </div>
</template>

<script>
import AddMedicalHistory from './AddMedicalHistory';
export default {
    components:{
        AddMedicalHistory,
    },
    props: ['type', 'user_id', 'data'],
    data () {
      return {
            showModalMedicalHistory: false,
      }
    },
    methods: {
        closeModalMedicalHistory() {
            this.showModalMedicalHistory = false
        },
        openModalMedicalHistory() {
            this.showModalMedicalHistory = true
        },
        openMedicalHistory(){
            window.open('/patients/generate-medical-history-pdf/'+this.user_id, '_blank')
        },
    },
    created() {
    }
}
</script>