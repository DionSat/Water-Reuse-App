<div class="card mx-auto mt-3 shadow">
    <div class="card-body text-center">
        <div class="d-flex flex-row justify-content-between mb-3 mx-3">
            <div class="p-2 d-block">
                <h3>City</h3>
                <h5 class="text-muted">
                    {{$item->city->cityName ?? "N/A"}}
                </h5>
            </div>
            <div class="p-2 d-block">
                <h3>County</h3>
                <h5 class="text-muted">
                    {{$item->city->county->countyName ?? "N/A"}}
                </h5>
            </div>
            <div class="p-2 d-block">
                <h3>State</h3>
                <h5 class="text-muted">
                    {{$item->city->county->state->stateName ?? "N/A"}}
                </h5>
            </div>
        </div>
        <div class="d-flex flex-row justify-content-between mb-3 mx-3">
            <div class="p-2 d-block">
                <h3>Source</h3>
                <h5 class="text-muted">{{$item->source->node_name ?? "N/A"}}</h5>
            </div>
            <div class="p-2 d-block">
                <h3>Destination</h3>
                <h5 class="text-muted">{{$item->destination->node_name ?? "N/A"}}</h5>
            </div>
            <div class="p-2 d-block">
                <h3>Allowed</h3>
                <h3><span class="badge @if($item->allowed->allowedText === "Yes") badge-success @elseif($item->allowed->allowedText === "No") badge-danger @else badge-warning @endif">
                        {{$item->allowed->allowedText ?? "?"}}
                    </span></h3>
            </div>
        </div>
        <table class="table table-bordered">
            <h3 class="text-left">Links</h3>
            <thead>
            <tr>
                <th scope="row">Types</th>
                <th scope="col">Title</th>
                <th scope="col">Url</th>
                <th scope="col">Link State</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                 <td>
                    Codes
                </td>


                <!-- <td>
                    @if(empty($item->codesObj->linkText))
                        N/A
                    @else
                        <a href="{{$item->codesObj->linkText ?? "#"}}" class="btn btn-primary">{{$item->codesObj->name ?? "Code Link"}}</a>
                    @endif
                </td>
                <td>
                    @if(empty($item->permitObj->linkText))
                        N/A
                    @else
                        <a href="{{$item->permitObj->linkText ?? "#"}}" class="btn btn-primary">{{$item->permitObj->name ?? "Permit Link"}}</a>
                    @endif
                </td>
                <td>
                    @if(empty($item->incentivesObj->linkText))
                        N/A
                    @else
                        <a href="{{$item->incentivesObj->linkText ?? "#"}}" class="btn btn-primary">{{$item->incentivesObj->name ?? "Incentives Link"}}</a>
                    @endif
                </td>
                <td>
                    @if(empty($item->codesObj->linkText))
                        N/A
                    @else
                        <a href="{{$item->moreInfoObj->linkText ?? "#"}}" class="btn btn-primary">{{$item->moreInfoObj->name ?? "More Info"}}</a>
                     @endif
                </td> -->
            </tr>
            <tr>
                <td>
                    Permits
                </td>
            </tr>
            <tr>
                <td>
                    Incentives
                </td>
            </tr>
            <tr>
                <td>
                    More Info
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</div>