@extends('layouts.master')

@section('body')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Submit a New Water Reuse Regulation</div>
                <div class="card-body">
                    <form type="POST">
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
                                <select id="waterSource0" name="waterSource0" class="form-control">
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
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="allowed0">Is Water Reuse From This Source Allowed?</label>
                                    <select id="allowed0" class="form-control">
                                        <option value="choose" disabled>Choose...</option>
                                    </select>
                                </div>
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
                                    <label for="incentives0">Link to Incentives (Optional)</label>
                                    <input type="text" class="form-control" id="incentives0" placeholder="">
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
                        <button type="button" class="btn btn-primary" id="submit">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push("js")
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

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

        // get the water destinations
        function getAllowed( idNum ) {
            axios.get("{{route("allowed-api")}}")
            .then(function (response) {
                //get each county, and set them as options
                $allowed = response.data.map(obj => ("<option class='allowedName' value=" + obj.allowed_id + " >" + obj.allowedText + "</option>"));
                $("#allowed" + idNum).append($allowed);
            })
            .catch(function (error) {
                //Handle errors here
                console.log(error);
            });
        };

        //populate the initial water source and destination
        getWaterSources(numOfRegs);
        getWaterDestinations(numOfRegs);
        getAllowed(numOfRegs);


        $('#addSource').click(function(){
            numOfRegs += 1;
            $source = '<div class="form-row"><div class="form-group col-md-6"><label for="waterSource' + numOfRegs + '">Water Source</label><select id="waterSource' + numOfRegs + '" name="waterSource' + numOfRegs + '" class="form-control"><option value="choose" disabled>Choose...</option></select></div><div class="form-group col-md-6"><label for="waterDestination' + numOfRegs + '">Water Destination</label><select id="waterDestination' + numOfRegs + '" class="form-control"><option value="choose" disabled>Choose...</option></select></div></div></br><div class="form-row"><div class="form-group col-md-6"><label for="allowed' + numOfRegs + '">Is Water Reuse From This Source Allowed?</label><select id="allowed' + numOfRegs + '" class="form-control"><option value="choose" disabled>Choose...</option></select></div></div><hr><div class="form-row"><div class="form-group col-md-6"><label for="codes' + numOfRegs + '">Link to Codes (Optional)</label><input type="text" class="form-control" id="codes' + numOfRegs + '" placeholder=""></div><div class="form-group col-md-6"><label for="permits' + numOfRegs + '">Link to Permit (Optional)</label><input type="text" class="form-control" id="permits' + numOfRegs + '" placeholder=""></div></div><div class="form-row"><div class="form-group col-md-6"><label for="incentives' + numOfRegs + '">Link to Incentives (Optional)</label><input type="text" class="form-control" id="incentives' + numOfRegs + '" placeholder=""></div><div class="form-group col-md-6"><label for="moreInfo' + numOfRegs + '">Link to More Information (Optional)</label><input type="text" class="form-control" id="moreInfo' + numOfRegs + '" placeholder=""></div></div><div class="form-group"><label for="comments' + numOfRegs + '">Comments (Optional)</label><textarea class="form-control" id="comments' + numOfRegs + '" rows="3"></textarea><hr></div>';
            $("#waterSourceDiv").append($source);
            getWaterSources(numOfRegs);
            getWaterDestinations(numOfRegs);
            getAllowed(numOfRegs);
        });
        $('#submit').click(function(){
            $state = $("#inputState").children("option:selected").text();

            if($state == "Choose...")
            {
                Swal.fire({
                        title: 'Error: No State Selected',
                        text: 'You did not pick a State. You need to at least pick a State to add a regulation. Please try again.',
                        icon: 'error',
                        confirmButtonText: 'Ok'
                    });
                return;
            }
            else{
                $county = $("#county").children("option:selected").text();
                $city = $("#city").children("option:selected").text();
                $regList = [];

                for(i = 0; i <= numOfRegs; i++)
                {
                    $newReg = {
                        $state: $('#inputState').children("option:selected").text(),
                        $county: $('#county').children("option:selected").text(),
                        $city: $('#city').children("option:selected").text(),
                        $stateId: $('#inputState').children("option:selected").val(),
                        $countyId: $('#county').children("option:selected").val(),
                        $cityId: $('#city').children("option:selected").val(),
                        $sourceId: $('#waterSource' + i).children("option:selected").val(),
                        $destinationId: $('#waterDestination' + i).children("option:selected").val(),
                        $isPermitted: $("#allowed" + i).children("option:selected").val(),
                        $codesLink: $("#codes" + i).val(),
                        $permitLink: $("#permits" + i).val(),
                        $incentivesLink: $("#incentives" + i).val(),
                        $moreInfoLink: $("#moreInfo" + i).val(),
                        $comments: $("#comments" + i).val()
                    };
                    $regList.push($newReg);
                }

                axios.post("{{route('regSubmit')}}", {
                    newRegList: JSON.stringify($regList)
                })
                .then(function (response) {
                    Swal.fire({
                        title: 'You Did It!',
                        text: 'Your regulation request for ' + response.data + ' has been submitted. Please give our admin time to approve your submission.',
                        icon: 'success',
                        confirmButtonText: 'Ok'
                    }).then((result) => {
                        location.reload();
                    });

                })
                .catch(function (error) {
                    Swal.fire({
                        title: 'Error: Request Failed To Submit',
                        text: 'The regulation form you tried to turn in failed to submit. Please try again. If the problem continues, please contact an admin.',
                        icon: 'error',
                        confirmButtonText: 'Ok'
                    });
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
                    //get each county, and set them as options
                    $county = response.data.map(obj => ("<option class='countyName' value=" + obj.county_id + " >" + obj.countyName + "</option>"));
                    $("#county").append($county);
                })
                .catch(function (error) {
                    //Handle errors here
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
                    //get each city, and set them as options
                    $city = response.data.map(obj => ("<option class='cityName' value=" + obj.city_id + " >" + obj.cityName + "</option>"));
                    // console.log($city);
                    $("#city").append($city);
                })
                .catch(function (error) {
                    //Handle errors here
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

