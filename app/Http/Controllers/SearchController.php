<?php

namespace App\Http\Controllers;

use App\City;
use App\County;
use App\Links;
use App\ReuseNode;
use App\State;
use App\StateMerge;
use App\CountyMerge;
use App\CityMerge;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Services\LinkCheckerService;

class SearchController extends Controller
{
    public function mainPage(){

        $states = State::all()->sortBy("stateName");
        return view("search.searchpage", compact('states'));
    }

    public function searchDiagram(){
        return view("search.searchDiagram");
    }

    public function handleSubmit(Request $request){
        $countyRules = new Collection();
        $cityRules = new Collection();
        $state = State::find($request->state_id);
        dd($state);
        $county = null;
        $city = null;
        $lowestLevel = "state";

        $stateRules = StateMerge::with(['state', 'source', 'destination', 'allowed', 'codesObj', 'incentivesObj', 'permitObj', 'moreInfoObj'])
                                        ->where("stateID", $request->state_id)->where("location_type", $request->searchType)->get();
        if(isset($request->county_id)){
            $countyRules = CountyMerge::with(['county', 'source', 'destination', 'allowed', 'codesObj', 'incentivesObj', 'permitObj', 'moreInfoObj'])
                ->where("countyID", $request->county_id)->where("location_type", $request->searchType)->get();
            $lowestLevel = "county";
            $county = County::find($request->county_id);
        }

        if(isset($request->city_id)) {
            $cityRules = CityMerge::with(['city', 'source', 'destination', 'allowed', 'codesObj', 'incentivesObj', 'permitObj', 'moreInfoObj'])
                ->where("cityID", $request->city_id)->where("location_type", $request->searchType)->get();
            $lowestLevel = "city";
            $city = City::find($request->city_id);
        }

        // Get all the sources and destinations
        $sources = ReuseNode::sources();
        $destinations = ReuseNode::destinations();
        $type = $request->searchType === "residential" ? "Residential" : "Commercial";

        return view("search.searchresults", compact('stateRules', 'countyRules', 'cityRules', 'lowestLevel', 'city', 'county', 'state', 'sources', 'destinations', 'type'));
    }

    // Parses user-input into searchable query
    public function handleAddress(Request $request){
        $address_string = $request->addressInput;
        $address_info = json_decode($this->addressData($address_string), true);
        // TODO Check for empty string
        $stateIndex = $address_info["results"][0]["locations"][0]["adminArea3"];

        $countyRules = new Collection();
        $cityRules = new Collection();
        $stateName = $this->states[$stateIndex];
        $state = State::where('stateName', $stateName)->first();

        $county = null;
        $city = null;
        $lowestLevel = "state";

        $stateRules = StateMerge::with(['state', 'source', 'destination', 'allowed', 'codesObj', 'incentivesObj', 'permitObj', 'moreInfoObj'])
            ->where("stateID", $state->state_id)->where("location_type", $request->searchType)->get();
        if(isset($request->county_id)){
            $countyRules = CountyMerge::with(['county', 'source', 'destination', 'allowed', 'codesObj', 'incentivesObj', 'permitObj', 'moreInfoObj'])
                ->where("countyID", $request->county_id)->where("location_type", $request->searchType)->get();
            $lowestLevel = "county";
            $county = County::find($request->county_id);
        }

        if(isset($request->city_id)) {
            $cityRules = CityMerge::with(['city', 'source', 'destination', 'allowed', 'codesObj', 'incentivesObj', 'permitObj', 'moreInfoObj'])
                ->where("cityID", $request->city_id)->where("location_type", $request->searchType)->get();
            $lowestLevel = "city";
            $city = City::find($request->city_id);
        }

        // Get all the sources and destinations
        $sources = ReuseNode::sources();
        $destinations = ReuseNode::destinations();
        $type = $request->searchType === "residential" ? "Residential" : "Commercial";

        return view("search.searchresults", compact('stateRules', 'countyRules', 'cityRules', 'lowestLevel', 'city', 'county', 'state', 'sources', 'destinations', 'type'));
    }

    // API Request for geocode data
    public function addressData($address_string){
        /*
        $request_url = "https://rapidapi.p.rapidapi.com/Geocode";
        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', $request_url, [
            'query' => [
                'address' => $address_string,
                'language' => 'en',
                'country' => 'US'
            ],
            'headers' => [
                'x-rapidapi-host' => 'trueway-geocoding.p.rapidapi.com',
                'x-rapidapi-key' => env("TW_API_KEY")
            ]
        ]);
        */

        $request_url = "http://www.mapquestapi.com/geocoding/v1/address";
        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', $request_url, [
            'query' => [
                'key' => env('MQ_API_KEY'),
                'location' => $address_string,
                'thumpsMaps' => false,
                'maxResults' => 1,
                'outFormat' => 'json'
            ]
        ]);

        // Resource for checking address validation
        // https://developer.mapquest.com/forum/how-detect-invalid-address
        return $response->getBody();
    }

    protected $states = [
        'AL'=>'Alabama',
        'AK'=>'Alaska',
        'AZ'=>'Arizona',
        'AR'=>'Arkansas',
        'CA'=>'California',
        'CO'=>'Colorado',
        'CT'=>'Connecticut',
        'DE'=>'Delaware',
        'DC'=>'District of Columbia',
        'FL'=>'Florida',
        'GA'=>'Georgia',
        'HI'=>'Hawaii',
        'ID'=>'Idaho',
        'IL'=>'Illinois',
        'IN'=>'Indiana',
        'IA'=>'Iowa',
        'KS'=>'Kansas',
        'KY'=>'Kentucky',
        'LA'=>'Louisiana',
        'ME'=>'Maine',
        'MD'=>'Maryland',
        'MA'=>'Massachusetts',
        'MI'=>'Michigan',
        'MN'=>'Minnesota',
        'MS'=>'Mississippi',
        'MO'=>'Missouri',
        'MT'=>'Montana',
        'NE'=>'Nebraska',
        'NV'=>'Nevada',
        'NH'=>'New Hampshire',
        'NJ'=>'New Jersey',
        'NM'=>'New Mexico',
        'NY'=>'New York',
        'NC'=>'North Carolina',
        'ND'=>'North Dakota',
        'OH'=>'Ohio',
        'OK'=>'Oklahoma',
        'OR'=>'Oregon',
        'PA'=>'Pennsylvania',
        'PR'=>'Puerto Rico',
        'RI'=>'Rhode Island',
        'SC'=>'South Carolina',
        'SD'=>'South Dakota',
        'TN'=>'Tennessee',
        'TX'=>'Texas',
        'UT'=>'Utah',
        'VT'=>'Vermont',
        'VA'=>'Virginia',
        'WA'=>'Washington',
        'WV'=>'West Virginia',
        'WI'=>'Wisconsin',
        'WY'=>'Wyoming'
    ];
}
