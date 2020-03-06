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
                                        {{array_push($canEmail,$user->email)}}
                                    @endif
                                    <tr>
                                        <th scope="row">{{$user->id}}</th>
                                        <td>
                                            <a href="{{route(viewuser).'/'.$user->id}}">
                                                {{$user->company}}
                                                @if($user->company &&   $user->jobTitle):@endif
                                                {{$user->jobTitle}}
                                                {{$user->name}}
                                            </a>
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
                            <a href="mailto:@foreach($canEmail as $em){{$em}};@endforeach">
                                Email:{{print_r($canEmail)}}
                            </a>
                        </button>
                </div>
                <hr>
            </div>
        </div>
    </div>
</div>
@endsection

