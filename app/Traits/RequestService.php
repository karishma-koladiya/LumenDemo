<?php

namespace App\Traits;
use GuzzleHttp\Client;

trait RequestService 
{
    public function request($method, $requestUrl, $formParams = [], $headers = [])
    {
        // This is calling for everyrequest route. In controller construct method calling service and where it is sending base uri and secret of particular request
        \Log::info($requestUrl);
        $client = new Client([
            'base_uri' => $this->baseUri
        ]);
        
        if (isset($this->secret)) {
            $headers['Authorization'] = $this->secret;
        }
        \Log::info($headers);
        $response = $client->request($method, $requestUrl,
            [
                'form_params' => $formParams,
                'headers' => $headers
            ]
        );
        return $response->getBody()->getContents();
    }
}