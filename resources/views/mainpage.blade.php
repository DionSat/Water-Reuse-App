@extends("layouts.master")

@section('body')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Water Reuse App!</div>

                    <div class="card-body">
                        Main page...

                        <br>
                        <a href="{{route("search")}}"> Go to the Search Page!</a>
                        <br>
                        <br>
                        Note that this one will ask you to log in first, then take you to the page:
                        <br>
                        <a href="{{route("home")}}"> Go to the Dashboard/ Logged-in Homepage!</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
