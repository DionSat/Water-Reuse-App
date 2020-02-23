@extends('layouts.master')

@section('body')
    <div class="container">
        <div class="card">
            <div class="card-body">
                <button type="button" onclick="window.location='{{ route("updatePage") }}'"
                        class="btn btn-primary"> Edit Account Information
                </button>
                <button type="button" onclick="window.location='{{ route("password") }}'" class="btn btn-primary">
                   Change password
                </button>
            </div>
        </div>
@endsection
