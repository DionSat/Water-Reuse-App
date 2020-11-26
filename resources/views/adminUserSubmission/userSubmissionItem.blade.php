@extends('layouts.master')

@section('body')
  <link href=" {{ URL::asset('css/backgroundStyle.css') }}" rel="stylesheet">
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
                    @foreach($submissions as $item)
                        @include('common/reuse-item-detail',['item'=>$item])
                    @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
