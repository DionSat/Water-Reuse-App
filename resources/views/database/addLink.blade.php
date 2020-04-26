@extends('layouts.master')

@section('body')
    <div class="container">
        <div class="row my-3">
            <a href="{{route("database")}}" class="btn btn-primary col-md-2"> <i class="fas fa-arrow-circle-left"></i> Dashboard </a>
        </div>
        <h2 class="text-center"> Add Link </h2>
        <form method="POST" action="{{ route('linkAddSubmit') }}">
            {{ csrf_field() }}
            <div class="form-row mt-3 justify-content-center">
                <div class="col-md-4 input-group">
                    <div class="input-group-prepend">
                        <label class="input-group-text"> Link Name </label>
                    </div>
                    <input type="text" class="form-control" id="name" name="name" placeholder="New link Name">
                </div>
            </div>
            <div class="form-row mt-3 justify-content-center">
                <div class="col-md-4 input-group">
                    <div class="input-group-prepend">
                        <label class="input-group-text"> Link URL </label>
                    </div>
                    <input type="text" class="form-control" id="link" name="link" placeholder="New link URL">
                </div>
            </div>
            <div class="form-row mt-5 justify-content-center">
                <div class="col-md-4">
                    <button type="submit" class="btn btn-success w-100"> <i class="fas fa-plus-circle"></i> Add Link </button>
                </div>
            </div>
        </form>
    </div>

@endsection
