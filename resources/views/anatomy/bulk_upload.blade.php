@extends('layouts.app')

@section('content')
	
    <div class="main" id="app">
       	
		<h3 class="my-2">Anatomy parts upload</h3>
		
		<form action="{{route('parts-upload')}}" method="post" enctype="multipart/form-data">
			@csrf
			<div class="card">
				<div class="card-body">
					
					<div class="form-group">
						<input type="file" class="form-control" name="bulk_upload" value="Upload parts" accept='csv'>
					</div>
					
					<input type="submit" class="btn btn-primary" value="Parts upload">
				</div><!--card-body-->
			</div><!--card-->
		</form> 

		<h3 class="my-2">Anatomy Sub parts upload</h3>

		<form action="{{route('sub-parts-upload')}}" method="post" enctype="multipart/form-data">
			@csrf
			<div class="card">
				<div class="card-body">
					
					<div class="form-group">
						<input type="file" class="form-control" name="bulk_upload" value="Upload parts" accept='csv'>
					</div>
					
					<input type="submit" class="btn btn-primary" value="Sub parts upload">
				</div><!--card-body-->
			</div><!--card-->
		</form>     
		
    </div>
@endsection
