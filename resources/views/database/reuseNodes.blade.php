@extends('layouts.master')

@section('body')
    <div class="container">
        <div class="row my-3 d-flex justify-content-between">
            <div class="col-md-2">
                <a href="{{route("admin")}}" class="btn btn-primary d-block"> <i class="fas fa-arrow-circle-left"></i> Dashboard </a>
            </div>
            <div class="col-md-2">
                <a href="{{route("reuseNodeAdd")}}" class="btn btn-success d-block"> <i class="fas fa-plus-square"></i> Add New </a>
            </div>
        </div>
        <h2 class="text-center"> Reuse Pathway Nodes </h2>
        <table class="table w-75 mx-auto mt-4">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Source</th>
                <th scope="col">Destination</th>
                <th scope="col">Fixture</th>
                <th scope="col" class="text-center" colspan="2">Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($nodes as $node)
                <tr>
                    <th scope="row">{{$loop->index+1}}</th>
                    <td>
                        {{$node->node_name}}
                    </td>
                    <td class="text-center">
                        @if($node->is_source === false)
                            <span style="font-size: 1em; color: red;">
                              <i class="fas fa-times" ></i>
                          </span>
                        @else
                            <span style="font-size: 1em; color: green;">
                              <i class="fas fa-check" ></i>
                          </span>
                        @endif
                    </td>
                    <td class="text-center">
                        @if($node->is_destination === false)
                            <span style="font-size: 1em; color: red;">
                              <i class="fas fa-times" ></i>
                          </span>
                        @else
                            <span style="font-size: 1em; color: green;">
                              <i class="fas fa-check" ></i>
                          </span>
                        @endif
                    </td>
                    <td class="text-center">
                        @if($node->is_fixture === false)
                            <span style="font-size: 1em; color: red;">
                              <i class="fas fa-times" ></i>
                          </span>
                        @else
                            <span style="font-size: 1em; color: green;">
                              <i class="fas fa-check" ></i>
                          </span>
                        @endif
                    </td>
                    <td>
                        <form method="POST" action="{{ route('deleteReuseNode') }}">
                            {{ csrf_field() }}
                            <input id="delete" name="delete" value="delete" hidden>
                            <input id="sourceId-{{$node->node_id}}" name="node_id" value="{{$node->node_id}}" hidden>
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                    <td>
                        <a href="{{route('modifyReuseNode', ['node_id' => $node->node_id])}}" class="btn btn-primary"><i class="fas fa-edit" aria-hidden="true"></i> Modify </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="row mt-4">
            <span class="mx-auto">
                {{ $nodes->links() }}
            </span>
        </div>
    </div>

@endsection
