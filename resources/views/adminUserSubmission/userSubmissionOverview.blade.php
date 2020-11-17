@extends('layouts.master')

@section('body')
    <h2 class="text-center text-light my-3"> Pending User Submissions by Location </h2>
    <div class="text-center text-light">These re-use submissions are awaiting administrator approval and are not shown to users in search results.</div>
    <div class="container mt-5">
        <div class="row justify-content-center">
            @foreach($locationCards as $card)
                <div class="col-md-4">
                    <div class="card h-100 shadow">
                        <div class="card-body">
                            <div class="text-center">
                                    <h4 class="card-title">{{$card["title"]}}</h4>
                                    <h2 class=" text-muted lead"> {{$card["count"]}} Pending </h2>
                            </div>
                        </div>
                        <div class="card-footer">
                            <a href="{{$card["view"]}}" class="btn btn-primary d-block"> <i class="fas fa-edit"></i> View </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <hr class="mt-5">

        <h2 class="text-center text-light my-3"> Approved User Submissions by Location </h2>
        <div class="text-center text-light">These re-use submissions are approved and shown to users in search results.</div>
        <div class="container mt-5">
            <div class="row justify-content-center">
                @foreach($mergeCards as $card)
                    <div class="col-md-4">
                        <div class="card h-100 shadow">
                            <div class="card-body">
                                <div class="text-center">
                                    <h4 class="card-title">{{$card["title"]}}</h4>
                                    <h2 class=" text-muted lead"> {{$card["count"]}} Approved </h2>
                                </div>
                            </div>
                            <div class="card-footer">
                                <a href="{{$card["view"]}}" class="btn btn-success d-block"> <i class="fas fa-eye"></i> View </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
@endsection
