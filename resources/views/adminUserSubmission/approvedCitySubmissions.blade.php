@extends('layouts.master')

@section('body')
    <div class="container">
        <div class="row my-3">
            <a href="{{route("adminUserSubmissionView")}}" class="btn btn-primary col-md-2"> <i class="fas fa-arrow-circle-left"></i> All Submissions </a>
        </div>
        <h2 class="text-center mb-4 text-light"> Approved City Submissions </h2>
        @foreach($citySubmissions as $cityName => $cityArray)
            <div class="mx-auto text-light">
                <h3>{{$cityName}}</h3>
            </div>
            <table class="table mt-4 mx-auto text-light">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">user</th>
                    <th scope="col">Source</th>
                    <th scope="col">Destination</th>
                    <th scope="col">Allowed</th>
                    <th scope="col">Time Submitted</th>
                    <th scope="col">View</th>
                </tr>
                </thead>
                <tbody>
                @foreach($cityArray as $city)
                    <tr>
                        <th scope="row">{{$loop->index+1}}</th>
                        <td><a href="{{route('viewUser',['user_id' => $city->user->id])}}">{{$city->user->name}}</a>
                        <td> {{$city->source->node_name}}</td>
                        <td>{{$city->destination->node_name}}</td>
                        <td> <h5>{!! $city->allowed->getAllowedTextBadge() !!}</h5></td>
                        <td> {{$city->getTimeSubmittedAsString()}}</td>
                        <td>
                            <a href="{{route('viewSubmission', ["type" => $city->getLocationType(), "state" => $city->getStatus(), "itemId" => $city->id, "back" => url()->full()])}}" class="btn btn-primary"> View </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endforeach
    </div>
@endsection
@push("css")
  <style>

    body::before {
      content: "";
      position: fixed;
      width: 200%;
      height: 200%;
      top: -50%;
      left: -50%;
      z-index: -1;
      background-size: cover;
      background-image: url('https\3a //scontent.fhio2-1.fna.fbcdn.net/v/t15.5256-10/cp0/e15/q65/p600x600/20505009_401019313628316_6647662209365180416_n.jpg?_nc_cat\3d 102\26 ccb\3d 2\26 _nc_sid\3d ccf8b3\26 _nc_ohc\3d XdbCgFERuygAX-1bAXs\26 _nc_ht\3d scontent.fhio2-1.fna\26 oh\3d 11dfc9e7c7ba03c61b70c4b3b4f3bd0c\26 oe\3d 5FD1716B');
      no-repeat fixed center center;
      background-size: cover;
      transform: scaleY(-1);
      filter: brightness(80%);
    }
  </style>
@endpush

