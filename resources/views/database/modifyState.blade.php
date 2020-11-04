@extends('layouts.master')

@section('body')
  <div class="container">
    <div class="row my-3">
      <a href="{{route("stateView")}}" class="btn btn-primary col-md-2"> <i class="fas fa-arrow-circle-left"></i>
        Manage </a>
    </div>
  </div>
  <form method="POST" action="{{route('modifyStateSubmit')}}">
    {{ csrf_field() }}
    <div class="container">
      <div class="row mt-3 mb-5">
        <div class="card h-100 shadow  mx-auto text-center">
          <div class="card-header">
            <h3>Current State</h3>
            <h4>{{$state->stateName}}</h4>
          </div>
          <div class="card-body">
            <div class="d-flex justify-content-center">
              <div class="row mb-3">
                <label class="col-form-label" for="newStateName">New Name</label>
                <div class="col">
                  <input type="text" name="newStateValue" class="form-control" id="newStateName" aria-label="Default"
                         aria-describedby="inputGroup-sizing-default" value="{{$state->stateName}}">
                </div>
              </div>
              <input type="text" name="state_id" value="{{$state->state_id}}" hidden>
            </div>
          </div>
          <div class="card-footer">
            <div class="row">
              <div class="col-md-6">
                <button type="submit" class="btn btn-success btn-large btn-block"><i class="fas fa-edit"></i> Save
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </form>
@endsection
