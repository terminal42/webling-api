<?php

namespace Terminal42\WeblingApi;

use GuzzleHttp\Exception\ParseException as GuzzleParseException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Message\ResponseInterface;
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

            if (200 !== $response->getStatusCode()) {
                throw $this->convertResponseToException($response);
            }

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
            $response = $this->client->post(ltrim($url, '/'), ['body' => $json]);

            if (201 !== $response->getStatusCode()) {
                throw $this->convertResponseToException($response);
            }
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
            $response = $this->client->put(ltrim($url, '/'), ['body' => $json]);

            if (204 !== $response->getStatusCode()) {
                throw $this->convertResponseToException($response);
            }
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
            $response = $this->client->delete(ltrim($url, '/'));

            if (204 !== $response->getStatusCode()) {
                throw $this->convertResponseToException($response);
            }
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
    protected function convertException(\Exception $e)
    {
        if ($e instanceof RequestException) {
            if ($e->hasResponse()) {
                return $this->convertResponseToException($e->getResponse(), $e);
            }

            return new HttpStatusException($e->getMessage(), $e->getCode(), $e);
        }

        if ($e instanceof GuzzleParseException) {
            return new ParseException($e->getMessage(), $e->getCode(), $e);
        }

        return $e;
    }

    /**
     * Convert a Guzzle Response to an exception. Useful if status code is not as expected.
     *
     * @param ResponseInterface $response
     * @param \Exception|null   $exception
     *
     * @return \RuntimeException
     */
    protected function convertResponseToException(ResponseInterface $response, \Exception $exception = null)
    {
        $body = @json_decode($response->getBody(), true);

        if (!is_array($body) || empty($body['error'])) {
            return new HttpStatusException($response->getBody(), $response->getStatusCode(), $exception);
        }

        if (404 === $response->getStatusCode()) {
            return new NotFoundException($body['error'], $response->getStatusCode(), $exception);
        }

        return new ApiErrorException($body['error'], $response->getStatusCode(), $exception);
    }
}
