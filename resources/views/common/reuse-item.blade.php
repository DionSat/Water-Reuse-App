<div class="card mx-auto mt-3 shadow">
    <div class="card-body text-center">
        <div class="d-flex flex-row justify-content-between mb-3 mx-3">
            <div class="p-2 d-block">
                <h3>Location</h3>
                <h5 class="text-muted">
                    @if(!empty($item))
                        @if(isset($item->cityID)) {{$item->city->cityName ?? "N/A"}} @endif
                        @if(isset($item->countyID)) {{$item->county->countyName ?? "N/A"}} @endif
                        @if(isset($item->stateID)) {{$item->state->stateName ?? "N/A"}} @endif
                    @else
                        N/A
                    @endif
                </h5>
            </div>
            <div class="p-2 d-block">
                <h3>Source</h3>
                <h5 class="text-muted">{{$item->source->node_name ?? "N/A"}}</h5>
            </div>
            <div class="p-2 d-block">
                <h3>Destination</h3>
                <h5 class="text-muted">{{$item->destination->destinationName ?? "N/A"}}</h5>
            </div>
            <div class="p-2 d-block">
                <h3>Allowed</h3>
                <h3><span class="badge @if($item->allowed->allowedText === "Yes") badge-success @elseif($item->allowed->allowedText === "No") badge-danger @else badge-warning @endif">
                        {{$item->allowed->allowedText ?? "?"}}
                    </span></h3>
            </div>
        </div>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th scope="col">Codes</th>
                <th scope="col">Permits</th>
                <th scope="col">Incentives</th>
                <th scope="col">More Info</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td><a href="{{$item->codesObj->linkText ?? "#"}}" class="btn btn-primary">Link Name</a></td>
                <td><a href="{{$item->permitObj->linkText ?? "#"}}" class="btn btn-primary">Link Name</a></td>
                <td><a href="{{$item->incentivesObj->linkText ?? "#"}}" class="btn btn-primary">Link Name</a></td>
                <td><a href="{{$item->moreInfoObj->linkText ?? "#"}}" class="btn btn-primary">Link Name</a></td>
            </tr>
            </tbody>
        </table>
    </div>
</div>