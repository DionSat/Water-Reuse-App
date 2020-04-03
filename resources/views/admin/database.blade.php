@extends('layouts.master')

@section('body')
    <h2 class="text-center my-3"> Database Dashboard</h2>
    <div class="container">
        <h3 class="mt-4"> Locations </h3>
        <hr>
        <div class="row">
            @foreach($locationCards as $card)
                <div class="col-md-4">
                    <div class="card h-100 shadow">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="p-2 mr-3 w-75">
                                    <h4 class="card-title">{{$card["title"]}}</h4>
                                    <h6 class="card-subtitle mb-2 text-muted">{{$card["subheading"]}}</h6>
                                </div>
                                <div>
                                    <h1 class="m-3 flex-grow-1 w-100 text-muted">  {{$card["count"]}}</h1>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer">
                            <div class="row">
                                <div class="col-md-6">
                                    <a href="{{$card["manageData"]}}" class="btn btn-primary d-block"> <i class="fas fa-edit"></i> Manage </a>
                                </div>
                                <div class="col-md-6">
                                    <a href="{{$card["addData"]}}" class="btn btn-success d-block"> <i class="fas fa-plus-square"></i> Add </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <h3 class="mt-5">Sources and Destinations </h3>
        <hr>

        <div class="row mt-3">
            @foreach($sourcesAndDestinations as $card)
                <div class="col-md-4">
                    <div class="card h-100 shadow">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="p-2 mr-3 w-75">
                                    <h4 class="card-title">{{$card["title"]}}</h4>
                                    <h6 class="card-subtitle mb-2 text-muted">{{$card["subheading"]}}</h6>
                                </div>
                                <div>
                                    <h1 class="m-3 flex-grow-1 w-100 text-muted">  {{$card["count"]}}</h1>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer">
                            <div class="row">
                                <div class="col-md-6">
                                    <a href="{{$card["manageData"]}}" class="btn btn-primary d-block"> <i class="fas fa-edit"></i> Manage </a>
                                </div>
                                <div class="col-md-6">
                                    <a href="{{$card["addData"]}}" class="btn btn-success d-block"> <i class="fas fa-plus-square"></i> Add </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <h3 class="mt-5"> Website Links</h3>
        <hr>

        <div class="row mt-3 mb-5">
            @foreach($linksAndOther as $card)
                <div class="col-md-4">
                    <div class="card h-100 shadow">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="p-2 mr-3 w-75">
                                    <h4 class="card-title">{{$card["title"]}}</h4>
                                    <h6 class="card-subtitle mb-2 text-muted">{{$card["subheading"]}}</h6>
                                </div>
                                <div>
                                    <h1 class="m-3 flex-grow-1 w-100 text-muted">  {{$card["count"]}}</h1>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer">
                            <div class="row">
                                <div class="col-md-6">
                                    <a href="{{$card["manageData"]}}" class="btn btn-primary d-block"> <i class="fas fa-edit"></i> Manage </a>
                                </div>
                                <div class="col-md-6">
                                    <a href="{{$card["addData"]}}" class="btn btn-success d-block"> <i class="fas fa-plus-square"></i> Add </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

@endsection

