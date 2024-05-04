@extends('master.app')
<title>{{$title}} - {{config('app.name')}}</title>
@section('content')

  <div class="w-50 mx-auto">
    <h4>Save a life program</h4>
  </div>

  <div class="card w-50 mx-auto my-3">

    <div class="card-header">
        Select age and gender
    </div>

    <div class="card-body">

      <form action="/preventive-care/step/2" method="post">

        @csrf

        <div class="form-group">
          <label for="for">For</label>

          <select class="form-control" id="for" name="for">
            <option value="none">Select</option>
            <option value="me">Me</option>
          </select>

        </div>

        <div class="form-group">

          <label for="age">Age</label>

          <input class="form-control" type="text" name="age" placeholder="Please specify your age" id="age">

        </div>

        <div><label>Gender</label></div>

        <div class="form-check form-check-inline">
          <input class="form-check-input" type="radio" name="gender" id="male" value="1" checked>
          <label class="form-check-label" for="male">Male</label>
        </div>

        <div class="form-check form-check-inline">
          <input class="form-check-input" type="radio" name="gender" id="female" value="2">
          <label class="form-check-label" for="female">Female</label>
        </div>

        <div class="form-group float-right">
          <button type="submit" name="next" class="btn btn-success mt-5 btn-sm">
            Next <i class="fa fa-angle-right"></i>
          </button>
        </div>

      </form>

      <div class="clearfix"></div>

    </div><!--card-body-->

  </div><!--card-->

@endsection
