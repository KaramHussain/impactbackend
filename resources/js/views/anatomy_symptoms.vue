<template> 
    <div>  

        <div class="links pointer py-2">
            <router-link tag="button" to="/anatomy">
                <button class="btn btn-light border">
                    Start over
                </button> 
            </router-link>
        </div>

        <p class="text-center text-danger" v-if="max_threshold">Max symptoms selected</p>
        
        <form action="" method="post" @submit.prevent="submit">
            <div class="row justify-content-center">
                
                <div class="col-md-4">
                    
                    <div class="card" >
                        <div class="card-header">
                           Please select body part
                        </div>

                        <div class="card-body models-div" style="height: 450px; overflow:none;">
                            
                            <male :src="origin" v-show="patientInfo.gender == 1" @fillPart="fillPart($event)"></male>
                            <female :src="origin" v-show="patientInfo.gender == 2"  @fillPart="fillPart($event)"></female>
                            
                            <div class="refined" v-if="patientInfo.part=='abdomen' && this.openParts">
                                <refinedParts @closeParts="closeRefineParts" @changePart = "partIsChanged($event)" :url="origin" :part="patientInfo.part"/>
                            </div>
                            
                            <div 
                            class="refined-action-button pointer" 
                            @click="openParts = true"
                            v-if="patientInfo.part=='abdomen' && !this.openParts"    
                            >
                               <a href="javascript:void(0)"> Refine parts in {{patientInfo.part}}</a>
                            </div>

                        </div>

                    </div>

                </div>

                <div class="col-md-4" id="none">
                    
                    <div class="symptoms" style="height:450px;">
                        <div class="card-header border" style="background:#f7f7f7;">
                            Select Symptoms in 
                            <strong>{{patientBodyPart}}</strong>
                           
                            <strong>
                                <span v-if="inner_part">
                                  --
                                  {{inner_part}}
                                </span>
                            </strong>
                            </div>
	                    <div class="form-group symptoms-body">
	                         
	                        <ul 
                            class="list-group"
                            :class="{'pointer-none':max_threshold}"
                            >
	                            
	                            <li :key="symptom.id" class="list-group-item" v-for="(symptom, index) in computed_symptoms">
	                             	{{symptom.name}}
                                     
	                             	<span  @click="openPopup(symptom, index);" v-if="!max_threshold">
	                             	    <i class="fas fa-plus-circle text-success pointer"></i>
                                        +
                                    </span>

	                            </li>
                               
	                        </ul>

	                    </div>
                    
                        <warningModal :data="warning_data"></warningModal>
                            
                        <popup  @showAnswerWarning = "showWarning($event)" v-if="Number(questions.length != 0) && opened" @close="hidePopup($event)" :loading="loading" :questions = "questions"> 
                        </popup>

                	</div>
                    

                </div>

                <div class="col-md-4"> 
                	<div class="card">
                        
                        <div class="card-header">Your choices</div>

                        <div class="p-0 card-body selected_symptoms">
                            
                            <ul class="list-group border-0">
                                <li class="list-group-item" :key="index" v-for="(symptom, index) in selected_symptoms">
                               
                                    {{symptom.name}}
                                    
                                    <span class="pointer" @click="removeSelected(symptom, index)"> 
                                        <i class="fa fa-times-circle text-danger"></i>
                                        &times;
                                    </span>

                                    <span @click="changeQuestions(symptom, index)" class="pointer" v-if="symptom.has_questions">
                                        <i class="fa fa-pencil-alt text-success" title="Edit answers"></i>
                                        edit
                                    </span>
                               
                                </li>                                
                            </ul>

                        </div>

                    </div>
                </div>
                
            </div><!--row-->
            
            <div class="form-group float-right clearfix">
                <input type="submit" class="btn btn-success px-3" value="Next">     
            </div>

        </form>
    
    </div>   
