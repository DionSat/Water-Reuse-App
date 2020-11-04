@extends('layouts.master')

@section('body')
  <div class="container">
    <div class="row my-3">
      <a href="{{route("allowedView")}}" class="btn btn-primary col-md-2"> <i class="fas fa-arrow-circle-left"></i>
        Manage </a>
    </div>
  </div>
  <form method="POST" action="{{route('modifyAllowedSubmit')}}">
    {{ csrf_field() }}
    <div class="container">
      <div class="row mt-3 mb-5">
        <div class="card h-100 shadow  mx-auto text-center">
          <div class="card-body">
            <h3 class="card-title">Current Text</h3>
            <h4 class="card-subtitle">{{$allowed->allowedText}}</h4>
            <div class="d-flex mt-3">
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <label class="pr-3" for="newAllowed">New Text</label>
                </div>
                <input type="text" name="newValue" class="form-control" id="newAllowed" aria-label="Default"
                       value="{{$allowed->allowedText}}">
              </div>
              <input type="text" name="allowed_id" value="{{$allowed->allowed_id}}" hidden>
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
