<div class="card mx-auto mt-3 shadow">
    <div class="card-body text-center">
        <div class="d-flex flex-row justify-content-between mb-3 mx-3">
            <div class="p-2 d-block">
                <h3>City</h3>
                <h5 class="text-muted">
                    @if(!empty($item))
                        @if(isset($item->cityID))
                            {{$item->city->cityName ?? "N/A"}}
                        @else
                            N/A
                        @endif
                    @else
                        N/A
                    @endif
                </h5>
            </div>
            <div class="p-2 d-block">
                <h3>County</h3>
                <h5 class="text-muted">
                    @if(!empty($item))
                        @if(isset($item->stateID)){{"N/A"}}@endif
                        @if(isset($item->countyID)){{$item->county->countyName ?? "N/A"}}@endif
                        @if(isset($item->cityID)){{$item->city->county->countyName ?? "N/A"}}@endif
                    @else
                        N/A
                    @endif
                </h5>
            </div>
            <div class="p-2 d-block">
                <h3>State</h3>
                <h5 class="text-muted">
                    @if(!empty($item))
                        @if(isset($item->stateID)){{$item->state->stateName ?? "N/A"}}@endif 
                        @if(isset($item->countyID)){{$item->county->state->stateName ?? "N/A"}}@endif
                        @if(isset($item->cityID)){{$item->city->county->state->stateName ?? "N/A"}}@endif
                    @else
                        N/A
                    @endif
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
                <td>
                    @if(empty($item->codesObj->linkText))
                        N/A
                    @else
                        {{$item->codesObj->name ?? "Code Link"}}
                    @endif
                </td>
                <td>
                    @if(empty($item->codesObj->linkText))
                        N/A
                    @else
                        {{$item->codesObj->linkText}}
                    @endif
                </td>
                <td>
                    @if(empty($item->codesObj->linkText))
                        N/A
                    @else
                    <h4>
                    <span class="badge @if($item->codesObj->status === 'valid') badge-success @elseif($item->codesObj->status === 'broken')
                                badge-danger @else badge-warning @endif" style="font-size 2em">{{$item->codesObj->status}}</span>
                    @endif
                    </h4>
                </td>
            </tr>
            <tr>
                <td>
                    Permits
                </td>
                <td>
                    @if(empty($item->permitObj->linkText))
                        N/A
                    @else
                        {{$item->permitObj->name ?? "Code Link"}}
                    @endif
                </td>
                <td>
                    @if(empty($item->permitObj->linkText))
                        N/A
                    @else
                        {{$item->permitObj->linkText}}
                    @endif
                </td>
                <td>
                    @if(empty($item->permitObj->linkText))
                        N/A
                    @else
                    <h4>
                    <span class="badge @if($item->permitObj->status === 'valid') badge-success @elseif($item->permitObj->status === 'broken')
                                badge-danger @else badge-warning @endif" style="font-size 2em">{{$item->permitObj->status}}</span>
                    @endif
                    </h4>
                </td>
            </tr>
            <tr>
                <td>
                    Incentives
                </td>
                <td>
                    @if(empty($item->incentivesObj->linkText))
                        N/A
                    @else
                        {{$item->incentivesObj->name ?? "Code Link"}}
                    @endif
                </td>
                <td>
                    @if(empty($item->incentivesObj->linkText))
                        N/A
                    @else
                        {{$item->incentivesObj->linkText}}
                    @endif
                </td>
                <td>
                    @if(empty($item->incentivesObj->linkText))
                        N/A
                    @else
                    <h4>
                    <span class="badge @if($item->incentivesObj->status === 'valid') badge-success @elseif($item->incentivesObj->status === 'broken')
                                badge-danger @else badge-warning @endif" style="font-size 2em">{{$item->incentivesObj->status}}</span>
                    @endif
                    </h4>
                </td>

            </tr>
            <tr>
                <td>
                    More Info
                </td>
                <td>
                    @if(empty($item->moreInfoObj->linkText))
                        N/A
                    @else
                        {{$item->moreInfoObj->name ?? "Code Link"}}
                    @endif
                </td>
                <td>
                    @if(empty($item->moreInfoObj->linkText))
                        N/A
                    @else
                        {{$item->moreInfoObj->linkText}}
                    @endif
                </td>
                <td>
                    @if(empty($item->moreInfoObj->linkText))
                        N/A
                    @else
                    <h4>
                    <span class="badge @if($item->moreInfoObj->status === 'valid') badge-success @elseif($item->moreInfoObj->status === 'broken')
                                badge-danger @else badge-warning @endif" style="font-size 2em">{{$item->moreInfoObj->status}}</span>
                    @endif
                    </h4>
                </td>
            </tr>
            </tbody>
        </table>
        <table class="table table-bordered">
            <h3 class="text-left">Comments</h3>
            <tbody>
                <tr>
                    <td colspan="4">
                        @if($item->comments != "")
                            {{$item->comments}}                            
                        @else
                            No Comments.                            
                        @endif
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>