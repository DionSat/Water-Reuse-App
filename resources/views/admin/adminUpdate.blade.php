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
                                    <th scope="col">Contact</th>
                                    <th scope="col">Admin</th>
                                    <th scope="col">Toggle Admin</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($allUsers as $user)
                                    <tr>
                                        <th scope="row">{{$user->id}}</th>
                                        <td><a href="{{route('viewUser',['user_id' => $user->id])}}">{{$user->name}}</a>
                                        </td>
                                        <td>{{$user->email}}</td>
                                        @if($user->can_contact === true)
                                            <td><input type="checkbox" ame="can_contact[]" value={{$user->id}} checked
                                                       disabled></td>
                                        @else
                                            <td><input type="checkbox" disabled>
                                            </td>
                                        @endif
                                        @if($user->is_admin === true)
                                            <td><input type="checkbox"  checked disabled></td>
                                        @else
                                            <td><input type="checkbox"  disabled></td>
                                        @endif
                                        <td><input type="checkbox" name="userId[]" value={{$user->id}}></td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Update Admins') }}
                                </button>
                            </div>

                        </form>
                            <div class="text-center">
                                <button class="btn btn-link">
                                    <a href="mailto:@foreach($allUsers as $user){{$user->email}};@endforeach">
                                        Email all Users
                                    </a>
                                </button>

                            </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection

@push('css')
    <style>
        .table th {
            text-align: center;
        }

        .table td {
            text-align: center;
        }
    </style>
@endpush
