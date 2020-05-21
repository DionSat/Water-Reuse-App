@extends('layouts.master')

@section('body')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h3 style="text-align: center">Submit a New Water Reuse Regulation</h3>
                <div class="card">
                    <div class="card-header">Location</div>
                    <div class="card-body">
                        <form type="POST">
                        <div id="selectRegion">
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
                                    <div class="text-center">
                                        <i id="countySpinner" class="fas fa-spinner fa-pulse mt-2 d-none"></i>
                                    </div>
                                    <select class="form-control" id="county">
                                        <option id="chooseCounty" value="choose" disabled>Choose...</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                        <label for="city">City (Optional)</label>
                                        <select class="form-control" id="city">
                                            <option id="chooseCity" value="choose" disabled>Choose...</option>
                                        </select>
                                </div>
                            </div>
                            <div class="text-center">
                                <i id="citySpinner" class="justify-content-center fas fa-spinner fa-pulse mt-2 d-none"></i>
                            </div>
                        </div>
                        <div id="addRegionDiv" style="display: none">
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="inputStateEdit">State</label>
                                    <input type="text" id="inputStateEdit" class="form-control">
                                    </input>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="countyEdit">County (Optional)</label>
                                    <input class="form-control" type="text" id="countyEdit">
                                    </input>
                                </div>
                                <div class="form-group col-md-4">
                                        <label for="cityEdit">City (Optional)</label>
                                        <input type="text" class="form-control" id="cityEdit">
                                        </input>
                                </div>
                            </div>
                        </div>
                            <div class="form-group">
                                <button type="button" class="btn btn-secondary" id="addRegion">+</button>
                                <label id="addRegionLabel" for="addRegion"> Add A New State, County or City</label>
                            </div>
                        </form>
                    </div>
                </div>
                <br/>
                <div class="card">
                    <div class="card-header">Regulations</div>
                    <div class="card-body">
                        <form type="POST">
                            <div id="waterSourceDiv">
                                <div class="form-row">
                                    <div class="form-group col-md-4">
                                        <label for="waterSource0">Water Source</label>
                                        <select id="waterSource0" name="waterSource0" class="form-control">
                                            <option value="choose" disabled>Choose...</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="waterDestination0">Water Destination</label>
                                        <select id="waterDestination0" class="form-control">
                                            <option value="choose" disabled>Choose...</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="allowed0">Is Water Reuse From This Source Allowed?</label>
                                        <select id="allowed0" class="form-control">
                                            <option value="choose" disabled>Choose...</option>
                                        </select>
                                    </div>
                                </div>
                                <hr>
                                <div class="form-row">
                                    <div class="form-group col-md-3">
                                        <label for="codes0">Link to Codes (Optional)</label>
                                        <input type="text" class="form-control" id="codes0" placeholder="">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="permits0">Link to Permit (Optional)</label>
                                        <input type="text" class="form-control" id="permits0" placeholder="">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="incentives0">Link to Incentives (Optional)</label>
                                        <input type="text" class="form-control" id="incentives0" placeholder="">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="moreInfo0">Link to More Information (Optional)</label>
                                        <input type="text" class="form-control" id="moreInfo0" placeholder="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="comments0">Comments (Optional)</label>
                                    <textarea class="form-control" id="comments0" rows="3"></textarea>
                                </div>
                                <hr style="height:2px;border:none;color:#333;background-color:#333;"/>
                            </div>
                            <div class="form-group" style="float: left;">
                                <button type="button" class="btn btn-secondary" id="addSource">+</button>
                                <label for="addSource"> Add Another Regulation For This Area</label>
                            </div>
                            <button type="button" class="btn btn-primary" id="submit" style="float: right;">Submit</button>
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
        //Changes from false to true when the addRegion button is clicked
        addRegionClicked = false;
        //The error message returned from the back end
        $errorMessage = "A API error occurred."

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

        function showStateSpinner() {
            $("#inputState").removeClass("d-none");
            $("#state").addClass("d-none");
        }

        function hideStateSpinner() {
            $("#inputState").addClass("d-none");
            $("#state").removeClass("d-none");
        }

        // get the water sources
        function getWaterSources(idNum) {
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
        function getWaterDestinations(idNum) {
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
        function getAllowed(idNum) {
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


        $('#addSource').click(function () {
            numOfRegs += 1;
            $source = '<div class="form-row"><div class="form-group col-md-4"><label for="waterSource' + numOfRegs + '">Water Source</label><select id="waterSource' + numOfRegs + '" name="waterSource' + numOfRegs + '" class="form-control"><option value="choose" disabled>Choose...</option></select></div><div class="form-group col-md-4"><label for="waterDestination' + numOfRegs + '">Water Destination</label><select id="waterDestination' + numOfRegs + '" class="form-control"><option value="choose" disabled>Choose...</option></select></div><div class="form-group col-md-4"><label for="allowed' + numOfRegs + '">Is Water Reuse From This Source Allowed?</label><select id="allowed' + numOfRegs + '" class="form-control"><option value="choose" disabled>Choose...</option></select></div></div><hr><div class="form-row"><div class="form-group col-md-3"><label for="codes' + numOfRegs + '">Link to Codes (Optional)</label><input type="text" class="form-control" id="codes' + numOfRegs + '" placeholder=""></div><div class="form-group col-md-3"><label for="permits' + numOfRegs + '">Link to Permit (Optional)</label><input type="text" class="form-control" id="permits' + numOfRegs + '" placeholder=""></div><div class="form-group col-md-3"><label for="incentives' + numOfRegs + '">Link to Incentives (Optional)</label><input type="text" class="form-control" id="incentives' + numOfRegs + '" placeholder=""></div><div class="form-group col-md-3"><label for="moreInfo' + numOfRegs + '">Link to More Information (Optional)</label><input type="text" class="form-control" id="moreInfo' + numOfRegs + '" placeholder=""></div></div><div class="form-group"><label for="comments' + numOfRegs + '">Comments (Optional)</label><textarea class="form-control" id="comments' + numOfRegs + '" rows="3"></textarea><hr style="height:2px;border:none;color:#333;background-color:#333;"/></div>';
            $("#waterSourceDiv").append($source);
            getWaterSources(numOfRegs);
            getWaterDestinations(numOfRegs);
            getAllowed(numOfRegs);
            $("#codes" + numOfRegs).val($("#codes" + (numOfRegs - 1)).val());
            $("#permits" + numOfRegs).val($("#permits" + (numOfRegs - 1)).val());
            $("#incentives" + numOfRegs).val($("#incentives" + (numOfRegs - 1)).val());
            $("#moreInfo" + numOfRegs).val($("#moreInfo" + (numOfRegs - 1)).val());
        });
        $('#submit').click(function () {

            if(addRegionClicked){
                $stateSelected = $("#inputStateEdit").val();
                if (!$("#inputStateEdit").val()) {
                    Swal.fire({
                        title: 'Error: No State Selected',
                        text: 'You did not pick a State. You need to at least pick a State to add a regulation. Please try again.',
                        icon: 'error',
                        confirmButtonText: 'Ok'
                    });
                    return;
                }
                else{
                    $countySelected = $('#countyEdit').val();
                    $citySelected =  $('#cityEdit').val();
                    console.log("City: " + $citySelected)
                    $stateIdSelected = -1;
                    $countyIdSelected = -1;
                    $cityIdSelected = -1;
                }
            }
            else{
                $stateSelected = $("#inputState").children("option:selected").text();
                if ($stateSelected == "Choose...") {
                    Swal.fire({
                        title: 'Error: No State Selected',
                        text: 'You did not pick a State. You need to at least pick a State to add a regulation. Please try again.',
                        icon: 'error',
                        confirmButtonText: 'Ok'
                    });
                    return;
                }
                else{
                    $countySelected = $('#county').children("option:selected").text();
                    $citySelected =  $('#city').children("option:selected").text();
                    $stateIdSelected = $('#inputState').children("option:selected").val();
                    $countyIdSelected = $('#county').children("option:selected").val();
                    $cityIdSelected = $('#city').children("option:selected").val();
                }
            }
            $county = $("#county").children("option:selected").text();
            $city = $("#city").children("option:selected").text();
            $regList = [];

            for (i = 0; i <= numOfRegs; i++) {
                $newReg = {
                    $state: $stateSelected,
                    $county: $countySelected,
                    $city: $citySelected,
                    $stateId: $stateIdSelected,
                    $countyId: $countyIdSelected,
                    $cityId: $cityIdSelected,
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
                    if(response.data != $errorMessage && response.data != "County Already Exists, or There Was an Error on Loading New Area" || "State Already Exists, or There Was an Error on Loading New Area" || "City Already Exists, or There Was an Error on Loading New Area")
                    {
                        console.log("'" + response.data + "'");
                        Swal.fire({
                            title: 'You Did It!',
                            text: 'Your regulation request for ' + response.data + ' has been submitted. Please give our admin time to approve your submission.',
                            icon: 'success',
                            confirmButtonText: 'Ok'
                        }).then((result) => {
                            location.reload();
                        });
                    }
                    else{
                        Swal.fire({
                            title: 'Error: Request Failed To Submit',
                            text: 'The regulation form you tried to turn in failed to submit with error ' + response.data + '. Please try again. If the problem continues, please contact an admin.',
                            icon: 'error',
                            confirmButtonText: 'Ok'
                        });
                    }

                })
                .catch(function (error) {
                    Swal.fire({
                        title: 'Error: Request Failed To Submit',
                        text: 'The regulation form you tried to turn in failed to submit  with the error ' + error + '. Please try again. If the problem continues, please contact an admin.',
                        icon: 'error',
                        confirmButtonText: 'Ok'
                    });
                });
        });

        //If they want to add a new area, the other area fields are disabled
        //and the edit fields are shown
        $("#addRegion").click(function() {
            if(!addRegionClicked)
            {
                $("#addRegion").html("-");
                $("#addRegionLabel").html(" Choose From Existing States / Counties / Cities");
                $("#addRegionDiv").css("display", "block");
                $("#selectRegion").css("display", "none");
                addRegionClicked = true;
            }
            else{
                $("#addRegion").html("+");
                $("#addRegionLabel").html(" Add A New State, County or City");
                $("#addRegionDiv").css("display", "none");
                $("#selectRegion").css("display", "block");
                addRegionClicked = false;
            }

        });

        //for when the state changes
        $("#inputState").change(function () {
            showCountySpinner();
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
            if (inputState.value != "choose") {
                //enable the basic 'choose' option
                $("#chooseCounty").prop("disabled", false);
                //disable cities
                $("#chooseCity").prop("disabled", true);
                $("#chooseCity").prop("selected", false);

                axios.get("{{route("counties-api")}}" + "/" + inputState.value)
                    .then(function (response) {
                        hideCountySpinner();
                        //get each county, and set them as options
                        $county = response.data.map(obj => ("<option class='countyName' value=" + obj.county_id + " >" + obj.countyName + "</option>"));
                        $("#county").append($county);
                    })
                    .catch(function (error) {
                        //Handle errors here
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
            console.log(county.value);

            // delete each city
            $(".cityName").each(function () {
                $(this).remove();
            });

            //This is the Axios call to the API
            if (county.value != "choose") {
                $("#chooseCity").prop("disabled", false);

                axios.get("{{route("cities-api")}}" + "/" + county.value)
                    .then(function (response) {
                        hideCitySpinner();
                        //get each city, and set them as options
                        $city = response.data.map(obj => ("<option class='cityName' value=" + obj.city_id + " >" + obj.cityName + "</option>"));
                        // console.log($city);
                        $("#city").append($city);
                    })
                    .catch(function (error) {
                        //Handle errors here
                        console.log(error);
                    })
            } else {
                $("#chooseCity").prop("disabled", true);
                $("#chooseCity").prop("selected", false);
            }

        });


    </script>
@endpush

