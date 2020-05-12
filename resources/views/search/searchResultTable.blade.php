<table class="table text-center">
    <thead>
    <tr class="table-head">
        <th scope="col">Source</th>
        <th scope="col">Destination</th>
        <th scope="col">Allowed</th>
        <th scope="col">Codes</th>
        <th scope="col">Permits</th>
        <th scope="col">Incentives</th>
        <th scope="col">More Info</th>
    </tr>
    </thead>
    <tbody>
        @foreach($rules as $rule)
            <tr data-source="{{$rule->source->node_id}}" data-destination="{{$rule->destination->node_id}}" class="reuse-row">
                <td class="align-middle">{{$rule->source->node_name}}</td>
                <td class="align-middle">{{$rule->destination->node_name}}</td>
                <td class="align-middle"> <h4>{!! $rule->allowed->getAllowedTextBadge() !!}</h4> </td>
                <td class="align-middle">
                    <a class="btn btn-outline-primary" href="{{$rule->codesObj->linkText}}" role="button">{{!empty($rule->codesObj->name) ? $rule->codesObj->name : "Unknown"}}</a>
                </td>
                <td class="align-middle">
                    <a class="btn btn-outline-primary" href="{{$rule->permitObj->linkText}}" role="button">{{!empty($rule->permitObj->name) ? $rule->permitObj->name : "Unknown"}}</a>
                </td>
                <td class="align-middle">
                    <a class="btn btn-outline-primary" href="{{$rule->incentivesObj->linkText}}" role="button">{{!empty($rule->incentivesObj->name) ? $rule->incentivesObj->name : "Unknown"}}</a>
                </td>
                <td class="align-middle">
                    <a class="btn btn-outline-primary" href="{{$rule->moreInfoObj->linkText}}" role="button">{{!empty($rule->moreInfoObj->name) ? $rule->moreInfoObj->name : "Unknown"}}</a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>