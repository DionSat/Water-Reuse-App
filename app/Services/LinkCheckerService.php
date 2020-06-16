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
        $statusValue = [];

        if($forceLinkToBeCheckedNow)
            $statusValue = $link->checkSelfIfValid();
        else
            $statusValue = $link->checkSelfIfValidAutomatic();

        return "<strong>".$statusValue["status"]."</strong>".". Accompanying message: ".$statusValue["message"];
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
        $client = new Client([ 'timeout'  => 15.0 ]);

        try{
            // If link is valid - we get a response
            $response = $client->request('HEAD', $linkUrl);
            // If the reponse has a 200 status code - link is valid
            return ["status" => ($response->getStatusCode() === 200) ? "valid" : "broken",
                "message" => ($response->getStatusCode() === 200) ? "Website returned a status code indicating a successful response when pinged."
                    : "Website returned a non-successful status code of: ".$response->getStatusCode()." - ".$response->getReasonPhrase()];

        } catch (RequestException $exception){
            // Guzzle throws a exception on 404 errors
            // If we get a 404, we know the link is bad, otherwise we don't know what went wrong
            return ["status" => ($exception->getCode() === 404) ? "broken" : "unknown",
                "message" => "The ping to the website failed completely with code: ".$exception->getCode()." - ".$exception->getResponse()->getReasonPhrase()];
        }
    }

}
