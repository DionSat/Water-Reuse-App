<div class="card mx-auto mt-3 shadow">
    <div class="card-body text-center">
        <div class="mx-3 text-center">
            <h3>Type: {{$item->location_type}}</h3>
        </div>
        <hr>
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
                <h3>
                    {!! $item->allowed->getAllowedTextBadge() !!}
                </h3>
            </div>
        </div>
        <table class="table table-bordered">
            <h3 class="text-left">Links</h3>
            <thead>
            <tr>
                <th scope="row" colspan="1">Types</th>
                <th scope="col" colspan="3">Url</th>
                <th scope="col" colspan="1">Link State</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                 <td>
                    Codes
                </td>
                <td colspan="3">
                    @if(empty($item->codesObj->linkText))
                        N/A
                    @else
                        <a target="_blank" rel="noopener noreferrer" href="{{$item->codesObj->getSelfAsHttpLink()}}">{{$item->codesObj->linkText}}</a>
                    @endif
                </td>
                <td>
                    @if(empty($item->codesObj->linkText))
                        N/A
                    @else
                    <h4>
                        {!! $item->codesObj->getStatusTextBadge() !!}
                    </h4>
                    @endif
                </td>
            </tr>
            <tr>
                <td>
                    Permits
                </td>
                <td colspan="3">
                    @if(empty($item->permitObj->linkText))
                        N/A
                    @else
                        <a target="_blank" rel="noopener noreferrer" href="{{$item->permitObj->getSelfAsHttpLink()}}">{{$item->permitObj->linkText}}</a>
                    @endif
                </td>
                <td>
                    @if(empty($item->permitObj->linkText))
                        N/A
                    @else
                        <h4>
                            {!! $item->permitObj->getStatusTextBadge() !!}
                        </h4>
                    @endif
                </td>
            </tr>
            <tr>
                <td>
                    Incentives
                </td>
                <td colspan="3">
                    @if(empty($item->incentivesObj->linkText))
                        N/A
                    @else
                        <a target="_blank" rel="noopener noreferrer" href="{{$item->incentivesObj->getSelfAsHttpLink()}}">{{$item->incentivesObj->linkText}}</a>
                    @endif
                </td>
                <td>
                    @if(empty($item->incentivesObj->linkText))
                        N/A
                    @else
                        <h4>
                            {!! $item->incentivesObj->getStatusTextBadge() !!}
                        </h4>
                    @endif
                </td>

            </tr>
            <tr>
                <td>
                    More Info
                </td>
                <td colspan="3">
                    @if(empty($item->moreInfoObj->linkText))
                        N/A
                    @else
                        <a target="_blank" rel="noopener noreferrer" href="{{$item->moreInfoObj->getSelfAsHttpLink()}}">{{$item->moreInfoObj->linkText}}</a>
                    @endif
                </td>
                <td>
                    @if(empty($item->moreInfoObj->linkText))
                        N/A
                    @else
                        <h4>
                            {!! $item->moreInfoObj->getStatusTextBadge() !!}
                        </h4>
                    @endif
                </td>
            </tr>
            </tbody>
        </table>
        <div>
            <h3 class="text-left">Comments</h3>
            <div class="card text-left">
                <div class="card-body">
                    @if($item->comments != "")
                        {{$item->comments}}
                    @else
                        No comments.
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
