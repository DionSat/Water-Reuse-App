@extends('layouts.master')


@section('body')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">User List</div>                
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                        <p>{{$allUsers}}</p>
                    @endif
<!--
                        <br>
                        <h3>Here is a list of everyone who's registered:</h3>
                        <ul class="list-group">
                            @foreach($allUsers as $user)
                                <li class="list-group-item">{{$user->name}}</li>
                            @endforeach
                        </ul>
-->
                    <br>
                    <br>
                        <h3>User List:</h3>
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Location</th>
                                <th scope="col">Contact</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($allUsers as $user)
                                    {{array_push($emails,$user->email)}}
                                    @if($user->canContact == 1)
                                        {{array_push($canemail,$user->email)}}
                                    @endif
                                    <tr>
                                        <th scope="row">{{$user->id}}</th>
                                        <td>{{$user->company}}
                                            @if($user->company && $user->jobTitle):@endif
                                            {{$user->jobTitle}}
                                            {{$user->name}}
                                        </td>
                                        <td>{{$user->email}}</td>
                                        <td>{{$user->state}}/{{$user->city}}</td>
                                        <td>
                                            <input type="checkbox" @if($user->canContact == 1) checked @endif>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <button>
                            <a href="mailto:@foreach($emails as $em){{$em}};@endforeach">
                                Email to all
                            </a>
                        </button>
                        <button>
                            <a href="mailto:@foreach($emails as $em){{$em}};@endforeach">
                                Email:{{print_r($canemail)}}
                            </a>
                        </button>
                </div>
                <hr>
                <p>{{$allUsers}}</p>
            </div>
        </div>
    </div>
</div>
@endsection

