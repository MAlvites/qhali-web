<template>
    <div>
        <v-btn class="btn-general mb-4">Mapa:</v-btn>
        <div>
            <img :src="map.url" alt="" width="500">
        </div>
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
            map: '',
      }
    },
    methods: {
        getMap() {
            axios.get('/maps/' + this.data.mapId)
            .then(response => {
                this.map = response.data.data
            })
        },
    },
    created() {
        this.getMap()
    }
}
</script>