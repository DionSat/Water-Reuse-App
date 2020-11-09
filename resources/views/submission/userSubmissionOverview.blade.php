@extends('layouts.master')

@section('body')
    <div class="container">
        <h3 class="text-center" style="color: white">Heres what you submitted:</h3>
        <br>
    <div class="card">
        <table class="table mt-4 mx-auto">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Location</th>
                    <th scope="col">Source</th>
                    <th scope="col">Destination</th>
                    <th scope="col">Time Submitted</th>
                    <th scope="col">View</th>
                    <th scope="col">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($submissions as $submission)
                    <tr>
                        <th scope="row">{{$loop->index+1}}</th>
                        <td>{{$submission->getLocationAsString()}}</td>
                        <td>{{$submission->source->node_name}}</td>
                        <td>{{$submission->destination->node_name}}</td>
                        <td>{{$submission->getTimeSubmittedAsString()}}</td>
                        <td>
                            <a href="{{route('viewSubmission', ["type" => $submission->getLocationType(), "state" => $submission->getStatus(), "itemId" => $submission->id, "back" => url()->current()])}}" class="btn btn-primary"> View </a>
                        </td>
                        <td>{!! $submission->getStatusAsBadge() !!}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
        <div class="row mt-4">
            <span class="mx-auto">
                {{ $submissions->links() }}
            </span>
        </div>
    </div>
@endsection
