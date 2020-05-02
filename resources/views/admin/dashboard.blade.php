@extends('layouts.master')

@section('body')
    <body onload="onLoad()">
    <div class="container">
        <h2 class="text-center my-4"> Dashboard</h2>
        <hr>
        <nav class="nav nav-pills" style="display: flex; justify-content: center;">
            <a class="nav-link active" onclick="loadStats()" id="svcBtn" data-toggle="tab" style="cursor: pointer;"> Services & Stats </a>
            <a class="nav-link" onclick="loadDBStats()" id="dbBtn" data-toggle="tab" style="cursor: pointer;"> Database </a>
        </nav>
        </br>

        <div class="container" id="statsPage">
            <div class="row justify-content-center">
                @foreach($userAndEmail as $card)
                    <div class="col-md-3">
                        <div class="card h-80 shadow">
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
                                <div class="form-row mt-3 justify-content-center">
                                    <div class="col-md-6">
                                        <a href="{{$card["view"]}}" class="btn btn-primary d-block"> <i class="fas fa-eye"></i> View </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="container" id="dbStatsPage" style="display: none">
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
            <h3 class="mt-5"> Sources, Destinations, and Fixtures</h3>
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
    </div>

@endsection

@push("js")
<script>
    function loadStats() {
        var stats = document.getElementById("statsPage");
        var DBstats = document.getElementById("dbStatsPage");
        var svcBtn = document.getElementById("svcBtn");
        var dbBtn = document.getElementById("dbBtn");
        stats.style.display = "block";
        DBstats.style.display = "none";
    }

    function loadDBStats() {
        var stats = document.getElementById("statsPage");
        var DBstats = document.getElementById("dbStatsPage");
        var svcBtn = document.getElementById("svcBtn");
        var dbBtn = document.getElementById("dbBtn");
        stats.style.display = "none";
        DBstats.style.display = "block";
    }

    function onLoad() {
        var stats = document.getElementById("statsPage");
        var DBstats = document.getElementById("dbStatsPage");
        stats.style.display = "block";
        DBstats.style.display = "none";
    }
</script>
