<template>
    <div>
        <div class="row">
            <div class="col-md-6">
                <div class="row">
                    <div class="col-12">
                        <div class="class-position">Gestión de Pacientes</div>
                    </div>
                    <div class="col-12 text-center" style="padding: 0 60px;">
                        <select class="form-control" v-model="map">
                            <option v-for="(item, index) in maps" :key="index" :value="item.img">{{item.name}}</option>
                        </select>
                        <img :src="'/img/mapas/'+map" alt="" class="w-100 mt-2">
                    </div>
                    <div class="col-12 mt-4" style="padding: 0 60px;">
                        <select class="form-control" v-model="botId">
                            <option value="null" disabled>Seleccionar Robot</option>
                            <option v-for="(item, index) in bots" :key="index" :value="item.id">{{item.name}}</option>
                        </select>
                    </div>
                    <div class="col-12 mt-4" style="padding: 0 60px;">
                        <img v-if="botId" src="/img/svg/camara.svg" alt="" class="call-img-pointer" @click="startVideoChat()">
                        <img v-else src="/img/svg/camara-gris.svg" alt="" class="call-img">
                        <img v-if="botId" src="/img/svg/llamada.svg" alt="" class="call-img-pointer" @click="goTherapy()">
                        <img v-else src="/img/svg/llamada-gris.svg" alt="" class="call-img">
                    </div>                    
                </div>

            </div>
            <div class="col-md-6">
                <div class="row">
                    <div class="col-12">
                        <v-btn class="btn-general mb-3">Cámara Robot</v-btn>
                    </div>
                    <div class="col-12">
                        <video id="video1" autoplay="true" class="video-there" ref="video-there" ></video>
                        <video id="video2" autoplay="true" class="video-here" ref="video-here" hidden muted="muted"></video>
                    </div>
                    <!--Movimientos del Robot-->
                    <div class="col-12">
                        <MoveAndActionBot :type="'move'"></MoveAndActionBot>
                    </div>
                    <!--Acciones del Robot-->
                    <div class="col-12">
                        <MoveAndActionBot :type="'action'"></MoveAndActionBot>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import alerts from '../helpers/alerts';
import Pusher from 'pusher-js';
import Peer from 'simple-peer';
import MoveAndActionBot from './options/MoveAndActionBot';
export default {
    components:{
        MoveAndActionBot,
    },
    props: ['data'],
    data () {
      return {
        map: 'canete1.jpg',
        maps: [
            {id: 1, name: 'Hospital de cañete - piso 1', img: 'canete1.jpg'},
            {id: 2, name: 'Hospital de cañete - piso 2', img: 'canete2.jpg'}
        ],
        botActions: [],
        bots: [],
        botId: null,
        channel: null,
        stream: null,
        peers: {}
      }
    },
    methods: {
        startVideoChat() {
            this.getPeer(this.botId, true);
        },
        getPeer(userId, initiator) {
            if(this.peers[userId] === undefined) {
                let peer = new Peer({
                    initiator,
                    stream: this.stream,
                    trickle: false
                });
                peer.on('signal', (data) => {
                    this.channel.trigger(`client-signal-${userId}`, {
                        userId: this.data.user.id,
                        data: data
                    });
                })
                .on('stream', (stream) => {
                    const videoThere = this.$refs['video-there'];
                    videoThere.srcObject = stream;
                })
                .on('close', () => {
                    const peer = this.peers[userId];
                    if(peer !== undefined) {
                        peer.destroy();
                    }
                    delete this.peers[userId];
                })
                .on('error', (err) => {
                    const peer = this.peers[userId];
                    peer.destroy();
                });
                this.peers[userId] = peer;
            } 
            return this.peers[userId];
        },
        async setupVideoChat() {
            // To show pusher errors
            // Pusher.logToConsole = true;
            const stream = await navigator.mediaDevices.getUserMedia({ video: true, audio: true });
            const videoHere = this.$refs['video-here'];
            videoHere.srcObject = stream;
            this.stream = stream;
            const pusher = this.getPusherInstance();
            this.channel = pusher.subscribe('presence-video-chat');
            this.channel.bind(`client-signal-${this.data.user.id}`, (signal) => 
            {
                const peer = this.getPeer(signal.userId, false);
                peer.signal(signal.data);
            });
        },
        getPusherInstance() {
            return new Pusher(process.env.MIX_PUSHER_APP_KEY, {
                authEndpoint: '/video/video-chat',
                cluster: process.env.MIX_PUSHER_APP_CLUSTER,
                auth: {
                    headers: {
                        'X-CSRF-Token': document.head.querySelector('meta[name="csrf-token"]').content
                    }
                }
            });
        },
        getBots() {
            axios.get('/users/get-bots')
            .then(response => {
                this.bots = response.data.data
            })
            .catch(error => {
                alerts.alertSwal(error.response.data.message, 'error')
            })
            
        },
        getBotAction() {
            axios.get('/bot-actions/get-all')
            .then(response => {
                this.botActions = response.data.data
            })
            .catch(error => {
                alerts.alertSwal(error.response.data.message, 'error')
            })
            
        },
        goTherapy() {
            window.location.href = '/medical-appointments/medical-attention/'+this.data.patient.id+'/'+this.botId
        },
    },

    created() {
        this.getBots()
        this.getBotAction()
        this.setupVideoChat();
    }
}
</script>