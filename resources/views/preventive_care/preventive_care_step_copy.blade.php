@extends('master.app')
<title>{{$title}} - {{config('app.name')}}</title>
@section('content')

  <div class="w-50 mx-auto">
    <h3>Save a life program</h3>
    $
  </div>

  <div class="card w-50 mx-auto my-3">

    <div class="card-header">
      @if ($step == 2)
        Select services which you want to avail
      @elseif ($step == 3)
        Select if any applies
      @elseif ($step == 4)
        Questions
      @elseif ($step == 5)
        Did you avail this service before?
      @elseif ($step == 6)
        When did you last avail this servcice?
      @elseif ($step == 7)
        Finally after the hardwork of 2 weeks and so much struggle and with sleepy eyes you got cpts... :)
      @endif
    </div>

    <div class="card-body">

      @if($step == 2)

        <form action="/preventive-care/step/3" method="post">

          @csrf

          @if (count($services))

            @foreach ($services as $service)

              <div class="form-check my-2">

                <label class="form-check-label">

                  <input name = "services[]" class="form-check-input" type="checkbox" value="{{$service->id}}">

                  {{$service->service}}
                  <span title = "{{$service->definition}}" style="cursor:pointer;">
                    <small><i class="fas fa-question-circle"></i></small>
                  </span>

                </label>

              </div>

            @endforeach

            <div class="form-group float-left">
              <a href="/preventive-care" name="next" class="btn btn-success btn-sm mt-3">
                <i class="fa fa-angle-left"></i> Previous
              </a>
            </div>

            <div class="form-group float-right">
              <button type="submit" name="next" class="btn btn-success btn-sm mt-3">
                Next <i class="fa fa-angle-right"></i>
              </button>
            </div>

          @endif

        </form>


      @endif
      {{-- step 2 --}}

      @if($step == 3)

        <form action="/preventive-care/step/4" method="post">

          @csrf

          @if (count($excludes))

            @foreach($excludes as $exclude)

              <div class="form-check mt-2">
                <input class="form-check-input" type="checkbox" value="{{$exclude->id}}" id="excludes" name="excludes[]">
                <label class="form-check-label" for="excludes">
                  {{$exclude->exclude}}
                </label>
              </div>

            @endforeach

            <div class="form-group float-left">
              <a href="/preventive-care/step/2" class="btn btn-success mt-3 btn-sm">
                <i class="fa fa-angle-left"></i> Previous
              </a>
            </div>

            <div class="form-group float-right">
              <button type="submit" name="next" class="btn btn-success mt-3 btn-sm">
                Next <i class="fa fa-angle-right"></i>
              </button>
            </div>

          @endif

        </form>
      @endif


      @if($step == 4)

        <form action="/preventive-care/step/5" method="post">

          @csrf

          @if(count($questions))

            @foreach($questions as $id=>$question)

              <div class="form-check my-2">
                <input class="form-check-input" type="checkbox" value="{{$id}}" name="questions[]">
                <label class="form-check-label">
                  {{$question}}?
                </label>
              </div>

            @endforeach

            <div class="form-group float-left">
              <a href="/preventive-care/step/2" class="btn btn-success mt-3 btn-sm">
                <i class="fa fa-angle-left"></i> Previous
              </a>
            </div>

            <div class="form-group float-right">
              <button type="submit" name="next" class="btn btn-success mt-3">
                Next <i class="fa fa-angle-right"></i>
              </button>
            </div>

          @endif

        </form>
      @endif

      @if($step == 5)

        <form action="/preventive-care/step/6" method="post">

          @csrf

          @if (count($services))
            <ol>
              @foreach ($services as $service)
                <li class="my-1">
                    {{$service->service}}

                    <span title = "{{$service->definition}}" style="cursor:pointer;">
                      <small><i class="fas fa-question-circle"></i></small>
                    </span>
                </li>

                <div class="form-group ml-3">
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="{{$service->id}}" value="0">
                    <label class="form-check-label">No</label>
                  </div>

                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="{{$service->id}}" value="1" checked>
                    <label class="form-check-label">Yes</label>
                  </div>
                </div>

              @endforeach
            </ol>

            <div class="form-group">
              <button type="submit" name="next" class="btn btn-success mt-3">
                Next <i class="fa fa-angle-right"></i>
              </button>
            </div>

          @endif

        </form>
      @endif

      @if($step == 6)

        <form action="/preventive-care/step/7" method="post">

          @csrf

          @if (count($services))
            @foreach ($services as $service)

              <p>
                <input type="hidden" name="service_id[]" value="{{$service->id}}">
                <strong><span>{{$service->service}}</span></strong>

                <span title = "{{$service->definition}}" style="cursor:pointer;">
                  <small><i class="fas fa-question-circle"></i></small>
                </span>

                <?php

                  $frequencies = DB::table('preventive_service_deps')->where('service_id','=',$service->id)->get(['frequency_id']);

                  $frequency = array();


                  foreach ($frequencies as $freqs)
                  {
                    $id = $freqs->frequency_id;
                    $frequency []= $id;
                  }

                  $frequencies = $class->fetchFrequencies($frequency);

                  foreach($frequencies as $freqs)
                  {
                    ?>

                    <div class="form-check ml-2 my-1">
                      <input class="form-check-input" type="checkbox" name="{{$service->id}}[]" value="{{$freqs->id}}">
                      <label class="form-check-label">{{$freqs->frequency}}</label>
                    </div>

                  <?php
                  }

                ?>

              </p>

            @endforeach


            <div class="form-group">
              <button type="submit" name="next" class="btn btn-success mt-3">
                Next <i class="fa fa-angle-right"></i>
              </button>
            </div>

            </form>

          @endif


      @endif


      @if ($step == 7)
        <p>Cpts you got!</p>
        <ol style="font-weight:bold;">
          @foreach ($cpts as $cpt)
            <li class="my-2">{{$cpt}}</li>
          @endforeach
        </ol>
      @endif


      <div class="clearfix"></div>

    </div><!--card-body-->

  </div><!--card-->

@endsection
