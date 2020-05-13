@extends('layouts.master')

@section('body')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-9 mx-auto">
                <div class="card">
                    <div class="card-title jumbotron bg-white text-center">
                        <h1>Welcome to the Water Reuse Directory!</h1>
                        <div class="card-subtitle">
                            <h2>You have successfully logged in.</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-3">
                <div class="card h-100 text-center">
                    <div class="card-title">
                        <h3>Overview</h3>
                    </div>
                    <div class="card-body">
                        overview here
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center">
                <div class="card-title"><h3>Submit Re-Use items</h3></div>
                    <div class="card-text">
                        <a href="{{route('info')}}" class="badge badge-info">Info Page</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-title">
                        <h3>Links</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>





@endsection
