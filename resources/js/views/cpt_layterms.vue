<div>

    <div class="container my-3">
        
        <div class="card">
            <div class="card-body">
                <div v-if="loading==true">
                    <i class="fa fa-spinner fa-spin"></i>
                </div>
                <div v-if="loading == false">
                    <p>Cpt code <strong>{{cpt.cpt_code}}</strong></p>

                    <h4 v-if="cpt.cpt_code_full_description">Code Description</h4>

                    <p v-html="cpt.cpt_code_full_description"></p>

                    <h4>Treatment Description</h4>

                    <div v-if="cpt.layterms">
                        <h5>Lay Description</h5>
                        <p v-html="cpt.lay_summary"></p>
                    </div>

                    <div v-if="cpt.terminology">
                        <h5>Terminology</h5>
                        <div class="my-2">
                            <p v-html="cpt.terminology"></p>
                        </div>
                    </div>    

                    <div v-if="cpt.section_notes">
                    <h5>Section notes</h5>    
                        <div class="my-2">
                            <p v-html="cpt.section_notes"></p>
                        </div>
                    </div>  

                    <div v-if="cpt.additional_info">
                        <h5>Additional info</h5>
                            
                        <div class="my-2">
                            <p v-html="cpt.additional_info"></p>
                        </div>
                    </div>

                    <div v-if="cpt.coding_tips">

                        <h5>Tips</h5>
                        
                        <div class="my-2">
                            <p v-html="cpt.coding_tips"></p>
                        </div>

                    </div>

                    <router-link :to="{path:`/shouldice/questions`}" class="btn btn-success my-5">
                        Proceed
                    </router-link>

                    <div title="Virtual scribe" class="virtual-scribe" data-toggle="modal" data-target="#hpiModal">
                        <span class="">
                            <img class="virtual-scribe__img" src="/svg/icons/svg/nurse.svg" alt="Image">
                        </span>
                    </div>

                    <div class="modal" tabindex="-1" role="dialog" id="hpiModal">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                
                                <div class="modal-header">
                                    <div class="modal-title"> 
                                        
                                        <h4>Welcome to Virtual Scribe</h4>
                                            <!-- <span class="icon circle "> 
                                                <img class="" src="/svg/icons/svg/024-medical-history.svg" alt="Hpi medical history">  
                                            </span>   -->
                                    </div>
                                    <button type="button" @click="close" class="close text-danger pointer" data-dismiss="modal" aria-label="Close">
                                        <i class="fas fa-times-circle"></i>
                                    </button>
                                </div>
                                
                                <div class="modal-body">
                                    
                                    <div v-if="step==1">
                                        <h5>Location</h5>
                                        
                                        <div class="form-group">
                                            
                                            <p>What is the site of the problem? </p>
                                            
                                            <select class="form-control" v-model="hpi.location" @change="checkPart">
                                                <option value="0">Please select</option>
                                                <option :value="part.name" :key="part.id" v-for="part in parts">
                                                    {{part.name}} ({{part.view}})
                                                </option>
                                            </select>

                                        </div>

                                        <div class="form-group" v-if="hpi.bilateral">
                                            <p>Which side exactly are you feeling pain?</p>
                                            <input type="radio" name="location-bilateral" id="location-left" value="left" v-model="hpi.location_bilateral">
                                            <label for="location-left">Left
                                                <span class="radio-button"></span>
                                            </label>
                                            <input type="radio" name="location-bilateral" id="location-right" value="right" v-model="hpi.location_bilateral">
                                            <label for="location-right">Right
                                                <span class="radio-button"></span>
                                            </label>
                                            <input type="radio" name="location-bilateral" id="location-both" value="both" v-model="hpi.location_bilateral">
                                            <label for="location-both">Both
                                                <span class="radio-button"></span>
                                            </label>
                                        </div>
                                    </div>

                                    <div v-if="step==2">

                                        <h5>Quality</h5>

                                        <div class="form-group">
                                            <p>What is the nature of the pain?</p>
                                            <input type="radio" name="nature" v-model="hpi.nature_of_pain" id="nature-constant" value="constant">
                                            <label for="nature-constant">Constant
                                                <span class="radio-button"></span>
                                            </label>

                                            <input type="radio" id="nature-acute" name="nature" v-model="hpi.nature_of_pain" value="acute">
                                            <label for="nature-acute">Acute
                                                <span class="radio-button"></span>
                                            </label> 

                                            <input type="radio" name="nature" v-model="hpi.nature_of_pain" id="nature-chronic" value="chronic">
                                            <label for="nature-chronic">Chronic
                                                <span class="radio-button"></span>
                                            </label>   

                                            <input type="radio" name="nature" v-model="hpi.nature_of_pain" id="nature-improved" value="improved">
                                            <label for="nature-improved">Improved
                                                <span class="radio-button"></span>
                                            </label>   

                                            <input type="radio" name="nature" v-model="hpi.nature_of_pain" id="nature-worsening" value="worsening">
                                            <label for="nature-worsening">Worsening
                                                <span class="radio-button"></span>
                                            </label>     
                                        </div>
                                    </div>

                                    <div v-if="step==3">
                                        <h5>Severity</h5>

                                        <div class="form-group">
                                            <p>
                                                Describe the pain or redness, on a scale of 1 to 10, with 10 being the worst.
                                            </p>   
                                       
                                            <input style="display:inline-block;" type="range" @change="changeSeverity" class="slider" id="myRange" min="1" max="10" v-model="hpi.pain_bar" list="numbers"/>

                                            <!-- <datalist id="numbers">
                                                <option>3</option>  
                                                <option>7</option>
                                            </datalist> -->
                                        
                                        </div>
                                    </div>
                                    
                                    <div v-if="step==4">

                                        <h5>Duration</h5>    

                                        <p>How long has the problem been an issue?</p>
                                        
                                        <div class="row">
                                            
                                            <div class="form-group col-sm-6">
                                                <label>From</label>
                                                <input v-model="hpi.from_time" type="datetime-local" class="form-control" id="fromTime">
                                            </div>

                                            <div @click="set_present = false" v-if="set_present" class="form-group col-sm-6">
                                                <label>To</label>
                                                <input v-model="hpi.to_time" type="text" class="form-control to-present" value="Till present">  
                                            </div>

                                            <div v-if="!set_present" class="form-group col-sm-6">
                                                <label>To</label>
                                                <input v-model="hpi.to_time" type="time" class="form-control time-input"> 
                                                <i @click="set_present=true" class="fas fa-times-circle text-danger pointer"></i>
                                            </div>

                                        </div>

                                    </div>

                                    <!-- <div v-if="step==5">

                                        <h5>Timing</h5>

                                        <div class="form-group">
                                            
                                            <p>The problem gets worst in?</p>
                                            
                                            <input type="radio" name="timing" v-model="hpi.timing" id="timing-morning" value="morning">
                                            <label for="timing-morning">Morning
                                                <span class="radio-button"></span>
                                            </label> 

                                            <input type="radio" name="timing" v-model="hpi.timing" id="timing-evening" value="evening">
                                            <label for="timing-evening">Evening
                                                <span class="radio-button"></span>
                                            </label> 

                                            <input type="radio" name="timing" v-model="hpi.timing" id="timing-constant" value="constant">
                                            <label for="timing-constant">Its constant
                                                <span class="radio-button"></span>
                                            </label>                                              
                                        </div>
                                    </div>

                                    <div v-if="step==6">    
                                        <h5>Context</h5>
                                        <div class="form-group">

                                            <p>Is it associated with any activity?</p>
                                            
                                            <input type="radio" name="activity" v-model="hpi.activity" id="activity-yes" value="yes">
                                            <label for="activity-yes">Yes
                                                <span class="radio-button"></span>
                                            </label>

                                            <input type="radio" name="activity" v-model="hpi.activity" id="activity-no" value="no">
                                            <label for="activity-no">No
                                                <span class="radio-button"></span>
                                            </label>      

                                        </div>

                                        <div class="form-group" v-if="hpi.activity == 'yes'">
                                            <label for="activity-explained">Please explain?</label>
                                            <textarea class="form-control" id="activity-explained" placeholder="Explain what activity cause this problem" v-model="hpi.activity_explained"></textarea>
                                        </div>
                                    </div>

                                    <div v-if="step==7">

                                        <h5>Modifying Factors</h5>

                                        <div class="form-grou">
                                            <p> What efforts have you made to improve the problem?</p>
                                        </div>

                                        <div class="form-group">
                                            <label for="factors-other-explained">Please explain?</label>
                                            <textarea v-model="hpi.factors_other_explained" class="form-control" id="factors-other-explained"></textarea>
                                        </div>
                                    </div>

                                    <div v-if="step==8">

                                        <h5>Associated signs and symptoms</h5>
                                        <p>There will be associated sign and symptoms</p>
                                    
                                    </div> -->

                                    <div v-if="step==5">
                                        <h4 class="d-inline-block">Chief complain</h4>
                                        <div title="Add more complains" class="icon__add-more d-inline-block" @click="storeComplain">
                                            <i class="fas fa-plus"></i>
                                        </div>
                                        <div class="clearfix"></div>
                                        
                                        <ul class="list-group">        
                                            <li class="list-group-item" v-for="(hpi, index) in cc" :key="index">
                                                
                                                <span v-if="index == 0">
                                                  <strong>Primary complain</strong>
                                                </span>
                                                
                                                <span v-if="index != 0">
                                                  <strong>Secondary complain</strong>
                                                </span>

                                                Patient complains of {{hpi.location}}
                
                                                <span v-if="hpi.bilateral">
                                                    in {{hpi.location_bilateral}} 
                                                    <span v-if="hpi.location_bilateral =='both'">sides</span><span v-else>side</span>.
                                                </span>

                                            </li>
                                        </ul> 

                                    </div>

                                    <div v-if="step==6">
                                        <h4>Thankyou</h4>
                                        <p>
                                            Your provided information is important for us and your doctor.
                                        </p>
                                       
                                        <div class="card m-2" v-for="(complain, index) in cc" :key="index">
                                            
                                            <h5 class="card-header" v-if="index == 0">
                                                <strong>Primary complain</strong>
                                            </h5>
                                                
                                            <h5 class="card-header" v-if="index != 0">
                                                <strong>Secondary complain</strong>
                                            </h5>
                                            
                                            <div class="card-body">
                                                
                                                Patient complains of {{complain.location}}
                
                                                <span v-if="complain.bilateral">
                                                    in {{complain.location_bilateral}} 
                                                    <span v-if="complain.location_bilateral =='both'">sides</span><span v-else>side</span>.
                                                </span>

                                                <div class="nature">
                                                    Nature of pain: {{complain.nature_of_pain}}
                                                </div>

                                                <div class="pain_severity">
                                                    Pain severity: {{complain.pain_bar}}
                                                </div>

                                                <div class="time">
                                                    Pain Duration:<br>
                                                     From :{{complain.from_time}}
                                                     To : {{complain.to_time}}
                                                </div>  
                                                
                                            </div>

                                        </div>
                                    </div>
                                </div><!--modal-body-->
                                
                                <div class="modal-footer">
                                    
                                    <div v-if="step!=6">
                                        <button v-if="step!=1" class="btn btn-default left" @click="decrementStep">
                                            Previous
                                        </button>

                                        <button v-if="step!=5" class="btn btn-success right" @click="incrementStep">
                                            Next
                                        </button>
                                    </div>

                                    <button @click="showThankyou" v-if="step==5" class="btn btn-success right">
                                        Finish
                                    </button>

                                    <button v-show="step==6" type="button" class="btn btn-danger" data-dismiss="modal">
                                        Close
                                    </button>

                                </div>

                            </div>
                        </div>
                    </div>  

                </div>

            </div><!--card-body-->
        </div><!--card-->

        
    </div>
