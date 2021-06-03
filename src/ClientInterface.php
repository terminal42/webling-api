<?php

declare(strict_types=1);

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
     * @param string $url   The URL to send request to
     * @param array  $query An optional array of GET parameters
     *
     * @throws HttpStatusException If there was a problem with the request
     * @throws ParseException      If the JSON data could not be parsed
     * @throws NotFoundException   If the API returned a HTTP status code 404
     * @throws ApiErrorException   If the API returned an error message
     *
     * @return mixed
     */
    public function get(string $url, array $query = []);

    /**
     * Sends a POST request.
     *
     * @param string $url  The URL to send request to
     * @param string $json The JSON data
     *
     * @throws HttpStatusException If there was a problem with the request
     * @throws NotFoundException   If the API returned a HTTP status code 404
     * @throws ApiErrorException   If the API returned an error message
     *
     * @return mixed
     */
    public function post(string $url, string $json);

    /**
     * Sends a PUT request.
     *
     * @param string $url  The URL to send request to
     * @param string $json The JSON data
     *
     * @throws HttpStatusException If there was a problem with the request
     * @throws NotFoundException   If the API returned a HTTP status code 404
     * @throws ApiErrorException   If the API returned an error message
     *
     * @return mixed
     */
    public function put(string $url, string $json);

    /**
     * Sends a DELETE request.
     *
     * @param string $url The URL to send request to
     *
     * @throws HttpStatusException If there was a problem with the request
     * @throws NotFoundException   If the API returned a HTTP status code 404
     * @throws ApiErrorException   If the API returned an error message
     *
     * @return mixed
     */
    public function delete(string $url);
}
