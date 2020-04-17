@extends('layouts.master')

@section('body')
    <h2 class="text-center my-3"> User Submissions</h2>
    <div class="container">
        <h3 class="text-center my-3"> Locations </h3>
        <hr>
        <div class="row">
            @foreach($locationCards as $card)
                <div class="col-md-4">
                    <div class="card h-100 shadow">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="p-2 mr-3 w-75">
                                    <h4 class="card-title">{{$card["title"]}}</h4>
                                </div>
                                <div>
                                    <h1 class="m-3 flex-grow-1 w-100 text-muted"> {{$card["count"]}}</h1>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer">
                            <div class="form-row mt-5 justify-content-center">  
                                <div class="col-md-6">
                                    <a href="{{$card["view"]}}" class="btn btn-primary d-block"> <i class="fas fa-edit"></i> View </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
@endsection