<?php

declare(strict_types=1);

namespace Terminal42\WeblingApi;

use Http\Client\HttpClient;
use Http\Discovery\HttpClientDiscovery;
use Http\Discovery\MessageFactoryDiscovery;
use Http\Message\MessageFactory;
use Psr\Http\Message\ResponseInterface;
use Terminal42\WeblingApi\Exception\ApiErrorException;
use Terminal42\WeblingApi\Exception\HttpStatusException;
use Terminal42\WeblingApi\Exception\NotFoundException;
use Terminal42\WeblingApi\Exception\ParseException;

class Client implements ClientInterface
{
    /**
     * @var HttpClient|null
     */
    private $httpClient;

    /**
     * @var MessageFactory
     */
    private $requestFactory;

    /**
     * @var string
     */
    private $baseUri;

    /**
     * @var array
     */
    private $defaultQuery;

    public function __construct(string $subdomain, string $apiKey, int $apiVersion, HttpClient $httpClient = null, MessageFactory $messageFactory = null)
    {
        $this->httpClient = $httpClient ?: HttpClientDiscovery::find();
        $this->requestFactory = $messageFactory ?: MessageFactoryDiscovery::find();

        $this->baseUri = sprintf('https://%s.webling.ch/api/%s/', $subdomain, $apiVersion);
        $this->defaultQuery = ['apikey' => $apiKey];
    }

    public function get(string $url, array $query = [])
    {
        try {
            $response = $this->httpClient->sendRequest(
                $this->requestFactory->createRequest('GET', $this->buildUri($url, $query))
            );

            if (200 !== $response->getStatusCode()) {
                throw $this->convertResponseToException($response);
            }

            $json = @json_decode((string) $response->getBody(), true);

            if (false === $json) {
                throw new ParseException(json_last_error_msg(), json_last_error());
            }

            return $json;
        } catch (\Exception $e) {
            throw new HttpStatusException($e->getMessage(), $e->getCode(), $e);
        }
    }

    public function post(string $url, string $json): void
    {
        try {
            $response = $this->httpClient->sendRequest(
                $this->requestFactory->createRequest('POST', $this->buildUri($url), [], $json)
            );

            if (201 !== $response->getStatusCode()) {
                throw $this->convertResponseToException($response);
            }
        } catch (\Exception $e) {
            throw new HttpStatusException($e->getMessage(), $e->getCode(), $e);
        }
    }

    public function put(string $url, string $json): void
    {
        try {
            $response = $this->httpClient->sendRequest(
                $this->requestFactory->createRequest('PUT', $this->buildUri($url), [], $json)
            );

            if (204 !== $response->getStatusCode()) {
                throw $this->convertResponseToException($response);
            }
        } catch (\Exception $e) {
            throw new HttpStatusException($e->getMessage(), $e->getCode(), $e);
        }
    }

    public function delete(string $url): void
    {
        try {
            $response = $this->httpClient->sendRequest(
                $this->requestFactory->createRequest('DELETE', $this->buildUri($url))
            );

            if (204 !== $response->getStatusCode()) {
                throw $this->convertResponseToException($response);
            }
        } catch (\Exception $e) {
            throw new HttpStatusException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * Convert a Guzzle Response to an exception. Useful if status code is not as expected.
     *
     * @return \RuntimeException
     */
    protected function convertResponseToException(ResponseInterface $response, \Exception $exception = null)
    {
        $body = @json_decode((string) $response->getBody(), true);

        if (!\is_array($body) || empty($body['error'])) {
            return new HttpStatusException($response->getBody(), $response->getStatusCode(), $exception);
        }

        if (404 === $response->getStatusCode()) {
            return new NotFoundException($body['error'], $response->getStatusCode(), $exception);
        }

        return new ApiErrorException($body['error'], $response->getStatusCode(), $exception);
    }

    /**
     * Builds an API request URI including authentication credentials.
     *
     * @param string $path
     *
     * @return string
     */
    private function buildUri($path, array $query = [])
    {
        $query = array_merge($this->defaultQuery, $query);

        return $this->baseUri.ltrim($path, '/').'?'.http_build_query($query);
    }
}
