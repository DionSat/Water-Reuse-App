@extends('layouts.master')

@section('body')
    <div class="container">
        <div class="row my-3">
            <a href="{{route("admin")}}" class="btn btn-primary col-md-2"> <i class="fas fa-arrow-circle-left"></i> Dashboard </a>
        </div>
        <h2 class="text-center"> Add County </h2>
        <form method="POST" action="{{ route('countyAddSubmit') }}">
            {{ csrf_field() }}
            <div class="form-row mt-3 justify-content-center">
                <div class="col-md-4 input-group">
                    <div class="input-group-prepend">
                        <label class="input-group-text"> County Name </label>
                    </div>
                    <input type="text" class="form-control" id="county" name="county" placeholder="New county name...">
                </div>
                <div class="col-md-4 input-group">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="state"> State </label>
                    </div>
                    <select id="state" name="state" class="form-control">
                        @foreach($states as $state)
                            <option value="{{$state->state_id}}"> {{$state->stateName}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-row mt-5 justify-content-center">
                <div class="col-md-4">
                    <button type="submit" class="btn btn-success w-100"> <i class="fas fa-plus-circle"></i> Add County </button>
                </div>
            </div>
        </form>
    </div>

@endsection
