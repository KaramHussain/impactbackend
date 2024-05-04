<div>
    <div class="main">

        <h2 class="my-3">Treatment Details</h2>
        
        <div class="card my-3">
            
            <div class="row">
                
                <div class="card-left col-sm-4 text-center">
                    
                    <div v-if="step==1">
                        <div class="flat__icon">
                            <img src="/svg/icons/svg/004-patient-5.svg" alt="Icon" class="flat__icon__img">
                        </div>
                        
                        <h3 class="my-3">
                            Your medical Info
                        </h3>

                        <p class="my-1">
                            Please we need some medical information.
                        </p>
                        
                    </div>

                    <div v-if="step==2">
                        
                        <div class="flat__icon">
                            <img src="/svg/icons/svg/024-medical-history.svg" alt="Icon" class="flat__icon__img">
                        </div>
                        
                        <h3 class="my-3">
                            Your medical history
                        </h3>

                        <p class="my-1">
                            Please provide us little history.
                        </p>

                    </div> 

                    <div v-if="step==3">
                        
                        <div class="flat__icon">
                            <img src="/svg/icons/svg/010-patient-1.svg" alt="Icon" class="flat__icon__img">
                        </div>
                        
                        <h3 class="my-3">
                            Your medical history
                        </h3>

                        <p class="my-1">
                            A few more questions about your medical history.
                        </p>

                    </div> 

                    <div v-if="step==4">
                        
                        <div class="flat__icon">
                            <img src="/svg/icons/svg/030-patient.svg" alt="Icon" class="flat__icon__img">
                        </div>
                        
                        <h3 class="my-3">
                            Your medical history
                        </h3>

                        <p class="my-1">
                            A few more questions about your medical history.
                        </p>

                    </div> 

                    <div v-if="step==5">
                        
                        <div class="flat__icon">
                            <img src="/svg/icons/svg/022-medicines.svg" alt="Icon" class="flat__icon__img">
                        </div>
                        
                        <h3 class="my-3">
                            Your medical history
                        </h3>

                        <p class="my-1">
                            A few more questions about your medical history.
                        </p>

                    </div> 

                    <div v-if="step==6">
                        
                        <div class="flat__icon">
                            <img src="/svg/icons/svg/lens.svg" alt="Icon" class="flat__icon__img">
                            <img src="/svg/icons/svg/lost-tooth.svg" alt="Icon" class="flat__icon__img">
                        </div>
                

                    </div> 

                    <div v-if="step==7">
                        
                        <div class="flat__icon">
                            <img src="/svg/icons/svg/001-no-smoking.svg" alt="Icon" class="flat__icon__img">
                            <img src="/svg/icons/svg/wine-bottle.svg" alt="Icon" class="mt-5 flat__icon__img">
                        </div>
                        
                    </div> 

                    <div v-if="step==8">
                        
                        <div class="flat__icon">
                            <img src="/svg/icons/svg/home.svg" alt="Icon" class="flat__icon__img">
                        </div>
                        
                        <h3 class="my-3 d-inline-block">
                            Few more
                        </h3>

                        <p class="my-1">
                            A few more questions about your living style...
                        </p>

                    </div> 

                    <div v-if="step==9">
                        
                        <div class="flat__icon">
                            <img src="/svg/icons/svg/016-radiation.svg" alt="Icon" class="flat__icon__img">
                            <img src="/svg/icons/svg/021-bicycle.svg" alt="Icon" class="flat__icon__img">
                        </div>

                    </div> 

                    <div v-if="step==10">
                        
                        <div class="flat__icon">
                            <img src="/svg/icons/svg/020-healing.svg" alt="Icon" class="flat__icon__img">
                        </div>
                        
                        <h3 class="my-3 d-inline-block">
                            Rate your Health 
                        </h3>

                        <p class="my-1">
                            How is your health?
                        </p>

                    </div> 

                </div>

                <div class="card-right col-sm-8"> 
                    <div class="card-body">
                        <!-- <h3 class="my-3 d-inline-block">
                            Your medical history
                        </h3> -->
                        <span class="text-muted">
                            <span class="page_counter clearfix">{{step}}/10</span>
                        </span>
                        
                        <div v-show="step==1">
                            
                            <h4 class="my-3 mt-1 text-dark">Give us Information about Hernia.</h4>

                            <div class="form-group">
                                
                                <p>Do you have a referral?</p>

                                <input type="radio" name="referral" id="referral_yes" value="on" v-model="step1.referral">
                                <label for="referral_yes">Yes
                                    <span class="radio-button"></span>
                                </label>

                                <input type="radio" name="referral" id="referral_no" value="off" v-model="step1.referral">
                                <label for="referral_no">No
                                    <span class="radio-button"></span>
                                </label>

                            </div>
                              
                            <div v-if="step1.referral == 'on'" class="row" style="margin:0;padding:0;">
                               <div class="col form-group">
                                   <label for="referral_name">Name</label>
                                   <input placeholder="Referral name" type="text" id="referral_name" v-model="step1.referral_name" class="form-control">
                               </div>
                                <div class="col form-group">
                                   <label for="referral_email_or_phone">Email or phone</label>
                                   <input placeholder="Referral email or phone" type="text" id="referral_email_or_phone" v-model="step1.referral_email_or_phone" class="form-control">
                               </div>
                            </div>
                            

                            <div class="form-group">
                                
                                <p>Hernia identified has been diagnosed by a medical doctor.</p>

                                <input type="radio" name="hernia_diagnosed" id="hernia_diagnosed_yes" value="on" v-model="step1.hernia_diagnosed">
                                <label for="hernia_diagnosed_yes">Yes
                                    <span class="radio-button"></span>
                                </label>

                                <input type="radio" name="hernia_diagnosed" id="hernia_diagnosed_no" value="off" v-model="step1.hernia_diagnosed">
                                <label for="hernia_diagnosed_no">No
                                    <span class="radio-button"></span>
                                </label>

                            </div>

                            <div class="form-group" v-if="step1.hernia_diagnosed == 'on'">
                                
                                <p>How?</p>

                                <input type="radio" name="hernia_diagnosed_how" id="hernia_diagnosed_physical_exam" v-model="step1.hernia_diagnosed_how" value="physical_exam">
                                <label for="hernia_diagnosed_physical_exam">Physical Exam
                                    <span class="radio-button"></span>
                                </label>

                                <input type="radio" name="hernia_diagnosed_how" id="hernia_diagnosed_ultrasound" value="ultrasound" v-model="step1.hernia_diagnosed_how">
                                <label for="hernia_diagnosed_ultrasound">Ultrasound
                                    <span class="radio-button"></span>
                                </label>

                                <input type="radio" name="hernia_diagnosed_how" id="hernia_diagnosed_other" value="other" v-model="step1.hernia_diagnosed_how">
                                <label for="hernia_diagnosed_other">Other
                                    <span class="radio-button"></span>
                                </label>
                                
                                <div v-if="step1.hernia_diagnosed_how == 'other'">    
                                    <label for="hernia_diagnosed_no">Please define other<br></label>
                                    <input class="form-control" type="text" name="hernia_diagnosed_other" id="hernia_diagnosed_other" v-model="step1.hernia_diagnosed_other_text">
                                </div>

                            </div>

                            <div class="form-group">

                                <p>Suffering from chronic pain from hernia.</p>

                                <input type="radio" name="hernia_chronic_pain" id="hernia_chronic_pain_yes" value="on" v-model="step1.hernia_chronic_pain">
                                <label for="hernia_chronic_pain_yes">Yes
                                    <span class="radio-button"></span>
                                </label>

                                <input type="radio" name="hernia_chronic_pain" id="hernia_chronic_pain_no" value="off" v-model="step1.hernia_chronic_pain">
                                <label for="hernia_chronic_pain_no">No
                                    <span class="radio-button"></span>
                                </label>

                            </div>

                            <div v-if="step1.hernia_chronic_pain == 'on'">
                                
                                <div class="form-group">
                                    <p>
                                        Describe the pain, on a scale of 1 to 10, with 10 being the worst.
                                    </p>   
                                    <!-- @change="changeSeverity(step1.hernia_chronic_pain_bar, 'myRange')" -->
                                    <input type="range" class="slider" id="myRange" min="1" max="10" value="1" v-model="step1.hernia_chronic_pain_bar" :title="step1.hernia_chronic_pain_bar"/>
                                
                                </div>
                                
                                <p>Start and end time</p>

                                <div class="row">
                                    
                                    <div class="form-group col-sm-6">
                                        <label>From</label>
                                        <input v-model="step1.hernia_chronic_pain_from_time" type="datetime-local" class="form-control">
                                    </div>

                                    <div @click="set_present = false" v-if="set_present" class="form-group col-sm-6">
                                        <label>To</label>
                                        <input v-model="step1.hernia_chronic_pain_to_time" type="text" class="form-control to-present" value="Till present">  
                                    </div>

                                    <div v-if="!set_present" class="form-group col-sm-6">
                                        <label>To</label>
                                        <input v-model="step1.hernia_chronic_pain_to_time" type="time" class="form-control time-input"> 
                                        <i @click="set_present=true" class="fas fa-times-circle text-danger pointer"></i>
                                    </div>

                                </div>

                            </div>

                            <div class="form-group">

                                <p>Suffering from chronic pain from previous hernia repair.</p>

                                <input type="radio" name="hernia_chronic_pain_prev" id="hernia_chronic_pain_prev_yes" value="on" v-model="step1.hernia_chronic_pain_prev">
                                <label for="hernia_chronic_pain_prev_yes">Yes
                                    <span class="radio-button"></span>
                                </label>

                                <input type="radio" name="hernia_chronic_pain_prev" id="hernia_chronic_pain_prev_no" value="off" v-model="step1.hernia_chronic_pain_prev">
                                <label for="hernia_chronic_pain_prev_no">No
                                    <span class="radio-button"></span>
                                </label>

                            </div>

                            <div v-if="step1.hernia_chronic_pain_prev == 'on'">
                                
                                <div class="form-group">
                                    <p>
                                        Describe the pain or redness, on a scale of 1 to 10, with 10 being the worst.
                                    </p>   
                                    <!-- @change="changeSeverity(step1.hernia_chronic_pain_bar, 'myRange')" -->
                                    <input type="range" class="slider" id="myRange3" min="1" max="10" value="1" v-model="step1.hernia_chronic_pain_prev_bar" :title="step1.hernia_chronic_pain_prev_bar"/>
                                
                                </div>
                                
                                <p>Start and end time</p>

                                <div class="row">
                                    
                                    <div class="form-group col-sm-6">
                                        <label>From</label>
                                        <input v-model="step1.hernia_chronic_pain_prev_from_time" type="datetime-local" class="form-control">
                                    </div>

                                    <div @click="set_present = false" v-if="set_present" class="form-group col-sm-6">
                                        <label>To</label>
                                        <input v-model="step1.hernia_chronic_pain_prev_to_time" type="text" class="form-control to-present" value="Till present">  
                                    </div>

                                    <div v-if="!set_present" class="form-group col-sm-6">
                                        <label>To</label>
                                        <input v-model="step1.hernia_chronic_pain_prev_to_time" type="time" class="form-control time-input"> 
                                        <i @click="set_present=true" class="fas fa-times-circle text-danger pointer"></i>
                                    </div>

                                </div>

                            </div>

                            <div class="form-group">

                                <p>Experienced a wound infection in any previous surgery.</p>

                                <input type="radio" name="wound_infecfion" id="wound_infecfion_yes" v-model="step1.wound_infecfion" value="on">
                                <label for="wound_infecfion_yes">Yes
                                    <span class="radio-button"></span>
                                </label>

                                <input type="radio" name="wound_infecfion" id="wound_infecfion_no" v-model="step1.wound_infecfion" value="off">
                                <label for="wound_infecfion_no">No
                                    <span class="radio-button"></span>
                                </label>

                            </div>

                             <div class="form-group">
                               
                                <p> Was mesh used in your other prior hernia repair? </p>
                                
                                <input type="radio" name="hernia_repair_mesh" id="hernia_repair_mesh_yes" value="on" v-model="step1.hernia_repair_mesh">
                                <label for="hernia_repair_mesh_yes">Yes
                                    <span class="radio-button"></span>
                                </label>

                                <input type="radio" name="hernia_repair_mesh" id="hernia_repair_mesh_no" value="off" v-model="step1.hernia_repair_mesh">
                                <label for="hernia_repair_mesh_no">No
                                    <span class="radio-button"></span>
                                </label>

                                <input type="radio" name="hernia_repair_mesh" id="hernia_repair_mesh_dont_know" value="unaware" v-model="step1.hernia_repair_mesh">
                                <label for="hernia_repair_mesh_dont_know">Don't Know
                                    <span class="radio-button"></span>
                                </label>

                            </div>

                        </div>

                        <div v-show="step==2">
                        
                            <h4 class="my-4">Your medical history</h4>

                            <div class="form-group">
                               
                                <p> An abnormal reaction to a local or general anesthetic or history of malignant.</p>
                                
                                <input type="radio" name="abnormal_reaction_anesthetic" id="abnormal_reaction_anesthetic_yes" value="yes" v-model="step2.abnormal_reaction_anesthetic">
                                <label for="abnormal_reaction_anesthetic_yes">Yes
                                    <span class="radio-button"></span>
                                </label>

                                <input type="radio" name="abnormal_reaction_anesthetic" id="abnormal_reaction_anesthetic_no" value="no" v-model="step2.abnormal_reaction_anesthetic">
                                <label for="abnormal_reaction_anesthetic_no">No
                                    <span class="radio-button"></span>
                                </label>

                            </div>

                           
                            <div class="form-group">
                               
                                <p> A family member who has had an abnormal reaction to anesthetic. </p>
                                
                                <input type="radio" name="family_abnormal_reaction_anesthetic" id="family_abnormal_reaction_anesthetic_yes" value="yes" v-model="step2.family_abnormal_reaction_anesthetic">
                                <label for="family_abnormal_reaction_anesthetic_yes">Yes
                                    <span class="radio-button"></span>
                                </label>

                                <input type="radio" name="family_abnormal_reaction_anesthetic" id="family_abnormal_reaction_anesthetic_no" value="no" v-model="step2.family_abnormal_reaction_anesthetic">
                                <label for="family_abnormal_reaction_anesthetic_no">No
                                    <span class="radio-button"></span>
                                </label>

                            </div>

                            <div class="form-group">
                               
                                <p> Heart trouble, heart attack, angina, mechanical valves, or irregular heartbeat. </p>
                                
                                <input type="radio" name="heart_trouble" id="heart_trouble_yes" v-model="step2.heart_trouble" value="yes">
                                <label for="heart_trouble_yes">Yes
                                    <span class="radio-button"></span>
                                </label>

                                <input v-model="step2.heart_trouble" value="no" type="radio" name="heart_trouble" id="heart_trouble_no">
                                <label for="heart_trouble_no">No
                                    <span class="radio-button"></span>
                                </label>

                            </div>

                            <div v-if="step2.heart_trouble == 'yes'">
                                
                                <div class="form-group">
                                    <p>
                                        Describe the pain or redness, on a scale of 1 to 10, with 10 being the worst.
                                    </p>   
                                    <!--  -->
                                    <!-- onchange="changeSeverity()" -->
                                    <!-- @change="changeAnotherSeverity(step2.heart_trouble_pain_bar)" -->
                                    <input type="range" class="slider" id="myRange2" min="1" max="10" value="1" v-model="step2.heart_trouble_pain_bar" :title="step2.heart_trouble_pain_bar"/>
                                
                                </div>
                                
                                <p>Start and end time</p>

                                <div class="row">
                                    
                                    <div class="form-group col-sm-6">
                                        <label>From</label>
                                        <input v-model="step2.heart_trouble_from_time" type="datetime-local" class="form-control">
                                    </div>

                                    <div @click="set_present = false" v-if="set_present" class="form-group col-sm-6">
                                        <label>To</label>
                                        <input v-model="step2.heart_trouble_to_time" type="text" class="form-control to-present" value="Till present">  
                                    </div>

                                    <div v-if="!set_present" class="form-group col-sm-6">
                                        <label>To</label>
                                        <input v-model="step2.heart_trouble_to_time" type="time" class="form-control time-input"> 
                                        <i @click="set_present=true" class="fas fa-times-circle text-danger pointer"></i>
                                    </div>

                                </div>

                            </div>

                            <div class="form-group">
                               
                                <p> An abnormal blood pressure, high or low? </p>
                                
                                <input type="radio" name="abnormal_blood_pressure" id="abnormal_blood_pressure_yes" v-model="step2.abnormal_blood_pressure" value="yes">
                                <label for="abnormal_blood_pressure_yes">Yes
                                    <span class="radio-button"></span>
                                </label>

                                <input type="radio" name="abnormal_blood_pressure" id="abnormal_blood_pressure_no" v-model="step2.abnormal_blood_pressure" value="no">
                                <label for="abnormal_blood_pressure_no">No
                                    <span class="radio-button"></span>
                                </label>

                                <input type="radio" name="abnormal_blood_pressure" id="abnormal_blood_pressure_dont_know"
                                v-model="step2.abnormal_blood_pressure" value="unaware">
                                <label for="abnormal_blood_pressure_dont_know">Don't Know
                                    <span class="radio-button"></span>
                                </label>

                            </div>
                        </div>

                        <div v-if="step==3">    

                            <div class="form-group">
                               
                                <p> Medicine for your heart or high blood pressure? </p>
                                
                                <input type="radio" name="medicine_for_your_heart"
                                value="on" v-model="step3.medicine_for_your_heart" id="medicine_for_your_heart_yes">
                                <label for="medicine_for_your_heart_yes">Yes
                                    <span class="radio-button"></span>
                                </label>

                                <input type="radio" name="medicine_for_your_heart"
                                value="off" v-model="step3.medicine_for_your_heart" id="medicine_for_your_heart_no">
                                <label for="medicine_for_your_heart_no">No
                                    <span class="radio-button"></span>
                                </label>

                            </div>

                            <div class="form-group">
                               
                                <p> Difficulty with breathing or had unusual tiredness or weakness? </p>
                                
                                <input type="radio" name="difficulty_with_breathing"
                                v-model="step3.difficulty_with_breathing"
                                value="on" id="difficulty_with_breathing_yes">
                                <label for="difficulty_with_breathing_yes">Yes
                                    <span class="radio-button"></span>
                                </label>

                                <input type="radio" name="difficulty_with_breathing" 
                                v-model="step3.difficulty_with_breathing"
                                value="off"
                                id="difficulty_with_breathing_no">
                                <label for="difficulty_with_breathing_no">No
                                    <span class="radio-button"></span>
                                </label>

                            </div>

                            <div class="form-group">
                               
                                <p> Lung illness, asthma or other lung illness? </p>
                                
                                <input type="radio" name="lung_illness" id="lung_illness_yes" v-model="step3.lung_illness" value="on">
                                <label for="lung_illness_yes">Yes
                                    <span class="radio-button"></span>
                                </label>

                                <input type="radio" name="lung_illness" id="lung_illness_no" v-model="step3.lung_illness" value="off">
                                <label for="lung_illness_no">No
                                    <span class="radio-button"></span>
                                </label>

                            </div>

                            <div class="form-group">
                               
                                <p> Kidney illness or problems with urination? </p>
                                
                                <input type="radio" name="kidney_illness" id="kidney_illness_yes" v-model="step3.kidney_illness" value="on">
                                <label for="kidney_illness_yes">Yes
                                    <span class="radio-button"></span>
                                </label>

                                <input type="radio" name="kidney_illness" id="kidney_illness_no"
                                v-model="step3.kidney_illness" value="off">
                                <label for="kidney_illness_no">No
                                    <span class="radio-button"></span>
                                </label>

                            </div>
                        </div>

                        <div v-if="step==4">    

                            <div class="form-group">
                               
                                <p> Severe or unusual bleeding following any trauma, cut or dental extraction? </p>
                                
                                <input type="radio" name="unusual_bleeding" id="unusual_bleeding_yes" v-model="step4.unusual_bleeding" value="on">
                                <label for="unusual_bleeding_yes">Yes
                                    <span class="radio-button"></span>
                                </label>

                                <input type="radio" name="unusual_bleeding" id="unusual_bleeding_no" v-model="step4.unusual_bleeding" value="off">
                                <label for="unusual_bleeding_no">No
                                    <span class="radio-button"></span>
                                </label>

                            </div>

                            <div class="form-group">
                               
                                <p> A blood disorder (high or low platelets, hemoglobin or white cells? </p>
                                
                                <input type="radio" name="blood_disorder" id="blood_disorder_yes" v-model="step4.blood_disorder" value="on">
                                <label for="blood_disorder_yes">Yes
                                    <span class="radio-button"></span>
                                </label>

                                <input type="radio" name="blood_disorder" id="blood_disorder_no" v-model="step4.blood_disorder" value="off">
                                <label for="blood_disorder_no">No
                                    <span class="radio-button"></span>
                                </label>

                            </div>

                            <div class="form-group">
                               
                                <p> Blood dots in the legs (DVT) or in the lungs (pulmonary embolism)? </p>
                                
                                <input type="radio" name="blood_dots_mesh" id="blood_dots_mesh_yes" v-model="step4.blood_dots_mesh" value="on">
                                <label for="blood_dots_mesh_yes">Yes
                                    <span class="radio-button"></span>
                                </label>

                                <input type="radio" name="blood_dots_mesh" id="blood_dots_mesh_no" v-model="step4.blood_dots_mesh" value="off">
                                <label for="blood_dots_mesh_no">No
                                    <span class="radio-button"></span>
                                </label>

                            </div>

                            <div class="form-group">
                               
                                <p> Diabetes or abnormal blood sugar? </p>
                                
                                <input type="radio" name="diabetes" id="diabetes_yes" v-model="step4.diabetes" value="on">
                                <label for="diabetes_yes">Yes
                                    <span class="radio-button"></span>
                                </label>

                                <input type="radio" name="diabetes" id="diabetes_no" v-model="step4.diabetes" value="off">
                                <label for="diabetes_no">No
                                    <span class="radio-button"></span>
                                </label>

                            </div>
                        </div>

                        <div v-if="step==5">    

                            <div class="form-group">
                               
                                <p> Problems with digestion, bowel function, bleeding or vomiting? </p>
                                
                                <input type="radio" name="problems_with_digestion" id="problems_with_digestion_yes" v-model="step5.problems_with_digestion" value="on">

                                <label for="problems_with_digestion_yes">Yes
                                    <span class="radio-button"></span>
                                </label>

                                <input type="radio" name="problems_with_digestion" id="problems_with_digestion_no" v-model="step5.problems_with_digestion" value="off">
                                
                                <label for="problems_with_digestion_no">No
                                    <span class="radio-button"></span>
                                </label>

                            </div>

                            <div class="form-group">
                               
                                <p> A sexually transmitted disease or been exposed to/tested positive for HIV? </p>
                                
                                <input type="radio" name="sexually_transmitted_disease" id="sexually_transmitted_disease_yes"
                                v-model="step5.sexually_transmitted_disease" value="on">
                                
                                <label for="sexually_transmitted_disease_yes">Yes
                                    <span class="radio-button"></span>
                                </label>

                                <input type="radio" name="sexually_transmitted_disease"
                                v-model="step5.sexually_transmitted_disease" value="off" id="sexually_transmitted_disease_no">
                                
                                <label for="sexually_transmitted_disease_no">No
                                    <span class="radio-button"></span>
                                </label>

                            </div>

                            <div class="form-group">
                               
                                <p> Steroids, prednisone, cortisone, ACTH, or related? </p>
                                
                                <input type="radio" name="steroids_related" id="steroids_related_yes" v-model="step5.steroids_related" value="on">

                                <label for="steroids_related_yes">Yes
                                    <span class="radio-button"></span>
                                </label>

                                <input type="radio" name="steroids_related" id="steroids_related_no" v-model="step5.steroids_related" value="off">
                                
                                <label for="steroids_related_no">No
                                    <span class="radio-button"></span>
                                </label>

                            </div>

                            <div class="form-group">
                               
                                <p> A stroke, unusual dizziness, blackouts, tremors or memory loss? </p>
                                
                                <input type="radio" name="tremors_or_memory_loss"
                                v-model="step5.tremors_or_memory_loss" value="on" id="tremors_or_memory_loss_yes">
                                
                                <label for="tremors_or_memory_loss_yes">Yes
                                    <span class="radio-button"></span>
                                </label>

                                <input type="radio" name="tremors_or_memory_loss"
                                v-model="step5.tremors_or_memory_loss" value="off" id="tremors_or_memory_loss_no">
                                
                                <label for="tremors_or_memory_loss_no">No
                                    <span class="radio-button"></span>
                                </label>

                            </div>

                        </div>

                        <div v-if="step==6">    

                            <div class="form-group">
                               
                                <p> Any neurological disorders (e.g. Parkinson’s Epilepsy, Dementia)? </p>
                                
                                <input type="radio" name="neurological_disorders" id="neurological_disorders_yes" v-model="step6.neurological_disorders" value="on">
                                <label for="neurological_disorders_yes">Yes
                                    <span class="radio-button"></span>
                                </label>

                                <input type="radio" name="neurological_disorders" id="neurological_disorders_no" v-model="step6.neurological_disorders" value="off">
                                <label for="neurological_disorders_no">No
                                    <span class="radio-button"></span>
                                </label>

                            </div>

                            <div class="form-group">
                               
                                <p> Any neuromuscular disorders (e.g. Myasthenia gravis, Multiple Sclerosis)? </p>
                                
                                <input type="radio" name="neuromuscular_disorders" id="neuromuscular_disorders_yes" v-model="step6.neuromuscular_disorders" value="on">
                                <label for="neuromuscular_disorders_yes">Yes
                                    <span class="radio-button"></span>
                                </label>

                                <input type="radio" name="neuromuscular_disorders" id="neuromuscular_disorders_no" v-model="step6.neuromuscular_disorders" value="off">
                                <label for="neuromuscular_disorders_no">No
                                    <span class="radio-button"></span>
                                </label>

                            </div>

                            <div class="form-group">
                               
                                <p> Do you have any loose teeth? Capped teeth? False Teeth? </p>
                                
                                <input type="radio" name="capped_teeth" id="capped_teeth_yes" v-model="step6.capped_teeth" value="on">
                                <label for="capped_teeth_yes">Yes
                                    <span class="radio-button"></span>
                                </label>

                                <input type="radio" name="capped_teeth" id="capped_teeth_no" v-model="step6.capped_teeth" value="off">
                                <label for="capped_teeth_no">No
                                    <span class="radio-button"></span>
                                </label>

                            </div>

                            <div class="form-group">
                               
                                <p> Any problems with eyesight or wear contact lenses? </p>
                                
                                <input type="radio" name="eyesight_problems" id="eyesight_problems_yes" v-model="step6.eyesight_problems" value="on">
                                <label for="eyesight_problems_yes">Yes
                                    <span class="radio-button"></span>
                                </label>

                                <input type="radio" name="eyesight_problems" id="eyesight_problems_no" v-model="step6.eyesight_problems" value="off">
                                <label for="eyesight_problems_no">No
                                    <span class="radio-button"></span>
                                </label>

                            </div>

                        </div>

                        <div v-if="step==7">    

                            <div class="form-group">
                               
                                <p> Do you smoke? </p>
                                
                                <input type="radio" name="smoke" id="smoke_yes" v-model="step7.smoke" value="on">
                                
                                <label for="smoke_yes">Yes
                                    <span class="radio-button"></span>
                                </label>

                                <input type="radio" name="smoke" id="smoke_no" v-model="step7.smoke" value="off">
                                
                                <label for="smoke_no">No
                                    <span class="radio-button"></span>
                                </label>
                                
                                <div v-if="step7.smoke == 'on'">
                                    
                                    <label id="smoke_per_day">How much cigarettes per day?</label><br>
                                    <input type="text" name="smoke_per_day" id="smoke_per_day" placeholder="No of cigarettes" v-model="step7.smoke_per_day" class="form-control"> 
                                    
                                </div>    

                            </div>

                            <div class="form-group" v-if="step7.smoke == 'on'">

                                <p> Do you have cough or sputum from smoking? </p>
                                
                                <input type="radio" name="cough_smoke" id="cough_smoke_yes" v-model="step7.cough_smoke" value="on">
                                
                                <label for="cough_smoke_yes">Yes
                                    <span class="radio-button"></span>
                                </label>

                                <input type="radio" name="cough_smoke" id="cough_smoke_no" v-model="step7.cough_smoke" value="off">
                                
                                <label for="cough_smoke_no">No
                                    <span class="radio-button"></span>
                                </label>
                                
                            </div>

                            <div class="form-group">
                               
                                <p> Do you drink alcohol? </p>
                                
                                <input type="radio" name="drink_alcohol" id="drink_alcohol_yes" v-model="step7.drink_alcohol" value="on">
                                <label for="drink_alcohol_yes">Yes
                                    <span class="radio-button"></span>
                                </label>

                                <input type="radio" name="drink_alcohol" id="drink_alcohol_no" v-model="step7.drink_alcohol" value="off">
                                <label for="drink_alcohol_no">No
                                    <span class="radio-button"></span>
                                </label>

                                <div v-if="step7.drink_alcohol == 'on'">
                                    <label for="drink_alchol_weekly">
                                        How much per week? 
                                    </label>
                                    <br>
                                    <input type="text" v-model="step7.drink_alcohol_weekly" id="drink_alcohol_weekly" placeholder="How many glasses per week?" class="form-control">
                                </div>

                            </div>

                            <div class="form-group">
                               
                                <p> Do you have cultural or religious practices or requirements that we should know of? </p>
                                
                                <input type="radio" name="religious_practises" id="religious_practises_yes" v-model="step7.religious_practises" value="on">
                                <label for="religious_practises_yes">Yes
                                    <span class="radio-button"></span>
                                </label>

                                <input type="radio" name="religious_practises" id="religious_practises_no" v-model="step7.religious_practises" value="off">
                                <label for="religious_practises_no">No
                                    <span class="radio-button"></span>
                                </label>

                                <div v-if="step7.religious_practises == 'on'">
                                    <label for="religious_practises_text">Write</label><br>
                                    <textarea type="text" name="religious_practises_text" id="religious_practises_text" class="form-control" v-model="step7.religious_practises_text"></textarea>
                                </div> 

                            </div>

                            <div class="form-group">
                               
                                <p> Do you have any special needs or require supervision or attendant care (e.g. vision, mobility, dietary, Down’s or Tourette’s Syndrome)? </p>
                                
                                <input type="radio" name="special_needs" id="special_needs_yes" v-model="step7.special_needs" value="on">
                                <label for="special_needs_yes">Yes
                                    <span class="radio-button"></span>
                                </label>

                                <input type="radio" name="special_needs" v-model="step7.special_needs" value="off" id="special_needs_no">
                                <label for="special_needs_no">No
                                    <span class="radio-button"></span>
                                </label>

                            </div>

                        </div>

                        <div v-if="step==8">    

                            <!-- <div class="form-group">
                               
                                <p> Do you live alone? </p>
                                
                                <input type="radio" name="live_alone" id="live_alone_yes" v-model="step8.live_alone" value="on">
                                <label for="live_alone_yes">Yes
                                    <span class="radio-button"></span>
                                </label>

                                <input type="radio" name="live_alone" id="live_alone_no" v-model="step8.live_alone" value="off">
                                <label for="live_alone_no">No
                                    <span class="radio-button"></span>
                                </label>

                            </div> -->
                            
                            <!-- <div>
                                <p>Do you live in a retirement or nursing home?</p>
                                <input type="radio" v-model="step8.nursing_room" value="on" name="nursing_room" id="nursing_room_yes">
                                <label for="nursing_room_yes">Yes
                                    <span class="radio-button"></span>
                                </label>

                                <input type="radio" v-model="step8.nursing_room" value="off" name="nursing_room" id="nursing_room_no">
                                <label for="nursing_room_no">No
                                    <span class="radio-button"></span></label>   
                            </div> -->

                            <div class="form-group">
                                <p>Are you allergic to any (medication, food, environment, latex)?</p>
                                <input type="radio" name="allergic_to_medication" id="allergic_to_medication_yes" v-model="step8.allergic_to_medication" value="on">
                                
                                <label for="allergic_to_medication_yes">Yes
                                    <span class="radio-button"></span>
                                </label>

                                <input type="radio" name="allergic_to_medication" id="allergic_to_medication_no" v-model="step8.allergic_to_medication" value="off">
                                <label for="allergic_to_medication_no">No
                                    <span class="radio-button"></span>
                                </label>   
                            </div>

                            <div class="form-group">
                                <p>Are you currently pregnant?</p>
                                <input type="radio" name="pregnant" id="pregnant_yes" v-model="step8.pregnant" value="on">
                                <label for="pregnant_yes">Yes
                                    <span class="radio-button"></span>
                                </label>

                                <input type="radio" name="pregnant" id="pregnant_no" v-model="step8.pregnant" value="off">
                                <label for="pregnant_no">No
                                    <span class="radio-button"></span></label>   
                            </div>

                        </div>

                        <div v-if="step==9">    

                            <div class="form-group">
                                <p>Undergone chemotherapy in past 12 months?</p>
                                <input type="radio" name="undergone_chemotherapy" id="undergone_chemotherapy_yes" v-model="step9.undergone_chemotherapy" value="on">
                                <label for="undergone_chemotherapy_yes">Yes
                                    <span class="radio-button"></span>
                                </label>

                                <input type="radio" name="undergone_chemotherapy" id="undergone_chemotherapy_no" v-model="step9.undergone_chemotherapy" value="off">
                                <label for="undergone_chemotherapy_no">No
                                    <span class="radio-button"></span>
                                </label>   
                            </div>

                            <div class="form-group">
                                <p>In the last 12 months have you received radiation therapy?</p>
                                <input type="radio" name="undergone_radiation" id="undergone_radiation_yes" v-model="step9.undergone_radiation" value="on">
                                <label for="undergone_radiation_yes">Yes
                                    <span class="radio-button"></span>
                                </label>

                                <input type="radio" name="undergone_radiation" id="undergone_radiation_no" v-model="step9.undergone_radiation" value="off">
                                <label for="undergone_radiation_no">No
                                    <span class="radio-button"></span>
                                </label>   
                            </div>
                            
                            <div class="form-group">
                                <p>Can you climb two flights of stairs without shortness of breath? </p>
                                <input type="radio" name="shortness_of_breath" id="shortness_of_breath_yes" v-model="step9.shortness_of_breath" value="on">
                                <label for="shortness_of_breath_yes">Yes
                                    <span class="radio-button"></span>
                                </label>

                                <input type="radio" name="shortness_of_breath" id="shortness_of_breath_no" v-model="step9.shortness_of_breath" value="off">
                                <label for="shortness_of_breath_no">No
                                    <span class="radio-button"></span>
                                </label>

                                <div v-if="step9.shortness_of_breath == 'off'">
                                    <label>Please explain?</label>
                                    <br>
                                    <textarea type="text" name="shortness_of_breath_text" v-model="step9.shortness_of_breath_text" class="form-control"></textarea>
                                </div>   
                            </div>

                        </div>


                        <div v-if="step==10">

                            <div class="form-group">
                                
                                <p>How do you rate your current health?</p>
                                
                                <input type="radio" name="rate_your_health" id="rate_your_health_good" v-model="step10.rate_your_health" value="good">
                                <label for="rate_your_health_good">
                                    Good
                                    <span class="radio-button"></span>
                                </label>

                                <input type="radio" name="rate_your_health" id="rate_your_health_fair" v-model="step10.rate_your_health" value="fair">
                                <label for="rate_your_health_fair">Fair
                                    <span class="radio-button"></span>
                                </label>

                                <input type="radio" name="rate_your_health" id="rate_your_health_poor" v-model="step10.rate_your_health" value="poor">
                                <label for="rate_your_health_poor">
                                    Poor
                                    <span class="radio-button"></span>
                                </label>

                            </div>

                        </div>
                        
                        <div v-if="step==11">
                            <h4>We thank you for your information</h4>
                        </div>       

                    </div><!--card-body-->
                    
                </div><!--card-right-->

            </div><!--card-right-->

        </div><!--card-->

        <div class="form-group btn-prev" v-if="step!=1">
            <button class="btn btn-default px-3" @click="decrementStep">
                Previous
            </button>
        </div>

        <div class="form-group btn-next" v-if="step!=10">
            <button class="btn btn-success px-3" @click="incrementStep">
                Next
            </button>
        </div>

        <div class="form-group btn-next" v-if="step==10">
            <!-- <router-link class="btn btn-success px-3" :to="{name:'shop', params:{cpt:'49505'}}">
                Finish
            </router-link> -->
            <button @click="incrementStep" class="btn btn-success">Finish</button>
        </div>
            
    </div><!--main-->
</div>

<script>
export default {
  name: 'shouldice',
  data() {
      return {
            step:1,
            set_present:true,
            step1:{
                hernia_diagnosed:'',
                hernia_chronic_pain:'',
                hernia_chronic_pain_prev:'',
                hernia_diagnosed_how:'',
                wound_infecfion:'',
                hernia_repair_mesh:'',
                hernia_diagnosed_other_text:'',
                referral:'',
                referral_name:'',
                referral_email_or_phone:'',
                hernia_chronic_pain_to_time:'present',
                hernia_chronic_pain_from_time:'',
                hernia_chronic_pain_bar:'1',
                hernia_chronic_pain_prev_bar:'1',
                hernia_chronic_pain_prev_from_time:'',
                hernia_chronic_pain_prev_to_time:'present'
            },
            step2:{
                abnormal_reaction_anesthetic:'',
                family_abnormal_reaction_anesthetic:'',
                heart_trouble:'',
                abnormal_blood_pressure:'',
                heart_trouble_to_time:'present',
                heart_trouble_from_time:'',
                heart_trouble_pain_bar:'1'
            },
            step3:{
                medicine_for_your_heart:'',
                difficulty_with_breathing:'',
                lung_illness:'',
                kidney_illness:''
            },
            step4:{
                unusual_bleeding:'',
                blood_disorder:'',
                blood_dots_mesh:'',
                diabetes:''
            },
            step5:{
                problems_with_digestion:'',
                sexually_transmitted_disease:'',
                steroids_related:'',
                tremors_or_memory_loss:''
            },
            step6:{
                neurological_disorders:'',
                neuromuscular_disorders:'',
                capped_teeth:'',
                eyesight_problems:''
            },
            step7:{
                smoke:'',
                cough_smoke:'',
                smoke_per_day:'',
                drink_alcohol:'',
                drink_alcohol_weekly:'',
                religious_practises:'',
                religious_practises_text:'',
                special_needs:''
            },
            step8:{
                live_alone:'',
                nursing_room:'',
                allergic_to_medication:'',
                pregnant:''
            },
            step9:{
                undergone_chemotherapy:'',
                undergone_radiation:'',
                shortness_of_breath:'',
                shortness_of_breath_text:''
            },
            step10:{
                rate_your_health:''
            }

        };
    },

    mounted() {
        this.changeSeverity();
    },

    methods: {
        decrementStep() {
            if(this.step!=1) {
                this.step -= 1;
                let progress = this.step - 1;
                $('head').append('<style>.card::before{width:' + progress + '0% !important;}</style>');
            }
        },
        incrementStep() {

            if(this.step!=10) {
                this.step += 1;
                $('head').append('<style>.card::before{width:' + this.step + '0% !important;}</style>');
            }
            if(this.step == 10) {
                console.log("ok");
                this.showThankYou();
            }
        },

        showThankYou() {
            this.step==11;
        },
        
        changeSeverity() {
           
            //var x = document.getElementById(id);


            $(document).on('change', '.slider', function() {
                let value = $(this).val();          
                
                if (value == '1' || value == '2' || value == '3') {
                    $(this).css('background', '-webkit-linear-gradient(to right bottom, #56ab2f, #55c57a)');
                    $(this).css('background', 'linear-gradient(to right bottom, #56ab2f, #55c57a)');
                    // x.style.background = '-webkit-linear-gradient(to right bottom, #56ab2f, #55c57a)';
                    // x.style.background = 'linear-gradient(to right bottom, #56ab2f, #55c57a)';
                }

                else if (value == '4' || value == '5' || value == '6' || value == '7') {
                    $(this).css('background', '-webkit-linear-gradient(-60deg, #f09819 0%, #ff5858 100%)');
                    $(this).css('background', 'linear-gradient(-60deg, #f09819 0%, #ff5858 100%)');
                    //x.style.background = '-webkit-linear-gradient(-60deg, #f09819 0%, #ff5858 100%)';
                    //x.style.background = 'linear-gradient(-60deg, #f09819 0%, #ff5858 100%)';
                }

                else if (value == '8' || value == '9' || value == '10') {
                    $(this).css('background', '#D31027');
                    $(this).css('background', '-webkit-linear-gradient(to bottom, #ff416c, #ff4b2b)');
                    $(this).css('background', 'linear-gradient(to bottom, #ff416c, #ff4b2b)');
                    // x.style.background = '#D31027';
                    // x.style.background = '-webkit-linear-gradient(to bottom, #ff416c, #ff4b2b)';
                    // x.style.background = 'linear-gradient(to bottom, #ff416c, #ff4b2b)';   
                }
            });

        }
    }
}
</script>

<style scoped>
    .main {
        width:80%;
        margin-left:auto;
        margin-right:auto;
        box-sizing:border-box;
    }
    .card {
        position:relative;
        box-shadow:0 4px 6px rgba(0,0,0,0.4);
        padding:0;
        margin:0;
        width:100%;
        box-sizing:inherit;
        font-size:16px;
        border:none;
        transition:all 0.3s;
    }
    .card::before {
            content:"";
            width:0;
            border-top:3px solid seagreen;
    }
    .card-left {
        background-image:linear-gradient(to right bottom, #28b485, #55c57a);
        color:white;
        padding:40px 20px;
    }
    .card-right {
        padding:30px 20px;
    }
    .row {
        margin:0;
        padding:0;
    }
    .flat__icon {

        height:200px;
        padding:20px 0;
    }
    .flat__icon__img {
        width:100%;
        height:100%;
        display:block;     
    }

    .btn {
        box-shadow: 0 3px 8px rgba(0,0,0,0.4);
    }

    .btn:active,
    .btn:focus {
        transform:translateY(-1px);
        box-shadow:0 1 4px rgba(0,0,0,0.2);
    }

    .btn-next {
        float:right;
        margin:20px 0;
    }

    .btn-prev {
        float:left;
        margin:20px 0;
        background:white;
    }

    .page_counter {
        position:absolute;
        top:15px;
        right:15px;
        font-size:13px;
    }
    input[type="radio"] {
        display:none;
    }

    input[type="radio"] + label {
        position:relative;
        padding-left:30px;
    }

    .radio-button {
        position: absolute;
        top:2px;
        left:5px;
        width:18px;
        height:18px;
        border-radius:50%;
        display:inline-block;
        background:#ddd;
    }

    .radio-button::after {
            content:'';
            position: absolute;
            top:50%;
            left:50%;
            -webkit-transform: translate(-50%, -50%);
            transform:translate(-50%, -50%);
            width:10px;
            height:10px;
            border-radius:50%;
            display:inline-block;
            background:rgb(7, 119, 67);
            opacity:0;
            transition:opacity .0.5s;
    }

    input[type="radio"]:checked + label .radio-button::after {
        opacity:1;
    }

    input[type="radio"]:checked + label .radio-button {
        border:2px solid rgb(7, 119, 67);
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
.to-present {
  pointer-events:none;
  opacity:0.9;
}
.time-input {
  position:relative;
  padding-left:5px;
  padding-right:20px;
}
.time-input ~ i {
  position:absolute;
  top:63%;
  right:8%;
  cursor:pointer;
  /* transform:translateY(-50%); */
}
</style>

