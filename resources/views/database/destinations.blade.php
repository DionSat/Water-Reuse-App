@extends('layouts.master')

@section('body')
    <div class="container">
        <div class="row my-3">
            <a href="{{route("database")}}" class="btn btn-primary col-md-2"> <i class="fas fa-arrow-circle-left"></i> Dashboard </a>
        </div>
        <h2 class="text-center"> Destinations </h2>
        <table class="table w-50 mx-auto mt-4">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Destination</th>
                <th scope="col">Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($destinations as $destination)
                <tr>
                    <th scope="row">{{$loop->index+1}}</th>
                    <td>{{$destination->destinationName}}</td>
                    <td>
                        {{--<form method="POST" action="{{ route('deleteDestination') }}">--}}
                        <form method="POST" action="#">
                            {{ csrf_field() }}
                            <input id="delete" name="delete" value="delete" hidden>
                            <input id="destinationId-{{$destination->destination_id}}" name="destination_id" value="{{$destination->destination_id}}" hidden>
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

@endsection