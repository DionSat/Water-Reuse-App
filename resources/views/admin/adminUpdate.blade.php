@extends('layouts.master')

@section('body')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div align="center" class="card-header"><h3>Users</h3></div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        @if(session('nothing'))
                            <div class="alert alert-warning" role="alert">
                                {{ session('nothing') }}
                            </div>
                        @endif
                        <form action={{ route('updateUser') }} method="POST">
                            {{ csrf_field() }}
                            <table id="userTable" class="table">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Admin</th>
                                    <th scope="col">Toggle Admin</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($allUsers as $user)
                                    <tr>
                                        <th scope="row">{{$user->id}}</th>
                                        <td>{{$user->name}}</td>
                                        <td>{{$user->email}}</td>
                                        @if($user->is_admin === true)
                                            <td>Yes</td>
                                        @else
                                            <td>No</td>
                                        @endif
                                        <td><input type="checkbox" name="userId[]" value={{$user->id}}></td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <button type="submit" class="btn btn-primary">
                                {{ __('Update Admins') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('css')
    <style>
        .table th {
            text-align:center;
        }
        .table td {
            text-align: center;
        }
    </style>
@endpush
