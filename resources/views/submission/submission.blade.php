@extends('layouts.master')

@section('body')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif
                <div class="card-header">Dashboard</div>
                <div class="card-body">
                        <h3>Heres what you submitted:</h3>
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