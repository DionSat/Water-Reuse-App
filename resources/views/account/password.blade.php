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
                <div class="col-md-4 mx-auto">
                    <div class="card h-100 shadow mx-auto text-center">
                        <div class="card-header">
                            <h3>Change password</h3>
                        </div>
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <label class="input-group-text">Old password</label>
                                    </div>
                                    <input type="password" id="Oldpw" name="oldPW" class="form-control" aria-label="Default"
                                           aria-describedby="inputGroup-sizing-default"  placeholder="Old password">
                                </div>
                            </div>
                            <div class="d-flex">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <label class="input-group-text">New password</label>
                                    </div>
                                    <input type="password" id="pw" name="newPW" class="form-control" aria-label="Default"
                                           aria-describedby="inputGroup-sizing-default"  onkeyup="validate()" placeholder="New password">
                                </div>
                            </div>
                            <div class="d-flex">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <label class="input-group-text">Verify password</label>
                                    </div>
                                    <input type="password" id="pw2" name="newPW2" class="form-control" aria-label="Default"
                                           aria-describedby="inputGroup-sizing-default" placeholder="New password" onkeyup="validate()">
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-md-6">
                                        <button id="btnSubmit" type="submit" class="btn btn-success btn-large btn-block"><i
                                                class="fas fa-edit"></i>
                                            Save
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
