@extends('layouts.master')

@section('body')
    <div class="container">
        <a href="{{route("admin")}}" class="btn btn-primary col-md-2"> <i class="fas fa-arrow-circle-left"></i> Back </a>
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
                            <center id="searchP" style="font-size: 0.9em;display: inline-block;margin-bottom: 12px;">
                                <span style="margin-top: 10px">Search Current Page: <input type="text" id="searchBox" style="max-width: 150px;height: 35px;margin-top: 3px;margin-right:30px;"></span>
                                <div style="float: right;">
                                    <form action={{route('searchUsers')}} method="GET" style="display: inline-block;font-size: 1.0em;float: left;margin-top: 2px">
                                        {{ csrf_field() }}
                                        Search Database: <input type="text" id="searchDB" name="search" style="max-width: 150px;height: 35px;" >
                                        <button type="submit" class="btn btn-primary" style="width: 50px;height: 38px;font-size:1.3em;margin-bottom: 2px;text-align: center;padding: 2px 4px 6px 4px;">Go</button>
                                    </form>
                                    @if (!$userListHome)
                                        <button class="btn btn-primary" style="width: 50px;height: 38px;font-size:1.0em;margin-top:2px;margin-bottom: 4px;margin-left:2px;text-align: center;padding: 2px 4px 6px 4px;" onclick="window.location='{{ route('getUsers') }}'">Clear</button>
                                    @endif
                                </div>
                            </center>
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
                                            <!--13 is tha ascii value for return and in php its "\r"-->
                                            <tr data-toggle="tooltip" data-placement="bottom" title="Company: {{$user->company}} &#13Job Title: {{$user->jobTitle}} &#13City: {{$user->city}} &#13State: {{$user->state}}">
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
                        </div>

                    </div>
                </div>
            </div>
        </div>
@endsection

@push("js")
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
