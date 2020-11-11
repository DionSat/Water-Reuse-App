@extends('layouts.master')

@section('body')
    <div class="container">
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @elseif(session('nothing'))
            <div class="alert alert-warning" role="alert">
                {{ session('nothing') }}
            </div>
        @elseif (session('danger'))
            <div class="alert alert-danger" role="alert">
                {{ session('danger') }}
            </div>
        @endif
        <div id="myAlert" class="alert alert-danger" style="display:none" role="alert">Passwords don't match</div>
        <form action="{{route('changePassword')}}" method="POST" >
            {{csrf_field()}}
            <div class="row mt-3 mb-5">
                <div class="col-md-6 mx-auto">
                    <div class="card h-100 shadow mx-auto text-center">
                        <div class="card-header">
                            <h3>Change PASSWORD</h3>
                        </div>
                        <div class="card-body">
                            <form>
                                <label for="oldPW"><b>Old password</b></label>
                                <input type="text" id="oldPW" name="OldPassword" placeholder="type old password">
                                <label for="newPW"><b>New password</b></label>
                                <input type="password" id="newPW" name="NewPassword" onkeyup="validate()" placeholder="type new password">
                                <label for="verifyPW"><b>Verify new password</b></label>
                                <input type="password" id="verifyPW" name="VerifyPassword" onkeyup="validate()" placeholder="type new password again">
                            </form>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-md-6" style="display: inline-block;">
                                    <button id="btnSubmit" type="submit" class="btn btn-success btn-large btn-block">
                                        <i class="fas fa-edit"></i>
                                        Save
                                    </button>
                                </div>
                                <div class="col-md-6" style="display:inline-block;">
                                        <button id="btnBack" type="button" class="btn btn-success btn-large btn-block" onclick="window.location='{{ route("account") }}'">
                                            <i class="fas fa-edit"></i>
                                        Back
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@push("js")
  <script>
      function validate() {
          var pw = document.getElementById("pw").value;
          var pw2 = document.getElementById("pw2").value;
          if(pw != pw2) {
              $("#myAlert").show();
              document.getElementById("btnSubmit").disabled = true;
              return false;
          }
          $("#myAlert").hide();
          document.getElementById("btnSubmit").disabled = false;
      }
  </script>
@endpush

@push("css")
    <style>
        label{
            width: 40%;
        }
        input[type=text],input[type=password], select {
            width: 55%;
            padding: 12px 20px;
            margin: 8px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        @media (max-width: 400px) {
            label{
                width:100%;
            }
            input[type=text],input[type=password],select{
                width:100%;
            }
        }
    </style>
@endpush
