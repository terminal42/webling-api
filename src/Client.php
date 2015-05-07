<?php

namespace Terminal42\WeblingApi;

class Client implements ClientInterface
{
    private $baseUrl;
    private $apiKey;

    public function __construct($domain, $apiVersion, $apiKey)
    {
        $this->baseUrl = sprintf('https://%s.webling.ch/api/%d', $domain, $apiVersion);
        $this->apiKey  = $apiKey;
    }
}
