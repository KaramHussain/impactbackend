<template>
    <div class="main">
        <div class="container">

            <h5 class="my-2 float-left">Refine Parts</h5>

            <span class="pointer float-right" @click="close">
				<i class="fa fa-times-circle text-danger"></i>
			</span>

            <div class="clearfix"></div>

            <ul class="my-2">
                <li style="list-style:none" :key="i" v-for="(part, i) in parts">
                    <div class="radio">
                        <input @change="changeSymptoms($event)" type="radio" name="optradio" :id="part.part" :value="part.id">
                        <label :for="part.part">
                            {{part.part}}
                            <span class="radio-button"></span>
                        </label>
                    </div>
                </li>
                <li style="list-style:none">
                    <div class="radio">
                        <input @change="changeSymptoms($event)" type="radio" name="optradio" value="0" id="not_sure">
                        <label for="not_sure">
                            Not sure
                            <span class="radio-button"></span>
                        </label>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
import { mapActions } from 'vuex';
export default {
    name:'refinedParts',
    data(){
        return {

        };
    },

    computed:{
        parts(){
            //return this.$store.getters['anatomy/refinedParts'];
            return this.$store.state.anatomy.refined_parts;
        }
    },

    created(){
        let url = this.url;
        let part = this.part;
        this.getParts({url, part});
    },

    methods:{

        ...mapActions(
            'anatomy', [
                'getParts'
            ]
        ),

        close(){
            this.$emit('closeParts');
        },

        changeSymptoms(event){

            let value = event.target.value;
            let id = event.target.id;

            this.$emit('changePart', {value, id});
        }
    },

    props:['url', 'part']
}
</script>

<style scoped>
    .main{
        background:white;
        height:100%;
    }
</style>
