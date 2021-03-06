@extends('layouts.master')

@section('body')
  <link href=" {{ URL::asset('css/backgroundStyle.css') }}" rel="stylesheet">
  <div class="container">
        <div class="row my-3">
            <a href="{{route("adminUserSubmissionView")}}" class="btn btn-primary col-md-2"> <i class="fas fa-arrow-circle-left"></i> All Submissions </a>
        </div>
    <div class="card">
      <div align="center" class="card-header">
        <h2>Approved County Submissions</h2>
      </div>
      @foreach($countySubmissions as $countyName => $countyArray)
        <div align="left" class="mt-4 ml-2">
          <h3>{{$countyName}}</h3>
        </div>

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
            @foreach($countyArray as $county)
                <tr>
                    <th scope="row">{{$loop->index+1}}</th>
                    <td><a href="{{route('viewUser',['user_id' => $county->user->id])}}">{{$county->user->name}}</a>
                    <td> {{$county->source->node_name}}</td>
                    <td>{{$county->destination->node_name}}</td>
                    <td> <h5>{!! $county->allowed->getAllowedTextBadge() !!}</h5></td>
                    <td> {{$county->getTimeSubmittedAsString()}}</td>
                    <td>
                        <a href="{{route('viewSubmission', ["type" => $county->getLocationType(), "state" => $county->getStatus(), "itemId" => $county->id, "back" => url()->full()])}}" class="btn btn-primary"> View </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endforeach
    </div>
  </div>
@endsection
