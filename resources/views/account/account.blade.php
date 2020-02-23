@extends('layouts.master')

@section('body')
    <div class="container">
        <div class="card">
            <div class="card-body">
                <button type="button" onclick="window.location='{{ route("updatePage") }}'"
                        class="btn btn-primary">Edit
                    Account Information
                </button>
            </div>
        </div>
@endsection
