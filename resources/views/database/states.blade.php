@extends('layouts.master')

@section('body')
    <div class="container">
        <div class="row my-3 d-flex justify-content-between">
            <div class="col-md-3">
                <a href="{{route("admin")}}" class="btn btn-primary d-block"> <i class="fas fa-arrow-circle-left"></i>
                    Dashboard </a>
            </div>
            <div class="col-md-3">
                <a href="{{route("stateAdd")}}" class="btn btn-success d-block"> <i class="fas fa-plus-square"></i> Add
                    New </a>
            </div>
        </div>
        <h2 class="text-center"> States </h2>
        <table class="table w-50 mx-auto mt-4">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">State</th>
                <th scope="col">Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($states as $state)
                <tr>
                    <th scope="row">{{$loop->index+1}}</th>
                    <td>{{$state->stateName}}</td>
                    <td>
                        <form method="POST" action="{{ route('deleteState') }}">
                            {{ csrf_field() }}
                            <input id="delete" name="delete" value="delete" hidden>
                            <input id="stateId-{{$state->state_id}}" name="state_id" value="{{$state->state_id}}"
                                   hidden>
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                    <td>
                        <a href="{{route('modifyState', ['state_id' => $state->state_id])}}" class="btn btn-primary"><i
                                class="fas fa-edit" aria-hidden="true"></i> Modify </a>
                    </td>
                </tr>
            @endforeach

            </tbody>

        </table>
        <div class="row mt-4">
            <span class="mx-auto">
                {{ $states->links() }}
            </span>
        </div>
    </div>



@endsection
