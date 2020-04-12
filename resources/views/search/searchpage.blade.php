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

                        {{--<form  method="POST" class="form-inline mt-3" action={{route('searchResults')}}>--}}
                            <form  method="POST" class="form-inline mt-3">
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

                        <br><br>
                        <hr>
                        <form>
                            <div class="form-group row">
                                <label for="stateSelect" class="col-md-4 col-form-label"> State </label>
                                <div class="col-md-6">

                                    {{--Here in the select, we can generate the initial set of states with PHP --}}

                                    <select id="stateSelect" class="form-control">
                                        <option value="" disabled selected>Select a state</option>
                                        @foreach($states as $state)
                                            <option value="{{$state->state_id}}">{{$state->stateName}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </form>

                        <div class="card">
                            <div id="dataTest" class="card-body">
                                Counties will appear here on select
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push("js")
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script>


        $( "#stateSelect" ).change(function() {

            // Here we can see the currently selected state (the state_id is the value)
            console.log(stateSelect.value);

            //This is the Axios call to the API
            axios.get("{{route("counties-api")}}"+"/"+stateSelect.value)
                .then(function (response) {

                    // handle success, we can print out what we got back to console for debugging
                    console.log("Response: " + response);
                    console.log(response.data);

                    // We can then set the html that we need to with the results
                    $("#dataTest").text(response.data.map(obj => obj.countyName).join(", "));

                })
                .catch(function (error) {
                    //Handle errors here

                    //Generally don't have to worry about errors too much,
                    // but maybe want to do "alert('There was a error, please try re-loading the page.')"
                    console.log(error);
                })
        });



    </script>
@endpush

