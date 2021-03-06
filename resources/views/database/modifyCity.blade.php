@extends('layouts.master')

@section('body')
  <link href=" {{ URL::asset('css/backgroundStyle.css') }}" rel="stylesheet">
  <div class="container">
    <div class="row my-3">
      <a href="{{route("cityView")}}" class="btn btn-primary col-md-2"> <i class="fas fa-arrow-circle-left"></i>
        Manage </a>
    </div>
  </div>
  <form method="POST" action="{{route('modifyCitySubmit')}}">
    {{ csrf_field() }}
    <div class="container">
      <div class="row mt-3 mb-5">
        <div class="card h-100 shadow mx-auto text-center">
          <div class="card-header">
            <h3>Current City</h3>
            <h4>{{$city->cityName}}</h4>
          </div>
          <div class="card-body">
            <div class="d-flex justify-content-center">
              <div class="row mb-3">
                <label class="col-form-label" for="newCityName">New Name</label>
                <div class="col">
                  <input type="text" name="newCityValue" class="form-control" id="newCityName" aria-label="Default"
                         aria-describedby="inputGroup-sizing-default" value="{{$city->cityName}}">
                </div>
              </div>
              <input type="text" name="city_id" value="{{$city->city_id}}" hidden>
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
