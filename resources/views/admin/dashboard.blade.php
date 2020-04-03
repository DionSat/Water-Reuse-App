@extends('layouts.master')

@section('body')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Dashboard</div>
                    <div class="card-body">

                        <button type="button" onclick="window.location='{{ route("getUsers") }}'"
                                class="btn btn-primary"> View Users
                        </button>

                    </div>
                </div>


            </div>
        </div>
    </div>
@endsection

