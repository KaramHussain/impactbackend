@extends('layouts.app')

@section('content')
	
    <div class="main" id="app">
       	
		<h3 class="my-2">Anatomy</h3>
		
		<form action="{{route('questions-and-answers-upload')}}" method="post" autocomplete="off">
			@csrf
			<div class="card">
				<div class="card-body">
						
						<div class="row">
							
							<div class="form-group col-sm-6">
								<label>Symptom</label>
								<input type="text" class="form-control symptomFinder" name="symptom" required placeholder = "Add symptom to enter questions">
								<div id="searchResults" class="SearchResults"></div>
							</div>
							
							<div class="col-sm-2">
								<div class="form-group">
									<label>Body Part</label>
									<select class="form-control" name="body_parts">
										<option value="none" selected>Select</option>
										@if($parts->count())
											@foreach($parts as $part)
												
												<option value="{{$part->id}}">	{{$part->name}} 	({{$part->view}})
												</option>
											@endforeach
										@endif
										
									</select>
								</div>	
							</div>
							
							<div class="col-sm-2">
								<div class="form-group">
									<label>Gender</label>
									<select class="form-control" name="gender">
										<option value="1" selected>Male</option>
										<option value="2">Female</option>
										<option value="3">Both</option>
									</select>
								</div>	
							</div>
							
							
							<div class="col-sm-2 form-group">
								<label><br></label>
								<button type="button" class="form-control btn btn-light border findSymptom">
								Find
								</button> 
							</div>	
						</div><!--row-->
				</div><!--card-body-->
			</div>	<!--card-->
					
				<div class="card my-2">
					<div class="card-body">
						<div class="question-box">
							<div class="questions hidden my-1">
								
								<div>
									<label class='strong'>Question <span class="hidden q-counter">0</span></label>
									<input type="text" class="form-control" name="questions[]" disabled required>
								</div>
								
							</div>
							
							<div class="hidden answers my-2">
								
								<div class="row answer-box">
									<div class="col-sm-6">
										<label class='strong'>Answer</label>
										<input type="text" class="form-control" name="q0answer[]" disabled required>
									</div>
									
									<div class="col-sm-6">
										<div class="answer-warning-text">
								
											<label class="strong">Warning</label>
											<input type="text" class="form-control" name="q0answer_warning[]" disabled>
											
										</div>
									</div>
									<div class="col">
										<div class="defaultDiseasesScores"></div>
									</div>
								</div>
								
								<!--<div class="q0-a0-defaultDiseasesScores"></div>-->

								
								<div class="addMoreAnswers"></div>
								
								<div class="float-right">
									<span class="hidden ans-counter">0</span>
									<span class="hidden disease-counter">0</span>
									<button type="button" class="btn btn-primary my-2 add-answers-btn">
										Add more answers <i class="fas fa-plus-circle"></i>
									</button>
								</div>
								<div class="clearfix"></div>
								
							</div>
							
							
							<div class="hidden ans-warning">
								
								<div class="addMoreQuestions"></div>
								
								<div class="my-2">
									
									<button type="button" class="btn btn-primary add-questions-btn">
										Add more questions <i class="fas fa-plus-circle"></i>
									</button>
									
								</div>
								
							</div>
							
						</div><!--question-box-->
						
						<div class="form-group row my-2">
							<input type="submit" class="btn btn-primary col-sm-3 mx-auto" name="upload" value="Upload" disabled>
						</div>
				</div><!--card-body-->
			</div><!--card-->
		</form>     
    </div>
@endsection
