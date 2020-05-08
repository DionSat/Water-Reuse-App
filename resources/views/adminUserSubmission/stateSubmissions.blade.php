@extends('layouts.master')

@section('body')
    <div class="container">
        <div class="row my-3">
            <a href="{{route("adminUserSubmissionView")}}" class="btn btn-primary col-md-2"> <i class="fas fa-arrow-circle-left"></i> All Submissions </a>
        </div>

        <h2 class="text-center"> State Submissions </h2>
        @foreach($stateSubmissions as $stateName => $stateArray)
            <div class="w-75 mx-auto">
                <h3>{{$stateName}}</h3>
            </div>
            <table class="table w-75 mt-4 mx-auto">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">User</th>
                        <th scope="col">Source</th>
                        <th scope="col">Destination</th>
                        <th scope="col">Allowed</th>
                        <th scope="col">View</th>
                        <th scope="col">Action</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                        @foreach($stateArray as $submission)
                            <tr>
                                <th scope="row">{{$loop->index+1}}</th>
                                <td>{{$submission->user->name}}</td>
                                <td> {{$submission->source->node_name}}</td>
                                <td>{{$submission->destination->node_name}}</td>
                                <td> <h5>{!! $submission->allowed->getAllowedTextBadge() !!}</h5></td>
                                <td>
                                    <a href="{{route('userStateSubmissionItem')."/".$submission->id}}" class="btn btn-primary"> View </a>
                                </td>
                                <td>
                                    <form method="POST" action="{{ route('stateDelete') }}">
                                        {{ csrf_field() }}
                                        <input id="delete" name="delete" value="delete" hidden>
                                        <input id="stateId-{{$submission->id}}" name="id" value="{{$submission->id}}" hidden>
                                        <button type="submit" class="btn btn-danger">Decline</button>
                                    </form>
                                </td>
                                <td>
                                    <form method="POST" action="{{ route('addStateMergeSubmit') }}">
                                        {{ csrf_field() }}
                                        <input id="stateId-{{$submission->id}}" name="id" value="{{$submission->id}}" hidden>
                                        <button type="submit" class="btn btn-success">Approve</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                </tbody>
            </table>
        @endforeach
    </div>
@endsection