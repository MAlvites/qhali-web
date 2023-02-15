<template>
    <div>
        <div class="class-position">Acciones del Robot</div>
        <v-app>
            <div class="content-call-robotin">
                <v-row>
                    <v-col cols="7" sm="12" md="7">
                        <div class="content-call">
                            <div class="content-video">
                                <video id="video1" autoplay="false" muted="muted" class="video-here" ref="video-here" ></video>  
                            </div>
                            <div class="content-options-call">
                                <v-row>
                                    <v-col cols="5">
                                        <div class="content-audio-call">
                                            <v-slider
                                                v-model="volumen"
                                                :max="100"
                                                class="mx-4"
                                                ticks
                                                prepend-icon="mdi-volume-high"
                                            ></v-slider>
                                        </div>
                                        <div class="content-audio-call">
                                            <v-slider
                                                v-model="microfono"
                                                :max="100"
                                                class="mx-4"
                                                ticks
                                                prepend-icon="mdi-microphone"
                                            ></v-slider>
                                        </div>
                                    </v-col>
                                    <v-col cols="7" class="d-flex align-center">
                                        <div class="option-call">
                                            <img src="/img/svg/camara.svg" alt="" class="call-img-pointer" >
                                        </div>
                                    </v-col>
                                </v-row>
                            </div>
                        </div>
                    </v-col>
                    <v-col cols="5" sm="12" md="5">
                        <div class="content-options-robotin">
                            <div class="content-option-volumen">
                                <span>Volumen: </span>
                                <div>
                                    <img src="/img/svg/menos.svg" alt="" @click="bajar(1)">
                                    <span>{{`${totalVolumen}%`}}</span>
                                    <img src="/img/svg/mas.svg" alt="" @click="subir(1)">
                                </div>
                            </div>
                            <div class="content-option-volumen">
                                <span>Brillo: </span>
                                <div>
                                    <img src="/img/svg/menos.svg" alt=""  @click="bajar(2)">
                                    <span>{{`${totalBrillo}%`}}</span>
                                    <img src="/img/svg/mas.svg" alt="" @click="subir(2)">
                                </div>
                            </div>
                            <div class="content-option-bateria">
                                <span>Nivel de bateria: </span>
                                <div>
                                    <span class="color-primary">{{`${bateria}%`}}</span>
                                    <v-progress-linear
                                        value="50"
                                        color="bg-secondary"
                                        height="25"
                                        rounded
                                        >
                                    </v-progress-linear>
                                </div>
                            </div>
                            <div class="content-option-bateria">
                                <span>Red Wifi: </span>
                                <span>Hospital Piso 3</span>
                            </div>
                        </div>
                    </v-col>
                </v-row>
            </div>
        </v-app>
    </div>
</template>

<script>

export default {
    data() {
        return {
            volumen: 0,
            microfono: 0,
            totalVolumen: 0,
            totalBrillo: 0,
            bateria: 50,

            channel: null,
            stream: null,
            peers: {},
        }
    },
    created() {
        this.setupVideoChat();
    },
    methods: {
        subir(type){
            if(type == 1){
                if(this.totalVolumen >= 0 && this.totalVolumen < 100) this.totalVolumen = ++this.totalVolumen
            }else{
                if(this.totalBrillo >= 0 && this.totalBrillo < 100) this.totalBrillo = ++this.totalBrillo
            }
        },
        bajar(type){
            if(type == 1){
                if(this.totalVolumen > 0) this.totalVolumen = --this.totalVolumen
            }else{
                if(this.totalBrillo > 0) this.totalBrillo = --this.totalBrillo
            }
        },
        async setupVideoChat() {
            const stream = await navigator.mediaDevices.getUserMedia({ video: true, audio: true });
            const videoHere = this.$refs['video-here'];
            videoHere.srcObject = stream;
            this.stream = stream;
        },
        async closeAudio(){
            const stream = await navigator.mediaDevices.getUserMedia({ video: true, audio: false });
            const videoHere = this.$refs['video-here'];
            videoHere.srcObject = stream;
            this.stream = stream;
        }
    }
}
</script>

<style lang="scss">
@import '../../.././sass/app.scss';
    .content-call-robotin{
        margin: 40px 40px 0;

        .content-call{

            .content-video{
                display: flex;
                justify-content: center;
                margin-left: 35px;
                position: relative;

            }
        }

        .content-options-robotin{
            .content-option-volumen{
                display: flex;
                font-size: 25px;
                color: $color-azul;
                font-weight: bold;
                margin-bottom: 50px;

                span{
                    width: 120px;
                }

                div{
                    display: inline-flex;
                    margin-left: 20px;

                    img{
                        margin: 0 20px;
                        width: 35px;
                    }

                    span{
                        margin: 0 20px;
                        width: auto !important;
                    }
                }
            }

            .content-option-bateria{
                display: flex;
                font-size: 25px;
                color: $color-azul;
                font-weight: bold;
                margin-bottom: 50px;

                span{
                    width: 120px;
                }

                .v-progress-linear{
                    width: 170px;
                    border-radius: 25px;
                }
            }
        }
    }
</style>