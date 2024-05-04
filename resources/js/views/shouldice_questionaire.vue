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
                            <img src="/svg/icons/svg/007-patient-2.svg" alt="Icon" class="flat__icon__img">
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
                            <img src="/svg/icons/svg/021-lung.svg" alt="Icon" class="flat__icon__img">
                            
                        </div>
                

                    </div> 

                    <div v-if="step==7">
                        
                        <div class="flat__icon">
                            <img src="/svg/icons/svg/002-vitamin.svg" alt="Icon" class="flat__icon__img">
                            
                        </div>
                        
                        <h3 class="my-3 d-inline-block">
                            Few more questions
                        </h3>

                    </div> 

                    <div v-if="step==8">
                        
                        <div class="flat__icon">
                            <img src="/svg/icons/svg/022-medicines.svg" alt="Icon" class="flat__icon__img">
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
                            <img src="/svg/icons/svg/027-diet.svg" alt="Icon" class="flat__icon__img">
                            <img src="/svg/icons/svg/021-bicycle.svg" alt="Icon" class="flat__icon__img">
                        </div>

                    </div> 

                    <div v-if="step==10">
                        
                        <div class="flat__icon">
                            <img src="/svg/icons/svg/020-healing.svg" alt="Icon" class="flat__icon__img">
                        </div>
                        
                        <h3 class="my-3 d-inline-block">
                            Almost done!
                        </h3>

                    </div> 

                    <div v-if="step==11">
                        <div class="flat__icon">
                            <img src="/svg/icons/svg/019-weight.svg" alt="Icon" class="flat__icon__img">
                        </div>
                        
                        <h4>BMI</h4>

                    </div>

                </div>

                <div class="card-right col-sm-8"> 
                    <div class="card-body">
                        
                        <span class="text-muted">
                            <span class="page_counter clearfix" v-if="step!=11">
                                {{step}}/11
                            </span>
                        </span>
                        
                        <div v-show="step==1">
                            
                            <h4 class="my-3 mt-1 text-dark">Give us Information about Hernia.</h4>

                            <div class="form-group">
                                
                                <p>After a physical examine, did your physician confirm your hernia?</p>

                                <input type="radio" name="hernia_diagnosed" id="hernia_diagnosed_yes" value="on" v-model="step1.hernia_diagnosed">
                                <label for="hernia_diagnosed_yes">Yes
                                    <span class="radio-button"></span>
                                </label>

                                <input type="radio" name="hernia_diagnosed" id="hernia_diagnosed_no" value="off" v-model="step1.hernia_diagnosed">
                                <label for="hernia_diagnosed_no">No
                                    <span class="radio-button"></span>
                                </label>

                            </div>

                            <div v-if="step1.hernia_diagnosed == 'on'">
                                
                                <div class="form-group">
                                    
                                    <label>When did you have your physical exam?</label>
                                    <input v-model="step1.hernia_diagnosed_how" type="date" class="form-control">    
                                </div>
                                

                                <!-- <input type="radio" name="hernia_diagnosed_how" id="hernia_diagnosed_physical_exam" v-model="step1.hernia_diagnosed_how" value="physical_exam">
                                <label for="hernia_diagnosed_physical_exam">Physical Exam
                                    <span class="radio-button"></span>
                                </label> -->
                                

                                <div class="form-group">                                
                                    <label for="referral_name">
                                        Wnat is the name of your physician?
                                    </label>
                                    <input placeholder="Referral name" type="text" id="referral_name" v-model="step1.referral_name" class="form-control">
                                </div>

                                <div class="form-group">

                                    <label for="referral_email_or_phone">
                                        Wnat is the email of your physician or contact person?
                                    </label>
                                    <input placeholder="Referral email" type="email" id="referral_email" v-model="step1.referral_email" class="form-control">
                                
                                </div>

                                <div class="form-group">

                                    <label for="referral_phone">
                                        Wnat is the phone of your physician or contact person?
                                    </label>
                                    <input placeholder="Referral phone" type="text" id="referral_phone" v-model="step1.referral_phone" class="form-control">
                                
                                </div>
                                
                            </div>

                            <div class="form-group">

                                <p>What type of hernia do you have?</p>

                                <select class="form-control" v-model="step1.hernia_chronic_pain">
                                    <option value="0">Please select</option>
                                    <option value="inguinial_hernia">Inguinial hernia
                                        (Pelvis)
                                    </option>
                                    <option value="umbilical_hernia">
                                        Umbilical Hernia
                                        (naval - belly button)
                                    </option>
                                    <option value="ventral_hernia">
                                        Ventral Hernia
                                        (Abdomen)                    
                                    </option>
                                    <option value="epigastric_hernia">
                                        Epigastric Hernia
                                        (stomach)
                                    </option>
                                    <option value="hiatal_hernia">
                                        Hiatal Hernia
                                        (upper stomach)
                                    </option>
                                    <option value="incisional_hernia">
                                        Incisional Hernia
                                        (Incision site)
                                    </option>
                                    <option value="spigelian_hernia">
                                        Spigelian Hernia
                                        (Abdomen)
                                    </option>
                                    <option value="femoral_hernia">
                                        Femoral Hernia
                                        (Inner upper thigh)
                                    </option>
                                </select> 

                            </div>


                            <div class="form-group">

                                <p>When did you notice your hernia?</p>

                                <input type="date" class="form-control">  

                            </div>

                            
                        </div>

                        <div v-show="step==2">
                        
                            <h4 class="my-4">Your medical history</h4>

                            <div class="form-group">
                               
                            
                                <p>Is this your first hernia?</p>   
                                
                                <input type="radio" name="first-hernia" id="first-hernia_yes" value="yes" v-model="step2.first_hernia">
                                <label for="first-hernia_yes">Yes
                                    <span class="radio-button"></span>
                                </label>

                                <input type="radio" name="first-hernia" id="first-hernia_no" value="no" v-model="step2.first_hernia">
                                <label for="first-hernia_no">No
                                    <span class="radio-button"></span>
                                </label>

                            </div>

                            <div v-if="step2.first_hernia == 'no'">
                                <p>Tell us about your previous hernia</p>
                                <div class="form-group row" style="margin-left:-15px;">

                                    <div class="col">
                                        <label for="">Type of hernia</label>
                                        <select class="form-control" v-model="step2.first_hernia_type">
                                            <option value="0">Please select</option>
                                            <option value="inguinial_hernia">Inguinial hernia
                                                (Pelvis)
                                            </option>
                                            <option value="umbilical_hernia">
                                                Umbilical Hernia
                                                (naval - belly button)
                                            </option>
                                            <option value="ventral_hernia">
                                                Ventral Hernia
                                                (Abdomen)                    
                                            </option>
                                            <option value="epigastric_hernia">
                                                Epigastric Hernia
                                                (stomach)
                                            </option>
                                            <option value="hiatal_hernia">
                                                Hiatal Hernia
                                                (upper stomach)
                                            </option>
                                            <option value="incisional_hernia">
                                                Incisional Hernia
                                                (Incision site)
                                            </option>
                                            <option value="spigelian_hernia">
                                                Spigelian Hernia
                                                (Abdomen)
                                            </option>
                                            <option value="femoral_hernia">
                                                Femoral Hernia
                                                (Inner upper thigh)
                                            </option>
                                        </select>

                                    </div>

                                    <div class="col">
                                        <label for="first_hernia_date">Date of surgery</label>
                                        <input type="date" id="first_hernia_date" class="form-control" v-model="step2.first_hernia_date">    
                                    </div>
                                    
                                </div>


                            </div><!--v-if-->

                            <div class="form-group mt-3">
                               
                                
                                <p>Is this a recurrent hernia?</p>
                                
                                <input type="radio" name="recurrent_hernia" id="recurrent_hernia_yes" value="yes" v-model="step2.recurrent_hernia">
                                <label for="recurrent_hernia_yes">Yes
                                    <span class="radio-button"></span>
                                </label>

                                <input type="radio" name="recurrent_hernia" id="recurrent_hernia_no" value="no" v-model="step2.recurrent_hernia">
                                <label for="recurrent_hernia_no">No
                                    <span class="radio-button"></span>
                                </label>

                            </div>

                            <div v-if="step2.recurrent_hernia == 'yes'">
                                
                                <div class="form-group row" style="margin-left:-15px;">

                                    <div class="col">
                                        <label for="">Type of hernia</label>
                                        <select class="form-control" v-model="step2.recurrent_hernia_type">
                                            <option value="0">Please select</option>
                                            <option value="inguinial_hernia">Inguinial hernia
                                                (Pelvis)
                                            </option>
                                            <option value="umbilical_hernia">
                                                Umbilical Hernia
                                                (naval - belly button)
                                            </option>
                                            <option value="ventral_hernia">
                                                Ventral Hernia
                                                (Abdomen)                    
                                            </option>
                                            <option value="epigastric_hernia">
                                                Epigastric Hernia
                                                (stomach)
                                            </option>
                                            <option value="hiatal_hernia">
                                                Hiatal Hernia
                                                (upper stomach)
                                            </option>
                                            <option value="incisional_hernia">
                                                Incisional Hernia
                                                (Incision site)
                                            </option>
                                            <option value="spigelian_hernia">
                                                Spigelian Hernia
                                                (Abdomen)
                                            </option>
                                            <option value="femoral_hernia">
                                                Femoral Hernia
                                                (Inner upper thigh)
                                            </option>
                                        </select>

                                    </div>

                                    <div class="col">
                                        <label for="recurrent_hernia_date">Date of surgery</label>
                                        <input type="date" id="recurrent_hernia_date" class="form-control" v-model="step2.recurrent_hernia_date">    
                                    </div>
                                    
                                </div><!--col-->

                                <div class="form-group mt-3">
                                    
                                    <p>Was mesh used? </p>

                                    <input type="radio" name="recurrent_hernia_mesh" id="recurrent_hernia_mesh_yes" v-model="step2.recurrent_hernia_mesh" value="yes">
                                    <label for="recurrent_hernia_mesh_yes">Yes
                                        <span class="radio-button"></span>
                                    </label>

                                    <input v-model="step2.recurrent_hernia_mesh" value="no" type="radio" name="recurrent_hernia_mesh" id="recurrent_hernia_mesh_no">
                                    <label for="recurrent_hernia_mesh_no">No
                                        <span class="radio-button"></span>
                                    </label>

                                    <input v-model="step2.recurrent_hernia_mesh" value="unaware" type="radio" name="recurrent_hernia_mesh" id="recurrent_hernia_mesh_unaware">
                                    <label for="recurrent_hernia_mesh_unaware">Don't know
                                        <span class="radio-button"></span>
                                    </label>

                                </div>

                            </div>

                            

                        </div>

                        <div v-if="step==3">    

                            <div class="form-group">
                               
                                <!-- <p> Medicine for your heart or high blood pressure? </p> -->

                                <p>Do you have more than one hernia?</p>

                                <input type="radio" name="more_than_one" id="more_than_one_yes" value="yes" v-model="step3.more_than_one_hernia">
                                <label for="more_than_one_yes">Yes
                                    <span class="radio-button"></span>
                                </label>

                                <input type="radio" name="more_than_one" id="more_than_one_no" value="no" v-model="step3.more_than_one_hernia">
                                <label for="more_than_one_no">No
                                    <span class="radio-button"></span>
                                </label> 
                            </div>

                            <div class="form-group" v-if="step3.more_than_one_hernia == 'yes'">       
                                
                                <label for="">Type of hernia</label>
                                        
                                <select class="form-control" v-model="step3.more_than_one_hernia_type">
                                    <option value="0">Please select</option>
                                    <option value="inguinial_hernia">Inguinial hernia
                                        (Pelvis)
                                    </option>
                                    <option value="umbilical_hernia">
                                        Umbilical Hernia
                                        (naval - belly button)
                                    </option>
                                    <option value="ventral_hernia">
                                        Ventral Hernia
                                        (Abdomen)                    
                                    </option>
                                    <option value="epigastric_hernia">
                                        Epigastric Hernia
                                        (stomach)
                                    </option>
                                    <option value="hiatal_hernia">
                                        Hiatal Hernia
                                        (upper stomach)
                                    </option>
                                    <option value="incisional_hernia">
                                        Incisional Hernia
                                        (Incision site)
                                    </option>
                                    <option value="spigelian_hernia">
                                        Spigelian Hernia
                                        (Abdomen)
                                    </option>
                                    <option value="femoral_hernia">
                                        Femoral Hernia
                                        (Inner upper thigh)
                                    </option>
                                </select>

                            </div>

                            <div class="form-group">
                               
                                <!-- <p> Difficulty with breathing or had unusual tiredness or weakness? </p> -->

                                <p>Is the bulge painful or sensitive to the touch?</p>
                                
                                <input type="radio" name="bulge_sensitive_to_touch"
                                v-model="step3.bulge_sensitive_to_touch"
                                value="yes" id="bulge_sensitive_to_touch_yes">
                                <label for="bulge_sensitive_to_touch_yes">Yes
                                    <span class="radio-button"></span>
                                </label>

                                <input type="radio" name="bulge_sensitive_to_touch" 
                                v-model="step3.bulge_sensitive_to_touch"
                                value="no"
                                id="bulge_sensitive_to_touch_no">
                                <label for="bulge_sensitive_to_touch_no">No
                                    <span class="radio-button"></span>
                                </label>

                            </div>

                            <div class="form-group" v-if="step3.bulge_sensitive_to_touch == 'no'">
                                
                                <p>Does it feel more like a dull ache?</p>
                                
                                <input type="radio" name="dull_ache"
                                v-model="step3.dull_ache"
                                value="on" id="dull_ache_yes">
                                <label for="dull_ache_yes">Yes
                                    <span class="radio-button"></span>
                                </label>

                                <input type="radio" name="dull_ache" 
                                v-model="step3.dull_ache"
                                value="off" id="dull_ache_no">
                                <label for="dull_ache_no">No
                                    <span class="radio-button"></span>
                                </label>

                            </div>



                            <!-- <div class="form-group">
                               
                                <p> Lung illness, asthma or other lung illness? </p>
                                
                                <input type="radio" name="lung_illness" id="lung_illness_yes" v-model="step3.lung_illness" value="on">
                                <label for="lung_illness_yes">Yes
                                    <span class="radio-button"></span>
                                </label>

                                <input type="radio" name="lung_illness" id="lung_illness_no" v-model="step3.lung_illness" value="off">
                                <label for="lung_illness_no">No
                                    <span class="radio-button"></span>
                                </label>

                            </div> -->

                            <!-- <div class="form-group">
                               
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

                            </div> -->
                        </div>

                        <div v-if="step==4">    

                            <div class="form-group">
                               
                                <p> Can the bulge be push back inside? </p>
                                
                                <input type="radio" name="bulge_push_back_inside" id="bulge_push_back_inside_yes" v-model="step4.bulge_push_back_inside" value="on">
                                <label for="bulge_push_back_inside_yes">Yes
                                    <span class="radio-button"></span>
                                </label>

                                <input type="radio" name="bulge_push_back_inside" id="bulge_push_back_inside_no" v-model="step4.bulge_push_back_inside" value="off">
                                <label for="bulge_push_back_inside_no">No
                                    <span class="radio-button"></span>
                                </label>

                            </div>

                            <div class="form-group" v-if="step4.bulge_push_back_inside == 'off'">
                                <p>Does the bulge appear red, purple or darker?</p>
                                
                                <input type="radio" name="bulge_appearance" id="bulge_appearance_yes" v-model="step4.bulge_appearance" value="on">
                                <label for="bulge_appearance_yes">Yes
                                    <span class="radio-button"></span>
                                </label>

                                <input type="radio" name="bulge_appearance" id="bulge_appearance_no" v-model="step4.bulge_appearance" value="off">
                                <label for="bulge_appearance_no">No
                                    <span class="radio-button"></span>
                                </label>

                            </div>

                            <div class="form-group" v-if="step4.bulge_appearance == 'off'">
                            
                                <p>
                                    Are you having any pain with a fever, chills, and/or vomiting or are unable to have a bowel movement or pass gas?
                                </p>

                                <input type="radio" name="pain_with_a_fever" id="pain_with_a_fever_yes" v-model="step4.pain_with_a_fever" value="on" @change="showModal()">
                                <label for="pain_with_a_fever_yes">Yes
                                    <span class="radio-button"></span>
                                </label>

                                <input @change="showModal()" type="radio" name="pain_with_a_fever" id="pain_with_a_fever_no" v-model="step4.pain_with_a_fever" value="off">
                                <label for="pain_with_a_fever_no">No
                                    <span class="radio-button"></span>
                                </label>

                            </div>

            
                            <div class="modal border border-danger" tabindex="-1" role="dialog" id="warningModal">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                    
                                        <div class="modal-header">
                                            <div class="modal-title text-danger"> 
                                                <h5>
                                                    <span class="icon circle"> 
                                                        <i class="fas fa-exclamation-triangle" aria-hidden="true"></i>  
                                                    </span>

                                                    <span>Warning</span>

                                                </h5>
                                            
                                            </div>
                                            
                                            <button type="button" class="close text-danger" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>

                                        </div>
                                    
                                        <div class="modal-body">
                                            <p>  
                                                Your symptoms may indicate an emergency. don’t wait, seek immediate medical care or call 911. 
                                            </p>
                                        </div>
                                        
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">
                                                Close
                                            </button>
                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>

                        <div v-if="step==5">    

                            <div class="form-group">
                               
                                <p> Is there a family history of hernias?  </p>
                                
                                <input type="radio" name="family_history_of_hernia" id="family_history_of_hernia_yes" v-model="step5.family_history_of_hernia" value="on">

                                <label for="family_history_of_hernia_yes">Yes
                                    <span class="radio-button"></span>
                                </label>

                                <input type="radio" name="family_history_of_hernia" id="family_history_of_hernia_no" v-model="step5.family_history_of_hernia" value="off">
                                
                                <label for="family_history_of_hernia_no">No
                                    <span class="radio-button"></span>
                                </label>

                            </div>

                            <div class="form-group" v-if="step5.family_history_of_hernia == 'on'">
                                
                                <div v-if="step5.family_and_type_mappings.length!=0">
                                    
                                    <ul class="list-group my-2">
                                        <li class="list-group-item" v-for="(mappings, index) in step5.family_and_type_mappings" :key="index">
                                            
                                            A {{index}} has {{mappings}}
                                            
                                            <span @click="popMappingsData(index)" class="cancel float-right">
                                                
                                                <i class="fas fa-times-circle text-danger"></i>
                                            </span> 

                                        </li>
                                    </ul>

                                </div>

                                <div class="row" style="margin-left:-15px;">
                                    <div class="col">
                                        <label for="family_history_of_hernia_member">Family member</label>
                                        
                                        <select id="family_history_of_hernia_member" class="form-control" v-model="step5.family_history_of_hernia_member" @change="mapFamiliesWithHernia">
                                            
                                            <option value="0">Please select</option>
                                            
                                            <option :value="member" v-for="(member, index) in step5.family_members" :key="index">
                                                {{member}}
                                            </option> 

                                        </select>

                                    </div>

                                    <div class="col">
                                        <label for="">Hernia type</label>
                                        
                                         <select @change="mapFamiliesWithHernia" class="form-control" v-model="step5.family_history_of_hernia_type">
                                            <option value="0">Please select</option>
                                            <option :value="part.name" v-for="(part, index) in step5.hernia_types" :key="index">
                                                {{part.name}} ({{(part.part)}})
                                            </option>
                                        </select>    
                                    </div>

                                </div><!--row-->

                            </div><!--v-if-->

                            <div class="form-group">
                                
                                <p>Are you a smoker?</p>

                                <input type="radio" name="smoker" id="smoker_yes" v-model="step5.smoker" value="on">
                                <label for="smoker_yes">Yes
                                    <span class="radio-button"></span>
                                </label>

                                <input type="radio" name="smoker" id="smoker_no" v-model="step5.smoker" value="off">
                                <label for="smoker_no">No
                                    <span class="radio-button"></span>
                                </label>

                            </div>

                            <div class="form-group" v-if="step5.smoker == 'on'">
                                <label>When did you start smoking?</label>
                                <input type="date" class="form-control" v-model="smoke_date">
                            </div>

                            <div class="form-group" v-if="step5.smoker == 'off'">
                                <p>Have you ever been a smoker?</p>
                                
                                <input type="radio" name="ever_smoked" id="ever_smoked_yes" v-model="step5.ever_smoked" value="on">
                                <label for="ever_smoked_yes">Yes
                                    <span class="radio-button"></span>
                                </label>

                                <input type="radio" name="ever_smoked" id="ever_smoked_no" v-model="step5.ever_smoked" value="off">
                                <label for="ever_smoked_no">No
                                    <span class="radio-button"></span>
                                </label>

                            </div>

                            <div class="form-group row" v-if="step5.ever_smoked == 'on'">
                                
                                <div class="col">
                                    <label>From</label>
                                    <input type="date" class="form-control" v-model="ever_smoked_from_date">
                                </div>

                                <div class="col">
                                    <label>To</label>
                                    <input type="date" class="form-control" v-model="ever_smoked_to_date">
                                </div>

                            </div>

                        </div>

                        <div v-if="step==6">    

                            <div class="form-group">
                               
                                <p> Do you have a history of Diabetes? </p>
                                
                                <input type="radio" name="history_of_diabetes" id="history_of_diabetes_yes" v-model="step6.history_of_diabetes" value="on">
                                <label for="history_of_diabetes_yes">Yes
                                    <span class="radio-button"></span>
                                </label>

                                <input type="radio" name="history_of_diabetes" id="history_of_diabetes_no" v-model="step6.history_of_diabetes" value="off">
                                <label for="history_of_diabetes_no">No
                                    <span class="radio-button"></span>
                                </label>

                            </div>

                            <div class="form-group" v-if="step6.history_of_diabetes == 'on'">
                               
                                <p> Are you receiving any dialysis? </p>
                                
                                <input type="radio" name="receiving_dialysis" id="receiving_dialysis_yes" v-model="step6.receiving_dialysis" value="on">
                                <label for="receiving_dialysis_yes">Yes
                                    <span class="radio-button"></span>
                                </label>

                                <input type="radio" name="receiving_dialysis" id="receiving_dialysis_no" v-model="step6.receiving_dialysis" value="off">
                                <label for="receiving_dialysis_no">No
                                    <span class="radio-button"></span>
                                </label>

                            </div>

                            <div class="form-group">
                               
                                <p> Do you have a history of lung disease? </p>
                                
                                <input type="radio" name="lung_disease" id="lung_disease_yes" v-model="step6.lung_disease" value="on">
                                <label for="lung_disease_yes">Yes
                                    <span class="radio-button"></span>
                                </label>

                                <input type="radio" name="lung_disease" id="lung_disease_no" v-model="step6.lung_disease" value="off">
                                <label for="lung_disease_no">No
                                    <span class="radio-button"></span>
                                </label>

                            </div>

                            <div class="form-group">
                               
                                <p> 
                                    Currently, are you taking any immuno suppressant drugs or steroids?
                                </p>
                                
                                <input type="radio" name="steroids" id="steroids_yes" v-model="step6.steroids" value="on">
                                <label for="steroids_yes">Yes
                                    <span class="radio-button"></span>
                                </label>

                                <input type="radio" name="steroids" id="steroids_no" v-model="step6.steroids" value="off">
                                <label for="steroids_no">No
                                    <span class="radio-button"></span>
                                </label>

                            </div>

                            <div class="form-group">
                               
                                <p> 
                                    Are you currently on any blood thinner or beta blockers?
                                </p>
                                
                                <input type="radio" name="beta_blockers" id="beta_blockers_yes" v-model="step6.beta_blockers" value="on">
                                <label for="beta_blockers_yes">Yes
                                    <span class="radio-button"></span>
                                </label>

                                <input type="radio" name="beta_blockers" id="beta_blockers_no" v-model="step6.beta_blockers" value="off">
                                <label for="beta_blockers_no">No
                                    <span class="radio-button"></span>
                                </label>

                            </div>

                        </div>

                        <div v-if="step==7">   
                            <p> 
                                Do you have any medication allergies? 
                            </p>

                            <div class="form-group checklist">
                               
                                <label class="checkbox__container checkbox__container--block" for="medication_allergies_1">
                                    Antibiotics -- amoxicillin (Moxatag), ampicillin, penicillin (Bicillin L-A), tetracycline (Sumycin), and others 
                                    <input type="checkbox" value="Antibiotics -- amoxicillin (Moxatag), ampicillin, penicillin (Bicillin L-A), tetracycline (Sumycin), and others" id="medication_allergies_1"> 
                                    <span class="checkmark"></span>
                                </label>

                                <label class="checkbox__container checkbox__container--block" for="medication_allergies_2">
                                    Nonsteroidal anti-inflammatory drugs like ibuprofen and naproxen
                                    <input type="checkbox" value="Nonsteroidal anti-inflammatory drugs like ibuprofen and naproxen" id="medication_allergies_2">
                                    <span class="checkmark"></span>
                                </label>

                                    
                               
                                <label class="checkbox__container checkbox__container--block" for="medication_allergies_3">
                                   Aspirin
                                   <input type="checkbox" value="Aspirin" id="medication_allergies_3">
                                   <span class="checkmark"></span>
                                </label>

                                   
                               
                                <label class="checkbox__container checkbox__container--block" for="medication_allergies_4">
                                    Sulfa drugs
                                    <input type="checkbox" value="Sulfa drugs" id="medication_allergies_4">
                                    <span class="checkmark"></span> 
                                </label>

                                    
                               
                                <label class="checkbox__container checkbox__container--block" for="medication_allergies_5">
                                   Chemotherapy drugs
                                   <input type="checkbox" value="Chemotherapy drugs" id="medication_allergies_5">
                                   <span class="checkmark"></span>
                                </label>

                                    
                               
                                <label class="checkbox__container checkbox__container--block" for="medication_allergies_6">
                                    Monoclonal antibody therapy -- cetuximab (Erbitux), rituximab (Rituxian and others
                                    <input type="checkbox" value="Monoclonal antibody therapy -- cetuximab (Erbitux), rituximab (Rituxian and others" id="medication_allergies_6">
                                    <span class="checkmark"></span>
                                </label>

                                    
                               
                                <label class="checkbox__container checkbox__container--block" for="medication_allergies_7">
                                    HIV drugs -- abacavir (Ziagen), nevirapine (Viramune), and others
                                    <input type="checkbox" value="HIV drugs -- abacavir (Ziagen), nevirapine (Viramune), and others" id="medication_allergies_7">
                                    <span class="checkmark"></span>
                                </label>

                                   
                               
                                <label class="checkbox__container checkbox__container--block" for="medication_allergies_8">
                                    Insulin
                                    <input type="checkbox" value="Insulin" id="medication_allergies_8"> 
                                    <span class="checkmark"></span>
                                </label>

                                    
                               
                                <label class="checkbox__container checkbox__container--block" for="medication_allergies_9">
                                    Antiseizure drugs -- carbamazepine (Tegretol), lamotrigine (Lamictal), phenytoin, and others
                                    <input type="checkbox" value="Antiseizure drugs -- carbamazepine (Tegretol), lamotrigine (Lamictal), phenytoin, and others" id="medication_allergies_9">
                                    <span class="checkmark"></span>
                                </label>

                                   
                               
                                <label class="checkbox__container  checkbox__container--block" for="medication_allergies_10">
                                    Muscle relaxers given by IV -- atracurium, succinylcholine, or vecuronium
                                    <input type="checkbox" value="Muscle relaxers given by IV -- atracurium, succinylcholine, or vecuronium" id="medication_allergies_10">
                                    <span class="checkmark"></span> 
                                </label>
                            
                            </div>      

                        </div>

                        <div v-if="step==8">    

                            <div class="form-group">
                                
                                <p>Do you have any allergic reactions to anesthesia?</p>
                                
                                <input type="radio" name="allergic_to_anasthesia" id="allergic_to_anasthesia_yes" v-model="step8.allergic_to_anasthesia" value="on">
                                
                                <label for="allergic_to_anasthesia_yes">Yes
                                    <span class="radio-button"></span>
                                </label>

                                <input type="radio" name="allergic_to_anasthesia" id="allergic_to_anasthesia_no" v-model="step8.allergic_to_anasthesia" value="off">
                                <label for="allergic_to_anasthesia_no">No
                                    <span class="radio-button"></span>
                                </label>   
                            </div>

                            <div class="form-group checklist" v-if="step8.allergic_to_anasthesia =='on'">
                            
                                <label class="checkbox__container checkbox__container--block">
                                    Smoking?
                                    <input type="checkbox" value="smoking">
                                    <span class="checkmark"></span>
                                </label>

                                <label class="checkbox__container checkbox__container--block">
                                    History of seizures?
                                    <input type="checkbox" value="history of seizures">
                                    <span class="checkmark"></span>
                                </label>

                                <label class="checkbox__container checkbox__container--block">
                                    Sleep apnea?
                                    <input type="checkbox" value="Sleep apnea">
                                    <span class="checkmark"></span>
                                </label>

                                <label class="checkbox__container checkbox__container--block">
                                    History of high blood pressure?
                                    <input type="checkbox" value="History of high blood pressure?">
                                    <span class="checkmark"></span>
                                </label>

                                <label class="checkbox__container checkbox__container--block">
                                    Any heart conditions?
                                    <input type="checkbox" value="Any heart conditions?">
                                    <span class="checkmark"></span>
                                </label>

                                <label class="checkbox__container checkbox__container--block">
                                    Any lung condition?
                                    <input type="checkbox" value="Any lung condition?">
                                    <span class="checkmark"></span>
                                </label>

                                <label class="checkbox__container checkbox__container--block">
                                    kidney condition?
                                    <input type="checkbox" value="kidney condition?">
                                    <span class="checkmark"></span>
                                </label>

                                <label class="checkbox__container checkbox__container--block">
                                    A history of heavy alcohol use
                                    <input type="checkbox" value="a history of heavy alcohol use">
                                    <span class="checkmark"></span>
                                </label>

                                <label class="checkbox__container checkbox__container--block">
                                    A history of adverse reactions to anesthesia?   
                                    <input type="checkbox" value="a history of adverse reactions to anesthesia?">
                                    <span class="checkmark"></span>
                                </label>

                            </div>

                            <div class="form-group">
                               
                                <p>Is there a family history of asthma? </p>
                                
                                <input type="radio" name="history_of_asthma" id="history_of_asthma_yes" v-model="step8.history_of_asthma" value="on">
                                <label for="history_of_asthma_yes">Yes
                                    <span class="radio-button"></span>
                                </label>

                                <input type="radio" name="history_of_asthma" id="history_of_asthma_no" v-model="step8.history_of_asthma" value="off">
                                <label for="history_of_asthma_no">No
                                    <span class="radio-button"></span>
                                </label>   
                            </div>

                            <div class="form-group">
                               
                                <p>Is there a family history of eczema?  </p>
                                
                                <input type="radio" name="history_of_eczema" id="history_of_eczema_yes" v-model="step8.history_of_eczema" value="on">
                                <label for="history_of_eczema_yes">Yes
                                    <span class="radio-button"></span>
                                </label>

                                <input type="radio" name="history_of_eczema" id="history_of_eczema_no" v-model="step8.history_of_eczema" value="off">
                                <label for="history_of_eczema_no">No
                                    <span class="radio-button"></span>
                                </label>   
                            </div>

                            <div class="form-group">
                               
                                <p>Is there a family history of hives or allergies such as hay fever? </p>
                                
                                <input type="radio" name="history_of_hay_fever" id="history_of_hay_fever_yes" v-model="step8.history_of_hay_fever" value="on">
                                <label for="history_of_hay_fever_yes">Yes
                                    <span class="radio-button"></span>
                                </label>

                                <input type="radio" name="history_of_hay_fever" id="history_of_hay_fever_no" v-model="step8.history_of_hay_fever" value="off">
                                <label for="history_of_hay_fever_no">No
                                    <span class="radio-button"></span>
                                </label>   

                            </div>

                            <div class="form-group">
                               
                                <p>Do you have Celiac disease or a gluten allergy?  </p>
                                
                                <input type="radio" name="history_of_gluten_allergy" id="history_of_gluten_allergy_yes" v-model="step8.history_of_gluten_allergy" value="on">
                                <label for="history_of_gluten_allergy_yes">Yes
                                    <span class="radio-button"></span>
                                </label>

                                <input type="radio" name="history_of_gluten_allergy" id="history_of_gluten_allergy_no" v-model="step8.history_of_gluten_allergy" value="off">
                                <label for="history_of_gluten_allergy_no">No
                                    <span class="radio-button"></span>
                                </label>   
                            </div>

                        </div>

                        <div v-if="step==9">    

                            <h4 class="mb-3">What are your allergy symptoms?</h4>

                            <div class="form-group checklist">
                               
                               <label class="checkbox__container checkbox__container--block">
                                    Difficult to breath?    
                                    <input type="checkbox" value="Difficult to breath?">
                                    <span class="checkmark"></span>
                                </label>

                                <label class="checkbox__container checkbox__container--block">
                                    Shock with a severe drop of blood pressure?     
                                    <input type="checkbox" value="Shock with a severe drop of blood pressure?">
                                    <span class="checkmark"></span>
                                </label>

                                <label class="checkbox__container checkbox__container--block">
                                    Rapid Pulse?     
                                    <input type="checkbox" value="Rapid Pulse? ">
                                    <span class="checkmark"></span>
                                </label>

                                <label class="checkbox__container checkbox__container--block">
                                    Dizziness or lightheadedness?     
                                    <input type="checkbox" value="Dizziness or lightheadedness? ">
                                    <span class="checkmark"></span>
                                </label>    

                            </div>

                            <div v-if="step9.open_other_allergies" class="add_more_text form-group">
                                <input type="text" class="form-control form-control-sm w-50 float-left" placeholder="Add more" @keypress="addToAllergies($event)">
                                <button @click="step9.open_other_allergies = false" class="btn btn-danger btn-sm float-left">
                                    Cancel
                                </button>
                            </div>
                            
                            <!-- clear the float -->

                            <div class="cleafrix"></div>

                            <div class="add_more_button" @click="step9.open_other_allergies = true">
                                <i class="fas fa-plus"></i>
                            </div>
                            
                            


                            <div class="form-group checklist">
                                
                                <label class="checkbox__container checkbox__container--block">
                                    <h4 class="mt-3 my-2">Food</h4>    
                                    <input type="checkbox" value="Food" @change="showFood($event)">
                                    <span class="checkmark"></span>
                                </label>

                                <div v-if="step9.food_toggle">

                                    <label class="checkbox__container checkbox__container--block">
                                        Shellfish, such as shrimp, lobster and crab    
                                        <input type="checkbox" value="Shellfish, such as shrimp, lobster and crab">
                                        <span class="checkmark"></span>
                                    </label>

                                    <label class="checkbox__container checkbox__container--block">
                                        Peanuts    
                                        <input type="checkbox" value="Peanuts">
                                        <span class="checkmark"></span>
                                    </label>

                                    <label class="checkbox__container checkbox__container--block">
                                        Peanuts    
                                        <input type="checkbox" value="Peanuts">
                                        <span class="checkmark"></span>
                                    </label>

                                    <label class="checkbox__container checkbox__container--block">
                                        Tree nuts, such as walnuts and pecans    
                                        <input type="checkbox" value="Tree nuts, such as walnuts and pecans">
                                        <span class="checkmark"></span>
                                    </label>

                                    <label class="checkbox__container checkbox__container--block">
                                        Fish    
                                        <input type="checkbox" value="Fish">
                                        <span class="checkmark"></span>
                                    </label>

                                    <label class="checkbox__container checkbox__container--block">
                                        Eggs    
                                        <input type="checkbox" value="Eggs">
                                        <span class="checkmark"></span>
                                    </label>

                                    <label class="checkbox__container checkbox__container--block">
                                        Cow's milk    
                                        <input type="checkbox" value="Cow's milk">
                                        <span class="checkmark"></span>
                                    </label>

                                    <label class="checkbox__container checkbox__container--block">
                                        Wheat    
                                        <input type="checkbox" value="Wheat">
                                        <span class="checkmark"></span>
                                    </label>

                                    <label class="checkbox__container checkbox__container--block">
                                        Soy    
                                        <input type="checkbox" value="Soy">
                                        <span class="checkmark"></span>
                                    </label>
                                   

                                </div>

                            </div><!--checklist-->

                            <div v-if="step9.open_other_foods" class="add_more_text form-group">
                                <input type="text" class="form-control form-control-sm w-50 float-left" placeholder="Add more" @keypress="addToFoods">
                                <button @click="step9.open_other_foods = false" class="btn btn-danger btn-sm float-left">
                                    Cancel
                                </button>
                            </div>

                            <div class="clearfix"></div>
                            
                            <div class="add_more_button" @click="step9.open_other_foods = true">
                                <i class="fas fa-plus"></i>
                            </div>

                            <h4 class="my-3">Pollen food allergy</h4>
                            <h5>Birch pollen</h5>
                            
                            
                            <div class="form-group checklist">
                                
                                <label class="checkbox__container checkbox__container--block">
                                    Almond    
                                    <input type="checkbox" value="Almond">
                                    <span class="checkmark"></span>
                                </label>

                                <label class="checkbox__container checkbox__container--block">
                                    Apple    
                                    <input type="checkbox" value="Apple">
                                    <span class="checkmark"></span>
                                </label>

                                <label class="checkbox__container checkbox__container--block">
                                    Apricot    
                                    <input type="checkbox" value="Apricot">
                                    <span class="checkmark"></span>
                                </label>

                                <label class="checkbox__container checkbox__container--block">
                                    Carrot    
                                    <input type="checkbox" value="Carrot">
                                    <span class="checkmark"></span>
                                </label>

                                <label class="checkbox__container checkbox__container--block">
                                    Celery    
                                    <input type="checkbox" value="Celery">
                                    <span class="checkmark"></span>
                                </label>

                                <label class="checkbox__container checkbox__container--block">
                                    Cherry    
                                    <input type="checkbox" value="Cherry">
                                    <span class="checkmark"></span>
                                </label>

                                <label class="checkbox__container checkbox__container--block">
                                    Hazelnut    
                                    <input type="checkbox" value="Hazelnut">
                                    <span class="checkmark"></span>
                                </label>

                                <label class="checkbox__container checkbox__container--block">
                                    Peach    
                                    <input type="checkbox" value="Peach">
                                    <span class="checkmark"></span>
                                </label>

                                <label class="checkbox__container checkbox__container--block">
                                    Peanut    
                                    <input type="checkbox" value="Peanut">
                                    <span class="checkmark"></span>
                                </label>

                                <label class="checkbox__container checkbox__container--block">
                                    Pear    
                                    <input type="checkbox" value="Pear">
                                    <span class="checkmark"></span>
                                </label>

                                <label class="checkbox__container checkbox__container--block">
                                    Plum    
                                    <input type="checkbox" value="Plum">
                                    <span class="checkmark"></span>
                                </label>

                                <label class="checkbox__container checkbox__container--block">
                                    Raw potatoes    
                                    <input type="checkbox" value="Raw potatoes">
                                    <span class="checkmark"></span>
                                </label>

                                <label class="checkbox__container checkbox__container--block">
                                    Soybean    
                                    <input type="checkbox" value="Soybean">
                                    <span class="checkmark"></span>
                                </label>

                                <label class="checkbox__container checkbox__container--block">
                                    Some herbs and spices (anise, caraway, coriander, fennel, parsley)    
                                    <input type="checkbox" value="Some herbs and spices (anise, caraway, coriander, fennel, parsley)">
                                    <span class="checkmark"></span>
                                </label>

                            </div>

                            <h5>Ragweed pollen</h5>

                            <div class="form-group checklist">
                                
                                <label class="checkbox__container checkbox__container--block">
                                    Bananas    
                                    <input type="checkbox" value="Bananas">
                                    <span class="checkmark"></span>
                                </label>

                                <label class="checkbox__container checkbox__container--block">
                                    Cucumber    
                                    <input type="checkbox" value="Cucumber">
                                    <span class="checkmark"></span>
                                </label>

                                <label class="checkbox__container checkbox__container--block">
                                    Melons (cantaloupe, honeydew and watermelon)    
                                    <input type="checkbox" value="Melons (cantaloupe, honeydew and watermelon)">
                                    <span class="checkmark"></span>
                                </label>

                                <label class="checkbox__container checkbox__container--block">
                                    Zucchini    
                                    <input type="checkbox" value="Zucchini">
                                    <span class="checkmark"></span>
                                </label>

                            </div>

                            <h5>Grasses</h5>

                            <div class="form-group checklist">
                                
                                <label class="checkbox__container checkbox__container--block">
                                    Orange    
                                    <input type="checkbox" value="Orange">
                                    <span class="checkmark"></span>
                                </label>

                                <label class="checkbox__container checkbox__container--block">
                                    Peanut    
                                    <input type="checkbox" value="Peanut">
                                    <span class="checkmark"></span>
                                </label>

                                <label class="checkbox__container checkbox__container--block">
                                    Tomatoes    
                                    <input type="checkbox" value="Tomatoes">
                                    <span class="checkmark"></span>
                                </label>

                                <label class="checkbox__container checkbox__container--block">
                                    White potato    
                                    <input type="checkbox" value="White potato">
                                    <span class="checkmark"></span>
                                </label>

                            </div> 

                            <h5>Muggwort pollen</h5>

                            <div class="form-group checklist">
                                
                                <label class="checkbox__container checkbox__container--block">
                                    Apple    
                                    <input type="checkbox" value="Apple">
                                    <span class="checkmark"></span>
                                </label>

                                <label class="checkbox__container checkbox__container--block">
                                    Bell pepper    
                                    <input type="checkbox" value="Bell pepper">
                                    <span class="checkmark"></span>
                                </label>

                                <label class="checkbox__container checkbox__container--block">
                                    Broccoli    
                                    <input type="checkbox" value="Broccoli">
                                    <span class="checkmark"></span>
                                </label>

                                <label class="checkbox__container checkbox__container--block">
                                    Cabbage    
                                    <input type="checkbox" value="Cabbage">
                                    <span class="checkmark"></span>
                                </label>

                                <label class="checkbox__container checkbox__container--block">
                                    Celery    
                                    <input type="checkbox" value="Celery">
                                    <span class="checkmark"></span>
                                </label>

                                <label class="checkbox__container checkbox__container--block">
                                    Cauliflower    
                                    <input type="checkbox" value="Cauliflower">
                                    <span class="checkmark"></span>
                                </label>

                                <label class="checkbox__container checkbox__container--block">
                                    Carrots    
                                    <input type="checkbox" value="Carrots">
                                    <span class="checkmark"></span>
                                </label>

                                <label class="checkbox__container checkbox__container--block">
                                    Garlic    
                                    <input type="checkbox" value="Garlic">
                                    <span class="checkmark"></span>
                                </label>

                                <label class="checkbox__container checkbox__container--block">
                                    Onion    
                                    <input type="checkbox" value="Onion">
                                    <span class="checkmark"></span>
                                </label>

                                <label class="checkbox__container checkbox__container--block">
                                    Peach    
                                    <input type="checkbox" value="Peach">
                                    <span class="checkmark"></span>
                                </label>

                                <label class="checkbox__container checkbox__container--block">
                                    Some herbs and spices (anise, black pepper, caraway seed, coriander, fennel, mustard, parsley)
                                    <input type="checkbox" value="Some herbs and spices (anise, black pepper, caraway seed, coriander, fennel, mustard, parsley)">
                                    <span class="checkmark"></span>
                                </label>

                            </div>   

                        </div>


                        <div v-if="step==10">

                            <div class="form-group">
                                
                                <p>Do you have any breathing difficulties?</p>
                                
                                <input type="radio" name="breathing_difficulties" id="breathing_difficulties_yes" v-model="step10.breathing_difficulties" value="yes">
                                <label for="breathing_difficulties_yes">
                                    Yes
                                    <span class="radio-button"></span>
                                </label>

                                <input type="radio" name="breathing_difficulties" id="breathing_difficulties_no" v-model="step10.breathing_difficulties" value="no">
                                <label for="breathing_difficulties_no">No
                                    <span class="radio-button"></span>
                                </label>

                            </div>

                            <div class="form-group">
                                
                                <p>Are you currently feeling nausea?</p>
                                
                                <input type="radio" name="feeling_nausea" id="feeling_nausea_yes" v-model="step10.feeling_nausea" value="yes">
                                <label for="feeling_nausea_yes">
                                    Yes
                                    <span class="radio-button"></span>
                                </label>

                                <input type="radio" name="feeling_nausea" id="feeling_nausea_no" v-model="step10.feeling_nausea" value="no">
                                <label for="feeling_nausea_no">No
                                    <span class="radio-button"></span>
                                </label>

                            </div>

                            <div class="form-group">
                                
                                <p>Are you recently been vomiting? </p>
                                
                                <input type="radio" name="vomiting" id="vomiting_yes" v-model="step10.vomiting" value="yes">
                                <label for="vomiting_yes">
                                    Yes
                                    <span class="radio-button"></span>
                                </label>

                                <input type="radio" name="vomiting" id="vomiting_no" v-model="step10.vomiting" value="no">
                                <label for="vomiting_no">No
                                    <span class="radio-button"></span>
                                </label>

                            </div>

                            <div class="form-group">
                                
                                <p>Are you having difficulties performing daily activities?</p>
                                
                                <input type="radio" name="performing_daily_activities" id="performing_daily_activities_yes" v-model="step10.performing_daily_activities" value="yes">
                                <label for="performing_daily_activities_yes">
                                    Yes
                                    <span class="radio-button"></span>
                                </label>

                                <input type="radio" name="performing_daily_activities" id="performing_daily_activities_no" v-model="step10.performing_daily_activities" value="no">
                                <label for="performing_daily_activities_no">No
                                    <span class="radio-button"></span>
                                </label>

                            </div>

                            
                            <div class="form-group">
                                
                                <p>Do you have a history of persistent coughing?</p>
                                
                                <input type="radio" name="persistent_coughing" id="persistent_coughing_yes" v-model="step10.persistent_coughing" value="yes">
                                <label for="persistent_coughing_yes">
                                    Yes
                                    <span class="radio-button"></span>
                                </label>

                                <input type="radio" name="persistent_coughing" id="persistent_coughing_no" v-model="step10.persistent_coughing" value="no">
                                <label for="persistent_coughing_no">No
                                    <span class="radio-button"></span>
                                </label>

                            </div>
                         
                            
                            <div class="form-group">
                                
                                <p>Are you straining during bowel movement or urination?</p>
                                
                                <input type="radio" name="urination" id="urination_yes" v-model="step10.urination" value="yes">
                                <label for="urination_yes">
                                    Yes
                                    <span class="radio-button"></span>
                                </label>

                                <input type="radio" name="urination" id="urination_no" v-model="step10.urination" value="no">
                                <label for="urination_no">No
                                    <span class="radio-button"></span>
                                </label>

                            </div>

                            <div class="form-group">
                                
                                <p>Do you have any fever?</p>
                                
                                <input type="radio" name="fever" id="fever_yes" v-model="step10.fever" value="yes">
                                <label for="fever_yes">
                                    Yes
                                    <span class="radio-button"></span>
                                </label>

                                <input type="radio" name="fever" id="fever_no" v-model="step10.fever" value="no">
                                <label for="fever_no">No
                                    <span class="radio-button"></span>
                                </label>

                            </div>

                        </div>
                        
                        <div v-if="step==11">
                            <h4>
                                BMI (body mass index)
                            </h4>

                            <div class="form-group">
                                <label for="">Height</label>
                                <input type="text" class="form-control" placeholder="please enter your height in inches eg 58" v-model="bmi.height">
                            </div>

                            <div class="form-group">
                                <label for="">Weight</label>
                                <input type="text" class="form-control" placeholder="please enter your weight in pounds e.g 100" v-model="bmi.weight">
                            </div>

                            <div class="form-group">
                                <button @click ="bmiCalculator" class="btn btn-sm btn-success">
                                    Calculate Bmi
                                </button>
                            </div>

                            <div class="modal border border-danger" tabindex="-1" role="dialog" id="bmiModal">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                    
                                        <div class="modal-header">
                                            <div class="modal-title"> 
                                                <h5>
                                                    <!-- <span class="icon circle">
                                                        <div v-if="type == 'text-danger'"> 
                                                            <i class="fas fa-exclamation-triangle" aria-hidden="true"></i>
                                                        </div>
                                                        
                                                        <div v-if="type == 'text-success'"> 
                                                            <i class="fas fa-check" aria-hidden="true"></i>
                                                        </div>

                                                        <div v-if="type == 'text-warning'"> 
                                                            <i class="fas fa-exclamation-triangle" aria-hidden="true"></i>
                                                        </div>        
                                                    </span> -->

                                                    
                                                    {{bmi.message}}
                                                        
        
                                                </h5>
                                            
                                            </div>
                                            
                                            <button type="button" class="close text-danger" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>

                                        </div>
                                    
                                        <div class="modal-body">
                                            <h4> 
                                                {{bmi.message}}
                                            </h4>
                                            <p>Your BMI is {{bmi.score.toFixed(2)}}</p>   
                                        </div>
                                        
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">
                                                Close
                                            </button>
                                        </div>

                                    </div>
                                </div>
                            </div>

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

        <div class="form-group btn-next" v-if="step!=11">
            <button class="btn btn-success px-3" @click="incrementStep">
                Next
            </button>
        </div>

        <div class="form-group btn-next" v-if="step==11">
            <router-link class="btn btn-success px-3" :to="{path:`/offer/49505`}">
                Finish
            </router-link>
            <!-- <button @click="incrementStep" class="btn btn-success">Finish</button> -->
        </div>
            
    </div><!--main-->

</div>

<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>-->


<script>

export default {
    
    props:['origin'],
    
    data() {
        return {
            step:1,
            set_present:true,
            step1:{
                hernia_diagnosed:'',
                hernia_chronic_pain:'0',
                hernia_chronic_pain_prev:'',
                hernia_diagnosed_how:'',
                wound_infecfion:'',
                hernia_repair_mesh:'',
                hernia_diagnosed_other_text:'',
                referral:'',
                referral_name:'',
                referral_email:'',
                referral_phone:'',
                hernia_chronic_pain_to_time:'present',
                hernia_chronic_pain_from_time:'',
                hernia_chronic_pain_bar:'1',
                hernia_chronic_pain_prev_bar:'1',
                hernia_chronic_pain_prev_from_time:'',
                hernia_chronic_pain_prev_to_time:'present'
            },
            step2:{
                first_hernia:'',
                first_hernia_date:'',
                first_hernia_type:'0',
                recurrent_hernia:'',
                recurrent_hernia_date:'',
                recurrent_hernia_type:'0',
                recurrent_hernia_mesh:'',
                heart_trouble:'',
                abnormal_blood_pressure:'',
                heart_trouble_to_time:'present',
                heart_trouble_from_time:'',
                heart_trouble_pain_bar:'1'
            },
            step3:{
                more_than_one_hernia:'',
                more_than_one_hernia_type:'0',
                medicine_for_your_heart:'',
                bulge_sensitive_to_touch:'',
                dull_ache:'',
                lung_illness:'',
                kidney_illness:''
            },
            step4:{
                bulge_push_back_inside:'',
                bulge_appearance:'',
                pain_with_a_fever:''
            },
            step5:{
                family_history_of_hernia:'',
                family_history_of_hernia_member:'0',
                family_history_of_hernia_type:'0',
                family_members:this.loadFamilyMembers(),
                hernia_types:this.loadHerniaTypes(),
                family_and_type_mappings:{},
                smoke:'',
                smoke_date:'',
                ever_smoked:'',
                ever_smoked_from_date:'',
                ever_smoked_to_date:''
            },
            step6:{
                history_of_diabetes:'',
                receiving_dialysis:'',
                high_risk:false,
                lung_disease:'',
                steroids:'',
                beta_blockers:''
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
                allergic_to_anasthesia:'',
                history_of_asthma:'',
                history_of_eczema:'',
                history_of_hay_fever:'',
                history_of_gluten_allergy:''
            },
            step9:{
                difficulty_to_breath:'',
                severe_drop_of_blood_pressure:'',
                rapid_pulse:'',
                open_other_allergies:false,
                allergy_symptoms:[],
                more_allergy_symptoms:[],
                open_other_foods:false,
                allergy_foods:[],
                more_allergy_foods:[],
                food_toggle:false,
                pollen_toggle:false,
                ragweed_toggle:false,
                grasses:false,
                mugwort:false
            },
            step10:{
                breathing_difficulties:'',
                feeling_nausea:'',
                vomiting:'',
                performing_daily_activities:'',
                persistent_coughing:'',
                urination:'',
                fever:''
            },
            bmi:{
                weight:'',
                height:'',
                message:'',
                type:'',
                score:0
            }

        };
    },

    mounted() {
        this.changeSeverity();
    },

    computed:{
        type() {
            let type = '';
            if(this.bmi.type == 'danger') {
                type = 'text-danger';
            }
            else if(this.bmi.type == 'success') {
                type = 'text-success';
            }
            else if(this.bmi.type == 'warning') {
                type = 'text-warning';
            }
            return type;
        }
    },

    methods: {
        
        showFood(event) {
           
           let checked = event.target.checked;
				
            if(checked) {
                this.step9.food_toggle = true;
            }
            else {
                this.step9.food_toggle = false;
            }

        },

        showPollen() {
            let checked = event.target.checked;
				
            if(checked) {
                this.step9.pollen_toggle = true;
            }
            else {
                this.step9.pollen_toggle = false;
            }
        },

        bmiCalculator() {
            let ranges = {
                underweight:'1-18',
                normal:'19-24',
                overweight:'25-29',
                obese:'30-39',
                severe_obese:'40-54'
            };
            
            let weight = parseFloat(this.bmi.weight).toFixed(2);
            let height = parseFloat(this.bmi.height).toFixed(2);
              
            let result = weight/height; 
            let final_result = result/height;
            
            final_result = final_result * 703;
            var message = '';
            var type = '';

            console.log(final_result + "is the final");
            
            if(final_result >= 1 && final_result <= 19) {
               message = 'Underweight';  
               type = 'danger';   
            }

            else if(final_result > 19 && final_result <= 25) {
               message = 'Normal'; 
               type = 'success';    
            }

            else if(final_result > 25 && final_result <= 30) {
               message = 'Overweight';
               type = 'warning';     
            }

            else if(final_result > 30 && final_result <= 40) {
               message = 'Obesity';
               type = 'danger';     
            }

            else if(final_result > 40) {
               message = 'Severe Obesity';     
               type = 'danger';
            }

           $("#bmiModal").modal('show');

           this.bmi.message = message;
           this.bmi.type = type;
           this.bmi.score = final_result;

        },

        loadFamilyMembers() {
           
           let family = [
               'father',
               'mother',
               'brother',
               'sister',
               'grandfather',
               'grandmother',
               'uncle',
               'aunt',
           ];

           return family;
        },
        
        loadHerniaTypes() {
            
            let parts = [
                {
                    name:'inguinial hernia',
                    part:'pelvis'
                },
                {
                    name:'Umbilical hernia',
                    part:'naval - belly button'
                },
                {
                    name:'Ventral hernia',
                    part:'Abdomen'
                },
                {
                    name:'Epigastric hernia',
                    part:'stomach'
                },
                {
                    name:'Incisional hernia',
                    part:'incision_site'
                },
                {
                    name:'Hiatal hernia',
                    part:'upper stomach'
                },
                {
                    name:'Spigelian hernia',
                    part:'Abdomen'
                },
                {
                    name:'Femoral hernia',
                    part:'inner upper thigh'
                },
                
            ];
            return parts;

        },

        mapFamiliesWithHernia() {
           var member = this.step5.family_history_of_hernia_member;
           var type = this.step5.family_history_of_hernia_type;

           if(member != '0' && type != '0') {
               this.step5.family_and_type_mappings[member] = type;
               //this.popMappingsData(member, type);   
           }

        
        },

        popMappingsData(index) {
            
            var this_mappings = this.step5.family_and_type_mappings;
            var new_mappings = {};

            for(var mappings in this_mappings) {
                if(index != mappings) {
                    new_mappings[index] = this_mappings[mappings];
                }    
            }
            this.step5.family_and_type_mappings = new_mappings;

        },

        addToAllergies(e) {
            console.log(e.which);
        },
        
        addToFoods() {

        },

        showModal() {
            if(this.step4.pain_with_a_fever == 'on') {
                $("#warningModal").modal('show');    
            }
        },

        decrementStep() {
            if(this.step!=1) {
                this.step -= 1;
                let progress = this.step - 1;
                $('head').append('<style>.card::before{width:' + progress + '0% !important;}</style>');
            }
        },
        incrementStep() {

            if(this.step!=11) {
                this.step += 1;
                if(this.step!=10 && !this.step >= 10) {
                    $('head').append('<style>.card::before{width:' + this.step + '0% !important;}</style>');
                }
            }

            if(this.step == 11) {
                console.log("ok");
                this.showThankYou();
            }

        },

        showThankYou() {
            //this.step==11;
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

<style scoped lang="scss">
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
        //height:700px;
        //overflow: auto;
        transition:all 0.3s;
        &::before {
            content:"";
            width:0;
            border-top:3px solid seagreen;
        }
    }
    .card-left {
        background-image:linear-gradient(to right bottom, #28b485, #55c57a);
        color:white;
        padding:40px 20px;
        //height:100%;
    }
    .card-right {
        padding:30px 20px;
        //height:100%;
    }
    .row {
        margin:0;
        padding:0;
    }
    .flat__icon {

        height:200px;
        padding:20px 0;
        
        &__img {
            width:100%;
            height:100%;
            display:block;     
        }
    }

    .btn {
        box-shadow: 0 3px 8px rgba(0,0,0,0.4);
        &:active,
        &:focus {
            transform:translateY(-1px);
            box-shadow:0 1 4px rgba(0,0,0,0.2);
        }
    }


    .btn-next {
        float:right;
        margin:20px 0;
        // position: absolute;
        // bottom:20px;
        // right:30px;
    }

    .btn-prev {
        float:left;
        margin:20px 0;
        background:white;
        // position: absolute;
        // bottom:20px;
        // right:30px;
    }

    .page_counter {
        position:absolute;
        top:15px;
        right:15px;
        font-size:13px;
    }

    .add_more_button {
        background:#fff;
        box-shadow: 0 3px 8px rgba(0,0,0,0.4);
        width:30px;
        height:30px;
        position:relative;
        display:block;
        cursor:pointer;
        border-radius:50%;
        transition:all 0.2s;
        
        i {
            position:absolute;
            top:50%;
            left:50%;
            transform:translate(-50%, -50%);
        } 

        &:hover {
            transform:translateY(-2px);
            box-shadow: 0 4px 10px rgba(0,0,0,0.4);
        }
        
        &:active,
        &:focus {
            transform:translateY(2px);
            box-shadow: 0 2px 6px rgba(0,0,0,0.2);
        }
    }
    
    
</style>
