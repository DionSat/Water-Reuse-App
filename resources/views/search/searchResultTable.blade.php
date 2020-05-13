<table class="table text-center">
    <thead>
    <tr class="table-head">
        <th scope="col">Source</th>
        <th scope="col">Destination</th>
        <th scope="col">Allowed</th>
        <th scope="col" colspan="4">Links</th>
    </tr>
    </thead>
    <tbody>
        @foreach($rules as $rule)
            <tr data-source="{{$rule->source->node_id}}" data-destination="{{$rule->destination->node_id}}" class="reuse-row">
                <td class="align-middle">{{$rule->source->node_name}}</td>
                <td class="align-middle">{{$rule->destination->node_name}}</td>
                <td class="align-middle"> <h4>{!! $rule->allowed->getAllowedTextBadge() !!}</h4> </td>
                <td class="align-middle">
                    <a class="btn btn-outline-primary link-button" data-linkid="{{$rule->codesObj->link_id}}" href="{{$rule->codesObj->linkText}}">Codes</a>
                </td>
                <td class="align-middle">
                    <a class="btn btn-outline-primary link-button" data-linkid="{{$rule->permitObj->link_id}}" href="{{$rule->permitObj->linkText}}">Permits</a>
                </td>
                <td class="align-middle">
                    <a class="btn btn-outline-primary link-button" data-linkid="{{$rule->incentivesObj->link_id}}" href="{{$rule->incentivesObj->linkText}}">Incentives</a>
                </td>
                <td class="align-middle">
                    <a class="btn btn-outline-primary link-button" data-linkid="{{$rule->moreInfoObj->link_id}}" href="{{$rule->moreInfoObj->linkText}}">More Info</a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>