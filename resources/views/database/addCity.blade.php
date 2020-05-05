@extends('layouts.master')

@section('body')
    <div class="container">
        <div class="row my-3">
            <a href="{{route("admin")}}" class="btn btn-primary col-md-2"> <i class="fas fa-arrow-circle-left"></i> Dashboard </a>
        </div>
        <h2 class="text-center"> Add City </h2>
        <form method="POST" action="{{ route('cityAddSubmit') }}">
            {{ csrf_field() }}
            <div class="form-row mt-3 justify-content-center">
                <div class="col-md-4 input-group">
                    <div class="input-group-prepend">
                        <label class="input-group-text"> City Name </label>
                    </div>
                    <input type="text" class="form-control" id="city" name="city" placeholder="New city name...">
                </div>
                <div class="col-md-4 input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"> County / State </span>
                    </div>
                    <select name="county" class="form-control">
                        @foreach($counties as $county)
                            <option value="{{$county->county_id}}"> {{$county->countyName}}, {{$county->state->stateName}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-row mt-5 justify-content-center">
                <div class="col-md-4">
                    <button type="submit" class="btn btn-success w-100"> <i class="fas fa-plus-circle"></i> Add City </button>
                </div>
            </div>
        </form>
    </div>

@endsection
