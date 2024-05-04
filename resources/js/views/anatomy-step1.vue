<template>
    <div>
    
        <form action="" method="post" @submit.prevent="submit" @keydown="form.errors.clear($event.target.name)">
            
            <div class="row justify-content-center">
                
                <div class="col-md-6">
                    <h4>Select body part</h4>    
                    <male :src="origin" v-show="form.gender=='1'"  @fillPart="fillPart($event)"></male>
                    <female :src="origin" v-show="form.gender=='2'"  @fillPart="fillPart($event)"></female>
                </div>

                <div class="col-md-6 mt-5">
                    
                    <div class="form-group">
                        <label for="gender">Gender</label>
                        <select id="gender" class="form-control" name="gender" v-model="form.gender">
                            <option value="1">Male</option>   
                            <option value="2">Female</option>   
                        </select>
                    </div>

                    <div class="form-group">
                        
                        <label for="age">Age</label>
                        <select id="age" class="form-control" name="age" v-model="form.age" :class="{'is-invalid':form.errors.has('age')}">
                            <option v-for="(age, index) in ages" :key="index" :value="age">
                                {{age}}
                            </option>
                        </select>
                        
                        <span class="text-danger" v-if="form.errors.has('age')"> 
                            {{form.errors.get('age')}}
                        </span>   

                    </div>

                    <div class="form-group">
                        
                        <label for="location">Location</label>
                        
                        <input id="location" class="form-control" name="location" v-model="form.location" type="text" placeholder="Your location" :class="{'is-invalid':form.errors.has('location')}">
                        
                        <span class="text-danger" v-if="form.errors.has('location')" id="location"> 
                            {{form.errors.get('location')}}
                        </span>                
                    
                    </div>

                    <div class="form-group">
                
                        <input type="submit" class="btn btn-success control px-3" value="Next" :disabled="form.errors.any()">
                    
                    </div>  

                </div>
                
            </div>
        
        </form>

    </div>
</template>

<script>
    
    import male from './male.vue';
    import female from './female.vue';
    import {mapActions} from 'vuex';

    class Errors {
        
        constructor(){
            this.errors = {};
        }

        has(field){
            if (this.errors[field]) {
                return this.errors.hasOwnProperty(field);
            }
        }

        get(field){
            if (this.errors[field]) {
                return this.errors[field][0];
            }
        }

        any(){
            return Object.keys(this.errors).length > 0;
        }

        record(errors){
            this.errors = errors;
        }

        clear(field){
            if (field) {
                delete this.errors[field];
                return;
            }
            this.errors = {};
        }
    }

    class Form{
            
        constructor(data){
            this.originalData = data;

            for(let field in data){
                this[field] = data[field];    
            }

            this.errors = new Errors();
        }

        data(){
            
            let data = {};

            for(let property in this.originalData){
                data[property] = this[property];
            }

            return data;
        }

        submit(requestType, action){

            return new Promise((resolve, reject)=>{
                
                axios[requestType](action, this.data())//[] and . are equal
                
                .then(res => {
                    
                    this.success(res.data);
                    resolve(res.data);

                })
                
                .catch((errors)=>{
                    
                    this.fail(errors);
                    reject(errors.response.data);
                
                })

            });

        }

        reset(){
            
            for(let field in this.originalData){
                this[field] = '';
            }

            this.errors.clear();
        }

        success(data){
            this.reset();
        }

        fail(errors){
            console.log(errors.response.data);
            this.errors.record(errors.response.data.errors);   
        }

        post(url){
            return this.submit('post', url);
        }

        get(url){
            return this.submit('get', url);
        }
    }

    export default {

        props:['origin'],
        
        components:{
            male,
            female
        },

        computed:{
            ages() {
                return this.$store.state.anatomy.ages;
            }
        },

        data(){
            return {
               form: new Form({
                    gender:'1',
                    age:'0-1',
                    location:'',
                    part:'',
                    view:'' 
                }) 
            };
        },
        
        mounted() {
            this.getAges(this.origin);
        },

        methods:{
            
            ...mapActions('anatomy', [
                'FILL_SYMPTOMS_ACTION',
                'getAges',
                'fillPatientInfo'
            ]),

            submit() {
                
                //v-model location not giving correct value

                this.form.location = document.getElementById('location').value;
                this.fillPatientInfo(this.form.data());

                this.form.post(`${this.origin}/fetch-symptoms`)
                .then(data => {
                    this.FILL_SYMPTOMS_ACTION(data);                   
                    this.$router.push({path:'anatomy/symptoms'});
                })
                .catch(errors => {
                    console.log(errors);                    
                });   
            },

            fillPart(part) {
                //filling part and part view from the original male or female[.vue]
                this.form.part = part.id;
                this.form.view = part.view;
            }

        }
        
    }

</script>


<style>

    #organswrapper {
    font-family: Arial, 'Helvetica Neue', Helvetica, sans-serif;
    max-width: 1920px;
    margin: 0 auto;
    padding: 0 0;
    background-color: transparent;
    min-width: 220px;
    -webkit-touch-callout: none;
    -webkit-user-select: none;
    -khtml-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    cursor: default;
}
#organswrapper svg {
    max-height: 100%;
    width: 100%;
    margin: 0;
}
.go_bck, .go_frt, .go_bck_female, .go_frt_female{
    fill: #72B8FC;
    opacity: 0.7;
    -webkit-transition: fill 0.1s ease;
    -moz-transition: fill 0.1s ease;
    -o-transition: fill 0.1s ease;
    transition: fill 0.1s ease;
    cursor: pointer;
}
.go_bck:hover, .go_frt:hover{
    opacity: 1;
}
.organs-tip {
    font: 14px/16px Trebuchet MS, Helvetica, Arial, sans-serif;
    display: none;
    padding: 5px;
    border: 1px solid #404040;
    color: #404040;
    z-index: 1000;
    float: left;
    position: absolute;
    background: rgba(265, 265, 265, 0.9);
    word-break: keep-all;
    box-shadow:1px 2px 4px rgba(0, 0, 0, 0.5);
    -moz-box-shadow:1px 2px 4px rgba(0, 0, 0, 0.5);
    -webkit-box-shadow:1px 2px 4px rgba(0, 0, 0, 0.5);
}
.organs-tip p {
    margin: 0!important;
    color: #404040!important;
}
.organs-tip img {
    float: left;
    padding: 3px;
}
@media screen and (max-width: 320px){
    #organswrapper svg {
        height:260px;
    }
    .organs-tip {
        max-width: 40%;
    }
    .organs-tip img {
        max-width: 95%;
    }
}
@media screen and (max-width: 400px) and (min-width: 321px) {
    #organswrapper svg {
        height:300px;
    }
}
@media screen and (max-width: 480px) and (min-width: 401px) {
    #organswrapper svg {
        height:360px;
    }
}
@media screen and (max-width: 568px) and (min-width: 481px) {
    #organswrapper svg {
        height:440px;
    }
}
@media screen and (max-width: 685px) and (min-width: 569px) {
    #organswrapper svg {
        height:530px;
    }
}
@media screen and (max-width: 767px) and (min-width: 686px) {
    #organswrapper svg {
        height:640px;
    }
}
@media screen and (min-width: 768px) {
    #organswrapper svg {
        height:720px;
    }
}
</style>
