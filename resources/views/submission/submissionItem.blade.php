@extends('layouts.master')

@section('body')
    <div class="container">
    <div class="row my-3">
            <a href="{{route("submission")}}" class="btn btn-primary col-md-2"> <i class="fas fa-arrow-circle-left"></i> Submissions </a>
        </div>
        <h2 class="text-center my-3"> User Submission</h2>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header"></div>
                    <div class="card-body">
                    @foreach($submissions as $item)
                        @include('common/reuse-item',['item'=>$item])

                            @if(isset($approved))
                                <div class="text-center mt-5 text-center">
                                    <i class="fas fa-lock mx-auto"></i> Approved submissions cannot be edited or deleted.
                                </div>
                            @else
                                <span class="text-center">
                                        <a style="margin: 25px 10px 0px 10px" href="{{route('submissionEdit')."/".$type."/".$item->id}}" class="btn btn-primary"> Edit </a>
                                </span>
                                <form action={{ route('deleteUnapproved') }} method="POST">
                                    {{ csrf_field() }}
                                    <input type="text" name="type" style="display: none;" value="{{$type}}">
                                    <input type="number" name="id" style="display: none;" value="{{$item->id}}">
                                    <button style="float:right;margin:-40px 10px 10px 10px;" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal" type="button">Delete</button>

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
                                            <button type="button" class="btn btn-danger" type="submit" onClick="javascript:this.form.submit();">Confirm Delete</button>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                </form>
                            @endif
                    @endforeach

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection