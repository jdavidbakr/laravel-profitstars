<?php

namespace jdavidbakr\ProfitStars;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ServerException;
use SimpleXMLElement;

abstract class RequestBase
{
    protected $endpoint;
    public $faultcode;
    public $faultstring;

    public function Call($view)
    {
        $client = new Client();

        try {
            $response = $client->post($this->endpoint, [
                'headers'=>[
                    'Content-Type'=>'text/xml;charset=UTF-8',
                ],
                'body'=>$view->render(),
            ]);
        } catch (ServerException $e) {
            $response = $e->getResponse();
        }
        $body = $response->getBody();
        $xml = new SimpleXMLElement((string)$body);
        $body = $xml->children('soap', true)->Body;
        $fault = $body->children('soap', true)->Fault;
        if ($body->children() && $body->children()->children()) {
            return $body->children()->children();
        } elseif ($fault) {
            $this->faultcode = (string)$fault->children()->faultcode[0];
            $this->faultstring = (string)$fault->children()->faultstring[0];
            return false;
        } else {
            abort(500, "Unknown SOAP response");
        }
    }
}
