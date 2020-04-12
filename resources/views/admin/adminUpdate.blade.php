@extends('layouts.master')

@section('body')
<script src="https://code.jquery.com/jquery-1.11.1.min.js" ></script>
<script src="https://cdn.jsdelivr.net/gh/rexeze/formatTimeStamp/src/index-cdn.js" ></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#searchBox').on('input',function(){
            $(".justaclone").remove();
            if ($("#searchBox").val().trim() === "") {
                $('.userListItem').removeAttr('hidden');
            }else{
                var resNum = 0;
                $('.userListItem').attr('hidden', true);
                <?php foreach ($allUsers as $user):?>
                    if("{{$user->name}}".toLowerCase().search($('#searchBox').val()) > -1 || "{{$user->email}}".toLowerCase().search($('#searchBox').val()) > -1){
                        $('#{{$user->id}}').removeAttr('hidden');
                        resNum +=1;
                    }
                <?php endforeach ?>
                $("#searchP").append("<span class='justaclone'>Results: "+resNum+"</span>");
            }
        });
    });
</script>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div align="center" class="card-header"><h3>Users</h3></div>

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
                        <p id="searchP" style="font-size: 0.5em;display: inline-block;">
                            Search Current Page: <input type="text" id="searchBox" style="max-width: 100px;">
                            <div style="float: right;">
                                <form action={{route('searchUsers')}} method="GET" style="display: inline-block;font-size: 0.5em;float: left;">
                                    {{ csrf_field() }}
                                    Search Database: <input type="text" id="searchDB" name="search" style="max-width: 100px;" >
                                    <button type="submit" class="btn btn-primary" style="max-width: 40px;max-height: 20px;font-size:0.7em;margin-bottom: 4px;text-align: center;padding: 2px 4px 6px 4px;">Go</button>
                                </form>
                                @if (!$userListHome)
                                    <button class="btn btn-primary" style="max-width: 40px;max-height: 20px;font-size:0.7em;margin-bottom: 4px;margin-left:2px;text-align: center;padding: 2px 4px 6px 4px;float: right;" onclick="window.location='{{ route('getUsers') }}'">Clear Search</button>
                                @endif
                            </div>
                        </p>
                            <table id="userTable" class="table">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Contact</th>
                                    <th scope="col">Admin</th>
                                    <th scope="col">Toggle Admin</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($allUsers as $user)
                                    <tr class="userListItem" id="{{$user->id}}" title="{{$user->company}},{{$user->jobTitle}},{{$user->city}},{{$user->state}}">
                                        <th scope="row">{{$user->id}}</th>
                                        <td><a href="{{route('viewUser',['user_id' => $user->id])}}">{{$user->name}}</a>
                                        </td>
                                        <td>{{$user->email}}</td>
                                        <td>
                                            <input type="checkbox" disabled style="height: 40px;width: 40px" @if($user->can_contact === true) checked @endif>
                                        </td>
                                        <td>
                                            <input type="checkbox" disabled style="height: 40px;width: 40px;" @if($user->is_admin === true) checked @endif>
                                        </td>
                                        <td>
                                            <form action={{ route('updateUser') }} method="POST">
                                                {{ csrf_field() }}
                                                <input type="number" name="userId" style="display: none;" value={{$user->id}}>
                                                <button type="submit" class="btn btn-primary">
                                                    {{ __('Toggle Admin') }}
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="text-center">
                                {{ $allUsers->links() }}
                                
                            </div>
                            <div class="text-center">
                                <button class="btn btn-link">
                                    <a href="mailto:@foreach($allUsers as $user){{$user->email}};@endforeach">
                                        Email Every User
                                    </a>
                                </button>

                            </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection

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
