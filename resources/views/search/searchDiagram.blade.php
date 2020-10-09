@extends('layouts.master')

@section('body')
    <div class="container">
        <div class="navbar">
            <a href="{{route("search")}}" class="btn btn-primary col-md-2 mb-4 float-left"> <i class="fas fa-arrow-circle-left"></i>
                Search Again
            </a>
            <a href="{{route("search-submit")}}?state_id=1&county_id=1&city_id=1&searchType=residential" class="btn btn-primary col-md-2 mb-4 float-right">
                <i class="fas fa-clipboard-list"></i> List Option
            </a>
        </div>
        <div class="card mb-3">
            <div class="card-body">
                <h3 class="text-center"> Do Stuff </h3>
            </div>
        </div>

    </div>
@endsection
