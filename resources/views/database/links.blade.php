@extends('layouts.master')

@section('body')
    <div class="container">
        <div class="row my-3">
            <a href="{{route("database")}}" class="btn btn-primary col-md-2"> <i class="fas fa-arrow-circle-left"></i> Dashboard </a>
        </div>
        <h2 class="text-center"> Links </h2>
        <div class="table-responsive text-align-center ">
            <table class="table w-auto mx-auto mt-4 text-center">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Link Text</th>
                    <th scope="col">Status</th>
                    <th scope="col">Last Update</th>
                    <th scope="col" colspan="2">Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($links as $link)
                    <tr>
                        <th scope="row">{{$loop->index+1}}</th>
                        <td>{{$link->name}}</td>
                        <td>{{$link->linkText}}</td>
                        <td><span class="badge @if($link->status === 'valid') badge-success @elseif($link->status === 'broken')
                                badge-danger @else badge-warning @endif">{{$link->status}}</span></td>
                        <td>{{$link->updated_at}}</td>
                        <td>
                            <form method="POST" action="{{ route('deleteLink') }}">
                                {{ csrf_field() }}
                                <input id="delete" name="delete" value="delete" hidden>
                                <input id="linkId-{{$link->link_id}}" name="link_id" value="{{$link->link_id}}" hidden>
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                        <td>
                            <a href="{{route('modifyLink', ['link_id' => $link->link_id])}}" class="btn btn-primary"><i class="fas fa-edit" aria-hidden="true"></i> Modify </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="d-flex justify-content-center">
                    {{ $links->links() }}
            </div>

        </div>
    </div>

@endsection

@push('css')
    <style>
        /*
        .table th {
            text-align: center;
        }

        .table td {
            text-align: center;
        }
    </style>

@endpush
