@extends('layouts.app')

@section('content')
	
    <div class="main">

		<h3 class="my-2">Anatomy data</h3>
		
		<div class="float-right">{{$symptoms->links()}}</div>
		<div class="clearfix"></div>
		<div class="table-responsive">
			<table class="table table-striped">
				<th>Id</th>
				<th>Symptom</th>
				<th>Diseases</th>
				<th>Q&As</th>
				<th title="symptoms disease gender body part">SDGP</th>
				<th>Created at</th>
				<th>updated at</th>
				
				@if($symptoms->count())
					
					@foreach($symptoms as $symptom)
						<tr>
							<td>{{$symptom->id}}</td>
							<td>{{$symptom->name}}</td>
							
							<td>
								
								<a data-toggle="modal" data-target="#relatedRecord" href="#" class="btn btn-link fetchRelatedRecord" data-id = "{{$symptom->id}}" data-model="disease">view
									</a>

							</td>

							<td>
								@if($symptom->questions->count())
									<a data-toggle="modal" data-target="#relatedRecord"href="#" class="btn btn-link fetchRelatedRecord" data-id = "{{$symptom->id}}" data-model="question">view
									</a>
									
									@else
									<small><span class="text-muted m-3">Null</span></small>
								@endif

							</td>

							<td>
								<a data-toggle="modal" data-target="#relatedRecord" href="#" class="btn btn-link fetchRelatedRecord" data-id = "{{$symptom->id}}" data-model="symptom_all_diseases">
									view
								</a>
							</td>

							<td>{{$symptom->created_at->diffForHumans()}}</td>
							<td>{{$symptom->updated_at->diffForHumans()}}</td>
						</tr>
					@endforeach
				@else
					<p>No data found</p>
				@endif

			</table>
		</div><!--table-responsive-->

		{{-- records modal --}}
			<div class="modal fade" id="relatedRecord">
			  
			  <div class="modal-dialog modal-dialog-centered">
			    <div class="modal-content">

			      <!-- Modal Header -->
			      <div class="modal-header">
			      	
			        <h4 class="modal-title" id="record-title"></h4>
			        <span class="icon mt-1 hidden">
			      		<i class="fas fa-spinner fa-spin"></i>
			      	</span>
			        <button type="button" class="close" data-dismiss="modal">&times;</button>

			      </div>

			      <!-- Modal body -->
			      <div class="modal-body">
			        <table class="" id="record-content"></table>
			      </div>

			      <!-- Modal footer -->
			      <div class="modal-footer">
			        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
			      </div>

			    </div>

			  </div>
			</div>
		{{-- records modal --}}

		<div class="float-right">{{$symptoms->links()}}</div>
		<div class="clearfix"></div>


    </div>
@endsection


