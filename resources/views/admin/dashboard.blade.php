@extends('layouts.master')

@section('body')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Dashboard</div>
                    <div class="card-body">
                        <form action="{{ route('adminSave') }}" method="POST">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-md-4 mb-2">
                                    <label for="psuid">Name</label>
                                    <input type="text" name="name" class="form-control" value="Dmitri" >
                                </div>
                                <div class="col-md-4 mb-2">
                                    <label for="user_name">Integer to Add</label>
                                    <input type="text" name="integer1" class="form-control" value="5" >
                                </div>
                                <div class="col-md-4 mb-2">
                                    <label for="user_name">Second Integer to Add</label>
                                    <input type="text" name="integer2" class="form-control" value="5" >
                                </div>
                            </div>
                            <hr>
                            <button type="submit" class="btn btn-primary float-right mt-3">Save (new page) <i class="fas fa-check-circle"></i> </button>

                        </form>


                    </div>
                </div>
                <div class="card mt-5">
                    <div class="card-header">Going to function and re-directing back to page</div>
                    <div class="card-body">
                        <form action="{{ route('adminRedirect') }}" method="POST">
                            {{ csrf_field() }}
                            This is for submitting some info, and then going back to the page that submitted it with some message.
                            <hr>
                            <label for="info">Some info:</label>
                            <input type="text" name="info" class="form-control" value="Something..." >


                            <button type="submit" class="btn btn-primary float-right mt-3">Save (redirect back) <i class="fas fa-check-circle"></i> </button>
                        </form>
                    </div>
                </div>
                <button type="button" onclick="window.location='{{ route("getUsers") }}'"
                        class="btn btn-primary"> Update User Privileges
                </button>
            </div>
        </div>
    </div>
@endsection

