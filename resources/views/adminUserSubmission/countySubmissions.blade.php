@extends('layouts.master')

@section('body')
  <div class="container">
    <div class="row my-3">
            <a href="{{route("adminUserSubmissionView")}}" class="btn btn-primary col-md-2"> <i class="fas fa-arrow-circle-left"></i> All Submissions </a>
        </div>
        <h2 class="text-center mb-4 text-light"> Pending County Submissions </h2>
        @foreach($countySubmissions as $countyName => $countyArray)
            <div class="mx-auto text-light">
                <h3>{{$countyName}}</h3>
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
                            <td>
                                <form method="POST" action="{{ route('countyDelete') }}">
                                    {{ csrf_field() }}
                                    <input id="delete" name="delete" value="delete" hidden>
                                    <input id="countyId-{{$county->id}}" name="id" value="{{$county->id}}" hidden>
                                    <button type="submit" class="btn btn-danger">Decline</button>
                                </form>
                            </td>
                            <td>
                                <form method="POST" action="{{ route('addCountyMergeSubmit') }}">
                                    {{ csrf_field() }}
                                    <input id="countyId-{{$county->id}}" name="id" value="{{$county->id}}" hidden>
                                    <button type="submit" class="btn btn-success">Approve</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endforeach
    </div>
    <h2 class="text-center mb-4"> Pending County Submissions </h2>
    @foreach($countySubmissions as $countyName => $countyArray)
      <div class="mx-auto">
        <h3>{{$countyName}}</h3>
      </div>

      <div class="table-responsive">
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
            <th scope="col">Action</th>
            <th scope="col">Action</th>
          </tr>
          </thead>
          <tbody>
          @foreach($countyArray as $county)
            <tr>
              <th scope="row">{{$loop->index+1}}</th>
              <td><a href="{{route('viewUser',['user_id' => $county->user->id])}}">{{$county->user->name}}</a>
              <td> {{$county->source->node_name}}</td>
              <td>{{$county->destination->node_name}}</td>
              <td><h5>{!! $county->allowed->getAllowedTextBadge() !!}</h5></td>
              <td> {{$county->getTimeSubmittedAsString()}}</td>
              <td>
                <a
                  href="{{route('viewSubmission', ["type" => $county->getLocationType(), "state" => $county->getStatus(), "itemId" => $county->id, "back" => url()->full()])}}"
                  class="btn btn-primary"> View </a>
              </td>
              <td>
                <form method="POST" action="{{ route('countyDelete') }}">
                  {{ csrf_field() }}
                  <input id="delete" name="delete" value="delete" hidden>
                  <input id="countyId-{{$county->id}}" name="id" value="{{$county->id}}" hidden>
                  <button type="submit" class="btn btn-danger">Decline</button>
                </form>
              </td>
              <td>
                <form method="POST" action="{{ route('addCountyMergeSubmit') }}">
                  {{ csrf_field() }}
                  <input id="countyId-{{$county->id}}" name="id" value="{{$county->id}}" hidden>
                  <button type="submit" class="btn btn-success">Approve</button>
                </form>
              </td>
            </tr>
          @endforeach
          </tbody>
        </table>
      </div>
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

