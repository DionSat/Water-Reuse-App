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
                                <option selected>Choose...</option>
                                @foreach($states as $state)
                                    <option value="{{$state->state_id}}">{{$state->stateName}}</option>
                                @endforeach
                                <option>...</option>
                            </select>
                            </div>
                            <div class="form-group col-md-6">
                            <label for="inputCity">City (Optional)</label>
                            <select class="form-control" id="city">
                                <option selected>Choose...</option>
                            </select>
                            </div>
                            <div class="form-group col-md-2">
                            <label for="inputZip">Zip (Optional)</label>
                            <input type="text" class="form-control" id="zip">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="county">County (Optional)</label>
                            <select class="form-control" id="county">
                                <option selected>Choose...</option>
                            </select>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                            <label for="waterSource">Water Source</label>
                            <select id="waterSource" class="form-control">
                                <option selected>Choose...</option>
                                <option>...</option>
                            </select>
                            </div>
                            <div id="waterDest" class="button-group col-md-6">
                                <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">Water Destinations</button>
                                    <ul class="dropdown-menu">
                                        <li><input type="checkbox"/>&nbsp;Option 1</li>
                                        <li><input type="checkbox"/>&nbsp;Option 2</li>
                                        <li><input type="checkbox"/>&nbsp;Option 3</li>
                                        <li><input type="checkbox"/>&nbsp;Option 4</li>
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


        $( "#inputState" ).change(function() {

            // Here we can see the currently selected state (the state_id is the value)
            console.log(inputState.value);

            //This is the Axios call to the API
            axios.get("{{route("my-counties-api")}}"+"/"+inputState.value)
                .then(function (response) {

                    // handle success, we can print out what we got back to console for debugging
                    console.log(response);
                    console.log(response.data);

                    // We can then set the html that we need to with the results
                    // $("#county").text(response.data.map(obj => obj.countyName).join(", "));
                    $county = response.data.map(obj => obj.countyName).join(", ");
                    $option = ("<option>" + $county + "</option>");
                    console.log($option);
                    $("#county").append($option);
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

