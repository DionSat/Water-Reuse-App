@extends('layouts.master')

@section('body')
  <div class="container">
    <div class="row my-3">
      <a href="{{url()->previous()}}" class="btn btn-primary col-md-2"> <i class="fas fa-arrow-circle-left"></i>
        Back </a>
    </div>
    <div class="row justify-content-center">
      <div class="col-lg-10">
        <div class="card h-100 mt-5 shadow mx-auto">
          <h2 class="card-header text-center"> Add County </h2>
          <form method="POST" action="{{ route('countyAddSubmit') }}">
            {{ csrf_field() }}
            <div class="card-body mt-3">
              <div class="row">
                <div class="container col-md-5">
                  <div class="form-group row">
                    <label class="col-md-5 col-form-label text-md-right" for="county"> County Name </label>
                    <div class="col-md-7 pl-md-0 pr-md-1">
                      <input type="text" class="form-control" id="county" name="county"
                             placeholder="New county name...">
                    </div>
                  </div>
                </div>
                <div class="container col-md-6">
                  <div class="form-group row">
                    <label class="col-md-5 col-form-label text-md-right" for="state"> State </label>
                    <div class="col-md-7 pl-md-0 pr-md-1">
                      <select id="state" name="state" class="form-control">
                        @foreach($states as $state)
                          <option value="{{$state->state_id}}"> {{$state->stateName}}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                </div>
              </div>
              <div class="form-row mt-5 justify-content-center">
                <div class="col-md-4">
                  <button type="submit" class="btn btn-success w-100"><i
                      class="fas fa-plus-circle"></i>
                    Add County
                  </button>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

@endsection
