@extends('layouts.master')

@section('body')
  <link href=" {{ URL::asset('css/backgroundStyle.css') }}" rel="stylesheet">
  <div class="container">
        <div class="row my-3">
            <a href="{{route("adminUserSubmissionView")}}" class="btn btn-primary col-md-2"> <i class="fas fa-arrow-circle-left"></i> All Submissions </a>
        </div>

        <h2 class="text-center text-light"> Pending State Submissions </h2>
        @foreach($stateSubmissions as $stateName => $stateArray)
            <div class="mx-auto text-light">
                <h3>{{$stateName}}</h3>
            </div>
            <table class="table mt-4 mx-auto text-light">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">User</th>
                        <th scope="col">Source</th>
                        <th scope="col">Destination</th>
                        <th scope="col">Allowed</th>
                        <th scope="col">Time Submitted</th>
                        <th scope="col">View</th>
                        <th scope="col">Action</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                        @foreach($stateArray as $submission)
                            <tr>
                                <th scope="row">{{$loop->index+1}}</th>
                                <td><a href="{{route('viewUser',['user_id' => $submission->user->id])}}">{{$submission->user->name}}</a>
                                <td> {{$submission->source->node_name}}</td>
                                <td>{{$submission->destination->node_name}}</td>
                                <td> <h5>{!! $submission->allowed->getAllowedTextBadge() !!}</h5></td>
                                <td> {{$submission->getTimeSubmittedAsString()}}</td>
                                <td>
                                    <a href="{{route('viewSubmission', ["type" => $submission->getLocationType(), "state" => $submission->getStatus(), "itemId" => $submission->id, "back" => url()->full()])}}" class="btn btn-primary"> View </a>
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
