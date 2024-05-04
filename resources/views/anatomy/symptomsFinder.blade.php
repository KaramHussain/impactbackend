@extends('layouts.app')

@section('content')
	
    <div class="main" id="app">
       	
		<h3 class="my-2">Anatomy</h3>
		
		<form action="{{route('fetch-old-and-send')}}" method="post" autocomplete="off">
			@csrf
			<div class="card">
				<div class="card-body">
						@csrf
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
								<button type="submit" class="form-control btn btn-light border">
								Find
								</button> 
							</div>	
						</div>
					   
				</div><!--card-body-->
			</div><!--card-->
		</form>     
    </div>
@endsection