</div>

<script>
export default {
    
    data() {
        return {
            cpt:{},
            loading:false,
            parts:{},
            step: 1,
            set_present:true,
            hpi: {
                location:'0',
                bilateral:false,
                location_bilateral:'both',
                nature_of_pain:'constant',
                pain_bar:'0',
                to_time:'present',
                from_time:''
            },
            cc:[]
        };
    },

    computed: {

        terminology() {
            
            let term = this.cpt.terminology;
            
            let terminology = term.split(':');

            console.log(terminology);

        }
    },
    created() {
        this.fetchData();
        this.fetchParts();
    },
    methods: {
        
        showThankyou() {
            this.step = 6;
            this.finishSetup();
        },

        storeComplain() {
            //start from the step1
            this.step = 1;
            
            //pop that part which has been compaint of!
            var parts = this.parts.filter((part) => {
                return part.name != this.hpi.location;
            });
            
            //assign updated parts to this.parts
            this.parts = parts;
            //reset all data    
            this.resetHpi();
        },

        finishSetup() {
            //this.cc.push(this.hpi);
            this.resetHpi();
        },

        resetHpi() {
            this.hpi.location = 0;
            this.hpi.bilateral = false;
            this.hpi.location_bilateral = 'both';
            this.hpi.nature_of_pain = 'constant',
            this.hpi.pain_bar='1',
            this.hpi.to_time = '',
            this.hpi.from_time = ''
        },

        changeSeverity() {
            
            var x = document.getElementById('myRange');
           
            if (this.hpi.pain_bar == '1' || this.hpi.pain_bar == '2' || this.hpi.pain_bar == '3') {
                x.style.background = '-webkit-linear-gradient(to right bottom, #56ab2f, #55c57a)';
                x.style.background = 'linear-gradient(to right bottom, #56ab2f, #55c57a)';
            }

            else if (this.hpi.pain_bar == '4' || this.hpi.pain_bar == '5' || this.hpi.pain_bar == '6' || this.hpi.pain_bar == '7') {
                x.style.background = '-webkit-linear-gradient(-60deg, #f09819 0%, #ff5858 100%)';
                x.style.background = 'linear-gradient(-60deg, #f09819 0%, #ff5858 100%)';
            }

            else if (this.hpi.pain_bar == '8' || this.hpi.pain_bar == '9' || this.hpi.pain_bar == '10') {
                x.style.background = '#D31027';
                x.style.background = '-webkit-linear-gradient(to bottom, #ff416c, #ff4b2b)';
                x.style.background = 'linear-gradient(to bottom, #ff416c, #ff4b2b)';   
            }
        },

        incrementStep() {
            if(this.step == 4) {
                this.pushHpi();
            }

            if(this.step != 5) {
                this.step += 1; 
            }
        },

        pushHpi() {
            if(this.hpi.location !=0) {
                if(!this.locationExists()) {
                    let ccData = {};
                    //clone hpi data and assign to ccData
                    Object.assign(ccData, this.hpi);
                    //hpi.to_time
                    this.hpi.from_time = document.getElementById('fromTime').value;
                    console.log(document.getElementById('fromTime').value);
                    //push ccData to cc
                    this.cc.push(ccData);
                }
            }
        },

        locationExists() {
            var location = this.hpi.location;
            var exists = false;
            //if current complain's location exists in cc then return exists true  
            this.cc.filter((objs) => {
                if(location == objs.location) {
                    exists = true;
                }
            });
            return exists;
        },

        decrementStep() {
            if(this.step != 1) {
                this.step -= 1; 
            }
        },

        fetchData() {
            //fetch Data before page loads
            this.loading = true;
            let cpt = this.$route.params.cpt;
            axios.post('/anatomy/cpt_layterms', {
                cpt:cpt
            })
            .then((res) => {
                this.cpt = res.data[0];
                this.loading = false;
            })
            .catch((error) => {
                this.loading = false;
            });
        },

        fetchParts() {
            axios.post('/parts-all')
            .then((res) => {
                this.parts = res.data;
            })
            .catch((error) => {
            });
        },
        
        close() {

        },

        checkPart() {
            
            var parts = ['eyes', 'ear', 'shoulder', 'upper arm', 'elbow', 'fore arm', 'wrist', 'fingers', 'armpit', 'palm', 'toes', 'sole', 'ankle', 'calf', 'thigh', 'knee', 'shin', 'groin', 'hip', 'buttock', 'hamstring', 'upper abdomen', 'lower abdomen'];
    
            var part = this.hpi.location.toLowerCase();

            if(parts.indexOf(part) == -1) {
                this.hpi.bilateral = false;
            }

            else {
                this.hpi.bilateral = true;
            }
        }
    }
}
</script>

