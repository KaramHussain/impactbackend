@extends('layouts.app')

@section('content')
	
    <div class="main" id="app">
       	
		<h3 class="my-2">Anatomy</h3>
		
		<form action="{{route('symptoms-and-diseases-upload')}}" method="post">
			@csrf
			<div class="card">
				<div class="card-body">
					
						<div class="row">
                            
							<div class="col-sm-6">
								<div class="form-group">
									<label>Gender</label>
									<select class="form-control" name="gender">
										<option value="1" selected>Male</option>
										<option value="2">Female</option>
										<option value="3">Both</option>
									</select>
								</div>	
							</div>
							
							<div class="col-sm-6">
								<div class="form-group">
									<label>Body Part</label>
									<select class="form-control" name="body_parts[]" multiple id="body_parts">
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
							
						</div>
						
						<div>
							
							<div>
								<div class="form-group">
									<label>Symptom</label>
									<input type="text" class="form-control" name="symptom" required id="symptomFinder">
								</div>	
							</div>
							
					
						</div>
						
						<div id="diseases-row">

							@foreach($diseases as $disease)
								<div class="diseases-row-data row">
								
									<div class="col-sm-6">
										<div class="form-group">
											<label>Disease</label>
											<input type="text" class="form-control" name="disease[]" required value="{{$disease->disease}}" readonly>
										</div>	
									</div>
									
									<div class="col-sm-4">
										<div class="form-group">
											<label>Score</label>
											<input type="text" class="form-control" name="score[]" required value="{{$disease->disease_score}}">
											
										</div>
									</div>

									<div class="form-group">
										<div>
											<label>Action</label> <button type="button" class="btn btn-danger btn-sm delete-disease-row form-control"><i class="fa fa-times"></i></button>
										</div>
									</div>

								</div>
							@endforeach
							
												
						</div>
						
						<div id="addMoreDiseases"></div>
						
						<div>
							<div>
								<div>
									<button type="button" class="btn btn-primary add-diseases-btn">
										Add more <i class="fas fa-plus-circle"></i>
									</button>
								</div>
							</div>							
						</div>
						
						
						<div>
							
							<div>
								<br><label>Do this symptom has warning?</label><br>
								<div class="form-check form-check-inline">
								  <input class="form-check-input" type="radio" name="has_warning" value="1">
								  <label class="form-check-label">Yes</label>
								</div>
								
								<div class="form-check form-check-inline">
								  <input class="form-check-input" type="radio" name="has_warning" value="0" checked>
								  <label class="form-check-label">No</label>
								</div>
								
							</div>
						</div>
						
						<div>
							<div class="warnings hidden">
								<div>
									<div class="form-group">

										<label>Warning</label>
										<input type="text" class="form-control" name="symptom_warning" disabled required>
									</div>	
								</div>
							</div>
						</div>
						
						
						<div class="form-group row my-2">
							<input type="submit" class="btn btn-primary col-sm-3 mx-auto" name="upload" value="Upload">
						</div>

				</div><!--card-body-->
			</div><!--card-->
		</form>     
    </div>
@endsection
