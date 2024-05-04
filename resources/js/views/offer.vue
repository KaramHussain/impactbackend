<div>
    <div>
        <section class="hospital-advertisement-cards" style="margin-top:150px;">
            <div class="row cards-inner" style="margin:0;padding:0">
                
                <div class="col-sm-4" style="margin:0;padding:0;margin-right:-10px;">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="text-center">Hospital</h4>
                            <p class="text-center">Hernia Repair</p>
                        </div>
                        
                        <ul class="list-group text-center">
                            <li class="list-group-item display-4">
                                <strong>$24,000</strong>
                            </li>
                            <li class="list-group-item">Hernia</li>
                            <li class="list-group-item">Pre-Op Services 
                                <i class="fa fa-times-circle text-danger"></i>
                            </li>
                            <li class="list-group-item">Surgery 
                                <i class="fas fa-check-circle text-success"></i>
                            </li>
                            <li class="list-group-item">Post op servcies 
                                <i class="fa fa-times-circle text-danger"></i>
                            </li>
                        </ul>   
                        
                    </div>     
                </div>
                
                <div class="col-sm-4" style="margin:0;padding:0">
                    <div class="card shouldice-card">
                        <div class="card-header shouldice text-center">
                            
                            <h4>Shouldice</h4>
                            <p>Hernia Repair</p>

                        </div>
                        
                            
                        <ul class="list-group text-center">
                            <li class="list-group-item display-4">
                                <strong>$6,000</strong>
                            </li>
                            <!-- <li class="list-group-item">Treatment name</li> -->
                            <li class="list-group-item">
                                Pre Op consult
                                <i class="fa fa-check-circle text-success"></i>
                            </li>
                            <li class="list-group-item">Surgery 
                                <i class="fas fa-check-circle text-success"></i>
                            </li>
                            <li class="list-group-item">2 night inpatient stay 
                                <i class="fa fa-check-circle text-success"></i>
                            </li>
                            <li class="list-group-item">
                                Physical therapy 
                            </li>
                            <li class="list-group-item">
                                Nutritional  counseling 
                            </li>
                            <li class="list-group-item">
                                Follow up visit 
                            </li>
                            <li class="list-group-item">
                                Guarantee 
                            </li>
                           
                            <li class="list-group-item">
                                <router-link disabled class="btn btn-success px-5" :to="{name:'shop'}">
                                    Proceed
                                </router-link> 
                            </li>
                            
                        </ul>

                        
                    </div>    
                </div>
                
                <div class="col-sm-4" style="margin:0;padding:0;margin-left:-10px;">
                    <div class="card">
                        <div class="card-header text-center">
                            <h4>Ambultary centers</h4>
                            <p>Hernia Repair</p>
                        </div>
                        
                        <ul class="list-group text-center">
                            <li class="list-group-item display-4">
                                <strong>$12,000</strong>
                            </li>
                            <li class="list-group-item">Hernia</li>
                            <li class="list-group-item">Pre-Op Services 
                                <i class="fa fa-times-circle text-danger"></i>
                            </li>
                            <li class="list-group-item">Surgery 
                                <i class="fas fa-check-circle text-success"></i>
                            </li>
                            <li class="list-group-item">Post op services 
                                <i class="fa fa-times-circle text-danger"></i>
                            </li>
                            
                        </ul>    
                        
                    </div><!--card-body-->    
                </div><!--card-->

            </div><!--row-->


        </section>
    </div>
</div>

<script>
export default {

}
</script>

<style scoped>
    .hospital-advertisement-cards {
        width:100%;
    }
    .card {
        box-shadow:0 1px 4px rgba(0,0,0,0.4);
    }
    .shouldice-card {
        z-index:1;
        transform:translateY(-15%);
        box-shadow:0 12px 15px rgba(0,0,0,0.4);
    }
    .card-header {
        background: #bebebe;
        color:#fff;
        font-weight:bold;
        padding:10px;
    }
    .shouldice {
        background: #2ea3f2;
    }
    .display-4 {
        font-size:30px;
    }
    .shouldice-card .card-header.display-4 {
        font-size:36px;
    }
</style>
