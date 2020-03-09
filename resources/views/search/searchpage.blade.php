@extends("layouts.master")

@section('body')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header"><h3>Search for Location </h3></div>

                    <div class="card-body">

                        <h3>You are:
                            @if(Auth::check())
                                Logged In!
                            @else
                                Not Logged In!
                            @endif
                        </h3>

                        <form  method="POST" class="form-inline mt-3" }>
                            {{--This is a required thing for forms in Laravel, to stop CSRF attacks --}}
                            {{ csrf_field() }}

                            <div class="form-group">
                                <label for="search">Address</label>
                                <input type="text" class="form-control" id="search" placeholder="Address...">
                            </div>
                            <button type="submit" class="btn btn-primary"> Search </button>
                        </form>
                        <br>
                        // Have a search form here or something

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
