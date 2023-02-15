<template>
    <div>
        <!--Movimientos del Robot-->
        <div class="row" v-if="type == 'move'">
            <div class="col-12">
                <v-btn class="btn-general mb-4">Mover Robot</v-btn>
            </div>
            <div class="col-12 d-flex">
                <div v-for="(item, index) in botActions" :key="index" v-show="item.type == type" class="text-center mr-10px">
                    <a style="cursor:pointer;" @click="sendAction(item.url)">
                        <img :src="item.img" :alt="item.name"  height="100px" width="100px">
                    </a>
                </div>
            </div>
        </div>
        
        <!--Acciones del Robot-->
        <div class="row" v-if="type == 'action'">
            <div class="col-7">
                <v-btn class="btn-general mb-4">Acciones del Robot</v-btn>
            </div>
            <div class="col-4">
                <v-text-field
                    v-model="action"
                    label="Buscar acción"
                    solo
                    dense
                    @keyup="findAction()"
                ></v-text-field>
            </div>
            <div class="col-1">
                <i class="fas fa-redo-alt btn btn-outline-secondary" @click="resetActons()" style="cursor: pointer;"></i>
            </div>
            <div class="col-12 bot-actions-content">
                <div class="row">
                    <div v-for="(item, index) in actions" :key="index" v-show="item.type == type" class="text-center col-3">
                        <a style="cursor:pointer;" @click="sendAction(item.url)">
                            <img :src="item.img" :alt="item.name"  height="100px" width="100px">
                            <p class="bot-action-name">{{item.name}}</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import alerts from '../../helpers/alerts';
export default {
    props: ['type', 'user_id', 'data'],
    data () {
      return {
        botActions: [],
        action: '',
        actions: []
      }
    },
    methods: {
        resetActons() {
            this.action = ''
            this.actions = this.botActions
        },
        findAction(){
            this.actions = []
            this.botActions.map(item => {
                let value = item.name.toLowerCase()
                if (value.indexOf(this.action.toLowerCase())!=-1) {
                    this.actions.push(item)
                }
            })
          
        },
        sendAction(url){
            axios.post(url)
            .then(response => {
                if (response.status == 200) {
                    //alerts.alertSwal('Accion realizada', 'success')
                }
            })
            .catch(error => {
                alerts.alertSwal(error.response.data.message, 'error')
            })
        },
        getBotAction() {
            axios.get('/bot-actions/get-all')
            .then(response => {
                this.botActions = response.data.data
                this.actions = response.data.data
            })
            .catch(error => {
                alerts.alertSwal(error.response.data.message, 'error')
            })            
        },
    },
    created() {
        this.getBotAction()
    }
}
</script>