@extends('layouts.master')

@section('body')
<div class="container">
    <a href="{{url()->previous()}}" class="btn btn-primary col-md-2"> <i class="fas fa-arrow-circle-left"></i> Back </a>
        <h3 class="text-center">Email Options</h3>
            <hr>
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div align="center" class="card-header"><h3>All Users Email</h3></div>
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
                                    <table id="userTable" class="table">
                                        <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Name</th>
                                            <th scope="col">Email</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($all as $user)
                                            <tr class="list" id="{{$user->id}}" >
                                                <th scope="row">{{$user->id}}</th>
                                                <td><a href="{{route('viewUser',['user_id' => $user->id])}}">{{$user->name}}</a>
                                                </td>
                                                <td>{{$user->email}}</td>
                                        @endforeach
                                        </tbody>
                                    </table>
                                    <div class="text-center">
                                        {{ $all->appends(['users' => $all->currentPage(), 'contactable' => $canBeEmailed->currentPage()])->links() }}
                                    </div>
                                <div class="text-center">
                                        <a href="mailto:@foreach($allUsers as $user){{$user->email}};@endforeach" class="btn btn-primary">
                                                Email Every User
                                        </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card">
                            <div align="center" class="card-header" data-toggle="tooltip" data-placement="bottom" title="Users that agreed to be contacted by email"><h3>Contact Opt-In Users</h3></div>

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
                                    <table id="userTable" class="table">
                                        <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Name</th>
                                            <th scope="col">Email</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($canBeEmailed as $user)
                                            <tr class="list" id="{{$user->id}}">                                       
                                                <th scope="row">{{$loop->iteration++}}</th>
                                                <td><a href="{{route('viewUser',['user_id' => $user->id])}}">{{$user->name}}</a>
                                                </td>
                                                <td>{{$user->email}}</td>
                                        @endforeach
                                        </tbody>
                                    </table>
                                    <div class="text-center">
                                        {{$canBeEmailed->appends(['users' => $all->currentPage(), 'contactable' => $canBeEmailed->currentPage()])->links()}}
                                    </div>
                                <div class="text-center">
                                        <a href="mailto:@foreach($canEmail as $email){{$email}};@endforeach" class="btn btn-primary">
                                                Email Consenting Users
                                        </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
@endsection

