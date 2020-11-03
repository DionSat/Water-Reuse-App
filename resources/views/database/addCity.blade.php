@extends('layouts.master')

@section('body')
    <div class="container">
        <div class="row my-3">
            <a href="{{url()->previous()}}" class="btn btn-primary col-md-2"> <i class="fas fa-arrow-circle-left"></i>
                Back </a>
        </div>
        <div col-lg-8 col-xl-5>
        <div class="card h-100 shadow mx-auto">
            <form method="POST" action="{{ route('cityAddSubmit') }}">
                {{ csrf_field() }}
                <h2 class="card-header text-center"> Add City </h2>
                <div class="card-body mt-3">
                    <div class="row">
                        <div class="container col-md-5">
                            <div class="form-group row">
                                <label class="col-md-5 col-form-label text-md-right pl-md-1"> City Name </label>
                                <div class="col-md-7 pl-md-0 pr-md-1">
                                    <input type="text" class="form-control" id="city" name="city"
                                           placeholder="New city name...">
                                </div>
                            </div>
                        </div>
                        <div class="container col-md-6 ">
                            <div class="form-group row">
                                <label class="col-md-5 col-form-label text-md-right" for="countyState"> County / State </label>
                                <div class="col-md-7 pl-md-0 pr-md-1">
                                    <select name="county" class="form-control" id="countyState">
                                        @foreach($counties as $county)
                                            <option value="{{$county->county_id}}"> {{$county->countyName}}
                                                , {{$county->state->stateName}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-row mt-5 justify-content-center">
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-success w-100"><i class="fas fa-plus-circle"></i>
                                Add
                                City
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        </div>
    </div>

@endsection
