<?php

namespace Terminal42\WeblingApi;

class Client implements ClientInterface
{
    protected $client;

    /**
     * Constructor.
     *
     * @param string $subdomain  Your Webling subdomain.
     * @param string $apiKey     Your Webling API key.
     * @param int    $apiVersion The API version
     */
    public function __construct($subdomain, $apiKey, $apiVersion)
    {
        $this->client = new \GuzzleHttp\Client(
            [
                'base_url' => [
                    'https://{subdomain}.webling.ch/api/{version}/',
                    ['subdomain' => $subdomain, 'version' => $apiVersion]
                ],
                'defaults' => [
                    'query' => ['apikey' => $apiKey]
                ]
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function get($url, $query = [])
    {
        return $this->client->get(ltrim($url, '/'), ['query' => $query]);
    }

    /**
     * {@inheritdoc}
     */
    public function post($url, $json)
    {
        return $this->client->post(ltrim($url, '/'), ['json' => $json]);
    }

    /**
     * {@inheritdoc}
     */
    public function put($url, $json)
    {
        return $this->client->put(ltrim($url, '/'), ['json' => $json]);
    }

    /**
     * {@inheritdoc}
     */
    public function delete($url)
    {
        return $this->client->delete(ltrim($url, '/'));
    }
}
