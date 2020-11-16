@extends('layouts.master')

@section('body')
    <div class="container">
        <div class="row my-3">
            <a href="{{$backUrl}}" class="btn btn-primary col-md-2"> <i class="fas fa-arrow-circle-left"></i> Back </a>
        </div>
        <h2 class="text-center my-3"> Reuse Item Detail View </h2>
        <div class="row justify-content-center">
            @auth
                @if(!empty($item2) && Auth::user()->is_admin > 0)
                    <div class="col-md-6">
                @else
                    <div class="col-md-12">
                @endif
                    @if(($item->getStatus() != "approved" && $item->user_id === Auth::user()->id) || Auth::user()->is_admin)
                        <div class="my-3 row d-flex justify-content-between">
                            <span class="text-center col-md-4">
                                <a href="{{route('submissionEdit', ["type" => $item->getLocationType(), "state" => $item->getStatus(), "itemId" => $item->id, "back" => url()->full(), "previousBack" => $backUrl])}}"
                                   class="btn btn-primary btn-block"> Edit </a>
                            </span>
                            <div class="text-center col-md-4">
                                @if($item->getStatus() != "approved" && Auth::user()->is_admin)
                                    <form method="POST" @if($type==="state") action="{{route('addStateMergeSubmit')}}"
                                          @elseif($type==="county") action="{{route('addCountyMergeSubmit')}}"
                                          @else action="{{route('addCityMergeSubmit')}}"@endif>
                                                                   {{ csrf_field() }}
                                                             <input name="id" value="{{$item->id}}" hidden>
                                        <button type="submit" class="btn btn-success btn-block">Approve</button>
                                    </form>
                                @endif
                            </div>
                            <span class="text-center col-md-4">
                            <button class="btn btn-danger btn-block" data-toggle="modal" data-target="#exampleModal"
                                    type="button">Delete</button>
                            </span>
                        </div>
                    @else
                        <div class="text-center mt-5 text-center">
                            <i class="fas fa-lock mx-auto"></i> Approved submissions cannot be edited or deleted.
                        </div>
                    @endif
                @endauth
                @include('common/reuse-item-detail',['item'=>$item])
            </div>
            @auth
                @if(!empty($item2) && Auth::user()->is_admin > 0)
                    <div class="col-md-6">
                        @if(!empty($item2) && Auth::user()->is_admin)
                            <div class="my-3 row d-flex justify-content-between">
                                <span class="text-center col-md-6">
                                    <a href="{{route('submissionEdit', ["type" => $item2->getLocationType(), "state" => $item2->getStatus(), "itemId" => $item2->id, "returnItemType" => $item->getLocationType(), "returnItemState" => $item->getStatus(), "returnItemId" => $item->id, "back" => url()->full(), "previousBack" => $backUrl])}}"
                                       class="btn btn-primary btn-block"> Edit </a>
                                </span>
                                <span class="text-center col-md-6">
                                    <button class="btn btn-danger btn-block" data-toggle="modal" data-target="#exampleModal2"
                                        type="button">Delete</button>
                                    </span>
                            </div>
                        @else
                            <div class="text-center mt-5 text-center">
                                <i class="fas fa-lock mx-auto"></i> Approved submissions cannot be edited or deleted.
                            </div>
                        @endif
                    @include('common/reuse-item-detail',['item'=>$item2])
                    </div>
                @endif
            @endauth
        </div>
    </div>

    <!-- Modal -->
    @auth
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal-title">Delete Submission Confirmation</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to delete this submission?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <form action="{{ route('deleteItem') }}" method="POST">
                            {{ csrf_field() }}
                            <input type="text" name="back" style="display: none;" value="{{$backUrl}}">
                            <input type="text" name="type" style="display: none;" value="{{$type}}">
                            <input type="text" name="state" style="display: none;" value="{{$item->getStatus()}}">
                            <input type="number" name="id" style="display: none;" value="{{$item->id}}">
                            <button type="submit" class="btn btn-danger">Confirm Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @auth
            @if(!empty($item2) && Auth::user()->is_admin > 0)
                <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modal-title">Delete Submission Confirmation</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                Are you sure you want to delete this submission?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <form action="{{ route('deleteItem') }}" method="POST">
                                    {{ csrf_field() }}
                                    <input type="text" name="back" style="display: none;" value="{{$backUrl}}">
                                    <input type="text" name="type" style="display: none;" value="{{$item2->getLocationType()}}">
                                    <input type="text" name="state" style="display: none;" value="{{$item2->getStatus()}}">
                                    <input type="number" name="id" style="display: none;" value="{{$item2->id}}">
                                    <button type="submit" class="btn btn-danger">Confirm Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endauth
    @endauth
@endsection
