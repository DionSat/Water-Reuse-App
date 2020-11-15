@extends('layouts.master')

@section('body')
    <div class="container">
        <div class="row my-3">
            <a href="{{$backUrl}}" class="btn btn-primary col-md-2"> <i class="fas fa-arrow-circle-left"></i> Back </a>
        </div>
        <h2 class="text-center my-3" style="color:white;"> Reuse Item Detail View </h2>
        <div class="row justify-content-center">
            <div class="col-md-12">
                @auth
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
                        <div class="text-center mt-5 text-light">
                            <i id="icon" class="fas fa-lock mx-auto"></i> Approved submissions cannot be edited or deleted.
                        </div>
                    @endif
                @endauth
                @include('common/reuse-item-detail',['item'=>$item])
            </div>
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
    @endauth
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
        background-size: cover;
        transform: scaleY(-1);
        filter: brightness(80%);
      }

        #icon {
          color: #FFF;
        }
    </style>
@endpush
