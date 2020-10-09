@extends('layouts.master')

@section('body')
    <div class="container-fluid">
        <div class="row mb-5">
            <div class="col-md-9 mx-auto">
                <div class="card">
                    <div class="card-title jumbotron bg-white text-center">
                        <h1>Welcome to the Water Reuse Permit App!</h1>
                        <div class="card-subtitle">
                            <h2>You have successfully logged in.</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-3">
                <div class="card h-100 text-center">
                    <div class="card-header">
                        <h3>Overview</h3>
                    </div>
                    <div class="card-body text-center">
                        <div class="card-text">
                            <p>Status of your submission items</p>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <a href="{{route('submission')}}" type="button" class="btn btn-secondary" title="Submissions that are pending">Pending<span class="badge badge-light"> {{$pending}}</span></a>
                            </div>
                            <div class="col-sm-4">
                                <a href="{{route('submission')}}"  class="btn btn-success" title="Submissions that have been approved">Approved<span class="badge badge-light"> {{$approved}}</span></a>
                            </div>
                            <div class="col-sm-4">
                                <a href="{{route('submission')}}" class="btn btn-danger" title="Submissions that have been rejected">Rejected<span class="badge badge-light"> {{$rejected}}</span></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card h-100 text-center">
                    <div class="card-header"><h3>Information</h3></div>
                    <div class="card-body">
                        <div class="card-text">
                            <p>Information on using the website </p>
                            <a href="{{route('info')}}" class="btn btn-primary" title="More information about the application">Info</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card h-100 text-center">
                    <div class="card-header">
                        <h3>Links</h3>
                    </div>

                    <div class="card-body justify-content-center">
                        <div class="card-text">
                            <p>Quick navigation</p>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <a class="btn btn-dark" href="{{route('account')}}" title="View/modify account details">View Account</a>
                            </div>
                            <div class="col-sm-6">
                                <a class="btn btn-warning" href="{{route('submission')}}" title="View your submissions">Submissions</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('css')
<style>
    body{
        background: url("img/bird-s-eye-view-of-ocean-during-daytime-2707756.jpg");
        background-size: cover;
    }
</style>
@endpush
