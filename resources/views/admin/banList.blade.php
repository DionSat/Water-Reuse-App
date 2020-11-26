@extends('layouts.master')

@section('body')
  <link href=" {{ URL::asset('css/backgroundStyle.css') }}" rel="stylesheet">
  <div class="container">
    <div class="row my-3">
      <a href="{{route("admin")}}" class="btn btn-primary col-md-2"> <i class="fas fa-arrow-circle-left"></i> Back
      </a>
    </div>
    <div class="row justify-content-center">
      <div class="col-md-10">
        <div class="card">
          <div class="card-header text-center"><h3>Users</h3></div>

          <div class="card-body">
            @if (session('status'))
              <div class="alert alert-success" role="alert">
                {{ session('status') }}
              </div>
            @endif
            @if(session('nothing'))
              <div class="alert alert-warning" role="alert">
                {{ session('nothing') }}
              </div>
            @endif
            <div class="d-md-flex justify-content-between">
              <div class="col-lg-5">
                <label for="search control-label"> Search Current Page:</label>
                <input type="text" id="search" class="form-control">
              </div>
              <form class="col-lg-5"
                    action={{route('searchUsers', ["type" => "banList"])}} method="GET">
                {{ csrf_field() }}
                <label for="searchDB">Search Database:</label>
                <div class="input-group">
                  <input type="text" id="searchDB" name="search" class="form-control">
                  <div class="input-group-append">
                    <button type="submit" class="btn btn-primary"> Go</button>
                  </div>
                </div>
              </form>
              @if (!$userListHome)
                <button class="btn btn-primary h-50 align-self-md-end float-right float-md-none mt-1 mt-md-0"
                        onclick="window.location='{{ route('banList') }}'">Clear
                </button>
              @endif
            </div>
            </center>
              <div class="table-responsive">
                <table id="userTable" class="table">
                <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Unban User</th>
              </tr>
              </thead>
              <tbody>
              @foreach($users as $user)
                <!--13 is tha ascii value for return and in php its "\r"-->
                <tr data-toggle="tooltip" data-placement="bottom"
                    title="Company: {{$user->company}} &#13Job Title: {{$user->jobTitle}} &#13City: {{$user->city}} &#13State: {{$user->state}}">
                  <th scope="row">{{$user->id}}</th>
                  <td><a href="{{route('viewUser',['user_id' => $user->id])}}">{{$user->name}}</a>
                  </td>
                  <td>{{$user->email}}</td>
                  <td>
                    <form action={{ route('toggleBanUser') }} method="POST">
                      {{ csrf_field() }}
                      <input type="number" name="userId" style="display: none;"
                             value={{$user->id}}>
                      <button type="submit" class="btn btn-primary">
                        Unban
                      </button>
                    </form>
                  </td>
                </tr>
              @endforeach
              </tbody>
            </table>
          </div>

        </div>
      </div>
    </div>
  </div>
@endsection

@push("js")
  <script type="text/javascript">
    //were looking at the usertable and finding the name of a user in the current page
    var $rows = $('#userTable tr');
    $('#search').keyup(function () {
      var value = $.trim($(this).val()).toLowerCase();
      $rows.show().filter(function () {
        var text = $(this).text().toLowerCase();
        //return the first occurrence of the variable
        return !~text.indexOf(value);
      }).hide();
    });
  </script>

  <script type="text/javascript">
    $(document).ready(function () {
      $('#searchBox').on('input', function () {
        $(".justaclone").remove();
        if ($("#searchBox").val().trim() === "") {
          $('.userListItem').removeAttr('hidden');
        } else {
          var resNum = 0;
          $('.userListItem').attr('hidden', true);
          <?php foreach ($users as $user):?>
          if ("{{$user->name}}".toLowerCase().search($('#searchBox').val()) > -1 || "{{$user->email}}".toLowerCase().search($('#searchBox').val()) > -1) {
            $('#{{$user->id}}').removeAttr('hidden');
            resNum += 1;
          }
          <?php endforeach ?>
          $("#searchP").append("<span class='justaclone'>Results: " + resNum + "</span>");
        }
      });
    });
  </script>
@endpush

@push('css')
  <style>
    .table th {
      text-align: center;
    }

    .table td {
      text-align: center;
    }
  </style>
@endpush
