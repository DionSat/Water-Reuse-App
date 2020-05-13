@extends('layouts.master')

@section('body')
    <div class="container">
        <div class="row my-3 d-flex justify-content-between">
            <a href="{{route("admin")}}" class="btn btn-primary col-md-2"> <i class="fas fa-arrow-circle-left"></i> Dashboard </a>

            @if($page === "regular")
                <a href="{{route("linkView", ["type" => "broken"])}}" class="btn btn-danger col-md-3"> <i class="fas fa-unlink"></i> View Broken Links <span class="badge badge-light">{{$brokenLinkCount}}</span></a>
            @else
                <a href="{{route("linkView")}}" class="btn btn-primary col-md-3"> <i class="fas fa-link"></i> View All Links </a>
            @endif

        </div>
        <h2 class="text-center"> Links </h2>
        <div class="table-responsive text-align-center ">
            @if($links->count() === 0)
                <hr>
                <h3 class="text-center"> No links {{$page === "broken" ? "broken" : ""}} found...</h3>
            @else
                <table class="table w-auto mx-auto mt-4 text-center">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Link Text</th>
                        <th scope="col">Status</th>
                        <th scope="col">Last Checked</th>
                        <th scope="col" colspan="2">Actions</th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($links as $link)
                        <tr>
                            <th scope="row">{{$loop->index+1}}</th>
                            <td>{{$link->name}}</td>
                            <td>{{$link->linkText}}</td>
                            <td>{!! $link->getStatusTextBadge() !!}</td>
                            <td>{{$link->getTimeCheckedAsString()}}</td>
                            <td>
                                <form method="POST" action="{{ route('checkLinkStatus') }}">
                                    {{ csrf_field() }}
                                    <input id="linkId-{{$link->link_id}}" name="link_id" value="{{$link->link_id}}" hidden>
                                    <button type="submit" class="btn btn-success" onclick="this.innerHTML='<span>Checking</span><i class=\'fas fa-spinner fa-pulse ml-2\'></i>'">Check Status</button>
                                </form>
                            </td>
                            <td>
                                <a href="{{route('modifyLink', ['link_id' => $link->link_id])}}" class="btn btn-primary"><i class="fas fa-edit" aria-hidden="true"></i> Modify </a>
                            </td>
                            <td>
                                <form method="POST" action="{{ route('deleteLink') }}">
                                    {{ csrf_field() }}
                                    <input id="delete" name="delete" value="delete" hidden>
                                    <input id="linkId-{{$link->link_id}}" name="link_id" value="{{$link->link_id}}" hidden>
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </td>

                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @endif
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
