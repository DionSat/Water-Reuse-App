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
            <div class="col-md-9 col-lg-4 my-3 my-lg-0">
                <div class="card h-100 text-center">
                    <div class="card-header">
                        <h3>Overview</h3>
                    </div>
                    <div class="card-body text-center">
                        <div class="card-text">
                            <p>Item Submission Status</p>
                        </div>
                        <div class="row justify-content-around statusButtons">
                            <a href="{{route('submission')}}"  class="btn btn-success">Approved
                                <div>
                                    <h3><span class="badge badge-light"> {{$approved}}</span></h3>
                                </div>
                            </a>
                            <a href="{{route('submission')}}" type="button" class="btn btn-secondary">Pending
                                <div>
                                    <h3><span class="badge badge-light"> {{$pending}}</span></h3>
                                </div>
                            </a>
                            <a href="{{route('submission')}}" class="btn btn-danger">Rejected
                                <div>
                                    <h3><span class="badge badge-light"> {{$rejected}}</span></h3>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-9 col-lg-4">
                <div class="card h-100 text-center">
                    <div class="card-header">
                        <h3>Navigation</h3>
                    </div>

                    <div class="card-body justify-content-center">
                        <div class="card-text">
                            <p>Quick Links</p>
                        </div>
                        <div class="row">
                            <a class="btn btn-primary btn-block" href="{{route('account')}}">View Account</a>
                            <a class="btn btn-primary btn-block" href="{{route('submission')}}">Submissions</a>
                            <a class="btn btn-primary btn-block" href="{{route('info')}}">Website Information</a>
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

    .statusButtons > a {
        font-size: 20px;
        width: 30%;
    }

    @media (max-width: 414px) {
        .statusButtons > a {
            font-size: 16px;
            width: 30%;
        }
    }
</style>
@endpush
