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
        <table class="table table-responsive-lg w-50 mx-auto mt-4" style="color: white">
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
@push("css")
    <style>
        body::before {
            content: "";
            position: fixed;
            width: 200%;
            height: 200%;
            top: -50%;
            left: -50%;
            z-index: -1;
            background-size: cover;
            background-image: url('https\3a //scontent.fhio2-1.fna.fbcdn.net/v/t15.5256-10/cp0/e15/q65/p600x600/20505009_401019313628316_6647662209365180416_n.jpg?_nc_cat\3d 102\26 ccb\3d 2\26 _nc_sid\3d ccf8b3\26 _nc_ohc\3d XdbCgFERuygAX-1bAXs\26 _nc_ht\3d scontent.fhio2-1.fna\26 oh\3d 11dfc9e7c7ba03c61b70c4b3b4f3bd0c\26 oe\3d 5FD1716B');
            no-repeat fixed center center;
            transform: scaleY(-1);
            filter: brightness(80%);
        }
        .container{
            color: white;
        }
    </style>
@endpush
