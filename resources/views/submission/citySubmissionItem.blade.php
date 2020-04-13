@extends('layouts.master')

@section('body')
    <div class="container">
    <div class="row my-3">
            <a href="{{route("submission")}}" class="btn btn-primary col-md-2"> <i class="fas fa-arrow-circle-left"></i> City Submissions </a>
        </div>
        <h2 class="text-center my-3"> User Submission</h2>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header"></div>
                    <div class="card-body">
                    @foreach($citySubmissions as $city)
                        @include('common/reuse-item',['item'=>$city])
                    @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection