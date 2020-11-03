@extends('layouts.master')

@section('body')
    <div class="container">
        <div class="row my-3 d-flex justify-content-between">
            <div class="col-md-3">
                <a href="{{route("admin")}}" class="btn btn-primary d-block"> <i class="fas fa-arrow-circle-left"></i> Dashboard </a>
            </div>
            <div class="col-md-3">
                <a href="{{route("allowedAdd")}}" class="btn btn-success d-block"> <i class="fas fa-plus-square"></i> Add New </a>
            </div>
        </div>
        <h2 class="text-center"> Allowed Types </h2>
        <table class="table table-responsive-lg w-50 mx-auto mt-4">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Allowed Text</th>
                <th scope="col" class="text-center" colspan="2">Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($types as $type)
                <tr>
                    <th scope="row">{{$loop->index+1}}</th>
                    <td>{{$type->allowedText}}</td>
                    <td>
                        <form method="POST" action="{{ route('deleteAllowed') }}">
                            {{ csrf_field() }}
                            <input id="delete" name="delete" value="delete" hidden>
                            <input id="allowedId-{{$type->allowed_id}}" name="allowed_id" value="{{$type->allowed_id}}" hidden>
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                    <td>
                        <a href="{{route('modifyAllowed', ['allowedText' => $type->allowedText, 'allowed_id' => $type->allowed_id])}}" class="btn btn-primary"><i class="fas fa-edit" aria-hidden="true"></i> Modify </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

@endsection
