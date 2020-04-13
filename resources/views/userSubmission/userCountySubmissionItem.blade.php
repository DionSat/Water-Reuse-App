@extends('layouts.master')

@section('body')
    <div class="container">
    <div class="row my-3">
            <a href= "{{url()->previous()}}" class="btn btn-primary col-md-2"> <i class="fas fa-arrow-circle-left"></i> Submissions </a>
        </div>
        <h2 class="text-center my-3"> User Submission</h2>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header"></div>
                    <div class="card-body">
                    @foreach($countySubmissions as $county)
                        @include('common/reuse-item', ['item'=>$county])
                    @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection