<?php

namespace App\Services;

use App\Links;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class LinkCheckerService {

    // Function to check link by id
    // Returns link status
    public static function checkAndUpdateLinkStatusById($linkId, $forceLinkToBeCheckedNow) {
        $link = Links::find($linkId);

        if($forceLinkToBeCheckedNow)
            $link->checkSelfIfValid();
        else
            $link->checkSelfIfValidAutomatic();

        return $link->status;
    }

    public static function validateUrl($url){
        return filter_var($url, FILTER_VALIDATE_URL);
    }

    public static function checkIfLinkIsValid ($linkUrl) {

        //Check if protocol is defined, prepend if not
        if(empty(parse_url($linkUrl)["scheme"]))
            $linkUrl = "http://".$linkUrl;

        //Validate the url first
        if (filter_var($linkUrl, FILTER_VALIDATE_URL) === false){
            return "broken";
        }

        // Create the Guzzle client
        $client = new Client([ 'timeout'  => 2.0 ]);

        try{
            // If link is valid - we get a response
            $response = $client->request('HEAD', $linkUrl);
            // If the reponse has a 200 status code - link is valid
            return ($response->getStatusCode() === 200) ? "valid" : "broken";

        } catch (RequestException $exception){
            // Guzzle throws a exception on 404 errors
            // If we get a 404, we know the link is bad, otherwise we don't know what went wrong
            return ($exception->getCode() === 404) ? "broken" : "unknown";
        }
    }

}
