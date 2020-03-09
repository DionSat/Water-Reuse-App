@extends('layouts.master')

@section('body')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Dashboard</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <h3>Users </h3>
                        <form action={{ route('updateUser') }} method="POST">
                            {{ csrf_field() }}
                            <table class="table">
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
                                            <td>
                                                <button type="submit" value={{$user->id}} name='userId' class="btn btn-sm btn-primary">Revoke Admin
                                                    Access
                                                </button>
                                            </td>
                                        @else
                                            <td>No</td>
                                            <td>
                                                <button type="submit" value={{$user->id}} name='userId' class="btn btn-sm btn-primary">Allow Admin
                                                    Access
                                                </button>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
