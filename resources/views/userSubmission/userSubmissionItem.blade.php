@extends('layouts.master')

@section('body')
    <h2 class="text-center my-3"> User Submissions</h2>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header"></div>
                    <div class="card-body">
                    @foreach($stateSubmissions as $item)
                        @include('common/reuse-item',['item'=>$item])
                    @endforeach
                    @foreach($citySubmissions as $item)
                        @include('common/reuse-item',['item'=>$item])
                    @endforeach
                    @foreach($countySubmissions as $item)
                        @include('common/reuse-item',['item'=>$item])
                    @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection