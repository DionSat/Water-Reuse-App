@extends('layouts.master')

@section('body')
  <div class="container">
    <div class="row my-3">
      <a href="{{route("adminUserSubmissionView")}}" class="btn btn-primary col-md-2"> <i
          class="fas fa-arrow-circle-left"></i> All Submissions </a>
    </div>

    <h2 class="text-center"> Approved State Submissions </h2>
    @foreach($stateSubmissions as $stateName => $stateArray)
      <div class="mx-auto">
        <h3>{{$stateName}}</h3>
      </div>
      <div class="table-responsive-md">
        <table class="table mt-4 mx-auto">
          <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">User</th>
            <th scope="col">Source</th>
            <th scope="col">Destination</th>
            <th scope="col">Allowed</th>
            <th scope="col">Time Submitted</th>
            <th scope="col">View</th>
          </tr>
          </thead>
          <tbody>
          @foreach($stateArray as $submission)
            <tr>
              <th scope="row">{{$loop->index+1}}</th>
              <td><a href="{{route('viewUser',['user_id' => $submission->user->id])}}">{{$submission->user->name}}</a>
              <td> {{$submission->source->node_name}}</td>
              <td>{{$submission->destination->node_name}}</td>
              <td><h5>{!! $submission->allowed->getAllowedTextBadge() !!}</h5></td>
              <td> {{$submission->getTimeSubmittedAsString()}}</td>
              <td>
                <a
                  href="{{route('viewSubmission', ["type" => $submission->getLocationType(), "state" => $submission->getStatus(), "itemId" => $submission->id, "back" => url()->full()])}}"
                  class="btn btn-primary"> View </a>
              </td>
            </tr>
          @endforeach
          </tbody>
        </table>
      </div>
    @endforeach
  </div>


@endsection
