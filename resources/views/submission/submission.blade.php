@extends('layouts.master')

@section('body')
    <div class="container">
        <h3 class="text-center">Heres what you submitted:</h3>
        <table class="table w-75 mt-4 mx-auto">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Source</th>
                    <th scope="col">Destination</th>
                    <th scope="col">View</th>
                    <th scope="col">Status</th>
                </tr>
            </thead>
            <tbody>
            @php
            $a = 1
            @endphp
                @foreach($stateSubmissions as $state)
                    <tr>
                        <th scope="row">{{$a++}}</th>
                        <td> {{$state->source->node_name}}</td>
                        <td>{{$state->destination->node_name}}</td>
                        <td>
                            <a href="{{route('stateSubmission')."/".$state->id}}" class="btn btn-primary"> View </a>
                        </td>
                        <td>Pending</td>
                    </tr>
                @endforeach
                @foreach($citySubmissions as $city)
                    <tr>
                        <th scope="row">{{$a++}}</th>
                        <td> {{$city->source->node_name}}</td>
                        <td>{{$city->destination->node_name}}</td>
                        <td>
                            <a href="{{route('citySubmission')."/".$city->id}}" class="btn btn-primary"> View </a>
                        </td>
                        <td>Pending</td>
                    </tr>
                @endforeach
                @foreach($countySubmissions as $county)
                    <tr>
                        <th scope="row">{{$a++}}</th>
                        <td> {{$county->source->node_name}}</td>
                        <td>{{$county->destination->node_name}}</td>
                        <td>
                            <a href="{{route('countySubmission')."/".$county->id}}" class="btn btn-primary"> View </a>
                        </td>
                        <td>Pending</td>
                    </tr>
                @endforeach
                @foreach($stateApproved as $stateAp)
                    <tr>
                        <th scope="row">{{$a++}}</th>
                        <td> {{$stateAp->source->node_name}}</td>
                        <td>{{$stateAp->destination->node_name}}</td>
                        <td>
                            <a href="{{route('stateApprove')."/".$stateAp->id}}" class="btn btn-primary"> View </a>
                        </td>
                        <td>Approved</td>
                    </tr>
                @endforeach
                @foreach($cityApproved as $cityAp)
                    <tr>
                        <th scope="row">{{$a++}}</th>
                        <td> {{$cityAp->source->node_name}}</td>
                        <td>{{$cityAp->destination->node_name}}</td>
                        <td>
                            <a href="{{route('cityApprove')."/".$cityAp->id}}" class="btn btn-primary"> View </a>
                        </td>
                        <td>Approved</td>
                    </tr>
                @endforeach
                @foreach($countyApproved as $countyAp)
                    <tr>
                        <th scope="row">{{$a++}}</th>
                        <td> {{$countyAp->source->node_name}}</td>
                        <td>{{$countyAp->destination->node_name}}</td>
                        <td>
                            <a href="{{route('countyApprove')."/".$countyAp->id}}" class="btn btn-primary"> View </a>
                        </td>
                        <td>Approved</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection