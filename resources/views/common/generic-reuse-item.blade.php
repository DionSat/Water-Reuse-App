@extends('layouts.master')

@section('body')
    <div class="container">
        <div class="row my-3">
            <a href="{{url()->previous()}}" class="btn btn-primary col-md-2"> <i class="fas fa-arrow-circle-left"></i> Back </a>
        </div>
        <h2 class="text-center my-3"> Reuse Item Detail View </h2>
        <div class="row justify-content-center">
            <div class="col-md-8">
                @if(($item->getStatus() != "approved" && $item->user_id === Auth::user()->id) || Auth::user()->is_admin)
                    <div class="my-3 row d-flex justify-content-between">
                        <span class="text-center col-md-4">
                            <a href="{{route('submissionEdit')."/".$type."/".$state."/".$item->id}}" class="btn btn-primary btn-block"> Edit </a>
                        </span>
                        <span class="text-center col-md-4">
                        <button class="btn btn-danger btn-block" data-toggle="modal" data-target="#exampleModal" type="button">Delete</button>
                        </span>
                    </div>
                @else
                    <div class="text-center mt-5 text-center">
                        <i class="fas fa-lock mx-auto"></i> Approved submissions cannot be edited or deleted.
                    </div>
                @endif
                @include('common/reuse-item-detail',['item'=>$item])
            </div>
        </div>
    </div>

    <!-- Modal -->
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
                    <form action="{{ route('deleteUnapproved') }}" method="POST">
                        {{ csrf_field() }}
                        <input type="text" name="type" style="display: none;" value="{{$type}}">
                        <input type="number" name="id" style="display: none;" value="{{$item->id}}">
                        <button type="submit" class="btn btn-danger">Confirm Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection