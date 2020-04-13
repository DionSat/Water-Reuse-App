@extends('layouts.master')

@section('body')
    <div class="container">
    <div class="row my-3">
            <a href="{{route("userSubmission2")}}" class="btn btn-primary col-md-2"> <i class="fas fa-arrow-circle-left"></i> User Submissions </a>
        </div>
        <h2 class="text-center"> State Submissions </h2>
        <table class="table w-75 mt-4 mx-auto">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">user</th>
                    <th scope="col">Source</th>
                    <th scope="col">Destination</th>
                    <th scope="col">View</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <body>
                @foreach($stateSubmissions as $state)
                    <tr>
                        <th scope="row">{{$loop->index+1}}</th>
                        <td>{{$state->user->name}}</td>
                        <td> {{$state->source->sourceName}}</td>
                        <td>{{$state->destination->destinationName}}</td>
                        <td>
                            <a href="{{route('userStateSubmissionItem')."/".$state->id}}" class="btn btn-primary"> View </a>
                        </td>
                        <td>
                            <a class="btn btn-danger">Decline</a>
                            <a class="btn btn-success">Approve</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection