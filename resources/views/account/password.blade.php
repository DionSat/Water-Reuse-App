@extends('layouts.master')

@section('body')
    <div class="container">
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @elseif(session('nothing'))
            <div class="alert alert-warning" role="alert">
                {{ session('nothing') }}
            </div>
        @elseif (session('danger'))
            <div class="alert alert-danger" role="alert">
                {{ session('danger') }}
            </div>
        @endif
        <form action={{ route('changePassword') }} method="POST">
            {{ csrf_field() }}
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="inputPasswordOld1">Old Password</label><input type="password" class="form-control"
                                                                              name="inputPasswordOld1"
                                                                              placeholder="Password">
                </div>
                <div class="form-group col-md-4">
                    <label for="inputPasswordOld2">Verify Password</label>
                    <input type="password" class="form-control" name="inputPasswordOld2"
                           placeholder="Re-enter Password">
                </div>

            </div>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label
                        for="newPW">New Password</label>
                    <input type="password" class="form-control" name="newPW" placeholder="New Password">
                </div>
                <div class="form-group col-md-4">
                    <label
                        for="newPW2">Verify new password</label>
                    <input type="password" class="form-control" name="newPW2" placeholder="Verify new Password">
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
@endsection
