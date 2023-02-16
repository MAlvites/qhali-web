<template>
    <div>
        <div class="w-100 mt-5 text-center">
            <video id="video1" autoplay="true" class="video-there" ref="video-there"></video>
            <video id="video2" autoplay="true" class="video-here" ref="video-here" hidden muted="muted"></video>
        </div>

        <v-app>
            <v-dialog v-if="modalQuiz" persistent :max-width="maxWidth" >
                <ResolveQuiz :data="data" @close="closeResolveQuiz()" :quizId="quizId" :who_resolve="who_resolve"></ResolveQuiz>
            </v-dialog>
        </v-app>
    </div>
</template>

<script>
import alerts from '../helpers/alerts';
import Pusher from 'pusher-js';
import Peer from 'simple-peer';
import ResolveQuiz from '../medical-appointment/options/ResolveQuiz.vue';

export default {
    components: { ResolveQuiz },
    props: ['data'],
    data () {
      return {
        volumen: 0,
        microfono: 0,
        totalVolumen: 0,
        totalBrillo: 0,
        bateria: 50,

        botActions: [],
        botId: null,
        channel: null,
        stream: null,
        peers: {},
        currentComponent: 'History',
        component: 'History',
        menu: [
            {'value': 'historia', 'key': 'History'},
            {'value': 'encuesta', 'key': 'Quiz'},
            {'value': 'acciones', 'key': 'MoveAndActionBot'},
        ],
        modalQuiz: false,
        quizId: 1,
        who_resolve: 'paciente'
      }
    },
    methods: {
        closeResolveQuiz() {
            this.modalQuiz = false;
        },
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
             //Pusher.logToConsole = true;
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
        getBotAction() {
            axios.get('/bot-actions/get-all')
            .then(response => {
                this.botActions = response.data.data
            })
            .catch(error => {
                alerts.alertSwal(error.response.data.message, 'error')
            })
            
        },
        async closeAudio(){
            const stream = await navigator.mediaDevices.getUserMedia({ video: true, audio: false });
            const videoHere = this.$refs['video-here'];
            videoHere.srcObject = stream;
            this.stream = stream;
        },
        setupRealizeQuiz() {
            var pusher = new Pusher(process.env.MIX_PUSHER_APP_KEY, {
                cluster: process.env.MIX_PUSHER_APP_CLUSTER
            });

            var channel = pusher.subscribe('realize-quiz-channel');
            channel.bind('realize-quiz-event', data => {
                this.quizId = data.quizId
                this.data.patient.id = data.patientId
                this.modalQuiz = true
            });
        }
    },
    created() {
        this.getBotAction()
        this.setupVideoChat();
        this.setupRealizeQuiz();
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
}
</script>