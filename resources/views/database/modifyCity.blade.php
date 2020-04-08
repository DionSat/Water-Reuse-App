@extends('layouts.master')

@section('body')
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
                <div class="card h-100 shadow">
                    <div class="card-header">
                        <h3>Current City</h3>
                        <h4>{{$city->cityName}}</h4>
                    </div>
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroup-sizing-default">New City</span>
                                </div>
                                <input type="text" name="newCityValue" class="form-control" aria-label="Default"
                                       aria-describedby="inputGroup-sizing-default">
                            </div>
                            <input type="text" name="city_id" value="{{$city->city_id}}" hidden>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-success btn-large btn-block"><i class="fas fa-edit"></i> Edit </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
