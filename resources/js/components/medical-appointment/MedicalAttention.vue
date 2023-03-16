<template>
    <div>
        <div class="class-position">Cámara Robot</div>
        <div class="row p-5">
            <div class="col-md-7">
                <div class="row">
                    <div class="col-12 text-center">
                        <video id="video1" autoplay="true" class="video-there" ref="video-there" ></video>
                        <video id="video2" autoplay="true" class="video-here" ref="video-here" hidden muted="muted"></video>
                    </div>
                    <div class="col-12">
                        <div class="option-call">
                            <img src="/img/svg/llamada.svg" alt="" class="call-img-pointer" @click="startVideoChat()">
                            <img src="/img/svg/camara.svg" alt="" class="call-img-pointer">
                            <img src="/img/svg/colgar.svg" alt="" class="call-img-pointer" @click="closeCall()">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="row">
                    <div class="col-12">
                        <!-- Componentes -->
                         <component :is="currentComponent" :type="'action'" :user_id="this.data.patient.id" :data="data"></component>
                    </div>
                    <div class="col-12">
                        <!-- Movimientos del robot -->
                        <MoveAndActionBot :type="'move'"></MoveAndActionBot>
                    </div>
                </div>
            </div>
        </div>
        <div class="menu-right-patient">
            <ul>
                <li :class="item.key == component ? 'active' : ''" 
                    style="cursor: pointer;" 
                    v-for="(item, index) in menu" :key="index"
                    @click="selectComponent(item.key)"> {{item.value}}
                 </li>
            </ul>
        </div>
    </div>
</template>

<script>
import alerts from '../helpers/alerts';
import Pusher from 'pusher-js';
import Peer from 'simple-peer';
import MoveAndActionBot from './options/MoveAndActionBot';

import History from './options/History'
import Quiz from './options/Quiz'
import Action from './options/MoveAndActionBot'
import SiteMap from './options/SiteMap'
export default {
    components:{
        MoveAndActionBot,
        History,
        Quiz,
        Action,
        SiteMap
    },
    props: ['data'],
    data () {
      return {
        volumen: 0,
        microfono: 0,
        totalVolumen: 0,
        totalBrillo: 0,
        bateria: 50,

        botActions: [],
        botId: this.data.botId,
        channel: null,
        stream: null,
        peers: {},
        currentComponent: 'History',
        component: 'History',
        menu: [
            {'value': 'Historia', 'key': 'History'},
            {'value': 'Encuesta', 'key': 'Quiz'},
            {'value': 'Acciones', 'key': 'MoveAndActionBot'},
            {'value': 'Mapa del sitio', 'key': 'SiteMap'},
        ],
      }
    },
    methods: {
        selectComponent (value) {
            this.component = value
            this.currentComponent = this.component
        },
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
            return new Pusher(this.data.pusher.key, {
                authEndpoint: '/video/video-chat',
                cluster: this.data.pusher.cluster,
                auth: {
                    headers: {
                        'X-CSRF-Token': document.head.querySelector('meta[name="csrf-token"]').content
                    }
                }
            });
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
        async closeCall(){
            this.peers[this.data.botId].on('close', () => {
                    const peer = this.peers[userId];
                        peer.destroy();
                    delete this.peers[userId];
                });
        }
    },

    created() {
        this.getBotAction()
        this.setupVideoChat();
    }
}
</script>
<style lang="scss">
@import '../../.././sass/app.scss';
    .menu-right-patient{
        position: fixed;
        right: 0;
        top: 80px;
        ul{
            li{
                list-style: none;
                background: $color-celeste;
                color: white;
                padding: 40px 15px;
                margin: 5px 0;
                writing-mode: vertical-lr;
                transform: rotate(180deg);
                border-radius: 5px;

                &.active{
                    background: $color-azul;
                }
            }
        }
    }
</style>