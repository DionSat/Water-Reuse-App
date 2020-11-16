@extends('layouts.master')

@section('body')
    <div class="container">
        <div class="my-3">
            <a href="{{$backUrl}}" class="btn btn-primary col-md-2"> <i class="fas fa-arrow-circle-left"></i>
                Back
            </a>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Edit Submission</div>
                    <div class="card-body">
                        <form action="{{ route('submissionEditUpdate') }}" method="POST">
                            {{ csrf_field() }}
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="inputState">State</label>
                                    <select id="inputState" class="form-control" name="state">
                                        <option value="-1">Choose...</option>
                                        @foreach($states as $state)
                                            <option value="{{$state->state_id}}"
                                                    @if($state->state_id == $submissionState)
                                                    selected
                                                @endif
                                            >{{$state->stateName}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="county">County (Optional)</label>
                                    <div class="text-center">
                                        <i id="countySpinner" class="fas fa-spinner fa-pulse mt-2 d-none"></i>
                                    </div>
                                    <select class="form-control" id="county" name="county">
                                        <option id="chooseCounty" value="-1">Choose...</option>
                                        @foreach($counties as $county)
                                            <option class="countyName" value="{{$county->county_id}}"
                                                    @if($county->county_id == $submissionCounty)
                                                    selected
                                                @endif
                                            >{{$county->countyName}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="city">City (Optional)</label>
                                    <div class="text-center">
                                        <i id="citySpinner"
                                           class="justify-content-center fas fa-spinner fa-pulse mt-2 d-none"></i>
                                    </div>
                                    <select class="form-control " id="city" name="city">
                                        <option id="chooseCity" value="-1">Choose...</option>
                                        @foreach($cities as $city)
                                            <option class="cityName" value="{{$city->city_id}}"
                                                    @if($city->city_id == $submissionCity)
                                                    selected
                                                @endif
                                            >{{$city->cityName}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <hr>
                            <div id="waterSourceDiv">
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="waterSource">Water Source</label>
                                        <select id="waterSource" class="form-control" name="source">
                                            <option value="-1" disabled>Choose...</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="waterDestination">Water Destination</label>
                                        <select id="waterDestination" class="form-control" name="destination">
                                            <option value="-1" disabled>Choose...</option>
                                        </select>
                                    </div>
                                </div>
                                </br>
                                <div class="form-group col-md-4">
                                    <label for="isPermitted">Is this permitted: </label>
                                    <select class="form-control " type="checkbox" id="isPermitted" name="allowed">
                                        @foreach($allowed as $option)
                                            <option id="chooseAllowed" value="{{$option->allowed_id}}"
                                                    @if($option->allowed_id == $submission->allowedID)
                                                    selected
                                                @endif
                                            >{{$option->allowedText}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <hr>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="codes">Link to Codes (Optional)</label>
                                        <input type="text" class="form-control" id="codes" placeholder=""
                                               value="{{empty($submission->codesObj) ? "" : $submission->codesObj->linkText}}" name="codes">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="permit">Link to Permit (Optional)</label>
                                        <input type="text" class="form-control" id="permit" placeholder=""
                                               value="{{empty($submission->permitObj) ? "" : $submission->permitObj->linkText}}" name="permit">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="incentives">Link to Incentives (Optional)</label>
                                        <input type="text" class="form-control" id="incentives" placeholder=""
                                               value="{{empty($submission->incentivesObj) ? "" : $submission->incentivesObj->linkText}}" name="incentives">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="moreInfo">Link to More Information (Optional)</label>
                                        <input type="text" class="form-control" id="moreInfo" placeholder=""
                                               value="{{empty($submission->moreInfoObj) ? "" : $submission->moreInfoObj->linkText}}" name="moreInfo">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="comments">Comments (Optional)</label>
                                    <textarea class="form-control" id="comments" rows="3" name="comments">{{$submission->comments}}</textarea>
                                </div>
                                <input type="text" name="type" style="display: none;" value="{{$type}}">
                                <input type="number" name="id" style="display: none;" value={{$submission->id}}>
                                <hr>
                            </div>
                            <input name="submissionState" style="display: none;" value={{$submission->getStatus()}}>
                            <input name="submissionType" style="display: none;" value="{{$type}}">
                            <input name="back" style="display: none;" value="{{$previousBackUrl}}">
                            <button type="submit" class="btn btn-primary" id="submit"> Save </button>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push("js")
    <script src="{{ URL::asset('/libraries/axios.min.js') }}"></script>
    <script>

        function showCountySpinner() {
            $("#countySpinner").removeClass("d-none");
            $("#county").addClass("d-none");
        }

        function hideCountySpinner() {
            $("#countySpinner").addClass("d-none");
            $("#county").removeClass("d-none");
        }

        function showCitySpinner() {
            $("#citySpinner").removeClass("d-none");
            $("#city").addClass("d-none");
        }

        function hideCitySpinner() {
            $("#citySpinner").addClass("d-none");
            $("#city").removeClass("d-none");
        }

        // get the water sources
        function getWaterSources() {
            var current = {{$submission->sourceID}};
            axios.get("{{route("my-sources-api")}}")
                .then(function (response) {
                    //get each county, and set them as options
                    $source = response.data.map(obj => (
                        "<option "
                        + (obj.node_id == current ? ' selected ' : "")
                        + " class='sourceName' value="
                        + obj.node_id
                        + " >"
                        + obj.node_name
                        + "</option>"));

                    $("#waterSource").append($source);
                })
                .catch(function (error) {
                    //Handle errors here
                    console.log(error);
                });
        };

        // get the water destinations
        function getWaterDestinations() {
            var current = {{$submission->destinationID}};
            axios.get("{{route("my-destination-api")}}")
                .then(function (response) {
                    //get each county, and set them as options
                    $destination = response.data.map(obj => ("<option "
                        + (obj.node_id == current ? 'selected' : "")
                        + " class='destinationName' value="
                        + obj.node_id
                        + " >"
                        + obj.node_name
                        + "</option>"));
                    $("#waterDestination").append($destination);
                })
                .catch(function (error) {
                    //Handle errors here
                    console.log(error);
                });
        };

        //populate the initial water source and destination
        getWaterSources();
        getWaterDestinations();

        //for when the state changes
        $("#inputState").change(function () {
            showCountySpinner();
            // Here we can see the currently selected state (the state_id is the value)
            //console.log(inputState.value);

            // delete each county
            $(".countyName").each(function () {
                $(this).remove();
            });

            // delete each city
            $(".cityName").each(function () {
                $(this).remove();
            });

            //This is the Axios call to the API
            if (inputState.value != -1) {
                //enable the basic 'choose' option
                $("#chooseCounty").prop("disabled", false);
                //disable cities
                $("#chooseCity").prop("disabled", true);
                $("#chooseCity").prop("selected", false);

                axios.get("{{route("counties-api")}}" + "/" + inputState.value)
                    .then(function (response) {

                        hideCountySpinner();
                        // console.log("Response: " + response);
                        // console.log("Data: " + response.data);
                        //get each county, and set them as options
                        $county = response.data.map(obj => ("<option class='countyName' value=" + obj.county_id + " >" + obj.countyName + "</option>"));
                        // console.log($county);
                        $("#county").append($county);
                    })
                    .catch(function (error) {
                        //Handle errors here

                        //Generally don't have to worry about errors too much,
                        // but maybe want to do "alert('There was a error, please try re-loading the page.')"
                        console.log(error);
                    });
            } else {
                $("#chooseCounty").prop("disabled", true);
                $("#chooseCounty").prop("selected", false);
                $("#chooseCity").prop("disabled", true);
                $("#chooseCity").prop("selected", false);
            }

        });


        //Populate the cities
        //for when the state changes
        $("#county").change(function () {
            showCitySpinner();
            // Here we can see the currently selected state (the state_id is the value)
            //console.log(county.value);

            // delete each city
            $(".cityName").each(function () {
                $(this).remove();
            });

            //This is the Axios call to the API
            if (county.value != -1) {
                $("#chooseCity").prop("disabled", false);

                axios.get("{{route("cities-api")}}" + "/" + county.value)
                    .then(function (response) {

                        hideCitySpinner();
                        // console.log("Response: " + response);
                        // console.log("Data: " + response.data);
                        //get each city, and set them as options
                        $city = response.data.map(obj => ("<option class='cityName' value=" + obj.city_id + " >" + obj.cityName + "</option>"));
                        // console.log($city);
                        $("#city").append($city);
                    })
                    .catch(function (error) {
                        //Handle errors here

                        //Generally don't have to worry about errors too much,
                        // but maybe want to do "alert('There was a error, please try re-loading the page.')"
                        console.log(error);
                    })
            } else {
                $("#chooseCity").prop("disabled", true);
                $("#chooseCity").prop("selected", false);
            }

        });


    </script>
@endpush


@push("css")
  <style>
    body::before {
      content: "";
      position: fixed;
      width: 200%;
      height: 200%;
      top: -50%;
      left: -50%;
      z-index: -1;
      background-size: cover;
      background-image: url('https\3a //scontent.fhio2-1.fna.fbcdn.net/v/t15.5256-10/cp0/e15/q65/p600x600/20505009_401019313628316_6647662209365180416_n.jpg?_nc_cat\3d 102\26 ccb\3d 2\26 _nc_sid\3d ccf8b3\26 _nc_ohc\3d XdbCgFERuygAX-1bAXs\26 _nc_ht\3d scontent.fhio2-1.fna\26 oh\3d 11dfc9e7c7ba03c61b70c4b3b4f3bd0c\26 oe\3d 5FD1716B');
      no-repeat fixed center center;
      background-size: cover;
      transform: scaleY(-1);
      filter: brightness(80%);
    }

  </style>
@endpush

