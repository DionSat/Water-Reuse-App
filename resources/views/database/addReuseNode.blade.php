@extends('layouts.master')

@section('body')
    <div class="container">
        <div class="row my-3">
            <a href="{{route("admin")}}" class="btn btn-primary col-md-2"> <i class="fas fa-arrow-circle-left"></i> Dashboard </a>
        </div>
        <h2 class="text-center"> Add Source, Destination, & Fixture </h2>
        <form method="POST" action="{{ route('reuseNodeAddSubmit') }}">
            {{ csrf_field() }}
            <div class="form-row mt-3 justify-content-center">
                <div class="col-md-4 input-group">
                    <div class="input-group-prepend">
                        <label class="input-group-text"> Source/Destination/Fixture  </label>
                    </div>
                    <input type="text" class="form-control" id="source" name="source" placeholder="Name">
                </div>
            </div>
            <div class="form-row mt-3 justify-content-center">
                <div class="col-md-4">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" id="is_source_checkbox" type="checkbox" name="is_source">
                        <label class="form-check-label" for="is_source_checkbox">Source</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" id="is_destination_checkbox" type="checkbox" name="is_destination">
                        <label class="form-check-label" for="is_destination_checkbox">Destination</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" id="is_fixture_checkbox" type="checkbox" name="is_fixture">
                        <label class="form-check-label" for="is_fixture_checkbox">Fixture</label>
                    </div>
                </div>
            </div>
            <div class="form-row mt-5 justify-content-center">
                <div class="col-md-4">
                    <button type="submit" class="btn btn-success w-100"> <i class="fas fa-plus-circle"></i> Add </button>
                </div>
            </div>
        </form>
    </div>

@endsection
