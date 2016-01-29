<?php

namespace Terminal42\WeblingApi;

use GuzzleHttp\Exception\ParseException as GuzzleParseException;
use GuzzleHttp\Exception\RequestException;
use Terminal42\WeblingApi\Exception\ApiErrorException;
use Terminal42\WeblingApi\Exception\HttpStatusException;
use Terminal42\WeblingApi\Exception\NotFoundException;
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
    public function get($url, array $query = [])
    {
        try {
            $response = $this->client->get(ltrim($url, '/'), ['query' => $query]);
            return $response->json();

        } catch (\Exception $e) {
            throw $this->convertException($e);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function post($url, $json)
    {
        try {
            return $this->client->post(ltrim($url, '/'), ['body' => $json]);
        } catch (\Exception $e) {
            throw $this->convertException($e);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function put($url, $json)
    {
        try {
            return $this->client->put(ltrim($url, '/'), ['body' => $json]);
        } catch (\Exception $e) {
            throw $this->convertException($e);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function delete($url)
    {
        try {
            return $this->client->delete(ltrim($url, '/'));
        } catch (\Exception $e) {
            throw $this->convertException($e);
        }
    }

    /**
     * Convert known Guzzle exceptions to our custom ones
     *
     * @param \Exception $e
     *
     * @return \Exception
     */
    private function convertException(\Exception $e)
    {
        if ($e instanceof RequestException) {

            if ($e->hasResponse()) {
                $response = $e->getResponse();
                $body     = @json_decode($response->getBody(), true);
                $error    = (is_array($body) && !empty($body['error'])) ? $body['error'] : $e->getMessage();

                switch ($e->getResponse()->getStatusCode()) {
                    case 404:
                        return new NotFoundException($error, $response->getStatusCode(), $e);

                    default:
                        return new ApiErrorException($error, $response->getStatusCode(), $e);
                }
            }

            return new HttpStatusException($e->getMessage(), $e->getCode(), $e);
        }

        if ($e instanceof GuzzleParseException) {
            return new ParseException($e->getMessage(), $e->getCode(), $e);
        }

        return $e;
    }
}
