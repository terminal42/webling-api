<?php

namespace Terminal42\WeblingApi;

use GuzzleHttp\Exception\ParseException as GuzzleParseException;
use GuzzleHttp\Exception\RequestException;
use Terminal42\WeblingApi\Exception\HttpStatusException;
use Terminal42\WeblingApi\Exception\ParseException;

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
        try {
            $response = $this->client->get(ltrim($url, '/'), ['query' => $query]);
            return $response->json();

        } catch (RequestException $e) {
            throw new HttpStatusException($e->getMessage(), $e->getCode(), $e);
        } catch (GuzzleParseException $e) {
            throw new ParseException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function post($url, $json)
    {
        try {
            return $this->client->post(ltrim($url, '/'), ['json' => $json]);
        } catch (RequestException $e) {
            throw new HttpStatusException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function put($url, $json)
    {
        try {
            return $this->client->put(ltrim($url, '/'), ['json' => $json]);
        } catch (RequestException $e) {
            throw new HttpStatusException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function delete($url)
    {
        try {
            return $this->client->delete(ltrim($url, '/'));
        } catch (RequestException $e) {
            throw new HttpStatusException($e->getMessage(), $e->getCode(), $e);
        }
    }
}
