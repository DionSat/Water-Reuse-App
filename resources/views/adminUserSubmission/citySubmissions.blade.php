@extends('layouts.master')

@section('body')
  <link href=" {{ URL::asset('css/backgroundStyle.css') }}" rel="stylesheet">
  <div class="container">
    <div class="row my-3">
            <a href="{{route("adminUserSubmissionView")}}" class="btn btn-primary col-md-2"> <i class="fas fa-arrow-circle-left"></i> All Submissions </a>
        </div>
        <h2 class="text-center mb-4 text-light"> Pending City Submissions </h2>
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
                        <th scope="col">Action</th>
                        <th scope="col">Action</th>
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
                            <td>
                                <form method="POST" action="{{ route('cityDelete') }}">
                                    {{ csrf_field() }}
                                    <input id="delete" name="delete" value="delete" hidden>
                                    <input id="cityId-{{$city->id}}" name="id" value="{{$city->id}}" hidden>
                                    <button type="submit" class="btn btn-danger">Decline</button>
                                </form>
                            </td>
                            <td>
                                <form method="POST" action="{{ route('addCityMergeSubmit') }}">
                                    {{ csrf_field() }}
                                    <input id="cityId-{{$city->id}}" name="id" value="{{$city->id}}" hidden>
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
