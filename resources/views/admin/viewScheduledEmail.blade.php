@extends('layouts.master')

@section('body')
  <div class="container">
    <a href="{{route("admin")}}" class="btn btn-primary col-md-2"> <i class="fas fa-arrow-circle-left"></i> Back </a>
    <h3 class="text-center mt-5">Scheduled Emails</h3>
    <div class="text-muted text-center"> The users listed below will receive a summary email however often they select.
      Summary emails are sent out at 10am.
    </div>
    <hr>
    <div class="row">
      <div class="col-md-10 mx-auto">
        <table id="userTable" class="table">
          <thead>
          <tr>
            <th scope="col" class="text-center">User Id</th>
            <th scope="col" class="text-center">Name</th>
            <th scope="col" class="text-center">Frequency</th>
            <th scope="col" class="text-center">Email</th>
            <th scope="col" class="text-center">Action</th>
          </tr>
          </thead>
          <tbody>
          @foreach($currentScheduledEmails as $item)
            <tr class="list" id="{{$item->user->id}}">
              <th class="text-center">{{$item->user->id}}</th>
              <td class="text-center"><a
                  href="{{route('viewUser',['user_id' => $item->user->id])}}">{{$item->user->name}}</a></td>
              <td class="text-center" scope="row">Every {{$item->send_interval}} day(s)</td>
              <td class="text-center">{{$item->user->email}}</td>
              <td class="text-center">
                <form method="POST" action="{{route("scheduledEmailsSubmit")}}">
                  {{ csrf_field() }}
                  <input name="req_type" class="d-none" id="type" value="remove">
                  <input name="item_id" class="d-none" id="type" value="{{$item->id}}">
                  <button type="submit" class="btn btn-danger"> Remove</button>
                </form>
              </td>
          @endforeach
          </tbody>
        </table>

        <h5 class="text-center mt-5">
          Schedule Another Summary Email
        </h5>
        <hr>
        <form class="form mt-2" method="POST" action="{{route("scheduledEmailsSubmit")}}">
          {{ csrf_field() }}
          <div class="row">
            <div class="container col-md-5">
              <div class="form-group row">
                <label class="col-form-label col-md text-md-right" for="user_id"> Admin User </label>
                <div class="col-md pl-md-0">
                  <select name="user_id" class="form-control">
                    @foreach($adminUsers as $admin)
                      <option value="{{$admin->id}}"
                              @if(Auth::user()->id === $admin->id) selected @endif> {{$admin->name}}</option>
                    @endforeach
                  </select>
                </div>
              </div>
            </div>
            <div class="container col-md-7">
              <div class="form-group row">
                <label class="col-form-label col-md-6 text-md-right" for="email_frequency">
                  How Often (in days)
                </label>
                <div class="col-md-6 pl-md-0">
                  <input type="number" name="email_frequency" class="form-control" id="email_frequency" value="1">
                </div>
              </div>
            </div>
            <div class="col-md-3">
              <input type="type" name="req_type" class="d-none" id="type" value="add">
            </div>
          </div>
          <div class="row mt-1 justify-content-center">
            <div class="col-md-4">
              <button type="submit" class="btn btn-success btn-block"><i class="fas fa-plus-circle"></i> Schedule
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection

