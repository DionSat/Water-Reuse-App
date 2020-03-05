@extends('layouts.master')

@section('body')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">User List</div>
                <p>{{$allUsers}}</p>
                
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                        <p>{{$allUsers}}</p>
                    @endif

                        <br>
                        <h3>Here is a list of everyone who's registered:</h3>
                        <ul class="list-group">
                            @foreach($allUsers as $user)
                                <li class="list-group-item">{{$user->name}}</li>
                            @endforeach
                        </ul>

                    <br>
                    <br>
                        <h3>Here is the same thing as a table:</h3>
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($allUsers as $user)
                                    <tr>
                                        <th scope="row">{{$user->id}}</th>
                                        <td>{{$user->name}}</td>
                                        <td>{{$user->email}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

