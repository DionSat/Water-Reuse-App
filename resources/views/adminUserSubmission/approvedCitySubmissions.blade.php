@extends('layouts.master')

@section('body')
    <div class="container">
        <div class="row my-3">
            <a href="{{route("adminUserSubmissionView")}}" class="btn btn-primary col-md-2"> <i class="fas fa-arrow-circle-left"></i> All Submissions </a>
        </div>
        <h2 class="text-center mb-4"> Approved City Submissions </h2>
        @foreach($citySubmissions as $cityName => $cityArray)
            <div class="mx-auto">
                <h3>{{$cityName}}</h3>
            </div>
            <table class="table mt-4 mx-auto">
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
