@extends('layouts.master')

@section('body')
    <div class="container">
        <div class="row my-3">
            <a href="{{url()->previous()}}" class="btn btn-primary col-md-2"> <i class="fas fa-arrow-circle-left"></i> Back </a>
        </div>
        <h2 class="text-center"> Add Allowed Type </h2>
        <form method="POST" action="{{ route('allowedAddSubmit') }}">
            {{ csrf_field() }}
            <div class="form-row mt-3 justify-content-center">
                <div class="col-md-4 input-group">
                    <div class="input-group-prepend">
                        <label class="input-group-text"> Allowed Text </label>
                    </div>
                    <input type="text" class="form-control" id="allowedText" name="allowedText" placeholder="Yes...No...Sometimes...">
                </div>
            </div>
            <div class="form-row mt-5 justify-content-center">
                <div class="col-md-4">
                    <button type="submit" class="btn btn-success w-100"> <i class="fas fa-plus-circle"></i> Add Allowed Type </button>
                </div>
            </div>
        </form>
    </div>

@endsection