</template>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<script>
    
    import male from './male.vue';
    import female from './female.vue';
    import popup from '../partials/popup.vue';
    import headers from '../partials/header.vue';
    import warningModal from '../partials/warning_modal';
    import refinedParts from '../partials/refinedParts.vue';

    import {mapGetters, mapState, mapActions} from 'vuex';

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
            if (this.errors[field]) {
                delete this.errors[field];
                return;
            }
            this.errors = {};
        }
    }

    class Form {
            
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
            
        }

        post(url){
            return this.submit('post', url);
        }

        get(url){
            return this.submit('get', url);
        }
    }

    export default {
        
        //must add route middleware just in case someone popin into this route

        // beforeRouteEnter(to, from, next){
        //     if (!localStorage.getItem('symptoms')) {
        //         return next({path:'/anatomy'});
        //     }
        //     return next();
        // },

        name:'anatomy-sypmtoms',
        props:['origin'],
        
        components: {
            male,
            female,
            popup,
            headers,
            warningModal,
            refinedParts
        },

        data(){
            return {
                symptoms:{},
                selected_symptoms:[],
                warning_data:{},
                questions:{},
                view:'F',
                part:'chest',
                opened:false,
                loading:false,
                patientInfo:{},
                selected_questions: [],
                openParts:true,
                inner_part:''
            };
        },

        created() {
            this.symptoms = this.defaultSymptoms();
            this.patientInfo = this.loadPatientInfo();
            this.selectPartView();
        },

        computed: { 
    
            patientBodyPart() {
                if(this.patientInfo.hasOwnProperty('part')) {
                    return this.patientInfo.part.charAt(0).toUpperCase() + this.patientInfo.part.slice(1);
                }
                
            },
            
            computed_symptoms: {
                get:function() {
                    return this.symptoms;
                },

                set:function(value) {
                    this.symptoms = value;
                }
            },

            max_threshold() {
                if(this.selected_symptoms.length == 10) {
                    return true;
                }
                return false;
            }
        },

        methods: {
            
            selectPartView() {
                if(this.patientInfo.view == 'B' && this.patientInfo.gender == 1) {
                    $('.frt_base').hide().animate({'opacity':'0'}, 1000);
                    $('.bck_base').show().animate({'opacity':'1'}, 1000);
                }
                else if(this.patientInfo.view == 'F' && this.patientInfo.gender == 1) {
                    $('.bck_base').hide().animate({'opacity':'0'}, 1000);
                    $('.frt_base').show().animate({'opacity':'1'}, 1000);
                }
                else if(this.patientInfo.view == 'F' && this.patientInfo.gender == 2) {
                    $('.bck_base_female').hide().animate({'opacity':'0'}, 1000);
                    $('.frt_base_female').show().animate({'opacity':'1'}, 1000);
                }
                else if(this.patientInfo.view == 'B' && this.patientInfo.gender == 2) {
                    $('.bck_base_female').show().animate({'opacity':'0'}, 1000);
                    $('.frt_base_female').hide().animate({'opacity':'1'}, 1000);
                }
            },

            partIsChanged(info) {
                //document.getElementById('none').style.display = "none";
                
                let id = info.value;
                let inner_part = info.id;

                let url = this.origin;
                let view = this.patientInfo.view;
                let age = this.patientInfo.age;
                let gender = this.patientInfo.gender;
                let location = this.patientInfo.location;
                let part = this.patientInfo.part;
                
                this.inner_part = inner_part;

                if(id == 0) {

                    this.inner_part = '';
                    this.fetchSymptoms(part, view);
                    return;

                }   
                //selected symptoms will be set to empty    
                this.selected_symptoms = [];
                
                this.$store.dispatch('anatomy/getSymptomsFromSubParts', {id, url, age, view, gender, location})
                .then( ()=> {

                    //this.patientInfo.part = parts;
                    
                    localStorage.setItem('patientInfo', JSON.stringify(this.patientInfo)); 
                    let symptoms = this.$store.state.anatomy.symptoms;
                    this.symptoms = symptoms;
                    localStorage.setItem('symptoms', JSON.stringify(symptoms));
                
                }); 
            },

            closeRefineParts() {
                this.openParts = false;
            },

            loadPatientInfo() {

                let info = this.$store.state.anatomy.patientInfo;
                if(this.isEmpty(info, 'part')) {
                    return JSON.parse(localStorage.getItem('patientInfo'));
                }
                return this.$store.state.anatomy.patientInfo;
            
            },

            isEmpty(obj, key) {
                 if(obj.hasOwnProperty(key)) {
                    return false;
                }
                return true;
            },

            showWarning(data) {
                //console.log("data is "+ data);
                this.warning_data = data;
                $("#warningModal").modal('show');
            },

            defaultSymptoms() {
                return JSON.parse(localStorage.getItem('symptoms'));
            },

            fetchSymptoms(part, view) {

                this.inner_part = '';
                //empty the selected symptoms
                this.selected_symptoms = [];
                let url = this.origin;
                
                let age = this.patientInfo.age;
                let gender = this.patientInfo.gender;
                let location = this.patientInfo.location;

                this.$store.dispatch('anatomy/getSymptoms', {part, view, url, age, gender, location})
                .then( ()=> {
                    this.patientInfo.part = part;
                    localStorage.setItem('patientInfo', JSON.stringify(this.patientInfo)); 
                    let symptoms = this.$store.state.anatomy.symptoms;
                    this.symptoms = symptoms;
                    localStorage.setItem('symptoms', JSON.stringify(symptoms));
                }); 
            },

            fillPart(part) {
                //filling part and part view from the original male or female[.vue]
                
                this.part = part.id;
                this.view = part.view;
                this.fetchSymptoms(this.part, this.view);
            
            },

            submit() {
               
                let symptoms = this.selected_symptoms;
                let answers = this.$store.state.anatomy.selected_answers;
                let part = this.patientInfo.part;
                let view = this.patientInfo.view;
                let age = this.patientInfo.age;
                let gender = this.patientInfo.gender;

                //console.log(symptoms, answers, part, view, age, gender);    
               
                let form = new Form({
                    symptoms,
                    answers,
                    part,
                    view,
                    age,
                    gender
                });
                
                
                form.post(`${this.origin}/fetch-diseases`)
                .then((res) => {
                    console.log(res);
                    this.$router.push({name:'cpt-layterms', params: {cpt:res} });
                })
                .catch(()=>{

                });
            },

            current_symptom_questions(symptom) {
                
                var changed_questions = [];

                //if not empty selected questions    
                if(this.selected_questions.length != 0) {
                    var questions_array = this.selected_questions.filter((question) => {
                        if(symptom.id == question.symptom_id) {
                            changed_questions.push(question);
                        }
                    });
                }
            
                //now the popup questions will be the current symptom questions
                
                this.$store.dispatch('anatomy/filteredQuestions', symptom);
                this.questions = this.$store.state.anatomy.questions;
               
            },

            changeQuestions(symptom, index) {
                this.current_symptom_questions(symptom);
                this.opened = true;
            },

            openPopup(symptom, index) {
                
                //checking if symptom has warning then open the warning modal
                if(symptom.warning_text) {
                    this.showWarning(symptom);
                }  
                
                //checking if symptom has questions then open the modal of questions and answers
                if(symptom.has_questions) {
                    this.currentSymptomId = symptom.id;

                    this.opened = true;
                    this.loading = true;

                    let gender = this.patientInfo.gender;
                    let part = this.patientInfo.part;
                    let view = this.patientInfo.view;
                    
                    this.$http.get('/fetch-questions', {
                		params:{
                            id:symptom.id,
                            gender:gender,
                            part:part,
                            view:view,
                        }
                	})
                	.then(response => {
                        
                        //inserting in questions object the current symptom questions
                        this.questions = response.data;
                        let response_questions = [];    
                        //push current question in selected questions
                        for(var questions of response.data) {
                            response_questions.push(questions);
                            this.selected_questions.push(questions);
                            this.$store.dispatch('anatomy/fillQuestions', questions);
                        }
                        //console.log(response_questions);

                        //set loader to false
                        this.loading = false;
    					
                	}, errors => {
                		//console.log(errors);
                        this.loading = false;
                	});
                }
                
                //checking if threshold of max symptoms selcetion reached
                if(!this.max_threshold)
                {
                    //add current index in sypmtom object
                    if(!symptom.hasOwnProperty('index')) {
                        symptom = Object.assign({}, symptom, {index:index});
                    }
                    
                    //fill symtoms which are selected
                    this.selected_symptoms.push(symptom);
                    
                    //remove it from original symptom
                    this.symptoms.splice(index, 1);
                }
            
            },

            hidePopup(event) {
    
            	this.opened = false;
            	//this.selected_questions.push(event);

            },

            removeSelected(symptom, index) {
                
                //remove from selected
                this.selected_symptoms.splice(index, 1);
               
                //define index of symptom
                const sypmtom_index = symptom.index;
               
                //insert into symptoms in specific index
                this.symptoms.splice(sypmtom_index, 0, symptom);

                //remove symptom questions from selected_questions
                
                 if(this.selected_questions.length != 0) {
                    //those questions which have not symptom id matching question.symptom_id will remain those with matching will be remove
                    var questions_array = this.selected_questions.filter((question) => {
                        return symptom.id != question.symptom_id;
                    });

                    //those questions who have matching sypmtom.question_id with symptom.id will be sent to remove selected answers which was to be sent to server 
            
                    var questions_to_remove = this.selected_questions.filter((question) => {
                        return symptom.id == question.symptom_id;
                    });

                    //find and remove answers from selected_answers
                    this.findAnswers(questions_to_remove);

                    this.$store.dispatch('anatomy/removeQuestions', questions_array);
                    this.selected_questions = questions_array;
                }

            },

            findAnswers(questions) {
                this.$store.dispatch('anatomy/removeAnswer', questions);
            },

        },
        mounted(){
           this.$store.dispatch('anatomy/FETCH_SYMTOMPS');
        }
    }
</script>

<style type="text/css">
    .models-div {
        position: relative;
    }
    .refined {
        position:absolute;
        top:0;
        left:0;
        width:100%;
        height:100% !important;
    }
    .refined-action-button {
        position:absolute;
        top:20px;
        right:10px;
    }
    .pointer-none {
        pointer-events:none; 
        background: #f7f7f7 !important;
    }
	.symptoms {
		position:relative;
	}
	.symptoms-body {
		height:450px;
		overflow:auto;
		width:100%;
	}
    .selected_symptoms{
        height:450px;
        overflow:auto;
        width:100%;
    }
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