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
@push("css")
    <style>
        body::before {
            content: "";
            position: fixed;
            width: 200%;
            height: 200%;
            top: -50%;
            left: -50%;
            z-index: -1;
            background-size: cover;
            background-image: url('https\3a //scontent.fhio2-1.fna.fbcdn.net/v/t15.5256-10/cp0/e15/q65/p600x600/20505009_401019313628316_6647662209365180416_n.jpg?_nc_cat\3d 102\26 ccb\3d 2\26 _nc_sid\3d ccf8b3\26 _nc_ohc\3d XdbCgFERuygAX-1bAXs\26 _nc_ht\3d scontent.fhio2-1.fna\26 oh\3d 11dfc9e7c7ba03c61b70c4b3b4f3bd0c\26 oe\3d 5FD1716B');
            no-repeat fixed center center;
            transform: scaleY(-1);
            filter: brightness(80%);
        }
    </style>
@endpush