<style scoped lang=scss>
   
    .pointer {
        cursor:pointer;
    }
    .virtual-scribe {
        width:50px;
        height:50px;
        background-image: linear-gradient(purple, #c02bc0);
        border-radius:50%;
        display:block;
        position:fixed;
        bottom:5%;
        right:5%;
        overflow: hidden;
        box-shadow: 1px 3px 5px rgba(0,0,0,0.4);
        transition:all 0.3s;


        &:hover {
            box-shadow:0 6px 10px rgba(0,0,0,0.4);
            cursor:pointer;
        }

        &:active, 
        &:focus {
            box-shadow:0 4px 6px rgba(0,0,0,0.4);
            transform:translateY(4px);
        }

        &__img {
            width:70%;
            height:70%;
            position: absolute;
            top:50%;
            left:50%;
            transform:translate(-50%, -50%);
        }
    }
    .left {
        float:left;
    }
    .right {
        float:right;
    }
    .btn {
        box-shadow: 0 3px 8px rgba(0,0,0,0.4);
        border:0;
        outline:none;
        &:active,
        &:focus {
            transform:translateY(-1px);
            box-shadow:0 1 4px rgba(0,0,0,0.2);
        }
    }
    .slider {
        -webkit-appearance: none;
        width:100%;
        height:15px;
        border-radius: 5px;
        background: linear-gradient(to right bottom, #28b485, #55c57a);
        outline: none;
        /* opacity: 0.7; */
        -webkit-transition: .2s;
        transition: all .2s;
        
        /* &:hover {
            opacity: 1;
        } */

    }
   
    .slider::webkit-slider-thumb {
        -webkit-appearance: none;
        appearance: none;
        width: 25px;
        height: 25px;
        border-radius: 50%;
        background:linear-gradient(to right bottom, #28b485, #55c57a);
        cursor: pointer;
    }

    .slider::-moz-range-thumb {
        width: 25px;
        height: 25px;
        border-radius: 50%;
        background:linear-gradient(to right bottom, #28b485, #55c57a);
        cursor: pointer;
    }
    .slider::-moz-slider-thumb::before,
    .slider::webkit-slider-thumb::before {
        content:'80%';
    }

    .icon__add-more {
        width:30px;
        height:30px;
        background: white;
        box-shadow:0 1px 4px rgba(0,0,0,0.2) !important;
        border-radius:50%;
        cursor:pointer;
        color:#222;
        position:relative;
        transition:all 0.3s;
        
        i {
            position:absolute;
            top:50%;
            left:50%;
            transform: translate(-50%, -50%);
            font-size:15px;
        }

        &:hover {
            box-shadow:0 3px 6px rgba(0,0,0,0.4) !important;
        }
        &:focus,
        &:active {
            box-shadow:0 1px 3px rgba(0,0,0,0.2) !important;
            transform: translateY(2px);
        }
    }
    #numbers {
        display:inline-block;
    }
    .to-present {
        pointer-events:none;
        opacity:0.9;
    }
    .time-input {
        position:relative;
    }
    .time-input ~ i {
        position:absolute;
        top:63%;
        right:8%;
        cursor:pointer;
        /* transform:translateY(-50%); */
    }
</style>
