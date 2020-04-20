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
                        <hr>
                        <div id="waterSourceDiv">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                <label for="waterSource0">Water Source</label>
                                <select id="waterSource0" class="form-control">
                                    <option value="choose" disabled>Choose...</option>
                                </select>
                                </div>
                                <div class="form-group col-md-6">
                                <label for="waterDestination0">Water Destination</label>
                                <select id="waterDestination0" class="form-control">
                                    <option value="choose" disabled>Choose...</option>
                                </select>
                                </div>
                            </div>
                            </br>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="isPermitted0">
                                <label class="form-check-label" for="isPermitted0">Check if reuse from this source is permitted</label>
                            </div>
                            <hr>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="codes0">Link to Codes (Optional)</label>
                                    <input type="text" class="form-control" id="codes0" placeholder="">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="permits0">Link to Permit (Optional)</label>
                                    <input type="text" class="form-control" id="permits0" placeholder="">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="insentives0">Link to Insentives (Optional)</label>
                                    <input type="text" class="form-control" id="insentives0" placeholder="">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="moreInfo0">Link to More Information (Optional)</label>
                                    <input type="text" class="form-control" id="moreInfo0" placeholder="">
                                </div>
                            </div>
                            <div class="form-group" >
                                <label for="comments0">Comments (Optional)</label>
                                <textarea class="form-control" id="comments0" rows="3"></textarea>
                            </div>
                            <hr>
                        </div>
                        <div class="form-group" style="float: right;">
                            <button type="button" class="btn btn-secondary" id="addSource">+</button>
                            <label for="addSource"> Add Another Regulation For This Area</label>
                        </div>
                        <button type="submit" class="btn btn-primary" id="submit">Submit</button>
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
        //holds the number of regulations a user wishes to submit, using 0 indexing
        numOfRegs = 0;

        // get the water sources
        function getWaterSources( idNum ) {
            axios.get("{{route("my-sources-api")}}")
            .then(function (response) {
                //get each county, and set them as options
                $source = response.data.map(obj => ("<option class='sourceName' value=" + obj.node_id + " >" + obj.node_name + "</option>"));
                $("#waterSource" + idNum).append($source);
            })
            .catch(function (error) {
                //Handle errors here
                console.log(error);
            });
        };

        // get the water destinations
        function getWaterDestinations( idNum ) {
            axios.get("{{route("my-destination-api")}}")
            .then(function (response) {
                //get each county, and set them as options
                $destination = response.data.map(obj => ("<option class='destinationName' value=" + obj.node_id + " >" + obj.node_name + "</option>"));
                $("#waterDestination" + idNum).append($destination);
            })
            .catch(function (error) {
                //Handle errors here
                console.log(error);
            });
        };

        //populate the initial water source and destination
        getWaterSources(numOfRegs);
        getWaterDestinations(numOfRegs);


        $('#addSource').click(function(){
            numOfRegs += 1;
            $source = '<div class="form-row"><div class="form-group col-md-6"><label for="waterSource' + numOfRegs + '">Water Source</label><select id="waterSource' + numOfRegs + '" class="form-control"><option value="choose" disabled>Choose...</option></select></div><div class="form-group col-md-6"><label for="waterDestination' + numOfRegs + '">Water Destination</label><select id="waterDestination' + numOfRegs + '" class="form-control"><option value="choose" disabled>Choose...</option></select></div></div></br><div class="form-check form-check-inline"><input class="form-check-input" type="checkbox" id="isPermitted' + numOfRegs + '"><label class="form-check-label" for="isPermitted' + numOfRegs + '">Check if reuse from this source is permitted</label></div><hr><div class="form-row"><div class="form-group col-md-6"><label for="codes' + numOfRegs + '">Link to Codes (Optional)</label><input type="text" class="form-control" id="codes' + numOfRegs + '" placeholder=""></div><div class="form-group col-md-6"><label for="permits' + numOfRegs + '">Link to Permit (Optional)</label><input type="text" class="form-control" id="permits' + numOfRegs + '" placeholder=""></div></div><div class="form-row"><div class="form-group col-md-6"><label for="insentives' + numOfRegs + '">Link to Insentives (Optional)</label><input type="text" class="form-control" id="insentives' + numOfRegs + '" placeholder=""></div><div class="form-group col-md-6"><label for="moreInfo' + numOfRegs + '">Link to More Information (Optional)</label><input type="text" class="form-control" id="moreInfo' + numOfRegs + '" placeholder=""></div></div><div class="form-group"><label for="comments' + numOfRegs + '">Comments (Optional)</label><textarea class="form-control" id="comments' + numOfRegs + '" rows="3"></textarea><hr></div>';
            $("#waterSourceDiv").append($source);
            getWaterSources(numOfRegs);
            getWaterDestinations(numOfRegs);

        });
        $('#submit').click(function(){
            $state = $("#inputState").children("option:selected").text();

            if($state == "Choose...")
            {
                alert("You have not chosen a state. Please select the state you wish to create a regulation for.");
            }
            else{
                $county = $("#county").children("option:selected").text();
                $city = $("#city").children("option:selected").text();
                $regList = [];

                for(i = 0; i <= numOfRegs; i++)
                {
                    $newReg = {
                        $source: $('#waterSource' + i).children("option:selected").text(),
                        $destination: $('#waterDestination' + i).children("option:selected").text(),
                        $isPermitted: $("#isPermitted" + i).prop("checked"),
                        $codesLink: $("#codes" + i).val(),
                        $permitLink: $("#permits" + i).val(),
                        $insentivesLink: $("#insentives" + i).val(),
                        $moreInfoLink: $("#moreInfo" + i).val(),
                        $comments: $("#comments" + i).val()
                    };
                    $regList.push($newReg);
                }

                axios.post('/regSubmit', {
                    newRegList: $regList
                })
                .then(function (response) {
                    console.log(response);
                })
                .catch(function (error) {
                    console.log(error);
                });
            }
        })




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
            }
            else{
                $("#chooseCity").prop("disabled", true);
                $("#chooseCity").prop("selected", false);
            }

        });



    </script>
@endpush

