@extends('layouts.master')

@section('body')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Submit a New Water Reuse Regulation</div>
                <div class="card-body">
                    <form>
                        <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="inputState">State</label>
                            <select id="inputState" class="form-control">
                                <option value="choose" selected>Choose...</option>
                                @foreach($states as $state)
                                    <option value="{{$state->state_id}}">{{$state->stateName}}</option>
                                @endforeach
                            </select>
                            </div>
                            <div class="form-group col-md-4">
                            <label for="county">County (Optional)</label>
                            <select class="form-control" id="county">
                                <option id="chooseCounty" value="choose" disabled>Choose...</option>
                            </select>
                            </div>
                            <div class="form-group col-md-4">
                            <label for="inputZip">Zip (Optional)</label>
                            <input type="text" class="form-control" id="inputZip">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="city">City (Optional)</label>
                            <select class="form-control" id="city">
                                <option id="chooseCity" value="choose" disabled>Choose...</option>
                            </select>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                            <label for="waterSource">Water Source</label>
                            <select id="waterSource" class="form-control">
                                <option value="choose" disabled>Choose...</option>
                            </select>
                            </div>
                            <div id="waterDest" class="button-group col-md-6">
                                <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">Water Destinations</button>
                                    <ul class="dropdown-menu" id="destination">

                                    </ul>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label class="form-check-label" for="gridCheck">
                                    Is reusing water from this source permitted?
                                </label>
                            </div>
                            <div class="form-group col-md-2">
                                <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="yes">
                                <label class="form-check-label" for="yes">
                                    Yes
                                </label>
                                </div>
                            </div>
                            <div class="form-group col-md-2">
                                <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="no">
                                <label class="form-check-label" for="no">
                                    No
                                </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="codes">Link to Codes (Optional)</label>
                            <input type="text" class="form-control" id="codes" placeholder="">
                        </div>
                        <div class="form-group">
                            <label for="permits">Link to Permit (Optional)</label>
                            <input type="text" class="form-control" id="permits" placeholder="">
                        </div>
                        <div class="form-group">
                            <label for="insentives">Link to Insentives (Optional)</label>
                            <input type="text" class="form-control" id="insentives" placeholder="">
                        </div>
                        <div class="form-group">
                            <label for="moreInfo">Link to More Information (Optional)</label>
                            <input type="text" class="form-control" id="moreInfo" placeholder="">
                        </div>

                        <div class="form-group">
                            <label for="comments">Comments (Optional)</label>
                            <textarea class="form-control" id="comments" rows="3"></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push("js")
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script>

        //Unclick yes or no depending on which one is selected
        $("#no").click(function(){
            $("#yes").prop("checked", false);
        });

        $("#yes").click(function(){
            $("#no").prop("checked", false);
        });



        // get the water sources
        axios.get("{{route("my-sources-api")}}")
        .then(function (response) {


            console.log("Response: " + response);
            console.log("Data: " + response.data);
            //get each county, and set them as options
            $source = response.data.map(obj => ("<option class='sourceName' value=" + obj.source_id + " >" + obj.node_name + "</option>"));
            console.log($source);
            $("#waterSource").append($source);
        })
        .catch(function (error) {
            //Handle errors here

            //Generally don't have to worry about errors too much,
            // but maybe want to do "alert('There was a error, please try re-loading the page.')"
            console.log(error);
        });

        // get the water sources
        axios.get("{{route("my-destination-api")}}")
        .then(function (response) {


            console.log("Response: " + response);
            console.log("Data: " + response.data);
            //get each county, and set them as options
            $destination = response.data.map(obj => ("<li><input type='checkbox' value=" + obj.destination_id + "/>&nbsp;" + obj.node_name + "</li>"));
            console.log($destination);
            $("#destination").append($destination);
        })
        .catch(function (error) {
            //Handle errors here

            //Generally don't have to worry about errors too much,
            // but maybe want to do "alert('There was a error, please try re-loading the page.')"
            console.log(error);
        });


        //for when the state changes
        $( "#inputState" ).change(function() {

            // Here we can see the currently selected state (the state_id is the value)
            console.log(inputState.value);

            // delete each county
            $(".countyName").each(function () {
                $(this).remove();
            });

            // delete each city
            $(".cityName").each(function () {
                $(this).remove();
            });

            //This is the Axios call to the API
            if(inputState.value != "choose")
            {
                //enable the basic 'choose' option
                $("#chooseCounty").prop("disabled", false);
                //disable cities
                $("#chooseCity").prop("disabled", true);
                $("#chooseCity").prop("selected", false);

                axios.get("{{route("counties-api")}}"+"/"+inputState.value)
                .then(function (response) {


                    console.log("Response: " + response);
                    console.log("Data: " + response.data);
                    //get each county, and set them as options
                    $county = response.data.map(obj => ("<option class='countyName' value=" + obj.county_id + " >" + obj.countyName + "</option>"));
                    console.log($county);
                    $("#county").append($county);
                })
                .catch(function (error) {
                    //Handle errors here

                    //Generally don't have to worry about errors too much,
                    // but maybe want to do "alert('There was a error, please try re-loading the page.')"
                    console.log(error);
                });
            }
            else {
                $("#chooseCounty").prop("disabled", true);
                $("#chooseCounty").prop("selected", false);
                $("#chooseCity").prop("disabled", true);
                $("#chooseCity").prop("selected", false);
            }

        });




        //Populate the cities
        //for when the state changes
        $( "#county" ).change(function() {

            // Here we can see the currently selected state (the state_id is the value)
            console.log(county.value);

            // delete each city
            $(".cityName").each(function () {
                $(this).remove();
            });

            //This is the Axios call to the API
            if(county.value != "choose")
            {
                $("#chooseCity").prop("disabled", false);

                axios.get("{{route("cities-api")}}"+"/"+county.value)
                .then(function (response) {


                    console.log("Response: " + response);
                    console.log("Data: " + response.data);
                    //get each city, and set them as options
                    $city = response.data.map(obj => ("<option class='cityName' value=" + obj.city_id + " >" + obj.cityName + "</option>"));
                    console.log($city);
                    $("#city").append($city);
                })
                .catch(function (error) {
                    //Handle errors here

                    //Generally don't have to worry about errors too much,
                    // but maybe want to do "alert('There was a error, please try re-loading the page.')"
                    console.log(error);
                })
            }
            else{
                $("#chooseCity").prop("disabled", true);
                $("#chooseCity").prop("selected", false);
            }

        });

    </script>
@endpush

