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
                                <option>...</option>
                            </select>
                            </div>
                            <div class="form-group col-md-6">
                            <label for="inputCity">City (Optional)</label>
                            <input type="text" class="form-control" id="city">
                            </div>
                            <div class="form-group col-md-2">
                            <label for="inputZip">Zip (Optional)</label>
                            <input type="text" class="form-control" id="zip">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="county">County (Optional)</label>
                            <input type="text" class="form-control" id="county" placeholder="">
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="waterSource">Water Source</label>
                                <input type="text" class="form-control" id="waterSource" placeholder="Sink, lake, etc.">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="waterDestination">Water Destination</label>
                                <input type="text" class="form-control" id="waterDestination" placeholder="Sink, Toilet, etc.">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="gridCheck">
                            <label class="form-check-label" for="gridCheck">
                                Check if reusing water from this source is aloud
                            </label>
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

