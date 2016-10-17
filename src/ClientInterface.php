<?php

namespace Terminal42\WeblingApi;

use Terminal42\WeblingApi\Exception\ApiErrorException;
use Terminal42\WeblingApi\Exception\HttpStatusException;
use Terminal42\WeblingApi\Exception\NotFoundException;
use Terminal42\WeblingApi\Exception\ParseException;

interface ClientInterface
{
    /**
     * Sends a GET request.
     *
     * @param string $url  The URL to send request to
     * @param array $query An optional array of GET parameters
     *
     * @return array
     *
     * @throws HttpStatusException If there was a problem with the request
     * @throws ParseException      If the JSON data could not be parsed
     * @throws NotFoundException   If the API returned a HTTP status code 404
     * @throws ApiErrorException   If the API returned an error message
     */
    public function get($url, array $query = []);

    /**
     * Sends a POST request.
     *
     * @param string $url  The URL to send request to
     * @param string $json The JSON data
     *
     * @return mixed
     *
     * @throws HttpStatusException If there was a problem with the request
     * @throws NotFoundException   If the API returned a HTTP status code 404
     * @throws ApiErrorException   If the API returned an error message
     */
    public function post($url, $json);

    /**
     * Sends a PUT request.
     *
     * @param string $url  The URL to send request to
     * @param string $json The JSON data
     *
     * @return mixed
     *
     * @throws HttpStatusException If there was a problem with the request
     * @throws NotFoundException   If the API returned a HTTP status code 404
     * @throws ApiErrorException   If the API returned an error message
     */
    public function put($url, $json);

    /**
     * Sends a DELETE request.
     *
     * @param string $url The URL to send request to
     *
     * @return mixed
     *
     * @throws HttpStatusException If there was a problem with the request
     * @throws NotFoundException   If the API returned a HTTP status code 404
     * @throws ApiErrorException   If the API returned an error message
     */
    public function delete($url);
}
