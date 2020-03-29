@extends('layouts.master')

@section('body')
    <div class="container">
        <div class="row my-3">
            <a href="{{$backRoute}}" class="btn btn-primary col-md-2"> <i class="fas fa-arrow-circle-left"></i> {{$backName}} </a>
        </div>
        <h2 class="text-center text-danger"> Oops, {{$item}} has dependencies! </h2>
        <h5 class="text-center mt-4 w-75 mx-auto">The database item ({{$item}}) is linked to by the following {{$dependantCategory}}.
                                                    Please delete these items before deleting "{{$item}}". </h5>
        <ul class="list-group w-25 mx-auto mt-4">
            @foreach($dependantItems as $dependantItem)
                <li class="list-group-item"> {{$dependantItem}} </li>
            @endforeach
        </ul>
    </div>

@endsection