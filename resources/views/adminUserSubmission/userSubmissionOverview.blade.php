@extends('layouts.master')

@section('body')
    <h2 class="text-center my-3"> Pending User Submissions by Location </h2>
    <div class="text-center text-muted">These re-use submissions are awaiting administrator approval and are not shown to users in search results.</div>
    <div class="container mt-5">
        <div class="row justify-content-center">
            @foreach($locationCards as $card)
                <div class="col-md-3">
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
                            <a href="{{$card["view"]}}" class="btn btn-primary d-block"> <i class="fas fa-edit"></i> View </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
@endsection