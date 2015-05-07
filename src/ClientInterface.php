<?php

namespace Terminal42\WeblingApi;

use Terminal42\WeblingApi\Exception\HttpStatusException;
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
     */
    public function get($url, $query = []);

    /**
     * Sends a POST request.
     *
     * @param string $url  The URL to send request to
     * @param string $json The JSON data
     *
     * @return mixed
     *
     * @throws HttpStatusException If there was a problem with the request
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
     */
    public function delete($url);
}
